<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjekPajak;
use App\Models\PembayaranPajak;
use App\Models\TahunAnggaran;
use App\Services\DateFilterService;

class CekPbbController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $nop = $request->get('nop');
        $tahun = $request->get('tahun', $filter['start_year'] ?? 2026);
        $objekPajak = null;
        $pembayaran = null;

        if ($nop) {
            // Normalize NOP
            $cleanNop = trim($nop);
            $objekPajak = ObjekPajak::with(['wajibPajak', 'jenisPajak', 'desa.kecamatan', 'pembayaran'])
                ->where('nop', 'like', "%{$cleanNop}%")
                ->first();

            if ($objekPajak) {
                $pembayaran = $objekPajak->pembayaran->where('tahun_pajak', $tahun)->first();
            }
        }

        // Sample NOPs for quick testing
        $sampleNops = ObjekPajak::take(5)->pluck('nop')->toArray();

        return view('cek-pbb.index', compact('nop', 'tahun', 'objekPajak', 'pembayaran', 'sampleNops', 'filter'));
    }

    public function bayar(Request $request, $id)
    {
        $objekPajak = ObjekPajak::findOrFail($id);
        $tahun = $request->input('tahun_pajak', 2026);

        // Check if already paid
        $existing = PembayaranPajak::where('id_objek_pajak', $objekPajak->id_objek_pajak)
            ->where('tahun_pajak', $tahun)
            ->first();

        if (!$existing) {
            PembayaranPajak::create([
                'id_objek_pajak' => $objekPajak->id_objek_pajak,
                'tanggal_bayar' => now()->toDateString(),
                'tahun_pajak' => $tahun,
                'jumlah_bayar' => $objekPajak->nilai_pajak,
                'status_pembayaran' => 'Lunas',
                'metode_pembayaran' => $request->input('metode', 'Bank BJB QRIS'),
                'nomor_transaksi' => 'TRX-' . strtoupper(uniqid()),
            ]);

            $objekPajak->status_pembayaran = 'Lunas';
            $objekPajak->save();
        }

        return redirect()->route('cek-pbb.index', ['nop' => $objekPajak->nop, 'tahun' => $tahun])
            ->with('success', 'Pembayaran PBB-P2 NOP ' . $objekPajak->nop . ' berhasil diproses dan tercatat LUNAS!');
    }
}
