<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keanggotaan;
use App\Models\Registrasi_keanggotaan;
use App\Models\Paket_keanggotaan;
use Carbon\Carbon;

class KeanggotaanController extends Controller
{
    /**
     * Membuat atau memperbarui keanggotaan berdasarkan pembayaran.
     */
    public function registerMembership(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'id_paket_keanggotaan' => 'required|exists:paket_keanggotaan,id_paket_keanggotaan',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
        ]);

        $paket = Paket_keanggotaan::find($validated['id_paket_keanggotaan']);

        if (!$paket) {
            return response()->json([
                'message' => 'Paket keanggotaan tidak ditemukan.',
            ], 404);
        }

        // Menghitung tanggal berakhir berdasarkan durasi paket
        $tanggalBerakhir = Carbon::parse($validated['tanggal_mulai']);
        switch ($paket->durasi) {
            case '1_bulan':
                $tanggalBerakhir = $tanggalBerakhir->addMonth();
                break;
            case '6_bulan':
                $tanggalBerakhir = $tanggalBerakhir->addMonths(6);
                break;
            case '1_tahun':
                $tanggalBerakhir = $tanggalBerakhir->addYear();
                break;
            default:
                return response()->json([
                    'message' => 'Durasi paket tidak valid.',
                ], 400);
        }

        // Simpan data keanggotaan
        $keanggotaan = Keanggotaan::updateOrCreate(
            ['id_user' => $user->id_user],
            [
                'id_paket_keanggotaan' => $validated['id_paket_keanggotaan'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_berakhir' => $tanggalBerakhir,
                'status' => true,
            ]
        );

        return response()->json([
            'message' => 'Keanggotaan berhasil didaftarkan.',
            'data' => $keanggotaan,
        ], 201);
    }


    /**
     * Menampilkan status keanggotaan pengguna.
     */
    public function showByUser(Request $request)
    {
        $user = $request->user();

        $keanggotaan = Keanggotaan::with('paket_keanggotaan')
            ->where('id_user', $user->id_user)
            ->first();

        if (!$keanggotaan) {
            return response()->json([
                'message' => 'Pengguna belum memiliki keanggotaan aktif.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data keanggotaan berhasil diambil.',
            'data' => $keanggotaan,
        ], 200);
    }
}

