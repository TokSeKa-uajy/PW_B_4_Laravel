<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

            // Update path foto profil ke database
            $user->foto_profil = $path; // Simpan path relatif
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
}

