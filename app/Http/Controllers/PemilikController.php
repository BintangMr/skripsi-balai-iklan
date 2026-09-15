<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pemesanan;

class PemilikController extends Controller
{
    // Halaman Utama Laporan Pemilik
    public function index(Request $request)
    {
        if (session('role') !== 'Pemilik') return redirect('/login');

        // Tarik data laporan dengan join tabel pelanggan dan pembayaran (Hanya yang lunas)
        $query = Pemesanan::select('pemesanans.*', 'pelanggans.nama as nama_pelanggan', 'pembayarans.tgl_bayar', 'pembayarans.created_at as waktu_bayar')
            ->join('pelanggans', 'pemesanans.pelanggan_id', '=', 'pelanggans.login_id')
            ->leftJoin('pembayarans', 'pemesanans.id', '=', 'pembayarans.pemesanan_id')
            ->where('pemesanans.status', 'Lunas');

        // Filter Nama
        if ($request->cari_nama) {
            $query->where('pelanggans.nama', 'like', '%' . $request->cari_nama . '%');
        }

        // Filter Periode Tanggal
        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('pemesanans.tgl_pesan', [$request->tgl_awal, $request->tgl_akhir]);
        } else if (!$request->cari_nama) {
            $query->whereYear('pemesanans.tgl_pesan', date('Y'));
        }

        $laporans = $query->orderBy('pemesanans.updated_at', 'desc')->get();

        return view('pemilik.laporan', compact('laporans'));
    }

    // Halaman Khusus Cetak Print PDF
    public function cetak(Request $request)
    {
        // Jalur aman untuk peran Admin dan Pemilik
        if (!in_array(session('role'), ['Pemilik', 'Admin'])) return redirect('/login');

        $query = Pemesanan::select('pemesanans.*', 'pelanggans.nama as nama_pelanggan', 'pembayarans.tgl_bayar', 'pembayarans.created_at as waktu_bayar')
            ->join('pelanggans', 'pemesanans.pelanggan_id', '=', 'pelanggans.login_id')
            ->leftJoin('pembayarans', 'pemesanans.id', '=', 'pembayarans.pemesanan_id')
            ->where('pemesanans.status', 'Lunas'); // Filter hanya yang lunas

        // Tangkap filter jika ada
        if ($request->filled('jenis_iklan')) {
            $query->where('pemesanans.jenis_iklan', $request->jenis_iklan);
        }
        if ($request->cari_nama) {
            $query->where('pelanggans.nama', 'like', '%' . $request->cari_nama . '%');
        }
        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('pemesanans.tgl_pesan', [$request->tgl_awal, $request->tgl_akhir]);
        }

        // Ambil data dalam bentuk Kumpulan (Collection)
        $laporans = $query->orderBy('pemesanans.updated_at', 'desc')->get();

        // Oper ke view cetak
        return view('pemilik.cetak', compact('laporans'));
    }
}