<?php

namespace App\Http\Controllers;

use App\Models\Pelatih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class PelatihController extends Controller
{
    // Menampilkan semua pelatih
    public function index()
    {
        try {
            $pelatih = Pelatih::all();

            if ($pelatih->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada pelatih yang ditemukan.',
                    'data' => []
                ], 404); // Status code 404 karena tidak ada data
            }

            return response()->json([
                'message' => 'Data pelatih ditemukan.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk permintaan berhasil
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menambahkan pelatih baru
    public function store(Request $request)
    {
        try {
            $storeData = $request->all();

            $validate = Validator::make($storeData, [
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'jenis_kelamin' => 'required|in:pria,wanita',
            ]);

            if ($validate->fails()) {
                return response(['message'=> $validate->errors()],400);
            }
            
            if ($request->hasFile('foto_profil')) {
                $uploadFolder = 'pelatih';
                $image = $request->file('foto_profil');
                $image_uploaded_path = $image->store($uploadFolder, 'public');
                $uploadedImageResponse = basename($image_uploaded_path);
                $storeData['foto_profil'] = $uploadedImageResponse;
            }

            $pelatih = Pelatih::create($storeData);

            return response()->json([
                'message' => 'Pelatih berhasil ditambahkan.',
                'data' => $pelatih
            ], 201); // Status code 201 untuk data yang berhasil dibuat
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menampilkan pelatih berdasarkan ID
    public function show($id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika data tidak ditemukan
            }

            return response()->json([
                'message' => 'Data pelatih ditemukan.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk permintaan berhasil
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Memperbarui data pelatih
    public function update(Request $request, $id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika pelatih tidak ditemukan
            }
            $updateData = $request->all();

            $validate = Validator::make($updateData,[
                'nama_depan' => 'nullable|string|max:255',
                'nama_belakang' => 'nullable|string|max:255',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'jenis_kelamin' => 'nullable|in:pria,wanita',
            ]);

            if ($validate->fails()) {
                return response(['message'=> $validate->errors()],400);
            }

            if($request->hasFile('foto_profil')){
                // kalau kalian membaca ini, ketahuilah bahwa gambar tidak akan bisa diupdate karena menggunakan method PUT ;)
                // kalian bisa mengubahnya menjadi POST atau PATCH untuk mengupdate gambar
                $uploadFolder = 'pelatih';
                $image = $request->file('foto_profil');
                $image_uploaded_path = $image->store($uploadFolder, 'public');
                $uploadedImageResponse = basename($image_uploaded_path);
    
                // hapus data foto_profil yang lama dari storage
                Storage::disk('public')->delete('pelatih/'.$pelatih->foto_profil);
    
                // set foto_profil yang baru
                $updateData['foto_profil'] = $uploadedImageResponse;
            }

            $pelatih->update($updateData);

            return response()->json([
                'message' => 'Data pelatih berhasil diperbarui.',
                'data' => $pelatih
            ], 200); // Status code 200 untuk data yang berhasil diperbarui
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }

    // Menghapus data pelatih
    public function destroy($id)
    {
        try {
            $pelatih = Pelatih::find($id);

            if (!$pelatih) {
                return response()->json([
                    'message' => 'Pelatih tidak ditemukan.',
                    'data' => null
                ], 404); // Status code 404 jika pelatih tidak ditemukan
            }

            $pelatih->delete();

            return response()->json([
                'message' => 'Pelatih berhasil dihapus.',
                'data' => null
            ], 200); // Status code 200 untuk data yang berhasil dihapus
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data pelatih.',
                'error' => $e->getMessage()
            ], 500); // Status code 500 jika ada error server
        }
    }
}
