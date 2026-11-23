@extends('layouts.app')

@section('title', 'Daftar Jadwal Kuliah')

@section('content')
    <!-- Header Page -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Jadwal Perkuliahan Mahasiswa</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola dan pantau seluruh jadwal akademik BAAK UCIC semester berjalan.
            </p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <form action="{{ route('jadwal.reset') }}" method="POST" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Muat ulang 8 jadwal resmi perkuliahan UCIC?')" class="px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors" title="Reset & Muat 8 Data Resmi UCIC">
                    Muat 8 Jadwal Resmi UCIC
                </button>
            </form>
            <a href="{{ route('jadwal.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-5 py-2.5 rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-200 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar Form (HTTP GET) -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm mt-6">
        <form method="GET" action="{{ route('jadwal.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari kode, matkul, atau dosen..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <select name="hari" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <option value="">Semua Hari</option>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}" @selected($filterHari === $hari)>{{ $hari }}</option>
                @endforeach
            </select>

            <select name="tipe" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <option value="">Semua Tipe</option>
                @foreach (['Teori','Praktikum','Daring'] as $tipe)
                    <option value="{{ $tipe }}" @selected($filterTipe === $tipe)>{{ $tipe }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs transition-colors">
                Terapkan Filter
            </button>

            @if ($cari || $filterHari || $filterTipe)
                <a href="{{ route('jadwal.index') }}" class="px-4 py-2.5 rounded-xl text-xs text-slate-500 hover:text-slate-800 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table or Empty State Card -->
    @if (count($jadwals) === 0)
        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm mt-6 text-center">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum ada jadwal yang sesuai filter.</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                Silakan ubah filter pencarian Anda atau tambahkan jadwal perkuliahan baru ke dalam sistem.
            </p>
            <a href="{{ route('jadwal.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-md shadow-indigo-100">
                + Tambah Jadwal Baru
            </a>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm mt-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-5">Kode</th>
                            <th class="py-4 px-4">Mata Kuliah</th>
                            <th class="py-4 px-4">Dosen Pengampu</th>
                            <th class="py-4 px-3">Hari</th>
                            <th class="py-4 px-3">Waktu</th>
                            <th class="py-4 px-3">Ruangan</th>
                            <th class="py-4 px-3">Kelas</th>
                            <th class="py-4 px-3">SKS</th>
                            <th class="py-4 px-3">Tipe</th>
                            <th class="py-4 px-3">Status</th>
                            <th class="py-4 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-5 font-bold text-indigo-600 text-xs">{{ $jadwal['kode'] }}</td>
                                <td class="py-4 px-4 font-medium text-slate-900">{{ $jadwal['mata_kuliah'] }}</td>
                                <td class="py-4 px-4 text-xs text-slate-600">{{ $jadwal['dosen'] }}</td>
                                <td class="py-4 px-3 text-xs text-slate-600 font-medium">{{ $jadwal['hari'] }}</td>
                                <td class="py-4 px-3 text-xs text-slate-600 font-mono">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</td>
                                <td class="py-4 px-3 text-xs text-slate-600">{{ $jadwal['ruangan'] }}</td>
                                <td class="py-4 px-3 text-xs font-semibold text-slate-700">{{ $jadwal['kelas'] }}</td>
                                <td class="py-4 px-3 text-xs text-slate-600">{{ $jadwal['sks'] }} SKS</td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold {{ $jadwal['tipe'] === 'Teori' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : ($jadwal['tipe'] === 'Praktikum' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-violet-50 text-violet-700 border border-violet-100') }}">
                                        {{ $jadwal['tipe'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold {{ $jadwal['status'] === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($jadwal['status'] === 'Dibatalkan' ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                        {{ $jadwal['status'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap text-xs space-x-2">
                                    <a href="{{ route('jadwal.show', $jadwal['kode']) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                        Detail
                                    </a>
                                    <a href="{{ route('jadwal.edit', $jadwal['kode']) }}" class="font-medium text-slate-600 hover:text-slate-900">
                                        Edit
                                    </a>
                                    <form action="{{ route('jadwal.destroy', $jadwal['kode']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-rose-600 hover:text-rose-800">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
