<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriWisataController extends Controller
{
    public function index()
    {
        return view('pages.desa.galeri-wisata.index');
    }

    public function uploadStore(Request $request)
    {
        // Logic untuk menyimpan foto/video
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,jpg,png,mp4,avi|max:10240',
            'category' => 'required|string',
            'year' => 'required|integer'
        ]);

        // Proses upload file
        // ... logic upload

        return redirect()->route('desa.galeri-wisata.index')->with('success', '✅ Foto berhasil diunggah ke galeri desa.');
    }
}