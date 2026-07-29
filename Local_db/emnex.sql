-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 02:15 PM
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
-- Database: `emnex`
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

INSERT INTO `branches` (`id`, `company_id`, `branch_code`, `name`, `phone`, `email`, `address`, `is_head_office`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'BR001', 'Head Office', '08012345678', 'headoffice@emmanexitconsult.com', 'Lagos, Nigeria', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(2, 1, 'BR002', 'Lekki Branch', '08087654321', 'lekki@emmanexitconsult.com', 'Lekki, Lagos', 0, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('emnex-cache-user_permissions_1', 'a:0:{}', 1785328646);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_code`, `name`, `slug`, `email`, `phone`, `address`, `logo`, `currency`, `currency_symbol`, `timezone`, `subscription_start`, `subscription_end`, `subscription_status`, `business_type`, `registration_no`, `tin`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'COMP-0001', 'Emmanex Supermarket', 'emmanex-supermarket', 'info@emmanexitconsult.com', '08012345678', 'Lagos, Nigeria', NULL, 'NGN', '₦', 'Africa/Lagos', '2026-07-29', '2027-07-29', 'Active', 'Retail Supermarket', 'RC123456', 'TIN123456789', 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL);

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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `company_id`, `branch_id`, `customer_code`, `first_name`, `last_name`, `email`, `phone`, `address`, `credit_limit`, `current_balance`, `customer_type`, `loyalty_points`, `last_purchase_date`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'CUS000001', 'Walk-in', 'Customer', NULL, NULL, NULL, 0.00, 0.00, 'Walk-in', 0, NULL, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(2, 1, NULL, 'CUS000002', 'John', 'Doe', 'john@example.com', '08030000001', NULL, 0.00, 0.00, 'Regular', 0, NULL, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(3, 1, NULL, 'CUS000003', 'Jane', 'Smith', 'jane@example.com', '08030000002', NULL, 0.00, 0.00, 'Regular', 0, NULL, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(4, 1, NULL, 'CUS000004', 'Michael', 'Johnson', 'michael@example.com', '08030000003', NULL, 0.00, 0.00, 'Wholesale', 0, NULL, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(5, 1, NULL, 'CUS000005', 'Sarah', 'Williams', 'sarah@example.com', '08030000004', NULL, 0.00, 0.00, 'VIP', 0, NULL, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_automatic` tinyint(1) NOT NULL DEFAULT 0,
  `type` enum('Percentage','Fixed') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `company_id`, `name`, `is_automatic`, `type`, `value`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'No Discount', 1, 'Percentage', 0.00, '2026-07-29', '2036-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(2, 1, 'Opening Promotion', 1, 'Percentage', 5.00, '2026-07-29', '2026-08-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(3, 1, 'Manager Discount', 0, 'Percentage', 10.00, '2026-07-29', '2027-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(4, 1, 'Special Customer', 0, 'Fixed', 500.00, '2026-07-29', '2027-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13');

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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `use_date_in_sequence` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_sequences`
--

INSERT INTO `document_sequences` (`id`, `company_id`, `document_type`, `prefix`, `suffix`, `separator`, `current_number`, `number_length`, `reset_frequency`, `status`, `created_at`, `updated_at`, `use_date_in_sequence`) VALUES
(1, 1, 'category', 'CAT', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(2, 1, 'product', 'PRD', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(3, 1, 'customer', 'CUS', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(4, 1, 'supplier', 'SUP', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(5, 1, 'order', 'ORD', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(6, 1, 'payment', 'PAY', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(7, 1, 'purchase', 'PUR', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(8, 1, 'purchase_return', 'PRN', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(9, 1, 'sales_return', 'SRN', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(10, 1, 'stock_movement', 'STM', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(11, 1, 'stock_adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0),
(12, 1, 'expense', 'EXP', NULL, '-', 1, 6, 'Never', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', 0);

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
(29, '2026_07_29_094243_add_code_to_roles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cashier_id` bigint(20) UNSIGNED NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
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
  `payment_method` enum('Cash','POS','Transfer','Wallet','Credit','Cheque') NOT NULL,
  `payment_status` enum('Pending','Completed','Failed','Cancelled','Refunded') NOT NULL DEFAULT 'Completed',
  `payment_date` datetime NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED NOT NULL,
  `payment_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `company_id`, `module`, `name`, `code`, `display_name`, `description`, `status`, `is_system`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Dashboard', 'dashboard.view', 'dashboard.view', 'View Dashboard', 'View Dashboard', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(2, 1, 'Company', 'company.view', 'company.view', 'View Company', 'View Company', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(3, 1, 'Company', 'company.update', 'company.update', 'Update Company', 'Update Company', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(4, 1, 'Branches', 'branches.view', 'branches.view', 'View Branches', 'View Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(5, 1, 'Branches', 'branches.create', 'branches.create', 'Create Branches', 'Create Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(6, 1, 'Branches', 'branches.update', 'branches.update', 'Update Branches', 'Update Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(7, 1, 'Branches', 'branches.delete', 'branches.delete', 'Delete Branches', 'Delete Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(8, 1, 'Branches', 'branches.analytics', 'branches.analytics', 'Analytics Branches', 'Analytics Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(9, 1, 'Branches', 'branches.export', 'branches.export', 'Export Branches', 'Export Branches', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(10, 1, 'Terminals', 'terminals.view', 'terminals.view', 'View Terminals', 'View Terminals', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(11, 1, 'Terminals', 'terminals.create', 'terminals.create', 'Create Terminals', 'Create Terminals', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(12, 1, 'Terminals', 'terminals.update', 'terminals.update', 'Update Terminals', 'Update Terminals', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(13, 1, 'Terminals', 'terminals.delete', 'terminals.delete', 'Delete Terminals', 'Delete Terminals', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(14, 1, 'Users', 'users.view', 'users.view', 'View Users', 'View Users', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(15, 1, 'Users', 'users.create', 'users.create', 'Create Users', 'Create Users', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(16, 1, 'Users', 'users.update', 'users.update', 'Update Users', 'Update Users', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(17, 1, 'Users', 'users.delete', 'users.delete', 'Delete Users', 'Delete Users', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(18, 1, 'Users', 'users.reset_password', 'users.reset_password', 'Reset Password Users', 'Reset Password Users', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(19, 1, 'Roles', 'roles.view', 'roles.view', 'View Roles', 'View Roles', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(20, 1, 'Roles', 'roles.create', 'roles.create', 'Create Roles', 'Create Roles', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(21, 1, 'Roles', 'roles.update', 'roles.update', 'Update Roles', 'Update Roles', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(22, 1, 'Roles', 'roles.delete', 'roles.delete', 'Delete Roles', 'Delete Roles', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(23, 1, 'Roles', 'roles.assign_permissions', 'roles.assign_permissions', 'Assign Permissions Roles', 'Assign Permissions Roles', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(24, 1, 'Permissions', 'permissions.view', 'permissions.view', 'View Permissions', 'View Permissions', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(25, 1, 'Products', 'products.view', 'products.view', 'View Products', 'View Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(26, 1, 'Products', 'products.create', 'products.create', 'Create Products', 'Create Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(27, 1, 'Products', 'products.update', 'products.update', 'Update Products', 'Update Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(28, 1, 'Products', 'products.delete', 'products.delete', 'Delete Products', 'Delete Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(29, 1, 'Products', 'products.import', 'products.import', 'Import Products', 'Import Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(30, 1, 'Products', 'products.export', 'products.export', 'Export Products', 'Export Products', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(31, 1, 'Categories', 'categories.view', 'categories.view', 'View Categories', 'View Categories', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(32, 1, 'Categories', 'categories.create', 'categories.create', 'Create Categories', 'Create Categories', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(33, 1, 'Categories', 'categories.update', 'categories.update', 'Update Categories', 'Update Categories', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(34, 1, 'Categories', 'categories.delete', 'categories.delete', 'Delete Categories', 'Delete Categories', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(35, 1, 'Units', 'units.view', 'units.view', 'View Units', 'View Units', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(36, 1, 'Units', 'units.create', 'units.create', 'Create Units', 'Create Units', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(37, 1, 'Units', 'units.update', 'units.update', 'Update Units', 'Update Units', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(38, 1, 'Units', 'units.delete', 'units.delete', 'Delete Units', 'Delete Units', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(39, 1, 'Tax Rates', 'tax_rates.view', 'tax_rates.view', 'View Tax Rates', 'View Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(40, 1, 'Tax Rates', 'tax_rates.create', 'tax_rates.create', 'Create Tax Rates', 'Create Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(41, 1, 'Tax Rates', 'tax_rates.update', 'tax_rates.update', 'Update Tax Rates', 'Update Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(42, 1, 'Tax Rates', 'tax_rates.delete', 'tax_rates.delete', 'Delete Tax Rates', 'Delete Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(43, 1, 'Discounts', 'discounts.view', 'discounts.view', 'View Discounts', 'View Discounts', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(44, 1, 'Discounts', 'discounts.create', 'discounts.create', 'Create Discounts', 'Create Discounts', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(45, 1, 'Discounts', 'discounts.update', 'discounts.update', 'Update Discounts', 'Update Discounts', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(46, 1, 'Discounts', 'discounts.delete', 'discounts.delete', 'Delete Discounts', 'Delete Discounts', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(47, 1, 'Inventory', 'inventory.view', 'inventory.view', 'View Inventory', 'View Inventory', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(48, 1, 'Inventory', 'inventory.adjust_stock', 'inventory.adjust_stock', 'Adjust Stock Inventory', 'Adjust Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(49, 1, 'Inventory', 'inventory.transfer_stock', 'inventory.transfer_stock', 'Transfer Stock Inventory', 'Transfer Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(50, 1, 'Inventory', 'inventory.stock_count', 'inventory.stock_count', 'Stock Count Inventory', 'Stock Count Inventory', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(51, 1, 'Inventory', 'inventory.low_stock', 'inventory.low_stock', 'Low Stock Inventory', 'Low Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(52, 1, 'Customers', 'customers.view', 'customers.view', 'View Customers', 'View Customers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(53, 1, 'Customers', 'customers.create', 'customers.create', 'Create Customers', 'Create Customers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(54, 1, 'Customers', 'customers.update', 'customers.update', 'Update Customers', 'Update Customers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(55, 1, 'Customers', 'customers.delete', 'customers.delete', 'Delete Customers', 'Delete Customers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(56, 1, 'Customers', 'customers.export', 'customers.export', 'Export Customers', 'Export Customers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(57, 1, 'Suppliers', 'suppliers.view', 'suppliers.view', 'View Suppliers', 'View Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(58, 1, 'Suppliers', 'suppliers.create', 'suppliers.create', 'Create Suppliers', 'Create Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(59, 1, 'Suppliers', 'suppliers.update', 'suppliers.update', 'Update Suppliers', 'Update Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(60, 1, 'Suppliers', 'suppliers.delete', 'suppliers.delete', 'Delete Suppliers', 'Delete Suppliers', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(61, 1, 'Purchases', 'purchases.view', 'purchases.view', 'View Purchases', 'View Purchases', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(62, 1, 'Purchases', 'purchases.create', 'purchases.create', 'Create Purchases', 'Create Purchases', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(63, 1, 'Purchases', 'purchases.update', 'purchases.update', 'Update Purchases', 'Update Purchases', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(64, 1, 'Purchases', 'purchases.delete', 'purchases.delete', 'Delete Purchases', 'Delete Purchases', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(65, 1, 'Purchases', 'purchases.approve', 'purchases.approve', 'Approve Purchases', 'Approve Purchases', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(66, 1, 'Pos', 'pos.sell', 'pos.sell', 'Sell Pos', 'Sell Pos', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(67, 1, 'Pos', 'pos.hold_sale', 'pos.hold_sale', 'Hold Sale Pos', 'Hold Sale Pos', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(68, 1, 'Pos', 'pos.open_orders', 'pos.open_orders', 'Open Orders Pos', 'Open Orders Pos', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(69, 1, 'Pos', 'pos.return_sale', 'pos.return_sale', 'Return Sale Pos', 'Return Sale Pos', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(70, 1, 'Pos', 'pos.cash_drawer', 'pos.cash_drawer', 'Cash Drawer Pos', 'Cash Drawer Pos', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(71, 1, 'Orders', 'orders.view', 'orders.view', 'View Orders', 'View Orders', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(72, 1, 'Orders', 'orders.create', 'orders.create', 'Create Orders', 'Create Orders', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(73, 1, 'Orders', 'orders.update', 'orders.update', 'Update Orders', 'Update Orders', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(74, 1, 'Orders', 'orders.cancel', 'orders.cancel', 'Cancel Orders', 'Cancel Orders', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(75, 1, 'Orders', 'orders.refund', 'orders.refund', 'Refund Orders', 'Refund Orders', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(76, 1, 'Payments', 'payments.view', 'payments.view', 'View Payments', 'View Payments', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(77, 1, 'Payments', 'payments.create', 'payments.create', 'Create Payments', 'Create Payments', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(78, 1, 'Payments', 'payments.refund', 'payments.refund', 'Refund Payments', 'Refund Payments', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(79, 1, 'Reports', 'reports.sales', 'reports.sales', 'Sales Reports', 'Sales Reports', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(80, 1, 'Reports', 'reports.inventory', 'reports.inventory', 'Inventory Reports', 'Inventory Reports', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(81, 1, 'Reports', 'reports.profit_loss', 'reports.profit_loss', 'Profit Loss Reports', 'Profit Loss Reports', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(82, 1, 'Reports', 'reports.tax', 'reports.tax', 'Tax Reports', 'Tax Reports', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(83, 1, 'Settings', 'settings.view', 'settings.view', 'View Settings', 'View Settings', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(84, 1, 'Settings', 'settings.update', 'settings.update', 'Update Settings', 'Update Settings', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(85, 1, 'Document Sequences', 'document_sequences.view', 'document_sequences.view', 'View Document Sequences', 'View Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(86, 1, 'Document Sequences', 'document_sequences.create', 'document_sequences.create', 'Create Document Sequences', 'Create Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(87, 1, 'Document Sequences', 'document_sequences.update', 'document_sequences.update', 'Update Document Sequences', 'Update Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(88, 1, 'Document Sequences', 'document_sequences.delete', 'document_sequences.delete', 'Delete Document Sequences', 'Delete Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(89, 1, 'Payment Methods', 'payment_methods.view', 'payment_methods.view', 'View Payment Methods', 'View Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(90, 1, 'Payment Methods', 'payment_methods.create', 'payment_methods.create', 'Create Payment Methods', 'Create Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(91, 1, 'Payment Methods', 'payment_methods.update', 'payment_methods.update', 'Update Payment Methods', 'Update Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(92, 1, 'Payment Methods', 'payment_methods.delete', 'payment_methods.delete', 'Delete Payment Methods', 'Delete Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(93, 1, 'Audit Logs', 'audit_logs.view', 'audit_logs.view', 'View Audit Logs', 'View Audit Logs', 1, 1, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `products` (`id`, `company_id`, `product_category_id`, `product_code`, `barcode`, `sku`, `qr_code`, `name`, `description`, `image`, `cost_price`, `selling_price`, `discount_id`, `unit_id`, `shelf_location`, `track_stock`, `brand`, `manufacturer`, `expiry_date`, `taxable`, `tax_rate_id`, `status`, `minimum_stock`, `maximum_stock`, `weight`, `dimensions`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `reorder_level`) VALUES
(1, 1, 1, 'PRD000001', '100000000001', 'COKE50CL', NULL, 'Coca-Cola 50cl', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Coca-Cola', 'NBC', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(2, 1, 1, 'PRD000002', '100000000002', 'FANTA50CL', NULL, 'Fanta 50cl', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Fanta', 'NBC', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(3, 1, 1, 'PRD000003', '100000000003', 'SPRITE50CL', NULL, 'Sprite 50cl', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Sprite', 'NBC', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(4, 1, 5, 'PRD000004', '100000000004', 'PEAK500', NULL, 'Peak Milk 500g', NULL, NULL, 4200.00, 4800.00, 1, 1, NULL, 1, 'Peak', 'FrieslandCampina', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(5, 1, 2, 'PRD000005', '100000000005', 'INDM70', NULL, 'Indomie Chicken Noodles', NULL, NULL, 180.00, 250.00, 1, 1, NULL, 1, 'Indomie', 'Dufil', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(6, 1, 2, 'PRD000006', '100000000006', 'SUG1KG', NULL, 'Dangote Sugar 1kg', NULL, NULL, 1450.00, 1650.00, 1, 1, NULL, 1, 'Dangote', 'Dangote', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(7, 1, 3, 'PRD000007', '100000000007', 'BREAD001', NULL, 'Family Bread', NULL, NULL, 900.00, 1200.00, 1, 1, NULL, 1, 'Local', 'Bakery', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(8, 1, 2, 'PRD000008', '100000000008', 'RICE50KG', NULL, 'Mama Gold Rice 50kg', NULL, NULL, 82000.00, 90000.00, 1, 11, NULL, 1, 'Mama Gold', 'Mama Gold', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(9, 1, 7, 'PRD000009', '100000000009', 'SOAP001', NULL, 'Premier Soap', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Premier', 'PZ', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(10, 1, 9, 'PRD000010', '100000000010', 'PAMP001', NULL, 'Pampers Size 3', NULL, NULL, 7800.00, 8600.00, 1, 2, NULL, 1, 'Pampers', 'P&G', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `product_categories` (`id`, `company_id`, `category_code`, `name`, `description`, `parent_id`, `image`, `sort_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'CAT000001', 'Beverages', 'Soft drinks, juices, bottled water and energy drinks.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(2, 1, 'CAT000002', 'Groceries', 'Rice, beans, pasta, noodles and food items.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(3, 1, 'CAT000003', 'Bakery', 'Bread, cakes and pastries.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(4, 1, 'CAT000004', 'Frozen Foods', 'Frozen meat, fish and poultry.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(5, 1, 'CAT000005', 'Dairy', 'Milk, butter, cheese and yoghurt.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(6, 1, 'CAT000006', 'Snacks', 'Biscuits, chocolates and confectioneries.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(7, 1, 'CAT000007', 'Household', 'Cleaning materials and home essentials.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(8, 1, 'CAT000008', 'Toiletries', 'Personal care and hygiene products.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(9, 1, 'CAT000009', 'Baby Products', 'Baby food, diapers and accessories.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(10, 1, 'CAT000010', 'Stationery', 'Office and school supplies.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL);

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
(1, 1, 1, 1, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(2, 1, 1, 2, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(3, 1, 1, 3, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(4, 1, 1, 4, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(5, 1, 1, 5, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(6, 1, 1, 6, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(7, 1, 1, 7, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(8, 1, 1, 8, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(9, 1, 1, 9, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(10, 1, 1, 10, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13');

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

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `code`, `display_name`, `description`, `status`, `is_system`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'owner', 'owner', 'Owner', 'System owner with unrestricted access.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:00', NULL),
(2, 1, 'administrator', 'administrator', 'Administrator', 'Company administrator.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(3, 1, 'branch_manager', 'branch_manager', 'Branch Manager', 'Manages a business branch.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(4, 1, 'supervisor', 'supervisor', 'Supervisor', 'Supervises daily business operations.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(5, 1, 'cashier', 'cashier', 'Cashier', 'Processes customer sales.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(6, 1, 'inventory_manager', 'inventory_manager', 'Inventory Manager', 'Manages inventory and stock.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(7, 1, 'accountant', 'accountant', 'Accountant', 'Handles financial operations.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL);

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
('HX6AwrIFgLDtuYVCfrrDomLBpYzVOqEPCAjPWhPr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YToxMTp7czo2OiJfdG9rZW4iO3M6NDA6IlNZUFdsRkluNHVFQzRJNnJIcVJLQUgyeDhlWmNVQ2o2eTYzWlNEOWUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYnJhbmNoZXMvdGVzdC1wZXJtaXNzaW9uIjtzOjU6InJvdXRlIjtzOjk6ImJyYW5jaGVzLiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxOToiRW1tYW5leCBTdXBlcm1hcmtldCI7czoxMjoiY29tcGFueV9jb2RlIjtzOjk6IkNPTVAtMDAwMSI7czo5OiJicmFuY2hfaWQiO2k6MTtzOjg6ImN1cnJlbmN5IjtzOjM6Ik5HTiI7czoxNToiY3VycmVuY3lfc3ltYm9sIjtzOjM6IuKCpiI7czo4OiJ0aW1lem9uZSI7czoxMjoiQWZyaWNhL0xhZ29zIjt9', 1785326847);

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
  `print_logo` tinyint(1) NOT NULL DEFAULT 1,
  `print_barcode` tinyint(1) NOT NULL DEFAULT 0,
  `allow_negative_stock` tinyint(1) NOT NULL DEFAULT 0,
  `allow_price_change` tinyint(1) NOT NULL DEFAULT 0,
  `enable_discounts` tinyint(1) NOT NULL DEFAULT 1,
  `enable_customer_credit` tinyint(1) NOT NULL DEFAULT 0,
  `default_customer` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Africa/Lagos',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_id`, `company_name`, `company_email`, `company_phone`, `company_address`, `company_logo`, `currency`, `currency_symbol`, `tax_rate`, `tax_enabled`, `receipt_footer`, `print_logo`, `print_barcode`, `allow_negative_stock`, `allow_price_change`, `enable_discounts`, `enable_customer_credit`, `default_customer`, `timezone`, `maintenance_mode`, `created_at`, `updated_at`) VALUES
(1, 1, 'Emmanex Supermarket', 'info@emmanexitconsult.com', '08012345678', 'Lagos, Nigeria', NULL, 'NGN', '₦', 7.50, 1, 'Thank you for shopping with us.', 1, 0, 0, 0, 1, 0, 'Walk-in Customer', 'Africa/Lagos', 0, '2026-07-29 10:37:13', '2026-07-29 10:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `movement_type` enum('Opening Stock','Purchase','Sale','Return','Adjustment','Transfer','Damage','Expired') NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(15,2) NOT NULL,
  `balance_after` decimal(15,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `company_id`, `name`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'No Tax', 0.00, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(2, 1, 'VAT 7.5%', 7.50, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(3, 1, 'VAT 15%', 15.00, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(4, 1, 'Luxury Tax', 10.00, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `terminals`
--

CREATE TABLE `terminals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_code` varchar(255) NOT NULL,
  `terminal_name` varchar(255) NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terminals`
--

INSERT INTO `terminals` (`id`, `company_id`, `branch_id`, `terminal_code`, `terminal_name`, `device_name`, `ip_address`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'BR001-POS01', 'Head Office POS 1', 'Desktop POS', NULL, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(2, 1, 1, 'BR001-POS02', 'Head Office POS 2', 'Desktop POS', NULL, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(3, 1, 2, 'BR002-POS01', 'Lekki Branch POS 1', 'Desktop POS', NULL, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `company_id`, `name`, `short_name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Piece', 'PCS', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(2, 1, 'Pack', 'PK', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(3, 1, 'Carton', 'CTN', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(4, 1, 'Bottle', 'BTL', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(5, 1, 'Can', 'CAN', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(6, 1, 'Kilogram', 'KG', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(7, 1, 'Gram', 'G', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(8, 1, 'Litre', 'LTR', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(9, 1, 'Millilitre', 'ML', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(10, 1, 'Dozen', 'DOZ', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(11, 1, 'Bag', 'BAG', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(12, 1, 'Roll', 'ROL', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(13, 1, 'Box', 'BOX', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL);

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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `force_password_change` tinyint(1) NOT NULL DEFAULT 0,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `branch_id`, `role_id`, `employee_no`, `first_name`, `last_name`, `username`, `email`, `is_owner`, `email_verified_at`, `two_factor_enabled`, `phone`, `password`, `profile_photo`, `gender`, `date_of_birth`, `employment_date`, `status`, `last_login_at`, `last_login_ip`, `force_password_change`, `password_changed_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 'EMP0001', 'System', 'Owner', 'owner', 'owner@emmanexitconsult.com', 1, '2026-07-29 10:37:10', 0, NULL, '$2y$12$L7/APL0EoI63ZWa9zNDoaOzuAwz//Q2.xHa22o.Iq5Of8Mvfpybby', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:10', '2026-07-29 10:37:10', NULL),
(2, 1, 1, 2, 'EMP0002', 'System', 'Administrator', 'admin', 'admin@emmanexitconsult.com', 0, '2026-07-29 10:37:10', 0, NULL, '$2y$12$zPemhQB4t0by5HjwdteQX.Zfuas6VQ3BuaQzN8SALTxqhG6zQvRJ6', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(3, 1, 1, 3, 'EMP0003', 'Branch', 'Manager', 'manager', 'manager@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$VG6ccScaNLrU.r011G.DMueH3D1TuNPUKaJa/eT3JWQe.PkUdy4cK', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(4, 1, 1, 4, 'EMP0004', 'Branch', 'Supervisor', 'supervisor', 'supervisor@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$Mnb.9S7tdyOowvwKXTlK9edKlg0UC8jM4R.AOw5Y4.kwnHCf32Uz6', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(5, 1, 1, 5, 'EMP0005', 'Main', 'Cashier', 'cashier', 'cashier@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$T1ovqUxatrDaNNgfTtkRUOGZtYbvmkVjao8EU/1LCJFH1KA0M.1qO', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:12', '2026-07-29 10:37:12', NULL),
(6, 1, 1, 6, 'EMP0006', 'Inventory', 'Manager', 'inventory', 'inventory@emmanexitconsult.com', 0, '2026-07-29 10:37:12', 0, NULL, '$2y$12$lWJtwgUPhnO44mwKMNifgeZiD.oVJwv9QqHYPCMNMOSpP0IhCHNAC', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:12', '2026-07-29 10:37:12', NULL),
(7, 1, 1, 7, 'EMP0007', 'Company', 'Accountant', 'accountant', 'accountant@emmanexitconsult.com', 0, '2026-07-29 10:37:12', 0, NULL, '$2y$12$Aj3KYFJ24AXQQWWE3taN.uWPk/7eQSkS9oH84LMpPHxJ6nq1vXS5i', NULL, NULL, NULL, '2026-07-29', 1, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL);

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
  ADD UNIQUE KEY `branches_branch_code_unique` (`branch_code`);

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
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_company_code_unique` (`company_code`),
  ADD UNIQUE KEY `companies_slug_unique` (`slug`);

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
  ADD KEY `customers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_company_id_name_unique` (`company_id`,`name`);

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
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_cashier_id_foreign` (`cashier_id`),
  ADD KEY `orders_discount_id_foreign` (`discount_id`),
  ADD KEY `orders_tax_rate_id_foreign` (`tax_rate_id`),
  ADD KEY `orders_terminal_id_foreign` (`terminal_id`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`);

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
  ADD KEY `payments_received_by_foreign` (`received_by`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_company_id_name_unique` (`company_id`,`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_company_id_product_code_unique` (`company_id`,`product_code`),
  ADD UNIQUE KEY `products_company_id_barcode_unique` (`company_id`,`barcode`),
  ADD UNIQUE KEY `products_company_id_sku_unique` (`company_id`,`sku`),
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
  ADD KEY `product_categories_parent_id_foreign` (`parent_id`),
  ADD KEY `product_categories_created_by_foreign` (`created_by`),
  ADD KEY `product_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_stocks_company_id_branch_id_product_id_unique` (`company_id`,`branch_id`,`product_id`),
  ADD KEY `product_stocks_branch_id_foreign` (`branch_id`),
  ADD KEY `product_stocks_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `settings_company_id_unique` (`company_id`);

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
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_rates_company_id_name_unique` (`company_id`,`name`);

--
-- Indexes for table `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terminals_company_id_terminal_code_unique` (`company_id`,`terminal_code`),
  ADD KEY `terminals_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_company_id_name_unique` (`company_id`,`name`),
  ADD UNIQUE KEY `units_company_id_short_name_unique` (`company_id`,`short_name`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_cashier_id_foreign` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `product_stocks_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

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
