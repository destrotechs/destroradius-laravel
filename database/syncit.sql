-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2021 at 03:12 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `syncit`
--

-- --------------------------------------------------------

--
-- Table structure for table `customerpackages`
--

CREATE TABLE `customerpackages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` int(11) NOT NULL,
  `packageid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customerpackages`
--

INSERT INTO `customerpackages` (`id`, `customerid`, `packageid`, `created_at`, `updated_at`) VALUES
(1, 5, 2, NULL, NULL),
(2, 6, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'prepaid',
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system_generate',
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'prefer not to say',
  `customer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not a reseller',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `username`, `password`, `phone`, `zone`, `type`, `address`, `email`, `created_by`, `gender`, `customer_type`, `created_at`, `updated_at`) VALUES
(1, 'mike mokay', 'mokaym', '$2y$10$BV/CAJzMjW97TD6B8DIUEu53uj/LobRrtI4JEg9WORSlyweckBAke', '0791875066', '2', 'prepaid', NULL, 'morrisdestro@gmail.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-09 07:02:35', '2021-04-09 07:02:35'),
(2, 'test 1234', 'test1234', '$2y$10$m.Xji4zhUBtJcToSQGrs/u654mTHnmRI0kZXlp/hnnu8mVWeaEuES', '0701530647', '3', 'prepaid', '123 m', 'test@test.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-17 03:34:51', '2021-04-17 03:34:51'),
(3, 'user two34', 'user234', '$2y$10$43qrV5NyG/NnixwW06gimu44TNa6u76sZ948.1nMjzJE3ehupLXIi', '0701530647', '3', 'prepaid', '124m', 'user@user.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-17 03:39:43', '2021-04-17 03:39:43'),
(4, 'my user', 'myuser', '$2y$10$Y5CNMfgsNjEGWRL4/GHDQuVPlzURIIgMDdaJt6GXuH5tjJRLN9.p6', '0701530647', '3', 'prepaid', '123 b', 'myuser@gmail.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-17 04:13:54', '2021-04-17 04:13:54'),
(5, 'user 231', 'user231', '$2y$10$yuqq7nSUDA.p.NKDP9MI5.GPSAvwBXe9N7gRyaOT0Uq38548jXOF.', '0701530647', '3', 'prepaid', '123', 'ew@g.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-20 01:37:01', '2021-04-20 01:37:01'),
(6, 'user one two', 'user12', '$2y$10$ljNse7GYNt8q6FeL7Kj9EeVMRi38aNDqWYY7xXt8pBKzJQPobYTgK', '1234567890', '3', 'prepaid', '123 main', 'user12@user.com', 'admin@admin.com', 'male', 'not a reseller', '2021-04-29 16:21:43', '2021-04-29 16:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(233) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `model`, `serial`, `type`, `quantity`, `cost`, `description`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 'mikrotik router', 'hex604', '0000', 'router', '10', '20000', 'router', '1', '2021-03-19 16:34:17', '2021-03-19 16:34:17'),
(2, 'cisco 2900s', '2900s', '211', 'switch', '2', '20000', 'switch', '1', '2021-03-19 17:23:08', '2021-03-19 17:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user`, `action`, `time`, `created_at`, `updated_at`) VALUES
(1, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:23:25', NULL, NULL),
(2, 'mm', 'Visited packages page /freeradius-client/public/packages/all', '2021-04-08 06:24:08', NULL, NULL),
(3, 'mm', 'Visited packages page /freeradius-client/public/packages/prices', '2021-04-08 06:32:10', NULL, NULL),
(4, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:42:52', NULL, NULL),
(5, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:43:17', NULL, NULL),
(6, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:43:43', NULL, NULL),
(7, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:46:30', NULL, NULL),
(8, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:46:57', NULL, NULL),
(9, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:48:53', NULL, NULL),
(10, 'mm', 'Visited packages page /freeradius-client/public/packages/new', '2021-04-08 06:57:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `managercommissionrates`
--

CREATE TABLE `managercommissionrates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `managerid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managercommissionrates`
--

INSERT INTO `managercommissionrates` (`id`, `managerid`, `type`, `rate`, `created_at`, `updated_at`) VALUES
(1, 1, 'ticket', 10, NULL, NULL),
(2, 2, 'ticket', 10, NULL, NULL),
(3, 4, NULL, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `managertransactions`
--

CREATE TABLE `managertransactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transactionid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `managerid` int(11) NOT NULL,
  `commission` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managertransactions`
--

INSERT INTO `managertransactions` (`id`, `transactionid`, `managerid`, `commission`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, '135504335087', 1, 75, 'paid', 'ticket sold', NULL, NULL),
(2, '720302019311', 1, 75, 'paid', 'ticket sold', NULL, NULL),
(3, '613072748818', 1, 100, 'paid', 'ticket sold', NULL, NULL),
(4, '798543805077', 2, 0, 'paid', 'ticket sold', NULL, NULL),
(5, '515289891419', 2, 75, 'paid', 'ticket sold', NULL, NULL),
(6, '676499717983', 1, 75, 'paid', 'ticket sold', NULL, NULL),
(7, '977268882716', 1, 100, 'paid', 'ticket sold', NULL, NULL),
(8, '255788264816', 1, 10, 'paid', 'ticket sold', NULL, NULL),
(9, '378392101554', 1, 1, 'paid', 'ticket sold', NULL, NULL),
(10, '490552316980', 2, 120, 'paid', 'ticket sold', NULL, NULL),
(11, '030045377190', 2, 200, 'paid', 'ticket sold', NULL, NULL),
(12, '079182858067', 1, 200, 'paid', 'ticket sold', NULL, NULL),
(13, '275672999905', 1, 200, 'paid', 'ticket sold', NULL, NULL),
(14, '541592356815', 2, 75, 'paid', 'ticket sold', NULL, NULL),
(15, '906988126544', 1, 150, 'paid', 'ticket sold', NULL, NULL),
(16, '615745716701', 4, 0, 'paid', 'ticket sold', NULL, NULL),
(17, '455741429897', 1, 120, 'paid', 'ticket sold', NULL, NULL),
(18, '075523566456', 1, 120, 'paid', 'ticket sold', NULL, NULL),
(19, '724868482393', 1, 2, 'paid', 'ticket sold', NULL, NULL),
(20, '211101454545', 1, 200, 'paid', 'ticket sold', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2021_03_07_080426_create_package_prices_table', 4),
(14, '2021_03_12_202525_create_zones_table', 5),
(15, '2021_03_12_204259_create_zonecustomers_table', 6),
(16, '2021_03_12_204334_create_zonemanagers_table', 7),
(17, '2021_03_19_171945_create_items_table', 8),
(18, '2021_03_19_172015_create_products_table', 8),
(19, '2021_03_19_172050_create_supplies_table', 8),
(20, '2021_03_21_091618_create_vendors_table', 9),
(23, '2021_04_08_172900_logs', 11),
(25, '2021_04_08_173955_settings', 12),
(29, '2021_02_28_151304_create_packages_table', 14),
(32, '2021_04_09_084902_customerpackages', 15),
(33, '2021_02_27_134413_create_customers_table', 16),
(34, '2021_04_09_073017_naszones', 16),
(36, '2021_04_09_113552_create_transactions_table', 17),
(38, '2021_04_09_114612_managercommissionrates', 17),
(39, '2021_03_24_140015_create_tickets_table', 18),
(42, '2021_04_09_114020_managertransactions', 19),
(43, '2014_10_12_000000_create_users_table', 20),
(44, '2021_03_12_201628_create_managers_table', 21),
(45, '2021_04_09_193651_create_permission_tables', 21);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

CREATE TABLE `nas` (
  `id` int(10) NOT NULL,
  `nasname` varchar(128) NOT NULL,
  `shortname` varchar(32) DEFAULT NULL,
  `type` varchar(30) DEFAULT 'other',
  `ports` int(5) DEFAULT NULL,
  `secret` varchar(60) NOT NULL DEFAULT 'secret',
  `server` varchar(64) DEFAULT NULL,
  `community` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT 'RADIUS Client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nas`
--

INSERT INTO `nas` (`id`, `nasname`, `shortname`, `type`, `ports`, `secret`, `server`, `community`, `description`) VALUES
(1, '0.0.0.0', '3', 'mikrotik', NULL, '0000', NULL, NULL, 'qqq');

-- --------------------------------------------------------

--
-- Table structure for table `naszones`
--

CREATE TABLE `naszones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zoneid` int(11) NOT NULL,
  `nasid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `naszones`
--

INSERT INTO `naszones` (`id`, `zoneid`, `nasid`, `created_at`, `updated_at`) VALUES
(1, 2, 17, NULL, NULL),
(2, 3, 18, NULL, NULL),
(3, 6, 19, NULL, NULL),
(4, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packagename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploadspeed` int(11) NOT NULL,
  `downloadspeed` int(11) NOT NULL,
  `numberofdevices` int(11) NOT NULL,
  `quota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `packagezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validdays` int(11) DEFAULT NULL,
  `durationmeasure` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `packagename`, `uploadspeed`, `downloadspeed`, `numberofdevices`, `quota`, `users`, `packagezone`, `validdays`, `durationmeasure`, `created_at`, `updated_at`) VALUES
(1, '512K/512K', 524288, 524288, 2, '104857600000', 'hotspot', 'all zones', 30, '', '2021-04-09 05:19:58', '2021-04-09 05:19:58'),
(2, '1M/1M', 1048576, 1048576, 2, '107374182400', 'hotspot', 'all zones', 30, 'day', '2021-04-09 15:31:47', '2021-04-09 15:31:47'),
(4, '1M', 1048576, 1048576, 5, '107374182400', 'hotspot', 'all zones', 30, '', '2021-04-11 12:30:34', '2021-04-11 12:30:34'),
(5, '100MBs', 2097152, 2097152, 1, '104857600', 'hotspot', 'all zones', 30, '', '2021-04-14 05:30:13', '2021-04-14 05:30:13'),
(6, '500Mbs', 2097152, 2097152, 1, '104857600000', 'hotspot', 'zone M', 30, '', '2021-04-14 09:11:54', '2021-04-14 09:11:54'),
(7, '1.5M/1.5M', 1572864, 1572864, 1, '107374182400', 'hotspot', 'all zones', 2, '', '2021-04-17 03:24:42', '2021-04-17 03:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `package_prices`
--

CREATE TABLE `package_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packageid` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_prices`
--

INSERT INTO `package_prices` (`id`, `packageid`, `currency`, `amount`, `rate`, `created_at`, `updated_at`) VALUES
(1, 4, 'KSH', 1200.00, '1 Month', '2021-03-07 15:09:58', '2021-03-07 15:09:58'),
(2, 6, 'KSH', 50.00, '1 Month', NULL, NULL),
(3, 3, 'KSH', 1000.00, '1 Month', NULL, NULL),
(4, 1, 'KSH', 1500.00, '1 Month', NULL, NULL),
(5, 2, 'KSH', 2000.00, '1 Month', NULL, NULL),
(6, 5, 'KSH', 20.00, '1 Month', NULL, NULL),
(7, 7, 'KSH', 2000.00, 'null', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@admin.com', '$2y$10$/5znHir9Y4bd.QH6aHQD1OiWUw.E/p/VdK0G/6NI9Iq00v/0xT0rq', '2021-04-14 06:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producttype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `producttype`, `vendor`, `price`, `created_at`, `updated_at`) VALUES
(1, '4g', 'network', 'safaricom', '14000', '2021-03-19 18:06:19', '2021-03-19 18:06:19'),
(2, '5g', 'network', 'safaricom', '30000', '2021-04-29 09:37:13', '2021-04-29 09:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

CREATE TABLE `radacct` (
  `radacctid` bigint(21) NOT NULL,
  `acctsessionid` varchar(64) NOT NULL DEFAULT '',
  `acctuniqueid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `realm` varchar(64) DEFAULT '',
  `nasipaddress` varchar(15) NOT NULL DEFAULT '',
  `nasportid` varchar(32) DEFAULT NULL,
  `nasporttype` varchar(32) DEFAULT NULL,
  `acctstarttime` datetime DEFAULT NULL,
  `acctupdatetime` datetime DEFAULT NULL,
  `acctstoptime` datetime DEFAULT NULL,
  `acctinterval` int(12) DEFAULT NULL,
  `acctsessiontime` int(12) UNSIGNED DEFAULT NULL,
  `acctauthentic` varchar(32) DEFAULT NULL,
  `connectinfo_start` varchar(50) DEFAULT NULL,
  `connectinfo_stop` varchar(50) DEFAULT NULL,
  `acctinputoctets` bigint(20) DEFAULT NULL,
  `acctoutputoctets` bigint(20) DEFAULT NULL,
  `calledstationid` varchar(50) NOT NULL DEFAULT '',
  `callingstationid` varchar(50) NOT NULL DEFAULT '',
  `acctterminatecause` varchar(32) NOT NULL DEFAULT '',
  `servicetype` varchar(32) DEFAULT NULL,
  `framedprotocol` varchar(32) DEFAULT NULL,
  `framedipaddress` varchar(15) NOT NULL DEFAULT '',
  `framedipv6address` varchar(45) NOT NULL DEFAULT '',
  `framedipv6prefix` varchar(45) NOT NULL DEFAULT '',
  `framedinterfaceid` varchar(44) NOT NULL DEFAULT '',
  `delegatedipv6prefix` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

CREATE TABLE `radcheck` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radcheck`
--

INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'gLF28e', 'Cleartext-Password', ':=', 'U7BJM'),
(2, 'URKgrL', 'Cleartext-Password', ':=', '6769L'),
(3, 'dZZsBc', 'Cleartext-Password', ':=', '5PFF7'),
(4, '257z24', 'Cleartext-Password', ':=', 'WLE23'),
(5, 'CAkALT', 'Cleartext-Password', ':=', 'E5QXK'),
(6, 'bajVmv', 'Cleartext-Password', ':=', 'FZHKH'),
(7, 'K45hcj', 'Cleartext-Password', ':=', '94DF4'),
(8, '7AHtBK', 'Cleartext-Password', ':=', 'S4QVN'),
(9, 'mokaym', 'Cleartext-Password', ':=', '123456'),
(10, 'B3XAt8', 'Cleartext-Password', ':=', 'WZL5V'),
(11, 'w6psHC', 'Cleartext-Password', ':=', 'YKMPU'),
(12, 'HqJrxf', 'Cleartext-Password', ':=', 'YZ5F6'),
(13, 'NusGxK', 'Cleartext-Password', ':=', 'Y6Z39'),
(14, 'SbWXZr', 'Cleartext-Password', ':=', '3NNEN'),
(15, 'mBXGfS', 'Cleartext-Password', ':=', 'M6JKS'),
(16, 'qWqtjg', 'Cleartext-Password', ':=', 'CJZH4'),
(17, 'F2PSBw', 'Cleartext-Password', ':=', '33YZQ'),
(18, 'qRFH4Q', 'Cleartext-Password', ':=', '2Q4T4'),
(19, 'BSSfqu', 'Cleartext-Password', ':=', '9FLWT'),
(20, 'TfwXeH', 'Cleartext-Password', ':=', 'DU428'),
(21, 'llRdSb', 'Cleartext-Password', ':=', 'VV4AF'),
(22, 'bJK6ZK', 'Cleartext-Password', ':=', 'ZWR8A'),
(23, 'f24YpS', 'Cleartext-Password', ':=', 'AWZNG'),
(24, 'TpLmbE', 'Cleartext-Password', ':=', '6NP6T'),
(25, 'dr9LvW', 'Cleartext-Password', ':=', '8UGVT'),
(26, 'mRG8Ee', 'Cleartext-Password', ':=', 'Q8PTZ'),
(27, 'eNfXqs', 'Cleartext-Password', ':=', '74ZME'),
(28, '8XGSzv', 'Cleartext-Password', ':=', 'TJ28G'),
(29, 'mgRGJC', 'Cleartext-Password', ':=', '5QAJM'),
(30, 'VTQWhJ', 'Cleartext-Password', ':=', 'MJJNF'),
(31, '7cnLPG', 'Cleartext-Password', ':=', 'SSFMH'),
(32, 'aJvnzR', 'Cleartext-Password', ':=', 'GBWEL'),
(33, 'fJGLm2', 'Cleartext-Password', ':=', '8NX5C'),
(34, 'xSf3lZ', 'Cleartext-Password', ':=', 'XVZ5X'),
(35, 'jUQ7BS', 'Cleartext-Password', ':=', 'Z3AQZ'),
(36, 'qYpSvu', 'Cleartext-Password', ':=', '8P67D'),
(37, 'tNrC3y', 'Cleartext-Password', ':=', 'YAVRU'),
(38, '3q5GjE', 'Cleartext-Password', ':=', '9BM2D'),
(39, '7qf4VD', 'Cleartext-Password', ':=', 'ZCV6N'),
(40, 'rcJDah', 'Cleartext-Password', ':=', 'BP3A6'),
(41, 'EskqJS', 'Cleartext-Password', ':=', 'XPX9J'),
(42, 'EJMTRe', 'Cleartext-Password', ':=', 'MLM99'),
(43, '32RMEf', 'Cleartext-Password', ':=', '9MZG9'),
(44, 'CSsfTh', 'Cleartext-Password', ':=', '8JXEN'),
(45, 'ckP4vq', 'Cleartext-Password', ':=', '6V38S'),
(46, 'rnyRNM', 'Cleartext-Password', ':=', 'RW54H'),
(47, '7XGwly', 'Cleartext-Password', ':=', 'ZTQWD'),
(48, 'wm9AHa', 'Cleartext-Password', ':=', 'Q4UUB'),
(49, 'F2nWjw', 'Cleartext-Password', ':=', 'PLTNW'),
(50, 'vKVCCy', 'Cleartext-Password', ':=', 'G4556'),
(51, 'DTwqty', 'Cleartext-Password', ':=', '6AM73'),
(52, 'sw6kxb', 'Cleartext-Password', ':=', 'TEL26'),
(53, 'QYyvEk', 'Cleartext-Password', ':=', 'HBK3R'),
(54, 'y9xSSQ', 'Cleartext-Password', ':=', 'AKJL2'),
(55, 'pmxfPB', 'Cleartext-Password', ':=', 'HF223'),
(56, 'test1234', 'Cleartext-Password', ':=', 'test1234'),
(57, 'user234', 'Cleartext-Password', ':=', 'user234'),
(58, 'user234', 'Expire-After', ':=', '172800'),
(59, 'myuser', 'Cleartext-Password', ':=', 'myuser'),
(60, 'myuser', 'Expire-After', ':=', '2592000'),
(61, 'myuser', 'Max-All-MB', ':=', '107374182400'),
(62, 'user231', 'Cleartext-Password', ':=', 'user231'),
(63, 'user231', 'Expire-After', ':=', '2592000'),
(64, 'user231', 'Max-All-MB', ':=', '107374182400'),
(65, 'user12', 'Cleartext-Password', ':=', '123456'),
(66, 'user12', 'Expire-After', ':=', '2592000'),
(67, 'user12', 'Max-All-MB', ':=', '104857600'),
(68, '8WcXaR', 'Cleartext-Password', ':=', 'UHV9F'),
(69, 'zuaZUj', 'Cleartext-Password', ':=', 'N5MN8'),
(70, 'vSXdBl', 'Cleartext-Password', ':=', 'NHKDT'),
(71, 'zfaEUV', 'Cleartext-Password', ':=', 'A7NRY'),
(72, 'qwWEnE', 'Cleartext-Password', ':=', 'RDCUH'),
(73, 'jZ9lBB', 'Cleartext-Password', ':=', '9L9VZ'),
(74, 'BZtprF', 'Cleartext-Password', ':=', '2S6JK'),
(75, 'yR9JNk', 'Cleartext-Password', ':=', 'SE9PW'),
(76, 'QLTFmJ', 'Cleartext-Password', ':=', 'KEW62'),
(77, 'jdApgp', 'Cleartext-Password', ':=', 'BTRMR');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

CREATE TABLE `radgroupcheck` (
  `id` int(11) UNSIGNED NOT NULL,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radgroupcheck`
--

INSERT INTO `radgroupcheck` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(15, '512K/512K', 'Max-All-MB', ':=', '104857600000'),
(16, '512K/512K', 'Max-All-MB', ':=', '104857600000'),
(18, '1M', 'Max-All-MB', ':=', '107374182400'),
(19, '100MBs', 'Max-All-MB', ':=', '104857600'),
(20, '500Mbs', 'Max-All-MB', ':=', '104857600000'),
(22, '1.5M/1.5M', 'Max-All-MB', ':=', '107374182400'),
(24, '1M/1M', 'Max-All-MB', ':=', '107374182400'),
(25, '1M/1M', 'Max-All-Session', ':=', '2592000');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

CREATE TABLE `radgroupreply` (
  `id` int(11) UNSIGNED NOT NULL,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radgroupreply`
--

INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(58, '512K/512K', 'WISPr-Bandwidth-Max-Down', ':=', '524288'),
(59, '512K/512K', 'WISPr-Bandwidth-Max-Up', ':=', '524288'),
(60, '512K/512K', 'Simultaneous-Use', ':=', '2'),
(61, '512K/512K', 'Max-All-MB', ':=', '104857600000'),
(62, '512K/512K', 'WISPr-Bandwidth-Max-Down', ':=', '524288'),
(63, '512K/512K', 'WISPr-Bandwidth-Max-Up', ':=', '524288'),
(64, '512K/512K', 'Simultaneous-Use', ':=', '2'),
(65, '512K/512K', 'Max-All-MB', ':=', '104857600000'),
(70, '1M', 'WISPr-Bandwidth-Max-Down', ':=', '1048576'),
(71, '1M', 'WISPr-Bandwidth-Max-Up', ':=', '1048576'),
(72, '1M', 'Simultaneous-Use', ':=', '5'),
(73, '1M', 'Max-All-MB', ':=', '107374182400'),
(74, '100MBs', 'WISPr-Bandwidth-Max-Down', ':=', '2097152'),
(75, '100MBs', 'WISPr-Bandwidth-Max-Up', ':=', '2097152'),
(76, '100MBs', 'Simultaneous-Use', ':=', '1'),
(77, '100MBs', 'Max-All-MB', ':=', '104857600'),
(78, '500Mbs', 'WISPr-Bandwidth-Max-Down', ':=', '2097152'),
(79, '500Mbs', 'WISPr-Bandwidth-Max-Up', ':=', '2097152'),
(80, '500Mbs', 'Simultaneous-Use', ':=', '1'),
(81, '500Mbs', 'Max-All-MB', ':=', '104857600000'),
(86, '1.5M/1.5M', 'WISPr-Bandwidth-Max-Down', ':=', '1572864'),
(87, '1.5M/1.5M', 'WISPr-Bandwidth-Max-Up', ':=', '1572864'),
(88, '1.5M/1.5M', 'Simultaneous-Use', ':=', '1'),
(89, '1.5M/1.5M', 'Max-All-MB', ':=', '107374182400'),
(94, '1M/1M', 'WISPr-Bandwidth-Max-Down', ':=', '1048576'),
(95, '1M/1M', 'WISPr-Bandwidth-Max-Up', ':=', '1048576'),
(96, '1M/1M', 'Simultaneous-Use', ':=', '2'),
(97, '1M/1M', 'Max-All-MB', ':=', '107374182400'),
(98, '1M/1M', 'Max-All-Session', ':=', '2592000');

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

CREATE TABLE `radpostauth` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `pass` varchar(64) NOT NULL DEFAULT '',
  `reply` varchar(32) NOT NULL DEFAULT '',
  `authdate` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

CREATE TABLE `radreply` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radreply`
--

INSERT INTO `radreply` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'myuser', 'Max-All-MB', ':=', '107374182400'),
(2, 'user231', 'Max-All-MB', ':=', '107374182400'),
(3, 'user12', 'Max-All-MB', ':=', '104857600');

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

CREATE TABLE `radusergroup` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radusergroup`
--

INSERT INTO `radusergroup` (`id`, `username`, `groupname`, `priority`) VALUES
(1, 'gLF28e', '5', 1),
(2, 'URKgrL', '5', 1),
(6, 'bajVmv', '1M/1M', 1),
(7, 'K45hcj', '1M/1M', 1),
(8, '7AHtBK', '1M/1M', 1),
(9, 'mokaym', '512K/512K', 10),
(10, 'SbWXZr', '512K/512K', 1),
(11, 'mBXGfS', '512K/512K', 1),
(12, 'qWqtjg', '512K/512K', 1),
(13, 'F2PSBw', '512K/512K', 1),
(14, 'qRFH4Q', '512K/512K', 1),
(15, 'BSSfqu', '512K/512K', 1),
(16, 'TfwXeH', '512K/512K', 1),
(17, 'llRdSb', '512K/512K', 1),
(18, 'bJK6ZK', '512K/512K', 1),
(19, 'f24YpS', '512K/512K', 1),
(20, 'TpLmbE', '512K/512K', 1),
(21, 'dr9LvW', '512K/512K', 1),
(22, 'mRG8Ee', '512K/512K', 1),
(23, 'eNfXqs', '512K/512K', 1),
(24, '8XGSzv', '512K/512K', 1),
(25, 'mgRGJC', '512K/512K', 1),
(26, 'VTQWhJ', '512K/512K', 1),
(27, '7cnLPG', '512K/512K', 1),
(28, 'aJvnzR', '512K/512K', 1),
(29, 'fJGLm2', '512K/512K', 1),
(30, 'xSf3lZ', '1M/1M', 1),
(31, 'jUQ7BS', '1M/1M', 1),
(32, 'qYpSvu', '1M/1M', 1),
(33, 'tNrC3y', '1M/1M', 1),
(34, '3q5GjE', '1M/1M', 1),
(35, '7qf4VD', '1M/1M', 1),
(36, 'rcJDah', '512K/512K', 1),
(37, 'EskqJS', '512K/512K', 1),
(38, 'EJMTRe', '512K/512K', 1),
(39, '32RMEf', '1M', 1),
(40, 'CSsfTh', '1M', 1),
(41, 'ckP4vq', '1M', 1),
(42, 'rnyRNM', '1M/1M', 1),
(43, '7XGwly', '1M/1M', 1),
(44, 'wm9AHa', '1M/1M', 1),
(45, 'F2nWjw', '1M/1M', 1),
(46, 'vKVCCy', '1M/1M', 1),
(47, 'DTwqty', '100MBs', 1),
(48, 'sw6kxb', '100MBs', 1),
(49, 'QYyvEk', '100MBs', 1),
(50, 'y9xSSQ', '100MBs', 1),
(51, 'pmxfPB', '100MBs', 1),
(52, 'test1234', '1.5M/1.5M', 10),
(53, 'user234', '1.5M/1.5M', 10),
(54, 'myuser', '1M/1M', 10),
(55, 'user231', '1M/1M', 10),
(56, 'user12', '100MBs', 10),
(57, '8WcXaR', '1.5M/1.5M', 1),
(58, 'zuaZUj', '1.5M/1.5M', 1),
(59, 'vSXdBl', '1.5M/1.5M', 1),
(60, 'zfaEUV', '1.5M/1.5M', 1),
(61, 'qwWEnE', '1.5M/1.5M', 1),
(62, 'jZ9lBB', '1.5M/1.5M', 1),
(63, 'BZtprF', '1.5M/1.5M', 1),
(64, 'yR9JNk', '1.5M/1.5M', 1),
(65, 'QLTFmJ', '1.5M/1.5M', 1),
(66, 'jdApgp', '1.5M/1.5M', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logs_enabled` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logs_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`id`, `supplier_name`, `address`, `zipcode`, `email`, `contact`, `phone`, `description`, `created_at`, `updated_at`) VALUES
(2, 'goodwill stores', 'kk', '1', 'manager@one.com', 'muriithi', '4122366', 'food stuff', '2021-03-20 11:20:47', '2021-03-20 11:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignedto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'low',
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'closed',
  `package` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serialnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` double NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `customer_username`, `assignedto`, `group`, `priority`, `status`, `package`, `serialnumber`, `cost`, `type`, `password`, `subject`, `message`, `location`, `created_at`, `updated_at`) VALUES
(1, '8XGSzv', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '135504335087', 1500, NULL, 'TJ28G', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:07:38', '2021-04-09 15:07:38'),
(2, 'mgRGJC', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '346313456022', 1500, NULL, '5QAJM', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:07:38', '2021-04-09 15:07:38'),
(3, 'VTQWhJ', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '382216994669', 1500, NULL, 'MJJNF', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:07:38', '2021-04-09 15:07:38'),
(4, '7cnLPG', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '515289891419', 1500, NULL, 'SSFMH', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:20:02', '2021-04-09 15:20:02'),
(6, 'fJGLm2', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '720302019311', 1500, NULL, '8NX5C', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:20:03', '2021-04-09 15:20:03'),
(10, 'tNrC3y', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '798543805077', 2000, NULL, 'YAVRU', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:41:41', '2021-04-09 15:41:41'),
(11, '3q5GjE', 'me', '1M/1M', '1', 'open', '1M/1M', '941178139985', 2000, NULL, '9BM2D', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:41:41', '2021-04-09 15:41:41'),
(12, '7qf4VD', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '613072748818', 2000, NULL, 'ZCV6N', 'package ticket', 'auto generated package ', 'all', '2021-04-09 15:41:41', '2021-04-09 15:41:41'),
(13, 'rcJDah', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '676499717983', 1500, NULL, 'BP3A6', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:28:58', '2021-04-11 12:28:58'),
(14, 'EskqJS', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '541592356815', 1500, NULL, 'XPX9J', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:28:59', '2021-04-11 12:28:59'),
(15, 'EJMTRe', 'all managers', '512K/512K', '1', 'closed', '512K/512K', '906988126544', 1500, NULL, 'MLM99', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:28:59', '2021-04-11 12:28:59'),
(16, '32RMEf', 'all managers', '1M', '1', 'closed', '1M', '615745716701', 1200, NULL, '9MZG9', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:34:52', '2021-04-11 12:34:52'),
(17, 'CSsfTh', 'all managers', '1M', '1', 'closed', '1M', '455741429897', 1200, NULL, '8JXEN', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:34:52', '2021-04-11 12:34:52'),
(18, 'ckP4vq', 'all managers', '1M', '1', 'closed', '1M', '075523566456', 1200, NULL, '6V38S', 'package ticket', 'auto generated package ', 'all', '2021-04-11 12:34:52', '2021-04-11 12:34:52'),
(19, 'rnyRNM', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '275672999905', 2000, NULL, 'RW54H', 'package ticket', 'auto generated package ', 'all', '2021-04-14 03:37:02', '2021-04-14 03:37:02'),
(20, '7XGwly', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '977268882716', 2000, NULL, 'ZTQWD', 'package ticket', 'auto generated package ', 'all', '2021-04-14 03:37:02', '2021-04-14 03:37:02'),
(21, 'wm9AHa', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '079182858067', 2000, NULL, 'Q4UUB', 'package ticket', 'auto generated package ', 'all', '2021-04-14 03:37:02', '2021-04-14 03:37:02'),
(22, 'F2nWjw', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '030045377190', 2000, NULL, 'PLTNW', 'package ticket', 'auto generated package ', 'all', '2021-04-14 03:37:03', '2021-04-14 03:37:03'),
(23, 'vKVCCy', 'all managers', '1M/1M', '1', 'closed', '1M/1M', '490552316980', 2000, NULL, 'G4556', 'package ticket', 'auto generated package ', 'all', '2021-04-14 03:37:03', '2021-04-14 03:37:03'),
(24, 'DTwqty', 'all managers', '100MBs', '1', 'closed', '100MBs', '724868482393', 20, NULL, '6AM73', 'package ticket', 'auto generated package ', 'all', '2021-04-14 05:30:54', '2021-04-14 05:30:54'),
(25, 'sw6kxb', 'all managers', '100MBs', '1', 'closed', '100MBs', '255788264816', 20, NULL, 'TEL26', 'package ticket', 'auto generated package ', 'all', '2021-04-14 05:30:54', '2021-04-14 05:30:54'),
(26, 'QYyvEk', 'all managers', '100MBs', '1', 'open', '100MBs', '596873366475', 20, NULL, 'HBK3R', 'package ticket', 'auto generated package ', 'all', '2021-04-14 05:30:54', '2021-04-14 05:30:54'),
(27, 'y9xSSQ', 'all managers', '100MBs', '1', 'open', '100MBs', '877319983640', 20, NULL, 'AKJL2', 'package ticket', 'auto generated package ', 'all', '2021-04-14 05:30:54', '2021-04-14 05:30:54'),
(28, 'pmxfPB', 'all managers', '100MBs', '1', 'closed', '100MBs', '378392101554', 20, NULL, 'HF223', 'package ticket', 'auto generated package ', 'all', '2021-04-14 05:30:54', '2021-04-14 05:30:54'),
(29, '8WcXaR', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '197462447966', 2000, NULL, 'UHV9F', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:55', '2021-05-01 15:27:55'),
(30, 'zuaZUj', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '437666938885', 2000, NULL, 'N5MN8', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:55', '2021-05-01 15:27:55'),
(31, 'vSXdBl', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '748286199026', 2000, NULL, 'NHKDT', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:56', '2021-05-01 15:27:56'),
(32, 'zfaEUV', 'all managers', '1.5M/1.5M', '1', 'closed', '1.5M/1.5M', '211101454545', 2000, NULL, 'A7NRY', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:56', '2021-05-01 15:27:56'),
(33, 'qwWEnE', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '878963418622', 2000, NULL, 'RDCUH', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:56', '2021-05-01 15:27:56'),
(34, 'jZ9lBB', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '677601631919', 2000, NULL, '9L9VZ', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:57', '2021-05-01 15:27:57'),
(35, 'BZtprF', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '846836304968', 2000, NULL, '2S6JK', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:57', '2021-05-01 15:27:57'),
(36, 'yR9JNk', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '908604635016', 2000, NULL, 'SE9PW', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:57', '2021-05-01 15:27:57'),
(37, 'QLTFmJ', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '670885713850', 2000, NULL, 'KEW62', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:57', '2021-05-01 15:27:57'),
(38, 'jdApgp', 'all managers', '1.5M/1.5M', '1', 'open', '1.5M/1.5M', '006970272041', 2000, NULL, 'BTRMR', 'package ticket', 'auto generated package ', 'all', '2021-05-01 15:27:58', '2021-05-01 15:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initiator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `amount`, `initiator`, `description`, `created_at`, `updated_at`) VALUES
(1, '3', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:07:59', '2021-04-09 15:07:59'),
(2, '3', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:09:48', '2021-04-09 15:09:48'),
(3, '2', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:12:34', '2021-04-09 15:12:34'),
(4, '2', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:13:12', '2021-04-09 15:13:12'),
(5, '1', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:16:22', '2021-04-09 15:16:22'),
(6, '1', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:16:56', '2021-04-09 15:16:56'),
(7, '6', '1500', 'admin@admin.com', 'ticket sold', '2021-04-09 15:20:15', '2021-04-09 15:20:15'),
(8, '12', '2000', 'admin@admin.com', 'ticket sold', '2021-04-09 15:41:58', '2021-04-09 15:41:58'),
(9, '10', '2000', 'managerone@manager.com', 'ticket sold', '2021-04-09 16:16:23', '2021-04-09 16:16:23'),
(10, '4', '1500', 'managerone@manager.com', 'ticket sold', '2021-04-09 16:17:49', '2021-04-09 16:17:49'),
(11, '13', '1500', 'admin@admin.com', 'ticket sold', '2021-04-11 12:29:22', '2021-04-11 12:29:22'),
(12, '20', '2000', 'admin@admin.com', 'ticket sold', '2021-04-14 03:37:27', '2021-04-14 03:37:27'),
(13, '25', '20', 'admin@admin.com', 'ticket sold', '2021-04-14 09:04:54', '2021-04-14 09:04:54'),
(14, '28', '20', 'admin@admin.com', 'ticket sold', '2021-04-14 09:05:57', '2021-04-14 09:05:57'),
(15, '23', '2000', 'managerone@manager.com', 'ticket sold', '2021-04-14 11:18:32', '2021-04-14 11:18:32'),
(16, '22', '2000', 'managerone@manager.com', 'ticket sold', '2021-04-14 15:29:45', '2021-04-14 15:29:45'),
(17, '21', '2000', 'admin@admin.com', 'ticket sold', '2021-04-17 15:42:21', '2021-04-17 15:42:21'),
(18, '19', '2000', 'admin@admin.com', 'ticket sold', '2021-04-28 08:24:17', '2021-04-28 08:24:17'),
(19, '14', '1500', 'managerone@manager.com', 'ticket sold', '2021-04-28 14:45:29', '2021-04-28 14:45:29'),
(20, '15', '1500', 'admin@admin.com', 'ticket sold', '2021-04-29 02:22:15', '2021-04-29 02:22:15'),
(21, '16', '1200', 'manager2@one.com', 'ticket sold', '2021-04-29 03:19:25', '2021-04-29 03:19:25'),
(22, '17', '1200', 'admin@admin.com', 'ticket sold', '2021-04-30 15:44:17', '2021-04-30 15:44:17'),
(23, '18', '1200', 'admin@admin.com', 'ticket sold', '2021-04-30 15:44:23', '2021-04-30 15:44:23'),
(24, '24', '20', 'admin@admin.com', 'ticket sold', '2021-04-30 15:44:29', '2021-04-30 15:44:29'),
(25, '32', '2000', 'admin@admin.com', 'ticket sold', '2021-05-01 15:28:23', '2021-05-01 15:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `city`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin One', 'admin@admin.com', NULL, '$2y$10$K8mva5DZMKM3YpiUGO9A..X5S9u8ulSHXFiKW7zqd3V3Ey1U2xZK6', 1, '', '', '', 'ZMosTve0zDhsGU3FFKTRs29oX3wLcEsskknKOfbMDESWEof0FbSccn05BWvp', '2021-04-09 16:04:13', '2021-04-09 16:04:13'),
(2, 'Manager one', 'managerone@manager.com', NULL, '$2y$10$1BpTorcVJN/MnUyEdkDjceLET0VOSjZhmsEVcniUB1CejpUOr42Gq', 2, 'Nairobi', '0123456789', 'meru', NULL, '2021-04-09 16:07:44', '2021-04-29 13:43:36'),
(4, 'manager two', 'manager2@one.com', NULL, '$2y$10$ortKfgE0JQ74bQa.msMig.CXR6DgN9hisyDEUqAkuULBT5P/RBCry', 2, 'igoji', '0701530647', 'kk', NULL, '2021-04-29 03:03:02', '2021-04-29 03:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `vendor`, `description`, `created_at`, `updated_at`) VALUES
(1, 'mikrotik', 'main nas', '2021-03-21 06:48:42', '2021-03-24 10:41:59'),
(3, 'freeradius', 'AAA server', '2021-03-21 12:33:01', '2021-04-28 10:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `zonecustomers`
--

CREATE TABLE `zonecustomers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zoneid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customertotal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zonemanagers`
--

CREATE TABLE `zonemanagers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `managerid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zoneid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zonemanagers`
--

INSERT INTO `zonemanagers` (`id`, `managerid`, `zoneid`, `created_at`, `updated_at`) VALUES
(5, '1', '2', NULL, NULL),
(6, '1', '3', NULL, NULL),
(8, '1', '5', NULL, NULL),
(9, '2', '6', NULL, NULL),
(10, '4', '7', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zonename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `networktype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hotspot',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `zonename`, `networktype`, `created_at`, `updated_at`) VALUES
(2, 'chuka', 'hotspot', '2021-04-04 05:51:45', '2021-04-04 05:51:45'),
(3, 'kk', 'hotspot', '2021-04-04 06:36:57', '2021-04-09 03:46:59'),
(6, 'zone M', 'hotspot', '2021-04-14 09:09:53', '2021-04-14 09:10:46'),
(7, 'Zone A', 'hotspot', '2021-04-28 08:11:14', '2021-04-28 08:11:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customerpackages`
--
ALTER TABLE `customerpackages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managercommissionrates`
--
ALTER TABLE `managercommissionrates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managertransactions`
--
ALTER TABLE `managertransactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nas`
--
ALTER TABLE `nas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nasname` (`nasname`);

--
-- Indexes for table `naszones`
--
ALTER TABLE `naszones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_packagename_unique` (`packagename`);

--
-- Indexes for table `package_prices`
--
ALTER TABLE `package_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radacct`
--
ALTER TABLE `radacct`
  ADD PRIMARY KEY (`radacctid`),
  ADD UNIQUE KEY `acctuniqueid` (`acctuniqueid`),
  ADD KEY `username` (`username`),
  ADD KEY `framedipaddress` (`framedipaddress`),
  ADD KEY `framedipv6address` (`framedipv6address`),
  ADD KEY `framedipv6prefix` (`framedipv6prefix`),
  ADD KEY `framedinterfaceid` (`framedinterfaceid`),
  ADD KEY `delegatedipv6prefix` (`delegatedipv6prefix`),
  ADD KEY `acctsessionid` (`acctsessionid`),
  ADD KEY `acctsessiontime` (`acctsessiontime`),
  ADD KEY `acctstarttime` (`acctstarttime`),
  ADD KEY `acctinterval` (`acctinterval`),
  ADD KEY `acctstoptime` (`acctstoptime`),
  ADD KEY `nasipaddress` (`nasipaddress`),
  ADD KEY `bulk_close` (`acctstoptime`,`nasipaddress`,`acctstarttime`);

--
-- Indexes for table `radcheck`
--
ALTER TABLE `radcheck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`(32));

--
-- Indexes for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radpostauth`
--
ALTER TABLE `radpostauth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radreply`
--
ALTER TABLE `radreply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`(32));

--
-- Indexes for table `radusergroup`
--
ALTER TABLE `radusergroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`(32));

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zonecustomers`
--
ALTER TABLE `zonecustomers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zonemanagers`
--
ALTER TABLE `zonemanagers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customerpackages`
--
ALTER TABLE `customerpackages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `managercommissionrates`
--
ALTER TABLE `managercommissionrates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `managertransactions`
--
ALTER TABLE `managertransactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `nas`
--
ALTER TABLE `nas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `naszones`
--
ALTER TABLE `naszones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `package_prices`
--
ALTER TABLE `package_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `radacct`
--
ALTER TABLE `radacct`
  MODIFY `radacctid` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radcheck`
--
ALTER TABLE `radcheck`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `radpostauth`
--
ALTER TABLE `radpostauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radreply`
--
ALTER TABLE `radreply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `radusergroup`
--
ALTER TABLE `radusergroup`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zonecustomers`
--
ALTER TABLE `zonecustomers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zonemanagers`
--
ALTER TABLE `zonemanagers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
