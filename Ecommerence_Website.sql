-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 11, 2026 at 04:56 PM
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
-- Database: `Ecommerence_Website`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `en_name_translation`, `ur_name_translation`, `name_translations`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Gucci', 'Gucciiii', 'گوچی', '{\n  \"en\": \"Gucci\",\n  \"ur\": \"گوچی\"\n}\n', 'Gucci', '1', '2025-02-11 05:28:28', '2025-02-11 05:28:40'),
(3, 'J.', 'J.', 'جے', '{\n  \"en\": \"J.\",\n  \"ur\": \"جے۔\"\n}\n', 'J.', '1', '2025-10-18 21:52:12', '2025-10-18 21:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) NOT NULL,
  `discounted_value` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `additional_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `size_id`, `color_id`, `user_id`, `product_attribute_id`, `title`, `quantity`, `price`, `discounted_price`, `discounted_value`, `product_image`, `additional_attributes`, `created_at`, `updated_at`) VALUES
(45, 26, 0, 0, 3, 26, 'Giovanny Dach', 4, 1600.00, 0.00, '0', 'Screenshot from 2025-02-11 16-57-04-26--1739353421.png', '\"{\\\"size\\\":null,\\\"color\\\":null}\"', '2025-12-17 01:46:02', '2025-12-17 01:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `cart_coupon_amounts`
--

CREATE TABLE `cart_coupon_amounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `original_total` decimal(10,2) NOT NULL,
  `discounted_total` decimal(10,2) NOT NULL,
  `coupon_amount` decimal(10,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `en_name_translation`, `ur_name_translation`, `name_translations`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Clothes', 'Clothes', 'کپڑے', '{\"en\":\"Clothes\",\"ur\":\"\\u06a9\\u067e\\u0691\\u06d2\"}', 'Clothes', '1-1760841547.jpg', '1', '2024-12-22 09:27:49', '2025-12-16 05:41:23'),
(4, 'Women', 'Women', 'خواتین', '{\"en\":\"Women\",\"ur\":\"\\u062e\\u0648\\u0627\\u062a\\u06cc\\u0646\"}', 'Women', '.jpeg', '1', '2025-10-17 00:18:01', '2025-12-16 05:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `name`, `status`, `price`, `product_id`, `value`, `created_at`, `updated_at`, `size_id`) VALUES
(1, 'black', '1', '400', '2', '#000000', '2025-01-01 07:52:24', '2025-10-28 06:46:35', '6'),
(2, 'Light Grey', '1', '500', '2', '#e4e2e2', '2025-01-08 00:44:41', '2025-10-28 05:39:26', '6'),
(3, 'White', '1', '600', '5', '#fbf4f4', '2025-01-08 00:45:12', '2025-11-08 22:16:16', ''),
(7, 'red', '1', '390', '5', '#f90606', '2025-05-14 08:05:24', '2025-11-08 22:14:02', ''),
(8, 'red', '1', '390', '0', '#d50707', '2025-05-14 08:07:13', '2025-05-14 08:08:24', '9'),
(10, 'green', '1', '490', '2', '#07502e', '2025-05-14 08:10:21', '2025-10-28 06:47:21', '9');

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
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `exchange_rate` decimal(15,8) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `exchange_rate`, `logo`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 'US Dollar', 'USD', '$', 1.00000000, NULL, 1, 0, '2026-01-30 07:06:51', '2026-02-04 05:45:47'),
(3, 'Pakistani Rupee', 'PKR', '₨', 280.00000000, NULL, 1, 0, '2026-01-30 07:06:51', '2026-02-04 05:46:00'),
(4, 'Euro', 'EUR', '€', 0.92000000, NULL, 1, 1, '2026-01-30 07:06:51', '2026-02-04 05:46:00'),
(5, 'British Pound', 'GBP', '£', 0.79000000, NULL, 1, 0, '2026-01-30 07:06:51', '2026-02-03 01:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `en_firstname_translation` varchar(255) DEFAULT NULL,
  `ur_firstname_translation` varchar(255) DEFAULT NULL,
  `firstname_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`firstname_translations`)),
  `lastname` varchar(255) NOT NULL,
  `en_lastname_translation` varchar(255) DEFAULT NULL,
  `ur_lastname_translation` varchar(255) DEFAULT NULL,
  `lastname_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lastname_translations`)),
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `flat` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `en_address_translation` varchar(255) DEFAULT NULL,
  `ur_address_translation` varchar(255) DEFAULT NULL,
  `address_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`address_translations`)),
  `city` varchar(255) NOT NULL,
  `en_city_translation` varchar(255) DEFAULT NULL,
  `ur_city_translation` varchar(255) DEFAULT NULL,
  `city_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`city_translations`)),
  `state` varchar(255) NOT NULL,
  `en_state_translation` varchar(255) DEFAULT NULL,
  `ur_state_translation` varchar(255) DEFAULT NULL,
  `state_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`state_translations`)),
  `zip` varchar(255) NOT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `address_type` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `firstname`, `en_firstname_translation`, `ur_firstname_translation`, `firstname_translations`, `lastname`, `en_lastname_translation`, `ur_lastname_translation`, `lastname_translations`, `email`, `mobile`, `country_id`, `apartment`, `flat`, `area`, `landmark`, `address`, `en_address_translation`, `ur_address_translation`, `address_translations`, `city`, `en_city_translation`, `ur_city_translation`, `city_translations`, `state`, `en_state_translation`, `ur_state_translation`, `state_translations`, `zip`, `pin_code`, `address_type`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 2, 'Muhammad', '', 'محمد شہریار', '{\"en\":\"Muhammad\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f\"}', 'Asif', '', 'آصف', '{\"en\":\"Asif\",\"ur\":\"\\u0622\\u0635\\u0641\"}', 'msheharyar76@gmail.com', '03175038179', 164, 'kkk', 'kkk', 'Village Post Office Hattian Saiden Tehsil Hazro District Attock', 'kkkkk', 'Village Post Office Hattian Saiden Tehsil Hazro District Attock', NULL, 'گاؤں، ڈاک خانہ ہٹیاں سیدن، تحصیل حضرو، ضلع اٹک', '{\"en\":\"Village Post Office Hattian Saiden Tehsil Hazro District Attock\",\"ur\":\"\\u06af\\u0627\\u0624\\u06ba \\u0688\\u0627\\u06a9 \\u062e\\u0627\\u0646\\u06c1 Hattian Saiden \\u062a\\u062d\\u0635\\u06cc\\u0644 Hazro District \\u0627\\u0679\\u06a9\"}', 'Attock', NULL, 'اٹک', '{\"en\":\"Attock\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'Alabama', NULL, 'الاباما', '{\"en\":\"Alabama\",\"ur\":\"\\u0627\\u0644\\u0627\\u0628\\u0627\\u0645\\u0627\"}', '43580', '43580', 'home', 1, '2025-01-02 04:43:48', '2026-01-29 02:00:51'),
(3, 4, 'Muhammad', NULL, NULL, '{\"en\":\"Muhammad\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f\"}', 'Asif', NULL, NULL, '{\"en\":\"Asif\",\"ur\":\"\\u0622\\u0635\\u0641\"}', 'sp21-rcs-010@cuiatk.edu.pk', '03175038179', 164, NULL, NULL, NULL, NULL, 'Village Post Office Hattain Saiden Tehsil Hazro District Attock', NULL, NULL, '{\"en\":\"Village Post Office Hattain Saiden Tehsil Hazro District Attock\",\"ur\":\"\\u06af\\u0627\\u0624\\u06ba \\u0688\\u0627\\u06a9 \\u062e\\u0627\\u0646\\u06c1 Hattain Saiden \\u062a\\u062d\\u0635\\u06cc\\u0644 Hazro District \\u0627\\u0679\\u06a9\"}', 'Attock City', NULL, NULL, '{\"en\":\"Attock City\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'punjab', NULL, NULL, '{\"en\":\"punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43580', NULL, NULL, 0, '2025-02-13 00:35:21', '2025-02-13 00:35:21'),
(4, 5, 'Muhammad', NULL, NULL, '{\"en\":\"Muhammad\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f\"}', 'Asif', NULL, NULL, '{\"en\":\"Asif\",\"ur\":\"\\u0622\\u0635\\u0641\"}', 'sp21-rcs-010@cuiatk.edu.pk', '03175038179', 9, NULL, NULL, NULL, NULL, 'Hattian ,Attock, Rawalpindi, Pakistan', NULL, NULL, '{\"en\":\"Hattian ,Attock, Rawalpindi, Pakistan\",\"ur\":\"Hattian ,\\u0627\\u0679\\u06a9, \\u0631\\u0627\\u0648\\u0644\\u067e\\u0646\\u0688\\u06cc, \\u067e\\u0627\\u06a9\\u0633\\u062a\\u0627\\u0646\"}', 'Attock City', NULL, NULL, '{\"en\":\"Attock City\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'punjab', NULL, NULL, '{\"en\":\"punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43580', NULL, NULL, 0, '2025-04-16 01:45:15', '2025-04-16 01:46:09'),
(9, 15, 'Muhammad Sheharyar Asif', NULL, NULL, '{\"en\":\"Muhammad Sheharyar Asif\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', '', NULL, NULL, NULL, 'msheharyar7886@gmail.com', '876879', 4, NULL, 'mmmm', 'A.K Brohi Road G-11 Islamabad', NULL, 'A.K Brohi Road G-11 Islamabad', NULL, NULL, '{\"en\":\"A.K Brohi Road G-11 Islamabad\",\"ur\":\"A.K Brohi \\u0631\\u0648\\u0688 \\u062c\\u06cc-11 \\u0627\\u0633\\u0644\\u0627\\u0645 \\u0622\\u0628\\u0627\\u062f\"}', 'Attock City', NULL, NULL, '{\"en\":\"Attock City\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'punjab', NULL, NULL, '{\"en\":\"punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43600', '43600', 'home', 1, '2025-11-04 05:03:27', '2025-11-04 05:03:27'),
(14, 3, 'Muhammad Sheharyar', NULL, NULL, '{\"en\":\"Muhammad Sheharyar\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631\"}', '', NULL, NULL, NULL, 'shery0597@gmail.com', '', 164, NULL, 'kkkkkk', 'hdklsfjklsdjfklsdfjlkdsjfkldshfjkldsjflkdsfjlksdjfkldsjflkdsjfkldsjfklsdjf,', NULL, 'hdklsfjklsdjfklsdfjlkdsjfkldshfjkldsjflkdsfjlksdjfkldsjflkdsjfkldsjfklsdjf,', NULL, NULL, '{\"en\":\"hdklsfjklsdjfklsdfjlkdsjfkldshfjkldsjflkdsfjlksdjfkldsjflkdsjfkldsjfklsdjf,\",\"ur\":\"hdklsfjklsdjfklsdfjlkdsjfkldshfjkldsjflkdsfjlksdjfkldsjflkdsjfkldsjfklsdjf,\"}', 'Attock City', NULL, NULL, '{\"en\":\"Attock City\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'punjab', NULL, NULL, '{\"en\":\"punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43600', '43600', 'home', 1, '2025-11-14 02:05:49', '2025-11-19 01:49:19'),
(16, 3, 'Muhammad Sheharyar', NULL, NULL, '{\"en\":\"Muhammad Sheharyar\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631\"}', '', NULL, NULL, NULL, 'shery0597@gmail.com', '', 8, NULL, 'kkkkkk', 'VPO hattian Saiden', NULL, 'VPO hattian Saiden', NULL, NULL, '{\"en\":\"VPO hattian Saiden\",\"ur\":\"\\u0648\\u06cc \\u067e\\u06cc \\u0627\\u0648 hattian Saiden\"}', 'Attock City', NULL, NULL, '{\"en\":\"Attock City\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'punjab', NULL, NULL, '{\"en\":\"punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43600', '43600', 'home', 0, '2025-11-15 22:57:34', '2025-11-19 01:49:19'),
(19, 2, 'Muhammad Sheharyar Asif', NULL, NULL, '{\"en\":\"Muhammad Sheharyar Asif\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', '', NULL, NULL, NULL, 'msheharyar76@gmail.com', '03175038179', 164, NULL, 'iueouwoer', 'A.K brohi Road Islamabad', 'kkkkk', 'A.K brohi Road Islamabad', NULL, 'اے کے بروہی روڈ، اسلام آباد', '{\"en\":\"A.K brohi Road Islamabad\",\"ur\":\"A.K brohi \\u0631\\u0648\\u0688 \\u0627\\u0633\\u0644\\u0627\\u0645 \\u0622\\u0628\\u0627\\u062f\"}', 'Attock', NULL, NULL, '{\"en\":\"Attock\",\"ur\":\"\\u0627\\u0679\\u06a9\"}', 'Punjab', NULL, NULL, '{\"en\":\"Punjab\",\"ur\":\"\\u067e\\u0646\\u062c\\u0627\\u0628\"}', '43580', '43580', 'home', 0, '2025-11-25 12:00:14', '2026-01-29 02:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('1','0') DEFAULT NULL,
  `value` decimal(8,2) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_ids`)),
  `start_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `status`, `value`, `type`, `product_ids`, `category_ids`, `start_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, '40% off', '1', 40.00, 'percentage', '\"24,25,26\"', NULL, '2025-09-30 19:00:00', '2026-02-03 19:00:00', '2025-03-15 20:33:42', '2026-02-04 04:50:32'),
(5, '50 % off', '1', 50.00, 'percentage', '\"2,3,4\"', NULL, '2025-12-08 19:00:00', '2026-02-03 19:00:00', '2025-12-10 01:13:45', '2026-02-04 04:50:09');

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

--
-- Dumping data for table `discount_coupons`
--

INSERT INTO `discount_coupons` (`id`, `code`, `name`, `description`, `max_user`, `max_user_user`, `type`, `discont_amount`, `min_amount`, `status`, `start_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'ZU9MMQZ1', 'Discont token', NULL, 2, 4, 'percent', 20.00, 5.00, 1, '2025-04-08 06:03:00', '2025-04-25 06:03:00', '2025-04-16 01:03:08', '2025-04-16 01:03:08'),
(4, 'wewe3434', 'Fashion', NULL, 7, 7, 'fixed', 70.00, NULL, 1, '2025-11-26 05:16:00', '2025-11-29 05:16:00', '2025-11-14 00:16:38', '2025-11-25 02:35:23');

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

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(3, 'ec45ed6f-ab5e-48ae-abdc-56840ab9cc4d', 'database', 'default', '{\"uuid\":\"ec45ed6f-ab5e-48ae-abdc-56840ab9cc4d\",\"displayName\":\"App\\\\Listeners\\\\ProcessOrderItemsListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:39:\\\"App\\\\Listeners\\\\ProcessOrderItemsListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\OrderCreatedEvent\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:80;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"cartItems\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Cart\\\";s:2:\\\"id\\\";a:1:{i:0;i:36;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Order]. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:621\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(109): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(62): App\\Events\\OrderCreatedEvent->restoreModel()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesModels.php(93): App\\Events\\OrderCreatedEvent->getRestoredPropertyValue()\n#3 [internal function]: App\\Events\\OrderCreatedEvent->__unserialize()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(97): unserialize()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(60): Illuminate\\Queue\\CallQueuedHandler->getCommand()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#25 {main}', '2025-11-29 08:36:38'),
(4, '883dc0bc-6c3b-4ff9-a720-45e1eb014b6b', 'database', 'default', '{\"uuid\":\"883dc0bc-6c3b-4ff9-a720-45e1eb014b6b\",\"displayName\":\"App\\\\Listeners\\\\ProcessOrderItemsListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:39:\\\"App\\\\Listeners\\\\ProcessOrderItemsListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\OrderCreatedEvent\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:81;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"cartItems\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Cart\\\";s:2:\\\"id\\\";a:1:{i:0;i:36;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Order]. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:621\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(109): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(62): App\\Events\\OrderCreatedEvent->restoreModel()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesModels.php(93): App\\Events\\OrderCreatedEvent->getRestoredPropertyValue()\n#3 [internal function]: App\\Events\\OrderCreatedEvent->__unserialize()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(97): unserialize()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(60): Illuminate\\Queue\\CallQueuedHandler->getCommand()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#25 {main}', '2025-11-29 08:36:38'),
(5, 'ec47402b-8fa1-4604-ac49-1c6ca3b49f32', 'database', 'default', '{\"uuid\":\"ec47402b-8fa1-4604-ac49-1c6ca3b49f32\",\"displayName\":\"App\\\\Listeners\\\\ProcessOrderItemsListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:39:\\\"App\\\\Listeners\\\\ProcessOrderItemsListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\OrderCreatedEvent\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:83;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"cartItems\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Cart\\\";s:2:\\\"id\\\";a:1:{i:0;i:36;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Order]. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:621\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(109): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(62): App\\Events\\OrderCreatedEvent->restoreModel()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesModels.php(93): App\\Events\\OrderCreatedEvent->getRestoredPropertyValue()\n#3 [internal function]: App\\Events\\OrderCreatedEvent->__unserialize()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(97): unserialize()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(60): Illuminate\\Queue\\CallQueuedHandler->getCommand()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#25 {main}', '2025-12-03 01:54:40'),
(6, 'e4532be3-3d76-40b3-ac20-24d7ee9ab1f8', 'database', 'default', '{\"uuid\":\"e4532be3-3d76-40b3-ac20-24d7ee9ab1f8\",\"displayName\":\"App\\\\Listeners\\\\ProcessOrderItemsListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:39:\\\"App\\\\Listeners\\\\ProcessOrderItemsListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\OrderCreatedEvent\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:84;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"cartItems\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Cart\\\";s:2:\\\"id\\\";a:1:{i:0;i:36;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Order]. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:621\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(109): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesAndRestoresModelIdentifiers.php(62): App\\Events\\OrderCreatedEvent->restoreModel()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/SerializesModels.php(93): App\\Events\\OrderCreatedEvent->getRestoredPropertyValue()\n#3 [internal function]: App\\Events\\OrderCreatedEvent->__unserialize()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(97): unserialize()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(60): Illuminate\\Queue\\CallQueuedHandler->getCommand()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#25 {main}', '2025-12-03 01:54:40'),
(7, 'e5f17a95-a78a-474c-8b9b-74bd74820d9b', 'database', 'default', '{\"uuid\":\"e5f17a95-a78a-474c-8b9b-74bd74820d9b\",\"displayName\":\"App\\\\Listeners\\\\UpdateOrderPaymentListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:40:\\\"App\\\\Listeners\\\\UpdateOrderPaymentListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:34:\\\"App\\\\Events\\\\OrderPaymentUpdateEvent\\\":3:{s:7:\\\"orderId\\\";s:2:\\\"92\\\";s:11:\\\"paymentInfo\\\";a:2:{s:14:\\\"transaction_id\\\";s:27:\\\"pi_3SaAC7Hy0U8qxro01zROiFLx\\\";s:6:\\\"status\\\";s:9:\\\"completed\\\";}s:13:\\\"paymentMethod\\\";s:6:\\\"Stripe\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'PDOException: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'payment_approve_date\' in \'field list\' in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php:608\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(608): PDO->prepare()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(816): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(600): Illuminate\\Database\\Connection->run()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(552): Illuminate\\Database\\Connection->affectingStatement()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(3602): Illuminate\\Database\\Connection->update()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1061): Illuminate\\Database\\Query\\Builder->update()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1214): Illuminate\\Database\\Eloquent\\Builder->update()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1131): Illuminate\\Database\\Eloquent\\Model->performUpdate()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/app/Listeners/UpdateOrderPaymentListener.php(32): Illuminate\\Database\\Eloquent\\Model->save()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Events/CallQueuedListener.php(114): App\\Listeners\\UpdateOrderPaymentListener->handle()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#34 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#35 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#36 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#37 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#38 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#39 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#40 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#41 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#42 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#43 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#44 {main}\n\nNext Illuminate\\Database\\QueryException: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'payment_approve_date\' in \'field list\' (Connection: mysql, SQL: update `orders` set `payment_status` = completed, `stripe_charge_id` = pi_3SaAC7Hy0U8qxro01zROiFLx, `payment_method` = Stripe, `payment_approve_date` = 2025-12-03 07:09:53, `orders`.`updated_at` = 2025-12-03 07:09:53 where `id` = 92) in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php:829\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(600): Illuminate\\Database\\Connection->run()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(552): Illuminate\\Database\\Connection->affectingStatement()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(3602): Illuminate\\Database\\Connection->update()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1061): Illuminate\\Database\\Query\\Builder->update()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1214): Illuminate\\Database\\Eloquent\\Builder->update()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1131): Illuminate\\Database\\Eloquent\\Model->performUpdate()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/app/Listeners/UpdateOrderPaymentListener.php(32): Illuminate\\Database\\Eloquent\\Model->save()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Events/CallQueuedListener.php(114): App\\Listeners\\UpdateOrderPaymentListener->handle()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#34 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#35 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#36 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#37 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#38 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#39 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#40 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#41 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#42 {main}', '2025-12-03 02:09:53');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(8, '6be9162d-25f0-41f0-801c-caa20a1f3f73', 'database', 'default', '{\"uuid\":\"6be9162d-25f0-41f0-801c-caa20a1f3f73\",\"displayName\":\"App\\\\Listeners\\\\UpdateOrderPaymentListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:40:\\\"App\\\\Listeners\\\\UpdateOrderPaymentListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:34:\\\"App\\\\Events\\\\OrderPaymentUpdateEvent\\\":3:{s:7:\\\"orderId\\\";s:2:\\\"94\\\";s:11:\\\"paymentInfo\\\";a:2:{s:14:\\\"transaction_id\\\";s:27:\\\"pi_3SasLRHy0U8qxro00wFgVemh\\\";s:6:\\\"status\\\";s:9:\\\"completed\\\";}s:13:\\\"paymentMethod\\\";s:6:\\\"Stripe\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'PDOException: SQLSTATE[01000]: Warning: 1265 Data truncated for column \'payment_status\' at row 1 in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php:612\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(612): PDOStatement->execute()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(816): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(600): Illuminate\\Database\\Connection->run()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(552): Illuminate\\Database\\Connection->affectingStatement()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(3602): Illuminate\\Database\\Connection->update()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1061): Illuminate\\Database\\Query\\Builder->update()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1214): Illuminate\\Database\\Eloquent\\Builder->update()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1131): Illuminate\\Database\\Eloquent\\Model->performUpdate()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/app/Listeners/UpdateOrderPaymentListener.php(31): Illuminate\\Database\\Eloquent\\Model->save()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Events/CallQueuedListener.php(114): App\\Listeners\\UpdateOrderPaymentListener->handle()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#34 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#35 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#36 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#37 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#38 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#39 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#40 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#41 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#42 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#43 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#44 {main}\n\nNext Illuminate\\Database\\QueryException: SQLSTATE[01000]: Warning: 1265 Data truncated for column \'payment_status\' at row 1 (Connection: mysql, SQL: update `orders` set `payment_status` = completed, `stripe_charge_id` = pi_3SasLRHy0U8qxro00wFgVemh, `payment_method` = Stripe, `orders`.`updated_at` = 2025-12-05 06:18:26 where `id` = 94) in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php:829\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(600): Illuminate\\Database\\Connection->run()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Connection.php(552): Illuminate\\Database\\Connection->affectingStatement()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(3602): Illuminate\\Database\\Connection->update()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1061): Illuminate\\Database\\Query\\Builder->update()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1214): Illuminate\\Database\\Eloquent\\Builder->update()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1131): Illuminate\\Database\\Eloquent\\Model->performUpdate()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/app/Listeners/UpdateOrderPaymentListener.php(31): Illuminate\\Database\\Eloquent\\Model->save()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Events/CallQueuedListener.php(114): App\\Listeners\\UpdateOrderPaymentListener->handle()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#34 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#35 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#36 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#37 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#38 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#39 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#40 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#41 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#42 {main}', '2025-12-05 01:18:26'),
(9, '6d5b2022-980f-4f5a-85b6-41ac06a68afb', 'database', 'default', '{\"uuid\":\"6d5b2022-980f-4f5a-85b6-41ac06a68afb\",\"displayName\":\"App\\\\Events\\\\NewTrade\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:19:\\\"App\\\\Events\\\\NewTrade\\\":1:{s:5:\\\"trade\\\";s:16:\\\"This is message!\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Broadcasting\\BroadcastException: Pusher error: cURL error 7: Failed to connect to 127.0.0.1 port 6001 after 0 ms: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for http://127.0.0.1:6001/apps/12345/events?auth_key=ABCDE&auth_timestamp=1765082357&auth_version=1.0&body_md5=c6faccefa9592c8947b4be40e9b59cbc&auth_signature=d13b263bd3a7f582d865e2115e94df988f95e2c8904872787848b62a1f1dec6b. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/Broadcasters/PusherBroadcaster.php:164\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/BroadcastEvent.php(92): Illuminate\\Broadcasting\\Broadcasters\\PusherBroadcaster->broadcast()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Broadcasting\\BroadcastEvent->handle()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#34 {main}', '2025-12-06 23:39:17'),
(10, 'edf96443-b438-41db-8da9-5af74dea243f', 'database', 'default', '{\"uuid\":\"edf96443-b438-41db-8da9-5af74dea243f\",\"displayName\":\"App\\\\Events\\\\NewTrade\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:19:\\\"App\\\\Events\\\\NewTrade\\\":1:{s:5:\\\"trade\\\";s:16:\\\"This is message!\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Broadcasting\\BroadcastException: Pusher error: cURL error 7: Failed to connect to 127.0.0.1 port 6001 after 0 ms: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for http://127.0.0.1:6001/apps/12345/events?auth_key=ABCDE&auth_timestamp=1770794332&auth_version=1.0&body_md5=c6faccefa9592c8947b4be40e9b59cbc&auth_signature=34895392a8419db362b098d27d05d589522bd02b243728fc06c4fe4e3da47f08. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/Broadcasters/PusherBroadcaster.php:164\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/BroadcastEvent.php(92): Illuminate\\Broadcasting\\Broadcasters\\PusherBroadcaster->broadcast()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Broadcasting\\BroadcastEvent->handle()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#34 {main}', '2026-02-11 02:18:52'),
(11, '2c00accc-a292-436a-b665-88c700032ee2', 'database', 'default', '{\"uuid\":\"2c00accc-a292-436a-b665-88c700032ee2\",\"displayName\":\"App\\\\Events\\\\NewTrade\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:19:\\\"App\\\\Events\\\\NewTrade\\\":1:{s:5:\\\"trade\\\";s:16:\\\"This is message!\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Broadcasting\\BroadcastException: Pusher error: cURL error 7: Failed to connect to 127.0.0.1 port 6001 after 0 ms: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for http://127.0.0.1:6001/apps/12345/events?auth_key=ABCDE&auth_timestamp=1770794335&auth_version=1.0&body_md5=c6faccefa9592c8947b4be40e9b59cbc&auth_signature=30d11c3513ceb64d843988a131ec948457ed0f4d6537ddc03f0ec33bc59a0c09. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/Broadcasters/PusherBroadcaster.php:164\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/BroadcastEvent.php(92): Illuminate\\Broadcasting\\Broadcasters\\PusherBroadcaster->broadcast()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Broadcasting\\BroadcastEvent->handle()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#34 {main}', '2026-02-11 02:18:55'),
(12, 'ac88f85f-d277-456b-8df6-0f52bc8183c9', 'database', 'default', '{\"uuid\":\"ac88f85f-d277-456b-8df6-0f52bc8183c9\",\"displayName\":\"App\\\\Events\\\\NewTrade\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:19:\\\"App\\\\Events\\\\NewTrade\\\":1:{s:5:\\\"trade\\\";s:16:\\\"This is message!\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'Illuminate\\Broadcasting\\BroadcastException: Pusher error: cURL error 7: Failed to connect to 127.0.0.1 port 6001 after 0 ms: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for http://127.0.0.1:6001/apps/12345/events?auth_key=ABCDE&auth_timestamp=1770794446&auth_version=1.0&body_md5=c6faccefa9592c8947b4be40e9b59cbc&auth_signature=07012de1bd25d29944354c1520b51b83c597486daa75d9f62a048d646b18a070. in /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/Broadcasters/PusherBroadcaster.php:164\nStack trace:\n#0 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Broadcasting/BroadcastEvent.php(92): Illuminate\\Broadcasting\\Broadcasters\\PusherBroadcaster->broadcast()\n#1 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Broadcasting\\BroadcastEvent->handle()\n#2 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#4 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#5 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#6 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#7 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#8 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#9 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#10 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(123): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#11 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#12 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#13 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#15 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#16 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(389): Illuminate\\Queue\\Worker->process()\n#18 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(176): Illuminate\\Queue\\Worker->runJob()\n#19 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(137): Illuminate\\Queue\\Worker->daemon()\n#20 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(120): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#21 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#24 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#25 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Container/Container.php(662): Illuminate\\Container\\BoundMethod::call()\n#26 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#27 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Command/Command.php(326): Illuminate\\Console\\Command->execute()\n#28 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#29 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(1096): Illuminate\\Console\\Command->run()\n#30 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand()\n#31 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/symfony/console/Application.php(175): Symfony\\Component\\Console\\Application->doRun()\n#32 /home/sheharyar/Documents/GitHub/Laravel_Shop/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(201): Symfony\\Component\\Console\\Application->run()\n#33 /home/sheharyar/Documents/GitHub/Laravel_Shop/artisan(28): Illuminate\\Foundation\\Console\\Kernel->handle()\n#34 {main}', '2026-02-11 02:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_labels`
--

CREATE TABLE `homepage_labels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label_key` varchar(255) NOT NULL,
  `label_name` varchar(255) NOT NULL,
  `en_label_name` varchar(255) NOT NULL,
  `ur_label_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `homepage_labels`
--

INSERT INTO `homepage_labels` (`id`, `label_key`, `label_name`, `en_label_name`, `ur_label_name`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'tending_now', 'Trending now', '', 'اس وقت مقبول', 0, 0, '2025-12-06 00:21:34', '2025-12-06 00:21:45'),
(2, 'latest', 'Latest', '', 'تازہ ترین', 1, 0, '2025-12-06 00:22:27', '2025-12-06 00:22:55'),
(3, 'top_rated', 'Top Rated', '', 'اعلیٰ درجہ یافتہ', 1, 0, '2025-12-06 00:22:48', '2025-12-06 00:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `is_default` smallint(6) NOT NULL DEFAULT 0,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `Isocode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `en_name_translation`, `ur_name_translation`, `is_default`, `name_translations`, `slug`, `Isocode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', NULL, 'انگریزی', 0, '{\"en\":\"English\",\"ur\":\"\\u0627\\u0646\\u06af\\u0631\\u06cc\\u0632\\u06cc\"}', 'English', 'en', '1', '2024-12-22 09:28:04', '2026-02-11 02:33:47'),
(3, 'Urdu', NULL, 'اردو', 0, '{\"en\":\"Urdu\",\"ur\":\"\\u0627\\u0631\\u062f\\u0648\"}', 'Urdu', 'ur', '1', '2025-05-13 01:00:10', '2026-02-11 02:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message_content` text NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_content`, `read_status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Asslam o ALikam', 0, '2025-01-04 11:42:44', '2025-01-04 11:42:44');

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
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_03_23_031819_create_categories_table', 1),
(7, '2024_03_25_161302_create_temp_images_table', 1),
(8, '2024_03_27_130833_create_sub_categories_table', 1),
(9, '2024_03_30_155300_create_brands_table', 1),
(10, '2024_03_31_144135_create_products_table', 1),
(11, '2024_03_31_144207_create_product_images_table', 1),
(12, '2024_04_12_130053_update_products_table', 1),
(13, '2024_05_26_133328_alter_products_table', 1),
(14, '2024_06_07_055028_alter_users_table', 1),
(15, '2024_06_10_053603_create_countries_table', 1),
(16, '2024_06_11_045207_create_orders_table', 1),
(18, '2024_06_11_045345_create_customer_addresses_table', 1),
(19, '2024_06_12_051525_alter_customer_addresses_table', 1),
(20, '2024_06_14_043753_create_shipping_charges_table', 1),
(21, '2024_06_27_044136_create_discount_coupons_table', 1),
(22, '2024_07_27_145454_create_wishlists_table', 1),
(23, '2024_08_01_051150_create_languages_table', 1),
(24, '2024_08_07_055335_update_products_table', 1),
(25, '2024_08_08_050726_create_product_ratings_table', 1),
(26, '2024_08_17_134349_alter_orders_table', 1),
(27, '2024_08_19_051417_alter_orders_table', 1),
(28, '2024_08_31_132620_create_discounts_table', 1),
(29, '2024_08_31_163451_alter_discount_table', 1),
(30, '2024_08_31_171111_alter_discounts_table', 1),
(31, '2024_09_04_040558_create_color_table', 1),
(32, '2024_09_04_040609_create_size_table', 1),
(33, '2024_09_04_041302_alter_color_table', 1),
(34, '2024_09_04_041312_alter_size_table', 1),
(35, '2024_09_08_124840_create_stocks_table', 1),
(36, '2024_09_09_003511_alter_table_product', 1),
(37, '2024_09_09_004546_drop_column_from_table', 1),
(38, '2024_09_10_031044_create_product_attributes_table', 1),
(39, '2024_09_18_050913_drop_table_name', 1),
(40, '2024_09_22_032736_alter_product_attributes_table', 1),
(41, '2024_09_22_033624_drop_product_attibute_colum', 1),
(43, '2024_10_06_053404_alter_users_table', 1),
(44, '2024_10_08_171505_alter_szie_table', 1),
(45, '2024_10_08_171804_alter_color_table', 1),
(46, '2024_10_08_172218_alter_product_table', 1),
(48, '2024_10_24_051903_alter_stock_table', 1),
(49, '2024_11_06_050107_create_messages_table', 1),
(50, '2024_11_19_161825_alter_users_table', 1),
(51, '2024_11_21_183417_alter_users_table', 1),
(52, '2024_12_09_172819_create_sub_sub_category_table', 1),
(53, '2024_12_16_080357_add_size_to_temp_images_table', 1),
(54, '2024_12_16_080539_add_size_to_product_images_table', 1),
(57, '2025_01_01_134116_alter_order_table', 2),
(59, '2024_06_11_045242_create_orders_items_table', 4),
(60, '2025_01_08_040236_create_product_view_table', 5),
(62, '2025_02_17_070856_alter_user_table', 7),
(64, '2025_03_05_052143_create-currencies-table', 8),
(68, '2025_03_18_043824_create_webservices_table', 10),
(69, '2025_03_18_154120_alter_webservices_table', 11),
(70, '2025_04_08_050129_create_promotions_table', 12),
(71, '2025_05_02_125321_alter_user_table', 13),
(72, '2025_05_12_045327_alter_color_table', 14),
(73, '2025_05_18_140130_create_table_onboarding', 15),
(74, '2025_06_12_162354_create_themes_table', 16),
(75, '2025_10_21_053717_alter_users_table_add_personal_details', 17),
(76, '2025_11_03_130054_add_extra_fields_to_addresses_table', 18),
(77, '2025_11_05_103348_add_likes_dislikes_to_reviews_table', 19),
(79, '2024_10_05_073005_create_cart_table', 20),
(80, '2025_11_20_072423_create_cart_coupon_amounts_table', 21),
(81, '2025_11_20_152746_add_discount_columns_to_orders_table', 22),
(82, '2025_11_25_075846_create_jobs_table', 23),
(83, '2025_12_03_064625_update_orders_table', 24),
(84, '2025_12_05_062728_alter-order-table', 25),
(85, '2025_12_06_050506_create-homelabel-table', 26),
(86, '2025_12_07_042349_alter-orderitem-table', 27),
(87, '2025_12_12_054302_add_color_size_to_wishlists_table', 28),
(88, '2025_12_16_071303_add_name_translations_to_brands_table', 29),
(90, '2025_12_16_095228_add_translations_to_products_table', 30),
(91, '2025_12_16_103634_add_name_translations_to_categories_table', 31),
(92, '2025_12_16_110726_add_name_translations_to_subcategories_table', 32),
(93, '2025_12_16_115838_add_translations_to_sub_sub_categories_table', 33),
(94, '2025_12_16_120706_add_name_translations_to_languages_table', 34),
(95, '2025_12_17_065209_add_translation_fields_to_users_table', 35),
(96, '2025_12_17_070545_add_translation_columns_to_addresses_table', 36),
(97, '2026_01_05_104142_add_discount_columns_to_orders_items_table', 37),
(98, '2026_01_21_104550_add_translation_columns_to_products_table', 38),
(99, '2026_01_21_114818_add_translation_to_brands', 39),
(100, '2026_01_21_115726_add_translation_to_categories', 40),
(101, '2026_01_21_120932_add_translation_to_sub_categories', 41),
(102, '2026_01_21_121428_add_translation_to_sub_sub_categories', 42),
(103, '2026_01_21_122132_add_translation_to_languages', 43),
(104, '2026_01_27_095743_add_translation_columns_to_users_table', 44),
(105, '2026_01_27_102043_add_translation_columns_to_customer_address_table', 45),
(106, '2026_01_29_064725_add_en_ur_translation_columns_to_orders_table', 46),
(107, '2026_01_30_063058_add_en_ur_translation_columns_to_homepage_labels_table', 47),
(108, '2026_01_30_115945_add_symbol_to_currencies_table', 48),
(109, '2026_02_02_100402_add_is_default_to_currencies_table', 49),
(110, '2026_02_10_094311_add_is_default_to_languages_table', 50),
(111, '2026_02_10_114943_update_is_default_column_in_languages_table', 51);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` double(10,2) NOT NULL,
  `shipping` double(10,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount_amount` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `product_discount_amount` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'not paid',
  `stripe_charge_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `Shipping_status` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_currency` varchar(10) DEFAULT NULL,
  `shipping_date` timestamp NULL DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `en_firstname_translation` varchar(255) DEFAULT NULL,
  `ur_firstname_translation` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `en_lastname_translation` varchar(255) DEFAULT NULL,
  `ur_lastname_translation` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `en_apartment_translation` varchar(255) DEFAULT NULL,
  `ur_apartment_translation` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `en_address_translation` text DEFAULT NULL,
  `ur_address_translation` text DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `en_city_translation` varchar(255) DEFAULT NULL,
  `ur_city_translation` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `en_state_translation` varchar(255) DEFAULT NULL,
  `ur_state_translation` varchar(255) DEFAULT NULL,
  `zip` varchar(255) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `en_notes_translation` text DEFAULT NULL,
  `ur_notes_translation` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `shipping`, `coupon_code`, `coupon_discount_amount`, `discount`, `product_discount_amount`, `grandtotal`, `payment_status`, `stripe_charge_id`, `status`, `Shipping_status`, `payment_method`, `payment_currency`, `shipping_date`, `firstname`, `en_firstname_translation`, `ur_firstname_translation`, `lastname`, `en_lastname_translation`, `ur_lastname_translation`, `email`, `country_id`, `apartment`, `en_apartment_translation`, `ur_apartment_translation`, `address`, `en_address_translation`, `ur_address_translation`, `city`, `en_city_translation`, `ur_city_translation`, `state`, `en_state_translation`, `ur_state_translation`, `zip`, `notes`, `en_notes_translation`, `ur_notes_translation`, `created_at`, `updated_at`) VALUES
(126, 2, 3200.00, 500.00, NULL, NULL, 0.00, 0.00, 3700.00, 'paid', '', 'delivered', NULL, 'COD', NULL, '2026-02-03 07:11:00', 'Muhammad', '', 'محمد شہریار', 'Asif', '', 'آصف', 'msheharyar76@gmail.com', 164, 'kkk', NULL, NULL, 'Village Post Office Hattian Saiden Tehsil Hazro District Attock', NULL, 'گاؤں، ڈاک خانہ ہٹیاں سیدن، تحصیل حضرو، ضلع اٹک', 'Attock', NULL, 'اٹک', 'Alabama', NULL, 'الاباما', '43580', NULL, NULL, NULL, '2026-02-11 01:59:08', '2026-02-11 02:11:11'),
(127, 2, 1400.00, 150.00, NULL, NULL, 0.00, 500.00, 1050.00, 'pending', '', 'pending', NULL, 'COD', NULL, NULL, 'Muhammad', '', 'محمد شہریار', 'Asif', '', 'آصف', 'msheharyar76@gmail.com', 164, 'kkk', NULL, NULL, 'Village Post Office Hattian Saiden Tehsil Hazro District Attock', NULL, 'گاؤں، ڈاک خانہ ہٹیاں سیدن، تحصیل حضرو، ضلع اٹک', 'Attock', NULL, 'اٹک', 'Alabama', NULL, 'الاباما', '43580', NULL, NULL, NULL, '2026-02-11 02:47:53', '2026-02-11 02:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders_items`
--

CREATE TABLE `orders_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `discounted_value` double(10,2) DEFAULT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `additional_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_attributes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_items`
--

INSERT INTO `orders_items` (`id`, `order_id`, `product_id`, `cart_id`, `name`, `quantity`, `price`, `discounted_price`, `discounted_value`, `total`, `created_at`, `updated_at`, `additional_attributes`) VALUES
(111, 120, 2, 57, 'T -  Shirt', 7, 9800.00, 4900.00, 50.00, 9800.00, '2026-02-04 05:27:12', '2026-02-04 05:27:12', '{\"size\":\"Medium\",\"color\":\"Light Grey\"}'),
(112, 121, 2, 58, 'T -  Shirt', 3, 4200.00, 2100.00, 50.00, 4200.00, '2026-02-04 05:28:55', '2026-02-04 05:28:55', '{\"size\":\"Medium\",\"color\":\"Light Grey\"}'),
(113, 121, 26, 59, 'Giovanny Dach', 2, 800.00, 480.00, 40.00, 800.00, '2026-02-04 05:28:55', '2026-02-04 05:28:55', '{\"size\":null,\"color\":null}'),
(114, 122, 26, 60, 'Giovanny Dach', 45, 2000.00, 1200.00, 40.00, 2000.00, '2026-02-04 05:50:55', '2026-02-04 06:49:09', '{\"size\":null,\"color\":null}'),
(115, 123, 26, 61, 'Giovanny Dach', 4, 400.00, 240.00, 40.00, 400.00, '2026-02-04 06:52:19', '2026-02-04 07:15:16', '{\"size\":null,\"color\":null}'),
(116, 124, 26, 62, 'Giovanny Dach', 20, 400.00, 0.00, 0.00, 400.00, '2026-02-06 01:37:10', '2026-02-06 02:32:16', '{\"size\":null,\"color\":null}'),
(117, 125, 26, 64, 'Giovanny Dach', 8, 3200.00, 0.00, 0.00, 3200.00, '2026-02-09 08:53:53', '2026-02-09 08:53:53', '{\"size\":null,\"color\":null}'),
(118, 126, 26, 64, 'Giovanny Dach', 8, 3200.00, 0.00, 0.00, 3200.00, '2026-02-11 01:59:08', '2026-02-11 01:59:08', '{\"size\":null,\"color\":null}'),
(119, 127, 2, 65, 'T -  Shirt', 1, 1400.00, 900.00, 0.00, 1400.00, '2026-02-11 02:47:53', '2026-02-11 02:47:53', '{\"size\":\"Medium\",\"color\":\"Light Grey\"}');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(24, 'App\\Models\\User', 11, 'auth_token', '454ee2c3e46372f0f1978538baaebc1ffe1a6f1a367d91c873df278324af9707', '[\"*\"]', NULL, NULL, '2025-05-19 10:59:25', '2025-05-19 10:59:25'),
(25, 'App\\Models\\User', 11, 'auth_token', '6bb3b8a5eb64e4c386223440bc9ae86ad4a331eab5429a567e813c7e019ffe59', '[\"*\"]', '2025-05-19 11:34:29', NULL, '2025-05-19 11:06:54', '2025-05-19 11:34:29'),
(26, 'App\\Models\\User', 11, 'auth_token', '653b88d74edae419f46d23aa703397c4590d3020296f6946937312f890173d98', '[\"*\"]', '2025-06-13 00:48:38', NULL, '2025-06-13 00:36:48', '2025-06-13 00:48:38'),
(27, 'App\\Models\\User', 5, 'auth_token', '169ef34217d4111e4d181c53f0ae8c0ed1fe6e702c4ec978a58a47b0bea04ba2', '[\"*\"]', NULL, NULL, '2025-08-22 00:02:35', '2025-08-22 00:02:35'),
(28, 'App\\Models\\User', 5, 'auth_token', 'fe75e85dc7bb995983581df04847bcd20bffe51e414f876110026666ed5bb112', '[\"*\"]', NULL, NULL, '2025-08-22 00:27:24', '2025-08-22 00:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `en_title_translation` varchar(255) DEFAULT NULL,
  `ur_title_translation` varchar(255) DEFAULT NULL,
  `title_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`title_translations`)),
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `en_description_translation` text DEFAULT NULL,
  `ur_description_translation` text DEFAULT NULL,
  `description_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`description_translations`)),
  `short_description` text DEFAULT NULL,
  `shipping_returns` text DEFAULT NULL,
  `related_products` text DEFAULT NULL,
  `categories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brands_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `en_title_translation`, `ur_title_translation`, `title_translations`, `slug`, `description`, `en_description_translation`, `ur_description_translation`, `description_translations`, `short_description`, `shipping_returns`, `related_products`, `categories_id`, `sub_category_id`, `sub_sub_category_id`, `brands_id`, `is_featured`, `sku`, `barcode`, `status`, `created_at`, `updated_at`, `price`) VALUES
(1, 'Laptop', NULL, NULL, '{\"en\":\"Laptop\",\"ur\":\"\\u0644\\u06cc\\u067e \\u0679\\u0627\\u067e\"}', 'Laptop', NULL, NULL, NULL, '{\"en\":\"High performance laptop\",\"ur\":\"\\u0627\\u0639\\u0644\\u06cc \\u06a9\\u0627\\u0631\\u06a9\\u0631\\u062f\\u06af\\u06cc \\u06a9\\u0627 \\u0644\\u06cc\\u067e \\u0679\\u0627\\u067e\"}', NULL, NULL, '19,17,15', 54, 7, NULL, 8, 0, 'Dell-6430', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(2, 'T -  Shirt', 'T-Shirt', 'ٹی شرٹ', '{\"en\":\"T - Shirt\",\"ur\":\"\\u0679\\u06cc \\u0634\\u0631\\u0679\"}', 'T -  Shirt', '', 'Comfortable cotton t-shirt', 'آرام دہ کاٹن ٹی شرٹ', '{\"en\":\"Comfortable cotton t-shirt\",\"ur\":\"\\u0622\\u0631\\u0627\\u0645 \\u062f\\u06c1 \\u06a9\\u0627\\u0679\\u0646 \\u0679\\u06cc \\u0634\\u0631\\u0679\"}', '', '', '', 1, 3, 2, 3, 1, 'Shirt-ATU', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', 500),
(3, 'Shoes Jogger', NULL, NULL, '{\"en\":\"Shoes Jogger\",\"ur\":\"\\u062c\\u06af\\u0631 \\u062c\\u0648\\u062a\\u06d2\"}', 'Shoes Jogger', '', NULL, NULL, '{\"en\":\"Stylish jogging shoes\",\"ur\":\"\\u0627\\u0633\\u0679\\u0627\\u0626\\u0644\\u0634 \\u062c\\u0627\\u06af\\u0646\\u06af \\u06a9\\u06d2 \\u062c\\u0648\\u062a\\u06d2\"}', '', '', '', 1, 3, 3, 3, 0, 'shoes-45', NULL, 1, '2024-12-22 09:41:20', '2025-11-25 02:01:03', 600),
(4, 'shoes', NULL, NULL, '{\"en\":\"Shoes\",\"ur\":\"\\u062c\\u0648\\u062a\\u06d2\"}', 'shoes', '', NULL, NULL, '{\"en\":\"Casual shoes\",\"ur\":\"\\u0639\\u0627\\u0645 \\u062c\\u0648\\u062a\\u06d2\"}', '', '', '', 1, 3, 3, NULL, 0, 'dd', NULL, 1, '2024-12-22 09:41:20', '2025-11-25 01:55:06', 4000),
(5, 'Paint Hores', NULL, NULL, '{\"en\":\"Paint Horse\",\"ur\":\"\\u067e\\u06cc\\u0646\\u0679 \\u06c1\\u0627\\u0631\\u0633\"}', 'Paint Hores', '', NULL, NULL, '{\"en\":\"Decorative paint horse\",\"ur\":\"\\u0633\\u062c\\u0627\\u0648\\u0679\\u06cc \\u067e\\u06cc\\u0646\\u0679 \\u06c1\\u0627\\u0631\\u0633\"}', '', '', '', 1, NULL, NULL, NULL, 0, 'tttttttt', NULL, 1, '2024-12-22 09:41:20', '2025-01-01 07:53:55', 500),
(6, 'Dr. Katrina Kutch V', NULL, NULL, '{\"en\":\"Dr. Katrina Kutch V\",\"ur\":\"\\u0688\\u0627\\u06a9\\u0679\\u0631 \\u06a9\\u06cc\\u0679\\u0631\\u06cc\\u0646\\u0627 \\u06a9\\u0686 \\u0648\\u06cc\"}', 'dr-katrina-kutch-v', NULL, NULL, NULL, '{\"en\":\"Product description for Dr. Katrina\",\"ur\":\"\\u0688\\u0627\\u06a9\\u0679\\u0631 \\u06a9\\u06cc\\u0679\\u0631\\u06cc\\u0646\\u0627 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 8, 0, '2708', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(7, 'Miss Annie Blick III', NULL, NULL, '{\"en\":\"Miss Annie Blick III\",\"ur\":\"\\u0645\\u0633 \\u0627\\u06cc\\u0646\\u06cc \\u0628\\u0644\\u06cc\\u06a9 \\u062a\\u06be\\u0631\\u06cc\"}', 'miss-annie-blick-iii', NULL, NULL, NULL, '{\"en\":\"Product description for Miss Annie\",\"ur\":\"\\u0645\\u0633 \\u0627\\u06cc\\u0646\\u06cc \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '4390', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(8, 'Timothy Howe Jr.', NULL, NULL, '{\"en\":\"Timothy Howe Jr.\",\"ur\":\"\\u0679\\u0645\\u0648\\u062a\\u06be\\u06cc \\u06c1\\u0627\\u0624 \\u062c\\u0648\\u0646\\u06cc\\u0626\\u0631\"}', 'timothy-howe-jr', NULL, NULL, NULL, '{\"en\":\"Product description for Timothy Howe\",\"ur\":\"\\u0679\\u0645\\u0648\\u062a\\u06be\\u06cc \\u06c1\\u0627\\u0624 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 6, 0, '4789', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(9, 'Ervin Emmerich', NULL, NULL, '{\"en\":\"Ervin Emmerich\",\"ur\":\"\\u0627\\u0631\\u0648\\u06cc\\u0646 \\u0627\\u06cc\\u0645\\u06cc\\u0631\\u0686\"}', 'ervin-emmerich', NULL, NULL, NULL, '{\"en\":\"Product description for Ervin Emmerich\",\"ur\":\"\\u0627\\u0631\\u0648\\u06cc\\u0646 \\u0627\\u06cc\\u0645\\u06cc\\u0631\\u0686 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '2702', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(10, 'Dr. Hassan Leffler II', NULL, NULL, '{\"en\":\"Dr. Hassan Leffler II\",\"ur\":\"\\u0688\\u0627\\u06a9\\u0679\\u0631 \\u062d\\u0633\\u0646 \\u0644\\u06cc\\u0641\\u0644\\u0631 II\"}', 'dr-hassan-leffler-ii', NULL, NULL, NULL, '{\"en\":\"Product description for Dr. Hassan\",\"ur\":\"\\u0688\\u0627\\u06a9\\u0679\\u0631 \\u062d\\u0633\\u0646 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 6, 0, '6885', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(11, 'Mr. Stephan Hirthe', NULL, NULL, '{\"en\":\"Mr. Stephan Hirthe\",\"ur\":\"\\u0645\\u0633\\u0679\\u0631 \\u0627\\u0633\\u0679\\u06cc\\u0641\\u0646 \\u06c1\\u0631\\u062a\\u06be\\u06d2\"}', 'mr-stephan-hirthe', NULL, NULL, NULL, '{\"en\":\"Product description for Stephan\",\"ur\":\"\\u0627\\u0633\\u0679\\u06cc\\u0641\\u0646 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 8, 0, '1330', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(12, 'Alexandria Keebler', NULL, NULL, '{\"en\":\"Alexandria Keebler\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06af\\u0632\\u06cc\\u0646\\u0688\\u0631\\u06cc\\u0627 \\u06a9\\u06cc\\u0628\\u0644\\u0631\"}', 'alexandria-keebler', NULL, NULL, NULL, '{\"en\":\"Product description for Alexandria\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06af\\u0632\\u06cc\\u0646\\u0688\\u0631\\u06cc\\u0627 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 8, 0, '5340', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(13, 'Josiah Brown', NULL, NULL, '{\"en\":\"Josiah Brown\",\"ur\":\"\\u062c\\u0648\\u0633\\u0627\\u06cc\\u0627 \\u0628\\u0631\\u0627\\u0624\\u0646\"}', 'josiah-brown', NULL, NULL, NULL, '{\"en\":\"Product description for Josiah\",\"ur\":\"\\u062c\\u0648\\u0633\\u0627\\u06cc\\u0627 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '1078', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(14, 'Chelsey Nader', NULL, NULL, '{\"en\":\"Chelsey Nader\",\"ur\":\"\\u0686\\u06cc\\u0644\\u0633\\u06cc \\u0646\\u0627\\u062f\\u0631\"}', 'chelsey-nader', NULL, NULL, NULL, '{\"en\":\"Product description for Chelsey\",\"ur\":\"\\u0686\\u06cc\\u0644\\u0633\\u06cc \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 8, 0, '9420', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(15, 'Horace Larson Sr.', NULL, NULL, '{\"en\":\"Horace Larson Sr.\",\"ur\":\"\\u06c1\\u0648\\u0631\\u06cc\\u0633 \\u0644\\u0627\\u0631\\u0633\\u0646 \\u0633\\u06cc\\u0646\\u0626\\u0631\"}', 'horace-larson-sr', NULL, NULL, NULL, '{\"en\":\"Product description for Horace Larson\",\"ur\":\"\\u06c1\\u0648\\u0631\\u06cc\\u0633 \\u0644\\u0627\\u0631\\u0633\\u0646 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 6, 0, '2955', NULL, 1, '2024-12-22 09:41:20', '2025-12-16 05:21:22', NULL),
(16, 'Althea Wunsch V', NULL, NULL, '{\"en\":\"Althea Wunsch V\",\"ur\":\"\\u0627\\u0644\\u062a\\u06be\\u06cc\\u06c1 \\u0648\\u0646\\u0634 \\u0648\\u06cc\"}', 'althea-wunsch-v', NULL, NULL, NULL, '{\"en\":\"Product description for Althea\",\"ur\":\"\\u0627\\u0644\\u062a\\u06be\\u06cc\\u06c1 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '5087', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(17, 'Alysa Olson', NULL, NULL, '{\"en\":\"Alysa Olson\",\"ur\":\"\\u0627\\u0644\\u06cc\\u0633\\u0627 \\u0627\\u0648\\u0644\\u0633\\u0646\"}', 'alysa-olson', NULL, NULL, NULL, '{\"en\":\"Product description for Alysa\",\"ur\":\"\\u0627\\u0644\\u06cc\\u0633\\u0627 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '9774', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(18, 'Kelvin Windler', NULL, NULL, '{\"en\":\"Kelvin Windler\",\"ur\":\"\\u06a9\\u06cc\\u0644\\u0648\\u0646 \\u0648\\u0646\\u0688\\u0644\\u0631\"}', 'kelvin-windler', NULL, NULL, NULL, '{\"en\":\"Product description for Kelvin\",\"ur\":\"\\u06a9\\u06cc\\u0644\\u0648\\u0646 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 7, 0, '6573', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(19, 'Darion Lockman DVM', NULL, NULL, '{\"en\":\"Darion Lockman DVM\",\"ur\":\"\\u062f\\u0627\\u0631\\u06cc\\u0648\\u0646 \\u0644\\u0627\\u06a9 \\u0645\\u06cc\\u0646 DVM\"}', 'darion-lockman-dvm', NULL, NULL, NULL, '{\"en\":\"Product description for Darion\",\"ur\":\"\\u062f\\u0627\\u0631\\u06cc\\u0648\\u0646 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 8, 0, '8600', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(20, 'Prof. Mable Quitzon', NULL, NULL, '{\"en\":\"Prof. Mable Quitzon\",\"ur\":\"\\u067e\\u0631\\u0648\\u0641\\u06cc\\u0633\\u0631 \\u0645\\u06cc\\u0628\\u0644 \\u06a9\\u0648\\u0626\\u0679\\u0632\\u0648\\u0646\"}', 'prof-mable-quitzon', NULL, NULL, NULL, '{\"en\":\"Product description for Mable\",\"ur\":\"\\u0645\\u06cc\\u0628\\u0644 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 5, NULL, 8, 0, '1331', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(21, 'Virginia Brakus', NULL, NULL, '{\"en\":\"Virginia Brakus\",\"ur\":\"\\u0648\\u0631\\u062c\\u06cc\\u0646\\u06cc\\u0627 \\u0628\\u0631\\u06cc\\u06a9\\u0633\"}', 'virginia-brakus', '', NULL, NULL, '{\"en\":\"Product description for Virginia\",\"ur\":\"\\u0648\\u0631\\u062c\\u06cc\\u0646\\u06cc\\u0627 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', '', '', '', 4, NULL, NULL, NULL, 0, '8676', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', 200),
(22, 'Jarret Bruen', NULL, NULL, '{\"en\":\"Jarret Bruen\",\"ur\":\"\\u062c\\u06cc\\u0631\\u06cc\\u0679 \\u0628\\u0631\\u0648\\u0646\"}', 'jarret-bruen', NULL, NULL, NULL, '{\"en\":\"Product description for Jarret\",\"ur\":\"\\u062c\\u06cc\\u0631\\u06cc\\u0679 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', NULL, NULL, NULL, 53, 6, NULL, 7, 0, '8990', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', NULL),
(23, 'Alanis Dach', NULL, NULL, '{\"en\":\"Alanis Dach\",\"ur\":\"\\u0627\\u0644\\u0627\\u0646\\u0650\\u0633 \\u0688\\u0627\\u0686\"}', 'alanis-dach', '', NULL, NULL, '{\"en\":\"Product description for Alanis\",\"ur\":\"\\u0627\\u0644\\u0627\\u0646\\u0650\\u0633 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', '', '', '', 4, NULL, NULL, NULL, 0, '5181', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', 1000),
(24, 'Abbigail Dicki', NULL, NULL, '{\"en\":\"Abbigail Dicki\",\"ur\":\"\\u0627\\u0628\\u06cc\\u06af\\u0644 \\u0688\\u06a9\\u06cc\"}', 'abbigail-dicki', '', NULL, NULL, '{\"en\":\"Product description for Abbigail\",\"ur\":\"\\u0627\\u0628\\u06cc\\u06af\\u0644 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', '', '', '', 4, NULL, NULL, NULL, 0, '2067', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', 200),
(25, 'Astrid Ratke', NULL, NULL, '{\"en\":\"Astrid Ratke\",\"ur\":\"\\u0627\\u0633\\u0679\\u0631\\u0688 \\u0631\\u06cc\\u0679\\u06a9\\u06d2\"}', 'astrid-ratke', '', NULL, NULL, '{\"en\":\"Product description for Astrid\",\"ur\":\"\\u0627\\u0633\\u0679\\u0631\\u0688 \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', '', '', '', 4, NULL, NULL, NULL, 1, '9508', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', 400),
(26, 'Giovanny Dach', NULL, 'جیووانی ڈاچ', '{\"en\":\"Giovanny Dach\",\"ur\":\"\\u062c\\u06cc\\u0648\\u0648\\u0627\\u0646\\u06cc \\u0688\\u0627\\u0686\"}', 'giovanny-dach', '', NULL, NULL, '{\"en\":\"Product description for Giovanny\",\"ur\":\"\\u062c\\u06cc\\u0648\\u0648\\u0627\\u0646\\u06cc \\u06a9\\u06d2 \\u0644\\u0626\\u06d2 \\u0645\\u0635\\u0646\\u0648\\u0639 \\u06a9\\u06cc \\u062a\\u0641\\u0635\\u06cc\\u0644\"}', '', '', '', 1, 3, NULL, 2, 1, '1234', NULL, 1, '2024-12-22 09:41:21', '2025-12-16 05:21:22', 400);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `saling_price` int(11) DEFAULT NULL,
  `original_price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remaning_quantity` int(11) NOT NULL DEFAULT 0,
  `sold_quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `size` decimal(10,2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `size`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 2, 'blact-TShirt-2--1736314826.jpg', NULL, NULL, '2025-01-08 00:40:26', '2025-01-08 00:40:26'),
(5, 2, 'white-TShirt-2--1736314926.jpg', NULL, NULL, '2025-01-08 00:42:06', '2025-01-08 00:42:06'),
(6, 26, 'Screenshot from 2025-02-11 16-57-04-26--1739353421.png', NULL, NULL, '2025-02-12 04:43:41', '2025-02-12 04:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `product_id`, `username`, `email`, `comment`, `rating`, `status`, `created_at`, `updated_at`, `likes`, `dislikes`) VALUES
(7, 5, 'Muhammad Sheharyar', 'shery0597@gmail.com', 'dnklfnsdlkfklsdjfskdlf', 4.00, 0, '2025-11-06 02:22:31', '2025-11-06 02:22:31', 0, 0),
(8, 26, 'Muhammad Sheharyar', 'shery0597@gmail.com', 'iiiiii', 5.00, 0, '2025-11-07 02:01:42', '2025-11-07 02:01:42', 0, 0),
(9, 2, 'Muhammad Sheharyar', 'shery0597@gmail.com', 'hhjhjhjh', 5.00, 0, '2025-11-08 08:16:13', '2025-11-08 08:16:13', 0, 0),
(10, 2, 'Muhammad Sheharyar Asif', 'msheharyar76@gmail.com', 'ekee', 4.00, 0, '2025-11-27 01:28:49', '2025-11-27 01:28:49', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_view`
--

CREATE TABLE `product_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_view`
--

INSERT INTO `product_view` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 2, 5, '2025-01-08 00:33:34', '2025-01-08 00:33:34'),
(2, NULL, 26, '2025-01-09 00:56:04', '2025-01-09 00:56:04'),
(3, NULL, 2, '2025-01-09 00:57:39', '2025-01-09 00:57:39'),
(4, NULL, 7, '2025-01-09 00:57:46', '2025-01-09 00:57:46'),
(5, NULL, 1, '2025-01-09 01:00:58', '2025-01-09 01:00:58'),
(6, 4, 2, '2025-01-09 01:03:31', '2025-01-09 01:03:31'),
(7, 4, 26, '2025-01-09 01:03:40', '2025-01-09 01:03:40'),
(8, NULL, 5, '2025-01-16 01:14:49', '2025-01-16 01:14:49'),
(9, 2, 2, '2025-01-18 04:22:38', '2025-01-18 04:22:38'),
(10, 5, 5, '2025-01-18 04:26:09', '2025-01-18 04:26:09'),
(11, 5, 2, '2025-01-18 04:26:15', '2025-01-18 04:26:15'),
(12, 5, 1, '2025-01-22 11:50:46', '2025-01-22 11:50:46'),
(13, 8, 2, '2025-03-09 11:35:53', '2025-03-09 11:35:53'),
(14, 4, 5, '2025-03-15 19:58:01', '2025-03-15 19:58:01'),
(15, 4, 4, '2025-03-15 19:58:07', '2025-03-15 19:58:07'),
(16, 4, 3, '2025-03-15 19:58:16', '2025-03-15 19:58:16'),
(17, 2, 26, '2025-05-13 01:03:05', '2025-05-13 01:03:05'),
(18, NULL, 15, '2025-08-31 11:54:40', '2025-08-31 11:54:40'),
(19, NULL, 11, '2025-08-31 11:54:40', '2025-08-31 11:54:40'),
(20, NULL, 12, '2025-08-31 12:02:15', '2025-08-31 12:02:15'),
(21, 15, 21, '2025-10-25 22:07:37', '2025-10-25 22:07:37'),
(22, 15, 26, '2025-10-28 02:57:08', '2025-10-28 02:57:08'),
(23, 15, 25, '2025-10-28 04:50:21', '2025-10-28 04:50:21'),
(24, 15, 2, '2025-10-28 05:15:55', '2025-10-28 05:15:55'),
(25, 15, 3, '2025-10-29 23:20:16', '2025-10-29 23:20:16'),
(26, 15, 5, '2025-10-31 00:32:53', '2025-10-31 00:32:53'),
(27, 3, 24, '2025-11-05 02:05:19', '2025-11-05 02:05:19'),
(28, 3, 25, '2025-11-05 02:07:31', '2025-11-05 02:07:31'),
(29, 3, 5, '2025-11-05 02:08:50', '2025-11-05 02:08:50'),
(30, 3, 26, '2025-11-05 04:38:12', '2025-11-05 04:38:12'),
(31, 3, 2, '2025-11-05 04:56:39', '2025-11-05 04:56:39'),
(32, 3, 21, '2025-11-06 02:00:18', '2025-11-06 02:00:18'),
(33, 3, 7, '2025-11-08 08:27:32', '2025-11-08 08:27:32'),
(34, 3, 10, '2025-11-08 08:27:36', '2025-11-08 08:27:36'),
(35, 3, 8, '2025-11-08 08:28:00', '2025-11-08 08:28:00'),
(36, 3, 17, '2025-11-08 08:28:07', '2025-11-08 08:28:07'),
(37, NULL, 25, '2025-11-08 21:56:04', '2025-11-08 21:56:04'),
(38, NULL, 24, '2025-11-08 21:56:30', '2025-11-08 21:56:30'),
(39, 3, 20, '2025-11-14 00:40:09', '2025-11-14 00:40:09'),
(40, 2, 25, '2025-11-25 02:17:21', '2025-11-25 02:17:21'),
(41, 2, 24, '2025-11-25 12:09:09', '2025-11-25 12:09:09'),
(42, 3, 15, '2025-12-11 02:04:46', '2025-12-11 02:04:46'),
(43, 3, 18, '2025-12-11 03:06:30', '2025-12-11 03:06:30'),
(44, 3, 16, '2025-12-12 00:27:53', '2025-12-12 00:27:53'),
(45, 3, 4, '2025-12-16 07:03:29', '2025-12-16 07:03:29'),
(46, 2, 1, '2026-01-30 02:10:30', '2026-01-30 02:10:30'),
(47, 2, 9, '2026-02-02 06:55:07', '2026-02-02 06:55:07'),
(48, NULL, 16, '2026-02-09 06:41:08', '2026-02-09 06:41:08'),
(49, 2, 23, '2026-02-09 06:50:29', '2026-02-09 06:50:29'),
(50, 2, 20, '2026-02-09 08:55:11', '2026-02-09 08:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `description`, `created_at`, `updated_at`) VALUES
(11, 'hajhjdkhaskjdhkjasd', '2025-04-09 01:17:26', '2025-04-09 01:17:26'),
(12, 'new discounts available', '2025-04-09 01:29:51', '2025-04-09 23:50:33'),
(13, 'nnnnn', '2025-04-09 01:31:38', '2025-04-09 01:31:38'),
(14, 'new discount is available', '2025-04-09 23:51:10', '2025-04-09 23:51:10');

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
(3, '164', 50.00, '2025-01-01 11:00:28', '2025-01-01 11:00:28'),
(5, '3', 90.00, '2025-11-14 02:07:24', '2025-11-14 02:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `name`, `status`, `price`, `product_id`, `code`, `created_at`, `updated_at`) VALUES
(6, 'Medium', '1', '400', '2', 'M', '2025-03-03 11:07:34', '2025-03-03 11:07:34'),
(8, 'Meim', '1', '3000', '3', 'M', '2025-03-05 04:41:08', '2025-03-05 04:41:08'),
(9, 'small', '1', '390', '2', 'S', '2025-05-14 07:58:57', '2025-10-28 07:09:58'),
(11, 'Large', '1', '200', '2', 'L', '2025-11-24 08:14:08', '2025-11-24 08:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sold_quantity` int(11) NOT NULL DEFAULT 0,
  `color_id` int(11) NOT NULL DEFAULT 0,
  `size_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `sold_quantity`, `color_id`, `size_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 46, 21, 3, 0, 1, '2025-01-01 07:48:23', '2025-11-08 22:35:00'),
(2, 2, 44, 6, 0, 0, 1, '2025-01-08 00:37:47', '2025-02-17 07:54:03'),
(5, 26, 184, 425, 0, 0, 1, '2025-02-11 06:12:21', '2026-02-09 07:25:38'),
(6, 2, 165, 282, 2, 6, 1, '2025-03-03 11:11:27', '2025-11-22 22:50:20'),
(7, 2, 1, 17, 10, 9, 1, '2025-11-12 02:53:25', '2025-12-12 02:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `en_name_translation`, `ur_name_translation`, `name_translations`, `slug`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(3, 'Men', NULL, 'مرد', '{\"en\":\"Men\",\"ur\":\"مرد\"}', 'Men', 1, 1, '2025-02-11 05:30:08', '2025-12-16 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_categories`
--

CREATE TABLE `sub_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_sub_categories`
--

INSERT INTO `sub_sub_categories` (`id`, `name`, `en_name_translation`, `ur_name_translation`, `name_translations`, `slug`, `status`, `category_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(2, 'Shirts', NULL, 'شرٹس', '{\"en\":\"Shirts\",\"ur\":\"\\u0634\\u0631\\u0679\\u0633\"}', 'Shirts', 1, 1, 3, '2025-02-11 05:37:42', '2025-10-18 21:39:52'),
(3, 'Shoes', NULL, 'جوتے', '{\"en\":\"Shoes\",\"ur\":\"\\u062c\\u0648\\u062a\\u06d2\"}', 'Shoes', 1, 1, 3, '2025-10-18 21:40:27', '2025-10-18 21:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `table_onboarding`
--

CREATE TABLE `table_onboarding` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `subtitle` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `size`, `created_at`, `updated_at`) VALUES
(1, 'last_room_1734877668.jpg', 39742.00, '2024-12-22 09:27:48', '2024-12-22 09:27:48'),
(2, 'Screenshot from 2025-02-09 20-39-50_1739344090.png', 286048.00, '2025-02-12 02:08:10', '2025-02-12 02:08:10'),
(3, 'Screenshot from 2025-02-09 20-39-50_1739344105.png', 286048.00, '2025-02-12 02:08:25', '2025-02-12 02:08:25'),
(4, 'Screenshot from 2025-02-06 15-12-07_1739344184.png', 28955.00, '2025-02-12 02:09:44', '2025-02-12 02:09:44'),
(5, 'Screenshot from 2025-02-11 16-57-04_1739353453.png', 93577.00, '2025-02-12 04:44:13', '2025-02-12 04:44:13'),
(6, '1739354006.png', NULL, '2025-02-12 04:53:26', '2025-02-12 04:53:26'),
(7, 'WhatsApp Image 2025-05-17 at 6.20.44 PM (2)_1747576542.jpeg', 13527.00, '2025-05-18 08:55:42', '2025-05-18 08:55:42'),
(8, 'women_images_1760677342.jpeg', 6391.00, '2025-10-17 00:02:22', '2025-10-17 00:02:22'),
(9, 'women_images_1760677654.jpeg', 6391.00, '2025-10-17 00:07:34', '2025-10-17 00:07:34'),
(10, 'women_images_1760678280.jpeg', 6391.00, '2025-10-17 00:18:00', '2025-10-17 00:18:00'),
(11, 'date-hero-mens-mb-data_1760841545.jpg', 80513.00, '2025-10-18 21:39:05', '2025-10-18 21:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_name` varchar(255) NOT NULL,
  `theme_color_code` varchar(255) NOT NULL,
  `theme_status` tinyint(1) NOT NULL DEFAULT 1,
  `theme_isset_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `theme_name`, `theme_color_code`, `theme_status`, `theme_isset_status`, `created_at`, `updated_at`) VALUES
(4, 'shery', '#000000', 0, 0, '2025-06-13 00:47:11', '2025-06-13 00:47:11'),
(5, 'ALi', '#000000', 0, 0, '2025-06-13 00:47:21', '2025-06-13 00:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `en_first_name_translation` varchar(255) DEFAULT NULL,
  `ur_first_name_translation` varchar(255) DEFAULT NULL,
  `first_name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`first_name_translations`)),
  `last_name` varchar(255) DEFAULT NULL,
  `en_last_name_translation` varchar(255) DEFAULT NULL,
  `ur_last_name_translation` varchar(255) DEFAULT NULL,
  `last_name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`last_name_translations`)),
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `en_gender_translation` varchar(255) DEFAULT NULL,
  `ur_gender_translation` varchar(255) DEFAULT NULL,
  `gender_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gender_translations`)),
  `mobile_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `en_name_translation` varchar(255) DEFAULT NULL,
  `ur_name_translation` varchar(255) DEFAULT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `personal_access_token_id` varchar(255) DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `en_first_name_translation`, `ur_first_name_translation`, `first_name_translations`, `last_name`, `en_last_name_translation`, `ur_last_name_translation`, `last_name_translations`, `date_of_birth`, `gender`, `en_gender_translation`, `ur_gender_translation`, `gender_translations`, `mobile_number`, `name`, `en_name_translation`, `ur_name_translation`, `name_translations`, `email`, `phone`, `github_id`, `facebook_id`, `google_id`, `email_verified_at`, `password`, `role`, `status`, `token`, `remember_token`, `created_at`, `updated_at`, `image`, `address`, `personal_access_token_id`, `fcm_token`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Sheharyar Asif', NULL, 'محمد شہریار آصف', '{\"en\":\"Muhammad Sheharyar Asif\",\n\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', 'msheharyar76@gmail.com', '03175038179', NULL, NULL, '102567426625344175175', NULL, '$2y$12$0N2iMESOTG46/ScH7fP39e4050jryU9UdRAcoJxD/it5aLtHG9rW2', 1, 1, 'ya29.a0ARW5m76twB5IQtIl-TrGofgk_ewPUyM5PEVGyp1MJG942cD27iBUcgbKub5rb3C698ng_Oy5Ceya-wQmzrRIDGofw-xtPjOHQbGixh6uMMouEZ5vxYfVm6m_ZsICpJrluEdQaxfaBKLZwDhqknGdeixUJeMK7TcuXsGUhMdEaCgYKAdkSARESFQHGX2MiHgbdmDnbQFDvpmJu9uRXRw0175', NULL, '2024-12-24 00:50:03', '2025-07-19 11:58:28', NULL, 'Village Post Office Hattian Saiden Tehsil Hazro District Attock', NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Sheharyar', NULL, NULL, '{\"en\":\"Muhammad Sheharyar\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631\"}', 'shery0597@gmail.com', NULL, NULL, NULL, '107196562319021049348', NULL, '$2y$12$0ngPnUsMckPC65.7fOatr.fwSK2K95at49u2opz4d3P/kPv9Bhv6m', 1, 1, 'ya29.a0ARW5m75M_R0JR-nqXMTD3bKVWUWojDHcCRAz7u1-FpuT2nhzqSW2tgzXMV-irW9hOOL8FoGVQM0DwAfOrlxVuvBbS31dFbFII8fK9ptUpRftIOH3Z-dE35M9l_EOTcEkX-zkOcNHvH8eS4f08Iy0sllIEFuJnedbbLhQt1pTaCgYKAXUSARISFQHGX2Miqwv76w6S5TArHWyee0hvdQ0175', NULL, '2024-12-27 01:03:07', '2024-12-27 01:03:07', NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Sheharyar Asif', NULL, NULL, '{\"en\":\"Muhammad Sheharyar Asif\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', 'sp21-rcs-010@cuiatk.edu.pk', NULL, NULL, NULL, '117954621993009938682', NULL, '$2y$12$YcRxwlFmMjnyX8x5O.jJ3OSgA5jxwYMmBo27yoRyJvA2SZuqayVdq', 1, 1, 'ya29.a0ARW5m76ZITmeCFsnipNvY8tPUHc-F6oIFqR57tRo6M7y19GYMmnw4gYOYhY8AgzRPGT9QnWoslkyBBKfsgFMYh8VX1BunAPKqCXQrY1lEFCyEo4H13YMGSziSvwlEhw4AvYygM5hVht2yPJEZZnYe3npynDD6F9tkCFYxa4NaCgYKAaESARESFQHGX2MiHdotQbhADvXwqyB9r95wSw0175', NULL, '2025-01-09 01:03:22', '2025-01-09 01:03:22', NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sheharyar Asif', NULL, NULL, '{\"en\":\"Sheharyar Asif\",\"ur\":\"\\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', 'shery05977@gmail.com', '03175038179', NULL, NULL, NULL, NULL, '$2y$12$8HMdgy6DEt1D22ZE7H6wz.49gTZgOhlFs5S774FCon2zWSUSFspzm', 1, 1, NULL, NULL, '2025-01-09 05:37:26', '2025-08-22 00:27:24', NULL, NULL, '28|MeQRoSLOiqGRkezkBfZIr5Th4K8QaasriXxOoBXM60e41c5b', NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Awais Shah', NULL, NULL, '{\"en\":\"Awais Shah\",\"ur\":\"\\u0627\\u0648\\u06cc\\u0633 \\u0634\\u0627\\u06c1\"}', 'awaisshah05977@gmail.com', '0300000000001', NULL, NULL, NULL, NULL, '$2y$12$4djBNX2qtYbQ/FuHY68dQu.NvUJyfPM/TfLmw/tuuYWqSqr6xHi0q', 1, 1, NULL, NULL, '2025-02-07 00:10:18', '2025-02-07 00:10:18', NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Sheharyar Asif', NULL, NULL, '{\"en\":\"Muhammad Sheharyar Asif\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', 'msheharyar78888886@gmail.com', '03175038179', NULL, NULL, NULL, NULL, '$2y$12$3xGom290GOaaRdd8qhvd9.PooDcFKwg6qGb1ozoCyAm6d1a5epubC', 1, 1, NULL, NULL, '2025-03-09 11:35:19', '2025-03-09 11:35:19', NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Usman Ali', NULL, NULL, '{\"en\":\"Usman Ali\",\"ur\":\"\\u0639\\u062b\\u0645\\u0627\\u0646 \\u0639\\u0644\\u06cc\"}', 'usaman234@gmail.com', '33333333333333333333', NULL, NULL, NULL, NULL, '$2y$12$6bkXn9iNURak9HEJM2wt2u7dzKN7QMaVlz9hNkE.j0HQ49io86mVS', 1, 1, NULL, NULL, '2025-04-16 01:12:04', '2025-04-16 01:12:04', NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Usman Ali', NULL, NULL, '{\"en\":\"Usman Ali\",\"ur\":\"\\u0639\\u062b\\u0645\\u0627\\u0646 \\u0639\\u0644\\u06cc\"}', 'usman@example.com', '031778497584', NULL, NULL, NULL, NULL, '$2y$12$qFwyAWNnWaVdB0FwYqJa3OFMjyRo..BA0oIMNa7JFjHLKH8EiwaBm', 1, 1, NULL, NULL, '2025-05-05 01:36:59', '2025-05-05 01:36:59', NULL, NULL, NULL, 'csNMy1i3_PJ8pVFO9B4kQZ:APA91bEp2p-DysG1cBZzZ-giigzJxF1aFJff49uI12UJrM9Yz0bNZYfqYfIZ2Ogmz6CHh1eMbibKDvuPf0k3SEM6Kf8gzZYs00Ihrjbx9NfEIJJO2FQrjjI'),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin User', NULL, NULL, '{\"en\":\"Admin User\",\"ur\":\"Admin User\"}', 'admin@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$jR7nHmPR9yxVZZZwL1Y0ruxmOIGXk2msw5iyBTu5BWf9ola40R92m', 2, 1, NULL, NULL, '2025-05-18 23:47:47', '2025-06-13 00:36:48', NULL, NULL, '26|Yi0f9qjIICA114dm61C5o3L7ngu8VjSsAiUdWmx2225637cd', NULL),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Shery', NULL, NULL, '{\"en\":\"Shery\",\"ur\":\"Shery\"}', 'msheharyar75556@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$0WhuHYh9aYUT/6XvSeHtu.HYIWHRIuHKrcaLdlGKBnEP/07f7KhNK', 1, 1, NULL, NULL, '2025-10-19 07:07:41', '2025-10-19 07:07:41', NULL, NULL, NULL, NULL),
(15, 'hhhhhhhhhhhhh', NULL, NULL, '{\"en\":\"hhhhhhhhhhhhh\",\"ur\":\"hhhhhhhhhhhhh\"}', 'kkkkk', NULL, NULL, '{\"en\":\"kkkkk\",\"ur\":\"kkkkk\"}', '2025-10-17', 'male', NULL, NULL, '{\"en\":\"Male\",\"ur\":\"\\u0645\\u0631\\u062f\"}', NULL, 'Muhammad Sheharyar Asif', NULL, NULL, '{\"en\":\"Muhammad Sheharyar Asif\",\"ur\":\"\\u0645\\u062d\\u0645\\u062f \\u0634\\u06c1\\u0631\\u06cc\\u0627\\u0631 \\u0622\\u0635\\u0641\"}', 'msheharyar7886@gmail.com', '876879', NULL, NULL, NULL, NULL, '$2y$12$rMrg2AyOKQxKwvwu6WDTsu59TL6nddx/UyNuE/v6cfA31ky3D4nBS', 1, 1, NULL, NULL, '2025-10-20 10:55:21', '2025-10-22 00:50:33', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webservices`
--

CREATE TABLE `webservices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_type` varchar(255) NOT NULL,
  `api_url` varchar(255) NOT NULL,
  `api_name` varchar(255) NOT NULL,
  `api_description` text DEFAULT NULL,
  `api_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_payload`)),
  `api_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_side` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webservices`
--

INSERT INTO `webservices` (`id`, `api_type`, `api_url`, `api_name`, `api_description`, `api_payload`, `api_response`, `created_at`, `updated_at`, `api_side`) VALUES
(1, 'get', 'http://127.0.0.1:8000/api/v1/admin/dashboard', 'Admin Dashboard API', NULL, NULL, NULL, '2025-03-18 00:03:25', '2025-03-18 00:03:25', 0),
(2, 'post', 'http://127.0.0.1:8000/api/v1/admin/authenticate', 'Admin Login API', NULL, '{\r\n    \"email\": \"john.doe@example.com\",\r\n    \"password\": \"sheharyar\"\r\n}', NULL, '2025-03-18 00:08:49', '2025-03-18 00:08:49', 0),
(3, 'get', 'http://127.0.0.1:8000/api/v1/admin/logout', 'Admin Logout API', NULL, NULL, NULL, '2025-03-18 00:10:24', '2025-03-18 00:10:24', 0),
(4, 'post', 'http://127.0.0.1:8000/api/v1/admin/coupons/store', 'Discount Coupon ADD', NULL, '{\r\n    \"code\": \"yuuue773\",\r\n    \"name\": \"pak123\",\r\n    \"type\": \"percent\",\r\n    \"discount_amount\": 40,\r\n    \"min_amount\": 20,\r\n    \"description\": \"nothing\",\r\n    \"max_uses\": 10,\r\n    \"max_uses_user\": 20,\r\n    \"starts_at\": \"2025-02-11\",\r\n    \"expires_at\": \"2025-02-14\",\r\n    \"status\": true    \r\n}', NULL, '2025-03-18 00:13:36', '2025-03-18 00:13:36', 0),
(5, 'get', 'http://127.0.0.1:8000/api/v1/admin/coupons/index', 'Discount Coupon Fetch data', NULL, NULL, NULL, '2025-03-18 05:07:25', '2025-03-18 05:07:25', 0),
(6, 'put', 'http://127.0.0.1:8000/api/v1/admin/coupons/2/update', 'Discount Coupon Update data', NULL, '{\r\n    \"code\": \"yuuue773\",\r\n    \"name\": \"pk123\",\r\n    \"type\": \"percent\",\r\n    \"discount_amount\": 50,\r\n    \"min_amount\": 20,\r\n    \"description\": \"nothing\",\r\n    \"max_uses\": 10,\r\n    \"max_uses_user\": 20,\r\n    \"starts_at\": \"2025-02-11\",\r\n    \"expires_at\": \"2025-02-14\",\r\n    \"status\": true    \r\n}', NULL, '2025-03-18 05:08:13', '2025-03-18 05:08:13', 0),
(7, 'delete', 'http://127.0.0.1:8000/api/v1/admin/coupons/2/delete', 'Discount Coupon Delete data', NULL, NULL, NULL, '2025-03-18 05:09:00', '2025-03-18 05:09:00', 0),
(8, 'get', 'http://127.0.0.1:8000/api/v1/admin/discount/index', 'Discount', 'Discount for product', NULL, NULL, '2025-03-18 05:12:20', '2025-03-18 05:12:20', 0),
(9, 'post', 'http://127.0.0.1:8000/api/v1/admin/discount/store', 'Discount ADD', 'Discount for Product', '{\r\n    \"discount_name\": \"Product Discount\",\r\n    \"select_product\": [1],\r\n    \"type\": \"percentage\",\r\n    \"discount_amount\": 40,\r\n    \"starts_at\": \"2025-02-11\",\r\n    \"expires_at\": \"2025-02-14\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:15:40', '2025-03-18 05:15:40', 0),
(10, 'put', 'http://127.0.0.1:8000/api/v1/admin/discount/2/update', 'Discount Update', NULL, '{\r\n    \"discount_name\": \"Product Discount\",\r\n    \"select_product\": [1],\r\n    \"type\": \"percentage\",\r\n    \"discount_amount\": 40,\r\n    \"starts_at\": \"2025-02-11\",\r\n    \"expires_at\": \"2025-02-14\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:16:31', '2025-03-18 05:16:31', 0),
(11, 'delete', 'http://127.0.0.1:8000/api/v1/admin/discount/2/delete', 'Discount Delete', NULL, NULL, NULL, '2025-03-18 05:16:55', '2025-03-18 05:16:55', 0),
(12, 'get', 'http://127.0.0.1:8000/api/v1/admin/categories', 'Categories Fetch', NULL, NULL, NULL, '2025-03-18 05:19:09', '2025-03-18 05:19:09', 0),
(13, 'post', 'http://127.0.0.1:8000/api/v1/admin/categories/store', 'Categories Add', NULL, '{\r\n    \"name\": \"Clothes\",\r\n    \"slug\": \"Clothes\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:19:47', '2025-03-18 05:19:47', 0),
(14, 'put', 'http://127.0.0.1:8000/api/v1/admin/categories/update/1', 'Categories Update', NULL, '{ \"name\": \"Clothes\", \"slug\": \"Clothes\", \"status\": true }', NULL, '2025-03-18 05:22:29', '2025-03-18 05:22:29', 0),
(15, 'delete', 'http://127.0.0.1:8000/api/v1/admin/subcategory', 'Subcategories Fetch', NULL, NULL, NULL, '2025-03-18 05:23:46', '2025-03-18 05:23:46', 0),
(16, 'post', 'http://127.0.0.1:8000/api/v1/admin/subcategory/store', 'Subcategories Add', NULL, '{\r\n    \"name\": \"men\",\r\n    \"slug\": \"Clothes\",\r\n    \"category\": 1,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:24:36', '2025-03-18 05:24:36', 0),
(17, 'put', 'http://127.0.0.1:8000/api/v1/admin/subcategory/update/1', 'Subcategories Update', NULL, '{ \"name\": \"men\", \"slug\": \"Clothes\", \"category\": 1, \"status\": true }', NULL, '2025-03-18 05:26:44', '2025-03-18 05:26:44', 0),
(18, 'delete', 'http://127.0.0.1:8000/api/v1/admin/subcategory/delete/2', 'Subcategories Delete', NULL, NULL, NULL, '2025-03-18 05:27:20', '2025-03-18 05:27:20', 0),
(19, 'post', 'http://127.0.0.1:8000/api/v1/admin/subsubcategory/store', 'SubSubcategories store', NULL, '{\r\n    \"name\": \"men\",\r\n    \"slug\": \"Clothes\",\r\n    \"category\": 1,\r\n    \"subcategory\": 3,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:28:54', '2025-03-18 05:28:54', 0),
(20, 'get', 'http://127.0.0.1:8000/api/v1/admin/subsubcategory', 'SubSubcategories Get', NULL, NULL, NULL, '2025-03-18 05:29:30', '2025-03-18 05:29:30', 0),
(21, 'put', 'http://127.0.0.1:8000/api/v1/admin/subsubcategory/update/1', 'SubSubcategories Update', NULL, '{\r\n    \"name\": \"shoes\",\r\n    \"slug\": \"shoes\",\r\n    \"category\": 1,\r\n    \"subcategory\": 3,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:30:32', '2025-03-18 05:30:32', 0),
(22, 'delete', 'http://127.0.0.1:8000/api/v1/admin/subsubcategory/delete/1', 'SubSubcategories Delete', NULL, NULL, NULL, '2025-03-18 05:31:13', '2025-03-18 05:31:13', 0),
(23, 'post', 'http://127.0.0.1:8000/api/v1/admin/brands/store', 'Brand Add', NULL, '{\r\n    \"name\": \"Gucci\",\r\n    \"slug\": \"Gucci\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:32:11', '2025-03-18 05:32:11', 0),
(24, 'put', 'http://127.0.0.1:8000/api/v1/admin/brands/update/2', 'Brand Update', NULL, '{ \"name\": \"Gucci\", \"slug\": \"Gucci\", \"status\": true }', NULL, '2025-03-18 05:32:49', '2025-03-18 05:32:49', 0),
(25, 'get', 'http://127.0.0.1:8000/api/v1/admin/brands', 'Brand Fetch', NULL, NULL, NULL, '2025-03-18 05:33:24', '2025-03-18 05:33:24', 0),
(26, 'delete', 'http://127.0.0.1:8000/api/v1/admin/brands/delete/1', 'Brand Delete', NULL, NULL, NULL, '2025-03-18 05:33:55', '2025-03-18 05:33:55', 0),
(27, 'post', 'http://127.0.0.1:8000/api/v1/admin/stock/store', 'Stock Add', NULL, '{\r\n    \"color_id\": 0,\r\n    \"size_id\": 0,\r\n    \"quantity\": 100,\r\n    \"select_product\": [26],\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:37:31', '2025-03-18 05:37:31', 0),
(28, 'put', 'http://127.0.0.1:8000/api/v1/admin/stock/update/4', 'Stock Update', NULL, '{ \"color_id\": 0, \"size_id\": 0, \"quantity\": 100, \"select_product\": [26], \"status\": true }', NULL, '2025-03-18 05:38:29', '2025-03-18 05:38:29', 0),
(29, 'get', 'http://127.0.0.1:8000/api/v1/admin/stock', 'Stock Fetch', NULL, NULL, NULL, '2025-03-18 05:39:33', '2025-03-18 05:39:33', 0),
(30, 'delete', 'http://127.0.0.1:8000/api/v1/admin/stock/delete/4', 'Stock Delete', NULL, NULL, NULL, '2025-03-18 05:40:22', '2025-03-18 05:40:22', 0),
(31, 'get', 'http://127.0.0.1:8000/api/v1/admin/users', 'User Fetch', NULL, NULL, NULL, '2025-03-18 05:41:11', '2025-03-18 05:41:11', 0),
(32, 'post', 'http://127.0.0.1:8000/api/v1/admin/users/store', 'User Add', NULL, '{\r\n    \"name\": \"www\",\r\n    \"email\": \"eem@gmail.com\",\r\n    \"phone\": 22222222222222,\r\n    \"password\": \"1243454\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:41:46', '2025-03-18 05:41:46', 0),
(33, 'post', 'http://127.0.0.1:8000/api/v1/admin/users/store', 'User Update', NULL, '{\r\n    \"name\": \"www\",\r\n    \"email\": \"eem@gmail.com\",\r\n    \"phone\": 22222222222222,\r\n    \"password\": \"1243454\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:42:41', '2025-03-18 05:42:41', 0),
(34, 'delete', 'http://127.0.0.1:8000/api/v1/admin/users/delete/7', 'User Delete', NULL, NULL, NULL, '2025-03-18 05:43:06', '2025-03-18 05:43:06', 0),
(35, 'post', 'http://127.0.0.1:8000/api/v1/admin/language/store', 'Language Add', NULL, '{\r\n    \"name\": \"Urdu\",\r\n    \"slug\": \"Urdu\",\r\n    \"isocode\": \"ur\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:45:04', '2025-03-18 05:45:04', 0),
(36, 'put', 'http://127.0.0.1:8000/api/v1/admin/language/update/2', 'Language update', NULL, '{\r\n    \"name\": \"Farsi\",\r\n    \"slug\": \"Farsi\",\r\n    \"Isocode\": \"fr\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:45:33', '2025-03-18 05:45:33', 0),
(37, 'delete', 'http://127.0.0.1:8000/api/v1/admin/language/delete/2', 'Language Delete', NULL, NULL, NULL, '2025-03-18 05:46:34', '2025-03-18 05:46:34', 0),
(38, 'get', 'http://127.0.0.1:8000/api/v1/admin/language', 'Language Fetch', NULL, NULL, NULL, '2025-03-18 05:47:48', '2025-03-18 05:47:48', 0),
(39, 'post', 'http://127.0.0.1:8000/api/v1/admin/shipping/store', 'Shipping Add', NULL, '{\r\n    \"country\": \"Afginastan\",\r\n    \"amount\": 400,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:48:43', '2025-03-18 05:48:43', 0),
(40, 'get', 'http://127.0.0.1:8000/api/v1/admin/shipping/index', 'Shipping Fetch', NULL, NULL, NULL, '2025-03-18 05:50:56', '2025-03-18 05:50:56', 0),
(41, 'put', 'http://127.0.0.1:8000/api/v1/admin/shipping/update/4', 'Shipping Update', NULL, '{\r\n    \"country\": 1,\r\n    \"amount\": 400,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:51:24', '2025-03-18 05:51:24', 0),
(42, 'delete', 'http://127.0.0.1:8000/api/v1/admin/shipping/delete/4', 'Shipping Delete', NULL, NULL, NULL, '2025-03-18 05:51:59', '2025-03-18 05:51:59', 0),
(43, 'post', 'http://127.0.0.1:8000/api/v1/admin/colorss/store', 'Color Add', NULL, '{\r\n    \"name\": \"RED\",\r\n    \"value\": \"#FF0000\",\r\n    \"price\": 5000,\r\n    \"product_id\": 1,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:53:10', '2025-03-18 05:53:10', 0),
(44, 'put', 'http://127.0.0.1:8000/api/v1/admin/colorss/update/5', 'Color Update', NULL, '{\r\n    \"name\": \"biege\",\r\n    \"value\": \"#FF0000\",\r\n    \"price\": 5000,\r\n    \"product_id\": 1,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:53:34', '2025-03-18 05:53:34', 0),
(45, 'get', 'http://127.0.0.1:8000/api/v1/admin/colorss/index', 'Color Fetch', NULL, NULL, NULL, '2025-03-18 05:53:48', '2025-03-18 05:53:48', 0),
(46, 'delete', 'http://127.0.0.1:8000/api/v1/admin/colorss/delete/5', 'Color Delete', NULL, NULL, NULL, '2025-03-18 05:54:05', '2025-03-18 05:54:05', 0),
(47, 'post', 'http://127.0.0.1:8000/api/v1/admin/sizes/store', 'Size Add', NULL, '{\r\n    \"name\": \"LArge\",\r\n    \"code\": \"L\",\r\n    \"price\": 4000,\r\n    \"product_id\": 1,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:54:36', '2025-03-18 05:54:36', 0),
(48, 'put', 'http://127.0.0.1:8000/api/v1/admin/sizes/update/4', 'Size Update', NULL, '{\r\n    \"name\": \"medium\",\r\n    \"code\": \"M\",\r\n    \"price\": 3000,\r\n    \"product_id\": 1,\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:55:00', '2025-03-18 05:55:00', 0),
(49, 'delete', 'http://127.0.0.1:8000/api/v1/admin/sizes/delete/4', 'Size Delete', NULL, NULL, NULL, '2025-03-18 05:55:51', '2025-03-18 05:55:51', 0),
(50, 'get', 'http://127.0.0.1:8000/api/v1/admin/sizes/index', 'Size Fetch', NULL, NULL, NULL, '2025-03-18 05:56:08', '2025-03-18 05:56:08', 0),
(51, 'get', 'http://127.0.0.1:8000/api/v1/admin/product', 'Product Fetch', NULL, NULL, NULL, '2025-03-18 05:57:46', '2025-03-18 05:57:46', 0),
(52, 'post', 'http://127.0.0.1:8000/api/v1/admin/product/store', 'Product Store', NULL, '{\r\n    \"title\": \"Sample Product\",\r\n    \"slug\": \"sample-product\",\r\n    \"price\": 199.99,\r\n    \"sku\": \"SP001\",\r\n    \"category\": 1,\r\n    \"is_featured\": 1,\r\n    \"short_description\": \"This is a short description.\",\r\n    \"description\": \"This is a longer product description.\",\r\n    \"shipping_return\": \"Shipping and return policy details.\",\r\n    \"related_product\": [\r\n        2,\r\n        3,\r\n        5\r\n    ],\r\n    \"image_array\": [\r\n        6\r\n    ],\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:59:01', '2025-03-18 05:59:01', 0),
(53, 'put', 'http://127.0.0.1:8000/api/v1/admin/product/update/28', 'Product Update', NULL, '{\r\n    \"title\": \"New Product\",\r\n    \"slug\": \"new-product\",\r\n    \"price\": 199.99,\r\n    \"sku\": \"SP001\",\r\n    \"category\": 1,\r\n    \"is_featured\": 1,\r\n    \"short_description\": \"This is a short description.\",\r\n    \"description\": \"This is a longer product description.\",\r\n    \"shipping_return\": \"Shipping and return policy details.\",\r\n    \"related_product\": [2, 3, 5],\r\n    \"image_array\": [6],\r\n    \"status\": true\r\n}', NULL, '2025-03-18 05:59:29', '2025-03-18 05:59:29', 0),
(54, 'delete', 'http://127.0.0.1:8000/api/v1/admin/product/delete/28', 'Product Delete', NULL, NULL, NULL, '2025-03-18 05:59:51', '2025-03-18 05:59:51', 0),
(55, 'get', 'http://127.0.0.1:8000/api/v1/admin/orders', 'Order Fetch', NULL, NULL, NULL, '2025-03-18 06:01:46', '2025-03-18 06:01:46', 0),
(56, 'get', 'http://127.0.0.1:8000/api/v1/admin/orders/18', 'Order Detail', NULL, NULL, NULL, '2025-03-18 06:02:11', '2025-03-18 06:02:11', 0),
(57, 'post', 'http://127.0.0.1:8000/api/v1/admin/orders/change_status/18', 'Order Detail Status', NULL, '{\r\n    \"shipped_date\": \"2025-02-14 00:00:00\",\r\n    \"status\": true\r\n}', NULL, '2025-03-18 06:02:47', '2025-03-18 06:02:47', 0),
(58, 'post', 'http://127.0.0.1:8000/api/v1/account/login', 'User Login', NULL, '{\r\n    \"email\": \"shery05977@gmail.com\",\r\n    \"password\": \"shery0598887@gmail.com\"\r\n}', NULL, '2025-03-18 11:17:27', '2025-03-18 11:17:27', 2),
(59, 'get', 'http://127.0.0.1:8000/api/v1/account/profile', 'User Profile', NULL, NULL, NULL, '2025-03-18 11:21:01', '2025-03-18 11:21:01', 2),
(60, 'get', 'http://127.0.0.1:8000/api/v1/index', 'Homepage Api', NULL, NULL, NULL, '2025-03-18 11:21:33', '2025-03-18 11:21:33', 2),
(61, 'get', 'http://127.0.0.1:8000/api/v1/search?search_query=laptop', 'Search Api', 'Search Api for frontend side', NULL, NULL, '2025-03-18 11:23:00', '2025-03-18 11:23:00', 2),
(62, 'get', 'http://127.0.0.1:8000/api/v1/account/my-orders', 'User Order Detail API', 'This Api is for featching user detail\r\nthis api in front side account section', NULL, NULL, '2025-03-18 11:24:29', '2025-03-18 11:24:29', 2),
(63, 'get', 'http://127.0.0.1:8000/api/v1/account/mywishlist', 'Whishlist APi', 'This api is also for the account section \r\nwhere we can find the faverite user products', NULL, NULL, '2025-03-18 11:25:45', '2025-03-18 11:25:45', 2),
(64, 'post', 'http://127.0.0.1:8000/api/v1/account/process-register', 'User Registeration API', 'this Api is for user Signup', '{\r\n    \"name\": \"Awais Shah\",\r\n    \"role\": 1,\r\n    \"phone\": \"0300000000001\",\r\n    \"email\": \"awaisshah05977@gmail.com\",\r\n    \"password\": \"awaisshah05977@gmail.com\",\r\n    \"password_confirmation\":\"awaisshah05977@gmail.com\"\r\n  }', NULL, '2025-03-18 11:26:52', '2025-03-18 11:26:52', 2),
(65, 'post', 'http://127.0.0.1:8000/api/v1/account/logout', 'User Logot', 'This API is for the User Logout', NULL, NULL, '2025-03-18 11:28:08', '2025-03-18 11:28:08', 2),
(66, 'get', 'http://127.0.0.1:8000/api/v1/product/Laptop', 'Product Page APi', 'API is for product page, when click on the product \r\nit show the all detail of the product', NULL, NULL, '2025-03-18 11:29:52', '2025-03-18 11:29:52', 2),
(67, 'get', 'http://127.0.0.1:8000/api/v1/shop/Fashion', 'Cagegory API', 'when pass the category at the url it \r\nshow the cateory related products', NULL, NULL, '2025-03-18 11:33:28', '2025-03-18 11:33:28', 2),
(68, 'post', 'http://127.0.0.1:8000/api/v1/apply-discount', 'Add Coupon Discount', 'This API is used for applying the coupon discount', '{\r\n\"code\": \"ZU9MMQZ1\",\r\n\"country_id\": \"\"\r\n}', '{\r\n    \"status\": true,\r\n    \"discount\": \"<strong>20%</strong>\",\r\n    \"discountString\": \"<div class=\\\"mt-4\\\">\\n            <strong>ZU9MMQZ1</strong>\\n            <a class=\\\"btn btn-sm btn-danger\\\" id=\\\"remove-discount\\\" ><i class=\\\"fa fa-times\\\"></i></a>\\n        </div>\",\r\n    \"shipping_charge\": \"0\",\r\n    \"grand_total\": \"1,120.00\"\r\n}', '2025-04-16 01:39:36', '2025-04-16 01:39:36', 2),
(69, 'post', 'http://127.0.0.1:8000/api/v1/process-checkout', 'Checkout COD API', NULL, '{\r\n  \"firstname\": \"Muhammad\",\r\n  \"lastname\": \"Asif\",\r\n  \"email\": \"sp21-rcs-010@cuiatk.edu.pk\",\r\n  \"country\": \"9\",\r\n  \"address\": \"Hattian ,Attock, Rawalpindi, Pakistan\",\r\n  \"apartment\": \"\",\r\n  \"city\": \"Attock City\",\r\n  \"state\": \"punjab\",\r\n  \"zip\": \"43580\",\r\n  \"mobile\": \"03175038179\",\r\n  \"order_notes\": \"dddddd\",\r\n  \"discount_code\": \"ZU9MMQZ1\",\r\n  \"payment_method\": \"cod\",\r\n  \"stripeToken\": \"\"\r\n}', '{\r\n    \"status\": true,\r\n    \"message\": \"Order Saved Successfully\",\r\n    \"orderId\": 20\r\n}', '2025-04-16 01:47:41', '2025-04-16 01:47:41', 2),
(70, 'get', 'http://127.0.0.1:8000/api/v1/admin/onboarding', 'Onboarding Fetch Api', 'Onboarding Fetch Api', NULL, NULL, '2025-05-19 11:16:00', '2025-05-19 11:16:00', 0),
(71, 'post', 'http://127.0.0.1:8000/api/v1/admin/onboarding/store', 'Onboarding Post API', NULL, '{\r\n    \"title\":\"admin123\",\r\n    \"subtitle\":\"dhsjksdkf\",\r\n    \"image\":\"dhsjksdkf.jpg\"\r\n}', NULL, '2025-05-19 11:19:52', '2025-05-19 11:19:52', 0),
(72, 'put', 'http://127.0.0.1:8000/api/v1/admin/onboarding/update/12', 'Onboarding Update API', NULL, '{\r\n    \"title\":\"ffffffffffffff\",\r\n    \"subtitle\":\"hhhhhhhh\",\r\n    \"image\":\"hhhhhhhhn.jpg\"\r\n}', NULL, '2025-05-19 11:32:43', '2025-05-19 11:32:43', 0),
(73, 'delete', 'http://127.0.0.1:8000/api/v1/admin/onboarding/delete/12', 'Onboarding Delete API', 'it can delete the onboard data', NULL, NULL, '2025-05-19 11:35:00', '2025-05-19 11:35:00', 0),
(74, 'get', 'http://127.0.0.1:8000/api/v1/admin/themes/index', 'Get Themes', 'this apis is used for the fetch theme', NULL, NULL, '2025-06-13 00:51:33', '2025-06-13 00:51:33', 0),
(75, 'post', 'http://127.0.0.1:8000/api/v1/admin/themes/store', 'Add Theme', 'The API is used for the Add theme', '{\r\n    \"theme_name\": \"ALi\",\r\n    \"theme_color_code\": \"#000000\",\r\n    \"theme_status\": 0,\r\n    \"theme_isset_status\": 0\r\n}', NULL, '2025-06-13 00:52:58', '2025-06-13 00:52:58', 0),
(76, 'put', 'http://127.0.0.1:8000/api/v1/admin/themes/3/update', 'Update Theme', 'This API is used for update theme', '{ \"theme_name\": \"ALi\", \"theme_color_code\": \"#000000\", \"theme_status\": 0, \"theme_isset_status\": 0 }', NULL, '2025-06-13 00:54:06', '2025-06-13 00:54:06', 0),
(77, 'delete', 'http://127.0.0.1:8000/api/v1/admin/themes/3/delete', 'Delete Theme', 'The API is used for Delete theme', NULL, '{\r\n    \"status\": true,\r\n    \"message\": \"Theme deleted successfully\"\r\n}', '2025-06-13 00:55:30', '2025-06-13 00:55:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `color_id`, `size_id`, `created_at`, `updated_at`) VALUES
(87, 3, 2, NULL, NULL, '2025-12-16 05:24:36', '2025-12-16 05:24:36'),
(88, 3, 25, NULL, NULL, '2025-12-16 05:24:36', '2025-12-16 05:24:36'),
(89, 3, 26, NULL, NULL, '2025-12-16 05:24:37', '2025-12-16 05:24:37'),
(90, 2, 2, NULL, NULL, '2026-01-04 10:26:08', '2026-01-04 10:26:08'),
(91, 2, 1, NULL, NULL, '2026-01-04 10:26:09', '2026-01-04 10:26:09'),
(92, 2, 26, NULL, NULL, '2026-02-04 02:51:34', '2026-02-04 02:51:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_coupon_amounts`
--
ALTER TABLE `cart_coupon_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `homepage_labels`
--
ALTER TABLE `homepage_labels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `homepage_labels_label_key_unique` (`label_key`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_items`
--
ALTER TABLE `orders_items`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_view`
--
ALTER TABLE `product_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_onboarding`
--
ALTER TABLE `table_onboarding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `webservices`
--
ALTER TABLE `webservices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `cart_coupon_amounts`
--
ALTER TABLE `cart_coupon_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `homepage_labels`
--
ALTER TABLE `homepage_labels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `orders_items`
--
ALTER TABLE `orders_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_view`
--
ALTER TABLE `product_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_onboarding`
--
ALTER TABLE `table_onboarding`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `webservices`
--
ALTER TABLE `webservices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
