-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2024 at 03:17 PM
-- Server version: 8.0.33
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uueziobj_artist`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int NOT NULL,
  `artist_id` int NOT NULL,
  `message` text,
  `availability` date NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `artist_id`, `message`, `availability`, `user_id`, `created_at`) VALUES
(3, 15, 'Api test description', '2024-02-14', 16, '2024-02-11 21:16:17'),
(6, 17, 'Api test description', '2024-02-14', 16, '2024-02-12 22:09:56'),
(7, 17, 'Api test description new', '2024-02-14', 16, '2024-02-12 22:09:59'),
(8, 17, 'Api test description new', '2024-02-14', 16, '2024-02-13 18:43:30'),
(9, 18, 'dfgdsfgdsfg', '2024-02-22', 14, '2024-02-22 12:19:28'),
(10, 33, 'sdsdsd', '2024-02-23', 18, '2024-02-22 14:58:11'),
(11, 34, 'hfyjtfjy', '2024-02-22', 14, '2024-02-22 17:31:56'),
(12, 18, 'hfyjtfjy', '2024-02-22', 14, '2024-02-22 17:36:57'),
(13, 33, 'messageqqqqqq', '2024-03-01', 18, '2024-02-26 19:44:32'),
(14, 34, 'messageqqqqqq', '2024-02-09', 18, '2024-02-26 19:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `artist_data`
--

CREATE TABLE `artist_data` (
  `id` int NOT NULL,
  `artist_id` int NOT NULL,
  `hourly_rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '100',
  `specialty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `years_in_trade` int DEFAULT '2',
  `walk_in_welcome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `certified_professionals` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `consultation_available` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `language_spoken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'English',
  `parking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Cash',
  `air_conditioned` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `water_available` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `coffee_available` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `mask_worn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `vaccinated_staff` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `wheel_chair_accessible` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `bike_parking` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `wifi_available` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'yes',
  `artist_of_the_year` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `insta_handle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook_handle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube_handle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter_handle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `google_map_api` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `yelp_api` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_percentage` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '40',
  `shop_email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist_data`
--

INSERT INTO `artist_data` (`id`, `artist_id`, `hourly_rate`, `specialty`, `years_in_trade`, `walk_in_welcome`, `certified_professionals`, `consultation_available`, `language_spoken`, `parking`, `payment_method`, `air_conditioned`, `water_available`, `coffee_available`, `mask_worn`, `vaccinated_staff`, `wheel_chair_accessible`, `bike_parking`, `wifi_available`, `artist_of_the_year`, `insta_handle`, `facebook_handle`, `youtube_handle`, `twitter_handle`, `google_map_api`, `yelp_api`, `shop_logo`, `shop_percentage`, `shop_email`, `shop_name`, `shop_address`, `created_at`, `updated_at`) VALUES
(2, 38, '18', '41', 1971, 'no', 'no', 'yes', 'Spanish,French,Italian,Chinese,Farsi', 'no', 'CC,Venomo,CashApp,Paypal,ApplePay,GooglePay', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'https://www.fifoqutafapi.net', 'https://www.qod.cm', 'https://www.gakur.org.uk', 'https://www.nijymexo.org.au', 'Sit sit voluptas d', 'Ad est dicta necessi', NULL, 'Magna quo rerum volu', 'zimepixor@mailinator.com', 'Paki Neal', 'Sed at ad eaque nesc', '2024-05-05 19:48:44', '2024-05-05 19:48:44'),
(3, 39, '50', '9', 2004, 'yes', 'yes', 'yes', 'Spanish,Farsi', 'yes', 'CC,Zelle,CashApp,Paypal,ApplePay,GooglePay', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'https://www.qilox.mobi', 'https://www.sejyvek.us', 'https://www.namenup.com', 'https://www.waheradegevyj.in', 'Qui tempor accusamus', 'Et eum nisi laudanti', '17149915612003.jpg', 'In est debitis cillu', 'neel.bandyopadhyay@codeclouds.co.in', 'Nina Lott', 'Laudantium dolor qu', '2024-05-05 20:02:15', '2024-05-06 13:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_view` int NOT NULL DEFAULT '0',
  `style_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `placement_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`id`, `user_id`, `title`, `total_view`, `style_id`, `subject_id`, `placement_id`, `created_at`, `updated_at`, `image`, `zipcode`, `country`) VALUES
(18, 14, 'debashis_012324_1', 0, 4, 5, 4, '2024-01-23 11:08:20', '2024-01-31 14:24:08', 'debashis_012324_1.webp', '700158', 'United States of America'),
(19, 14, 'debashis_012324_2', 0, 3, 4, 3, '2024-01-23 11:28:41', '2024-01-31 14:23:44', 'debashis_012324_2.webp', '700158', 'United States of America'),
(20, 14, 'debashis_012324_3', 0, 2, 2, 2, '2024-01-23 13:10:42', '2024-01-31 14:23:25', 'debashis_012324_3.webp', '700158', 'United States of America'),
(21, 12, 'debashis_012424_1', 0, 1, 1, 1, '2024-01-24 11:11:42', '2024-01-24 11:11:42', 'debashis_012424_1.webp', '700158', 'United States of America'),
(22, 16, 'supriyo dey_020224_1', 0, 2, 13, 1, '2024-02-02 12:22:11', '2024-02-02 12:22:11', 'supriyo dey_020224_1.webp', '1234567', 'United States of America'),
(23, 16, 'supriyo dey_021124_1', 0, 1, 2, 2, '2024-02-11 08:53:16', '2024-02-11 08:53:16', 'supriyo dey_021124_1.png', '1234567', 'United States of America'),
(24, 20, 'caymus_022524_1', 0, 12, 45, 2, '2024-02-25 12:15:58', '2024-02-25 12:15:58', 'caymus_022524_1.webp', '90802', 'United States of America'),
(25, 20, 'caymus_022524_2', 0, 1, 38, 6, '2024-02-25 12:18:06', '2024-02-25 12:18:06', 'caymus_022524_2.webp', '90802', 'United States of America'),
(28, 18, 'banerjee_neel_030124_1', 0, 3, 3, 3, '2024-03-01 17:30:14', '2024-03-01 17:30:14', 'banerjee_neel_030124_1.png', '1234567', 'United States of America'),
(29, 33, 'test_artist_1_042324_1', 0, 3, 2, 3, '2024-04-23 05:36:47', '2024-04-23 05:36:47', 'test_artist_1_042324_1.png', '10016', 'United States of America'),
(30, 34, 'test_artist_2_042324_1', 0, 1, 2, 1, '2024-04-23 07:44:22', '2024-05-08 02:23:33', 'test_artist_2_042324_1.png', '11201', 'United States of America');

-- --------------------------------------------------------

--
-- Table structure for table `banner_images`
--

CREATE TABLE `banner_images` (
  `id` bigint UNSIGNED NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_images`
--

INSERT INTO `banner_images` (`id`, `banner_image`, `user_id`, `description`, `from_date`, `to_date`, `created_at`, `updated_at`) VALUES
(7, '17058420251734.png', 14, NULL, NULL, NULL, '2024-01-21 07:30:25', '2024-01-21 07:30:25'),
(9, '1708883305673.jpg', 20, NULL, NULL, NULL, '2024-02-25 12:18:25', '2024-02-25 12:18:25'),
(10, '17089752242680.PNG', 18, NULL, NULL, NULL, '2024-02-26 13:50:24', '2024-02-26 13:50:24'),
(11, '17144701766286.png', 33, NULL, NULL, NULL, '2024-04-30 04:12:56', '2024-04-30 04:12:56'),
(13, '17144702234988.png', 34, NULL, NULL, NULL, '2024-04-30 04:13:43', '2024-04-30 04:13:43'),
(15, '17149286931109.jpeg', 34, 'rtrt', '2024-05-05', '2024-05-31', '2024-05-05 11:34:53', '2024-05-05 11:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `artwork_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `artwork_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 12, 'test comment', NULL, NULL),
(5, 20, 14, 'jsdbhfjbs,dfbj,sdbf', NULL, NULL),
(6, 25, 20, 'This is a picture of my son near a truck working with me', NULL, NULL),
(10, 28, 18, 'cool artwork...!', '2024-03-01 23:06:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expense_items` enum('advertising','ink','tools','clothing','insurance','ccfees') COLLATE utf8mb4_general_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `user_id`, `transaction_date`, `payment_method`, `amount`, `expense_items`, `note`, `created_at`, `updated_at`) VALUES
(2, 34, '2024-02-12', 'Zelle', '100', 'tools', 'this is a test note', '2024-02-12 00:43:00', '2024-05-08 02:34:00'),
(3, 20, '2024-02-25', 'PayPal', '200', 'ink', 'ink restock', '2024-02-25 00:43:49', NULL),
(4, 20, '2024-02-21', 'Check', '500', 'clothing', 'new shirts', '2024-02-25 00:45:15', NULL),
(5, 18, '2024-02-27', 'Credit Card', '4524', 'clothing', '45454', '2024-02-26 01:56:43', '2024-03-02 00:07:02'),
(6, 18, '2024-02-29', 'Debit Card', '100', 'tools', 'This is a test creation.', '2024-03-02 00:08:47', NULL),
(7, 34, '2024-05-08', 'Cash', '100', 'advertising', 'This is a test note.', '2024-05-08 02:34:26', '2024-05-08 02:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED NOT NULL,
  `artwork_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `artwork_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 2, 9, '2023-12-01 11:40:41', '2023-12-01 11:40:41'),
