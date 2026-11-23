@extends('layouts.app')

@section('title', 'Dashboard Jadwal')

@section('content')
    <!-- Top Welcome Banner Card (Persis Seperti Screenshot) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                    Dashboard Jadwal
                </span>
                <span class="text-xs font-medium text-slate-400">Ringkasan Operasional BAAK</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 flex items-center gap-2">
                Welcome Back, Admin <span class="text-2xl">👋</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa BAAK UCIC. Pantau seluruh jadwal perkuliahan hari {{ $hariIni }}.
            </p>
        </div>
        <a href="{{ route('jadwal.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-5 py-3 rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-200 shrink-0 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Jadwal Baru</span>
        </a>
    </div>

    <!-- 4 Metric Cards Grid (Sesuai Layout Screenshot) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6">
        <!-- Card 1: Total Jadwal -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400">Total Jadwal</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $total }}</h3>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[11px] font-semibold text-emerald-600 flex items-center">
                        <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +12.4%
                    </span>
                    <span class="text-[11px] text-slate-400">vs semester lalu</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Jadwal Aktif -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400">Jadwal Aktif</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $aktif }}</h3>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[11px] font-semibold text-emerald-600 flex items-center">
                        <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +8.2%
                    </span>
                    <span class="text-[11px] text-slate-400">status operasional</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Jadwal Hari Ini -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400">Jadwal Hari {{ $hariIni }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ count($jadwalHariIni) }}</h3>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[11px] font-semibold text-cyan-600">Sesi Aktif</span>
                    <span class="text-[11px] text-slate-400">hari ini</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Total Beban SKS -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400">Beban SKS Terjadwal</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalSks }}</h3>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[11px] font-semibold text-emerald-600">Akademik TI</span>
                    <span class="text-[11px] text-slate-400">total kredit</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Middle Analytics & Category Distribution Grid (Persis Seperti Screenshot) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-6">
        <!-- Card Kiri: Distribusi Jadwal Perkuliahan Mingguan (2/3 width) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Distribusi Sesi Kuliah Mingguan</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Visualisasi beban perkuliahan mahasiswa Senin hingga Sabtu</p>
                </div>
                <div class="flex items-center gap-1 bg-slate-50 p-1 rounded-xl text-[11px] font-medium text-slate-500">
                    <span class="px-2.5 py-1 rounded-lg bg-white shadow-xs text-indigo-600 font-semibold">Weekly</span>
                    <span class="px-2.5 py-1">Semester 3</span>
                </div>
            </div>

            <!-- Visual Bar Chart Antarmuka -->
            <div class="h-56 flex items-end justify-between gap-3 pt-6 border-b border-slate-100 pb-4">
                @php
                    $maxCount = max(array_values($distribusiHari)) ?: 1;
                @endphp
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                    @php
                        $count = $distribusiHari[$hari] ?? 0;
                        $percent = round(($count / $maxCount) * 100);
                        $heightPercent = max($percent, 12);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                        <span class="text-[11px] font-semibold text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $count }} sesi</span>
                        <div class="w-full max-w-[48px] rounded-2xl bg-gradient-to-t from-indigo-600 to-indigo-400 transition-all duration-300 group-hover:from-indigo-700 group-hover:to-indigo-500 shadow-sm" style="height: {{ $heightPercent }}%;"></div>
                        <span class="text-xs font-medium text-slate-500 mt-1">{{ substr($hari, 0, 3) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center justify-between mt-4 text-xs text-slate-400">
                <span>Total Jadwal Aktif: <strong class="text-slate-700">{{ $aktif }} sesi</strong></span>
                <span>Kapasitas Perkuliahan Normal</span>
            </div>
        </div>

        <!-- Card Kanan: Category Distribution (Donut Chart Visual) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Distribusi Tipe Sesi</h2>
                <p class="text-xs text-slate-400 mt-0.5">Klasifikasi metode pelaksanaan kuliah BAAK</p>
            </div>

            <!-- Circular Donut Visual -->
            <div class="my-6 flex items-center justify-center">
                <div class="relative w-40 h-40 rounded-full flex items-center justify-center"
                     style="background: conic-gradient(
                         #4f46e5 0% {{ $total ? round(($perTipe['Teori'] / $total) * 100) : 33 }}%,
                         #10b981 {{ $total ? round(($perTipe['Teori'] / $total) * 100) : 33 }}% {{ $total ? round((($perTipe['Teori'] + $perTipe['Praktikum']) / $total) * 100) : 66 }}%,
                         #8b5cf6 {{ $total ? round((($perTipe['Teori'] + $perTipe['Praktikum']) / $total) * 100) : 66 }}% 100%
                     );">
                    <!-- Inner Hole -->
                    <div class="w-28 h-28 rounded-full bg-white flex flex-col items-center justify-center shadow-inner">
                        <span class="text-2xl font-extrabold text-slate-900">{{ $total }}</span>
                        <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Total Sesi</span>
                    </div>
                </div>
            </div>

            <!-- Legend Pills -->
            <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-100 text-center">
                <div class="p-2 rounded-xl bg-indigo-50/50">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span class="text-[11px] font-semibold text-indigo-700">Teori</span>
                    </div>
                    <p class="text-xs font-bold text-slate-800">{{ $perTipe['Teori'] }}</p>
                </div>
                <div class="p-2 rounded-xl bg-emerald-50/50">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[11px] font-semibold text-emerald-700">Praktik</span>
                    </div>
                    <p class="text-xs font-bold text-slate-800">{{ $perTipe['Praktikum'] }}</p>
                </div>
                <div class="p-2 rounded-xl bg-violet-50/50">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                        <span class="text-[11px] font-semibold text-violet-700">Daring</span>
                    </div>
                    <p class="text-xs font-bold text-slate-800">{{ $perTipe['Daring'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Tables Grid -->
    <div class="mt-6 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-bold text-slate-900">Agenda Perkuliahan Hari {{ $hariIni }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">Daftar kelas yang sedang dan akan berjalan di kampus UCIC hari ini</p>
            </div>
            <a href="{{ route('jadwal.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                Lihat Seluruh Jadwal &rarr;
            </a>
        </div>

        @if (count($jadwalHariIni) === 0)
            <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center bg-slate-50">
                <p class="text-sm text-slate-500">Tidak ada agenda kuliah untuk hari {{ $hariIni }}.</p>
                <a href="{{ route('jadwal.index') }}" class="text-xs font-semibold text-indigo-600 mt-1 inline-block hover:underline">
                    Periksa jadwal di hari lainnya &rarr;
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3">Kode</th>
                            <th class="pb-3">Mata Kuliah</th>
                            <th class="pb-3">Dosen</th>
                            <th class="pb-3">Jam Kuliah</th>
                            <th class="pb-3">Ruangan</th>
                            <th class="pb-3">Tipe</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($jadwalHariIni as $jadwal)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 font-bold text-indigo-600 text-xs">{{ $jadwal['kode'] }}</td>
                                <td class="py-3.5 font-medium text-slate-800">{{ $jadwal['mata_kuliah'] }}</td>
                                <td class="py-3.5 text-slate-500 text-xs">{{ $jadwal['dosen'] }}</td>
                                <td class="py-3.5 text-slate-600 text-xs">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</td>
                                <td class="py-3.5 text-slate-600 text-xs">{{ $jadwal['ruangan'] }}</td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-semibold {{ $jadwal['tipe'] === 'Teori' ? 'bg-indigo-50 text-indigo-700' : ($jadwal['tipe'] === 'Praktikum' ? 'bg-emerald-50 text-emerald-700' : 'bg-violet-50 text-violet-700') }}">
                                        {{ $jadwal['tipe'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('jadwal.show', $jadwal['kode']) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
