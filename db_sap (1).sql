-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 04 Jul 2025 pada 03.19
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sap`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('hadir','cuti','izin','sakit','alpa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '2025-06-01', 'hadir', NULL, NULL),
(2, 4, '2025-06-27', 'sakit', NULL, NULL),
(3, 4, '2025-06-25', 'cuti', '2025-06-19 20:00:06', '2025-06-19 20:00:06'),
(4, 4, '2025-06-26', 'cuti', '2025-06-19 20:00:06', '2025-06-19 20:00:06'),
(5, 4, '2025-07-04', 'cuti', '2025-07-03 12:55:26', '2025-07-03 12:55:26'),
(6, 4, '2025-07-03', 'izin', '2025-07-03 13:04:16', '2025-07-03 13:04:16'),
(7, 3, '2025-07-03', 'alpa', '2025-07-03 13:25:38', '2025-07-03 13:25:38'),
(8, 7, '2025-07-03', 'alpa', '2025-07-03 13:25:38', '2025-07-03 13:25:38'),
(9, 8, '2025-07-03', 'alpa', '2025-07-03 13:25:38', '2025-07-03 13:25:38'),
(10, 10, '2025-07-03', 'alpa', '2025-07-03 13:25:38', '2025-07-03 13:25:38'),
(11, 12, '2025-07-03', 'alpa', '2025-07-03 13:25:38', '2025-07-03 13:25:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `phonenumber`, `address`, `created_at`, `updated_at`) VALUES
(1, 'PT. Contoh Perusahaan', 'company@example.com', '084131331131', 'Lampung', '2025-05-22 10:41:41', '2025-05-22 13:04:34'),
(5, 'motion', 'company@example.com', '084131331131', 'afadadwada', '2025-05-22 13:07:21', '2025-05-22 13:07:21'),
(6, 'PT. Contoh Perusahaan 2', 'company@example.com', '0841313', 'adadqawda', '2025-05-22 13:46:48', '2025-05-22 13:46:48'),
(7, 'Pt apaan', 'apaan@gmail.com', '23131', 'dadawadw', '2025-06-19 20:42:38', '2025-06-19 20:42:38'),
(8, 'Pt maju', 'maju@gmail.com', '081313', 'adawdadkwaj', '2025-07-03 19:40:01', '2025-07-03 19:40:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'IT', '2025-05-22 10:41:41', '2025-05-22 10:41:41'),
(2, 'HRD', '2025-05-22 10:41:41', '2025-05-22 10:41:41'),
(5, 'Editor', '2025-07-03 05:19:33', '2025-07-03 05:19:33'),
(6, 'Sales', '2025-07-03 05:19:58', '2025-07-03 05:19:58'),
(7, 'SDM', '2025-07-03 05:23:19', '2025-07-03 05:23:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `division_details`
--

CREATE TABLE `division_details` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `division_details`
--

INSERT INTO `division_details` (`id`, `division_id`, `company_id`, `basic_salary`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 3000000.00, '2025-07-03 05:37:39', '2025-07-03 05:45:26'),
(2, 1, 1, 2000000.00, '2025-07-03 06:03:45', '2025-07-03 06:03:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `leaves`
--

INSERT INTO `leaves` (`id`, `user_id`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '2025-06-20', '2025-06-27', 'Sakit Mang', 'rejected', '2025-06-19 10:35:54', '2025-06-19 10:59:24'),
(2, 4, '2025-06-20', '2025-06-27', 'Sakit Mang', 'rejected', '2025-06-19 10:38:32', '2025-06-19 10:59:21'),
(3, 4, '2025-06-20', '2025-06-27', 'Sakit Mang', 'approved', '2025-06-19 10:45:57', '2025-06-19 10:59:18'),
(4, 4, '2025-06-25', '2025-06-26', 'Sakit', 'approved', '2025-06-19 19:59:42', '2025-06-19 20:00:06'),
(5, 4, '2025-07-04', '2025-07-05', 'Cuti aja', 'approved', '2025-07-03 12:55:00', '2025-07-03 12:55:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_05_21_063839_create_companies_table', 1),
(3, '2025_05_21_063843_create_divisions_table', 1),
(4, '2025_05_21_063847_create_users_table', 1),
(5, '2025_05_21_063853_create_tokens_table', 1),
(6, '2025_05_21_063857_create_leaves_table', 1),
(7, '2025_05_21_063906_create_salaries_table', 1),
(8, '2025_05_21_063907_create_salaries_table', 2),
(9, '2025_06_19_181039_create_attendances_table', 3),
(10, '2025_07_03_111619_create_division_details', 4),
(11, '2025_07_03_172830_add_division_detail_id_to_users_table', 5),
(12, '2025_07_03_181006_add_avatar_to_users_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `allowance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(12,2) NOT NULL,
  `payment_status` enum('pending','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `salaries`
--

INSERT INTO `salaries` (`id`, `user_id`, `basic_salary`, `allowance`, `bonus`, `deduction`, `amount`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 3, 100000.00, 10.00, 100.00, 10.00, 100100.00, 'paid', '2025-06-19', '2025-06-19 08:36:46', '2025-06-19 19:11:48'),
(2, 3, 1000.00, 100.00, 100.00, 10.00, 1190.00, 'paid', '2025-06-19', '2025-06-19 08:45:38', '2025-06-19 08:50:32'),
(4, 4, 2000.00, 10.00, 100.00, 100.00, 1000000.00, 'paid', '2025-05-08', NULL, '2025-07-03 12:15:29'),
(6, 7, 10000.00, 10.00, 100.00, 10.00, 10100.00, 'paid', '2025-06-25', '2025-06-19 20:44:29', '2025-06-19 20:45:19'),
(7, 10, 2000000.00, 200000.00, 20.00, 200.00, 2199820.00, 'pending', '2025-07-03', '2025-07-03 06:09:09', '2025-07-03 06:09:09'),
(8, 4, 3000000.00, 20000.00, 20.00, 200.00, 3019820.00, 'paid', '2025-07-04', '2025-07-03 12:26:22', '2025-07-03 12:26:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','admin','manager','employee') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_detail_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `company_id`, `phone`, `address`, `avatar`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `division_detail_id`) VALUES
(1, 'Jaka Kusuma', 'superadmin@example.com', '$2y$12$kAtOnAy13z8zhnH95NSPGeRArxZY8xVUr6XGPQXL/tsepDaGz7dWq', 'superadmin', NULL, NULL, NULL, NULL, NULL, 'l6GHUfqoWUeSL5pOiOziWheeImNWwPjW72oKIXJvPh1cnBzFDlUrlxwpT3sU', '2025-05-22 10:43:35', '2025-05-22 10:43:35', NULL),
(2, 'Budi', 'admin@example.com', '$2y$12$XP8HfJ09eyIWSLtEJnO2SuROx.fmAzcYt7YlGAnGJcuasUwy26Ule', 'admin', 1, NULL, NULL, 'avatars/F43og6sQKOJisIU6ejgGTRrnZaY7oKRk6lZ8rVng.jpg', NULL, '0TIEVwtJRgsJyGbzjkyX7rBoL53LeMeZLv6o2Lt8zbGjR8Ip4mAFDRHkZ0gX', '2025-05-22 10:43:35', '2025-07-03 12:17:01', NULL),
(3, 'Manager IT', 'manager@example.com', '$2y$12$SZoFP4kJ5eLnyozJfer1zuRZWvCmo6Hi3PeLUwyU3Gk7Utef9tuz.', 'employee', 1, '0895888', 'jln.buah gg.semangka No.1b Bandar Lampung', NULL, NULL, NULL, '2025-05-22 10:43:36', '2025-07-03 08:21:25', NULL),
(4, 'Siti', 'employee@example.com', '$2y$12$.a4U3XaqaHnahj0n451jMuQxNSn6RQV7l.mGh6t3MUyjjRegv7..W', 'employee', 1, '083181', 'dwkdqnnnlda', 'avatars/9fXjZ5fDCG3msQAyOYlaiyKJzjwk1qddh9EFzdPn.jpg', NULL, NULL, '2025-05-22 10:43:36', '2025-07-03 12:02:53', 1),
(5, 'Annisa Hajar', 'company@example.com', '$2y$12$4iLphYTHqcAyGmrWrT3.r.x0kMC57nxiQYacS8lrS7GDU4zuYLMFq', 'admin', 5, NULL, NULL, NULL, NULL, NULL, '2025-05-22 13:09:04', '2025-05-22 13:09:04', NULL),
(6, 'motion', 'cinta@gmail.com', '$2y$12$jHoMKBqNS8WALISqJiNVNuHUdrxLIVVo89r8di7FMqQkP7EuPNaUq', 'admin', 5, NULL, NULL, NULL, NULL, NULL, '2025-05-22 13:51:44', '2025-05-22 13:51:44', NULL),
(7, 'Wendi', 'wendi@gmail.com', '$2y$12$fJpx8hjNyZqa3Q8dJ9pyD.E8JesdozQ/5ZXhgl.WLb2PgW92V9vtS', 'employee', 1, '09414014', 'aokdkwdkawk', NULL, NULL, NULL, '2025-05-22 13:52:48', '2025-07-03 12:34:46', 1),
(8, 'Handika', 'handika@gmail.com', '$2y$12$2VLEhQNHqmUZIEWqYIO52uen2NtPHVP1jVWcX8NTYH9bW7jCx6Tsq', 'employee', 1, '0324', 'aokwkwkwkwwk', NULL, NULL, NULL, '2025-05-22 19:30:37', '2025-05-28 22:14:16', NULL),
(10, 'Annisa', 'annisa123@gmail.com', '$2y$12$BkFjsvigc/5rNP8F.XPIr.6TlrP3FUFhKllT.m3Iu1BkeWmTOMR7y', 'employee', 1, '02313', 'awoowkwkwkw', NULL, NULL, NULL, '2025-06-11 09:16:46', '2025-07-03 10:38:51', 2),
(11, 'adawa', 'wadw@gmail.com', '$2y$12$eN7ZMCz5cWptuytgUJIvZeFgx/WFQy8jlCUHINyLYOxkHkybxaDL6', 'admin', 7, NULL, NULL, NULL, NULL, NULL, '2025-06-19 20:43:11', '2025-06-19 20:43:11', NULL),
(12, 'sahrul', 'sahrul@gmail.com', '$2y$12$xor5bwUC5raoIiSSaY1ZP.x4TA6Ss/y/5pTZ3vRhJpQ2in2cRleCO', 'employee', 1, '201913', 'mkmad', NULL, NULL, NULL, '2025-07-03 12:35:37', '2025-07-03 12:35:37', 2),
(13, 'adwada', 'dawd@gmail.com', '$2y$12$1CLrfCfp12X2KDCxmrc/P.ofAucVOH37TyH6mG6KZvcmbugcXkPyG', 'admin', 8, NULL, NULL, NULL, NULL, NULL, '2025-07-03 19:40:30', '2025-07-03 19:40:30', NULL),
(14, 'Adam', 'adam@gmail.com', '$2y$12$iIvRhvtLYpIo9W/44coaIeXrnfU.z8EJTP0rxIrHFzF5jnRpe7Gti', 'manager', 1, '131331', 'dadaw', NULL, NULL, NULL, '2025-07-03 19:43:11', '2025-07-03 19:43:11', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_date_unique` (`user_id`,`date`);

--
-- Indeks untuk tabel `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `division_details`
--
ALTER TABLE `division_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `division_details_division_id_company_id_unique` (`division_id`,`company_id`),
  ADD KEY `division_details_company_id_foreign` (`company_id`);

--
-- Indeks untuk tabel `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tokens_token_unique` (`token`),
  ADD KEY `tokens_company_id_foreign` (`company_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_division_detail_id_foreign` (`division_detail_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `division_details`
--
ALTER TABLE `division_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `division_details`
--
ALTER TABLE `division_details`
  ADD CONSTRAINT `division_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `division_details_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_division_detail_id_foreign` FOREIGN KEY (`division_detail_id`) REFERENCES `division_details` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
