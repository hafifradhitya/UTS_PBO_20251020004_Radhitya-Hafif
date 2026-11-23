@extends('layouts.app')

@section('title', 'Tambah Jadwal Kuliah')

@section('content')
    <!-- Top Action Bar -->
    <div
    class="
    bg-white
    rounded-3xl
    p-6
    sm:p-8
    border
    border-slate-200
    shadow-sm
    flex
    flex-col
    sm:flex-row
    sm:items-center
    justify-between
    gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Tambah Jadwal Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Lengkapi seluruh parameter perkuliahan BAAK. Kode jadwal bertindak sebagai identifier unik.
            </p>
        </div>
        <a
        href="{{ route('jadwal.index') }}"
        class="
        px-4
        py-2.5
        rounded-xl
        border
        border-slate-200
        text-xs
        font-medium
        text-slate-600
        hover:bg-slate-50
        transition-colors">
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container -->
    <div
    class="
    bg-white
    rounded-3xl
    p-6
    sm:p-8
    border
    border-slate-200
    shadow-sm
    mt-6
    max-w-4xl">
        <form
        action="{{ route('jadwal.store') }}"
        method="POST"
        class="space-y-6">
            @csrf

            <!-- Baris 1: Kode & Kelas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label
                    for="kode"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Kode Jadwal (Unik)
                    </label>
                    <input
                    type="text"
                    id="kode"
                    name="kode"
                    value="{{ old('kode') }}"
                    placeholder="Contoh: JDW001"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                    @error('kode')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label
                    for="kelas"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Kelas Mahasiswa
                    </label>
                    <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas') }}"
                    placeholder="Contoh: TI-3A"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                    @error('kelas')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 2: Mata Kuliah -->
            <div>
                <label
                for="mata_kuliah"
                class="
                block
                text-xs
                font-semibold
                text-slate-700
                uppercase
                tracking-wider
                mb-2">
                    Nama Mata Kuliah
                </label>
                <input
                type="text"
                id="mata_kuliah"
                name="mata_kuliah"
                value="{{ old('mata_kuliah') }}"
                placeholder="Contoh: Pemrograman Berorientasi Objek"
                required
                class="
                w-full
                px-4
                py-3
                rounded-xl
                border
                border-slate-200
                text-sm
                focus:outline-none
                focus:ring-2
                focus:ring-indigo-600">
                @error('mata_kuliah')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Baris 3: Dosen -->
            <div>
                <label
                for="dosen"
                class="
                block
                text-xs
                font-semibold
                text-slate-700
                uppercase
                tracking-wider
                mb-2">
                    Dosen Pengampu
                </label>
                <input
                type="text"
                id="dosen"
                name="dosen"
                value="{{ old('dosen') }}"
                placeholder="Contoh: Hilman Lesmana, S.T., M.S.F."
                required
                class="
                w-full
                px-4
                py-3
                rounded-xl
                border
                border-slate-200
                text-sm
                focus:outline-none
                focus:ring-2
                focus:ring-indigo-600">
                @error('dosen')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Baris 4: Hari, Jam Mulai, Jam Selesai -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label
                    for="hari"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Hari Perkuliahan
                    </label>
                    <select
                    id="hari"
                    name="hari"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                        <option value="">Pilih Hari</option>
                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <option value="{{ $hari }}" @selected(old('hari') === $hari)>{{ $hari }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label
                    for="jam_mulai"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Jam Mulai
                    </label>
                    <input
                    type="time"
                    id="jam_mulai"
                    name="jam_mulai"
                    value="{{ old('jam_mulai') }}"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600
                    font-mono">
                    @error('jam_mulai')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label
                    for="jam_selesai"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Jam Selesai
                    </label>
                    <input
                    type="time"
                    id="jam_selesai"
                    name="jam_selesai"
                    value="{{ old('jam_selesai') }}"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600
                    font-mono">
                    @error('jam_selesai')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 5: Ruangan & SKS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label
                    for="ruangan"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Ruangan / Lab
                    </label>
                    <input
                    type="text"
                    id="ruangan"
                    name="ruangan"
                    value="{{ old('ruangan') }}"
                    placeholder="Contoh: Lab 1"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                    @error('ruangan')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label
                    for="sks"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Beban SKS (1-6)
                    </label>
                    <input
                    type="number"
                    id="sks"
                    name="sks"
                    value="{{ old('sks', 3) }}"
                    min="1"
                    max="6"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                    @error('sks')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 6: Tipe & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label
                    for="tipe"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Tipe Perkuliahan
                    </label>
                    <select
                    id="tipe"
                    name="tipe"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                        <option value="">Pilih Tipe</option>
                        @foreach (['Teori','Praktikum','Daring'] as $tipe)
                            <option value="{{ $tipe }}" @selected(old('tipe') === $tipe)>{{ $tipe }}</option>
                        @endforeach
                    </select>
                    @error('tipe')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label
                    for="status"
                    class="
                    block
                    text-xs
                    font-semibold
                    text-slate-700
                    uppercase
                    tracking-wider
                    mb-2">
                        Status Jadwal
                    </label>
                    <select
                    id="status"
                    name="status"
                    required
                    class="
                    w-full
                    px-4
                    py-3
                    rounded-xl
                    border
                    border-slate-200
                    text-sm
                    bg-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-600">
                        <option value="">Pilih Status</option>
                        @foreach (['Aktif','Dibatalkan','Selesai'] as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div
            class="
            pt-4
            border-t
            border-slate-100
            flex
            items-center
            gap-3">
                <button
                type="submit"
                class="
                px-6
                py-3
                rounded-2xl
                bg-indigo-600
                hover:bg-indigo-700
                text-white
                font-semibold
                text-sm
                shadow-lg
                shadow-indigo-200
                transition-colors">
                    Simpan Jadwal Kuliah
                </button>
                <a
                href="{{ route('jadwal.index') }}"
                class="
                px-5
                py-3
                rounded-2xl
                border
                border-slate-200
                text-sm
                font-medium
                text-slate-600
                hover:bg-slate-50
                transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
