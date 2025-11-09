<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }
    
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);
        
        // Logic untuk menyimpan pesan kontak
        // Bisa menggunakan Mail, Queue, atau database
        
        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.'
        ]);
    }
    
    public function quickContact(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        // Logic untuk quick contact
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah terkirim!'
        ]);
    }
}

