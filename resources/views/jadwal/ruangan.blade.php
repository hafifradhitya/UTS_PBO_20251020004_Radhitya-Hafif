@extends('layouts.app')

@section('title', 'Alokasi Ruangan & Laboratorium')

@section('content')
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Alokasi Ruangan & Laboratorium</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Distribusi pemanfaatan ruang kelas teori dan laboratorium komputer di kampus UCIC.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                Total Ruangan Terjadwal: {{ count($ruanganList) }}
            </span>
        </div>
    </div>

    @if (count($ruanganList) === 0)
        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm mt-6 text-center">
            <p class="text-sm text-slate-500">Belum ada ruangan yang terjadwal.</p>
            <a href="{{ route('jadwal.create') }}" class="text-xs text-indigo-600 font-semibold mt-2 inline-block hover:underline">
                + Tambah jadwal untuk mengalokasikan ruangan
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
            @foreach ($ruanganList as $ruangan)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $ruangan['nama'] }}</h3>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Gedung Akademik UCIC</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700">
                                {{ $ruangan['total_sesi'] }} Sesi
                            </span>
                        </div>

                        <div class="space-y-2 mt-4 pt-3 border-t border-slate-100">
                            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Jadwal Sesi di Ruang Ini:</p>
                            @foreach ($ruangan['jadwal'] as $j)
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100/80 text-xs">
                                    <p class="font-bold text-slate-800">{{ $j['mata_kuliah'] }}</p>
                                    <div class="flex items-center justify-between text-slate-500 text-[11px] mt-1">
                                        <span>{{ $j['hari'] }}, {{ $j['jam_mulai'] }}-{{ $j['jam_selesai'] }}</span>
                                        <span class="font-semibold text-indigo-600">{{ $j['kelas'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('jadwal.index', ['cari' => $ruangan['nama']]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            Filter Ruangan Ini &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
