<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori_kelas;

class KategoriKelasController extends Controller
{
    // Menampilkan semua kategori kelas
    public function index()
    {
        try {
            $kategoriKelas = Kategori_Kelas::all();

            if ($kategoriKelas->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada kategori kelas yang ditemukan.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Data kategori kelas ditemukan.',
                'data' => $kategoriKelas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kategori kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Menambahkan kategori kelas baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_kategori' => 'required|string|max:255',
                'deskripsi_kategori' => 'nullable|string',
            ]);

            $kategoriKelas = Kategori_Kelas::create($validatedData);

            return response()->json([
                'message' => 'Kategori kelas berhasil ditambahkan.',
                'data' => $kategoriKelas
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan kategori kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan kategori kelas berdasarkan ID
    public function show($id)
    {
        try {
            $kategoriKelas = Kategori_Kelas::find($id);

            if (!$kategoriKelas) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'message' => 'Data kategori kelas ditemukan.',
                'data' => $kategoriKelas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kategori kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Memperbarui data kategori kelas
    public function update(Request $request, $id)
    {
        try {
            $kategoriKelas = Kategori_Kelas::find($id);

            if (!$kategoriKelas) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            $validatedData = $request->validate([
                'nama_kategori' => 'required|string|max:255',
                'deskripsi_kategori' => 'nullable|string',
            ]);

            $kategoriKelas->update($validatedData);

            return response()->json([
                'message' => 'Data kategori kelas berhasil diperbarui.',
                'data' => $kategoriKelas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data kategori kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Menghapus kategori kelas
    public function destroy($id)
    {
        try {
            $kategoriKelas = Kategori_Kelas::find($id);

            if (!$kategoriKelas) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            $kategoriKelas->delete();

            return response()->json([
                'message' => 'Kategori kelas berhasil dihapus.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kategori kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
