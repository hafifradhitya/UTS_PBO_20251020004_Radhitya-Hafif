@extends('layouts.app')

@section('title', 'Dashboard Jadwal')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">Dashboard Jadwal</h1>
            <p class="text-sm text-zinc-500">Ringkasan jadwal hari {{ $hariIni }} dan seluruh jadwal BAAK.</p>
        </div>
        <a href="{{ route('jadwal.create') }}" class="rounded-md bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700">Tambah Jadwal</a>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-zinc-200 bg-white p-4">
            <p class="text-xs text-zinc-500">Total Jadwal</p>
            <p class="mt-1 text-2xl font-semibold">{{ $total }}</p>
            <p class="text-xs text-zinc-500">Seluruh jadwal yang tersimpan di session</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white p-4">
            <p class="text-xs text-zinc-500">Jadwal Aktif</p>
            <p class="mt-1 text-2xl font-semibold">{{ $aktif }}</p>
            <p class="text-xs text-zinc-500">Status Aktif dari total {{ $total }} jadwal</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white p-4">
            <p class="text-xs text-zinc-500">Jadwal Hari {{ $hariIni }}</p>
            <p class="mt-1 text-2xl font-semibold">{{ count($jadwalHariIni) }}</p>
            <p class="text-xs text-zinc-500">Teori {{ $perTipe['Teori'] }} • Praktikum {{ $perTipe['Praktikum'] }} • Daring {{ $perTipe['Daring'] }}</p>
        </div>
    </div>

    <div class="mt-6 rounded-lg border border-zinc-200 bg-white">
        <div class="border-b border-zinc-200 px-4 py-3">
            <h2 class="text-sm font-semibold">Jadwal Hari {{ $hariIni }}</h2>
        </div>
        @if (count($jadwalHariIni) === 0)
            <p class="px-4 py-6 text-sm text-zinc-500">Tidak ada jadwal hari {{ $hariIni }}. Lihat daftar lengkap di halaman Daftar Jadwal.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500">Kode</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500">Jam</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500">Ruangan</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($jadwalHariIni as $jadwal)
                            <tr>
                                <td class="px-4 py-2 font-medium">{{ $jadwal['kode'] }}</td>
                                <td class="px-4 py-2">{{ $jadwal['mata_kuliah'] }}</td>
                                <td class="px-4 py-2">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</td>
                                <td class="px-4 py-2">{{ $jadwal['ruangan'] }}</td>
                                <td class="px-4 py-2"><a href="{{ route('jadwal.show', $jadwal['kode']) }}" class="text-emerald-700 hover:underline">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
