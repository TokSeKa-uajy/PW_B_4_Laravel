<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umpan_balik;

class UmpanBalikController extends Controller
{
    // Tambah umpan balik
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'id_pemesanan_kelas' => 'required|exists:pemesanan_kelas,id_pemesanan_kelas',
            'rating' => 'nullable|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:255',
        ]);

        $data['id_user'] = $user->id_user;
        $data['tanggal_umpan_balik'] = now();

        $umpanBalik = Umpan_balik::create($data);

        return response()->json([
            'message' => 'Umpan balik berhasil ditambahkan.',
            'data' => $umpanBalik,
        ], 201);
    }

    // Lihat semua umpan balik
    public function index()
    {
        $umpanBalik = Umpan_balik::with('pemesanan_kelas.paket_kelas.kelas')->get();

        return response()->json([
            'message' => 'Data umpan balik berhasil diambil.',
            'data' => $umpanBalik,
        ], 200);
    }

    // Lihat detail umpan balik
    public function show($id)
    {
        $umpanBalik = Umpan_balik::with(['user', 'pemesananKelas'])->find($id);

        if (!$umpanBalik) {
            return response()->json(['message' => 'Umpan balik tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Detail umpan balik berhasil diambil.',
            'data' => $umpanBalik,
        ], 200);
    }

    // Perbarui umpan balik
    public function update(Request $request, $id)
    {
        $umpanBalik = Umpan_balik::find($id);

        if (!$umpanBalik) {
            return response()->json(['message' => 'Umpan balik tidak ditemukan.'], 404);
        }

        $data = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:255',
        ]);

        $umpanBalik->update($data);

        return response()->json([
            'message' => 'Umpan balik berhasil diperbarui.',
            'data' => $umpanBalik,
        ], 200);
    }

    // Hapus umpan balik
    public function destroy($id)
    {
        $umpanBalik = Umpan_balik::find($id);

        if (!$umpanBalik) {
            return response()->json(['message' => 'Umpan balik tidak ditemukan.'], 404);
        }

        $umpanBalik->delete();

        return response()->json(['message' => 'Umpan balik berhasil dihapus.'], 200);
    }
}
