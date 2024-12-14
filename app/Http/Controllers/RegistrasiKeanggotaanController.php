<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi_keanggotaan;
use App\Models\Paket_keanggotaan;
use Carbon\Carbon;

class RegistrasiKeanggotaanController extends Controller
{
    //riwayat pembayaran
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_paket_keanggotaan' => 'required|exists:paket_keanggotaan,id_paket_keanggotaan',
            'total_pembayaran' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Kartu Kredit,Kartu Debit,E Wallet',
        ]);

        $registrasi = Registrasi_keanggotaan::create([
            'id_user' => $validated['id_user'],
            'id_paket_keanggotaan' => $validated['id_paket_keanggotaan'],
            'tanggal_pembayaran' => now(),
            'total_pembayaran' => $validated['total_pembayaran'],
            'jenis_pembayaran' => $validated['jenis_pembayaran'],
        ]);

        return response()->json([
            'message' => 'Transaksi pembayaran berhasil disimpan.',
            'data' => $registrasi,
        ], 201);
    }

    //tampil riwayat
    public function showByUser(Request $request)
    {
        $user = $request->user();

        $riwayat = Registrasi_keanggotaan::with('paket_keanggotaan')
            ->where('id_user', $user->id_user)
            ->get();

        return response()->json([
            'message' => 'Riwayat pembayaran berhasil diambil.',
            'data' => $riwayat,
        ], 200);
    }
}
