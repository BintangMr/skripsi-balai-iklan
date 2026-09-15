<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - PT. Balai Iklan</title>
    <link rel="icon" href="{{ asset('balai_iklan.jpeg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <nav class="bg-[#1e3a8a] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2 font-bold tracking-wide">PT. BALAI IKLAN</div>
        <div class="text-sm font-semibold flex items-center space-x-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
            <span>Pembayaran Aman</span>
        </div>
    </nav>

    <div class="flex justify-center items-center my-8 text-sm font-semibold text-teal-600">
        <span class="flex items-center"><div class="w-6 h-6 rounded-full border-2 border-teal-500 flex justify-center items-center mr-2">1</div> Pemesanan</span>
        <div class="w-16 h-0.5 bg-teal-500 mx-4"></div>
        <span class="flex items-center"><div class="w-6 h-6 rounded-full bg-teal-500 text-white flex justify-center items-center mr-2">2</div> Pembayaran</span>
        <div class="w-16 h-0.5 bg-gray-300 mx-4"></div>
        <span class="flex items-center text-gray-400"><div class="w-6 h-6 rounded-full border-2 border-gray-300 flex justify-center items-center mr-2">3</div> Selesai</span>
    </div>

    <div class="max-w-5xl mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold">Nomor Pesanan</p>
                            <p class="font-bold text-gray-800">#INV-202605{{ str_pad($pesanan->id, 2, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 font-semibold">Batas Waktu Pembayaran</p>
                            <p id="timer" class="font-bold text-red-600 text-lg">Menghitung...</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-1">Total Tagihan Pembayaran</p>
                        <p class="text-3xl font-bold text-[#1e3a8a]">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Transfer ke Rekening Berikut:</h3>
                    <div class="border rounded-lg p-4 flex items-center justify-between mb-3 border-l-4 border-l-blue-500">
                        <div>
                            <p class="font-bold text-lg">BCA <span class="ml-4 text-gray-800 tracking-wider">123 456 7890</span></p>
                            <p class="text-xs text-gray-500">a.n PT Balai Iklan Bandung</p>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 flex items-center justify-between border-l-4 border-l-yellow-500">
                        <div>
                            <p class="font-bold text-lg text-yellow-600">MANDIRI <span class="ml-4 text-gray-800 tracking-wider">098 765 4321 123</span></p>
                            <p class="text-xs text-gray-500">a.n PT Balai Iklan Bandung</p>
                        </div>
                    </div>
                </div>

                <!-- DIALOG / TATACARA SOP PEMBAYARAN -->
                <div class="bg-blue-50 border border-blue-200 p-5 rounded-xl text-blue-900">
                    <h4 class="font-bold text-sm mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tata Cara & SOP Pembayaran:
                    </h4>
                    <ol class="list-decimal pl-4 text-xs space-y-1.5 text-blue-800">
                        <li>Lakukan transfer sesuai dengan nominal total tagihan di atas ke salah satu rekening PT Balai Iklan Bandung.</li>
                        <li>Simpan struk atau ambil *screenshot* bukti transaksi Anda.</li>
                        <li>Isi form konfirmasi di sebelah kanan (Pilih Bank tujuan, masukkan nama dan nomor rekening pengirim Anda).</li>
                        <li>Unggah bukti transfer berformat JPG/PNG lalu klik tombol kirim.</li>
                        <li>Bagian Keuangan akan memverifikasi mutasi bank dalam waktu maksimal 1x24 jam.</li>
                    </ol>
                </div>
            </div>

            <div class="bg-[#1e293b] text-white p-8 rounded-xl shadow-lg">
                <h3 class="text-xl font-bold mb-2">Konfirmasi Pembayaran</h3>
                <p class="text-xs text-gray-400 mb-6">Sudah melakukan transfer? Silakan lengkapi data di bawah ini untuk diverifikasi oleh Bagian Keuangan.</p>
                
                @if($errors->any())
                    <div class="bg-red-500 text-white text-xs p-4 rounded-lg mb-6 shadow-md border border-red-700">
                        <ul class="list-disc pl-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/pembayaran/{{ $pesanan->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- FIELD 1: BANK TUJUAN TRANSFER -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Bank Tujuan Transfer</label>
                        <select name="bank_tujuan" class="w-full bg-slate-800 border border-slate-600 rounded-md px-3 py-2 text-sm text-white focus:ring-teal-500 focus:border-teal-500" required>
                            <option value="" disabled selected>-- Pilih Bank Tujuan --</option>
                            <option value="BCA">BCA (123 456 7890)</option>
                            <option value="MANDIRI">MANDIRI (098 765 4321 123)</option>
                        </select>
                    </div>

                    <!-- FIELD 2: NAMA PEMILIK REKENING PENGIRIM -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Pemilik Rekening Pengirim</label>
                        <input type="text" name="nama_pengirim" class="w-full bg-slate-800 border border-slate-600 rounded-md px-3 py-2 text-sm text-white focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: Bintang Muhammad Rizqi" required>
                    </div>

                    <!-- FIELD 3: NOMOR REKENING PENGIRIM -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor Rekening Pengirim</label>
                        <input type="text" name="no_rekening_pengirim" class="w-full bg-slate-800 border border-slate-600 rounded-md px-3 py-2 text-sm text-white focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: 1350294811" required>
                    </div>
                    
                    <!-- FIELD 4: UNGGAH BUKTI TRANSFER -->
                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Unggah Bukti Transfer (JPG/PNG)</label>
                        <div class="border-2 border-dashed border-slate-600 rounded-lg p-6 flex flex-col items-center justify-center bg-slate-800 hover:bg-slate-700 transition">
                            <input type="file" name="bukti_transfer" accept="image/png, image/jpeg" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-500 file:text-white hover:file:bg-teal-600" required>
                        </div>
                    </div>

                    <button id="btnSubmit" type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 rounded-lg transition shadow-md flex justify-center items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Kirim Konfirmasi Pembayaran</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        var deadline = new Date("{{ $pesanan->created_at->addHours(24)->format('Y-m-d\TH:i:s') }}").getTime();

        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = deadline - now;

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML = 
                (hours < 10 ? "0" + hours : hours) + ":" + 
                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                (seconds < 10 ? "0" + seconds : seconds) + " WIB";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "KADALUARSA";
                
                const btnSubmit = document.getElementById("btnSubmit");
                btnSubmit.disabled = true;
                btnSubmit.classList.remove('bg-teal-500', 'hover:bg-teal-600');
                btnSubmit.classList.add('bg-gray-400', 'cursor-not-allowed');
                btnSubmit.innerHTML = "Pesanan Telah Kadaluarsa";
            }
        }, 1000);
    </script>
</body>
</html>