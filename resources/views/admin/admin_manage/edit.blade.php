<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Ubah Data Kredensial Karyawan - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 p-8 flex justify-center items-center min-h-screen">
    <div class="bg-white border rounded-xl shadow-md p-6 w-full max-w-md">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Perbarui Data Akun Karyawan</h2>
        <p class="text-xs text-gray-500 mb-6">Ubah email akses pengelola atau ganti kata sandi penunjang keamanan internal.</p>

        @if($errors->any())
            <div class="mb-4 p-2 bg-red-100 border text-red-700 rounded text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/data-admin/{{ $admin_data->id }}/update" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Alamat Email Terdaftar</label>
                <input type="email" name="email" value="{{ $admin_data->email }}" class="w-full border rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kata Sandi Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Isi hanya jika ingin mengubah sandi lama">
            </div>
            <div class="pt-4 border-t flex space-x-2">
                <a href="/admin/data-admin" class="flex-1 bg-gray-100 text-center text-gray-700 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Kembali</a>
                <button type="submit" class="flex-1 bg-yellow-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-yellow-700 transition shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>