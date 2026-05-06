<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    public function index() 
    {
        $accounts = [
            ['bank' => 'Mandiri', 'number' => '123-00-0987654-3', 'holder' => 'DKM Al Hikmah'],
            ['bank' => 'BSI', 'number' => '711-22-33445', 'holder' => 'Infaq Masjid Al Hikmah']
        ];

        $accounts = json_decode(json_encode($accounts));

        return view('public.infaq.index', compact('accounts'));
    }
}
