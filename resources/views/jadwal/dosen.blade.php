@extends('layouts.app')

@section('title', 'Direktori Dosen Pengampu')

@section('content')
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Direktori Dosen Pengampu</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Data beban pengajaran dosen yang terdaftar aktif dalam jadwal perkuliahan semester ini.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                Total Dosen: {{ count($dosenList) }}
            </span>
        </div>
    </div>

    @if (count($dosenList) === 0)
        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm mt-6 text-center">
            <p class="text-sm text-slate-500">Belum ada data dosen dalam jadwal perkuliahan.</p>
            <a href="{{ route('jadwal.create') }}" class="text-xs text-indigo-600 font-semibold mt-2 inline-block hover:underline">
                + Tambah jadwal untuk memasukkan data dosen
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
            @foreach ($dosenList as $dosen)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($dosen['nama'], 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm leading-tight">{{ $dosen['nama'] }}</h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">Dosen Pengampu TI</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-3 rounded-2xl bg-slate-50 text-center mb-4">
                            <div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase">Mata Kuliah</p>
                                <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $dosen['total_matkul'] }} Kelas</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase">Total Beban</p>
                                <p class="text-sm font-bold text-indigo-600 mt-0.5">{{ $dosen['total_sks'] }} SKS</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Mata Kuliah Diampu:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                @foreach ($dosen['matkul'] as $mk)
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                        <span>{{ $mk }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('jadwal.index', ['cari' => $dosen['nama']]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            Lihat di Jadwal &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
