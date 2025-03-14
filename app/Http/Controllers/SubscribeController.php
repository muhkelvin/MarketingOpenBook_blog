<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    /**
     * Menyimpan data subscribe yang dikirim dari form.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'email' => 'required|email|unique:subscribes,email',
        ]);

        // Simpan data ke tabel subscribes
        Subscribe::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Thank you for subscribing!');
    }
}
