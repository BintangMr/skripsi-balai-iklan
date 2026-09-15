<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Portal Laporan Pemilik - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 h-screen flex flex-col">

    <nav class="bg-[#1a2235] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <span class="font-bold tracking-widest">PORTAL PEMILIK PERUSAHAAN</span>
        <div class="flex items-center space-x-4 text-sm">
            <span>Selamat Datang, Bapak/Ibu Pemilik</span>
            <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-semibold transition text-xs">Keluar</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 mt-10 pb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pusat Pembuatan Laporan Keuangan</h2>
                <p class="text-sm text-gray-500 mt-1">Pilih periode dan nama pelanggan untuk memfilter data arsip transaksi lunas.</p>
            </div>
            
            <form action="/laporan-pemilik" method="GET" class="flex space-x-2 bg-white p-2 rounded-lg border shadow-sm">
                <input type="text" name="cari_nama" placeholder="Cari Nama/Instansi..." value="{{ request('cari_nama') }}" class="border rounded px-3 py-1.5 text-xs w-48 bg-gray-50">
                <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" class="border rounded px-3 py-1.5 text-xs bg-gray-50">
                <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" class="border rounded px-3 py-1.5 text-xs bg-gray-50">
                <button type="submit" class="bg-[#1a2235] text-white px-4 py-1.5 rounded text-xs font-bold hover:bg-slate-700">Filter</button>
                <a href="/laporan-pemilik" class="bg-gray-200 text-gray-700 px-4 py-1.5 rounded text-xs font-bold hover:bg-gray-300">Reset</a>
            </form>
        </div>

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px]">
                    <thead class="bg-slate-800 text-slate-200 uppercase font-semibold">
                        <tr>
                            <th class="py-3 px-4">No. Invoice & Nama</th>
                            <th class="py-3 px-4">Subtotal (Tanpa PPN)</th>
                            <th class="py-3 px-4">Pajak (PPN 11%)</th>
                            <th class="py-3 px-4 font-bold text-teal-300">Total Asli</th>
                            <th class="py-3 px-4">Tgl Order</th>
                            <th class="py-3 px-4">Tgl Terbit</th>
                            <th class="py-3 px-4">Tgl & Jam Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($laporans as $lap)
                            @php
                                $subtotal = $lap->total_biaya / 1.11;
                                $ppn = $lap->total_biaya - $subtotal;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <p class="font-bold text-blue-700">#INV-202605{{ str_pad($lap->id, 2, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-gray-600 font-semibold">{{ $lap->nama_pelanggan }}</p>
                                </td>
                                <td class="py-3 px-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-red-600">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 font-bold text-teal-700 text-xs">Rp {{ number_format($lap->total_biaya, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($lap->tgl_pesan)->format('d M Y') }}</td>
                                <td class="py-3 px-4 text-gray-500">{{ $lap->tgl_tayang? \Carbon\Carbon::parse($lap->tgl_tayang)->translatedFormat('d M Y') : '-'}}</td>
                                <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($lap->tgl_bayar)->format('d M Y') }} <br>
                                <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($lap->waktu_bayar)->format('H:i:s') }} WIB</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-8 text-center text-red-500 font-bold">Data kosong! Tidak ada arsip laporan pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t flex justify-end bg-gray-50">
                @if($laporans->isEmpty())
                    <button type="button" onclick="alert('Arsip laporan kosong! Silakan pilih periode lain sebelum melakukan ekspor.')" class="bg-gray-400 text-white px-6 py-2 rounded text-xs font-bold cursor-not-allowed">Ekspor PDF Terkunci</button>
                @else
                    <a href="/laporan-pemilik/cetak?tgl_awal={{ request('tgl_awal') }}&tgl_akhir={{ request('tgl_akhir') }}&cari_nama={{ request('cari_nama') }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded text-xs font-bold shadow-md">Unduh Dokumen Laporan PDF</a>
                @endif
            </div>
        </div>
    </div>

</body>
</html>