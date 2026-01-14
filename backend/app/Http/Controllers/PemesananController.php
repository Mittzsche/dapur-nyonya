<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Http\Requests\PemesananRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    /**
     * Display a listing of pemesanan (Admin)
     * GET /api/admin/pemesanan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pemesanan::with(['layanan', 'mitra']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_acara', [$request->start_date, $request->end_date]);
        }

        $pemesanan = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pemesanan,
        ]);
    }

    /**
     * Store a newly created pemesanan (Public - Form pelanggan)
     * POST /api/pemesanan
     */
    public function store(PemesananRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status'] = Pemesanan::STATUS_MENUNGGU;

        $pemesanan = Pemesanan::create($data);
        $pemesanan->load('layanan');

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dikirim! Kami akan segera menghubungi Anda.',
            'data' => $pemesanan,
        ], 201);
    }

    /**
     * Display the specified pemesanan (Admin)
     * GET /api/admin/pemesanan/{id}
     */
    public function show($id): JsonResponse
    {
        $pemesanan = Pemesanan::with(['layanan', 'mitra'])->find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pemesanan,
        ]);
    }

    /**
     * Update the specified pemesanan (Admin)
     * PUT /api/admin/pemesanan/{id}
     */
    public function update(PemesananRequest $request, $id): JsonResponse
    {
        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        $pemesanan->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil diperbarui',
            'data' => $pemesanan,
        ]);
    }

    /**
     * Update status pemesanan (Admin)
     * PATCH /api/admin/pemesanan/{id}/status
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,dibatalkan',
        ]);

        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        $pemesanan->update(['status' => $request->status]);

        $statusMessages = [
            'menunggu' => 'Status diubah menjadi Menunggu',
            'dikonfirmasi' => 'Pesanan dikonfirmasi',
            'dibatalkan' => 'Pesanan dibatalkan',
        ];

        return response()->json([
            'success' => true,
            'message' => $statusMessages[$request->status],
            'data' => $pemesanan,
        ]);
    }

    /**
     * Remove the specified pemesanan (Admin)
     * DELETE /api/admin/pemesanan/{id}
     */
    public function destroy($id): JsonResponse
    {
        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        $pemesanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dihapus',
        ]);
    }
}
