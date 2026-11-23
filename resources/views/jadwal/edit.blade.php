@extends('layouts.app')

@section('title', 'Edit Jadwal ' . $jadwal['kode'])

@section('content')
    <!-- Top Action Bar -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                    {{ $jadwal['kode'] }}
                </span>
                <span class="text-xs font-medium text-slate-400">Pembaruan Jadwal</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Jadwal: {{ $jadwal['mata_kuliah'] }}</h1>
        </div>
        <a href="{{ route('jadwal.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition-colors">
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm mt-6 max-w-4xl">
        <form action="{{ route('jadwal.update', $jadwal['kode']) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Baris 1: Kode Readonly & Kelas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="kode" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kode Jadwal (Read-only)</label>
                    <input type="text" id="kode" name="kode" value="{{ old('kode', $jadwal['kode']) }}" readonly
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500 font-mono cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">Kode jadwal terkunci sebagai identitas session.</p>
                </div>
                <div>
                    <label for="kelas" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kelas Mahasiswa</label>
                    <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $jadwal['kelas']) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @error('kelas') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Baris 2: Mata Kuliah -->
            <div>
                <label for="mata_kuliah" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Mata Kuliah</label>
                <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah', $jadwal['mata_kuliah']) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                @error('mata_kuliah') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Baris 3: Dosen -->
            <div>
                <label for="dosen" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Dosen Pengampu</label>
                <input type="text" id="dosen" name="dosen" value="{{ old('dosen', $jadwal['dosen']) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                @error('dosen') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Baris 4: Hari, Jam Mulai, Jam Selesai -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="hari" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Hari Perkuliahan</label>
                    <select id="hari" name="hari" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <option value="{{ $hari }}" @selected(old('hari', $jadwal['hari']) === $hari)>{{ $hari }}</option>
                        @endforeach
                    </select>
                    @error('hari') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="jam_mulai" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jam Mulai</label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jadwal['jam_mulai']) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600 font-mono">
                    @error('jam_mulai') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="jam_selesai" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jam Selesai</label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jadwal['jam_selesai']) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600 font-mono">
                    @error('jam_selesai') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Baris 5: Ruangan & SKS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="ruangan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Ruangan / Lab</label>
                    <input type="text" id="ruangan" name="ruangan" value="{{ old('ruangan', $jadwal['ruangan']) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @error('ruangan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="sks" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Beban SKS (1-6)</label>
                    <input type="number" id="sks" name="sks" value="{{ old('sks', $jadwal['sks']) }}" min="1" max="6" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @error('sks') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Baris 6: Tipe & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="tipe" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Tipe Perkuliahan</label>
                    <select id="tipe" name="tipe" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        @foreach (['Teori','Praktikum','Daring'] as $tipe)
                            <option value="{{ $tipe }}" @selected(old('tipe', $jadwal['tipe']) === $tipe)>{{ $tipe }}</option>
                        @endforeach
                    </select>
                    @error('tipe') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Status Jadwal</label>
                    <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        @foreach (['Aktif','Dibatalkan','Selesai'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $jadwal['status']) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition-colors">
                    Perbarui Jadwal Kuliah
                </button>
                <a href="{{ route('jadwal.index') }}" class="px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
