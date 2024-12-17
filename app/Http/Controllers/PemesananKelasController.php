<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan_kelas;
use App\Models\Paket_kelas;
use Carbon\Carbon;

class PemesananKelasController extends Controller
{
    // Menemukan pemesanan berdasarkan id
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

    public function allPesananKelas()
    {
        $pemesanan = Pemesanan_kelas::all();

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

        $pemesanan = Pemesanan_kelas::create([
            'id_user' => $user->id_user,
            'id_paket_kelas' => $validated['id_paket_kelas'],
            'tanggal_pemesanan' => now(),
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $tanggalSelesai,
            'jenis_pembayaran' => $validated['jenis_pembayaran'],
        ]);

        return response()->json([
            'message' => 'Pemesanan berhasil dilakukan.',
            'data' => $pemesanan,
        ], 201);
    }

    // Menampilkan detail pemesanan berdasarkan id
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

    public function allById(Request $request)
    {
        $user = $request->user();

        $pemesanan = Pemesanan_kelas::where('id_user', $user->id_user)
            ->with(['paket_kelas.kelas.pelatih', 'paket_kelas.kelas.kategori'])
            ->get();

        if ($pemesanan->isEmpty()) {
            return response()->json([
                'message' => 'Pemesanan dengan ID tersebut tidak ditemukan.',
                'data' => [],
            ], 404);
        }

        $kelas = $pemesanan->map(function ($pemesanan) {
            return [
                'id_pemesanan_kelas' => $pemesanan->id_pemesanan_kelas,
                'kelas' => $pemesanan->paket_kelas->kelas ?? null,
            ];
        })->filter(function ($item) {
            return $item['kelas'] !== null;
        });

        return response()->json([
            'message' => 'Pemesanan berhasil ditemukan.',
            'data' => $kelas->values(),
        ], 200);
    }


}
