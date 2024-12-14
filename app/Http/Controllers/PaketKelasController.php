<?php

namespace App\Http\Controllers;

use App\Models\Paket_kelas;
use Illuminate\Http\Request;
use Exception;

class PaketKelasController extends Controller
{
    // Index
    public function index()
    {
        try {
            $paketKelas = Paket_kelas::all();

            return response()->json([
                'message' => 'Data paket kelas berhasil diambil.',
                'data' => $paketKelas,
                'total' => $paketKelas->count(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'durasi' => 'required|in:1_minggu,1_bulan,6_bulan',
                'harga' => 'required|numeric|min:0',
            ]);

            $paketKelas = Paket_kelas::create($validated);

            return response()->json([
                'message' => 'Paket kelas berhasil dibuat.',
                'data' => $paketKelas,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Show
    public function show($id)
    {
        try {
            $paketKelas = Paket_kelas::find($id);

            if (!$paketKelas) {
                return response()->json([
                    'message' => 'Paket kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            return response()->json([
                'message' => 'Data paket kelas berhasil diambil.',
                'data' => $paketKelas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            $paketKelas = Paket_kelas::find($id);

            if (!$paketKelas) {
                return response()->json([
                    'message' => 'Paket kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $validated = $request->validate([
                'durasi' => 'sometimes|in:1_minggu,1_bulan,6_bulan',
                'harga' => 'sometimes|numeric|min:0',
            ]);

            $paketKelas->update($validated);

            return response()->json([
                'message' => 'Paket kelas berhasil diperbarui.',
                'data' => $paketKelas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Destroy
    public function destroy($id)
    {
        try {
            $paketKelas = Paket_kelas::find($id);

            if (!$paketKelas) {
                return response()->json([
                    'message' => 'Paket kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $paketKelas->delete();

            return response()->json([
                'message' => 'Paket kelas berhasil dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
