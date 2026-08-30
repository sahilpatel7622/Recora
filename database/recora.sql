-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2026 at 11:29 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recora`
--

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `mail_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_password` text COLLATE utf8mb4_unicode_ci,
  `mail_encryption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_settings`
--

INSERT INTO `mail_settings` (`id`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `created_at`, `updated_at`) VALUES
(1, 'smtp.gmail.com', '587', 'sahilpatel55500@gmail.com', 'vahwjiizbprhwzwn', 'tls', 'sahilpatel55500@gmail.com', 'Recora', '2026-08-30 09:01:58', '2026-08-30 11:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, '2026-08-08 13:31:16', '2026-08-08 14:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_08_01_140605_users', 1),
(2, '2026_08_08_185724_create_maintenances_table', 2),
(3, '2026_08_15_181954_create_notifications_table', 3),
(4, '2026_08_15_191106_create_send_notifications_table', 4),
(5, '2026_08_15_211543_add_deleted_at_to_send_notifications_table', 5),
(6, '2026_08_15_212650_alter_send_notifications_table_add_recipient_type', 6),
(7, '2026_08_30_140408_create_project_settings_table', 7),
(8, '2026_08_30_142141_create_mail_settings_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 4, 'User Login', 'Sahil logged into the system.', 'login', 1, '2026-08-15 13:13:46', '2026-08-15 13:39:25'),
(2, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 13:20:44', '2026-08-15 13:39:25'),
(3, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 13:42:10', '2026-08-15 13:43:10'),
(4, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 13:45:45', '2026-08-15 13:46:15'),
(5, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 13:46:02', '2026-08-15 13:46:15'),
(6, 4, 'User Login', 'Sahil logged into the system.', 'login', 1, '2026-08-15 16:09:29', '2026-08-15 16:09:49'),
(7, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 16:25:31', '2026-08-15 16:30:19'),
(8, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 16:25:56', '2026-08-15 16:30:19'),
(9, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 16:29:53', '2026-08-15 16:30:19'),
(10, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 16:51:30', '2026-08-15 17:00:00'),
(11, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 16:55:08', '2026-08-15 17:00:00'),
(12, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-15 16:56:21', '2026-08-15 17:00:00'),
(13, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 17:05:02', '2026-08-15 17:07:59'),
(14, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-15 17:06:39', '2026-08-15 17:07:59'),
(15, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:17:22', '2026-08-16 06:25:05'),
(16, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:18:22', '2026-08-16 06:25:05'),
(17, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:23:10', '2026-08-16 06:25:05'),
(18, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-16 06:24:47', '2026-08-16 06:25:05'),
(19, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:25:38', '2026-08-16 06:25:38'),
(20, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:29:27', '2026-08-16 06:39:31'),
(21, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:39:08', '2026-08-16 06:39:31'),
(22, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-16 06:39:21', '2026-08-16 06:39:31'),
(23, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:40:38', '2026-08-16 06:44:01'),
(24, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-16 06:40:55', '2026-08-16 06:44:01'),
(25, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:41:05', '2026-08-16 06:44:01'),
(26, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:42:25', '2026-08-16 06:44:01'),
(27, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-16 06:43:11', '2026-08-16 06:44:01'),
(28, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-16 06:43:32', '2026-08-16 06:44:01'),
(29, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-30 08:01:36', '2026-08-30 08:10:59'),
(30, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 08:02:20', '2026-08-30 08:10:59'),
(31, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-30 08:06:35', '2026-08-30 08:10:59'),
(32, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-30 08:10:46', '2026-08-30 08:10:59'),
(33, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 08:46:17', '2026-08-30 08:48:30'),
(34, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 08:47:15', '2026-08-30 08:48:30'),
(35, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 08:47:51', '2026-08-30 08:48:30'),
(36, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 1, '2026-08-30 10:20:55', '2026-08-30 10:23:19'),
(37, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 10:21:07', '2026-08-30 10:23:19'),
(38, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 10:22:37', '2026-08-30 10:23:19'),
(39, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 10:22:57', '2026-08-30 10:23:19'),
(40, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 11:14:59', '2026-08-30 11:16:30'),
(41, 3, 'User Logout', 'Sahil patel logged out of the system.', 'logout', 1, '2026-08-30 11:15:33', '2026-08-30 11:16:30'),
(42, 3, 'User Login', 'Sahil patel logged into the system.', 'login', 0, '2026-08-30 11:18:16', '2026-08-30 11:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_settings`
--

