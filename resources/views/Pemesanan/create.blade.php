<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Iklan - PT. Balai Iklan</title>
    <link rel="icon" href="{{ asset('balai_iklan.jpeg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> 
        #form-baris { display: none; } 
        /* Custom scrollbar untuk grid OTP agar rapi di layar kecil */
        .otp-scroll::-webkit-scrollbar { height: 6px; }
        .otp-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <nav class="bg-[#1e3a8a] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="font-bold tracking-wide">PT. BALAI IKLAN</span>
        </div>
        <div class="flex items-center space-x-6 text-sm">
            <a href="/dashboard-pelanggan" class="hover:text-teal-300">Beranda</a>
            <a href="/riwayat-pesanan" class="hover:text-teal-300">Riwayat Pesanan</a>
            <a href="/tagihan" class="hover:text-teal-300">Tagihan</a>
            <div class="flex items-center space-x-2 border-l border-blue-700 pl-6">
                <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center font-bold text-white">{{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}</div>
                <span>{{ session('nama', 'Pengguna') }}</span>
            </div>
            <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-semibold transition ml-2">Keluar</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8 pb-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Formulir Pendaftaran Iklan Baru</h1>
            <p class="text-gray-500 text-sm mt-1">Lengkapi data di bawah ini sesuai dengan ketentuan perusahaan.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <form action="/pesan-iklan" method="POST" id="formPemesanan" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="jenis_iklan" id="input_jenis_iklan" value="{{ old('jenis_iklan', 'Baris') }}">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Iklan</label>
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" id="btn-baris" onclick="gantiTabIklan('Baris')" 
                                class="py-3 px-4 border rounded-lg font-medium transition-all duration-200 border-teal-500 bg-teal-50 text-teal-700">
                                Iklan Baris (Teks)
                            </button>
                            <button type="button" id="btn-display" onclick="gantiTabIklan('Display')" 
                                class="py-3 px-4 border rounded-lg font-medium transition-all duration-200 border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                Iklan Display (Gambar)
                            </button>
                        </div>
                    </div>

                    <!-- AREA FORM DISPLAY -->
                    <div id="area-form-display" class="hidden">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Unggah Desain Iklan (Ukuran mmK)</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition min-h-[160px]">
                                <input type="file" name="file_desain" id="inputFileDesain" accept="image/png, image/jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                                    <div id="previewContainer" class="hidden w-full flex flex-col items-center z-0">
                                        <img id="imagePreview" src="" class="max-h-40 object-contain rounded shadow-sm mb-2 border border-gray-200">
                                            <p class="text-xs text-teal-600 font-semibold bg-teal-50 px-3 py-1 rounded-full">Klik kotak ini untuk mengganti gambar</p>
                                    </div>
                                <div id="uploadPlaceholder" class="flex flex-col items-center text-center z-0">
                                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <p class="text-sm font-medium text-gray-600">Pilih File Gambar</p>
                                </div>
                            </div>
                                @error('file_desain')
                                    <p class="text-red-500 text-xs font-bold mt-1">⚠️ {{ $message }}</p>
                                @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Simulasi Tampilan Iklan di Koran</label>
                            <div class="relative w-full border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-gray-900 flex justify-center p-4">
                                <div class="relative inline-block">
                                    <img src="{{ asset('images/template-koran.png') }}" alt="Template Koran" class="max-h-[450px] w-auto object-contain block mx-auto opacity-90">
                                    <div id="boxVisualisasi" class="absolute top-[35%] left-1/2 -translate-x-1/2 border-2 border-dashed border-teal-400 bg-white/95 p-1 rounded shadow-md transition-all duration-150 flex items-center justify-center overflow-hidden" style="width: 30%; height: 25%;">
                                        <img id="visualisasiKoran" src="" class="hidden w-full h-full object-fill" alt="Preview Visualisasi">
                                        <p id="teksVisualisasi" class="text-[10px] text-teal-800 font-semibold text-center px-1">Area Iklan (2 Kolom x 50 mm)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran Kolom & Tinggi (Minimal 2x50, Maksimal 7x540)</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="flex">
                                        <input type="number" id="inputLebar" name="lebar_kolom" value="2" min="2" max="7" class="w-full border border-r-0 border-gray-300 rounded-l-md px-3 py-2 focus:ring-teal-500 focus:border-teal-500">
                                        <span class="bg-gray-50 border border-gray-300 border-l-0 rounded-r-md px-3 py-2 text-sm text-gray-500">Kolom</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex">
                                        <input type="number" id="inputTinggi" name="tinggi_mm" value="50" min="50" max="540" class="w-full border border-r-0 border-gray-300 rounded-l-md px-3 py-2 focus:ring-teal-500 focus:border-teal-500">
                                        <span class="bg-gray-50 border border-gray-300 border-l-0 rounded-r-md px-3 py-2 text-sm text-gray-500">mm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AREA FORM BARIS (GRID OTP) -->
                    <div id="area-form-baris" class="block">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Materi Naskah (Maks 8 Baris / 208 Karakter)</label>
                            
                            <!-- Input hidden ini akan dikirim ke backend -->
                            <input type="hidden" name="materi_teks" id="input_materi_teks" value="{{ old('materi_teks') }}">
                            
                            <div id="otp-container" class="otp-scroll overflow-x-auto py-4 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-inner">
                                <!-- Kotak-kotak Grid akan di-generate oleh JavaScript di bawah -->
                            </div>
                            
                            <div class="flex justify-between text-xs mt-2 px-1">
                                <span class="text-red-500 font-medium">*Min: 2 Baris | 1 Baris = 26 Karakter</span>
                                <span id="wordCount" class="text-gray-600 font-bold">0 Baris (0/208 Karakter)</span>
                            </div>
                            
                            @error('materi_teks')
                                <p class="text-red-500 text-xs font-bold mt-1">⚠️ {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- INPUT TANGGAL UTAMA -->
                    <div class="border-t pt-6 mt-6">
                    <label for="tgl_tayang" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai Terbit</label>
                        <input type="date" name="tgl_tayang" class="form-control w-full md:w-1/2 border rounded-md px-3 py-2 focus:ring-teal-500 focus:border-teal-500 @error('tgl_tayang') border-red-500 @else border-gray-300 @enderror" required >
                        @error('tgl_tayang')
                            <p class="text-red-500 text-xs font-bold mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-[#1e293b] text-white p-6 rounded-xl shadow-lg sticky top-6">
                    <h3 class="text-lg font-bold mb-4 border-b border-slate-600 pb-2">Kalkulasi Biaya Tayang</h3>
                    
                    <div class="space-y-3 text-sm mb-4">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Jenis Layanan</span>
                            <span class="font-medium text-teal-400" id="calcJenis">Iklan Display</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tarif Dasar</span>
                            <span class="font-medium" id="calcTarif">Rp 55.000 / mmK</span>
                        </div>
                        
                        <div class="flex justify-between pt-2 border-t border-slate-600 calc-display-only">
                            <span class="text-slate-400">Lebar Kolom</span>
                            <span class="font-medium" id="calcLebar">2 Kolom</span>
                        </div>
                        <div class="flex justify-between calc-display-only">
                            <span class="text-slate-400">Tinggi Frame</span>
                            <span class="font-medium" id="calcTinggi">50 mm</span>
                        </div>
                        <div class="flex justify-between calc-display-only">
                            <span class="text-slate-400">Total Dimensi</span>
                            <span class="font-bold" id="calcDimensi">100 mmK</span>
                        </div>

                        <div class="flex justify-between calc-baris-only" style="display:none;">
                            <span class="text-slate-400">Jumlah Baris Ditagih</span>
                            <span class="font-bold" id="calcBaris">2 Baris</span>
                        </div>

                        <div class="flex justify-between pt-4 border-t border-slate-600">
                            <span class="text-slate-400">Subtotal</span>
                            <span class="font-medium" id="calcSubtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-red-400">PPN (11%)</span>
                            <span class="font-medium text-red-400" id="calcPPN">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6 pt-2 border-t border-slate-500">
                        <span class="text-lg font-bold">Total Tagihan</span>
                        <span class="text-2xl font-bold text-teal-400" id="calcTotal">Rp 0</span>
                    </div>

                    <button type="submit" form="formPemesanan" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 rounded-lg flex justify-center transition shadow-md">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const inputLebar = document.getElementById('inputLebar');
        const inputTinggi = document.getElementById('inputTinggi');
        
        if(inputLebar) inputLebar.addEventListener('input', updateKalkulasi);
        if(inputTinggi) inputTinggi.addEventListener('input', updateKalkulasi);

        // Fungsi Kalkulasi
        function updateKalkulasi() {
            const inputJenis = document.getElementById('input_jenis_iklan');
            if(!inputJenis) return; 
            
            const jenisAktif = inputJenis.value; 
            let subtotal = 0;
            let ppn = 0;
            let total = 0;

            if (jenisAktif === 'Display') {
                document.getElementById('calcJenis').innerText = 'Iklan Display';
                document.getElementById('calcTarif').innerText = 'Rp 55.000 / mmK';
                document.querySelectorAll('.calc-display-only').forEach(el => el.style.display = 'flex');
                document.querySelectorAll('.calc-baris-only').forEach(el => el.style.display = 'none');

                let lebar = parseInt(inputLebar.value) || 2;
                if (lebar < 2) lebar = 2;
                if (lebar > 7) lebar = 7;

                let tinggi = parseInt(inputTinggi.value) || 50;
                if (tinggi < 50) tinggi = 50;
                if (tinggi > 540) tinggi = 540;
                
                let dimensi = lebar * tinggi;

                document.getElementById('calcLebar').innerText = lebar + ' Kolom';
                document.getElementById('calcTinggi').innerText = tinggi + ' mm';
                document.getElementById('calcDimensi').innerText = dimensi + ' mmK';

                subtotal = dimensi * 55000;

                let persentaseLebar = (lebar / 7) * 75; 
                let persentaseTinggi = (tinggi / 540) * 50; 

                const boxVisualisasi = document.getElementById('boxVisualisasi');
                if(boxVisualisasi) {
                    boxVisualisasi.style.width = persentaseLebar + '%';
                    boxVisualisasi.style.height = persentaseTinggi + 'px';
                }

            } else {
                document.getElementById('calcJenis').innerText = 'Iklan Baris';
                document.getElementById('calcTarif').innerText = 'Rp 22.500 / Baris';
                document.querySelectorAll('.calc-display-only').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.calc-baris-only').forEach(el => el.style.display = 'flex');

                const inputMateri = document.getElementById('input_materi_teks');
                let teks = inputMateri ? inputMateri.value : '';
                
                let barisArray = teks === '' ? [] : teks.split('\n');
                let jumlahBarisAsli = barisArray.length;
                let jumlahKarakter = teks.replace(/\n/g, '').length;
                
                const wordCountSpan = document.getElementById('wordCount');
                if (wordCountSpan) {
                    wordCountSpan.innerText = `${jumlahBarisAsli} Baris (${jumlahKarakter}/208 Karakter)`;
                }

                let jumlah_baris = jumlahBarisAsli;
                if (jumlah_baris < 2) jumlah_baris = 2; 
                if (jumlah_baris > 8) jumlah_baris = 8;

                document.getElementById('calcBaris').innerText = jumlah_baris + ' Baris';
                subtotal = jumlah_baris * 22500;
            }

            ppn = subtotal * 0.11;
            total = subtotal + ppn;

            document.getElementById('calcSubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('calcPPN').innerText = 'Rp ' + ppn.toLocaleString('id-ID');
            document.getElementById('calcTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('previewContainer');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const imagePreview = document.getElementById('imagePreview');
            const visualisasiKoran = document.getElementById('visualisasiKoran');
            const teksVisualisasi = document.getElementById('teksVisualisasi');

            if (input.files && input.files[0] && input.files[0].type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');

                    if(visualisasiKoran && teksVisualisasi) {
                        visualisasiKoran.src = e.target.result;
                        visualisasiKoran.classList.remove('hidden');
                        teksVisualisasi.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
                imagePreview.src = "";

                if(visualisasiKoran && teksVisualisasi) {
                    visualisasiKoran.src = "";
                    visualisasiKoran.classList.add('hidden');
                    teksVisualisasi.classList.remove('hidden');
                }
            }
        }

        function gantiTabIklan(jenis) {
            const btnBaris = document.getElementById('btn-baris');
            const btnDisplay = document.getElementById('btn-display');
            const areaBaris = document.getElementById('area-form-baris');
            const areaDisplay = document.getElementById('area-form-display');
            const inputJenis = document.getElementById('input_jenis_iklan');

            if(!btnBaris || !btnDisplay || !areaBaris || !areaDisplay || !inputJenis) return;

            const styleNyala = "py-3 px-4 border rounded-lg font-medium transition-all duration-200 border-teal-500 bg-teal-50 text-teal-700";
            const styleMati = "py-3 px-4 border rounded-lg font-medium transition-all duration-200 border-gray-300 bg-white text-gray-500 hover:bg-gray-50";

            if (jenis === 'Baris') {
                btnBaris.className = styleNyala;       
                btnDisplay.className = styleMati;      
                areaBaris.classList.remove('hidden');  
                areaDisplay.classList.add('hidden');   
                inputJenis.value = 'Baris';            
            } else {
                btnDisplay.className = styleNyala;     
                btnBaris.className = styleMati;        
                areaDisplay.classList.remove('hidden');
                areaBaris.classList.add('hidden');     
                inputJenis.value = 'Display';          
            }
            
            updateKalkulasi();
        }

        // Jalankan saat DOM dimuat
        document.addEventListener("DOMContentLoaded", function() {
            const otpContainer = document.getElementById('otp-container');
            const MAX_ROWS = 8;
            const COLS = 26;
            let otpInputs = [];

            if (otpContainer) {
                let html = '<div class="flex flex-col gap-1.5 w-max">';
                for(let r=0; r<MAX_ROWS; r++) {
                    html += '<div class="flex gap-1.5 items-center">';
                    html += `<span class="text-xs font-bold text-teal-600 w-4">${r+1}</span>`;
                    for(let c=0; c<COLS; c++) {
                        html += `<input type="text" maxlength="1" id="otp-${r}-${c}" class="otp-box w-6 h-8 text-center border border-gray-300 rounded text-sm font-bold text-gray-800 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 uppercase transition-all shadow-sm" autocomplete="off">`;
                    }
                    html += '</div>';
                }
                html += '</div>';
                otpContainer.innerHTML = html;
                otpInputs = Array.from(document.querySelectorAll('.otp-box'));

                otpInputs.forEach((input, index) => {
                    input.addEventListener('input', (e) => {
                        if (input.value.length > 1) input.value = input.value.slice(-1);
                        if (input.value !== ' ') input.value = input.value.toUpperCase();
                        
                        if (input.value && index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                        compileOtpText();
                    });

                    input.addEventListener('keydown', (e) => {
                        // FIX BUG 2: Blokir aksi bawaan Enter, pindahkan fokus ke awal baris baru
                        if (e.key === 'Enter') {
                            e.preventDefault(); 
                            let nextRowFirstColIndex = Math.floor(index / COLS) * COLS + COLS;
                            if (nextRowFirstColIndex < otpInputs.length) {
                                otpInputs[nextRowFirstColIndex].focus();
                            }
                        } else if (e.key === 'Backspace') {
                            if (!input.value && index > 0) {
                                otpInputs[index - 1].focus();
                                otpInputs[index - 1].value = '';
                                e.preventDefault();
                            }
                            setTimeout(compileOtpText, 10);
                        } else if (e.key === 'ArrowLeft' && index > 0) {
                            otpInputs[index - 1].focus();
                        } else if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        } else if (e.key === 'ArrowUp' && index >= COLS) {
                            otpInputs[index - COLS].focus();
                        } else if (e.key === 'ArrowDown' && index < otpInputs.length - COLS) {
                            otpInputs[index + COLS].focus();
                        }
                    });

                    input.addEventListener('paste', (e) => {
                        e.preventDefault();
                        let pasteData = e.clipboardData.getData('text').replace(/[\r\n]/g, '').trim().toUpperCase();
                        let currIndex = index;
                        for(let i=0; i<pasteData.length; i++) {
                            if (currIndex < otpInputs.length) {
                                otpInputs[currIndex].value = pasteData[i];
                                currIndex++;
                            }
                        }
                        if (currIndex < otpInputs.length) otpInputs[currIndex].focus();
                        else otpInputs[otpInputs.length-1].focus();
                        compileOtpText();
                    });
                });
            }

            function compileOtpText() {
                let maxRowIndex = -1;
                let constructedLines = [];
                
                for(let r=0; r<MAX_ROWS; r++) {
                    // FIX BUG 1: Rekam posisi terakhir yang diisi (termasuk spasi yang diketik sengaja)
                    let lastCharIndex = -1;
                    for(let c=0; c<COLS; c++) {
                        let val = document.getElementById(`otp-${r}-${c}`).value;
                        if (val !== '') lastCharIndex = c;
                    }
                    
                    let rowStr = '';
                    if (lastCharIndex >= 0) {
                        for(let c=0; c<=lastCharIndex; c++) {
                            let val = document.getElementById(`otp-${r}-${c}`).value;
                            // Ubah kotak kosong yang terapit menjadi spasi
                            rowStr += val === '' ? ' ' : val; 
                        }
                    }
                    
                    constructedLines.push(rowStr);
                    if(rowStr.length > 0) maxRowIndex = r;
                }
                
                let finalLines = [];
                if (maxRowIndex >= 0) {
                    for(let r=0; r<=maxRowIndex; r++) {
                        finalLines.push(constructedLines[r]);
                    }
                }
                
                const finalString = finalLines.join('\n');
                const hiddenInput = document.getElementById('input_materi_teks');
                if(hiddenInput) hiddenInput.value = finalString;

                updateKalkulasi();
            }

            const hiddenInput = document.getElementById('input_materi_teks');
            if(hiddenInput && hiddenInput.value) {
                let lines = hiddenInput.value.split('\n');
                for(let r=0; r<lines.length && r<MAX_ROWS; r++) {
                    let rowText = lines[r];
                    for(let c=0; c<rowText.length && c<COLS; c++) {
                        let char = rowText[c];
                        if(char !== ' ') {
                            let box = document.getElementById(`otp-${r}-${c}`);
                            if(box) box.value = char.toUpperCase();
                        }
                    }
                }
            }

            const inputJenis = document.getElementById('input_jenis_iklan');
            if (inputJenis) {
                const jenisTerakhir = inputJenis.value || 'Baris';
                gantiTabIklan(jenisTerakhir);
            }
            updateKalkulasi(); 
        });
    </script>
</body>
</html>