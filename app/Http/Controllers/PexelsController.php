<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PexelsController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => ['nullable', 'string', 'max:100'],
        ]);

        $apiKey = env('PEXELS_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'message' => 'Pexels API key is missing. Add PEXELS_API_KEY in your .env file.',
            ], 500);
        }

        $query = $validated['query'] ?? 'event celebration';

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get('https://api.pexels.com/v1/search', [
            'query' => $query,
            'per_page' => 12,
            'orientation' => 'landscape',
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Unable to fetch images from Pexels.',
                'status' => $response->status(),
            ], 500);
        }

        $photos = collect($response->json('photos'))->map(function ($photo) {
            return [
                'id' => $photo['id'],
                'pexels_url' => $photo['url'],
                'photographer' => $photo['photographer'],
                'photographer_url' => $photo['photographer_url'],
                'image' => $photo['src']['large2x'] ?? $photo['src']['large'],
                'thumbnail' => $photo['src']['medium'],
            ];
        });

        return response()->json([
            'photos' => $photos,
        ]);
    }
}