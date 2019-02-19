-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2019 at 10:54 AM
-- Server version: 10.2.19-MariaDB-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhamma12_meditation`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(10) UNSIGNED NOT NULL,
  `friend1` int(11) NOT NULL,
  `friend2` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`id`, `friend1`, `friend2`, `created_at`, `updated_at`) VALUES
(3, 1, 5, '2019-01-22 20:47:15', '2019-01-22 20:47:15'),
(4, 5, 1, '2019-01-22 20:47:15', '2019-01-22 20:47:15'),
(7, 1, 3, '2019-01-23 01:15:00', '2019-01-23 01:15:00'),
(8, 3, 1, '2019-01-23 01:15:00', '2019-01-23 01:15:00'),
(9, 8, 1, '2019-02-08 22:42:08', '2019-02-08 22:42:08'),
(10, 1, 8, '2019-02-08 22:42:08', '2019-02-08 22:42:08'),
(11, 16, 1, '2019-02-08 22:56:48', '2019-02-08 22:56:48'),
(12, 1, 16, '2019-02-08 22:56:48', '2019-02-08 22:56:48'),
(13, 15, 16, '2019-02-08 23:07:26', '2019-02-08 23:07:26'),
(14, 16, 15, '2019-02-08 23:07:26', '2019-02-08 23:07:26'),
(15, 15, 1, '2019-02-08 23:11:03', '2019-02-08 23:11:03'),
(16, 1, 15, '2019-02-08 23:11:03', '2019-02-08 23:11:03'),
(17, 17, 1, '2019-02-08 23:17:48', '2019-02-08 23:17:48'),
(18, 1, 17, '2019-02-08 23:17:48', '2019-02-08 23:17:48'),
(23, 15, 17, '2019-02-08 23:29:31', '2019-02-08 23:29:31'),
(24, 17, 15, '2019-02-08 23:29:31', '2019-02-08 23:29:31'),
(25, 10, 15, '2019-02-08 23:32:45', '2019-02-08 23:32:45'),
(26, 15, 10, '2019-02-08 23:32:45', '2019-02-08 23:32:45'),
(27, 16, 10, '2019-02-08 23:33:36', '2019-02-08 23:33:36'),
(28, 10, 16, '2019-02-08 23:33:36', '2019-02-08 23:33:36'),
(29, 8, 16, '2019-02-08 23:34:36', '2019-02-08 23:34:36'),
(30, 16, 8, '2019-02-08 23:34:36', '2019-02-08 23:34:36'),
(31, 4, 1, '2019-02-08 23:35:31', '2019-02-08 23:35:31'),
(32, 1, 4, '2019-02-08 23:35:31', '2019-02-08 23:35:31'),
(33, 4, 8, '2019-02-08 23:36:00', '2019-02-08 23:36:00'),
(34, 8, 4, '2019-02-08 23:36:00', '2019-02-08 23:36:00'),
(35, 4, 3, '2019-02-08 23:37:19', '2019-02-08 23:37:19'),
(36, 3, 4, '2019-02-08 23:37:19', '2019-02-08 23:37:19'),
(37, 18, 1, '2019-02-08 23:39:43', '2019-02-08 23:39:43'),
(38, 1, 18, '2019-02-08 23:39:43', '2019-02-08 23:39:43'),
(39, 15, 18, '2019-02-08 23:44:37', '2019-02-08 23:44:37'),
(40, 18, 15, '2019-02-08 23:44:37', '2019-02-08 23:44:37'),
(41, 17, 8, '2019-02-08 23:47:43', '2019-02-08 23:47:43'),
(42, 8, 17, '2019-02-08 23:47:43', '2019-02-08 23:47:43'),
(43, 18, 17, '2019-02-09 00:11:54', '2019-02-09 00:11:54'),
(44, 17, 18, '2019-02-09 00:11:54', '2019-02-09 00:11:54'),
(45, 18, 4, '2019-02-09 01:49:39', '2019-02-09 01:49:39'),
(46, 4, 18, '2019-02-09 01:49:39', '2019-02-09 01:49:39');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_12_29_173626_create_posts_table', 1),
(4, '2018_12_29_175012_post', 2),
(5, '2018_12_29_175347_post', 3),
(6, '2018_12_29_175713_post', 4),
(7, '2018_12_29_175747_add_minutes_to_posts', 4),
(8, '2018_12_29_175920_add_minutes_to_posts', 5),
(9, '2018_12_29_180130_add_minutes_to_posts', 6),
(10, '2018_12_29_195908_make_fields_nullable', 7),
(11, '2018_12_30_012153_add_timezone_to_posts', 8),
(12, '2019_01_15_195628_create_user__preferences_table', 9),
(13, '2019_01_15_202119_create_preferences_table', 10),
(14, '2019_01_15_203156_make_preference_fields_nullable', 11),
(15, '2019_01_19_215010_add_username_to_users', 12),
(16, '2019_01_20_194006_rename_name_in_users', 13),
(17, '2019_01_20_194201_add_last_name_to_users', 14),
(18, '2019_01_20_195908_add_fullname_to_users', 15),
(19, '2019_01_21_170548_create_notifications_table', 16),
(20, '2019_01_21_171017_create_friendships_table', 16),
(21, '2019_01_21_171225_drop_offset_from_notifications', 17),
(22, '2019_02_04_203847_create_social_facebook_accounts_table', 18),
(23, '2019_02_06_150214_create_social_google_accounts_table', 19),
(24, '2019_02_07_152531_create_login_timestamps_table', 20),
(25, '2019_02_07_162832_drop_first_login_from_login_timestamps', 21),
(26, '2019_02_07_162937_add_login_count_to_login_timestamps', 22),
(27, '2019_02_07_163651_drop_login_timestamps', 23),
(28, '2019_02_07_164032_add_last_login_to_users', 24),
(29, '2019_02_07_170733_change_default_on_login_count', 25);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester` int(11) DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `requester`, `resolved`, `created_at`, `updated_at`) VALUES
(1, 1, 'friend request', 3, 1, '2019-01-21 22:29:41', '2019-01-23 01:02:47'),
(27, 1, 'friend request', 4, 1, '2019-01-22 02:03:57', '2019-01-23 01:02:01'),
(29, 5, 'friend request accepted', 1, 1, '2019-01-22 20:58:58', '2019-01-22 21:21:44'),
(30, 4, 'friend request declined', 1, 1, '2019-01-23 01:02:01', '2019-01-23 01:17:25'),
(31, 3, 'friend request declined', 1, 1, '2019-01-23 01:02:47', '2019-01-23 01:08:52'),
(32, 1, 'friend request', 3, 1, '2019-01-23 01:10:49', '2019-01-23 01:11:03'),
(33, 3, 'friend request declined', 1, 1, '2019-01-23 01:11:03', '2019-01-23 01:13:51'),
(34, 1, 'friend request', 3, 1, '2019-01-23 01:13:59', '2019-01-23 01:14:17'),
(35, 3, 'friend request declined', 1, 1, '2019-01-23 01:14:17', '2019-01-23 01:14:35'),
(36, 1, 'friend request', 3, 1, '2019-01-23 01:14:43', '2019-01-23 01:15:41'),
(37, 3, 'friend request accepted', 1, 1, '2019-01-23 01:15:00', '2019-01-23 01:16:03'),
(38, 3, 'friend request declined', 1, 1, '2019-01-23 01:15:41', '2019-01-23 01:16:02'),
(39, 4, 'friend request', 3, 1, '2019-01-23 01:17:12', '2019-02-08 23:37:19'),
(40, 4, 'friend request', 1, 1, '2019-02-08 22:39:19', '2019-02-08 23:35:31'),
(41, 8, 'friend request', 1, 1, '2019-02-08 22:41:50', '2019-02-08 22:42:08'),
(42, 1, 'friend request accepted', 8, 1, '2019-02-08 22:42:08', '2019-02-08 22:42:58'),
(43, 16, 'friend request', 1, 1, '2019-02-08 22:56:41', '2019-02-11 22:33:48'),
(44, 1, 'friend request accepted', 16, 1, '2019-02-08 22:56:48', '2019-02-08 23:10:32'),
(45, 15, 'friend request', 16, 1, '2019-02-08 23:07:12', '2019-02-08 23:07:26'),
(46, 16, 'friend request accepted', 15, 1, '2019-02-08 23:07:26', '2019-02-11 22:33:43'),
(47, 15, 'friend request', 1, 1, '2019-02-08 23:10:48', '2019-02-08 23:11:03'),
(48, 1, 'friend request accepted', 15, 1, '2019-02-08 23:11:03', '2019-02-09 03:13:54'),
(49, 17, 'friend request', 1, 1, '2019-02-08 23:17:43', '2019-02-08 23:19:23'),
(50, 1, 'friend request accepted', 17, 1, '2019-02-08 23:17:49', '2019-02-09 03:13:51'),
(51, 1, 'friend request accepted', 17, 1, '2019-02-08 23:17:58', '2019-02-09 03:13:48'),
(52, 1, 'friend request accepted', 17, 1, '2019-02-08 23:19:23', '2019-02-09 03:13:45'),
(53, 16, 'friend request', 17, 1, '2019-02-08 23:20:45', '2019-02-08 23:22:20'),
(54, 17, 'friend request declined', 16, 1, '2019-02-08 23:22:20', '2019-02-08 23:25:31'),
(55, 15, 'friend request', 17, 1, '2019-02-08 23:29:17', '2019-02-08 23:31:11'),
(56, 17, 'friend request accepted', 15, 1, '2019-02-08 23:29:31', '2019-02-08 23:47:38'),
(57, 17, 'friend request declined', 15, 1, '2019-02-08 23:31:11', '2019-02-08 23:47:40'),
(58, 10, 'friend request', 15, 1, '2019-02-08 23:32:31', '2019-02-08 23:32:45'),
(59, 15, 'friend request accepted', 10, 1, '2019-02-08 23:32:45', '2019-02-08 23:40:30'),
(60, 16, 'friend request', 10, 1, '2019-02-08 23:33:14', '2019-02-08 23:33:36'),
(61, 10, 'friend request accepted', 16, 0, '2019-02-08 23:33:36', '2019-02-08 23:33:36'),
(62, 8, 'friend request', 16, 1, '2019-02-08 23:34:23', '2019-02-08 23:34:36'),
(63, 16, 'friend request accepted', 8, 1, '2019-02-08 23:34:36', '2019-02-11 22:33:42'),
(64, 4, 'friend request', 8, 1, '2019-02-08 23:35:11', '2019-02-08 23:36:00'),
(65, 1, 'friend request accepted', 4, 1, '2019-02-08 23:35:31', '2019-02-09 03:13:35'),
(66, 8, 'friend request accepted', 4, 1, '2019-02-08 23:36:00', '2019-02-08 23:45:46'),
(67, 3, 'friend request accepted', 4, 1, '2019-02-08 23:37:19', '2019-02-09 01:47:43'),
(68, 18, 'friend request', 1, 1, '2019-02-08 23:39:36', '2019-02-08 23:39:43'),
(69, 1, 'friend request accepted', 18, 1, '2019-02-08 23:39:43', '2019-02-09 03:13:27'),
(70, 15, 'friend request', 18, 1, '2019-02-08 23:40:15', '2019-02-08 23:44:37'),
(71, 18, 'friend request accepted', 15, 1, '2019-02-08 23:44:37', '2019-02-09 01:49:42'),
(72, 8, 'friend request', 15, 1, '2019-02-08 23:45:32', '2019-02-08 23:46:27'),
(73, 15, 'friend request declined', 8, 1, '2019-02-08 23:46:27', '2019-02-09 03:50:48'),
(74, 17, 'friend request', 8, 1, '2019-02-08 23:47:21', '2019-02-08 23:47:43'),
(75, 8, 'friend request accepted', 17, 1, '2019-02-08 23:47:43', '2019-02-11 22:34:33'),
(76, 18, 'friend request', 17, 1, '2019-02-08 23:52:26', '2019-02-09 00:11:54'),
(77, 17, 'friend request accepted', 18, 1, '2019-02-09 00:11:54', '2019-02-11 22:31:43'),
(78, 18, 'friend request', 4, 1, '2019-02-09 01:47:22', '2019-02-09 01:49:39'),
(79, 18, 'friend request', 3, 1, '2019-02-09 01:48:12', '2019-02-09 01:49:33'),
(80, 3, 'friend request declined', 18, 0, '2019-02-09 01:49:33', '2019-02-09 01:49:33'),
(81, 4, 'friend request accepted', 18, 0, '2019-02-09 01:49:39', '2019-02-09 01:49:39'),
(82, 1, 'friend request declined', 16, 1, '2019-02-11 22:33:48', '2019-02-12 21:22:24'),
(83, 16, 'friend request', 18, 1, '2019-02-13 21:32:50', '2019-02-13 21:34:26'),
(84, 18, 'friend request declined', 16, 0, '2019-02-13 21:34:26', '2019-02-13 21:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `minutes` int(11) NOT NULL,
  `shared` tinyint(1) DEFAULT 1,
  `offset` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `entry`, `audio`, `created_at`, `updated_at`, `minutes`, `shared`, `offset`) VALUES
