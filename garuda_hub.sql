-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2026 at 01:31 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garuda_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `developer_id` int NOT NULL,
  `harga` bigint NOT NULL,
  `durasi` int NOT NULL,
  `proposal` text NOT NULL,
  `is_winner` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `project_id`, `developer_id`, `harga`, `durasi`, `proposal`, `is_winner`, `created_at`) VALUES
(1, 1, 5, 8500000, 30, 'Saya akan membangun dengan PHP dan MySQL, lengkap dengan panel admin produk.', 0, '2026-11-17 10:49:14'),
(2, 1, 6, 7000000, 40, 'Pengalaman 3 tahun membuat toko online. Termasuk pelatihan penggunaan.', 0, '2026-11-17 10:49:14'),
(3, 1, 7, 9500000, 25, 'Desain premium bernuansa batik, dukungan perawatan 3 bulan.', 0, '2026-11-17 10:49:14'),
(4, 2, 5, 12000000, 45, 'Aplikasi native Kotlin, dukungan printer Bluetooth termasuk.', 0, '2026-11-17 10:49:14'),
(5, 2, 8, 10000000, 50, 'Memakai Flutter agar bisa juga dipakai di iOS nanti.', 0, '2026-11-17 10:49:14'),
(6, 3, 6, 3000000, 14, 'Tiga konsep logo dan UI kit lengkap di Figma.', 1, '2026-11-17 10:49:14'),
(7, 3, 7, 3500000, 10, 'Revisi tak terbatas selama 2 minggu.', 0, '2026-11-17 10:49:14'),
(8, 4, 8, 9000000, 35, 'Dashboard dengan Chart dan ekspor PDF.', 0, '2026-11-17 10:49:14'),
(9, 4, 5, 11000000, 30, 'Termasuk modul impor CSV otomatis.', 0, '2026-11-17 10:49:14'),
(10, 4, 6, 7500000, 45, 'Fokus pada grafik interaktif dan filter cabang.', 0, '2026-11-17 10:49:14'),
(11, 5, 7, 6000000, 30, 'Chatbot berbasis aturan dengan basis pengetahuan FAQ sekolah.', 0, '2026-11-17 10:49:14'),
(12, 6, 8, 11000000, 40, 'Sistem lengkap dengan rekap otomatis dan ekspor Excel.', 1, '2026-11-17 10:49:14'),
(13, 6, 5, 13000000, 35, 'Termasuk aplikasi pemindai kode QR untuk absensi.', 0, '2026-11-17 10:49:14'),
(14, 7, 6, 4500000, 15, 'Skrip impor dengan validasi data dan laporan galat.', 1, '2026-11-17 10:49:14'),
(15, 7, 7, 5000000, 12, 'Termasuk dokumentasi skema dan pelatihan singkat.', 0, '2026-11-17 10:49:14'),
(16, 9, 10, 12000, 3, 'bismillah menang', 1, '2026-11-18 11:35:39'),
(17, 8, 10, 2000000, 3, 'ya allah', 0, '2026-11-19 01:47:28'),
(18, 10, 10, 1500000, 2, 'erg', 1, '2026-11-23 13:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `budget_min` bigint NOT NULL DEFAULT '0',
  `budget_max` bigint NOT NULL DEFAULT '0',
  `batas_lelang` date NOT NULL,
  `status` enum('terbuka','ditutup') NOT NULL DEFAULT 'terbuka',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `judul`, `deskripsi`, `kategori`, `budget_min`, `budget_max`, `batas_lelang`, `status`, `created_at`) VALUES
