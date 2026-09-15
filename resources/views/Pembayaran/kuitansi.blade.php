<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran - PT. Balai Iklan</title>
    <link rel="icon" href="{{ asset('balai_iklan.jpeg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white; padding: 0; }
            .no-print { display: none; }
            .print-border { border: 1px solid #e2e8f0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 flex justify-center text-slate-800 font-sans min-h-screen items-center">
    
    <!-- Tombol Print (Sembunyi saat dicetak) -->
    <div class="fixed top-6 right-8 no-print">
        <button onclick="window.print()" class="bg-[#1e3a8a] text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-blue-800 transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Kuitansi</span>
        </button>
    </div>

    <!-- Area Kuitansi -->
    <div class="bg-white w-full max-w-4xl rounded-xl shadow-xl border-t-8 border-[#1e3a8a] p-10 print-border relative overflow-hidden">
        
        <!-- Header Kuitansi -->
        <div class="flex justify-between items-start border-b-2 border-slate-100 pb-6 mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-6 h-6 bg-[#1e3a8a] rounded-sm"></div>
                <div>
                    <h1 class="text-2xl font-black text-[#1e3a8a] tracking-wider">PT. BALAI IKLAN</h1>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Jl. Aceh No.21, Babakan Ciamis, Sumur Bandung<br>
                        Kota Bandung, Jawa Barat 40117<br>
                        Telp: (022) 1234567
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-bold text-slate-200 tracking-widest uppercase">Kuitansi</h2>
                <p class="text-sm font-semibold text-slate-800 mt-2">No: K-2026/05/{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-xs text-slate-500">Tanggal: {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Info Pelanggan & Layanan -->
        <div class="flex justify-between mb-8">
            <div class="w-1/2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Pelanggan</p>
                <p class="text-lg font-bold text-slate-800">{{ $pelanggan->nama ?? 'Nama Pelanggan' }}</p>
                <p class="text-xs text-slate-500">{{ $pelanggan->no_telp ?? '-' }}</p>
            </div>
            <div class="w-1/2 text-right">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Untuk Pembayaran</p>
                <p class="text-base font-bold text-slate-800">Pemasangan Iklan {{ $pesanan->jenis_iklan }}</p>
                <p class="text-xs text-slate-500">Sesuai pesanan pada tanggal {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Kalkulasi PPN di belakang layar -->
        @php
            $subtotal = $pesanan->total_biaya / 1.11;
            $ppn = $pesanan->total_biaya - $subtotal;
        @endphp

        <!-- Tabel Rincian -->
        <table class="w-full text-left text-sm mb-8 border-collapse">
            <thead>
                <tr class="border-y-2 border-slate-800 text-slate-500 font-bold text-[10px] uppercase tracking-widest">
                    <th class="py-3 px-2">Rincian Layanan</th>
                    <th class="py-3 px-2 text-center">Tgl Muat</th>
                    <th class="py-3 px-2 text-center">Ukuran</th>
                    <th class="py-3 px-2 text-right">Harga (Rp)</th>
                    <th class="py-3 px-2 text-right">PPN 11%</th>
                    <th class="py-3 px-2 text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="border-b border-slate-200">
                <tr>
                    <td class="py-5 px-2">
                        <p class="font-bold text-slate-800 text-base">Iklan {{ $pesanan->jenis_iklan }}</p>
                        @if($pesanan->jenis_iklan === 'Display')
                            <p class="text-[10px] text-slate-400 mt-1 truncate max-w-[200px]">Desain: {{ $pesanan->materi_iklan }}</p>
                        @else
                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 italic">"{{ $pesanan->materi_iklan }}"</p>
                        @endif
                    </td>
                    <td class="py-5 px-2 text-center text-slate-700 font-medium">
                        {{ $pesanan->tgl_tayang ? \Carbon\Carbon::parse($pesanan->tgl_tayang)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="py-5 px-2 text-center text-slate-700 font-medium">
                        @if($pesanan->jenis_iklan === 'Display')
                            {{ $pesanan->lebar_kolom ?? '-' }} Kolom x {{ $pesanan->tinggi_mm ?? '-' }} mm
                        @else
                            {{ $pesanan->qty_atau_ukuran }} Baris
                        @endif
                    </td>
                    <td class="py-5 px-2 text-right text-slate-700 font-medium">
                        {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                    <td class="py-5 px-2 text-right text-slate-700 font-medium">
                        {{ number_format($ppn, 0, ',', '.') }}
                    </td>
                    <td class="py-5 px-2 text-right font-black text-slate-900 text-base">
                        {{ number_format($pesanan->total_biaya, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Total Pembayaran & Stempel -->
        <div class="flex justify-between items-end mt-4">
            <div class="w-1/2">
                <!-- INFORMASI PEMBAYARAN TRANSFER KE REKENING -->
                <div class="border border-slate-400 p-3 rounded-md bg-slate-50 text-[11px] mb-3">
                    <p class="font-bold text-slate-700 mb-1">Pembayaran Transfer ke Rekening :</p>
                    @if(isset($pembayaran) && $pembayaran->bank_tujuan)
                        @if($pembayaran->bank_tujuan === 'BCA')
                            <p class="font-semibold text-slate-800">• BCA <span class="ml-2 font-mono">123 456 7890</span> a.n. PT. Balai Iklan</p>
                        @else
                            <p class="font-semibold text-slate-800">• MANDIRI <span class="ml-2 font-mono">098 765 4321 123</span> a.n. PT. Balai Iklan</p>
                        @endif
                    @else
                        <p class="italic text-slate-500">• Belum dikonfirmasi / Tunai</p>
                    @endif
                </div>

                <p class="text-[9px] text-slate-400 italic max-w-xs">
                    *Kuitansi ini diterbitkan secara elektronik oleh sistem informasi PT. Balai Iklan Bandung dan sah tanpa tanda tangan basah.
                </p>
            </div>
            <div class="w-1/2 text-right relative">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Pembayaran</p>
                <p class="text-4xl font-black text-[#1e3a8a]">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
                <!-- Stempel Lunas (Hanya muncul jika status benar-benar Lunas) -->
                @if($pesanan->status === 'Lunas')
                <div class="absolute -top-6 right-24 transform -rotate-12 opacity-80 border-4 border-green-500 text-green-500 rounded p-2 text-center inline-block">
                    <p class="text-3xl font-black tracking-widest leading-none">LUNAS</p>
                    <p class="text-[8px] font-bold tracking-widest border-t-2 border-green-500 mt-1 pt-1">SISTEM PT. BALAI IKLAN</p>
                </div>
                <p class="text-xs font-bold text-green-600 mt-8 mr-6">Sistem PT. Balai Iklan</p>
                @endif
            </div>
        </div>
        
    </div>
</body>
</html>