<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan_kelas;
use App\Models\Kelas;
use App\Models\Paket_kelas;
use Carbon\Carbon;

class PemesananKelasController extends Controller
{
    public function findById(Request $request, $id)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::where('id_user', $user->id_user)
            ->where('id_pemesanan_kelas', $id)
            ->first();

        // Jika pemesanan tidak ditemukan, kembalikan respon error 404
        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan dengan ID tersebut tidak ditemukan.',
            ], 404);
        }

        // Mengembalikan pemesanan yang ditemukan dengan data lengkap
        return response()->json([
            'message' => 'Pemesanan berhasil ditemukan.',
            'data' => $pemesanan,
        ], 200);
    }


    public function tampilPesanan(Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::with(['kelas', 'paket_kelas'])
            ->where('id_user', $user->id_user)
            ->get();

        return response()->json([
            'message' => 'Data pemesanan berhasil diambil.',
            'data' => $pemesanan,
        ], 200);
    }

    public function pesanKelas(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_paket_kelas' => 'required|exists:paket_kelas,id_paket_kelas',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jenis_pembayaran' => 'required|in:Kartu Kredit,Kartu Debit,E Wallet',
        ]);

        $paket = Paket_kelas::findOrFail($validated['id_paket_kelas']);

        // Menghitung tanggal selesai berdasarkan durasi paket
        $tanggalSelesai = Carbon::parse($validated['tanggal_mulai']);
        switch ($paket->durasi) {
            case '1_minggu':
                $tanggalSelesai = $tanggalSelesai->addWeek();
                break;
            case '1_bulan':
                $tanggalSelesai = $tanggalSelesai->addMonth();
                break;
            case '6_bulan':
                $tanggalSelesai = $tanggalSelesai->addMonths(6);
                break;
        }

        $pemesanan = Pemesanan_kelas::create([
            'id_user' => $user->id_user,
            'id_kelas' => $validated['id_kelas'],
            'id_paket_kelas' => $validated['id_paket_kelas'],
            'tanggal_pemesanan' => now(),
            'status_pembayaran' => 'Tertunda',
            'jenis_pembayaran' => $validated['jenis_pembayaran'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $tanggalSelesai,
        ]);

        return response()->json([
            'message' => 'Pemesanan berhasil dilakukan.',
            'data' => $pemesanan,
        ], 201);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::with(['kelas', 'paket_kelas'])
            ->where('id_user', $user->id_user)
            ->find($id);

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail pemesanan berhasil diambil.',
            'data' => $pemesanan,
        ], 200);
    }

    public function updateStatusPembayaran(Request $request, $id)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::where('id_user', $user->id_user)->find($id);

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Tertunda,Gagal',
        ]);

        $pemesanan->update($validated);

        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
            'data' => $pemesanan,
        ], 200);
    }

    public function hapusPesanan($id, Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::where('id_user', $user->id_user)->find($id);

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan tidak ditemukan.',
            ], 404);
        }

        $pemesanan->delete();

        return response()->json([
            'message' => 'Pemesanan berhasil dihapus.',
        ], 200);
    }
}
