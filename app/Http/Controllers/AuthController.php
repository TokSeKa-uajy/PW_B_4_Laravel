<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nomor_telepon' => 'required|unique:users,nomor_telepon',
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|string',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Cek apakah user ada dan password sesuai
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('authToken', [$user->role])->plainTextToken;

        // Berikan respons berhasil login
        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id_user,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

    public function roleCheck(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            return response()->json(['message' => 'You are an admin'], 200);
        }

        return response()->json(['message' => 'You are a regular user'], 200);
    }
}
