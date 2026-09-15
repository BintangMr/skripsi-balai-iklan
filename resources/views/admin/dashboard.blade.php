<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Admin Panel - PT. Balai Iklan</title>
    <link rel="icon" href="{{ asset('balai_iklan.jpeg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 flex h-screen overflow-hidden">

<aside class="w-64 bg-[#1a2235] text-gray-300 flex flex-col justify-between h-full shadow-lg">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-700 mb-4">
                <span class="text-white font-bold tracking-widest text-sm">ADMIN PANEL</span>
            </div>
            <nav class="space-y-1 px-3">
                <a href="/admin/data-admin" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('dashboard-admin') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Dashboard
                </a>
                
                <a href="/admin/pelanggan" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('admin/pelanggan') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Data Pelanggan
                </a>
                <a href="/admin/data-admin" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('admin/data-admin*') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Data Karyawan
                </a>
            </nav>
        </div>
        
        <div class="p-4 border-t border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">A</div>
                <div class="text-xs">
                    <p class="text-white font-bold">Staf</p>
                    <p class="text-gray-400">PT. Balai Iklan</p>
                </div>
            </div>
            <a href="/logout" class="text-red-400 hover:text-red-300" title="Keluar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8">
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Verifikasi & Laporan</h1>
                <p class="text-xs text-gray-500 mt-1">Monitoring seluruh aktivitas transaksi secara real-time.</p>
            </div>
            <button onclick="window.location.reload()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded shadow-sm text-xs font-bold flex items-center space-x-2 hover:bg-gray-50">
                <span>↻ Refresh Data</span>
            </button>
        </div>

        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl border shadow-sm flex flex-col justify-between">
                <span class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-2">Total Pesanan</span>
                <span class="text-3xl font-bold text-blue-600">{{ str_pad($pesanan_baru, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="bg-white p-5 rounded-xl border shadow-sm flex flex-col justify-between">
                <span class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-2">Menunggu Validasi</span>
                <span class="text-3xl font-bold text-orange-500">{{ str_pad($menunggu_validasi, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="bg-white p-5 rounded-xl border shadow-sm flex flex-col justify-between">
                <span class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-2">Iklan Aktif</span>
                <span class="text-3xl font-bold text-teal-500">{{ str_pad($iklan_aktif, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="bg-white p-5 rounded-xl border shadow-sm flex flex-col justify-between">
                <span class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-2">Total Pendapatan</span>
                <span class="text-2xl font-bold text-gray-800">Rr {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white border rounded-xl shadow-sm mb-10 overflow-hidden">
            <div class="p-4 border-b bg-red-50 flex justify-between items-center">
                <h3 class="font-bold text-sm text-red-800">Antrean Verifikasi Bukti Pembayaran</h3>
            </div>
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase border-b">
                    <tr>
                        <th class="py-3 px-4">No. Invoice</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4 text-center">Total Biaya</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($antreans as $antrean)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-bold text-gray-800">#INV-202605{{ str_pad($antrean->id, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 px-4 font-bold">{{ $antrean->nama_pelanggan }}</td>
                        <td class="py-3 px-4 font-bold text-center">Rp {{ number_format($antrean->total_biaya, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center"><span class="bg-orange-100 text-orange-800 px-2 py-0.5 rounded text-[10px] font-bold">Cek Pembayaran</span></td>
                        <td class="py-3 px-4 text-center">
                            <a href="/admin/pesanan/{{ $antrean->id }}" class="bg-blue-600 text-white px-3 py-1.5 rounded font-bold text-[10px] hover:bg-blue-700">Detail & Verifikasi</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">Tidak ada antrean verifikasi saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden mb-12">
            <div class="p-5 border-b bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-sm text-gray-800">Pusat Laporan & Arsip</h3>
                
                <form action="/dashboard-admin" method="GET" class="flex space-x-2">
                    <select name="jenis_iklan" class="border rounded px-3 py-1.5 text-xs bg-white text-gray-700 font-medium">
                        <option value="">Semua Jenis Iklan</option>
                        <option value="Baris" {{ request('jenis_iklan') == 'Baris' ? 'selected' : '' }}>Iklan Baris</option>
                        <option value="Display" {{ request('jenis_iklan') == 'Display' ? 'selected' : '' }}>Iklan Display</option>
                    </select>
                    <input type="text" name="cari_nama" placeholder="Cari Nama/Instansi..." value="{{ request('cari_nama') }}" class="border rounded px-3 py-1.5 text-xs w-48">
                    <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" class="border rounded px-3 py-1.5 text-xs">
                    <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" class="border rounded px-3 py-1.5 text-xs">
                    <button type="submit" class="bg-slate-800 text-white px-4 py-1.5 rounded text-xs font-bold hover:bg-slate-700">Filter</button>
                    <a href="/dashboard-admin" class="bg-gray-200 text-gray-700 px-4 py-1.5 rounded text-xs font-bold hover:bg-gray-300">Reset</a>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px]">
                    <thead class="bg-slate-800 text-slate-200 uppercase">
                        <tr>
                            <th class="py-3 px-4">No. Invoice & Nama</th>
                            <th class="py-3 px-4">Subtotal (Tanpa PPN)</th>
                            <th class="py-3 px-4">Pajak (PPN 11%)</th>
                            <th class="py-3 px-4 font-bold text-teal-300">Total Asli</th>
                            <th class="py-3 px-4">Tgl Order</th>
                            <th class="py-3 px-4">Tgl Terbit</th>
                            <th class="py-3 px-4">Tgl & Jam Bayar</th>
                            <th class="py-3 px-4 text-center">Bukti Terbit</th>
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
                                    <span class="text-[9px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded font-bold">Iklan {{ $lap->jenis_iklan }}</span>
                                </td>
                                    <td class="py-3 px-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-red-600">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 font-bold text-teal-700 text-xs">Rp {{ number_format($lap->total_biaya, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($lap->tgl_pesan)->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ $lap->tgl_tayang? \Carbon\Carbon::parse($lap->tgl_tayang)->translatedFormat('d M Y') : '-'}}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($lap->tgl_bayar)->format('d M Y') }} <br>
                                    <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($lap->waktu_bayar)->format('H:i:s') }} WIB</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($lap->bukti_terbit)
                                        <a href="{{ asset('bukti_terbit/'.$lap->bukti_terbit) }}" target="_blank" class="text-indigo-600 font-bold underline text-[10px]">Lihat File</a>
                                    @else
                                        <form action="/admin/pesanan/{{ $lap->id }}/upload-bukti" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                            @csrf
                                            <input type="file" name="file_bukti" accept="image/*" class="hidden" id="file_{{$lap->id}}" onchange="this.form.submit()">
                                            <label for="file_{{$lap->id}}" class="cursor-pointer bg-indigo-500 text-white px-2 py-1 rounded text-[9px] hover:bg-indigo-600">
                                                + Upload
                                            </label>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-8 text-center text-red-500 font-bold">Data kosong! Tidak ada arsip laporan pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t flex justify-end">
                @if($laporans->isEmpty())
                    <button type="button" onclick="alert('Arsip kosong! Tidak ada data yang bisa diekspor.')" class="bg-gray-400 text-white px-6 py-2 rounded text-xs font-bold cursor-not-allowed">Ekspor PDF Terkunci</button>
                @else
                    <a href="/laporan-pemilik/cetak?tgl_awal={{ request('tgl_awal') }}&tgl_akhir={{ request('tgl_akhir') }}&cari_nama={{ request('cari_nama') }}&jenis_iklan={{ request('jenis_iklan') }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded text-xs font-bold shadow-md">Unduh Dokumen Laporan PDF</a>
                @endif
            </div>
        </div>
    </main>
</body>
</html>