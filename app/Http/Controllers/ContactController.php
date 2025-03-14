<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Menyimpan data contact yang dikirim dari form.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan data ke tabel contacts
        Contact::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
