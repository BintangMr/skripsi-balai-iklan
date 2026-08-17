<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan; // Memanggil model Pemesanan
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function create()
    {
        return view('pemesanan.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Berdasarkan Jenis Iklan yang Dipilih
        $rules = [
            'jenis_iklan' => 'required|in:Baris,Display',
            'tgl_tayang' => 'required|date',
        ];

        $messages = [
            'tgl_tayang.required' => 'Tanggal mulai terbit wajib dipilih.',
            'tgl_tayang.date' => 'Format tanggal tidak valid.',
        ];

        if ($request->jenis_iklan === 'Baris') {
            $rules['materi_teks'] = 'required|string|min:52|max:182';
            $messages['materi_teks.required'] = 'Materi naskah iklan baris wajib diisi.';
            $messages['materi_teks.min'] = 'Naskah terlalu singkat. Harap masukkan minimal 52 karakter untuk memenuhi syarat.';
            $messages['materi_teks.max'] = 'Naskah terlalu panjang. Maksimal hanya diperbolehkan 182 karakter (7 baris).';
        } else {
            $rules['file_desain'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            $messages['file_desain.required'] = 'File desain gambar wajib diunggah.';
            $messages['file_desain.image'] = 'File yang diunggah harus berupa gambar.';
            $messages['file_desain.mimes'] = 'Format gambar harus ber-ekstensi jpeg, png, atau jpg.';
        }

        $request->validate($rules, $messages);

        // 2. Logika Perhitungan Tarif Otomatis (Sesuai Aturan Bisnis)
        $subtotal = 0;
        $qty_atau_ukuran = 0;
        $materi_iklan = '';

        if ($request->jenis_iklan === 'Baris') {
            
            $materi_iklan = $request->input('materi_teks');
            
            // Hitung panjang karakter (termasuk spasi)
            $panjang_karakter = strlen($materi_iklan);
            
            // 1 baris = 26 karakter (Dibulatkan ke atas)
            $jumlah_baris = ceil($panjang_karakter / 26);
            
            // Aturan Minimal 2 baris
            if ($jumlah_baris < 2) {
                $jumlah_baris = 2;
            }

            // Aturan Maksimal 7 baris (Validasi keamanan ganda)
            if ($jumlah_baris > 7) {
                return back()->withErrors(['materi_teks' => 'Maksimal iklan baris adalah 7 baris (182 karakter).']);
            }
            
            $qty_atau_ukuran = $jumlah_baris;
            $subtotal = $jumlah_baris * 22500; // Harga per baris Rp 22.500
            
        } else {
            // Iklan Display
            if ($request->hasFile('file_desain')) {
                $pathDesain = $request->file('file_desain')->store('desain_iklan', 'public');
                $materi_iklan = $pathDesain;
            } else {
                $materi_iklan = 'Tidak ada file desain';
            }
            
            $lebar = $request->input('lebar_kolom');
            $tinggi = $request->input('tinggi_mm');
            
            // Proteksi Minimal Lebar 2, Tinggi 50
            if ($lebar < 2) $lebar = 2;
            if ($tinggi < 50) $tinggi = 50;

            $mmk = $lebar * $tinggi;
            $qty_atau_ukuran = $mmk;
            $subtotal = $mmk * 55000; // Harga per mmk Rp 55.000
        }

        // Hitung PPN 11% dan Total Akhir
        $ppn = $subtotal * 0.11;
        $total_biaya = $subtotal + $ppn;

        // 3. Simpan ke Database
        $pesanan = new Pemesanan();
        $pesanan->pelanggan_id = session('user_id'); 
        $pesanan->tgl_pesan = Carbon::now();
        $pesanan->jenis_iklan = $request->jenis_iklan;
        $pesanan->materi_iklan = $materi_iklan;
        $pesanan->qty_atau_ukuran = $qty_atau_ukuran;
        $pesanan->total_biaya = $total_biaya;
        $pesanan->status = 'Menunggu Pembayaran'; 
        $pesanan->save();

        return redirect('/pembayaran/' . $pesanan->id);
    }

    public function tagihan()
    {
        $tagihans = Pemesanan::where('pelanggan_id', session('user_id'))
            ->whereIn('status', ['Menunggu Pembayaran', 'Bukti Tidak Valid']) // TAMBAHKAN INI
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pemesanan.tagihan', compact('tagihans'));
    }
    public function riwayat()
    {
        // Ambil semua riwayat pesanan milik pelanggan yang sedang login, diurutkan dari yang terbaru
        $pesanans = Pemesanan::where('pelanggan_id', session('user_id'))
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pemesanan.riwayat', compact('pesanans'));
    }
}