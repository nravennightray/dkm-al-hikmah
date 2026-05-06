<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index() 
    {
        return view('public.kegiatan.index');
    }
    public function showCategory($category) 
    {
        $kegiatans = [
            [
                'title' => 'Kajian Rutin: Adab Terhadap Orang Tua',
                'slug' => 'adab-orang-tua',
                'date' => '10 Mei 2026',
                'excerpt' => 'Membahas pentingnya berbakti kepada orang tua dalam pandangan Islam...',
                'image' => 'dkm-pic-1.jpeg'
            ],
            [
                'title' => 'Thaharah: Menyempurnakan Wudhu',
                'slug' => 'menyempurnakan-wudhu',
                'date' => '03 Mei 2026',
                'excerpt' => 'Sesi praktek cara berwudhu yang sesuai dengan sunnah Nabi SAW...',
                'image' => 'dkm-pic-2.jpg'
            ],
            [
                'title' => 'Kajian Kitab Riyadhus Shalihin',
                'slug' => 'riyadhus-shalihin-part-1',
                'date' => '26 April 2026',
                'excerpt' => 'Pembahasan bab ikhlas dan niat dalam setiap amal perbuatan...',
                'image' => 'dkm-pic-1.jpeg'
            ],
        ];

        $kegiatans = json_decode(json_encode($kegiatans));

        return view('public.kegiatan.category', compact('kegiatans', 'category'));
    }

    public function showDetail($category, $slug) {
        return view('public.kegiatan.post', compact('category', 'slug'));
    }
}
