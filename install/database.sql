-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 16, 2025 at 03:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OvoSale`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'admin@site.com', 'admin', NULL, '67b6fbf40771d1740045300.png', '$2y$12$ecxM9ta/Mu9RTovy4/xAKebotQbkFcTwDEriRGnf3bwwJ2YBn//Ai', NULL, 1, '2024-09-01 11:37:12', '2025-02-20 03:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activities`
--

CREATE TABLE `admin_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci,
  `model_name` text COLLATE utf8mb4_unicode_ci,
  `model_id` int UNSIGNED NOT NULL DEFAULT '0',
  `ip_address` text COLLATE utf8mb4_unicode_ci,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `user_browser` text COLLATE utf8mb4_unicode_ci,
  `is_api` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=no,1=yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_activities`
--

INSERT INTO `admin_activities` (`id`, `admin_id`, `remark`, `activity`, `model_name`, `model_id`, `ip_address`, `user_agent`, `user_browser`, `is_api`, `created_at`, `updated_at`) VALUES
(1, 1, 'extension-status-change', 'The extension status change successfully', 'App\\Models\\Extension', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Chrome', 0, '2025-08-16 14:56:12', '2025-08-16 14:56:12'),
(2, 1, 'extension-updated', 'The extension updated successfully', 'App\\Models\\Extension', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Chrome', 0, '2025-08-16 14:56:18', '2025-08-16 14:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `employee_id` int UNSIGNED NOT NULL DEFAULT '0',
  `shift_id` int NOT NULL DEFAULT '0',
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_details_id` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity` int NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive\r\n',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_from` date DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `minimum_amount` decimal(28,0) NOT NULL DEFAULT '0',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=percent, 2=fixed',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `maximum_using_time` int NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `department_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `department_id` int UNSIGNED NOT NULL DEFAULT '0',
  `designation_id` int UNSIGNED NOT NULL DEFAULT '0',
  `shift_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_type_id` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_account_id` int UNSIGNED NOT NULL DEFAULT '0',
  `added_by` int UNSIGNED NOT NULL DEFAULT '0',
  `expense_date` date DEFAULT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `info` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci,
  `shortcode` text COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `info`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'Google reCAPTCHA v2 blocks bots, reducing spam and enhancing website security', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"--------------------\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2025-08-16 14:56:18'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'Custom Captcha checks users with simple challenges, stopping spam and keeping your site safe', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2024-12-29 01:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci,
  `firebase_config` text COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `in_app_payment` tinyint(1) NOT NULL DEFAULT '1',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socialite_credentials` text COLLATE utf8mb4_unicode_ci,
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `time_format` text COLLATE utf8mb4_unicode_ci,
  `date_format` text COLLATE utf8mb4_unicode_ci,
  `allow_precision` int NOT NULL DEFAULT '2',
  `thousand_separator` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix_setting` text COLLATE utf8mb4_unicode_ci,
  `company_information` text COLLATE utf8mb4_unicode_ci,
  `next_cron_run_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `in_app_payment`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `socialite_credentials`, `last_cron`, `available_version`, `system_customized`, `paginate_number`, `currency_format`, `time_format`, `date_format`, `allow_precision`, `thousand_separator`, `prefix_setting`, `company_information`, `next_cron_run_at`, `created_at`, `updated_at`) VALUES
(1, 'OvoSale', 'USD', '$', 'info@ovosolution.com', '{{site_name}}', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Email Notification</title>\r\n    <style>\r\n        /* General Styles */\r\n        body {\r\n            margin: 0;\r\n            padding: 0;\r\n            font-family: \'Open Sans\', Arial, sans-serif;\r\n            background-color: #f4f4f4;\r\n            -webkit-text-size-adjust: 100%;\r\n            -ms-text-size-adjust: 100%;\r\n        }\r\n\r\n        table {\r\n            border-spacing: 0;\r\n            border-collapse: collapse;\r\n            width: 100%;\r\n        }\r\n\r\n        img {\r\n            display: block;\r\n            border: 0;\r\n            line-height: 0;\r\n        }\r\n\r\n        a {\r\n            color: #ff600036;\r\n            text-decoration: none;\r\n        }\r\n\r\n        .email-wrapper {\r\n            width: 100%;\r\n            background-color: #f4f4f4;\r\n            padding: 30px 0;\r\n        }\r\n\r\n        .email-container {\r\n            width: 100%;\r\n            max-width: 600px;\r\n            margin: 0 auto;\r\n            background-color: #ffffff;\r\n            border-radius: 8px;\r\n            overflow: hidden;\r\n            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);\r\n        }\r\n\r\n        /* Header */\r\n        .email-header {\r\n            background-color: #ff600036;\r\n            color: #000;\r\n            text-align: center;\r\n            padding: 20px;\r\n            font-size: 16px;\r\n            font-weight: 600;\r\n        }\r\n\r\n        /* Logo */\r\n        .email-logo {\r\n            text-align: center;\r\n            padding: 40px 0;\r\n        }\r\n\r\n        .email-logo img {\r\n            max-width: 180px;\r\n            margin: 0 auto;\r\n        }\r\n\r\n        /* Content */\r\n        .email-content {\r\n            padding: 0 30px 30px 30px;\r\n            text-align: left;\r\n        }\r\n\r\n        .email-content h1 {\r\n            font-size: 22px;\r\n            color: #414a51;\r\n            font-weight: bold;\r\n            margin-bottom: 10px;\r\n        }\r\n\r\n        .email-content p {\r\n            font-size: 16px;\r\n            color: #7f8c8d;\r\n            line-height: 1.6;\r\n            margin: 20px 0;\r\n        }\r\n\r\n        .email-divider {\r\n            margin: 20px auto;\r\n            width: 60px;\r\n            border-bottom: 3px solid #ff600036;\r\n        }\r\n\r\n        /* Footer */\r\n        .email-footer {\r\n            background-color: #ff600036;\r\n            color: #000;\r\n            text-align: center;\r\n            font-size: 16px;\r\n            font-weight: 600;\r\n            padding: 20px;\r\n        }\r\n\r\n\r\n        /* Responsive Design */\r\n        @media only screen and (max-width: 480px) {\r\n            .email-content {\r\n                padding: 20px;\r\n            }\r\n\r\n            .email-header,\r\n            .email-footer {\r\n                padding: 15px;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body>\r\n    <div class=\"email-wrapper\">\r\n        <table class=\"email-container\" cellpadding=\"0\" cellspacing=\"0\">\r\n            <tbody style=\"border: 1px solid #ffddc9\">\r\n                <tr>\r\n                    <td>\r\n                        <!-- Header -->\r\n                        <div class=\"email-header\">\r\n                            System Generated Email\r\n                        </div>\r\n\r\n                        \r\n                        <!-- Logo -->\r\n                        <div class=\"email-logo\">\r\n                            <a href=\"#\">\r\n                                <img src=\"https://ovosolution.com/assets/img/logo.png\" alt=\"Company Logo\">\r\n                            </a>\r\n                        </div>\r\n                        <!-- Content -->\r\n                        <div class=\"email-content\">\r\n                            <h1>Hello {{username}}</h1>\r\n                            <p>{{message}}</p>\r\n                        </div>\r\n\r\n                        <!-- Footer -->\r\n                        <div class=\"email-footer\">\r\n                            &copy; 2024 <a href=\"#\" style=\"color: #0087ff;\">{{site_name}}</a>. All Rights Reserved.\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n</body>\r\n\r\n</html>', 'hi {{fullname}} ({{username}}), {{message}}', '{{site_name}}', '{{site_name}}', 'hi {{fullname}} ({{username}}), {{message}}', '202123', '2d9bf7', '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"AIzaSyCb6zm7_8kdStXjZMgLZpwjGDuTUg0e_qM\",\"authDomain\":\"flutter-prime-df1c5.firebaseapp.com\",\"projectId\":\"flutter-prime-df1c5\",\"storageBucket\":\"flutter-prime-df1c5.appspot.com\",\"messagingSenderId\":\"274514992002\",\"appId\":\"1:274514992002:web:4d77660766f4797500cd9b\",\"measurementId\":\"G-KFPM07RXRC\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 1, 'basic', '{\"google\":{\"client_id\":\"------------\",\"client_secret\":\"-------------\",\"status\":0,\"info\":\"Quickly set up Google Login for easy and secure access to your website for all users\"},\"facebook\":{\"client_id\":\"------\",\"client_secret\":\"sdfsdf\",\"status\":0,\"info\":\"Set up Facebook Login for fast, secure user access and seamless integration with your website.\"},\"linkedin\":{\"client_id\":\"-----\",\"client_secret\":\"http:\\/\\/localhost\\/flutter\\/admin_panel\\/user\\/social-login\\/callback\\/linkedin\",\"status\":1,\"info\":\"Set up LinkedIn Login for professional, secure access and easy user authentication on your website.\"}}', '2024-10-07 11:16:38', '1.0', 0, 20, 2, 'h:i A', 'Y-m-d', 2, ',', '{\"purchase_invoice_prefix\":\"PT-\",\"sale_invoice_prefix\":\"ST-\",\"product_code_prefix\":\"PD\",\"stock_transfer_invoice_prefix\":\"ST-\"}', '{\"name\":\"OvoSale\",\"email\":\"info@ovosale.com\",\"phone\":\"+1 12 12152 4541\",\"address\":\"95 University Pl, NY- 10003,USA\"}', '2025-08-16 21:44:38', NULL, '2025-08-16 20:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `days` int NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `info`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '66dd7636311b31725789750.png', 'English is a global language with rich vocabulary, bridging international communication and culture.', '2020-07-06 03:47:55', '2024-10-03 04:11:19'),
(12, 'bangla', 'bn', 0, '66dd762f478701725789743.png', 'Bangla is a rich, expressive language spoken by millions, known for its cultural depth and literary heritage.', '2024-09-08 01:34:54', '2024-10-02 08:10:11'),
(13, 'Turkish', 'tr', 0, '66dd763ce41bd1725789756.png', 'Turkish is a vibrant language with deep historical roots, known for its unique structure and cultural significance.', '2024-09-08 01:35:12', '2024-09-10 05:19:32'),
(14, 'Spanish', 'es', 0, '66dd764462e2f1725789764.png', 'Spanish is a widely spoken language, celebrated for its melodic flow and rich cultural heritage.', '2024-09-08 01:35:22', '2024-10-03 04:11:19'),
(15, 'French', 'fr', 0, '66dd7652c06061725789778.png', 'French is a romantic language, renowned for its elegance, rich literature, and global influence.', '2024-09-08 01:35:28', '2024-10-02 08:10:07'),
(17, 'Russian', 'ru', 0, '66dd7a31f25a01725790769.png', 'Russian is a powerful language, known for its complex grammar and rich literary tradition.', '2024-09-08 04:19:30', '2024-09-10 05:20:29'),
(19, 'Portuguese', 'pt', 0, '66e6c31120d4c1726399249.png', 'Portuguese is a dynamic language with a rich cultural history, known for its expressiveness and global influence.', '2024-09-15 05:20:49', '2024-09-15 05:25:42'),
(23, 'Italy', 'it', 0, '670781623fe0d1728545122.png', 'Italian is a romantic and melodic language, celebrated for its rich history, artistic influence, and cultural significance in music.', '2024-10-10 01:25:22', '2024-10-10 01:27:28'),
(24, 'Japanese', 'ja', 0, '670cd7835eb281728894851.png', 'Japanese is a unique and nuanced language, known for its complex writing and deep cultural significance.', '2024-10-14 02:34:12', '2024-10-14 02:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED NOT NULL DEFAULT '0',
  `leave_type_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days` int NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int NOT NULL DEFAULT '0',
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci,
  `sms_body` text COLLATE utf8mb4_unicode_ci,
  `push_body` text COLLATE utf8mb4_unicode_ci,
  `shortcodes` text COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '{{site_name}} Password Reset Code', '<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>', 'To proceed with the password reset, please use the following account recovery code: {{code}}', 'To proceed with the password reset, please use the following account recovery code: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:24:57'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Password Reset Successful', NULL, '<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>', 'We are writing to inform you that the password reset for your account was successful.', 'We are writing to inform you that the password reset for your account was successful.', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:24'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-05-16 01:32:53'),
(18, 'HOLIDAY', 'Holiday', 'Employee Holiday', '{{site_name}} Holiday', '<p data-start=\"159\" data-end=\"169\" class=\"\">Dear Team,</p><p data-start=\"171\" data-end=\"355\" class=\"\">We are pleased to announce that <strong data-start=\"203\" data-end=\"216\">{{title}}</strong> has been scheduled as a company-wide holiday, starting from <strong data-start=\"277\" data-end=\"295\">{{start_date}}</strong> to <strong data-start=\"299\" data-end=\"315\">{{end_date}}</strong>, covering a total of <strong data-start=\"337\" data-end=\"349\">{{days}}</strong> days.</p><p data-start=\"357\" data-end=\"449\" class=\"\">Please plan your work accordingly and ensure all responsibilities are managed ahead of time.</p><p data-start=\"451\" data-end=\"485\" class=\"\">Enjoy your well-deserved time off!</p><p data-start=\"171\" data-end=\"355\" class=\"\">\r\n\r\n\r\n\r\n</p><p data-start=\"487\" data-end=\"547\" class=\"\">Best regards,<br data-start=\"522\" data-end=\"525\">HR / Management Team</p>', 'We are pleased to announce that  {{title}} Date {{start_date}} To {{end_date}}. Total {{days}} Days', '', '{\"title\":\"Holiday Title\",\"start_date\":\"Start Date\",\"end_date\":\"End Date\",\"days\":\"Days\"}', 1, '{{site_name}}', NULL, 1, NULL, 0, '2021-11-03 19:00:00', '2025-04-19 16:01:36');


--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_accounts`
--

CREATE TABLE `payment_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_type_id` int NOT NULL DEFAULT '0',
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `slug`, `status`, `is_default`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 'cash', 1, 1, NULL, '2025-01-23 11:03:22', '2025-01-23 11:03:39'),
(2, 'Card', 'card', 1, 1, NULL, '2025-01-23 11:03:27', '2025-01-23 11:03:36');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `payment_method_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_account_id` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'view sale', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(2, 'add sale', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(3, 'edit sale', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(4, 'print sale invoice', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(5, 'print pos sale invoice', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(6, 'download sale invoice', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(7, 'view sale payment', 'admin', 'sale', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(8, 'view purchase', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(9, 'add purchase', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(10, 'edit purchase', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(11, 'update purchase status', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(12, 'print purchase invoice', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(13, 'download purchase invoice', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(14, 'add purchase payment', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(15, 'view purchase payment', 'admin', 'purchase', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(16, 'view expense', 'admin', 'expense', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(17, 'add expense', 'admin', 'expense', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(18, 'edit expense', 'admin', 'expense', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(19, 'trash expense', 'admin', 'expense', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(20, 'view expense category', 'admin', 'expense category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(21, 'add expense category', 'admin', 'expense category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(22, 'edit expense category', 'admin', 'expense category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(23, 'trash expense category', 'admin', 'expense category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(24, 'view product', 'admin', 'product', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(25, 'add product', 'admin', 'product', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(26, 'edit product', 'admin', 'product', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(27, 'print product barcode', 'admin', 'product', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(28, 'trash product', 'admin', 'product', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(29, 'view category', 'admin', 'category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(30, 'add category', 'admin', 'category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(31, 'edit category', 'admin', 'category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(32, 'trash category', 'admin', 'category', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(33, 'view brand', 'admin', 'brand', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(34, 'add brand', 'admin', 'brand', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(35, 'edit brand', 'admin', 'brand', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(36, 'trash brand', 'admin', 'brand', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(37, 'view unit', 'admin', 'unit', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(38, 'add unit', 'admin', 'unit', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(39, 'edit unit', 'admin', 'unit', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(40, 'trash unit', 'admin', 'unit', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(41, 'view attribute', 'admin', 'attribute', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(42, 'add attribute', 'admin', 'attribute', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(43, 'edit attribute', 'admin', 'attribute', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(44, 'trash attribute', 'admin', 'attribute', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(45, 'view variant', 'admin', 'variant', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(46, 'add variant', 'admin', 'variant', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(47, 'edit variant', 'admin', 'variant', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(48, 'trash variant', 'admin', 'variant', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(49, 'view stock transfer', 'admin', 'stock_transfer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(50, 'add stock transfer', 'admin', 'stock_transfer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(51, 'edit stock transfer', 'admin', 'stock_transfer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(52, 'view sale report', 'admin', 'report', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(53, 'view purchase report', 'admin', 'report', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(54, 'view expense report', 'admin', 'report', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(55, 'view stock report', 'admin', 'report', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(56, 'view profit loss report', 'admin', 'report', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(57, 'view warehouse', 'admin', 'warehouse', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(58, 'add warehouse', 'admin', 'warehouse', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(59, 'edit warehouse', 'admin', 'warehouse', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(60, 'trash warehouse', 'admin', 'warehouse', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(61, 'view tax', 'admin', 'tax', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(62, 'add tax', 'admin', 'tax', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(63, 'edit tax', 'admin', 'tax', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(64, 'trash tax', 'admin', 'tax', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(65, 'view coupon', 'admin', 'coupon', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(66, 'add coupon', 'admin', 'coupon', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(67, 'edit coupon', 'admin', 'coupon', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(68, 'trash coupon', 'admin', 'coupon', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(69, 'view payment type', 'admin', 'payment type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(70, 'add payment type', 'admin', 'payment type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(71, 'edit payment type', 'admin', 'payment type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(72, 'trash payment type', 'admin', 'payment type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(73, 'view payment account', 'admin', 'payment account', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(74, 'add payment account', 'admin', 'payment account', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(75, 'edit payment account', 'admin', 'payment account', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(76, 'adjust payment account balance', 'admin', 'payment account', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(77, 'trash payment account', 'admin', 'payment account', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(78, 'view customer', 'admin', 'customer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(79, 'add customer', 'admin', 'customer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(80, 'edit customer', 'admin', 'customer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(81, 'trash customer', 'admin', 'customer', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(82, 'view supplier', 'admin', 'supplier', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(83, 'add supplier', 'admin', 'supplier', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(84, 'edit supplier', 'admin', 'supplier', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(85, 'trash supplier', 'admin', 'supplier', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(86, 'view admin', 'admin', 'admin', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(87, 'add admin', 'admin', 'admin', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(88, 'edit admin', 'admin', 'admin', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(89, 'view role', 'admin', 'role', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(90, 'add role', 'admin', 'role', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(91, 'edit role', 'admin', 'role', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(92, 'assign permission', 'admin', 'role', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(93, 'general setting', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(94, 'prefix setting', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(95, 'company setting', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(96, 'brand setting', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(97, 'system configuration', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(98, 'notification setting', 'admin', 'setting', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(99, 'view dashboard', 'admin', 'other', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(100, 'view transaction', 'admin', 'other', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(101, 'manage extension', 'admin', 'other', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(102, 'manage language', 'admin', 'other', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(103, 'application information', 'admin', 'other', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(104, 'view company', 'admin', 'company', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(105, 'add company', 'admin', 'company', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(106, 'edit company', 'admin', 'company', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(107, 'trash company', 'admin', 'company', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(108, 'view department', 'admin', 'department', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(109, 'add department', 'admin', 'department', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(110, 'edit department', 'admin', 'department', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(111, 'trash department', 'admin', 'department', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(112, 'view designation', 'admin', 'designation', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(113, 'add designation', 'admin', 'designation', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(114, 'edit designation', 'admin', 'designation', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(115, 'trash designation', 'admin', 'designation', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(116, 'view shift', 'admin', 'shift', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(117, 'add shift', 'admin', 'shift', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(118, 'edit shift', 'admin', 'shift', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(119, 'trash shift', 'admin', 'shift', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(120, 'view employee', 'admin', 'employee', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(121, 'add employee', 'admin', 'employee', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(122, 'edit employee', 'admin', 'employee', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(123, 'trash employee', 'admin', 'employee', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(124, 'view attendance', 'admin', 'attendance', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(125, 'add attendance', 'admin', 'attendance', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(126, 'edit attendance', 'admin', 'attendance', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(127, 'trash attendance', 'admin', 'attendance', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(128, 'view leave request', 'admin', 'leave request', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(129, 'add leave request', 'admin', 'leave request', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(130, 'edit leave request', 'admin', 'leave request', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(131, 'trash leave request', 'admin', 'leave request', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(132, 'view leave type', 'admin', 'leave type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(133, 'add leave type', 'admin', 'leave type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(134, 'edit leave type', 'admin', 'leave type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(135, 'trash leave type', 'admin', 'leave type', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(136, 'view holiday', 'admin', 'holiday', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(137, 'add holiday', 'admin', 'holiday', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(138, 'edit holiday', 'admin', 'holiday', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(139, 'trash holiday', 'admin', 'holiday', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(140, 'view payroll', 'admin', 'payroll', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(141, 'add payroll', 'admin', 'payroll', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(142, 'edit payroll', 'admin', 'payroll', '2025-08-12 10:57:32', '2025-08-12 10:57:32'),
(143, 'trash payroll', 'admin', 'payroll', '2025-08-12 10:57:32', '2025-08-12 10:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=static,2=variable',
  `category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `unit_id` int UNSIGNED NOT NULL DEFAULT '0',
  `brand_id` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=enable, 0=disable',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `tax_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tax_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'exclusive=1,inclusive=2',
  `tax_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `profit_margin` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sale_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'percent=1,fixed=2',
  `discount_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `alert_quantity` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `variant_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attribute_id` int UNSIGNED NOT NULL DEFAULT '0',
  `barcode_html` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_details_id` int UNSIGNED NOT NULL DEFAULT '0',
  `warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int UNSIGNED NOT NULL DEFAULT '0',
  `warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'percent=1,fixed=2',
  `discount_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `shipping_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `subtotal` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `total` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=received,2=pending,3=ordered=',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_details_id` int UNSIGNED NOT NULL DEFAULT '0',
  `base_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `tax_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tax_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'exclusive=1,inclusive=2',
  `tax_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `profit_margin` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sale_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'percent=1,fixed=2',
  `discount_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', 1, '2025-01-18 14:04:23', '2025-01-23 10:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `customer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'percent=1,fixed=2',
  `discount_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `shipping_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `subtotal` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `total` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `paying_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `changes_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `note` text COLLATE utf8mb4_unicode_ci,
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_pos_sale` int NOT NULL DEFAULT '1' COMMENT '1=yes,0=no',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'final= 1,quotation = 2',
  `coupon_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_details_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tax_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tax_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'exclusive=1,inclusive=2',
  `tax_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'percent=1,fixed=2',
  `discount_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `purchase_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `unit_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sale_price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `quantity` int NOT NULL DEFAULT '0',
  `subtotal` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payments`
--

CREATE TABLE `sale_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` int UNSIGNED NOT NULL DEFAULT '0',
  `customer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_type` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_account_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `trx` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `to_warehouse_id` int UNSIGNED NOT NULL DEFAULT '0',
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=sent,0=draft',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_details`
--

CREATE TABLE `stock_transfer_details` (
  `id` bigint UNSIGNED NOT NULL,
  `stock_transfer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int UNSIGNED NOT NULL DEFAULT '0',
  `product_details_id` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` int UNSIGNED NOT NULL DEFAULT '0',
  `supplier_id` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_type_id` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_account_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `payment_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_account_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_activities`
--
ALTER TABLE `admin_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attributes_name_unique` (`name`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`mobile`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_categories_name_unique` (`name`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
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
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_types_name_unique` (`name`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

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
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_details_sku_unique` (`sku`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_company_name_unique` (`company_name`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`),
  ADD UNIQUE KEY `suppliers_phone_unique` (`mobile`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `taxes_name_unique` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`),
  ADD UNIQUE KEY `units_short_name_unique` (`short_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attribute_id` (`attribute_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouses_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_activities`
--
ALTER TABLE `admin_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;


--
-- AUTO_INCREMENT for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payments`
--
ALTER TABLE `sale_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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



INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `address`, `city`, `state`, `country`, `zip`, `postcode`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Walk-in customer', 'walk_in_customer@gmail.com', '', '123456', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-11-27 06:06:33', '2024-12-04 04:31:24');

-- ===========================================================
-- ======================== version 2.0 ======================
-- ===========================================================

DELETE FROM
  `role_has_permissions`;

DELETE FROM
  `model_has_permissions`;

DELETE FROM
  `model_has_roles`;

DELETE FROM
  `roles`;

DELETE FROM
  `permissions`;

DROP TABLE `role_has_permissions`;

DROP TABLE `model_has_permissions`;

DROP TABLE `model_has_roles`;

DROP TABLE `roles`;

DROP TABLE `permissions`;

ALTER TABLE
  `attributes`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `brands`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `categories`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `companies`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `coupons`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `customers`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `designations`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `expenses`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `expense_categories`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `leave_requests`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `leave_types`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `payment_types`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `payrolls`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `products`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `purchases`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `sales`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `stock_transfers` CHANGE `admin_id` `user_id` INT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE
  `suppliers`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `taxes`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `transactions`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `units`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `variants`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `warehouses`
ADD
  `user_id` BIGINT UNSIGNED NOT NULL
AFTER
  `id`;

ALTER TABLE
  `users`
ADD
  `parent_id` BIGINT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `tsc`,
ADD
  `is_staff` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `parent_id`;

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;




CREATE TABLE `plan_purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_plan_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `staff_has_permissions` (
  `id` bigint NOT NULL,
  `staff_permission_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `staff_id` bigint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `staff_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_permissions`
--
INSERT INTO
  `staff_permissions` (
    `id`,
    `name`,
    `guard_name`,
    `group_name`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    'view sale',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    2,
    'add sale',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    3,
    'edit sale',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    4,
    'print sale invoice',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    5,
    'print pos sale invoice',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    6,
    'download sale invoice',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    7,
    'view sale payment',
    'web',
    'sale',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    8,
    'view purchase',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    9,
    'add purchase',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    10,
    'edit purchase',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    11,
    'update purchase status',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    12,
    'print purchase invoice',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    13,
    'download purchase invoice',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    14,
    'add purchase payment',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    15,
    'view purchase payment',
    'web',
    'purchase',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    16,
    'view expense',
    'web',
    'expense',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    17,
    'add expense',
    'web',
    'expense',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    18,
    'edit expense',
    'web',
    'expense',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    19,
    'trash expense',
    'web',
    'expense',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    20,
    'view expense category',
    'web',
    'expense category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    21,
    'add expense category',
    'web',
    'expense category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    22,
    'edit expense category',
    'web',
    'expense category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    23,
    'trash expense category',
    'web',
    'expense category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    24,
    'view product',
    'web',
    'product',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    25,
    'add product',
    'web',
    'product',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    26,
    'edit product',
    'web',
    'product',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    27,
    'print product barcode',
    'web',
    'product',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    28,
    'trash product',
    'web',
    'product',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    29,
    'view category',
    'web',
    'category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    30,
    'add category',
    'web',
    'category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    31,
    'edit category',
    'web',
    'category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    32,
    'trash category',
    'web',
    'category',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    33,
    'view brand',
    'web',
    'brand',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    34,
    'add brand',
    'web',
    'brand',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    35,
    'edit brand',
    'web',
    'brand',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    36,
    'trash brand',
    'web',
    'brand',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    37,
    'view unit',
    'web',
    'unit',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    38,
    'add unit',
    'web',
    'unit',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    39,
    'edit unit',
    'web',
    'unit',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    40,
    'trash unit',
    'web',
    'unit',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    41,
    'view attribute',
    'web',
    'attribute',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    42,
    'add attribute',
    'web',
    'attribute',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    43,
    'edit attribute',
    'web',
    'attribute',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    44,
    'trash attribute',
    'web',
    'attribute',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    45,
    'view variant',
    'web',
    'variant',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    46,
    'add variant',
    'web',
    'variant',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    47,
    'edit variant',
    'web',
    'variant',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    48,
    'trash variant',
    'web',
    'variant',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    49,
    'view stock transfer',
    'web',
    'stock_transfer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    50,
    'add stock transfer',
    'web',
    'stock_transfer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    51,
    'edit stock transfer',
    'web',
    'stock_transfer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    52,
    'view sale report',
    'web',
    'report',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    53,
    'view purchase report',
    'web',
    'report',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    54,
    'view expense report',
    'web',
    'report',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    55,
    'view stock report',
    'web',
    'report',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    56,
    'view profit loss report',
    'web',
    'report',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    57,
    'view warehouse',
    'web',
    'warehouse',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    58,
    'add warehouse',
    'web',
    'warehouse',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    59,
    'edit warehouse',
    'web',
    'warehouse',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    60,
    'trash warehouse',
    'web',
    'warehouse',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    61,
    'view tax',
    'web',
    'tax',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    62,
    'add tax',
    'web',
    'tax',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    63,
    'edit tax',
    'web',
    'tax',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    64,
    'trash tax',
    'web',
    'tax',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    65,
    'view coupon',
    'web',
    'coupon',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    66,
    'add coupon',
    'web',
    'coupon',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    67,
    'edit coupon',
    'web',
    'coupon',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    68,
    'trash coupon',
    'web',
    'coupon',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    69,
    'view payment type',
    'web',
    'payment type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    70,
    'add payment type',
    'web',
    'payment type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    71,
    'edit payment type',
    'web',
    'payment type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    72,
    'trash payment type',
    'web',
    'payment type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    73,
    'view payment account',
    'web',
    'payment account',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    74,
    'add payment account',
    'web',
    'payment account',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    75,
    'edit payment account',
    'web',
    'payment account',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    76,
    'adjust payment account balance',
    'web',
    'payment account',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    77,
    'trash payment account',
    'web',
    'payment account',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    78,
    'view customer',
    'web',
    'customer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    79,
    'add customer',
    'web',
    'customer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    80,
    'edit customer',
    'web',
    'customer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    81,
    'trash customer',
    'web',
    'customer',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    82,
    'view supplier',
    'web',
    'supplier',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    83,
    'add supplier',
    'web',
    'supplier',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    84,
    'edit supplier',
    'web',
    'supplier',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    85,
    'trash supplier',
    'web',
    'supplier',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    93,
    'general setting',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    94,
    'prefix setting',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    95,
    'company setting',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    96,
    'brand setting',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    97,
    'system configuration',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    98,
    'notification setting',
    'web',
    'setting',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    99,
    'view dashboard',
    'web',
    'other',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    100,
    'view transaction',
    'web',
    'other',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    101,
    'manage extension',
    'web',
    'other',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    102,
    'manage language',
    'web',
    'other',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    103,
    'application information',
    'web',
    'other',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    104,
    'view company',
    'web',
    'company',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    105,
    'add company',
    'web',
    'company',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    106,
    'edit company',
    'web',
    'company',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    107,
    'trash company',
    'web',
    'company',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    108,
    'view department',
    'web',
    'department',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    109,
    'add department',
    'web',
    'department',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    110,
    'edit department',
    'web',
    'department',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    111,
    'trash department',
    'web',
    'department',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    112,
    'view designation',
    'web',
    'designation',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    113,
    'add designation',
    'web',
    'designation',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    114,
    'edit designation',
    'web',
    'designation',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    115,
    'trash designation',
    'web',
    'designation',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    116,
    'view shift',
    'web',
    'shift',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    117,
    'add shift',
    'web',
    'shift',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    118,
    'edit shift',
    'web',
    'shift',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    119,
    'trash shift',
    'web',
    'shift',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    120,
    'view employee',
    'web',
    'employee',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    121,
    'add employee',
    'web',
    'employee',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    122,
    'edit employee',
    'web',
    'employee',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    123,
    'trash employee',
    'web',
    'employee',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    124,
    'view attendance',
    'web',
    'attendance',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    125,
    'add attendance',
    'web',
    'attendance',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    126,
    'edit attendance',
    'web',
    'attendance',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    127,
    'trash attendance',
    'web',
    'attendance',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    128,
    'view leave request',
    'web',
    'leave request',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    129,
    'add leave request',
    'web',
    'leave request',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    130,
    'edit leave request',
    'web',
    'leave request',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    131,
    'trash leave request',
    'web',
    'leave request',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    132,
    'view leave type',
    'web',
    'leave type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    133,
    'add leave type',
    'web',
    'leave type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    134,
    'edit leave type',
    'web',
    'leave type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    135,
    'trash leave type',
    'web',
    'leave type',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    136,
    'view holiday',
    'web',
    'holiday',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    137,
    'add holiday',
    'web',
    'holiday',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    138,
    'edit holiday',
    'web',
    'holiday',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    139,
    'trash holiday',
    'web',
    'holiday',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    140,
    'view payroll',
    'web',
    'payroll',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    141,
    'add payroll',
    'web',
    'payroll',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    142,
    'edit payroll',
    'web',
    'payroll',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    143,
    'trash payroll',
    'web',
    'payroll',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    144,
    'view user',
    'web',
    'user',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  ),
  (
    145,
    'update user',
    'web',
    'user',
    '2025-10-16 09:41:01',
    '2025-10-16 09:41:01'
  );

CREATE TABLE `subscription_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'DAILY = 1,\r\nWEEKLY = 2,\r\nMONTHLY = 3,\r\nHALF_YEARLY = 4,\r\nYEARLY = 5,\r\n',
  `price` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `offer_price` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `trial_days` int NOT NULL DEFAULT '0',
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--
INSERT INTO
  `cron_jobs` (
    `id`,
    `name`,
    `alias`,
    `action`,
    `url`,
    `cron_schedule_id`,
    `next_run`,
    `last_run`,
    `is_running`,
    `is_default`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    6,
    'Fetch Subscriptions',
    'fetch_subscriptions',
    '[\"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\"fetchSubscriptions\"]',
    '',
    1,
    '2025-10-20 21:40:04',
    '2025-10-20 20:40:04',
    1,
    1,
    '2024-09-09 03:36:44',
    '2025-10-20 14:40:04'
  );

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--
INSERT INTO
  `cron_schedules` (
    `id`,
    `name`,
    `interval`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    'Hourly2',
    3600,
    1,
    '2024-03-13 23:34:09',
    '2025-10-12 10:52:58'
  ),
  (
    3,
    'Daily',
    86400,
    1,
    '2024-05-06 04:46:39',
    '2024-05-06 04:46:39'
  ),
  (
    4,
    'yearly',
    2000,
    1,
    '2024-09-09 02:52:56',
    '2024-09-09 02:52:56'
  );

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `subscription_plan_id` int DEFAULT NULL,
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO
  `notification_templates` (
    `act`,
    `name`,
    `subject`,
    `push_title`,
    `email_body`,
    `sms_body`,
    `push_body`,
    `shortcodes`,
    `email_status`,
    `email_sent_from_name`,
    `email_sent_from_address`,
    `sms_status`,
    `sms_sent_from`,
    `push_status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    'KYC_APPROVE',
    'KYC Approved',
    'KYC Details has been approved',
    '{{site_name}} - KYC Approved',
    '<div><div><span>We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.</span></div><br><div><span>Your commitment to completing the KYC process promptly is greatly appreciated, as it helps us ensure the security and integrity of our platform for all users.</span></div><br><div><span>With your KYC verification now complete, you can proceed with confidence to carry out any payout transactions you require. Should you encounter any issues or have any questions along the way, please don\'t hesitate to reach out to our support team. We\'re here to assist you every step of the way.</span></div><br><div><span>Thank you once again for choosing {{site_name}} and for your cooperation in this matter.</span></div></div>',
    'We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.',
    'Your Know Your Customer (KYC) information has been approved successfully',
    '[]',
    1,
    '{{site_name}} Verification Center',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  ),
  (
    'KYC_REJECT',
    'KYC Rejected',
    'KYC has been rejected',
    '{{site_name}} - KYC Rejected',
    '<div><div><span>We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time.</span></div><br><div><span>We understand that this news may be disappointing, and we want to assure you that we take these matters seriously to maintain the security and integrity of our platform.</span></div><br><div><span>Reasons for rejection may include discrepancies or incomplete information in the documentation provided. If you believe there has been a misunderstanding or if you would like further clarification on why your KYC was rejected, please don\'t hesitate to contact our support team.</span></div><br><div><span>We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.</span></div><br><div><span>We apologize for any inconvenience this may cause and appreciate your understanding and cooperation in this matter.</span></div><br><div>Rejection Reason:</div><div>{{reason}}</div><div><br></div><div><span>Thank you for your continued support and patience.</span></div></div>',
    'We regret to inform you that your Know Your Customer (KYC) information has not met our verification standards. Please review and resubmit your KYC details.',
    'Your Know Your Customer (KYC) information has been rejected',
    '{\"reason\":\"Rejection Reason\"}',
    1,
    '{{site_name}} Verification Center',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  ),
  (
    'SVER_CODE',
    'Verification - SMS',
    'Verify Your Mobile Number',
    NULL,
    '---',
    'Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.',
    '---',
    '{\"code\":\"SMS Verification Code\"}',
    0,
    '{{site_name}} Verification Center',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  ),
  (
    'EVER_CODE',
    'Verification - Email',
    'Email Verification Code',
    NULL,
    '<div><div><span>Thank you for verifying your email address. Your verification code is</span>: <b><font size=\"6\">{{code}}</font></b></div><br><div><span>Please enter this code to complete your verification process.</span></div><br><div><span>If you did not request this code, please disregard this email.</span></div></div>',
    '---',
    '---',
    '{\"code\":\"Email verification code\"}',
    1,
    '{{site_name}} Verification Center',
    NULL,
    0,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  ),
  (
    'ADMIN_SUPPORT_REPLY',
    'Support - Reply',
    'Re: {{ticket_subject}} - Ticket #{{ticket_id}}',
    '{{site_name}} - Support Ticket Replied',
    '<div><div><span>Thank you for reaching out to us regarding your support ticket</span> #{{ticket_id}} with subject \"{{ticket_subject}}\".</div><br><div>{{reply}}</div><br><div><a href=\"{{link}}\">Click here</a> to view your ticket and continue the conversation.</div></div>',
    'We have replied to your support ticket #{{ticket_id}}. Please check your dashboard for details.',
    'Re: {{ticket_subject}} - Ticket #{{ticket_id}}',
    '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject of the ticket\",\"reply\":\"Reply from admin\",\"link\":\"Ticket URL\"}',
    1,
    '{{site_name}} Support Team',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  ),
  (
    'PLAN_PURCHASE',
    'Plan Purchase',
    'Plan has been purchased',
    '{{site_name}} - Plan Purchase',
    '<div>We wish to inform you that an amount of <strong data-start=\"186\" data-end=\"218\">{{amount}} {{site_currency}}</strong> has been successfully deducted from your account for your subscription to the <strong data-start=\"297\" data-end=\"314\">{{plan_name}}</strong> plan.</div><div><br></div><div>Below are the details of the transaction:</div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Subscription Plan</b> <b>:</b> {{plan_name}}</div><div><b>Billing Cycle :</b>&nbsp;{{duration}}</div><div><b>Amount Paid : </b>{{amount}}</div><div><b>Next Billing Date :</b>&nbsp;{{next_billing}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div></div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>',
    'Congratulations! We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted for subscription payment.',
    '{{amount}} {{site_currency}} payment has been done for subscription.',
    '{\r\n    \"trx\": \"Transaction number for the action\",\r\n    \"amount\": \"Amount of the subscription payment\",\r\n    \"plan_name\": \"The name of the subscription plan\",\r\n    \"duration\" : \"The duration of the subscription plan\",\r\n    \"next_billing\" : \"The next billing date\",\r\n    \"remark\": \"Remark inserted by the admin\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}',
    1,
    '{{site_name}} Finance',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 06:30:28',
    '2025-10-25 06:30:28'
  ),
  (
    'STAFF_REGISTERED',
    'Staff-Registered',
    'Staff registered by user',
    '{{site_name}} - Staff Registered',
    '<div>Hello <b>{{user}}</b>,</div>\r\n\r\n<br>\r\n\r\n<div>\r\n  🎉 Congratulations! You have been successfully registered on <b>{{site_name}}</b> as a staff member by <b>{{parent_user}}</b>.\r\n</div>\r\n\r\n<br>\r\n\r\n<div>Here are your login details:</div>\r\n<div><b>Username:</b> {{username}}</div>\r\n<div><b>Email:</b> {{email}}</div>\r\n<div><b>Password:</b> {{password}} <i>(One-time password)</i></div>\r\n\r\n<br>\r\n\r\n<div>\r\n  👉 <a href=\"{{login_url}}\" target=\"_blank\" style=\"color:#007bff; text-decoration:none;\">Click here to log in to your account</a>\r\n</div>\r\n\r\n<br>\r\n\r\n<div>\r\n  <b>Important:</b> For security purposes, please change your password immediately after your first login.  \r\n  This one-time password will expire once you update it.\r\n</div>\r\n\r\n<br>\r\n\r\n<div>\r\n  If you have any questions or need help, don’t hesitate to contact our support team.\r\n</div>\r\n\r\n<br>\r\n\r\n<div>\r\n  Best regards,<br>\r\n  <b>The {{site_name}} Team</b>\r\n</div>\r\n',
    '',
    '',
    '{\r\n  \"user\": \"Username of the newly created user (agent)\",\r\n  \"parent_user\": \"Username of the user who created the agent\",\r\n  \"username\": \"Username of the agent\",\r\n  \"email\": \"Email address of the agent\",\r\n  \"password\": \"One-time password for the agent\",\r\n  \"login_url\": \"Login URL for the agent\"\r\n}\r\n',
    1,
    '{{site_name}} Management',
    NULL,
    1,
    NULL,
    0,
    '2025-10-25 12:30:28',
    '2025-10-25 12:30:28'
  );

INSERT INTO
  `extensions` (
    `id`,
    `act`,
    `name`,
    `description`,
    `info`,
    `image`,
    `script`,
    `shortcode`,
    `support`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    'tawk-chat',
    'Tawk.to',
    'Key location is shown bellow',
    'Tawk.to offers live chat support, helping you communicate with visitors and boost customer satisfaction',
    'tawky_big.png',
    '<script>\r\n    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n    (function(){\r\n        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];\r\n        s1.async=true;\r\n        s1.src="https://embed.tawk.to/{{app_key}}";\r\n        s1.charset="UTF-8";\r\n        s1.setAttribute("crossorigin","*");\r\n        s0.parentNode.insertBefore(s1,s0);\r\n    })();\r\n</script>',
    '{\"app_key\":{\"title\":\"App Key\",\"value\":\"121\"}}',
    'twak.png',
    0,
    NOW(),
    NOW()
  ),
  (
    4,
    'google-analytics',
    'Google Analytics',
    'Key location is shown bellow',
    'Google Analytics tracks website traffic and user behavior, helping you improve performance and understand your audience',
    'google_analytics.png',
    '<script async src="https://www.googletagmanager.com/gtag/js?id={{measurement_id}}"></script>\r\n<script>\r\n  window.dataLayer = window.dataLayer || [];\r\n  function gtag(){dataLayer.push(arguments);}\r\n  gtag("js", new Date());\r\n  gtag("config", "{{measurement_id}}");\r\n</script>',
    '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}',
    'ganalytics.png',
    0,
    NOW(),
    NOW()
  ),
  (
    5,
    'fb-comment',
    'Facebook Comment',
    'Key location is shown bellow',
    'Facebook Comment lets users share feedback on your site, increasing engagement and social interaction',
    'Facebook.png',
    '<div id="fb-root"></div>\r\n<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1"></script>',
    '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}',
    'fb_com.png',
    0,
    NOW(),
    NOW()
  );

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

ALTER TABLE
  `user_logins`
ADD
  PRIMARY KEY (`id`);

ALTER TABLE
  `user_logins`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--
INSERT INTO
  `gateways` (
    `id`,
    `form_id`,
    `code`,
    `name`,
    `alias`,
    `image`,
    `status`,
    `gateway_parameters`,
    `supported_currencies`,
    `crypto`,
    `extra`,
    `description`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    0,
    101,
    'Paypal - Basic',
    'Paypal',
    '66f93024b850f1727606820.png',
    1,
    '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-sie1e33346198@business.example.com\"}}',
    '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 03:59:25'
  ),
  (
    2,
    0,
    102,
    'PerfectMoney',
    'PerfectMoney',
    '66f9305b163861727606875.png',
    1,
    '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"h9Rz18d60KeErSFPUViTlTyUX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}',
    '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 05:05:22'
  ),
  (
    3,
    0,
    103,
    'Stripe - Hosted',
    'Stripe',
    '66f932d3898531727607507.png',
    1,
    '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"}}',
    '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-05 00:27:02'
  ),
  (
    5,
    0,
    105,
    'PayTM',
    'Paytm',
    '66f9305278b331727606866.png',
    1,
    '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-----------\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"-----------\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"-----------\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"-----------\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"-----------\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"-----------\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"-----------\"}}',
    '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-14 00:19:59'
  ),
  (
    6,
    0,
    106,
    'Payeer',
    'Payeer',
    '66f93018e4b7c1727606808.png',
    1,
    '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"P1124379867\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"768336\"}}',
    '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}',
    0,
    '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}',
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 03:41:46'
  ),
  (
    7,
    0,
    107,
    'PayStack',
    'Paystack',
    '66f9303d3ca031727606845.png',
    1,
    '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_7a71410e62ae07cad950d94e4a3827b974937450\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_e8cf00c8c7fc173b60f02199e2752e2f34e50494\"}}',
    '{\"NGN\": \"NGN\",\"GHS\": \"GHS\",\"ZAR\": \"ZAR\",\"USD\": \"USD\",\"XOF\": \"XOF\",\"KES\": \"KES\"}',
    0,
    '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n',
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 04:19:28'
  ),
  (
    9,
    0,
    109,
    'Flutterwave',
    'Flutterwave',
    '66f92fb282a3a1727606706.png',
    1,
    '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"FLWPUBK_TEST-0ee1835b2e1088d2a529356ec7dcdb30-X\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"FLWSECK_TEST-6c5417024ef775a0eabfb021d41369f8-X\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"FLWSECK_TEST78b28d6fdf42\"}}',
    '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 01:33:13'
  ),
  (
    10,
    0,
    110,
    'RazorPay',
    'Razorpay',
    '66f93067ae7661727606887.png',
    1,
    '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"-------------\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"------------\"}}',
    '{\"INR\":\"INR\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-14 00:20:13'
  ),
  (
    12,
    0,
    112,
    'Instamojo',
    'Instamojo',
    '66f92fbe2ccbb1727606718.png',
    1,
    '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"--------------\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"----------------\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"------------\"}}',
    '{\"INR\":\"INR\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-14 00:19:23'
  ),
  (
    15,
    0,
    503,
    'CoinPayments Crypto',
    'Coinpayments',
    '66f92f90365d41727606672.png',
    1,
    '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"222a8c8825477fbea80812a9d5d70057e4821e43198926daa075fdc08cc98cd6\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"6d049b6B91a5eBe2053bb21eAa0DCb60f33790ec96B2342192804b0e9dfFf741\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"47818ed2d6962bcab1eba829e38ad0c4\"}}',
    '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}',
    1,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 06:14:28'
  ),
  (
    16,
    0,
    504,
    'CoinPayments Fiat',
    'CoinpaymentsFiat',
    '66f92fa7d56851727606695.png',
    1,
    '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}',
    '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-09-29 04:44:55'
  ),
  (
    17,
    0,
    505,
    'Coingate',
    'Coingate',
    '66f92f1dafc6e1727606557.png',
    1,
    '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"------------------\"}}',
    '{\"USD\":\"USD\",\"EUR\":\"EUR\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-14 00:19:09'
  ),
  (
    18,
    0,
    506,
    'CoinbaseCommerce',
    'CoinbaseCommerce',
    '66f92e80485251727606400.png',
    1,
    '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"------------------\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"-------------\"}}',
    '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n',
    0,
    '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}',
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-14 00:18:55'
  ),
  (
    24,
    0,
    113,
    'Paypal - Express',
    'PaypalSdk',
    '66f954f3b28261727616243.png',
    1,
    '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"AYq9c_gjnfFiLpWdotm-5XTw-RwtWtBrxIEW7IJGcjmq6cLDcTOjSSVlIqnIq4dYWnxrOEeK7s0UuuCy\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"ECXn_0gIPEdgVDiPfh-zR3KFm5WfmZe5UvhDrKNNa59i5bTSZ3K4S9QFb9uJNZ-vjBGEwcdKD0SRQsP5\"}}',
    '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}',
    0,
    NULL,
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-13 03:59:51'
  ),
  (
    25,
    0,
    114,
    'Stripe - Checkout',
    'StripeV3',
    '66f930941abc51727606932.png',
    1,
    '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_VnTLcUcx5bMenhc6P0PZiTR0T6NGs5yF\"}}',
    '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}',
    0,
    '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}',
    NULL,
    '2019-09-14 13:14:22',
    '2024-10-05 00:25:34'
  ),
  (
    36,
    0,
    119,
    'MercadoPago',
    'MercadoPago',
    '66f92fcac0e111727606730.png',
    1,
    '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"--------------\"}}',
    '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\",\"BRL\":\"BRL\"}',
    0,
    NULL,
    NULL,
    NULL,
    '2024-10-14 00:19:38'
  ),
  (
    37,
    0,
    120,
    'Authorize.net',
    'Authorize',
    '66f92de1ce5151727606241.png',
    1,
    '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}',
    '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}',
    0,
    NULL,
    NULL,
    NULL,
    '2024-10-03 03:12:33'
  ),
  (
    50,
    0,
    507,
    'BTCPay',
    'BTCPay',
    '66f92dab2d0c81727606187.png',
    1,
    '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"GLeYKqo2vM1jW9e2aFpGsLqokwTbfpQ3yZFQBRy2um58\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"a60a2d61645cddd1f552212ca0f802121e47d08c\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}',
    '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}',
    1,
    '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}',
    NULL,
    NULL,
    '2024-10-14 03:40:52'
  ),
  (
    51,
    0,
    508,
    'NowPayments - Hosted',
    'NowPaymentsHosted',
    '66f92ffed509e1727606782.png',
    1,
    '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}}',
    '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}',
    1,
    '',
    NULL,
    NULL,
    '2024-10-13 02:56:13'
  ),
  (
    52,
    0,
    509,
    'NowPayments - Checkout',
    'NowPaymentsCheckout',
    '66f92ff5897b41727606773.png',
    1,
    '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}}',
    '{\"USD\":\"USD\",\"EUR\":\"EUR\"}',
    1,
    '',
    NULL,
    NULL,
    '2024-10-13 02:47:13'
  ),
  (
    53,
    0,
    122,
    '2Checkout',
    'TwoCheckout',
    '66f93484853cf1727607940.png',
    1,
    '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"255237318607\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"tNbET^O0mlJ4QHdAf6W#\"}}',
    '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}',
    0,
    '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}',
    NULL,
    NULL,
    '2024-10-13 05:40:07'
  ),
  (
    54,
    0,
    123,
    'Checkout',
    'Checkout',
    '66f92e6bd08e01727606379.png',
    0,
    '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}',
    '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}',
    0,
    NULL,
    NULL,
    NULL,
    '2024-09-30 01:55:03'
  ),
  (
    55,
    19,
    1000,
    'Bank Transfer',
    'bank_transfer',
    '66f95525bfa571727616293.png',
    1,
    '[]',
    '[]',
    0,
    NULL,
    '<div style=\"border-left: 3px solid #b5b0b0;\r\n    padding: 12px;\r\n    font-style: italic;\r\n    margin: 30px 0px;\r\n    background: #f9f9f9;\r\n    border-radius: 3px;\"><p style=\"\r\n    margin-bottom: 10px;\r\n    font-weight: bold;\r\n    font-size: 17px;\r\n\">Please send the funds to the information provided below. We cannot be held responsible for any errors if the amount is sent to incorrect details. Kindly complete the form after transferring the funds<br><br>Bank information</p><p style=\"\r\n    margin-bottom: 0;\r\n\">\r\n</p><p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Bank Name:</span>&nbsp;Demo Bank</p>\r\n<p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Branch:</span>&nbsp;Demo Branch</p>\r\n<p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Routing:</span> 1234</p>\r\n<p style=\"\r\n    margin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Account Number:</span> xxx-xxx-<span style=\"color: rgb(67, 64, 79); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); display: inline !important;\">xxx-xxx-xxx</span></p></div>',
    '2024-03-13 23:11:21',
    '2024-10-05 03:08:54'
  ),
  (
    56,
    0,
    510,
    'Binance',
    'Binance',
    '66f92d4ae66161727606090.png',
    1,
    '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-------------\"}}',
    '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}',
    1,
    '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}',
    NULL,
    NULL,
    '2024-10-14 00:18:37'
  ),
  (
    57,
    0,
    124,
    'SslCommerz',
    'SslCommerz',
    '66f93471b7b9b1727607921.png',
    1,
    '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}',
    '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}',
    0,
    NULL,
    NULL,
    NULL,
    '2024-09-29 05:05:21'
  ),
  (
    58,
    0,
    125,
    'Aamarpay',
    'Aamarpay',
    '66f933390c5201727607609.png',
    0,
    '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}',
    '{\"BDT\":\"BDT\"}',
    0,
    NULL,
    NULL,
    NULL,
    '2024-10-14 06:00:24'
  ),
  (
    60,
    22,
    1001,
    'Mobile Money Transfer',
    'mobile_money_transfer',
    '670e115c4d5251728975196.png',
    1,
    '[]',
    '[]',
    0,
    NULL,
    '<p style=\"margin-bottom: 10px; font-size: 17px; font-weight: bold; font-style: italic;\">Please send the funds to the information provided below. We cannot be held responsible for any errors if the amount is sent to incorrect details. Kindly complete the form after transferring the funds<br><br>Bank information</p><p style=\"font-style: italic;\"></p><p style=\"font-style: italic;\"><span style=\"color: hsl(var(--body-color)); font-size: 0.875rem; background-color: hsl(var(--white)); text-align: var(--bs-body-text-align); display: inline !important;\">Mobile Number:&nbsp;xxx-xxx-</span><span style=\"font-size: 0.875rem; font-weight: var(--bs-body-font-weight); background-color: hsl(var(--white)); text-align: var(--bs-body-text-align); color: rgb(67, 64, 79); display: inline !important;\">xxx-xxx-xxx</span><br></p>',
    '2024-09-25 08:22:40',
    '2024-10-15 00:53:33'
  );

-- --------------------------------------------------------
--
-- Table structure for table `gateway_currencies`
--
CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5, 2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28, 8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `gateways`
--
ALTER TABLE
  `gateways`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE
  `gateway_currencies`
ADD
  PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE
  `gateways`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE
  `gateway_currencies`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

COMMIT;

ALTER TABLE
  `subscription_plans` DROP `frequency`,
  DROP `price`,
  DROP `offer_price`,
  DROP `trial_days`,
  DROP `is_popular`;

ALTER TABLE
  `subscription_plans`
ADD
  `product_limit` INT NOT NULL DEFAULT '0'
AFTER
  `name`,
ADD
  `user_limit` INT NOT NULL DEFAULT '0'
AFTER
  `product_limit`,
ADD
  `warehouse_limit` INT NOT NULL DEFAULT '0'
AFTER
  `user_limit`,
ADD
  `supplier_limit` INT NOT NULL DEFAULT '0'
AFTER
  `warehouse_limit`,
ADD
  `hrm_access` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `supplier_limit`;

ALTER TABLE
  `subscription_plans`
ADD
  `monthly_price` DECIMAL(28, 8) NOT NULL DEFAULT '0'
AFTER
  `hrm_access`,
ADD
  `yearly_price` DECIMAL(28, 8) NOT NULL DEFAULT '0'
AFTER
  `monthly_price`;

ALTER TABLE
  `subscription_plans` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1';

ALTER TABLE
  `subscription_plans` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
add
  PRIMARY KEY (`id`);

ALTER TABLE
  `users`
ADD
  `plan_id` INT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `provider_id`,
ADD
  `plan_expired_at` TIMESTAMP NULL DEFAULT NULL
AFTER
  `plan_id`;

ALTER TABLE
  `users`
ADD
  `product_limit` INT NOT NULL DEFAULT '0'
AFTER
  `plan_expired_at`,
ADD
  `user_limit` INT NOT NULL DEFAULT '0'
AFTER
  `product_limit`,
ADD
  `warehouse_limit` INT NOT NULL DEFAULT '0'
AFTER
  `user_limit`,
ADD
  `supplier_limit` INT NOT NULL DEFAULT '0'
AFTER
  `warehouse_limit`,
ADD
  `hrm_access` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `supplier_limit`;

ALTER TABLE
  `users`
ADD
  `coupon_limit` INT NOT NULL DEFAULT '0'
AFTER
  `hrm_access`;

ALTER TABLE
  `subscription_plans`
ADD
  `coupon_limit` INT NOT NULL DEFAULT '0'
AFTER
  `supplier_limit`;

ALTER TABLE
  `employees`
ADD
  `user_id` INT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `company_id`;

ALTER TABLE
  `departments`
ADD
  `user_id` INT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `company_id`;

ALTER TABLE
  `holidays`
ADD
  `user_id` INT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `company_id`;

ALTER TABLE
  `attendances`
ADD
  `user_id` INT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `company_id`;

ALTER TABLE
  `payment_types` DROP INDEX `payment_types_name_unique`;

ALTER TABLE
  `payment_accounts`
ADD
  `user_id` INT NOT NULL DEFAULT '0'
AFTER
  `payment_type_id`;

ALTER TABLE
  `users`
ADD
  `is_deleted` TIMESTAMP NULL DEFAULT NULL
AFTER
  `coupon_limit`;

ALTER TABLE
  `users` CHANGE `is_deleted` `is_deleted` TINYINT(1) NULL DEFAULT '0';

ALTER TABLE
  `brands` DROP INDEX `brands_name_unique`;

ALTER TABLE
  `payment_types` DROP `slug`;

ALTER TABLE
  `product_details`
ADD
  `user_id` INT NOT NULL DEFAULT '0'
AFTER
  `product_id`;

ALTER TABLE
  `payment_types`
ADD
  `variant` VARCHAR(255) NOT NULL
AFTER
  `name`,
ADD
  `icon` VARCHAR(255) NOT NULL
AFTER
  `variant`;

ALTER TABLE
  `customers` DROP INDEX `customers_email_unique`;

ALTER TABLE
  `customers` DROP INDEX `customers_phone_unique`;

ALTER TABLE
  suppliers DROP INDEX suppliers_company_name_unique;

ALTER TABLE
  suppliers DROP INDEX suppliers_email_unique;

ALTER TABLE
  suppliers DROP INDEX suppliers_phone_unique;

ALTER TABLE
  categories DROP INDEX categories_name_unique;

ALTER TABLE
  units DROP INDEX units_name_unique;

ALTER TABLE
  units DROP INDEX units_short_name_unique;

ALTER TABLE
  attributes DROP INDEX attributes_name_unique;

ALTER TABLE
  expense_categories DROP INDEX expense_categories_name_unique;

ALTER TABLE
  product_details DROP INDEX product_details_sku_unique;

ALTER TABLE
  taxes DROP INDEX taxes_name_unique;

ALTER TABLE
  warehouses DROP INDEX warehouses_name_unique;

ALTER TABLE
  `general_settings`
ADD
  `user_id` INT NOT NULL
AFTER
  `id`;

ALTER TABLE
  `general_settings` CHANGE `user_id` `user_id` INT NULL DEFAULT NULL;

ALTER TABLE
  `general_settings`
ADD
  `logo_light` VARCHAR(255) NULL DEFAULT NULL
AFTER
  `prefix_setting`,
ADD
  `logo_dark` VARCHAR(255) NULL DEFAULT NULL
AFTER
  `logo_light`,
ADD
  `logo_favicon` VARCHAR(255) NULL DEFAULT NULL
AFTER
  `logo_dark`;

ALTER TABLE
  `plan_purchases`
ADD
  `auto_renewal` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `subscription_plan_id`;

ALTER TABLE
  `plan_purchases`
ADD
  `coupon_id` BIGINT UNSIGNED NOT NULL DEFAULT '0'
AFTER
  `user_id`,
ADD
  `recurring_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT ' 1=monthly,2=yearly '
AFTER
  `coupon_id`,
ADD
  `amount` DECIMAL(28, 8) NOT NULL DEFAULT '0'
AFTER
  `recurring_type`,
ADD
  `discount_amount` DECIMAL(28, 8) NOT NULL DEFAULT '0'
AFTER
  `amount`,
ADD
  `payment_method` TINYINT(1) NOT NULL DEFAULT '1' COMMENT ' 1=wallet,2=gateway '
AFTER
  `discount_amount`,
ADD
  `gateway_method_code` INT NOT NULL
AFTER
  `payment_method`;

ALTER TABLE
  `plan_purchases`
ADD
  `expired_at` DATETIME NULL DEFAULT NULL
AFTER
  `auto_renewal`;

ALTER TABLE
  `plan_purchases` DROP `coupon_id`,
  DROP `discount_amount`;

UPDATE
  `staff_permissions`
SET
  `name` = 'invoice setting'
WHERE
  `staff_permissions`.`id` = 94;

INSERT INTO
  `cron_jobs` (
    `id`,
    `name`,
    `alias`,
    `action`,
    `url`,
    `cron_schedule_id`,
    `next_run`,
    `last_run`,
    `is_running`,
    `is_default`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    7,
    'Subscription Expiration Notify',
    'subscription_expired',
    '[\"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\"subscriptionExpired\"]',
    '',
    3,
    '2025-10-13 18:25:06',
    '2025-10-12 18:25:06',
    1,
    1,
    '2024-09-09 03:36:44',
    '2025-10-13 01:25:06'
  ),
  (
    8,
    'Subscription notify ',
    'subscription_notify',
    '[\"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\"subscriptionNotify\"]',
    '',
    3,
    '2025-10-13 18:25:06',
    '2025-10-12 18:25:06',
    1,
    1,
    '2024-09-09 03:36:44',
    '2025-10-13 01:25:06'
  );

ALTER TABLE
  `plan_purchases`
ADD
  `is_sent_expired_notify` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `expired_at`,
ADD
  `is_sent_reminder_notify` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
  `is_sent_expired_notify`;

INSERT INTO
  `notification_templates` (
    `id`,
    `act`,
    `name`,
    `subject`,
    `push_title`,
    `email_body`,
    `sms_body`,
    `push_body`,
    `shortcodes`,
    `email_status`,
    `email_sent_from_name`,
    `email_sent_from_address`,
    `sms_status`,
    `sms_sent_from`,
    `push_status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    NULL,
    'SUBSCRIPTION_EXPIRED',
    'Subscription expired',
    'Subscription has been expired.',
    '{{site_name}} - Subscription expired',
    '<div>We wish to inform you that your&nbsp;&nbsp;<strong data-start=\"186\" data-end=\"218\">{{subscription_type}}&nbsp; </strong><span data-start=\"186\" data-end=\"218\">subscription has&nbsp;&nbsp;</span>been expired.</div><div><br></div><div>Below are the details of the subscription :</div><div><b>Subscription Plan</b> <b>:</b> {{plan_name}}</div><div><b>Billing Cycle :</b>&nbsp;{{subscription_type}}</div><div><b>Expired Date :</b>&nbsp;{{expired_at}}</div><div><span style=\"font-weight: bolder;\">Billing Price :&nbsp;</span>{{amount}}&nbsp;{{site_currency}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>',
    'Test',
    '{{amount}} {{site_currency}} payment done for subscription payment.',
    '{\r\n    \"trx\": \"Transaction number for the action\",\r\n    \"plan_name\": \"The name of the subscription plan\",\r\n    \"expired_at\": \"The expired datetime\",\r\n    \"subscription_url\": \"Redirect URL\",\r\n    \"subscription_type\": \"Yearly or Monthly\",\r\n    \"remark\": \"Remark inserted by the admin\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}',
    '1',
    '{{site_name}} Maintenance',
    NULL,
    '0',
    NULL,
    '0',
    NULL,
    NULL
  );

INSERT INTO
  `notification_templates` (
    `id`,
    `act`,
    `name`,
    `subject`,
    `push_title`,
    `email_body`,
    `sms_body`,
    `push_body`,
    `shortcodes`,
    `email_status`,
    `email_sent_from_name`,
    `email_sent_from_address`,
    `sms_status`,
    `sms_sent_from`,
    `push_status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    NULL,
    'UPCOMING_EXPIRED_SUBSCRIPTION',
    'Subscription expiring notification',
    'Subscription expiration notification.',
    '{{site_name}} - Subscription expiration',
    '<div>\r\n  We wish to inform you that your&nbsp;&nbsp;<strong data-start=\"186\" data-end=\"218\">{{subscription_type}}&nbsp; </strong><span data-start=\"186\" data-end=\"218\">subscription will be expired on&nbsp;</span><span style=\"\r\n      font-weight: bolder;\r\n      background-color: hsl(var(--white));\r\n      font-size: var(--bs-body-font-size);\r\n      text-align: var(--bs-body-text-align);\r\n      display: inline !important;\r\n    \">{{next_billing}}</span><span style=\"\r\n      background-color: hsl(var(--white));\r\n      font-size: var(--bs-body-font-size);\r\n      text-align: var(--bs-body-text-align);\r\n      display: inline !important;\r\n    \">. Kindly renew your subscription to continue enjoying our services.</span>\r\n</div>\r\n<div><br></div>\r\n<div>Below are the details of the subscription :</div>\r\n<div><b>Subscription Plan</b> <b>:</b> {{plan_name}}</div>\r\n<div>\r\n  <span style=\"font-weight: bolder\">Plan Price</span><span style=\"display: inline !important\">&nbsp;</span><span style=\"font-weight: bolder\">:</span><span style=\"display: inline !important\">&nbsp;{{plan_price}}&nbsp;{{site_currency}}</span>\r\n</div>\r\n<div><b>Billing Cycle :</b>&nbsp;{{subscription_type}}</div>\r\n<div><b>Billing Date :</b>&nbsp;{{next_billing}}</div>\r\n<div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div>\r\n<div>\r\n  <b>For renew &nbsp; :&nbsp;&nbsp;</b><a href=\"{{subscription_url}}\" style=\"display: inline !important\">Click here</a>\r\n</div>\r\n<div><br></div>\r\n<div>Thank you for your continued trust in {{site_name}}.</div>',
    'Test',
    '{{amount}} {{site_currency}} payment done for subscription payment.',
    '{\r\n    \"trx\": \"Transaction number for the action\",\r\n    \"plan_name\": \"The name of the subscription plan\",\r\n    \"plan_price\" : \"Price of the plan\",\r\n    \"next_billing\": \"The next billing date\",\r\n    \"subscription_url\": \"Redirect URL\",\r\n    \"expiration_days\": \"Expiration days of the subscription\",\r\n    \"subscription_type\": \"Yearly or Monthly\",\r\n    \"remark\": \"Remark inserted by the admin\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}',
    '1',
    '{{site_name}} Maintenance',
    NULL,
    '0',
    NULL,
    '0',
    NULL,
    NULL
  );

INSERT INTO
  `notification_templates` (
    `id`,
    `act`,
    `name`,
    `subject`,
    `push_title`,
    `email_body`,
    `sms_body`,
    `push_body`,
    `shortcodes`,
    `email_status`,
    `email_sent_from_name`,
    `email_sent_from_address`,
    `sms_status`,
    `sms_sent_from`,
    `push_status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    NULL,
    'UPCOMING_EXPIRED_SUBSCRIPTION',
    'Subscription expiring notification',
    'Subscription expiration notification.',
    '{{site_name}} - Subscription expiration',
    '<div>\r\n  We wish to inform you that your&nbsp;&nbsp;<strong data-start=\"186\" data-end=\"218\">{{subscription_type}}&nbsp; </strong><span data-start=\"186\" data-end=\"218\">subscription will be expired on&nbsp;</span><span style=\"\r\n      font-weight: bolder;\r\n      background-color: hsl(var(--white));\r\n      font-size: var(--bs-body-font-size);\r\n      text-align: var(--bs-body-text-align);\r\n      display: inline !important;\r\n    \">{{next_billing}}</span><span style=\"\r\n      background-color: hsl(var(--white));\r\n      font-size: var(--bs-body-font-size);\r\n      text-align: var(--bs-body-text-align);\r\n      display: inline !important;\r\n    \">. Kindly renew your subscription to continue enjoying our services.</span>\r\n</div>\r\n<div><br></div>\r\n<div>Below are the details of the subscription :</div>\r\n<div><b>Subscription Plan</b> <b>:</b> {{plan_name}}</div>\r\n<div>\r\n  <span style=\"font-weight: bolder\">Plan Price</span><span style=\"display: inline !important\">&nbsp;</span><span style=\"font-weight: bolder\">:</span><span style=\"display: inline !important\">&nbsp;{{plan_price}}&nbsp;{{site_currency}}</span>\r\n</div>\r\n<div><b>Billing Cycle :</b>&nbsp;{{subscription_type}}</div>\r\n<div><b>Billing Date :</b>&nbsp;{{next_billing}}</div>\r\n<div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div>\r\n<div>\r\n  <b>For renew &nbsp; :&nbsp;&nbsp;</b><a href=\"{{subscription_url}}\" style=\"display: inline !important\">Click here</a>\r\n</div>\r\n<div><br></div>\r\n<div>Thank you for your continued trust in {{site_name}}.</div>',
    'Test',
    '{{amount}} {{site_currency}} payment done for subscription payment.',
    '{\r\n    \"trx\": \"Transaction number for the action\",\r\n    \"plan_name\": \"The name of the subscription plan\",\r\n    \"plan_price\" : \"Price of the plan\",\r\n    \"next_billing\": \"The next billing date\",\r\n    \"subscription_url\": \"Redirect URL\",\r\n    \"expiration_days\": \"Expiration days of the subscription\",\r\n    \"subscription_type\": \"Yearly or Monthly\",\r\n    \"remark\": \"Remark inserted by the admin\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}',
    '1',
    '{{site_name}} Maintenance',
    NULL,
    '0',
    NULL,
    '0',
    NULL,
    NULL
  );

ALTER TABLE
  `general_settings`
ADD
  `subscription_notify_before` INT NOT NULL DEFAULT '7' COMMENT 'How many days before the notification will send to user for subscription '
AFTER
  `push_template`;




INSERT INTO `gateway_currencies` (`id`, `name`, `currency`, `symbol`, `method_code`, `gateway_alias`, `min_amount`, `max_amount`, `percent_charge`, `fixed_charge`, `rate`, `gateway_parameter`, `created_at`, `updated_at`) VALUES
(147, 'Bank Wire', 'USD', '', 1001, 'bank_wire', 10.00000000, 100000.00000000, 1.00, 5.00000000, 1.00000000, NULL, '2022-03-30 09:16:43', '2022-07-26 05:57:22'),
(202, 'Bank Transfer', 'USD', '', 1000, 'bank_transfer', 100.00000000, 1000.00000000, 1.00, 1.00000000, 1.00000000, NULL, '2024-03-13 23:11:21', '2024-10-15 00:49:18'),
(269, 'BTCPay - BTC', 'BTC', '₿', 507, 'BTCPay', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"store_id\":\"GLeYKqo2vM1jW9e2aFpGsLqokwTbfpQ3yZFQBRy2um58\",\"api_key\":\"a60a2d61645cddd1f552212ca0f802121e47d08c\",\"server_name\":\"https:\\/\\/testnet.demo.btcpayserver.org\",\"secret_code\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}', '2024-05-07 08:08:13', '2024-10-12 02:37:53'),
(273, 'Checkout - USD', 'USD', '$', 123, 'Checkout', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"secret_key\":\"------\",\"public_key\":\"------\",\"processing_channel_id\":\"------\"}', '2024-05-07 08:09:44', '2024-09-29 04:39:39'),
(276, 'Coingate - USD', 'USD', '$', 505, 'Coingate', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"------------------\"}', '2024-05-07 08:11:37', '2024-10-14 00:19:09'),
(280, 'CoinPayments Fiat - USD', 'USD', '$', 504, 'CoinpaymentsFiat', 1.00000000, 10000.00000000, 10.00, 1.00000000, 10.00000000, '{\"merchant_id\":\"6515561\"}', '2024-05-07 08:12:07', '2024-09-29 04:44:55'),
(281, 'CoinPayments Fiat - AUD', 'AUD', '$', 504, 'CoinpaymentsFiat', 1.00000000, 10000.00000000, 0.00, 1.00000000, 1.00000000, '{\"merchant_id\":\"6515561\"}', '2024-05-07 08:12:07', '2024-09-29 04:44:55'),
(282, 'Flutterwave - USD', 'USD', 'USD', 109, 'Flutterwave', 1.00000000, 2000.00000000, 0.00, 1.00000000, 1.00000000, '{\"public_key\":\"FLWPUBK_TEST-0ee1835b2e1088d2a529356ec7dcdb30-X\",\"secret_key\":\"FLWSECK_TEST-6c5417024ef775a0eabfb021d41369f8-X\",\"encryption_key\":\"FLWSECK_TEST78b28d6fdf42\"}', '2024-05-07 08:12:18', '2024-10-13 01:33:13'),
(284, 'Mercado Pago - USD', 'USD', '$', 119, 'MercadoPago', 1.00000000, 10.00000000, 1.00, 1.00000000, 1.00000000, '{\"access_token\":\"--------------\"}', '2024-05-07 08:19:24', '2024-10-14 00:19:38'),
(287, 'Now payments checkout - USD', 'USD', '$', 509, 'NowPaymentsCheckout', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\",\"secret_key\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}', '2024-05-07 08:20:21', '2024-10-13 02:47:13'),
(288, 'Payeer - USD', 'USD', '$', 106, 'Payeer', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"merchant_id\":\"P1124379867\",\"secret_key\":\"768336\"}', '2024-05-07 08:20:58', '2024-10-13 03:41:46'),
(289, 'Paypal - USD', 'USD', '$', 101, 'Paypal', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"paypal_email\":\"sb-sie1e33346198@business.example.com\"}', '2024-05-07 08:21:11', '2024-10-13 03:59:25'),
(290, 'Paypal Express - USD', 'USD', '$', 113, 'PaypalSdk', 1.00000000, 1000000.00000000, 1.00, 1.00000000, 1.00000000, '{\"clientId\":\"AYq9c_gjnfFiLpWdotm-5XTw-RwtWtBrxIEW7IJGcjmq6cLDcTOjSSVlIqnIq4dYWnxrOEeK7s0UuuCy\",\"clientSecret\":\"ECXn_0gIPEdgVDiPfh-zR3KFm5WfmZe5UvhDrKNNa59i5bTSZ3K4S9QFb9uJNZ-vjBGEwcdKD0SRQsP5\"}', '2024-05-07 08:21:33', '2024-10-13 03:59:51'),
(292, 'PayTM - AUD', 'AUD', '$', 105, 'Paytm', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"MID\":\"-----------\",\"merchant_key\":\"-----------\",\"WEBSITE\":\"-----------\",\"INDUSTRY_TYPE_ID\":\"-----------\",\"CHANNEL_ID\":\"-----------\",\"transaction_url\":\"-----------\",\"transaction_status_url\":\"-----------\"}', '2024-05-07 08:22:07', '2024-10-14 00:19:59'),
(293, 'PayTM - USD', 'USD', '$', 105, 'Paytm', 1.00000000, 10000.00000000, 1.00, 1.00000000, 2.00000000, '{\"MID\":\"-----------\",\"merchant_key\":\"-----------\",\"WEBSITE\":\"-----------\",\"INDUSTRY_TYPE_ID\":\"-----------\",\"CHANNEL_ID\":\"-----------\",\"transaction_url\":\"-----------\",\"transaction_status_url\":\"-----------\"}', '2024-05-07 08:22:07', '2024-10-14 00:19:59'),
(294, 'Perfect Money - USD', 'USD', 'usd', 102, 'PerfectMoney', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"passphrase\":\"h9Rz18d60KeErSFPUViTlTyUX\",\"wallet_id\":\"100\"}', '2024-05-07 08:22:25', '2024-10-13 05:05:23'),
(295, 'RazorPay - INR', 'INR', '$', 110, 'Razorpay', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"key_id\":\"-------------\",\"key_secret\":\"------------\"}', '2024-05-07 08:22:50', '2024-10-14 00:21:41'),
(299, 'Stripe Hosted - USD', 'USD', '$', 103, 'Stripe', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"secret_key\":\"-------------\",\"publishable_key\":\"------------------------\"}', '2024-05-07 08:24:06', '2024-10-09 06:06:36'),
(301, 'Stripe Checkout - USD', 'USD', 'USD', 114, 'StripeV3', 10.00000000, 1000.00000000, 0.00, 1.00000000, 1.00000000, '{\"secret_key\":\"-------------\",\"publishable_key\":\"------------------------\",\"end_point\":\"whsec_VnTLcUcx5bMenhc6P0PZiTR0T6NGs5yF\"}', '2024-05-07 08:24:47', '2024-10-05 00:25:34'),
(302, '2Checkout - USD', 'USD', '$', 122, 'TwoCheckout', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"merchant_code\":\"255237318607\",\"secret_key\":\"tNbET^O0mlJ4QHdAf6W#\"}', '2024-05-07 08:24:57', '2024-10-13 05:40:07'),
(304, 'SslCommerz - BDT', 'BDT', '৳', 124, 'SslCommerz', 1.00000000, 100.00000000, 1.00, 1.00000000, 115.00000000, '{\"store_id\":\"---------\",\"store_password\":\"----------\"}', '2024-05-08 07:34:12', '2024-09-29 05:05:21'),
(309, 'CoinPayments - BTC', 'BTC', '₿', 503, 'Coinpayments', 1.00000000, 10000.00000000, 10.00, 1.00000000, 1.00000000, '{\"public_key\":\"222a8c8825477fbea80812a9d5d70057e4821e43198926daa075fdc08cc98cd6\",\"private_key\":\"6d049b6B91a5eBe2053bb21eAa0DCb60f33790ec96B2342192804b0e9dfFf741\",\"merchant_id\":\"47818ed2d6962bcab1eba829e38ad0c4\"}', '2024-05-08 07:35:24', '2024-10-13 06:14:28'),
(312, 'Binance - BTC', 'BTC', '₿', 510, 'Binance', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"--------------------\",\"secret_key\":\"--------------------\",\"merchant_id\":\"-------------\"}', '2024-05-08 07:36:01', '2024-10-14 00:18:37'),
(314, 'Coinbase Commerce - USD', 'USD', '$', 506, 'CoinbaseCommerce', 1.00000000, 10000.00000000, 10.00, 1.00000000, 1.00000000, '{\"api_key\":\"------------------\",\"secret\":\"-------------\"}', '2024-05-08 07:41:51', '2024-10-14 00:18:55'),
(315, 'Instamojo - INR', 'INR', '₹', 112, 'Instamojo', 1.00000000, 10000.00000000, 1.00, 1.00000000, 85.00000000, '{\"api_key\":\"--------------\",\"auth_token\":\"----------------\",\"salt\":\"------------\"}', '2024-05-08 07:42:57', '2024-10-14 00:19:23'),
(316, 'Now payments hosted - BTC', 'BTC', '₿', 508, 'NowPaymentsHosted', 1.00000000, 1000.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\",\"secret_key\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}', '2024-05-08 07:43:55', '2024-10-13 02:56:13'),
(318, 'PayStack - NGN', 'NGN', '₦', 107, 'Paystack', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1420.00000000, '{\"public_key\":\"pk_test_7a71410e62ae07cad950d94e4a3827b974937450\",\"secret_key\":\"sk_test_e8cf00c8c7fc173b60f02199e2752e2f34e50494\"}', '2024-05-08 07:44:50', '2024-10-13 04:19:28'),
(327, 'Authorize.net - USD', 'USD', '$', 120, 'Authorize', 1.00000000, 10.00000000, 1.00, 1.00000000, 1.00000000, '{\"login_id\":\"59e4P9DBcZv\",\"transaction_key\":\"47x47TJyLw2E7DbR\"}', '2024-09-25 04:57:07', '2024-09-29 04:37:21'),
(330, 'Perfect Money - EUR', 'EUR', '$', 102, 'PerfectMoney', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"passphrase\":\"h9Rz18d60KeErSFPUViTlTyUX\",\"wallet_id\":\"200\"}', '2024-09-25 07:23:23', '2024-10-13 05:05:23'),
(331, 'Mobile Money Transfer', 'USD', '', 1001, 'mobile_money_transfer', 10.00000000, 10000.00000000, 2.00, 2.00000000, 1.00000000, NULL, '2024-09-25 08:22:40', '2024-10-15 00:53:17'),
(333, 'Binance - BNB', 'BNB', 'BNB', 510, 'Binance', 1.00000000, 100.00000000, 1.00, 1.00000000, 0.00170000, '{\"api_key\":\"--------------------\",\"secret_key\":\"--------------------\",\"merchant_id\":\"-------------\"}', '2024-10-09 06:01:52', '2024-10-14 00:18:37'),
(334, 'Stripe Hosted - JPY', 'JPY', 'JPY', 103, 'Stripe', 1.00000000, 1000000.00000000, 1.00, 1.00000000, 148.71000000, '{\"secret_key\":\"-------------\",\"publishable_key\":\"------------------------\"}', '2024-10-09 06:06:36', '2024-10-09 06:06:36');


ALTER TABLE `deposits` CHANGE `subscription_plan_id` `plan_id` INT NULL DEFAULT '0';
ALTER TABLE `deposits` ADD `plan_recurring_type` TINYINT(1) NOT NULL DEFAULT '1' AFTER `plan_id`;
ALTER TABLE `plan_purchases`DROP `status`;


 
ALTER TABLE `cron_jobs`ADD PRIMARY KEY (`id`);

ALTER TABLE `cron_jobs` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `cron_job_logs`ADD PRIMARY KEY (`id`);

ALTER TABLE `cron_job_logs` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `cron_schedules`ADD PRIMARY KEY (`id`);
ALTER TABLE `cron_schedules` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deposits`ADD PRIMARY KEY (`id`);
ALTER TABLE `deposits` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `plan_purchases`ADD PRIMARY KEY (`id`);
ALTER TABLE `plan_purchases` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `staff_has_permissions`ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_has_permissions` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


INSERT INTO `users` (
    `firstname`, `username`, `email`, `password`, `ev`,`sv`,`kv`,`profile_complete`
)
SELECT 
    `name`,
    `username`,
    `email`,
    `password`,
    1 AS `ev`,
    1 AS `sv`,
    1 AS `kv`,
    1 AS `profile_complete`
FROM `admins`
WHERE `id` = 1;



-- Update user_id = 1 in all related tables
UPDATE `attendances` SET `user_id` = 1;
UPDATE `attributes` SET `user_id` = 1;
UPDATE `brands` SET `user_id` = 1;
UPDATE `categories` SET `user_id` = 1;
UPDATE `companies` SET `user_id` = 1;
UPDATE `coupons` SET `user_id` = 1;
UPDATE `customers` SET `user_id` = 1;
UPDATE `departments` SET `user_id` = 1;
UPDATE `designations` SET `user_id` = 1;
UPDATE `employees` SET `user_id` = 1;
UPDATE `expenses` SET `user_id` = 1;
UPDATE `expense_categories` SET `user_id` = 1;
UPDATE `holidays` SET `user_id` = 1;
UPDATE `leave_requests` SET `user_id` = 1;
UPDATE `leave_types` SET `user_id` = 1;
UPDATE `payment_accounts` SET `user_id` = 1;
UPDATE `payment_types` SET `user_id` = 1;
UPDATE `payrolls` SET `user_id` = 1;
UPDATE `products` SET `user_id` = 1;
UPDATE `purchases` SET `user_id` = 1;
UPDATE `product_details` SET `user_id` = 1;
UPDATE `sales` SET `user_id` = 1;
UPDATE `suppliers` SET `user_id` = 1;
UPDATE `customers` SET `user_id` = 1;
UPDATE `taxes` SET `user_id` = 1;
UPDATE `warehouses` SET `user_id` = 1;
UPDATE `transactions` SET `user_id` = 1;

UPDATE `payment_types`
SET 
    `variant` = 'primary',
    `icon` = '<i class="fas fa-hand-holding-usd"></i>'
WHERE `id` = 1;

UPDATE `payment_types`
SET 
    `variant` = 'success',
    `icon` = '<i class="far fa-credit-card"></i>'
WHERE `id` = 2;

UPDATE `payment_types`
SET 
    `variant` = 'info',
    `icon` = '<i class="fas fa-university"></i>'
WHERE `id` = 3;

ALTER TABLE `transactions` ADD `is_pos_transaction` TINYINT(1) NOT NULL DEFAULT '1' AFTER `remark`; 
ALTER TABLE `general_settings` ADD `timezone` TEXT NULL DEFAULT NULL AFTER `logo_favicon`; 


ALTER TABLE `staff_permissions` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`); 
ALTER TABLE `sales` CHANGE `admin_id` `sale_by` INT UNSIGNED NOT NULL DEFAULT '0'; 
ALTER TABLE `purchases` CHANGE `admin_id` `purchase_by` INT UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `stock_transfers` ADD `added_by` INT NOT NULL DEFAULT '0' AFTER `user_id`;  
ALTER TABLE admin_activities RENAME TO user_activities;
ALTER TABLE `transactions` ADD `payment_type_id` INT NOT NULL DEFAULT '0' AFTER `payment_account_id`;
ALTER TABLE `support_tickets` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `users` ADD `image` TEXT NULL DEFAULT NULL AFTER `coupon_limit`; 

ALTER TABLE `carts` CHANGE `admin_id` `user_id` INT UNSIGNED NOT NULL DEFAULT '0'; 
ALTER TABLE `user_activities` CHANGE `admin_id` `user_id` INT UNSIGNED NOT NULL DEFAULT '0'; 



-- ======== frontend table =====


CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"social_title\":\"OvoSale - Complete Cross-Platform POS Solution | Android & iOS Mobile Apps, Web, PWA-Desktop | Saas\",\"keywords\":[\"OvoSale\",\"SaaS POS\",\"cross-platform POS\",\"Android POS app\",\"iOS POS app\",\"web POS\",\"PWA desktop POS\",\"retail management software\",\"inventory management\",\"sales tracking\",\"multi-device POS\",\"point of sale software\",\"SaaS retail solution\"],\"description\":\"OvoSale is a complete cross-platform POS and SaaS solution for retail businesses. Manage sales, inventory, staff, and customers seamlessly on Android, iOS, web, and PWA-enabled desktops. Ideal for small shops, growing stores, and SaaS entrepreneurs.\",\"social_description\":\"Discover OvoSale \\u2013 a powerful SaaS and cross-platform POS solution for mobile, web, and desktop. Simplify sales, inventory, and customer management while scaling your retail or SaaS business efficiently.\",\"image\":\"6927fbb3685011764228019.png\"}', NULL, NULL, '', '2020-07-03 23:42:52', '2025-11-27 01:20:19'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"Latest News\",\"subheading\":\"11\",\"description\":\"fdg sdfgsdf g ggg\",\"about_icon\":\"<i class=\\\"las la-address-card\\\"><\\/i>\",\"background_image\":\"60951a84abd141620384388.png\",\"about_image\":\"5f9914e907ace1603867881.jpg\"}', NULL, 'basic', '', '2020-10-27 00:51:20', '2024-09-09 07:37:23'),
(25, 'blog.content', '{\"heading\":\"Blog, News & Updates\",\"subheading\":\"Explore tips, insights, and product updates to help you grow, manage, and scale your retail or SaaS POS business smarter with OvoSale.\"}', NULL, 'basic', '', '2020-10-27 00:51:34', '2025-11-26 04:54:41'),
(27, 'contact_us.content', '{\"has_image\":\"1\",\"email_address\":\"info@ovosale.com\",\"contact_address\":\"212 E International Airport Rd, USA\",\"contact_number\":\"(907) 562-2511\",\"image\":\"692710c50afe71764167877.png\"}', NULL, 'basic', '', '2020-10-27 00:59:19', '2025-11-26 08:37:57'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2020-10-27 01:04:02', '2024-10-07 05:16:28'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-square\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', NULL, 'basic', '', '2020-11-11 04:07:30', '2025-10-21 21:05:58'),
(33, 'feature.content', '{\"heading\":\"Powerful Features for Your Business\",\"subheading\":\"Tools designed to make sales, inventory, supplier, purchhase , staff and customer management easier.\"}', NULL, 'basic', '', '2021-01-02 23:40:54', '2025-11-23 03:14:12'),
(36, 'service.content', '{\"heading\":\"OvoSale for Every Retail Store\",\"subheading\":\"Whether it\\u2019s a clothing store, hardware shop, supermarket, gadget store, or grocery shop, OvoSale has the tools to manage your business efficiently.\"}', NULL, 'basic', '', '2021-03-05 01:27:34', '2025-11-23 03:18:21'),
(41, 'cookie.data', '{\"short_desc\":\"We may utilize cookies when you access our website, including any related media platforms or mobile applications. These technologies are employed to enhance site functionality and optimize your interactions with our services.\",\"description\":\"<div>\\r\\n    <h4>What Are Cookies?<\\/h4>\\r\\n    <p>Cookies are small data files that are placed on your computer or mobile device when you visit a website. These\\r\\n        files contain information that is transferred to your device\\u2019s hard drive. Cookies are widely used by website\\r\\n        owners for various purposes: they help websites function properly by enabling essential features such as page\\r\\n        navigation and access to secure areas; they improve efficiency by remembering your preferences and actions over\\r\\n        time, such as login details and language settings, so you don\\u2019t have to re-enter them each time you visit; they\\r\\n        provide reporting information that helps website owners understand how their site is being used, including data\\r\\n        on page visits, duration of visits, and any errors that occur, which is crucial for improving site performance\\r\\n        and user experience; they personalize your experience by remembering your preferences and tailoring content to\\r\\n        your interests, including showing relevant advertisements or recommendations based on your browsing history; and\\r\\n        they enhance security by detecting fraudulent activity and protecting your data from unauthorized access. By\\r\\n        using cookies, website owners can enhance the overall functionality and efficiency of their sites, providing a\\r\\n        better experience for their users.<\\/p>\\r\\n    <p><br><\\/p>\\r\\n<\\/div>\\r\\n\\r\\n<div>\\r\\n    <h4>Why Do We Use Cookies?<\\/h4>\\r\\n    <p>We use cookies for several reasons. Some cookies are required for technical reasons for our website to operate,\\r\\n        and we refer to these as \\u201cessential\\u201d or \\u201cstrictly necessary\\u201d cookies. These essential cookies are crucial for\\r\\n        enabling basic functions like page navigation, secure access to certain areas, and ensuring the overall\\r\\n        functionality of the site. Without these cookies, the website cannot perform properly.<\\/p>\\r\\n    <p>Other cookies enable us to track and target the interests of our users to enhance the experience on our website.\\r\\n        These cookies help us understand your preferences and behaviors, allowing us to tailor content and features to\\r\\n        better suit your needs. For example, they can remember your login details, language preferences, and other\\r\\n        customizable settings, providing a more personalized and efficient browsing experience.<br><\\/p>\\r\\n    <p><br><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h4>Types of Cookies We Use<\\/h4>\\r\\n    <p>\\r\\n    <\\/p>\\r\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Essential Cookies<\\/strong>\\r\\n            <span>These cookies are necessary for the website to function and cannot be switched off in our systems.\\r\\n                They are usually only set in response to actions made by you which amount to a request for services,\\r\\n                such as setting your privacy preferences, logging in, or filling in forms.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Performance and Functionality Cookies<\\/strong>\\r\\n            <span>These cookies are used to enhance the performance and functionality of our website but are\\r\\n                non-essential to its use. However, without these cookies, certain functionality may become\\r\\n                unavailable.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Analytics and Customization Cookies <\\/strong>\\r\\n            <span>These cookies collect information that is used either in aggregate form to help us understand how our\\r\\n                website is being used or how effective our marketing campaigns are, or to help us customize our website\\r\\n                for you.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Advertising Cookies<\\/strong>\\r\\n            <span>These cookies are used to make advertising messages more relevant to you. They perform functions like\\r\\n                preventing the same ad from continuously reappearing, ensuring that ads are properly displayed for\\r\\n                advertisers, and in some cases selecting advertisements that are based on your interests.<\\/span>\\r\\n        <\\/li><\\/ul>\\r\\n    <p><\\/p>\\r\\n<\\/div>\\r\\n<br>\\r\\n\\r\\n<div>\\r\\n    <h4>Your Choices Regarding Cookies<\\/h4>\\r\\n    <p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by\\r\\n        clicking on the appropriate opt-out links provided in the cookie banner. This banner typically appears when you\\r\\n        first visit our website and allows you to choose which types of cookies you are comfortable with. You can also\\r\\n        set or amend your web browser controls to accept or refuse cookies. Most web browsers provide settings that\\r\\n        allow you to manage or delete cookies, and you can usually find these settings in the \\u201coptions\\u201d or \\u201cpreferences\\u201d\\r\\n        menu of your browser.<\\/p>\\r\\n    <p><br><\\/p>\\r\\n    <p>If you choose to reject cookies, you may still use our website, though your access to some functionality and\\r\\n        areas of our website may be restricted. For example, certain features that rely on cookies to remember your\\r\\n        preferences or login details may not work properly. Additionally, rejecting cookies may impact the\\r\\n        personalization of your experience, as we use cookies to tailor content and advertisements to your interests.\\r\\n        Despite these limitations, we respect your right to control your cookie preferences and strive to provide a\\r\\n        functional and enjoyable browsing experience regardless of your choices.<\\/p>\\r\\n<\\/div>\\r\\n<br>\\r\\n\\r\\n<div>\\r\\n    <h4>Contact Us\\r\\n    <\\/h4>\\r\\n    <p>\\r\\n        If you have any questions about our use of cookies or other technologies, please contact <a href=\\\"contact\\\"><strong> with us<\\/strong><\\/a>. Our team is available to assist you with any inquiries or concerns you may have\\r\\n        regarding our cookie policy. We value your privacy and are committed to ensuring that your experience on our\\r\\n        website is transparent and satisfactory.\\r\\n    <\\/p>\\r\\n<\\/div>\\r\\n<br><br>\",\"status\":1}', NULL, NULL, NULL, '2020-07-03 23:42:52', '2024-09-18 04:51:09'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div>\\r\\n    <h4>Privacy Policy<\\/h4>\\r\\n    <p>This Privacy Policy outlines how we collect, use, disclose, and protect your personal information when you visit\\r\\n        our website. By accessing or using our website, you agree to the terms of this Privacy Policy\\r\\n        and consent to the collection and use of your information as described herein.\\r\\n        We are committed to ensuring that your privacy is protected. Should we ask you to provide certain information by\\r\\n        which you can be identified when using this website, you can be assured that it will only be used in accordance\\r\\n        with this Privacy Policy. We regularly review our compliance with this policy and ensure that all data handling\\r\\n        practices are transparent and secure.\\r\\n    <\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4> Information We Collect<\\/h4>\\r\\n    <p>We collect personal information such as names, email addresses, \\r\\nand browsing data to enhance user experience and provide personalized \\r\\nservices. This data helps us understand user preferences and improve our\\r\\n offerings. Your privacy is important to us, and we ensure that all \\r\\ninformation is handled with strict confidentiality.<\\/p>\\r\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>Personal Information:<\\/span>\\r\\n            <span>Name, email address, phone number, and other contact details.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>Usage Data:<\\/span>\\r\\n            <span>Information about how you use our website, including your IP address, browser type, and pages\\r\\n                visited.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>Cookies and Tracking technology:<\\/span>\\r\\n            <span> We use cookies to enhance your experience on our website. You can manage your cookie preferences\\r\\n                through your browser settings.<\\/span>\\r\\n        <\\/li><\\/ul>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>How We Use Your Information<\\/h4>\\r\\n    <p>We use your information to provide and improve our services, \\r\\nensuring a personalized experience tailored to your needs. This includes\\r\\n processing transactions, communicating updates, and responding to \\r\\ninquiries. Additionally, we use your data for analytical purposes to \\r\\nenhance our offerings and for security measures to protect against \\r\\nfraud.<\\/p>\\r\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>To provide and maintain our services.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>To improve and personalize your experience on our website.\\r\\n            <\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>To communicate with you, including sending updates and promotional materials.\\r\\n            <\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <span>\\r\\n                To analyze website usage and improve our services.\\r\\n            <\\/span>\\r\\n        <\\/li><\\/ul>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n\\r\\n<div>\\r\\n    <h4>Sharing Your Information<\\/h4>\\r\\n    <p>\\r\\n        We do not sell, trade, or otherwise transfer your personal information to outside parties except as described in\\r\\n        this Privacy Policy. We take reasonable steps to ensure that any third parties with whom we share your personal\\r\\n        information are bound by appropriate confidentiality and security obligations regarding your personal\\r\\n        information.\\r\\n\\r\\n        We understand the importance of maintaining the privacy and security of your personal information. Therefore, we\\r\\n        implement stringent measures to protect your data from unauthorized access, use, or disclosure. Our commitment\\r\\n        to safeguarding your privacy includes:\\r\\n\\r\\n    <\\/p><ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Data Encryption<\\/strong>\\r\\n            <span>We use advanced encryption technologies to protect your personal information during transmission and\\r\\n                storage. This ensures that your data is secure and inaccessible to unauthorized parties.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Access Controls<\\/strong>\\r\\n            <span>We restrict access to your personal information to only those employees, contractors, and agents who\\r\\n                need to know that information to process it on our behalf. These individuals are subject to strict\\r\\n                confidentiality obligations and may be disciplined or terminated if they fail to meet these\\r\\n                obligations.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Regular Audits<\\/strong>\\r\\n            <span>We conduct regular audits of our data handling practices and security measures to ensure compliance\\r\\n                with this Privacy Policy and applicable laws. This helps us identify and address any potential\\r\\n                vulnerabilities in our systems.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Incident Response<\\/strong>\\r\\n            <span>n the unlikely event of a data breach, we have established procedures to respond promptly and\\r\\n                effectively. We will notify you and any relevant authorities as required by law and take all necessary\\r\\n                steps to mitigate the impact of the breach.<\\/span>\\r\\n        <\\/li><\\/ul>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<br \\/>\\r\\n\\r\\n<div>\\r\\n    <h4>Contact Us\\r\\n    <\\/h4>\\r\\n    <p>\\r\\n        If you have any questions about our privacy & policy, please contact\\u00a0<a href=\\\"\\/contact\\\"><strong>with us<\\/strong><\\/a>. Our team is available to assist you with any inquiries or\\r\\n        concerns you may have\\r\\n        regarding our privacy & policy. We value your privacy and are committed to ensuring that your experience on our\\r\\n        website is transparent and satisfactory.\\r\\n    <\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\"}', '{\"image\":null,\"description\":null,\"social_title\":null,\"social_description\":null,\"keywords\":null}', 'basic', 'privacy-policy', '2021-06-08 08:50:42', '2024-10-05 03:10:26'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div>\\r\\n    <h4>Terms and Conditions<\\/h4>\\r\\n    <p>By accessing this website, you agree to be bound by these Terms and Conditions of Use, along with all applicable laws and regulations. You are responsible for compliance with any local laws that may apply. If you do not agree with any of these terms, you are prohibited from using or accessing this site.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Customer Support<\\/h4>\\r\\n    <p>After purchasing or downloading our product, you can reach out for support via email. We will make every effort to resolve your issue and may provide smaller fixes through email correspondence, followed by updates to the core package. Verified users can access content support through our ticketing system, as well as via email and live chat.<\\/p>\\r\\n    <p>If your request requires additional modifications to the system, you have two options:<\\/p>\\r\\n    <ul>\\r\\n        <li>Wait for the next update release.<\\/li>\\r\\n        <li>Hire an expert (customizations are available for an additional fee).<\\/li>\\r\\n    <\\/ul>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Intellectual Property Ownership<\\/h4>\\r\\n    <p>You cannot claim intellectual or exclusive ownership of any of our products, whether modified or unmodified. All products remain the property of our organization. Our products are provided \\\"as-is\\\" without any warranty, express or implied. Under no circumstances shall we be liable for any damages, including but not limited to direct, indirect, incidental, or consequential damages arising from the use or inability to use our products.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Product Warranty Disclaimer<\\/h4>\\r\\n    <p>We do not offer any warranty or guarantee for our services. Once our services have been modified, we cannot guarantee compatibility with third-party plugins, modules, or web browsers. Browser compatibility should be tested using the demo templates. Please ensure the browsers you use are compatible, as we cannot guarantee functionality across all browser combinations.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Prohibited and Illegal Use<\\/h4>\\r\\n    <p>You may not use our products for any illegal or unauthorized purposes, nor may you violate any laws in your jurisdiction (including but not limited to copyright laws), as well as the laws of your country and international laws. The use of our platform for pages that promote violence, terrorism, explicit adult content, racism, offensive material, or illegal software is strictly prohibited.<\\/p>\\r\\n    <p>It is prohibited to reproduce, duplicate, copy, sell, trade, or exploit any part of our products without our express written permission or the product owner\'s consent.<\\/p>\\r\\n    <p>Our members are responsible for all content posted on forums and demos, as well as any activities that occur under their account. We reserve the right to block your account immediately if we detect any prohibited behavior.<\\/p>\\r\\n    <p>If you create an account on our site, you are responsible for maintaining the security of your account and all activities that occur under it. You must notify us immediately of any unauthorized use or security breaches.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Payment and Refund Policy<\\/h4>\\r\\n    <p>Refunds or cashback will not be issued. Once a deposit is made, it is non-reversible. You must use your balance to purchase our services, such as hosting or SEO campaigns. By making a deposit, you agree not to file a dispute or chargeback against us.<\\/p>\\r\\n    <p>If a dispute or chargeback is filed after making a deposit, we reserve the right to terminate all future orders and ban you from our site. Fraudulent activities, such as using unauthorized or stolen credit cards, will result in account termination without exceptions.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Free Balance and Coupon Policy<\\/h4>\\r\\n    <p>We offer multiple ways to earn free balance, coupons, and deposit offers, but we reserve the right to review and deduct these balances if we believe there is any form of misuse. If we deduct your free balance and your account balance becomes negative, your account will be suspended. To reactivate a suspended account, you must make a custom payment to settle your balance.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\\r\\n<div>\\r\\n    <h4>Contact Information<\\/h4>\\r\\n    <p>If you have any questions about our Terms of Service, please contact us through <a href=\\\"\\/contact\\\"><strong>this link<\\/strong><\\/a>. Our team is available to assist you with any inquiries or concerns regarding our Terms of Service. We are committed to ensuring that your experience on our platform is secure and satisfactory.<\\/p>\\r\\n<\\/div>\\r\\n<br \\/>\"}', '{\"image\":\"6635d5d9618e71714804185.png\",\"description\":null,\"social_title\":null,\"social_description\":null,\"keywords\":null}', 'basic', 'terms-of-service', '2021-06-08 08:51:18', '2024-10-05 03:09:40'),
(44, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"margin-bottom: 3rem !important;\\\">\\r\\n    <h3 class=\\\"mb-3\\\" style=\\\"text-align: center;\\\">\\r\\n        <font color=\\\"#ff0000\\\" face=\\\"Exo, sans-serif\\\"><span style=\\\"font-size: 24px;\\\">SITE UNDER MAINTENANCE<\\/span><\\/font>\\r\\n    <\\/h3>\\r\\n    <div class=\\\"mb-3\\\">\\r\\n        <p>Our site is currently undergoing scheduled maintenance to enhance performance and ensure a smoother\\r\\n            experience for you. During this time, some features may be temporarily unavailable. We are committed to\\r\\n            completing this update as quickly as possible. Thank you for your patience and understanding as we work to\\r\\n            improve your experience. Please check back oon for further updates.<\\/p>\\r\\n    <\\/div>\\r\\n<\\/div>\",\"image\":\"68fe005d2962d1761476701.png\"}', NULL, NULL, NULL, '2020-07-03 23:42:52', '2025-10-25 23:05:02'),
(55, 'counter.content', '{\"heading\":\"Latest Newsss\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-20 01:13:50', '2024-04-20 01:13:50'),
(56, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-20 01:13:52', '2024-04-20 01:13:52'),
(60, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\"}', NULL, 'basic', '', '2024-04-24 06:35:35', '2024-04-24 06:35:35'),
(61, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', '', '2024-04-24 06:40:29', '2024-04-24 06:40:29'),
(64, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Run your Retail Smarter with OvoSale\",\"description\":\"Take full control of your retail business with OvoSale \\u2013 manage sales, track inventory, and serve your customers better.\",\"button_name\":\"Get Started Now\",\"button_url\":\"user\\/register\",\"image_one\":\"691f18303ce441763645488.png\",\"image_two\":\"691f18322c61a1763645490.png\",\"image_three\":\"691f18328eef21763645490.png\"}', NULL, 'basic', '', '2024-04-30 00:06:45', '2025-11-23 03:11:18'),
(66, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Page you are looking for doesn\'t exit or an other error occurred or temporarily unavailable.\",\"button_name\":\"Go to Home\",\"button_url\":\"#\",\"image\":\"69230103d082b1763901699.png\"}', NULL, 'basic', '', '2024-05-06 05:23:12', '2025-11-23 06:41:39'),
(68, 'faq.content', '{\"heading\":\"Frequently Asked Questions\",\"subheading\":\"Yes, our POS works on mobile, web, and PWA, allowing seamless access across different devices.\",\"button_name\":\"Have a question?\",\"button_url\":\"contact\",\"footer_title\":\"Still have questions?\",\"footer_subtitle\":\"Can\'t find the answer you are looking for? Please chat to our friendly team.\"}', NULL, 'basic', '', '2024-09-10 00:52:59', '2025-11-26 04:52:49'),
(69, 'counter.element', '{\"title\":\"Nesciunt excepteur\",\"counter_digit\":\"Excepturi atque solu\",\"sub_title\":\"Fugiat qui officia p\",\"counter_icon\":\"<i class=\\\"fab fa-accusoft\\\"><\\/i>\",\"counter_icon_2\":\"<i class=\\\"fab fa-accessible-icon\\\"><\\/i>\"}', NULL, 'basic', '', '2024-10-07 05:04:22', '2024-10-07 05:16:14'),
(70, 'social_icon.element', '{\"title\":\"Instagram\",\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', NULL, 'basic', '', '2025-10-21 21:06:44', '2025-10-21 21:06:44'),
(71, 'social_icon.element', '{\"title\":\"X\",\"social_icon\":\"<i class=\\\"fa-brands fa-x-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/x.com\\/\"}', NULL, 'basic', '', '2025-10-21 21:07:43', '2025-10-21 21:07:43'),
(72, 'social_icon.element', '{\"title\":\"Linkedin\",\"social_icon\":\"<i class=\\\"fab fa-linkedin\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', NULL, 'basic', '', '2025-10-21 21:08:19', '2025-10-21 21:08:19'),
(73, 'footer.content', '{\"title\":\"OvoSale is a SaaS POS platform that helps retailers manage their business from anywhere, with real-time insights, device flexibility, and scalable plans\",\"subscribe_title\":\"Subscribe to our newsletter to receive updates, exclusive offers directly.\"}', NULL, 'basic', '', '2025-10-21 21:12:29', '2025-11-26 05:04:31'),
(74, 'client.content', '{\"title\":\"Our Partners\",\"heading\":\"Our High-level Partners\",\"description\":\"We cooperate with top partners and provide access to over 1m properties in 180 countries.\",\"has_image\":\"1\",\"image\":\"68f8a837665a81761126455.png\"}', NULL, 'basic', '', '2025-10-21 21:47:35', '2025-10-21 21:47:35'),
(75, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a85064fc31761126480.png\"}', NULL, 'basic', '', '2025-10-21 21:48:00', '2025-10-21 21:48:00'),
(76, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a85736ecc1761126487.png\"}', NULL, 'basic', '', '2025-10-21 21:48:07', '2025-10-21 21:48:07'),
(77, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a85e0d7db1761126494.png\"}', NULL, 'basic', '', '2025-10-21 21:48:14', '2025-10-21 21:48:14'),
(78, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a865bad371761126501.png\"}', NULL, 'basic', '', '2025-10-21 21:48:21', '2025-10-21 21:48:21'),
(79, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a86da8d261761126509.png\"}', NULL, 'basic', '', '2025-10-21 21:48:29', '2025-10-21 21:48:29'),
(80, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a876044221761126518.png\"}', NULL, 'basic', '', '2025-10-21 21:48:38', '2025-10-21 21:48:38'),
(81, 'client.element', '{\"has_image\":\"1\",\"image\":\"68f8a880b12db1761126528.png\"}', NULL, 'basic', '', '2025-10-21 21:48:48', '2025-10-21 21:48:48'),
(85, 'how_it_work.content', '{\"title\":\"How to Start\",\"heading\":\"How to Start?\",\"subheading\":\"Yes, our POS works on mobile, web, and PWA, allowing seamless access across different devices.\"}', NULL, 'basic', '', '2025-10-21 22:04:53', '2025-10-21 22:04:53'),
(86, 'how_it_work.element', '{\"has_image\":\"1\",\"heading\":\"Sign Up\",\"description\":\"Track and manage all sales and purchases in real-time with automated invoicing and order tracking.\",\"image\":\"68f8ac75024ab1761127541.png\"}', NULL, 'basic', '', '2025-10-21 22:05:41', '2025-10-21 22:07:08'),
(87, 'how_it_work.element', '{\"has_image\":\"1\",\"heading\":\"Create Your Store\",\"description\":\"Track and manage all sales and purchases in real-time with automated invoicing and order tracking.\",\"image\":\"68f8ac87a51451761127559.png\"}', NULL, 'basic', '', '2025-10-21 22:05:59', '2025-10-21 22:06:58'),
(88, 'how_it_work.element', '{\"has_image\":\"1\",\"heading\":\"Start Your Business\",\"description\":\"Track and manage all sales and purchases in real-time with automated invoicing and order tracking.\",\"image\":\"68f8aca0f27871761127584.png\"}', NULL, 'basic', '', '2025-10-21 22:06:24', '2025-10-21 22:06:43'),
(89, 'pricing.content', '{\"heading\":\"Simple, Transparent Pricing\",\"subheading\":\"Pick the plan that fits your business. Manage sales, inventory, and staff with OvoSale \\u2013 your all-in-one retail POS.\"}', NULL, 'basic', '', '2025-10-21 22:09:54', '2025-11-23 03:35:29'),
(90, 'cta.content', '{\"heading\":\"Ready to Power Your Business with OvoSale?\",\"description\":\"Try OvoSale free \\u2014 and discover how simple retail can be.\",\"button_one_name\":\"Get Started\",\"button_one_url\":\"user\\/register\",\"button_two_name\":\"Download App\",\"button_two_url\":\"#\",\"has_image\":\"1\",\"image\":\"69230b8123d271763904385.png\"}', NULL, 'basic', '', '2025-10-21 22:14:28', '2025-11-26 04:57:16'),
(91, 'cta.element', '{\"title\":\"Satisfied Customers\",\"counter_digit\":\"2\",\"counter_suffix\":\"M\"}', NULL, 'basic', '', '2025-10-21 22:15:43', '2025-10-21 22:15:43'),
(92, 'cta.element', '{\"title\":\"Customers Everyday\",\"counter_digit\":\"100\",\"counter_suffix\":\"None\"}', NULL, 'basic', '', '2025-10-21 22:16:12', '2025-10-21 22:17:35'),
(93, 'cta.element', '{\"title\":\"Customers Everyday\",\"counter_digit\":\"200\",\"counter_suffix\":\"None\"}', NULL, 'basic', '', '2025-10-21 22:16:49', '2025-10-21 22:16:49'),
(94, 'cta.element', '{\"title\":\"Yearly Transactions\",\"counter_digit\":\"5\",\"counter_suffix\":\"M\"}', NULL, 'basic', '', '2025-10-21 22:17:06', '2025-10-21 22:17:06'),
(95, 'testimonial.content', '{\"heading\":\"Trusted by Retailers Worldwide\",\"subheading\":\"OvoSale is trusted by retailers of all sizes across the globe to manage their sales, inventory, and staff efficiently.\"}', NULL, 'basic', '', '2025-10-21 22:22:12', '2025-11-23 04:00:05'),
(96, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Ahmed Enterprise\",\"designation\":\"Senior Accountant, BlueWave Trading Co.\",\"description\":\"\\u201cFinancial transparency has improved drastically since we started using OvoSale. Payment management, expenses, and transaction history are clean and well-organized.\\u201d\",\"rating\":\"5\",\"thumb\":\"692712c3574ba1764168387.png\"}', NULL, 'basic', '', '2025-10-21 22:23:25', '2025-11-26 08:49:55'),
(97, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Marcus Rashford\",\"designation\":\"Technical Lead, HyperLink Retail Solutions\",\"description\":\"\\u201cOvoSale integrates smoothly with our workflows. The extension management and admin controls are top-notch. It\\u2019s one of the most flexible POS systems we\\u2019ve tested.\\u201d\",\"rating\":\"5\",\"thumb\":\"6926eadab846b1764158170.jpg\"}', NULL, 'basic', '', '2025-10-21 22:24:00', '2025-11-26 08:50:04'),
(98, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Linda Cruz\",\"designation\":\"HR & Admin Supervisor, Sunbeam Electronics\",\"description\":\"\\u201cThe leave request and payroll features make HR tasks so much easier. OvoSale isn\\u2019t just a POS \\u2014 it\\u2019s a full business management system.\\u201d\",\"rating\":\"5\",\"thumb\":\"6927129f08c701764168351.png\"}', NULL, 'basic', '', '2025-10-21 22:24:35', '2025-11-26 08:50:18'),
(99, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Ravi Teja\",\"designation\":\"IT Administrator, Metro Wholesale Depot\",\"description\":\"\\u201cWe switched to OvoSale for better control of stock and supplier management. The warehouse and purchase modules are fantastic. Role-based permissions give us strong security and team control.\\u201d\",\"rating\":\"5\",\"thumb\":\"692712bc1139d1764168380.png\"}', NULL, 'basic', '', '2025-10-21 22:25:01', '2025-11-26 08:49:42'),
(100, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Sarah Middleton\",\"designation\":\"Retail Store Owner, StyleCorner Boutique\",\"description\":\"\\u201cThis POS system covers everything my store needs \\u2014 sales, inventory, coupons, customers, even staff payroll. ovoPos is powerful yet simple once you get used to it. A great all-in-one solution!\\u201d\",\"rating\":\"5\",\"thumb\":\"69271344f162a1764168516.png\"}', NULL, 'basic', '', '2025-10-21 22:26:08', '2025-11-26 08:48:37'),
(101, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Daniel Morris\",\"designation\":\"Operations Manager, GreenMart Superstores\",\"description\":\"\\u201cOvoSale has transformed our daily operations. From stock control to employee management, everything is centralized and easy to use. Reporting is detailed and accurate. Highly recommended for multi-branch businesses.\\u201d\",\"rating\":\"5\",\"thumb\":\"692190b629a511763807414.png\"}', NULL, 'basic', '', '2025-10-21 22:26:36', '2025-11-26 08:49:31'),
(102, 'faq.element', '{\"question\":\"What is Ovosale POS Solution?\",\"answer\":\"Ovosale is a complete cross-platform POS (Point of Sale) system that works seamlessly on Android, iOS, Web, and Desktop (PWA). It\\u2019s designed for retail stores, restaurants, and businesses to manage sales, inventory, and customers.\"}', NULL, 'basic', '', '2025-10-21 22:51:59', '2025-10-21 22:51:59'),
(103, 'faq.element', '{\"question\":\"Can multiple staff use the system at the same time?\",\"answer\":\"Yes. Ovosale supports multiple users with role-based access (admin, cashier, manager, etc.).\"}', NULL, 'basic', '', '2025-10-21 22:52:22', '2025-10-21 22:52:22'),
(105, 'faq.element', '{\"question\":\"Does it support different payment methods?\",\"answer\":\"Yes. You can accept cash, card, mobile payments, wallets, and even split payments.\"}', NULL, 'basic', '', '2025-10-21 22:52:45', '2025-10-21 22:52:45'),
(106, 'faq.element', '{\"question\":\"Which platforms are supported?\",\"answer\":\"Ovosale runs on Android, iOS, web browsers, and can be installed as a PWA for desktop use (Windows, Mac, Linux).\"}', NULL, 'basic', '', '2025-10-21 22:52:59', '2025-10-21 22:52:59'),
(108, 'faq.element', '{\"question\":\"Does it support real-time stock management?\",\"answer\":\"Yes. Stock updates automatically after each sale or purchase entry.\"}', NULL, 'basic', '', '2025-10-21 22:53:27', '2025-10-21 22:53:27'),
(109, 'faq.element', '{\"question\":\"What technologies are used to build Ovosale?\",\"answer\":\"Ovosale is built using Flutter (Android\\/iOS), Laravel\\/PHP (Backend & Web), and a MySQL database.\"}', NULL, 'basic', '', '2025-10-21 22:53:40', '2025-10-21 22:53:40'),
(110, 'faq.element', '{\"question\":\"Is Ovosale suitable for small businesses?\",\"answer\":\"Yes. Whether you\\u2019re running a single shop, a chain of stores, or an online + offline hybrid business, Ovosale is scalable and easy to use.\"}', NULL, 'basic', '', '2025-10-21 22:53:56', '2025-10-21 22:53:56'),
(111, 'faq.element', '{\"question\":\"Does it support barcode and QR code scanning?\",\"answer\":\"Yes. Ovosale allows barcode\\/QR scanning for quick product search and checkout.\"}', NULL, 'basic', '', '2025-10-21 22:54:17', '2025-10-21 22:54:17'),
(116, 'newsletter.content', '{\"has_image\":\"1\",\"title\":\"Have a question in mind?\",\"heading\":\"Subscribe to Our Newsletter\",\"subheading\":\"Subheading description and information can be added here\",\"button_name\":\"Subscribe\",\"image\":\"68f8c9a5a89b71761135013.png\"}', NULL, 'basic', '', '2025-10-22 00:10:13', '2025-10-22 00:10:14'),
(118, 'login_register.content', '{\"register_heading\":\"Create Account\",\"login_heading\":\"Login to Account\"}', NULL, 'basic', '', '2025-10-24 20:38:23', '2025-11-23 06:52:03'),
(122, 'service.element', '{\"has_image\":\"1\",\"title\":\"Clothing Store\",\"description\":\"Manage apparel, sizes, and stock\",\"icon_image\":\"692307e9a0c251763903465.png\",\"image\":\"692307e9a61811763903465.png\"}', NULL, 'basic', '', '2025-11-22 01:34:06', '2025-11-23 07:11:05'),
(123, 'service.element', '{\"has_image\":\"1\",\"title\":\"Gadget Store\",\"description\":\"Manage electronics, accessories, and sales\",\"icon_image\":\"692307cfb4cc81763903439.png\",\"image\":\"692307cfba2a71763903439.png\"}', NULL, 'basic', '', '2025-11-22 01:36:12', '2025-11-23 07:10:40'),
(124, 'service.element', '{\"has_image\":\"1\",\"title\":\"Supermarket\",\"description\":\"Handle groceries, checkout, and billing\",\"icon_image\":\"692307c50d5971763903429.png\",\"image\":\"692307c512f2f1763903429.png\"}', NULL, 'basic', '', '2025-11-22 02:36:41', '2025-11-23 07:10:29'),
(125, 'service.element', '{\"has_image\":\"1\",\"title\":\"Hardware Store\",\"description\":\"Manage electronics, accessories, and sales\",\"icon_image\":\"692307b3a3e791763903411.png\",\"image\":\"692307b3a92d51763903411.png\"}', NULL, 'basic', '', '2025-11-22 02:39:21', '2025-11-23 07:10:11'),
(126, 'service.element', '{\"has_image\":\"1\",\"title\":\"Grocery Shop\",\"description\":\"Track fresh produce and products\",\"icon_image\":\"692307df71f811763903455.png\",\"image\":\"692307df76f291763903455.png\"}', NULL, 'basic', '', '2025-11-22 02:40:04', '2025-11-23 07:10:55'),
(127, 'device.content', '{\"title\":\"Device Flexibility\",\"heading\":\"Retail POS on any device, anywhere\",\"description\":\"OvoSale works seamlessly on desktops, tablets, and smartphones, giving you the flexibility to manage sales, inventory, and customers from anywhere\\u2014whether you\'re in-store, at home, or on the go.\",\"has_image\":\"1\",\"image\":\"6922ec388f1471763896376.png\"}', NULL, 'basic', '', '2025-11-22 03:33:44', '2025-11-26 04:44:37'),
(129, 'login_register.element', '{\"has_image\":\"1\",\"image\":\"6923f9ed259451763965421.png\"}', NULL, 'basic', '', '2025-11-22 08:14:25', '2025-11-24 00:23:41'),
(130, 'login_register.element', '{\"has_image\":\"1\",\"image\":\"6923f9f4862091763965428.png\"}', NULL, 'basic', '', '2025-11-22 08:14:31', '2025-11-24 00:23:48'),
(131, 'login_register.element', '{\"has_image\":\"1\",\"image\":\"6923f9fe64b821763965438.png\"}', NULL, 'basic', '', '2025-11-22 08:14:37', '2025-11-24 00:23:58'),
(132, 'about_us.content', '{\"heading\":\"Why Retailers Trust OvoSale POS\",\"subheading\":\"OvoSale is a smart and user-friendly POS system designed for any retail business. From small shops to growing stores, it helps you manage sales, inventory, customers, and staff\\u2014all in one easy platform.\",\"has_image\":\"1\",\"image\":\"6926eab39db291764158131.png\"}', NULL, 'basic', '', '2025-11-25 08:20:27', '2025-11-26 05:55:31'),
(133, 'about_us.element', '{\"title\":\"Built for Your Comfort\",\"description\":\"Multiple plans, smart features, and clean interface tailored to fit your business needs.\"}', NULL, 'basic', '', '2025-11-25 08:23:23', '2025-11-26 04:41:23'),
(134, 'about_us.element', '{\"title\":\"Affordable, High Quality\",\"description\":\"Enjoy premium POS features at a budget-friendly price without compromising performance.\"}', NULL, 'basic', '', '2025-11-25 08:23:39', '2025-11-26 04:41:34'),
(135, 'about_us.element', '{\"title\":\"Flexible Refund Assurance\",\"description\":\"Get up to 100% refund under eligible conditions \\u2014 your satisfaction matters.\"}', NULL, 'basic', '', '2025-11-25 08:23:53', '2025-11-26 04:42:01'),
(136, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How OvoSale Transforms Retail Management for Modern Stores\",\"description\":\"<p>Managing a retail store in today\\u2019s competitive market requires more than just keeping track of sales and inventory. Modern retailers need a solution that integrates operations, improves efficiency, and provides actionable insights. Our blog, <strong>\\\"How OvoSale Transforms Retail Management for Modern Stores,\\\"<\\/strong> explores how OvoSale empowers store owners to optimize their business and stay ahead in the fast-paced retail world.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Centralized Inventory Management<\\/h4>\\r\\n<p>OvoSale allows retailers to manage all products from a single platform. From tracking stock levels to updating product details, store owners can ensure that inventory is accurate and up-to-date, reducing errors and out-of-stock situations. Real-time updates help maintain smooth operations and improve customer satisfaction.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Streamlined Sales and Checkout<\\/h4>\\r\\n<p>With OvoSale, sales processes become faster and more accurate. The POS system simplifies checkout, handles multiple payment methods, and generates instant invoices. This ensures a seamless experience for both staff and customers, enhancing efficiency and reducing waiting times at the counter.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Employee and User Management<\\/h4>\\r\\n<p>Retail stores often struggle with managing multiple staff members and user roles. OvoSale provides comprehensive user management features, allowing store owners to assign permissions, track performance, and ensure accountability across the team. This improves operational control and team productivity.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Insightful Reporting and Analytics<\\/h4>\\r\\n<p>Data-driven decisions are key to retail success. OvoSale generates detailed sales reports, inventory summaries, and performance metrics. Store owners can identify trends, monitor profits, and make informed decisions to grow their business effectively.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Multi-Store Support<\\/h4>\\r\\n<p>For retailers operating multiple outlets, OvoSale provides centralized management across locations. Owners can track inventory, sales, and staff performance across all stores from a single dashboard, making expansion and scaling much easier.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Customizable POS Features<\\/h4>\\r\\n<p>Every retail store has unique needs. OvoSale offers flexible customization options, from adding new product categories to configuring discounts and promotions. This ensures the POS system adapts to your business rather than forcing your business to adapt to the system.<\\/p> <br \\/>\\r\\n\\r\\n<p>OvoSale transforms retail management by combining inventory control, sales optimization, employee management, and data insights into one powerful platform. Our blog, <strong>\\\"How OvoSale Transforms Retail Management for Modern Stores,\\\"<\\/strong> is your guide to understanding how modern retailers can leverage technology to run smarter, more efficient businesses.<\\/p>\",\"image\":\"6925c396bcea11764082582.png\"}', NULL, 'basic', 'how-ovosale-transforms-retail-management-for-modern-stores', '2025-11-25 08:27:47', '2025-11-25 08:56:23'),
(137, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Top Benefits of Using a SaaS POS Solution for Your Business\",\"description\":\"<p>Modern businesses need more than traditional point-of-sale systems\\u2014they need flexible, scalable, and easy-to-use solutions that can grow with their operations. Our blog, <strong>\\\"Top Benefits of Using a SaaS POS Solution for Your Business,\\\"<\\/strong> explores how adopting a SaaS POS system like OvoSale can transform your retail operations and improve efficiency.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Access Anywhere, Anytime<\\/h4>\\r\\n<p>SaaS POS solutions are accessible via web browsers on any device, allowing business owners and staff to manage sales, inventory, and customer data from anywhere. This flexibility ensures operations continue smoothly whether you are in-store, at home, or traveling.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Automatic Updates and Maintenance<\\/h4>\\r\\n<p>With SaaS, you never have to worry about software updates or maintenance. The system automatically receives new features, improvements, and security patches, ensuring your POS stays up-to-date without any downtime or manual intervention.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Cost-Effective and Scalable<\\/h4>\\r\\n<p>SaaS POS solutions are subscription-based, reducing the upfront costs associated with traditional POS systems. Businesses can start with a small plan and scale up as their operations grow, adding more users, products, or stores as needed without extra hardware costs.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Enhanced Data Security<\\/h4>\\r\\n<p>Protecting customer and business data is critical. SaaS POS platforms typically include built-in security measures such as encrypted transactions, secure logins, and regular backups. This provides peace of mind and reduces the risk of data loss or breaches.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Integration with Other Tools<\\/h4>\\r\\n<p>A SaaS POS can integrate with accounting, CRM, and inventory management tools, creating a seamless workflow. This connectivity helps businesses automate tasks, reduce manual errors, and gain comprehensive insights into their operations.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Real-Time Analytics and Reporting<\\/h4>\\r\\n<p>SaaS POS platforms provide real-time sales reports, inventory updates, and customer insights. Business owners can make informed decisions quickly, respond to trends, and optimize operations to maximize profits and efficiency.<\\/p> <br \\/>\\r\\n\\r\\n<p>Adopting a SaaS POS solution offers flexibility, scalability, and advanced features that traditional POS systems often lack. Our blog, <strong>\\\"Top Benefits of Using a SaaS POS Solution for Your Business,\\\"<\\/strong> highlights why modern retailers are choosing platforms like OvoSale to streamline operations, improve se\\r\\n<\\/p>\",\"image\":\"6925c19cd1ac61764082076.png\"}', NULL, 'basic', 'top-benefits-of-using-a-saas-pos-solution-for-your-business', '2025-11-25 08:29:45', '2025-11-25 08:47:57');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(138, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"From Store Management to SaaS: How OvoSale Empowers Entrepreneurs\",\"description\":\"<p>Entrepreneurs today need tools that not only manage their retail stores but also open opportunities to launch SaaS-based solutions. Our blog, <strong>\\\"From Store Management to SaaS: How OvoSale Empowers Entrepreneurs,\\\"<\\/strong> explores how OvoSale provides a complete platform for running a retail business while offering the potential to create SaaS POS solutions.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Comprehensive Store Management<\\/h4>\\r\\n<p>OvoSale offers all the essential tools to run a retail store efficiently. From inventory tracking and sales management to employee oversight and reporting, entrepreneurs can manage every aspect of their business from a single platform.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Opportunity to Launch SaaS Solutions<\\/h4>\\r\\n<p>Beyond managing a single store, OvoSale empowers business owners to create and sell their own SaaS POS solutions. This opens new revenue streams, allowing entrepreneurs to scale their operations beyond traditional retail.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Customizable Features for Every Business<\\/h4>\\r\\n<p>Every retail business has unique needs. OvoSale provides flexible features, such as configurable product categories, discount systems, and subscription plans, enabling entrepreneurs to tailor their store or SaaS offerings to their target market.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Multi-Store and Multi-User Capabilities<\\/h4>\\r\\n<p>Entrepreneurs can manage multiple outlets or SaaS accounts with ease. OvoSale supports centralized control over inventory, sales, and users, ensuring efficient management as the business grows.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Data-Driven Insights<\\/h4>\\r\\n<p>Access to analytics and reporting helps entrepreneurs make informed decisions. By understanding sales trends, customer preferences, and operational efficiency, business owners can optimize performance and maximize profitability.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Scalable and Future-Ready<\\/h4>\\r\\n<p>Whether starting with a single store or launching a SaaS POS platform, OvoSale scales with the business. The system supports growth, allowing entrepreneurs to expand without the hassle of switching platforms or reconfiguring setups.<\\/p> <br \\/>\\r\\n\\r\\n<p>OvoSale empowers entrepreneurs to not only run efficient retail stores but also explore SaaS opportunities. Our blog, <strong>\\\"From Store Management to SaaS: How OvoSale Empowers Entrepreneurs,\\\"<\\/strong> shows how modern business owners can leverage technology to manage, grow, and diversify their ventures effectively.<\\/p>\",\"image\":\"6925c227929a41764082215.png\"}', NULL, 'basic', 'from-store-management-to-saas-how-ovosale-empowers-entrepreneurs', '2025-11-25 08:31:46', '2025-11-25 08:50:15'),
(139, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Boost Sales and Productivity with a Smart POS Business Solution\",\"description\":\"<p>Retail businesses are constantly seeking ways to increase sales while improving efficiency. Our blog, <strong>\\\"Boost Sales and Productivity with a Smart POS Business Solution,\\\"<\\/strong> explores how using a modern POS system like OvoSale can streamline operations, enhance customer experiences, and drive business growth.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Efficient Sales Processing<\\/h4>\\r\\n<p>Smart POS systems speed up transactions, reduce errors, and provide multiple payment options. OvoSale ensures quick checkouts, allowing your staff to serve more customers in less time, boosting overall sales.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Inventory Management Made Simple<\\/h4>\\r\\n<p>OvoSale helps businesses track stock levels, monitor product performance, and avoid out-of-stock situations. Accurate inventory management ensures popular products are always available, preventing missed sales opportunities.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Employee Productivity and Management<\\/h4>\\r\\n<p>Assign roles, monitor performance, and track attendance easily with a smart POS system. OvoSale allows managers to optimize staff productivity, ensuring that every employee contributes effectively to business operations.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Data-Driven Decisions<\\/h4>\\r\\n<p>Access real-time sales reports and analytics to understand customer behavior, peak hours, and product trends. This information empowers business owners to make informed decisions that drive revenue and improve operational efficiency.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Customer Experience Enhancement<\\/h4>\\r\\n<p>With faster transactions, accurate billing, and personalized services, a smart POS improves the overall shopping experience. Happy customers are more likely to return, increasing loyalty and repeat sales.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Scalable for Growing Businesses<\\/h4>\\r\\n<p>As your business expands, OvoSale scales easily. Whether adding new products, users, or locations, the system grows with you, maintaining smooth operations without disruption.<\\/p> <br \\/>\\r\\n\\r\\n<p>Using a smart POS system like OvoSale not only streamlines store operations but also drives sales and enhances productivity. Our blog, <strong>\\\"Boost Sales and Productivity with a Smart POS Business Solution,\\\"<\\/strong> provides insights into how modern retailers can leverage technology to maximize efficiency and grow their business.<\\/p>\",\"image\":\"6925c2d88a43a1764082392.png\"}', NULL, 'basic', 'boost-sales-and-productivity-with-a-smart-pos-business-solution', '2025-11-25 08:32:24', '2025-11-25 08:53:12'),
(140, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Building a SaaS POS Platform: Tips for Retailers and Startups\",\"description\":\"<p>Launching a SaaS POS platform can open new revenue streams and expand business opportunities for retailers and startups. Our blog, <strong>\\\"Building a SaaS POS Platform: Tips for Retailers and Startups,\\\"<\\/strong> provides practical guidance on creating, managing, and scaling a successful SaaS POS solution.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Understand Your Target Market<\\/h4>\\r\\n<p>Before building a SaaS POS platform, it\\u2019s crucial to know your audience. Identify the types of businesses you want to serve, their pain points, and the features they value most. OvoSale provides inspiration for features that appeal to small to medium retailers and multi-location stores.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Choose the Right Technology<\\/h4>\\r\\n<p>Select a platform that is reliable, scalable, and easy to maintain. Using web-based solutions ensures that your SaaS POS is accessible on multiple devices without requiring downloads, allowing clients to manage their stores efficiently.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Feature Prioritization<\\/h4>\\r\\n<p>Focus on features that bring the most value to your customers, such as inventory management, sales tracking, employee management, reporting, and subscription plans. Prioritizing key functionality ensures your platform meets real business needs effectively.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Scalability and Flexibility<\\/h4>\\r\\n<p>A successful SaaS POS platform must\\r\\n<\\/p>\",\"image\":\"6925c321e818a1764082465.png\"}', NULL, 'basic', 'building-a-saas-pos-platform-tips-for-retailers-and-startups', '2025-11-25 08:32:51', '2025-11-25 08:54:26'),
(141, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Why Multi-Device POS Systems Are Essential for Growing Retailers\",\"description\":\"<p>As retail businesses expand, managing operations across multiple devices becomes increasingly important. Our blog, <strong>\\\"Why Multi-Device POS Systems Are Essential for Growing Retailers,\\\"<\\/strong> explores how using a POS system like OvoSale on multiple devices can improve efficiency, flexibility, and customer experience.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Seamless Operations Across Devices<\\/h4>\\r\\n<p>Multi-device POS systems allow staff to access the same sales and inventory data on desktops, tablets, or mobile devices. This ensures consistent information, reduces errors, and allows employees to work efficiently from anywhere in the store.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Improved Customer Experience<\\/h4>\\r\\n<p>With access to POS data on multiple devices, sales staff can quickly check stock, process payments, and offer personalized service. Customers benefit from faster checkout and more informed assistance, enhancing overall satisfaction.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Flexibility for Store Layouts<\\/h4>\\r\\n<p>Multi-device POS systems enable retailers to adapt to different store setups. Whether you have multiple checkout counters, kiosks, or roaming staff, the POS system works seamlessly on any device, supporting diverse operational needs.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Real-Time Data Synchronization<\\/h4>\\r\\n<p>All devices connected to a multi-device POS system update in real time. Sales, inventory, and customer records are synchronized instantly, allowing managers to monitor performance and make data-driven decisions without delays.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Scalability for Growth<\\/h4>\\r\\n<p>Growing retailers can add more devices as their business expands. Multi-device POS systems like OvoSale scale easily, accommodating new checkout counters, locations, or staff members without complex setups or additional infrastructure.<\\/p> <br \\/>\\r\\n\\r\\n<h4>Enhanced Staff Productivity<\\/h4>\\r\\n<p>With multiple devices, employees can work simultaneously without waiting for a single POS terminal. This reduces bottlenecks during peak hours and ensures smoother operations throughout the day.<\\/p> <br \\/>\\r\\n\\r\\n<p>Multi-device POS systems are no longer optional\\u2014they are essential for retailers aiming to grow efficiently and deliver superior customer experiences. Our blog, <strong>\\\"Why Multi-Device POS Systems Are Essential for Growing Retailers,\\\"<\\/strong> highlights how OvoSale helps businesses stay flexible, responsive, and ready for expansion.<\\/p>\",\"image\":\"6925c27a24dab1764082298.png\"}', NULL, 'basic', 'why-multi-device-pos-systems-are-essential-for-growing-retailers', '2025-11-25 08:33:44', '2025-11-25 08:51:38'),
(142, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Sale\",\"description\":\"Track and manage all sales transactions efficiently from one place.\",\"image\":\"6926facee2bf81764162254.png\"}', NULL, 'basic', '', '2025-11-26 06:37:27', '2025-11-26 07:04:14'),
(143, 'feature.element', '{\"has_image\":\"1\",\"title\":\"POS Sale\",\"description\":\"Process in-store sales quickly with our intuitive POS interface.\",\"image\":\"6927081a429381764165658.png\"}', NULL, 'basic', '', '2025-11-26 06:39:20', '2025-11-26 08:00:58'),
(145, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Add Sale\",\"description\":\"Add new sales with speed, accuracy, and ease.\",\"image\":\"69270d6895e0d1764167016.png\"}', NULL, 'basic', '', '2025-11-26 06:39:48', '2025-11-26 08:23:36'),
(146, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Sale List\",\"description\":\"View and manage all sales records with detailed filters.\",\"image\":\"69270d41520471764166977.png\"}', NULL, 'basic', '', '2025-11-26 06:39:57', '2025-11-26 08:22:57'),
(147, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Purchase\",\"description\":\"Keep track of supplier orders and purchases effortlessly.\",\"image\":\"69270d83f0bab1764167043.png\"}', NULL, 'basic', '', '2025-11-26 06:40:09', '2025-11-26 08:24:04'),
(148, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Add Purchase\",\"description\":\"Record new purchases quickly to maintain inventory accuracy.\",\"image\":\"69270d96c30e21764167062.png\"}', NULL, 'basic', '', '2025-11-26 06:40:18', '2025-11-26 08:24:22'),
(149, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Purchase List\",\"description\":\"Review all purchase records and monitor supplier activity.\",\"image\":\"69270cd0f38cf1764166864.png\"}', NULL, 'basic', '', '2025-11-26 06:40:28', '2025-11-26 08:21:05'),
(150, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Product\",\"description\":\"Organize all products in your store with ease.\",\"image\":\"69270cb28a16f1764166834.png\"}', NULL, 'basic', '', '2025-11-26 06:40:38', '2025-11-26 08:20:34'),
(151, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Add Product\",\"description\":\"Add new products quickly with detailed attributes.\",\"image\":\"69270c97623bd1764166807.png\"}', NULL, 'basic', '', '2025-11-26 06:40:46', '2025-11-26 08:20:08'),
(152, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Product List\",\"description\":\"Access a comprehensive list of all products instantly.\",\"image\":\"69270a492b6dc1764166217.png\"}', NULL, 'basic', '', '2025-11-26 06:40:54', '2025-11-26 08:10:17'),
(153, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Print Label\",\"description\":\"Print product labels and barcodes for faster identification.\",\"image\":\"69270a31b51931764166193.png\"}', NULL, 'basic', '', '2025-11-26 06:41:02', '2025-11-26 08:09:53'),
(154, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Category\",\"description\":\"Categorize products for better inventory organization.\",\"image\":\"69270a1bcef231764166171.png\"}', NULL, 'basic', '', '2025-11-26 06:41:09', '2025-11-26 08:09:31'),
(155, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Brand\",\"description\":\"Add and manage product brands efficiently.\",\"image\":\"69270a1132b5e1764166161.png\"}', NULL, 'basic', '', '2025-11-26 06:41:17', '2025-11-26 08:09:21'),
(156, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Unit\",\"description\":\"Define measurement units for products easily.\",\"image\":\"69270997042301764166039.png\"}', NULL, 'basic', '', '2025-11-26 06:41:28', '2025-11-26 08:07:19'),
(157, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Attribute\",\"description\":\"Create custom product attributes for flexible tracking.\",\"image\":\"6927097eebe1d1764166014.png\"}', NULL, 'basic', '', '2025-11-26 06:41:36', '2025-11-26 08:06:54'),
(158, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Variant\",\"description\":\"Manage product variations like size, color, or style.\",\"image\":\"6927094877dfb1764165960.png\"}', NULL, 'basic', '', '2025-11-26 06:41:46', '2025-11-26 08:06:00'),
(159, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Stock Transfer\",\"description\":\"Transfer stock between warehouses effortlessly.\",\"image\":\"6927091c0b1aa1764165916.png\"}', NULL, 'basic', '', '2025-11-26 06:41:54', '2025-11-26 08:05:16'),
(160, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Add Transfer\",\"description\":\"Record a new stock transfer in seconds.\",\"image\":\"69270905d58c01764165893.png\"}', NULL, 'basic', '', '2025-11-26 06:42:02', '2025-11-26 08:04:53'),
(161, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Transfer List\",\"description\":\"Monitor all transfers for better inventory control.\",\"image\":\"692708f106ac31764165873.png\"}', NULL, 'basic', '', '2025-11-26 06:42:10', '2025-11-26 08:04:33'),
(162, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Stock Report\",\"description\":\"Track current stock levels and avoid out-of-stock situations.\",\"image\":\"692708a7d8bbd1764165799.png\"}', NULL, 'basic', '', '2025-11-26 06:42:18', '2025-11-26 08:03:19'),
(163, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Sales Report\",\"description\":\"Analyze sales performance across products, staff, and locations.\",\"image\":\"6927088f329cb1764165775.png\"}', NULL, 'basic', '', '2025-11-26 06:42:25', '2025-11-26 08:02:55'),
(164, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Purchase Report\",\"description\":\"Monitor purchases to optimize inventory and supplier relationships.\",\"image\":\"69270853c72801764165715.png\"}', NULL, 'basic', '', '2025-11-26 06:42:33', '2025-11-26 08:01:55'),
(165, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Expense Report\",\"description\":\"Keep an eye on all expenses and control costs.\",\"image\":\"69270841cdbf81764165697.png\"}', NULL, 'basic', '', '2025-11-26 06:42:40', '2025-11-26 08:01:37'),
(166, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Profit & Loss Report\",\"description\":\"Understand profitability and business performance in real time.\",\"image\":\"6927082c998921764165676.png\"}', NULL, 'basic', '', '2025-11-26 06:42:49', '2025-11-26 08:01:16'),
(167, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Expense\",\"description\":\"Record and categorize all business expenses efficiently.\",\"image\":\"692704978083f1764164759.png\"}', NULL, 'basic', '', '2025-11-26 06:43:00', '2025-11-26 07:45:59'),
(168, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Expense List\",\"description\":\"View and manage all expense records.\",\"image\":\"6927044a288f71764164682.png\"}', NULL, 'basic', '', '2025-11-26 06:43:07', '2025-11-26 07:44:42'),
(169, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Expense Category\",\"description\":\"Organize expenses into meaningful categories.\",\"image\":\"6927042b651901764164651.png\"}', NULL, 'basic', '', '2025-11-26 06:43:14', '2025-11-26 07:44:11'),
(170, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Payment\",\"description\":\"Handle all payments, including cash, card, or online.\",\"image\":\"692703cdd46731764164557.png\"}', NULL, 'basic', '', '2025-11-26 06:43:21', '2025-11-26 07:42:37'),
(171, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Payment Type\",\"description\":\"Define and manage multiple payment methods.\",\"image\":\"6927039d2e7421764164509.png\"}', NULL, 'basic', '', '2025-11-26 06:43:31', '2025-11-26 07:41:49'),
(172, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Payment Account\",\"description\":\"rack all payment accounts securely.\",\"image\":\"6927037a4df7a1764164474.png\"}', NULL, 'basic', '', '2025-11-26 06:43:41', '2025-11-26 07:41:14'),
(173, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Transaction History\",\"description\":\"View a complete history of all financial transactions.\",\"image\":\"69270355c520f1764164437.png\"}', NULL, 'basic', '', '2025-11-26 06:43:48', '2025-11-26 07:40:37'),
(174, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Company\",\"description\":\"Organize multiple companies within a single platform.\",\"image\":\"6927034485d421764164420.png\"}', NULL, 'basic', '', '2025-11-26 06:43:59', '2025-11-26 07:40:20'),
(175, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Department\",\"description\":\"Create and manage departments for structured operations.\",\"image\":\"69270228223361764164136.png\"}', NULL, 'basic', '', '2025-11-26 06:44:08', '2025-11-26 07:35:36'),
(176, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Holidays\",\"description\":\"Define company holidays and manage employee schedules.\",\"image\":\"692702006e0f91764164096.png\"}', NULL, 'basic', '', '2025-11-26 06:44:17', '2025-11-26 07:34:56'),
(177, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Employee\",\"description\":\"Add, edit, and track employee information.\",\"image\":\"692701cc25afb1764164044.png\"}', NULL, 'basic', '', '2025-11-26 06:44:27', '2025-11-26 07:34:04'),
(178, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Attendance\",\"description\":\"Record attendance and monitor working hours.\",\"image\":\"692701991e6371764163993.png\"}', NULL, 'basic', '', '2025-11-26 06:44:37', '2025-11-26 07:33:13'),
(179, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Designation\",\"description\":\"Assign and manage employee roles and positions.\",\"image\":\"692701847f0491764163972.png\"}', NULL, 'basic', '', '2025-11-26 06:44:48', '2025-11-26 07:32:52'),
(180, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Shift\",\"description\":\"Define employee shifts for smooth operations.\",\"image\":\"692701417ea2f1764163905.png\"}', NULL, 'basic', '', '2025-11-26 06:44:58', '2025-11-26 07:31:45'),
(181, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Employee Leave\",\"description\":\"Approve and track leave requests easily.\",\"image\":\"6927013088a951764163888.png\"}', NULL, 'basic', '', '2025-11-26 06:45:07', '2025-11-26 07:31:28'),
(182, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Leave Request\",\"description\":\"Employees can submit leave requests through the system.\",\"image\":\"69270083467d61764163715.png\"}', NULL, 'basic', '', '2025-11-26 06:45:16', '2025-11-26 07:28:35'),
(183, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Leave Type\",\"description\":\"Define types of leave such as casual, sick, or annual.\",\"image\":\"6927007a4d4261764163706.png\"}', NULL, 'basic', '', '2025-11-26 06:45:28', '2025-11-26 07:28:26'),
(184, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Payroll\",\"description\":\"Automate salary calculation and generate payroll reports.\",\"image\":\"692700239ad4a1764163619.png\"}', NULL, 'basic', '', '2025-11-26 06:45:37', '2025-11-26 07:26:59'),
(185, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Warehouse\",\"description\":\"Track inventory across multiple warehouses efficiently.\",\"image\":\"6926ffbe0679c1764163518.png\"}', NULL, 'basic', '', '2025-11-26 06:45:45', '2025-11-26 07:25:18'),
(186, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Tax\",\"description\":\"Define and manage tax rules for accurate invoicing.\",\"image\":\"6926ff92c18271764163474.png\"}', NULL, 'basic', '', '2025-11-26 06:45:54', '2025-11-26 07:24:34'),
(187, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Coupon\",\"description\":\"Create and manage discount coupons for promotions.\",\"image\":\"6926ff85e17f71764163461.png\"}', NULL, 'basic', '', '2025-11-26 06:46:03', '2025-11-26 07:24:21'),
(188, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Customer\",\"description\":\"Maintain detailed customer profiles for better engagement.\",\"image\":\"6926ff757165c1764163445.png\"}', NULL, 'basic', '', '2025-11-26 06:46:13', '2025-11-26 07:24:05'),
(189, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Supplier\",\"description\":\"Track suppliers and manage purchase relationships.\",\"image\":\"6926ff65e92871764163429.png\"}', NULL, 'basic', '', '2025-11-26 06:46:25', '2025-11-26 07:23:49'),
(190, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Staff\",\"description\":\"Organize staff accounts and permissions effectively.\",\"image\":\"6926fc26a24cb1764162598.png\"}', NULL, 'basic', '', '2025-11-26 06:46:34', '2025-11-26 07:09:58'),
(191, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Manage Setting\",\"description\":\"Access all system configurations in one place.\",\"image\":\"6926fc1aab20d1764162586.png\"}', NULL, 'basic', '', '2025-11-26 06:46:45', '2025-11-26 07:09:46'),
(192, 'feature.element', '{\"has_image\":\"1\",\"title\":\"General Settings\",\"description\":\"Configure basic settings for your store.\",\"image\":\"6926fbf0215cf1764162544.png\"}', NULL, 'basic', '', '2025-11-26 06:46:59', '2025-11-26 07:09:04'),
(193, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Company Setting\",\"description\":\"Set company details and branding information.\",\"image\":\"6926fbbb607321764162491.png\"}', NULL, 'basic', '', '2025-11-26 06:47:07', '2025-11-26 07:08:11'),
(194, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Invoice Settings\",\"description\":\"Customize invoices with your branding and preferences.\",\"image\":\"6926fba36e9861764162467.png\"}', NULL, 'basic', '', '2025-11-26 06:47:15', '2025-11-26 07:07:47'),
(195, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Brand Setting\",\"description\":\"Manage brands used in your store for better organization.\",\"image\":\"6926fb61850311764162401.png\"}', NULL, 'basic', '', '2025-11-26 06:47:22', '2025-11-26 07:06:41'),
(196, 'feature.element', '{\"has_image\":\"1\",\"title\":\"My Ticket\",\"description\":\"Access support tickets and track resolutions directly.\",\"image\":\"6926fb2874f841764162344.png\"}', NULL, 'basic', '', '2025-11-26 06:47:30', '2025-11-26 07:05:44');


ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `frontends` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;


-- =========== pages table ============
DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"about_us\",\"feature\",\"device\",\"service\",\"pricing\",\"testimonial\",\"faq\",\"blog\",\"cta\"]', '{\"image\":\"670d1fed046621728913389.png\",\"description\":\"Et recusandae Minus\",\"social_title\":\"test\",\"social_description\":\"Odit magna eos cons\",\"keywords\":null}', 1, '2020-07-11 00:23:58', '2025-11-26 03:11:12'),
(4, 'Blog', 'blog', 'templates.basic.', NULL, NULL, 1, '2020-10-21 19:14:43', '2024-09-10 19:15:02'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"cta\"]', NULL, 1, '2020-10-21 19:14:53', '2025-11-22 08:04:48'),
(28, 'Features', 'features', 'templates.basic.', '[\"cta\"]', NULL, 1, '2025-11-22 07:10:54', '2025-11-22 07:23:19'),
(29, 'Pricing', 'pricing-plan', 'templates.basic.', '[\"cta\"]', NULL, 1, '2025-11-22 07:27:54', '2025-11-22 07:31:09');

ALTER TABLE `pages` ADD PRIMARY KEY (`id`);
ALTER TABLE `pages` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
UPDATE `general_settings` SET `base_color` = '0070f0' WHERE `general_settings`.`id` = 1; 


-- ======================= v2.1 ========================================

ALTER TABLE `expenses` DROP `payment_account_id`;
ALTER TABLE `payrolls` DROP `payment_account_id`;
ALTER TABLE `supplier_payments` DROP `payment_account_id`;
ALTER TABLE `transactions` DROP `payment_account_id`;
ALTER TABLE `transactions` DROP `is_pos_transaction`;


CREATE TABLE `cash_registers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `starting_time` timestamp NULL DEFAULT NULL,
  `closing_time` timestamp NULL DEFAULT NULL,
  `starting_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `closing_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `starting_note` text COLLATE utf8mb4_unicode_ci,
  `closing_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `cash_register_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_register_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` tinyint DEFAULT NULL COMMENT '1=ale, 9=Expense',
  `details` text COLLATE utf8mb4_unicode_ci,
  `payment_type_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `cash_registers` ADD PRIMARY KEY (`id`);
ALTER TABLE `cash_register_transactions` ADD PRIMARY KEY (`id`);
ALTER TABLE `cash_registers` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `cash_register_transactions` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `sale_payments` DROP `payment_account_id`;

INSERT INTO `staff_permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(147, 'view  cash register report', 'web', 'other', NULL, NULL),
(146, 'view  cash register', 'web', 'other', NULL, NULL);

-- ======================= version 2.2 =================== 
INSERT INTO languages (name, code, is_default, image, info, created_at, updated_at)
SELECT 
    'Arabic',
    'ar',
    0,
    '69a82eee859fb1772629742.png',
    'Arabic is a widely spoken Semitic language used by over 400 million people, mainly in the Middle East and North Africa. It is written from right to left and has many regional dialects.',
    '2026-03-04 07:09:04',
    '2026-03-04 23:51:53'
WHERE NOT EXISTS (
    SELECT 1 FROM languages WHERE code = 'ar'
);


-- ====================version 2.3 ==================

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `device_tokens` ADD PRIMARY KEY (`id`);

ALTER TABLE `device_tokens` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users` ADD `one_time_password` TINYINT(1) NOT NULL DEFAULT '0' AFTER `password`;


INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES (NULL, 'SUBSCRIPTION_ASSIGNED', 'Subscription assigned', 'Subscription assigned notification.', '{{site_name}} - {{plan_name}} Subscription assigned', '<div>\r\n  Hello <strong>{{user}}</strong>,\r\n</div>\r\n\r\n<div><br></div>\r\n\r\n<div>\r\n  We’re happy to inform you that a new subscription plan has been assigned to your account.\r\n</div>\r\n\r\n<div><br></div>\r\n\r\n<div>\r\n  <b>Subscription Details:</b>\r\n</div>\r\n\r\n<div><b>Plan Name :</b> {{plan_name}}</div>\r\n<div><b>Billing Cycle :</b> {{recurring}}</div>\r\n<div><b>Expiry Date :</b> <strong>{{expired_date}}</strong></div>\r\n\r\n<div><br></div>\r\n\r\n<div>\r\n  Your subscription is now active and you can enjoy all the features included in your plan.\r\n</div>\r\n\r\n<div><br></div>\r\n\r\n<div>\r\n  Please make sure to renew your subscription before the expiry date to avoid any interruption in service.\r\n</div>\r\n\r\n<div><br></div>\r\n\r\n<div>\r\n  Thank you for choosing <strong>{{site_name}}</strong>.\r\n</div>\r\n', '', 'You\'re now subscribed to {{plan_name}} ({{recurring}})! Valid till {{expired_date}}.', '{\r\n    \"user\": \"Full name of the user\",\r\n    \"plan_name\": \"Subscription plan name\",\r\n    \"recurring\": \"Monthly or Yearly\",\r\n    \"expired_date\": \"Expiry date of the plan\"\r\n}', '1', '{{site_name}} Maintenance', NULL, '0', NULL, '0', NULL, NULL);

ALTER TABLE `plan_purchases` CHANGE `payment_method` `payment_method` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=wallet,2=gateway,3=admin';

DELETE FROM `cron_jobs` WHERE `alias` = 'fetch_subscriptions';


INSERT INTO `forms` (`act`, `form_data`, `created_at`, `updated_at`) VALUES
('kyc', '{\"business_or_shop_name\":{\"name\":\"Business Or Shop Name\",\"label\":\"business_or_shop_name\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"business_type\":{\"name\":\"Business Type\",\"label\":\"business_type\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[\"Retail\",\"Clothing Shop\",\"Gadget Store\",\"Grocery Store\",\"Super Shop\",\"Hardware Store\"],\"type\":\"select\",\"width\":\"12\"},\"business_registration_number\":{\"name\":\"Business Registration Number\",\"label\":\"business_registration_number\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"business_license_front_part\":{\"name\":\"Business License Front Part\",\"label\":\"business_license_front_part\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png,pdf,doc\",\"options\":[],\"type\":\"file\",\"width\":\"6\"},\"business_license_back_part\":{\"name\":\"Business License Back Part\",\"label\":\"business_license_back_part\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png,pdf,doc\",\"options\":[],\"type\":\"file\",\"width\":\"6\"},\"country_of_registration\":{\"name\":\"Country of Registration\",\"label\":\"country_of_registration\",\"is_required\":\"optional\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"business_address\":{\"name\":\"Business Address\",\"label\":\"business_address\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"text\",\"width\":\"12\"}}', '2026-04-30 04:37:20', '2026-04-30 05:20:45');


ALTER TABLE `payrolls` CHANGE `payment_method_id` `payment_method_id` INT NULL DEFAULT '0'; 

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '{{site_name}} - Balance Added', '<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>', 'We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.', '{{amount}} {{site_currency}} has been successfully added to your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 0, NULL, 1, '2021-11-03 12:00:00', '2025-03-15 04:03:25'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '{{site_name}} - Balance Subtracted', '<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>', 'We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.', '{{amount}} {{site_currency}} debited from your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 0, NULL, 1, '2021-11-03 12:00:00', '2025-03-15 04:03:10');


INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(30, 'SUBSCRIPTION_EXTENDED', 'Subscription extended', 'Subscription extended notification.', '{{site_name}} - {{plan_name}} Subscription extended', '<div>\r\n      Hello <strong>{{user}}</strong>,\r\n    </div>\r\n\r\n    <div><br></div>\r\n\r\n    <div>\r\n      Great news! Your subscription plan has been successfully extended.<br><br></div>\r\n    <div>\r\n\r\n    <b>New Expiry Date :</b> <strong>{{expired_date}} </strong>\r\n    <br>\r\n    <b>New Product Limit</b> : <strong>{{product_limit}}</strong>\r\n    <br>\r\n    <b>New User Limit :</b><strong>{{user_limit}}</strong>\r\n    <br>\r\n    \r\n    <b>New Warehouse Limit:</b> <strong> {{warehouse_limit}} </strong>\r\n\r\n    <br>\r\n    <b>New Coupon Limit:</b> <strong> {{coupon_limit}}</strong>\r\n    \r\n    <br>\r\n    <b>HRM Access:</b> <b> {{hrm_access}} </b>\r\n\r\n\r\n    <div style=\"font-weight: bold;\"><br></div>\r\n\r\n    <div style=\"\">\r\n      Your subscription remains active, and you can continue enjoying all the features included in your plan without interruption.\r\n    </div>\r\n\r\n    <div style=\"font-weight: bold;\"><br></div>\r\n\r\n    <div style=\"font-weight: bold;\">\r\n      Thank you for continuing with <strong>{{site_name}}</strong>.\r\n    </div>\r\n</div>', '', 'Your {{plan_name}} subscription has been extended. New expiry date: {{expired_date}}.', '{\n    \"user\": \"Full name of the user\",\n    \"expired_date\": \"New expiry date of the plan\",\n    \"product_limit\": \"Mew Product Limit\",\n    \"user_limit\": \"New user limit\",\n    \"warehouse_limit\": \"New warehouse limit\",\n    \"coupon_limit\": \"New coupon limit\",\n    \"hrm_access\": \"New HRM Access\"\n}', 1, '{{site_name}} Maintenance', NULL, 0, NULL, 0, NULL, '2026-05-01 22:17:53');