(1, 2, 'Website Toko Batik Online', 'Membutuhkan toko online dengan katalog produk, keranjang, dan halaman kontak. Desain responsif.', 'Web', 5000000, 10000000, '2027-12-31', 'terbuka', '2026-11-17 10:49:14'),
(2, 2, 'Aplikasi Kasir Android', 'Aplikasi kasir sederhana untuk warung: catat transaksi, laporan harian, cetak struk via Bluetooth.', 'Mobile', 8000000, 15000000, '2027-11-30', 'terbuka', '2026-11-17 10:49:14'),
(3, 3, 'Redesain Logo dan UI Kit', 'Redesain identitas visual startup kuliner beserta UI kit untuk aplikasi pemesanan.', 'Desain', 2000000, 4000000, '2026-09-01', 'ditutup', '2026-11-17 10:49:14'),
(4, 3, 'Dashboard Analitik Penjualan', 'Dashboard grafik penjualan bulanan dari file CSV, dengan filter per cabang dan ekspor laporan.', 'Data', 6000000, 12000000, '2027-10-15', 'terbuka', '2026-11-17 10:49:14'),
(5, 4, 'Chatbot Layanan Pelanggan', 'Chatbot FAQ untuk situs sekolah, dapat dijawab dalam bahasa Indonesia.', 'AI', 4000000, 8000000, '2026-08-20', 'terbuka', '2026-11-17 10:49:14'),
(6, 4, 'Sistem Absensi Sekolah', 'Sistem absensi siswa berbasis web dengan rekap per kelas dan laporan bulanan untuk wali kelas.', 'Web', 7000000, 14000000, '2026-07-10', 'ditutup', '2026-11-17 10:49:14'),
(7, 2, 'Migrasi Database ke MySQL', 'Memindahkan data inventaris dari spreadsheet ke MySQL dan membuat skrip impor.', 'Data', 3000000, 6000000, '2026-06-30', 'ditutup', '2026-11-17 10:49:14'),
(8, 3, 'Landing Page Event Kampus', 'Satu halaman informasi acara seminar teknologi dengan formulir pendaftaran sederhana.', 'Web', 1500000, 3000000, '2027-09-01', 'terbuka', '2026-11-17 10:49:14'),
(9, 9, 'aej', 'alken', 'qlekfn', 10000, 15000, '2026-11-25', 'ditutup', '2026-11-18 05:30:09'),
(10, 9, 'projek bismillah A', 'BISMILLAH', 'PWEB', 1000000, 2000000, '2026-11-29', 'ditutup', '2026-11-23 13:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('klien','developer','admin') NOT NULL DEFAULT 'klien',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Neina Kompe', 'admin@example.com', '$2y$12$FBAg2/FlhqDC6/vtS3QTru9PrsKhZKY2r4C0C914Rjpy1Czp68ZM2', 'admin', '2026-11-17 10:49:14'),
(2, 'Budi Santoso', 'budi@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'klien', '2026-11-17 10:49:14'),
(3, 'Siti Rahayu', 'siti@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'klien', '2026-11-17 10:49:14'),
(4, 'Agus Wijaya', 'agus@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'klien', '2026-11-17 10:49:14'),
(5, 'Dewi Lestari', 'dewi@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'developer', '2026-11-17 10:49:14'),
(6, 'Eko Prasetyo', 'eko@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'developer', '2026-11-17 10:49:14'),
(7, 'Fitri Handayani', 'fitri@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'developer', '2026-11-17 10:49:14'),
(8, 'Gilang Ramadhan', 'gilang@example.com', '$2y$10$pHIf.b4iIPVj2M2vIih4i.OP6Oj0ifF27OrSlmgZW1yXl/zdX2NPW', 'developer', '2026-11-17 10:49:14'),
(9, 'neina', 'neina@gmail.com', '$2y$12$.XppOtB.gbr6TwfB.5mRZ.9w3/T/tOWEV.MPlavfKp69.X.cIG6nm', 'klien', '2026-11-18 05:06:03'),
(10, 'neinalagi', 'neinadeveloper@gmail.com', '$2y$12$sjVSKPBmdKYC3/J7zZManuHts.tGmzfTs.x/Nrt/4TL5swaEjwwBS', 'developer', '2026-11-18 11:34:44'),
(11, 'mamartini', 'mamartini@example.com', '$2y$12$5HmUwyPXcmCWtV5PgQbRDe5njCnhNbWzrx9Z4ouyxKVPXMedHZevO', 'klien', '2026-11-23 13:12:34'),
(12, 'keonho', 'gamtenk@example.com', '$2y$12$SoDT6GOoaH/1spPkEfSIZuHgEIPIGIpI.vyth08JqOW482/gbYmfu', 'developer', '2026-11-23 13:13:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_bids_project_developer` (`project_id`,`developer_id`),
  ADD KEY `fk_bids_developer` (`developer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_projects_status` (`status`),
  ADD KEY `idx_projects_client` (`client_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `fk_bids_developer` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bids_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
