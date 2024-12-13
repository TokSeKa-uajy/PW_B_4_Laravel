<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::with(['pelatih', 'kategori'])->get();

        return response()->json([
            'message' => 'Data kelas berhasil diambil',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelatih' => 'required|exists:pelatih,id',
            'id_kategori' => 'required|exists:kategori_kelas,id',
            'nama_kelas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu,Setiap Hari',
            'jam_mulai' => 'required|date_format:H:i',
            'durasi' => 'required|date_format:H:i',
            'harga' => 'required|numeric|min:0',
            'kapasitas_kelas' => 'required|integer|min:1',
        ]);

        $kelas = Kelas::create($validated);

        return response()->json([
            'message' => 'Kelas berhasil dibuat',
            'data' => $kelas,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::with(['pelatih', 'kategori'])->find($id);

        if (!$kelas) {
            return response()->json([
                'message' => 'Kelas tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data kelas berhasil diambil',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'message' => 'Kelas tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_pelatih' => 'sometimes|exists:pelatih,id',
            'id_kategori' => 'sometimes|exists:kategori_kelas,id',
            'nama_kelas' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'hari' => 'sometimes|string|max:50',
            'jam_mulai' => 'sometimes|date_format:H:i',
            'durasi' => 'sometimes|integer|min:1',
            'harga' => 'sometimes|numeric|min:0',
            'kapasitas_kelas' => 'sometimes|integer|min:1',
        ]);

        $kelas->update($validated);

        return response()->json([
            'message' => 'Kelas berhasil diupdate',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        $kelas->delete();

        return response()->json([
            'message' => 'Kelas berhasil dihapus',
        ], 200);
    }
}

