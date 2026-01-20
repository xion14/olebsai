-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2026 at 02:07 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olebsai`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `description`, `image`, `link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Main Banner', NULL, '20250331022418.jpg', 'http://olebsai.test/', 1, '2025-03-30 19:24:18', '2025-03-30 19:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

DROP TABLE IF EXISTS `cart_products`;
CREATE TABLE IF NOT EXISTS `cart_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_type` enum('single','multi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single',
  `price` int DEFAULT NULL,
  `duration` text COLLATE utf8mb4_unicode_ci,
  `duration_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `customer_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `qty` int NOT NULL,
  `checked` enum('no','yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_products`
--

INSERT INTO `cart_products` (`id`, `seller_id`, `price_type`, `price`, `duration`, `duration_info`, `description`, `detail`, `customer_id`, `product_id`, `qty`, `checked`, `created_at`, `updated_at`) VALUES
(3, NULL, 'single', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 'no', '2025-03-30 20:57:49', '2025-03-30 20:57:49'),
(6, NULL, 'single', NULL, NULL, NULL, NULL, NULL, 3, 125, 1, 'no', '2025-04-04 04:32:43', '2025-04-04 04:32:43'),
(10, NULL, 'single', NULL, NULL, NULL, NULL, NULL, 6, 126, 1, 'no', '2025-12-04 18:45:39', '2025-12-04 18:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `wallet` bigint NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `address_status` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `image_user_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  UNIQUE KEY `customers_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `code`, `name`, `email`, `phone`, `birthday`, `gender`, `user_id`, `wallet`, `status`, `address_status`, `image_user_profile`, `created_at`, `updated_at`, `bank_name`, `bank_account_name`, `bank_account_number`, `bank_code`) VALUES
(1, '67e99e48579c8', 'Nur Afianto', 'nurafianto@gmail.com', '85869101484', '2025-03-16', 'male', 23, 0, 1, 'yes', NULL, '2025-03-30 19:40:56', '2025-03-30 19:40:56', NULL, NULL, NULL, NULL),
(2, '67e9b02f0227f', 'Xion', 'xirfaroxas@gmail.com', '81248419335', '2025-03-31', 'male', 24, 0, 1, 'yes', '1tdDLnJdLELNcLM33dkK14Gajr7HKwfBRp91knew.png', '2025-03-30 20:57:19', '2025-04-08 08:23:25', NULL, NULL, NULL, NULL),
(3, '67ee4ad46e87f', 'buyer1', 'buyer1@gmail.com', '81248419335', '2025-04-03', 'male', 26, 0, 1, 'yes', NULL, '2025-04-03 08:46:12', '2025-04-03 08:46:12', NULL, NULL, NULL, NULL),
(4, '67f52210405fe', 'jatquh', 'jatquh@gmail.com', '81248419334', '2025-04-08', 'male', 27, 0, 1, 'yes', NULL, '2025-04-08 13:18:08', '2025-04-08 13:18:08', NULL, NULL, NULL, NULL),
(6, '67fbb6ffb1a47', 'Nur', 'fadildwi121@gmail.com', '85869101484', '2025-04-01', 'male', 29, 0, 1, 'yes', NULL, '2025-04-13 13:07:11', '2025-04-13 13:07:11', NULL, NULL, NULL, NULL),
(7, '6804e037f2cd8', 'indy', 'indyi0516@gmail.com', NULL, NULL, NULL, 30, 0, 1, 'yes', NULL, '2025-04-20 11:53:27', '2025-04-20 11:53:27', NULL, NULL, NULL, NULL),
(8, '6804e24edc633', 'dany', 'danielgebze05@gmail.com', NULL, NULL, NULL, 31, 0, 1, 'yes', NULL, '2025-04-20 12:02:22', '2025-04-20 12:02:22', NULL, NULL, NULL, NULL),
(9, '68c900e6715b0', 'ekraf', 'kominfontago@gmail.com', NULL, NULL, NULL, 32, 0, 1, 'yes', NULL, '2025-09-16 06:17:10', '2025-09-16 06:17:10', NULL, NULL, NULL, NULL),
(10, '6909ebcc2204a', 'buyer', 'buyerolebsai@gmail.com', NULL, NULL, NULL, 35, 0, 1, 'yes', NULL, '2025-11-04 12:04:28', '2026-01-05 06:32:07', NULL, NULL, NULL, NULL),
(11, '69380e8f19e3d', 'freeza', 'terataritore@gmail.com', NULL, NULL, NULL, 38, 0, 1, 'yes', NULL, '2025-12-09 11:57:03', '2025-12-09 11:57:03', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

DROP TABLE IF EXISTS `customer_addresses`;
CREATE TABLE IF NOT EXISTS `customer_addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `road` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `customer_id`, `name`, `phone`, `road`, `city`, `province`, `province_id`, `city_id`, `district_id`, `zip_code`, `address`, `status`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nur Afianto', '085869101484', 'Salatiga', 'Kabupaten Boyolali', 'Central Java', NULL, NULL, NULL, '57352', 'Gondang Sari, Jlarem, Gladagsari, Boyolali, RT01, RW03', 1, 'no', '2025-03-30 19:43:19', '2025-05-20 10:02:11'),
(3, 3, 'merauke', '081233221144', 'merauke', 'merauke', 'papua', NULL, NULL, NULL, '99606', 'merauke', 1, 'no', '2025-04-04 04:33:36', '2025-04-04 04:33:36'),
(4, 3, '2', '2', '2', '2', '2', NULL, NULL, NULL, '2', '2', 1, 'no', '2025-04-04 04:34:50', '2025-04-04 04:34:50'),
(5, 10, 'arif irfandy', '081248419434', 'CIBINONG', 'BOGOR', 'JAWA BARAT', 5, 77, 751, '99615', 'Ternate', 1, 'no', '2025-11-04 12:06:05', '2025-12-28 16:58:35'),
(6, 6, 'Nur', '085869101484', 'Kec', 'Kabupaten', 'Central Java', NULL, NULL, NULL, '11111', 'Testing', 1, 'no', '2025-12-04 18:40:14', '2025-12-04 18:40:14'),
(7, 11, 'freeza', '082113498393', 'menteng', 'jakarta', 'jakarta', NULL, NULL, NULL, '10230', 'Jakarta', 1, 'no', '2025-12-09 11:58:06', '2025-12-09 11:58:06'),
(10, 10, 'Reza', '082110325253', 'JAGAKARSA', 'JAKARTA SELATAN', 'DKI JAKARTA', 10, 136, 1330, '14335', 'RUKAN PURI Aulia', 1, 'no', '2025-12-28 15:03:12', '2026-01-10 10:07:55'),
(11, 10, 'sandra', '08338938555', 'CIKANDE', 'SERANG', 'BANTEN', 11, 148, 1468, '34366', 'JL. Cempaka', 1, 'yes', '2025-12-29 08:32:14', '2026-01-10 10:07:55'),
(12, 10, 'devina', '08383957905', 'KILO', 'DOMPU', 'NUSA TENGGARA BARAT (NTB)', 1, 3, 15, '22222', 'fegwegewgewgw', 1, 'no', '2025-12-29 08:41:01', '2025-12-29 09:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `customer_balances`
--

DROP TABLE IF EXISTS `customer_balances`;
CREATE TABLE IF NOT EXISTS `customer_balances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint NOT NULL,
  `transaction_id` bigint DEFAULT NULL,
  `customer_withdraw_id` bigint DEFAULT NULL,
  `amount` double NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_balances_transaction_id_unique` (`transaction_id`),
  UNIQUE KEY `customer_balances_customer_withdraw_id_unique` (`customer_withdraw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_withdraws`
--

DROP TABLE IF EXISTS `customer_withdraws`;
CREATE TABLE IF NOT EXISTS `customer_withdraws` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `success_at` datetime DEFAULT NULL,
  `approval_by` bigint DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_withdraws_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_trackings`
--

DROP TABLE IF EXISTS `delivery_trackings`;
CREATE TABLE IF NOT EXISTS `delivery_trackings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_trackings_transaction_id_foreign` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_trackings`
--

INSERT INTO `delivery_trackings` (`id`, `transaction_id`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 3, 'Sedang Dikemas', 'Pesanan sedang dikemas oleh penjual', '2025-04-02 11:02:28', '2025-04-02 11:02:28'),
(2, 3, 'Telah Diserahkan ke Jasa Kirim', 'Barang Telah diserahkan ke jasa kirim dengan nomor resi R00001', '2025-04-02 11:03:14', '2025-04-02 11:03:14'),
(3, 3, 'On Transit', 'Barang telah sampai di DC Capung 1', '2025-04-02 11:04:44', '2025-04-02 11:04:44'),
(4, 3, 'Received', 'Barang telah diterima', '2025-04-02 11:09:32', '2025-04-02 11:09:32'),
(5, 4, 'Sedang Dikemas', 'Pesanan sedang dikemas oleh penjual', '2025-04-03 09:09:57', '2025-04-03 09:09:57'),
(6, 4, 'Telah Diserahkan ke Jasa Kirim', 'Barang Telah diserahkan ke jasa kirim dengan nomor resi 1314', '2025-04-03 09:12:30', '2025-04-03 09:12:30'),
(7, 4, 'On Transit', 'paket sedang di transit', '2025-04-03 09:14:03', '2025-04-03 09:14:03'),
(8, 4, 'Received', 'barang telah sampai', '2025-04-03 09:16:37', '2025-04-03 09:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klaster_ekraf`
--

DROP TABLE IF EXISTS `klaster_ekraf`;
CREATE TABLE IF NOT EXISTS `klaster_ekraf` (
  `id` int NOT NULL,
  `nama_klaster` varchar(255) NOT NULL,
  `deskripsi_klaster` int DEFAULT NULL,
  `status_aktif` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `klaster_ekraf`
--

INSERT INTO `klaster_ekraf` (`id`, `nama_klaster`, `deskripsi_klaster`, `status_aktif`, `created_at`, `updated_at`) VALUES
(0, 'Fisik', NULL, 'no', '2025-12-14 10:59:54', NULL),
(0, 'Jasa', NULL, 'no', '2025-12-14 10:59:54', NULL),
(0, 'Digital', NULL, 'no', '2025-12-14 11:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_01_24_182022_create_sellers_table', 1),
(6, '2025_01_27_143112_create_permission_tables', 1),
(7, '2025_01_28_185143_create_setting_categories_table', 1),
(8, '2025_01_28_185243_create_setting_unit_logs_table', 1),
(9, '2025_01_28_185311_create_setting_category_logs_table', 1),
(10, '2025_01_29_131815_create_setting_units_table', 1),
(11, '2025_02_02_175112_create_products_table', 1),
(12, '2025_02_02_182343_create_product_logs_table', 1),
(13, '2025_02_17_154209_create_customers_table', 1),
(14, '2025_02_17_154212_create_customer_addresses_table', 1),
(15, '2025_02_23_162749_create_banner_table', 1),
(16, '2025_02_24_133754_create_seller_banner_table', 1),
(17, '2025_02_27_164209_create_cart_products_table', 1),
(18, '2025_02_27_164225_create_transactions_table', 1),
(19, '2025_02_27_164232_create_transaction_products_table', 1),
(20, '2025_03_02_044946_add_total_sells_to_products_table', 1),
(21, '2025_03_03_222202_add_slug_to_setting_categories', 1),
(22, '2025_03_03_222500_add_username_to_sellers', 1),
(23, '2025_03_07_163927_create_other_cost_table', 1),
(24, '2025_03_07_163956_create_delivery_tracking_table', 1),
(25, '2025_03_07_164142_create_transaction_logs_table', 1),
(26, '2025_03_08_090216_add_seller_id_to_cart_products', 1),
(27, '2025_03_11_151226_create_seller_balances_table', 1),
(28, '2025_03_11_160447_create_seller_withdraws_table', 1),
(29, '2025_03_20_145217_create_setting_information_bars_table', 1),
(30, '2025_03_20_150645_create_notification_users_table', 1),
(31, '2025_03_20_150655_create_notification_sellers_table', 1),
(32, '2025_03_20_151216_create_notification_admins_table', 1),
(33, '2025_03_24_013850_create_setting_about_us_table', 1),
(34, '2025_03_24_180935_add_shipping_attachment_to_transactions_table', 1),
(35, '2025_03_25_174612_add_shipping_status_to_transactions_table', 1),
(36, '2025_03_28_084408_add_image_user_profile_column_to_customers_table', 1),
(37, '2025_03_29_150814_add_note_to_seller_withdraws', 1),
(38, '2025_03_29_231517_remove_subtitle_from_seller_banner', 1),
(39, '2025_03_30_090141_create_setting_contact_admins_table', 1),
(40, '2025_04_05_191306_add_verification_to_users_table', 2),
(41, '2025_04_08_142448_create_verification_codes_table', 2),
(42, '2025_04_16_223405_create_customer_balance_table', 3),
(43, '2025_04_16_223737_create_customer_withdraws_table', 3),
(44, '2025_04_17_232358_create_vouchers_table', 3),
(45, '2025_04_25_192431_add_bank_information_seller_table', 4),
(46, '2025_04_25_192440_add_bank_information_customer_table', 4),
(47, '2025_04_25_192501_add_voucher_id_transaction_table', 4),
(48, '2025_04_25_194910_add_note_column_customer_withdraw_table', 4),
(49, '2025_04_28_230159_create_setting_cost_table', 4),
(50, '2025_04_29_220917_add_column_admin_cost_product_table', 4),
(51, '2025_04_29_224227_add_column_admin_cost_transaction_product_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21);

-- --------------------------------------------------------

--
-- Table structure for table `notification_admins`
--

DROP TABLE IF EXISTS `notification_admins`;
CREATE TABLE IF NOT EXISTS `notification_admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('info','warning','error','success') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_admins`
--

INSERT INTO `notification_admins` (`id`, `is_read`, `title`, `content`, `type`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Add Product', 'Product MIE has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-03-30 19:38:45', '2025-03-30 19:39:35'),
(2, 1, 'Order Confirmation', 'Order #CO202503310243001931 has been confirmed by seller', 'success', '/admin/transactions/1', NULL, '2025-03-30 19:45:15', '2025-03-30 19:45:41'),
(3, 1, 'Order Confirmation', 'Order #CO202503310303008862 has been confirmed by seller', 'success', '/admin/transactions/2', NULL, '2025-03-30 20:04:40', '2025-03-30 20:05:02'),
(4, 1, 'Order Confirmation', 'Order #CO202504021756007303 has been confirmed by seller', 'success', '/admin/transactions/3', NULL, '2025-04-02 10:58:16', '2025-04-02 10:59:00'),
(5, 1, 'Order Delivery', 'Order #CO202504021756007303 has been delivery by seller', 'info', '/admin/transactions/3', NULL, '2025-04-02 11:03:14', '2025-04-02 11:03:54'),
(6, 0, 'Registration Seller', 'Seller xion has been registered', 'info', '/admin/sellers/confirmation/', NULL, '2025-04-03 08:40:03', '2025-04-03 08:40:03'),
(7, 0, 'Add Product', 'Product Noken has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-04-03 08:49:59', '2025-04-03 08:49:59'),
(8, 0, 'Order Confirmation', 'Order #CO202504031601002914 has been confirmed by seller', 'success', '/admin/transactions/4', NULL, '2025-04-03 09:03:12', '2025-04-03 09:03:12'),
(9, 0, 'Order Delivery', 'Order #CO202504031601002914 has been delivery by seller', 'info', '/admin/transactions/4', NULL, '2025-04-03 09:12:30', '2025-04-03 09:12:30'),
(10, 0, 'Withdrawal Request', 'Withdrawal request from seller xion with amount Rp 10.000', 'info', '/admin/withdraw', NULL, '2025-04-03 09:18:39', '2025-04-03 09:18:39'),
(11, 0, 'Registration Seller', 'Seller toko noken has been registered', 'info', '/admin/sellers/confirmation/', NULL, '2025-11-04 06:14:38', '2025-11-04 06:14:38'),
(12, 0, 'Add Product', 'Product noken asli papua has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-11-04 11:49:52', '2025-11-04 11:49:52'),
(13, 0, 'Order Confirmation', 'Order #CO202511041906008475 has been confirmed by seller', 'success', '/admin/transactions/5', NULL, '2025-11-04 12:09:43', '2025-11-04 12:09:43'),
(14, 1, 'Order Confirmation', 'Order #CO202512050140006956 has been confirmed by seller', 'success', '/admin/transactions/6', NULL, '2025-12-09 11:44:14', '2025-12-09 11:44:27'),
(15, 0, 'Registration Seller', 'Seller reeza has been registered', 'info', '/admin/sellers/confirmation/', NULL, '2025-12-09 11:53:10', '2025-12-09 11:53:10'),
(16, 0, 'Registration Seller', 'Seller reeza has been registered', 'info', '/admin/sellers/confirmation/', NULL, '2025-12-09 11:54:56', '2025-12-09 11:54:56'),
(17, 0, 'Order Confirmation', 'Order #CO2025120919010050213 has been confirmed by seller', 'success', '/admin/transactions/13', NULL, '2025-12-09 12:01:39', '2025-12-09 12:01:39'),
(18, 0, 'Add Product', 'Product test 001 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-17 05:47:05', '2025-12-17 05:47:05'),
(19, 0, 'Order Confirmation', 'Order #CO2025121713470032515 has been confirmed by seller', 'success', '/admin/transactions/15', NULL, '2025-12-17 07:01:50', '2025-12-17 07:01:50'),
(20, 0, 'Order Confirmation', 'Order #CO2025121714490016116 has been confirmed by seller', 'success', '/admin/transactions/16', NULL, '2025-12-17 07:55:30', '2025-12-17 07:55:30'),
(21, 0, 'Add Product', 'Product test 002 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-18 08:29:33', '2025-12-18 08:29:33'),
(22, 0, 'Add Product', 'Product test 003 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-18 08:33:39', '2025-12-18 08:33:39'),
(23, 0, 'Add Product', 'Product testing 003 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-18 08:38:55', '2025-12-18 08:38:55'),
(24, 0, 'Add Product', 'Product testing 005 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-18 09:33:14', '2025-12-18 09:33:14'),
(25, 0, 'Add Product', 'Product test 07 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-19 11:44:19', '2025-12-19 11:44:19'),
(26, 1, 'Add Product', 'Product test0008 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-19 11:56:30', '2025-12-19 12:00:20'),
(27, 1, 'Add Product', 'Product test 009 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-19 12:21:15', '2025-12-19 12:24:41'),
(28, 0, 'Add Product', 'Product testing 01 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-20 03:54:11', '2025-12-20 03:54:11'),
(29, 0, 'Add Product', 'Product testing 0001 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-20 06:55:41', '2025-12-20 06:55:41'),
(30, 0, 'Order Confirmation', 'Order #CO2025122014210057117 has been confirmed by seller', 'success', '/admin/transactions/17', NULL, '2025-12-20 07:23:33', '2025-12-20 07:23:33'),
(31, 0, 'Add Product', 'Product testing 0001 minggu has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-21 09:50:09', '2025-12-21 09:50:09'),
(32, 0, 'Add Product', 'Product gweg ewgew 555 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:24:47', '2025-12-25 12:24:47'),
(33, 0, 'Add Product', 'Product gewg4wv264b  65 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:38:51', '2025-12-25 12:38:51'),
(34, 0, 'Add Product', 'Product egwvwrtrwvtw89 89 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:40:40', '2025-12-25 12:40:40'),
(35, 0, 'Add Product', 'Product dafdag agadg a 89 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:43:45', '2025-12-25 12:43:45'),
(36, 0, 'Add Product', 'Product daadfadfagerwgw 66 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:46:49', '2025-12-25 12:46:49'),
(37, 0, 'Add Product', 'Product dgageg eqgewgwe 78 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:50:11', '2025-12-25 12:50:11'),
(38, 0, 'Add Product', 'Product safsafafaga 78 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:53:57', '2025-12-25 12:53:57'),
(39, 0, 'Add Product', 'Product rqwqrwqrwq 56 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:55:46', '2025-12-25 12:55:46'),
(40, 0, 'Add Product', 'Product sfadgadgadg 33 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 12:59:09', '2025-12-25 12:59:09'),
(41, 0, 'Add Product', 'Product dvdavadgegwe 56 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-25 13:01:36', '2025-12-25 13:01:36'),
(42, 0, 'Add Product', 'Product baru again 1 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2025-12-27 09:45:52', '2025-12-27 09:45:52'),
(43, 0, 'Add Product', 'Product cwiqgwqw q99 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-08 09:46:27', '2026-01-08 09:46:27'),
(44, 0, 'Add Product', 'Product dvioihphfep p 88 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-08 09:50:31', '2026-01-08 09:50:31'),
(45, 0, 'Add Product', 'Product wfowqyfqwifpw q 90 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-08 09:51:53', '2026-01-08 09:51:53'),
(46, 0, 'Add Product', 'Product foeo eihgqe q89 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-08 09:56:38', '2026-01-08 09:56:38'),
(47, 0, 'Add Product', 'Product dhvqeoihfeqpofqe 99 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-08 09:57:58', '2026-01-08 09:57:58'),
(48, 0, 'Add Product', 'Product testing reza 01 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-10 14:27:00', '2026-01-10 14:27:00'),
(49, 0, 'Add Product', 'Product digitalsubstime 01 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 06:05:10', '2026-01-14 06:05:10'),
(50, 0, 'Add Product', 'Product digitalsubstime 03 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 06:10:10', '2026-01-14 06:10:10'),
(51, 0, 'Add Product', 'Product digitalsubstime 04 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 06:19:47', '2026-01-14 06:19:47'),
(52, 0, 'Add Product', 'Product digitalsubstime 06 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 06:22:06', '2026-01-14 06:22:06'),
(53, 0, 'Add Product', 'Product digital 555 has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 10:44:02', '2026-01-14 10:44:02'),
(54, 0, 'Add Product', 'Product digital aaa has been submited by seller', 'info', '/admin/products/confirmation/', NULL, '2026-01-14 10:56:11', '2026-01-14 10:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `notification_sellers`
--

DROP TABLE IF EXISTS `notification_sellers`;
CREATE TABLE IF NOT EXISTS `notification_sellers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('info','warning','error','success') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_sellers`
--

INSERT INTO `notification_sellers` (`id`, `user_id`, `is_read`, `title`, `content`, `type`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 22, 1, 'Product Approved', 'Product #S-001 (MIE) has been approved by admin', 'success', '/seller/products/', NULL, '2025-03-30 19:39:39', '2025-04-02 11:01:46'),
(2, 22, 1, 'New Order', 'You have a new order', 'success', '/seller/transaction/1', NULL, '2025-03-30 19:43:35', '2025-03-30 19:44:08'),
(3, 22, 1, 'New Order', 'You have a new order', 'success', '/seller/transactions/2', NULL, '2025-03-30 20:03:15', '2025-03-30 20:04:22'),
(4, 22, 1, 'New Order', 'You have a new order', 'success', '/seller/transactions/3', NULL, '2025-04-02 10:56:44', '2025-04-02 10:57:35'),
(5, 25, 0, 'Product Approved', 'Product #oleh oleh (Noken) has been approved by admin', 'success', '/seller/products/', NULL, '2025-04-03 08:56:36', '2025-04-03 08:56:36'),
(6, 25, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/4', NULL, '2025-04-03 09:01:03', '2025-04-03 09:01:03'),
(7, 34, 0, 'Product Approved', 'Product #001 (noken asli papua) has been approved by admin', 'success', '/seller/products/', NULL, '2025-11-04 11:50:28', '2025-11-04 11:50:28'),
(8, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/5', NULL, '2025-11-04 12:06:54', '2025-11-04 12:06:54'),
(9, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/6', NULL, '2025-12-04 18:40:47', '2025-12-04 18:40:47'),
(10, 3, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/7', NULL, '2025-12-09 11:37:38', '2025-12-09 11:37:38'),
(11, 3, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/10', NULL, '2025-12-09 11:38:31', '2025-12-09 11:38:31'),
(12, 3, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/11', NULL, '2025-12-09 11:39:06', '2025-12-09 11:39:06'),
(13, 3, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/12', NULL, '2025-12-09 11:58:46', '2025-12-09 11:58:46'),
(14, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/13', NULL, '2025-12-09 12:01:14', '2025-12-09 12:01:14'),
(15, 3, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/14', NULL, '2025-12-09 12:11:10', '2025-12-09 12:11:10'),
(16, 34, 0, 'Product Approved', 'Product #test001 (test 001) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-17 06:12:49', '2025-12-17 06:12:49'),
(17, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/15', NULL, '2025-12-17 06:47:22', '2025-12-17 06:47:22'),
(18, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/16', NULL, '2025-12-17 07:49:05', '2025-12-17 07:49:05'),
(19, 34, 0, 'Product Approved', 'Product #test 0008 (test0008) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-19 12:00:32', '2025-12-19 12:00:32'),
(20, 34, 1, 'Product Approved', 'Product #test009 (test 009) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-19 12:24:52', '2025-12-19 12:25:08'),
(21, 34, 0, 'Product Approved', 'Product #testing0001 (testing 0001) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-20 06:56:40', '2025-12-20 06:56:40'),
(22, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/17', NULL, '2025-12-20 07:21:42', '2025-12-20 07:21:42'),
(23, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/18', NULL, '2025-12-20 07:31:14', '2025-12-20 07:31:14'),
(24, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/19', NULL, '2025-12-20 07:33:29', '2025-12-20 07:33:29'),
(25, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/20', NULL, '2025-12-20 07:43:17', '2025-12-20 07:43:17'),
(26, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/21', NULL, '2025-12-20 07:51:33', '2025-12-20 07:51:33'),
(27, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/22', NULL, '2025-12-20 08:16:44', '2025-12-20 08:16:44'),
(28, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/23', NULL, '2025-12-20 08:18:18', '2025-12-20 08:18:18'),
(29, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/24', NULL, '2025-12-20 08:23:38', '2025-12-20 08:23:38'),
(30, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/25', NULL, '2025-12-20 08:24:56', '2025-12-20 08:24:56'),
(31, 34, 0, 'Product Approved', 'Product #testing0001minggu (testing 0001 minggu) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-21 09:59:46', '2025-12-21 09:59:46'),
(32, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/26', NULL, '2025-12-21 10:00:37', '2025-12-21 10:00:37'),
(33, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/27', NULL, '2025-12-21 10:33:30', '2025-12-21 10:33:30'),
(34, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/28', NULL, '2025-12-21 11:28:18', '2025-12-21 11:28:18'),
(35, 34, 0, 'Product Approved', 'Product #sdvdsgsdgewtwetgw56 (dvdavadgegwe 56) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-25 14:23:17', '2025-12-25 14:23:17'),
(36, 34, 0, 'Product Approved', 'Product #baruagain1 (baru again 1) has been approved by admin', 'success', '/seller/products/', NULL, '2025-12-27 09:59:40', '2025-12-27 09:59:40'),
(37, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/29', NULL, '2025-12-27 10:10:26', '2025-12-27 10:10:26'),
(38, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/30', NULL, '2025-12-27 10:31:08', '2025-12-27 10:31:08'),
(39, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/31', NULL, '2025-12-27 10:32:13', '2025-12-27 10:32:13'),
(40, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/32', NULL, '2025-12-27 10:42:36', '2025-12-27 10:42:36'),
(41, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/33', NULL, '2025-12-27 10:48:01', '2025-12-27 10:48:01'),
(42, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/34', NULL, '2026-01-04 16:31:36', '2026-01-04 16:31:36'),
(43, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/35', NULL, '2026-01-05 07:07:25', '2026-01-05 07:07:25'),
(44, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/38', NULL, '2026-01-05 08:38:24', '2026-01-05 08:38:24'),
(45, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/39', NULL, '2026-01-05 08:41:35', '2026-01-05 08:41:35'),
(46, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/40', NULL, '2026-01-05 08:45:25', '2026-01-05 08:45:25'),
(47, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/41', NULL, '2026-01-05 08:54:20', '2026-01-05 08:54:20'),
(48, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/42', NULL, '2026-01-05 08:56:02', '2026-01-05 08:56:02'),
(49, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/43', NULL, '2026-01-05 08:58:48', '2026-01-05 08:58:48'),
(50, 34, 0, 'Product Approved', 'Product #ncihqeihp999 (dhvqeoihfeqpofqe 99) has been approved by admin', 'success', '/seller/products/', NULL, '2026-01-08 09:59:34', '2026-01-08 09:59:34'),
(51, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/44', NULL, '2026-01-10 10:12:16', '2026-01-10 10:12:16'),
(52, 34, 0, 'Product Approved', 'Product #testingreza01 (testing reza 01) has been approved by admin', 'success', '/seller/products/', NULL, '2026-01-10 14:30:05', '2026-01-10 14:30:05'),
(53, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/45', NULL, '2026-01-10 15:18:16', '2026-01-10 15:18:16'),
(54, 34, 0, 'Product Approved', 'Product #digitalsubstime03 (digitalsubstime 03) has been approved by admin', 'success', '/seller/products/', NULL, '2026-01-14 06:11:37', '2026-01-14 06:11:37'),
(55, 34, 0, 'Product Approved', 'Product #digitalsubstime06 (digitalsubstime 06) has been approved by admin', 'success', '/seller/products/', NULL, '2026-01-14 06:23:25', '2026-01-14 06:23:25'),
(56, 34, 0, 'Product Approved', 'Product #digitalaaa (digital aaa) has been approved by admin', 'success', '/seller/products/', NULL, '2026-01-14 11:02:08', '2026-01-14 11:02:08'),
(57, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/46', NULL, '2026-01-15 07:59:13', '2026-01-15 07:59:13'),
(58, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/47', NULL, '2026-01-15 08:34:59', '2026-01-15 08:34:59'),
(59, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/48', NULL, '2026-01-15 08:35:56', '2026-01-15 08:35:56'),
(60, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/49', NULL, '2026-01-15 08:41:59', '2026-01-15 08:41:59'),
(61, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/50', NULL, '2026-01-15 08:43:06', '2026-01-15 08:43:06'),
(62, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/51', NULL, '2026-01-15 08:46:44', '2026-01-15 08:46:44'),
(63, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/52', NULL, '2026-01-15 08:52:43', '2026-01-15 08:52:43'),
(64, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/53', NULL, '2026-01-15 09:07:33', '2026-01-15 09:07:33'),
(65, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/54', NULL, '2026-01-15 09:28:24', '2026-01-15 09:28:24'),
(66, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/55', NULL, '2026-01-15 09:36:56', '2026-01-15 09:36:56'),
(67, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/56', NULL, '2026-01-15 09:37:49', '2026-01-15 09:37:49'),
(68, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/57', NULL, '2026-01-15 09:41:21', '2026-01-15 09:41:21'),
(69, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/58', NULL, '2026-01-15 09:43:11', '2026-01-15 09:43:11'),
(70, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/59', NULL, '2026-01-15 09:45:25', '2026-01-15 09:45:25'),
(71, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/60', NULL, '2026-01-15 09:53:49', '2026-01-15 09:53:49'),
(72, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/61', NULL, '2026-01-15 09:58:40', '2026-01-15 09:58:40'),
(73, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/62', NULL, '2026-01-15 10:00:15', '2026-01-15 10:00:15'),
(74, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/63', NULL, '2026-01-15 10:02:26', '2026-01-15 10:02:26'),
(75, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/64', NULL, '2026-01-15 10:03:06', '2026-01-15 10:03:06'),
(76, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/65', NULL, '2026-01-15 10:04:31', '2026-01-15 10:04:31'),
(77, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/66', NULL, '2026-01-15 10:07:18', '2026-01-15 10:07:18'),
(78, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/67', NULL, '2026-01-15 13:16:15', '2026-01-15 13:16:15'),
(79, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/68', NULL, '2026-01-15 13:35:41', '2026-01-15 13:35:41'),
(80, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/69', NULL, '2026-01-15 13:43:36', '2026-01-15 13:43:36'),
(81, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/70', NULL, '2026-01-16 16:35:39', '2026-01-16 16:35:39'),
(82, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/71', NULL, '2026-01-16 17:05:44', '2026-01-16 17:05:44'),
(83, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/75', NULL, '2026-01-16 17:27:43', '2026-01-16 17:27:43'),
(84, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/76', NULL, '2026-01-16 17:51:13', '2026-01-16 17:51:13'),
(85, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/81', NULL, '2026-01-17 05:17:01', '2026-01-17 05:17:01'),
(86, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/82', NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(87, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/83', NULL, '2026-01-17 11:43:59', '2026-01-17 11:43:59'),
(88, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/84', NULL, '2026-01-17 11:46:55', '2026-01-17 11:46:55'),
(89, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/85', NULL, '2026-01-17 11:48:23', '2026-01-17 11:48:23'),
(90, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/86', NULL, '2026-01-17 11:49:03', '2026-01-17 11:49:03'),
(91, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/87', NULL, '2026-01-17 11:53:25', '2026-01-17 11:53:25'),
(92, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/88', NULL, '2026-01-17 11:55:09', '2026-01-17 11:55:09'),
(93, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/89', NULL, '2026-01-17 11:56:23', '2026-01-17 11:56:23'),
(94, 34, 0, 'New Order', 'You have a new order', 'success', '/seller/transactions/90', NULL, '2026-01-17 11:57:33', '2026-01-17 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `notification_users`
--

DROP TABLE IF EXISTS `notification_users`;
CREATE TABLE IF NOT EXISTS `notification_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('info','warning','error','success') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_users`
--

INSERT INTO `notification_users` (`id`, `user_id`, `is_read`, `title`, `content`, `type`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 23, 1, 'Order Confirmation', 'Order #CO202503310243001931 has been confirmed by seller', 'success', '/order-history', NULL, '2025-03-30 19:45:15', '2025-03-30 19:50:03'),
(2, 1, 0, 'Order Confirmed', 'Order #CO202503310243001931 has been confirmed by admin', 'success', '/order-history', NULL, '2025-03-30 19:47:17', '2025-03-30 19:47:17'),
(3, 23, 1, 'Order Confirmation', 'Order #CO202503310303008862 has been confirmed by seller', 'success', '/order-history', NULL, '2025-03-30 20:04:40', '2025-03-30 20:07:56'),
(4, 1, 0, 'Order Confirmed', 'Order #CO202503310303008862 has been confirmed by admin', 'success', '/order-history', NULL, '2025-03-30 20:05:10', '2025-03-30 20:05:10'),
(5, 23, 1, 'Order Confirmation', 'Order #CO202504021756007303 has been confirmed by seller', 'success', '/order-history', NULL, '2025-04-02 10:58:16', '2025-04-02 10:59:59'),
(6, 1, 0, 'Order Confirmed', 'Order #CO202504021756007303 has been confirmed by admin', 'success', '/order-history', NULL, '2025-04-02 10:59:23', '2025-04-02 10:59:23'),
(7, 23, 0, 'Order Packing', 'Order #CO202504021756007303 has been packing by seller', 'info', '/order-history', NULL, '2025-04-02 11:02:28', '2025-04-02 11:02:28'),
(8, 23, 1, 'Order Delivery', 'Order #CO202504021756007303 has been delivery by seller', 'info', '/order-history', NULL, '2025-04-02 11:03:14', '2025-04-02 11:05:14'),
(9, 23, 1, 'Transaction Received', 'Transaction  has been arrived to your address', 'success', '/order-history', NULL, '2025-04-02 11:09:32', '2025-04-02 11:09:59'),
(10, 26, 1, 'Order Confirmation', 'Order #CO202504031601002914 has been confirmed by seller', 'success', '/order-history', NULL, '2025-04-03 09:03:12', '2025-04-03 09:05:25'),
(11, 3, 0, 'Order Confirmed', 'Order #CO202504031601002914 has been confirmed by admin', 'success', '/order-history', NULL, '2025-04-03 09:05:08', '2025-04-03 09:05:08'),
(12, 26, 1, 'Order Packing', 'Order #CO202504031601002914 has been packing by seller', 'info', '/order-history', NULL, '2025-04-03 09:09:57', '2025-04-03 09:10:46'),
(13, 26, 1, 'Order Delivery', 'Order #CO202504031601002914 has been delivery by seller', 'info', '/order-history', NULL, '2025-04-03 09:12:30', '2025-04-03 09:14:20'),
(14, 26, 1, 'Transaction Received', 'Transaction  has been arrived to your address', 'success', '/order-history', NULL, '2025-04-03 09:16:37', '2025-04-03 09:17:00'),
(15, 35, 1, 'Order Confirmation', 'Order #CO202511041906008475 has been confirmed by seller', 'success', '/order-history', NULL, '2025-11-04 12:09:43', '2025-12-29 05:45:43'),
(16, 10, 0, 'Order Confirmed', 'Order #CO202511041906008475 has been confirmed by admin', 'success', '/order-history', NULL, '2025-11-04 12:11:24', '2025-11-04 12:11:24'),
(17, 29, 0, 'Order Confirmation', 'Order #CO202512050140006956 has been confirmed by seller', 'success', '/order-history', NULL, '2025-12-09 11:44:14', '2025-12-09 11:44:14'),
(18, 6, 0, 'Order Confirmed', 'Order #CO202512050140006956 has been confirmed by admin', 'success', '/order-history', NULL, '2025-12-09 11:44:45', '2025-12-09 11:44:45'),
(19, 38, 0, 'Order Confirmation', 'Order #CO2025120919010050213 has been confirmed by seller', 'success', '/order-history', NULL, '2025-12-09 12:01:39', '2025-12-09 12:01:39'),
(20, 11, 0, 'Order Confirmed', 'Order #CO2025120919010050213 has been confirmed by admin', 'success', '/order-history', NULL, '2025-12-09 12:04:44', '2025-12-09 12:04:44'),
(21, 35, 1, 'Order Confirmation', 'Order #CO2025121713470032515 has been confirmed by seller', 'success', '/order-history', NULL, '2025-12-17 07:01:50', '2025-12-29 05:45:43'),
(22, 10, 0, 'Order Confirmed', 'Order #CO2025121713470032515 has been confirmed by admin', 'success', '/order-history', NULL, '2025-12-17 07:41:11', '2025-12-17 07:41:11'),
(23, 35, 1, 'Order Confirmation', 'Order #CO2025121714490016116 has been confirmed by seller', 'success', '/order-history', NULL, '2025-12-17 07:55:30', '2025-12-29 05:45:43'),
(24, 10, 0, 'Order Confirmed', 'Order #CO2025121714490016116 has been confirmed by admin', 'success', '/order-history', NULL, '2025-12-17 07:57:42', '2025-12-17 07:57:42'),
(25, 35, 1, 'Order Confirmation', 'Order #CO2025122014210057117 has been confirmed by seller', 'success', '/order-history', NULL, '2025-12-20 07:23:33', '2025-12-29 05:45:43'),
(26, 10, 0, 'Order Confirmed', 'Order #CO2025122014210057117 has been confirmed by admin', 'success', '/order-history', NULL, '2025-12-20 07:26:00', '2025-12-20 07:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `other_costs`
--

DROP TABLE IF EXISTS `other_costs`;
CREATE TABLE IF NOT EXISTS `other_costs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `other_costs_transaction_id_foreign` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_costs`
--

INSERT INTO `other_costs` (`id`, `transaction_id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Other', 50, '2025-03-30 19:45:00', '2025-03-30 19:45:00'),
(2, 2, 'Admin', 100, '2025-03-30 20:04:31', '2025-03-30 20:04:31'),
(3, 3, 'Admin', 100, '2025-04-02 10:57:54', '2025-04-02 10:57:54'),
(6, 4, 'packing kayu', 1, '2025-04-03 09:04:42', '2025-04-03 09:04:42'),
(7, 4, 'bubble', 1, '2025-04-03 09:04:56', '2025-04-03 09:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_cost_id` bigint UNSIGNED DEFAULT NULL,
  `seller_id` int NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int NOT NULL,
  `category_id` int NOT NULL,
  `sub_category_id` int DEFAULT NULL,
  `unit_id` int NOT NULL,
  `weight` int NOT NULL,
  `stock` int NOT NULL,
  `price` bigint NOT NULL,
  `seller_price` double DEFAULT NULL,
  `admin_cost` double DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digitals` longtext COLLATE utf8mb4_unicode_ci,
  `subtimes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_1` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_2` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_3` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_4` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `total_sells` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `admin_cost_id`, `seller_id`, `code`, `name`, `type_id`, `category_id`, `sub_category_id`, `unit_id`, `weight`, `stock`, `price`, `seller_price`, `admin_cost`, `slug`, `digitals`, `subtimes`, `file_1`, `file_2`, `file_3`, `file_4`, `image_1`, `image_2`, `image_3`, `image_4`, `description`, `note`, `status`, `total_sells`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'YUZK2DAHKN', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 32, 238121, 238121, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(2, NULL, 1, 'FGLKTITIMH', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 11, 241039, 241039, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(3, NULL, 1, 'IHZ2DXFAQ6', 'Power Bank Batik', 0, 4, NULL, 1, 0, 27, 483308, 483308, 0, 'power-bank-batik', NULL, NULL, '', NULL, NULL, NULL, 'power-bank-batik.jpg', NULL, NULL, NULL, 'Power bank dengan motif batik eksklusif yang unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(4, NULL, 1, 'MNNXY6MGOZ', 'Minyak Kayu Putih', 0, 5, NULL, 1, 0, 22, 426946, 426946, 0, 'minyak-kayu-putih', NULL, NULL, '', NULL, NULL, NULL, 'minyak-kayu-putih.jpg', NULL, NULL, NULL, 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(5, NULL, 1, 'UYGPUIIQBW', 'Essential Oil', 0, 5, NULL, 1, 0, 60, 195774, 195774, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(6, NULL, 2, 'YYTHVKYRXQ', 'Batik Solo', 0, 3, NULL, 1, 0, 15, 363682, 363682, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(7, NULL, 2, 'QA0GSRSAYX', 'Sarung Tenun', 0, 3, NULL, 1, 0, 73, 143830, 143830, 0, 'sarung-tenun', NULL, NULL, '', NULL, NULL, NULL, 'sarung-tenun.jpg', NULL, NULL, NULL, 'Sarung tradisional hasil tenunan tangan dengan motif elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(8, NULL, 2, '74BTSLZRPB', 'Kaos Lukis', 0, 3, NULL, 1, 0, 75, 421127, 421127, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(9, NULL, 2, 'I1Y6QL3XUK', 'Flashdisk Anyaman', 0, 4, NULL, 1, 0, 66, 116603, 116603, 0, 'flashdisk-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'flashdisk-anyaman.jpg', NULL, NULL, NULL, 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(10, NULL, 2, 'NTEN6EKF2X', 'Masker Herbal', 0, 5, NULL, 3, 0, 40, 271989, 271989, 0, 'masker-herbal', NULL, NULL, '', NULL, NULL, NULL, 'masker-herbal.jpg', NULL, NULL, NULL, 'Masker wajah dari bahan alami untuk perawatan kulit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(11, NULL, 2, 'EJ34UR48QS', 'Sabun Organik', 0, 5, NULL, 3, 0, 14, 349451, 349451, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(12, NULL, 2, '0AGSKZQ9SH', 'Essential Oil', 0, 5, NULL, 1, 0, 40, 260039, 260039, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(13, NULL, 3, 'YY4L5ILHAL', 'Dodol Betawi', 0, 1, NULL, 2, 0, 61, 344238, 344238, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(14, NULL, 3, '5NVDU1EG3J', 'Pempek Palembang', 0, 1, NULL, 2, 0, 21, 458181, 458181, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(15, NULL, 3, 'B629EEIHRU', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 16, 339870, 339870, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(16, NULL, 3, 'DDZNGF2OV5', 'Kain Ulos', 0, 3, NULL, 1, 0, 92, 192925, 192925, 0, 'kain-ulos', NULL, NULL, '', NULL, NULL, NULL, 'kain-ulos.jpg', NULL, NULL, NULL, 'Kain tradisional Batak yang sering digunakan dalam acara adat.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(17, NULL, 3, '9AFGCECOET', 'Batik Solo', 0, 3, NULL, 1, 0, 10, 422869, 422869, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(18, NULL, 4, 'URHA2IQAHA', 'Dodol Betawi', 0, 1, NULL, 2, 0, 68, 458498, 458498, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(19, NULL, 4, 'VYZE6V4AKD', 'Keripik Balado', 0, 1, NULL, 1, 0, 37, 405942, 405942, 0, 'keripik-balado', NULL, NULL, '', NULL, NULL, NULL, 'keripik-balado.jpg', NULL, NULL, NULL, 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(20, NULL, 4, 'IQIBZMMJPE', 'Jaket Kulit Garut', 0, 3, NULL, 1, 0, 80, 217829, 217829, 0, 'jaket-kulit-garut', NULL, NULL, '', NULL, NULL, NULL, 'jaket-kulit-garut.jpg', NULL, NULL, NULL, 'Jaket kulit asli dari Garut yang stylish dan tahan lama.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(21, NULL, 4, 'SZMTCAVBBB', 'Kaos Lukis', 0, 3, NULL, 1, 0, 96, 256516, 256516, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(22, NULL, 4, 'ZBCOU5X1VZ', 'Batik Solo', 0, 3, NULL, 1, 0, 25, 348235, 348235, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(23, NULL, 5, 'EVOK8HXA8K', 'Keripik Balado', 0, 1, NULL, 2, 0, 65, 100816, 100816, 0, 'keripik-balado', NULL, NULL, '', NULL, NULL, NULL, 'keripik-balado.jpg', NULL, NULL, NULL, 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(24, NULL, 5, 'ZBCJE4AX9R', 'Kaos Lukis', 0, 3, NULL, 1, 0, 43, 417677, 417677, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(25, NULL, 5, '1BUE0PPLUP', 'Sarung Tenun', 0, 3, NULL, 1, 0, 90, 354371, 354371, 0, 'sarung-tenun', NULL, NULL, '', NULL, NULL, NULL, 'sarung-tenun.jpg', NULL, NULL, NULL, 'Sarung tradisional hasil tenunan tangan dengan motif elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(26, NULL, 5, '2CZ28JWOPD', 'Lulur Tradisional', 0, 5, NULL, 1, 0, 56, 201987, 201987, 0, 'lulur-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lulur-tradisional.jpg', NULL, NULL, NULL, 'Lulur tubuh dari rempah-rempah pilihan untuk kulit lebih cerah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(27, NULL, 5, 'HXSYEFTWB1', 'Essential Oil', 0, 5, NULL, 3, 0, 37, 226351, 226351, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(28, NULL, 5, 'IWW1650VXE', 'Masker Herbal', 0, 5, NULL, 3, 0, 23, 406509, 406509, 0, 'masker-herbal', NULL, NULL, '', NULL, NULL, NULL, 'masker-herbal.jpg', NULL, NULL, NULL, 'Masker wajah dari bahan alami untuk perawatan kulit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(29, NULL, 6, 'SX28ULU0XQ', 'Bakpia Pathok', 0, 1, NULL, 2, 0, 48, 276211, 276211, 0, 'bakpia-pathok', NULL, NULL, '', NULL, NULL, NULL, 'bakpia-pathok.jpg', NULL, NULL, NULL, 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(30, NULL, 6, 'H7OZKIOSHT', 'Pempek Palembang', 0, 1, NULL, 2, 0, 27, 476283, 476283, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(31, NULL, 6, 'EMGWWLXNLD', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 21, 240565, 240565, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(32, NULL, 6, 'EKTOPSVYBI', 'Batik Pekalongan', 0, 2, NULL, 1, 0, 94, 207052, 207052, 0, 'batik-pekalongan', NULL, NULL, '', NULL, NULL, NULL, 'batik-pekalongan.jpg', NULL, NULL, NULL, 'Kain batik khas Pekalongan dengan motif klasik dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(33, NULL, 6, 'BFANIB7LHN', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 20, 465104, 465104, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(34, NULL, 6, 'CVMZHKSVYO', 'Speaker Kayu', 0, 4, NULL, 1, 0, 19, 361042, 361042, 0, 'speaker-kayu', NULL, NULL, '', NULL, NULL, NULL, 'speaker-kayu.jpg', NULL, NULL, NULL, 'Speaker portable dengan casing kayu dan suara berkualitas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(35, NULL, 6, 'VUHYUIJXP1', 'Lampu Hias Unik', 0, 4, NULL, 1, 0, 73, 392688, 392688, 0, 'lampu-hias-unik', NULL, NULL, '', NULL, NULL, NULL, 'lampu-hias-unik.jpg', NULL, NULL, NULL, 'Lampu dekoratif handmade dari bahan kayu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(36, NULL, 6, '3CBZHXZDBC', 'Essential Oil', 0, 5, NULL, 3, 0, 25, 72626, 72626, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(37, NULL, 6, 'YVLX2MG5SL', 'Sabun Organik', 0, 5, NULL, 1, 0, 24, 113191, 113191, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(38, NULL, 7, 'HXLL9VX01R', 'Dodol Betawi', 0, 1, NULL, 2, 0, 10, 427540, 427540, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(39, NULL, 7, 'ZJ3EBX2MJI', 'Pempek Palembang', 0, 1, NULL, 2, 0, 20, 281808, 281808, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(40, NULL, 7, 'A8CGC73IZH', 'Batik Solo', 0, 3, NULL, 1, 0, 47, 137183, 137183, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(41, NULL, 7, 'KBFQFCJIPV', 'Speaker Kayu', 0, 4, NULL, 1, 0, 37, 161025, 161025, 0, 'speaker-kayu', NULL, NULL, '', NULL, NULL, NULL, 'speaker-kayu.jpg', NULL, NULL, NULL, 'Speaker portable dengan casing kayu dan suara berkualitas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(42, NULL, 7, 'FFEIRSWQPH', 'Flashdisk Anyaman', 0, 4, NULL, 1, 0, 46, 350640, 350640, 0, 'flashdisk-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'flashdisk-anyaman.jpg', NULL, NULL, NULL, 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(43, NULL, 7, '5WUDX3XBAJ', 'Masker Herbal', 0, 5, NULL, 1, 0, 93, 253349, 253349, 0, 'masker-herbal', NULL, NULL, '', NULL, NULL, NULL, 'masker-herbal.jpg', NULL, NULL, NULL, 'Masker wajah dari bahan alami untuk perawatan kulit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(44, NULL, 7, 'C321P9MGUK', 'Essential Oil', 0, 5, NULL, 3, 0, 49, 494695, 494695, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(45, NULL, 8, 'W8E10T63VL', 'Kain Ulos', 0, 3, NULL, 1, 0, 17, 375917, 375917, 0, 'kain-ulos', NULL, NULL, '', NULL, NULL, NULL, 'kain-ulos.jpg', NULL, NULL, NULL, 'Kain tradisional Batak yang sering digunakan dalam acara adat.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(46, NULL, 8, 'OHZ2P4FFMF', 'Kaos Lukis', 0, 3, NULL, 1, 0, 37, 410675, 410675, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(47, NULL, 8, 'B4HKL4ANCU', 'Batik Solo', 0, 3, NULL, 1, 0, 65, 67789, 67789, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(48, NULL, 8, 'NYE48AT73K', 'Sabun Organik', 0, 5, NULL, 1, 0, 60, 209895, 209895, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(49, NULL, 9, 'CGQUARQJNN', 'Bakpia Pathok', 0, 1, NULL, 2, 0, 89, 346650, 346650, 0, 'bakpia-pathok', NULL, NULL, '', NULL, NULL, NULL, 'bakpia-pathok.jpg', NULL, NULL, NULL, 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(50, NULL, 9, '6HVO7SX1FV', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 21, 229951, 229951, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(51, NULL, 9, 'QCSMHB8YKI', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 44, 190545, 190545, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(52, NULL, 9, 'X7VKWWPOVI', 'Jaket Kulit Garut', 0, 3, NULL, 1, 0, 11, 55858, 55858, 0, 'jaket-kulit-garut', NULL, NULL, '', NULL, NULL, NULL, 'jaket-kulit-garut.jpg', NULL, NULL, NULL, 'Jaket kulit asli dari Garut yang stylish dan tahan lama.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(53, NULL, 9, 'ORPBUX98MY', 'Batik Solo', 0, 3, NULL, 1, 0, 93, 141233, 141233, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(54, NULL, 10, 'Y539JGKEQ3', 'Dodol Betawi', 0, 1, NULL, 1, 0, 64, 275946, 275946, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(55, NULL, 10, 'WVQ68NAMOC', 'Pempek Palembang', 0, 1, NULL, 2, 0, 38, 346643, 346643, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(56, NULL, 10, 'AZTOW1IXE9', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 58, 116318, 116318, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(57, NULL, 10, 'H5ZGRDGFP8', 'Patung Kayu', 0, 2, NULL, 1, 0, 80, 156851, 156851, 0, 'patung-kayu', NULL, NULL, '', NULL, NULL, NULL, 'patung-kayu.jpg', NULL, NULL, NULL, 'Patung ukiran kayu dari pengrajin lokal, cocok untuk dekorasi rumah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(58, NULL, 10, 'W0RXYYEPBE', 'Power Bank Batik', 0, 4, NULL, 1, 0, 76, 276718, 276718, 0, 'power-bank-batik', NULL, NULL, '', NULL, NULL, NULL, 'power-bank-batik.jpg', NULL, NULL, NULL, 'Power bank dengan motif batik eksklusif yang unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(59, NULL, 10, 'H15ETETAL4', 'Speaker Kayu', 0, 4, NULL, 1, 0, 89, 339627, 339627, 0, 'speaker-kayu', NULL, NULL, '', NULL, NULL, NULL, 'speaker-kayu.jpg', NULL, NULL, NULL, 'Speaker portable dengan casing kayu dan suara berkualitas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(60, NULL, 10, 'OGMYVWTOG8', 'Flashdisk Anyaman', 0, 4, NULL, 1, 0, 26, 487856, 487856, 0, 'flashdisk-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'flashdisk-anyaman.jpg', NULL, NULL, NULL, 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(61, NULL, 10, 'NMPG2HNVGG', 'Lulur Tradisional', 0, 5, NULL, 3, 0, 62, 99847, 99847, 0, 'lulur-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lulur-tradisional.jpg', NULL, NULL, NULL, 'Lulur tubuh dari rempah-rempah pilihan untuk kulit lebih cerah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(62, NULL, 10, 'U0YGPKQNE5', 'Minyak Kayu Putih', 0, 5, NULL, 1, 0, 83, 421921, 421921, 0, 'minyak-kayu-putih', NULL, NULL, '', NULL, NULL, NULL, 'minyak-kayu-putih.jpg', NULL, NULL, NULL, 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(63, NULL, 10, 'K6J7KWIISG', 'Essential Oil', 0, 5, NULL, 3, 0, 55, 329827, 329827, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(64, NULL, 11, 'FHP9CVDINT', 'Dodol Betawi', 0, 1, NULL, 1, 0, 88, 123969, 123969, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(65, NULL, 11, 'IVBHTB7OIU', 'Kaos Lukis', 0, 3, NULL, 1, 0, 20, 325902, 325902, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(66, NULL, 11, 'UQX0ZNVGGY', 'Jaket Kulit Garut', 0, 3, NULL, 1, 0, 48, 195298, 195298, 0, 'jaket-kulit-garut', NULL, NULL, '', NULL, NULL, NULL, 'jaket-kulit-garut.jpg', NULL, NULL, NULL, 'Jaket kulit asli dari Garut yang stylish dan tahan lama.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(67, NULL, 12, 'DCKXVONPLA', 'Patung Kayu', 0, 2, NULL, 1, 0, 77, 187457, 187457, 0, 'patung-kayu', NULL, NULL, '', NULL, NULL, NULL, 'patung-kayu.jpg', NULL, NULL, NULL, 'Patung ukiran kayu dari pengrajin lokal, cocok untuk dekorasi rumah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(68, NULL, 12, 'C4IET0H0R4', 'Flashdisk Anyaman', 0, 4, NULL, 1, 0, 33, 381815, 381815, 0, 'flashdisk-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'flashdisk-anyaman.jpg', NULL, NULL, NULL, 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(69, NULL, 13, 'PXFBSAJKCB', 'Pempek Palembang', 0, 1, NULL, 1, 0, 69, 227335, 227335, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(70, NULL, 13, 'IRGVTWOXGY', 'Bakpia Pathok', 0, 1, NULL, 1, 0, 19, 256385, 256385, 0, 'bakpia-pathok', NULL, NULL, '', NULL, NULL, NULL, 'bakpia-pathok.jpg', NULL, NULL, NULL, 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(71, NULL, 13, 'GKFLV9YOI6', 'Dodol Betawi', 0, 1, NULL, 1, 0, 53, 482209, 482209, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(72, NULL, 13, 'SJVENWVQU7', 'Sarung Tenun', 0, 3, NULL, 1, 0, 43, 229506, 229506, 0, 'sarung-tenun', NULL, NULL, '', NULL, NULL, NULL, 'sarung-tenun.jpg', NULL, NULL, NULL, 'Sarung tradisional hasil tenunan tangan dengan motif elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(73, NULL, 13, '0SLKCOFNIN', 'Power Bank Batik', 0, 4, NULL, 1, 0, 59, 252193, 252193, 0, 'power-bank-batik', NULL, NULL, '', NULL, NULL, NULL, 'power-bank-batik.jpg', NULL, NULL, NULL, 'Power bank dengan motif batik eksklusif yang unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(74, NULL, 13, 'NNMGVPBOMH', 'Sabun Organik', 0, 5, NULL, 3, 0, 54, 75819, 75819, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(75, NULL, 14, 'LENYAQOTRR', 'Kopi Toraja', 0, 1, NULL, 2, 0, 74, 304660, 304660, 0, 'kopi-toraja', NULL, NULL, '', NULL, NULL, NULL, 'kopi-toraja.jpg', NULL, NULL, NULL, 'Kopi arabika premium dari Toraja dengan aroma khas dan rasa yang kaya.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(76, NULL, 14, '7IHEUUPB2X', 'Patung Kayu', 0, 2, NULL, 1, 0, 91, 137443, 137443, 0, 'patung-kayu', NULL, NULL, '', NULL, NULL, NULL, 'patung-kayu.jpg', NULL, NULL, NULL, 'Patung ukiran kayu dari pengrajin lokal, cocok untuk dekorasi rumah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(77, NULL, 14, 'BI5SNLSHMH', 'Batik Pekalongan', 0, 2, NULL, 1, 0, 44, 499560, 499560, 0, 'batik-pekalongan', NULL, NULL, '', NULL, NULL, NULL, 'batik-pekalongan.jpg', NULL, NULL, NULL, 'Kain batik khas Pekalongan dengan motif klasik dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(78, NULL, 14, 'SHZ4AYMX07', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 44, 480119, 480119, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(79, NULL, 14, 'TFH67SGZIO', 'Power Bank Batik', 0, 4, NULL, 1, 0, 80, 74875, 74875, 0, 'power-bank-batik', NULL, NULL, '', NULL, NULL, NULL, 'power-bank-batik.jpg', NULL, NULL, NULL, 'Power bank dengan motif batik eksklusif yang unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(80, NULL, 14, 'I8EFI8ODKY', 'Flashdisk Anyaman', 0, 4, NULL, 1, 0, 44, 473912, 473912, 0, 'flashdisk-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'flashdisk-anyaman.jpg', NULL, NULL, NULL, 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(81, NULL, 14, 'MVILGZM3PK', 'Essential Oil', 0, 5, NULL, 3, 0, 76, 358216, 358216, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(82, NULL, 15, 'WWU2FRGJKQ', 'Keripik Balado', 0, 1, NULL, 2, 0, 86, 258523, 258523, 0, 'keripik-balado', NULL, NULL, '', NULL, NULL, NULL, 'keripik-balado.jpg', NULL, NULL, NULL, 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(83, NULL, 15, 'VQELF3MH2P', 'Bakpia Pathok', 0, 1, NULL, 1, 0, 51, 382516, 382516, 0, 'bakpia-pathok', NULL, NULL, '', NULL, NULL, NULL, 'bakpia-pathok.jpg', NULL, NULL, NULL, 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(84, NULL, 15, 'DDXL17PHJC', 'Dodol Betawi', 0, 1, NULL, 2, 0, 38, 55260, 55260, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(85, NULL, 15, 'TSYCYOEJQC', 'Kerajinan Anyaman', 0, 2, NULL, 1, 0, 27, 320846, 320846, 0, 'kerajinan-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'kerajinan-anyaman.jpg', NULL, NULL, NULL, 'Anyaman tangan dari bahan alami seperti bambu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(86, NULL, 15, '3YK5S3WUZU', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 39, 457420, 457420, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(87, NULL, 15, 'LSINOBISZ2', 'Sabun Organik', 0, 5, NULL, 1, 0, 92, 395028, 395028, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(88, NULL, 15, 'B0GLSC0GFZ', 'Minyak Kayu Putih', 0, 5, NULL, 3, 0, 72, 258807, 258807, 0, 'minyak-kayu-putih', NULL, NULL, '', NULL, NULL, NULL, 'minyak-kayu-putih.jpg', NULL, NULL, NULL, 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(89, NULL, 15, 'OJT8DQHZI1', 'Lulur Tradisional', 0, 5, NULL, 3, 0, 81, 421639, 421639, 0, 'lulur-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lulur-tradisional.jpg', NULL, NULL, NULL, 'Lulur tubuh dari rempah-rempah pilihan untuk kulit lebih cerah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(90, NULL, 16, 'C8J1KBNHO6', 'Dodol Betawi', 0, 1, NULL, 1, 0, 95, 187901, 187901, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(91, NULL, 16, 'ZXDIRSY6YQ', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 34, 347720, 347720, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(92, NULL, 16, 'RKEYFYVGPP', 'Kerajinan Anyaman', 0, 2, NULL, 1, 0, 94, 390159, 390159, 0, 'kerajinan-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'kerajinan-anyaman.jpg', NULL, NULL, NULL, 'Anyaman tangan dari bahan alami seperti bambu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(93, NULL, 16, 'IJR4GICHNA', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 54, 80397, 80397, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(94, NULL, 16, 'PVNDNTVTPQ', 'Batik Solo', 0, 3, NULL, 1, 0, 76, 243176, 243176, 0, 'batik-solo', NULL, NULL, '', NULL, NULL, NULL, 'batik-solo.jpg', NULL, NULL, NULL, 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(95, NULL, 16, 'W8YAWYT3OU', 'Sarung Tenun', 0, 3, NULL, 1, 0, 51, 306903, 306903, 0, 'sarung-tenun', NULL, NULL, '', NULL, NULL, NULL, 'sarung-tenun.jpg', NULL, NULL, NULL, 'Sarung tradisional hasil tenunan tangan dengan motif elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(96, NULL, 16, 'KUOZON9JDR', 'Kaos Lukis', 0, 3, NULL, 1, 0, 46, 306419, 306419, 0, 'kaos-lukis', NULL, NULL, '', NULL, NULL, NULL, 'kaos-lukis.jpg', NULL, NULL, NULL, 'Kaos berbahan katun premium dengan desain lukisan tangan unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(97, NULL, 17, 'NUM0KXUZRL', 'Keripik Balado', 0, 1, NULL, 2, 0, 88, 278893, 278893, 0, 'keripik-balado', NULL, NULL, '', NULL, NULL, NULL, 'keripik-balado.jpg', NULL, NULL, NULL, 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(98, NULL, 17, 'HVC0UXQ7PB', 'Power Bank Batik', 0, 4, NULL, 1, 0, 51, 277731, 277731, 0, 'power-bank-batik', NULL, NULL, '', NULL, NULL, NULL, 'power-bank-batik.jpg', NULL, NULL, NULL, 'Power bank dengan motif batik eksklusif yang unik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(99, NULL, 17, '5NBSCQFNBC', 'Speaker Kayu', 0, 4, NULL, 1, 0, 35, 60658, 60658, 0, 'speaker-kayu', NULL, NULL, '', NULL, NULL, NULL, 'speaker-kayu.jpg', NULL, NULL, NULL, 'Speaker portable dengan casing kayu dan suara berkualitas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(100, NULL, 17, 'XXILWSG5GV', 'Lampu Hias Unik', 0, 4, NULL, 1, 0, 50, 330663, 330663, 0, 'lampu-hias-unik', NULL, NULL, '', NULL, NULL, NULL, 'lampu-hias-unik.jpg', NULL, NULL, NULL, 'Lampu dekoratif handmade dari bahan kayu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(101, NULL, 17, '5DYZKPRU6T', 'Masker Herbal', 0, 5, NULL, 3, 0, 98, 480441, 480441, 0, 'masker-herbal', NULL, NULL, '', NULL, NULL, NULL, 'masker-herbal.jpg', NULL, NULL, NULL, 'Masker wajah dari bahan alami untuk perawatan kulit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(102, NULL, 17, '3Y99MIPY0K', 'Essential Oil', 0, 5, NULL, 3, 0, 32, 159932, 159932, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(103, NULL, 18, 'CHBJ1JZWZQ', 'Bakpia Pathok', 0, 1, NULL, 1, 0, 87, 153164, 153164, 0, 'bakpia-pathok', NULL, NULL, '', NULL, NULL, NULL, 'bakpia-pathok.jpg', NULL, NULL, NULL, 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(104, NULL, 18, 'JY9CJSFTJD', 'Dodol Betawi', 0, 1, NULL, 1, 0, 71, 310693, 310693, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(105, NULL, 18, 'LND0IG69H3', 'Keripik Balado', 0, 1, NULL, 1, 0, 29, 138743, 138743, 0, 'keripik-balado', NULL, NULL, '', NULL, NULL, NULL, 'keripik-balado.jpg', NULL, NULL, NULL, 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(106, NULL, 18, 'FEVPZTATA6', 'Patung Kayu', 0, 2, NULL, 1, 0, 46, 167865, 167865, 0, 'patung-kayu', NULL, NULL, '', NULL, NULL, NULL, 'patung-kayu.jpg', NULL, NULL, NULL, 'Patung ukiran kayu dari pengrajin lokal, cocok untuk dekorasi rumah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(107, NULL, 18, '9DBDOTZIOL', 'Kerajinan Anyaman', 0, 2, NULL, 1, 0, 21, 143576, 143576, 0, 'kerajinan-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'kerajinan-anyaman.jpg', NULL, NULL, NULL, 'Anyaman tangan dari bahan alami seperti bambu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(108, NULL, 18, 'DHJDFBLHV4', 'Jam Tangan Kayu', 0, 4, NULL, 1, 0, 10, 407037, 407037, 0, 'jam-tangan-kayu', NULL, NULL, '', NULL, NULL, NULL, 'jam-tangan-kayu.jpg', NULL, NULL, NULL, 'Jam tangan eksklusif berbahan kayu dengan desain minimalis.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(109, NULL, 19, 'BYQG4EQSAI', 'Dodol Betawi', 0, 1, NULL, 2, 0, 43, 238367, 238367, 0, 'dodol-betawi', NULL, NULL, '', NULL, NULL, NULL, 'dodol-betawi.jpg', NULL, NULL, NULL, 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(110, NULL, 19, 'XDBNHO8QVC', 'Pempek Palembang', 0, 1, NULL, 1, 0, 24, 215410, 215410, 0, 'pempek-palembang', NULL, NULL, '', NULL, NULL, NULL, 'pempek-palembang.jpg', NULL, NULL, NULL, 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(111, NULL, 19, 'BVEULQERWL', 'Batik Pekalongan', 0, 2, NULL, 1, 0, 81, 427813, 427813, 0, 'batik-pekalongan', NULL, NULL, '', NULL, NULL, NULL, 'batik-pekalongan.jpg', NULL, NULL, NULL, 'Kain batik khas Pekalongan dengan motif klasik dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(112, NULL, 19, '2Z1UXWQAZ2', 'Lukisan Tradisional', 0, 2, NULL, 1, 0, 58, 311448, 311448, 0, 'lukisan-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lukisan-tradisional.jpg', NULL, NULL, NULL, 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(113, NULL, 19, 'TKSHLZDFRB', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 59, 412881, 412881, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(114, NULL, 19, 'T8HV3RWMKN', 'Sarung Tenun', 0, 3, NULL, 1, 0, 42, 203458, 203458, 0, 'sarung-tenun', NULL, NULL, '', NULL, NULL, NULL, 'sarung-tenun.jpg', NULL, NULL, NULL, 'Sarung tradisional hasil tenunan tangan dengan motif elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(115, NULL, 19, 'Y1MWALPFCQ', 'Lulur Tradisional', 0, 5, NULL, 1, 0, 34, 291664, 291664, 0, 'lulur-tradisional', NULL, NULL, '', NULL, NULL, NULL, 'lulur-tradisional.jpg', NULL, NULL, NULL, 'Lulur tubuh dari rempah-rempah pilihan untuk kulit lebih cerah.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(116, NULL, 19, 'X0M0II9CGK', 'Minyak Kayu Putih', 0, 5, NULL, 1, 0, 77, 301151, 301151, 0, 'minyak-kayu-putih', NULL, NULL, '', NULL, NULL, NULL, 'minyak-kayu-putih.jpg', NULL, NULL, NULL, 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(117, NULL, 19, 'ZGLSKSRQPY', 'Essential Oil', 0, 5, NULL, 1, 0, 81, 327192, 327192, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(118, NULL, 20, 'LKWWWV8BW8', 'Batik Pekalongan', 0, 2, NULL, 1, 0, 38, 230157, 230157, 0, 'batik-pekalongan', NULL, NULL, '', NULL, NULL, NULL, 'batik-pekalongan.jpg', NULL, NULL, NULL, 'Kain batik khas Pekalongan dengan motif klasik dan elegan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(119, NULL, 20, 'AU5UBNYZ98', 'Aksesoris Etnik', 0, 2, NULL, 1, 0, 54, 92769, 92769, 0, 'aksesoris-etnik', NULL, NULL, '', NULL, NULL, NULL, 'aksesoris-etnik.jpg', NULL, NULL, NULL, 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(120, NULL, 20, 'UABHXGCCW7', 'Kerajinan Anyaman', 0, 2, NULL, 1, 0, 90, 89432, 89432, 0, 'kerajinan-anyaman', NULL, NULL, '', NULL, NULL, NULL, 'kerajinan-anyaman.jpg', NULL, NULL, NULL, 'Anyaman tangan dari bahan alami seperti bambu dan rotan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(121, NULL, 20, '41DOHFF4UL', 'Sabun Organik', 0, 5, NULL, 1, 0, 59, 308890, 308890, 0, 'sabun-organik', NULL, NULL, '', NULL, NULL, NULL, 'sabun-organik.jpg', NULL, NULL, NULL, 'Sabun berbahan alami yang cocok untuk kulit sensitif.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(122, NULL, 20, 'C8VP78XJ5Q', 'Minyak Kayu Putih', 0, 5, NULL, 3, 0, 63, 274286, 274286, 0, 'minyak-kayu-putih', NULL, NULL, '', NULL, NULL, NULL, 'minyak-kayu-putih.jpg', NULL, NULL, NULL, 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(123, NULL, 20, 'H24ZRTZVPJ', 'Essential Oil', 0, 5, NULL, 1, 0, 11, 263979, 263979, 0, 'essential-oil', NULL, NULL, '', NULL, NULL, NULL, 'essential-oil.jpg', NULL, NULL, NULL, 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.', NULL, 2, NULL, '2025-03-30 19:23:47', '2025-12-30 08:15:22'),
(124, NULL, 21, 'S-001', 'MIE', 0, 1, NULL, 1, 0, 97, 1000, 1000, 0, 'mie-2503310238', NULL, NULL, '', NULL, NULL, NULL, 'IP - FS 3 (1)_1743363525.png', NULL, NULL, NULL, 'Lorem Ipsum', NULL, 2, NULL, '2025-03-30 19:38:45', '2025-12-30 08:15:22'),
(126, NULL, 24, '131415', 'noken asli papua', 1, 6, NULL, 1, 1000, 97, 350250, 350250, 0, 'noken-asli-papua-2511041849', 'a:2:{i:0;a:1:{s:4:\"name\";s:48:\"1-7011_noken asli papua115_1766847481_575548.jpg\";}i:1;a:1:{s:4:\"name\";s:48:\"2-7011_noken asli papua369_1766847481_921312.jpg\";}}', NULL, '', NULL, NULL, NULL, 'WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg', 'WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg', 'WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg', 'WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg', 'noken asli papua dengan tema asli papua', NULL, 2, NULL, '2025-11-04 11:49:52', '2026-01-17 11:56:23'),
(127, NULL, 24, 'test001', 'test 001', 3, 10, NULL, 1, 0, 8, 150250, 150250, 0, 'test-001-2512171247', NULL, NULL, '', NULL, NULL, NULL, 'Eropa Tengah - Mobile_1765950425.jpg', NULL, NULL, NULL, 'ini adalah test 001', NULL, 2, NULL, '2025-12-17 05:47:05', '2025-12-30 08:15:23'),
(128, NULL, 24, 'test 002', 'test 002', 3, 10, NULL, 1, 0, 20, 140000, 140000, 0, 'test-002-2512181529', NULL, NULL, '', NULL, NULL, NULL, '536d6dda-7e45-4f21-af8f-95532091be5f_1766046573.jpg', NULL, NULL, NULL, 'ini adalah test 002', NULL, 1, NULL, '2025-12-18 08:29:33', '2025-12-30 08:15:23'),
(129, NULL, 24, 'test003', 'test 003', 3, 13, NULL, 1, 0, 20, 150000, 150000, 0, 'test-003-2512181533', NULL, NULL, '', NULL, NULL, NULL, 'WhatsApp Installer (2)_1766046819.exe', 'poto-buat-blog_1766046819.jpg', NULL, NULL, 'geoigheoqgiheqogihewogiwo', NULL, 1, NULL, '2025-12-18 08:33:39', '2025-12-30 08:15:23'),
(130, NULL, 24, 'testing003', 'testing 003', 3, 14, NULL, 1, 0, 20, 130000, 130000, 0, 'testing-003-2512181538', NULL, NULL, '', NULL, NULL, NULL, 'Setup_1766047135.exe', 'cotton-top-tamarin-8463471_1280_1766047135.jpg', NULL, NULL, 'eoihfoeqi fqepfgo qepf', NULL, 1, NULL, '2025-12-18 08:38:55', '2025-12-30 08:15:23'),
(131, NULL, 24, 'testing005', 'testing 005', 3, 10, NULL, 1, 0, 20, 120000, 120000, 0, 'testing-005-2512181633', NULL, NULL, '', NULL, NULL, NULL, 'images (2)_1766050394.jpeg', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-18 09:33:14', '2025-12-30 08:15:23'),
(132, NULL, 24, 'test07', 'test 07', 3, 12, NULL, 1, 0, 20, 120000, 120000, 0, 'test-07-2512191844', NULL, NULL, '', NULL, NULL, NULL, '6667_sfafagag879_1766144659_415531.jpg', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-19 11:44:19', '2025-12-30 08:15:23'),
(133, NULL, 24, 'test 0008', 'test0008', 3, 12, NULL, 1, 0, 20, 120000, 120000, 0, 'test0008-2512191856', NULL, NULL, '', NULL, NULL, NULL, '8146_test0008416_1766145390_710170.jpg', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2025-12-19 11:56:30', '2025-12-30 08:15:23'),
(134, NULL, 24, 'test009', 'test 009 edit ok lagi donk', 1, 11, NULL, 1, 0, 20, 120250, 120250, 0, 'test-009-2512191921', NULL, NULL, 'D:\\wamp64\\tmp\\php75C7.tmp', NULL, NULL, NULL, '5058_test 009821_1766146875_591539.jpg', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2025-12-19 12:21:15', '2025-12-30 08:15:23'),
(135, NULL, 24, 'testing01', 'testing 01', 1, 5, NULL, 1, 0, 20, 150000, 150000, 0, 'testing-01-2512201054', NULL, NULL, NULL, NULL, NULL, NULL, '7570_testing 01676_1766202851_240946.jpg', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-20 03:54:11', '2025-12-30 08:15:23'),
(136, NULL, 24, 'testing0001', 'testing 0001 edit ke digital', 3, 9, NULL, 1, 1000, 9, 100250, 100250, 0, 'testing-0001-2512201355', NULL, NULL, 'D:\\wamp64\\tmp\\php4FD7.tmp', NULL, NULL, NULL, '6982_testing 0001393_1766213741_994929.jpg', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2025-12-20 06:55:41', '2026-01-10 14:15:25'),
(137, NULL, 24, 'testing0001minggu', 'testing 0001 minggu', 3, 8, NULL, 1, 0, 18, 100250, 100250, 0, 'testing-0001-minggu-2512211650', NULL, NULL, '1-2144_testing 0001 minggu637_1766310609_198381.exe', NULL, NULL, NULL, '2144_testing 0001 minggu139_1766310609_112009.jpg', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2025-12-21 09:50:09', '2025-12-30 08:15:23'),
(138, NULL, 24, 'egewg555', 'gweg ewgew 555', 3, 11, NULL, 1, 0, 20, 100000, 100000, 0, 'gweg-ewgew-555-2512251924', NULL, NULL, NULL, NULL, NULL, NULL, '7888_gweg ewgew 555875_1766665487_981285.jpg', NULL, NULL, NULL, 'grg rwghwh rw hrw h', NULL, 1, NULL, '2025-12-25 12:24:47', '2025-12-30 08:15:23'),
(139, NULL, 24, 'tgegew65', 'gewg4wv264b  65', 3, 10, NULL, 1, 0, 20, 100000, 100000, 0, 'gewg4wv264b-65-2512251938', NULL, NULL, NULL, NULL, NULL, NULL, '5379_gewg4wv264b  65569_1766666331_622094.jpg', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-25 12:38:51', '2025-12-30 08:15:23'),
(140, NULL, 24, 'feewvtwevtw89', 'egwvwrtrwvtw89 89', 3, 10, NULL, 1, 0, 20, 120000, 120000, 0, 'egwvwrtrwvtw89-89-2512251940', NULL, NULL, NULL, NULL, NULL, NULL, '8172_egwvwrtrwvtw89 89177_1766666440_452928.jpg', NULL, NULL, NULL, 'grherh reherh whwrhrw hrw', NULL, 1, NULL, '2025-12-25 12:40:40', '2025-12-30 08:15:23'),
(141, NULL, 24, 'fxbsfbsfbfsbs 89', 'dafdag agadg a 89', 3, 15, NULL, 1, 0, 20, 120000, 120000, 0, 'dafdag-agadg-a-89-2512251943', NULL, NULL, NULL, NULL, NULL, NULL, '4437_dafdag agadg a 89472_1766666625_522668.jpg', NULL, NULL, NULL, 'hfd hh te hteh ehte htwe', NULL, 1, NULL, '2025-12-25 12:43:45', '2025-12-30 08:15:23'),
(142, NULL, 24, 'vbdsfadfafa66', 'daadfadfagerwgw 66', 3, 15, NULL, 1, 0, 20, 120000, 120000, 0, 'daadfadfagerwgw-66-2512251946', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, '3239_daadfadfagerwgw 66729_1766666809_584927.jpg', NULL, NULL, NULL, 'bfsgsgsdh raegea geaw gqw', NULL, 1, NULL, '2025-12-25 12:46:49', '2025-12-30 08:15:23'),
(143, NULL, 24, 'dsafgaeefegeq 78', 'dgageg eqgewgwe 78', 3, 15, NULL, 1, 0, 20, 120000, 120000, 0, 'dgageg-eqgewgwe-78-2512251950', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, '1273_dgageg eqgewgwe 78371_1766667011_199828.jpg', NULL, NULL, NULL, 'gdsgewgwe gweg ewgwe gewgwe', NULL, 1, NULL, '2025-12-25 12:50:11', '2025-12-30 08:15:23'),
(144, NULL, 24, 'safafegewgwe78', 'safsafafaga 78', 3, 14, NULL, 1, 0, 20, 120000, 120000, 0, 'safsafafaga-78-2512251953', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, '9865_safsafafaga 78169_1766667237_750275.jpg', NULL, NULL, NULL, 'vdsgdsgs hrhrw hrw hrw hwr', NULL, 1, NULL, '2025-12-25 12:53:57', '2025-12-30 08:15:23'),
(145, NULL, 24, 'qwqwfqfgqw56', 'rqwqrwqrwq 56', 3, 15, NULL, 1, 0, 20, 120000, 120000, 0, 'rqwqrwqrwq-56-2512251955', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, '7209_rqwqrwqrwq 56148_1766667346_315473.jpg', NULL, NULL, NULL, 'gdsgsgrhehe hrwe hjwrjhwr jwrjrwhw', NULL, 1, NULL, '2025-12-25 12:55:46', '2025-12-30 08:15:23'),
(146, NULL, 24, 'fdafafasgaga33', 'sfadgadgadg 33', 3, 12, NULL, 1, 0, 20, 120000, 120000, 0, 'sfadgadgadg-33-2512251959', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, '3881_sfadgadgadg 33767_1766667549_368381.jpg', NULL, NULL, NULL, 'fdagagrw hrwhwr hw', NULL, 1, NULL, '2025-12-25 12:59:09', '2025-12-30 08:15:23'),
(147, NULL, 24, 'sdvdsgsdgewtwetgw56', 'dvdavadgegwe 56 FISIK KEMBALI', 1, 15, NULL, 1, 0, 20, 120250, 120250, 0, 'dvdavadgegwe-56-2512252001', 'a:2:{i:0;a:1:{s:4:\"name\";s:47:\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\";}i:1;a:1:{s:4:\"name\";s:47:\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\";}}', NULL, NULL, NULL, NULL, NULL, '1-8408_dvdavadgegwe 56 FISIK KEMBALI147_1766828324_198156.jpeg', NULL, '1-1606_dvdavadgegwe 56 FISIK KEMBALI63_1766828352_386021.jpg', NULL, 'sdgrwhwjrj wjrw jrwjrw jrw', NULL, 2, NULL, '2025-12-25 13:01:36', '2025-12-30 08:15:23'),
(148, NULL, 24, 'baruagain1', 'baru again 1', 3, 12, NULL, 1, 0, 17, 120000, 120000, 0, 'baru-again-1-2512271645', 'a:1:{i:0;a:1:{s:4:\"name\";s:43:\"1-949_baru again 1190_1766828752_926558.jpg\";}}', NULL, NULL, NULL, NULL, NULL, '949_baru again 1779_1766828752_318145.jpg', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2025-12-27 09:45:52', '2026-01-04 16:31:36'),
(149, NULL, 24, 'coeifeqfpqe99', 'cwiqgwqw q99', 1, 1, NULL, 1, 1000, 20, 100000, 100000, 0, 'cwiqgwqw-q99-2601081646', NULL, NULL, NULL, NULL, NULL, NULL, '5047_cwiqgwqw q99145_1767865587_743925.jpeg', NULL, NULL, NULL, 'feqoifheqof qepfoqep foj eqpgepqj gp[q', NULL, 1, NULL, '2026-01-08 09:46:27', '2026-01-08 09:46:27'),
(150, NULL, 24, 'vdlafoeif reqoirq88', 'dvioihphfep p 88', 1, 1, NULL, 1, 0, 1000, 100000, 100000, 0, 'dvioihphfep-p-88-2601081650', NULL, NULL, NULL, NULL, NULL, NULL, '7576_dvioihphfep p 88890_1767865831_666466.jpeg', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-01-08 09:50:31', '2026-01-08 09:50:31'),
(151, NULL, 24, 'qqowprqwopfwq90', 'wfowqyfqwifpw q 90', 1, 1, NULL, 1, 0, 100, 100000, 100000, 0, 'wfowqyfqwifpw-q-90-2601081651', NULL, NULL, NULL, NULL, NULL, NULL, '822_wfowqyfqwifpw q 90333_1767865913_403890.jpeg', NULL, NULL, NULL, 'feoifqep ogeqpghoqe pgjpqegq', NULL, 1, NULL, '2026-01-08 09:51:53', '2026-01-08 09:51:53'),
(152, NULL, 24, '4iihgegopgeo', 'foeo eihgqe q89', 1, 1, 1, 1, 1000, 100, 100000, 100000, 0, 'foeo-eihgqe-q89-2601081656', NULL, NULL, NULL, NULL, NULL, NULL, '2714_foeo eihgqe q89902_1767866198_425504.jpeg', NULL, NULL, NULL, 'doihfe geqpgoqepg oqejgpoqe gqe', NULL, 1, NULL, '2026-01-08 09:56:38', '2026-01-08 09:56:38'),
(153, NULL, 24, 'ncihqeihp999', 'dhvqeoihfeqpofqe 99', 1, 3, 3, 1, 1000, 1000, 100000, 100000, 0, 'dhvqeoihfeqpofqe-99-2601081657', 'a:1:{i:0;a:1:{s:4:\"name\";s:5:\"value\";}}', NULL, NULL, NULL, NULL, NULL, '8105_dhvqeoihfeqpofqe 99347_1767866278_272772.jpg', NULL, NULL, NULL, 'dofhefgio epgohep goj eqp gojeqopgewgw', NULL, 2, NULL, '2026-01-08 09:57:58', '2026-01-09 07:26:46'),
(154, NULL, 24, 'testingreza01', 'testing reza 01', 3, 4, NULL, 1, 0, 99, 100000, 100000, 0, 'testing-reza-01-2601102127', 'a:1:{i:0;a:1:{s:4:\"name\";s:48:\"1-4133_testing reza 01154_1768055220_747229.jpeg\";}}', NULL, NULL, NULL, NULL, NULL, '4133_testing reza 01820_1768055220_829792.jpg', NULL, NULL, NULL, 'fegew hrwhrw h rwhwr hwr', NULL, 2, NULL, '2026-01-10 14:27:00', '2026-01-10 15:18:16'),
(155, NULL, 24, 'digitalsubstime01', 'digitalsubstime 01', 3, 1, 1, 1, 0, 100, 50000, 50000, 0, 'digitalsubstime-01-2601141305', 'a:1:{i:0;a:1:{s:4:\"name\";s:51:\"1-9715_digitalsubstime 01102_1768370710_699596.jpeg\";}}', NULL, NULL, NULL, NULL, NULL, '9715_digitalsubstime 01447_1768370710_608723.jpg', NULL, NULL, NULL, 'gewoihgewpgo ewpgojew pgoew hew', NULL, 1, NULL, '2026-01-14 06:05:10', '2026-01-14 06:05:10'),
(156, NULL, 24, 'digitalsubstime03', 'digitalsubstime 03', 3, 1, NULL, 1, 0, 100, 50000, 50000, 0, 'digitalsubstime-03-2601141310', 'a:1:{i:0;a:1:{s:4:\"name\";s:51:\"1-1101_digitalsubstime 03555_1768371010_889915.jpeg\";}}', 's:7:\"2 bulan\";', NULL, NULL, NULL, NULL, '1101_digitalsubstime 03711_1768371010_724284.jpg', NULL, NULL, NULL, 'pfeowgpewo pgoewjog[e wpgjw[ gkpew[ gpkjew[gw', NULL, 2, NULL, '2026-01-14 06:10:10', '2026-01-14 06:11:37'),
(157, NULL, 24, 'digitalsubstime04', 'digitalsubstime 04', 3, 1, NULL, 1, 0, 100, 49998, 49998, 0, 'digitalsubstime-04-2601141319', 'a:1:{i:0;a:1:{s:4:\"name\";s:51:\"1-4051_digitalsubstime 04612_1768371587_123633.jpeg\";}}', 's:7:\"2 bulan\";', NULL, NULL, NULL, NULL, '4051_digitalsubstime 0492_1768371587_375554.jpg', NULL, NULL, NULL, 'foiahfgogeihgpeoqpg eqopgoeqgoeqpgo qep', NULL, 1, NULL, '2026-01-14 06:19:47', '2026-01-14 06:19:47'),
(158, NULL, 24, 'digitalsubstime06', 'digitalsubstime 06', 3, 1, NULL, 1, 0, 100, 0, 0, 0, 'digitalsubstime-06-2601141322', 'a:1:{i:0;a:1:{s:4:\"name\";s:51:\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\";}}', 'a:3:{i:0;s:7:\"1 bulan\";i:1;s:7:\"2 bulan\";i:2;s:7:\"1 tahun\";}', NULL, NULL, NULL, NULL, '3428_digitalsubstime 06160_1768371726_614311.jpg', NULL, NULL, NULL, 'feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq', NULL, 2, NULL, '2026-01-14 06:22:06', '2026-01-14 09:30:01');
INSERT INTO `products` (`id`, `admin_cost_id`, `seller_id`, `code`, `name`, `type_id`, `category_id`, `sub_category_id`, `unit_id`, `weight`, `stock`, `price`, `seller_price`, `admin_cost`, `slug`, `digitals`, `subtimes`, `file_1`, `file_2`, `file_3`, `file_4`, `image_1`, `image_2`, `image_3`, `image_4`, `description`, `note`, `status`, `total_sells`, `created_at`, `updated_at`) VALUES
(159, NULL, 24, 'digital555', 'digital 555', 3, 1, NULL, 1, 0, 100, 50000, 50000, 0, 'digital-555-2601141744', 'a:1:{i:0;a:1:{s:4:\"name\";s:44:\"1-8902_digital 555691_1768387442_338143.jpeg\";}}', 'a:2:{i:0;a:2:{s:7:\"subtime\";s:7:\"1 bulan\";s:8:\"subprice\";s:5:\"20000\";}i:1;a:2:{s:7:\"subtime\";s:7:\"2 bulan\";s:8:\"subprice\";s:5:\"35000\";}}', NULL, NULL, NULL, NULL, '8902_digital 555741_1768387442_900813.jpg', NULL, NULL, NULL, 'foeihgoeqigpeq opoq geq', NULL, 1, NULL, '2026-01-14 10:44:02', '2026-01-14 10:44:02'),
(160, NULL, 24, 'digitalaaa', 'digital aaa', 3, 1, NULL, 1, 0, 47, 10000, 10000, 0, 'digital-aaa-2601141756', 'a:1:{i:0;a:1:{s:4:\"name\";s:44:\"1-5095_digital aaa716_1768388171_840129.jpeg\";}}', 'a:3:{i:0;a:3:{s:7:\"subtime\";s:7:\"1 bulan\";s:8:\"subprice\";i:20000;s:14:\"subsellerprice\";i:20000;}i:1;a:3:{s:7:\"subtime\";s:7:\"2 bulan\";s:8:\"subprice\";i:35000;s:14:\"subsellerprice\";i:35000;}i:2;a:3:{s:7:\"subtime\";s:7:\"3 bulan\";s:8:\"subprice\";i:50000;s:14:\"subsellerprice\";i:50000;}}', NULL, NULL, NULL, NULL, '5095_digital aaa637_1768388171_947495.jpg', NULL, NULL, NULL, 'vfoeihfgpeqofgpewo gpewjg we', NULL, 2, NULL, '2026-01-14 10:56:11', '2026-01-17 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `product_logs`
--

DROP TABLE IF EXISTS `product_logs`;
CREATE TABLE IF NOT EXISTS `product_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `activity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `product_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_logs_product_id_user_id_index` (`product_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_logs`
--

INSERT INTO `product_logs` (`id`, `user_id`, `activity`, `note`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 22, 'Create', '{\"code\":\"S-001\",\"name\":\"MIE\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":\"1000\",\"description\":\"Lorem Ipsum\",\"image_1\":\"IP - FS 3 (1)_1743363525.png\",\"seller_id\":21,\"slug\":\"mie-2503310238\",\"updated_at\":\"2025-03-30T19:38:45.000000Z\",\"created_at\":\"2025-03-30T19:38:45.000000Z\",\"id\":124}', 124, '2025-03-30 19:38:45', '2025-03-30 19:38:45'),
(2, 1, 'Approve', '{\"id\":124,\"seller_id\":21,\"code\":\"S-001\",\"name\":\"MIE\",\"category_id\":1,\"unit_id\":1,\"stock\":100,\"price\":1000,\"slug\":\"mie-2503310238\",\"image_1\":\"IP - FS 3 (1)_1743363525.png\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"Lorem Ipsum\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-03-30T19:38:45.000000Z\",\"updated_at\":\"2025-03-30T19:39:39.000000Z\",\"seller\":{\"id\":21,\"username\":\"seller\",\"name\":\"seller\",\"email\":\"seller@gmail.com\",\"tax_number\":\"1111111\",\"business_number\":\"111111\",\"phone\":\"85869101484\",\"address\":\"Gondang Sari, Jlarem, Gladagsari, Boyolali, RT01, RW03\",\"city\":\"Kabupaten Boyolali\",\"province\":\"Central Java\",\"country\":\"Indonesia\",\"zip\":\"57352\",\"status\":4,\"note\":null,\"user_id\":22,\"created_at\":\"2025-03-30T19:25:23.000000Z\",\"updated_at\":\"2025-03-30T19:37:14.000000Z\"}}', 124, '2025-03-30 19:39:39', '2025-03-30 19:39:39'),
(3, 25, 'Create', '{\"code\":\"oleh oleh\",\"name\":\"Noken\",\"category_id\":\"2\",\"unit_id\":\"1\",\"stock\":\"15\",\"price\":\"10000\",\"description\":\"noken asli dari papua\",\"image_1\":\"Screenshot 2025-04-03 at 17.49.30_1743670199.png\",\"image_2\":\"Screenshot 2025-04-03 at 17.49.15_1743670199.png\",\"image_3\":\"Screenshot 2025-04-03 at 17.49.03_1743670199.png\",\"image_4\":\"Screenshot 2025-04-03 at 17.48.50_1743670199.png\",\"seller_id\":22,\"slug\":\"noken-2504031549\",\"updated_at\":\"2025-04-03T08:49:59.000000Z\",\"created_at\":\"2025-04-03T08:49:59.000000Z\",\"id\":125}', 125, '2025-04-03 08:49:59', '2025-04-03 08:49:59'),
(4, 1, 'Approve', '{\"id\":125,\"seller_id\":22,\"code\":\"oleh oleh\",\"name\":\"Noken\",\"category_id\":2,\"unit_id\":1,\"stock\":15,\"price\":10000,\"slug\":\"noken-2504031549\",\"image_1\":\"Screenshot 2025-04-03 at 17.49.30_1743670199.png\",\"image_2\":\"Screenshot 2025-04-03 at 17.49.15_1743670199.png\",\"image_3\":\"Screenshot 2025-04-03 at 17.49.03_1743670199.png\",\"image_4\":\"Screenshot 2025-04-03 at 17.48.50_1743670199.png\",\"description\":\"noken asli dari papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-04-03T08:49:59.000000Z\",\"updated_at\":\"2025-04-03T08:56:36.000000Z\",\"seller\":{\"id\":22,\"username\":\"seler1\",\"name\":\"xion\",\"email\":\"seler1@gmail.com\",\"tax_number\":\"99616\",\"business_number\":\"081248419336\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":25,\"created_at\":\"2025-04-03T08:40:03.000000Z\",\"updated_at\":\"2025-04-03T08:44:25.000000Z\"}}', 125, '2025-04-03 08:56:36', '2025-04-03 08:56:36'),
(5, 1, 'Delete', '{\"id\":125,\"seller_id\":22,\"code\":\"oleh oleh\",\"name\":\"Noken\",\"category_id\":2,\"unit_id\":1,\"stock\":14,\"price\":10000,\"slug\":\"noken-2504031549\",\"image_1\":\"Screenshot 2025-04-03 at 17.49.30_1743670199.png\",\"image_2\":\"Screenshot 2025-04-03 at 17.49.15_1743670199.png\",\"image_3\":\"Screenshot 2025-04-03 at 17.49.03_1743670199.png\",\"image_4\":\"Screenshot 2025-04-03 at 17.48.50_1743670199.png\",\"description\":\"noken asli dari papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-04-03T08:49:59.000000Z\",\"updated_at\":\"2025-04-03T09:01:03.000000Z\"}', 125, '2025-04-08 06:21:50', '2025-04-08 06:21:50'),
(6, 34, 'Create', '{\"code\":\"001\",\"name\":\"noken asli papua\",\"category_id\":\"7\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":350250,\"description\":\"noken asli papua dengan tema asli papua\",\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"seller_id\":24,\"slug\":\"noken-asli-papua-2511041849\",\"seller_price\":\"350000\",\"admin_cost_id\":1,\"admin_cost\":\"250\",\"updated_at\":\"2025-11-04T11:49:52.000000Z\",\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"id\":126}', 126, '2025-11-04 11:49:52', '2025-11-04 11:49:52'),
(7, 1, 'Approve', '{\"id\":126,\"admin_cost_id\":\"1\",\"seller_id\":\"24\",\"code\":\"001\",\"name\":\"noken asli papua\",\"category_id\":\"7\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":\"350250\",\"seller_price\":\"350000\",\"admin_cost\":\"250\",\"slug\":\"noken-asli-papua-2511041849\",\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-11-04T11:50:28.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":\"4\",\"note\":null,\"user_id\":\"34\",\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 126, '2025-11-04 11:50:28', '2025-11-04 11:50:28'),
(8, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":\"24\",\"code\":\"001\",\"name\":\"noken asli papua\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":\"250\",\"slug\":\"noken-asli-papua-2511041849\",\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-11-04T11:52:42.000000Z\"}', 126, '2025-11-04 11:52:42', '2025-11-04 11:52:42'),
(9, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":\"24\",\"code\":\"131415\",\"name\":\"noken asli papua\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":\"250\",\"slug\":\"noken-asli-papua-2511041849\",\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-11-04T11:54:20.000000Z\"}', 126, '2025-11-04 11:54:20', '2025-11-04 11:54:20'),
(10, 34, 'Create', '{\"code\":\"test001\",\"name\":\"test 001\",\"type_id\":\"1\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":150250,\"description\":\"ini adalah test 001\",\"image_1\":\"Eropa Tengah - Mobile_1765950425.jpg\",\"seller_id\":24,\"slug\":\"test-001-2512171247\",\"seller_price\":\"150000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-17T05:47:05.000000Z\",\"created_at\":\"2025-12-17T05:47:05.000000Z\",\"id\":127}', 127, '2025-12-17 05:47:05', '2025-12-17 05:47:05'),
(11, 1, 'Approve', '{\"id\":127,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test001\",\"name\":\"test 001\",\"type_id\":1,\"category_id\":10,\"unit_id\":1,\"stock\":10,\"price\":150250,\"seller_price\":150000,\"admin_cost\":250,\"slug\":\"test-001-2512171247\",\"image_1\":\"Eropa Tengah - Mobile_1765950425.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"ini adalah test 001\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-17T05:47:05.000000Z\",\"updated_at\":\"2025-12-17T06:12:49.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 127, '2025-12-17 06:12:49', '2025-12-17 06:12:49'),
(12, 34, 'Update', '{\"id\":127,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test001\",\"name\":\"test 001\",\"type_id\":\"3\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"10\",\"price\":\"150250\",\"seller_price\":\"150250\",\"admin_cost\":250,\"slug\":\"test-001-2512171247\",\"image_1\":\"Eropa Tengah - Mobile_1765950425.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"ini adalah test 001\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-17T05:47:05.000000Z\",\"updated_at\":\"2025-12-17T06:44:56.000000Z\"}', 127, '2025-12-17 06:44:56', '2025-12-17 06:44:56'),
(13, 34, 'Create', '{\"code\":\"test 002\",\"name\":\"test 002\",\"type_id\":\"3\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":140250,\"description\":\"ini adalah test 002\",\"seller_id\":24,\"image_1\":\"536d6dda-7e45-4f21-af8f-95532091be5f_1766046573.jpg\",\"slug\":\"test-002-2512181529\",\"seller_price\":\"140000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-18T08:29:33.000000Z\",\"created_at\":\"2025-12-18T08:29:33.000000Z\",\"id\":128}', 128, '2025-12-18 08:29:33', '2025-12-18 08:29:33'),
(14, 34, 'Create', '{\"code\":\"test003\",\"name\":\"test 003\",\"type_id\":\"3\",\"category_id\":\"13\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":150250,\"description\":\"geoigheoqgiheqogihewogiwo\",\"image_2\":\"poto-buat-blog_1766046819.jpg\",\"seller_id\":24,\"image_1\":\"WhatsApp Installer (2)_1766046819.exe\",\"slug\":\"test-003-2512181533\",\"seller_price\":\"150000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-18T08:33:39.000000Z\",\"created_at\":\"2025-12-18T08:33:39.000000Z\",\"id\":129}', 129, '2025-12-18 08:33:39', '2025-12-18 08:33:39'),
(15, 34, 'Create', '{\"code\":\"testing003\",\"name\":\"testing 003\",\"type_id\":\"3\",\"category_id\":\"14\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":130250,\"description\":\"eoihfoeqi fqepfgo qepf\",\"image_2\":\"cotton-top-tamarin-8463471_1280_1766047135.jpg\",\"seller_id\":24,\"image_1\":\"Setup_1766047135.exe\",\"slug\":\"testing-003-2512181538\",\"seller_price\":\"130000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-18T08:38:55.000000Z\",\"created_at\":\"2025-12-18T08:38:55.000000Z\",\"id\":130}', 130, '2025-12-18 08:38:55', '2025-12-18 08:38:55'),
(16, 34, 'Create', '{\"code\":\"testing005\",\"name\":\"testing 005\",\"type_id\":\"3\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":null,\"seller_id\":24,\"image_1\":\"images (2)_1766050394.jpeg\",\"slug\":\"testing-005-2512181633\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-18T09:33:14.000000Z\",\"created_at\":\"2025-12-18T09:33:14.000000Z\",\"id\":131}', 131, '2025-12-18 09:33:14', '2025-12-18 09:33:14'),
(17, 34, 'Create', '{\"code\":\"test07\",\"name\":\"test 07\",\"type_id\":\"3\",\"category_id\":\"12\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":null,\"image_1\":\"6667_sfafagag879_1766144659_415531.jpg\",\"seller_id\":24,\"slug\":\"test-07-2512191844\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-19T11:44:19.000000Z\",\"created_at\":\"2025-12-19T11:44:19.000000Z\",\"id\":132}', 132, '2025-12-19 11:44:19', '2025-12-19 11:44:19'),
(18, 34, 'Create', '{\"code\":\"test 0008\",\"name\":\"test0008\",\"type_id\":\"3\",\"category_id\":\"12\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":null,\"image_1\":\"8146_test0008416_1766145390_710170.jpg\",\"seller_id\":24,\"slug\":\"test0008-2512191856\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-19T11:56:30.000000Z\",\"created_at\":\"2025-12-19T11:56:30.000000Z\",\"id\":133}', 133, '2025-12-19 11:56:30', '2025-12-19 11:56:30'),
(19, 1, 'Approve', '{\"id\":133,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test 0008\",\"name\":\"test0008\",\"type_id\":3,\"category_id\":12,\"unit_id\":1,\"stock\":20,\"price\":120250,\"seller_price\":120000,\"admin_cost\":250,\"slug\":\"test0008-2512191856\",\"image_1\":\"8146_test0008416_1766145390_710170.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T11:56:30.000000Z\",\"updated_at\":\"2025-12-19T12:00:32.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 133, '2025-12-19 12:00:32', '2025-12-19 12:00:32'),
(20, 34, 'Create', '{\"code\":\"test009\",\"name\":\"test 009\",\"type_id\":\"3\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":null,\"file_1\":\"1-5058_test 009618_1766146875_864028.exe\",\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"seller_id\":24,\"slug\":\"test-009-2512191921\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-19T12:21:15.000000Z\",\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"id\":134}', 134, '2025-12-19 12:21:15', '2025-12-19 12:21:15'),
(21, 1, 'Approve', '{\"id\":134,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test009\",\"name\":\"test 009\",\"type_id\":3,\"category_id\":11,\"unit_id\":1,\"stock\":20,\"price\":120250,\"seller_price\":120000,\"admin_cost\":250,\"slug\":\"test-009-2512191921\",\"file_1\":\"1-5058_test 009618_1766146875_864028.exe\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"updated_at\":\"2025-12-19T12:24:52.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 134, '2025-12-19 12:24:52', '2025-12-19 12:24:52'),
(22, 34, 'Create', '{\"code\":\"testing01\",\"name\":\"testing 01\",\"type_id\":\"1\",\"category_id\":\"5\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":150250,\"description\":null,\"image_1\":\"7570_testing 01676_1766202851_240946.jpg\",\"seller_id\":24,\"slug\":\"testing-01-2512201054\",\"seller_price\":\"150000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-20T03:54:11.000000Z\",\"created_at\":\"2025-12-20T03:54:11.000000Z\",\"id\":135}', 135, '2025-12-20 03:54:11', '2025-12-20 03:54:11'),
(23, 34, 'Update', '{\"id\":134,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test009\",\"name\":\"test 009 edit ok\",\"type_id\":\"3\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"test-009-2512191921\",\"file_1\":{},\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"updated_at\":\"2025-12-20T05:30:19.000000Z\"}', 134, '2025-12-20 05:30:19', '2025-12-20 05:30:19'),
(24, 34, 'Update', '{\"id\":134,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test009\",\"name\":\"test 009 edit ok\",\"type_id\":\"3\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"test-009-2512191921\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php75C7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"updated_at\":\"2025-12-20T05:30:19.000000Z\"}', 134, '2025-12-20 06:07:17', '2025-12-20 06:07:17'),
(25, 34, 'Update', '{\"id\":134,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test009\",\"name\":\"test 009 edit ok lagi donk\",\"type_id\":\"3\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"test-009-2512191921\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php75C7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"updated_at\":\"2025-12-20T06:21:52.000000Z\"}', 134, '2025-12-20 06:21:52', '2025-12-20 06:21:52'),
(26, 34, 'Update', '{\"id\":134,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"test009\",\"name\":\"test 009 edit ok lagi donk\",\"type_id\":\"1\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"test-009-2512191921\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php75C7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5058_test 009821_1766146875_591539.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-19T12:21:15.000000Z\",\"updated_at\":\"2025-12-20T06:22:38.000000Z\"}', 134, '2025-12-20 06:22:38', '2025-12-20 06:22:38'),
(27, 34, 'Create', '{\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"1\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":100250,\"description\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"seller_id\":24,\"slug\":\"testing-0001-2512201355\",\"seller_price\":\"100000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-20T06:55:41.000000Z\",\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"id\":136}', 136, '2025-12-20 06:55:41', '2025-12-20 06:55:41'),
(28, 1, 'Approve', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":1,\"category_id\":9,\"unit_id\":1,\"stock\":20,\"price\":100250,\"seller_price\":100000,\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T06:56:40.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 136, '2025-12-20 06:56:40', '2025-12-20 06:56:40'),
(29, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"1\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:00:27.000000Z\"}', 136, '2025-12-20 07:00:27', '2025-12-20 07:00:27'),
(30, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:00:47.000000Z\"}', 136, '2025-12-20 07:00:47', '2025-12-20 07:00:47'),
(31, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":{},\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:02:59.000000Z\"}', 136, '2025-12-20 07:02:59', '2025-12-20 07:02:59'),
(32, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"1\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:03:51.000000Z\"}', 136, '2025-12-20 07:03:51', '2025-12-20 07:03:51'),
(33, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"1\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:03:51.000000Z\"}', 136, '2025-12-20 07:04:05', '2025-12-20 07:04:05'),
(34, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:13:31.000000Z\"}', 136, '2025-12-20 07:13:31', '2025-12-20 07:13:31'),
(35, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:13:31.000000Z\"}', 136, '2025-12-20 07:13:50', '2025-12-20 07:13:50'),
(36, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:13:31.000000Z\"}', 136, '2025-12-20 07:14:42', '2025-12-20 07:14:42'),
(37, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001\",\"type_id\":\"1\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:16:18.000000Z\"}', 136, '2025-12-20 07:16:18', '2025-12-20 07:16:18'),
(38, 34, 'Update', '{\"id\":136,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001 edit ke digital\",\"type_id\":\"3\",\"category_id\":\"9\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-2512201355\",\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2025-12-20T07:18:53.000000Z\"}', 136, '2025-12-20 07:18:53', '2025-12-20 07:18:53'),
(39, 34, 'Create', '{\"code\":\"testing0001minggu\",\"name\":\"testing 0001 minggu\",\"type_id\":\"3\",\"category_id\":\"8\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":100250,\"description\":null,\"file_1\":\"1-2144_testing 0001 minggu637_1766310609_198381.exe\",\"image_1\":\"2144_testing 0001 minggu139_1766310609_112009.jpg\",\"seller_id\":24,\"slug\":\"testing-0001-minggu-2512211650\",\"seller_price\":\"100000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-21T09:50:09.000000Z\",\"created_at\":\"2025-12-21T09:50:09.000000Z\",\"id\":137}', 137, '2025-12-21 09:50:09', '2025-12-21 09:50:09'),
(40, 1, 'Approve', '{\"id\":137,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001minggu\",\"name\":\"testing 0001 minggu\",\"type_id\":3,\"category_id\":8,\"unit_id\":1,\"stock\":20,\"price\":100250,\"seller_price\":100000,\"admin_cost\":250,\"slug\":\"testing-0001-minggu-2512211650\",\"file_1\":\"1-2144_testing 0001 minggu637_1766310609_198381.exe\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"2144_testing 0001 minggu139_1766310609_112009.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-21T09:50:09.000000Z\",\"updated_at\":\"2025-12-21T09:59:46.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 137, '2025-12-21 09:59:46', '2025-12-21 09:59:46'),
(41, 34, 'Update', '{\"id\":137,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"testing0001minggu\",\"name\":\"testing 0001 minggu\",\"type_id\":\"3\",\"category_id\":\"8\",\"unit_id\":\"1\",\"stock\":\"18\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":250,\"slug\":\"testing-0001-minggu-2512211650\",\"file_1\":\"1-2144_testing 0001 minggu637_1766310609_198381.exe\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"2144_testing 0001 minggu139_1766310609_112009.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-21T09:50:09.000000Z\",\"updated_at\":\"2025-12-25T11:56:15.000000Z\"}', 137, '2025-12-25 11:56:15', '2025-12-25 11:56:15'),
(42, 34, 'Create', '{\"code\":\"egewg555\",\"name\":\"gweg ewgew 555\",\"type_id\":\"3\",\"category_id\":\"11\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":100250,\"description\":\"grg rwghwh rw hrw h\",\"image_1\":\"7888_gweg ewgew 555875_1766665487_981285.jpg\",\"seller_id\":24,\"slug\":\"gweg-ewgew-555-2512251924\",\"seller_price\":\"100000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:24:47.000000Z\",\"created_at\":\"2025-12-25T12:24:47.000000Z\",\"id\":138}', 138, '2025-12-25 12:24:47', '2025-12-25 12:24:47'),
(43, 34, 'Create', '{\"code\":\"tgegew65\",\"name\":\"gewg4wv264b  65\",\"type_id\":\"3\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":100250,\"description\":null,\"image_1\":\"5379_gewg4wv264b  65569_1766666331_622094.jpg\",\"seller_id\":24,\"slug\":\"gewg4wv264b-65-2512251938\",\"seller_price\":\"100000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:38:51.000000Z\",\"created_at\":\"2025-12-25T12:38:51.000000Z\",\"id\":139}', 139, '2025-12-25 12:38:51', '2025-12-25 12:38:51'),
(44, 34, 'Create', '{\"code\":\"feewvtwevtw89\",\"name\":\"egwvwrtrwvtw89 89\",\"type_id\":\"3\",\"category_id\":\"10\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"grherh reherh whwrhrw hrw\",\"image_1\":\"8172_egwvwrtrwvtw89 89177_1766666440_452928.jpg\",\"seller_id\":24,\"slug\":\"egwvwrtrwvtw89-89-2512251940\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:40:40.000000Z\",\"created_at\":\"2025-12-25T12:40:40.000000Z\",\"id\":140}', 140, '2025-12-25 12:40:40', '2025-12-25 12:40:40'),
(45, 34, 'Create', '{\"code\":\"fxbsfbsfbfsbs 89\",\"name\":\"dafdag agadg a 89\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"hfd hh te hteh ehte htwe\",\"image_1\":\"4437_dafdag agadg a 89472_1766666625_522668.jpg\",\"seller_id\":24,\"slug\":\"dafdag-agadg-a-89-2512251943\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:43:45.000000Z\",\"created_at\":\"2025-12-25T12:43:45.000000Z\",\"id\":141}', 141, '2025-12-25 12:43:45', '2025-12-25 12:43:45'),
(46, 34, 'Create', '{\"code\":\"vbdsfadfafa66\",\"name\":\"daadfadfagerwgw 66\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"bfsgsgsdh raegea geaw gqw\",\"image_1\":\"3239_daadfadfagerwgw 66729_1766666809_584927.jpg\",\"seller_id\":24,\"digitals\":\"a:0:{}\",\"slug\":\"daadfadfagerwgw-66-2512251946\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:46:49.000000Z\",\"created_at\":\"2025-12-25T12:46:49.000000Z\",\"id\":142}', 142, '2025-12-25 12:46:49', '2025-12-25 12:46:49'),
(47, 34, 'Create', '{\"code\":\"dsafgaeefegeq 78\",\"name\":\"dgageg eqgewgwe 78\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"gdsgewgwe gweg ewgwe gewgwe\",\"image_1\":\"1273_dgageg eqgewgwe 78371_1766667011_199828.jpg\",\"seller_id\":24,\"digitals\":\"a:0:{}\",\"slug\":\"dgageg-eqgewgwe-78-2512251950\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:50:11.000000Z\",\"created_at\":\"2025-12-25T12:50:11.000000Z\",\"id\":143}', 143, '2025-12-25 12:50:11', '2025-12-25 12:50:11'),
(48, 34, 'Create', '{\"code\":\"safafegewgwe78\",\"name\":\"safsafafaga 78\",\"type_id\":\"3\",\"category_id\":\"14\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"vdsgdsgs hrhrw hrw hrw hwr\",\"image_1\":\"9865_safsafafaga 78169_1766667237_750275.jpg\",\"seller_id\":24,\"digitals\":\"a:0:{}\",\"slug\":\"safsafafaga-78-2512251953\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:53:57.000000Z\",\"created_at\":\"2025-12-25T12:53:57.000000Z\",\"id\":144}', 144, '2025-12-25 12:53:57', '2025-12-25 12:53:57'),
(49, 34, 'Create', '{\"code\":\"qwqwfqfgqw56\",\"name\":\"rqwqrwqrwq 56\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"gdsgsgrhehe hrwe hjwrjhwr jwrjrwhw\",\"image_1\":\"7209_rqwqrwqrwq 56148_1766667346_315473.jpg\",\"seller_id\":24,\"digitals\":\"a:0:{}\",\"slug\":\"rqwqrwqrwq-56-2512251955\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:55:46.000000Z\",\"created_at\":\"2025-12-25T12:55:46.000000Z\",\"id\":145}', 145, '2025-12-25 12:55:46', '2025-12-25 12:55:46'),
(50, 34, 'Create', '{\"code\":\"fdafafasgaga33\",\"name\":\"sfadgadgadg 33\",\"type_id\":\"3\",\"category_id\":\"12\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"fdagagrw hrwhwr hw\",\"image_1\":\"3881_sfadgadgadg 33767_1766667549_368381.jpg\",\"seller_id\":24,\"digitals\":\"a:0:{}\",\"slug\":\"sfadgadgadg-33-2512251959\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T12:59:09.000000Z\",\"created_at\":\"2025-12-25T12:59:09.000000Z\",\"id\":146}', 146, '2025-12-25 12:59:09', '2025-12-25 12:59:09'),
(51, 34, 'Create', '{\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"seller_id\":24,\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"slug\":\"dvdavadgegwe-56-2512252001\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-25T13:01:36.000000Z\",\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"id\":147}', 147, '2025-12-25 13:01:36', '2025-12-25 13:01:36'),
(52, 1, 'Approve', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56\",\"type_id\":3,\"category_id\":15,\"unit_id\":1,\"stock\":20,\"price\":120250,\"seller_price\":120000,\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-25T14:23:17.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 147, '2025-12-25 14:23:17', '2025-12-25 14:23:17'),
(53, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"1\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T04:32:02.000000Z\"}', 147, '2025-12-27 04:32:02', '2025-12-27 04:32:02'),
(54, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T07:28:43.000000Z\"}', 147, '2025-12-27 08:43:04', '2025-12-27 08:43:04'),
(55, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T07:28:43.000000Z\"}', 147, '2025-12-27 09:08:08', '2025-12-27 09:08:08'),
(56, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T07:28:43.000000Z\"}', 147, '2025-12-27 09:15:38', '2025-12-27 09:15:38'),
(57, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T07:28:43.000000Z\"}', 147, '2025-12-27 09:17:48', '2025-12-27 09:17:48'),
(58, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:2:{i:0;s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";i:1;s:47:\\\"2-3944_dvdavadgegwe 56608_1766667696_778758.jpg\\\";}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:25:04.000000Z\"}', 147, '2025-12-27 09:25:04', '2025-12-27 09:25:04'),
(59, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK\",\"type_id\":\"3\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:3:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:53:\\\"1-6129_dvdavadgegwe 56 FISIK795_1766827690_895998.jpg\\\";}i:2;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:28:10.000000Z\"}', 147, '2025-12-27 09:28:10', '2025-12-27 09:28:10'),
(60, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK KEMBALI\",\"type_id\":\"1\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:30:17.000000Z\"}', 147, '2025-12-27 09:30:17', '2025-12-27 09:30:17'),
(61, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK KEMBALI\",\"type_id\":\"1\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3944_dvdavadgegwe 56694_1766667696_635687.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:30:17.000000Z\"}', 147, '2025-12-27 09:30:34', '2025-12-27 09:30:34'),
(62, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK KEMBALI\",\"type_id\":\"1\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"1-8408_dvdavadgegwe 56 FISIK KEMBALI147_1766828324_198156.jpeg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:38:44.000000Z\"}', 147, '2025-12-27 09:38:44', '2025-12-27 09:38:44'),
(63, 34, 'Update', '{\"id\":147,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"sdvdsgsdgewtwetgw56\",\"name\":\"dvdavadgegwe 56 FISIK KEMBALI\",\"type_id\":\"1\",\"category_id\":\"15\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":\"120250\",\"seller_price\":\"120250\",\"admin_cost\":250,\"slug\":\"dvdavadgegwe-56-2512252001\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:47:\\\"1-3944_dvdavadgegwe 56279_1766667696_988972.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:47:\\\"3-3944_dvdavadgegwe 56636_1766667696_998499.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"1-8408_dvdavadgegwe 56 FISIK KEMBALI147_1766828324_198156.jpeg\",\"image_2\":null,\"image_3\":\"1-1606_dvdavadgegwe 56 FISIK KEMBALI63_1766828352_386021.jpg\",\"image_4\":null,\"description\":\"sdgrwhwjrj wjrw jrwjrw jrw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-25T13:01:36.000000Z\",\"updated_at\":\"2025-12-27T09:39:12.000000Z\"}', 147, '2025-12-27 09:39:12', '2025-12-27 09:39:12');
INSERT INTO `product_logs` (`id`, `user_id`, `activity`, `note`, `product_id`, `created_at`, `updated_at`) VALUES
(64, 34, 'Create', '{\"code\":\"baruagain1\",\"name\":\"baru again 1\",\"type_id\":\"3\",\"category_id\":\"12\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":120250,\"description\":null,\"image_1\":\"949_baru again 1779_1766828752_318145.jpg\",\"seller_id\":24,\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:43:\\\"1-949_baru again 1190_1766828752_926558.jpg\\\";}}\",\"slug\":\"baru-again-1-2512271645\",\"seller_price\":\"120000\",\"admin_cost_id\":1,\"admin_cost\":250,\"updated_at\":\"2025-12-27T09:45:52.000000Z\",\"created_at\":\"2025-12-27T09:45:52.000000Z\",\"id\":148}', 148, '2025-12-27 09:45:52', '2025-12-27 09:45:52'),
(65, 1, 'Approve', '{\"id\":148,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"baruagain1\",\"name\":\"baru again 1\",\"type_id\":3,\"category_id\":12,\"unit_id\":1,\"stock\":20,\"price\":120250,\"seller_price\":120000,\"admin_cost\":250,\"slug\":\"baru-again-1-2512271645\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:43:\\\"1-949_baru again 1190_1766828752_926558.jpg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"949_baru again 1779_1766828752_318145.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-27T09:45:52.000000Z\",\"updated_at\":\"2025-12-27T09:59:40.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 148, '2025-12-27 09:59:40', '2025-12-27 09:59:40'),
(66, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"131415\",\"name\":\"noken asli papua\",\"type_id\":\"3\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"0\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":250,\"slug\":\"noken-asli-papua-2511041849\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:5:\\\"value\\\";}}\",\"file_1\":\"\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-12-27T14:48:19.000000Z\"}', 126, '2025-12-27 14:48:19', '2025-12-27 14:48:19'),
(67, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"131415\",\"name\":\"noken asli papua\",\"type_id\":\"1\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":250,\"slug\":\"noken-asli-papua-2511041849\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:5:\\\"value\\\";}}\",\"file_1\":\"\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-12-27T14:49:17.000000Z\"}', 126, '2025-12-27 14:49:17', '2025-12-27 14:49:17'),
(68, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"131415\",\"name\":\"noken asli papua\",\"type_id\":\"1\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":250,\"slug\":\"noken-asli-papua-2511041849\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:5:\\\"value\\\";}}\",\"file_1\":\"\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-12-27T14:49:17.000000Z\"}', 126, '2025-12-27 14:56:00', '2025-12-27 14:56:00'),
(69, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"131415\",\"name\":\"noken asli papua\",\"type_id\":\"3\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":250,\"slug\":\"noken-asli-papua-2511041849\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:48:\\\"1-7011_noken asli papua115_1766847481_575548.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:48:\\\"2-7011_noken asli papua369_1766847481_921312.jpg\\\";}}\",\"file_1\":\"\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-12-27T14:58:01.000000Z\"}', 126, '2025-12-27 14:58:01', '2025-12-27 14:58:01'),
(70, 34, 'Update', '{\"id\":126,\"admin_cost_id\":1,\"seller_id\":24,\"code\":\"131415\",\"name\":\"noken asli papua\",\"type_id\":\"1\",\"category_id\":\"6\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":\"350250\",\"seller_price\":\"350250\",\"admin_cost\":250,\"slug\":\"noken-asli-papua-2511041849\",\"digitals\":\"a:2:{i:0;a:1:{s:4:\\\"name\\\";s:48:\\\"1-7011_noken asli papua115_1766847481_575548.jpg\\\";}i:1;a:1:{s:4:\\\"name\\\";s:48:\\\"2-7011_noken asli papua369_1766847481_921312.jpg\\\";}}\",\"file_1\":\"\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"WhatsApp Image 2025-11-04 at 15.05.10 (2)_1762256992.jpeg\",\"image_2\":\"WhatsApp Image 2025-11-04 at 15.05.08 (1)_1762256992.jpeg\",\"image_3\":\"WhatsApp Image 2025-11-04 at 15.05.08_1762256992.jpeg\",\"image_4\":\"WhatsApp Image 2025-11-04 at 15.05.05_1762256992.jpeg\",\"description\":\"noken asli papua dengan tema asli papua\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-11-04T11:49:52.000000Z\",\"updated_at\":\"2025-12-27T14:58:37.000000Z\"}', 126, '2025-12-27 14:58:37', '2025-12-27 14:58:37'),
(71, 34, 'Create', '{\"code\":\"coeifeqfpqe99\",\"name\":\"cwiqgwqw q99\",\"type_id\":\"1\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"20\",\"price\":100000,\"description\":\"feqoifheqof qepfoqep foj eqpgepqj gp[q\",\"weight\":\"1000\",\"image_1\":\"5047_cwiqgwqw q99145_1767865587_743925.jpeg\",\"seller_id\":24,\"slug\":\"cwiqgwqw-q99-2601081646\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"updated_at\":\"2026-01-08T09:46:27.000000Z\",\"created_at\":\"2026-01-08T09:46:27.000000Z\",\"id\":149}', 149, '2026-01-08 09:46:27', '2026-01-08 09:46:27'),
(72, 34, 'Create', '{\"code\":\"vdlafoeif reqoirq88\",\"name\":\"dvioihphfep p 88\",\"type_id\":\"1\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"1000\",\"price\":100000,\"description\":null,\"weight\":\"0\",\"image_1\":\"7576_dvioihphfep p 88890_1767865831_666466.jpeg\",\"seller_id\":24,\"slug\":\"dvioihphfep-p-88-2601081650\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"updated_at\":\"2026-01-08T09:50:31.000000Z\",\"created_at\":\"2026-01-08T09:50:31.000000Z\",\"id\":150}', 150, '2026-01-08 09:50:31', '2026-01-08 09:50:31'),
(73, 34, 'Create', '{\"code\":\"qqowprqwopfwq90\",\"name\":\"wfowqyfqwifpw q 90\",\"type_id\":\"1\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":100000,\"description\":\"feoifqep ogeqpghoqe pgjpqegq\",\"weight\":\"0\",\"image_1\":\"822_wfowqyfqwifpw q 90333_1767865913_403890.jpeg\",\"seller_id\":24,\"slug\":\"wfowqyfqwifpw-q-90-2601081651\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"updated_at\":\"2026-01-08T09:51:53.000000Z\",\"created_at\":\"2026-01-08T09:51:53.000000Z\",\"id\":151}', 151, '2026-01-08 09:51:53', '2026-01-08 09:51:53'),
(74, 34, 'Create', '{\"code\":\"4iihgegopgeo\",\"name\":\"foeo eihgqe q89\",\"type_id\":\"1\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":100000,\"description\":\"doihfe geqpgoqepg oqejgpoqe gqe\",\"weight\":\"1000\",\"image_1\":\"2714_foeo eihgqe q89902_1767866198_425504.jpeg\",\"seller_id\":24,\"slug\":\"foeo-eihgqe-q89-2601081656\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":\"1\",\"updated_at\":\"2026-01-08T09:56:38.000000Z\",\"created_at\":\"2026-01-08T09:56:38.000000Z\",\"id\":152}', 152, '2026-01-08 09:56:38', '2026-01-08 09:56:38'),
(75, 34, 'Create', '{\"code\":\"ncihqeihp999\",\"name\":\"dhvqeoihfeqpofqe 99\",\"type_id\":\"1\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"1000\",\"price\":100000,\"description\":\"dofhefgio epgohep goj eqp gojeqopgewgw\",\"weight\":\"1000\",\"image_1\":\"8105_dhvqeoihfeqpofqe 99347_1767866278_272772.jpg\",\"seller_id\":24,\"slug\":\"dhvqeoihfeqpofqe-99-2601081657\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-08T09:57:58.000000Z\",\"created_at\":\"2026-01-08T09:57:58.000000Z\",\"id\":153}', 153, '2026-01-08 09:57:58', '2026-01-08 09:57:58'),
(76, 1, 'Approve', '{\"id\":153,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"ncihqeihp999\",\"name\":\"dhvqeoihfeqpofqe 99\",\"type_id\":1,\"category_id\":1,\"sub_category_id\":null,\"unit_id\":1,\"weight\":1000,\"stock\":1000,\"price\":100000,\"seller_price\":100000,\"admin_cost\":0,\"slug\":\"dhvqeoihfeqpofqe-99-2601081657\",\"digitals\":null,\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"8105_dhvqeoihfeqpofqe 99347_1767866278_272772.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"dofhefgio epgohep goj eqp gojeqopgewgw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-08T09:57:58.000000Z\",\"updated_at\":\"2026-01-08T09:59:33.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 153, '2026-01-08 09:59:34', '2026-01-08 09:59:34'),
(77, 34, 'Update', '{\"id\":153,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"ncihqeihp999\",\"name\":\"dhvqeoihfeqpofqe 99\",\"type_id\":\"1\",\"category_id\":\"3\",\"sub_category_id\":\"3\",\"unit_id\":\"1\",\"weight\":\"1000\",\"stock\":\"1000\",\"price\":\"100000\",\"seller_price\":\"100000\",\"admin_cost\":0,\"slug\":\"dhvqeoihfeqpofqe-99-2601081657\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:5:\\\"value\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"8105_dhvqeoihfeqpofqe 99347_1767866278_272772.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"dofhefgio epgohep goj eqp gojeqopgewgw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-08T09:57:58.000000Z\",\"updated_at\":\"2026-01-09T07:26:46.000000Z\"}', 153, '2026-01-09 07:26:46', '2026-01-09 07:26:46'),
(78, 34, 'Update', '{\"id\":136,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"testing0001\",\"name\":\"testing 0001 edit ke digital\",\"type_id\":\"3\",\"category_id\":\"9\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"1000\",\"stock\":\"9\",\"price\":\"100250\",\"seller_price\":\"100250\",\"admin_cost\":0,\"slug\":\"testing-0001-2512201355\",\"digitals\":null,\"file_1\":\"D:\\\\wamp64\\\\tmp\\\\php4FD7.tmp\",\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"6982_testing 0001393_1766213741_994929.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":null,\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2025-12-20T06:55:41.000000Z\",\"updated_at\":\"2026-01-10T14:15:25.000000Z\"}', 136, '2026-01-10 14:15:26', '2026-01-10 14:15:26'),
(79, 34, 'Create', '{\"code\":\"testingreza01\",\"name\":\"testing reza 01\",\"type_id\":\"3\",\"category_id\":\"4\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":100000,\"description\":\"fegew hrwhrw h rwhwr hwr\",\"weight\":\"0\",\"image_1\":\"4133_testing reza 01820_1768055220_829792.jpg\",\"seller_id\":24,\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:48:\\\"1-4133_testing reza 01154_1768055220_747229.jpeg\\\";}}\",\"slug\":\"testing-reza-01-2601102127\",\"seller_price\":\"100000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-10T14:27:00.000000Z\",\"created_at\":\"2026-01-10T14:27:00.000000Z\",\"id\":154}', 154, '2026-01-10 14:27:00', '2026-01-10 14:27:00'),
(80, 1, 'Approve', '{\"id\":154,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"testingreza01\",\"name\":\"testing reza 01\",\"type_id\":3,\"category_id\":4,\"sub_category_id\":null,\"unit_id\":1,\"weight\":0,\"stock\":100,\"price\":100000,\"seller_price\":100000,\"admin_cost\":0,\"slug\":\"testing-reza-01-2601102127\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:48:\\\"1-4133_testing reza 01154_1768055220_747229.jpeg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"4133_testing reza 01820_1768055220_829792.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"fegew hrwhrw h rwhwr hwr\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-10T14:27:00.000000Z\",\"updated_at\":\"2026-01-10T14:30:05.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 154, '2026-01-10 14:30:05', '2026-01-10 14:30:05'),
(81, 34, 'Update', '{\"id\":154,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"testingreza01\",\"name\":\"testing reza 01\",\"type_id\":\"3\",\"category_id\":\"4\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"1000\",\"stock\":\"100\",\"price\":\"100000\",\"seller_price\":\"100000\",\"admin_cost\":0,\"slug\":\"testing-reza-01-2601102127\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:48:\\\"1-4133_testing reza 01154_1768055220_747229.jpeg\\\";}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"4133_testing reza 01820_1768055220_829792.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"fegew hrwhrw h rwhwr hwr\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-10T14:27:00.000000Z\",\"updated_at\":\"2026-01-10T14:32:51.000000Z\"}', 154, '2026-01-10 14:32:51', '2026-01-10 14:32:51'),
(82, 34, 'Create', '{\"code\":\"digitalsubstime01\",\"name\":\"digitalsubstime 01\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":50000,\"description\":\"gewoihgewpgo ewpgojew pgoew hew\",\"weight\":\"0\",\"image_1\":\"9715_digitalsubstime 01447_1768370710_608723.jpg\",\"seller_id\":24,\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-9715_digitalsubstime 01102_1768370710_699596.jpeg\\\";}}\",\"slug\":\"digitalsubstime-01-2601141305\",\"seller_price\":\"50000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":\"1\",\"updated_at\":\"2026-01-14T06:05:10.000000Z\",\"created_at\":\"2026-01-14T06:05:10.000000Z\",\"id\":155}', 155, '2026-01-14 06:05:10', '2026-01-14 06:05:10'),
(83, 34, 'Create', '{\"code\":\"digitalsubstime03\",\"name\":\"digitalsubstime 03\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":50000,\"description\":\"pfeowgpewo pgoewjog[e wpgjw[ gkpew[ gpkjew[gw\",\"weight\":\"0\",\"image_1\":\"1101_digitalsubstime 03711_1768371010_724284.jpg\",\"seller_id\":24,\"subtimes\":\"s:7:\\\"2 bulan\\\";\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-1101_digitalsubstime 03555_1768371010_889915.jpeg\\\";}}\",\"slug\":\"digitalsubstime-03-2601141310\",\"seller_price\":\"50000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-14T06:10:10.000000Z\",\"created_at\":\"2026-01-14T06:10:10.000000Z\",\"id\":156}', 156, '2026-01-14 06:10:10', '2026-01-14 06:10:10'),
(84, 1, 'Approve', '{\"id\":156,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime03\",\"name\":\"digitalsubstime 03\",\"type_id\":3,\"category_id\":1,\"sub_category_id\":null,\"unit_id\":1,\"weight\":0,\"stock\":100,\"price\":50000,\"seller_price\":50000,\"admin_cost\":0,\"slug\":\"digitalsubstime-03-2601141310\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-1101_digitalsubstime 03555_1768371010_889915.jpeg\\\";}}\",\"subtimes\":\"s:7:\\\"2 bulan\\\";\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"1101_digitalsubstime 03711_1768371010_724284.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"pfeowgpewo pgoewjog[e wpgjw[ gkpew[ gpkjew[gw\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:10:10.000000Z\",\"updated_at\":\"2026-01-14T06:11:37.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 156, '2026-01-14 06:11:37', '2026-01-14 06:11:37'),
(85, 34, 'Create', '{\"code\":\"digitalsubstime04\",\"name\":\"digitalsubstime 04\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":49998,\"description\":\"foiahfgogeihgpeoqpg eqopgoeqgoeqpgo qep\",\"weight\":\"0\",\"image_1\":\"4051_digitalsubstime 0492_1768371587_375554.jpg\",\"seller_id\":24,\"subtimes\":\"s:7:\\\"2 bulan\\\";\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-4051_digitalsubstime 04612_1768371587_123633.jpeg\\\";}}\",\"slug\":\"digitalsubstime-04-2601141319\",\"seller_price\":\"49998\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-14T06:19:47.000000Z\",\"created_at\":\"2026-01-14T06:19:47.000000Z\",\"id\":157}', 157, '2026-01-14 06:19:47', '2026-01-14 06:19:47'),
(86, 34, 'Create', '{\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":0,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"weight\":\"0\",\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"seller_id\":24,\"subtimes\":\"a:2:{i:0;s:7:\\\"1 bulan\\\";i:1;s:7:\\\"2 bulan\\\";}\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"slug\":\"digitalsubstime-06-2601141322\",\"seller_price\":\"0\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-14T06:22:06.000000Z\",\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"id\":158}', 158, '2026-01-14 06:22:06', '2026-01-14 06:22:06'),
(87, 1, 'Approve', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":3,\"category_id\":1,\"sub_category_id\":null,\"unit_id\":1,\"weight\":0,\"stock\":100,\"price\":0,\"seller_price\":0,\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":\"a:2:{i:0;s:7:\\\"1 bulan\\\";i:1;s:7:\\\"2 bulan\\\";}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T06:23:25.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 158, '2026-01-14 06:23:25', '2026-01-14 06:23:25'),
(88, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T06:24:02.000000Z\"}', 158, '2026-01-14 06:24:02', '2026-01-14 06:24:02'),
(89, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\",\"3 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:00:42.000000Z\"}', 158, '2026-01-14 09:00:42', '2026-01-14 09:00:42'),
(90, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:03:13.000000Z\"}', 158, '2026-01-14 09:03:13', '2026-01-14 09:03:13'),
(91, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:06:25.000000Z\"}', 158, '2026-01-14 09:06:25', '2026-01-14 09:06:25'),
(92, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:08:39.000000Z\"}', 158, '2026-01-14 09:08:40', '2026-01-14 09:08:40'),
(93, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:09:57.000000Z\"}', 158, '2026-01-14 09:09:57', '2026-01-14 09:09:57'),
(94, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:11:20.000000Z\"}', 158, '2026-01-14 09:11:20', '2026-01-14 09:11:20'),
(95, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:15:17.000000Z\"}', 158, '2026-01-14 09:15:17', '2026-01-14 09:15:17'),
(96, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":[\"1 bulan\",\"2 bulan\"],\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:20:11.000000Z\"}', 158, '2026-01-14 09:20:11', '2026-01-14 09:20:11'),
(97, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":\"a:2:{i:0;s:7:\\\"1 bulan\\\";i:1;s:7:\\\"2 bulan\\\";}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:20:11.000000Z\"}', 158, '2026-01-14 09:29:28', '2026-01-14 09:29:28'),
(98, 34, 'Update', '{\"id\":158,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalsubstime06\",\"name\":\"digitalsubstime 06\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"0\",\"seller_price\":\"0\",\"admin_cost\":0,\"slug\":\"digitalsubstime-06-2601141322\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:51:\\\"1-3428_digitalsubstime 06503_1768371726_157305.jpeg\\\";}}\",\"subtimes\":\"a:3:{i:0;s:7:\\\"1 bulan\\\";i:1;s:7:\\\"2 bulan\\\";i:2;s:7:\\\"1 tahun\\\";}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"3428_digitalsubstime 06160_1768371726_614311.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"feoifeq fpqe ofgeqpogeqpgo heqpgooehq pgeq\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T06:22:06.000000Z\",\"updated_at\":\"2026-01-14T09:30:01.000000Z\"}', 158, '2026-01-14 09:30:01', '2026-01-14 09:30:01'),
(99, 34, 'Create', '{\"code\":\"digital555\",\"name\":\"digital 555\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":50000,\"description\":\"foeihgoeqigpeq opoq geq\",\"weight\":\"0\",\"image_1\":\"8902_digital 555741_1768387442_900813.jpg\",\"seller_id\":24,\"subtimes\":\"a:2:{i:0;a:2:{s:7:\\\"subtime\\\";s:7:\\\"1 bulan\\\";s:8:\\\"subprice\\\";s:5:\\\"20000\\\";}i:1;a:2:{s:7:\\\"subtime\\\";s:7:\\\"2 bulan\\\";s:8:\\\"subprice\\\";s:5:\\\"35000\\\";}}\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:44:\\\"1-8902_digital 555691_1768387442_338143.jpeg\\\";}}\",\"slug\":\"digital-555-2601141744\",\"seller_price\":\"50000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-14T10:44:02.000000Z\",\"created_at\":\"2026-01-14T10:44:02.000000Z\",\"id\":159}', 159, '2026-01-14 10:44:02', '2026-01-14 10:44:02'),
(100, 34, 'Create', '{\"code\":\"digitalaaa\",\"name\":\"digital aaa\",\"type_id\":\"3\",\"category_id\":\"1\",\"unit_id\":\"1\",\"stock\":\"100\",\"price\":10000,\"description\":\"vfoeihfgpeqofgpewo gpewjg we\",\"weight\":\"0\",\"image_1\":\"5095_digital aaa637_1768388171_947495.jpg\",\"seller_id\":24,\"subtimes\":\"a:2:{i:0;a:3:{s:7:\\\"subtime\\\";s:7:\\\"1 bulan\\\";s:8:\\\"subprice\\\";i:20000;s:14:\\\"subsellerprice\\\";i:20000;}i:1;a:3:{s:7:\\\"subtime\\\";s:7:\\\"2 bulan\\\";s:8:\\\"subprice\\\";i:35000;s:14:\\\"subsellerprice\\\";i:35000;}}\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:44:\\\"1-5095_digital aaa716_1768388171_840129.jpeg\\\";}}\",\"slug\":\"digital-aaa-2601141756\",\"seller_price\":\"10000\",\"admin_cost_id\":null,\"admin_cost\":0,\"sub_category_id\":null,\"updated_at\":\"2026-01-14T10:56:11.000000Z\",\"created_at\":\"2026-01-14T10:56:11.000000Z\",\"id\":160}', 160, '2026-01-14 10:56:11', '2026-01-14 10:56:11'),
(101, 1, 'Approve', '{\"id\":160,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalaaa\",\"name\":\"digital aaa\",\"type_id\":3,\"category_id\":1,\"sub_category_id\":null,\"unit_id\":1,\"weight\":0,\"stock\":100,\"price\":10000,\"seller_price\":10000,\"admin_cost\":0,\"slug\":\"digital-aaa-2601141756\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:44:\\\"1-5095_digital aaa716_1768388171_840129.jpeg\\\";}}\",\"subtimes\":\"a:2:{i:0;a:3:{s:7:\\\"subtime\\\";s:7:\\\"1 bulan\\\";s:8:\\\"subprice\\\";i:20000;s:14:\\\"subsellerprice\\\";i:20000;}i:1;a:3:{s:7:\\\"subtime\\\";s:7:\\\"2 bulan\\\";s:8:\\\"subprice\\\";i:35000;s:14:\\\"subsellerprice\\\";i:35000;}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5095_digital aaa637_1768388171_947495.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"vfoeihfgpeqofgpewo gpewjg we\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T10:56:11.000000Z\",\"updated_at\":\"2026-01-14T11:02:08.000000Z\",\"seller\":{\"id\":24,\"username\":\"tokonoken\",\"name\":\"toko noken\",\"email\":\"tokonoken@gmail.com\",\"tax_number\":\"99762728188118\",\"business_number\":\"081248419335\",\"phone\":\"81248419335\",\"address\":\"jln pendidikan\",\"city\":\"merauke\",\"province\":\"papua selatan\",\"country\":\"indonesia\",\"zip\":\"99616\",\"status\":4,\"note\":null,\"user_id\":34,\"created_at\":\"2025-11-04T06:14:37.000000Z\",\"updated_at\":\"2025-11-04T06:17:48.000000Z\",\"bank_name\":null,\"bank_account_name\":null,\"bank_account_number\":null,\"bank_code\":null}}', 160, '2026-01-14 11:02:08', '2026-01-14 11:02:08'),
(102, 34, 'Update', '{\"id\":160,\"admin_cost_id\":null,\"seller_id\":24,\"code\":\"digitalaaa\",\"name\":\"digital aaa\",\"type_id\":\"3\",\"category_id\":\"1\",\"sub_category_id\":null,\"unit_id\":\"1\",\"weight\":\"0\",\"stock\":\"100\",\"price\":\"10000\",\"seller_price\":\"10000\",\"admin_cost\":0,\"slug\":\"digital-aaa-2601141756\",\"digitals\":\"a:1:{i:0;a:1:{s:4:\\\"name\\\";s:44:\\\"1-5095_digital aaa716_1768388171_840129.jpeg\\\";}}\",\"subtimes\":\"a:3:{i:0;a:3:{s:7:\\\"subtime\\\";s:7:\\\"1 bulan\\\";s:8:\\\"subprice\\\";i:20000;s:14:\\\"subsellerprice\\\";i:20000;}i:1;a:3:{s:7:\\\"subtime\\\";s:7:\\\"2 bulan\\\";s:8:\\\"subprice\\\";i:35000;s:14:\\\"subsellerprice\\\";i:35000;}i:2;a:3:{s:7:\\\"subtime\\\";s:7:\\\"3 bulan\\\";s:8:\\\"subprice\\\";i:50000;s:14:\\\"subsellerprice\\\";i:50000;}}\",\"file_1\":null,\"file_2\":null,\"file_3\":null,\"file_4\":null,\"image_1\":\"5095_digital aaa637_1768388171_947495.jpg\",\"image_2\":null,\"image_3\":null,\"image_4\":null,\"description\":\"vfoeihfgpeqofgpewo gpewjg we\",\"note\":null,\"status\":2,\"total_sells\":null,\"created_at\":\"2026-01-14T10:56:11.000000Z\",\"updated_at\":\"2026-01-14T11:11:26.000000Z\"}', 160, '2026-01-14 11:11:26', '2026-01-14 11:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'admin', '2025-03-30 19:23:41', '2025-03-30 19:23:41'),
(2, 'admin', 'admin', '2025-03-30 19:23:41', '2025-03-30 19:23:41'),
(3, 'customer', 'customer', '2025-03-30 19:23:41', '2025-03-30 19:23:41'),
(4, 'seller', 'seller', '2025-03-30 19:23:41', '2025-03-30 19:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
CREATE TABLE IF NOT EXISTS `sellers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `note` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sellers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `username`, `name`, `email`, `tax_number`, `business_number`, `phone`, `address`, `city`, `province`, `country`, `zip`, `status`, `note`, `user_id`, `created_at`, `updated_at`, `bank_name`, `bank_account_name`, `bank_account_number`, `bank_code`) VALUES
(1, 'eprakasa', 'PD Fujiati Salahudin', 'rika90@example.net', NULL, NULL, '081061069516', 'Gg. Rumah Sakit No. 355, Malang 53028, Sumsel', 'Cimahi', 'Sulawesi Utara', 'Indonesia', '20317', 4, NULL, 3, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(2, 'jrajasa', 'PD Prasetyo (Persero) Tbk', 'spurwanti@example.org', NULL, NULL, '088020912111', 'Jln. Bayan No. 889, Bekasi 80868, Sulbar', 'Jambi', 'Kalimantan Utara', 'Indonesia', '29997', 4, NULL, 4, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(3, 'utami.puti', 'Yayasan Hassanah Sitorus Tbk', 'kairav91@example.net', NULL, NULL, '084531978800', 'Kpg. Taman No. 651, Parepare 41168, Babel', 'Lhokseumawe', 'Kepulauan Bangka Belitung', 'Indonesia', '75335', 4, NULL, 5, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(4, 'raharja03', 'Fa Narpati Tbk', 'znurdiyanti@example.com', NULL, NULL, '082756585864', 'Ki. Fajar No. 681, Samarinda 39588, NTT', 'Tual', 'Nusa Tenggara Barat', 'Indonesia', '81547', 4, NULL, 6, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(5, 'bagya52', 'UD Wibowo Mustofa (Persero) Tbk', 'hardana08@example.com', NULL, NULL, '089736465428', 'Kpg. Jagakarsa No. 352, Ternate 29489, Sumbar', 'Tomohon', 'Maluku Utara', 'Indonesia', '85620', 4, NULL, 7, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(6, 'gpudjiastuti', 'PJ Sihombing', 'wibisono.ajiman@example.net', NULL, NULL, '086262696896', 'Ki. Balikpapan No. 407, Pematangsiantar 63592, DIY', 'Ternate', 'Banten', 'Indonesia', '30420', 4, NULL, 8, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(7, 'setya34', 'PJ Maheswara Widiastuti (Persero) Tbk', 'atma49@example.com', NULL, NULL, '085154356912', 'Gg. Zamrud No. 685, Malang 37061, Kepri', 'Parepare', 'Kepulauan Riau', 'Indonesia', '46629', 4, NULL, 9, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(8, 'hastuti.darman', 'Yayasan Usamah Prasasta', 'prabowo.karma@example.com', NULL, NULL, '088260082831', 'Jr. Gajah Mada No. 833, Pontianak 79236, Sumut', 'Palu', 'Gorontalo', 'Indonesia', '30569', 4, NULL, 10, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(9, 'hidayat.hasna', 'Yayasan Hassanah Manullang Tbk', 'wakiman.novitasari@example.com', NULL, NULL, '081259008113', 'Kpg. Adisucipto No. 185, Pariaman 72763, DIY', 'Jambi', 'Kepulauan Riau', 'Indonesia', '60087', 4, NULL, 11, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(10, 'suci.farida', 'Fa Tamba (Persero) Tbk', 'azalea32@example.net', NULL, NULL, '086890082978', 'Jln. Basoka No. 225, Jayapura 17288, Bengkulu', 'Sorong', 'Nusa Tenggara Barat', 'Indonesia', '28490', 4, NULL, 12, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(11, 'nhidayanto', 'UD Laksmiwati Pratiwi Tbk', 'pprasetya@example.net', NULL, NULL, '088389298302', 'Dk. Kebonjati No. 287, Sawahlunto 20998, Aceh', 'Tebing Tinggi', 'Gorontalo', 'Indonesia', '11781', 4, NULL, 13, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(12, 'maimunah.hakim', 'Perum Farida', 'haryanto.jarwi@example.com', NULL, NULL, '086964407132', 'Kpg. Bappenas No. 989, Sabang 16021, Banten', 'Dumai', 'Kalimantan Timur', 'Indonesia', '87847', 4, NULL, 14, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(13, 'devi51', 'Fa Aryani Suartini', 'osetiawan@example.com', NULL, NULL, '083170222480', 'Jr. R.E. Martadinata No. 896, Banjarmasin 40273, Lampung', 'Tarakan', 'Jambi', 'Indonesia', '26360', 4, NULL, 15, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(14, 'lthamrin', 'CV Zulaika Wahyuni', 'yhalim@example.net', NULL, NULL, '080491440203', 'Ds. Madrasah No. 458, Denpasar 70875, Kaltim', 'Tomohon', 'Maluku', 'Indonesia', '88657', 4, NULL, 16, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(15, 'olivia.wastuti', 'UD Novitasari Zulaika', 'nmansur@example.org', NULL, NULL, '084635602957', 'Ki. Jakarta No. 237, Padangpanjang 40321, Kaltim', 'Banjarbaru', 'Kepulauan Bangka Belitung', 'Indonesia', '35459', 4, NULL, 17, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(16, 'prasasta.lembah', 'UD Mardhiyah Tarihoran', 'salimah.jailani@example.net', NULL, NULL, '088416622235', 'Ds. Raden Saleh No. 994, Kotamobagu 60809, Sumbar', 'Bontang', 'Sulawesi Barat', 'Indonesia', '91432', 4, NULL, 18, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(17, 'mutia.yulianti', 'PD Hasanah Novitasari (Persero) Tbk', 'michelle.purnawati@example.com', NULL, NULL, '085213812919', 'Kpg. Wahid No. 681, Ternate 80986, NTB', 'Prabumulih', 'Sulawesi Tengah', 'Indonesia', '72257', 4, NULL, 19, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(18, 'ophelia32', 'Yayasan Wahyuni Safitri Tbk', 'yulianti.irfan@example.org', NULL, NULL, '083135741262', 'Psr. Yos Sudarso No. 459, Salatiga 25857, Kalbar', 'Palangka Raya', 'Jawa Timur', 'Indonesia', '28604', 4, NULL, 20, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(19, 'mfarida', 'UD Widiastuti Iswahyudi', 'hesti46@example.com', NULL, NULL, '089646055867', 'Ds. Gambang No. 526, Cimahi 97735, Sulbar', 'Administrasi Jakarta Pusat', 'Sumatera Selatan', 'Indonesia', '16484', 4, NULL, 21, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL, NULL, NULL, NULL),
(21, 'seller', 'seller', 'seller@gmail.com', '1111111', '111111', '85869101484', 'Gondang Sari, Jlarem, Gladagsari, Boyolali, RT01, RW03', 'Kabupaten Boyolali', 'Central Java', 'Indonesia', '57352', 4, NULL, 22, '2025-03-30 19:25:23', '2025-03-30 19:37:14', NULL, NULL, NULL, NULL),
(22, 'seler1', 'xion', 'seler1@gmail.com', '99616', '081248419336', '81248419335', 'jln pendidikan', 'merauke', 'papua selatan', 'indonesia', '99616', 4, NULL, 25, '2025-04-03 08:40:03', '2025-04-03 08:44:25', NULL, NULL, NULL, NULL),
(24, 'tokonoken', 'toko noken', 'tokonoken@gmail.com', '99762728188118', '081248419335', '81248419335', 'jln pendidikan', 'merauke', 'papua selatan', 'indonesia', '99616', 4, NULL, 34, '2025-11-04 06:14:37', '2025-11-04 06:17:48', NULL, NULL, NULL, NULL),
(25, 'ramalaura@gmail.com', 'reeza', 'ramalaura@gmail.com', '535135135', '082113498393', '082113498393', 'Jakarta', 'jakarta', 'jakarta', 'Indonesia', '10230', 1, NULL, 36, '2025-12-09 11:53:10', '2025-12-09 11:53:10', NULL, NULL, NULL, NULL),
(26, 'ananarlia123', 'reeza', 'ananarlia123@gmail.com', '26264246', '082113498393', '082113498393', 'Jakarta', 'jakarta', 'jakarta', 'Indonesia', '10230', 1, NULL, 37, '2025-12-09 11:54:56', '2025-12-09 11:54:56', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller_balances`
--

DROP TABLE IF EXISTS `seller_balances`;
CREATE TABLE IF NOT EXISTS `seller_balances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` bigint NOT NULL,
  `transaction_id` bigint DEFAULT NULL,
  `withdraw_id` bigint DEFAULT NULL,
  `amount` double NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seller_balances_transaction_id_unique` (`transaction_id`),
  UNIQUE KEY `seller_balances_withdraw_id_unique` (`withdraw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_balances`
--

INSERT INTO `seller_balances` (`id`, `seller_id`, `transaction_id`, `withdraw_id`, `amount`, `type`, `created_at`, `updated_at`) VALUES
(1, 21, 3, NULL, 1200, 'in', '2025-04-02 11:10:34', '2025-04-02 11:10:34'),
(2, 22, 4, NULL, 10004, 'in', '2025-04-03 09:17:08', '2025-04-03 09:17:08'),
(3, 22, NULL, 1, 10000, 'out', '2025-04-03 09:22:43', '2025-04-03 09:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `seller_banners`
--

DROP TABLE IF EXISTS `seller_banners`;
CREATE TABLE IF NOT EXISTS `seller_banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_withdraws`
--

DROP TABLE IF EXISTS `seller_withdraws`;
CREATE TABLE IF NOT EXISTS `seller_withdraws` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` bigint NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `amount` double NOT NULL,
  `success_at` datetime DEFAULT NULL,
  `approval_by` bigint DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `note_reject` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seller_withdraws_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_withdraws`
--

INSERT INTO `seller_withdraws` (`id`, `seller_id`, `code`, `note`, `amount`, `success_at`, `approval_by`, `image`, `status`, `note_reject`, `created_at`, `updated_at`) VALUES
(1, 22, 'WD202504031618002841', '1540016444220', 10000, '2025-04-03 16:22:43', 1, 'screenshot_2025_04_03_at_182231_1743672163.png', 2, NULL, '2025-04-03 09:18:39', '2025-04-03 09:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `setting_about_us`
--

DROP TABLE IF EXISTS `setting_about_us`;
CREATE TABLE IF NOT EXISTS `setting_about_us` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleteable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_about_us`
--

INSERT INTO `setting_about_us` (`id`, `key`, `title`, `subtitle`, `image`, `is_deleteable`, `created_at`, `updated_at`) VALUES
(1, 'main', 'Belanja barang tradisional di Olebsai', 'Rasakan keindahan budaya, beli barang tradisional sekarang', 'banner_about_1.jpg', 0, NULL, NULL),
(2, 'about', 'Tingkatkan koleksi Anda dengan barang-barang tradisional unik', 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.', NULL, 0, NULL, NULL),
(3, 'mission', 'Kami ingin membentuk dan memajukan usaha lokal di Indonesia', 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.', 'content_about.jpg', 0, NULL, NULL),
(4, 'impact', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.', 'content_about_1.jpg', 1, NULL, NULL),
(5, 'impact', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.', 'content_about_2.jpg', 1, NULL, NULL),
(6, 'impact', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.', 'content_about_3.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_categories`
--

DROP TABLE IF EXISTS `setting_categories`;
CREATE TABLE IF NOT EXISTS `setting_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'okedeh',
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_categories_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_categories`
--

INSERT INTO `setting_categories` (`id`, `label`, `code`, `slug`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'okedeh', 'CAT001', 'makanan-minuman', 'Kulinerz', '1.jpg', 1, '2025-03-30 19:23:47', '2025-12-30 07:36:41'),
(2, 'okedeh', 'CAT002', 'kerajinan-tangan', 'Kriya', '2.jpeg', 1, '2025-03-30 19:23:47', '2025-09-16 06:24:25'),
(3, 'okedeh', 'CAT003', 'pakaian-tekstil', 'Fesyen', '3.jpeg', 1, '2025-03-30 19:23:47', '2025-09-16 06:26:16'),
(4, 'okedeh', 'CAT004', 'elektronik-aksesoris', 'Musik', '4.jpeg', 1, '2025-03-30 19:23:47', '2025-09-16 06:26:27'),
(5, 'okedeh', 'CAT005', 'kosmetik-kesehatan', 'Film', '5.jpeg', 1, '2025-03-30 19:23:47', '2025-09-16 06:26:38'),
(6, 'okedeh', 'CAT006', 'seni-pertunjukan', 'Seni Pertunjukan', '6.jpeg', 1, '2025-09-16 06:27:01', '2025-09-16 06:27:01'),
(7, 'okedeh', 'CAT007', 'seni-rupa', 'Seni Rupa', '7.jpeg', 1, '2025-09-16 06:27:20', '2025-09-16 06:27:20'),
(8, 'okedeh', 'CAT008', 'fotografi', 'Fotografi', '8.jpeg', 1, '2025-09-16 06:27:45', '2025-09-16 06:27:45'),
(9, 'okedeh', 'CAT009', NULL, 'CAT009', '9.png', 1, '2025-12-13 08:22:26', '2025-12-13 08:22:26'),
(10, 'okedeh', 'CAT010', NULL, 'CAT010', '10.jpeg', 1, '2025-12-13 08:24:31', '2025-12-13 08:24:31'),
(11, 'okedeh', 'CAT011', NULL, 'CAT011', '11.jpeg', 1, '2025-12-13 08:25:17', '2025-12-13 08:25:17'),
(12, 'okedeh', 'CAT012', NULL, 'CAT012', '12.jpeg', 1, '2025-12-13 08:25:46', '2025-12-13 08:25:46'),
(13, 'okedeh', 'CAT013', NULL, 'CAT013', '13.jpg', 1, '2025-12-13 08:26:23', '2025-12-13 08:26:23'),
(14, 'okedeh', 'CAT014', NULL, 'CAT014', '14.PNG', 1, '2025-12-13 08:27:11', '2025-12-13 08:27:11'),
(15, 'okedeh', 'CAT015', NULL, 'CAT015', '15.jpg', 1, '2025-12-13 08:28:05', '2025-12-13 08:28:05'),
(16, 'okedeh', 'CAT016', NULL, 'CAT016', '16.jpg', 1, '2025-12-13 08:28:29', '2025-12-13 08:28:29'),
(17, 'okedeh', 'CAT017', NULL, 'CAT017', '17.jpg', 1, '2025-12-13 08:29:52', '2025-12-13 08:29:52'),
(18, 'okedeh', 'CAT018', NULL, 'CAT018', '18.jpg', 1, '2025-12-13 08:30:19', '2025-12-13 08:30:19'),
(19, 'okedeh', 'CAT019', NULL, 'CAT019', '19.jpg', 1, '2025-12-13 08:30:49', '2025-12-13 08:30:49'),
(20, 'okedeh', 'CAT020', NULL, 'CAT020', '20.jpeg', 1, '2025-12-13 08:31:24', '2025-12-13 08:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `setting_category_logs`
--

DROP TABLE IF EXISTS `setting_category_logs`;
CREATE TABLE IF NOT EXISTS `setting_category_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `activity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `setting_category_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_category_logs_setting_category_id_user_id_index` (`setting_category_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_category_logs`
--

INSERT INTO `setting_category_logs` (`id`, `user_id`, `activity`, `note`, `setting_category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:41', '2025-03-31 00:13:41'),
(2, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:49', '2025-03-31 00:13:49'),
(3, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:49', '2025-03-31 00:13:49'),
(4, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:49', '2025-03-31 00:13:49'),
(5, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:54', '2025-03-31 00:13:54'),
(6, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:54', '2025-03-31 00:13:54'),
(7, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:54', '2025-03-31 00:13:54'),
(8, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:57', '2025-03-31 00:13:57'),
(9, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:57', '2025-03-31 00:13:57'),
(10, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Makanan & Minuman\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:13:41.000000Z\"}', 1, '2025-03-31 00:13:58', '2025-03-31 00:13:58'),
(11, 1, 'Update', '{\"id\":5,\"code\":\"CAT005\",\"slug\":\"kosmetik-kesehatan\",\"name\":\"Kosmetik & Kesehatan\",\"image\":\"5.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:16:07.000000Z\"}', 5, '2025-03-31 00:16:07', '2025-03-31 00:16:07'),
(12, 1, 'Update', '{\"id\":5,\"code\":\"CAT005\",\"slug\":\"kosmetik-kesehatan\",\"name\":\"Kosmetik & Kesehatan\",\"image\":\"5.png\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-03-31T00:19:10.000000Z\"}', 5, '2025-03-31 00:19:10', '2025-03-31 00:19:10'),
(13, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Kuliner\",\"image\":\"1.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:23:27.000000Z\"}', 1, '2025-09-16 06:23:27', '2025-09-16 06:23:27'),
(14, 1, 'Update', '{\"id\":2,\"code\":\"CAT002\",\"slug\":\"kerajinan-tangan\",\"name\":\"Kriya\",\"image\":\"2.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:24:25.000000Z\"}', 2, '2025-09-16 06:24:25', '2025-09-16 06:24:25'),
(15, 1, 'Update', '{\"id\":2,\"code\":\"CAT002\",\"slug\":\"kerajinan-tangan\",\"name\":\"Kriya\",\"image\":\"2.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:24:25.000000Z\"}', 2, '2025-09-16 06:24:25', '2025-09-16 06:24:25'),
(16, 1, 'Update', '{\"id\":3,\"code\":\"CAT003\",\"slug\":\"pakaian-tekstil\",\"name\":\"Fesyen\",\"image\":\"3.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:26:16.000000Z\"}', 3, '2025-09-16 06:26:16', '2025-09-16 06:26:16'),
(17, 1, 'Update', '{\"id\":4,\"code\":\"CAT004\",\"slug\":\"elektronik-aksesoris\",\"name\":\"Musik\",\"image\":\"4.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:26:27.000000Z\"}', 4, '2025-09-16 06:26:28', '2025-09-16 06:26:28'),
(18, 1, 'Update', '{\"id\":5,\"code\":\"CAT005\",\"slug\":\"kosmetik-kesehatan\",\"name\":\"Film\",\"image\":\"5.jpeg\",\"status\":\"1\",\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:26:38.000000Z\"}', 5, '2025-09-16 06:26:38', '2025-09-16 06:26:38'),
(19, 1, 'Create', '{\"code\":\"CAT006\",\"name\":\"Seni Pertunjukan\",\"image\":\"6.jpeg\",\"updated_at\":\"2025-09-16T06:27:01.000000Z\",\"created_at\":\"2025-09-16T06:27:01.000000Z\",\"id\":6}', 6, '2025-09-16 06:27:01', '2025-09-16 06:27:01'),
(20, 1, 'Create', '{\"code\":\"CAT007\",\"name\":\"Seni Rupa\",\"image\":\"7.jpeg\",\"updated_at\":\"2025-09-16T06:27:20.000000Z\",\"created_at\":\"2025-09-16T06:27:20.000000Z\",\"id\":7}', 7, '2025-09-16 06:27:20', '2025-09-16 06:27:20'),
(21, 1, 'Create', '{\"code\":\"CAT008\",\"name\":\"Fotografi\",\"image\":\"8.jpeg\",\"updated_at\":\"2025-09-16T06:27:45.000000Z\",\"created_at\":\"2025-09-16T06:27:45.000000Z\",\"id\":8}', 8, '2025-09-16 06:27:45', '2025-09-16 06:27:45'),
(22, 1, 'Update', '{\"id\":7,\"code\":\"CAT007\",\"slug\":null,\"name\":\"Seni Rupa\",\"image\":\"7.jpeg\",\"status\":\"1\",\"created_at\":\"2025-09-16T06:27:20.000000Z\",\"updated_at\":\"2025-09-16T06:27:20.000000Z\"}', 7, '2025-11-04 06:33:00', '2025-11-04 06:33:00'),
(23, 1, 'Update', '{\"id\":1,\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Kuliner\",\"image\":\"1.jpeg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-09-16T06:23:27.000000Z\"}', 1, '2025-12-13 08:20:52', '2025-12-13 08:20:52'),
(24, 1, 'Create', '{\"code\":\"CAT009\",\"name\":\"CAT009\",\"image\":\"9.png\",\"updated_at\":\"2025-12-13T08:22:26.000000Z\",\"created_at\":\"2025-12-13T08:22:26.000000Z\",\"id\":9}', 9, '2025-12-13 08:22:26', '2025-12-13 08:22:26'),
(25, 1, 'Create', '{\"code\":\"CAT010\",\"name\":\"CAT010\",\"image\":\"10.jpeg\",\"updated_at\":\"2025-12-13T08:24:31.000000Z\",\"created_at\":\"2025-12-13T08:24:31.000000Z\",\"id\":10}', 10, '2025-12-13 08:24:31', '2025-12-13 08:24:31'),
(26, 1, 'Create', '{\"code\":\"CAT011\",\"name\":\"CAT011\",\"image\":\"11.jpeg\",\"updated_at\":\"2025-12-13T08:25:17.000000Z\",\"created_at\":\"2025-12-13T08:25:17.000000Z\",\"id\":11}', 11, '2025-12-13 08:25:17', '2025-12-13 08:25:17'),
(27, 1, 'Create', '{\"code\":\"CAT012\",\"name\":\"CAT012\",\"image\":\"12.jpeg\",\"updated_at\":\"2025-12-13T08:25:46.000000Z\",\"created_at\":\"2025-12-13T08:25:46.000000Z\",\"id\":12}', 12, '2025-12-13 08:25:47', '2025-12-13 08:25:47'),
(28, 1, 'Create', '{\"code\":\"CAT013\",\"name\":\"CAT013\",\"image\":\"13.jpg\",\"updated_at\":\"2025-12-13T08:26:23.000000Z\",\"created_at\":\"2025-12-13T08:26:23.000000Z\",\"id\":13}', 13, '2025-12-13 08:26:23', '2025-12-13 08:26:23'),
(29, 1, 'Create', '{\"code\":\"CAT014\",\"name\":\"CAT014\",\"image\":\"14.PNG\",\"updated_at\":\"2025-12-13T08:27:11.000000Z\",\"created_at\":\"2025-12-13T08:27:11.000000Z\",\"id\":14}', 14, '2025-12-13 08:27:11', '2025-12-13 08:27:11'),
(30, 1, 'Create', '{\"code\":\"CAT015\",\"name\":\"CAT015\",\"image\":\"15.jpg\",\"updated_at\":\"2025-12-13T08:28:05.000000Z\",\"created_at\":\"2025-12-13T08:28:05.000000Z\",\"id\":15}', 15, '2025-12-13 08:28:05', '2025-12-13 08:28:05'),
(31, 1, 'Create', '{\"code\":\"CAT016\",\"name\":\"CAT016\",\"image\":\"16.jpg\",\"updated_at\":\"2025-12-13T08:28:29.000000Z\",\"created_at\":\"2025-12-13T08:28:29.000000Z\",\"id\":16}', 16, '2025-12-13 08:28:29', '2025-12-13 08:28:29'),
(32, 1, 'Create', '{\"code\":\"CAT017\",\"name\":\"CAT017\",\"image\":\"17.jpg\",\"updated_at\":\"2025-12-13T08:29:52.000000Z\",\"created_at\":\"2025-12-13T08:29:52.000000Z\",\"id\":17}', 17, '2025-12-13 08:29:52', '2025-12-13 08:29:52'),
(33, 1, 'Create', '{\"code\":\"CAT018\",\"name\":\"CAT018\",\"image\":\"18.jpg\",\"updated_at\":\"2025-12-13T08:30:19.000000Z\",\"created_at\":\"2025-12-13T08:30:19.000000Z\",\"id\":18}', 18, '2025-12-13 08:30:19', '2025-12-13 08:30:19'),
(34, 1, 'Create', '{\"code\":\"CAT019\",\"name\":\"CAT019\",\"image\":\"19.jpg\",\"updated_at\":\"2025-12-13T08:30:49.000000Z\",\"created_at\":\"2025-12-13T08:30:49.000000Z\",\"id\":19}', 19, '2025-12-13 08:30:49', '2025-12-13 08:30:49'),
(35, 1, 'Create', '{\"code\":\"CAT020\",\"name\":\"CAT020\",\"image\":\"20.jpeg\",\"updated_at\":\"2025-12-13T08:31:24.000000Z\",\"created_at\":\"2025-12-13T08:31:24.000000Z\",\"id\":20}', 20, '2025-12-13 08:31:24', '2025-12-13 08:31:24'),
(36, 1, 'Update', '{\"id\":1,\"label\":\"okedeh\",\"code\":\"CAT001\",\"slug\":\"makanan-minuman\",\"name\":\"Kulinerz\",\"image\":\"1.jpg\",\"status\":1,\"created_at\":\"2025-03-30T19:23:47.000000Z\",\"updated_at\":\"2025-12-30T07:36:41.000000Z\"}', 1, '2025-12-30 07:36:41', '2025-12-30 07:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `setting_contact_admins`
--

DROP TABLE IF EXISTS `setting_contact_admins`;
CREATE TABLE IF NOT EXISTS `setting_contact_admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_contact_admins`
--

INSERT INTO `setting_contact_admins` (`id`, `key`, `name`, `contact`, `created_at`, `updated_at`) VALUES
(1, 'admin_contact', 'Admin', '81392460980', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_costs`
--

DROP TABLE IF EXISTS `setting_costs`;
CREATE TABLE IF NOT EXISTS `setting_costs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `min_price` int NOT NULL,
  `max_price` int NOT NULL,
  `cost_value` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_costs`
--

INSERT INTO `setting_costs` (`id`, `min_price`, `max_price`, `cost_value`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 99999999, 250, NULL, 0, '2025-04-29 17:39:43', '2025-12-30 08:15:22');

-- --------------------------------------------------------

--
-- Table structure for table `setting_information_bars`
--

DROP TABLE IF EXISTS `setting_information_bars`;
CREATE TABLE IF NOT EXISTS `setting_information_bars` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_information_bars`
--

INSERT INTO `setting_information_bars` (`id`, `text`, `created_at`, `updated_at`) VALUES
(1, 'This is an information bar.', '2025-03-30 19:23:47', '2025-03-30 19:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `setting_sub_categories`
--

DROP TABLE IF EXISTS `setting_sub_categories`;
CREATE TABLE IF NOT EXISTS `setting_sub_categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `setting_category_id` bigint NOT NULL,
  `code` varchar(15) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setting_sub_categories`
--

INSERT INTO `setting_sub_categories` (`id`, `setting_category_id`, `code`, `slug`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUB A', NULL, 'INI SUB A', '18.jpg', 1, NULL, NULL),
(3, 3, 'subfesyen1', NULL, 'sub fesyen 1 edit', '3.png', 1, '2026-01-01 08:27:50', '2026-01-01 09:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `setting_types`
--

DROP TABLE IF EXISTS `setting_types`;
CREATE TABLE IF NOT EXISTS `setting_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setting_types`
--

INSERT INTO `setting_types` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fisik', '', 1, '2025-12-16 21:46:29', NULL),
(2, 'Jasa', '', 1, '2025-12-16 21:46:36', NULL),
(3, 'Digital', '', 1, '2025-12-16 21:46:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_units`
--

DROP TABLE IF EXISTS `setting_units`;
CREATE TABLE IF NOT EXISTS `setting_units` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_units_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_units`
--

INSERT INTO `setting_units` (`id`, `code`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'UNIT001', 'Pcs', 1, '2025-03-30 19:23:47', '2025-03-30 19:23:47'),
(2, 'UNIT002', 'Kg', 1, '2025-03-30 19:23:47', '2025-03-30 19:23:47'),
(3, 'UNIT003', 'Liter', 1, '2025-03-30 19:23:47', '2025-03-30 19:23:47'),
(4, 'UNIT004', 'Pack', 1, '2025-03-30 19:23:47', '2025-03-30 19:23:47'),
(5, 'UNIT005', 'Dus', 1, '2025-03-30 19:23:47', '2025-03-30 19:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `setting_unit_logs`
--

DROP TABLE IF EXISTS `setting_unit_logs`;
CREATE TABLE IF NOT EXISTS `setting_unit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `activity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `setting_unit_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_unit_logs_setting_unit_id_user_id_index` (`setting_unit_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` bigint DEFAULT NULL,
  `customer_id` bigint NOT NULL,
  `customer_address_id` bigint NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` bigint NOT NULL DEFAULT '0',
  `other_cost` bigint NOT NULL DEFAULT '0',
  `total` bigint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_channel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_information` text COLLATE utf8mb4_unicode_ci,
  `shipping_cost` double NOT NULL DEFAULT '0',
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_etd` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `can_review_until_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voucher_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `seller_id`, `customer_id`, `customer_address_id`, `code`, `subtotal`, `other_cost`, `total`, `status`, `payment_method`, `payment_channel`, `snap_token`, `shipping_number`, `shipping_information`, `shipping_cost`, `shipping_name`, `shipping_description`, `shipping_etd`, `shipping_attachment`, `shipping_status`, `note`, `can_review_until_at`, `created_at`, `updated_at`, `voucher_id`) VALUES
(1, 21, 1, 1, 'CO202503310243001931', 1000, 50, 1070, 3, NULL, NULL, '56eaaa16-279a-4dda-a7b6-eb5b0d77a00a', NULL, NULL, 150000, 'JNE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 19:43:35', '2025-03-31 00:20:50', NULL),
(2, 21, 1, 1, 'CO202503310303008862', 1000, 100, 1150, 4, 'qris', NULL, 'a81e9d57-0a6f-405a-89cb-c59e762b19ab', NULL, NULL, 50, 'JNE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 20:03:15', '2025-03-30 20:08:27', NULL),
(3, 21, 1, 1, 'CO202504021756007303', 1000, 100, 1200, 7, 'qris', NULL, 'c1b38428-3630-4a6b-9f9b-96aa4f09abc5', 'R00001', NULL, 100, 'JNE', NULL, NULL, '1743591794.jpg', 'Received', NULL, NULL, '2025-04-02 10:56:44', '2025-04-02 11:10:34', NULL),
(4, 22, 3, 2, 'CO202504031601002914', 10000, 2, 10004, 7, 'qris', NULL, '9dc8acc7-978a-4c25-b7bc-b0f384204bbd', '1314', NULL, 2, 'jnt', NULL, NULL, '1743671550.png', 'Received', NULL, NULL, '2025-04-03 09:01:03', '2025-04-03 09:17:08', NULL),
(5, 24, 10, 5, 'CO202511041906008475', 350250, 0, 450250, 9, 'qris', NULL, 'cf584cfe-d332-447e-8e11-21616276d9d6', NULL, NULL, 100000, 'JNT', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-04 12:06:54', '2025-11-04 12:29:02', NULL),
(6, 24, 6, 6, 'CO202512050140006956', 350250, 0, 360250, 3, NULL, NULL, NULL, NULL, NULL, 10000, 'testing', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-04 18:40:47', '2025-12-09 11:44:45', NULL),
(7, 1, 10, 5, 'CO202512091837000867', 476742, 0, 476742, 8, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 11:37:38', '2025-12-09 11:38:41', NULL),
(10, 1, 10, 5, 'CO202512091838009418', 238371, 0, 238371, 8, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 11:38:31', '2025-12-09 11:38:44', NULL),
(11, 1, 10, 5, 'CO2025120918390022811', 238371, 0, 238371, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 11:39:06', '2025-12-09 11:39:06', NULL),
(12, 1, 11, 7, 'CO2025120918580098112', 715113, 0, 715113, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 11:58:46', '2025-12-09 11:58:46', NULL),
(13, 24, 11, 7, 'CO2025120919010050213', 350250, 0, 360250, 3, NULL, NULL, '2f2194a0-9f2f-43aa-bc0c-2f388b957451', NULL, NULL, 10000, 'testing', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 12:01:14', '2025-12-09 12:05:01', NULL),
(14, 1, 11, 7, 'CO2025120919110047114', 238371, 0, 238371, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 12:11:10', '2025-12-09 12:11:10', NULL),
(15, 24, 10, 5, 'CO2025121713470032515', 150250, 0, 160250, 3, NULL, NULL, NULL, NULL, NULL, 10000, 'testing', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-17 06:47:22', '2025-12-17 07:41:11', NULL),
(16, 24, 10, 5, 'CO2025121714490016116', 150250, 0, 170250, 4, 'qris', NULL, NULL, NULL, NULL, 20000, 'testingship', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-17 07:49:05', '2025-12-17 07:57:42', NULL),
(17, 24, 10, 5, 'CO2025122014210057117', 100250, 0, 110250, 3, NULL, NULL, NULL, NULL, NULL, 10000, 'coba kurir', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 07:21:42', '2025-12-20 07:26:00', NULL),
(18, 24, 10, 5, 'CO2025122014310028018', 100250, 0, 100250, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 07:31:14', '2025-12-20 07:31:14', NULL),
(19, 24, 10, 5, 'CO2025122014330084919', 100250, 0, 100250, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 07:33:29', '2025-12-20 07:33:29', NULL),
(20, 24, 10, 5, 'CO2025122014430048720', 100250, 0, 100250, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 07:43:17', '2025-12-20 07:43:17', NULL),
(21, 24, 10, 5, 'CO2025122014510023121', 450500, 0, 450500, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 07:51:33', '2025-12-20 07:51:33', NULL),
(22, 24, 10, 5, 'CO2025122015160042422', 100250, 0, 100250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 08:16:44', '2025-12-20 08:16:44', NULL),
(23, 24, 10, 5, 'CO2025122015180076823', 450500, 0, 450500, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 08:18:18', '2025-12-20 08:18:18', NULL),
(24, 24, 10, 5, 'CO2025122015230068824', 450500, 0, 450500, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 08:23:38', '2025-12-20 08:23:38', NULL),
(25, 24, 10, 5, 'CO2025122015240017125', 200500, 0, 200500, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-20 08:24:56', '2025-12-20 08:24:56', NULL),
(26, 24, 10, 5, 'CO2025122117000072926', 100250, 0, 100250, 4, 'qris', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-21 10:00:37', '2025-12-21 10:00:37', NULL),
(27, 24, 10, 5, 'CO2025122117330064227', 100250, 0, 100250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-21 10:33:30', '2025-12-21 10:33:30', NULL),
(28, 24, 10, 5, 'CO2025122118280014328', 350250, 0, 350250, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-21 11:28:18', '2025-12-21 11:28:18', NULL),
(29, 24, 10, 5, 'CO2025122717100095129', 120250, 0, 120250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 10:10:26', '2025-12-27 10:10:26', NULL),
(30, 24, 10, 5, 'CO2025122717310056530', 350250, 0, 350250, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 10:31:08', '2025-12-27 10:31:08', NULL),
(31, 24, 10, 5, 'CO2025122717320038531', 120250, 0, 120250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 10:32:13', '2025-12-27 10:32:13', NULL),
(32, 24, 10, 5, 'CO2025122717420064432', 350250, 0, 350250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 10:42:36', '2025-12-27 10:42:36', NULL),
(33, 24, 10, 5, 'CO2025122717480087233', 350250, 0, 350250, 4, 'qris', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 10:48:01', '2025-12-27 10:48:01', NULL),
(34, 24, 10, 10, 'CO2026010423310080334', 120000, 0, 120000, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-04 16:31:36', '2026-01-04 16:31:36', NULL),
(35, 24, 10, 10, 'CO2026010514070050535', 1751250, 0, 1751250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 07:07:25', '2026-01-05 07:07:25', NULL),
(38, 24, 10, 10, 'CO2026010515380078136', 0, 0, 396250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 08:38:24', '2026-01-05 08:38:24', NULL),
(39, 24, 10, 10, 'CO2026010515410097839', 0, 0, 413250, 3, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 08:41:35', '2026-01-05 08:41:35', NULL),
(40, 24, 10, 10, 'CO2026010515450049740', 350250, 0, 410250, 3, NULL, NULL, NULL, NULL, NULL, 60000, 'Satria Antaran Prima', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 08:45:25', '2026-01-05 08:45:25', NULL),
(41, 24, 10, 10, 'CO2026010515540080841', 350250, 0, 410250, 3, NULL, NULL, NULL, NULL, NULL, 60000, 'Satria Antaran Prima', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 08:54:20', '2026-01-05 08:54:20', NULL),
(42, 24, 10, 10, 'CO2026010515560039242', 350250, 0, 396250, 3, NULL, NULL, NULL, NULL, '{\"name\":\"Satria Antaran Prima\",\"code\":\"sap\",\"service\":\"UDRONS\",\"description\":\"Nextday\",\"cost\":46000,\"etd\":\"1-2 day\"}', 46000, 'Satria Antaran Prima', 'Nextday', '1-2 day', NULL, NULL, NULL, NULL, '2026-01-05 08:56:02', '2026-01-05 08:56:02', NULL),
(43, 24, 10, 10, 'CO2026010515580014843', 450500, 0, 510500, 4, 'qris', NULL, NULL, NULL, '{\"name\":\"Satria Antaran Prima\",\"code\":\"sap\",\"service\":\"DRGREG\",\"description\":\"Cargo\",\"cost\":60000,\"etd\":\"9-12 day\"}', 60000, 'Satria Antaran Prima', 'Cargo', '9-12 day', NULL, NULL, NULL, NULL, '2026-01-05 08:58:48', '2026-01-05 08:58:48', NULL),
(44, 24, 10, 11, 'CO2026011017120097244', 350250, 0, 440250, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-10 10:12:16', '2026-01-10 10:12:16', NULL),
(45, 24, 10, 11, 'CO2026011022180056445', 100000, 0, 100000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-10 15:18:16', '2026-01-10 15:18:16', NULL),
(46, 24, 10, 11, 'CO2026011514590026046', 1831250, 0, 1831250, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 07:59:13', '2026-01-15 07:59:13', NULL),
(47, 24, 10, 11, 'CO2026011515340017347', 40000, 0, 40000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:34:59', '2026-01-15 08:34:59', NULL),
(48, 24, 10, 11, 'CO2026011515350079248', 700500, 0, 700500, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:35:56', '2026-01-15 08:35:56', NULL),
(49, 24, 10, 11, 'CO2026011515410060949', 350250, 0, 350250, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:41:59', '2026-01-15 08:41:59', NULL),
(50, 24, 10, 11, 'CO2026011515430039050', 350250, 0, 350250, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:43:06', '2026-01-15 08:43:06', NULL),
(51, 24, 10, 11, 'CO2026011515460057851', 350250, 0, 350250, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:46:44', '2026-01-15 08:46:44', NULL),
(52, 24, 10, 11, 'CO2026011515520066552', 350250, 0, 350250, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 08:52:43', '2026-01-15 08:52:43', NULL),
(53, 24, 10, 11, 'CO2026011516070099553', 350250, 0, 440250, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-15 09:07:33', '2026-01-15 09:07:33', NULL),
(54, 24, 10, 11, 'CO2026011516280091754', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:28:24', '2026-01-15 09:28:24', NULL),
(55, 24, 10, 11, 'CO2026011516360096755', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:36:56', '2026-01-15 09:36:56', NULL),
(56, 24, 10, 11, 'CO2026011516370098956', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:37:49', '2026-01-15 09:37:49', NULL),
(57, 24, 10, 11, 'CO2026011516410046857', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:41:21', '2026-01-15 09:41:21', NULL),
(58, 24, 10, 11, 'CO2026011516430007258', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:43:11', '2026-01-15 09:43:11', NULL),
(59, 24, 10, 11, 'CO2026011516450070359', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:45:25', '2026-01-15 09:45:25', NULL),
(60, 24, 10, 11, 'CO2026011516530008460', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:53:49', '2026-01-15 09:53:49', NULL),
(61, 24, 10, 11, 'CO2026011516580070361', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 09:58:40', '2026-01-15 09:58:40', NULL),
(62, 24, 10, 11, 'CO2026011517000063362', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 10:00:15', '2026-01-15 10:00:15', NULL),
(63, 24, 10, 11, 'CO2026011517020077463', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 10:02:26', '2026-01-15 10:02:26', NULL),
(64, 24, 10, 11, 'CO2026011517030087964', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 10:03:06', '2026-01-15 10:03:06', NULL),
(65, 24, 10, 11, 'CO2026011517040094865', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 10:04:31', '2026-01-15 10:04:31', NULL),
(66, 24, 10, 11, 'CO2026011517070089366', 0, 0, 0, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-15 10:07:18', '2026-01-15 10:07:18', NULL),
(67, 24, 10, 11, 'CO2026011520160037167', 23166500, 0, 23256500, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-15 13:16:15', '2026-01-15 13:16:15', NULL),
(68, 24, 10, 11, 'CO2026011520350082368', 700500, 0, 790500, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-15 13:35:41', '2026-01-15 13:35:41', NULL),
(69, 24, 10, 11, 'CO2026011520430016569', 800500, 0, 890500, 4, 'qris', NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-15 13:43:36', '2026-01-15 13:43:36', NULL),
(70, 24, 10, 11, 'CO2026011623350000570', 105000, 0, 105000, 4, 'qris', NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-16 16:35:39', '2026-01-16 16:35:39', NULL),
(71, 24, 10, 11, 'CO2026011700050060671', 125000, 0, 125000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-16 17:05:44', '2026-01-16 17:05:44', NULL),
(75, 24, 10, 11, 'CO2026011700270014272', 125000, 0, 125000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-16 17:27:43', '2026-01-16 17:27:43', NULL),
(76, 24, 10, 11, 'CO2026011700510025376', 155000, 0, 155000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-16 17:51:13', '2026-01-16 17:51:13', NULL),
(81, 24, 10, 11, 'CO2026011712170047177', 105000, 0, 105000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-17 05:17:01', '2026-01-17 05:17:01', NULL),
(82, 24, 10, 11, 'CO2026011718380035582', 880500, 0, 970500, 4, 'qris', NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19', NULL),
(83, 24, 10, 11, 'CO2026011718430009683', 160000, 0, 160000, 4, 'qris', NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-17 11:43:59', '2026-01-17 11:43:59', NULL),
(84, 24, 10, 11, 'CO2026011718460072984', 700500, 0, 790500, 4, 'qris', NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-17 11:46:55', '2026-01-17 11:46:55', NULL),
(85, 24, 10, 11, 'CO2026011718480024485', 70000, 0, 70000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-17 11:48:23', '2026-01-17 11:48:23', NULL),
(86, 24, 10, 11, 'CO2026011718490013586', 700500, 0, 790500, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-17 11:49:03', '2026-01-17 11:49:03', NULL),
(87, 24, 10, 11, 'CO2026011718530018587', 700500, 0, 790500, 4, 'qris', NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-17 11:53:25', '2026-01-17 11:53:25', NULL),
(88, 24, 10, 11, 'CO2026011718550026188', 70000, 0, 70000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-17 11:55:09', '2026-01-17 11:55:09', NULL),
(89, 24, 10, 11, 'CO2026011718560088989', 350250, 0, 440250, 3, NULL, NULL, NULL, NULL, '{\"name\":\"J&T Express\",\"code\":\"jnt\",\"service\":\"EZ\",\"description\":\"Reguler\",\"cost\":90000,\"etd\":\"\"}', 90000, 'J&T Express', 'Reguler', '', NULL, NULL, NULL, NULL, '2026-01-17 11:56:23', '2026-01-17 11:56:23', NULL),
(90, 24, 10, 11, 'CO2026011718570060290', 50000, 0, 50000, 3, NULL, NULL, NULL, NULL, '', 0, '', '', '', NULL, NULL, NULL, NULL, '2026-01-17 11:57:33', '2026-01-17 11:57:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

DROP TABLE IF EXISTS `transaction_logs`;
CREATE TABLE IF NOT EXISTS `transaction_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `activity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_logs_transaction_id_foreign` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `user_id`, `transaction_id`, `activity`, `note`, `created_at`, `updated_at`) VALUES
(1, 23, 1, 'create', 'order has been created', '2025-03-30 19:43:35', '2025-03-30 19:43:35'),
(2, 22, 1, 'Add Other Cost', '{\"transaction_id\":\"1\",\"name\":\"Other\",\"amount\":50,\"updated_at\":\"2025-03-30T19:45:00.000000Z\",\"created_at\":\"2025-03-30T19:45:00.000000Z\",\"id\":1}', '2025-03-30 19:45:00', '2025-03-30 19:45:00'),
(3, 22, 1, 'Confirm', 'Confirmed by seller', '2025-03-30 19:45:15', '2025-03-30 19:45:15'),
(4, 1, 1, 'Confirm', 'Confirmed by admin', '2025-03-30 19:47:17', '2025-03-30 19:47:17'),
(5, 23, 2, 'create', 'order has been created', '2025-03-30 20:03:15', '2025-03-30 20:03:15'),
(6, 22, 2, 'Add Other Cost', '{\"transaction_id\":\"2\",\"name\":\"Admin\",\"amount\":100,\"updated_at\":\"2025-03-30T20:04:31.000000Z\",\"created_at\":\"2025-03-30T20:04:31.000000Z\",\"id\":2}', '2025-03-30 20:04:31', '2025-03-30 20:04:31'),
(7, 22, 2, 'Confirm', 'Confirmed by seller', '2025-03-30 20:04:40', '2025-03-30 20:04:40'),
(8, 1, 2, 'Confirm', 'Confirmed by admin', '2025-03-30 20:05:10', '2025-03-30 20:05:10'),
(9, 23, 2, 'handle_notification', 'this transaction ispending', '2025-03-30 20:08:09', '2025-03-30 20:08:09'),
(10, 23, 2, 'handle_notification', 'this transaction issettlement', '2025-03-30 20:08:27', '2025-03-30 20:08:27'),
(11, 23, 3, 'create', 'order has been created', '2025-04-02 10:56:44', '2025-04-02 10:56:44'),
(12, 22, 3, 'Add Other Cost', '{\"transaction_id\":\"3\",\"name\":\"Admin\",\"amount\":100,\"updated_at\":\"2025-04-02T10:57:54.000000Z\",\"created_at\":\"2025-04-02T10:57:54.000000Z\",\"id\":3}', '2025-04-02 10:57:54', '2025-04-02 10:57:54'),
(13, 22, 3, 'Confirm', 'Confirmed by seller', '2025-04-02 10:58:16', '2025-04-02 10:58:16'),
(14, 1, 3, 'Confirm', 'Confirmed by admin', '2025-04-02 10:59:23', '2025-04-02 10:59:23'),
(15, 23, 3, 'handle_notification', 'this transaction ispending', '2025-04-02 11:00:22', '2025-04-02 11:00:22'),
(16, 23, 3, 'handle_notification', 'this transaction issettlement', '2025-04-02 11:00:50', '2025-04-02 11:00:50'),
(17, 22, 3, 'Packing', 'Packing by seller', '2025-04-02 11:02:28', '2025-04-02 11:02:28'),
(18, 22, 3, 'Delivery', 'Delivery by seller with shipping number R00001', '2025-04-02 11:03:14', '2025-04-02 11:03:14'),
(19, 23, 3, 'received', 'order has been received', '2025-04-02 11:10:34', '2025-04-02 11:10:34'),
(20, 26, 4, 'create', 'order has been created', '2025-04-03 09:01:03', '2025-04-03 09:01:03'),
(21, 25, 4, 'Add Other Cost', '{\"transaction_id\":\"4\",\"name\":\"ongkir\",\"amount\":10,\"updated_at\":\"2025-04-03T09:02:02.000000Z\",\"created_at\":\"2025-04-03T09:02:02.000000Z\",\"id\":4}', '2025-04-03 09:02:02', '2025-04-03 09:02:02'),
(22, 25, 4, 'Add Other Cost', '{\"transaction_id\":\"4\",\"name\":\"packing\",\"amount\":1,\"updated_at\":\"2025-04-03T09:02:57.000000Z\",\"created_at\":\"2025-04-03T09:02:57.000000Z\",\"id\":5}', '2025-04-03 09:02:57', '2025-04-03 09:02:57'),
(23, 25, 4, 'Confirm', 'Confirmed by seller', '2025-04-03 09:03:12', '2025-04-03 09:03:12'),
(24, 1, 4, 'Add Other Cost', '{\"transaction_id\":\"4\",\"name\":\"packing kayu\",\"amount\":1,\"updated_at\":\"2025-04-03T09:04:42.000000Z\",\"created_at\":\"2025-04-03T09:04:42.000000Z\",\"id\":6}', '2025-04-03 09:04:42', '2025-04-03 09:04:42'),
(25, 1, 4, 'Add Other Cost', '{\"transaction_id\":\"4\",\"name\":\"bubble\",\"amount\":1,\"updated_at\":\"2025-04-03T09:04:56.000000Z\",\"created_at\":\"2025-04-03T09:04:56.000000Z\",\"id\":7}', '2025-04-03 09:04:56', '2025-04-03 09:04:56'),
(26, 1, 4, 'Confirm', 'Confirmed by admin', '2025-04-03 09:05:08', '2025-04-03 09:05:08'),
(27, 26, 4, 'handle_notification', 'this transaction ispending', '2025-04-03 09:06:04', '2025-04-03 09:06:04'),
(28, 26, 4, 'handle_notification', 'this transaction issettlement', '2025-04-03 09:07:15', '2025-04-03 09:07:15'),
(29, 25, 4, 'Packing', 'Packing by seller', '2025-04-03 09:09:57', '2025-04-03 09:09:57'),
(30, 25, 4, 'Delivery', 'Delivery by seller with shipping number 1314', '2025-04-03 09:12:30', '2025-04-03 09:12:30'),
(31, 26, 4, 'received', 'order has been received', '2025-04-03 09:17:08', '2025-04-03 09:17:08'),
(32, 35, 5, 'create', 'order has been created', '2025-11-04 12:06:54', '2025-11-04 12:06:54'),
(33, 34, 5, 'Confirm', 'Confirmed by seller', '2025-11-04 12:09:44', '2025-11-04 12:09:44'),
(34, 1, 5, 'Confirm', 'Confirmed by admin', '2025-11-04 12:11:24', '2025-11-04 12:11:24'),
(35, 35, 5, 'handle_notification', 'this transaction ispending', '2025-11-04 12:13:00', '2025-11-04 12:13:00'),
(36, 35, 5, 'handle_notification', 'this transaction isexpire', '2025-11-04 12:29:02', '2025-11-04 12:29:02'),
(37, 29, 6, 'create', 'order has been created', '2025-12-04 18:40:47', '2025-12-04 18:40:47'),
(38, 35, 7, 'create', 'order has been created', '2025-12-09 11:37:38', '2025-12-09 11:37:38'),
(39, 35, 10, 'create', 'order has been created', '2025-12-09 11:38:31', '2025-12-09 11:38:31'),
(40, 35, 7, 'cancel', 'order has been canceled', '2025-12-09 11:38:41', '2025-12-09 11:38:41'),
(41, 35, 10, 'cancel', 'order has been canceled', '2025-12-09 11:38:44', '2025-12-09 11:38:44'),
(42, 35, 11, 'create', 'order has been created', '2025-12-09 11:39:06', '2025-12-09 11:39:06'),
(43, 34, 6, 'Confirm', 'Confirmed by seller', '2025-12-09 11:44:14', '2025-12-09 11:44:14'),
(44, 1, 6, 'Confirm', 'Confirmed by admin', '2025-12-09 11:44:45', '2025-12-09 11:44:45'),
(45, 38, 12, 'create', 'order has been created', '2025-12-09 11:58:46', '2025-12-09 11:58:46'),
(46, 38, 13, 'create', 'order has been created', '2025-12-09 12:01:14', '2025-12-09 12:01:14'),
(47, 34, 13, 'Confirm', 'Confirmed by seller', '2025-12-09 12:01:39', '2025-12-09 12:01:39'),
(48, 1, 13, 'Confirm', 'Confirmed by admin', '2025-12-09 12:04:44', '2025-12-09 12:04:44'),
(49, 38, 14, 'create', 'order has been created', '2025-12-09 12:11:10', '2025-12-09 12:11:10'),
(50, 35, 15, 'create', 'order has been created', '2025-12-17 06:47:22', '2025-12-17 06:47:22'),
(51, 34, 15, 'Confirm', 'Confirmed by seller', '2025-12-17 07:01:50', '2025-12-17 07:01:50'),
(52, 1, 15, 'Confirm', 'Confirmed by admin', '2025-12-17 07:41:11', '2025-12-17 07:41:11'),
(53, 35, 16, 'create', 'order has been created', '2025-12-17 07:49:05', '2025-12-17 07:49:05'),
(54, 34, 16, 'Confirm', 'Confirmed by seller', '2025-12-17 07:55:30', '2025-12-17 07:55:30'),
(55, 1, 16, 'Confirm', 'Confirmed by admin', '2025-12-17 07:57:42', '2025-12-17 07:57:42'),
(56, 35, 17, 'create', 'order has been created', '2025-12-20 07:21:42', '2025-12-20 07:21:42'),
(57, 34, 17, 'Confirm', 'Confirmed by seller', '2025-12-20 07:23:33', '2025-12-20 07:23:33'),
(58, 1, 17, 'Confirm', 'Confirmed by admin', '2025-12-20 07:26:00', '2025-12-20 07:26:00'),
(59, 35, 18, 'create', 'order has been created', '2025-12-20 07:31:14', '2025-12-20 07:31:14'),
(60, 35, 19, 'create', 'order has been created', '2025-12-20 07:33:29', '2025-12-20 07:33:29'),
(61, 35, 20, 'create', 'order has been created', '2025-12-20 07:43:17', '2025-12-20 07:43:17'),
(62, 35, 21, 'create', 'order has been created', '2025-12-20 07:51:33', '2025-12-20 07:51:33'),
(63, 35, 22, 'create', 'order has been created', '2025-12-20 08:16:44', '2025-12-20 08:16:44'),
(64, 35, 23, 'create', 'order has been created', '2025-12-20 08:18:18', '2025-12-20 08:18:18'),
(65, 35, 24, 'create', 'order has been created', '2025-12-20 08:23:38', '2025-12-20 08:23:38'),
(66, 35, 25, 'create', 'order has been created', '2025-12-20 08:24:56', '2025-12-20 08:24:56'),
(67, 35, 26, 'create', 'order has been created', '2025-12-21 10:00:37', '2025-12-21 10:00:37'),
(68, 35, 27, 'create', 'order has been created', '2025-12-21 10:33:30', '2025-12-21 10:33:30'),
(69, 35, 28, 'create', 'order has been created', '2025-12-21 11:28:18', '2025-12-21 11:28:18'),
(70, 35, 29, 'create', 'order has been created', '2025-12-27 10:10:26', '2025-12-27 10:10:26'),
(71, 35, 30, 'create', 'order has been created', '2025-12-27 10:31:08', '2025-12-27 10:31:08'),
(72, 35, 31, 'create', 'order has been created', '2025-12-27 10:32:13', '2025-12-27 10:32:13'),
(73, 35, 32, 'create', 'order has been created', '2025-12-27 10:42:36', '2025-12-27 10:42:36'),
(74, 35, 33, 'create', 'order has been created', '2025-12-27 10:48:01', '2025-12-27 10:48:01'),
(75, 35, 34, 'create', 'order has been created', '2026-01-04 16:31:36', '2026-01-04 16:31:36'),
(76, 35, 35, 'create', 'order has been created', '2026-01-05 07:07:25', '2026-01-05 07:07:25'),
(77, 35, 38, 'create', 'order has been created', '2026-01-05 08:38:24', '2026-01-05 08:38:24'),
(78, 35, 39, 'create', 'order has been created', '2026-01-05 08:41:35', '2026-01-05 08:41:35'),
(79, 35, 40, 'create', 'order has been created', '2026-01-05 08:45:25', '2026-01-05 08:45:25'),
(80, 35, 41, 'create', 'order has been created', '2026-01-05 08:54:20', '2026-01-05 08:54:20'),
(81, 35, 42, 'create', 'order has been created', '2026-01-05 08:56:02', '2026-01-05 08:56:02'),
(82, 35, 43, 'create', 'order has been created', '2026-01-05 08:58:48', '2026-01-05 08:58:48'),
(83, 35, 44, 'create', 'order has been created', '2026-01-10 10:12:16', '2026-01-10 10:12:16'),
(84, 35, 45, 'create', 'order has been created', '2026-01-10 15:18:16', '2026-01-10 15:18:16'),
(85, 35, 46, 'create', 'order has been created', '2026-01-15 07:59:14', '2026-01-15 07:59:14'),
(86, 35, 47, 'create', 'order has been created', '2026-01-15 08:34:59', '2026-01-15 08:34:59'),
(87, 35, 48, 'create', 'order has been created', '2026-01-15 08:35:56', '2026-01-15 08:35:56'),
(88, 35, 49, 'create', 'order has been created', '2026-01-15 08:41:59', '2026-01-15 08:41:59'),
(89, 35, 50, 'create', 'order has been created', '2026-01-15 08:43:06', '2026-01-15 08:43:06'),
(90, 35, 51, 'create', 'order has been created', '2026-01-15 08:46:44', '2026-01-15 08:46:44'),
(91, 35, 52, 'create', 'order has been created', '2026-01-15 08:52:43', '2026-01-15 08:52:43'),
(92, 35, 53, 'create', 'order has been created', '2026-01-15 09:07:33', '2026-01-15 09:07:33'),
(93, 35, 54, 'create', 'order has been created', '2026-01-15 09:28:24', '2026-01-15 09:28:24'),
(94, 35, 55, 'create', 'order has been created', '2026-01-15 09:36:56', '2026-01-15 09:36:56'),
(95, 35, 56, 'create', 'order has been created', '2026-01-15 09:37:49', '2026-01-15 09:37:49'),
(96, 35, 57, 'create', 'order has been created', '2026-01-15 09:41:21', '2026-01-15 09:41:21'),
(97, 35, 58, 'create', 'order has been created', '2026-01-15 09:43:11', '2026-01-15 09:43:11'),
(98, 35, 59, 'create', 'order has been created', '2026-01-15 09:45:25', '2026-01-15 09:45:25'),
(99, 35, 60, 'create', 'order has been created', '2026-01-15 09:53:49', '2026-01-15 09:53:49'),
(100, 35, 61, 'create', 'order has been created', '2026-01-15 09:58:40', '2026-01-15 09:58:40'),
(101, 35, 62, 'create', 'order has been created', '2026-01-15 10:00:15', '2026-01-15 10:00:15'),
(102, 35, 63, 'create', 'order has been created', '2026-01-15 10:02:26', '2026-01-15 10:02:26'),
(103, 35, 64, 'create', 'order has been created', '2026-01-15 10:03:06', '2026-01-15 10:03:06'),
(104, 35, 65, 'create', 'order has been created', '2026-01-15 10:04:31', '2026-01-15 10:04:31'),
(105, 35, 66, 'create', 'order has been created', '2026-01-15 10:07:18', '2026-01-15 10:07:18'),
(106, 35, 67, 'create', 'order has been created', '2026-01-15 13:16:15', '2026-01-15 13:16:15'),
(107, 35, 68, 'create', 'order has been created', '2026-01-15 13:35:41', '2026-01-15 13:35:41'),
(108, 35, 69, 'create', 'order has been created', '2026-01-15 13:43:36', '2026-01-15 13:43:36'),
(109, 35, 70, 'create', 'order has been created', '2026-01-16 16:35:39', '2026-01-16 16:35:39'),
(110, 35, 71, 'create', 'order has been created', '2026-01-16 17:05:44', '2026-01-16 17:05:44'),
(111, 35, 75, 'create', 'order has been created', '2026-01-16 17:27:43', '2026-01-16 17:27:43'),
(112, 35, 76, 'create', 'order has been created', '2026-01-16 17:51:13', '2026-01-16 17:51:13'),
(113, 35, 81, 'create', 'order has been created', '2026-01-17 05:17:01', '2026-01-17 05:17:01'),
(114, 35, 82, 'create', 'order has been created', '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(115, 35, 83, 'create', 'order has been created', '2026-01-17 11:43:59', '2026-01-17 11:43:59'),
(116, 35, 84, 'create', 'order has been created', '2026-01-17 11:46:55', '2026-01-17 11:46:55'),
(117, 35, 85, 'create', 'order has been created', '2026-01-17 11:48:23', '2026-01-17 11:48:23'),
(118, 35, 86, 'create', 'order has been created', '2026-01-17 11:49:03', '2026-01-17 11:49:03'),
(119, 35, 87, 'create', 'order has been created', '2026-01-17 11:53:25', '2026-01-17 11:53:25'),
(120, 35, 88, 'create', 'order has been created', '2026-01-17 11:55:09', '2026-01-17 11:55:09'),
(121, 35, 89, 'create', 'order has been created', '2026-01-17 11:56:23', '2026-01-17 11:56:23'),
(122, 35, 90, 'create', 'order has been created', '2026-01-17 11:57:33', '2026-01-17 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_products`
--

DROP TABLE IF EXISTS `transaction_products`;
CREATE TABLE IF NOT EXISTS `transaction_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `variant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint NOT NULL,
  `seller_price` double DEFAULT NULL,
  `admin_cost` double DEFAULT NULL,
  `qty` int NOT NULL,
  `total` bigint NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_products`
--

INSERT INTO `transaction_products` (`id`, `transaction_id`, `product_id`, `variant`, `price`, `seller_price`, `admin_cost`, `qty`, `total`, `review`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 124, '', 1000, NULL, NULL, 1, 1000, '', NULL, '2025-03-30 19:43:35', '2025-03-30 19:43:35'),
(2, 2, 124, '', 1000, NULL, NULL, 1, 1000, '', NULL, '2025-03-30 20:03:15', '2025-03-30 20:03:15'),
(3, 3, 124, '', 1000, NULL, NULL, 1, 1000, '', NULL, '2025-04-02 10:56:44', '2025-04-02 10:56:44'),
(4, 4, 125, '', 10000, NULL, NULL, 1, 10000, '', NULL, '2025-04-03 09:01:03', '2025-04-03 09:01:03'),
(5, 5, 126, '', 350250, 350250, 250, 1, 350250, 'grw gwr h rwhw hwh whw', '2026-01-17 05:02:35', '2025-11-04 12:06:54', '2025-11-04 12:06:54'),
(6, 6, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-04 18:40:47', '2025-12-04 18:40:47'),
(7, 7, 1, '', 238371, 238121, 250, 2, 476742, '', NULL, '2025-12-09 11:37:38', '2025-12-09 11:37:38'),
(8, 10, 1, '', 238371, 238121, 250, 1, 238371, '', NULL, '2025-12-09 11:38:31', '2025-12-09 11:38:31'),
(9, 11, 1, '', 238371, 238121, 250, 1, 238371, '', NULL, '2025-12-09 11:39:06', '2025-12-09 11:39:06'),
(10, 12, 1, '', 238371, 238121, 250, 3, 715113, '', NULL, '2025-12-09 11:58:46', '2025-12-09 11:58:46'),
(11, 13, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-09 12:01:14', '2025-12-09 12:01:14'),
(12, 14, 1, '', 238371, 238121, 250, 1, 238371, '', NULL, '2025-12-09 12:11:10', '2025-12-09 12:11:10'),
(13, 15, 127, '', 150250, 150250, 250, 1, 150250, '', NULL, '2025-12-17 06:47:22', '2025-12-17 06:47:22'),
(14, 16, 127, '', 150250, 150250, 250, 1, 150250, '', NULL, '2025-12-17 07:49:05', '2025-12-17 07:49:05'),
(15, 17, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 07:21:42', '2025-12-20 07:21:42'),
(16, 18, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 07:31:14', '2025-12-20 07:31:14'),
(17, 19, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 07:33:29', '2025-12-20 07:33:29'),
(18, 20, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 07:43:17', '2025-12-20 07:43:17'),
(19, 21, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-20 07:51:33', '2025-12-20 07:51:33'),
(20, 21, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 07:51:33', '2025-12-20 07:51:33'),
(21, 22, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 08:16:44', '2025-12-20 08:16:44'),
(22, 23, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 08:18:18', '2025-12-20 08:18:18'),
(23, 23, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-20 08:18:18', '2025-12-20 08:18:18'),
(24, 24, 136, '', 100250, 100250, 250, 1, 100250, '', NULL, '2025-12-20 08:23:38', '2025-12-20 08:23:38'),
(25, 24, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-20 08:23:38', '2025-12-20 08:23:38'),
(26, 25, 136, '', 100250, 100250, 250, 2, 200500, '', NULL, '2025-12-20 08:24:56', '2025-12-20 08:24:56'),
(27, 26, 137, '', 100250, 100000, 250, 1, 100250, '', NULL, '2025-12-21 10:00:37', '2025-12-21 10:00:37'),
(28, 27, 137, '', 100250, 100000, 250, 1, 100250, '', NULL, '2025-12-21 10:33:30', '2025-12-21 10:33:30'),
(29, 28, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-21 11:28:18', '2025-12-21 11:28:18'),
(30, 29, 148, '', 120250, 120000, 250, 1, 120250, '', NULL, '2025-12-27 10:10:26', '2025-12-27 10:10:26'),
(31, 30, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-27 10:31:08', '2025-12-27 10:31:08'),
(32, 31, 148, '', 120250, 120000, 250, 1, 120250, '', NULL, '2025-12-27 10:32:13', '2025-12-27 10:32:13'),
(33, 32, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-27 10:42:36', '2025-12-27 10:42:36'),
(34, 33, 126, '', 350250, 350250, 250, 1, 350250, '', NULL, '2025-12-27 10:48:01', '2025-12-27 10:48:01'),
(35, 34, 148, '', 120000, 120000, 0, 1, 120000, '', NULL, '2026-01-04 16:31:36', '2026-01-04 16:31:36'),
(36, 35, 126, '', 350250, 350250, 0, 5, 1751250, '', NULL, '2026-01-05 07:07:25', '2026-01-05 07:07:25'),
(37, 38, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:38:24', '2026-01-05 08:38:24'),
(38, 39, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:41:35', '2026-01-05 08:41:35'),
(39, 40, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:45:25', '2026-01-05 08:45:25'),
(40, 41, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:54:20', '2026-01-05 08:54:20'),
(41, 42, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:56:02', '2026-01-05 08:56:02'),
(42, 43, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-05 08:58:48', '2026-01-05 08:58:48'),
(43, 43, 136, '', 100250, 100250, 0, 1, 100250, '', NULL, '2026-01-05 08:58:48', '2026-01-05 08:58:48'),
(44, 44, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-10 10:12:16', '2026-01-10 10:12:16'),
(45, 45, 154, '', 100000, 100000, 0, 1, 100000, '', NULL, '2026-01-10 15:18:16', '2026-01-10 15:18:16'),
(46, 46, 126, '', 350250, 350250, 0, 5, 1751250, '', NULL, '2026-01-15 07:59:13', '2026-01-15 07:59:13'),
(47, 46, 160, '', 10000, 10000, 0, 8, 80000, '', NULL, '2026-01-15 07:59:13', '2026-01-15 07:59:13'),
(48, 47, 160, '', 10000, 10000, 0, 4, 40000, '', NULL, '2026-01-15 08:34:59', '2026-01-15 08:34:59'),
(49, 48, 126, '', 350250, 350250, 0, 2, 700500, '', NULL, '2026-01-15 08:35:56', '2026-01-15 08:35:56'),
(50, 49, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-15 08:41:59', '2026-01-15 08:41:59'),
(51, 50, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-15 08:43:06', '2026-01-15 08:43:06'),
(52, 51, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-15 08:46:44', '2026-01-15 08:46:44'),
(53, 52, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-15 08:52:43', '2026-01-15 08:52:43'),
(54, 53, 126, '', 350250, 350250, 0, 1, 350250, '', NULL, '2026-01-15 09:07:33', '2026-01-15 09:07:33'),
(55, 67, 160, '', 10000, 10000, 0, 5, 50000, '', NULL, '2026-01-15 13:16:15', '2026-01-15 13:16:15'),
(56, 67, 126, '', 350250, 350250, 0, 66, 23116500, '', NULL, '2026-01-15 13:16:15', '2026-01-15 13:16:15'),
(57, 68, 126, '', 350250, 350250, 0, 2, 700500, '', NULL, '2026-01-15 13:35:41', '2026-01-15 13:35:41'),
(58, 69, 126, '', 350250, 350250, 0, 2, 700500, '', NULL, '2026-01-15 13:43:36', '2026-01-15 13:43:36'),
(59, 69, 160, '', 10000, 10000, 0, 2, 20000, '', NULL, '2026-01-15 13:43:36', '2026-01-15 13:43:36'),
(60, 70, 160, '', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 16:35:39', '2026-01-16 16:35:39'),
(61, 70, 160, '', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 16:35:39', '2026-01-16 16:35:39'),
(62, 70, 160, '', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 16:35:39', '2026-01-16 16:35:39'),
(63, 71, 160, '1 bulan', 10000, 10000, 0, 2, 20000, '', NULL, '2026-01-16 17:05:44', '2026-01-16 17:05:44'),
(64, 71, 160, '2 bulan', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 17:05:44', '2026-01-16 17:05:44'),
(65, 71, 160, '3 bulan', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 17:05:44', '2026-01-16 17:05:44'),
(66, 75, 160, '2 bulan', 10000, 10000, 0, 1, 10000, 'gewgwgwe gwe w', '2026-01-17 05:14:11', '2026-01-16 17:27:43', '2026-01-16 17:27:43'),
(67, 75, 160, '1 bulan', 10000, 10000, 0, 2, 20000, '', NULL, '2026-01-16 17:27:43', '2026-01-16 17:27:43'),
(68, 75, 160, '3 bulan', 10000, 10000, 0, 1, 10000, '', NULL, '2026-01-16 17:27:43', '2026-01-16 17:27:43'),
(69, 76, 160, '2 bulan', 35000, 10000, 0, 1, 10000, '11111111111111111111111111', '2026-01-17 04:32:13', '2026-01-16 17:51:13', '2026-01-16 17:51:13'),
(70, 76, 160, '3 bulan', 50000, 10000, 0, 2, 20000, '222222222222222222222222222222222', '2026-01-17 04:34:00', '2026-01-16 17:51:13', '2026-01-16 17:51:13'),
(71, 76, 160, '1 bulan', 20000, 10000, 0, 1, 10000, '33333333333333333', '2026-01-17 04:31:53', '2026-01-16 17:51:13', '2026-01-16 17:51:13'),
(72, 81, 160, '2 bulan', 35000, 10000, 0, 3, 30000, 'barang lumayan sesuai harga', '2026-01-17 05:26:34', '2026-01-17 05:17:01', '2026-01-17 05:17:01'),
(73, 82, 126, NULL, 350250, 350250, 0, 2, 700500, NULL, NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(74, 82, 160, '1 bulan', 20000, 10000, 0, 3, 30000, NULL, NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(75, 82, 160, '3 bulan', 50000, 10000, 0, 1, 10000, NULL, NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(76, 82, 160, '2 bulan', 35000, 10000, 0, 2, 20000, NULL, NULL, '2026-01-17 11:38:19', '2026-01-17 11:38:19'),
(77, 83, 160, '1 bulan', 20000, 10000, 0, 3, 30000, NULL, NULL, '2026-01-17 11:43:59', '2026-01-17 11:43:59'),
(78, 83, 160, '3 bulan', 50000, 10000, 0, 2, 20000, NULL, NULL, '2026-01-17 11:43:59', '2026-01-17 11:43:59'),
(79, 84, 126, NULL, 350250, 350250, 0, 2, 700500, NULL, NULL, '2026-01-17 11:46:55', '2026-01-17 11:46:55'),
(80, 85, 160, '2 bulan', 35000, 10000, 0, 2, 20000, NULL, NULL, '2026-01-17 11:48:23', '2026-01-17 11:48:23'),
(81, 86, 126, NULL, 350250, 350250, 0, 2, 700500, NULL, NULL, '2026-01-17 11:49:03', '2026-01-17 11:49:03'),
(82, 87, 126, NULL, 350250, 350250, 0, 2, 700500, NULL, NULL, '2026-01-17 11:53:25', '2026-01-17 11:53:25'),
(83, 88, 160, '2 bulan', 35000, 10000, 0, 2, 20000, NULL, NULL, '2026-01-17 11:55:09', '2026-01-17 11:55:09'),
(84, 89, 126, NULL, 350250, 350250, 0, 1, 350250, NULL, NULL, '2026-01-17 11:56:23', '2026-01-17 11:56:23'),
(85, 90, 160, '3 bulan', 50000, 10000, 0, 1, 10000, NULL, NULL, '2026-01-17 11:57:33', '2026-01-17 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '3',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `verification_code`) VALUES
(1, 'Super Admin', 'admin@olebsai.com', '088888888', NULL, '$2y$12$Omc/3rGnr1Jqol9.I.FOsOgRWcvDN8pmMF.NZ8Ca7ENqIw5ojb/zW', 1, NULL, '2025-03-30 19:23:41', '2025-03-30 19:23:41', NULL),
(2, 'Vicky Handayani', 'vicky.handayani41@olebsai.com', '086181088624', NULL, '$2y$12$5IfjBQjLmb.n3bQa54mZy.710rZoToAPYpalKjxUlFn/9XolC6hiu', 4, NULL, '2025-03-30 19:23:42', '2025-03-30 19:23:42', NULL),
(3, 'Halima Saputra', 'halima.saputra63@olebsai.com', '089609188366', NULL, '$2y$12$5GN42FLL6qJ5A4oy19jVHOmuLjt3tC8jpdaiNZIebMDecFbXfZwPa', 4, NULL, '2025-03-30 19:23:42', '2025-03-30 19:23:42', NULL),
(4, 'Juli Permata', 'juli.permata58@olebsai.com', '081301341049', NULL, '$2y$12$PnrM8BUk8svMt3nbu0EZLukC7j6mXaNXsi.vTwWJrJKWSErwluYgO', 4, NULL, '2025-03-30 19:23:42', '2025-03-30 19:23:42', NULL),
(5, 'Gangsa Wasita', 'gangsa.wasita65@olebsai.com', '083304590794', NULL, '$2y$12$JeIkL7LLQyQ7BkEaXq.fieKD61doXV1sn43ProcGyKU9zCUZRwCm2', 4, NULL, '2025-03-30 19:23:43', '2025-03-30 19:23:43', NULL),
(6, 'Kartika Sinaga', 'kartika.sinaga59@olebsai.com', '087611137497', NULL, '$2y$12$Gb4kRAQZKP9HcIBt.erZgOOzaTPwtohDUO07huDXXSzRpw7YwrtiG', 4, NULL, '2025-03-30 19:23:43', '2025-03-30 19:23:43', NULL),
(7, 'Taufan Rahimah', 'taufan.rahimah94@olebsai.com', '087977123222', NULL, '$2y$12$h5cE1rMmsnvlt9iO/lNkiu6MT/YhgYoDV/fNU75Zy/ysb8gWDsll6', 4, NULL, '2025-03-30 19:23:43', '2025-03-30 19:23:43', NULL),
(8, 'Icha Putra', 'icha.putra29@olebsai.com', '081677461717', NULL, '$2y$12$c12XLyIocYWWs7DebeR5pOT3.8HPnopJrdmNDddVp8Tshyg3YRK6y', 4, NULL, '2025-03-30 19:23:43', '2025-03-30 19:23:43', NULL),
(9, 'Legawa Ramadan', 'legawa.ramadan19@olebsai.com', '084534680778', NULL, '$2y$12$ZUyrVDIOmxcFjBCdQX2cJO/GJ0lsZn1U3tp.MqwdlBwVC0jW0P0FC', 4, NULL, '2025-03-30 19:23:44', '2025-03-30 19:23:44', NULL),
(10, 'Dacin Wulandari', 'dacin.wulandari34@olebsai.com', '085516811499', NULL, '$2y$12$X0lsA1hzIJwhpXlGlWqxV.iliWRfZxiY262dgekCb5ZdozL6.Dhpy', 4, NULL, '2025-03-30 19:23:44', '2025-03-30 19:23:44', NULL),
(11, 'Jagaraga Nasyiah', 'jagaraga.nasyiah50@olebsai.com', '084280922643', NULL, '$2y$12$zDJuJSPCO.6A5YIIxq7kxORCHHsLEvfLCm2c8jLXrsnR.qWER0Une', 4, NULL, '2025-03-30 19:23:44', '2025-03-30 19:23:44', NULL),
(12, 'Cornelia Tamba', 'cornelia.tamba85@olebsai.com', '088240735070', NULL, '$2y$12$CdWbam8V8DBqYQz4KOISGONRrT.MbVO.yHaMB.OYOFCw4yRLKPOzS', 4, NULL, '2025-03-30 19:23:45', '2025-03-30 19:23:45', NULL),
(13, 'Ghaliyati Maryati', 'ghaliyati.maryati29@olebsai.com', '089002368943', NULL, '$2y$12$rGJRo8hqzPkEkw2.38Myp.LNxVG.YkTiHa16XXahSAntkf0I8hh5e', 4, NULL, '2025-03-30 19:23:45', '2025-03-30 19:23:45', NULL),
(14, 'Viman Maryadi', 'viman.maryadi74@olebsai.com', '089215563680', NULL, '$2y$12$v8baO4yfO2zFrYG0aw80Fu3lGbF7pa8w1T183nsYB909IEC5hQ7rO', 4, NULL, '2025-03-30 19:23:45', '2025-03-30 19:23:45', NULL),
(15, 'Siti Laksita', 'siti.laksita59@olebsai.com', '084161307247', NULL, '$2y$12$2V.At5wKdA8NNbeR9D/aK.23ATjpSZX.yJ1m9MXFdgPddm5dSBCee', 4, NULL, '2025-03-30 19:23:45', '2025-03-30 19:23:45', NULL),
(16, 'Vicky Aryani', 'vicky.aryani80@olebsai.com', '083466872188', NULL, '$2y$12$2jVupVXgEOMHHbYYvuLeIu4nwr8lhdjztDxoaHlBfzFN79sq6vOoW', 4, NULL, '2025-03-30 19:23:46', '2025-03-30 19:23:46', NULL),
(17, 'Hana Prastuti', 'hana.prastuti26@olebsai.com', '083209870040', NULL, '$2y$12$zQyJlj5EwBUQ6Op.KcOE0eg8047Pz3ZyP7jbd/OW0MsmNSZlgYLsO', 4, NULL, '2025-03-30 19:23:46', '2025-03-30 19:23:46', NULL),
(18, 'Wira Waskita', 'wira.waskita77@olebsai.com', '086412396143', NULL, '$2y$12$L2sWBkj.g/21yjM3A4ZOKO/VMTAcCgsgNUjmmqTHbP3.iVZAlXcYy', 4, NULL, '2025-03-30 19:23:46', '2025-03-30 19:23:46', NULL),
(19, 'Carub Mulyani', 'carub.mulyani58@olebsai.com', '083999736596', NULL, '$2y$12$puESTlF2mJgQQB3ZeOoQfOvrUqyZtFU4rJeijiTXqKgPJZ90TIqI6', 4, NULL, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL),
(20, 'Tami Hastuti', 'tami.hastuti43@olebsai.com', '082412974733', NULL, '$2y$12$vUF.QTJr1IDciT2puZkch.UYuVlAfnjW5RgHZ2aYULQTz5Jisyy2O', 4, NULL, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL),
(21, 'Jinawi Setiawan', 'jinawi.setiawan19@olebsai.com', '088904624631', NULL, '$2y$12$RXXCJcYmF6QknCWXhLrMo.Yd2le5xpLoH5LL2x24Hfg6b/mjikFEG', 4, NULL, '2025-03-30 19:23:47', '2025-03-30 19:23:47', NULL),
(22, 'seller', 'seller@gmail.com', '85869101484', NULL, '$2y$12$BrEQ7pEZtqJiDTe4fA1uruP4NJ6QNbZIN1F1Kc4nya91VdAdNnYn6', 4, NULL, '2025-03-30 19:25:24', '2025-03-30 19:25:24', NULL),
(23, 'Nur Afianto', 'nurafianto@gmail.com', NULL, NULL, '$2y$12$rHcB7ILJ/xnkckeSHLMOp.IIDNn.waDP.9ix.FHv9DHinE.DM5zIS', 3, NULL, '2025-03-30 19:40:56', '2025-03-30 19:40:56', NULL),
(24, 'Xion', 'xirfaroxas@gmail.com', NULL, NULL, '$2y$12$7b1QzITmOMADDVV93dvIw.NBp5cDlc2TZ1IH86uWsUNVclIxjAREO', 3, NULL, '2025-03-30 20:57:19', '2025-05-20 09:59:42', NULL),
(25, 'xion', 'seler1@gmail.com', '81248419335', NULL, '$2y$12$/T4/P3ilLham3Y0R7bZhq.utkJ/REdSWg6Tx57cI7Bv3cjSPnE6ZC', 4, NULL, '2025-04-03 08:40:03', '2025-04-03 08:40:03', NULL),
(26, 'buyer1', 'buyer1@gmail.com', NULL, NULL, '$2y$12$1GVYhgeWqsgAjo3zyCn9x./9H2je4/bnA/I/d/lhfgeeDxY3Dcq82', 3, NULL, '2025-04-03 08:46:12', '2025-04-03 08:46:12', NULL),
(27, 'jatquh', 'jatquh@gmail.com', NULL, NULL, '$2y$12$KZiSjLBlDVPtVuDuV4rOMO6QQCIzuYlg4RSP/AEA4GyP1v11MeE/i', 3, NULL, '2025-04-08 13:18:08', '2025-04-08 13:18:08', NULL),
(29, 'Nur', 'fadildwi121@gmail.com', NULL, '2025-04-13 13:08:06', '$2y$12$faY/jQFITxH0D4vyM1uJQOfi9iy/g80cSbTx6qQ6gUvHFDt.6H/Zy', 3, NULL, '2025-04-13 13:07:11', '2025-04-13 13:09:22', NULL),
(30, 'indy', 'indyi0516@gmail.com', NULL, NULL, '$2y$12$pHv5pU4yz2zuLXUlcDvhkuQm21hLdCphkqOBDji2teqlzcAYD8O16', 3, NULL, '2025-04-20 11:53:27', '2025-04-20 11:53:27', NULL),
(31, 'dany', 'danielgebze05@gmail.com', NULL, '2025-04-20 12:03:05', '$2y$12$tpVgcPoVjgon80E6c.p3p.GJUHNCGHqm7TQWJZEYPZ6RPolS65Kie', 3, NULL, '2025-04-20 12:02:22', '2025-04-20 12:03:05', NULL),
(32, 'ekraf', 'kominfontago@gmail.com', NULL, '2025-09-16 06:17:47', '$2y$12$Wm2WI44XEVsSt9SEAqUmHeljYA/GmSVADYLZXj1fAhM6jOdAGomsO', 3, NULL, '2025-09-16 06:17:10', '2025-09-16 06:17:47', NULL),
(34, 'toko noken', 'tokonoken@gmail.com', '81248419335', '2025-11-04 06:15:15', '$2y$12$EiH4lVKKDoly63g1SD8jAO.cbIXzKMS1DNEbPoxIpUECpwxWbIdpC', 4, NULL, '2025-11-04 06:14:38', '2025-11-04 06:15:15', NULL),
(35, 'buyer', 'buyerolebsai@gmail.com', NULL, '2025-11-04 12:05:01', '$2y$12$ffZcrbqheY2bXNdQC33S3usnh5XebQsFlUP0UAcbphasLOagSAmDy', 3, NULL, '2025-11-04 12:04:28', '2025-11-04 12:05:01', NULL),
(36, 'reeza', 'ramalaura@gmail.com', '082113498393', NULL, '$2y$12$virLqYgbeF722EPL9zXOWu2hjCQLD.mWNTQkyqrYbL1ndSjsUEmzK', 4, NULL, '2025-12-09 11:53:10', '2025-12-09 11:53:10', NULL),
(37, 'reeza', 'ananarlia123@gmail.com', '082113498393', '2025-12-09 11:55:26', '$2y$12$JVgrJzAHJ8ILLeUyYOoJ7.Tk1BX49oFijpYUw0l.Cn7L1Bs4WKG1G', 4, NULL, '2025-12-09 11:54:56', '2025-12-09 11:55:26', NULL),
(38, 'freeza', 'terataritore@gmail.com', NULL, '2025-12-09 11:57:24', '$2y$12$UsLMKkBbL5s6mc2QwYzwFeNFJbGviLxGfp8/dmQZ3LpHh.FJ9wpte', 3, NULL, '2025-12-09 11:57:03', '2025-12-09 11:57:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

DROP TABLE IF EXISTS `verification_codes`;
CREATE TABLE IF NOT EXISTS `verification_codes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('reset_password','register') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_codes_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_codes`
--

INSERT INTO `verification_codes` (`id`, `type`, `code`, `user_id`, `status`, `expired_at`, `created_at`, `updated_at`) VALUES
(2, 'register', '484263', 29, 1, '2025-04-13 13:12:11', '2025-04-13 13:07:11', '2025-04-13 13:08:06'),
(3, 'register', '446308', 30, 0, '2025-04-20 11:58:27', '2025-04-20 11:53:27', '2025-04-20 11:53:27'),
(4, 'register', '765564', 31, 1, '2025-04-20 12:07:22', '2025-04-20 12:02:22', '2025-04-20 12:03:05'),
(5, 'register', '834112', 32, 1, '2025-09-16 06:22:10', '2025-09-16 06:17:10', '2025-09-16 06:17:47'),
(6, 'register', '181803', 34, 1, '2025-11-04 06:19:38', '2025-11-04 06:14:38', '2025-11-04 06:15:15'),
(7, 'register', '189740', 35, 1, '2025-11-04 12:09:28', '2025-11-04 12:04:28', '2025-11-04 12:05:01'),
(8, 'register', '494393', 36, 0, '2025-12-09 11:58:10', '2025-12-09 11:53:10', '2025-12-09 11:53:10'),
(9, 'register', '130774', 37, 1, '2025-12-09 11:59:56', '2025-12-09 11:54:56', '2025-12-09 11:55:26'),
(10, 'register', '670240', 38, 1, '2025-12-09 12:02:03', '2025-12-09 11:57:03', '2025-12-09 11:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `percentage` double(5,2) NOT NULL DEFAULT '0.00',
  `max_discount` double(15,2) DEFAULT NULL,
  `minimum_transaction` double(15,2) NOT NULL DEFAULT '0.00',
  `quota` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `user_created` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vouchers_user_created_foreign` (`user_created`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `name`, `type`, `percentage`, `max_discount`, `minimum_transaction`, `quota`, `status`, `start_date`, `expired_date`, `user_created`, `created_at`, `updated_at`) VALUES
(1, 'Voucher Diskon', 1, 10.00, 100.00, 0.00, 10, 1, '2025-04-01 00:38:00', '2025-05-01 00:38:00', 1, '2025-04-29 17:38:23', '2025-04-29 17:38:23');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_trackings`
--
ALTER TABLE `delivery_trackings`
  ADD CONSTRAINT `delivery_trackings_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `other_costs`
--
ALTER TABLE `other_costs`
  ADD CONSTRAINT `other_costs_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `transaction_logs_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD CONSTRAINT `verification_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_user_created_foreign` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
