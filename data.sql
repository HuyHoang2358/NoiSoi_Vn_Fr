-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.24 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6376
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for label_img_db
CREATE DATABASE IF NOT EXISTS `label_img_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `label_img_db`;

-- Dumping structure for table label_img_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table label_img_db.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `project_id` bigint NOT NULL,
  `parent_id` bigint DEFAULT '0',
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `size` bigint DEFAULT NULL,
  `top` bigint NOT NULL DEFAULT '0',
  `left` bigint NOT NULL DEFAULT '0',
  `width` bigint NOT NULL DEFAULT '0',
  `height` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000047 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.images: ~7 rows (approximately)
DELETE FROM `images`;
INSERT INTO `images` (`id`, `user_id`, `project_id`, `parent_id`, `file_name`, `file_path`, `size`, `top`, `left`, `width`, `height`, `created_at`, `updated_at`) VALUES
	(10000040, 2, 1000000, NULL, 'Image_25602.png', '/storage/1000000/Image_25602.png', 849088, 0, 0, 0, 0, '2024-01-11 06:52:34', '2024-01-11 06:52:34'),
	(10000041, 2, 1000000, NULL, 'Image_26133.png', '/storage/1000000/Image_26133.png', 849030, 0, 0, 0, 0, '2024-01-11 06:52:35', '2024-01-11 06:52:35'),
	(10000042, 2, 1000000, NULL, 'Image_26625.png', '/storage/1000000/Image_26625.png', 850353, 0, 0, 0, 0, '2024-01-11 06:52:35', '2024-01-11 06:52:35'),
	(10000043, 2, 1000000, NULL, 'Image_26944.png', '/storage/1000000/Image_26944.png', 850318, 0, 0, 0, 0, '2024-01-11 06:52:35', '2024-01-11 06:52:35'),
	(10000044, 2, 1000000, NULL, 'Image_27218.png', '/storage/1000000/Image_27218.png', 844069, 0, 0, 0, 0, '2024-01-11 06:52:35', '2024-01-11 06:52:35'),
	(10000045, 2, 1000000, NULL, 'Image_5477.png', '/storage/1000000/Image_5477.png', 826414, 0, 0, 0, 0, '2024-01-11 06:52:35', '2024-01-11 06:52:35'),
	(10000046, 2, 1000000, NULL, 'Image_22028.png', '/storage/1000000/Image_22028.png', 754877, 0, 0, 0, 0, '2024-01-11 06:52:36', '2024-01-11 06:52:36');

-- Dumping structure for table label_img_db.labels
CREATE TABLE IF NOT EXISTS `labels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.labels: ~14 rows (approximately)
DELETE FROM `labels`;
INSERT INTO `labels` (`id`, `name`, `class_id`, `type`, `created_at`, `updated_at`) VALUES
	(6, 'Brightness', '0', 'quality', '2024-01-02 01:23:52', '2024-01-07 01:20:40'),
	(7, 'Dark', '1', 'quality', '2024-01-02 01:23:59', '2024-01-07 01:20:50'),
	(8, 'HQ', '2', 'quality', '2024-01-02 01:24:08', '2024-01-07 01:21:00'),
	(9, 'Atrophic gastritis', '0', 'diseases', '2024-01-02 01:33:40', '2024-01-02 01:37:08'),
	(10, 'Chronic gastritis', '1', 'diseases', '2024-01-02 01:38:06', '2024-01-02 01:38:06'),
	(11, 'Antrophic metaplasia', '2', 'diseases', '2024-01-02 01:38:51', '2024-01-02 01:38:51'),
	(12, 'Intestinal metaplasia', '3', 'diseases', '2024-01-02 01:39:08', '2024-01-02 01:39:08'),
	(13, 'Normal', '4', 'diseases', '2024-01-02 01:39:20', '2024-01-02 01:39:20'),
	(14, 'Motion', '3', 'quality', '2024-01-07 01:21:08', '2024-01-07 01:21:08'),
	(15, 'Atrophic gastritis', '0', 'gastritis', '2024-01-07 01:23:46', '2024-01-07 01:23:46'),
	(16, 'Chronic gastritis', '1', 'gastritis', '2024-01-07 01:23:56', '2024-01-07 01:23:56'),
	(17, 'Intestinal metaplasia', '2', 'gastritis', '2024-01-07 01:24:14', '2024-01-07 01:24:14'),
	(18, 'Normal', '3', 'gastritis', '2024-01-07 01:24:26', '2024-01-07 01:24:26'),
	(19, 'Undefined', '4', 'gastritis', '2024-01-07 01:24:34', '2024-01-07 01:24:34');

-- Dumping structure for table label_img_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.migrations: ~10 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2023_12_27_122216_create_sessions_table', 1),
	(7, '2023_12_27_135909_create_permission_tables', 1),
	(8, '2024_01_02_021040_create_labels_table', 2),
	(11, '2024_01_09_170417_create_project_models_table', 3),
	(13, '2024_01_10_073056_create_images_table', 4);

-- Dumping structure for table label_img_db.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.model_has_permissions: ~0 rows (approximately)
DELETE FROM `model_has_permissions`;

-- Dumping structure for table label_img_db.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.model_has_roles: ~2 rows (approximately)
DELETE FROM `model_has_roles`;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2);

-- Dumping structure for table label_img_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table label_img_db.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.permissions: ~0 rows (approximately)
DELETE FROM `permissions`;

-- Dumping structure for table label_img_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table label_img_db.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.projects: ~1 rows (approximately)
DELETE FROM `projects`;
INSERT INTO `projects` (`id`, `name`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
	(1000000, 'Project 1', 'Sample images', 2, '2024-01-10 00:26:21', '2024-01-10 00:26:21');

-- Dumping structure for table label_img_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.roles: ~2 rows (approximately)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2023-12-27 07:08:44', '2023-12-27 07:08:44'),
	(2, 'user', 'web', '2023-12-27 07:08:45', '2023-12-27 07:08:45');

-- Dumping structure for table label_img_db.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.role_has_permissions: ~0 rows (approximately)
DELETE FROM `role_has_permissions`;

-- Dumping structure for table label_img_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('ImH6atFd1FFeEbEB2XddGmZqi1TfDTgxJ1wMPRPN', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiazkyVUsycURZSmxXRDNVcGVWQkNNMTFJdFlDTXBuSldFRWZHQVI1ZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkc0x4M0JlLmF1cWZJbFFiZ0NhL1RFLlhHYlFFbHRYMzBuSmNJTmlVekJ0QnNqS2QwQTVjdE8iO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vbGFiZWxpbWcudGgvcHJvamVjdC8xMDAwMDAwIjt9fQ==', 1704988108);

-- Dumping structure for table label_img_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table label_img_db.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$/LwxUe7MBJQr8rXBNlFA8ulw2sAxAHo90MDlU//WtqLhzWuJ3gXvS', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-27 07:08:45', '2023-12-27 07:08:45'),
	(2, 'User', 'user@gmail.com', NULL, '$2y$12$sLx3Be.auqfIlQbgCa/TE.XGbQEltX30nJcINiUzBtBsjKd0A5ctO', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-27 07:08:45', '2023-12-27 07:08:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
