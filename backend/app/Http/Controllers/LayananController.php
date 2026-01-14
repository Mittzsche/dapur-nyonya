<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Http\Requests\LayananRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    /**
     * Display a listing of layanan
     * GET /api/layanan
     */
    public function index(): JsonResponse
    {
        $layanan = Layanan::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $layanan,
        ]);
    }

    /**
     * Store a newly created layanan
     * POST /api/admin/layanan
     */
    public function store(LayananRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('images/layanan', 'public');
            $data['gambar'] = $path;
        }

        $layanan = Layanan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil ditambahkan',
            'data' => $layanan,
        ], 201);
    }

    /**
     * Display the specified layanan
     * GET /api/layanan/{id}
     */
    public function show($id): JsonResponse
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $layanan,
        ]);
    }

    /**
     * Update the specified layanan
     * PUT /api/admin/layanan/{id}
     */
    public function update(LayananRequest $request, $id): JsonResponse
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan tidak ditemukan',
            ], 404);
        }

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($layanan->gambar) {
                Storage::disk('public')->delete($layanan->gambar);
            }
            $path = $request->file('gambar')->store('images/layanan', 'public');
            $data['gambar'] = $path;
        }

        $layanan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil diperbarui',
            'data' => $layanan,
        ]);
    }

    /**
     * Remove the specified layanan
     * DELETE /api/admin/layanan/{id}
     */
    public function destroy($id): JsonResponse
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan tidak ditemukan',
            ], 404);
        }

        // Delete image if exists
        if ($layanan->gambar) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        $layanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus',
        ]);
    }
}