(75, '15', NULL, '/storage/7511022019172041.wav', '2019-02-11 22:20:32', '2019-02-11 22:20:42', 1, 1, 300),
(76, '1', NULL, NULL, '2019-02-11 22:37:04', '2019-02-11 22:37:04', 20, 1, 300),
(77, '15', '<p>This is a test.</p>', '/storage/7712022019162202.wav', '2019-02-12 21:21:46', '2019-02-12 21:22:03', 1, 0, 300),
(78, '1', NULL, NULL, '2019-02-13 22:17:45', '2019-02-13 22:17:45', 20, 1, 300),
(79, '16', NULL, NULL, '2019-02-13 22:22:42', '2019-02-13 22:22:42', 1, 1, 300),
(80, '16', NULL, NULL, '2019-02-13 22:24:47', '2019-02-13 22:24:47', 1, 1, 300),
(81, '16', NULL, NULL, '2019-02-13 22:27:05', '2019-02-13 22:27:05', 1, 1, 300),
(82, '16', NULL, NULL, '2019-02-13 22:28:54', '2019-02-13 22:28:54', 1, 1, 300),
(83, '16', NULL, NULL, '2019-02-13 22:32:50', '2019-02-13 22:32:50', 1, 1, 300),
(84, '16', NULL, NULL, '2019-02-13 22:32:50', '2019-02-13 22:32:50', 1, 1, 300),
(85, '16', NULL, NULL, '2019-02-13 22:51:25', '2019-02-13 22:51:25', 1, 1, 300),
(86, '1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, '2019-02-12 23:32:37', '2019-02-14 00:04:06', 20, 1, 300),
(91, '1', NULL, NULL, '2019-02-15 00:10:59', '2019-02-19 00:10:59', 20, 1, 300),
(92, '1', NULL, NULL, '2019-02-15 21:12:13', '2019-02-19 00:12:13', 20, 1, 300),
(93, '1', NULL, NULL, '2019-02-16 18:15:05', '2019-02-19 00:15:05', 30, 1, 300),
(94, '1', 'I had to meditate on the train today, which is really not ideal. The ambient noise makes it very easy for the mind to wander. Furthermore, I overslept and so didn\'t have time to sit first thing in the morning. Still, I\'m glad I made the time to sit.', NULL, '2019-02-18 00:19:16', '2019-02-19 00:19:16', 30, 1, 300),
(95, '1', NULL, '/storage/9518022019194319.wav', '2019-02-18 20:39:16', '2019-02-19 00:43:20', 22, 1, 300),
(96, '1', NULL, NULL, '2019-02-19 00:21:24', '2019-02-19 00:21:24', 1, 1, 300);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `preferred_time` int(11) DEFAULT NULL,
  `lower` int(11) DEFAULT NULL,
  `upper` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `user_id`, `preferred_time`, `lower`, `upper`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 15, 30, '2019-01-16 01:45:49', '2019-02-19 00:19:30'),
