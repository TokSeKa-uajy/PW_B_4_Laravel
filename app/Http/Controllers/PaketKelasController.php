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
                'id_kelas' => 'required|exists:kelas,id_kelas',
                'durasi' => 'required|in:1_bulan,6_bulan,1_tahun',
                'harga' => 'required|numeric|min:0',
            ]);

            $paketKelas = Paket_kelas::create([
                'id_kelas' => $validated['id_kelas'],
                'durasi' => $validated['durasi'],
                'harga' => $validated['harga'],
            ]);

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
                'id_kelas' => 'sometimes|exists:kelas,id_kelas',
                'durasi' => 'sometimes|in:1_bulan,6_bulan,1_tahun',
                'harga' => 'sometimes|numeric|min:0',
            ]);

            if (isset($validated['id_kelas'])) {
                $paketKelas->id_kelas = $validated['id_kelas'];
            }

            if (isset($validated['durasi'])) {
                $paketKelas->durasi = $validated['durasi'];
            }
            if (isset($validated['harga'])) {
                $paketKelas->harga = $validated['harga'];
            }

            $paketKelas->save();

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

    public function indexKelas($idKelas)
    {
        try {
            $paketKelas = Paket_kelas::where('id_kelas', $idKelas)->get()->all();

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

    public function idPaket($id_kelas)
    {
        try {
            $paketKelas = Paket_kelas::where('id_kelas', $id_kelas)
                ->select('id_paket_kelas', 'durasi', 'harga')
                ->get();

            if ($paketKelas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "Tidak ada paket kelas yang ditemukan untuk id_kelas {$id_kelas}.",
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $paketKelas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data paket kelas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
