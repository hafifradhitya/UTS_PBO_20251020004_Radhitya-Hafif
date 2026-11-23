@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">Edit Jadwal {{ $jadwal['kode'] }}</h1>
            <p class="text-sm text-zinc-500">Kode tidak dapat diubah karena dipakai sebagai identitas jadwal.</p>
        </div>
        <a href="{{ route('jadwal.index') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Kembali</a>
    </div>

    <form action="{{ route('jadwal.update', $jadwal['kode']) }}" method="POST" class="mt-4 rounded-lg border border-zinc-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="kode" class="block text-sm font-medium text-zinc-700">Kode Jadwal (Readonly)</label>
                <input type="text" id="kode" name="kode" value="{{ old('kode', $jadwal['kode']) }}" readonly class="mt-1 w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 cursor-not-allowed">
            </div>
            <div>
                <label for="kelas" class="block text-sm font-medium text-zinc-700">Kelas</label>
                <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $jadwal['kelas']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                @error('kelas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4">
            <label for="mata_kuliah" class="block text-sm font-medium text-zinc-700">Mata Kuliah</label>
            <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah', $jadwal['mata_kuliah']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
            @error('mata_kuliah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="dosen" class="block text-sm font-medium text-zinc-700">Dosen Pengampu</label>
            <input type="text" id="dosen" name="dosen" value="{{ old('dosen', $jadwal['dosen']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
            @error('dosen') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label for="hari" class="block text-sm font-medium text-zinc-700">Hari</label>
                <select id="hari" name="hari" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                        <option value="{{ $hari }}" @selected(old('hari', $jadwal['hari']) === $hari)>{{ $hari }}</option>
                    @endforeach
                </select>
                @error('hari') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-zinc-700">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jadwal['jam_mulai']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                @error('jam_mulai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-zinc-700">Jam Selesai</label>
                <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jadwal['jam_selesai']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                @error('jam_selesai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="ruangan" class="block text-sm font-medium text-zinc-700">Ruangan</label>
                <input type="text" id="ruangan" name="ruangan" value="{{ old('ruangan', $jadwal['ruangan']) }}" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                @error('ruangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="sks" class="block text-sm font-medium text-zinc-700">Beban SKS</label>
                <input type="number" id="sks" name="sks" value="{{ old('sks', $jadwal['sks']) }}" min="1" max="6" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                @error('sks') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="tipe" class="block text-sm font-medium text-zinc-700">Tipe Perkuliahan</label>
                <select id="tipe" name="tipe" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    @foreach (['Teori','Praktikum','Daring'] as $tipe)
                        <option value="{{ $tipe }}" @selected(old('tipe', $jadwal['tipe']) === $tipe)>{{ $tipe }}</option>
                    @endforeach
                </select>
                @error('tipe') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-zinc-700">Status</label>
                <select id="status" name="status" required class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    @foreach (['Aktif','Dibatalkan','Selesai'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $jadwal['status']) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Perbarui Jadwal</button>
            <a href="{{ route('jadwal.index') }}" class="rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-600 hover:bg-zinc-50">Batal</a>
        </div>
    </form>
@endsection
