<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /**
     * Display a listing of mitra
     * GET /api/admin/mitra
     */
    public function index(): JsonResponse
    {
        $mitra = Mitra::withCount('pemesanans')
            ->orderBy('nama_mitra', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $mitra,
        ]);
    }

    /**
     * Store a newly created mitra
     * POST /api/admin/mitra
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_mitra' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'alamat_mitra' => 'required|string',
        ], [
            'nama_mitra.required' => 'Nama mitra wajib diisi',
            'kontak.required' => 'Kontak mitra wajib diisi',
            'alamat_mitra.required' => 'Alamat mitra wajib diisi',
        ]);

        $mitra = Mitra::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mitra berhasil ditambahkan',
            'data' => $mitra,
        ], 201);
    }

    /**
     * Display the specified mitra
     * GET /api/admin/mitra/{id}
     */
    public function show($id): JsonResponse
    {
        $mitra = Mitra::withCount('pemesanans')->find($id);

        if (!$mitra) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mitra,
        ]);
    }

    /**
     * Update the specified mitra
     * PUT /api/admin/mitra/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $mitra = Mitra::find($id);

        if (!$mitra) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'nama_mitra' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'alamat_mitra' => 'required|string',
        ]);

        $mitra->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mitra berhasil diperbarui',
            'data' => $mitra,
        ]);
    }

    /**
     * Remove the specified mitra
     * DELETE /api/admin/mitra/{id}
     */
    public function destroy($id): JsonResponse
    {
        $mitra = Mitra::find($id);

        if (!$mitra) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan',
            ], 404);
        }

        // Check if mitra has pemesanan
        if ($mitra->pemesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak dapat dihapus karena masih memiliki pemesanan',
            ], 400);
        }

        $mitra->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mitra berhasil dihapus',
        ]);
    }
}
