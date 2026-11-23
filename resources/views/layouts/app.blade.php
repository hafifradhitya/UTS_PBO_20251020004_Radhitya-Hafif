<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jadwal Perkuliahan') — BAAK UCIC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-100 text-zinc-900 antialiased">
    <div class="min-h-screen">
        <header class="bg-white border-b border-zinc-200">
            <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium tracking-wide text-zinc-500">UCIC • BAAK</p>
                    <p class="text-lg font-semibold">Sistem Pengelolaan Jadwal Perkuliahan</p>
                </div>
                <nav class="flex gap-4 text-sm items-center">
                    <a href="{{ route('jadwal.dashboard') }}" class="text-zinc-600 hover:text-zinc-900">Dashboard</a>
                    <a href="{{ route('jadwal.index') }}" class="text-zinc-600 hover:text-zinc-900">Daftar Jadwal</a>
                    <a href="{{ route('jadwal.create') }}" class="rounded-md bg-emerald-600 px-3 py-2 text-white hover:bg-emerald-700">Tambah Jadwal</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="mx-auto max-w-7xl px-4 py-6 text-xs text-zinc-500">
            UTS Pemrograman Berorientasi Objek — Laravel 13 — SESSION_DRIVER=file — BAAK UCIC
        </footer>
    </div>
</body>
</html>
