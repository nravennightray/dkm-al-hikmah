<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() 
    {
        $summaries = [
            ['title' => 'Kas Masjid', 'slug' => 'laporan-kas', 'balance' => 'Rp 25.450.000', 'last_update' => 'Mei 2026'],
            ['title' => 'Tabungan Umroh', 'slug' => 'tabungan-umroh', 'balance' => 'Rp 12.000.000', 'last_update' => 'Mei 2026'],
            ['title' => 'Tabungan Qurban', 'slug' => 'tabungan-qurban', 'balance' => 'Rp 8.750.000', 'last_update' => 'Mei 2026'],
        ];

        $summaries = json_decode(json_encode($summaries));

        return view('public.laporan.index', compact('summaries'));
    }

    public function showReport($type) 
    {
        $reports = [
            ['date' => '01 Mei 2026', 'desc' => 'Saldo Awal', 'in' => 'Rp 5.000.000', 'out' => '-', 'balance' => 'Rp 5.000.000'],
            ['date' => '02 Mei 2026', 'desc' => 'Infaq Jumat', 'in' => 'Rp 2.500.000', 'out' => '-', 'balance' => 'Rp 7.500.000'],
            ['date' => '05 Mei 2026', 'desc' => 'Biaya Kebersihan', 'in' => '-', 'out' => 'Rp 500.000', 'balance' => 'Rp 7.000.000'],
        ];

        $reports = json_decode(json_encode($reports));

        return view('public.laporan.show', compact('reports', 'type'));
    }
}
