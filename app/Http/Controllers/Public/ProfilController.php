<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index() {
        return view('public.profil.index');
    }

    public function sejarah() {
        return view('public.profil.sejarah');
    }

    public function visiMisi() {
        return view('public.profil.visi-misi');
    }

    public function struktur() {
        return view('public.profil.struktur');
    }

    public function kepengurusan() {
        return view('public.profil.kepengurusan');
    }
}
