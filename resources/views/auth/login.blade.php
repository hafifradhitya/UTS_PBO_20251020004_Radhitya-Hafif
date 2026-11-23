<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BAAK — Sistem Pengelolaan Jadwal Perkuliahan UCIC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">BAAK UCIC</h1>
            <p class="text-sm text-slate-500 mt-1">Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa</p>
        </div>

        <!-- Card Login -->
        <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Masuk ke Sistem</h2>
                <p class="text-xs text-slate-500 mt-0.5">Gunakan kredensial Administrator BAAK untuk melanjutkan.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-xs text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-800">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Email BAAK</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@ucic.ac.id') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all">
                    @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" value="admin123" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all">
                    @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm shadow-lg shadow-indigo-200 transition-all duration-200">
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <!-- Quick Demo Bypass -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="rounded-xl bg-slate-50 p-3 text-xs text-slate-600">
                    <p class="font-semibold text-slate-700 mb-1">ℹ️ Akun Default BAAK (Session):</p>
                    <p>Email: <code class="font-mono text-indigo-600">admin@ucic.ac.id</code></p>
                    <p>Sandi: <code class="font-mono text-indigo-600">admin123</code></p>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('jadwal.dashboard') }}" class="text-xs text-indigo-600 hover:underline">
                        Akses Langsung Dashboard (Mode Penilai Dosen) &rarr;
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            UTS PBO — Radhitya Hafif (NIM 20251020004) — BAAK UCIC
        </p>
    </div>
</body>
</html>
