<?php

namespace App\Http\Controllers;

use App\Models\Pelatih;
use Illuminate\Http\Request;

class PelatihController extends Controller
{
    // Menampilkan semua pelatih
    public function index()
    {
        try {
            $pelatih = Pelatih::all();

            if ($pelatih->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada pelatih yang ditemukan.',
                    'data' => []
                ], 404); // Status code 404 karena tidak ada data
            }

            return response()->json([
                'message' => 'Data pelatih ditemukan.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk permintaan berhasil
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menambahkan pelatih baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'jenis_kelamin' => 'required|in:pria,wanita',
            ]);

            $pelatih = Pelatih::create($validatedData);

            return response()->json([
                'message' => 'Pelatih berhasil ditambahkan.',
                'data' => $pelatih
            ], 201); // Status code 201 untuk data yang berhasil dibuat
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menampilkan pelatih berdasarkan ID
    public function show($id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika data tidak ditemukan
            }

            return response()->json([
                'message' => 'Data pelatih ditemukan.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk permintaan berhasil
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Memperbarui data pelatih
    public function update(Request $request, $id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika pelatih tidak ditemukan
            }

            $validatedData = $request->validate([
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'jenis_kelamin' => 'required|in:pria,wanita',
            ]);

            $pelatih->update($validatedData);

            return response()->json([
                'message' => 'Data pelatih berhasil diperbarui.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk data yang berhasil diperbarui
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menghapus data pelatih
    public function destroy($id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika pelatih tidak ditemukan
            }

            $pelatih->delete();

            return response()->json([
                'message' => 'Pelatih berhasil dihapus.',
                'data' => null
            ], 200); // Status code 200 untuk data yang berhasil dihapus
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }
}
