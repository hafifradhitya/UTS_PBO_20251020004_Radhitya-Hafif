@extends('layouts.app')

@section('title', 'Detail Jadwal ' . $jadwal['kode'])

@section('content')
    <!-- Top Action Bar -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                    {{ $jadwal['kode'] }}
                </span>
                <span class="text-xs font-medium text-slate-400">Rincian Jadwal Kuliah</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $jadwal['mata_kuliah'] }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('jadwal.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                Kembali ke Daftar
            </a>
            <a href="{{ route('jadwal.edit', $jadwal['kode']) }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium shadow-md shadow-indigo-100 transition-colors">
                Edit Jadwal Ini
            </a>
        </div>
    </div>

    <!-- 11 Field Grid Details Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm mt-6">
        <h2 class="text-base font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">
            Informasi Lengkap Perkuliahan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kode Jadwal</p>
                <p class="text-base font-bold text-indigo-600 mt-1">{{ $jadwal['kode'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Mata Kuliah</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['mata_kuliah'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Dosen Pengampu</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['dosen'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Hari Perkuliahan</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['hari'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jam Pelaksanaan</p>
                <p class="text-base font-bold text-slate-900 mt-1 font-mono">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }} WIB</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Ruangan / Lab</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['ruangan'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kelas Mahasiswa</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['kelas'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Beban SKS</p>
                <p class="text-base font-bold text-slate-900 mt-1">{{ $jadwal['sks'] }} SKS</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tipe Perkuliahan</p>
                <div class="mt-1">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $jadwal['tipe'] === 'Teori' ? 'bg-indigo-50 text-indigo-700' : ($jadwal['tipe'] === 'Praktikum' ? 'bg-emerald-50 text-emerald-700' : 'bg-violet-50 text-violet-700') }}">
                        {{ $jadwal['tipe'] }}
                    </span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status Jadwal</p>
                <div class="mt-1">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $jadwal['status'] === 'Aktif' ? 'bg-emerald-50 text-emerald-700' : ($jadwal['status'] === 'Dibatalkan' ? 'bg-rose-50 text-rose-700' : 'bg-slate-200 text-slate-700') }}">
                        {{ $jadwal['status'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
