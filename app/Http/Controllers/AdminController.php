<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $mahasiswa = User::where('role', 'mahasiswa')->latest()->paginate(10);

        return view('admin.dashboard', compact('totalMahasiswa', 'mahasiswa'));
    }

    public function createMahasiswa()
    {
        return view('admin.create-mahasiswa');
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required', 'string', 'unique:users'],
            'jurusan' => ['required', 'string'],
            'semester' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function editMahasiswa(User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            abort(404);
        }

        return view('admin.edit-mahasiswa', compact('mahasiswa'));
    }

    public function updateMahasiswa(Request $request, User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $mahasiswa->id],
            'nim' => ['required', 'string', 'unique:users,nim,' . $mahasiswa->id],
            'jurusan' => ['required', 'string'],
            'semester' => ['required', 'string'],
        ]);

        $mahasiswa->update($request->only(['name', 'email', 'nim', 'jurusan', 'semester']));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Data mahasiswa berhasil diupdate!');
    }

    public function destroyMahasiswa(User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            abort(404);
        }

        $mahasiswa->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }
}