@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">Detail Jadwal</h1>
            <p class="text-sm text-zinc-500">Informasi lengkap jadwal perkuliahan.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('jadwal.index') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Kembali ke Daftar</a>
            <a href="{{ route('jadwal.edit', $jadwal['kode']) }}" class="rounded-md bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700">Edit Jadwal</a>
        </div>
    </div>

    <div class="mt-4 rounded-lg border border-zinc-200 bg-white p-6 text-sm">
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Kode Jadwal</dt>
                <dd class="mt-1 font-semibold text-zinc-900">{{ $jadwal['kode'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Mata Kuliah</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['mata_kuliah'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Dosen Pengampu</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['dosen'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Hari Perkuliahan</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['hari'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Waktu / Jam</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }} WIB</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Ruangan</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['ruangan'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Kelas</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['kelas'] }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Beban SKS</dt>
                <dd class="mt-1 text-zinc-900">{{ $jadwal['sks'] }} SKS</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Tipe Perkuliahan</dt>
                <dd class="mt-1">
                    @if ($jadwal['tipe'] === 'Teori')
                        <span class="rounded border border-blue-200 bg-blue-50 px-2 py-0.5 text-xs text-blue-700">Teori</span>
                    @elseif ($jadwal['tipe'] === 'Praktikum')
                        <span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700">Praktikum</span>
                    @else
                        <span class="rounded border border-violet-200 bg-violet-50 px-2 py-0.5 text-xs text-violet-700">Daring</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Status Jadwal</dt>
                <dd class="mt-1">
                    @if ($jadwal['status'] === 'Aktif')
                        <span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700">Aktif</span>
                    @elseif ($jadwal['status'] === 'Dibatalkan')
                        <span class="rounded border border-amber-200 bg-amber-50 px-2 py-0.5 text-xs text-amber-700">Dibatalkan</span>
                    @else
                        <span class="rounded border border-zinc-200 bg-zinc-100 px-2 py-0.5 text-xs text-zinc-700">Selesai</span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>
@endsection
