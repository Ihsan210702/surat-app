-- Adminer 4.8.1 MySQL 5.7.39 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'Administrasi',	'2022-01-03 06:44:22',	'2022-01-03 06:44:22');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `letters`;
CREATE TABLE `letters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `letter_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `date_received` date NOT NULL,
  `regarding` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `sender_id` bigint(20) unsigned NOT NULL,
  `letter_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('diproses','diterima','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `letters` (`id`, `letter_no`, `letter_date`, `date_received`, `regarding`, `department_id`, `sender_id`, `letter_file`, `letter_type`, `status`, `created_at`, `updated_at`) VALUES
(1,	'283/PL18.8/LT/2018',	'2018-09-17',	'2018-09-20',	'Undangan Seminar Kekayaan Intelektual',	1,	1,	'assets/letter-file/7kc7xqqKS9Yw5XmAaksGxY9UydKuCyf3AOL06MMm.pdf',	'Surat Masuk',	'diproses',	'2022-01-03 06:46:29',	'2022-01-03 06:46:29'),
(2,	'002/RM/XI/2021',	'2021-11-12',	'2021-11-15',	'Peringatan Maulid Nabi Muhammad SAW',	1,	2,	'assets/letter-file/GLCG87pU2iNBM1UmN2RVprbJZmbgMOKn9Od9Wr3g.pdf',	'Surat Keluar',	'diproses',	'2022-01-03 06:50:53',	'2024-10-22 18:31:36'),
(3,	'123123123',	'2024-10-14',	'2024-10-15',	'testing surat masuk',	1,	1,	'assets/letter-file/5qem7SEEgwhPx6axsr2qEl7cjGvLrVpPmxuM9nJb.pdf',	'Surat Masuk',	'ditolak',	'2024-10-13 11:19:31',	'2024-10-13 12:54:29'),
(4,	'123123123',	'2024-10-14',	'2024-10-15',	'testing surat masuk',	1,	1,	'assets/letter-file/GXyN2L7pJ4jVg0cUEbm284ZL73dQuYedTgHYrWC7.pdf',	'Surat Masuk',	'diterima',	'2024-10-13 11:20:36',	'2024-10-13 12:42:23'),
(5,	'123123123',	'2024-10-14',	'2024-10-15',	'testing surat masuk',	1,	1,	'assets/letter-file/eaHliU0ZYT9R7Rt7pAdfOV8gnDkTkzomvKKnquVo.pdf',	'Surat Masuk',	'diproses',	'2024-10-13 11:21:07',	'2024-10-13 11:21:07'),
(6,	'123123123',	'2024-10-14',	'2024-10-15',	'testing surat masuk',	1,	1,	'assets/letter-file/yIjMFsTZ9ZYtig0CciXDj6Qa7Zus9ScKY3EJHGRm.pdf',	'Surat Masuk',	'diterima',	'2024-10-13 11:21:22',	'2024-10-13 12:37:52'),
(7,	'686867',	'2024-10-14',	'2024-10-15',	'testing surat masuk',	1,	1,	'public/assets/letter-file/gFrexcEVhAAtEfMYAdte12uCEdmLFjS5HxpXnivZ.pdf',	'Surat Masuk',	'diterima',	'2024-10-13 11:22:38',	'2024-10-13 12:50:55');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2021_12_29_043513_create_departments_table',	1),
(6,	'2021_12_29_065240_create_senders_table',	1),
(7,	'2021_12_30_055748_create_letters_table',	1);

DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('Guru','Murid') NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` longtext,
  `is_seen` enum('Y','N') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `senders`;
CREATE TABLE `senders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `senders` (`id`, `name`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1,	'Politeknik Negeri Banjarmasin',	'Jl. Brigjen H. Hasan Basri, Kayutangi, Banjarmasin 70123',	'(0511) 3305052',	'poliban@poliban.ac.id',	'2022-01-03 06:45:35',	'2022-01-03 06:45:35'),
(2,	'Karimu',	'Dusun Cikatomas RT 10 RW 03, Desa Gunungsari,\r\nKec. Sadananya, Kab. Ciamis, Jawa Barat 46256',	'082317688174',	'karimu@gmail.com',	'2022-01-03 06:49:49',	'2022-01-03 06:49:49');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff administrasi','guru','kepala sekolah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` int(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `role`, `nip`, `email_verified_at`, `password`, `profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Aris Maulana',	'admin@gmail.com',	'admin',	NULL,	NULL,	'$2y$10$OZHdNDSPAstB9D65oiSineO2Tgyr3/kBqvPYbVHDLUAjyRf8vdTy6',	NULL,	NULL,	'2022-01-03 00:21:03',	'2022-01-03 00:21:03'),
(2,	'Staff TU',	'staff_tu@gmail.com',	'staff administrasi',	NULL,	NULL,	'$2a$12$tj3nVW.PX1dkHuVeFhx7WuDhvU1DDOCVmgcHtr8dcf055zfirCemu',	NULL,	NULL,	'2022-01-03 00:21:03',	'2022-01-03 00:21:03'),
(3,	'Guru',	'guru@gmail.com',	'guru',	NULL,	NULL,	'$2a$12$GoYFbrpsr5tpJxuX1wCKI.PQ17iEQDunZFLFyv2wzYu5cbMJhlgk2',	NULL,	NULL,	'2022-01-03 00:21:03',	'2022-01-03 00:21:03'),
(4,	'Kepala Sekolah',	'kepsek@gmail.com',	'kepala sekolah',	NULL,	NULL,	'$2a$12$hzousWiGg/8b7CD38Bz/TuGUSoN582z04Dzn35g4Dh5PRHq9hM/4y',	NULL,	NULL,	'2022-01-03 00:21:03',	'2022-01-03 00:21:03'),
(5,	'testing',	'testing@gmail.com',	'admin',	NULL,	NULL,	'$2y$10$i7WaCoHixFthCsQ3YiCWFeeb.B2RJzcZzAY4cCLUqXXBSaMmk5zKy',	NULL,	NULL,	'2024-10-13 10:06:04',	'2024-10-13 10:06:04');

-- 2024-10-24 15:57:16
