<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'nama' => 'Admin Garuda-Hub',
            'email' => 'admin@garudahub.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $klien = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'klien@garudahub.id',
            'password' => Hash::make('password123'),
            'role' => 'klien',
        ]);

        $dev = User::create([
            'nama' => 'Siti Aminah',
            'email' => 'dev@garudahub.id',
            'password' => Hash::make('password123'),
            'role' => 'developer',
            'keahlian' => 'Laravel, Vue.js, MySQL',
            'bio' => 'Fullstack Web Developer berpengalaman 3 tahun.',
        ]);

        $proyek = Project::create([
            'klien_id' => $klien->id,
            'judul' => 'Pembuatan Sistem Informasi Manajemen Klinik',
            'kategori' => 'Web Development',
            'deskripsi' => 'Membutuhkan aplikasi berbasis web untuk pendaftaran pasien, rekam medis, dan apotek.',
            'anggaran' => 7500000,
            'batas_lelang' => now()->addDays(14)->toDateString(),
            'status' => 'terbuka',
        ]);

        Bid::create([
            'project_id' => $proyek->id,
            'developer_id' => $dev->id,
            'harga_tawaran' => 6800000,
            'estimasi_hari' => 21,
            'proposal' => 'Siap mengerjakan menggunakan Laravel dan MySQL dengan fitur lengkap dan dokumentasi.',
            'status' => 'menunggu',
        ]);
    }
}