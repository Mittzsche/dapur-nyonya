<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display sales report
     * GET /api/admin/penjualan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pemesanan::with(['layanan', 'mitra'])
            ->where('status', Pemesanan::STATUS_DIKONFIRMASI);

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_acara', [$request->start_date, $request->end_date]);
        }

        // Filter by month
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('tanggal_acara', $request->month)
                ->whereYear('tanggal_acara', $request->year);
        }

        $penjualan = $query->orderBy('tanggal_acara', 'desc')->get();

        // Calculate totals
        $totalTransaksi = $penjualan->count();
        $totalPendapatan = $penjualan->sum(function ($item) {
            return $item->layanan ? $item->layanan->harga : 0;
        });

        return response()->json([
            'success' => true,
            'data' => [
                'penjualan' => $penjualan,
                'summary' => [
                    'total_transaksi' => $totalTransaksi,
                    'total_pendapatan' => $totalPendapatan,
                ],
            ],
        ]);
    }

    /**
     * Display sales summary/statistics
     * GET /api/admin/penjualan/summary
     */
    public function summary(Request $request): JsonResponse
    {
        // Total pesanan hari ini
        $today = now()->toDateString();
        $pesananHariIni = Pemesanan::whereDate('created_at', $today)->count();

        // Total pesanan menunggu konfirmasi
        $pesananMenunggu = Pemesanan::where('status', Pemesanan::STATUS_MENUNGGU)->count();

        // Total pesanan dikonfirmasi bulan ini
        $bulanIni = now()->month;
        $tahunIni = now()->year;
        $pesananBulanIni = Pemesanan::where('status', Pemesanan::STATUS_DIKONFIRMASI)
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        // Total pendapatan bulan ini
        $pendapatanBulanIni = Pemesanan::with('layanan')
            ->where('status', Pemesanan::STATUS_DIKONFIRMASI)
            ->whereMonth('tanggal_acara', $bulanIni)
            ->whereYear('tanggal_acara', $tahunIni)
            ->get()
            ->sum(function ($item) {
                return $item->layanan ? $item->layanan->harga : 0;
            });

        // Layanan terpopuler
        $layananPopuler = Pemesanan::select('id_layanan', DB::raw('count(*) as total'))
            ->where('status', Pemesanan::STATUS_DIKONFIRMASI)
            ->groupBy('id_layanan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('layanan')
            ->get();

        // Statistik per status
        $statusStats = [
            'menunggu' => Pemesanan::where('status', Pemesanan::STATUS_MENUNGGU)->count(),
            'dikonfirmasi' => Pemesanan::where('status', Pemesanan::STATUS_DIKONFIRMASI)->count(),
            'dibatalkan' => Pemesanan::where('status', Pemesanan::STATUS_DIBATALKAN)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'pesanan_hari_ini' => $pesananHariIni,
                'pesanan_menunggu' => $pesananMenunggu,
                'pesanan_bulan_ini' => $pesananBulanIni,
                'pendapatan_bulan_ini' => $pendapatanBulanIni,
                'layanan_populer' => $layananPopuler,
                'status_stats' => $statusStats,
            ],
        ]);
    }
}
