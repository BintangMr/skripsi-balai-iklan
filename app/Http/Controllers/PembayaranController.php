<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Pelanggan;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    // 1. Menampilkan Halaman Pembayaran
    public function create($id)
    {
        // Cari data pesanan berdasarkan ID
        $pesanan = Pemesanan::findOrFail($id);
        return view('pembayaran.create', compact('pesanan'));
    }

    // 2. Memproses Data Pembayaran dan File Gambar
    public function store(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Simpan file gambar ke folder 'public/bukti_transfer'
        $pathGambar = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        // Simpan data ke tabel pembayarans
        $pembayaran = new Pembayaran();
        $pembayaran->pemesanan_id = $pesanan->id;
        $pembayaran->tgl_bayar = Carbon::now();
        $pembayaran->bukti_transfer = $pathGambar;
        $pembayaran->status_bayar = 'Menunggu'; 
        $pembayaran->save();

        // UBAH BARIS INI:
        $pesanan->status = 'Menunggu Validasi'; // Admin yang akan mengubahnya jadi Lunas
        $pesanan->save();

        // Arahkan ke Riwayat Pesanan agar pelanggan tahu sedang diproses
        return redirect('/riwayat-pesanan')->with('success', 'Bukti bayar terkirim. Menunggu verifikasi admin.');
    }

    // 3. Menampilkan Halaman Kuitansi
    public function kuitansi($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        
        // Ambil data pelanggan yang berelasi dengan pesanan ini
        $pelanggan = Pelanggan::find($pesanan->pelanggan_id);

        return view('pembayaran.kuitansi', compact('pesanan', 'pelanggan'));
    }
}