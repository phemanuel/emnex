-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2026 at 02:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emnex-central`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `module` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `record_type` varchar(255) DEFAULT NULL,
  `record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_head_office` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `sync_uuid`, `company_id`, `branch_code`, `name`, `phone`, `email`, `address`, `is_head_office`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '4e4add8f-63ff-4171-9c6a-f750458b806b', 1, 'BR001', 'Head Office', NULL, NULL, NULL, 1, 1, '2026-10-14 12:01:22', '2026-10-19 09:57:54', NULL),
(2, '187a46bb-189a-486d-b576-007001a8a150', 1, 'BR002', 'Lekki Branch', '08087654321', 'lekki@emmanexitconsult.com', 'Lekki, Lagos', 0, 1, '2026-10-19 10:17:56', '2026-10-19 10:17:56', NULL),
(3, '13e586f9-fd0b-40ac-93ef-c963baad42e5', 1, 'BR003', 'Ajah Outlet New', '07034657383', 'ajah@emmanexitconsult.com', 'Agbado, Ajah express way, Lagos.', 0, 1, '2026-10-19 10:27:58', '2026-10-19 10:27:58', NULL),
(4, '84782dc7-722f-4676-b30e-e994c0c19e81', 1, 'BR004', 'Ikorodu Outlet Updated', '07038899203', 'Ikd@emmanexitconsult.com', 'Odogunyan, Ikorodu, Lagos.', 0, 1, '2026-10-19 10:30:16', '2026-10-19 10:34:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_drawers`
--

CREATE TABLE `cash_drawers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_id` bigint(20) UNSIGNED NOT NULL,
  `opened_by` bigint(20) UNSIGNED NOT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cash_sales` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cash_in` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cash_out` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cash_refunds` decimal(15,2) NOT NULL DEFAULT 0.00,
  `expected_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `actual_balance` decimal(15,2) DEFAULT NULL,
  `variance` decimal(15,2) DEFAULT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `opened_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `opening_remarks` text DEFAULT NULL,
  `closing_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_drawer_transactions`
--

CREATE TABLE `cash_drawer_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_id` bigint(20) UNSIGNED NOT NULL,
  `cash_drawer_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('Opening','Sale','Refund','Cash In','Cash Out','Adjustment','Closing') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `balance_before` decimal(15,2) NOT NULL,
  `balance_after` decimal(15,2) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `currency_symbol` varchar(10) NOT NULL DEFAULT '₦',
  `timezone` varchar(255) NOT NULL DEFAULT 'Africa/Lagos',
  `subscription_start` date DEFAULT NULL,
  `subscription_end` date DEFAULT NULL,
  `subscription_status` enum('Trial','Active','Expired','Suspended') NOT NULL DEFAULT 'Trial',
  `business_type` varchar(255) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `lifecycle_status` varchar(40) NOT NULL DEFAULT 'Active',
  `archive_eligible_at` timestamp NULL DEFAULT NULL,
  `archive_scheduled_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `lifecycle_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_code`, `name`, `slug`, `email`, `phone`, `address`, `logo`, `currency`, `currency_symbol`, `timezone`, `subscription_start`, `subscription_end`, `subscription_status`, `business_type`, `registration_no`, `tin`, `status`, `last_activity_at`, `lifecycle_status`, `archive_eligible_at`, `archive_scheduled_at`, `archived_at`, `lifecycle_locked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'COMP-0001', 'Emmanex Supermarket', 'emmanex-supermarket', NULL, NULL, NULL, NULL, 'NGN', '₦', 'Africa/Lagos', '2026-07-29', '2027-07-29', 'Active', NULL, NULL, NULL, 1, NULL, 'Active', NULL, NULL, NULL, 0, '2026-10-14 11:58:46', '2026-10-14 11:58:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_archives`
--

CREATE TABLE `company_archives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_company_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Pending',
  `archive_format` varchar(20) NOT NULL DEFAULT 'zip-json',
  `storage_disk` varchar(255) NOT NULL,
  `storage_path` text DEFAULT NULL,
  `archive_size` bigint(20) UNSIGNED DEFAULT NULL,
  `checksum` varchar(128) DEFAULT NULL,
  `manifest` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`manifest`)),
  `verification` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`verification`)),
  `error_message` text DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `purged_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_business_profiles`
--

CREATE TABLE `company_business_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `capability_overrides` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`capability_overrides`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_lifecycle_events`
--

CREATE TABLE `company_lifecycle_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `archive_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(80) NOT NULL,
  `from_status` varchar(40) DEFAULT NULL,
  `to_status` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `platform_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `customer_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_code` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `credit_limit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `customer_type` varchar(255) NOT NULL DEFAULT 'Walk-in',
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `last_purchase_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `credit_limit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lifecycle_settings`
--

CREATE TABLE `data_lifecycle_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `inactivity_days` int(10) UNSIGNED NOT NULL DEFAULT 540,
  `grace_period_days` int(10) UNSIGNED NOT NULL DEFAULT 30,
  `warning_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`warning_days`)),
  `automatic_scheduling` tinyint(1) NOT NULL DEFAULT 0,
  `automatic_purge` tinyint(1) NOT NULL DEFAULT 0,
  `archive_disk` varchar(255) NOT NULL DEFAULT 'local',
  `archive_directory` varchar(255) NOT NULL DEFAULT 'company-archives',
  `archive_retention_days` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_automatic` tinyint(1) NOT NULL DEFAULT 0,
  `type` enum('Percentage','Fixed') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `sync_uuid`, `company_id`, `name`, `is_automatic`, `type`, `value`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '241fce75-1371-4e36-821e-d2186e9716d2', 1, 'No Discount', 1, 'Percentage', 0.00, '2026-07-29', '2036-07-29', 1, '2026-10-14 13:22:47', '2026-10-14 13:36:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `document_sequences`
--

CREATE TABLE `document_sequences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `separator` varchar(5) NOT NULL DEFAULT '-',
  `current_number` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `number_length` int(10) UNSIGNED NOT NULL DEFAULT 6,
  `reset_frequency` enum('Never','Daily','Monthly','Yearly') NOT NULL DEFAULT 'Never',
  `last_reset_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `use_date_in_sequence` tinyint(1) NOT NULL DEFAULT 0
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
-- Table structure for table `goods_received`
--

CREATE TABLE `goods_received` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_number` varchar(100) NOT NULL,
  `received_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Draft',
  `notes` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goods_received_items`
--

