<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Halaman About
    public function about()
    {
        return view('pages.about');
    }

    // Halaman Contact
    public function contact()
    {
        return view('pages.contact');
    }
}
