-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 10:55 AM
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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'United States', 'US', NULL, NULL),
(2, 'Canada', 'CA', NULL, NULL),
(3, 'Afghanistan', 'AF', NULL, NULL),
(4, 'Albania', 'AL', NULL, NULL),
(5, 'Algeria', 'DZ', NULL, NULL),
(6, 'American Samoa', 'AS', NULL, NULL),
(7, 'Andorra', 'AD', NULL, NULL),
(8, 'Angola', 'AO', NULL, NULL),
(9, 'Anguilla', 'AI', NULL, NULL),
(10, 'Antarctica', 'AQ', NULL, NULL),
(11, 'Antigua and/or Barbuda', 'AG', NULL, NULL),
(12, 'Argentina', 'AR', NULL, NULL),
(13, 'Armenia', 'AM', NULL, NULL),
(14, 'Aruba', 'AW', NULL, NULL),
(15, 'Australia', 'AU', NULL, NULL),
(16, 'Austria', 'AT', NULL, NULL),
(17, 'Azerbaijan', 'AZ', NULL, NULL),
(18, 'Bahamas', 'BS', NULL, NULL),
(19, 'Bahrain', 'BH', NULL, NULL),
(20, 'Bangladesh', 'BD', NULL, NULL),
(21, 'Barbados', 'BB', NULL, NULL),
(22, 'Belarus', 'BY', NULL, NULL),
(23, 'Belgium', 'BE', NULL, NULL),
(24, 'Belize', 'BZ', NULL, NULL),
(25, 'Benin', 'BJ', NULL, NULL),
(26, 'Bermuda', 'BM', NULL, NULL),
(27, 'Bhutan', 'BT', NULL, NULL),
(28, 'Bolivia', 'BO', NULL, NULL),
(29, 'Bosnia and Herzegovina', 'BA', NULL, NULL),
(30, 'Botswana', 'BW', NULL, NULL),
(31, 'Bouvet Island', 'BV', NULL, NULL),
(32, 'Brazil', 'BR', NULL, NULL),
(33, 'British lndian Ocean Territory', 'IO', NULL, NULL),
(34, 'Brunei Darussalam', 'BN', NULL, NULL),
(35, 'Bulgaria', 'BG', NULL, NULL),
(36, 'Burkina Faso', 'BF', NULL, NULL),
(37, 'Burundi', 'BI', NULL, NULL),
(38, 'Cambodia', 'KH', NULL, NULL),
(39, 'Cameroon', 'CM', NULL, NULL),
(40, 'Cape Verde', 'CV', NULL, NULL),
(41, 'Cayman Islands', 'KY', NULL, NULL),
(42, 'Central African Republic', 'CF', NULL, NULL),
(43, 'Chad', 'TD', NULL, NULL),
(44, 'Chile', 'CL', NULL, NULL),
(45, 'China', 'CN', NULL, NULL),
(46, 'Christmas Island', 'CX', NULL, NULL),
(47, 'Cocos (Keeling) Islands', 'CC', NULL, NULL),
(48, 'Colombia', 'CO', NULL, NULL),
(49, 'Comoros', 'KM', NULL, NULL),
(50, 'Congo', 'CG', NULL, NULL),
(51, 'Cook Islands', 'CK', NULL, NULL),
(52, 'Costa Rica', 'CR', NULL, NULL),
(53, 'Croatia (Hrvatska)', 'HR', NULL, NULL),
(54, 'Cuba', 'CU', NULL, NULL),
(55, 'Cyprus', 'CY', NULL, NULL),
(56, 'Czech Republic', 'CZ', NULL, NULL),
(57, 'Democratic Republic of Congo', 'CD', NULL, NULL),
(58, 'Denmark', 'DK', NULL, NULL),
(59, 'Djibouti', 'DJ', NULL, NULL),
(60, 'Dominica', 'DM', NULL, NULL),
(61, 'Dominican Republic', 'DO', NULL, NULL),
(62, 'East Timor', 'TP', NULL, NULL),
(63, 'Ecudaor', 'EC', NULL, NULL),
(64, 'Egypt', 'EG', NULL, NULL),
(65, 'El Salvador', 'SV', NULL, NULL),
(66, 'Equatorial Guinea', 'GQ', NULL, NULL),
(67, 'Eritrea', 'ER', NULL, NULL),
(68, 'Estonia', 'EE', NULL, NULL),
(69, 'Ethiopia', 'ET', NULL, NULL),
(70, 'Falkland Islands (Malvinas)', 'FK', NULL, NULL),
(71, 'Faroe Islands', 'FO', NULL, NULL),
(72, 'Fiji', 'FJ', NULL, NULL),
(73, 'Finland', 'FI', NULL, NULL),
(74, 'France', 'FR', NULL, NULL),
(75, 'France, Metropolitan', 'FX', NULL, NULL),
(76, 'French Guiana', 'GF', NULL, NULL),
(77, 'French Polynesia', 'PF', NULL, NULL),
(78, 'French Southern Territories', 'TF', NULL, NULL),
(79, 'Gabon', 'GA', NULL, NULL),
(80, 'Gambia', 'GM', NULL, NULL),
(81, 'Georgia', 'GE', NULL, NULL),
(82, 'Germany', 'DE', NULL, NULL),
(83, 'Ghana', 'GH', NULL, NULL),
(84, 'Gibraltar', 'GI', NULL, NULL),
(85, 'Greece', 'GR', NULL, NULL),
(86, 'Greenland', 'GL', NULL, NULL),
(87, 'Grenada', 'GD', NULL, NULL),
(88, 'Guadeloupe', 'GP', NULL, NULL),
(89, 'Guam', 'GU', NULL, NULL),
(90, 'Guatemala', 'GT', NULL, NULL),
(91, 'Guinea', 'GN', NULL, NULL),
(92, 'Guinea-Bissau', 'GW', NULL, NULL),
(93, 'Guyana', 'GY', NULL, NULL),
(94, 'Haiti', 'HT', NULL, NULL),
(95, 'Heard and Mc Donald Islands', 'HM', NULL, NULL),
(96, 'Honduras', 'HN', NULL, NULL),
(97, 'Hong Kong', 'HK', NULL, NULL),
(98, 'Hungary', 'HU', NULL, NULL),
(99, 'Iceland', 'IS', NULL, NULL),
(100, 'India', 'IN', NULL, NULL),
(101, 'Indonesia', 'ID', NULL, NULL),
(102, 'Iran (Islamic Republic of)', 'IR', NULL, NULL),
(103, 'Iraq', 'IQ', NULL, NULL),
(104, 'Ireland', 'IE', NULL, NULL),
(105, 'Israel', 'IL', NULL, NULL),
(106, 'Italy', 'IT', NULL, NULL),
(107, 'Ivory Coast', 'CI', NULL, NULL),
(108, 'Jamaica', 'JM', NULL, NULL),
(109, 'Japan', 'JP', NULL, NULL),
(110, 'Jordan', 'JO', NULL, NULL),
(111, 'Kazakhstan', 'KZ', NULL, NULL),
(112, 'Kenya', 'KE', NULL, NULL),
(113, 'Kiribati', 'KI', NULL, NULL),
(114, 'Korea, Democratic People\'s Republic of', 'KP', NULL, NULL),
(115, 'Korea, Republic of', 'KR', NULL, NULL),
(116, 'Kuwait', 'KW', NULL, NULL),
(117, 'Kyrgyzstan', 'KG', NULL, NULL),
(118, 'Lao People\'s Democratic Republic', 'LA', NULL, NULL),
(119, 'Latvia', 'LV', NULL, NULL),
(120, 'Lebanon', 'LB', NULL, NULL),
(121, 'Lesotho', 'LS', NULL, NULL),
(122, 'Liberia', 'LR', NULL, NULL),
(123, 'Libyan Arab Jamahiriya', 'LY', NULL, NULL),
(124, 'Liechtenstein', 'LI', NULL, NULL),
(125, 'Lithuania', 'LT', NULL, NULL),
(126, 'Luxembourg', 'LU', NULL, NULL),
(127, 'Macau', 'MO', NULL, NULL),
(128, 'Macedonia', 'MK', NULL, NULL),
(129, 'Madagascar', 'MG', NULL, NULL),
(130, 'Malawi', 'MW', NULL, NULL),
(131, 'Malaysia', 'MY', NULL, NULL),
(132, 'Maldives', 'MV', NULL, NULL),
(133, 'Mali', 'ML', NULL, NULL),
(134, 'Malta', 'MT', NULL, NULL),
(135, 'Marshall Islands', 'MH', NULL, NULL),
(136, 'Martinique', 'MQ', NULL, NULL),
(137, 'Mauritania', 'MR', NULL, NULL),
(138, 'Mauritius', 'MU', NULL, NULL),
(139, 'Mayotte', 'TY', NULL, NULL),
(140, 'Mexico', 'MX', NULL, NULL),
(141, 'Micronesia, Federated States of', 'FM', NULL, NULL),
(142, 'Moldova, Republic of', 'MD', NULL, NULL),
(143, 'Monaco', 'MC', NULL, NULL),
(144, 'Mongolia', 'MN', NULL, NULL),
(145, 'Montserrat', 'MS', NULL, NULL),
(146, 'Morocco', 'MA', NULL, NULL),
(147, 'Mozambique', 'MZ', NULL, NULL),
(148, 'Myanmar', 'MM', NULL, NULL),
(149, 'Namibia', 'NA', NULL, NULL),
(150, 'Nauru', 'NR', NULL, NULL),
(151, 'Nepal', 'NP', NULL, NULL),
(152, 'Netherlands', 'NL', NULL, NULL),
(153, 'Netherlands Antilles', 'AN', NULL, NULL),
(154, 'New Caledonia', 'NC', NULL, NULL),
(155, 'New Zealand', 'NZ', NULL, NULL),
(156, 'Nicaragua', 'NI', NULL, NULL),
(157, 'Niger', 'NE', NULL, NULL),
(158, 'Nigeria', 'NG', NULL, NULL),
(159, 'Niue', 'NU', NULL, NULL),
(160, 'Norfork Island', 'NF', NULL, NULL),
(161, 'Northern Mariana Islands', 'MP', NULL, NULL),
(162, 'Norway', 'NO', NULL, NULL),
(163, 'Oman', 'OM', NULL, NULL),
(164, 'Pakistan', 'PK', NULL, NULL),
(165, 'Palau', 'PW', NULL, NULL),
(166, 'Panama', 'PA', NULL, NULL),
(167, 'Papua New Guinea', 'PG', NULL, NULL),
(168, 'Paraguay', 'PY', NULL, NULL),
(169, 'Peru', 'PE', NULL, NULL),
(170, 'Philippines', 'PH', NULL, NULL),
(171, 'Pitcairn', 'PN', NULL, NULL),
(172, 'Poland', 'PL', NULL, NULL),
(173, 'Portugal', 'PT', NULL, NULL),
(174, 'Puerto Rico', 'PR', NULL, NULL),
(175, 'Qatar', 'QA', NULL, NULL),
(176, 'Republic of South Sudan', 'SS', NULL, NULL),
(177, 'Reunion', 'RE', NULL, NULL),
(178, 'Romania', 'RO', NULL, NULL),
(179, 'Russian Federation', 'RU', NULL, NULL),
(180, 'Rwanda', 'RW', NULL, NULL),
(181, 'Saint Kitts and Nevis', 'KN', NULL, NULL),
(182, 'Saint Lucia', 'LC', NULL, NULL),
(183, 'Saint Vincent and the Grenadines', 'VC', NULL, NULL),
(184, 'Samoa', 'WS', NULL, NULL),
(185, 'San Marino', 'SM', NULL, NULL),
(186, 'Sao Tome and Principe', 'ST', NULL, NULL),
(187, 'Saudi Arabia', 'SA', NULL, NULL),
(188, 'Senegal', 'SN', NULL, NULL),
(189, 'Serbia', 'RS', NULL, NULL),
(190, 'Seychelles', 'SC', NULL, NULL),
(191, 'Sierra Leone', 'SL', NULL, NULL),
(192, 'Singapore', 'SG', NULL, NULL),
(193, 'Slovakia', 'SK', NULL, NULL),
(194, 'Slovenia', 'SI', NULL, NULL),
(195, 'Solomon Islands', 'SB', NULL, NULL),
(196, 'Somalia', 'SO', NULL, NULL),
(197, 'South Africa', 'ZA', NULL, NULL),
(198, 'South Georgia South Sandwich Islands', 'GS', NULL, NULL),
(199, 'Spain', 'ES', NULL, NULL),
(200, 'Sri Lanka', 'LK', NULL, NULL),
(201, 'St. Helena', 'SH', NULL, NULL),
(202, 'St. Pierre and Miquelon', 'PM', NULL, NULL),
(203, 'Sudan', 'SD', NULL, NULL),
(204, 'Suriname', 'SR', NULL, NULL),
(205, 'Svalbarn and Jan Mayen Islands', 'SJ', NULL, NULL),
(206, 'Swaziland', 'SZ', NULL, NULL),
(207, 'Sweden', 'SE', NULL, NULL),
(208, 'Switzerland', 'CH', NULL, NULL),
(209, 'Syrian Arab Republic', 'SY', NULL, NULL),
(210, 'Taiwan', 'TW', NULL, NULL),
(211, 'Tajikistan', 'TJ', NULL, NULL),
(212, 'Tanzania, United Republic of', 'TZ', NULL, NULL),
(213, 'Thailand', 'TH', NULL, NULL),
(214, 'Togo', 'TG', NULL, NULL),
(215, 'Tokelau', 'TK', NULL, NULL),
(216, 'Tonga', 'TO', NULL, NULL),
(217, 'Trinidad and Tobago', 'TT', NULL, NULL),
(218, 'Tunisia', 'TN', NULL, NULL),
(219, 'Turkey', 'TR', NULL, NULL),
(220, 'Turkmenistan', 'TM', NULL, NULL),
(221, 'Turks and Caicos Islands', 'TC', NULL, NULL),
(222, 'Tuvalu', 'TV', NULL, NULL),
(223, 'Uganda', 'UG', NULL, NULL),
(224, 'Ukraine', 'UA', NULL, NULL),
(225, 'United Arab Emirates', 'AE', NULL, NULL),
(226, 'United Kingdom', 'GB', NULL, NULL),
(227, 'United States minor outlying islands', 'UM', NULL, NULL),
(228, 'Uruguay', 'UY', NULL, NULL),
(229, 'Uzbekistan', 'UZ', NULL, NULL),
(230, 'Vanuatu', 'VU', NULL, NULL),
(231, 'Vatican City State', 'VA', NULL, NULL),
(232, 'Venezuela', 'VE', NULL, NULL),
(233, 'Vietnam', 'VN', NULL, NULL),
(234, 'Virgin Islands (British)', 'VG', NULL, NULL),
(235, 'Virgin Islands (U.S.)', 'VI', NULL, NULL),
(236, 'Wallis and Futuna Islands', 'WF', NULL, NULL),
(237, 'Western Sahara', 'EH', NULL, NULL),
(238, 'Yemen', 'YE', NULL, NULL),
(239, 'Yugoslavia', 'YU', NULL, NULL),
(240, 'Zaire', 'ZR', NULL, NULL),
(241, 'Zambia', 'ZM', NULL, NULL),
(242, 'Zimbabwe', 'ZW', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `firstname`, `lastname`, `email`, `mobile`, `country_id`, `apartment`, `address`, `city`, `state`, `zip`, `created_at`, `updated_at`) VALUES
(3, 25, 'Muhammad', 'Asif', 'shery0597@gmail.com', '302851360', 3, NULL, 'village post office hattian saiden district attock\r\nvillage post office hattian saiden district attock', 'attock', 'punjab', '43600', '2024-08-17 22:32:59', '2024-08-19 11:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `max_user` int(11) DEFAULT NULL,
  `max_user_user` int(11) DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'fixed',
  `discont_amount` double(10,2) NOT NULL,
  `min_amount` double(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `start_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `Isocode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `slug`, `Isocode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'English', 'en', '1', '2024-08-03 09:42:10', '2024-08-03 09:42:10'),
(4, 'Urdu', 'Urdu', 'ur', '1', '2024-08-04 10:48:19', '2024-08-04 10:48:19');

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
(15, '2024_03_31_144207_create_product_images_table', 11),
(16, '2024_04_12_130053_update_products_table', 12),
(17, '2024_05_26_133328_alter_products_table', 12),
(18, '2024_06_07_055028_alter_users_table', 13),
(19, '2024_06_10_053603_create_countries_table', 14),
(20, '2024_06_11_045207_create_orders_table', 14),
(21, '2024_06_11_045242_create_orders_items_table', 14),
(22, '2024_06_11_045345_create_customer_addresses_table', 14),
(23, '2024_06_12_051525_alter_customer_addresses_table', 14),
(24, '2024_06_14_043753_create_shipping_charges_table', 14),
(25, '2024_06_27_044136_create_discount_coupons_table', 14),
(26, '2024_07_22_043116_alter_users_table', 14),
(27, '2024_07_22_051907_alter_users_table', 14),
(28, '2024_07_27_145454_create_wishlists_table', 15),
(29, '2024_08_01_051150_create_languages_table', 16),
(30, '2024_08_07_055335_update_products_table', 17),
(31, '2024_08_08_050726_create_product_ratings_table', 17),
(32, '2024_08_17_134349_alter_orders_table', 18),
(33, '2024_08_19_051417_alter_orders_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` double(10,2) NOT NULL,
  `shipping` double(10,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) NOT NULL,
  `payment_status` enum('paid','not paid') NOT NULL DEFAULT 'not paid',
  `status` enum('pending','shipped','delivered') NOT NULL DEFAULT 'pending',
  `shipping_date` timestamp NULL DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `shipping`, `coupon_code`, `discount`, `grandtotal`, `payment_status`, `status`, `shipping_date`, `firstname`, `lastname`, `email`, `country_id`, `apartment`, `address`, `city`, `state`, `zip`, `notes`, `created_at`, `updated_at`) VALUES
(1, 25, 100.00, 10.00, '', 0.00, 110.00, 'not paid', 'pending', NULL, 'Muhammad', 'Asif', 'msheharyar76@gmail.com', 164, NULL, 'village post office hattian saiden district attock\r\nvillage post office hattian saiden district attock', 'attock', 'punjab', '43600', 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnn', '2024-08-17 08:40:52', '2024-08-17 08:40:52'),
(2, 25, 3302.00, 10.00, '', 0.00, 3312.00, 'not paid', 'pending', NULL, 'Muhammad', 'Asif', 'msheharyar76@gmail.com', 164, NULL, 'village post office hattian saiden district attock\r\nvillage post office hattian saiden district attock', 'attock', 'punjab', '43600', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '2024-08-17 22:22:43', '2024-08-17 22:22:43'),
(3, 25, 51025.00, 135.00, '', 0.00, 51160.00, 'not paid', 'pending', NULL, 'Muhammad', 'Asif', 'msheharyar76@gmail.com', 3, NULL, 'village post office hattian saiden district attock\r\nvillage post office hattian saiden district attock', 'attock', 'punjab', '43600', '1111111111111111111111111111111111111', '2024-08-17 22:32:59', '2024-08-17 22:32:59'),
(4, 25, 40510.00, 90.00, '', 0.00, 40600.00, 'not paid', 'pending', NULL, 'Muhammad', 'Asif', 'shery0597@gmail.com', 3, NULL, 'village post office hattian saiden district attock\r\nvillage post office hattian saiden district attock', 'attock', 'punjab', '43600', 'jkhkdsljlsjdfkljd', '2024-08-19 11:31:26', '2024-08-19 11:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders_items`
--

CREATE TABLE `orders_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_items`
--

INSERT INTO `orders_items` (`id`, `order_id`, `product_id`, `name`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 50, 'jioewjrkl;akewrl;', 1, 100.00, 100.00, '2024-08-17 08:40:52', '2024-08-17 08:40:52'),
(2, 2, 23, 'Timothy Howe Jr.', 1, 302.00, 302.00, '2024-08-17 22:22:43', '2024-08-17 22:22:43'),
(3, 3, 13, 'Samsung A17', 1, 50000.00, 50000.00, '2024-08-17 22:32:59', '2024-08-17 22:32:59'),
(4, 4, 12, 'Laptop', 1, 40000.00, 40000.00, '2024-08-19 11:31:26', '2024-08-19 11:31:26'),
(5, 4, 25, 'Sylvan Ullrich', 1, 510.00, 510.00, '2024-08-19 11:31:26', '2024-08-19 11:31:26');

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
  `short_description` text DEFAULT NULL,
  `shipping_returns` text DEFAULT NULL,
  `related_products` text DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `compare_price` double(10,2) DEFAULT NULL,
  `categories_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brands_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `track_qty` tinyint(1) NOT NULL DEFAULT 0,
  `qty` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `short_description`, `shipping_returns`, `related_products`, `price`, `compare_price`, `categories_id`, `sub_category_id`, `brands_id`, `is_featured`, `sku`, `barcode`, `track_qty`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Laptop', 'Laptop', NULL, NULL, NULL, NULL, 40000.00, 4555.00, 54, 7, 8, 1, 'Dell-6430', NULL, 1, 23, 1, '2024-04-10 22:14:32', '2024-04-12 21:59:37'),
(13, 'Samsung A17', 'Samsung A17', NULL, NULL, NULL, NULL, 50000.00, NULL, 54, 8, 2, 2, 'A17', NULL, 1, 45, 1, '2024-04-10 22:17:06', '2024-04-10 22:55:33'),
(14, 'T -  Shirt', 'T -  Shirt', NULL, NULL, NULL, NULL, 12000.00, NULL, 52, 5, 7, 2, 'Shirt-ATU', NULL, 1, 34, 1, '2024-04-10 23:06:09', '2024-04-10 23:06:20'),
(15, 'Shoes Jogger', 'Shoes Jogger', NULL, NULL, NULL, NULL, 3000.00, NULL, 52, 6, 7, 2, 'shoes-45', NULL, 1, 45, 1, '2024-04-10 23:08:13', '2024-04-10 23:08:31'),
(16, 'shoes', 'shoes', NULL, NULL, NULL, NULL, 44000.00, NULL, 52, 5, 7, 1, 'dd', NULL, 1, 45, 1, '2024-04-10 23:18:13', '2024-04-10 23:18:40'),
(17, 'Paint Hores', 'Paint Hores', NULL, NULL, NULL, NULL, 60000.00, NULL, 51, NULL, 7, 2, 'tttttttt', NULL, 1, 56, 1, '2024-04-11 00:48:44', '2024-04-11 00:48:44'),
(19, 'Dr. Katrina Kutch V', 'dr-katrina-kutch-v', NULL, NULL, NULL, NULL, 644.00, NULL, 53, 6, 8, 1, '2708', NULL, 1, 10, 1, '2024-04-22 12:48:31', '2024-04-22 12:48:31'),
(20, 'Alfonso Dietrich', 'alfonso-dietrich', NULL, NULL, NULL, NULL, 160.00, NULL, 53, 6, 2, 1, '9117', NULL, 1, 10, 1, '2024-04-22 12:48:32', '2024-04-22 12:48:32'),
(21, 'Yasmin Paucek', 'yasmin-paucek', NULL, NULL, NULL, NULL, 191.00, NULL, 53, 6, 2, 1, '6482', NULL, 1, 10, 1, '2024-04-22 12:48:32', '2024-04-22 12:48:32'),
(22, 'Miss Annie Blick III', 'miss-annie-blick-iii', NULL, NULL, NULL, NULL, 66.00, NULL, 53, 5, 7, 1, '4390', NULL, 1, 10, 1, '2024-04-22 12:48:33', '2024-04-22 12:48:33'),
(23, 'Timothy Howe Jr.', 'timothy-howe-jr', NULL, NULL, NULL, NULL, 302.00, NULL, 53, 6, 6, 1, '4789', NULL, 1, 10, 1, '2024-04-22 12:48:33', '2024-04-22 12:48:33'),
(24, 'Mrs. Stella Shields II', 'mrs-stella-shields-ii', NULL, NULL, NULL, NULL, 236.00, NULL, 53, 5, 2, 1, '1715', NULL, 1, 10, 1, '2024-04-22 12:48:34', '2024-04-22 12:48:34'),
(25, 'Sylvan Ullrich', 'sylvan-ullrich', NULL, NULL, NULL, NULL, 510.00, NULL, 53, 6, 2, 1, '3596', NULL, 1, 10, 1, '2024-04-22 12:48:35', '2024-04-22 12:48:35'),
(26, 'Miss Angelica Senger', 'miss-angelica-senger', NULL, NULL, NULL, NULL, 851.00, NULL, 53, 5, 2, 1, '6469', NULL, 1, 10, 1, '2024-04-22 12:48:36', '2024-04-22 12:48:36'),
(27, 'Ervin Emmerich', 'ervin-emmerich', NULL, NULL, NULL, NULL, 322.00, NULL, 53, 5, 7, 1, '2702', NULL, 1, 10, 1, '2024-04-22 12:48:38', '2024-04-22 12:48:38'),
(28, 'Brigitte Donnelly DDS', 'brigitte-donnelly-dds', NULL, NULL, NULL, NULL, 704.00, NULL, 53, 6, 2, 1, '9707', NULL, 1, 10, 1, '2024-04-22 12:48:38', '2024-04-22 12:48:38'),
(29, 'Dr. Hassan Leffler II', 'dr-hassan-leffler-ii', NULL, NULL, NULL, NULL, 295.00, NULL, 53, 6, 6, 1, '6885', NULL, 1, 10, 1, '2024-04-22 12:48:41', '2024-04-22 12:48:41'),
(30, 'Mr. Stephan Hirthe', 'mr-stephan-hirthe', NULL, NULL, NULL, NULL, 615.00, NULL, 53, 5, 8, 1, '1330', NULL, 1, 10, 1, '2024-04-22 12:48:41', '2024-04-22 12:48:41'),
(31, 'Mr. Johnathan Harber', 'mr-johnathan-harber', NULL, NULL, NULL, NULL, 63.00, NULL, 53, 6, 2, 1, '5562', NULL, 1, 10, 1, '2024-04-22 12:48:42', '2024-04-22 12:48:42'),
(32, 'Alexandria Keebler', 'alexandria-keebler', NULL, NULL, NULL, NULL, 485.00, NULL, 53, 6, 8, 1, '5340', NULL, 1, 10, 1, '2024-04-22 12:48:42', '2024-04-22 12:48:42'),
(33, 'Josiah Brown', 'josiah-brown', NULL, NULL, NULL, NULL, 838.00, NULL, 53, 5, 7, 1, '1078', NULL, 1, 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(34, 'Chelsey Nader', 'chelsey-nader', NULL, NULL, NULL, NULL, 477.00, NULL, 53, 6, 8, 1, '9420', NULL, 1, 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(35, 'Horace Larson Sr.', 'horace-larson-sr', NULL, NULL, NULL, NULL, 721.00, NULL, 53, 6, 6, 1, '2955', NULL, 1, 10, 1, '2024-04-22 12:48:43', '2024-04-22 12:48:43'),
(36, 'Althea Wunsch V', 'althea-wunsch-v', NULL, NULL, NULL, NULL, 25.00, NULL, 53, 5, 7, 1, '5087', NULL, 1, 10, 1, '2024-04-22 12:48:44', '2024-04-22 12:48:44'),
(37, 'Alysa Olson', 'alysa-olson', NULL, NULL, NULL, NULL, 774.00, NULL, 53, 5, 7, 1, '9774', NULL, 1, 10, 1, '2024-04-22 12:48:44', '2024-04-22 12:48:44'),
(38, 'Kelvin Windler', 'kelvin-windler', NULL, NULL, NULL, NULL, 549.00, NULL, 53, 5, 7, 1, '6573', NULL, 1, 10, 1, '2024-04-22 12:48:45', '2024-04-22 12:48:45'),
(39, 'Darion Lockman DVM', 'darion-lockman-dvm', NULL, NULL, NULL, NULL, 816.00, NULL, 53, 5, 8, 1, '8600', NULL, 1, 10, 1, '2024-04-22 12:48:46', '2024-04-22 12:48:46'),
(40, 'Prof. Mable Quitzon', 'prof-mable-quitzon', NULL, NULL, NULL, NULL, 843.00, NULL, 53, 5, 8, 1, '1331', NULL, 1, 10, 1, '2024-04-22 12:48:49', '2024-04-22 12:48:49'),
(41, 'Virginia Brakus', 'virginia-brakus', NULL, NULL, NULL, NULL, 11.00, NULL, 53, 6, 7, 1, '8676', NULL, 1, 10, 1, '2024-04-22 12:48:49', '2024-04-22 12:48:49'),
(42, 'Jarret Bruen', 'jarret-bruen', NULL, NULL, NULL, NULL, 234.00, NULL, 53, 6, 7, 1, '8990', NULL, 1, 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(43, 'Alanis Dach', 'alanis-dach', NULL, NULL, NULL, NULL, 188.00, NULL, 53, 6, 6, 1, '5181', NULL, 1, 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(44, 'Nikita Welch', 'nikita-welch', NULL, NULL, NULL, NULL, 688.00, NULL, 53, 5, 2, 1, '1590', NULL, 1, 10, 1, '2024-04-22 12:48:50', '2024-04-22 12:48:50'),
(45, 'Abbigail Dicki', 'abbigail-dicki', NULL, NULL, NULL, NULL, 943.00, NULL, 53, 5, 6, 1, '2067', NULL, 1, 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(46, 'Dr. Valentin Kerluke', 'dr-valentin-kerluke', NULL, NULL, NULL, NULL, 209.00, NULL, 53, 6, 2, 1, '3782', NULL, 1, 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(47, 'Astrid Ratke', 'astrid-ratke', NULL, NULL, NULL, NULL, 180.00, NULL, 53, 6, 7, 1, '9508', NULL, 1, 10, 1, '2024-04-22 12:48:51', '2024-04-22 12:48:51'),
(48, 'Giovanny Dach', 'giovanny-dach', '<p>jioksfopdsjfhuidfhoipashdiofpahsdiof</p>', '<p>nkldmsfl\';dsml;fsd;lfm;ldsmf;</p>', '<p>guioshuaiohasuiuioashfuoiahsfiouadsf</p>', NULL, 375.00, 45666.00, 53, NULL, 7, 1, '1234', NULL, 1, 10, 1, '2024-04-22 12:48:52', '2024-05-26 19:49:04'),
(50, 'jioewjrkl;akewrl;', 'jioewjrkl;akewrl;', '<p>nkdald;fnm\'lk;admdfl\'madsf;l;aff</p>', '<p>\'mnkl;wdfc;lasmfc\'pkmals;,c l;anxmclk;a</p>', '<p>kml;sdvm,p[</p><p>kpfc[k\'w,lfp[</p><p><br></p><p>;,ervcdpnov mvcpwomrv</p><p>;W\":&lt;v<br><br></p>', NULL, 100.00, NULL, 52, 5, 7, 1, 'l;dmfa;l', '88888', 1, 4235, 1, '2024-05-26 19:56:44', '2024-05-26 19:56:44'),
(51, 'hockey', 'hockey', '<p>sssssssssssssssssssssssssssssssssssssssssssss</p>', '<p>dddddddddddddddddddddddddddd</p>', '<p>szzzzssssssssssssssssssssssssssssss</p>', '20', 400.00, 500.00, 53, NULL, 8, 0, 'ssssssssssssss', '4567', 1, 4, 1, '2024-08-22 03:54:13', '2024-08-22 03:54:13');

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
(15, 13, '13--1712805426.1712805398.jpeg', NULL, '2024-04-10 22:17:06', '2024-04-10 22:17:06'),
(16, 13, '13--1712805427.1712805401.jpg', NULL, '2024-04-10 22:17:07', '2024-04-10 22:17:07'),
(17, 14, '14--1712808370.1712808321.jpg', NULL, '2024-04-10 23:06:10', '2024-04-10 23:06:10'),
(18, 15, '15--1712808494.1712808468.jpeg', NULL, '2024-04-10 23:08:14', '2024-04-10 23:08:14'),
(19, 15, '15--1712808495.1712808475.jpg', NULL, '2024-04-10 23:08:15', '2024-04-10 23:08:15'),
(20, 16, '16--1712809093.1712809050.jpg', NULL, '2024-04-10 23:18:13', '2024-04-10 23:18:13'),
(21, 16, '16--1712809094.1712809057.jpg', NULL, '2024-04-10 23:18:14', '2024-04-10 23:18:14'),
(22, 17, '17--1712814525.1712814497.jpeg', NULL, '2024-04-11 00:48:45', '2024-04-11 00:48:45'),
(24, 50, '50--1716771404.1716771388.jpg', NULL, '2024-05-26 19:56:44', '2024-05-26 19:56:44'),
(25, 12, '12--1723649382.PNG', NULL, '2024-08-14 10:29:42', '2024-08-14 10:29:42'),
(26, 51, '51--1724316853.1724316800.jpeg', NULL, '2024-08-22 03:54:13', '2024-08-22 03:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `product_id`, `username`, `email`, `comment`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 19, 'Muhammad Sheharyar Asif', 'msheharyar76@gmail.com', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 3.00, 0, '2024-08-13 21:12:11', '2024-08-13 21:12:11'),
(2, 35, 'Muhammad Sheharyar Asif', 'msheharyar76@gmail.com', 'ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc', 5.00, 0, '2024-08-14 10:47:45', '2024-08-14 10:47:45'),
(3, 27, 'Muhammad Sheharyar', 'shery0597@gmail.com', 'this product is good', 4.00, 0, '2024-08-19 11:46:30', '2024-08-19 11:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`id`, `country_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, '3', 45.00, '2024-08-17 22:19:03', '2024-08-17 22:19:03');

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
(81, '1712814579.jpg', '2024-04-11 00:49:39', '2024-04-11 00:49:39'),
(82, '1716729951.jpg', '2024-05-26 08:25:51', '2024-05-26 08:25:51'),
(83, '1716771388.jpg', '2024-05-26 19:56:28', '2024-05-26 19:56:28'),
(84, '1724316114.jpg', '2024-08-22 03:41:54', '2024-08-22 03:41:54'),
(85, '1724316636.jpg', '2024-08-22 03:50:36', '2024-08-22 03:50:36'),
(86, '1724316800.jpeg', '2024-08-22 03:53:20', '2024-08-22 03:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `github_id`, `facebook_id`, `token`, `google_id`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'msheharyar76@gmail.com', NULL, NULL, NULL, NULL, NULL, 2, NULL, '$2y$12$i1VIOE0CW.S4feLhhAtHwOlPq.zBeVs/4R1A1HbpRsVlJKTV2NFpy', NULL, '2024-03-21 10:33:23', '2024-03-21 10:33:23'),
(6, 'Muhammad Sheharyar Asif', 'msheharyar678676@gmail.com', '03175038179', NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$D/1YwLyrm9EPvmRkYdQJqO6z/RJP4xRzs3G2ppWwx8iw0kQieG93O', NULL, '2024-06-08 21:49:03', '2024-06-08 21:49:03'),
(7, 'Muhammad Sheharyar Asif', 'sp21-7897389010@cuiatk.edu.pk', '03175038179', NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$NOqi9iszpOgNnfQvLWCmtOlODQYT/7ay7lLO8/AUc1GXiNxeYgUMm', NULL, '2024-06-08 21:52:04', '2024-06-08 21:52:04'),
(8, 'Muhammad Sheharyar Asif', 'msheharyar78947976@gmail.com', '175038179940785', NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$xqQWdZ.ct6PnQPxdl0RbA.7ckrpVK968x5u0YwqEMvFbzlaE8bP7G', NULL, '2024-06-09 01:49:55', '2024-06-09 01:49:55'),
(9, 'Ali', 'msheharyar678937590776@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$XdLAvOD2tGioONEAqifeX.6JaHCWTtkvP97sUgIrsaP6bFbZwJM1S', NULL, '2024-06-09 01:50:33', '2024-06-09 01:50:33'),
(10, 'ahmed', 'msheharyar78948983087839076@gmail.com', '78495-28-p3844', NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$8cB135T73YrMr1XjPId3lOCRbXBwYHheluPCL01VulpmicHQ1viP2', NULL, '2024-06-09 02:01:45', '2024-06-09 02:01:45'),
(11, 'Muhammad Sheharyar Asif', 'msheharyar77630985265387954795646@gmail.com', '03175038179', NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$X/Id6q2sxIMiktXT6itUluFYbSmkYH9iyxnwX0ELlM0LOc9fpV49G', NULL, '2024-06-09 02:03:06', '2024-06-09 02:03:06'),
(12, 'Asad Ali', 'msheharyar786@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$8c.JJWN7yHpr/lp67whtKurdk735kp2Z3b2mW.AUoNQnoqyIUz9f2', NULL, '2024-06-09 08:10:46', '2024-06-09 08:10:46'),
(13, 'shery', 'msheharyar67868776@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$JW42MYlUPkygbr7mw3dmYO3pp5B36uYrW9IegwSVua3gwMIGeyivO', NULL, '2024-07-21 12:17:33', '2024-07-21 12:17:33'),
(21, 'Muhammad Sheharyar Asif', 'sp21-rcs-010@cuiatk.edu.pk', NULL, NULL, NULL, 'ya29.a0AXooCgtzQF3Pk8en7osilUMrOG82Xh2cKR8lvlIItEV9JOP83emzmcd3e13396qFLemyU9kWDW-6y50WER9jppjr5xmkmx7YLoUSLMzgcRpTYklQbW8j94jazDrTQXs1DPMERWzK4rEYMRNi4_-p2xNpGbz_o-M_4QaCgYKAZkSARESFQHGX2MiHYAonQrz639Gsgu0SZXX6Q0169', '117954621993009938682', 1, NULL, '$2y$12$IEfypLTY8gI5I4fq9kEFVegKAiLv/rMBEP0Uh8UqdP9glDZK2kdKS', NULL, '2024-07-26 23:58:10', '2024-07-26 23:58:10'),
(22, 'Noor ul Huda', 'hudaasiff2003@gmail.com', NULL, NULL, NULL, 'ya29.a0AXooCgtc26hd7I_FP6Ef01juvwtUUCupxWtFTbYMvF0pYAMRNriWL-_WdEUiNyPbxfnE_5f9C5GZsFvXowxrBXPZ83I0GiiirL2H70qeexmvkleR8EKgpctNIXTXJyVHQH6qFIpeqSjSl2vk2ENecy4GsYAVMdk9wDIaCgYKAeQSARISFQHGX2MiihaUE_7pSOUB8_t0qrjV5A0170', '113952046934904582836', 1, NULL, '$2y$12$r2UPXV0zGznEYk8CMuSn7OBkjazFiIkYoNKpkZhvbrBfmgOQmkEXG', NULL, '2024-07-27 21:55:21', '2024-07-27 21:55:21'),
(23, 'MuHAmmaD SHehRyar asif', 'msheharyar76786897@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$e2hlSxqQCnT.SBMdMX.Ss.fsrlEGKYPs5pvv.3OIHz2sp1mNvpP0u', NULL, '2024-08-05 11:51:57', '2024-08-05 11:51:57'),
(24, 'MuHAmmaD SHehRyar asif', 'msheharyar7433456@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$12$O3TSpUiGIKTAGRax5JT4ruDYd3nJAaVREad77sKQJXE5C8XbfEdAa', NULL, '2024-08-05 11:54:59', '2024-08-05 11:54:59'),
(25, 'Muhammad Sheharyar', 'shery0597@gmail.com', NULL, NULL, NULL, 'ya29.a0AcM612wwEmCmqHoUY6fWoDQV9N5BxBc1EFdCM1CfbS90KvoDIOuLJtEL2aKahl2KUfBUSjqHqUyzSLFSQ__ADo4c8PGnpFCLS5EZawNwZfgy9yviTwXaMgnUFutOQVoIEP0Nz3VsRbHAmnu7fw6lNUL6jHuRlP0QLYFgaCgYKAWQSARISFQHGX2Mi64KTjXHK68z4eON3YNZd7g0171', '107196562319021049348', 1, NULL, '$2y$12$Or5Ic9P74Ov2YvLbFEmqHO8I4NX6UujE5TwS4Q87pnQBTPEu1kRbG', NULL, '2024-08-05 11:59:30', '2024-08-05 11:59:30'),
(26, 'Tayyba Qandeel', 'tayyba1998@gmail.com', NULL, NULL, NULL, 'ya29.a0AcM612ye5VUhKawSCjQ16XFf9CdvU-5p1yC5yiFtbL1CNv1Ie9SJKqhvYARvDntgnfuDdncA6n_bIZsjOoUNgHk0AEtLANPTQ4HMrC6pIVbzMgHw7HVlb6ZhXpww5rViq4yXjX7ncewV2abk2fFDW5nxq9bi7FdNP4GbaCgYKAWUSARESFQHGX2Mi09aBF9_jcKzTOci8Y1H_7Q0171', '115049555975493318781', 1, NULL, '$2y$12$FSKCg9y8JlMfRU2UbPoANOEXLeA.Eu6dB5kQ8fhG17CFxax33NmGe', NULL, '2024-08-05 19:27:09', '2024-08-05 19:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(11, 21, 15, '2024-07-28 08:28:39', '2024-07-28 08:28:39'),
(12, 21, 12, '2024-07-28 08:30:09', '2024-07-28 08:30:09'),
(13, 21, 22, '2024-08-04 11:58:24', '2024-08-04 11:58:24'),
(14, 25, 50, '2024-08-05 11:59:45', '2024-08-05 11:59:45'),
(15, 25, 20, '2024-08-05 12:05:20', '2024-08-05 12:05:20'),
(16, 26, 19, '2024-08-05 19:27:18', '2024-08-05 19:27:18'),
(17, 26, 42, '2024-08-05 20:11:59', '2024-08-05 20:11:59'),
(18, 26, 38, '2024-08-05 20:20:27', '2024-08-05 20:20:27'),
(19, 26, 30, '2024-08-05 20:22:41', '2024-08-05 20:22:41'),
(20, 26, 24, '2024-08-05 20:24:15', '2024-08-05 20:24:15'),
(21, 26, 50, '2024-08-05 20:24:21', '2024-08-05 20:24:21'),
(22, 26, 39, '2024-08-05 20:25:55', '2024-08-05 20:25:55'),
(23, 26, 40, '2024-08-05 20:26:24', '2024-08-05 20:26:24');

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
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_user_id_foreign` (`user_id`),
  ADD KEY `customer_addresses_country_id_foreign` (`country_id`);

--
-- Indexes for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_country_id_foreign` (`country_id`);

--
-- Indexes for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_items_order_id_foreign` (`order_id`),
  ADD KEY `orders_items_product_id_foreign` (`product_id`);

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
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_product_id_foreign` (`product_id`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders_items`
--
ALTER TABLE `orders_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `customer_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD CONSTRAINT `orders_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orders_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

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
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
