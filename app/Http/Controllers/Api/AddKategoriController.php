<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddKategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AddKategoriController extends Controller
{
    // Menampilkan semua kategori kelas
    public function index()
    {
        try {
            $addKategori = AddKategori::all();

            if ($addKategori->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada kategori kelas yang ditemukan.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Data kategori kelas ditemukan.',
                'data' => $addKategori
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
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            $addKategori = AddKategori::create($validatedData);

            return response()->json([
                'message' => 'Kategori kelas berhasil ditambahkan.',
                'data' => $addKategori
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
            $addKategori = AddKategori::find($id);

            if (!$addKategori) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'message' => 'Data kategori kelas ditemukan.',
                'data' => $addKategori
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
            $addKategori = AddKategori::find($id);

            if (!$addKategori) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            $addKategori->update($validatedData);

            return response()->json([
                'message' => 'Data kategori kelas berhasil diperbarui.',
                'data' => $addKategori
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
            $addKategori = AddKategori::find($id);

            if (!$addKategori) {
                return response()->json([
                    'message' => 'Kategori kelas tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            $addKategori->delete();

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
