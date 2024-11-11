-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2024 pada 01.49
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat-app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `incoming_mails`
--

CREATE TABLE `incoming_mails` (
  `id` int(11) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `status_surat` enum('Asli','Tembusan') NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `tujuan_disposisi` varchar(255) NOT NULL,
  `catatan_disposisi` varchar(255) NOT NULL,
  `status_disposisi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `incoming_mails`
--

INSERT INTO `incoming_mails` (`id`, `no_surat`, `tanggal_surat`, `pengirim`, `jenis_surat`, `tanggal_diterima`, `perihal`, `status_surat`, `file_surat`, `status`, `tujuan_disposisi`, `catatan_disposisi`, `status_disposisi`, `created_at`, `updated_at`) VALUES
(2, '40/B/23/4/2024', '2024-11-06', 'Dinas Pariwisata', 'Surat Permohonan', '2024-11-09', 'Kunjungan ke Sekolah', 'Tembusan', 'public/surat-masuk/EeRaaVj4xicu7nOwt8DYEgB96OWIg1BHPANLcU91.pdf', 3, '[\"6\"]', 'bagus', 1, '2024-11-06 05:12:01', '2024-11-08 18:42:11'),
(4, '420/B/131.242/2024', '2024-11-07', 'Kecamatan Ganding', 'Surat Permohonan', '2024-11-09', 'Pemberdayaan Manusia', 'Asli', 'public/surat-masuk/VnsbXxfFm6rdun884fQXSJhvLOD1ZN9w5C8lpNB3.pdf', 3, '[\"3\"]', 'Sudah bagus mantap', 3, '2024-11-09 05:23:19', '2024-11-10 17:32:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_12_29_043513_create_departments_table', 1),
(6, '2021_12_29_065240_create_senders_table', 1),
(7, '2021_12_30_055748_create_letters_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `role` enum('Guru','Murid') NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `is_seen` enum('Y','N') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `outgoing_mails`
--

CREATE TABLE `outgoing_mails` (
  `id` int(11) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `outgoing_mails`
--

INSERT INTO `outgoing_mails` (`id`, `no_surat`, `tanggal_surat`, `tujuan`, `jenis_surat`, `perihal`, `file_surat`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(2, '420/B/131.242/2023', '2024-11-06', 'Dinas Pendidikan', 'Surat Lomba', 'Lomba Karaoke', 'public/surat-keluar/UEMkgOdwIaCapfWo7pRq7kwyzgv9ZhHUnofdb0dy.pdf', 4, 'langusng kirim segera', '2024-11-05 19:52:36', '2024-11-10 17:41:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff','guru','kepsek') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` int(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `nip`, `email_verified_at`, `password`, `profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aris Maulana', 'admin@gmail.com', 'admin', NULL, NULL, '$2y$10$OZHdNDSPAstB9D65oiSineO2Tgyr3/kBqvPYbVHDLUAjyRf8vdTy6', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(2, 'Staff TU', 'staff_tu@gmail.com', 'staff', NULL, NULL, '$2a$12$tj3nVW.PX1dkHuVeFhx7WuDhvU1DDOCVmgcHtr8dcf055zfirCemu', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(3, 'Guru', 'guru@gmail.com', 'guru', NULL, NULL, '$2a$12$GoYFbrpsr5tpJxuX1wCKI.PQ17iEQDunZFLFyv2wzYu5cbMJhlgk2', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(4, 'Kepala Sekolah', 'kepsek@gmail.com', 'kepsek', NULL, NULL, '$2a$12$hzousWiGg/8b7CD38Bz/TuGUSoN582z04Dzn35g4Dh5PRHq9hM/4y', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(5, 'testing', 'testing@gmail.com', 'admin', NULL, NULL, '$2y$10$i7WaCoHixFthCsQ3YiCWFeeb.B2RJzcZzAY4cCLUqXXBSaMmk5zKy', NULL, NULL, '2024-10-13 10:06:04', '2024-10-13 10:06:04'),
(6, 'Syafaria', 'syafarian@gmail.com', 'guru', NULL, NULL, '$2y$10$rg4bj20zRDi6EzkcpJPaKOI7K4kPr1NFKKirekaZV42mpSbShjjYu', NULL, NULL, '2024-11-08 07:28:31', '2024-11-08 07:39:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `incoming_mails`
--
ALTER TABLE `incoming_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`role`);

--
-- Indeks untuk tabel `outgoing_mails`
--
ALTER TABLE `outgoing_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `incoming_mails`
--
ALTER TABLE `incoming_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `outgoing_mails`
--
ALTER TABLE `outgoing_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
