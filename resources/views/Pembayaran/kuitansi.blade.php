<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi - #INV-202605{{ str_pad($pesanan->id, 2, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 p-8 flex justify-center min-h-screen">
    
    <div class="w-full max-w-3xl">
        <div class="flex justify-between items-center mb-4 no-print">
            <h2 class="font-bold text-lg">Bukti Pembayaran Digital</h2>
            <div class="space-x-2">
                <button onclick="window.print()" class="bg-white border border-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-md hover:bg-gray-50 text-sm">🖨️ Cetak</button>
                <a href="/dashboard-pelanggan" class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-teal-700 text-sm">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="bg-white p-10 rounded-xl shadow-lg border-t-8 border-[#1e3a8a] relative overflow-hidden">
            <div class="absolute bottom-16 right-12 rotate-[-15deg] opacity-70 pointer-events-none">
                <div class="border-4 border-green-500 rounded-lg p-2 text-center">
                    <p class="text-green-500 font-bold text-2xl tracking-widest uppercase">Lunas</p>
                    <p class="text-green-500 text-[10px] font-bold border-t-2 border-green-500 mt-1 pt-1">SISTEM PT. BALAI IKLAN</p>
                </div>
            </div>

            <div class="flex justify-between items-start mb-8 pb-6 border-b-2 border-gray-100">
                <div>
                    <h1 class="text-2xl font-bold text-[#1e3a8a] flex items-center mb-2">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                        PT. BALAI IKLAN
                    </h1>
                    <p class="text-xs text-gray-500">Jl. Aceh No.21, Babakan Ciamis, Sumur Bandung<br>Kota Bandung, Jawa Barat 40117<br>Telp: (022) 1234567</p>
                </div>
                <div class="text-right">
                    <h2 class="text-3xl font-bold text-gray-300 tracking-widest mb-2">KUITANSI</h2>
                    <p class="text-sm font-semibold text-gray-700">No: <span class="text-[#1e3a8a]">K-2026/05/00{{ $pesanan->id }}</span></p>
                    <p class="text-xs text-gray-500 mt-1">Tanggal: {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('d M Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider mb-1">DITERIMA DARI</p>
                    <p class="font-bold text-gray-800">{{ $pelanggan->nama ?? 'Bintang M.' }}</p>
                    <p class="text-xs text-gray-500">{{ $pelanggan->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider mb-1">UNTUK PEMBAYARAN</p>
                    <p class="font-bold text-gray-800 text-sm">Pemasangan Iklan {{ $pesanan->jenis_iklan }}</p>
                    <p class="text-xs text-gray-500">Sesuai pesanan pada tanggal {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('d M Y') }}</p>
                </div>
            </div>

            <table class="w-full text-sm mb-6">
                <thead>
                    <tr class="border-b-2 border-gray-800 text-gray-600">
                        <th class="text-left py-2 text-[10px] uppercase tracking-wider">Rincian Layanan</th>
                        <th class="text-center py-2 text-[10px] uppercase tracking-wider">Durasi</th>
                        <th class="text-right py-2 text-[10px] uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-4">
                            <p class="font-bold text-gray-800">Iklan {{ $pesanan->jenis_iklan }}</p>
                            <p class="text-[10px] text-gray-500">Materi / Kuantitas: {{ Str::limit($pesanan->materi_iklan, 30) }} ({{ $pesanan->qty_atau_ukuran }} unit)</p>
                        </td>
                        <td class="text-center py-4 text-gray-600">Terjadwal</td>
                        <td class="text-right py-4 font-bold text-gray-800">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end mb-8">
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-bold mb-1">TOTAL PEMBAYARAN</p>
                    <p class="text-2xl font-bold text-[#1e3a8a]">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 flex justify-between items-center mt-12">
                <p class="text-[9px] text-gray-400 italic max-w-sm">*Kuitansi ini diterbitkan secara elektronik oleh sistem informasi PT. Balai Iklan Bandung dan sah tanpa tanda tangan basah.</p>
                <p class="text-xs font-bold text-gray-800">Sistem PT. Balai Iklan</p>
            </div>
        </div>
    </div>
</body>
</html>