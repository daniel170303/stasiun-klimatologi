<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Pengunjung;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_instansi' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'string', 'max:255'],
            'nama_penanggung_jawab' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'jenjang.required' => 'Jenjang wajib dipilih.',
            'nama_penanggung_jawab.required' => 'Nama penanggung jawab wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Create User
        $user = User::create([
            'name' => $request->nama_instansi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::PENGUNJUNG,
        ]);

        // Create Pengunjung Profile
        Pengunjung::create([
            'user_id' => $user->id,
            'nama_instansi' => $request->nama_instansi,
            'jenjang' => $request->jenjang,
            'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('pengunjung.dashboard');
    }
}