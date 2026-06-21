<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Mahasiswa;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Data
        $totalJurnal = Jurnal::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalUser = User::count();
        $totalKategori = Kategori::count();

        // 2. Statistik Jurnal per Prodi
        $statistikProdi = Jurnal::select('mahasiswa.prodi', DB::raw('count(*) as total'))
            ->join('penulis as mahasiswa', 'jurnals.penulis', '=', 'mahasiswa.penulis')
            ->groupBy('mahasiswa.prodi')
            ->orderBy('total', 'desc')
            ->get();

        // 3. Statistik Jurnal per Kategori
        $statistikKategori = Jurnal::select('kategoris.nama_kategori', DB::raw('count(*) as total'))
            ->join('kategoris', 'jurnals.id_kategori', '=', 'kategoris.id_kategori')
            ->groupBy('kategoris.nama_kategori')
            ->orderBy('total', 'desc')
            ->get();

        // 4. Statistik Jurnal per Tahun
        $statistikTahun = Jurnal::select(DB::raw('YEAR(tgl_upload) as tahun'), DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        // 5. Statistik Jurnal per Status
        $statistikStatus = Jurnal::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 6. 5 Jurnal Terbaru
        $jurnalTerbaru = Jurnal::with('mahasiswa', 'kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Data untuk chart
        $labelsProdi = $statistikProdi->pluck('prodi')->toArray();
        $dataProdi = $statistikProdi->pluck('total')->toArray();

        $labelsKategori = $statistikKategori->pluck('nama_kategori')->toArray();
        $dataKategori = $statistikKategori->pluck('total')->toArray();

        $labelsTahun = $statistikTahun->pluck('tahun')->toArray();
        $dataTahun = $statistikTahun->pluck('total')->toArray();

        $labelsStatus = $statistikStatus->pluck('status')->toArray();
        $dataStatus = $statistikStatus->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalJurnal',
            'totalMahasiswa',
            'totalUser',
            'totalKategori',
            'statistikProdi',
            'statistikKategori',
            'statistikTahun',
            'statistikStatus',
            'jurnalTerbaru',
            'labelsProdi',
            'dataProdi',
            'labelsKategori',
            'dataKategori',
            'labelsTahun',
            'dataTahun',
            'labelsStatus',
            'dataStatus'
        ));
    }
}