<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    /**
     * Get all testimoni (Public)
     */
    public function index(): JsonResponse
    {
        $testimoni = Testimoni::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimoni,
        ]);
    }

    /**
     * Get all testimoni including inactive (Admin)
     */
    public function adminIndex(): JsonResponse
    {
        $testimoni = Testimoni::orderBy('urutan')->get();

        return response()->json([
            'success' => true,
            'data' => $testimoni,
        ]);
    }

    /**
     * Store new testimoni (Admin)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $path = $request->file('gambar')->store('testimoni', 'public');

        $testimoni = Testimoni::create([
            'gambar' => $path,
            'caption' => $request->caption,
            'urutan' => $request->urutan ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil ditambahkan',
            'data' => $testimoni,
        ], 201);
    }

    /**
     * Update testimoni (Admin)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan',
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
            Storage::disk('public')->delete($testimoni->gambar);
            $testimoni->gambar = $request->file('gambar')->store('testimoni', 'public');
        }

        if ($request->has('caption')) {
            $testimoni->caption = $request->caption;
        }
        if ($request->has('urutan')) {
            $testimoni->urutan = $request->urutan;
        }
        if ($request->has('is_active')) {
            $testimoni->is_active = $request->is_active;
        }

        $testimoni->save();

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil diupdate',
            'data' => $testimoni,
        ]);
    }

    /**
     * Delete testimoni (Admin)
     */
    public function destroy(int $id): JsonResponse
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan',
            ], 404);
        }

        // Delete image file
        Storage::disk('public')->delete($testimoni->gambar);
        $testimoni->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dihapus',
        ]);
    }
}
