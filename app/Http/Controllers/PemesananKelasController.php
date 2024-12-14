<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan_kelas;
use App\Models\Paket_kelas;
use Carbon\Carbon;

class PemesananKelasController extends Controller
{
    // Menemukan pemesanan berdasarkan ID
    public function findById(Request $request, $id)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::where('id_user', $user->id_user)
            ->where('id_pemesanan_kelas', $id)
            ->first();

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan dengan ID tersebut tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Pemesanan berhasil ditemukan.',
            'data' => $pemesanan,
        ], 200);
    }

    // Menampilkan semua pesanan pengguna
    public function tampilPesanan(Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::with(['paket_kelas'])
            ->where('id_user', $user->id_user)
            ->get();

        return response()->json([
            'message' => 'Data pemesanan berhasil diambil.',
            'data' => $pemesanan,
        ], 200);
    }

    // Melakukan pemesanan kelas
    public function pesanKelas(Request $request)
    {
        $user = $request->user();

        // Validasi yang telah diperbarui untuk jenis_pembayaran
        $validated = $request->validate([
            'id_paket_kelas' => 'required|exists:paket_kelas,id_paket_kelas',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jenis_pembayaran' => 'required|in:Kartu Kredit,Kartu Debit,E Wallet',
        ]);

        $paket = Paket_kelas::findOrFail($validated['id_paket_kelas']);

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

        // Menyimpan pemesanan termasuk jenis_pembayaran
        $pemesanan = Pemesanan_kelas::create([
            'id_user' => $user->id_user,
            'id_paket_kelas' => $validated['id_paket_kelas'],
            'tanggal_pemesanan' => now(),
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $tanggalSelesai,
            'jenis_pembayaran' => $validated['jenis_pembayaran'],  // Menyimpan jenis pembayaran
        ]);

        return response()->json([
            'message' => 'Pemesanan berhasil dilakukan.',
            'data' => $pemesanan,
        ], 201);
    }

    // Menampilkan detail pemesanan berdasarkan ID
    public function show($id, Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::with(['paket_kelas'])
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
}