CREATE TABLE `goods_received_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goods_received_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ordered_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `received_quantity` decimal(15,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `source_invoice_no` varchar(50) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_items` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(30) NOT NULL DEFAULT 'Pending',
  `invoice_status` varchar(30) NOT NULL DEFAULT 'Active',
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `company_id`, `branch_id`, `terminal_id`, `order_id`, `customer_id`, `invoice_no`, `source_invoice_no`, `invoice_date`, `subtotal`, `discount`, `tax`, `total`, `amount_paid`, `balance`, `total_quantity`, `total_items`, `grand_total`, `payment_status`, `invoice_status`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 3, 1, NULL, 'INV-000051', 'INV-000051', '2026-10-19', 1200.00, 0.00, 90.00, 1200.00, 1290.00, 0.00, 1.00, 1, 1290.00, 'Paid', 'Active', NULL, NULL, NULL, '2026-10-19 12:00:06', '2026-10-19 12:00:06', NULL),
(2, 1, 2, 3, 2, NULL, 'INV-000052', 'INV-000052', '2026-10-19', 1200.00, 0.00, 90.00, 1200.00, 1290.00, 0.00, 1.00, 1, 1290.00, 'Paid', 'Active', NULL, NULL, NULL, '2026-10-19 12:20:37', '2026-10-19 12:20:37', NULL),
(5, 1, 1, 4, 5, NULL, 'INV-000053', 'INV-000053', '2026-10-20', 1200.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, 1.00, 1, 1200.00, 'Paid', 'Active', NULL, NULL, NULL, '2026-10-20 11:17:22', '2026-10-20 11:17:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_barcode` varchar(100) DEFAULT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `company_id`, `invoice_id`, `product_id`, `product_name`, `product_barcode`, `quantity`, `unit_price`, `discount`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-10-19 12:07:40', '2026-10-19 12:07:40'),
(4, 1, 2, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-10-19 12:20:37', '2026-10-19 12:20:37'),
(7, 1, 5, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-10-20 11:17:22', '2026-10-20 11:17:22');

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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '2026_07_26_080001_create_companies_table', 1),
(2, '2026_07_26_080002_create_branches_table', 1),
(3, '2026_07_26_080003_create_terminals_table', 1),
(4, '2026_07_26_080004_create_roles_table', 1),
(5, '2026_07_26_080005_create_permissions_table', 1),
(6, '2026_07_26_080006_create_role_permissions_table', 1),
(7, '2026_07_26_080007_create_users_table', 1),
(8, '2026_07_26_080008_create_settings_table', 1),
(9, '2026_07_26_080009_create_document_sequences_table', 1),
(10, '2026_07_26_080010_create_product_categories_table', 1),
(11, '2026_07_26_080011_create_units_table', 1),
(12, '2026_07_26_080012_create_tax_rates_table', 1),
(13, '2026_07_26_080013_create_discounts_table', 1),
(14, '2026_07_26_080014_create_products_table', 1),
(15, '2026_07_26_080015_create_product_stocks_table', 1),
(16, '2026_07_26_080017_create_customers_table', 1),
(17, '2026_07_26_080018_create_orders_table', 1),
(18, '2026_07_26_080019_create_order_items_table', 1),
(19, '2026_07_26_080020_create_payments_table', 1),
(20, '2026_07_26_080021_create_stock_movements_table', 1),
(21, '2026_07_26_080022_create_activity_logs_table', 1),
(22, '2026_07_26_080023_create_currencies_table', 1),
(23, '2026_07_26_080024_create_cache_table', 1),
(24, '2026_07_26_080025_create_jobs_table', 1),
(25, '2026_07_26_112309_add_extra_field_to_document_sequences_table', 1),
(26, '2026_07_26_205033_alter_payments_table_add_missing_fields', 1),
(27, '2026_07_27_011902_add_extra_field_to_customers_field', 1),
(28, '2026_07_29_093731_add_code_to_permissions_table', 1),
(29, '2026_07_29_094243_add_code_to_roles_table', 1),
(30, '2026_07_29_140700_alter_activity_logs_table_add_record_information', 1),
(31, '2026_07_29_141430_add_record_columns_to_activity_logs_table', 1),
(32, '2026_07_29_163213_add_additional_fields_to_users_table', 1),
(33, '2026_08_01_224447_add_description_and_last_seen_at_to_terminals_table', 1),
(34, '2026_08_02_010316_add_missing_fields_to_settings_table', 1),
(35, '2026_08_02_092343_add_last_reset_at_to_document_sequences_table', 1),
(36, '2026_08_02_103957_create_payment_methods_table', 1),
(37, '2026_08_02_104254_add_payment_method_id_to_payments_table', 1),
(38, '2026_08_02_104326_remove_payment_method_from_payments_table', 1),
(39, '2026_08_03_100609_add_payment_method_to_payments_table', 1),
(40, '2026_08_03_101122_add_unit_metadata_to_units_table', 1),
(41, '2026_08_04_100012_add_soft_deletes_to_discounts_table', 1),
(42, '2026_08_09_103055_update_stock_movements_for_stock_adjustments', 1),
(43, '2026_08_11_100444_update_stock_movement_types', 1),
(44, '2026_08_14_093916_create_stock_counts_table', 1),
(45, '2026_08_14_093949_create_stock_count_items_table', 1),
(46, '2026_08_15_133231_create_customer_groups_table', 1),
(47, '2026_08_15_134244_add_customer_group_id_to_customers_table', 1),
(48, '2026_08_16_120215_create_suppliers_table', 1),
(49, '2026_08_16_125844_create_purchase_orders_table', 1),
(50, '2026_08_16_125923_create_purchase_order_items_table', 1),
(51, '2026_08_16_125944_create_goods_receiveds_table', 1),
(52, '2026_08_16_130015_create_goods_received_items_table', 1),
(53, '2026_08_16_130034_create_purchase_returns_table', 1),
(54, '2026_08_16_130056_create_purchase_return_items_table', 1),
(55, '2026_08_28_081507_create_invoices_table', 1),
(56, '2026_08_28_081604_create_invoice_items_table', 1),
(57, '2026_08_29_151423_create_sales_returns_table', 1),
(58, '2026_08_29_151437_create_sales_return_payments_table', 1),
(59, '2026_08_30_021155_create_cash_drawers_table', 1),
(60, '2026_08_30_021227_create_cash_drawer_transactions_table', 1),
(61, '2026_08_30_112306_create_terminal_assignments_table', 1),
(62, '2026_09_14_134815_add_unit_cost_to_order_items_table', 1),
(63, '2026_09_16_114806_create_sales_return_items_table', 1),
(64, '2026_09_21_131904_create_sync_devices_table', 1),
(65, '2026_09_21_132116_create_sync_queue_table', 1),
(66, '2026_09_21_132304_create_sync_logs_table', 1),
(67, '2026_09_21_141419_create_sync_mutations_table', 1),
(68, '2026_09_26_203336_create_store_fronts_table', 1),
(69, '2026_09_26_232040_make_cashier_id_nullable_on_orders_table', 1),
(70, '2026_09_26_232431_make_online_sales_user_fields_nullable', 1),
(71, '2026_09_26_232746_make_online_sales_user_fields_nullable', 1),
(72, '2026_09_27_001854_create_platform_admins_table', 1),
(73, '2026_09_27_012938_add_data_lifecycle_fields_to_companies_table', 1),
(74, '2026_09_27_013237_create_data_lifecycle_settings_table', 1),
(75, '2026_09_27_013305_create_company_archives_table', 1),
(76, '2026_09_27_013330_create_company_lifecycle_events_table', 1),
(77, '2026_09_27_213040_add_storefront_public_fields_to_orders_table', 1),
(78, '2026_09_27_220804_create_shipping_settings_table', 1),
(79, '2026_09_27_220814_create_shipping_locations_table', 1),
(80, '2026_09_27_220831_add_shipping_fields_to_orders_table', 1),
(81, '2026_09_29_110242_add_theme_key_to_storefronts_table', 1),
(82, '2026_09_30_122125_create_company_business_profiles_table', 1),
(83, '2026_09_30_132520_create_product_images_table', 1),
(84, '2026_10_05_123224_add_sync_uuid_to_products_table', 1),
(85, '2026_10_05_133940_add_sync_uuid_to_product_categories_table', 1),
(86, '2026_10_05_135458_add_sync_uuid_to_units_table', 1),
(87, '2026_10_05_140157_add_sync_uuid_and_soft_deletes_to_tax_rates_table', 1),
(88, '2026_10_05_141549_add_sync_uuid_to_discounts_table', 1),
(89, '2026_10_19_094551_add_sync_uuid_to_branches_table', 2),
(90, '2026_10_19_113651_add_sync_uuid_to_terminals_table', 3),
(91, '2026_10_19_120814_add_sync_uuid_to_orders_table', 4),
(92, '2026_10_19_124351_add_source_document_numbers_for_sync', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `source_order_no` varchar(255) DEFAULT NULL,
  `public_token` varchar(64) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cashier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_items` int(11) NOT NULL DEFAULT 0,
  `total_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `change_given` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `completed_at` timestamp NULL DEFAULT NULL,
  `confirmation_email_sent_at` timestamp NULL DEFAULT NULL,
  `payment_status` enum('Pending','Partial','Paid','Refunded') NOT NULL DEFAULT 'Pending',
  `order_status` enum('Draft','Held','Completed','Cancelled','Refunded') NOT NULL DEFAULT 'Draft',
  `sales_channel` enum('POS','Online','Phone') NOT NULL DEFAULT 'POS',
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receipt_printed` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `shipping_method` varchar(30) DEFAULT NULL,
  `shipping_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_location_name` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `fulfilment_status` varchar(30) DEFAULT NULL,
  `tracking_reference` varchar(255) DEFAULT NULL,
  `shipping_notes` text DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `sync_uuid`, `company_id`, `branch_id`, `order_no`, `source_order_no`, `public_token`, `customer_id`, `cashier_id`, `subtotal`, `discount`, `discount_id`, `tax_rate_id`, `tax`, `total`, `amount_paid`, `balance`, `total_items`, `total_quantity`, `change_given`, `grand_total`, `completed_at`, `confirmation_email_sent_at`, `payment_status`, `order_status`, `sales_channel`, `terminal_id`, `receipt_printed`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `shipping_method`, `shipping_location_id`, `shipping_location_name`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_fee`, `fulfilment_status`, `tracking_reference`, `shipping_notes`, `shipped_at`, `delivered_at`) VALUES
(1, 'b1421326-e248-4242-93ea-b91778709182', 1, 2, 'ORD-000064', 'ORD-000064', NULL, NULL, NULL, 1200.00, 0.00, NULL, NULL, 90.00, 1200.00, 1290.00, 0.00, 1, 1.00, 0.00, 1290.00, '2026-10-19 08:34:02', NULL, 'Paid', 'Completed', 'POS', 3, 0, NULL, NULL, NULL, '2026-10-19 12:00:06', '2026-10-19 12:00:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(2, 'dd1d27e4-9dc7-4aa9-8f9d-f445b632cc4f', 1, 2, 'ORD-000065', 'ORD-000065', NULL, NULL, NULL, 1200.00, 0.00, NULL, NULL, 90.00, 1200.00, 1290.00, 0.00, 1, 1.00, 0.00, 1290.00, '2026-10-19 12:16:42', NULL, 'Paid', 'Completed', 'POS', 3, 0, NULL, NULL, NULL, '2026-10-19 12:20:37', '2026-10-19 12:20:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(5, '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 1, 1, 'ORD-000066', 'ORD-000066', NULL, NULL, NULL, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 1200.00, 0.00, 1, 1.00, 0.00, 1200.00, '2026-10-20 08:13:53', NULL, 'Paid', 'Completed', 'POS', 4, 0, NULL, NULL, NULL, '2026-10-20 11:17:22', '2026-10-20 11:17:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `company_id`, `order_id`, `product_id`, `product_name`, `product_barcode`, `quantity`, `unit_price`, `unit_cost`, `discount`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-10-19 12:07:40', '2026-10-19 12:07:40'),
(4, 1, 2, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-10-19 12:20:37', '2026-10-19 12:20:37'),
(7, 1, 5, 3, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-10-20 11:17:22', '2026-10-20 11:17:22');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_status` enum('Pending','Completed','Failed','Cancelled','Refunded') NOT NULL DEFAULT 'Completed',
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` datetime NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) NOT NULL,
  `source_payment_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` enum('Cash','POS','Transfer','Wallet','Credit','Cheque','Card') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `company_id`, `branch_id`, `order_id`, `customer_id`, `terminal_id`, `amount`, `payment_status`, `payment_method_id`, `payment_date`, `transaction_reference`, `payment_gateway`, `reference_no`, `remarks`, `received_by`, `payment_number`, `source_payment_number`, `created_at`, `updated_at`, `payment_method`) VALUES
(3, 1, 2, 1, NULL, 3, 1290.00, 'Completed', 1, '2026-10-19 09:34:02', NULL, NULL, NULL, NULL, NULL, 'PAY-000048', 'PAY-000048', '2026-10-19 12:07:40', '2026-10-19 12:07:40', 'Cash'),
(4, 1, 2, 2, NULL, 3, 1290.00, 'Completed', 1, '2026-10-19 13:16:42', NULL, NULL, NULL, NULL, NULL, 'PAY-000049', 'PAY-000049', '2026-10-19 12:20:37', '2026-10-19 12:20:37', 'Cash'),
(5, 1, 1, 5, NULL, 4, 1200.00, 'Completed', 2, '2026-10-20 09:13:53', NULL, NULL, 'ORD-000066', 'Payment received for sales order: ORD-000066', NULL, 'PAY-000050', 'PAY-000050', '2026-10-20 11:17:22', '2026-10-20 11:17:22', 'Card');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'primary',
  `requires_reference` tinyint(1) NOT NULL DEFAULT 0,
  `is_cash` tinyint(1) NOT NULL DEFAULT 0,
  `allow_change` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `company_id`, `name`, `code`, `icon`, `color`, `requires_reference`, `is_cash`, `allow_change`, `display_order`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Cash', 'CASH', 'bi-cash', 'success', 0, 1, 1, 1, 1, '2026-10-19 11:40:31', '2026-10-19 11:40:31', NULL),
(2, 1, 'Card', 'CARD', 'bi-credit-card', 'dark', 1, 0, 0, 1, 1, '2026-10-20 11:05:18', '2026-10-20 11:05:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `module` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(150) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_system` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform_admins`
--

CREATE TABLE `platform_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` enum('owner','admin','support') NOT NULL DEFAULT 'support',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cost_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(15,2) NOT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shelf_location` varchar(255) DEFAULT NULL,
  `track_stock` tinyint(1) NOT NULL DEFAULT 1,
  `brand` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `taxable` tinyint(1) NOT NULL DEFAULT 1,
  `tax_rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `minimum_stock` decimal(15,2) NOT NULL DEFAULT 0.00,
  `maximum_stock` decimal(15,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `reorder_level` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sync_uuid`, `company_id`, `product_category_id`, `product_code`, `barcode`, `sku`, `qr_code`, `name`, `description`, `image`, `cost_price`, `selling_price`, `discount_id`, `unit_id`, `shelf_location`, `track_stock`, `brand`, `manufacturer`, `expiry_date`, `taxable`, `tax_rate_id`, `status`, `minimum_stock`, `maximum_stock`, `weight`, `dimensions`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `reorder_level`) VALUES
(1, '26b06031-8503-4b3f-aa34-64f5bff690bd', 1, 1, 'PRD000001', '100000000001', 'COKE50CL', NULL, 'Coca-Cola 50cl', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Coca-Cola', 'NBC', '2026-09-23', 1, 2, 1, 10.00, 2000.00, NULL, NULL, NULL, NULL, '2026-10-14 13:41:12', '2026-10-15 10:41:00', NULL, 0.00),
(2, '4b1c50ab-8523-465d-b155-bd59f4fe9056', 1, 1, 'SYNCDEL-AIHF6KBL', NULL, 'SYNCDEL-QMYRYTXJ', NULL, 'Sync Delete Test Product', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Coca-Cola', 'NBC', '2026-09-23', 1, 2, 1, 10.00, 2000.00, NULL, NULL, NULL, NULL, '2026-10-15 10:50:18', '2026-10-15 12:26:53', '2026-10-15 12:26:53', 0.00),
(3, 'b4c04317-0179-47c0-a932-e353479e38fb', 1, 2, 'PRD000011', 'TH123456', NULL, NULL, 'Three Crown Evaporated Milk', 'Three Crown Evaporated Milk', NULL, 1000.00, 1200.00, NULL, 2, NULL, 1, 'Three Crown', 'Three Crown Ltd', '2027-11-25', 1, NULL, 1, 100.00, 1635.00, NULL, NULL, NULL, NULL, '2026-10-19 11:32:42', '2026-10-19 11:32:42', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `sync_uuid`, `company_id`, `category_code`, `name`, `description`, `parent_id`, `image`, `sort_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'c8b72c13-63dc-4161-8b4e-aff839f037e1', 1, 'CAT000001', 'Beverages', 'Soft drinks, juices, bottled water and energy drinks.', NULL, NULL, 0, 1, NULL, NULL, '2026-10-14 13:26:03', '2026-10-14 13:26:03', NULL),
(2, '006f5ba5-7812-4ebc-807f-3e171cff6f61', 1, 'CAT000005', 'Dairy', 'Milk, butter, cheese and yoghurt.', NULL, NULL, 0, 1, NULL, NULL, '2026-10-19 11:25:52', '2026-10-19 11:25:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(500) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reserved_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `available_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reorder_level` decimal(15,2) NOT NULL DEFAULT 0.00,
  `maximum_stock` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `company_id`, `branch_id`, `product_id`, `quantity`, `reserved_quantity`, `available_quantity`, `reorder_level`, `maximum_stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0.00, 0.00, 0.00, 10.00, 2000.00, '2026-10-14 13:41:12', '2026-10-15 10:41:00'),
(2, 1, 1, 2, 0.00, 0.00, 0.00, 10.00, 2000.00, '2026-10-15 10:50:18', '2026-10-15 11:53:46'),
(3, 1, 1, 3, 0.00, 0.00, 0.00, 100.00, 1635.00, '2026-10-19 11:32:43', '2026-10-19 11:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Draft',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `goods_received_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_number` varchar(100) NOT NULL,
  `return_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Draft',
  `reason` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_items`
--

CREATE TABLE `purchase_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `goods_received_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_number` varchar(255) NOT NULL,
  `return_type` enum('Completed','Held') NOT NULL,
  `order_total` decimal(15,2) NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `balance` decimal(15,2) NOT NULL,
  `refund_amount` decimal(15,2) NOT NULL,
  `refund_method` varchar(255) DEFAULT NULL,
  `return_status` enum('Pending','Completed','Cancelled','Failed') NOT NULL DEFAULT 'Pending',
  `reason` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `processed_at` datetime DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `sales_return_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_payments`
--

CREATE TABLE `sales_return_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_return_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1hBbAemNvY1vc0eeNqgUnAbEFCxdhArwgPSwUNQY', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNHVMc3o5OWgycFFBTkI5TGZFSWxCaXJsVkZUeEwxWkVqTHFDRW9kMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792065532),
('6IXFPY0JJcBb5W5Er4vWBKJd3WnvQCVtQfUEpDmX', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRHdRSG9pMGlTRmZlc0ppSTd4dmZpMnFWcktCVGk5NzBZRmVnUUR6UyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792060747),
('77HSuN1fZxFXd81fT7q0CucNNp8iMMjRLirMsn9P', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieEkwWUxIS2ZCdmlXTUNKZzlpN3I4RjRIOVlMUWo1MWdqYUdvSGtWdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792065880),
('A6MaI1ugQpsXOnBNoeco1r9vGFbRTZk7eySVb1Yt', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVDVvS0Jtb2RmczJDcW1rVkJXTW5DUG1WT2tSZm1XakFLdUJ6TGV2MyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792492330),
('bCVbQ9qkNDvlzlJjtzA6l3EVdtp4LBwRr1rTNWFz', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSnpGYWU2MHN5WERzWmpmYzhLanVXWUF5dFZjZTEzZEJPazFnM2tvMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792409278),
('BGhHQV0h9Iyk9ps6M7jpdgG8TUnEsHrbONdZepN4', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOTlVR2tzb0dIYmJiVVdnSzhHZ1hqSHVJSlhRdlFJaWFzemtLVGF5TyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792065714),
('bqDCYUZoNhaQZUddtixHkY4aSRjRm6WRoFWxiF36', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVUZTM2dFQVZFTERGdGpoQ2l4WFpYQXk5U2Y0bzBBYnZiRHNhQUFxNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792498056),
('CuqLZaNLQufvsQqukeC71I5ExYMlH8jJHAk7CtWZ', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaG45TzRaMlRNZzRyME5hNEZreUI1M1VwRG5wUDYxeFJVY1N4MVVmRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792409416),
('cuWrEwPklGMLVM5vsygEVq5zM5CTpZSuZxJ49uhs', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiY0lFUlFsNXRQOHVwNmwzS0hmejl1dG51T3ZJbXZQMVZKOWlWT1ZITiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792411149),
('DaVieuyn6bgIdLtDao3CcaTixIqkyFN2uw3e6SZt', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUXBTamtIUktSS0ZlYnRFTk91eXg0SThxajJoQ2l3eHVlOHdLY0NDVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792061056),
('DH8X8c5o7fPcfpikl5vZUKXKCjK9kIMGZUilx0Sc', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicXRQeGZqN21reHdFYlpCeURad3IwQW1NaUp3Nk95OUhTR0RCa2U3WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792064017),
('ExHFTARYZbeRGK0SIiAsg4iw0GRICeMnIVZfMvbK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVm5kWDJ2Zk5QV0lsYXdSWFN4aTNpdnQxMVRwZkF2amNrMm1xRjZPYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1792399174),
('FAhbBqmCybTEryJo8fRyZL5NKMyRo867sOiF19Eb', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiV2xvQ2VLdEh2WFZpRXhpbmRmN3NZMjJHWU9xOFpxUzNCMDdaMW1aNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792496854),
('FpPf94D4EQClnInwYGKE24Hzbm8AJd6q0aNrAkbw', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiR0lRRklQZ0JDeDFBZnZRWXV4djBQZ1J4VkJqUXk0MzVtU2dJUldlYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792411293),
('G91cKe8gJV53VMKq8JKkYBpK7amdWmsbyks3X3mz', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWVVjRWxyMXNBZXp6RmJOc3lUcTBhY2c3bFRJU0gybjBSeW5pQnRNYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792416037),
('I3DVwMdZruF7RK7JKONvC79ycyiyIrQX8SERBjTV', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiN2ZkZ2ZYdmdobUc0Z3Y1Q1UxejVoRVNCSzZFMHl6VXFJa1V4NlY4cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792414806),
('IBkfh6rEpNp5w6pDPfsy1T9rbyi7H2H7kQER7Vgi', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRzc3QWk5THlXcWx4N0dxVXJKOEZ2QXFxYVBucXVQS0xTYnBqV3NTUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792061387),
('ieZ7JiiIjlp08FcM5EVJn98NwFwpLbCvfDX44sCF', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNm5PWWpVcXJCQkcyM3FUSVZtdXZTUmZLMFpHS2NHaVZDMldOYkRQYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792498642),
('J79RVYMyzMXB394VS83HsjLXRTyl8tHD157zO5cE', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidjJtdXQwM2p5TGlLUnVaQXVOTTN2Z0l2YThVN0lWdkc4SE9tejFZaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792415133),
('L4DZMkH8kaUmHj9nFnwNoLTfqPmJv7MEdkgPExGf', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVFlMdjYyWUxiTzNSUnZIeHRPd2k3Sk56YnNSbmtOS2E0RDRBQUg1dCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792412934),
('M2Rzbaee9gw9CPJYsVFbVuTKWWB3Ecv3Ap5u3ZeO', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNVZXSGV4TXNhYmUyWFFUT2dvZUpwTGluYVh5ejB2T2lDUDYxa0NtVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792064460),
('MWP8S0NLXzFtYi8Oa9AwnxlYwVV1l24uiFFVR8Om', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZjFXcFJZYkU4cDJoekVvRzJEZzdtWWZlTGNaN1R6aUZrYmF6ejFtQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792063491),
('OnFlSR3eWqzjEZgIAsN34Q9nFr6LLmvjVM1eraQC', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicmlqRkVlaUlKR2doVnBSMk5hbzFSUlRicGVqTVRGS3lZVHpmcmlWaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792412465),
('QQOxyAsRuT65ecc533xrIlO4GL0HboJdqFZiRnvR', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUEtaT0t6NTF5RUhTMFZHUlhGZlhZRkgyVmZHTndmR3JVMGxlTnF2MyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792065018),
('s04OdKAGliGa1mnXcCeSpVoJ6I0wlQnuaL890sGx', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicHVjTVhJWk52N3FyUXc4NW9vTDhlZGtQbmRoVmpmcUQ3a3NPTjVadyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792413163),
('swqXbGQRphMcxwkQVuahRuw9JIMz9xSLXrDFxQRk', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNEltRmIwa29kZVVIbGt3WW9paUo4YWNWZVFVOURIdjBZblFmcWVheCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792068826),
('TqFOwIyJjesyuYW8sMrUGgQUVjxNCJHm9FEqhqGB', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMk5INHJuZk4wY2xTWWgwc2NsWDk4Y3EzYnJiUVE2enpPUUlZUDlXMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792409644),
('v3VSmFWZcOxbcqDPdnvhB2dzwIkgO4mPsiPwsimv', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiS2xlTW1OUkl1SnJleVBzQkVLbTRpSUQ5cnZ4WWRDRk1Qd1Q5Y0U1UyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792415260),
('vczLVcTNfk9dlemJFPjPAGHWByWZppLlIGGdG1cs', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiS3FpWExQSkk1bFZwaDdMb2ZKVUIwUnhyYzNBSlJBSUNjWnM2VjlabiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792497109),
('vupQc7kNzvMXAeXr4hEcb6CSIfNqOfhrYM6jXWlX', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNUIwR2doOXZTMFVLb3RZUHU4aXg2M21JMHFhUXo2QlZQNEVhaWcySyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792070813),
('wrPNaU0zMnsG5rvm2oAmqcfKNqQTBx0QtJ93dw0z', NULL, '127.0.0.1', 'GuzzleHttp/7', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQ1FabUpQSVBoRWZGNG9oUERoUHdsVnAwbFhvZTZHTGpCMTFWbVo2MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792412752);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `currency_symbol` varchar(10) NOT NULL DEFAULT '₦',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `receipt_footer` varchar(255) DEFAULT NULL,
  `receipt_header` varchar(255) DEFAULT NULL,
  `receipt_width` int(11) NOT NULL DEFAULT 80,
  `print_logo` tinyint(1) NOT NULL DEFAULT 1,
  `print_barcode` tinyint(1) NOT NULL DEFAULT 0,
  `allow_negative_stock` tinyint(1) NOT NULL DEFAULT 0,
  `low_stock_alert` int(11) NOT NULL DEFAULT 10,
  `allow_price_change` tinyint(1) NOT NULL DEFAULT 0,
  `allow_price_override` tinyint(1) NOT NULL DEFAULT 0,
  `enable_discounts` tinyint(1) NOT NULL DEFAULT 1,
  `allow_discount` tinyint(1) NOT NULL DEFAULT 1,
  `enable_customer_credit` tinyint(1) NOT NULL DEFAULT 0,
  `default_customer` varchar(255) DEFAULT NULL,
  `default_customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Africa/Lagos',
  `date_format` varchar(255) NOT NULL DEFAULT 'd-m-Y',
  `time_format` varchar(255) NOT NULL DEFAULT 'h:i A',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_locations`
--

CREATE TABLE `shipping_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_settings`
--

CREATE TABLE `shipping_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `shipping_mode` varchar(30) NOT NULL DEFAULT 'location',
  `manual_shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `count_date` date NOT NULL,
  `status` enum('Draft','In Progress','Completed','Cancelled') NOT NULL DEFAULT 'Draft',
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_count_items`
--

CREATE TABLE `stock_count_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_count_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `system_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `counted_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `variance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `movement_type` enum('Opening Stock','Purchase','Sale','Return','Adjustment','Transfer In','Transfer Out','Damage','Expired') NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(15,2) NOT NULL,
  `stock_before` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_after` decimal(15,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storefronts`
--

CREATE TABLE `storefronts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('Setup','Active','Disabled') NOT NULL DEFAULT 'Setup',
  `theme_key` varchar(50) NOT NULL DEFAULT 'editorial',
  `enabled_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `alternate_phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `credit_limit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sync_devices`
--

CREATE TABLE `sync_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `terminal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_uuid` char(36) NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) NOT NULL DEFAULT 'local',
  `app_version` varchar(255) DEFAULT NULL,
  `database_version` varchar(255) DEFAULT NULL,
  `sync_token_hash` varchar(255) DEFAULT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `last_sync_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sync_devices`
--

INSERT INTO `sync_devices` (`id`, `company_id`, `branch_id`, `terminal_id`, `device_uuid`, `device_name`, `device_type`, `app_version`, `database_version`, `sync_token_hash`, `token_created_at`, `is_active`, `last_seen_at`, `last_sync_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '1c77e876-5fd7-4306-b8d5-8ff3ee1ea905', 'EMNEX Sync Test Device', 'local', '1.0.0', '1.0.0', '$2y$10$BcNCfynBD02.S7pfkm5ouufAPJ/vr6ZDKtX/DynUuduiWdyqN0s1a', '2026-10-14 12:05:20', 1, '2026-10-20 11:17:22', NULL, '2026-10-14 12:05:40', '2026-10-20 11:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `sync_logs`
--

CREATE TABLE `sync_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mutation_uuid` char(36) DEFAULT NULL,
  `entity_sync_uuid` char(36) DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL,
  `direction` varchar(255) NOT NULL DEFAULT 'push',
  `status` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `error` text DEFAULT NULL,
  `duration_ms` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sync_logs`
--

INSERT INTO `sync_logs` (`id`, `company_id`, `device_id`, `mutation_uuid`, `entity_sync_uuid`, `entity`, `operation`, `direction`, `status`, `message`, `error`, `duration_ms`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'e75c5b6d-214c-431c-8cd2-2fd4f2d1d9f8', 'c61e9eee-5d6d-4ee4-908d-0b658a65a01e', 'unit', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 33, '2026-10-14 13:04:08', '2026-10-14 13:04:08'),
(2, 1, 1, '7e68f13b-7ab8-411c-8f74-077585a5a448', '01480936-e702-41ab-b5bc-209b893d7b12', 'tax_rate', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 30, '2026-10-14 13:19:28', '2026-10-14 13:19:28'),
(3, 1, 1, '85f8360a-c164-441b-8464-27e0c898e1d3', '241fce75-1371-4e36-821e-d2186e9716d2', 'discount', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 28, '2026-10-14 13:22:47', '2026-10-14 13:22:47'),
(4, 1, 1, '7438bd2e-d2df-4a6a-bfb8-2aea84cdec1d', 'c8b72c13-63dc-4161-8b4e-aff839f037e1', 'product_category', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 27, '2026-10-14 13:26:03', '2026-10-14 13:26:03'),
(5, 1, 1, '64cc3fdc-3a23-4e29-9050-45e6c9d3099f', 'c8b72c13-63dc-4161-8b4e-aff839f037e1', 'product_category', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 28, '2026-10-14 13:36:08', '2026-10-14 13:36:08'),
(6, 1, 1, '6e34202d-d5fa-49d1-9037-b9b3b1f523d5', 'c61e9eee-5d6d-4ee4-908d-0b658a65a01e', 'unit', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 27, '2026-10-14 13:36:09', '2026-10-14 13:36:09'),
(7, 1, 1, '239e9cd3-0498-4bc4-814c-44d9d441c5e7', '1c7b5633-9d09-4cf7-9342-35cb611ae171', 'tax_rate', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 32, '2026-10-14 13:36:10', '2026-10-14 13:36:10'),
(8, 1, 1, '04bc184c-ee13-40b8-bebc-2892201bd08a', '241fce75-1371-4e36-821e-d2186e9716d2', 'discount', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 33, '2026-10-14 13:36:11', '2026-10-14 13:36:11'),
(9, 1, 1, '793faf91-33f1-403e-8726-418ac63770a5', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 67, '2026-10-14 13:41:12', '2026-10-14 13:41:12'),
(10, 1, 1, '6bd8c140-bc9a-4043-9378-5516ecd6ec15', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 480, '2026-10-15 09:39:06', '2026-10-15 09:39:06'),
(11, 1, 1, '316790fd-52c0-48e2-bb02-3ab3c904a461', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 61, '2026-10-15 09:44:16', '2026-10-15 09:44:16'),
(12, 1, 1, '974d0357-944a-4ddf-8ed4-4870a8478a0d', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 63, '2026-10-15 09:49:47', '2026-10-15 09:49:47'),
(13, 1, 1, 'ffba251f-750e-4349-9275-ed0043e66928', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 65, '2026-10-15 10:24:51', '2026-10-15 10:24:51'),
(14, 1, 1, 'bae02da4-d0e8-48e5-95fb-03c070c67692', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 88, '2026-10-15 10:33:37', '2026-10-15 10:33:37'),
(15, 1, 1, '7d3ff52d-4104-4684-85d8-7e676575096f', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'product', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 61, '2026-10-15 10:41:00', '2026-10-15 10:41:00'),
(16, 1, 1, '8c743f58-56db-434c-a90b-a5e1b069372f', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 78, '2026-10-15 10:50:18', '2026-10-15 10:50:18'),
(17, 1, 1, '38261e7a-d2b2-424a-951a-ae42cd9953e8', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'delete', 'push', 'completed', 'Mutation processed successfully.', NULL, 26, '2026-10-15 10:58:52', '2026-10-15 10:58:52'),
(18, 1, 1, '6ace5987-288c-49e5-b728-2d34cc29e693', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'delete', 'push', 'completed', 'Mutation processed successfully.', NULL, 17, '2026-10-15 11:01:54', '2026-10-15 11:01:54'),
(19, 1, 1, '8dea154c-34a6-40b4-bf6e-4e2d739073dd', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'update', 'push', 'failed', 'The mutation could not be processed.', 'Product [4b1c50ab-8523-465d-b155-bd59f4fe9056] is deleted and cannot be updated.', 30, '2026-10-15 11:04:39', '2026-10-15 11:04:39'),
(20, 1, 1, 'e8f69f1c-f7f5-41a9-8506-5347a7c52250', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 76, '2026-10-15 11:53:46', '2026-10-15 11:53:46'),
(21, 1, 1, '23876392-f6fc-41a3-ad84-00bfff9e6a84', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'product', 'delete', 'push', 'completed', 'Mutation processed successfully.', NULL, 32, '2026-10-15 12:26:53', '2026-10-15 12:26:53'),
(22, 1, 1, 'c5790163-b1de-4e75-bfa3-54fa42cb8d38', '13e586f9-fd0b-40ac-93ef-c963baad42e5', 'branch', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 76, '2026-10-19 10:27:58', '2026-10-19 10:27:58'),
(23, 1, 1, '299e6e35-b179-4203-a116-c8d67ced65dc', '84782dc7-722f-4676-b30e-e994c0c19e81', 'branch', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 46, '2026-10-19 10:30:16', '2026-10-19 10:30:16'),
(24, 1, 1, 'ad8b77f5-e71d-4549-843e-013e5da04cca', '84782dc7-722f-4676-b30e-e994c0c19e81', 'branch', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 42, '2026-10-19 10:34:04', '2026-10-19 10:34:04'),
(25, 1, 1, 'ffa3d07d-ec44-465b-be2e-d68d0340be7c', 'ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5', 'terminal', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 38, '2026-10-19 10:59:09', '2026-10-19 10:59:09'),
(26, 1, 1, '5dd76cb0-3a72-46f1-a4d3-e36db307a801', 'ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5', 'terminal', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 34, '2026-10-19 11:01:33', '2026-10-19 11:01:33'),
(27, 1, 1, '8da29a71-f946-47da-a949-f6c693520232', '1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c', 'terminal', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 61, '2026-10-19 11:21:05', '2026-10-19 11:21:05'),
(28, 1, 1, '2c1c7393-ab05-4246-a43a-e5b90493486c', '006f5ba5-7812-4ebc-807f-3e171cff6f61', 'product_category', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 46, '2026-10-19 11:25:52', '2026-10-19 11:25:52'),
(29, 1, 1, '5ebfded3-5013-4576-ad49-5beccb2da44d', '926d6bd6-f059-460a-b403-1c8c3645f93a', 'unit', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 35, '2026-10-19 11:28:54', '2026-10-19 11:28:54'),
(30, 1, 1, '2362b008-5b07-43b3-b3cf-5bfd44924720', 'b4c04317-0179-47c0-a932-e353479e38fb', 'product', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 325, '2026-10-19 11:32:43', '2026-10-19 11:32:43'),
(31, 1, 1, '78c62a46-27c4-46cc-91a8-d559cd859466', 'b1421326-e248-4242-93ea-b91778709182', 'sale', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 180, '2026-10-19 12:00:06', '2026-10-19 12:00:06'),
(32, 1, 1, 'cd286611-c95e-4308-8080-4faf4424cc0e', 'b1421326-e248-4242-93ea-b91778709182', 'sale', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 107, '2026-10-19 12:05:33', '2026-10-19 12:05:33'),
(33, 1, 1, 'f56c6778-b536-426c-89d5-815f24258fa2', 'b1421326-e248-4242-93ea-b91778709182', 'sale', 'update', 'push', 'completed', 'Mutation processed successfully.', NULL, 99, '2026-10-19 12:07:40', '2026-10-19 12:07:40'),
(34, 1, 1, 'ffa527ae-fa67-4208-8698-0a88ed01596c', 'dd1d27e4-9dc7-4aa9-8f9d-f445b632cc4f', 'sale', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 151, '2026-10-19 12:20:37', '2026-10-19 12:20:37'),
(35, 1, 1, '5977f772-0697-4abb-8443-f724db115b11', '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 'sale', 'create', 'push', 'failed', 'The mutation could not be processed.', 'Terminal [13ca22f1-87e9-4cf8-8b52-8b40cffe38a4] does not exist for this company.', 41, '2026-10-20 09:32:10', '2026-10-20 09:32:10'),
(36, 1, 1, '2e235b6e-8b54-42b6-b055-586348808bca', '13ca22f1-87e9-4cf8-8b52-8b40cffe38a4', 'terminal', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 36, '2026-10-20 10:47:34', '2026-10-20 10:47:34'),
(37, 1, 1, '5977f772-0697-4abb-8443-f724db115b11', '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 'sale', 'create', 'push', 'failed', 'The mutation could not be processed.', 'Payment method [CARD] does not exist for this company.', 117, '2026-10-20 10:51:49', '2026-10-20 10:51:49'),
(38, 1, 1, '5977f772-0697-4abb-8443-f724db115b11', '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 'sale', 'create', 'push', 'failed', 'The mutation could not be processed.', 'SQLSTATE[01000]: Warning: 1265 Data truncated for column \'payment_method\' at row 1 (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: emnex-central, SQL: insert into `payments` (`company_id`, `branch_id`, `order_id`, `customer_id`, `terminal_id`, `amount`, `payment_status`, `payment_method_id`, `payment_method`, `payment_date`, `transaction_reference`, `payment_gateway`, `reference_no`, `remarks`, `received_by`, `payment_number`, `source_payment_number`, `updated_at`, `created_at`) values (1, 1, 4, ?, 4, 1200.00, Completed, 2, Card, 2026-10-20 09:13:53, ?, ?, ORD-000066, Payment received for sales order: ORD-000066, ?, PAY-000050, PAY-000050, 2026-10-20 12:07:35, 2026-10-20 12:07:35))', 119, '2026-10-20 11:07:35', '2026-10-20 11:07:35'),
(39, 1, 1, '5977f772-0697-4abb-8443-f724db115b11', '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 'sale', 'create', 'push', 'completed', 'Mutation processed successfully.', NULL, 101, '2026-10-20 11:17:22', '2026-10-20 11:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `sync_mutations`
--

CREATE TABLE `sync_mutations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `mutation_uuid` char(36) NOT NULL,
  `entity` varchar(255) NOT NULL,
  `entity_sync_uuid` char(36) NOT NULL,
  `operation` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response`)),
  `status` varchar(255) NOT NULL DEFAULT 'processing',
  `error` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sync_mutations`
--

INSERT INTO `sync_mutations` (`id`, `company_id`, `device_id`, `mutation_uuid`, `entity`, `entity_sync_uuid`, `operation`, `payload`, `response`, `status`, `error`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'e75c5b6d-214c-431c-8cd2-2fd4f2d1d9f8', 'unit', 'c61e9eee-5d6d-4ee4-908d-0b658a65a01e', 'create', '{\"unit_code\":\"UNT000001\",\"name\":\"Piece\",\"short_name\":\"PCS\",\"description\":\"Piece\",\"status\":true}', '{\"mutation_uuid\":\"e75c5b6d-214c-431c-8cd2-2fd4f2d1d9f8\",\"entity_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"unit\",\"sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:04:08', '2026-10-14 13:04:07', '2026-10-14 13:04:08'),
(2, 1, 1, '7e68f13b-7ab8-411c-8f74-077585a5a448', 'tax_rate', '01480936-e702-41ab-b5bc-209b893d7b12', 'create', '{\"name\":\"No Tax\",\"rate\":0,\"status\":true}', '{\"mutation_uuid\":\"7e68f13b-7ab8-411c-8f74-077585a5a448\",\"entity_sync_uuid\":\"01480936-e702-41ab-b5bc-209b893d7b12\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"tax_rate\",\"sync_uuid\":\"01480936-e702-41ab-b5bc-209b893d7b12\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:19:28', '2026-10-14 13:19:28', '2026-10-14 13:19:28'),
(3, 1, 1, '85f8360a-c164-441b-8464-27e0c898e1d3', 'discount', '241fce75-1371-4e36-821e-d2186e9716d2', 'create', '{\"name\":\"No Discount\",\"type\":\"Percentage\",\"value\":0,\"start_date\":\"2026-07-29\",\"end_date\":\"2036-07-29\",\"is_automatic\":true,\"status\":true}', '{\"mutation_uuid\":\"85f8360a-c164-441b-8464-27e0c898e1d3\",\"entity_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"discount\",\"sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:22:47', '2026-10-14 13:22:46', '2026-10-14 13:22:47'),
(4, 1, 1, '7438bd2e-d2df-4a6a-bfb8-2aea84cdec1d', 'product_category', 'c8b72c13-63dc-4161-8b4e-aff839f037e1', 'create', '{\"category_code\":\"CAT000001\",\"name\":\"Beverages\",\"description\":\"Soft drinks, juices, bottled water and energy drinks.\",\"parent_sync_uuid\":null,\"sort_order\":0,\"status\":true}', '{\"mutation_uuid\":\"7438bd2e-d2df-4a6a-bfb8-2aea84cdec1d\",\"entity_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product_category\",\"sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:26:03', '2026-10-14 13:26:03', '2026-10-14 13:26:03'),
(5, 1, 1, '64cc3fdc-3a23-4e29-9050-45e6c9d3099f', 'product_category', 'c8b72c13-63dc-4161-8b4e-aff839f037e1', 'create', '{\"category_code\":\"CAT000001\",\"name\":\"Beverages\",\"description\":\"Soft drinks, juices, bottled water and energy drinks.\",\"parent_sync_uuid\":null,\"sort_order\":0,\"status\":true}', '{\"mutation_uuid\":\"64cc3fdc-3a23-4e29-9050-45e6c9d3099f\",\"entity_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product_category\",\"sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:36:08', '2026-10-14 13:36:08', '2026-10-14 13:36:08'),
(6, 1, 1, '6e34202d-d5fa-49d1-9037-b9b3b1f523d5', 'unit', 'c61e9eee-5d6d-4ee4-908d-0b658a65a01e', 'create', '{\"unit_code\":\"UNT000001\",\"name\":\"Piece\",\"short_name\":\"PCS\",\"description\":\"Piece\",\"status\":true}', '{\"mutation_uuid\":\"6e34202d-d5fa-49d1-9037-b9b3b1f523d5\",\"entity_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"unit\",\"sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:36:09', '2026-10-14 13:36:09', '2026-10-14 13:36:09'),
(7, 1, 1, '239e9cd3-0498-4bc4-814c-44d9d441c5e7', 'tax_rate', '1c7b5633-9d09-4cf7-9342-35cb611ae171', 'create', '{\"name\":\"VAT 7.5%\",\"rate\":7.5,\"status\":true}', '{\"mutation_uuid\":\"239e9cd3-0498-4bc4-814c-44d9d441c5e7\",\"entity_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"tax_rate\",\"sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:36:10', '2026-10-14 13:36:10', '2026-10-14 13:36:10'),
(8, 1, 1, '04bc184c-ee13-40b8-bebc-2892201bd08a', 'discount', '241fce75-1371-4e36-821e-d2186e9716d2', 'create', '{\"name\":\"No Discount\",\"type\":\"Percentage\",\"value\":0,\"start_date\":\"2026-07-29\",\"end_date\":\"2036-07-29\",\"is_automatic\":true,\"status\":true}', '{\"mutation_uuid\":\"04bc184c-ee13-40b8-bebc-2892201bd08a\",\"entity_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"discount\",\"sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:36:11', '2026-10-14 13:36:11', '2026-10-14 13:36:11'),
(9, 1, 1, '793faf91-33f1-403e-8726-418ac63770a5', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'create', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true}', '{\"mutation_uuid\":\"793faf91-33f1-403e-8726-418ac63770a5\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-14 13:41:12', '2026-10-14 13:41:12', '2026-10-14 13:41:12'),
(10, 1, 1, '6bd8c140-bc9a-4043-9378-5516ecd6ec15', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":\"500ml bottle\"}', '{\"mutation_uuid\":\"6bd8c140-bc9a-4043-9378-5516ecd6ec15\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 09:39:06', '2026-10-15 09:39:06', '2026-10-15 09:39:06'),
(11, 1, 1, '316790fd-52c0-48e2-bb02-3ab3c904a461', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":\"500ml bottle\"}', '{\"mutation_uuid\":\"316790fd-52c0-48e2-bb02-3ab3c904a461\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 09:44:16', '2026-10-15 09:44:16', '2026-10-15 09:44:16'),
(12, 1, 1, '974d0357-944a-4ddf-8ed4-4870a8478a0d', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":\"500ml bottle\"}', '{\"mutation_uuid\":\"974d0357-944a-4ddf-8ed4-4870a8478a0d\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 09:49:47', '2026-10-15 09:49:47', '2026-10-15 09:49:47'),
(13, 1, 1, 'ffba251f-750e-4349-9275-ed0043e66928', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"ffba251f-750e-4349-9275-ed0043e66928\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 10:24:51', '2026-10-15 10:24:51', '2026-10-15 10:24:51'),
(14, 1, 1, 'bae02da4-d0e8-48e5-95fb-03c070c67692', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":11,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"bae02da4-d0e8-48e5-95fb-03c070c67692\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 10:33:37', '2026-10-15 10:33:37', '2026-10-15 10:33:37'),
(15, 1, 1, '7d3ff52d-4104-4684-85d8-7e676575096f', 'product', '26b06031-8503-4b3f-aa34-64f5bff690bd', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"PRD000001\",\"sku\":\"COKE50CL\",\"barcode\":\"100000000001\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"7d3ff52d-4104-4684-85d8-7e676575096f\",\"entity_sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"26b06031-8503-4b3f-aa34-64f5bff690bd\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 10:41:00', '2026-10-15 10:41:00', '2026-10-15 10:41:00'),
(16, 1, 1, '8c743f58-56db-434c-a90b-a5e1b069372f', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'create', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"SYNCDEL-AIHF6KBL\",\"sku\":\"SYNCDEL-QMYRYTXJ\",\"barcode\":null,\"qr_code\":null,\"name\":\"Sync Delete Test Product\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"8c743f58-56db-434c-a90b-a5e1b069372f\",\"entity_sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 10:50:18', '2026-10-15 10:50:18', '2026-10-15 10:50:18'),
(17, 1, 1, '38261e7a-d2b2-424a-951a-ae42cd9953e8', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'delete', '[]', '{\"mutation_uuid\":\"38261e7a-d2b2-424a-951a-ae42cd9953e8\",\"entity_sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"action\":\"deleted\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 10:58:52', '2026-10-15 10:58:52', '2026-10-15 10:58:52'),
(18, 1, 1, '6ace5987-288c-49e5-b728-2d34cc29e693', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'delete', '[]', '{\"mutation_uuid\":\"6ace5987-288c-49e5-b728-2d34cc29e693\",\"entity_sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"action\":\"already_deleted\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 11:01:54', '2026-10-15 11:01:54', '2026-10-15 11:01:54'),
(19, 1, 1, '8dea154c-34a6-40b4-bf6e-4e2d739073dd', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'update', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"SYNCDEL-AIHF6KBL\",\"sku\":\"SYNCDEL-QMYRYTXJ\",\"barcode\":null,\"qr_code\":null,\"name\":\"Sync Delete Test Product\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', NULL, 'failed', 'Product [4b1c50ab-8523-465d-b155-bd59f4fe9056] is deleted and cannot be updated.', NULL, '2026-10-15 11:04:39', '2026-10-15 11:04:39'),
(20, 1, 1, 'e8f69f1c-f7f5-41a9-8506-5347a7c52250', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'create', '{\"product_category_sync_uuid\":\"c8b72c13-63dc-4161-8b4e-aff839f037e1\",\"unit_sync_uuid\":\"c61e9eee-5d6d-4ee4-908d-0b658a65a01e\",\"tax_rate_sync_uuid\":\"1c7b5633-9d09-4cf7-9342-35cb611ae171\",\"discount_sync_uuid\":\"241fce75-1371-4e36-821e-d2186e9716d2\",\"product_code\":\"SYNCDEL-AIHF6KBL\",\"sku\":\"SYNCDEL-QMYRYTXJ\",\"barcode\":null,\"qr_code\":null,\"name\":\"Sync Delete Test Product\",\"description\":null,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"cost_price\":500,\"selling_price\":700,\"track_stock\":true,\"minimum_stock\":10,\"maximum_stock\":2000,\"weight\":null,\"expiry_date\":\"2026-09-23\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"e8f69f1c-f7f5-41a9-8506-5347a7c52250\",\"entity_sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"action\":\"restored\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 11:53:46', '2026-10-15 11:53:46', '2026-10-15 11:53:46'),
(21, 1, 1, '23876392-f6fc-41a3-ad84-00bfff9e6a84', 'product', '4b1c50ab-8523-465d-b155-bd59f4fe9056', 'delete', '[]', '{\"mutation_uuid\":\"23876392-f6fc-41a3-ad84-00bfff9e6a84\",\"entity_sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"4b1c50ab-8523-465d-b155-bd59f4fe9056\",\"action\":\"deleted\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-15 12:26:53', '2026-10-15 12:26:53', '2026-10-15 12:26:53'),
(22, 1, 1, 'c5790163-b1de-4e75-bfa3-54fa42cb8d38', 'branch', '13e586f9-fd0b-40ac-93ef-c963baad42e5', 'create', '{\"branch_code\":\"BR003\",\"name\":\"Ajah Outlet New\",\"phone\":\"07034657383\",\"email\":\"ajah@emmanexitconsult.com\",\"address\":\"Agbado, Ajah express way, Lagos.\",\"is_head_office\":false,\"status\":true}', '{\"mutation_uuid\":\"c5790163-b1de-4e75-bfa3-54fa42cb8d38\",\"entity_sync_uuid\":\"13e586f9-fd0b-40ac-93ef-c963baad42e5\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"branch\",\"sync_uuid\":\"13e586f9-fd0b-40ac-93ef-c963baad42e5\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 10:27:58', '2026-10-19 10:27:58', '2026-10-19 10:27:58'),
(23, 1, 1, '299e6e35-b179-4203-a116-c8d67ced65dc', 'branch', '84782dc7-722f-4676-b30e-e994c0c19e81', 'create', '{\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07038899203\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikorodu, Lagos.\",\"is_head_office\":false,\"status\":true}', '{\"mutation_uuid\":\"299e6e35-b179-4203-a116-c8d67ced65dc\",\"entity_sync_uuid\":\"84782dc7-722f-4676-b30e-e994c0c19e81\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"branch\",\"sync_uuid\":\"84782dc7-722f-4676-b30e-e994c0c19e81\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 10:30:16', '2026-10-19 10:30:16', '2026-10-19 10:30:16'),
(24, 1, 1, 'ad8b77f5-e71d-4549-843e-013e5da04cca', 'branch', '84782dc7-722f-4676-b30e-e994c0c19e81', 'update', '{\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet Updated\",\"phone\":\"07038899203\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikorodu, Lagos.\",\"is_head_office\":false,\"status\":true}', '{\"mutation_uuid\":\"ad8b77f5-e71d-4549-843e-013e5da04cca\",\"entity_sync_uuid\":\"84782dc7-722f-4676-b30e-e994c0c19e81\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"branch\",\"sync_uuid\":\"84782dc7-722f-4676-b30e-e994c0c19e81\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 10:34:04', '2026-10-19 10:34:04', '2026-10-19 10:34:04'),
(25, 1, 1, 'ffa3d07d-ec44-465b-be2e-d68d0340be7c', 'terminal', 'ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5', 'create', '{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_code\":\"BR001-POS02\",\"terminal_name\":\"Head Office POS 2\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true}', '{\"mutation_uuid\":\"ffa3d07d-ec44-465b-be2e-d68d0340be7c\",\"entity_sync_uuid\":\"ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"terminal\",\"sync_uuid\":\"ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 10:59:09', '2026-10-19 10:59:09', '2026-10-19 10:59:09'),
(26, 1, 1, '5dd76cb0-3a72-46f1-a4d3-e36db307a801', 'terminal', 'ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5', 'update', '{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_code\":\"BR001-POS02\",\"terminal_name\":\"Head Office POS 2 Updated\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true}', '{\"mutation_uuid\":\"5dd76cb0-3a72-46f1-a4d3-e36db307a801\",\"entity_sync_uuid\":\"ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"terminal\",\"sync_uuid\":\"ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5\",\"action\":\"updated\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 11:01:33', '2026-10-19 11:01:33', '2026-10-19 11:01:33'),
(27, 1, 1, '8da29a71-f946-47da-a949-f6c693520232', 'terminal', '1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c', 'create', '{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true}', '{\"mutation_uuid\":\"8da29a71-f946-47da-a949-f6c693520232\",\"entity_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"terminal\",\"sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 11:21:05', '2026-10-19 11:21:05', '2026-10-19 11:21:05'),
(28, 1, 1, '2c1c7393-ab05-4246-a43a-e5b90493486c', 'product_category', '006f5ba5-7812-4ebc-807f-3e171cff6f61', 'create', '{\"category_code\":\"CAT000005\",\"name\":\"Dairy\",\"description\":\"Milk, butter, cheese and yoghurt.\",\"parent_sync_uuid\":null,\"sort_order\":0,\"status\":true}', '{\"mutation_uuid\":\"2c1c7393-ab05-4246-a43a-e5b90493486c\",\"entity_sync_uuid\":\"006f5ba5-7812-4ebc-807f-3e171cff6f61\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product_category\",\"sync_uuid\":\"006f5ba5-7812-4ebc-807f-3e171cff6f61\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 11:25:52', '2026-10-19 11:25:52', '2026-10-19 11:25:52'),
(29, 1, 1, '5ebfded3-5013-4576-ad49-5beccb2da44d', 'unit', '926d6bd6-f059-460a-b403-1c8c3645f93a', 'create', '{\"unit_code\":\"UNT000005\",\"name\":\"Can\",\"short_name\":\"CAN\",\"description\":null,\"status\":true}', '{\"mutation_uuid\":\"5ebfded3-5013-4576-ad49-5beccb2da44d\",\"entity_sync_uuid\":\"926d6bd6-f059-460a-b403-1c8c3645f93a\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"unit\",\"sync_uuid\":\"926d6bd6-f059-460a-b403-1c8c3645f93a\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 11:28:54', '2026-10-19 11:28:54', '2026-10-19 11:28:54'),
(30, 1, 1, '2362b008-5b07-43b3-b3cf-5bfd44924720', 'product', 'b4c04317-0179-47c0-a932-e353479e38fb', 'create', '{\"product_category_sync_uuid\":\"006f5ba5-7812-4ebc-807f-3e171cff6f61\",\"unit_sync_uuid\":\"926d6bd6-f059-460a-b403-1c8c3645f93a\",\"tax_rate_sync_uuid\":null,\"discount_sync_uuid\":null,\"product_code\":\"PRD000011\",\"sku\":null,\"barcode\":\"TH123456\",\"qr_code\":null,\"name\":\"Three Crown Evaporated Milk\",\"description\":\"Three Crown Evaporated Milk\",\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"cost_price\":1000,\"selling_price\":1200,\"track_stock\":true,\"minimum_stock\":100,\"maximum_stock\":1635,\"weight\":null,\"expiry_date\":\"2027-11-25\",\"status\":true,\"taxable\":true,\"dimensions\":null}', '{\"mutation_uuid\":\"2362b008-5b07-43b3-b3cf-5bfd44924720\",\"entity_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"product\",\"sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 11:32:43', '2026-10-19 11:32:42', '2026-10-19 11:32:43'),
(31, 1, 1, '78c62a46-27c4-46cc-91a8-d559cd859466', 'sale', 'b1421326-e248-4242-93ea-b91778709182', 'create', '{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"order\":{\"order_no\":\"ORD-000064\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-10-19 09:34:02\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"shipping_method\":null,\"shipping_location_name\":null,\"shipping_address\":null,\"shipping_city\":null,\"shipping_state\":null,\"shipping_fee\":\"0.00\",\"fulfilment_status\":null,\"tracking_reference\":null,\"shipping_notes\":null,\"shipped_at\":null,\"delivered_at\":null},\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}],\"invoice\":{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"invoice_no\":\"INV-000051\",\"invoice_date\":\"2026-10-19\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}]},\"payments\":[{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"payment_number\":\"PAY-000048\",\"payment_method_code\":\"CASH\",\"payment_method\":\"Cash\",\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_date\":\"2026-10-19 09:34:02\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null}]}', '{\"mutation_uuid\":\"78c62a46-27c4-46cc-91a8-d559cd859466\",\"entity_sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"sale\",\"sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"action\":\"created\",\"order_id\":1,\"order_no\":\"ORD-000064\",\"source_order_no\":\"ORD-000064\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 12:00:06', '2026-10-19 12:00:06', '2026-10-19 12:00:06'),
(32, 1, 1, 'cd286611-c95e-4308-8080-4faf4424cc0e', 'sale', 'b1421326-e248-4242-93ea-b91778709182', 'create', '{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"order\":{\"order_no\":\"ORD-000064\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-10-19 09:34:02\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"shipping_method\":null,\"shipping_location_name\":null,\"shipping_address\":null,\"shipping_city\":null,\"shipping_state\":null,\"shipping_fee\":\"0.00\",\"fulfilment_status\":null,\"tracking_reference\":null,\"shipping_notes\":null,\"shipped_at\":null,\"delivered_at\":null},\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}],\"invoice\":{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"invoice_no\":\"INV-000051\",\"invoice_date\":\"2026-10-19\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}]},\"payments\":[{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"payment_number\":\"PAY-000048\",\"payment_method_code\":\"CASH\",\"payment_method\":\"Cash\",\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_date\":\"2026-10-19 09:34:02\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null}]}', '{\"mutation_uuid\":\"cd286611-c95e-4308-8080-4faf4424cc0e\",\"entity_sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"sale\",\"sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"action\":\"updated\",\"order_id\":1,\"order_no\":\"ORD-000064\",\"source_order_no\":\"ORD-000064\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 12:05:33', '2026-10-19 12:05:33', '2026-10-19 12:05:33'),
(33, 1, 1, 'f56c6778-b536-426c-89d5-815f24258fa2', 'sale', 'b1421326-e248-4242-93ea-b91778709182', 'update', '{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"order\":{\"order_no\":\"ORD-000064\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-10-19 09:34:02\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"shipping_method\":null,\"shipping_location_name\":null,\"shipping_address\":null,\"shipping_city\":null,\"shipping_state\":null,\"shipping_fee\":\"0.00\",\"fulfilment_status\":null,\"tracking_reference\":null,\"shipping_notes\":null,\"shipped_at\":null,\"delivered_at\":null},\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}],\"invoice\":{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"invoice_no\":\"INV-000051\",\"invoice_date\":\"2026-10-19\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}]},\"payments\":[{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"payment_number\":\"PAY-000048\",\"payment_method_code\":\"CASH\",\"payment_method\":\"Cash\",\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_date\":\"2026-10-19 09:34:02\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null}]}', '{\"mutation_uuid\":\"f56c6778-b536-426c-89d5-815f24258fa2\",\"entity_sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"sale\",\"sync_uuid\":\"b1421326-e248-4242-93ea-b91778709182\",\"action\":\"updated\",\"order_id\":1,\"order_no\":\"ORD-000064\",\"source_order_no\":\"ORD-000064\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 12:07:40', '2026-10-19 12:07:40', '2026-10-19 12:07:40'),
(34, 1, 1, 'ffa527ae-fa67-4208-8698-0a88ed01596c', 'sale', 'dd1d27e4-9dc7-4aa9-8f9d-f445b632cc4f', 'create', '{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"order\":{\"order_no\":\"ORD-000065\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-10-19 13:16:42\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"shipping_method\":null,\"shipping_location_name\":null,\"shipping_address\":null,\"shipping_city\":null,\"shipping_state\":null,\"shipping_fee\":\"0.00\",\"fulfilment_status\":null,\"tracking_reference\":null,\"shipping_notes\":null,\"shipped_at\":null,\"delivered_at\":null},\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}],\"invoice\":{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"invoice_no\":\"INV-000052\",\"invoice_date\":\"2026-10-19\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}]},\"payments\":[{\"branch_sync_uuid\":\"187a46bb-189a-486d-b576-007001a8a150\",\"terminal_sync_uuid\":\"1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c\",\"payment_number\":\"PAY-000049\",\"payment_method_code\":\"CASH\",\"payment_method\":\"Cash\",\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_date\":\"2026-10-19 13:16:42\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null}]}', '{\"mutation_uuid\":\"ffa527ae-fa67-4208-8698-0a88ed01596c\",\"entity_sync_uuid\":\"dd1d27e4-9dc7-4aa9-8f9d-f445b632cc4f\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"sale\",\"sync_uuid\":\"dd1d27e4-9dc7-4aa9-8f9d-f445b632cc4f\",\"action\":\"created\",\"order_id\":2,\"order_no\":\"ORD-000065\",\"source_order_no\":\"ORD-000065\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-19 12:20:37', '2026-10-19 12:20:37', '2026-10-19 12:20:37'),
(35, 1, 1, '5977f772-0697-4abb-8443-f724db115b11', 'sale', '48a48591-9b4c-4625-9aa4-d1f3dd56eb8d', 'create', '{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_sync_uuid\":\"13ca22f1-87e9-4cf8-8b52-8b40cffe38a4\",\"order\":{\"order_no\":\"ORD-000066\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":\"2026-10-20 09:13:53\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"shipping_method\":null,\"shipping_location_name\":null,\"shipping_address\":null,\"shipping_city\":null,\"shipping_state\":null,\"shipping_fee\":\"0.00\",\"fulfilment_status\":null,\"tracking_reference\":null,\"shipping_notes\":null,\"shipped_at\":null,\"delivered_at\":null},\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}],\"invoice\":{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_sync_uuid\":\"13ca22f1-87e9-4cf8-8b52-8b40cffe38a4\",\"invoice_no\":\"INV-000053\",\"invoice_date\":\"2026-10-20\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1200.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"items\":[{\"product_sync_uuid\":\"b4c04317-0179-47c0-a932-e353479e38fb\",\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\"}]},\"payments\":[{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_sync_uuid\":\"13ca22f1-87e9-4cf8-8b52-8b40cffe38a4\",\"payment_number\":\"PAY-000050\",\"payment_method_code\":\"CARD\",\"payment_method\":\"Card\",\"amount\":\"1200.00\",\"payment_status\":\"Completed\",\"payment_date\":\"2026-10-20 09:13:53\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"ORD-000066\",\"remarks\":\"Payment received for sales order: ORD-000066\"}]}', '{\"mutation_uuid\":\"5977f772-0697-4abb-8443-f724db115b11\",\"entity_sync_uuid\":\"48a48591-9b4c-4625-9aa4-d1f3dd56eb8d\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"sale\",\"sync_uuid\":\"48a48591-9b4c-4625-9aa4-d1f3dd56eb8d\",\"action\":\"created\",\"order_id\":5,\"order_no\":\"ORD-000066\",\"source_order_no\":\"ORD-000066\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-20 11:17:22', '2026-10-20 09:32:10', '2026-10-20 11:17:22'),
(36, 1, 1, '2e235b6e-8b54-42b6-b055-586348808bca', 'terminal', '13ca22f1-87e9-4cf8-8b52-8b40cffe38a4', 'create', '{\"branch_sync_uuid\":\"4e4add8f-63ff-4171-9c6a-f750458b806b\",\"terminal_code\":\"BR001-POS01\",\"terminal_name\":\"Head Office POS 1\",\"description\":\"Main Checkout\",\"device_name\":\"Desktop POS\",\"ip_address\":\"192.168.0.23\",\"status\":true}', '{\"mutation_uuid\":\"2e235b6e-8b54-42b6-b055-586348808bca\",\"entity_sync_uuid\":\"13ca22f1-87e9-4cf8-8b52-8b40cffe38a4\",\"accepted\":true,\"processed\":true,\"result\":{\"entity\":\"terminal\",\"sync_uuid\":\"13ca22f1-87e9-4cf8-8b52-8b40cffe38a4\",\"action\":\"created\"},\"message\":\"Mutation processed successfully.\"}', 'completed', NULL, '2026-10-20 10:47:34', '2026-10-20 10:47:34', '2026-10-20 10:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `sync_queue`
--

CREATE TABLE `sync_queue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `mutation_uuid` char(36) NOT NULL,
  `entity` varchar(255) NOT NULL,
  `entity_sync_uuid` char(36) NOT NULL,
  `operation` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `attempts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `available_at` timestamp NULL DEFAULT NULL,
  `processing_started_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `last_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `sync_uuid`, `company_id`, `name`, `rate`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '01480936-e702-41ab-b5bc-209b893d7b12', 1, 'No Tax', 0.00, 1, '2026-10-14 13:19:28', '2026-10-14 13:19:28', NULL),
(2, '1c7b5633-9d09-4cf7-9342-35cb611ae171', 1, 'VAT 7.5%', 7.50, 1, '2026-10-14 13:36:10', '2026-10-14 13:36:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminals`
--

CREATE TABLE `terminals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_code` varchar(255) NOT NULL,
  `terminal_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terminals`
--

INSERT INTO `terminals` (`id`, `sync_uuid`, `company_id`, `branch_id`, `terminal_code`, `terminal_name`, `description`, `device_name`, `ip_address`, `status`, `last_seen_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5b5cc01c-1f42-4a45-89a8-c3c03ede4494', 1, 2, 'BR002-POS01', 'Lekki Branch POS 1', NULL, 'Desktop POS', NULL, 1, NULL, '2026-10-19 10:52:16', '2026-10-19 10:52:16', NULL),
(2, 'ff13c88f-1311-46fe-bf19-eb8cdc1f0fb5', 1, 1, 'BR001-POS02', 'Head Office POS 2 Updated', NULL, 'Desktop POS', NULL, 1, NULL, '2026-10-19 10:59:09', '2026-10-19 11:01:33', NULL),
(3, '1ad86dea-97fa-4a4a-b3a9-b40b2d49c62c', 1, 2, 'Lek-Pos3', 'Lekki-Pos3', NULL, 'Desktop POS', NULL, 1, NULL, '2026-10-19 11:21:05', '2026-10-19 11:21:05', NULL),
(4, '13ca22f1-87e9-4cf8-8b52-8b40cffe38a4', 1, 1, 'BR001-POS01', 'Head Office POS 1', 'Main Checkout', 'Desktop POS', '192.168.0.23', 1, NULL, '2026-10-20 10:47:34', '2026-10-20 10:47:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminal_assignments`
--

CREATE TABLE `terminal_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `unassigned_at` timestamp NULL DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sync_uuid` char(36) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `unit_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `sync_uuid`, `company_id`, `unit_code`, `name`, `short_name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'c61e9eee-5d6d-4ee4-908d-0b658a65a01e', 1, 'UNT000001', 'Piece', 'PCS', 'Piece', 1, NULL, NULL, '2026-10-14 13:04:08', '2026-10-14 13:04:08', NULL),
(2, '926d6bd6-f059-460a-b403-1c8c3645f93a', 1, 'UNT000005', 'Can', 'CAN', NULL, 1, NULL, NULL, '2026-10-19 11:28:54', '2026-10-19 11:28:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_no` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_owner` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `employment_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `force_password_change` tinyint(1) NOT NULL DEFAULT 0,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_company_id_foreign` (`company_id`),
  ADD KEY `activity_logs_branch_id_foreign` (`branch_id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `activity_logs_terminal_id_foreign` (`terminal_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `branches_branch_code_unique` (`branch_code`),
  ADD UNIQUE KEY `branches_company_id_sync_uuid_unique` (`company_id`,`sync_uuid`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_drawers_branch_id_foreign` (`branch_id`),
  ADD KEY `cash_drawers_terminal_id_foreign` (`terminal_id`),
  ADD KEY `cash_drawers_opened_by_foreign` (`opened_by`),
  ADD KEY `cash_drawers_closed_by_foreign` (`closed_by`),
  ADD KEY `cash_drawers_company_id_branch_id_terminal_id_status_index` (`company_id`,`branch_id`,`terminal_id`,`status`);

--
-- Indexes for table `cash_drawer_transactions`
--
ALTER TABLE `cash_drawer_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_drawer_transactions_branch_id_foreign` (`branch_id`),
  ADD KEY `cash_drawer_transactions_terminal_id_foreign` (`terminal_id`),
  ADD KEY `cash_drawer_transactions_payment_id_foreign` (`payment_id`),
  ADD KEY `cash_drawer_transactions_order_id_foreign` (`order_id`),
  ADD KEY `cash_drawer_transactions_created_by_foreign` (`created_by`),
  ADD KEY `cash_drawer_transactions_cash_drawer_id_transaction_type_index` (`cash_drawer_id`,`transaction_type`),
  ADD KEY `cash_drawer_transactions_company_id_branch_id_terminal_id_index` (`company_id`,`branch_id`,`terminal_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_company_code_unique` (`company_code`),
  ADD UNIQUE KEY `companies_slug_unique` (`slug`),
  ADD KEY `companies_last_activity_at_index` (`last_activity_at`),
  ADD KEY `companies_lifecycle_status_index` (`lifecycle_status`);

--
-- Indexes for table `company_archives`
--
ALTER TABLE `company_archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_archives_requested_by_foreign` (`requested_by`),
  ADD KEY `company_archives_original_company_id_index` (`original_company_id`),
  ADD KEY `company_archives_status_index` (`status`);

--
-- Indexes for table `company_business_profiles`
--
ALTER TABLE `company_business_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_business_profiles_company_id_unique` (`company_id`),
  ADD KEY `company_business_profiles_profile_key_index` (`profile_key`);

--
-- Indexes for table `company_lifecycle_events`
--
ALTER TABLE `company_lifecycle_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_lifecycle_events_platform_admin_id_foreign` (`platform_admin_id`),
  ADD KEY `company_lifecycle_events_company_id_index` (`company_id`),
  ADD KEY `company_lifecycle_events_archive_id_index` (`archive_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_company_id_customer_code_unique` (`company_id`,`customer_code`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_updated_by_foreign` (`updated_by`),
  ADD KEY `customers_branch_id_foreign` (`branch_id`),
  ADD KEY `customers_customer_group_id_foreign` (`customer_group_id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_groups_company_id_code_unique` (`company_id`,`code`),
  ADD KEY `customer_groups_created_by_foreign` (`created_by`),
  ADD KEY `customer_groups_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `data_lifecycle_settings`
--
ALTER TABLE `data_lifecycle_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_lifecycle_settings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `discounts_sync_uuid_unique` (`sync_uuid`);

--
-- Indexes for table `document_sequences`
--
ALTER TABLE `document_sequences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_sequences_company_id_document_type_unique` (`company_id`,`document_type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `goods_received`
--
ALTER TABLE `goods_received`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `goods_received_company_id_receipt_number_unique` (`company_id`,`receipt_number`),
  ADD KEY `goods_received_branch_id_foreign` (`branch_id`),
  ADD KEY `goods_received_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `goods_received_supplier_id_foreign` (`supplier_id`),
  ADD KEY `goods_received_received_by_foreign` (`received_by`),
  ADD KEY `goods_received_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `goods_received_company_id_supplier_id_index` (`company_id`,`supplier_id`),
  ADD KEY `goods_received_company_id_purchase_order_id_index` (`company_id`,`purchase_order_id`),
  ADD KEY `goods_received_company_id_status_index` (`company_id`,`status`),
  ADD KEY `goods_received_company_id_received_date_index` (`company_id`,`received_date`);

--
-- Indexes for table `goods_received_items`
--
ALTER TABLE `goods_received_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_received_items_goods_received_id_index` (`goods_received_id`),
  ADD KEY `goods_received_items_purchase_order_item_id_index` (`purchase_order_item_id`),
  ADD KEY `goods_received_items_product_id_index` (`product_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_order_id_unique` (`order_id`),
  ADD KEY `invoices_branch_id_foreign` (`branch_id`),
  ADD KEY `invoices_terminal_id_foreign` (`terminal_id`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`),
  ADD KEY `invoices_updated_by_foreign` (`updated_by`),
  ADD KEY `invoices_company_id_invoice_no_index` (`company_id`,`invoice_no`),
  ADD KEY `invoices_company_id_invoice_status_index` (`company_id`,`invoice_status`),
  ADD KEY `invoices_company_id_payment_status_index` (`company_id`,`payment_status`),
  ADD KEY `invoices_company_id_invoice_date_index` (`company_id`,`invoice_date`),
  ADD KEY `invoices_company_id_branch_id_index` (`company_id`,`branch_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_product_id_foreign` (`product_id`),
  ADD KEY `invoice_items_company_id_invoice_id_index` (`company_id`,`invoice_id`),
  ADD KEY `invoice_items_company_id_product_id_index` (`company_id`,`product_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
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
  ADD UNIQUE KEY `orders_company_id_order_no_unique` (`company_id`,`order_no`),
  ADD UNIQUE KEY `orders_public_token_unique` (`public_token`),
  ADD UNIQUE KEY `orders_company_id_sync_uuid_unique` (`company_id`,`sync_uuid`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_discount_id_foreign` (`discount_id`),
  ADD KEY `orders_tax_rate_id_foreign` (`tax_rate_id`),
  ADD KEY `orders_terminal_id_foreign` (`terminal_id`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`),
  ADD KEY `orders_cashier_id_foreign` (`cashier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_company_id_foreign` (`company_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_payment_number_unique` (`payment_number`),
  ADD KEY `payments_company_id_foreign` (`company_id`),
  ADD KEY `payments_branch_id_foreign` (`branch_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_terminal_id_foreign` (`terminal_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_company_id_code_unique` (`company_id`,`code`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_company_id_name_unique` (`company_id`,`name`);

--
-- Indexes for table `platform_admins`
--
ALTER TABLE `platform_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform_admins_email_unique` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_company_id_product_code_unique` (`company_id`,`product_code`),
  ADD UNIQUE KEY `products_company_id_barcode_unique` (`company_id`,`barcode`),
  ADD UNIQUE KEY `products_company_id_sku_unique` (`company_id`,`sku`),
  ADD UNIQUE KEY `products_sync_uuid_unique` (`sync_uuid`),
  ADD KEY `products_product_category_id_foreign` (`product_category_id`),
  ADD KEY `products_discount_id_foreign` (`discount_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_tax_rate_id_foreign` (`tax_rate_id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_company_id_category_code_unique` (`company_id`,`category_code`),
  ADD UNIQUE KEY `product_categories_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `product_categories_sync_uuid_unique` (`sync_uuid`),
  ADD KEY `product_categories_parent_id_foreign` (`parent_id`),
  ADD KEY `product_categories_created_by_foreign` (`created_by`),
  ADD KEY `product_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_company_id_product_id_index` (`company_id`,`product_id`),
  ADD KEY `product_images_product_id_sort_order_index` (`product_id`,`sort_order`),
  ADD KEY `product_images_product_id_is_primary_index` (`product_id`,`is_primary`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_stocks_company_id_branch_id_product_id_unique` (`company_id`,`branch_id`,`product_id`),
  ADD KEY `product_stocks_branch_id_foreign` (`branch_id`),
  ADD KEY `product_stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_company_id_order_number_unique` (`company_id`,`order_number`),
  ADD KEY `purchase_orders_branch_id_foreign` (`branch_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_orders_created_by_foreign` (`created_by`),
  ADD KEY `purchase_orders_approved_by_foreign` (`approved_by`),
  ADD KEY `purchase_orders_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `purchase_orders_company_id_supplier_id_index` (`company_id`,`supplier_id`),
  ADD KEY `purchase_orders_company_id_status_index` (`company_id`,`status`),
  ADD KEY `purchase_orders_company_id_order_date_index` (`company_id`,`order_date`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_index` (`purchase_order_id`),
  ADD KEY `purchase_order_items_product_id_index` (`product_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_returns_company_id_return_number_unique` (`company_id`,`return_number`),
  ADD KEY `purchase_returns_branch_id_foreign` (`branch_id`),
  ADD KEY `purchase_returns_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_returns_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_returns_goods_received_id_foreign` (`goods_received_id`),
  ADD KEY `purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `purchase_returns_approved_by_foreign` (`approved_by`),
  ADD KEY `purchase_returns_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `purchase_returns_company_id_supplier_id_index` (`company_id`,`supplier_id`),
  ADD KEY `purchase_returns_company_id_purchase_order_id_index` (`company_id`,`purchase_order_id`),
  ADD KEY `purchase_returns_company_id_goods_received_id_index` (`company_id`,`goods_received_id`),
  ADD KEY `purchase_returns_company_id_status_index` (`company_id`,`status`),
  ADD KEY `purchase_returns_company_id_return_date_index` (`company_id`,`return_date`);

--
-- Indexes for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_items_purchase_return_id_index` (`purchase_return_id`),
  ADD KEY `purchase_return_items_goods_received_item_id_index` (`goods_received_item_id`),
  ADD KEY `purchase_return_items_product_id_index` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_company_id_name_unique` (`company_id`,`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_company_id_role_id_permission_id_unique` (`company_id`,`role_id`,`permission_id`),
  ADD KEY `role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_returns_return_number_unique` (`return_number`),
  ADD KEY `sales_returns_company_id_foreign` (`company_id`),
  ADD KEY `sales_returns_branch_id_foreign` (`branch_id`),
  ADD KEY `sales_returns_terminal_id_foreign` (`terminal_id`),
  ADD KEY `sales_returns_order_id_foreign` (`order_id`),
  ADD KEY `sales_returns_invoice_id_foreign` (`invoice_id`),
  ADD KEY `sales_returns_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_returns_processed_by_foreign` (`processed_by`),
  ADD KEY `sales_returns_created_by_foreign` (`created_by`),
  ADD KEY `sales_returns_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_items_sales_return_id_foreign` (`sales_return_id`),
  ADD KEY `sales_return_items_order_item_id_foreign` (`order_item_id`),
  ADD KEY `sales_return_items_product_id_foreign` (`product_id`),
  ADD KEY `sales_return_items_company_id_sales_return_id_index` (`company_id`,`sales_return_id`),
  ADD KEY `sales_return_items_company_id_order_item_id_index` (`company_id`,`order_item_id`),
  ADD KEY `sales_return_items_company_id_product_id_index` (`company_id`,`product_id`);

--
-- Indexes for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_payments_sales_return_id_foreign` (`sales_return_id`),
  ADD KEY `sales_return_payments_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_company_id_unique` (`company_id`),
  ADD KEY `settings_default_customer_id_foreign` (`default_customer_id`);

--
-- Indexes for table `shipping_locations`
--
ALTER TABLE `shipping_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_locations_company_id_status_index` (`company_id`,`status`);

--
-- Indexes for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_counts_branch_id_foreign` (`branch_id`),
  ADD KEY `stock_counts_created_by_foreign` (`created_by`),
  ADD KEY `stock_counts_completed_by_foreign` (`completed_by`),
  ADD KEY `stock_counts_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `stock_counts_company_id_status_index` (`company_id`,`status`),
  ADD KEY `stock_counts_reference_no_index` (`reference_no`);

--
-- Indexes for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_count_items_stock_count_id_product_id_unique` (`stock_count_id`,`product_id`),
  ADD KEY `stock_count_items_product_id_index` (`product_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_company_id_foreign` (`company_id`),
  ADD KEY `stock_movements_branch_id_foreign` (`branch_id`),
  ADD KEY `stock_movements_product_id_foreign` (`product_id`),
  ADD KEY `stock_movements_order_id_foreign` (`order_id`),
  ADD KEY `stock_movements_created_by_foreign` (`created_by`);

--
-- Indexes for table `storefronts`
--
ALTER TABLE `storefronts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `storefronts_company_id_unique` (`company_id`),
  ADD UNIQUE KEY `storefronts_slug_unique` (`slug`),
  ADD KEY `storefronts_created_by_foreign` (`created_by`),
  ADD KEY `storefronts_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_company_id_supplier_code_unique` (`company_id`,`supplier_code`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`),
  ADD KEY `suppliers_company_id_name_index` (`company_id`,`name`),
  ADD KEY `suppliers_company_id_status_index` (`company_id`,`status`),
  ADD KEY `suppliers_company_id_email_index` (`company_id`,`email`),
  ADD KEY `suppliers_company_id_phone_index` (`company_id`,`phone`);

--
-- Indexes for table `sync_devices`
--
ALTER TABLE `sync_devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sync_devices_device_uuid_unique` (`device_uuid`),
  ADD KEY `sync_devices_branch_id_foreign` (`branch_id`),
  ADD KEY `sync_devices_terminal_id_foreign` (`terminal_id`),
  ADD KEY `sync_devices_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `sync_devices_company_id_is_active_index` (`company_id`,`is_active`);

--
-- Indexes for table `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sync_logs_company_id_created_at_index` (`company_id`,`created_at`),
  ADD KEY `sync_logs_device_id_created_at_index` (`device_id`,`created_at`),
  ADD KEY `sync_logs_mutation_uuid_index` (`mutation_uuid`),
  ADD KEY `sync_logs_status_index` (`status`);

--
-- Indexes for table `sync_mutations`
--
ALTER TABLE `sync_mutations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sync_mutations_mutation_uuid_unique` (`mutation_uuid`),
  ADD KEY `sync_mutations_company_id_device_id_index` (`company_id`,`device_id`),
  ADD KEY `sync_mutations_entity_entity_sync_uuid_index` (`entity`,`entity_sync_uuid`),
  ADD KEY `sync_mutations_device_id_created_at_index` (`device_id`,`created_at`),
  ADD KEY `sync_mutations_status_index` (`status`);

--
-- Indexes for table `sync_queue`
--
ALTER TABLE `sync_queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sync_queue_mutation_uuid_unique` (`mutation_uuid`),
  ADD KEY `sync_queue_company_id_status_index` (`company_id`,`status`),
  ADD KEY `sync_queue_device_id_status_index` (`device_id`,`status`),
  ADD KEY `sync_queue_entity_entity_sync_uuid_index` (`entity`,`entity_sync_uuid`),
  ADD KEY `sync_queue_status_available_at_index` (`status`,`available_at`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_rates_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `tax_rates_sync_uuid_unique` (`sync_uuid`);

--
-- Indexes for table `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terminals_company_id_terminal_code_unique` (`company_id`,`terminal_code`),
  ADD UNIQUE KEY `terminals_company_id_sync_uuid_unique` (`company_id`,`sync_uuid`),
  ADD KEY `terminals_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `terminal_assignments`
--
ALTER TABLE `terminal_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terminal_assignments_branch_id_foreign` (`branch_id`),
  ADD KEY `terminal_assignments_terminal_id_foreign` (`terminal_id`),
  ADD KEY `terminal_assignments_user_id_foreign` (`user_id`),
  ADD KEY `terminal_assignments_created_by_foreign` (`created_by`),
  ADD KEY `terminal_assignments_updated_by_foreign` (`updated_by`),
  ADD KEY `terminal_assignments_company_id_branch_id_index` (`company_id`,`branch_id`),
  ADD KEY `terminal_assignments_company_id_terminal_id_index` (`company_id`,`terminal_id`),
  ADD KEY `terminal_assignments_company_id_user_id_index` (`company_id`,`user_id`),
  ADD KEY `terminal_assignments_status_index` (`status`),
  ADD KEY `terminal_assignments_assigned_at_index` (`assigned_at`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `units_company_id_short_name_unique` (`company_id`,`short_name`),
  ADD UNIQUE KEY `units_sync_uuid_unique` (`sync_uuid`),
  ADD KEY `units_created_by_foreign` (`created_by`),
  ADD KEY `units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_company_id_username_unique` (`company_id`,`username`),
  ADD UNIQUE KEY `users_company_id_email_unique` (`company_id`,`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_drawer_transactions`
--
ALTER TABLE `cash_drawer_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_archives`
--
ALTER TABLE `company_archives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_business_profiles`
--
ALTER TABLE `company_business_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_lifecycle_events`
--
ALTER TABLE `company_lifecycle_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lifecycle_settings`
--
ALTER TABLE `data_lifecycle_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods_received`
--
ALTER TABLE `goods_received`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods_received_items`
--
ALTER TABLE `goods_received_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform_admins`
--
ALTER TABLE `platform_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_locations`
--
ALTER TABLE `shipping_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storefronts`
--
ALTER TABLE `storefronts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sync_devices`
--
ALTER TABLE `sync_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sync_logs`
--
ALTER TABLE `sync_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sync_mutations`
--
ALTER TABLE `sync_mutations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sync_queue`
--
ALTER TABLE `sync_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `terminal_assignments`
--
ALTER TABLE `terminal_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `activity_logs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  ADD CONSTRAINT `cash_drawers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_drawers_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_drawers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_drawers_opened_by_foreign` FOREIGN KEY (`opened_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cash_drawers_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_drawer_transactions`
--
ALTER TABLE `cash_drawer_transactions`
  ADD CONSTRAINT `cash_drawer_transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_drawer_transactions_cash_drawer_id_foreign` FOREIGN KEY (`cash_drawer_id`) REFERENCES `cash_drawers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_drawer_transactions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_drawer_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cash_drawer_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_drawer_transactions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_drawer_transactions_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_archives`
--
ALTER TABLE `company_archives`
  ADD CONSTRAINT `company_archives_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `platform_admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `company_business_profiles`
--
ALTER TABLE `company_business_profiles`
  ADD CONSTRAINT `company_business_profiles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_lifecycle_events`
--
ALTER TABLE `company_lifecycle_events`
  ADD CONSTRAINT `company_lifecycle_events_platform_admin_id_foreign` FOREIGN KEY (`platform_admin_id`) REFERENCES `platform_admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_customer_group_id_foreign` FOREIGN KEY (`customer_group_id`) REFERENCES `customer_groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD CONSTRAINT `customer_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customer_groups_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `data_lifecycle_settings`
--
ALTER TABLE `data_lifecycle_settings`
  ADD CONSTRAINT `data_lifecycle_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `platform_admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_sequences`
--
ALTER TABLE `document_sequences`
  ADD CONSTRAINT `document_sequences_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods_received`
--
ALTER TABLE `goods_received`
  ADD CONSTRAINT `goods_received_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `goods_received_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_received_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `goods_received_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `goods_received_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `goods_received_items`
--
ALTER TABLE `goods_received_items`
  ADD CONSTRAINT `goods_received_items_goods_received_id_foreign` FOREIGN KEY (`goods_received_id`) REFERENCES `goods_received` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_received_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `goods_received_items_purchase_order_item_id_foreign` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `invoices_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_cashier_id_foreign` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_tax_rate_id_foreign` FOREIGN KEY (`tax_rate_id`) REFERENCES `tax_rates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_tax_rate_id_foreign` FOREIGN KEY (`tax_rate_id`) REFERENCES `tax_rates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `product_stocks_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `purchase_orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `purchase_returns_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_returns_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `purchase_returns_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_returns_goods_received_id_foreign` FOREIGN KEY (`goods_received_id`) REFERENCES `goods_received` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_returns_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_returns_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD CONSTRAINT `purchase_return_items_goods_received_item_id_foreign` FOREIGN KEY (`goods_received_item_id`) REFERENCES `goods_received_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_return_items_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD CONSTRAINT `sales_returns_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_returns_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_returns_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_returns_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_returns_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_returns_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD CONSTRAINT `sales_return_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_return_items_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`),
  ADD CONSTRAINT `sales_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sales_return_items_sales_return_id_foreign` FOREIGN KEY (`sales_return_id`) REFERENCES `sales_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  ADD CONSTRAINT `sales_return_payments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_return_payments_sales_return_id_foreign` FOREIGN KEY (`sales_return_id`) REFERENCES `sales_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `settings_default_customer_id_foreign` FOREIGN KEY (`default_customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shipping_locations`
--
ALTER TABLE `shipping_locations`
  ADD CONSTRAINT `shipping_locations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  ADD CONSTRAINT `shipping_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD CONSTRAINT `stock_counts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_counts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_counts_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD CONSTRAINT `stock_count_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_count_items_stock_count_id_foreign` FOREIGN KEY (`stock_count_id`) REFERENCES `stock_counts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_movements_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `storefronts`
--
ALTER TABLE `storefronts`
  ADD CONSTRAINT `storefronts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `storefronts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `storefronts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sync_devices`
--
ALTER TABLE `sync_devices`
  ADD CONSTRAINT `sync_devices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sync_devices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sync_devices_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD CONSTRAINT `sync_logs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sync_logs_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `sync_devices` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sync_mutations`
--
ALTER TABLE `sync_mutations`
  ADD CONSTRAINT `sync_mutations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sync_mutations_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `sync_devices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sync_queue`
--
ALTER TABLE `sync_queue`
  ADD CONSTRAINT `sync_queue_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sync_queue_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `sync_devices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD CONSTRAINT `tax_rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terminals`
--
ALTER TABLE `terminals`
  ADD CONSTRAINT `terminals_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminals_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terminal_assignments`
--
ALTER TABLE `terminal_assignments`
  ADD CONSTRAINT `terminal_assignments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminal_assignments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminal_assignments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `terminal_assignments_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminal_assignments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `terminal_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
