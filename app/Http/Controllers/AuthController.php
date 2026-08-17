<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegister() {
        return view('auth.register');
    }

    // Memproses data registrasi ke MySQL
    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'email' => 'required|string|email|unique:logins,email',
            'password' => 'required|string|min:6',
        ], [
            // Kustomisasi pesan error agar mudah dipahami pengguna
            'no_telp.numeric' => 'Nomor telepon hanya boleh berisi angka.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        // 1. Simpan ke tabel logins (Kredensial)
        $login = new Login();
        $login->email = $request->email;
        $login->password = Hash::make($request->password); // Enkripsi password demi keamanan
        $login->role = 'Pelanggan';
        $login->save();

        // 2. Simpan ke tabel pelanggans (Profil Data Diri)
        $pelanggan = new Pelanggan();
        $pelanggan->login_id = $login->id; // Menyambungkan foreign key relasi 1-to-1
        $pelanggan->nama = $request->nama;
        $pelanggan->no_telp = $request->no_telp;
        $pelanggan->email = $request->email;
        $pelanggan->save();

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Menampilkan halaman login
    public function showLogin() {
        return view('auth.login');
    }

    // Memproses validasi login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = Login::where('email', $request->email)->first();

        // Cek apakah user ada dan password-nya cocok
        if ($user && Hash::check($request->password, $user->password)) {
            
            // TAMBAHKAN BARIS INI: Perbarui waktu terakhir login di database
            \DB::table('logins')->where('id', $user->id)->update([
                'last_login_at' => \Carbon\Carbon::now()
            ]);

            // Simpan session dasar (kode Anda yang sudah ada)
            session([
                'user_id' => $user->id, 
                'role' => $user->role, 
                'nama' => $user->pelanggan->nama ?? 'Staff Internal'
            ]);
            
            // PENGALIHAN OTOMATIS BERDASARKAN ROLE
            if ($user->role === 'Admin') {
                return redirect('/dashboard-admin');
            } elseif ($user->role === 'Pemilik') {
                return redirect('/laporan-pemilik');
            }
            
            // Jalur default untuk Pelanggan biasa
            return redirect('/dashboard-pelanggan');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    // Memproses keluar sistem
    public function logout() {
        session()->forget(['user_id', 'role', 'nama']);
        return redirect('/login');
    }
}