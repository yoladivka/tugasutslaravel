<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswa = auth()->user();
        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    public function profile()
    {
        $mahasiswa = auth()->user();
        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            // NIM dihapus dari validation karena readonly
            'jurusan' => ['required', 'string'],
            'semester' => ['required', 'string'],
        ]);

        // Update tanpa NIM
        $user->update($request->only(['name', 'email', 'jurusan', 'semester']));

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Profile berhasil diupdate!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Password berhasil diubah!');
    }
}