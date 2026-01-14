<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Get all galeri (Public)
     */
    public function index(): JsonResponse
    {
        $galeri = Galeri::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $galeri,
        ]);
    }

    /**
     * Get all galeri including inactive (Admin)
     */
    public function adminIndex(): JsonResponse
    {
        $galeri = Galeri::orderBy('urutan')->get();

        return response()->json([
            'success' => true,
            'data' => $galeri,
        ]);
    }

    /**
     * Store new galeri (Admin)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $path = $request->file('gambar')->store('galeri', 'public');

        $galeri = Galeri::create([
            'gambar' => $path,
            'caption' => $request->caption,
            'urutan' => $request->urutan ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil ditambahkan',
            'data' => $galeri,
        ], 201);
    }

    /**
     * Update galeri (Admin)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $galeri = Galeri::find($id);

        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image
            Storage::disk('public')->delete($galeri->gambar);
            $galeri->gambar = $request->file('gambar')->store('galeri', 'public');
        }

        if ($request->has('caption')) {
            $galeri->caption = $request->caption;
        }
        if ($request->has('urutan')) {
            $galeri->urutan = $request->urutan;
        }
        if ($request->has('is_active')) {
            $galeri->is_active = $request->is_active;
        }

        $galeri->save();

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil diupdate',
            'data' => $galeri,
        ]);
    }

    /**
     * Delete galeri (Admin)
     */
    public function destroy(int $id): JsonResponse
    {
        $galeri = Galeri::find($id);

        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan',
            ], 404);
        }

        // Delete image file
        Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil dihapus',
        ]);
    }
}