(2, 4, 1, NULL, NULL, '2019-01-23 01:21:46', '2019-01-23 01:29:56'),
(3, 15, 1, NULL, NULL, '2019-02-09 02:16:31', '2019-02-12 21:20:31'),
(4, 8, 2, NULL, NULL, '2019-02-11 22:34:43', '2019-02-11 22:34:43'),
(5, 16, 1, 15, 30, '2019-02-13 22:08:56', '2019-02-13 22:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `social_facebook_accounts`
--

CREATE TABLE `social_facebook_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_facebook_accounts`
--

INSERT INTO `social_facebook_accounts` (`user_id`, `provider_user_id`, `provider`, `created_at`, `updated_at`) VALUES
(14, '299047054296431', 'facebook', '2019-02-08 22:42:32', '2019-02-08 22:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `social_google_accounts`
--

CREATE TABLE `social_google_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_google_accounts`
--

INSERT INTO `social_google_accounts` (`user_id`, `provider_user_id`, `provider`, `created_at`, `updated_at`) VALUES
(1, '116203552377397348373', 'google', '2019-02-08 02:41:59', '2019-02-08 02:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '2019-02-07 21:44:00',
  `login_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `last_name`, `full_name`, `last_login`, `login_count`) VALUES
(1, 'Erin', 'e.e.moir@gmail.com', NULL, '71a5c0514ab83382d98154e5a5f9d813', 'P4v4GZrEH7sevBZYpVRBuyappQYwQiTHlKUQ5jRkn52M1T0L7GvPw1eCnIxo', '2019-02-08 02:41:59', '2019-02-19 00:09:30', 'Erin', 'Moir', 'Erin Moir', '2019-02-19 00:09:30', 19),
(3, 'Squeezle', 'fakeemail@columbia.edu', NULL, '$2y$10$Lgi8QScLjyDqgCvDj09SPOc0iKKN8e1KumgqVtfdmqFN8sNLgJROm', 'nd80Uh7t0SlJF2A4JKG3vEdtWyqdJZB03xHmnQtbez3FchNmfmiAKJN22C9L', '2019-01-21 00:52:53', '2019-02-09 01:47:38', 'squeezlepie', 'Pie', 'Squeezle Pie', '2019-02-09 01:47:38', 2),
(4, 'Chicory', 'fakeemail@fakeemail.com', NULL, '$2y$10$a6AtPhg5dZXaynW/pXdY7eGJ19/g2Yn9X5p/zDImmhV5BmT41ZekC', 'AbAP8NfMOta3RijLeAUtllR1VdWwdsfclYqrFfKreheYbdDiYCy7QwUkiG83', '2019-01-21 01:05:00', '2019-02-09 01:47:13', 'cdizzle', 'Dove', 'Chicory Dove', '2019-02-09 01:47:13', 3),
(5, 'Erin', 'fakeremail@fakeremail.com', NULL, '$2y$10$.7m0Hti1pBXOrDPrvQBfReGb4M/zurAMIuNrppXzWVHi49XYSuTYS', 'o6D8ApoKe71Z3vWlfOBWF5iiTgKcHkO7xI64nuvYVAQ6lywjU0TOBbX1kf0Q', '2019-01-21 21:12:54', '2019-01-21 21:12:54', 'Erin2', 'Moir', 'Erin Moir', '2019-02-07 21:44:00', 1),
(8, 'Hector', 'hector@hector.com', NULL, '$2y$10$iSjxgixYnbeu6arRe4LdpeCmzKyiSQKBWyeNjSVZRVESzSI0rsvNS', '7ARVLoRaPTslEIX6AU56SMBcrqXbCHWWmYOlU7dL0RpCVrac5YAPGREWAias', '2019-02-07 22:06:15', '2019-02-12 01:11:35', 'hectoire', 'Weisenfeld', 'Hector Weisenfeld', '2019-02-12 01:11:35', 8),
(9, 'Andromache', 'kiki@hector.com', NULL, '$2y$10$l6aXiFz/2S8anQLkduzKjOxgBu71pT6MO6fzWTv4BmMLsTHJTuudq', 'FpHjsbqhQY1yNk9zoXMNGNspOuDSV3PxouAYnySWhJtsWWxxiE2amBT6CQ1P', '2019-02-07 22:08:22', '2019-02-07 22:08:22', 'Kiki', 'Weisenfeld', 'Andromache Weisenfeld', '2019-02-07 22:08:22', 2),
(10, 'Momo', 'momo@hector.com', NULL, '$2y$10$Q60QvLy21dv9R1OjsLGyuu9p0PhB9lCe/Im.h6.y2wf8ctqPAH8pe', 'LgqbZfJs0VOszHcJlfZwWQrlS4nonjyFJkw80sPiEEUmz8b7gnc1lL5p886Y', '2019-02-07 22:09:26', '2019-02-08 23:32:40', 'Momes2', 'Moir', 'Momo Moir', '2019-02-08 23:32:40', 2),
(14, 'Erin', 'eem2164@columbia.edu', NULL, '33686c2d8930be81c843ffb7d4312605', '8MKOS3JusTutjZ9iN7RXcEaMNleFfiudneQFJRcUp0YkG3dvC92AcXcNHriR', '2019-02-08 22:42:32', '2019-02-08 22:42:32', 'erin3787', 'Moir', 'Erin Moir', '2019-02-08 22:42:32', 1),
(15, 'Susan', 'ivanova@babylon5.org', NULL, '$2y$10$2qMIM7kpLURSEzB7NDOzLO1kSzmyoS5d1EFeFO.cCULN/Ej97dxbm', 'N6CcGgHeLrhpJvvW5GDWiRbA14F23TgfRpHeTqCxs8YW1koHiLFwKVnwjhs1', '2019-02-08 22:54:41', '2019-02-14 02:22:33', 'Susan', 'Ivanova', 'Susan Ivanova', '2019-02-14 02:22:33', 14),
(16, 'G\'kar', 'gkar@babylon5.org', NULL, '$2y$10$vLawKhWzdUG/3Pnc7eZgU.H22GFWiAJrcKeVq0yEqH53VvTE3IZqu', 'rd2Gaf5H5kRD8nOGZuEB1lcPyXIi9pisH9e2SyS54XeKMyzSLZQbS4obXT4a', '2019-02-08 22:56:41', '2019-02-13 21:33:03', 'Gkar', 'G\'karson', 'G\'kar G\'karson', '2019-02-13 21:33:03', 7),
(17, 'Londo', 'mollari@babylon5.org', NULL, '$2y$10$ifP/5h5nvZav2njPUQEVZ.abIIV50/KNrl.p8eSLORVN6eN2Fbr7a', '3Bvk2sXBhXUNFBaN3v6JMgeM73r9zvWRlvr3ToX9LQcV4Fp2mJuvHhV8B2CV', '2019-02-08 23:17:43', '2019-02-11 22:31:38', 'Londo', 'Mollari', 'Londo Mollari', '2019-02-11 22:31:38', 5),
(18, 'Michael', 'garibaldi@babylon5.org', NULL, '$2y$10$J.NOTO6TKzhYb8bmuKDFqOeG8U2Ze.0YAY9vZ2r3f7kJphJSdsHnS', '05WodJpzgOIn3X8ksqarVgJtMlP30RbB7xqn6Lsegg9D0qZu4ffdoerPix0s', '2019-02-08 23:39:36', '2019-02-13 21:26:50', 'garibaldi', 'Garibaldi', 'Michael Garibaldi', '2019-02-13 21:26:50', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
