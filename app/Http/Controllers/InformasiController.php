<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;
use App\Models\KategoriInformasi;
use App\Services\DateFilterService;

class InformasiController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $tab = $request->get('tab', 'semua');
        $startDate = $filter['start_date'];
        $endDate = $filter['end_date'];
        $isCustom = $filter['is_custom'];

        $kategoris = KategoriInformasi::all();

        $query = Informasi::with(['kategori', 'user'])->where('status', 'Publik');

        if ($tab !== 'semua') {
            $query->whereHas('kategori', function ($q) use ($tab) {
                $q->where('slug', $tab);
            });
        }

        if ($isCustom) {
            $query->whereBetween('tanggal_publikasi', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $allInformasi = $query->orderBy('tanggal_publikasi', 'desc')->get();

        // If custom filter returned no records, fallback so page has content
        if ($isCustom && $allInformasi->isEmpty()) {
            $fallbackQuery = Informasi::with(['kategori', 'user'])->where('status', 'Publik');
            if ($tab !== 'semua') {
                $fallbackQuery->whereHas('kategori', function ($q) use ($tab) {
                    $q->where('slug', $tab);
                });
            }
            $allInformasi = $fallbackQuery->orderBy('tanggal_publikasi', 'desc')->get();
        }

        $beritaList = $allInformasi->where('kategori.slug', 'berita');
        $pengumumanList = $allInformasi->where('kategori.slug', 'pengumuman');
        $regulasiList = $allInformasi->where('kategori.slug', 'regulasi');
        $faqList = $allInformasi->where('kategori.slug', 'faq');

        return view('informasi.index', compact(
            'tab',
            'kategoris',
            'allInformasi',
            'beritaList',
            'pengumumanList',
            'regulasiList',
            'faqList',
            'filter'
        ));
    }

    public function show($id)
    {
        $info = Informasi::with(['kategori', 'user'])->findOrFail($id);
        return response()->json($info);
    }
}
