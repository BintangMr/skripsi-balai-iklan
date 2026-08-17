<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased min-h-screen">

    <nav class="bg-[#1e3a8a] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2 font-bold tracking-wide">PT. BALAI IKLAN</div>
        <div class="flex items-center space-x-6 text-sm">
            <a href="/dashboard-pelanggan" class="hover:text-teal-300">Beranda</a>
            <a href="/riwayat-pesanan" class="text-teal-300 font-bold">Riwayat Pesanan</a>
            <a href="/tagihan" class="hover:text-teal-300">Tagihan</a>
            <div class="flex items-center space-x-2 border-l border-blue-700 pl-6">
                <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center font-bold text-white">
                    {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
                </div>
                <span>{{ session('nama', 'Pengguna') }}</span>
            </div>
            <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-semibold transition ml-2">Keluar</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 mt-10 pb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Riwayat Pemesanan Iklan</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar seluruh arsip berkas pengajuan dan transaksi iklan Anda di sistem.</p>
            </div>
            <a href="/pesan-iklan" class="bg-[#1e3a8a] hover:bg-blue-900 text-white font-semibold px-4 py-2 rounded-md text-sm transition shadow-sm">
                + Pasang Iklan Baru
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @if($pesanans->isEmpty())
                <div class="p-10 text-center text-gray-500 font-medium">
                    Anda belum pernah melakukan pemesanan iklan sama sekali.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-100 text-gray-600 font-semibold border-b border-gray-200 uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-4 px-6">No. Invoice</th>
                                <th class="py-4 px-6">Tanggal Pesan</th>
                                <th class="py-4 px-6">Jenis Layanan</th>
                                <th class="py-4 px-6">Kuantitas / Dimensi</th>
                                <th class="py-4 px-6">Total Biaya</th>
                                <th class="py-4 px-6 text-center">Status Sistem</th>
                                <th class="py-4 px-6 text-center">Aksi Dokumen</th>
                                <th class="py-4 px-6 text-center">Bukti Terbit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pesanans as $pesanan)
                                @php
                                    // Pengecekan status kadaluarsa otomatis untuk baris tabel
                                    $batasWaktu = \Carbon\Carbon::parse($pesanan->created_at)->addHours(24);
                                    $isExpired = now()->greaterThan($batasWaktu) && $pesanan->status === 'Menunggu Pembayaran';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-800">
                                        #INV-202605{{ str_pad($pesanan->id, 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">
                                        {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            Iklan {{ $pesanan->jenis_iklan }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">
                                        {{ $pesanan->qty_atau_ukuran }} {{ $pesanan->jenis_iklan === 'Baris' ? 'Baris' : 'mmK' }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900">
                                        Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($pesanan->status === 'Lunas')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                                                ✓ Lunas
                                            </span>
                                        @elseif($pesanan->status === 'Menunggu Validasi')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                                                ⏳ Sedang Diverifikasi
                                            </span>
                                        @elseif($pesanan->status === 'Bukti Tidak Valid')
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                                                ⚠ Bukti Ditolak
                                            </span>
                                        @elseif($isExpired)
                                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full border border-gray-300">
                                                ✕ Kadaluarsa
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">
                                                ⏳ Menunggu Pembayaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        @if($pesanan->status === 'Lunas')
                                            <a href="/kuitansi/{{ $pesanan->id }}" class="text-teal-600 hover:text-teal-800 font-bold text-xs underline">
                                                Lihat Kuitansi
                                            </a>
                                        @elseif($pesanan->status === 'Menunggu Validasi')
                                            <span class="text-gray-400 text-xs italic font-semibold">Menunggu Admin</span>
                                        @elseif($pesanan->status === 'Bukti Tidak Valid')
                                            <a href="/pembayaran/{{ $pesanan->id }}" class="bg-red-500 hover:bg-red-600 text-white font-bold px-3 py-1 rounded text-xs transition">
                                                Upload Ulang
                                            </a>
                                        @elseif($isExpired)
                                            <span class="text-gray-400 text-xs cursor-not-allowed italic">Tidak Ada Aksi</span>
                                        @else
                                            <a href="/pembayaran/{{ $pesanan->id }}" class="bg-teal-500 hover:bg-teal-600 text-white font-bold px-3 py-1 rounded text-xs transition">
                                                Bayar
                                            </a>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                    <!-- Tambahkan ini di dalam kolom Aksi Dokumen -->
                                        @if($pesanan->status === 'Lunas' && $pesanan->bukti_terbit)
                                            <div class="mt-2">
                                                <a href="{{ asset('bukti_terbit/'.$pesanan->bukti_terbit) }}" target="_blank" class="bg-indigo-600 text-white px-3 py-1 rounded font-bold text-[10px] hover:bg-indigo-700 transition">
                                                    Lihat Bukti Terbit
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</body>
</html>