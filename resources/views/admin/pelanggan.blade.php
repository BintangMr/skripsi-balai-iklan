<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Data Pelanggan Terdaftar - PT. Balai Iklan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-[#1a2235] text-gray-300 flex flex-col justify-between h-full shadow-lg">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-700 mb-4">
                <span class="text-white font-bold tracking-widest text-sm">ADMIN PANEL</span>
            </div>
            <nav class="space-y-1 px-3">
                <a href="/dashboard-admin" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('dashboard-admin') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="/admin/pelanggan" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('admin/pelanggan*') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Data Pelanggan
                </a>
                <a href="/admin/data-admin" class="flex items-center px-4 py-3 text-sm rounded-lg transition {{ request()->is('admin/data-admin*') ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Data Karyawan
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-3"><div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">A</div>
                <div class="text-xs"><p class="text-white font-bold">Admin Staf</p><p class="text-gray-400">PT. Balai Iklan</p></div>
            </div>
            <a href="/logout" class="text-red-400 hover:text-red-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-xs font-bold">{{ session('success') }}</div>
        @endif

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Database Master Pelanggan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola data pelanggan dan eliminasi akun yang sudah tidak aktif menggunakan kontrol penuh.</p>
        </div>

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-800 text-slate-200 font-bold uppercase tracking-wider border-b text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Nama Lengkap / Instansi</th>
                        <th class="py-3.5 px-6">Nomor Telepon</th>
                        <th class="py-3.5 px-6">Alamat Email</th>
                        <th class="py-3.5 px-6 text-center">Terakhir Login</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pelanggan_sistem as $plg)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3.5 px-6 font-bold text-gray-900">{{ $plg->nama }}</td>
                        <td class="py-3.5 px-6 text-gray-600 font-semibold">{{ $plg->no_telp }}</td>
                        <td class="py-3.5 px-6 text-blue-600 font-medium">{{ $plg->email }}</td>
                        <td class="py-3.5 px-6 text-center text-gray-500 font-medium">
                            {{ $plg->last_login_at ? \Carbon\Carbon::parse($plg->last_login_at)->format('d M Y, H:i') . ' WIB' : 'Belum Pernah Login' }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-8 text-center text-gray-400 font-semibold">Belum ada pelanggan terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>