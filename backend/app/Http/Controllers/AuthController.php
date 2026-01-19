<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login admin
     * POST /api/auth/login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        // Revoke existing tokens
        $admin->tokens()->delete();

        // Create new token
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'admin' => [
                    'id_admin' => $admin->id_admin,
                    'username' => $admin->username,
                    'nama_lengkap' => $admin->nama_lengkap,
                ],
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout admin
     * POST /api/auth/logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Get current admin info
     * GET /api/auth/me
     */
    public function me(Request $request): JsonResponse
    {
        $admin = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id_admin' => $admin->id_admin,
                'username' => $admin->username,
                'nama_lengkap' => $admin->nama_lengkap,
            ],
        ]);
    }
}
