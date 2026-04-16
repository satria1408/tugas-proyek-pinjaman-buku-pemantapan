<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar anggota (HANYA SISWA)
     */
    public function index()
    {
        $users = User::where('role', 'siswa')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tambah anggota
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan anggota baru (DEFAULT SISWA)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'alamat' => 'nullable',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'role' => 'siswa', // 🔥 selalu siswa
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Form edit anggota
     */
    public function edit(string $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update anggota (TIDAK BISA UBAH ROLE)
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'alamat' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data anggota diperbarui');
    }

    /**
     * Hapus anggota
     */
    public function destroy(string $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}