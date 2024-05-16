-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 07:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_project`
--
CREATE DATABASE IF NOT EXISTS `laravel_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `laravel_project`;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(2, 'samsung', 'samsung', '1', '2024-03-30 21:13:28', '2024-03-30 21:13:28'),
(6, 'Apple', 'Apple', '1', '2024-04-09 10:03:21', '2024-04-09 10:03:21'),
(7, 'J.', 'J.', '1', '2024-04-09 10:03:36', '2024-04-09 10:03:36'),
(8, 'Dell', 'Dell', '1', '2024-04-09 10:04:16', '2024-04-09 10:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(51, 'Assessories', 'Assessories', '51.jpg', '1', '2024-04-09 09:56:05', '2024-04-09 09:56:05'),
(52, 'Clothes', 'Clothes', '52.jpg', '1', '2024-04-09 09:58:01', '2024-04-09 09:58:01'),
(53, 'Arts', 'Arts', '53.jpeg', '1', '2024-04-09 10:01:36', '2024-04-12 21:28:18'),
(54, 'Electronics', 'Electronics', '54.jpg', '1', '2024-04-09 10:05:34', '2024-04-09 10:05:34');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_17_160836_alter_users_table', 2),
(6, '2024_03_21_173712_create_cateories_table', 3),
(7, '2024_03_23_030740_create_categorys_table', 4),
(8, '2024_03_23_031819_create_categories_table', 5),
(9, '2024_03_25_161302_create_temp_images_table', 6),
(10, '2024_03_27_125517_create_sub_categories_table', 7),
(11, '2024_03_27_130833_create_sub_categories_table', 8),
(12, '2024_03_30_155300_create_brands_table', 9),
(13, '2024_03_31_144135_create_products_table', 10),
(14, '2024_03_31_144207_create_products_images_table', 10),
(15, '2024_03_31_144207_create_product_images_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `compare_price` double(10,2) DEFAULT NULL,
  `categories_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brands_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `track_qty` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `qty` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `price`, `compare_price`, `categories_id`, `sub_category_id`, `brands_id`, `is_featured`, `sku`, `barcode`, `track_qty`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Laptop', 'Laptop', NULL, 40000.00, 4555.00, 54, 7, 8, 'Yes', 'Dell-6430', NULL, 'Yes', 23, 1, '2024-04-10 22:14:32', '2024-04-12 21:59:37'),
(13, 'Samsung A17', 'Samsung A17', NULL, 50000.00, NULL, 54, 8, 2, 'No', 'A17', NULL, 'Yes', 45, 1, '2024-04-10 22:17:06', '2024-04-10 22:55:33'),
(14, 'T -  Shirt', 'T -  Shirt', NULL, 12000.00, NULL, 52, 5, 7, 'No', 'Shirt-ATU', NULL, 'Yes', 34, 1, '2024-04-10 23:06:09', '2024-04-10 23:06:20'),
(15, 'Shoes Jogger', 'Shoes Jogger', NULL, 3000.00, NULL, 52, 6, 7, 'No', 'shoes-45', NULL, 'Yes', 45, 1, '2024-04-10 23:08:13', '2024-04-10 23:08:31'),
(16, 'shoes', 'shoes', NULL, 44000.00, NULL, 52, 5, 7, 'Yes', 'dd', NULL, 'Yes', 45, 1, '2024-04-10 23:18:13', '2024-04-10 23:18:40'),
(17, 'Paint Hores', 'Paint Hores', NULL, 60000.00, NULL, 51, NULL, 7, 'No', 'tttttttt', NULL, 'Yes', 56, 1, '2024-04-11 00:48:44', '2024-04-11 00:48:44'),
(19, 'Dr. Katrina Kutch V', 'dr-katrina-kutch-v', NULL, 644.00, NULL, 53, 6, 8, 'Yes', '2708', NULL, 'Yes', 10, 1, '2024-04-22 12:48:31', '2024-04-22 12:48:31'),
(20, 'Alfonso Dietrich', 'alfonso-dietrich', NULL, 160.00, NULL, 53, 6, 2, 'Yes', '9117', NULL, 'Yes', 10, 1, '2024-04-22 12:48:32', '2024-04-22 12:48:32'),
(21, 'Yasmin Paucek', 'yasmin-paucek', NULL, 191.00, NULL, 53, 6, 2, 'Yes', '6482', NULL, 'Yes', 10, 1, '2024-04-22 12:48:32', '2024-04-22 12:48:32'),
(22, 'Miss Annie Blick III', 'miss-annie-blick-iii', NULL, 66.00, NULL, 53, 5, 7, 'Yes', '4390', NULL, 'Yes', 10, 1, '2024-04-22 12:48:33', '2024-04-22 12:48:33'),
(23, 'Timothy Howe Jr.', 'timothy-howe-jr', NULL, 302.00, NULL, 53, 6, 6, 'Yes', '4789', NULL, 'Yes', 10, 1, '2024-04-22 12:48:33', '2024-04-22 12:48:33'),
(24, 'Mrs. Stella Shields II', 'mrs-stella-shields-ii', NULL, 236.00, NULL, 53, 5, 2, 'Yes', '1715', NULL, 'Yes', 10, 1, '2024-04-22 12:48:34', '2024-04-22 12:48:34'),
(25, 'Sylvan Ullrich', 'sylvan-ullrich', NULL, 510.00, NULL, 53, 6, 2, 'Yes', '3596', NULL, 'Yes', 10, 1, '2024-04-22 12:48:35', '2024-04-22 12:48:35'),
(26, 'Miss Angelica Senger', 'miss-angelica-senger', NULL, 851.00, NULL, 53, 5, 2, 'Yes', '6469', NULL, 'Yes', 10, 1, '2024-04-22 12:48:36', '2024-04-22 12:48:36'),
(27, 'Ervin Emmerich', 'ervin-emmerich', NULL, 322.00, NULL, 53, 5, 7, 'Yes', '2702', NULL, 'Yes', 10, 1, '2024-04-22 12:48:38', '2024-04-22 12:48:38'),
(28, 'Brigitte Donnelly DDS', 'brigitte-donnelly-dds', NULL, 704.00, NULL, 53, 6, 2, 'Yes', '9707', NULL, 'Yes', 10, 1, '2024-04-22 12:48:38', '2024-04-22 12:48:38'),
(29, 'Dr. Hassan Leffler II', 'dr-hassan-leffler-ii', NULL, 295.00, NULL, 53, 6, 6, 'Yes', '6885', NULL, 'Yes', 10, 1, '2024-04-22 12:48:41', '2024-04-22 12:48:41'),
(30, 'Mr. Stephan Hirthe', 'mr-stephan-hirthe', NULL, 615.00, NULL, 53, 5, 8, 'Yes', '1330', NULL, 'Yes', 10, 1, '2024-04-22 12:48:41', '2024-04-22 12:48:41'),
(31, 'Mr. Johnathan Harber', 'mr-johnathan-harber', NULL, 63.00, NULL, 53, 6, 2, 'Yes', '5562', NULL, 'Yes', 10, 1, '2024-04-22 12:48:42', '2024-04-22 12:48:42'),
(32, 'Alexandria Keebler', 'alexandria-keebler', NULL, 485.00, NULL, 53, 6, 8, 'Yes', '5340', NULL, 'Yes', 10, 1, '2024-04-22 12:48:42', '2024-04-22 12:48:42'),
(33, 'Josiah Brown', 'josiah-brown', NULL, 838.00, NULL, 53, 5, 7, 'Yes', '1078', NULL, 'Yes', 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(34, 'Chelsey Nader', 'chelsey-nader', NULL, 477.00, NULL, 53, 6, 8, 'Yes', '9420', NULL, 'Yes', 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(35, 'Horace Larson Sr.', 'horace-larson-sr', NULL, 721.00, NULL, 53, 6, 6, 'Yes', '2955', NULL, 'Yes', 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(36, 'Althea Wunsch V', 'althea-wunsch-v', NULL, 25.00, NULL, 53, 5, 7, 'Yes', '5087', NULL, 'Yes', 10, 1, '2024-04-22 12:48:44', '2024-04-22 12:48:44'),
(37, 'Alysa Olson', 'alysa-olson', NULL, 774.00, NULL, 53, 5, 7, 'Yes', '9774', NULL, 'Yes', 10, 1, '2024-04-22 12:48:44', '2024-04-22 12:48:44'),
(38, 'Kelvin Windler', 'kelvin-windler', NULL, 549.00, NULL, 53, 5, 7, 'Yes', '6573', NULL, 'Yes', 10, 1, '2024-04-22 12:48:45', '2024-04-22 12:48:45'),
(39, 'Darion Lockman DVM', 'darion-lockman-dvm', NULL, 816.00, NULL, 53, 5, 8, 'Yes', '8600', NULL, 'Yes', 10, 1, '2024-04-22 12:48:46', '2024-04-22 12:48:46'),
(40, 'Prof. Mable Quitzon', 'prof-mable-quitzon', NULL, 843.00, NULL, 53, 5, 8, 'Yes', '1331', NULL, 'Yes', 10, 1, '2024-04-22 12:48:49', '2024-04-22 12:48:49'),
(41, 'Virginia Brakus', 'virginia-brakus', NULL, 11.00, NULL, 53, 6, 7, 'Yes', '8676', NULL, 'Yes', 10, 1, '2024-04-22 12:48:49', '2024-04-22 12:48:49'),
(42, 'Jarret Bruen', 'jarret-bruen', NULL, 234.00, NULL, 53, 6, 7, 'Yes', '8990', NULL, 'Yes', 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(43, 'Alanis Dach', 'alanis-dach', NULL, 188.00, NULL, 53, 6, 6, 'Yes', '5181', NULL, 'Yes', 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(44, 'Nikita Welch', 'nikita-welch', NULL, 688.00, NULL, 53, 5, 2, 'Yes', '1590', NULL, 'Yes', 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(45, 'Abbigail Dicki', 'abbigail-dicki', NULL, 943.00, NULL, 53, 5, 6, 'Yes', '2067', NULL, 'Yes', 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(46, 'Dr. Valentin Kerluke', 'dr-valentin-kerluke', NULL, 209.00, NULL, 53, 6, 2, 'Yes', '3782', NULL, 'Yes', 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(47, 'Astrid Ratke', 'astrid-ratke', NULL, 180.00, NULL, 53, 6, 7, 'Yes', '9508', NULL, 'Yes', 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(48, 'Giovanny Dach', 'giovanny-dach', NULL, 375.00, NULL, 53, 6, 7, 'Yes', '1234', NULL, 'Yes', 10, 1, '2024-04-22 12:48:52', '2024-04-22 12:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(12, 12, '12--1712805272.1712805130.jpeg', NULL, '2024-04-10 22:14:32', '2024-04-10 22:14:32'),
(13, 12, '12--1712805273.1712805138.jpeg', NULL, '2024-04-10 22:14:33', '2024-04-10 22:14:33'),
(14, 12, '12--1712805273.1712805143.jpeg', NULL, '2024-04-10 22:14:33', '2024-04-10 22:14:33'),
(15, 13, '13--1712805426.1712805398.jpeg', NULL, '2024-04-10 22:17:06', '2024-04-10 22:17:06'),
(16, 13, '13--1712805427.1712805401.jpg', NULL, '2024-04-10 22:17:07', '2024-04-10 22:17:07'),
(17, 14, '14--1712808370.1712808321.jpg', NULL, '2024-04-10 23:06:10', '2024-04-10 23:06:10'),
(18, 15, '15--1712808494.1712808468.jpeg', NULL, '2024-04-10 23:08:14', '2024-04-10 23:08:14'),
(19, 15, '15--1712808495.1712808475.jpg', NULL, '2024-04-10 23:08:15', '2024-04-10 23:08:15'),
(20, 16, '16--1712809093.1712809050.jpg', NULL, '2024-04-10 23:18:13', '2024-04-10 23:18:13'),
(21, 16, '16--1712809094.1712809057.jpg', NULL, '2024-04-10 23:18:14', '2024-04-10 23:18:14'),
(22, 17, '17--1712814525.1712814497.jpeg', NULL, '2024-04-11 00:48:45', '2024-04-11 00:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(5, 'Men', 'Men', 1, 52, '2024-04-09 10:02:05', '2024-04-09 10:02:05'),
(6, 'Women', 'Women', 1, 52, '2024-04-09 10:02:21', '2024-04-09 10:02:21'),
(7, 'Laptop', 'Laptop', 1, 54, '2024-04-09 10:06:00', '2024-04-09 10:06:00'),
(8, 'Mobile Phone', 'Mobile Phone', 1, 54, '2024-04-09 10:06:18', '2024-04-09 10:06:18'),
(9, 'HeadPhones', 'HeadPhones', 1, 54, '2024-04-09 10:07:21', '2024-04-09 10:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '1711384529.jpg', '2024-03-25 11:35:29', '2024-03-25 11:35:29'),
(2, '1711384649.jpg', '2024-03-25 11:37:29', '2024-03-25 11:37:29'),
(3, '1711385106.jpeg', '2024-03-25 11:45:06', '2024-03-25 11:45:06'),
(4, '1711385401.jpeg', '2024-03-25 11:50:01', '2024-03-25 11:50:01'),
(5, '1711385467.jpeg', '2024-03-25 11:51:07', '2024-03-25 11:51:07'),
(6, '1711386394.jpeg', '2024-03-25 12:06:34', '2024-03-25 12:06:34'),
(7, '1711413266.jpeg', '2024-03-25 19:34:26', '2024-03-25 19:34:26'),
(8, '1711413574.jpg', '2024-03-25 19:39:34', '2024-03-25 19:39:34'),
(9, '1711413672.jpeg', '2024-03-25 19:41:12', '2024-03-25 19:41:12'),
(10, '1711413738.jpeg', '2024-03-25 19:42:18', '2024-03-25 19:42:18'),
(11, '1711511763.jpeg', '2024-03-26 22:56:03', '2024-03-26 22:56:03'),
(12, '1711511852.PNG', '2024-03-26 22:57:32', '2024-03-26 22:57:32'),
(13, '1711512013.jpg', '2024-03-26 23:00:13', '2024-03-26 23:00:13'),
(14, '1711512166.jpg', '2024-03-26 23:02:46', '2024-03-26 23:02:46'),
(15, '1711512250.jpeg', '2024-03-26 23:04:10', '2024-03-26 23:04:10'),
(16, '1711513045.PNG', '2024-03-26 23:17:25', '2024-03-26 23:17:25'),
(17, '1711513180.jpg', '2024-03-26 23:19:40', '2024-03-26 23:19:40'),
(18, '1711513343.jpeg', '2024-03-26 23:22:23', '2024-03-26 23:22:23'),
(19, '1711513378.PNG', '2024-03-26 23:22:58', '2024-03-26 23:22:58'),
(20, '1712162637.jpg', '2024-04-03 11:43:57', '2024-04-03 11:43:57'),
(21, '1712163660.jpg', '2024-04-03 12:01:00', '2024-04-03 12:01:00'),
(22, '1712163734.jpg', '2024-04-03 12:02:14', '2024-04-03 12:02:14'),
(23, '1712164782.jpg', '2024-04-03 12:19:42', '2024-04-03 12:19:42'),
(24, '1712164976.jpg', '2024-04-03 12:22:56', '2024-04-03 12:22:56'),
(25, '1712165060.jpg', '2024-04-03 12:24:20', '2024-04-03 12:24:20'),
(26, '1712165121.jpg', '2024-04-03 12:25:21', '2024-04-03 12:25:21'),
(27, '1712165261.jpg', '2024-04-03 12:27:41', '2024-04-03 12:27:41'),
(28, '1712165369.jpg', '2024-04-03 12:29:29', '2024-04-03 12:29:29'),
(29, '1712165564.jpg', '2024-04-03 12:32:44', '2024-04-03 12:32:44'),
(30, '1712165637.jpg', '2024-04-03 12:33:57', '2024-04-03 12:33:57'),
(31, '1712165826.jpg', '2024-04-03 12:37:06', '2024-04-03 12:37:06'),
(32, '1712166054.jpg', '2024-04-03 12:40:54', '2024-04-03 12:40:54'),
(33, '1712189637.jpg', '2024-04-03 19:13:57', '2024-04-03 19:13:57'),
(34, '1712189788.jpg', '2024-04-03 19:16:28', '2024-04-03 19:16:28'),
(35, '1712191196.jpg', '2024-04-03 19:39:56', '2024-04-03 19:39:56'),
(36, '1712191279.jpg', '2024-04-03 19:41:19', '2024-04-03 19:41:19'),
(37, '1712191424.jpg', '2024-04-03 19:43:44', '2024-04-03 19:43:44'),
(38, '1712247121.jpg', '2024-04-04 11:12:01', '2024-04-04 11:12:01'),
(39, '1712247267.jpg', '2024-04-04 11:14:27', '2024-04-04 11:14:27'),
(40, '1712247884.jpg', '2024-04-04 11:24:44', '2024-04-04 11:24:44'),
(41, '1712334786.jpg', '2024-04-05 11:33:06', '2024-04-05 11:33:06'),
(42, '1712334790.jpg', '2024-04-05 11:33:10', '2024-04-05 11:33:10'),
(43, '1712334795.jpg', '2024-04-05 11:33:15', '2024-04-05 11:33:15'),
(44, '1712334897.jpg', '2024-04-05 11:34:57', '2024-04-05 11:34:57'),
(45, '1712334901.jpg', '2024-04-05 11:35:01', '2024-04-05 11:35:01'),
(46, '1712335109.jpg', '2024-04-05 11:38:29', '2024-04-05 11:38:29'),
(47, '1712335742.jpg', '2024-04-05 11:49:02', '2024-04-05 11:49:02'),
(48, '1712338206.jpg', '2024-04-05 12:30:06', '2024-04-05 12:30:06'),
(49, '1712338394.jpg', '2024-04-05 12:33:14', '2024-04-05 12:33:14'),
(50, '1712338397.jpg', '2024-04-05 12:33:17', '2024-04-05 12:33:17'),
(51, '1712338467.jpg', '2024-04-05 12:34:27', '2024-04-05 12:34:27'),
(52, '1712338469.jpg', '2024-04-05 12:34:29', '2024-04-05 12:34:29'),
(53, '1712339032.jpg', '2024-04-05 12:43:52', '2024-04-05 12:43:52'),
(54, '1712339237.jpg', '2024-04-05 12:47:17', '2024-04-05 12:47:17'),
(55, '1712421722.png', '2024-04-06 11:42:02', '2024-04-06 11:42:02'),
(56, '1712421788.png', '2024-04-06 11:43:08', '2024-04-06 11:43:08'),
(57, '1712425088.jpg', '2024-04-06 12:38:08', '2024-04-06 12:38:08'),
(58, '1712425159.jpg', '2024-04-06 12:39:19', '2024-04-06 12:39:19'),
(59, '1712425279.png', '2024-04-06 12:41:19', '2024-04-06 12:41:19'),
(60, '1712425455.png', '2024-04-06 12:44:15', '2024-04-06 12:44:15'),
(61, '1712460234.png', '2024-04-06 22:23:54', '2024-04-06 22:23:54'),
(62, '1712673859.png', '2024-04-09 09:44:19', '2024-04-09 09:44:19'),
(63, '1712674563.jpg', '2024-04-09 09:56:03', '2024-04-09 09:56:03'),
(64, '1712674679.jpg', '2024-04-09 09:57:59', '2024-04-09 09:57:59'),
(65, '1712674894.jpeg', '2024-04-09 10:01:34', '2024-04-09 10:01:34'),
(66, '1712675132.jpg', '2024-04-09 10:05:32', '2024-04-09 10:05:32'),
(67, '1712675404.jpeg', '2024-04-09 10:10:04', '2024-04-09 10:10:04'),
(68, '1712675404.jpeg', '2024-04-09 10:10:04', '2024-04-09 10:10:04'),
(69, '1712675405.jpeg', '2024-04-09 10:10:05', '2024-04-09 10:10:05'),
(70, '1712805130.jpeg', '2024-04-10 22:12:10', '2024-04-10 22:12:10'),
(71, '1712805138.jpeg', '2024-04-10 22:12:18', '2024-04-10 22:12:18'),
(72, '1712805143.jpeg', '2024-04-10 22:12:23', '2024-04-10 22:12:23'),
(73, '1712805398.jpeg', '2024-04-10 22:16:38', '2024-04-10 22:16:38'),
(74, '1712805401.jpg', '2024-04-10 22:16:41', '2024-04-10 22:16:41'),
(75, '1712808321.jpg', '2024-04-10 23:05:21', '2024-04-10 23:05:21'),
(76, '1712808468.jpeg', '2024-04-10 23:07:48', '2024-04-10 23:07:48'),
(77, '1712808475.jpg', '2024-04-10 23:07:55', '2024-04-10 23:07:55'),
(78, '1712809050.jpg', '2024-04-10 23:17:30', '2024-04-10 23:17:30'),
(79, '1712809057.jpg', '2024-04-10 23:17:37', '2024-04-10 23:17:37'),
(80, '1712814497.jpeg', '2024-04-11 00:48:17', '2024-04-11 00:48:17'),
(81, '1712814579.jpg', '2024-04-11 00:49:39', '2024-04-11 00:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'sheharyar', 'sheharyar7@gmail.com', 1, NULL, '$2y$12$qjTrYfKAveb8hSn.te6VkOBvZD90smUB5b4OO3xvhuJKo3x12Ccfi', NULL, '2024-03-17 11:22:28', '2024-03-17 11:22:28'),
(3, 'admin', 'msheharyar76@gmail.com', 2, NULL, '$2y$12$i1VIOE0CW.S4feLhhAtHwOlPq.zBeVs/4R1A1HbpRsVlJKTV2NFpy', NULL, '2024-03-21 10:33:23', '2024-03-21 10:33:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categories_id_foreign` (`categories_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_brands_id_foreign` (`brands_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brands_id_foreign` FOREIGN KEY (`brands_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2019-10-21 13:37:09', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `project10`
--
CREATE DATABASE IF NOT EXISTS `project10` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project10`;

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `expires_at` timestamp NULL DEFAULT NULL,
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
