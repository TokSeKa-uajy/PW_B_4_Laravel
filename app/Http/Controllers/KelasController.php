<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Exception;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $kelas = Kelas::with(['pelatih', 'kategori'])->get();

            return response()->json([
                'message' => 'Data kelas berhasil diambil.',
                'data' => $kelas,
                'total' => $kelas->count(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_pelatih' => 'required|exists:pelatih,id_pelatih',
                'id_kategori_kelas' => 'required|exists:kategori_kelas,id_kategori_kelas',
                'nama_kelas' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu,Setiap Hari',
                'jam_mulai' => 'required|date_format:H:i',
                'durasi' => 'required|date_format:H:i',
                'kapasitas_kelas' => 'required|integer|min:1',
            ]);

            $kelas = Kelas::create($validated);

            return response()->json([
                'message' => 'Kelas berhasil dibuat.',
                'data' => $kelas,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $kelas = Kelas::with(['pelatih', 'kategori'])->find($id);

            if (!$kelas) {
                return response()->json([
                    'message' => 'Kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            return response()->json([
                'message' => 'Data kelas berhasil diambil.',
                'data' => $kelas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $kelas = Kelas::find($id);

            if (!$kelas) {
                return response()->json([
                    'message' => 'Kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $validated = $request->validate([
                'id_pelatih' => 'sometimes|exists:pelatih,id_pelatih',
                'id_kategori' => 'sometimes|exists:kategori_kelas,id_kategori_kelas',
                'nama_kelas' => 'sometimes|string|max:255',
                'deskripsi' => 'nullable|string',
                'hari' => 'sometimes|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu,Setiap Hari',
                'jam_mulai' => 'sometimes|date_format:H:i',
                'durasi' => 'sometimes|date_format:H:i',
                'kapasitas_kelas' => 'sometimes|integer|min:1',
            ]);

            $kelas->update($validated);

            return response()->json([
                'message' => 'Kelas berhasil diperbarui.',
                'data' => $kelas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $kelas = Kelas::find($id);

            if (!$kelas) {
                return response()->json([
                    'message' => 'Kelas tidak ditemukan.',
                    'id' => $id,
                ], 404);
            }

            $kelas->delete();

            return response()->json([
                'message' => 'Kelas berhasil dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
