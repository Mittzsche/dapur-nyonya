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
     * Add ?force=1 to force re-seed even if data exists
     */
    public function seedDefaults(Request $request): JsonResponse
    {
        $force = $request->query('force', '0') === '1';
        
        // Safety check: only run if content is empty (unless forced)
        $existingCount = Konten::count();
        
        if ($existingCount > 0 && !$force) {
            return response()->json([
                'success' => false,
                'message' => 'Konten sudah ada di database. Tambahkan ?force=1 untuk re-seed.',
                'existing_count' => $existingCount,
            ], 400);
        }

        // Truncate if forcing
        if ($force) {
            Konten::truncate();
        }

        // Run the seeder
        try {
            \Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\KontenSeeder']);
            
            $allKonten = Konten::all()->keyBy('key');
            
            return response()->json([
                'success' => true,
                'message' => 'Konten default berhasil di-seed! Total: ' . $allKonten->count(),
                'data' => $allKonten,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error running seeder: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Direct seed without Artisan (alternative method if seeder fails)
     */
    public function seedDirect(Request $request): JsonResponse
    {
        $force = $request->query('force', '0') === '1';
        
        $existingCount = Konten::count();
        if ($existingCount > 0 && !$force) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah ada. Gunakan ?force=1 untuk re-seed.',
                'existing_count' => $existingCount,
            ], 400);
        }

        if ($force) {
            Konten::truncate();
        }

        try {
            $kontenData = [
                ['key' => 'home_logo', 'value' => '', 'type' => 'image'],
                ['key' => 'home_hero_1', 'value' => '', 'type' => 'image'],
                ['key' => 'home_hero_2', 'value' => '', 'type' => 'image'],
                ['key' => 'home_tentang_image', 'value' => '', 'type' => 'image'],
                ['key' => 'home_cara_pemesanan', 'value' => '', 'type' => 'image'],
                ['key' => 'contact_phone', 'value' => '+62 812-3456-7890', 'type' => 'text'],
                ['key' => 'contact_email', 'value' => 'info@dapurnyonya.com', 'type' => 'text'],
                ['key' => 'contact_address', 'value' => 'Sukabumi, Jawa Barat, Indonesia', 'type' => 'text'],
                ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'type' => 'text'],
            ];

            foreach ($kontenData as $data) {
                Konten::create($data);
            }

            $allKonten = Konten::all()->keyBy('key');

            return response()->json([
                'success' => true,
                'message' => 'Data konten berhasil di-insert langsung! Total: ' . $allKonten->count(),
                'data' => $allKonten,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inserting data: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
