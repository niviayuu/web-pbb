<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\LogAktivitas;
use App\Models\Pengaturan;
use App\Services\DateFilterService;

class PengaturanController extends Controller
{
    public function users(Request $request)
    {
        $users = User::with('role')->get();
        $totalUsers = $users->count();
        $aktifUsers = $users->where('status', 'Aktif')->count();
        $nonaktifUsers = $users->where('status', 'Nonaktif')->count();

        return view('pengaturan.users', compact('users', 'totalUsers', 'aktifUsers', 'nonaktifUsers'));
    }

    public function keamanan(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $startDate = $filter['start_date'];
        $endDate = $filter['end_date'];
        $isCustom = $filter['is_custom'];

        $logsQuery = LogAktivitas::with('user');
        if ($isCustom) {
            $logsQuery->whereBetween('waktu', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        $logs = $logsQuery->orderBy('waktu', 'desc')->get();
        if ($isCustom && $logs->isEmpty()) {
            $logs = LogAktivitas::with('user')->orderBy('waktu', 'desc')->get();
        }

        $settings = Pengaturan::all()->pluck('nilai_pengaturan', 'nama_pengaturan');

        return view('pengaturan.keamanan', compact('logs', 'settings', 'filter'));
    }
}
