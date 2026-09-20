-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2025 at 07:33 AM
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
-- Database: `dt_radio_clean`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artist`
--

CREATE TABLE `tbl_artist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ads_premium`
--

CREATE TABLE `tbl_ads_premium` (
  `id` int(11) NOT NULL,
  `crea_name` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '	1- Song, 2- Podcast	',
  `content_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1-song,2-Podcast Episode',
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_episode`
--

CREATE TABLE `tbl_episode` (
  `id` int(11) NOT NULL,
  `podcasts_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `portrait_img` varchar(255) NOT NULL,
  `landscape_img` varchar(255) NOT NULL,
  `episode_upload_type` varchar(255) NOT NULL COMMENT 'server_video, external_url, youtube',
  `episode_audio` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `total_play` int(11) NOT NULL DEFAULT 0,
  `sortable` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_join_user`
--

CREATE TABLE `tbl_event_join_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `live_event_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1- Paid,0- Free	',
  `transaction_id` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorite`
--

CREATE TABLE `tbl_favorite` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1- Song, 2- Podcast',
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_setting`
--

CREATE TABLE `tbl_general_setting` (
  `id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `tbl_general_setting`
--

INSERT INTO `tbl_general_setting` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'DTRadio', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(2, 'host_email', 'support@divinetechs.com', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(3, 'app_version', '1.6', '2022-08-03 12:38:42', '2025-05-22 05:31:40'),
(4, 'author', 'Divinetechs', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(5, 'email', 'support@divinetechs.com', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(6, 'contact', '917984859403', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(7, 'app_desripation', 'DivineTechs, a top web & mobile app development company offering innovative solutions for diverse industry verticals. We have creative and dedicated group of developers who are mastered in Apps Developments and Web Development with a nice in delivering quality solutions to customers across the globe.', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(11, 'app_logo', '', '2022-08-03 12:38:42', '2025-05-22 05:31:45'),
(12, 'website', 'https://www.divinetechs.com/', '2022-08-03 12:38:42', '2024-08-20 04:55:10'),
(13, 'currency', 'usd', '2022-08-03 12:38:42', '2024-08-23 00:40:40'),
(14, 'currency_code', '$', '2022-08-03 12:38:42', '2024-08-20 04:55:29'),
(25, 'banner_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:31:47'),
(26, 'banner_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:31:48'),
(27, 'interstital_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:32:18'),
(28, 'interstital_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:32:15'),
(29, 'interstital_adclick', '', '2022-08-03 12:38:42', '2025-05-22 05:32:14'),
(30, 'reward_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:32:13'),
(31, 'reward_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:32:12'),
(32, 'reward_adclick', '', '2022-08-03 12:38:42', '2025-05-22 05:32:10'),
(33, 'ios_banner_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:32:09'),
(34, 'ios_banner_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:32:07'),
(35, 'ios_interstital_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:32:06'),
(36, 'ios_interstital_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:32:05'),
(37, 'ios_interstital_adclick', '', '2022-08-03 12:38:42', '2025-05-22 05:32:03'),
(38, 'ios_reward_ad', '0', '2022-08-03 12:38:42', '2025-05-22 05:32:02'),
(39, 'ios_reward_adid', '', '2022-08-03 12:38:42', '2025-05-22 05:32:01'),
(40, 'ios_reward_adclick', '', '2022-08-03 12:38:42', '2025-05-22 05:31:59'),
(41, 'fb_native_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(42, 'fb_native_id', '', '2022-08-03 12:38:42', '2023-04-15 11:23:54'),
(43, 'fb_banner_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(44, 'fb_banner_id', '', '2022-08-03 12:38:42', '2023-04-15 11:23:56'),
(45, 'fb_interstiatial_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(46, 'fb_interstiatial_id', '', '2022-08-03 12:38:42', '2024-03-01 05:00:28'),
(47, 'fb_rewardvideo_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(48, 'fb_rewardvideo_id', '', '2022-08-03 12:38:42', '2023-04-15 11:24:00'),
(49, 'fb_native_full_status', '1', '2022-08-03 12:38:42', '2024-03-01 04:51:29'),
(50, 'fb_native_full_id', '', '2022-08-03 12:38:42', '2024-03-01 04:53:21'),
(51, 'fb_ios_native_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(52, 'fb_ios_native_id', '', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(53, 'fb_ios_banner_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(54, 'fb_ios_banner_id', '', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(55, 'fb_ios_interstiatial_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(56, 'fb_ios_interstiatial_id', '', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(57, 'fb_ios_rewardvideo_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(58, 'fb_ios_rewardvideo_id', '', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(59, 'fb_ios_native_full_status', '0', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(60, 'fb_ios_native_full_id', '', '2022-08-03 12:38:42', '2022-11-23 10:42:53'),
(61, 'onesignal_apid', '', '2022-08-03 12:38:42', '2024-08-21 05:56:03'),
(62, 'onesignal_rest_key', '', '2022-08-03 12:38:42', '2024-08-21 05:56:03'),
(72, 'fb_interstital_adclick', '', '2024-02-29 05:09:15', '2024-03-01 10:33:31'),
(73, 'fb_reward_adclick', '', '2024-02-29 05:09:28', '2024-03-01 05:00:20'),
(74, 'fb_ios_interstital_adclick', '', '2024-02-29 05:09:38', '2024-03-01 05:15:19'),
(75, 'fb_ios_reward_adclick', '', '2024-02-29 05:09:48', '2024-03-01 05:15:19'),
(76, 'page_background_color', '#f7b5b5', '2024-08-21 11:48:53', '2024-08-21 06:59:24'),
(77, 'page_title_color', '#1c68ba', '2024-08-21 11:48:53', '2024-08-21 07:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_live_event`
--

CREATE TABLE `tbl_live_event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `portrait_img` varchar(255) NOT NULL,
  `landscape_img` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `is_paid` int(11) NOT NULL COMMENT '1-Paid,0-Free',
  `price` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1- Audio, 2- Video',
  `is_vod` int(11) NOT NULL DEFAULT 0 COMMENT '0-Live event, 1-Video on demand',
  `category_id` int(11) DEFAULT NULL COMMENT 'tbl_video_category.id (video on demand only)',
  `video_source` int(11) NOT NULL DEFAULT 1 COMMENT '1-External link, 2-Uploaded file (link holds the file name)',
  `link` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Open, 0-Close',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_onboarding_screen`
--

CREATE TABLE `tbl_onboarding_screen` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `android_product_package` varchar(255) NOT NULL,
  `ios_product_package` varchar(255) NOT NULL,
  `web_product_package` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `page_name`, `title`, `description`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 'About Us', '<h1 style=\"margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; font-size: 36px;\"><font style=\"\" color=\"#0000ff\">Privacy Policy for DivineTechs</font></h1><h1 style=\"margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 36px;\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">At www.divinetechs.com, accessible from https://www.divinetechs.com/, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by www.divinetechs.com and how we use it.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in www.divinetechs.com. This policy is not applicable to any information collected offline or via channels other than this website. Our Privacy Policy was created with the help of the&nbsp;<a href=\"https://www.privacypolicygenerator.info/\" style=\"color: rgb(51, 51, 51);\">Free Privacy Policy Generator</a>.</p></h1><h2 style=\"margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 30px;\">Consent</h2><h1 style=\"margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 36px;\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p><div><br></div></h1>', 'pages_20_08_2024_2051.png', 1, '2022-01-24 17:28:26', '2024-08-21 07:02:01'),
(2, 'privacy-policy', 'Privacy Policy', '<h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; \"><font color=\"#efc631\">Privacy Policy for DivineTechs</font></h1><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">At www.divinetechs.com, accessible from https://www.divinetechs.com/, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by www.divinetechs.com and how we use it.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in www.divinetechs.com. This policy is not applicable to any information collected offline or via channels other than this website. Our Privacy Policy was created with the help of the&nbsp;<a href=\"https://www.privacypolicygenerator.info/\" style=\"color: rgb(51, 51, 51);\">Free Privacy Policy Generator</a>.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">Consent</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">Information we collect</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">How we use your information</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">We use the information we collect in various ways, including to:</p><ul style=\"margin-bottom: 10px; font-size: 16px;\"><li>Provide, operate, and maintain our website</li><li>Improve, personalize, and expand our website</li><li>Understand and analyze how you use our website</li><li>Develop new products, services, features, and functionality</li><li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li><li>Send you emails</li><li>Find and prevent fraud</li></ul></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; b\">Log Files</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">Advertising Partners Privacy Policies</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">You may consult this list to find the Privacy Policy for each of the advertising partners of www.divinetechs.com.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on www.divinetechs.com, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Note that www.divinetechs.com has no access to or control over these cookies that are used by third-party advertisers.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">Third Party Privacy Policies</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">CCPA Privacy Rights (Do Not Sell My Personal Information)</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Under the CCPA, among other rights, California consumers have the right to:</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business delete any personal data about the consumer that a business has collected.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">GDPR Data Protection Rights</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; \">Children\'s Information</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); \"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p></h1>', '20_03_2024_9_65faeae628f7d.png', 1, '2022-01-24 17:28:26', '2024-08-21 12:24:38'),
(3, 'terms-and-conditions', 'Terms & Conditions', '<div><span style=\"font-size: 28px;\">Terms and Conditions for DivineTechs</span></div><div>At www.divinetechs.com, accessible from https://www.divinetechs.com/, one of our main priorities is the privacy of our visitors. This Terms and Conditions document contains types of information that is collected and recorded by www.divinetechs.com and how we use it.</div><div><br></div><div>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</div><div><br></div><div>This Terms and Conditions applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in www.divinetechs.com. This policy is not applicable to any information collected offline or via channels other than this website.</div><div><br></div><div>Consent</div><div>By using our website, you hereby consent to our Terms and Conditions and agree to its terms.</div><div><br></div><div>Information we collect</div><div>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</div><div><br></div><div>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</div><div><br></div><div>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</div><div><br></div><div>How we use your information</div><div>We use the information we collect in various ways, including to:</div><div><br></div><div>Provide, operate, and maintain our website</div><div>Improve, personalize, and expand our website</div><div>Understand and analyze how you use our website</div><div>Develop new products, services, features, and functionality</div><div>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</div><div>Send you emails</div><div>Find and prevent fraud</div><div>Log Files</div><div>www.divinetechs.com follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</div><div><br></div><div>Advertising Partners Privacy Policies</div><div>You may consult this list to find the Privacy Policy for each of the advertising partners of www.divinetechs.com.</div><div><br></div><div>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on www.divinetechs.com, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</div><div><br></div><div>Note that www.divinetechs.com has no access to or control over these cookies that are used by third-party advertisers.</div><div><br></div><div>Third Party Privacy Policies</div><div>www.divinetechs.com\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</div><div><br></div><div>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</div><div><br></div><div>CCPA Privacy Rights (Do Not Sell My Personal Information)</div><div>Under the CCPA, among other rights, California consumers have the right to:</div><div><br></div><div>Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</div><div><br></div><div>Request that a business delete any personal data about the consumer that a business has collected.</div><div><br></div><div>Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</div><div><br></div><div>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</div><div><br></div><div>GDPR Data Protection Rights</div><div>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</div><div><br></div><div>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</div><div><br></div><div>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</div><div><br></div><div>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</div><div><br></div><div>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</div><div><br></div><div>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</div><div><br></div><div>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</div><div><br></div><div>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</div><div><br></div><div>Children\'s Information</div><div>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</div><div><br></div><div>www.divinetechs.com does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our&nbsp;</div>', '20_03_2024_42_65faeaefeb47e.png', 1, '2022-01-24 17:28:37', '2024-08-21 06:56:05'),
(4, 'refund-policy', 'Refund Policy', '<h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\">Refund Policy for DivineTechs</h1><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">At www.divinetechs.com, accessible from https://www.divinetechs.com/, one of our main priorities is the privacy of our visitors. This Refund Policy document contains types of information that is collected and recorded by www.divinetechs.com and how we use it.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you have additional questions or require more information about our Refund Policy, do not hesitate to contact us.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">This Refund Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in www.divinetechs.com. This policy is not applicable to any information collected offline or via channels other than this website. Our Refund Policy was created with the help of the&nbsp;<a href=\"https://www.privacypolicygenerator.info/\" style=\"color: rgb(51, 51, 51);\">Free Refund Policy Generator</a>.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Consent</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">By using our website, you hereby consent to our Refund Policy and agree to its terms.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Information we collect</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">How we use your information</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">We use the information we collect in various ways, including to:</p><ul style=\"margin-bottom: 10px; font-size: 16px;\"><li>Provide, operate, and maintain our website</li><li>Improve, personalize, and expand our website</li><li>Understand and analyze how you use our website</li><li>Develop new products, services, features, and functionality</li><li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li><li>Send you emails</li><li>Find and prevent fraud</li></ul></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Log Files</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Advertising Partners Privacy Policies</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">You may consult this list to find the Refund Policy for each of the advertising partners of www.divinetechs.com.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on www.divinetechs.com, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Note that www.divinetechs.com has no access to or control over these cookies that are used by third-party advertisers.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Third Party Privacy Policies</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com\'s Refund Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">CCPA Privacy Rights (Do Not Sell My Personal Information)</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Under the CCPA, among other rights, California consumers have the right to:</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business delete any personal data about the consumer that a business has collected.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">GDPR Data Protection Rights</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p></h1><h2 style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-size: 30px; background-color: rgb(246, 246, 246);\">Children\'s Information</h2><h1 style=\"font-size: 36px; margin-right: 0px; margin-bottom: 18px; margin-left: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); background-color: rgb(246, 246, 246);\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-size: 16px;\">www.divinetechs.com does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p></h1>', '20_03_2024_89_65faeaf78cd33.png', 1, '2023-04-15 11:01:19', '2024-03-20 13:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_option`
--

CREATE TABLE `tbl_payment_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `visibility` varchar(255) NOT NULL,
  `is_live` varchar(255) NOT NULL,
  `key_1` varchar(255) NOT NULL,
  `key_2` varchar(255) NOT NULL,
  `key_3` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment_option`
--

INSERT INTO `tbl_payment_option` (`id`, `name`, `visibility`, `is_live`, `key_1`, `key_2`, `key_3`, `created_at`, `updated_at`) VALUES
(1, 'inapppurchage', '0', '0', '', '', '', '2023-01-27 10:19:52', '2024-08-23 00:44:12'),
(2, 'paypal', '0', '0', '', '', '', '2023-01-27 10:19:52', '2024-08-23 00:46:30'),
(3, 'razorpay', '0', '0', '', '', '', '2023-01-27 10:19:52', '2025-05-22 05:32:28'),
(4, 'flutterwave', '0', '0', '', '', '', '2023-01-27 10:19:52', '2024-08-23 00:46:00'),
(5, 'payumoney', '0', '0', '', '', '', '2023-01-27 10:19:52', '2024-08-23 00:45:54'),
(6, 'paytm', '0', '0', '', '', '', '2023-01-27 10:19:52', '2024-08-23 00:45:44'),
(7, 'stripe', '0', '0', '', '', '', '2023-06-17 08:32:13', '2024-08-23 00:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_play`
--

CREATE TABLE `tbl_play` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1-Song, 2-Podcast',
  `content_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_podcast`
--

CREATE TABLE `tbl_podcast` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `portrait_img` varchar(255) NOT NULL,
  `landscape_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_premium` int(11) NOT NULL DEFAULT 0,
  `total_play` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_podcast_section`
--

CREATE TABLE `tbl_podcast_section` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `language_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `screen_layout` varchar(255) NOT NULL,
  `is_premium` int(11) NOT NULL COMMENT '0-No,1-Yes',
  `order_by_upload` int(11) NOT NULL COMMENT '0-asc, 1-desc',
  `order_by_play` int(11) NOT NULL COMMENT '0-asc,1-desc',
  `no_of_content` int(11) NOT NULL,
  `view_all` int(11) NOT NULL DEFAULT 0 COMMENT '0-No,1-Yes',
  `sortable` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0-Hide, 1-Show',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1-Song, 2-Podcast, 3-Live event, 4-Artist, 5-Category, 6-\r\nLanguage, 7-City',
  `artist_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `language_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `city_id` int(11) NOT NULL DEFAULT 0 COMMENT '0-All',
  `screen_layout` varchar(255) NOT NULL,
  `is_premium` int(11) NOT NULL DEFAULT 0 COMMENT '1-Yes,0-No',
  `order_by_upload` int(11) NOT NULL DEFAULT 1 COMMENT '1-Desc,0-Asc',
  `order_by_play` int(11) NOT NULL DEFAULT 1 COMMENT '1-Desc,0-Asc',
  `is_paid` int(11) NOT NULL DEFAULT 0 COMMENT '1-Yes,0-No',
  `no_of_content` int(11) NOT NULL,
  `view_all` int(11) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `sortable` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Show, 0-Hide',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_setting`
--

CREATE TABLE `tbl_smtp_setting` (
  `id` int(11) NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_smtp_setting`
--

INSERT INTO `tbl_smtp_setting` (`id`, `protocol`, `host`, `port`, `user`, `pass`, `from_name`, `from_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'smtp123', 'smtp.gmail.com', '587', 'admin@admin.com', 'admin', 'DTRadio-Divintechs', 'admin@admin.com', 0, '2022-08-03 10:14:04', '2025-05-22 05:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_link`
--

CREATE TABLE `tbl_social_link` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_song`
--

CREATE TABLE `tbl_song` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `song_upload_type` varchar(255) NOT NULL COMMENT '	server_video, external_url	',
  `song_url` text NOT NULL,
  `is_premium` int(11) NOT NULL DEFAULT 0,
  `total_play` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `mobile_number` varchar(25) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = OTP, 2 = Goggle, 3 = Apple, 4 = Normal	',
  `device_type` int(11) NOT NULL DEFAULT 0 COMMENT '1-Android, 2-ios',
  `device_token` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_category`
--

CREATE TABLE `tbl_video_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_notification_tracking`
--

CREATE TABLE `tbl_user_notification_tracking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ads_premium`
--
ALTER TABLE `tbl_ads_premium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_episode`
--
ALTER TABLE `tbl_episode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event_join_user`
--
ALTER TABLE `tbl_event_join_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_live_event`
--
ALTER TABLE `tbl_live_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_onboarding_screen`
--
ALTER TABLE `tbl_onboarding_screen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_package`
--
ALTER TABLE `tbl_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_option`
--
ALTER TABLE `tbl_payment_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_play`
--
ALTER TABLE `tbl_play`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_podcast`
--
ALTER TABLE `tbl_podcast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_podcast_section`
--
ALTER TABLE `tbl_podcast_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_setting`
--
ALTER TABLE `tbl_smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social_link`
--
ALTER TABLE `tbl_social_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_song`
--
ALTER TABLE `tbl_song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_notification_tracking`
--
ALTER TABLE `tbl_user_notification_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video_category`
--
ALTER TABLE `tbl_video_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ads_premium`
--
ALTER TABLE `tbl_ads_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_episode`
--
ALTER TABLE `tbl_episode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_event_join_user`
--
ALTER TABLE `tbl_event_join_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_live_event`
--
ALTER TABLE `tbl_live_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_onboarding_screen`
--
ALTER TABLE `tbl_onboarding_screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_package`
--
ALTER TABLE `tbl_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_payment_option`
--
ALTER TABLE `tbl_payment_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_play`
--
ALTER TABLE `tbl_play`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_podcast`
--
ALTER TABLE `tbl_podcast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_podcast_section`
--
ALTER TABLE `tbl_podcast_section`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_smtp_setting`
--
ALTER TABLE `tbl_smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_social_link`
--
ALTER TABLE `tbl_social_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_song`
--
ALTER TABLE `tbl_song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_notification_tracking`
--
ALTER TABLE `tbl_user_notification_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_video_category`
--
ALTER TABLE `tbl_video_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
