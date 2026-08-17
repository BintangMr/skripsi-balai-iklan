<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'Admin') return redirect('/login');

        // 1. Data Antrean Verifikasi
        $antreans = Pemesanan::select('pemesanans.*', 'pelanggans.nama as nama_pelanggan')
            ->join('pelanggans', 'pemesanans.pelanggan_id', '=', 'pelanggans.login_id')
            ->where('pemesanans.status', 'Menunggu Validasi')
            ->orderBy('pemesanans.created_at', 'asc')
            ->get();

        // 2. Data Pusat Laporan
        $queryLaporan = Pemesanan::select('pemesanans.*', 'pelanggans.nama as nama_pelanggan', 'pembayarans.tgl_bayar', 'pembayarans.created_at as waktu_bayar')
            ->join('pelanggans', 'pemesanans.pelanggan_id', '=', 'pelanggans.login_id')
            ->leftJoin('pembayarans', 'pemesanans.id', '=', 'pembayarans.pemesanan_id')
            ->where('pemesanans.status', 'Lunas')
            ->where('pembayarans.status_bayar', 'Valid');

        // Filter Nama/Instansi
        if ($request->cari_nama) {
            $queryLaporan->where('pelanggans.nama', 'like', '%' . $request->cari_nama . '%');
        }

        // Filter Tanggal
        if ($request->tgl_awal && $request->tgl_akhir) {
            $queryLaporan->whereBetween('pemesanans.tgl_pesan', [$request->tgl_awal, $request->tgl_akhir]);
        } else if (!$request->cari_nama) {
            $queryLaporan->whereYear('pemesanans.tgl_pesan', date('Y'));
        }

        $laporans = $queryLaporan->orderBy('pemesanans.updated_at', 'desc')->get();

        // 3. KODE PERHITUNGAN KARTU STATISTIK (DIKEMBALIKAN UTUH)
        $pesanan_baru = Pemesanan::count(); // Total seluruh pesanan di sistem
        $menunggu_validasi = Pemesanan::where('status', 'Menunggu Validasi')->count();
        $iklan_aktif = Pemesanan::where('status', 'Lunas')->count();
        $total_pendapatan = Pemesanan::where('status', 'Lunas')->sum('total_biaya'); // Total omzet lunas

        return view('admin.dashboard', compact('antreans', 'laporans', 'pesanan_baru', 'menunggu_validasi', 'iklan_aktif', 'total_pendapatan'));
    }

    // Menampilkan Halaman Detail & Bukti Bayar
    public function detail($id)
    {
        // Proteksi hak akses session role admin
        if (session('role') !== 'Admin') return redirect('/login');
        
        // Ambil data pesanan tunggal beserta relasi nama dan nomor telepon pelanggan
        $pesanan = Pemesanan::select('pemesanans.*', 'pelanggans.nama as nama_pelanggan', 'pelanggans.no_telp')
            ->join('pelanggans', 'pemesanans.pelanggan_id', '=', 'pelanggans.login_id')
            ->where('pemesanans.id', $id)
            ->firstOrFail(); // Menghasilkan objek tunggal (bukan collection)

        // Ambil data catatan pembayaran terbaru terkait pesanan ini
        $pembayaran = Pembayaran::where('pemesanan_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('admin.detail', compact('pesanan', 'pembayaran'));
    }

    // Memproses Tombol "Lunas" atau "Tidak Valid"
    public function verifikasi(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pembayaran = Pembayaran::where('pemesanan_id', $id)->orderBy('created_at', 'desc')->first();

        if ($request->aksi === 'Lunas') {
            $pesanan->status = 'Lunas';
            if($pembayaran) {
                $pembayaran->status_bayar = 'Valid';
                $pembayaran->save();
            }
        } elseif ($request->aksi === 'Tolak') {
            $pesanan->status = 'Bukti Tidak Valid'; // Akan memunculkan tagihan kembali ke pelanggan
            if($pembayaran) {
                $pembayaran->status_bayar = 'Ditolak';
                $pembayaran->save();
            }
        }
        $pesanan->save();

        return redirect('/dashboard-admin')->with('success', 'Pesanan #INV-' . $id . ' berhasil diverifikasi.');
    }

    public function uploadBuktiTerbit(Request $request, $id)
    {
        $request->validate(['file_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048']);

        $pesanan = Pemesanan::findOrFail($id);
        
        // folder public/bukti_terbit sudah dibuat secara manual
        $fileName = 'BUKTI-' . $id . '-' . time() . '.' . $request->file('file_bukti')->extension();
        $request->file('file_bukti')->move(public_path('bukti_terbit'), $fileName);

        $pesanan->bukti_terbit = $fileName; // Langsung simpan nama filenya
        $pesanan->save();

        return back()->with('success', 'Bukti terbit berhasil diunggah!');
    }
    public function pelanggan()
{
    if (session('role') !== 'Admin') return redirect('/login');

    // Ambil data pelanggan beserta email dan waktu terakhir login
    $pelanggan_sistem = \App\Models\Pelanggan::select('pelanggans.*', 'logins.email', 'logins.last_login_at', 'logins.created_at as tgl_daftar')
        ->join('logins', 'pelanggans.login_id', '=', 'logins.id')
        ->where('logins.role', 'Pelanggan')
        ->orderBy('pelanggans.nama', 'asc')
        ->get();

    return view('admin.pelanggan', compact('pelanggan_sistem'));
}

    // Tampilan Utama Data Admin
    public function indexKaryawan()
    {
        // Proteksi URL: Tendang kembali ke dashboard jika bukan Admin Utama
        if (session('role') !== 'Admin') {
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki otorisasi untuk mengelola data karyawan.');
        }

        // ... lanjutan kode untuk mengambil data dan me-return view ...
        $karyawans = Login::whereIn('role', ['Admin', 'Karyawan'])->get();
        return view('admin.data_karyawan', compact('karyawans'));
    }
    
    public function adminIndex()
    {
        if (session('role') !== 'Admin') return redirect('/login');
        $admins = \DB::table('logins')->where('role', 'Admin')->orderBy('email', 'asc')->get();
        return view('admin.admin_manage.index', compact('admins'));
    }

    // Form Tambah Admin Baru
    public function adminCreate()
    {
        if (session('role') !== 'Admin') return redirect('/login');
        return view('admin.admin_manage.create');
    }

    // Proses Simpan Admin Baru
    public function adminStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:logins,email',
            'password' => 'required|min:8'
        ]);

        \DB::table('logins')->insert([
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => 'Admin',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return redirect('/admin/data-admin')->with('success', 'Akun Admin baru berhasil didaftarkan.');
    }

    // Form Edit Password/Email Admin
    public function adminEdit($id)
    {
        if (session('role') !== 'Admin') return redirect('/login');
        $admin_data = \DB::table('logins')->where('id', $id)->firstOrFail();
        return view('admin.admin_manage.edit', compact('admin_data'));
    }

    // Proses Update Data Admin
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:logins,email,' . $id
        ]);

        $updateData = ['email' => $request->email, 'updated_at' => \Carbon\Carbon::now()];

        // Jika password diisi, enkripsi dan update
        if ($request->password) {
            $updateData['password'] = \Hash::make($request->password);
        }

        \DB::table('logins')->where('id', $id)->update($updateData);

        return redirect('/admin/data-admin')->with('success', 'Data Admin berhasil diperbarui.');
    }

    // Proses Hapus Akun Admin secara Permanen
    public function adminDelete($id)
    {
        if (session('role') !== 'Admin') return redirect('/login');
        
        // Proteksi: Mencegah admin menghapus akun dirinya sendiri yang sedang login
        if ($id == session('user_id')) {
            return redirect('/admin/data-admin')->with('error', 'Anda tidak diperbolehkan menghapus akun Anda sendiri.');
        }

        \DB::table('logins')->where('id', $id)->delete();
        return redirect('/admin/data-admin')->with('success', 'Akun Admin berhasil dihapus.');
    }

    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:logins,email', // Sesuaikan nama tabel Anda
            'password' => 'required|min:8',
        ]);

        // Simpan data kredensial baru
        $akunBaru = new Login(); // Sesuaikan dengan nama Model Anda
        $akunBaru->email = $request->email;
        $akunBaru->password = bcrypt($request->password);
        
        // KUNCI OTOMATIS: Hardcode role menjadi 'Karyawan'
        $akunBaru->role = 'Karyawan'; 
        
        $akunBaru->save();

        return redirect('/data-admin')->with('success', 'Akun Karyawan berhasil ditambahkan.');
    }

}