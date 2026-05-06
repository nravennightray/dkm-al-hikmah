<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MusalaController extends Controller
{
    public function index() 
    {
        $locations = [
            [
                'name' => 'Musala Kantor',
                'slug' => 'musala-kantor',
                'short_desc' => 'Terletak di lantai 2 gedung utama, nyaman dan ber-AC.',
                'image' => 'musala-office.jpg'
            ],
            [
                'name' => 'Musala Plant',
                'slug' => 'musala-plant',
                'short_desc' => 'Dekat dengan area produksi, area wudhu luas untuk jamaah banyak.',
                'image' => 'musala-plant.jpg'
            ]
        ];

        $locations = json_decode(json_encode($locations));

        return view('public.musala.index', compact('locations'));
}

    public function show($name) 
    {
        $data = [
            'musala-kantor' => [
                'title' => 'Musala Kantor',
                'location' => 'Lantai 2, Gedung Utama (Office)',
                'capacity' => '50 Jamaah',
                'facilities' => ['AC', 'Mukena & Sarung', 'Tempat Wudhu Dalam', 'Sound System'],
                'image' => 'musala-office.jpg'
            ],
            'musala-plant' => [
                'title' => 'Musala Plant',
                'location' => 'Area Produksi (Samping Workshop)',
                'capacity' => '100 Jamaah',
                'facilities' => ['Exhaust Fan', 'Tempat Wudhu Luar', 'Loker Sepatu', 'Area Shalat Luas'],
                'image' => 'musala-plant.jpg'
            ]
        ];

        $musala = json_decode(json_encode($data[$name] ?? abort(404)));

        return view('public.musala.show', compact('musala'));
    }
}