(5, 18, 14, '2024-01-23 11:08:58', '2024-01-23 11:08:58'),
(26, 25, 18, '2024-02-26 16:39:19', '2024-02-26 16:39:19'),
(29, 20, 18, '2024-02-26 16:45:22', '2024-02-26 16:45:22'),
(31, 19, 23, '2024-02-26 17:07:44', '2024-02-26 17:07:44');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_11_10_100002_create_styles_table', 1),
(7, '2023_11_10_100016_create_subjects_table', 1),
(8, '2023_11_10_100035_create_placements_table', 1),
(9, '2023_11_11_093344_create_artworks_table', 1),
(10, '2023_11_11_094201_create_likes_table', 1),
(11, '2023_11_11_094254_create_total_views_table', 1),
(12, '2023_11_11_095924_create_comments_table', 1),
(13, '2023_11_12_024347_add_fields_to_artworks_table', 2),
(14, '2023_11_18_100221_create_time_tables_table', 3),
(15, '2023_11_22_164541_create_banner_images_table', 4),
(16, '2023_11_26_162122_add_fields_to_artworks', 5),
(17, '2023_12_11_180339_add_fields_to_users', 6),
(18, '2023_12_19_170513_create_quotes_table', 6),
(19, '2023_12_21_165943_add_fields_to_quotes', 7),
(21, '2024_02_10_201528_add_columns_to_quotes_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `artist_id` int DEFAULT NULL,
  `customers_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `design` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `placement` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `deposit` decimal(10,2) DEFAULT NULL,
  `tips` decimal(10,2) DEFAULT NULL,
  `fees` decimal(10,2) DEFAULT NULL,
  `total_due` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('atm_debit','cash','credit_card','gift_card') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bill_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `artist_id`, `customers_name`, `design`, `placement`, `price`, `deposit`, `tips`, `fees`, `total_due`, `payment_method`, `bill_image`, `date`) VALUES
(2, 18, 18, 'a', 'a', '4', 44.00, 44.00, 44.00, 44.00, 0.00, 'atm_debit', '/storage/DepositSlip/paypal-btn.png', '2024-03-15'),
(3, 17, 14, 'test', 'test', '2', 20000.00, 440.00, 500.00, 500.00, 500.00, 'atm_debit', '/storage/DepositSlip/1.PNG', '2024-01-31'),
(4, 16, 14, 'test', 'dragon', '2', 100.00, 50.00, 10.00, 40.00, 10.00, 'credit_card', '/storage/DepositSlip/Neel Deep Bandyopadhyay.jpg', '2024-02-07'),
(5, 20, 15, 'JohnDoe', 'eagle', '2', 250.00, 100.00, 25.00, 100.00, 150.00, 'cash', '/storage/DepositSlip/IMG_20170119_110244.jpg', '2024-02-25'),
(7, 18, 12, 'Neel Banerjee', 'Silk', '2', 14.95, 10.00, 2.00, 6.00, 4.00, 'atm_debit', '/storage/DepositSlip/paypal-btn.png', '2024-03-01'),
(8, 18, 18, 'sdsd', 'Silk', '3', 14.95, 10.00, 2.00, 6.00, 4.00, 'atm_debit', '/storage/DepositSlip/architectural-03.jpg', '2024-03-15'),
(9, 18, 14, 'Neel Banerjee', 'Silk', '3', 14.95, 10.00, 2.00, 6.00, 4.00, 'credit_card', '/storage/DepositSlip/ltwtemplates-com-localhost-ltwtemplates_v2_flex-shiphero_orders-phpMyAdmin-5-2-1.png', '2024-04-30'),
(10, 30, 33, 'Neel Banerjee', 'Silk', '2', 14.95, 10.00, 2.00, 6.00, 4.00, 'credit_card', '/storage/DepositSlip/paypal-btn.png', '2024-04-30'),
(11, 30, 34, 'Neel Banerjee', 'Silk', '3', 14.95, 10.00, 2.00, 6.00, 4.00, 'cash', '/storage/DepositSlip/0513 _ CC wallpapers 2023 WINTER DARK 1920x1080px.jpg', '2024-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 5, 'loginUser', '8cc32a74e41d08f6025a2ba4bbed97b5fd8e3234e79760934a9cf72ec774370a', '[\"*\"]', NULL, NULL, '2023-11-12 08:10:47', '2023-11-12 08:10:47'),
(2, 'App\\Models\\User', 5, 'loginUser', 'da4ba973c39f69c2257e862f68d7488ef0a05fdd1f55e7ccca9a6a555df4e1fd', '[\"*\"]', NULL, NULL, '2023-11-12 08:13:58', '2023-11-12 08:13:58'),
(3, 'App\\Models\\User', 5, 'loginUser', '0200e34f78747b025aad581663ab336c911ce991c941065401b5c3459c09c605', '[\"*\"]', NULL, NULL, '2023-11-12 08:16:28', '2023-11-12 08:16:28'),
(4, 'App\\Models\\User', 5, 'loginUser', '974bb9fc26fe0bb8a0ae6546ffc3a6f842d4c4117ff7f393b7e42e1daf9ad75e', '[\"*\"]', NULL, NULL, '2023-11-12 08:16:36', '2023-11-12 08:16:36'),
(5, 'App\\Models\\User', 5, 'loginUser', 'd159e4de7cb8d39bb8f472dbacf837d0383536d6a70b4df7b622290041532b34', '[\"*\"]', NULL, NULL, '2023-11-12 08:16:47', '2023-11-12 08:16:47'),
(6, 'App\\Models\\User', 5, 'loginUser', '8354afee132746815f0098af302755543b646ec4959b0cc6e1c91a0f423f692f', '[\"*\"]', NULL, NULL, '2023-11-12 08:20:33', '2023-11-12 08:20:33'),
(7, 'App\\Models\\User', 5, 'loginUser', '18b0c4f2a280990e1de4744385b40472e985d796c597ec524bfb42685c52a957', '[\"*\"]', '2023-11-22 10:56:28', NULL, '2023-11-12 08:21:07', '2023-11-22 10:56:28'),
(8, 'App\\Models\\User', 9, 'loginUser', 'f92b7c49dec0367471526f5532c16b3a9b2686003d7ec336e5b5391924b2923c', '[\"*\"]', '2023-12-21 10:16:20', NULL, '2023-11-22 10:58:25', '2023-12-21 10:16:20'),
(9, 'App\\Models\\User', 9, 'loginUser', '4ded3e59d9fc7387fb118bf3b1dc18888afea2daaa514acf4c8ed3aeb480a776', '[\"*\"]', '2023-11-23 11:26:32', NULL, '2023-11-23 11:01:51', '2023-11-23 11:26:32'),
(10, 'App\\Models\\User', 9, 'loginUser', '307a6d0f0f0a10861ed8e8dce4de7e9d756188dc91244d34512b9752b107c442', '[\"*\"]', '2023-12-21 11:37:33', NULL, '2023-12-21 10:19:22', '2023-12-21 11:37:33'),
(11, 'App\\Models\\User', 10, 'loginUser', 'f7ebc6d0503d83a0304df9fbd634e70e7c66749d184c103886b24821cb96041e', '[\"*\"]', '2023-12-23 04:36:13', NULL, '2023-12-23 04:30:24', '2023-12-23 04:36:13'),
(12, 'App\\Models\\User', 11, 'loginUser', '7687e71f3fad9239e19fd389eebd2fdb2ad1413ba397759fe662a396d300799b', '[\"*\"]', '2024-01-15 12:28:11', NULL, '2024-01-15 12:28:11', '2024-01-15 12:28:11'),
(13, 'App\\Models\\User', 11, 'loginUser', 'acb544d20a6f1e1e30c3a28774f5c8314dbf14ece345c566978b2421dd6bf5a7', '[\"*\"]', '2024-01-15 12:33:16', NULL, '2024-01-15 12:28:11', '2024-01-15 12:33:16'),
(14, 'App\\Models\\User', 12, 'loginUser', '6fe690e68f33b484b00a738c1d0699fdec605a4c949d112457bdb4e01c715fbb', '[\"*\"]', '2024-01-16 08:55:44', NULL, '2024-01-15 12:33:46', '2024-01-16 08:55:44'),
(15, 'App\\Models\\User', 11, 'loginUser', '09c785141d748c4a8a236677232bba8cc0333665697f7de46181db5bc87e0a5c', '[\"*\"]', '2024-01-16 10:55:10', NULL, '2024-01-16 10:48:14', '2024-01-16 10:55:10'),
(16, 'App\\Models\\User', 11, 'loginUser', '5acadd25061b89c28ff2ea7ac9a2e75b29a60f566b5c019adf7e6584136c0c30', '[\"*\"]', '2024-01-20 17:54:01', NULL, '2024-01-20 17:48:57', '2024-01-20 17:54:01'),
(17, 'App\\Models\\User', 12, 'loginUser', 'c5c2688b738d132d27655fbff889454286b0255d7bcfb263ab6b8bfbee63e351', '[\"*\"]', '2024-01-20 17:59:25', NULL, '2024-01-20 17:54:49', '2024-01-20 17:59:25'),
(18, 'App\\Models\\User', 13, 'loginUser', '1797e39986bc7514e99d479fecde4a1f3eef8790fac7cd31328b12ad99e92cf6', '[\"*\"]', '2024-01-20 18:04:01', NULL, '2024-01-20 18:00:33', '2024-01-20 18:04:01'),
(19, 'App\\Models\\User', 11, 'loginUser', '953fe76c960a8fd5aa5455a54498d01beb49d0edc98023997450b0b9fc726f2e', '[\"*\"]', '2024-01-28 15:02:03', NULL, '2024-01-20 18:04:23', '2024-01-28 15:02:03'),
(20, 'App\\Models\\User', 14, 'loginUser', '7dad8762b633058c30647becae5c900e29cc15b287ecf81bc8e6c91bd56543fe', '[\"*\"]', '2024-02-16 10:43:39', NULL, '2024-01-21 07:29:49', '2024-02-16 10:43:39'),
(21, 'App\\Models\\User', 14, 'loginUser', 'df0668b33ebe31438bc65421ae000d1146abd0bc188ea0a0120d679442b92ba1', '[\"*\"]', '2024-01-21 07:31:51', NULL, '2024-01-21 07:31:50', '2024-01-21 07:31:51'),
(22, 'App\\Models\\User', 14, 'loginUser', 'a7c7563fef442593ec499730c5120913a9c9a3560d793a514b9e0d247976d911', '[\"*\"]', '2024-01-23 11:04:31', NULL, '2024-01-21 07:31:50', '2024-01-23 11:04:31'),
(23, 'App\\Models\\User', 15, 'loginUser', '48c6230cab6f73dd1432ec953103b11b81388b43023086d5f7dd1304e3926f87', '[\"*\"]', '2024-01-28 15:04:58', NULL, '2024-01-28 15:04:01', '2024-01-28 15:04:58'),
(24, 'App\\Models\\User', 16, 'loginUser', '131759c4c9bf0a867d2387ac428bd62ad2e0a022a359d5f7946a86678894efd9', '[\"*\"]', '2024-01-31 04:31:15', NULL, '2024-01-31 04:31:14', '2024-01-31 04:31:15'),
(25, 'App\\Models\\User', 16, 'loginUser', '70221de5d79751da545787b92ecd1cc1f1d92d31074550c1d46f19d3cb293ff8', '[\"*\"]', '2024-02-15 12:01:30', NULL, '2024-01-31 04:31:14', '2024-02-15 12:01:30'),
(26, 'App\\Models\\User', 14, 'loginUser', 'd6c9df9174cb9c92278f4cd4f39995c8798beca922415eaf76bd499a28989696', '[\"*\"]', NULL, NULL, '2024-02-01 05:28:19', '2024-02-01 05:28:19'),
(27, 'App\\Models\\User', 14, 'loginUser', '2480de5a10012f26c315fb5179deeefb899fa5c437d140d29f13bd26dd1b6dae', '[\"*\"]', NULL, NULL, '2024-02-01 05:28:28', '2024-02-01 05:28:28'),
(28, 'App\\Models\\User', 14, 'loginUser', '68720c9cceccf0d881b819d9b74241dc4f1d35b7c0812f00e00d32fe0ab81121', '[\"*\"]', NULL, NULL, '2024-02-01 05:29:54', '2024-02-01 05:29:54'),
(29, 'App\\Models\\User', 14, 'loginUser', '8ca363d6b5f62d6d54b2416d90e325e19c6626c9828883985b87c32005eecd34', '[\"*\"]', NULL, NULL, '2024-02-01 05:30:08', '2024-02-01 05:30:08'),
(30, 'App\\Models\\User', 14, 'loginUser', 'f39aa239984c56a9713cb8123b869436645bc79b090710e61b816516afb7e14a', '[\"*\"]', NULL, NULL, '2024-02-01 05:30:21', '2024-02-01 05:30:21'),
(31, 'App\\Models\\User', 14, 'loginUser', '6e26f6e527d6893cf9118352e1a7ec34eddac745a521e039022969af30828451', '[\"*\"]', NULL, NULL, '2024-02-01 05:30:22', '2024-02-01 05:30:22'),
(32, 'App\\Models\\User', 14, 'loginUser', 'dd748a6c5d8fd138bfd4f94414ddc4c16f8aa9142731a7fb36bc2847e5f0bff9', '[\"*\"]', NULL, NULL, '2024-02-01 05:31:04', '2024-02-01 05:31:04'),
(33, 'App\\Models\\User', 14, 'loginUser', 'c6af6c57b0904acea9ffca6a9744fe7e2b39e4d01427efba0d67d986785b2a8f', '[\"*\"]', NULL, NULL, '2024-02-01 05:31:07', '2024-02-01 05:31:07'),
(34, 'App\\Models\\User', 14, 'loginUser', '0617000b221748aea4220612fc402625b1cf796017f8494fb1247c1d1db3ff4c', '[\"*\"]', NULL, NULL, '2024-02-01 05:31:12', '2024-02-01 05:31:12'),
(35, 'App\\Models\\User', 14, 'loginUser', '9508c5d265016a34e37c449d1489a52c86acb2a1eac6046591db0d46cc9a1978', '[\"*\"]', NULL, NULL, '2024-02-01 05:31:56', '2024-02-01 05:31:56'),
(36, 'App\\Models\\User', 14, 'loginUser', '839d302cf0d45ae6d4707d22be4b27894393e3ab47c4a5943c948239e5c118ee', '[\"*\"]', NULL, NULL, '2024-02-01 05:32:01', '2024-02-01 05:32:01'),
(37, 'App\\Models\\User', 16, 'loginUser', '3a0625006d4317f6428ad7193fc272e77a0967f08779190e7830d29853787561', '[\"*\"]', NULL, NULL, '2024-02-02 07:58:17', '2024-02-02 07:58:17'),
(38, 'App\\Models\\User', 16, 'loginUser', '55d8c0d264894c03c029bac362d6d231c9196fbf7d1fa4c3c8e3fc498a421304', '[\"*\"]', NULL, NULL, '2024-02-02 07:58:28', '2024-02-02 07:58:28'),
(39, 'App\\Models\\User', 16, 'loginUser', 'bf495d30d6ed121c5a1d37f58b286300124c887109c3f730ce44cd7f1959fd8f', '[\"*\"]', NULL, NULL, '2024-02-02 07:58:31', '2024-02-02 07:58:31'),
(40, 'App\\Models\\User', 16, 'loginUser', '6d77711b9ead18bae2a0b30cf2c8eded659ee5142a1ae8bc4def3052e13a35cb', '[\"*\"]', NULL, NULL, '2024-02-02 07:58:35', '2024-02-02 07:58:35'),
(41, 'App\\Models\\User', 16, 'loginUser', 'cc46902aeab25ab9c4924f20ab973a00795785784a8d79266283f481e1f95226', '[\"*\"]', '2024-02-07 15:33:08', NULL, '2024-02-07 15:33:08', '2024-02-07 15:33:08'),
(42, 'App\\Models\\User', 16, 'loginUser', 'c400affce2c64965ed19a05155722f51f19a3c5a7098c0a7fd36cd10a68885fc', '[\"*\"]', '2024-02-08 12:14:42', NULL, '2024-02-08 12:13:49', '2024-02-08 12:14:42'),
(43, 'App\\Models\\User', 16, 'loginUser', '155d80db50bbd5abb6bd8ed11b8100dae0998f8308ea839f0890db555afd54d8', '[\"*\"]', '2024-02-08 12:25:27', NULL, '2024-02-08 12:15:01', '2024-02-08 12:25:27'),
(44, 'App\\Models\\User', 16, 'loginUser', '4848d009ffaa529f63a877a74186237939e8a223fb1700e2e88dbd9485ae9f54', '[\"*\"]', '2024-02-10 16:44:07', NULL, '2024-02-08 12:17:32', '2024-02-10 16:44:07'),
(45, 'App\\Models\\User', 16, 'loginUser', 'fb4dc1d85b2ba99fcf181e4c7a624c8f0244e7c56f1cd20ae71a1f08eebcd78e', '[\"*\"]', '2024-02-10 16:46:25', NULL, '2024-02-10 13:51:02', '2024-02-10 16:46:25'),
(46, 'App\\Models\\User', 16, 'loginUser', 'f6cd8a1b5c374a9d0f427653711796f2de19ed249bb74ef8557acb72c672b050', '[\"*\"]', NULL, NULL, '2024-02-10 16:43:26', '2024-02-10 16:43:26'),
(47, 'App\\Models\\User', 16, 'loginUser', 'c8a0953db4dc221b9e20c2d35ddab5252168a6d2c6a10b0a473f657f47ad3875', '[\"*\"]', '2024-02-11 10:55:46', NULL, '2024-02-10 16:47:14', '2024-02-11 10:55:46'),
(48, 'App\\Models\\User', 16, 'loginUser', '819661e134132021233fca394bbafe3360343ad28667a875fe3855f0f92c547d', '[\"*\"]', '2024-02-17 12:58:31', NULL, '2024-02-11 00:03:44', '2024-02-17 12:58:31'),
(49, 'App\\Models\\User', 14, 'loginUser', '7494c05efbcd0a0895a32271c550bb092dbe3912fdf796316c4b5d13e45af08c', '[\"*\"]', NULL, NULL, '2024-02-14 01:45:10', '2024-02-14 01:45:10'),
(50, 'App\\Models\\User', 14, 'loginUser', '590599bd4132589b86c2394fc81bd23d6cebad414fd946bc65f472bd5b56731b', '[\"*\"]', NULL, NULL, '2024-02-14 01:45:18', '2024-02-14 01:45:18'),
(51, 'App\\Models\\User', 14, 'loginUser', '81ff7e651d19b7940194be73b1ea5decdebf1e5d3424b7dd48f95c17e097d41b', '[\"*\"]', NULL, NULL, '2024-02-14 01:45:46', '2024-02-14 01:45:46'),
(52, 'App\\Models\\User', 14, 'loginUser', '183e7803496efd8028e3b440c23d2d22852f6036d1ad8d8d47e791380a8bdbf9', '[\"*\"]', NULL, NULL, '2024-02-14 01:49:27', '2024-02-14 01:49:27'),
(53, 'App\\Models\\User', 14, 'loginUser', '7c2c13662a695d9f0af7993bd262edd0b5378f18ef515663283d75ec86b46bc4', '[\"*\"]', NULL, NULL, '2024-02-14 01:50:00', '2024-02-14 01:50:00'),
(54, 'App\\Models\\User', 14, 'loginUser', '699ed1788f00fc7a6cd5373f132aa97c22b0bce44faccf5bd790971702e804fa', '[\"*\"]', NULL, NULL, '2024-02-14 02:12:50', '2024-02-14 02:12:50'),
(55, 'App\\Models\\User', 14, 'loginUser', 'f77ae25b345fc03a66837841737d807288d85ec73469e641098a3d3439b03933', '[\"*\"]', NULL, NULL, '2024-02-14 02:13:01', '2024-02-14 02:13:01'),
(56, 'App\\Models\\User', 14, 'loginUser', 'fad04b48afdd00ec9e33c530a9f83a404e21c96d9a4f983f1b76ee0c63d6ca03', '[\"*\"]', NULL, NULL, '2024-02-14 02:13:22', '2024-02-14 02:13:22'),
(57, 'App\\Models\\User', 14, 'loginUser', 'b4684f7fdafbc184d7a3986e63b086e4c217033844e6aff13231d5ff46fce1fb', '[\"*\"]', NULL, NULL, '2024-02-14 02:13:37', '2024-02-14 02:13:37'),
(58, 'App\\Models\\User', 14, 'loginUser', 'd099798520fc19ba359c3230bb063cf054812c244440a3b590b6fd47bc5a8b2d', '[\"*\"]', NULL, NULL, '2024-02-14 02:18:06', '2024-02-14 02:18:06'),
(59, 'App\\Models\\User', 17, 'loginUser', 'b7c8ec8f6757089f2d7b7512a9ec2613a2865fd6d9403707cd56e0f79e3742bc', '[\"*\"]', '2024-02-15 12:01:58', NULL, '2024-02-15 12:01:57', '2024-02-15 12:01:58'),
(60, 'App\\Models\\User', 18, 'loginUser', '52d129b62c669013921e248f15d55517203c95e7b71ff86aaef6795e7672f05e', '[\"*\"]', '2024-02-15 12:14:50', NULL, '2024-02-15 12:03:49', '2024-02-15 12:14:50'),
(61, 'App\\Models\\User', 18, 'loginUser', '68bdf2e5df1afc4385054920b1c042a8b24d572a40412175411addfaa8083708', '[\"*\"]', '2024-02-22 13:13:59', NULL, '2024-02-15 12:15:09', '2024-02-22 13:13:59'),
(62, 'App\\Models\\User', 18, 'loginUser', '1e4e4859842637c7260abe61b45b506dd3ada6b4e28087775a27860bf0b10f15', '[\"*\"]', '2024-02-17 12:49:03', NULL, '2024-02-17 12:30:37', '2024-02-17 12:49:03'),
(63, 'App\\Models\\User', 18, 'loginUser', '57bf78b3632651b3ab17c400588e466d67ce195fc4259201d4482a74c4a3d361', '[\"*\"]', '2024-02-22 09:34:38', NULL, '2024-02-21 10:57:51', '2024-02-22 09:34:38'),
(64, 'App\\Models\\User', 14, 'loginUser', 'e50ad904c9baad69d82f8e776ac2e264a330b1490c4889c29b3f4796e909e3e3', '[\"*\"]', '2024-02-22 12:06:57', NULL, '2024-02-22 05:51:10', '2024-02-22 12:06:57'),
(65, 'App\\Models\\User', 14, 'loginUser', 'e70511d8df8591ec4f869c1758b1fe23360075b07fc9478f00518a6d41dd742d', '[\"*\"]', '2024-02-22 05:58:57', NULL, '2024-02-22 05:58:56', '2024-02-22 05:58:57'),
(66, 'App\\Models\\User', 18, 'loginUser', 'ce886c17d2f8bba85d07cffa4164b1d1145ae1d097c330979ba91bfb15a46697', '[\"*\"]', '2024-02-22 09:11:38', NULL, '2024-02-22 09:11:38', '2024-02-22 09:11:38'),
(67, 'App\\Models\\User', 19, 'loginUser', '7121a4ba5caa295204f6021291e24e039730c778729de4fdf12b2ca6d993253a', '[\"*\"]', '2024-02-26 13:39:32', NULL, '2024-02-22 13:18:04', '2024-02-26 13:39:33'),
(68, 'App\\Models\\User', 19, 'loginUser', 'cc78f1f102bfb1105b17b1d8c9684aa87fb49a64a155ed42503c3607348776bf', '[\"*\"]', '2024-02-22 13:30:39', NULL, '2024-02-22 13:26:27', '2024-02-22 13:30:39'),
(69, 'App\\Models\\User', 18, 'loginUser', '7fc58453fec031309f1f616aabfbf30d812eed24f0b1afefe7ed55ead196c044', '[\"*\"]', '2024-02-22 13:39:55', NULL, '2024-02-22 13:33:46', '2024-02-22 13:39:55'),
(70, 'App\\Models\\User', 19, 'loginUser', '2d99b3eb27175e91b00dca12eb79d5a55f2439e957544f72b7d1aafe87c7da85', '[\"*\"]', '2024-02-22 13:44:30', NULL, '2024-02-22 13:40:13', '2024-02-22 13:44:30'),
(71, 'App\\Models\\User', 18, 'loginUser', '97a13c47229757a56e0c89673b92019f748868b62d8fdc4ab43e4d9f2278a6bb', '[\"*\"]', '2024-02-26 14:36:32', NULL, '2024-02-22 13:44:52', '2024-02-26 14:36:32'),
(72, 'App\\Models\\User', 20, 'loginUser', '6ca256ed652f04bbe13efc86486329a3992810e463cb43fcdfb4dd0676e98b61', '[\"*\"]', NULL, NULL, '2024-02-25 12:07:51', '2024-02-25 12:07:51'),
(73, 'App\\Models\\User', 20, 'loginUser', 'c233625c47db17fea1a6575f3c6a5d9647a96b40ed2d83f41926dc48a01756b5', '[\"*\"]', '2024-02-25 12:53:48', NULL, '2024-02-25 12:07:54', '2024-02-25 12:53:48'),
(74, 'App\\Models\\User', 18, 'loginUser', '3696d2857f3a494ebe0b0b2b12aa2f18bc5bf8b25fd6558933f104a5b6f2a92a', '[\"*\"]', '2024-02-26 15:26:12', NULL, '2024-02-26 13:43:07', '2024-02-26 15:26:12'),
(75, 'App\\Models\\User', 18, 'loginUser', '01a4cc29b0da2fa439209402e9da21d5b3bdcd78478851ae533e256c9444f18a', '[\"*\"]', '2024-02-26 14:50:10', NULL, '2024-02-26 14:43:27', '2024-02-26 14:50:10'),
(76, 'App\\Models\\User', 18, 'loginUser', '547b0aa09b7afa41141d4adcbbf593d471280f67385ea38902a751fb084db191', '[\"*\"]', NULL, NULL, '2024-02-26 15:23:26', '2024-02-26 15:23:26'),
(77, 'App\\Models\\User', 18, 'loginUser', 'f70e6c812b3d9e484c3233e45fdc07d982aad6ddc029107a3d6ffaf9a28150ac', '[\"*\"]', NULL, NULL, '2024-02-26 15:23:31', '2024-02-26 15:23:31'),
(78, 'App\\Models\\User', 18, 'loginUser', 'be95859ae5eae4fe7daba367d57e637e4a2a51fdba16185b1b7438d0ac4631e6', '[\"*\"]', NULL, NULL, '2024-02-26 15:23:33', '2024-02-26 15:23:33'),
(79, 'App\\Models\\User', 18, 'loginUser', '4a5c7f6d6d2dd0ca1ae7feb97cf0abb2e4707962fcd78ed66112c29406f4ec55', '[\"*\"]', NULL, NULL, '2024-02-26 15:23:44', '2024-02-26 15:23:44'),
(80, 'App\\Models\\User', 18, 'loginUser', '79baa1d25ab0f0afd91845e2aa040a7de553de54bdb19a9e11d6d4ac3ef6f1dd', '[\"*\"]', NULL, NULL, '2024-02-26 15:24:06', '2024-02-26 15:24:06'),
(81, 'App\\Models\\User', 18, 'loginUser', '68387c2e0a0c81f9ab8d0aa6390b72f68229b7104e0c3145994a487da812936c', '[\"*\"]', '2024-02-26 16:45:40', NULL, '2024-02-26 15:26:35', '2024-02-26 16:45:40'),
(82, 'App\\Models\\User', 18, 'loginUser', '178f0ac3caf11a27e3b6a911e5c90f168c683034ddf2c2f7ac003de35b0ac61c', '[\"*\"]', NULL, NULL, '2024-02-26 15:27:20', '2024-02-26 15:27:20'),
(83, 'App\\Models\\User', 18, 'loginUser', '3e787ebb83fccb18bfb797ecc3a988598cc3b702c7cb7e55ba8ce9747f303865', '[\"*\"]', '2024-02-26 15:28:31', NULL, '2024-02-26 15:28:24', '2024-02-26 15:28:31'),
(84, 'App\\Models\\User', 18, 'loginUser', '34329f5d6a226679d04e7d795acf6f43459caffdbd1a304deff26449081c5707', '[\"*\"]', '2024-02-26 15:29:44', NULL, '2024-02-26 15:29:35', '2024-02-26 15:29:44'),
(85, 'App\\Models\\User', 18, 'loginUser', 'a7595363b36349790fcf2a50fd9c7418cd838ff6a8f4fd4725cc120ba14c8c19', '[\"*\"]', '2024-02-26 15:49:29', NULL, '2024-02-26 15:49:28', '2024-02-26 15:49:29'),
(86, 'App\\Models\\User', 23, 'loginUser', '15b6d1e6d3088e4b8301c3b7dcb3d1e0d76f8f90a7b36efb7c5dc81d6aba762a', '[\"*\"]', '2024-02-26 16:55:36', NULL, '2024-02-26 16:48:37', '2024-02-26 16:55:36'),
(87, 'App\\Models\\User', 24, 'loginUser', '1551584a0752d328b1db682a2dd0f9b5cb8e780f1e9208170aa5e2de89b33b38', '[\"*\"]', '2024-02-26 17:03:11', NULL, '2024-02-26 16:56:15', '2024-02-26 17:03:11'),
(88, 'App\\Models\\User', 23, 'loginUser', 'ddc5e8440374df8af7a5822fe5a596e9b5d766ee14b4c492abcea8b77e53c611', '[\"*\"]', '2024-02-26 17:19:14', NULL, '2024-02-26 17:03:24', '2024-02-26 17:19:14'),
(89, 'App\\Models\\User', 14, 'loginUser', '833fdac23922ca7d1addb25207087c5da870ee15da4d2b65a7e97e31a5282175', '[\"*\"]', NULL, NULL, '2024-02-28 00:25:35', '2024-02-28 00:25:35'),
(90, 'App\\Models\\User', 18, 'loginUser', '807f725bb70234a2067c791d6ff807a33ed89778ed7c83d2feebfd028cef8db0', '[\"*\"]', '2024-02-29 16:15:10', NULL, '2024-02-29 16:14:13', '2024-02-29 16:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE `placements` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `placements`
--

INSERT INTO `placements` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Ankle', NULL, NULL),
(2, 'Arm', NULL, NULL),
(3, 'Back', NULL, NULL),
(4, 'Bicep', NULL, NULL),
(5, 'Buttocks', NULL, NULL),
(6, 'Calf', NULL, NULL),
(7, 'Chest', NULL, NULL),
(8, 'Ear', NULL, NULL),
(9, 'Face', NULL, NULL),
(10, 'Foot', NULL, NULL),
(11, 'Forearm', NULL, NULL),
(12, 'Full back', NULL, NULL),
(13, 'Full leg', NULL, NULL),
(14, 'Half sleeve', NULL, NULL),
(15, 'Hand', NULL, NULL),
(16, 'Head', NULL, NULL),
(17, 'Hip', NULL, NULL),
(18, 'Knee', NULL, NULL),
(19, 'Leg', NULL, NULL),
(20, 'Lip', NULL, NULL),
(21, 'Lower back', NULL, NULL),
(22, 'Mouth', NULL, NULL),
(23, 'Neck', NULL, NULL),
(24, 'Ribcage', NULL, NULL),
(25, 'Shoulder', NULL, NULL),
(26, 'Side', NULL, NULL),
(27, 'Sleeve', NULL, NULL),
(28, 'Sternum', NULL, NULL),
(29, 'Stomach', NULL, NULL),
(30, 'Thigh', NULL, NULL),
(31, 'Torso', NULL, NULL),
(32, 'Upper back', NULL, NULL),
(33, 'Wrist', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint UNSIGNED NOT NULL,
  `artist_id` bigint UNSIGNED NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_send_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0=not define,1=email send waiting for form submited,2=view link',
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `when_get_tattooed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` date DEFAULT NULL,
  `front_back_view` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `artist_id`, `color`, `description`, `size`, `link_send_status`, `pdf_path`, `when_get_tattooed`, `reference_image`, `budget`, `availability`, `front_back_view`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 33, 'blue', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', 'L', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 34, 'Red', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 27, 'Red', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, 18, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Abstract', NULL, NULL),
(2, 'Ambigram', NULL, NULL),
(3, 'Anime', NULL, NULL),
(4, 'Armband', NULL, NULL),
(5, 'Baroque', NULL, NULL),
(6, 'Bio-mechanical', NULL, NULL),
(7, 'Bio-organic', NULL, NULL),
(8, 'Black & Grey', NULL, NULL),
(9, 'BlackWork', NULL, NULL),
(10, 'Body Mods', NULL, NULL),
(11, 'Bold Lettering', NULL, NULL),
(12, 'Botanical', NULL, NULL),
(13, 'Cartoons', NULL, NULL),
(14, 'Celtic', NULL, NULL),
(15, 'Chicano', NULL, NULL),
(16, 'Chinese', NULL, NULL),
(17, 'Classic Color', NULL, NULL),
(18, 'Cosmetic', NULL, NULL),
(19, 'Dark Art', NULL, NULL),
(20, 'DotWork', NULL, NULL),
(21, 'Expressionism', NULL, NULL),
(22, 'Fantasy', NULL, NULL),
(23, 'Fineline', NULL, NULL),
(24, 'Flash', NULL, NULL),
(25, 'Floral', NULL, NULL),
(26, 'Geometric', NULL, NULL),
(27, 'Graffiti', NULL, NULL),
(28, 'Hand-Poked', NULL, NULL),
(29, 'Hoot Hoot', NULL, NULL),
(30, 'Ignorant', NULL, NULL),
(31, 'Illusion', NULL, NULL),
(32, 'Illustrative', NULL, NULL),
(33, 'Japanese (Irezumi)', NULL, NULL),
(34, 'Japanese Lettering', NULL, NULL),
(35, 'Lettering', NULL, NULL),
(36, 'Linework', NULL, NULL),
(37, 'Manga', NULL, NULL),
(38, 'Maori', NULL, NULL),
(39, 'Marvel', NULL, NULL),
(40, 'Mashup', NULL, NULL),
(41, 'Memorial', NULL, NULL),
(42, 'Micro Realism', NULL, NULL),
(43, 'Minimalism', NULL, NULL),
(44, 'Neo Traditional', NULL, NULL),
(45, 'New School', NULL, NULL),
(46, 'Old School (Traditional)', NULL, NULL),
(47, 'Ornamental', NULL, NULL),
(48, 'People', NULL, NULL),
(49, 'Polka', NULL, NULL),
(50, 'Polynesian', NULL, NULL),
(51, 'Portraits', NULL, NULL),
(52, 'Quote', NULL, NULL),
(53, 'Realism', NULL, NULL),
(54, 'Realistic', NULL, NULL),
(55, 'Red Ink', NULL, NULL),
(56, 'Religious', NULL, NULL),
(57, 'Samoan', NULL, NULL),
(58, 'Scarification', NULL, NULL),
(59, 'Script', NULL, NULL),
(60, 'Small Lettering', NULL, NULL),
(61, 'Stonework', NULL, NULL),
(62, 'Surrealism', NULL, NULL),
(63, 'The Realest', NULL, NULL),
(64, 'Traditional', NULL, NULL),
(65, 'Trash', NULL, NULL),
(66, 'Trash Polka Style', NULL, NULL),
(67, 'Tribal', NULL, NULL),
(68, 'UV light', NULL, NULL),
(69, 'Watercolor', NULL, NULL),
(70, 'White ink', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Anatomy', NULL, NULL),
(2, 'Anchor', NULL, NULL),
(3, 'Angel', NULL, NULL),
(4, 'Animal', NULL, NULL),
(5, 'Aries', NULL, NULL),
(6, 'Art', NULL, NULL),
(7, 'Astrology', NULL, NULL),
(8, 'Astronomy', NULL, NULL),
(9, 'Awareness', NULL, NULL),
(10, 'Baby', NULL, NULL),
(11, 'Barcode', NULL, NULL),
(12, 'Beach', NULL, NULL),
(13, 'Bird', NULL, NULL),
(14, 'Books', NULL, NULL),
(15, 'Buddha', NULL, NULL),
(16, 'Butterfly', NULL, NULL),
(17, 'Cars', NULL, NULL),
(18, 'Cat', NULL, NULL),
(19, 'Catcher', NULL, NULL),
(20, 'Celebrity', NULL, NULL),
(21, 'Celestial', NULL, NULL),
(22, 'Cherry', NULL, NULL),
(23, 'Christian', NULL, NULL),
(24, 'Clock', NULL, NULL),
(25, 'Comic', NULL, NULL),
(26, 'Cross', NULL, NULL),
(27, 'Crystals/Gems', NULL, NULL),
(28, 'Dagger', NULL, NULL),
(29, 'Death', NULL, NULL),
(30, 'Devil', NULL, NULL),
(31, 'Dinosaur', NULL, NULL),
(32, 'Dogs', NULL, NULL),
(33, 'Dove', NULL, NULL),
(34, 'Dragon', NULL, NULL),
(35, 'Dragonfly', NULL, NULL),
(36, 'Dream', NULL, NULL),
(37, 'Eagle', NULL, NULL),
(38, 'Eyes', NULL, NULL),
(39, 'Fairy', NULL, NULL),
(40, 'Family', NULL, NULL),
(41, 'Feather', NULL, NULL),
(42, 'Fire', NULL, NULL),
(43, 'Fish', NULL, NULL),
(44, 'Flame', NULL, NULL),
(45, 'Flower', NULL, NULL),
(46, 'Food', NULL, NULL),
(47, 'Football', NULL, NULL),
(48, 'Geisha', NULL, NULL),
(49, 'Geometry', NULL, NULL),
(50, 'Girl', NULL, NULL),
(51, 'Gun', NULL, NULL),
(52, 'Hands', NULL, NULL),
(53, 'Heart', NULL, NULL),
(54, 'Indian', NULL, NULL),
(55, 'Infinity', NULL, NULL),
(56, 'Insects', NULL, NULL),
(57, 'Jellyfish', NULL, NULL),
(58, 'Jesus', NULL, NULL),
(59, 'Koi', NULL, NULL),
(60, 'Lettering', NULL, NULL),
(61, 'Lions', NULL, NULL),
(62, 'Lotus', NULL, NULL),
(63, 'Mandala', NULL, NULL),
(64, 'Marvel', NULL, NULL),
(65, 'Mermaids', NULL, NULL),
(66, 'Military', NULL, NULL),
(67, 'Moon', NULL, NULL),
(68, 'Moth', NULL, NULL),
(69, 'Mother/Child', NULL, NULL),
(70, 'Motorcycles', NULL, NULL),
(71, 'Music', NULL, NULL),
(72, 'Name', NULL, NULL),
(73, 'Nature', NULL, NULL),
(74, 'Ocean', NULL, NULL),
(75, 'Octopus', NULL, NULL),
(76, 'Other', NULL, NULL),
(77, 'Owl', NULL, NULL),
(78, 'Patriotic', NULL, NULL),
(79, 'Peace', NULL, NULL),
(80, 'Peacock', NULL, NULL),
(81, 'People', NULL, NULL),
(82, 'Phoenix', NULL, NULL),
(83, 'Pinup', NULL, NULL),
(84, 'Praying', NULL, NULL),
(85, 'Reptile', NULL, NULL),
(86, 'Rose', NULL, NULL),
(87, 'Sacred', NULL, NULL),
(88, 'Samurai', NULL, NULL),
(89, 'Science', NULL, NULL),
(90, 'Scorpion', NULL, NULL),
(91, 'Semicolon', NULL, NULL),
(92, 'Shells', NULL, NULL),
(93, 'Ships', NULL, NULL),
(94, 'Skateboard', NULL, NULL),
(95, 'Skulls', NULL, NULL),
(96, 'Snake', NULL, NULL),
(97, 'Space', NULL, NULL),
(98, 'Sparrow', NULL, NULL),
(99, 'Spider', NULL, NULL),
(100, 'Sports', NULL, NULL),
(101, 'Star', NULL, NULL),
(102, 'Sun', NULL, NULL),
(103, 'Surfboard', NULL, NULL),
(104, 'Surfing', NULL, NULL),
(105, 'Swallow', NULL, NULL),
(106, 'Symbols', NULL, NULL),
(107, 'Tigers', NULL, NULL),
(108, 'Travel', NULL, NULL),
(109, 'Tree', NULL, NULL),
(110, 'Tribal', NULL, NULL),
(111, 'Turtle', NULL, NULL),
(112, 'Wave', NULL, NULL),
(113, 'Wings', NULL, NULL),
(114, 'Wolf', NULL, NULL),
(115, 'Zodiac Signs', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tatto_form`
--

CREATE TABLE `tatto_form` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `artist_id` int NOT NULL,
  `general_good_health` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `you_under_any_medical_treatment` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `you_currently_taking_any_drugs` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `you_have_a_history_of_medication` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `you_have_a_history_of_fainting` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `are_you_allergic_to_latex` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `have_any_wounds_healed_slowly` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `are_you_allergic_to_any_know_materials` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `any_risk_factors_from_work_or_lifestyle` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `are_you_pregnant_or_nursing` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `cardiac_valve_disease` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `high_blood_pressure` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `respiratory_disease` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `diabetes` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `tumors_or_growths` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `hemophilia` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `liver_disease` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `bleeding_disorder` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `kidney_disease` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `epilepsy` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `jaundice` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `exposure_to_aids` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `hepatitis` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `venereal_disease` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `herpes_infection_at_proposed_procedure_site` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `todaysdate` date DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_general_ci,
  `stateid` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `driving_licence_front` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `driving_licence_back` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tatto_form`
--

INSERT INTO `tatto_form` (`id`, `user_id`, `artist_id`, `general_good_health`, `you_under_any_medical_treatment`, `you_currently_taking_any_drugs`, `you_have_a_history_of_medication`, `you_have_a_history_of_fainting`, `are_you_allergic_to_latex`, `have_any_wounds_healed_slowly`, `are_you_allergic_to_any_know_materials`, `any_risk_factors_from_work_or_lifestyle`, `are_you_pregnant_or_nursing`, `cardiac_valve_disease`, `high_blood_pressure`, `respiratory_disease`, `diabetes`, `tumors_or_growths`, `hemophilia`, `liver_disease`, `bleeding_disorder`, `kidney_disease`, `epilepsy`, `jaundice`, `exposure_to_aids`, `hepatitis`, `venereal_disease`, `herpes_infection_at_proposed_procedure_site`, `name`, `todaysdate`, `birthdate`, `phone`, `address`, `stateid`, `signature`, `driving_licence_front`, `driving_licence_back`) VALUES
(1, 11, 12, '1', '1', '1', '1', '0', '0', '1', '0', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, '1', NULL, 'Biswajit Maity', '2024-01-21', '2024-01-23', '8768624650', 'ee', 'erer', '/tmp/phpoeLiFz', '/tmp/phpXwoWfR', '/tmp/phpj87BZX'),
(2, 11, 12, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tattoo', '2024-01-09', '2024-01-02', '66469643612', 's', 'a', '/tmp/php5hJnRc', '/tmp/php0qGr76', '/tmp/php1JJxmp'),
(3, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'supriyo', '2024-01-31', '2024-01-31', '66469643612', 'test', 'jj', '/tmp/phpGwOic8', '/tmp/phpoE9a6z', '/tmp/phpaQDrku'),
(4, 16, 17, '0', '1', '0', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test', '2024-01-25', '2024-01-11', '66469643612', 'test', 'jj', '/tmp/phpChOFlb', '/tmp/phpnozHzD', '/tmp/php5frskw'),
(5, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tattoo', '2024-01-18', '2024-01-08', '2122122', 'qq', 'dd', '/tmp/php5KButl', '/tmp/phpah7jX0', '/tmp/phplJGWAX'),
(6, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tattoo', '2024-01-25', '2024-01-24', '66469643612', 'ff', 'ff', '/tmp/phpZevpSa', '/tmp/php6TE5rB', '/tmp/phpZMos9d'),
(7, 16, 17, '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 'zz', '2024-02-09', '2024-02-09', '66469643612', 'zz', 'zz', 'tattoform/gR7Iv3p0YXJgKeh2AV6SLhGtU8wAXyjcr704yjw9.png', 'tattoform/GrmsoX5CrdJIZECRr6JlhNt1Y3cctyl10mnm8RC9.png', 'tattoform/pmfcDIm2hPZoPTaR1aLdoYSDrVQOTCIBUvGjm5ZY.png'),
(8, 16, 17, '0', '1', '1', '1', '0', '1', '1', '1', '0', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sd', '2024-02-01', '2024-02-20', '66469643612', 'test', 'test', 'tattoform/nU6hfqKljX1cPdS0zt3DcN9yRjozzOhGZDkl13pt.png', 'tattoform/7Wt1bli1sXY5em9IBdz2WPonZ6sx39EfGpP500YA.png', 'tattoform/yoePD3KullKx4ENKi1MCLV30U3x7iYNaJhWPJ9e9.png'),
(9, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Neel Banerjee', '2024-02-11', '1993-04-25', '1234567890', '10600 Highland Springs Avenue', 'California', 'tattoform/5IClWjw7TfYOWynmDj61dY7GpY9agIvBgJHs5mzQ.png', 'tattoform/gzK92ZCkhsNqDp4sHXfBJi22E4yPfMJazgQsFbNo.png', 'tattoform/nPSOzmVY6aPuW3oHUKveKJ0dgOS81TE4sWG09vOq.png'),
(10, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test test', '2024-02-11', '2024-02-12', '1234567890', '10600 Highland Springs Avenue', 'California', 'tattoform/GkhDDiXyJVodJMDwRqtAMiopOodV1nNINQqbXr7U.png', '', ''),
(11, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test test', '2024-02-11', '2024-02-12', '1234567890', '10600 Highland Springs Avenue', 'California', 'tattoform/EGSCx8PWrsMCHlVH7ku9w1033P0v1NDKQxCKKk2J.png', 'tattoform/ndCrTxPnlpGk0u1Gibpzeoi1piqCy1Er6I51xKzU.png', 'tattoform/8HImOnR5LQlnxOKf16PaAq2kt7I0FZcNNNWSgNR1.png'),
(12, 16, 17, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test test', '2024-02-12', '2024-02-13', '1234567890', '10600 Highland Springs Avenue', 'California', 'tattoform/Wj7cnzMc0a9hzqbCw3zxs0xyzzpu36LLVcK3EXMS.png', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `time_tables`
--

CREATE TABLE `time_tables` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sunday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `sunday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `monday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tuesday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `tuesday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wednesday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `wednesday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thrusday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `thrusday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `friday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saterday_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '09:00',
  `saterday_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_tables`
--

INSERT INTO `time_tables` (`id`, `user_id`, `sunday_from`, `sunday_to`, `monday_from`, `monday_to`, `tuesday_from`, `tuesday_to`, `wednesday_from`, `wednesday_to`, `thrusday_from`, `thrusday_to`, `friday_from`, `friday_to`, `saterday_from`, `saterday_to`, `created_at`, `updated_at`) VALUES
(1, 9, '02:25', '02:50', '00:00', '00:00', '05:03', '05:05', '09:13', '04:13', '04:13', '05:13', '00:00', '00:00', '00:00', '00:00', '2023-11-20 12:14:09', '2023-12-02 01:17:14'),
(2, 9, '02:25', '02:25', '02:25', '03:22', '04:22', '11:22', '04:22', '04:22', '05:22', '04:22', NULL, NULL, NULL, NULL, '2023-11-20 12:26:55', '2023-11-20 12:26:55'),
(3, 9, '01:17', '03:13', '23:18', '02:13', '04:13', '04:13', '09:13', '04:13', '04:13', '05:13', '04:13', '04:13', '04:14', '04:14', '2023-11-22 10:33:40', '2023-11-22 10:33:40'),
(4, 9, '01:14', '03:13', '23:18', '02:13', '04:13', '04:13', '09:13', '04:13', '04:13', '05:13', '04:13', '04:13', '04:14', '04:14', '2023-11-22 10:45:22', '2023-11-22 10:45:22'),
(5, 10, NULL, NULL, '03:59', '04:45', NULL, NULL, '04:03', '05:00', '19:46', '20:52', '00:00', '00:00', '21:53', '19:52', '2023-12-16 04:47:19', '2023-12-16 05:01:54'),
(6, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-20 17:55:18', '2024-01-20 17:55:18'),
(7, 14, '16:15', '16:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 11:07:50', '2024-01-23 11:07:50'),
(8, 17, '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '2024-01-31 05:03:18', '2024-01-31 05:03:18'),
(9, 16, '16:15', '18:13', '23:22', '23:22', NULL, NULL, NULL, NULL, '23:22', '14:19', NULL, NULL, NULL, NULL, '2024-01-31 05:13:57', '2024-02-02 12:19:52'),
(10, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 12:06:26', '2024-02-25 12:06:26'),
(11, 18, '00:00', '00:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '00:00', '00:00', '2024-02-26 13:43:26', '2024-03-01 15:42:40'),
(12, 23, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-02-26 17:04:24', '2024-03-14 16:32:53'),
(13, 26, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-03-09 09:16:13', '2024-03-09 09:16:13'),
(14, 24, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-03-14 16:24:46', '2024-03-14 16:28:08'),
(15, 22, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-03-14 17:08:31', '2024-03-14 17:08:41'),
(16, 21, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-03-14 17:09:32', '2024-03-14 17:09:43'),
(17, 19, '00:00', '00:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '00:00', '00:00', '2024-03-14 17:10:52', '2024-03-14 17:29:56'),
(18, 27, '00:00', '00:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '00:00', '00:00', '2024-03-14 17:40:18', '2024-03-14 19:04:45'),
(21, 33, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-04-23 05:22:08', '2024-04-23 05:22:08'),
(22, 34, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-04-23 07:41:53', '2024-04-23 07:41:53'),
(23, 35, '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '2024-05-03 06:02:33', '2024-05-03 06:02:33'),
(24, 38, '20:40', '01:44', '09:52', '10:42', '08:20', '23:35', '15:06', '17:26', '19:32', '22:27', '10:34', '00:03', '06:25', '10:02', '2024-05-05 19:48:44', '2024-05-05 19:48:44'),
(25, 39, '05:54', '19:50', '06:43', '21:29', '07:06', '10:28', '18:07', '23:14', '01:06', '02:57', '17:34', '13:16', '20:36', '00:01', '2024-05-05 20:02:15', '2024-05-05 20:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `total_views`
--

CREATE TABLE `total_views` (
  `id` bigint UNSIGNED NOT NULL,
  `artwork_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `total_views`
--

INSERT INTO `total_views` (`id`, `artwork_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 9, '2023-11-30 10:10:57', '2023-11-30 10:10:57'),
(2, 2, 8, '2023-12-01 12:18:12', '2023-12-01 12:18:12'),
(3, 18, 14, '2024-01-23 11:09:01', '2024-01-23 11:09:01'),
(4, 20, 14, '2024-01-23 13:10:58', '2024-01-23 13:10:58'),
(5, 21, 11, '2024-01-28 15:01:49', '2024-01-28 15:01:49'),
(6, 20, 18, '2024-02-26 14:24:22', '2024-02-26 14:24:22'),
(7, 26, 18, '2024-02-26 14:24:26', '2024-02-26 14:24:26'),
(8, 19, 18, '2024-02-26 16:45:27', '2024-02-26 16:45:27'),
(9, 22, 18, '2024-02-26 16:45:31', '2024-02-26 16:45:31'),
(10, 21, 23, '2024-02-26 17:05:23', '2024-02-26 17:05:23'),
(11, 25, 23, '2024-02-26 17:05:29', '2024-02-26 17:05:29'),
(12, 24, 23, '2024-02-26 17:05:37', '2024-02-26 17:05:37'),
(13, 19, 23, '2024-02-26 17:05:45', '2024-02-26 17:05:45'),
(14, 20, 23, '2024-02-26 17:07:31', '2024-02-26 17:07:31'),
(15, 22, 23, '2024-02-26 17:07:34', '2024-02-26 17:07:34'),
(16, 23, 23, '2024-02-26 17:17:31', '2024-02-26 17:17:31'),
(17, 18, 23, '2024-02-26 17:18:26', '2024-02-26 17:18:26'),
(18, 26, 23, '2024-02-26 17:18:38', '2024-02-26 17:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'artist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `phone`, `address`, `address2`, `country`, `state`, `city`, `zipcode`, `latitude`, `longitude`, `profile_image`, `banner_image`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_by`, `created_at`, `updated_at`, `type`) VALUES
(1, 'Admin', 'artistAdmin', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, 'admin@mail.com', NULL, '$2y$12$D2sNlQDf1pRCA3wEOCttCe/sqCMd2yfK8.9Z8BHKSTwhzLNg5v.9m', 1, NULL, 0, '2024-01-15 12:26:12', '2024-01-15 12:26:12', 'admin'),
(11, 'testsuo', 'tte', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, 'biswajitmaityniit@gmail.com', NULL, '$2y$12$XqwMWgQ/j.5JSP6bRKXMKu1vaX6wM.kfhEErdB/W.UOSy9DQWaXR6', 1, NULL, 0, '2024-01-15 12:26:12', '2024-01-15 12:26:12', 'artist'),
(12, 'supriyo', 'supriyo', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '17057931183047.PNG', NULL, 'bhuinjohn@gmail.com', NULL, '$2y$10$9c4/3snzvsSVT.IuMbddLe0IoCf2JCt8kXCpxh..DwPcqnNNmqjLW', 1, NULL, 0, '2024-01-15 12:27:44', '2024-01-20 17:55:18', 'artist'),
(14, 'Debashis Saha', 'debashis', '15487487874', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14736.27983419713!2d88.43069445!3d22.576486650000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275af90856d03%3A0xf1d1e8161f99f1c1!2sRang%20De%20Basanti%20Dhaba-%20Diner%2C%20Sector%20V%20Salt%20Lake!5e0!3m2!1sen!2sin!4v1706035862938!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, '', '', '', '700158', NULL, NULL, '17060278708803.jpg', NULL, 'gamingplatform4@gmail.com', NULL, '$2y$12$bVLmxndnN5lgQGsEgrBMRe5O/FeBANfMIv1DAUnaW53n8mzo.4H4O', 1, NULL, 0, '2024-01-21 07:29:22', '2024-01-23 13:23:40', 'artist'),
(15, 'test', 'supriyo@gmail.com', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, 'supriyo@gmail.com', NULL, '$2y$12$MBqvxnNQjDvom5N/HzXzaeMEmSjrgv49Pp1QieflJfsJBX31PSXXq', 1, NULL, 0, '2024-01-28 15:03:39', '2024-01-28 15:03:39', 'artist'),
(16, 'supriyo', 'supriyo dey s', '1234567890', 'Mankar, Bardhaman, West bengal, India', NULL, '', '', '', '1234567', NULL, NULL, NULL, NULL, 'supriyo7dey.live@gmail.com', NULL, '$2y$12$TYrRM7UCb9/HkJ.jmfDnDev1V9R/3Na4/ymGB1HggJMdiURjB9tqm', 1, NULL, 0, '2024-01-31 04:29:35', '2024-02-11 00:10:06', 'artist'),
(17, 'supriyo2', 'supriyo2', '66469643612', 'supriyo.delipat@gmail.com', NULL, '', '', '', '1234567', NULL, NULL, '17066971988395.PNG', NULL, 'supriyo.delipat@gmail.com', NULL, '$2y$12$/Bo4pbWTBZrwYuj0o8QCTeMCMC/zoqGn/41pRwQwPNF6SPWA6ZhQe', 1, NULL, 0, '2024-01-31 04:30:10', '2024-01-31 05:03:18', 'artist'),
(18, 'Neel Banerjee', 'banerjee_neel', '9999999999', '2nd floor, Phase 2, Webel IT PARK, Palashdiha, Industrial Area, Durgapur, West Bengal 713208', NULL, '', '', '', '1234567', NULL, NULL, NULL, NULL, 'supriyo7dey@gmail.com', NULL, '$2y$12$D2sNlQDf1pRCA3wEOCttCe/sqCMd2yfK8.9Z8BHKSTwhzLNg5v.9m', 1, NULL, 0, '2024-02-15 12:03:37', '2024-03-01 00:29:59', 'artist'),
(19, 'tattoo', 'jk@gmail.com', '9999999999', NULL, NULL, '', '', '', '1232232', NULL, NULL, NULL, NULL, 'supriyo8dey@gmail.com', NULL, '$2y$12$D2sNlQDf1pRCA3wEOCttCe/sqCMd2yfK8.9Z8BHKSTwhzLNg5v.9m', 1, NULL, 0, '2024-02-22 13:16:15', '2024-03-14 17:10:52', 'Customer'),
(20, 'Caymus Kochis', 'caymus', '111111111111111111111', '11231545', NULL, '', '', '', '90802', NULL, NULL, '17088830877863.jpg', NULL, 'caymus@yahoo.com', NULL, '$2y$12$16ejvkrTTpUBg2Equ89QJ.ktdNA6axLdOz0oTHW4.ka.MDEI0BKfO', 1, NULL, 0, '2024-02-25 12:06:26', '2024-02-25 12:14:47', 'artist'),
(23, 'john', 'john', '9999999999', NULL, NULL, '', '', '', '1234556', NULL, NULL, '17089868644834.PNG', NULL, 'john@gmail.com', NULL, '$2y$12$0ii8819FFEpWaZvte3SG0udPo7Q2fGQvBEyZ036ygxK9kCK4fqWZ.', 1, NULL, 0, '2024-02-26 16:48:14', '2024-03-14 16:29:19', 'Customer'),
(24, 'aaaaaa', 'aaaaaaaa', '9999999999', NULL, NULL, '', '', '', '123456', NULL, NULL, NULL, NULL, 'a@gmail.com', NULL, '$2y$12$S0vMO0fm1NeF8EmJ4ufQleV.EJhZLVixW6.y/X18ewZ6pZUV8fVny', 1, NULL, 0, '2024-02-26 16:56:00', '2024-03-14 16:24:46', 'artist'),
(26, 'test test', 'admin', '1234567890', '10600 Highland Springs Avenue', NULL, '', '', '', '92223', NULL, NULL, NULL, NULL, 'neel.bandyopadhyay@codeclouds.co.in', NULL, '$2y$12$.99yrVUKNZ9iSzum2eViPOb./m/AivWIpgu4gKGDcqs6eoP4a8cme', 1, NULL, 0, '2024-03-09 09:16:13', '2024-03-09 09:16:13', 'artist'),
(27, 'test test', 'neel430', '1234567890', '10600 Westminster Boulevard, Westminster, CO, USA', '10370 Bel Air Dr', 'United States', 'Colorado', 'Westminster', '80020', '39.8906637', '-105.0654224', NULL, NULL, 'banerjeeneel.live@gmail.com', NULL, '$2y$12$1RkBqcTtVvpUkyw5oxExUendirEufQhgC7b6jEhzsvT4Xs116Gjca', 1, NULL, 0, '2024-03-14 17:40:18', '2024-03-24 11:29:53', 'artist'),
(30, 'test test', 'neelSales', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '17155270032013.png', NULL, 'neel.bandyopadhyays@codeclouds.co.in', NULL, '$2y$12$vp7SbO22OhMYpGM3xq8ROuArZGDh4iSqEHyJqFxj0fDmdvSqcU5aW', 1, NULL, 0, '2024-04-23 03:30:50', '2024-05-12 09:46:43', 'sales'),
(33, 'Test Artist', 'test_artist_1', '9999999999', '240 East 38th Street, New York, NY, USA', NULL, NULL, NULL, NULL, '10016', NULL, NULL, NULL, NULL, 'testartist@domain.com', NULL, '$2y$12$vrbuqX9C2C4sFAdI31Z/COjOlJnnDkzBF5G4Ro4nu/8SLoJbemfpO', 1, NULL, 30, '2024-04-23 05:22:08', '2024-04-23 05:22:08', 'artist'),
(34, 'Test Artist 2', 'test_artist_2', '9999999999', '360 Adams Street, Brooklyn, NY, USA', NULL, NULL, NULL, NULL, '11201', NULL, NULL, NULL, NULL, 'testartist2@domain.com', NULL, '$2y$12$x4Qclfxdvf3W9OMJRzd/dechlSXlb2l9qkRN5HQm0TEHIQH2TMdZC', 1, NULL, 30, '2024-04-23 07:41:53', '2024-04-23 07:41:53', 'artist'),
(38, 'Ulysses Hurst', 'dikylasez', '1336177738', '123 William Street, New York, NY, USA', NULL, NULL, NULL, NULL, '10038', NULL, NULL, '17149583234171.png', '17149583234674.jpg', 'manyq@mailinator.com', NULL, '$2y$12$e11OgkHPHSNvP.dyKkpzHu8Ew.SqJXrsP8w5abX38ok9GBdZ03dIq', 1, NULL, 0, '2024-05-05 19:48:44', '2024-05-05 19:48:44', 'artist'),
(39, 'test test', 'tihid', '1234567890', '10600 Highland Springs Avenue', '10370 Bel Air Dr', 'United States', 'California', 'Beaumont', '92223', NULL, NULL, '17149591351762.png', '17149591356405.jpg', 'muneke@mailinator.com', NULL, '$2y$12$4.2ArDuSJ8Kio6So4oiBc.UYzaS2NXRxAkmLmG2yPclwB4wY5S9YK', 1, NULL, 0, '2024-05-05 20:02:15', '2024-05-06 13:43:18', 'artist');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_data`
--
ALTER TABLE `artist_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_images`
--
ALTER TABLE `banner_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tatto_form`
--
ALTER TABLE `tatto_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_tables`
--
ALTER TABLE `time_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_views`
--
ALTER TABLE `total_views`
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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `artist_data`
--
ALTER TABLE `artist_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `banner_images`
--
ALTER TABLE `banner_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `placements`
--
ALTER TABLE `placements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tatto_form`
--
ALTER TABLE `tatto_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `time_tables`
--
ALTER TABLE `time_tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `total_views`
--
ALTER TABLE `total_views`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
