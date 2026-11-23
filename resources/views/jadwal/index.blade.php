@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">Daftar Jadwal</h1>
            <p class="text-sm text-zinc-500">Kelola jadwal perkuliahan BAAK. Gunakan filter untuk mencari jadwal.</p>
        </div>
        <a href="{{ route('jadwal.create') }}" class="rounded-md bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700">Tambah Jadwal</a>
    </div>

    <form method="GET" action="{{ route('jadwal.index') }}" class="mt-4 flex flex-wrap gap-2">
        <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari kode, mata kuliah, atau dosen" class="w-64 rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white">
        <select name="hari" class="rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white">
            <option value="">Semua Hari</option>
            @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                <option value="{{ $hari }}" @selected($filterHari === $hari)>{{ $hari }}</option>
            @endforeach
        </select>
        <select name="tipe" class="rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white">
            <option value="">Semua Tipe</option>
            @foreach (['Teori','Praktikum','Daring'] as $tipe)
                <option value="{{ $tipe }}" @selected($filterTipe === $tipe)>{{ $tipe }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm hover:bg-zinc-50">Filter</button>
        <a href="{{ route('jadwal.index') }}" class="rounded-md px-3 py-2 text-sm text-zinc-600 hover:text-zinc-900">Reset</a>
    </form>

    @if (count($jadwals) === 0)
        <div class="mt-6 rounded-lg border border-zinc-200 bg-white px-4 py-8 text-center">
            <p class="text-sm text-zinc-600">Belum ada jadwal yang sesuai filter.</p>
            <a href="{{ route('jadwal.create') }}" class="mt-2 inline-block text-sm text-emerald-700 hover:underline">Tambah jadwal baru</a>
        </div>
    @else
        <div class="mt-4 overflow-x-auto rounded-lg border border-zinc-200 bg-white">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Kode</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Mata Kuliah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Dosen</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Hari</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Jam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Ruangan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">SKS</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Tipe</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($jadwals as $jadwal)
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $jadwal['kode'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['mata_kuliah'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['dosen'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['hari'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['ruangan'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['kelas'] }}</td>
                            <td class="px-4 py-2">{{ $jadwal['sks'] }}</td>
                            <td class="px-4 py-2">
                                @if ($jadwal['tipe'] === 'Teori')
                                    <span class="rounded border border-blue-200 bg-blue-50 px-2 py-0.5 text-xs text-blue-700">Teori</span>
                                @elseif ($jadwal['tipe'] === 'Praktikum')
                                    <span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700">Praktikum</span>
                                @else
                                    <span class="rounded border border-violet-200 bg-violet-50 px-2 py-0.5 text-xs text-violet-700">Daring</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if ($jadwal['status'] === 'Aktif')
                                    <span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700">Aktif</span>
                                @elseif ($jadwal['status'] === 'Dibatalkan')
                                    <span class="rounded border border-amber-200 bg-amber-50 px-2 py-0.5 text-xs text-amber-700">Dibatalkan</span>
                                @else
                                    <span class="rounded border border-zinc-200 bg-zinc-100 px-2 py-0.5 text-xs text-zinc-700">Selesai</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <a href="{{ route('jadwal.show', $jadwal['kode']) }}" class="text-emerald-700 hover:underline">Detail</a>
                                <a href="{{ route('jadwal.edit', $jadwal['kode']) }}" class="ml-2 text-zinc-700 hover:underline">Edit</a>
                                <form action="{{ route('jadwal.destroy', $jadwal['kode']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
