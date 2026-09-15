<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - PT. Balai Iklan</title>
    <link rel="icon" href="{{ asset('balai_iklan.jpeg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-md border w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-[#1e3a8a] mb-2">Daftar Akun Baru</h2>
        <p class="text-center text-xs text-gray-500 mb-6">Silakan lengkapi data untuk memesan iklan</p>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 text-xs p-3 rounded mb-4">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700 block mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-teal-500 focus:border-teal-500" required>
            </div>
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700 block mb-1">Nomor Telepon</label>
                <input type="number" name="no_telp" value="{{ old('nama') }}" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-teal-500 focus:border-teal-500" required>
            </div>
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700 block mb-1">Alamat Email</label>
                <input type="email" name="email" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-teal-500 focus:border-teal-500" required>
            </div>
            <div class="mb-6">
                <label class="text-sm font-semibold text-gray-700 block mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-teal-500 focus:border-teal-500" required>
            </div>
            <button type="submit" class="w-full bg-[#1e3a8a] text-white font-bold py-2 rounded-md hover:bg-blue-900 transition text-sm">Registrasi Akun</button>
        </form>
        <p class="text-xs text-center text-gray-600 mt-4">Sudah punya akun? <a href="/login" class="text-teal-600 font-semibold hover:underline">Login di sini</a></p>
    </div>
</body>
</html>