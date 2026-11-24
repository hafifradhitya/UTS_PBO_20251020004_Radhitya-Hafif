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
                <button type="submit" onclick="return confirm('Muat ulang 8 jadwal resmi perkuliahan UCIC?')"
                class="
                px-4
                py-2.5
                rounded-2xl
                border
                border-slate-200
                text-xs
                font-semibold
                text-slate-600
                hover:bg-slate-50
                hover:text-indigo-600
                transition-colors"
                title="Reset & Muat 8 Data Resmi UCIC">
                    Muat 8 Jadwal Resmi UCIC
                </button>
            </form>
            <a href="{{ route('jadwal.create') }}"
            class="inline-flex
            items-center
            gap-2
            bg-indigo-600
            hover:bg-indigo-700
            text-white
            font-medium
            text-sm
            px-5
            py-2.5
            rounded-2xl
            shadow-lg
            shadow-indigo-200
            transition-all
            duration-200
            shrink-0">
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
                                    <button type="button"
                                            onclick="openDeleteModal('{{ $jadwal['kode'] }}', '{{ addslashes($jadwal['mata_kuliah']) }}', '{{ $jadwal['dosen'] }}', '{{ route('jadwal.destroy', $jadwal['kode']) }}')"
                                            class="font-medium text-rose-600 hover:text-rose-800 transition-colors cursor-pointer">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- DaisyUI Delete Confirmation Modal -->
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-white text-slate-800 rounded-3xl border border-slate-200 shadow-2xl p-6 sm:max-w-md">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-slate-900">Hapus Jadwal Kuliah</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Apakah Anda yakin ingin menghapus data perkuliahan ini dari sistem?
                    </p>
                </div>
            </div>

            <div class="my-5 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Mata Kuliah</span>
                    <span id="modal_kode_badge" class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 font-mono font-bold text-[11px]">TI033015</span>
                </div>
                <p id="modal_matkul_name" class="font-bold text-slate-900 text-sm mt-0.5"></p>
                <p id="modal_dosen_name" class="text-slate-600 text-[11px] mt-1"></p>
            </div>

            <div class="modal-action flex items-center justify-end gap-2 pt-2">
                <form method="dialog">
                    <button class="btn btn-ghost btn-sm rounded-xl text-slate-600 hover:bg-slate-100 font-medium normal-case">
                        Batal
                    </button>
                </form>
                <form id="delete_form_target" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm rounded-xl text-white font-medium normal-case shadow-md shadow-rose-200">
                        Ya, Hapus Jadwal
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-xs">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function openDeleteModal(kode, matkul, dosen, destroyUrl) {
            document.getElementById('modal_kode_badge').innerText = kode;
            document.getElementById('modal_matkul_name').innerText = matkul;
            document.getElementById('modal_dosen_name').innerText = 'Dosen: ' + dosen;
            document.getElementById('delete_form_target').action = destroyUrl;
            document.getElementById('delete_modal').showModal();
        }
    </script>
@endsection
