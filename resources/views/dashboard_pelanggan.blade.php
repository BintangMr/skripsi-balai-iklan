<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

<nav class="bg-[#1e3a8a] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="font-bold tracking-wide">PT. BALAI IKLAN</span>
        </div>
        <div class="flex items-center space-x-6 text-sm">
            <a href="/dashboard-pelanggan" class="hover:text-teal-300">Beranda</a>
            <a href="/riwayat-pesanan" class="hover:text-teal-300">Riwayat Pesanan</a>
            <a href="/tagihan" class="hover:text-teal-300">Tagihan</a>
            <div class="flex items-center space-x-4 border-l border-blue-700 pl-6">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center font-bold text-white">
                        {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
                    </div>
                    <span>{{ session('nama', 'Pengguna') }}</span>
                </div>
                <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-semibold transition ml-2">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-teal-500 to-[#1e3a8a] text-white p-8 rounded-2xl shadow-sm mb-8 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Halo, Selamat Datang {{ session('nama') }}!</h1>
                <p class="text-teal-100 text-sm mt-2">Kembangkan jangkauan bisnis Anda dengan memasang iklan cetak atau digital secara cepat bersama kami.</p>
            </div>
            <a href="/pesan-iklan" class="mt-4 md:mt-0 bg-white text-[#1e3a8a] font-bold px-6 py-3 rounded-lg hover:bg-teal-50 transition shadow-md flex items-center space-x-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Buat Pesanan Iklan</span>
            </a>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Berita & Info Terkini Informasi Periklanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border p-5">
                    <span class="bg-teal-100 text-teal-800 text-[10px] font-bold px-2 py-1 rounded">INFO</span>
                    <h3 class="font-bold text-md mt-2 text-gray-800">Tarif Baru Periklanan Kolom dan Baris 2026</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">PT. Balai Iklan Bandung memperbarui penyesuaian tarif untuk optimalisasi cetak media massa per Juli tahun ini...</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border p-5">
                    <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-1 rounded">TIPS</span>
                    <h3 class="font-bold text-md mt-2 text-gray-800">Cara Membuat Desain Iklan Display yang Menarik</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Simak panduan kombinasi warna kontras tinggi dan ukuran kolom frame agar iklan bisnis Anda dilirik ribuan pembaca...</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border p-5">
                    <span class="bg-purple-100 text-purple-800 text-[10px] font-bold px-2 py-1 rounded">FITUR</span>
                    <h3 class="font-bold text-md mt-2 text-gray-800">Sistem Validasi Kuitansi Otomatis Diluncurkan</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Kini pelanggan dapat mengunduh berkas bukti kuitansi digital secara langsung sesaat setelah pembayaran dikonfirmasi valid...</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>