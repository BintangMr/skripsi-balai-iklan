<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tagihan - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased min-h-screen">

    <nav class="bg-[#1e3a8a] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2 font-bold tracking-wide">PT. BALAI IKLAN</div>
        <div class="flex items-center space-x-6 text-sm">
            <a href="/dashboard-pelanggan" class="hover:text-teal-300">Beranda</a>
            <a href="/riwayat-pesanan" class="hover:text-teal-300">Riwayat Pesanan</a>
            <a href="/tagihan" class="text-teal-300 font-bold">Tagihan</a>
            <div class="flex items-center space-x-2 border-l border-blue-700 pl-6">
                <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center font-bold text-white">{{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}</div>
                <span>{{ session('nama', 'Pengguna') }}</span>
            </div>
            <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-semibold transition ml-2">Keluar</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Tagihan Belum Dibayar</h2>
        <p class="text-sm text-gray-500 mb-8">Segera selesaikan pembayaran Anda sebelum batas waktu berakhir agar iklan dapat ditayangkan.</p>

        @if($tagihans->isEmpty())
            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 text-center">
                <p class="text-gray-500 font-medium">Hore! Anda tidak memiliki tagihan yang tertunggak saat ini.</p>
                <a href="/pesan-iklan" class="inline-block mt-4 bg-teal-500 text-white px-6 py-2 rounded-md font-bold hover:bg-teal-600">Buat Pesanan Baru</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($tagihans as $tagihan)
                    @php
                        // Cek apakah sudah kadaluarsa (lewat dari 24 jam)
                        $batasWaktu = \Carbon\Carbon::parse($tagihan->created_at)->addHours(24);
                        $isExpired = now()->greaterThan($batasWaktu);
                    @endphp

                    <div class="bg-white p-6 rounded-xl shadow-sm border {{ $isExpired ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-1 rounded">Iklan {{ $tagihan->jenis_iklan }}</span>
                                <h3 class="font-bold text-lg mt-2">#INV-202605{{ str_pad($tagihan->id, 2, '0', STR_PAD_LEFT) }}</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-semibold mb-1">Total Tagihan</p>
                                <p class="text-xl font-bold text-[#1e3a8a]">Rp {{ number_format($tagihan->total_biaya, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 mb-6 line-clamp-2">
                            Materi: {{ $tagihan->materi_iklan }}
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div>
                                @if($isExpired)
                                    <p class="text-xs font-bold text-red-600">Telat Bayar (Kadaluarsa)</p>
                                @else
                                    <p class="text-xs text-gray-500 font-semibold">Batas: {{ $batasWaktu->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                            
                            @if($tagihan->status === 'Bukti Tidak Valid')
                                <p class="text-[10px] text-red-600 font-bold mb-2">BUKTI DITOLAK (Buram/Tidak Valid). Harap upload ulang!</p>
                                <a href="/pembayaran/{{ $tagihan->id }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-bold transition text-sm">Kirim Ulang Bukti</a>
                            @else
                                <a href="/pembayaran/{{ $tagihan->id }}" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md font-bold transition text-sm">Bayar Sekarang</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>