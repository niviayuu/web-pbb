<?php

namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TahunAnggaran;

class DateFilterService
{
    /**
     * Indonesian month abbreviations
     */
    private static array $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];

    /**
     * Indonesian full month names
     */
    private static array $fullMonths = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    /**
     * Resolve the active date filter from the request
     *
     * @param Request|null $request
     * @return array
     */
    public static function resolve(?Request $request = null): array
    {
        $request = $request ?? request();

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $tahunParam = $request->get('tahun');

        // If year parameter is explicitly passed without custom date range
        if ($tahunParam && (!$startDate || !$endDate)) {
            $yearVal = 2026;
            if (is_numeric($tahunParam)) {
                $thNum = (int)$tahunParam;
                if ($thNum <= 10) {
                    $thModel = TahunAnggaran::find($thNum);
                    $yearVal = $thModel ? $thModel->tahun : 2026;
                } else {
                    $yearVal = $thNum;
                }
            }
            $startDate = "{$yearVal}-01-01";
            $endDate = "{$yearVal}-12-31";
        }

        // Default active period: 1 Jan 2026 s/d 31 Des 2026
        if (!$startDate) {
            $startDate = '2026-01-01';
        }
        if (!$endDate) {
            $endDate = '2026-12-31';
        }

        // Validate date formats
        try {
            $startCarbon = Carbon::parse($startDate);
        } catch (\Exception $e) {
            $startCarbon = Carbon::parse('2026-01-01');
            $startDate = '2026-01-01';
        }

        try {
            $endCarbon = Carbon::parse($endDate);
        } catch (\Exception $e) {
            $endCarbon = Carbon::parse('2026-12-31');
            $endDate = '2026-12-31';
        }

        // Ensure start <= end
        if ($startCarbon->gt($endCarbon)) {
            $temp = $startCarbon;
            $startCarbon = $endCarbon;
            $endCarbon = $temp;
            $startDate = $startCarbon->format('Y-m-d');
            $endDate = $endCarbon->format('Y-m-d');
        }

        $startYear = (int)$startCarbon->year;
        $endYear = (int)$endCarbon->year;

        // Find corresponding TahunAnggaran record
        $tahunRecord = TahunAnggaran::where('tahun', $startYear)->first();
        if (!$tahunRecord) {
            $tahunRecord = TahunAnggaran::where('status', 'Aktif')->first() ?? TahunAnggaran::first();
        }
        $idTahun = $tahunRecord ? $tahunRecord->id_tahun : 3;

        // Format Indonesian label
        $startDay = $startCarbon->day;
        $startMonth = self::$months[$startCarbon->month] ?? $startCarbon->format('M');
        $startYr = $startCarbon->year;

        $endDay = $endCarbon->day;
        $endMonth = self::$months[$endCarbon->month] ?? $endCarbon->format('M');
        $endYr = $endCarbon->year;

        if ($startYr === $endYr) {
            if ($startDate === $endDate) {
                $label = "{$startDay} {$startMonth} {$startYr}";
            } elseif ($startDay === 1 && $startCarbon->month === 1 && $endDay === 31 && $endCarbon->month === 12) {
                $label = "1 Jan {$startYr} - 31 Des {$startYr}";
            } else {
                $label = "{$startDay} {$startMonth} - {$endDay} {$endMonth} {$startYr}";
            }
        } else {
            $label = "{$startDay} {$startMonth} {$startYr} - {$endDay} {$endMonth} {$endYr}";
        }

        // Calculate days & ratio for pro-rata scaling
        $totalDays = $startCarbon->diffInDays($endCarbon) + 1;
        $daysInYear = $startCarbon->isLeapYear() ? 366 : 365;
        $ratio = min(1.0, max(0.05, $totalDays / $daysInYear));

        $isCustom = ($startDate !== '2026-01-01' || $endDate !== '2026-12-31');

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_carbon' => $startCarbon,
            'end_carbon' => $endCarbon,
            'start_year' => $startYear,
            'end_year' => $endYear,
            'id_tahun' => $idTahun,
            'tahun_model' => $tahunRecord,
            'label' => $label,
            'total_days' => $totalDays,
            'ratio' => $ratio,
            'is_custom' => $isCustom,
        ];
    }
}

