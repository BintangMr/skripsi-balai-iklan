<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Registrasi Karyawan Baru - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 p-8 flex justify-center items-center min-h-screen">
    <div class="bg-white border rounded-xl shadow-md p-6 w-full max-w-md">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Registrasi Karyawan Pengelola Baru</h2>
        <p class="text-xs text-gray-500 mb-6">Buat akun kredensial akses masuk baru secara aman.</p>

        @if($errors->any())
            <div class="mb-4 p-2 bg-red-100 border text-red-700 rounded text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/data-admin/store" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Alamat Email Karyawan</label>
                <input type="email" name="email" class="w-full border rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="contoh: karyawan.baru@balaiiklan.co.id" required>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kata Sandi (Password)</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="pt-4 border-t flex space-x-2">
                <a href="/admin/data-admin" class="flex-1 bg-gray-100 text-center text-gray-700 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-blue-700 transition shadow-sm">Simpan Akun</button>
            </div>
        </form>
    </div>
</body>
</html>