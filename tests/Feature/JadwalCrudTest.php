<?php

namespace Tests\Feature;

use Tests\TestCase;

class JadwalCrudTest extends TestCase
{
    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->get(route('jadwal.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Jadwal');
        $response->assertSee('Total Jadwal');
    }

    public function test_index_page_loads_with_empty_state(): void
    {
        $response = $this->withSession(['jadwals' => []])->get(route('jadwal.index'));
        $response->assertStatus(200);
        $response->assertSee('Belum ada jadwal yang sesuai filter.');
    }

    public function test_create_page_loads(): void
    {
        $response = $this->get(route('jadwal.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Jadwal Baru');
    }

    public function test_store_creates_jadwal_in_session(): void
    {
        $data = [
            'kode' => 'JDW001',
            'mata_kuliah' => 'Pemrograman Berorientasi Objek',
            'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:30',
            'ruangan' => 'Lab 1',
            'kelas' => 'TI-3A',
            'sks' => 3,
            'tipe' => 'Praktikum',
            'status' => 'Aktif',
        ];

        $response = $this->withSession(['jadwals' => []])
            ->post(route('jadwal.store'), $data);

        $response->assertRedirect(route('jadwal.index'));
        $response->assertSessionHas('success', 'Jadwal berhasil ditambahkan.');
        $response->assertSessionHas('jadwals', [
            'JDW001' => $data,
        ]);
    }

    public function test_store_rejects_duplicate_kode(): void
    {
        $existing = [
            'JDW001' => [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
                'ruangan' => 'Lab 1',
                'kelas' => 'TI-3A',
                'sks' => 3,
                'tipe' => 'Praktikum',
                'status' => 'Aktif',
            ],
        ];

        $response = $this->withSession(['jadwals' => $existing])
            ->from(route('jadwal.create'))
            ->post(route('jadwal.store'), [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Basis Data',
                'dosen' => 'Dosen Contoh',
                'hari' => 'Selasa',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'ruangan' => 'Lab 2',
                'kelas' => 'TI-3B',
                'sks' => 2,
                'tipe' => 'Teori',
                'status' => 'Aktif',
            ]);

        $response->assertRedirect(route('jadwal.create'));
        $response->assertSessionHas('error', 'Kode sudah digunakan. Gunakan kode lain.');
    }

    public function test_show_displays_details_or_redirects_if_not_found(): void
    {
        $existing = [
            'JDW001' => [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
                'ruangan' => 'Lab 1',
                'kelas' => 'TI-3A',
                'sks' => 3,
                'tipe' => 'Praktikum',
                'status' => 'Aktif',
            ],
        ];

        $response = $this->withSession(['jadwals' => $existing])
            ->get(route('jadwal.show', 'JDW001'));
        $response->assertStatus(200);
        $response->assertSee('Pemrograman Berorientasi Objek');

        // Not found
        $responseNotFound = $this->withSession(['jadwals' => $existing])
            ->get(route('jadwal.show', 'JDW999'));
        $responseNotFound->assertRedirect(route('jadwal.index'));
        $responseNotFound->assertSessionHas('error');
    }

    public function test_edit_loads_form_with_old_values(): void
    {
        $existing = [
            'JDW001' => [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
                'ruangan' => 'Lab 1',
                'kelas' => 'TI-3A',
                'sks' => 3,
                'tipe' => 'Praktikum',
                'status' => 'Aktif',
            ],
        ];

        $response = $this->withSession(['jadwals' => $existing])
            ->get(route('jadwal.edit', 'JDW001'));
        $response->assertStatus(200);
        $response->assertSee('Edit Jadwal JDW001');
    }

    public function test_update_modifies_session(): void
    {
        $existing = [
            'JDW001' => [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
                'ruangan' => 'Lab 1',
                'kelas' => 'TI-3A',
                'sks' => 3,
                'tipe' => 'Praktikum',
                'status' => 'Aktif',
            ],
        ];

        $updatedData = [
            'mata_kuliah' => 'Pemrograman Berorientasi Objek Lanjutan',
            'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
            'hari' => 'Kamis',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:30',
            'ruangan' => 'Lab Multimedia',
            'kelas' => 'TI-3A',
            'sks' => 3,
            'tipe' => 'Praktikum',
            'status' => 'Aktif',
        ];

        $response = $this->withSession(['jadwals' => $existing])
            ->put(route('jadwal.update', 'JDW001'), $updatedData);

        $response->assertRedirect(route('jadwal.index'));
        $response->assertSessionHas('success', 'Jadwal berhasil diperbarui.');
    }

    public function test_destroy_removes_from_session(): void
    {
        $existing = [
            'JDW001' => [
                'kode' => 'JDW001',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'dosen' => 'Hilman Lesmana, S.T., M.S.F.',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
                'ruangan' => 'Lab 1',
                'kelas' => 'TI-3A',
                'sks' => 3,
                'tipe' => 'Praktikum',
                'status' => 'Aktif',
            ],
        ];

        $response = $this->withSession(['jadwals' => $existing])
            ->delete(route('jadwal.destroy', 'JDW001'));

        $response->assertRedirect(route('jadwal.index'));
        $response->assertSessionHas('success', 'Jadwal berhasil dihapus.');
    }
}
