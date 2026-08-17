<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Resmi_Pemesanan_Iklan.pdf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 flex justify-center" onload="window.print()">
    <div class="w-full max-w-4xl bg-white p-10 shadow-lg border rounded">
        
        <div class="text-center border-b-4 border-slate-900 pb-4 mb-6">
            <h1 class="text-3xl font-bold text-slate-900 tracking-wide">PT. BALAI IKLAN BANDUNG</h1>
            <p class="text-xs text-gray-500 mt-1">Jl. Aceh No.21, Babakan Ciamis, Sumur Bandung, Kota Bandung, Jawa Barat 40117</p>
            <p class="text-[10px] text-gray-400">Telp: (022) 1234567 | Email: corporate@balaiiklan.co.id</p>
        </div>

        <h2 class="text-xl font-bold text-center uppercase tracking-wide text-gray-800 mb-6">Laporan Resmi Pemesanan dan Pendapatan Iklan</h2>

        <table class="w-full text-left text-xs border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                    <th class="p-3 border border-gray-300 text-center">No. Invoice</th>
                    <th class="p-3 border border-gray-300">Nama Pelanggan</th>
                    <th class="p-3 border border-gray-300 text-center">Jenis Layanan</th>
                    <th class="p-3 border border-gray-300 text-center">Tanggal Bayar</th>
                    <th class="p-3 border border-gray-300 text-right">Total Asli (Inc. PPN)</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                
                @foreach($laporans as $laporan)
                <tr class="border-b border-gray-200">
                    <td class="p-3 border border-gray-300 text-center font-bold text-blue-700">
                        #INV-202605{{ str_pad($laporan->id, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="p-3 border border-gray-300 font-medium">{{ $laporan->nama_pelanggan }}</td>
                    <td class="p-3 border border-gray-300 text-center">Iklan {{ $laporan->jenis_iklan }}</td>
                    <td class="p-3 border border-gray-300 text-center">
                        {{ $laporan->tgl_bayar ? \Carbon\Carbon::parse($laporan->tgl_bayar)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-3 border border-gray-300 text-right font-bold text-gray-900">
                        Rp {{ number_format($laporan->total_biaya, 0, ',', '.') }}
                    </td>
                </tr>
                @php $grandTotal += $laporan->total_biaya; @endphp
                @endforeach
                
                <tr class="bg-slate-50 font-bold">
                    <td colspan="4" class="p-3 border border-gray-300 text-right uppercase">Total Akumulasi Pendapatan Bersih:</td>
                    <td class="p-3 border border-gray-300 text-right text-sm text-emerald-700">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-12 flex justify-end text-xs">
            <div class="text-center">
                <p class="text-gray-500 mb-16">Bandung, {{ date('d M Y') }}</p>
                <p class="font-bold underline text-gray-900">Direktur Utama PT. Balai Iklan</p>
            </div>
        </div>

    </div>
</body>
</html>