<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi_keanggotaan;
use App\Models\Keanggotaan;
use App\Models\Pemesanan_kelas;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function totalKeanggotaanPesan(): JsonResponse
    {
        $jumlahRegistrasiKeanggotaan = Registrasi_keanggotaan::count();

        // Hitung jumlah data pada tabel `pemesanan_kelas`
        $jumlahPemesananKelas = Pemesanan_kelas::count();

        // Return data dalam format JSON
        return response()->json([
            'jumlah_registrasi_keanggotaan' => $jumlahRegistrasiKeanggotaan,
            'jumlah_pemesanan_kelas' => $jumlahPemesananKelas,
        ]);
    }

    public function hitungKeuntungan(): JsonResponse
    {
        $keuntunganPemesananKelas = Pemesanan_kelas::join('paket_kelas', 'pemesanan_kelas.id_paket_kelas', '=', 'paket_kelas.id_paket_kelas')
            ->sum('paket_kelas.harga');

        $keuntunganRegistrasiKeanggotaan = Registrasi_keanggotaan::sum('total_pembayaran');

        $totalKeuntungan = $keuntunganPemesananKelas + $keuntunganRegistrasiKeanggotaan;

        // Return data dalam format JSON
        return response()->json([
            'keuntungan_pemesanan_kelas' => $keuntunganPemesananKelas,
            'keuntungan_registrasi_keanggotaan' => $keuntunganRegistrasiKeanggotaan,
            'total_keuntungan' => $totalKeuntungan,
        ]);
    }
}
