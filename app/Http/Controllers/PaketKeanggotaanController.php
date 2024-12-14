<?php

namespace App\Http\Controllers;

use App\Models\Paket_keanggotaan;
use Illuminate\Http\Request;
use Exception;

class PaketKeanggotaanController extends Controller
{
    // Index
    public function index()
    {
        try {
            $paket = Paket_keanggotaan::all();

            return response()->json([
                'message' => 'Data paket keanggotaan berhasil diambil.',
                'data' => $paket,
                'total' => $paket->count(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data paket keanggotaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'durasi' => 'required|in:1_bulan,6_bulan,1_tahun',
                'harga' => 'required|numeric|min:0',
            ]);

            $paket = Paket_keanggotaan::create($validated);

            return response()->json([
                'message' => 'Paket keanggotaan berhasil dibuat.',
                'data' => $paket,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat paket keanggotaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Show
    public function show($id)
    {
        try {
            $paket = Paket_keanggotaan::find($id);

            if (!$paket) {
                return response()->json([
                    'message' => 'Paket keanggotaan tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            return response()->json([
                'message' => 'Data paket keanggotaan berhasil diambil.',
                'data' => $paket,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data paket keanggotaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            $paket = Paket_keanggotaan::find($id);

            if (!$paket) {
                return response()->json([
                    'message' => 'Paket keanggotaan tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $validated = $request->validate([
                'durasi' => 'sometimes|in:1_bulan,6_bulan,1_tahun',
                'harga' => 'sometimes|numeric|min:0',
            ]);

            $paket->update($validated);

            return response()->json([
                'message' => 'Paket keanggotaan berhasil diperbarui.',
                'data' => $paket,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui paket keanggotaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Destroy
    public function destroy($id)
    {
        try {
            $paket = Paket_keanggotaan::find($id);

            if (!$paket) {
                return response()->json([
                    'message' => 'Paket keanggotaan tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $paket->delete();

            return response()->json([
                'message' => 'Paket keanggotaan berhasil dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus paket keanggotaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
