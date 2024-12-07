-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 05:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_mails`
--

CREATE TABLE `incoming_mails` (
  `id` int(11) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `isi_singkat` varchar(255) NOT NULL,
  `sifat_surat` enum('Biasa','Segera','Sangat Segera') NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `tujuan_disposisi` varchar(255) NOT NULL,
  `catatan_disposisi` varchar(255) NOT NULL,
  `isi_disposisi` varchar(255) NOT NULL,
  `status_disposisi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incoming_mails`
--

INSERT INTO `incoming_mails` (`id`, `no_surat`, `tanggal_surat`, `pengirim`, `tanggal_diterima`, `perihal`, `isi_singkat`, `sifat_surat`, `file_surat`, `status`, `tujuan_disposisi`, `catatan_disposisi`, `isi_disposisi`, `status_disposisi`, `created_at`, `updated_at`) VALUES
(13, '420/B/230.242/2024', '2024-12-05', 'Dinas Pendidikan', '2024-12-06', 'Pengajuan', 'Tentang Perluasan pembangunan ini', 'Sangat Segera', 'public/surat-masuk/TKQjGwsBgjQdEIp7QaQtUnQsFOMMaGs0Tg9xP1Uw.pdf', 3, '[\"3\"]', 'Segera tindak lanjuti oke', 'oke segera saya tindak lanjuti pak', 3, '2024-12-05 19:00:21', '2024-12-06 19:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_12_29_043513_create_departments_table', 1),
(6, '2021_12_29_065240_create_senders_table', 1),
(7, '2021_12_30_055748_create_letters_table', 1),
(8, '2024_11_12_013714_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('00161aff-1945-4bc5-bbfb-21c249ca8cf6', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 2, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:16:39', '2024-12-06 20:16:39'),
('16f1f1bf-48b1-45fc-afef-d24b7284eb3d', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 4, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengadaan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:23:04', '2024-12-06 20:23:04'),
('27fb70cd-6971-4a3f-92f2-0cfc0b3a8f40', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 3, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/guru\\/surat-masuk\\/13\\/show\"}', NULL, '2024-12-06 19:55:20', '2024-12-06 19:55:20'),
('4c44a36d-5b16-4c54-880a-61763e64b770', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 3, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:16:39', '2024-12-06 20:16:39'),
('5276d53e-5fd6-45dc-bec1-2959e04ed0ce', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 4, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/kepsek\\/surat-masuk\\/13\\/show\"}', NULL, '2024-12-05 19:28:12', '2024-12-05 19:28:12'),
('5974fb89-d61d-429b-9514-68a91775e80a', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 5, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:16:39', '2024-12-06 20:16:39'),
('864f4381-be48-4529-9c76-e9a9e42d2755', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 5, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/surat-masuk\\/13\\/show\"}', NULL, '2024-12-05 19:00:25', '2024-12-05 19:00:25'),
('8b894174-440a-477a-a627-e89223d99de6', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 1, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/surat-masuk\\/13\\/show\"}', NULL, '2024-12-05 19:00:25', '2024-12-05 19:00:25'),
('9573af13-95a5-4139-a00e-7d4eb6fac7a6', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 3, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/guru\\/surat-masuk\\/13\\/show\"}', NULL, '2024-12-06 03:55:56', '2024-12-06 03:55:56'),
('d03fd683-7208-4d44-97bc-656c2b07ddc8', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 1, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:16:39', '2024-12-06 20:16:39'),
('fa7a965a-1413-4a0d-8e71-04f16a65f90c', 'App\\Notifications\\SuratKeluarNotification', 'App\\Models\\User', 6, '{\"surat_id\":14,\"jenis_surat\":null,\"tipe_surat\":\"Surat Keluar\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-07\"}', NULL, '2024-12-06 20:16:39', '2024-12-06 20:16:39'),
('fd838aa7-3022-4a39-87d6-a70ad9830056', 'App\\Notifications\\SuratMasukNotification', 'App\\Models\\User', 2, '{\"surat_id\":13,\"jenis_surat\":null,\"tipe_surat\":\"Surat Masuk\",\"perihal\":\"Pengajuan\",\"tanggal_surat\":\"2024-12-05\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/staff\\/surat-masuk\\/13\\/show\"}', '2024-12-05 19:12:33', '2024-12-05 19:00:25', '2024-12-05 19:12:33');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_mails`
--

CREATE TABLE `outgoing_mails` (
  `id` int(11) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `isi_singkat` varchar(255) NOT NULL,
  `sifat_surat` enum('Biasa','Segera','Sangat Segera','') NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outgoing_mails`
--

INSERT INTO `outgoing_mails` (`id`, `no_surat`, `tanggal_surat`, `tujuan`, `perihal`, `isi_singkat`, `sifat_surat`, `file_surat`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(14, '420/C/230.242/2024', '2024-12-07', 'UPT Kecamatan Ganding', 'Pengadaan', 'Pengadaan lomba kecamatan per SD', 'Biasa', 'public/surat-keluar/MxrTtmObVY371gFvfaatTv3S6PxXDnOTBf6biF3C.pdf', 4, 'Bagus langsung segera kirim', '2024-12-06 20:16:39', '2024-12-06 20:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','staff','guru','kepsek') NOT NULL,
  `nip` int(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `nip`, `email_verified_at`, `password`, `profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aris Maulana', 'admin@gmail.com', 'admin', NULL, NULL, '$2y$10$OZHdNDSPAstB9D65oiSineO2Tgyr3/kBqvPYbVHDLUAjyRf8vdTy6', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(2, 'Staff TU', 'staff_tu@gmail.com', 'staff', NULL, NULL, '$2a$12$tj3nVW.PX1dkHuVeFhx7WuDhvU1DDOCVmgcHtr8dcf055zfirCemu', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(3, 'Guru', 'guru@gmail.com', 'guru', NULL, NULL, '$2a$12$GoYFbrpsr5tpJxuX1wCKI.PQ17iEQDunZFLFyv2wzYu5cbMJhlgk2', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(4, 'Kepala Sekolah', 'kepsek@gmail.com', 'kepsek', NULL, NULL, '$2a$12$hzousWiGg/8b7CD38Bz/TuGUSoN582z04Dzn35g4Dh5PRHq9hM/4y', NULL, NULL, '2022-01-03 00:21:03', '2022-01-03 00:21:03'),
(5, 'testing', 'testing@gmail.com', 'admin', NULL, NULL, '$2y$10$i7WaCoHixFthCsQ3YiCWFeeb.B2RJzcZzAY4cCLUqXXBSaMmk5zKy', NULL, NULL, '2024-10-13 10:06:04', '2024-10-13 10:06:04'),
(6, 'Syafarian', 'syafarian@gmail.com', 'guru', NULL, NULL, '$2y$10$rg4bj20zRDi6EzkcpJPaKOI7K4kPr1NFKKirekaZV42mpSbShjjYu', NULL, NULL, '2024-11-08 07:28:31', '2024-12-06 19:50:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `incoming_mails`
--
ALTER TABLE `incoming_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `outgoing_mails`
--
ALTER TABLE `outgoing_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incoming_mails`
--
ALTER TABLE `incoming_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `outgoing_mails`
--
ALTER TABLE `outgoing_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
