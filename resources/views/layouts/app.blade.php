<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jadwal Perkuliahan') — BAAK UCIC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar Kiri (Inspirasi Desain NexusMarket Control Center) -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between shrink-0 fixed inset-y-0 z-30">
            <div>
                <!-- Brand / Logo Header -->
                <div class="p-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md shadow-indigo-200 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-base text-slate-900 leading-tight">UCIC BAAK</h1>
                        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">Control Center</p>
                    </div>
                </div>

                <!-- Navigation List -->
                <div class="px-4 py-2">
                    <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Navigation</p>
                    <nav class="space-y-1 text-sm font-medium">
                        <!-- Overview / Dashboard -->
                        <a href="{{ route('jadwal.dashboard') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Overview</span>
                        </a>

                        <!-- Jadwal Perkuliahan -->
                        <a href="{{ route('jadwal.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.index') || request()->routeIs('jadwal.show') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Jadwal Kuliah</span>
                        </a>

                        <!-- Tambah Jadwal -->
                        <a href="{{ route('jadwal.create') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah Jadwal</span>
                        </a>

                        <!-- Data Dosen (Modul Ekstra) -->
                        <a href="{{ route('jadwal.dosen') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.dosen') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Direktori Dosen</span>
                        </a>

                        <!-- Alokasi Ruangan (Modul Ekstra) -->
                        <a href="{{ route('jadwal.ruangan') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.ruangan') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Ruangan & Lab</span>
                        </a>

                        <!-- Data Kelas (Modul Ekstra) -->
                        <a href="{{ route('jadwal.kelas') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('jadwal.kelas') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Daftar Kelas</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Bottom Node Info Card (Persis Seperti Screenshot) -->
            <div class="p-4 border-t border-slate-100">
                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100 text-xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-semibold text-slate-700 text-[11px] tracking-wide">STATUS: ONLINE</span>
                    </div>
                    <p class="text-slate-500 text-[11px]">Admin Node: <span class="font-mono text-slate-700">#UCIC-BAAK</span></p>
                    <p class="text-slate-400 text-[10px] mt-0.5">Driver: SESSION_DRIVER=file</p>
                </div>
            </div>
        </aside>

        <!-- Konten Utama + Topbar (Offset margin-left sesuai lebar sidebar) -->
        <div class="flex-1 ml-64 flex flex-col min-w-0">
            <!-- Topbar Header -->
            <header class="h-16 bg-white/90 backdrop-blur border-b border-slate-200 sticky top-0 z-20 px-8 flex items-center justify-between">
                <!-- Global Search Input -->
                <div class="flex items-center gap-3 w-96">
                    <form action="{{ route('jadwal.index') }}" method="GET" class="w-full relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="cari" placeholder="Global catalog search..."
                               class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all">
                    </form>
                </div>

                <!-- Topbar Actions & Profile -->
                <div class="flex items-center gap-4">
                    <!-- Notification Dropdown (DaisyUI Interactive) -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors relative cursor-pointer" title="Notifikasi BAAK">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notif-badge" class="w-2.5 h-2.5 rounded-full bg-rose-500 absolute top-1.5 right-1.5 ring-2 ring-white"></span>
                        </div>
                        <div tabindex="0" class="dropdown-content z-30 card card-compact w-80 p-0 shadow-2xl bg-white border border-slate-200 rounded-2xl mt-3">
                            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-slate-800">Pemberitahuan BAAK</span>
                                    <span id="notif-count" class="text-[10px] font-semibold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full">3 Baru</span>
                                </div>
                                <button type="button" onclick="document.getElementById('notif-badge')?.classList.add('hidden'); document.getElementById('notif-count')?.classList.add('hidden');" class="text-[11px] text-indigo-600 hover:underline font-medium">
                                    Tandai dibaca
                                </button>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                                <div class="p-3.5 hover:bg-slate-50 transition-colors flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Sistem Session File Aktif</p>
                                        <p class="text-slate-500 mt-0.5">Penyimpanan jadwal beroperasi normal via SESSION_DRIVER=file.</p>
                                        <span class="text-[10px] text-slate-400 mt-1 inline-block">Baru saja</span>
                                    </div>
                                </div>
                                <div class="p-3.5 hover:bg-slate-50 transition-colors flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500 mt-1.5 shrink-0"></span>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Kalender Akademik UCIC</p>
                                        <p class="text-slate-500 mt-0.5">Jadwal perkuliahan semester ganjil aktif dipantau BAAK.</p>
                                        <span class="text-[10px] text-slate-400 mt-1 inline-block">10 menit lalu</span>
                                    </div>
                                </div>
                                <div class="p-3.5 hover:bg-slate-50 transition-colors flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Alokasi Ruang Lab</p>
                                        <p class="text-slate-500 mt-0.5">Lab 1 dan Lab 2 telah dipetakan untuk sesi praktikum.</p>
                                        <span class="text-[10px] text-slate-400 mt-1 inline-block">1 jam lalu</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-slate-50 border-t border-slate-100 rounded-b-2xl text-center">
                                <a href="{{ route('jadwal.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Buka Pengelolaan Jadwal &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile & Session Auth -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold text-xs shadow-sm">
                            RH
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-semibold text-slate-800 leading-none">Radhitya Hafif</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">BAAK Administrator</p>
                        </div>

                        <!-- Tombol Logout / Login Sesi -->
                        @if (session('is_logged_in'))
                            <form action="{{ route('logout') }}" method="POST" class="inline ml-1">
                                @csrf
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-medium px-2 py-1 rounded-lg hover:bg-rose-50 transition-colors" title="Keluar Sesi">
                                    Keluar
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium px-2 py-1 rounded-lg hover:bg-indigo-50 transition-colors">
                                Masuk
                            </a>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Main Content Canvas -->
            <main class="flex-1 p-8">
                <!-- Flash Alerts -->
                @if (session('success'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-3.5 text-sm text-emerald-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 px-5 py-3.5 text-sm text-rose-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="px-8 py-5 text-xs text-slate-400 border-t border-slate-200 bg-white flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>UTS Pemrograman Berorientasi Objek — Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa (BAAK UCIC)</p>
                <p class="font-mono text-[11px]">Laravel 13 • DaisyUI • SESSION_DRIVER=file</p>
            </footer>
        </div>
    </div>
</body>
</html>
