<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function profile()
    {
        try {
            // Ambil user yang sedang login
            $user = Auth::user();

            // Jika user tidak ditemukan (tidak login)
            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            // $fotoProfil = url('user/' . $user->foto_profil);

            // Kembalikan data user
            return response()->json([
                'message' => 'Data profil berhasil diambil.',
                'data' => [
                    'id_user' => $user->id_user,
                    'email' => $user->email,
                    'nomor_telepon' => $user->nomor_telepon,
                    'nama_depan' => $user->nama_depan,
                    'nama_belakang' => $user->nama_belakang,
                    'role' => $user->role,
                    'jenis_kelamin' => $user->jenis_kelamin,
                    'foto_profil' => $user->foto_profil,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Jika ada kesalahan
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data profil.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload foto profil pengguna.
     */
    public function registerFoto(Request $request)
    {
        // Validasi input file
        $validator = Validator::make($request->all(), [
            'foto_profil' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Maksimum 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('foto_profil')) {
            // Ambil data user yang sedang login
            $user = $request->user();

            // Proses penyimpanan file
            $file = $request->file('foto_profil');
            $fileName = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('foto_profils', $fileName, 'public');

            $user->foto_profil = $path;
            $user->save();

            return response()->json([
                'message' => 'Foto profil berhasil diunggah',
                'data' => [
                    'user_id' => $user->id,
                    'foto_profil' => asset('storage/' . $path), // URL lengkap file
                ],
            ], 200);
        } else {
            return response()->json([
                'message' => 'File tidak ditemukan atau tidak valid',
            ], 422);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'nomor_telepon' => 'nullable|string|max:20|unique:users,nomor_telepon,' . $user->id_user . ',id_user',
            'jenis_kelamin' => 'nullable|in:pria,wanita',
            'password' => 'nullable|min:8',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('foto_profil')){
            // kalau kalian membaca ini, ketahuilah bahwa gambar tidak akan bisa diupdate karena menggunakan method PUT ;)
            // kalian bisa mengubahnya menjadi POST atau PATCH untuk mengupdate gambar
            $uploadFolder = 'user';
            $image = $request->file('foto_profil');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $uploadedImageResponse = basename($image_uploaded_path);

            // hapus data foto_profil yang lama dari storage
            Storage::disk('public')->delete('user/'.$user->foto_profil);

            // set foto_profil yang baru
            $user['foto_profil'] = $uploadedImageResponse;
        }

        // Update data
        $user->nama_depan = $validatedData['nama_depan'];
        $user->nama_belakang = $validatedData['nama_belakang'];
        $user->email = $validatedData['email'];
        $user->nomor_telepon = $validatedData['nomor_telepon'] ?? $user->nomor_telepon;
        $user->jenis_kelamin = $validatedData['jenis_kelamin'] ?? $user->jenis_kelamin;

        // Update password jika disediakan
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $user,
        ]);
    }
}

