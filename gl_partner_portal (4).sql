-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2024 at 11:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gl_partner_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$ykbTbPQreuuJepD/tR.5guJWh0qZr0U/80mglbpBBJar3O1hRNcMi', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `email`, `mobile`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Agent', 'agent@gmail.com', NULL, '$2y$10$Rruq/bWLkHUGs0gYntMbF.nM3h4BWyB6FgIqNqTRUfwkCQuOukUVC', NULL, '2023-01-12 12:04:38', '2023-01-12 12:04:38'),
(2, 'Sandeev MV', 'sandeevmv@gmail.com', NULL, '$2y$10$McDyN9sbZYhI0bnBtSg8Qew3S/txZqmIJp1jp2rELcvqqYDzFhh7G', NULL, '2023-01-16 04:55:58', '2023-01-16 04:55:58'),
(3, 'Ashir', 'ashir@gmail.com', NULL, '$2y$10$5xcb2pJqwqdqoNct969g5eBJEMwGp0xtPCYVYPu9PR.705hv/15C6', NULL, '2023-02-24 09:43:29', '2023-02-24 09:43:29'),
(4, 'haris', 'haris@getleadcrm.com', NULL, '$2y$10$XEQm4nCT/Fb6BgFOTpb6muWJ85HlIivLpZsgeQrWagd4Q81F6yV8e', NULL, '2023-02-24 09:44:19', '2023-02-24 09:44:19'),
(5, 'Sanofer', 'sanofer@getleadcrm.com', NULL, '$2y$10$XWPqdkE9k6OKXVB56G.Wles5lrp9nwn1bOSFlguJdkjCs1C32dTUG', NULL, '2023-02-24 09:49:16', '2023-02-24 09:49:16'),
(6, 'Akhilkrishna', 'akhil@getleadcrm.com', NULL, '$2y$10$lo6aMAXGpKV65o5mCEBNOOFHy9.9IXo5SWlS6FXM4x2XoE/LE27CK', NULL, '2023-07-20 05:49:40', '2023-07-20 05:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `bussiness_categories`
--

CREATE TABLE `bussiness_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bussiness_category_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bussiness_categories`
--

INSERT INTO `bussiness_categories` (`id`, `bussiness_category_name`, `created_at`, `updated_at`) VALUES
(1, 'General', '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(2, 'Education', '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(3, 'Transportation', '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(4, 'Finance', '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(5, 'Communication', '2023-01-12 12:04:37', '2023-01-12 12:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `hospital` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_cerified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
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
-- Table structure for table `gl_notification_settings`
--

CREATE TABLE `gl_notification_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `read_status` varchar(255) DEFAULT NULL,
  `register_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`id`, `email`, `token`, `agent_id`, `read_status`, `register_status`, `created_at`, `updated_at`) VALUES
(1, 'sandeev@getleadcrm.com', 'ybHMpAlLyrYX', 2, '0', '0', '2023-01-16 04:56:57', '2023-01-16 04:56:57'),
(2, 'partner@gmail.com', 'E2eWLYjQiWBA', 2, '0', '0', '2023-01-16 04:59:12', '2023-01-16 04:59:12'),
(3, 'partner@gmail.com', 'L1BCSnJgWwXz', 2, '0', '0', '2023-01-16 04:59:15', '2023-01-16 04:59:15'),
(4, 'sharon@getleadcrm.com', 'rJ3qKXl9maEt', 1, '0', '0', '2023-01-16 05:03:13', '2023-01-16 05:03:13'),
(5, 'sharon@getleadcrm.com', 'Oy29hT3YaaYG', 1, '0', '0', '2023-01-16 05:04:10', '2023-01-16 05:04:10'),
(6, 'sharon@getleadcrm.com', 'cBiiMrqYi8j7', 1, '0', '0', '2023-01-16 05:11:42', '2023-01-16 05:11:42'),
(7, 'sharon@getleadcrm.com', 'wbnAS2PXlvUM', 1, '0', '0', '2023-01-16 05:12:00', '2023-01-16 05:12:00'),
(8, 'sharon@getleadcrm.com', 'vd3RYXUqlYjk', 1, '0', '0', '2023-01-16 05:13:32', '2023-01-16 05:13:32'),
(9, 'sharon@getleadcrm.com', '3GjYJcqDf8iv', 1, '0', '0', '2023-01-16 05:15:18', '2023-01-16 05:15:18'),
(10, 'sharon.naz@gmail.com', 'NBpLPZYK0rif', 1, '0', '0', '2023-01-16 05:18:12', '2023-01-16 05:18:12'),
(11, 'sharon@getleadcrm.com', 'JytJO1f1hEmu', 1, '0', '0', '2023-01-16 05:30:47', '2023-01-16 05:30:47'),
(12, 'sharon@getleadcrm.com', 'mnbF3Hxn7pq8', 1, '0', '0', '2023-01-16 05:32:54', '2023-01-16 05:32:54'),
(13, 'sandeev@getleadcrm.com', '0dc7Rpof9LyB', 2, '0', '0', '2023-01-16 06:51:34', '2023-01-16 06:51:34'),
(14, 'partner@gmail.com', '7OhOh88TrOkl', 2, '0', '0', '2023-01-17 05:58:27', '2023-01-17 05:58:27'),
(15, 'partner@gmail.com', 'R5ge8Jse2I6P', 4, '0', '0', '2023-02-24 09:53:02', '2023-02-24 09:53:02'),
(16, 'partner@gmail.com', '6m9dU7FXePKo', 4, '0', '0', '2023-02-24 09:54:32', '2023-02-24 09:54:32'),
(17, 'partner@gmail.com', 'sV0Rhny6JPlb', 5, '0', '0', '2023-02-24 09:57:21', '2023-02-24 09:57:21'),
(18, 'partner@gmail.com', '3pmDQ4qXy1WD', 5, '0', '0', '2023-03-30 05:48:29', '2023-03-30 05:48:29'),
(19, 'partner@gmail.com', 'GwIqJuWzLj4b', 5, '0', '0', '2023-03-30 05:48:31', '2023-03-30 05:48:31'),
(20, 'partner@gmail.com', 'PZjVtIj7Pl7k', 5, '0', '0', '2023-03-30 05:48:32', '2023-03-30 05:48:32'),
(21, 'partner@gmail.com', 'CFqN0pW4xGYp', 5, '0', '0', '2023-03-30 05:48:33', '2023-03-30 05:48:33'),
(22, 'partner@gmail.com', 'QgBLMnfggOrX', 5, '0', '0', '2023-03-30 05:55:20', '2023-03-30 05:55:20'),
(23, 'partner@gmail.com', 'cXVjFGqIfVxH', 5, '0', '0', '2023-04-19 11:17:34', '2023-04-19 11:17:34'),
(24, 'partner@gmail.com', 'uAAeAb8mwH92', 5, '0', '0', '2023-04-20 04:58:10', '2023-04-20 04:58:10');

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
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `bussiness_category_id` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `plan_type` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `amount_collected` int(11) DEFAULT NULL,
  `commission_amount` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `lead_status` int(11) DEFAULT NULL,
  `owner_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `partner_id`, `email`, `designation`, `name`, `mobile`, `company_name`, `bussiness_category_id`, `country`, `state`, `area`, `pincode`, `address`, `plan_type`, `plan_id`, `remarks`, `amount_collected`, `commission_amount`, `total_amount`, `payment_date`, `payment_status`, `lead_status`, `owner_type`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'MD', 'Sandeep', '9037164586', 'Amyntor Tech Solutions Pvt Ltd', 1, 'IN', 'KL', 'Trivandrum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(2, 14, NULL, 'MD', 'Subeesh', '8137036666', 'O.X.E Distributors', 1, 'IN', 'KL', 'Calicut', '673633', 'Ramanattukara', NULL, NULL, 'A distribution company', NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(3, 19, NULL, 'MD', 'Najim', '9048832200', 'DOPA Coaching', 1, 'IN', 'KL', 'Kozhikode', '673008', NULL, NULL, NULL, 'Referral from Bonvoice', NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:43:55'),
(4, 19, NULL, 'IT Head', 'Ranju', '8075114412', 'AJINORAH GLOBAL VENTURES LLP', 1, 'IN', 'KL', 'Kochi', NULL, NULL, NULL, NULL, 'Reference from Bonvoice and they registered. Trial account is setting up,integrations going on.', NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-13 12:34:19'),
(5, 4, NULL, 'Director', 'Akhil', '6238725517', 'Bazani', 1, NULL, NULL, 'Trivandrum', '695035', 'B1,First Floor, Syed Sab Apartments Mulavana Jn, Gowreesapattom, Thiruvananthapuram, Kerala 695035', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:59'),
(6, 4, NULL, 'Director', 'Najam Faizi', '9731378251', 'Faizi Enterprises', 1, NULL, NULL, 'Trivandrum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:43:10'),
(7, 4, NULL, 'Director', 'Sonu S Raj', '919555551445', 'Eduwing', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:43:19'),
(8, 4, NULL, 'Director', 'Varghese', '9895265000', 'Francis Alukkas', 1, NULL, NULL, 'Calicut', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(9, 4, NULL, 'NA', 'Sreelakshmi', '9946242102', 'Matha Education', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(10, 4, NULL, 'NA', 'Sreelakshmi', '9946242102', 'Matha Education', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(11, 4, NULL, 'NA', 'Jayan Abrham', '966547650723', 'Elshio Agritech', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(12, 4, NULL, 'na', 'Praveen', '9744172747', 'Sarovar Exports', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(13, 4, NULL, 'NA', 'Sathar Ali', '9744207403', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:07', '2023-01-12 06:16:07'),
(14, 4, NULL, 'NA', 'Sreevidhya', '7907457019', 'Dalaal Dotcom', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:43:28'),
(15, 4, NULL, 'NA', 'Anu', '8281289792', 'Fortune', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:27'),
(16, 4, NULL, 'na', 'Sandeep', '9645104134', 'Winspire', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:44'),
(17, 4, NULL, 'Director', 'Maneesh', '9846096460', 'iTel iT Service', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:39'),
(18, 4, NULL, 'NA', 'Arun Mathew', '9940743175', 'Learn Stroke', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:36'),
(19, 4, NULL, 'NA', 'Mahin', '8590660385', 'Advenxa', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:36'),
(20, 4, NULL, 'na', 'Alan', '9746471477', 'Alans Academy', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:07', '2023-01-25 09:42:31'),
(21, 4, NULL, 'NA', 'Vivian', '9895005189', 'O2 polymer pots', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:08', '2023-01-25 09:42:24'),
(22, 4, NULL, 'na', 'Adv Deepu', '9072322722', 'Imiloglober', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:08', '2023-01-25 09:42:22'),
(23, 4, NULL, 'na', 'Sunil', '9567826133', 'Optionauts', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2023-01-12 06:16:08', '2023-01-25 09:42:19'),
(24, 4, NULL, 'NA', 'Pratheesh', '9562665444', 'Extreme Solutions', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:08', '2023-01-25 09:42:17'),
(25, 19, NULL, 'IT Head', 'Shafeer', '9995444411', 'EVM', 1, NULL, NULL, NULL, NULL, 'Kochi', NULL, NULL, 'They need 30+ user CRM', NULL, NULL, NULL, NULL, 1, 0, 2, '2023-01-12 06:16:08', '2023-01-13 12:34:13'),
(26, 19, NULL, 'Manager', 'Praseeth', '8590018922', 'Vagjyothi', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-01-13 12:39:44', '2023-01-13 12:39:44'),
(27, 19, NULL, 'Manager', 'Praseeth', '8590018922', 'Vagjyothi', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-01-13 12:39:55', '2023-01-13 12:39:55'),
(28, 19, NULL, 'Manager', 'Praseeth', '8590018922', 'Vagjyothi', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 1, '2023-01-13 12:39:56', '2023-01-19 10:50:33'),
(29, 19, NULL, 'Manager', 'Praseeth', '8590018922', 'Vagjyothi', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 1, '2023-01-13 12:40:01', '2023-01-19 10:50:33'),
(30, 19, NULL, 'Manager', 'Praseeth', '8590018922', 'Vagjyothi', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-01-13 12:40:06', '2023-01-13 12:40:06'),
(34, 19, NULL, 'Chairman', 'Adv. GEORGE JOHN VALATH', '7034028828', 'Richmax', NULL, 'IN', 'KL', 'Kalamassery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 1, '2023-01-16 07:17:05', '2023-01-19 10:50:31'),
(40, 4, 'md@medxonline.com', 'MD', 'Satheesh Bhairavan', '9037046638', 'Medx Online Pharmacy', NULL, 'IN', 'KL', 'Thrissur', NULL, NULL, NULL, NULL, '5 users', NULL, NULL, NULL, NULL, 1, 0, 1, '2023-01-19 10:53:13', '2023-01-19 10:53:13'),
(43, 42, NULL, 'manager', 'ÇRBC TEXTILES LLP', '6238989845', 'ÇRBC TEXTILES LLP', NULL, 'IN', 'AN', 'kochi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-04-17 07:09:54', '2023-04-17 07:11:19'),
(45, 46, 'Info@loroindia.com', 'Director', 'Hariharasudhan', '9047157563', 'Loro india', 1, 'IN', NULL, 'Trichy', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-05-03 09:05:36', '2023-05-03 09:05:36'),
(46, 46, 'Info@kinsterglobal.com', 'Director', 'Kevin', '9447218999', 'Kinster global Pvt ltd', 1, 'IN', 'KL', 'Kollam', NULL, NULL, 1, 8, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2023-05-03 09:13:34', '2023-05-25 09:07:36'),
(47, 49, NULL, 'Marketing head', 'Renju', '8075114412', 'Ajinora', NULL, 'IN', 'KL', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 1, '2023-06-22 10:12:13', '2023-06-22 10:12:19'),
(49, 48, NULL, 'Nil', 'Akhil R Nath', '7907448408', 'Unknown', NULL, 'AD', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2023-07-21 10:20:01', '2023-07-21 10:20:01'),
(57, 54, 'kepyxylu@mailinator.com', 'Qui qui quasi aute q', 'Lacy Larsen', '6034534533', 'Moss and Jones Associates', 5, 'CV', 'BR', 'Totam eos qui at nat', 'Repellendus Repudia', 'Consequat Molestiae', 2, 1, 'Laboris optio labor', NULL, NULL, NULL, NULL, 1, 0, 1, '2023-10-24 12:03:31', '2023-10-24 12:03:31'),
(60, 60, 'nijas.jalal77@gmail.com', 'Sales Manager', 'Nijas Jalal', '9947351654', 'Primefotech', 1, 'IN', 'KL', 'Kodungallur', '680664', 'puthuvathra valavil house kodungallur', 1, 8, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2024-02-03 04:27:00', '2024-02-03 04:27:53'),
(62, 65, 'sumisha@getlead.com', 'CRE', 'sumisha', '6238501008', 'getlead', 2, 'IN', 'KL', 'nellikkode', '673637', 'nellikkode', 1, 8, 'testing', NULL, NULL, NULL, NULL, 1, 0, 1, '2024-06-19 04:26:44', '2024-07-29 04:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `lead_purposes`
--

CREATE TABLE `lead_purposes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `product_and_service_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_purposes`
--

INSERT INTO `lead_purposes` (`id`, `lead_id`, `product_and_service_id`, `created_at`, `updated_at`) VALUES
(1, 38, 9, '2023-01-19 10:50:39', '2023-01-19 10:50:39'),
(2, 39, 9, '2023-01-19 10:53:02', '2023-01-19 10:53:02'),
(3, 40, 8, '2023-01-19 10:53:13', '2023-01-19 10:53:13'),
(5, 43, 8, '2023-04-17 07:11:19', '2023-04-17 07:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `lead_statuses`
--

CREATE TABLE `lead_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_statuses`
--

INSERT INTO `lead_statuses` (`id`, `lead_status`, `created_at`, `updated_at`) VALUES
(1, 'New', '2024-07-30 01:45:57', '2024-07-30 01:45:57'),
(2, 'Got Business', '2024-07-30 01:46:06', '2024-07-30 01:46:06');

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
(5, '2024_07_15_095856_create_admins_table', 1),
(6, '2024_07_15_100210_create_agents_table', 1),
(7, '2024_07_15_100336_create_bussiness_categories_table', 1),
(8, '2024_07_15_100449_create_doctors_table', 1),
(9, '2024_07_15_100555_create_invites_table', 1),
(10, '2024_07_15_100803_create_leads_table', 1),
(11, '2024_07_15_101553_create_lead_purposes_table', 1),
(12, '2024_07_15_101912_create_partners_table', 1),
(13, '2024_07_15_102518_create_password_resets_table', 1),
(14, '2024_07_15_102645_create_product_and_services_table', 1),
(15, '2024_07_15_102947_create_verification_otps_table', 1),
(16, '2024_07_15_121255_create_notification_statuses_table', 1),
(17, '2024_07_15_121256_create_notifications_table', 1),
(18, '2024_07_15_121257_create_lead_statuses_table', 1),
(19, '2024_07_22_041827_alter_table_partners_add_commission_percentage_column', 1),
(20, '2024_07_23_121258_create_payment_details_table', 1),
(21, '2024_07_25_121259_create_news_table', 1),
(22, '2024_07_23_154909_create_gl_notification_settings_table', 2),
(23, '2024_07_30_074147_create_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `news_content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `news_content`, `created_at`, `updated_at`) VALUES
(1, 'Google Input Tools സവിശേഷതകളുടെ ചുരുക്കവിവരണം', 'നിങ്ങൾക്ക് താൽപ്പര്യമുള്ള ഭാഷയിൽ കൂടുതൽ എളുപ്പത്തിൽ ടൈപ്പുചെയ്യാൻ Google എഴുത്ത് ഉപകരണങ്ങൾക്ക് നിങ്ങളെ സഹായിക്കാനാകും. ഞങ്ങൾ നിലവിൽ നിരവധി തരത്തിലുള്ള വാചക എഴുത്ത് ഉപകരണങ്ങൾ നൽകുന്നു:\r\n\r\nIME (ടൈപ്പുചെയ്യൽ രീതി എഡിറ്ററുകൾ) ഒരു പരിവർത്തന എഞ്ചിൻ ഉപയോഗിച്ച് നിങ്ങളുടെ കീസ്‌ട്രോക്കുകൾ മറ്റൊരു ഭാഷയിലേക്ക് മാപ്പുചെയ്യുന്നു.\r\nലിപ്യന്തരണം ഒരു ഭാഷയിലെ വാചകത്തിന്റെ ശബ്‌ദങ്ങൾ/സ്വരസൂചകങ്ങൾ എന്നിവ ശബ്‌ദങ്ങളുമായി മികച്ച രീതിയിൽ പൊരുത്തപ്പെടുന്ന മറ്റൊന്നിലേക്ക് പരിവർത്തനം ചെയ്യുന്നു. ഉദാഹരണത്തിന്, ലിപ്യന്തരണം “namaste” എന്നത് ഹിന്ദിയിൽ “नमस्ते” ആയി പരിവർത്തനം ചെയ്യുന്നു.\r\nവെർച്വൽ കീബോർഡ് നിങ്ങളുടെ യഥാർത്ഥ കീബോർഡിലെ കീകളിലേക്ക് മാപ്പുചെയ്യുന്ന ഒരു കീബോർഡ് നിങ്ങളുടെ സ്‌ക്രീനിൽ പ്രദർശിപ്പിക്കുന്നു. ഓൺ-സ്‌ക്രീൻ കീബോർഡ് ലേഔട്ട് അടിസ്ഥാനമാക്കി നിങ്ങൾക്ക് മറ്റൊരു ഭാഷയിൽ നേരിട്ട് ടൈപ്പുചെയ്യാനാകും.\r\nകൈയക്ഷരം നിങ്ങളുടെ കൈവിരലുകൾ ഉപയോഗിച്ച് പ്രതീകങ്ങൾ വരയ്‌ക്കുന്നതിലൂടെ വാചകത്തിൽ ടൈപ്പുചെയ്യാൻ നിങ്ങളെ അനുവദിക്കുന്നു. Google എഴുത്ത് ഉപകരണങ്ങളുടെ Chrome വിപുലീകരണത്തിൽ മാത്രമേ നിലവിൽ കൈയക്ഷരം ലഭ്യമാകൂ.\r\nGoogle അക്കൗണ്ട് ക്രമീകരണങ്ങളിൽ എഴുത്ത് ഉപകരണങ്ങൾ കോൺഫിഗർ ചെയ്യുന്നതെങ്ങനെയെന്ന് അറിയുക.\r\n\r\nGmail, ഡ്രൈവ്, തിരയൽ, വിവർത്തനം, Chrome, ChromeOS എന്നിവയുൾപ്പെടെയുള്ള Google ഉൽപ്പന്നങ്ങളിൽ എഴുത്ത് ഉപകരണങ്ങൾ ഉപയോഗിക്കേണ്ടത് എങ്ങനെയെന്ന് അറിയുക.\r\n\r\nഅത് പരീക്ഷിക്കാൻ, ഞങ്ങളുടെ ഡെമോ പേജിലേക്ക് പോകുക.', '2024-07-25 10:08:19', '2024-07-26 06:12:23'),
(2, 'എഴുത്ത് ഉപകരണങ്ങൾ ഓൺലൈനിൽ പരീക്ഷിച്ചുനോക്കുക', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '2024-07-25 10:08:19', '2024-07-25 10:08:19'),
(5, 'Google എഴുത്ത് ഉപകരണങ്ങൾ ഓൺലൈനിൽ ...', 'Google Input Tools നിങ്ങളുടെ തിരുത്തലുകൾ ഓർമ്മിപ്പിക്കുകയും പുതിയതോ സാധാരണ ഉപയോഗത്തിൽ ഇല്ലാത്തതോ ആയ പദങ്ങൾക്കും പേരുകൾക്കുമായി ഒരു ഇഷ്‌ടാനുസൃത നിഘണ്ടു പരിപാലിക്കുകയും ചെയ്യുന്നു.\r\nനിങ്ങൾക്ക് ആവശ്യമുള്ള ഭാഷയിലും ശൈലിയിലും സന്ദേശം നേടുക. 80-ലധികം ഭാഷകളിൽ സ്വിച്ചുചെയ്‌ത് ടൈപ്പിംഗ് പോലെ പരിധിയില്ലാത്ത ടൈപ്പുചെയ്യൽ രീതികൾ നേടൂ.', '2024-07-25 10:29:34', '2024-07-26 06:10:35'),
(6, 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '2024-07-25 10:30:51', '2024-07-26 06:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notification` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_statuses`
--

CREATE TABLE `notification_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `email_status` int(11) DEFAULT NULL,
  `whatsapp_status` int(11) DEFAULT NULL,
  `telegram_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `team_size` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin_code` varchar(10) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `commission_percentage` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `upi_id` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `mobile`, `company_name`, `email`, `website`, `team_size`, `country`, `state`, `city`, `pin_code`, `email_verified_at`, `password`, `agent_id`, `commission_percentage`, `photo`, `bank_name`, `ifsc`, `branch`, `account_number`, `upi_id`, `company_logo`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Saji', '9846611665', 'Hazlo Solutions', 'saji@hazlosolutions.in', 'https://hazlosolutions.in/', NULL, 'India', 'KL', 'Kochi', '682021', NULL, '$2y$10$AfjkAlSgA1stWB4kezrmC.imo4o1eJlSERl4tNxZ8fLJwKquZGGji', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(4, 'Gokulakrishnan R', '9645005501', 'Voxbay Solutions', 'basheer@voxbaysolutions.com', 'https://voxbaysolutions.com/', '30', 'India', 'KL', 'Ernakulam', '682021', NULL, '$2y$10$58pQYj3Cz7OYdkYrjV1F9ulyJcu9HAUJBUBl6AeRe15iQZnLgLOZ6', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(6, 'Mahesh Sargasree', '9400430499', 'Exetera Inc', 'maheshsargasree@gmail.com', 'https://exetera.in', '15', 'India', 'KL', 'Kochi', '682022', NULL, '$2y$10$yU/t/iugZjogB1Mnsc4Bxu4IsKxXKxc7CLpZ3XSC47dpaBkhHsZ7y', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(7, 'Arshad', '9745489998', 'exxae', 'hello@exxae.com', 'www.exxae.com', '15', 'India', 'KL', 'Calicut', '673572', NULL, '$2y$10$HqqYhdrDjKCzOotSsA45MOLWrEjBAvzDjaJz32WtVNuH6FyJo9rZq', 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-02-24 09:45:09'),
(8, 'Sufail B', '8714111696', 'OVOK INDIA BUSINESS SOLUTION', 'sufail@brandingworld.in', 'WWW.brandingworld.in', '5', 'India', 'Kerala', 'Calicut', '673016', NULL, '$2y$10$xDoqdsk1ITva3xX10BlUOux6i07uNawzeUOt2x4Rc5N2.AhtzP8iq', 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-02-24 09:45:16'),
(9, 'Thajudheen', '7012588384', 'Peqone Advertisers', 'info@peqone.com', 'www.peqone.com', '11', 'India', 'Andaman and Nicobar Islands', 'Calicut', '673634', NULL, '$2y$10$fRBpJW77eqZhxt/V4pMEMeHiGR7PNnAuoufTp5.uXrBb1vrq2F4wO', 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-02-24 09:49:47'),
(10, 'Abdul Rashid', '9946000525', 'Pensare Marketing Services', 'pensaremail@gmail.com', 'www.pensare.com', '10', 'India', 'KL', 'calicut', '673572', NULL, '$2y$10$6gw8hgl4Qg5xwa4NhKe54OVh9T8dEewxOHqGPY9CVZGuI/Cu1AtF2', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(11, 'Naveen PK', '08590288988', 'Mantra Ads', 'mantraadsclt@gmail.com', 'mantrads.com', NULL, 'India', 'KA', 'BANGALORE', '560049', NULL, '$2y$10$IAI5NGwQilnuI8MerlYdwOBWuVuw6nxzFQ8nRphvLRNzV.s9gfD8m', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(12, 'Prajish K', '7736333068', 'Micro Health Laboratories', 'k.prajish3@gmail.com', 'www.microhealthcare.com', '2', 'India', 'Kerala', 'Calicut', '673016', NULL, '$2y$10$8iR.JG3ZsBZXHHWTT.gPJet8aJ8F6yJNbv.Ac5x4c83J8yUAOO8LC', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(13, 'Jaleel Nechiyan', '9895771254', 'Jb enterprises', 'jaleelnechiyan@gmail.com', NULL, NULL, 'India', 'Kerala', 'Ernakulam', '682019', NULL, '$2y$10$SscuaYx9jYlRB5AynUxug.XT0vJXmWCzLc/q0RoW8DXFB17ATtKiO', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(14, 'Pradeep Kumar V', '7736123004', 'Techonus Solutions', 'info@techonussolutions.com', 'www.techonussolutions.com', NULL, 'India', 'Kerala', 'Kozhikode', NULL, NULL, '$2y$10$4ky4SyDr2f5UIG2c.d3gbe.9Rs2qVbwRo9GVptfym4JrdLgfIi/oq', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(18, 'Kannan', '9999284396', 'Cloud Infotech Pvt Ltd', 'kannans@cloudinfotech.co.in', 'www.cloudinfotech.co.in', '80', 'India', 'Kerala', 'Kochi', NULL, NULL, '$2y$10$pZylo6H00YtPqNgS9W7twuk9JbEZQL/0h0IICc6DlomBi/Sfem0zK', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(19, 'Anil Kumar', '9567855503', 'Bonvoice Solutions Pvt Ltd', 'anil.kumar@bonvoice.com', 'www.bonvoice.com', '40', 'India', 'Kerala', 'Cochin', '683503', NULL, '$2y$10$bw89m2YPC7go4ZfS4C6Q6OovrkTcLjFhE14oSnu.ySgHjyrlmBToy', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(20, 'Prasanth Varghese T', '9809881919', 'AdBerry', 'prasanth@adberry.in', 'AdBerry.in', NULL, 'India', 'Kerala', NULL, NULL, NULL, '$2y$10$3GPHZYCsh4J3ElXKAUw8XOeBauUxRSIOGwGjSRztxeKExx8GDIDl6', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(21, 'SAJITH S M,', '8086076579', 'BAZANI', 'contact@bazani.in', 'www.bazani.in', '10', 'India', 'Kerala', 'TRIVANDRUM', '695035', NULL, '$2y$10$KH9QSeu/NZEZBH.L2qgk/eD8T91s636iUticjchAN4iYKXZ4OvmUW', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(22, 'Althaf', '9961620621', 'SkyBook Digital', 'althaf@skybookdigital.com', 'www.skybookdigital.com', '35', 'India', 'Kerala', 'Kozhikode', '673016', NULL, '$2y$10$euaaGszyUlHuEgbuCJDV1unVMVCgSdqGuGvHeAZIEWYHN6Z/YEKeG', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(23, 'Febin', '7012486388', 'Focuz', 'febinfaiby123@gmail.com', 'Febinfaiby.com', '20', 'India', 'Kerala', 'Calicut', '673638', NULL, '$2y$10$OLSDdYE6V1ODmSKoxyGpD.sT.f2RT/CKdXxelq2SXj6y0TeDzOTWW', 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-02-24 09:50:16'),
(24, 'Eva', '8089124419', 'Eva', 'devasbusinesscafe@gmail.com', 'Evaonline.online', '5', 'India', 'Andaman and Nicobar Islands', NULL, NULL, NULL, '$2y$10$rAyDSk0ho.S.RQ6eMT88KeL5Gi6qc88KK/sGfp7T4PS6eh7xGtQaq', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(25, 'Sooraj', '7012935118', 'BrandLabz Digital Solutions Pvt Ltd', 'sooraj@brandlabz.in', 'www.brandlabz.in', '15', 'India', 'Kerala', 'Kochi', '682021', NULL, '$2y$10$1b6lftlP8Ohi0xyidKJaeeG.aNjEiLlq2KoS.rwwxLcCqkX87Pf2S', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(26, 'Gokulakrishnan R', '9645005501', 'Voxbay Solutions Pvt Ltd', 'gokul@voxbaysolutions.com', 'https://voxbaysolutions.com/', '30', 'India', 'KL', 'Kakkanad', '682021', NULL, '$2y$10$fA06CuG7VxAa1rUDww2JoejmkfP3/JUWuoIvo4dWLxHwU/9PJ4Kau', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(27, 'Ashkar', '7012475968', 'JIO', 'ashkarsubair9961672459@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$dPcE2tJKfU/zxrW2i7Oc9ejx18U7vacecOXHT8Q4ErVBrqq9kND2y', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:11:17', '2023-01-12 06:11:17'),
(33, 'Febin', '7012486388', 'Focuz', 'focuzholidayz@gmail.com', 'Focuzholidayz.com', '20', 'India', 'Kerala', 'Calicut', '673638', NULL, '$2y$10$4uc2f0ASIPHt7vHcs4mOT.poPpueOGt4rB7l6ChKk8ENp6yQga2b2', 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:12:20', '2023-02-24 09:50:34'),
(34, 'Saheer', '66826361', 'Ejabiz Software', 'saheer@ejabiz.com', 'www.ejabiz.com', '10', 'Kuwait', 'Al Kuwayt', 'Kuwait City', NULL, NULL, '$2y$10$YXDJLPvibhZL3q8YqBodf.w43ilPkfLQ4SJ9XuvwfNDavL9WdfPV6', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-12 06:12:20', '2023-01-12 06:12:20'),
(35, 'Partner', '9632547852', NULL, 'partner@gmail.com', NULL, NULL, 'AD', '02', NULL, NULL, NULL, '$2y$10$y0nFBHkIw8u.VIqHvNW0.OcLeITaSAgr5NQGLQYQCCoXC9JAq77ku', 0, 0, '1690189368.png', 'HDFC', 'HDFC0000INC', 'Calicut', '213412312342423', 'partner@okhdfc.com', NULL, NULL, '2023-01-12 12:04:37', '2023-07-24 09:02:48'),
(36, 'SANDEEV', '9605999605', 'GETLEAD', 'sandeev@getleadcrm.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$UWLmR1Fj/XqOz.MEG90AVua7qW4j0vU8bpFXQbFHumrvd2o7M97f.', 2, 0, '1672655863.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-16 05:00:20', '2023-01-16 05:00:20'),
(40, 'JOISH JOHN', '8848187092', 'Ideal Virtual Solutions', 'infoidealvirtualsolutions@gmail.com', NULL, NULL, 'IN', 'KL', NULL, '695011', NULL, '$2y$10$scTQw/UW5HXgRSepL/BqW.scCje8NdqrobPOvh4zXSMEjJoUm3ZsC', 4, 0, '1673860482.png', 'SOUTH INDIAN BANK', 'SIBL0000773', 'kumarapuram', '0773073000000127', 'infoidealvirtualsolutions@okaxis', NULL, NULL, '2023-02-24 07:14:07', '2023-02-24 09:44:32'),
(41, 'Ashir', '9809335953', 'Gl', 'ashiashir54@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$uLEcKnU1Uwh3XnVmuzk9k.gkNHaDA1X2xnnwnDerbtneiakNGvJMy', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-21 11:54:30', '2023-03-21 11:54:30'),
(42, 'Chacko Jose', '6238989845', 'Skybertech', 'chacko@skybertech.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$OSNdda8e0uyUqNSFvoT8veznDShkewYb7MCZ1DDKFLpmath5ih66u', 5, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-30 05:51:09', '2023-03-30 05:51:09'),
(43, 'Ashick Rathish', '9961957214', 'Techolas', 'ashickratheesh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$OrS3l49TO4Zntxj7kF5Plu3umERskFdgs7YTr3OSLLitX03nSh2xe', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-03 07:00:52', '2023-04-03 07:00:52'),
(44, 'Nithin Sai', '9656210077', 'Megatron Technologies', 'nithin.sai@megatrontech.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$yacmKMFWLTK1L2.yArlQce5S6Rry5OEiQOreS/ZeGWCgJWKpKolEK', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-04 05:56:59', '2023-05-25 09:07:02'),
(45, 'Waseem Nassar', '917306391390', 'Tociety', 'waseem@tociety.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$mGZVSTStJMgHvZJy019uOu245gsi/L33hZ6RmaPnO7yXVMCjhxMaa', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-19 11:19:26', '2023-05-25 09:07:07'),
(46, 'Alesh Asok', '9947050963', NULL, 'aleshasok@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$1vWzqozOupji8NDxpfny4.f3PIJPWaXYMwmOBFN1SZLp7BX.TTNWi', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-28 09:51:24', '2023-05-25 09:06:53'),
(47, 'Midhun', '9746473396', 'Greenads Global', 'midhun@greenadsglobal.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$n4C.0xgBnqy8yTG0wS1f5ukeo5HxTnLtV4r6Jj0Koj3EkhOfQDdeC', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-24 07:27:10', '2023-05-25 09:05:09'),
(48, 'Vibhu A', '9188051255', 'WEBSTRIO', 'webstriodigital@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Er4zza70fkPJ9H0JBP4jZu3Bl.nNqYPr4b4fTcjUFUeFtYmaPrBQW', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-24 07:45:59', '2023-05-25 09:05:02'),
(49, 'Usama Shihabudeen', '9544077711', NULL, 'usamashihabudeen@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ljywr6E3gYslgNpSSbiof.q0C8xuDsJhQJGo3gk2MECyCz6FZIlRG', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-22 10:08:20', '2023-06-22 10:10:53'),
(50, 'Sandhya Varma', '09946498632', 'skillquest360', 'sandhya.varma1983@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$z2uOYChXq2o4zI5dMy9fuug7jWEPfpknDttoGj23aRbHFlmRe78x2', 1, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-25 17:51:52', '2023-07-20 05:49:13'),
(51, 'Akhilkrishna.T', '9048333535', 'Getlead', 'akhil@getleadcrm.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ETMA5VouYpoS.7E2fHJgBOdD8x90nFmyMrTP/rcWFMSBrSttoaLrG', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-20 05:56:43', '2023-07-20 05:56:43'),
(52, 'tester', '7012266208', 'getlead', 'nodax83841@sparkroi.com', 'www.google .com', '1', 'AD', '02', NULL, '676639', NULL, '$2y$10$NKmhIYjYKe9yfCEP7Wn7P.VZ3ppuqZq9y67WQ9T2.IUYiCIWIwtmG', 0, 0, '1673860482.png', 'SAxd', 'sax', 'as', 'as', 'as', '1690179664.png', NULL, '2023-07-24 06:08:52', '2023-07-24 06:21:04'),
(53, 'Ajay', '8089420476', 'Getlead', 'ajayashirvad@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$HL7LnD3TpnS/f1vdDJwufO18TeCCQR.1LCEKVV6B1c2dudsoeND9G', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-26 10:25:59', '2023-07-26 10:25:59'),
(54, 'Shaji ', '9995338385', NULL, 'shaji@webqua.com', NULL, NULL, 'AD', NULL, NULL, NULL, NULL, '$2y$12$ykbTbPQreuuJepD/tR.5guJWh0qZr0U/80mglbpBBJar3O1hRNcMi', 0, 0, '1698149955.jpg', NULL, NULL, NULL, NULL, NULL, '1698149955.jpg', NULL, '2023-10-24 05:06:29', '2023-10-24 12:19:15'),
(55, 'Ashir', '9809335953', 'ssr', 'digital@getleadcrm.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ebCWY7LubKi4XCkbhXg27uUInRL3VXFh2X.FWweo.QorK7Rms7tNe', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-24 10:01:02', '2023-10-24 10:01:02'),
(58, 'Akash Kumar Tripathi', '9354930542', 'Soft Gallary', 'gallerysoft@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$YdDqoaXNJB2vpJB/TUONZ.3C8CUBuPZ4dSxKe768IC7T/OFKfw0T6', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-15 10:37:45', '2023-12-15 10:37:45'),
(59, 'VINEESH KUMAR', '8590991111', 'Vinvibes Technologies', 'vineesh.tycoons@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$eFWwRz9ns/lOgvs5zxCVZ.PjTH.LPlI8NGNL57UsWIv1iPkNtCFXG', 4, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-17 07:54:12', '2024-02-12 06:34:00'),
(60, 'Nijas Jalal', '8138051596', 'Primefotech', 'info@primefotech.com', 'www.primefotech.com', '20', 'IN', 'KL', NULL, '680664', NULL, '$2y$10$CP4eJuK3ap3pGxMSU1TI/eKbX4Xgc7CJPDRs3wMqBs1lBNRYESZD.', 4, 0, '1706934199.jpg', 'Federal Bank', 'FDRL0007777', 'Neo Banking - Jupiter Kochi', '77770127228993', '9947351654@jupiteraxis', NULL, NULL, '2024-02-03 04:21:22', '2024-02-12 06:34:03'),
(61, 'Dhanwanth MP', '9441156126', 'Kerala State IT Mission', 'dhanwanthmp@gmail.com', 'www', '2', 'IN', 'KL', NULL, '673571', NULL, '$2y$10$zUO3QiujesuZu2hKX3UtBeoZcYNQTHetHiDBBZigtn8xLJHd97O8q', 4, 0, '1673860482.png', 'FEDERAL BANK', 'FDRL0001413', 'KOZHIKODE MAVOOR ROAD', '99980102589269', '9447756126@paytm', NULL, NULL, '2024-02-12 06:29:27', '2024-02-12 07:11:53'),
(62, 'Chooscod', '8075565598', 'Chooscod', 'Chooscod@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zFFFg/AcK3KLqQY8olxTXu5mu3kkPaxqpXrjduN0.hQW1lNIebC96', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-19 08:20:39', '2024-02-19 08:20:39'),
(63, 'Nijas jalal', '9947351654', 'primefotech', 'reach@nijasjalal.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$8uJUPirz1rvLnerJ2cDjiOfMQbjn28tPmiA7RgXsFOyKlvUQHmwW2', 0, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-28 17:05:36', '2024-02-28 17:05:36'),
(67, 'shaji-new-111', '1234567898', 'getlead', 'shaji1@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$bEg4tB2VbiWVHd0EhEZs9enLmDu5sD57dfs0BprWMmm8h9yvQtmte', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:38:15', '2024-07-29 01:38:15'),
(68, 'shaji-new22', '1234567899', 'getlead', 'shaji2@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$G6.CPUF/1DIqTuG9d8kkuu8nudjEbVkkRnzuSSHhO3AmuhvjiSa0q', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:39:58', '2024-07-29 01:39:58'),
(69, 'shaji-new33', '3232422344', 'dfsasdsadasdsdad', 'shaji3@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$owgYrZBE5Z5bNp95Aoh4L.HAqCMKgL.Z.pYeNO.nK9Hqwn8tP1fg2', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:41:26', '2024-07-29 01:41:26'),
(70, 'shaji-new44', '12345678988', 'fdfdfsfsdf', 'shaji4@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$LTNt/jTljYh8ElXcC54FNuuTaEK5y9VYvz0eM/it4EUPkQQf6HokC', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:43:31', '2024-07-29 01:43:31'),
(71, 'shaji-new55', '432434324234', 'efasdfdsfsdfsdf', 'shaji5@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$hcx9xQAN3HKcv0wUwAi3Ae/..EXd2BihuN2nMefuK3oTHfat01YOO', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:45:07', '2024-07-29 01:45:07'),
(72, 'adsdasdadasdsad', '33213132132', 'adasddasdasdasd', 'shaji57@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$AR7ahfUgY1.VJwZVxPuTJ.4Ra2pTjDfYEpnxIZht7/AjJOgl9khTO', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:48:26', '2024-07-29 01:48:26'),
(73, 'sdfdfsfds', '432434234234', 'adasdasdsadsad', 'shaji44@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$WiVFDZlsWty6ebw8LyGvB.ApQeH4euOkiGJ9x.DeyZGMBBI4lt60a', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:50:29', '2024-07-29 01:50:29'),
(74, 'saadasdadad', '432442342343', 'adsdadasdsad', 'shaji32@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$/JqjI9xNLatFZNO1yUaahuZU7RtUjf9La2RawAwehwL6/NqmHPJr.', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:53:09', '2024-07-29 01:53:09'),
(75, 'dasadasdsads', '4342432424', 'sadadsadas', 'shaji43@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$esObAJlXZtaUww8bnUvPL.I0xowp5Bj9YMG9bc7WZJmt6OW0WkSHu', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 01:56:31', '2024-07-29 01:56:31'),
(76, 'fsdfsdfdsfds', '534545343534', 'sdfsdfdsfdsfdsfds', 'shaji54@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$qy4w5kO38zfAL0ZUJ65Ry.4jwKMAd4UitW2Eoj4TIG6JYoZn7DDVe', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 02:07:25', '2024-07-29 02:07:25'),
(77, 'sadassdasd', '4324342344', 'adadasdadasd', 'shaji43@webqua.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$SJQLaH.dWz6.x5/2JMLs.eoOF8dwVqM8GBn0vYycpqPYDgESY8NPC', NULL, 0, '1673860482.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-29 02:10:41', '2024-07-29 02:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `collected_amount` int(11) DEFAULT NULL,
  `commission` int(11) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `lead_id`, `partner_id`, `collected_amount`, `commission`, `percentage`, `payment_date`, `payment_id`, `payment_receipt`, `created_at`, `updated_at`) VALUES
(1, 62, 65, 10000, 500, 5, '2024-07-23', 'ewrrw424234234', 'rec_1722246788.jpg', '2024-07-29 04:23:09', '2024-07-29 04:23:09');

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
-- Table structure for table `product_and_services`
--

CREATE TABLE `product_and_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `users` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `pricing` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_and_services`
--

INSERT INTO `product_and_services` (`id`, `plan_name`, `type`, `users`, `month`, `pricing`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gl-Scratch', 2, 1, 1, 7999, 1, '2023-01-12 12:04:37', '2023-01-13 12:37:05'),
(2, 'Gl-Verify', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(3, 'SMS', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(4, 'IVR', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(5, 'GL Promo	', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(6, 'Campaigns', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(7, 'Missed Call', 2, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(8, 'CRM', 1, 5, 1, 599, 1, '2023-01-12 12:04:37', '2023-01-13 12:35:29'),
(9, 'Ticket', 1, 5, 1, 250, 1, '2023-01-12 12:04:37', '2023-01-12 12:04:37'),
(10, 'Sample', 2, 10, 1, 5200, 1, '2023-01-16 07:25:58', '2023-01-16 07:25:58');

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

-- --------------------------------------------------------

--
-- Table structure for table `verification_otps`
--

CREATE TABLE `verification_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_otps`
--

INSERT INTO `verification_otps` (`id`, `partner_id`, `otp`, `created_at`, `updated_at`) VALUES
(1, 36, '4575', '2023-01-16 08:17:04', '2023-01-16 08:17:04'),
(2, 40, '3080', '2023-02-24 07:19:58', '2023-02-24 07:19:58'),
(3, 40, '9614', '2023-02-24 07:20:07', '2023-02-24 07:20:07'),
(4, 35, '7328', '2023-07-21 10:15:53', '2023-07-21 10:15:53'),
(5, 52, '8305', '2023-07-24 06:15:48', '2023-07-24 06:15:48'),
(6, 54, '5940', '2023-10-24 12:16:43', '2023-10-24 12:16:43'),
(7, 60, '1704', '2024-02-03 04:23:40', '2024-02-03 04:23:40'),
(8, 60, '2145', '2024-02-03 05:23:09', '2024-02-03 05:23:09'),
(9, 63, '8519', '2024-02-28 17:06:41', '2024-02-28 17:06:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bussiness_categories`
--
ALTER TABLE `bussiness_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gl_notification_settings`
--
ALTER TABLE `gl_notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_purposes`
--
ALTER TABLE `lead_purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_statuses`
--
ALTER TABLE `notification_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_and_services`
--
ALTER TABLE `product_and_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `verification_otps`
--
ALTER TABLE `verification_otps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bussiness_categories`
--
ALTER TABLE `bussiness_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl_notification_settings`
--
ALTER TABLE `gl_notification_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invites`
--
ALTER TABLE `invites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `lead_purposes`
--
ALTER TABLE `lead_purposes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_statuses`
--
ALTER TABLE `notification_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_and_services`
--
ALTER TABLE `product_and_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_otps`
--
ALTER TABLE `verification_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
