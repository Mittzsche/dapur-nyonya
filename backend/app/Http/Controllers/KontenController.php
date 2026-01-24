<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    /**
     * Get all content (Public)
     */
    public function index(): JsonResponse
    {
        $konten = Konten::all()->keyBy('key');

        return response()->json([
            'success' => true,
            'data' => $konten,
        ]);
    }

    /**
     * Get content by key (Public)
     */
    public function show(string $key): JsonResponse
    {
        $konten = Konten::where('key', $key)->first();

        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Konten tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $konten,
        ]);
    }

    /**
     * Update or create content (Admin only)
     */
    public function update(Request $request, string $key): JsonResponse
    {
        $request->validate([
            'value' => 'nullable|string',
            'type' => 'in:text,image,html',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $konten = Konten::firstOrNew(['key' => $key]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($konten->type === 'image' && $konten->value) {
                Storage::disk('public')->delete($konten->value);
            }

            $path = $request->file('image')->store('konten', 'public');
            $konten->value = $path;
            $konten->type = 'image';
        } else {
            $konten->value = $request->value;
            $konten->type = $request->type ?? 'text';
        }

        $konten->save();

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil diupdate',
            'data' => $konten,
        ]);
    }

    /**
     * Bulk update content (Admin only)
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'contents' => 'required|array',
            'contents.*.key' => 'required|string',
            'contents.*.value' => 'nullable|string',
            'contents.*.type' => 'in:text,image,html',
        ]);

        foreach ($request->contents as $item) {
            Konten::updateOrCreate(
                ['key' => $item['key']],
                [
                    'value' => $item['value'] ?? '',
                    'type' => $item['type'] ?? 'text',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil diupdate',
        ]);
    }

    /**
     * Seed default content (One-time use, public access for initial setup)
     * This endpoint will only work if content table is empty
     */
    public function seedDefaults(): JsonResponse
    {
        // Safety check: only run if content is empty
        $existingCount = Konten::count();
        
        if ($existingCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Konten sudah ada di database. Seeder tidak dijalankan untuk keamanan.',
                'existing_count' => $existingCount,
            ], 400);
        }

        // Run the seeder
        try {
            \Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\KontenSeeder']);
            
            return response()->json([
                'success' => true,
                'message' => 'Konten default berhasil di-seed!',
                'data' => Konten::all()->keyBy('key'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error running seeder: ' . $e->getMessage(),
            ], 500);
        }
    }
}
