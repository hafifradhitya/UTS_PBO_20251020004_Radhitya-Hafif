<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function dashboard()
    {
        $jadwals = session()->get('jadwals', []);

        $hariIni = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'][date('N') - 1];

        $jadwalHariIni = array_filter($jadwals, function ($jadwal) use ($hariIni) {
            return $jadwal['hari'] === $hariIni;
        });

        $total = count($jadwals);
        $aktif = count(array_filter($jadwals, fn ($j) => $j['status'] === 'Aktif'));
        $perTipe = [
            'Teori' => count(array_filter($jadwals, fn ($j) => $j['tipe'] === 'Teori')),
            'Praktikum' => count(array_filter($jadwals, fn ($j) => $j['tipe'] === 'Praktikum')),
            'Daring' => count(array_filter($jadwals, fn ($j) => $j['tipe'] === 'Daring')),
        ];

        return view('jadwal.dashboard', compact('jadwals', 'jadwalHariIni', 'hariIni', 'total', 'aktif', 'perTipe'));
    }

    public function index(Request $request)
    {
        $jadwals = session()->get('jadwals', []);

        $cari = $request->query('cari');
        $filterHari = $request->query('hari');
        $filterTipe = $request->query('tipe');

        if ($cari) {
            $jadwals = array_filter($jadwals, function ($jadwal) use ($cari) {
                return str_contains(strtolower($jadwal['mata_kuliah'] . ' ' . $jadwal['kode'] . ' ' . $jadwal['dosen']), strtolower($cari));
            });
        }

        if ($filterHari) {
            $jadwals = array_filter($jadwals, fn ($jadwal) => $jadwal['hari'] === $filterHari);
        }

        if ($filterTipe) {
            $jadwals = array_filter($jadwals, fn ($jadwal) => $jadwal['tipe'] === $filterTipe);
        }

        return view('jadwal.index', compact('jadwals', 'cari', 'filterHari', 'filterTipe'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20',
            'mata_kuliah' => 'required|string|max:100',
            'dosen' => 'required|string|max:100',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'kelas' => 'required|string|max:20',
            'sks' => 'required|integer|min:1|max:6',
            'tipe' => 'required|in:Teori,Praktikum,Daring',
            'status' => 'required|in:Aktif,Dibatalkan,Selesai',
        ]);

        $jadwals = session()->get('jadwals', []);

        if (isset($jadwals[$validated['kode']])) {
            return back()->withInput()->with('error', 'Kode sudah digunakan. Gunakan kode lain.');
        }

        $jadwals[$validated['kode']] = $validated;
        session()->put('jadwals', $jadwals);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show($kode)
    {
        $jadwals = session()->get('jadwals', []);

        if (!isset($jadwals[$kode])) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal dengan kode tersebut tidak ditemukan.');
        }

        $jadwal = $jadwals[$kode];

        return view('jadwal.show', compact('jadwal'));
    }

    public function edit($kode)
    {
        $jadwals = session()->get('jadwals', []);

        if (!isset($jadwals[$kode])) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal dengan kode tersebut tidak ditemukan.');
        }

        $jadwal = $jadwals[$kode];

        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $kode)
    {
        $jadwals = session()->get('jadwals', []);

        if (!isset($jadwals[$kode])) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal dengan kode tersebut tidak ditemukan.');
        }

        $validated = $request->validate([
            'mata_kuliah' => 'required|string|max:100',
            'dosen' => 'required|string|max:100',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'kelas' => 'required|string|max:20',
            'sks' => 'required|integer|min:1|max:6',
            'tipe' => 'required|in:Teori,Praktikum,Daring',
            'status' => 'required|in:Aktif,Dibatalkan,Selesai',
        ]);

        $jadwals[$kode] = array_merge($jadwals[$kode], $validated);
        $jadwals[$kode]['kode'] = $kode;
        session()->put('jadwals', $jadwals);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($kode)
    {
        $jadwals = session()->get('jadwals', []);

        if (!isset($jadwals[$kode])) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal dengan kode tersebut tidak ditemukan.');
        }

        unset($jadwals[$kode]);
        session()->put('jadwals', $jadwals);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
