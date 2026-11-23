@extends('layouts.app')

@section('title', 'Daftar Kelas Mahasiswa')

@section('content')
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Rombongan Belajar Mahasiswa</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Data kelas perkuliahan program studi Teknik Informatika dan beban SKS per kelas.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                Total Kelas: {{ count($kelasList) }}
            </span>
        </div>
    </div>

    @if (count($kelasList) === 0)
        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm mt-6 text-center">
            <p class="text-sm text-slate-500">Belum ada data kelas dalam jadwal perkuliahan.</p>
            <a href="{{ route('jadwal.create') }}" class="text-xs text-indigo-600 font-semibold mt-2 inline-block hover:underline">
                + Tambah jadwal untuk mendaftarkan kelas
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
            @foreach ($kelasList as $kelas)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ $kelas['nama'] }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base leading-tight">Kelas {{ $kelas['nama'] }}</h3>
                                    <p class="text-[11px] text-slate-400 mt-0.5">S-1 Teknik Informatika</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700">
                                {{ $kelas['total_sks'] }} SKS
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-3 rounded-2xl bg-slate-50 text-center mb-4">
                            <div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase">Total Matkul</p>
                                <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $kelas['total_matkul'] }} Matkul</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase">Beban Semester</p>
                                <p class="text-sm font-bold text-indigo-600 mt-0.5">{{ $kelas['total_sks'] }} SKS</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Mata Kuliah Diikuti:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                @foreach ($kelas['jadwal'] as $j)
                                    <li class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100/60">
                                        <span class="font-medium text-slate-800">{{ $j['mata_kuliah'] }}</span>
                                        <span class="font-semibold text-indigo-600 text-[11px]">{{ $j['sks'] }} SKS</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('jadwal.index', ['cari' => $kelas['nama']]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            Lihat Jadwal Kelas Ini &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
