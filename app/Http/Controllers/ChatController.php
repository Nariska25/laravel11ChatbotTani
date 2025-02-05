<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        // Kirim permintaan POST ke server Python Flask
        $response = Http::post('http://localhost:5000/chat', [
            'message' => $userMessage,
        ]);

        // Ambil balasan dari server Python dan kirim kembali ke frontend
        return response()->json([
            'reply' => $response->json()['reply']
        ]);
    }
}