CREATE TABLE `project_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Recora',
  `project_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_settings`
--

INSERT INTO `project_settings` (`id`, `project_name`, `project_logo`, `project_description`, `created_at`, `updated_at`) VALUES
(1, 'Recora', 'project-settings/n3qX2e5SWSaSJ9h5vTGZN49KpgVgzKtMbL88zU58.png', NULL, '2026-08-30 08:44:05', '2026-08-30 10:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `send_notifications`
--

CREATE TABLE `send_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `recipient_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `send_notifications`
--

INSERT INTO `send_notifications` (`id`, `recipient_type`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'user', 3, 'Hello', 'How Are you ?', 1, '2026-08-15 16:47:25', '2026-08-30 11:24:55', NULL),
(6, 'user', 3, 'Test', 'This Notification for Testing...', 1, '2026-08-15 17:07:34', '2026-08-16 07:01:04', NULL),
(7, 'user', 3, 'hello', 'this is testing msggg.', 1, '2026-08-30 08:12:09', '2026-08-30 08:14:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `password`, `action_pass`, `role`, `status`, `last_login_time`, `ip_address`, `device`, `browser`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Sahil', '1234567890', 'sahil@gmail.com', '$2y$12$GZgl3xlYr2g3EaZddBj6lentF5PlQWaRS4LiNBB6/r/k8.BxAvIwu', NULL, 'user', 1, '2026-08-02 07:14:09', '192.168.0.13', 'Android Smartphone / Mobile (AndroidOS 10)', 'Chrome 150.0', 'dfYnpmtfgI73v3jwDabt25G9AreRjqj7BiV5kvaITEHXUJ8EgHJTcK67SCXX', '2026-08-01 15:08:01', '2026-08-15 13:34:58', NULL),
(3, 'Sahil patel', '6359950829', 'sahilpatel55500@gmail.com', '$2y$12$GZgl3xlYr2g3EaZddBj6lentF5PlQWaRS4LiNBB6/r/k8.BxAvIwu', NULL, 'user', 1, '2026-08-30 11:18:16', '192.168.0.17', 'Windows 10/11 PC / Desktop', 'Edge 152.0', 'nyJdZRpnKgPbgFPk1oXUzHnU92VjYRMn8VTS0k6bZ7bCnvSglSIMz3m7ETnX', '2026-08-01 15:09:23', '2026-08-15 16:19:19', NULL),
(4, 'Sahil', '7622920559', 'ds@gmail.com', '$2y$12$GZgl3xlYr2g3EaZddBj6lentF5PlQWaRS4LiNBB6/r/k8.BxAvIwu', NULL, 'admin', 1, '2026-08-30 10:23:13', '192.168.0.13', 'Android Smartphone / Mobile (AndroidOS 10)', 'Chrome 151.0', 'JqZbf8e5E23q1M6grEssd5X4oz0BMPIE4gWRYauooDPuCRJdoD4jIUqav97z', '2026-08-01 15:15:57', '2026-08-02 01:24:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
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
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_notifications`
--
ALTER TABLE `send_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `send_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_number_unique` (`number`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `project_settings`
--
ALTER TABLE `project_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `send_notifications`
--
ALTER TABLE `send_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `send_notifications`
--
ALTER TABLE `send_notifications`
  ADD CONSTRAINT `send_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
