<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi_keanggotaan;
use App\Models\Paket_keanggotaan;
use App\Http\Controllers\KeanggotaanController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegistrasiKeanggotaanController extends Controller
{
    //riwayat pembayaran
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'id_paket_keanggotaan' => 'required|exists:paket_keanggotaan,id_paket_keanggotaan',
            'jenis_pembayaran' => 'required|in:Kartu Kredit,Kartu Debit,E Wallet',
        ]);

        $paket = DB::table('paket_keanggotaan')
            ->select('harga')
            ->where('id_paket_keanggotaan', $validated['id_paket_keanggotaan'])
            ->first();

        if (!$paket) {
            return response()->json([
                'message' => 'Paket keanggotaan tidak ditemukan.',
            ], 404);
        }

        // Simpan pembayaran
        $registrasi = Registrasi_keanggotaan::create([
            'id_user' => $user->id_user,
            'id_paket_keanggotaan' => $validated['id_paket_keanggotaan'],
            'tanggal_pembayaran' => now(),
            'total_pembayaran' => $paket->harga,
            'jenis_pembayaran' => $validated['jenis_pembayaran'],
        ]);

        // Lanjutkan proses keanggotaan
        $keanggotaanController = new KeanggotaanController();
        $keanggotaanRequest = new Request([
            'id_paket_keanggotaan' => $validated['id_paket_keanggotaan'],
            'tanggal_mulai' => now(),
        ]);
        $keanggotaanRequest->setUserResolver(function () use ($request) {
            return $request->user();
        });

        $keanggotaanResponse = $keanggotaanController->registerMembership($keanggotaanRequest);

        if ($keanggotaanResponse->getStatusCode() !== 201) {
            return response()->json([
                'message' => 'Pembayaran berhasil, tetapi pendaftaran keanggotaan gagal.',
                'data' => $registrasi,
                'error' => json_decode($keanggotaanResponse->getContent(), true),
            ], 500);
        }

        return response()->json([
            'message' => 'Pembayaran berhasil dan keanggotaan didaftarkan.',
            'data' => [
                'registrasi' => $registrasi,
                'keanggotaan' => json_decode($keanggotaanResponse->getContent(), true)['data'],
            ],
        ], 201);
    }

    //tampil riwayat
    // public function showByUser(Request $request)
    // {
    //     $user = $request->user();

    //     $riwayat = Registrasi_keanggotaan::with('paket_keanggotaan')
    //         ->where('id_user', $user->id_user)
    //         ->get();

    //     return response()->json([
    //         'message' => 'Riwayat pembayaran berhasil diambil.',
    //         'data' => $riwayat,
    //     ], 200);
    // }

public function checkMembershipStatus(Request $request)
    {
        $user = $request->user();

        // Cek apakah ada data dengan id_user di tabel registrasi_keanggotaan
        $exists = Registrasi_keanggotaan::where('id_user', $user->id_user)->exists();

        // Mengembalikan response boolean
        return response()->json([
            'status' => $exists,
            'message' => $exists ? 'Keanggotaan ditemukan.' : 'Keanggotaan tidak ditemukan.'
        ], 200);
    }

    public function index()
    {
        try {
            $registrasi = Registrasi_keanggotaan::with(['user', 'paket_keanggotaan'])->get();

            if ($registrasi->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada data registrasi keanggotaan yang ditemukan.',
                    'data' => []
                ], 404);
            }

            // Jika data ditemukan
            return response()->json([
                'message' => 'Data registrasi keanggotaan berhasil diambil.',
                'data' => $registrasi
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi error
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data registrasi keanggotaan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllRegistrasiKeanggotaanByID(Request $request)
    {
        $user = $request->user();

        // Ambil semua data registrasi berdasarkan id_user
        $registrasiKeanggotaan = Registrasi_keanggotaan::where('id_user', $user->id_user)
            // ->with('paketKeanggotaan') // Jika Anda memiliki relasi ke tabel paket_keanggotaan
            ->get();

        // Periksa apakah data ditemukan
        if ($registrasiKeanggotaan->isEmpty()) {
            return response()->json([
                'message' => 'Keanggotaan tidak ditemukan.',
                'data' => []
            ], 404);
        }

        // Kembalikan response dengan data registrasi keanggotaan
        return response()->json([
            'message' => 'Keanggotaan ditemukan.',
            'data' => $registrasiKeanggotaan
        ], 200);
    }

}
