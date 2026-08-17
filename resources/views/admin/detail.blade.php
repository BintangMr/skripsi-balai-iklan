<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Pesanan - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg border w-full max-w-4xl flex overflow-hidden">
        
        <div class="w-1/2 p-8 border-r">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Detail Pesanan <span class="text-blue-600">#INV-202605{{ str_pad($pesanan->id, 2, '0', STR_PAD_LEFT) }}</span></h2>
            
            <div class="space-y-4 text-sm">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase">Nama Pelanggan / Instansi</p>
                    <p class="font-bold text-lg text-gray-900">{{ $pesanan->nama_pelanggan }} ({{ $pesanan->no_telp }})</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase">Jenis Layanan</p>
                    <p class="font-semibold text-blue-700">Iklan {{ $pesanan->jenis_iklan }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase">Materi Naskah / Desain</p>
                    <div class="text-gray-700 bg-gray-50 p-2 rounded border text-xs mt-1">
                        @if($pesanan->jenis_iklan === 'Display')
                            <a href="{{ asset('storage/' . $pesanan->materi_iklan) }}" target="_blank" class="text-blue-600 underline font-semibold flex items-center">
                                🖼️ Lihat File Desain Iklan Pelanggan
                            </a>
                        @else
                            <p class="italic">"{{ $pesanan->materi_iklan }}"</p>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase">Total Tagihan (Inc PPN 11%)</p>
                    <p class="font-bold text-2xl text-teal-600">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase">Status Antrean</p>
                    <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                        {{ $pesanan->status }}
                    </span>
                </div>
            </div>
            
            @if($pesanan->status === 'Menunggu Validasi')
                <form action="/admin/pesanan/{{ $pesanan->id }}/verifikasi" method="POST" class="mt-8 border-t pt-6 flex space-x-3">
                    @csrf
                    <button type="submit" name="aksi" value="Tolak" class="flex-1 bg-red-100 text-red-700 hover:bg-red-200 border border-red-300 font-bold py-3 rounded-lg text-sm transition">Tolak (Kirim Ulang Bukti)</button>
                    <button type="submit" name="aksi" value="Lunas" class="flex-1 bg-teal-600 text-white hover:bg-teal-700 font-bold py-3 rounded-lg text-sm shadow-md transition">Verifikasi Lunas</button>
                </form>
            @endif

            @if($pesanan->status === 'Lunas')
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Manajemen Bukti Terbit (Tear Sheet)</h3>
                    
                    @if($pesanan->bukti_terbit)
                        <div class="bg-green-50 p-3 rounded-lg text-green-700 text-xs font-bold mb-3 border border-green-200">
                            ✓ Bukti terbit koran telah sukses diunggah.
                        </div>
                        <a href="{{ asset('bukti_terbit/'.$pesanan->bukti_terbit) }}" target="_blank" class="text-xs font-bold text-blue-600 underline">Lihat file bukti terbit yang aktif</a>
                    @else
                        <form action="/admin/pesanan/{{ $pesanan->id }}/upload-bukti" method="POST" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <input type="file" name="file_bukti" accept="image/*" class="text-xs border p-2 rounded w-full bg-gray-50" required>
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded text-xs hover:bg-indigo-700 transition shadow-sm">Unggah Bukti Terbit ke Pelanggan</button>
                        </form>
                    @endif
                </div>
            @endif

            <a href="/dashboard-admin" class="block text-center mt-6 text-xs text-gray-500 hover:underline">← Kembali ke Dashboard Utama</a>
        </div>

        <div class="w-1/2 bg-slate-50 p-8 flex flex-col items-center justify-center">
            <h3 class="text-xs font-bold text-slate-500 uppercase mb-4 tracking-wider">Lampiran Bukti Transaksi Pelanggan</h3>
            
            @if($pembayaran && $pembayaran->bukti_transfer)
                <div class="bg-white p-2 rounded shadow border border-gray-200 max-w-full">
                    <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" alt="Bukti Transfer" class="max-w-full max-h-[380px] rounded object-contain">
                </div>
                <p class="text-[11px] text-gray-400 mt-4 font-medium">Diunggah pada: {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d M Y H:i:s') }} WIB</p>
            @else
                <div class="text-center p-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-100 max-w-xs">
                    <p class="text-red-500 font-bold text-xs uppercase tracking-wide">Tidak Ada Lampiran</p>
                    <p class="text-gray-400 text-[10px] mt-1">Pelanggan belum mengunggah berkas bukti transaksi atau riwayat pembayaran belum tercatat di sistem.</p>
                </div>
            @endif
        </div>

    </div>
</body>
</html>