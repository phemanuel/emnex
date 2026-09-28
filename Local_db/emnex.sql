-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2026 at 02:18 AM
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

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Authorization', 'Created', 'Created role Test Role User', 'Role', 14, NULL, '{\"company_id\":1,\"name\":\"Test Role User\",\"code\":\"test_role_user\",\"display_name\":\"Test Role User\",\"description\":\"This is just a test for a user.\",\"status\":true,\"updated_at\":\"2026-07-29T15:33:17.000000Z\",\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"id\":14}', 'roles', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 14:33:17', '2026-07-29 14:33:17'),
(2, 1, 1, 1, 'Authorization', 'Updated', 'Updated role Test Role User', 'Role', 14, '{\"id\":14,\"company_id\":1,\"name\":\"Test Role User\",\"code\":\"test_role_user\",\"display_name\":\"Test Role User\",\"description\":\"This is just a test for a user.\",\"status\":true,\"is_system\":false,\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"updated_at\":\"2026-07-29T15:33:17.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"name\":\"Test Role\",\"code\":\"test_role_user\",\"display_name\":\"Test Role User\",\"description\":\"This is just a test for a user.\",\"status\":true,\"is_system\":false,\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"updated_at\":\"2026-07-29T15:33:37.000000Z\",\"deleted_at\":null}', 'roles/14', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 14:33:37', '2026-07-29 14:33:37'),
(3, 1, 1, 1, 'Authorization', 'Updated', 'Updated role Test Role', 'Role', 14, '{\"id\":14,\"company_id\":1,\"name\":\"Test Role\",\"code\":\"test_role_user\",\"display_name\":\"Test Role User\",\"description\":\"This is just a test for a user.\",\"status\":true,\"is_system\":false,\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"updated_at\":\"2026-07-29T15:33:37.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"name\":\"Test Role\",\"code\":\"test_role_user\",\"display_name\":\"Test Role\",\"description\":\"This is just a test for a user.\",\"status\":true,\"is_system\":false,\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"updated_at\":\"2026-07-29T15:33:51.000000Z\",\"deleted_at\":null}', 'roles/14', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 14:33:51', '2026-07-29 14:33:51'),
(4, 1, 1, 1, 'Authorization', 'Deleted', 'Deleted role Test Role', 'Role', 14, '{\"id\":14,\"company_id\":1,\"name\":\"Test Role\",\"code\":\"test_role_user\",\"display_name\":\"Test Role\",\"description\":\"This is just a test for a user.\",\"status\":true,\"is_system\":false,\"created_at\":\"2026-07-29T15:33:17.000000Z\",\"updated_at\":\"2026-07-29T15:33:51.000000Z\",\"deleted_at\":null}', NULL, 'roles/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 14:34:00', '2026-07-29 14:34:00'),
(5, 1, 1, 1, 'Authorization', 'Created', 'Created role Test Role User', 'Role', 15, NULL, '{\"company_id\":1,\"name\":\"Test Role User\",\"code\":\"test_role_user\",\"display_name\":\"Test Role User\",\"description\":\"This is just a test role for a user.\",\"status\":true,\"updated_at\":\"2026-07-29T16:09:14.000000Z\",\"created_at\":\"2026-07-29T16:09:14.000000Z\",\"id\":15}', 'roles', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 15:09:14', '2026-07-29 15:09:14'),
(6, 1, 1, 1, 'Authorization', 'Permissions Updated', 'Updated permissions for role Test Role User', 'Role', 15, '{\"permissions\":[]}', '{\"permissions\":[8,5,32]}', 'roles/15/permissions', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 15:09:37', '2026-07-29 15:09:37'),
(7, 1, 1, 1, 'Authorization', 'Permissions Updated', 'Updated permissions for role Test Role User', 'Role', 15, '{\"permissions\":[8,5,32]}', '{\"permissions\":[8,5,32,36]}', 'roles/15/permissions', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-29 15:22:48', '2026-07-29 15:22:48'),
(8, 1, 1, 1, 'Users', 'Created', 'Created user Paul Olusogo Awolola', 'User', 11, NULL, '{\"company_id\":1,\"branch_id\":\"1\",\"role_id\":\"5\",\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"last_name\":\"Awolola\",\"other_name\":\"Olusogo\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"phone\":\"07038899203\",\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, ibadan\",\"notes\":null,\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-07-30T01:12:09.000000Z\",\"created_at\":\"2026-07-30T01:12:09.000000Z\",\"id\":11}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 00:12:09', '2026-07-30 00:12:09'),
(9, 1, 1, 1, 'Users', 'Created', 'Created user Paul Olusogo Awolola', 'User', 12, NULL, '{\"company_id\":1,\"branch_id\":\"1\",\"role_id\":\"5\",\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"last_name\":\"Awolola\",\"other_name\":\"Olusogo\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"phone\":\"07038899203\",\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":null,\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-07-30T01:16:49.000000Z\",\"created_at\":\"2026-07-30T01:16:49.000000Z\",\"id\":12}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 00:16:49', '2026-07-30 00:16:49'),
(10, 1, 1, 1, 'Users', 'Created', 'Created user Paul Olusogo Awolola', 'User', 13, NULL, '{\"company_id\":1,\"branch_id\":\"1\",\"role_id\":\"5\",\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"last_name\":\"Awolola\",\"other_name\":\"Olusogo\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"phone\":\"07038899203\",\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":null,\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-07-30T01:22:01.000000Z\",\"created_at\":\"2026-07-30T01:22:01.000000Z\",\"id\":13}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 00:22:01', '2026-07-30 00:22:01'),
(11, 1, 1, 1, 'Users', 'Created', 'Created user Paul Olusogo Awolola', 'User', 14, NULL, '{\"company_id\":1,\"branch_id\":\"1\",\"role_id\":\"5\",\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"last_name\":\"Awolola\",\"other_name\":\"Olusogo\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"phone\":\"07038899203\",\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":null,\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-07-30T01:26:14.000000Z\",\"created_at\":\"2026-07-30T01:26:14.000000Z\",\"id\":14}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 00:26:14', '2026-07-30 00:26:14'),
(12, 1, 1, 1, 'Users', 'Created', 'Created user Paul Olusogo Awolola', 'User', 15, NULL, '{\"company_id\":1,\"branch_id\":\"1\",\"role_id\":\"5\",\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"last_name\":\"Awolola\",\"other_name\":\"Olusogo\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"phone\":\"07038899203\",\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":null,\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-07-30T01:35:56.000000Z\",\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"id\":15}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 00:35:56', '2026-07-30 00:35:56'),
(13, 1, 1, 1, 'User Management', 'Updated', 'Updated user Paul Olusogo Awolola', 'User', 15, '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":null,\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-30T01:35:56.000000Z\",\"deleted_at\":null}', '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":\"Transfered from Lekki branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-30T18:55:06.000000Z\",\"deleted_at\":null}', 'users/15', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 17:55:06', '2026-07-30 17:55:06'),
(14, 1, 1, 1, 'User Management', 'Updated', 'Updated user Paul Olusogo Awolola', 'User', 15, '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":\"Transfered from Lekki branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-30T18:55:06.000000Z\",\"deleted_at\":null}', '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":\"Transfered from Lekki branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-30T18:55:06.000000Z\",\"deleted_at\":null}', 'users/15', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-30 17:55:06', '2026-07-30 17:55:06'),
(15, 1, 1, 1, 'User Management', 'Deleted', 'Deleted user Paul Olusogo Awolola', 'User', 15, '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":\"Transfered from Lekki branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-30T18:55:06.000000Z\",\"deleted_at\":null}', '[]', 'users/15', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:10:03', '2026-07-31 13:10:03'),
(16, 1, 1, 1, 'Users', 'Restored', 'Restored user Paul Olusogo Awolola', 'User', 15, '{\"id\":15,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-07T00:00:00.000000Z\",\"address\":\"Ido, Ibadan\",\"notes\":\"Transfered from Lekki branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-31T14:10:03.000000Z\",\"deleted_at\":\"2026-07-31T14:10:03.000000Z\"}', '{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-31T14:19:14.000000Z\",\"deleted_at\":null}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:19:14', '2026-07-31 13:19:14'),
(17, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Paul Olusogo Awolola', 'User', 15, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/15/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:30:17', '2026-07-31 13:30:17'),
(18, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Paul Olusogo Awolola', 'User', 15, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/15/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:31:40', '2026-07-31 13:31:40'),
(19, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Paul Olusogo Awolola', 'User', 15, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/15/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:31:55', '2026-07-31 13:31:55'),
(20, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Paul Olusogo Awolola', 'User', 15, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/15/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:32:06', '2026-07-31 13:32:06'),
(21, 1, 1, 1, 'Users', 'Disabled', 'Disabled user Paul Olusogo Awolola', 'User', 15, '{\"status\":true}', '{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":false,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-31T14:53:07.000000Z\",\"deleted_at\":null}', 'users/15/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:53:07', '2026-07-31 13:53:07'),
(22, 1, 1, 1, 'Users', 'Enabled', 'Enabled user Paul Olusogo Awolola', 'User', 15, '{\"status\":false}', '{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-07-31T14:58:33.000000Z\",\"deleted_at\":null}', 'users/15/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 13:58:33', '2026-07-31 13:58:33'),
(23, 1, 1, 1, 'Branch Management', 'Created', 'Created branch Ajah Outlet', 'Branch', 4, NULL, '{\"company_id\":1,\"branch_code\":\"BR003\",\"name\":\"Ajah Outlet\",\"email\":\"ajah@emmanexitconsult.com\",\"phone\":\"07034657383\",\"address\":\"Agbado, Ajah express way, Lagos.\",\"status\":true,\"is_head_office\":true,\"updated_at\":\"2026-07-31T15:47:21.000000Z\",\"created_at\":\"2026-07-31T15:47:21.000000Z\",\"id\":4}', 'branches', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 14:47:21', '2026-07-31 14:47:21'),
(24, 1, 1, 1, 'Branch Management', 'Created', 'Created branch Ikorodu Outlet', 'Branch', 6, NULL, '{\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"email\":\"Ikd@emmanexitconsult.com\",\"phone\":\"07032109983\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"status\":true,\"is_head_office\":false,\"updated_at\":\"2026-07-31T15:52:50.000000Z\",\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"id\":6}', 'branches', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-07-31 14:52:50', '2026-07-31 14:52:50'),
(25, 1, 1, 1, 'Branch Management', 'Updated', 'Updated branch Ajah Outlet New', 'Branch', 4, '{\"id\":4,\"company_id\":1,\"branch_code\":\"BR003\",\"name\":\"Ajah Outlet\",\"phone\":\"07034657383\",\"email\":\"ajah@emmanexitconsult.com\",\"address\":\"Agbado, Ajah express way, Lagos.\",\"is_head_office\":true,\"status\":true,\"created_at\":\"2026-07-31T15:47:21.000000Z\",\"updated_at\":\"2026-07-31T15:47:21.000000Z\",\"deleted_at\":null}', '{\"id\":4,\"company_id\":1,\"branch_code\":\"BR003\",\"name\":\"Ajah Outlet New\",\"phone\":\"07034657383\",\"email\":\"ajah@emmanexitconsult.com\",\"address\":\"Agbado, Ajah express way, Lagos.\",\"is_head_office\":true,\"status\":true,\"created_at\":\"2026-07-31T15:47:21.000000Z\",\"updated_at\":\"2026-08-01T21:36:13.000000Z\",\"deleted_at\":null}', 'branches/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 20:36:13', '2026-08-01 20:36:13'),
(26, 1, 1, 1, 'Branch Management', 'Disabled', 'Disabled branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-07-31T15:52:50.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":false,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:13:57.000000Z\",\"deleted_at\":null}', 'branches/6/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:13:57', '2026-08-01 21:13:57'),
(27, 1, 1, 1, 'Branch Management', 'Enabled', 'Enabled branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":false,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:13:57.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:15:10.000000Z\",\"deleted_at\":null}', 'branches/6/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:15:10', '2026-08-01 21:15:10'),
(28, 1, 1, 1, 'Branch Management', 'Disabled', 'Disabled branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:15:10.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":false,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:16:37.000000Z\",\"deleted_at\":null}', 'branches/6/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:16:37', '2026-08-01 21:16:37'),
(29, 1, 1, 1, 'Branch Management', 'Enabled', 'Enabled branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":false,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:16:37.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:19:02.000000Z\",\"deleted_at\":null}', 'branches/6/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:19:02', '2026-08-01 21:19:02'),
(30, 1, 1, 1, 'Branch Management', 'Deleted', 'Deleted branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:19:02.000000Z\",\"deleted_at\":null}', NULL, 'branches/6', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:20:32', '2026-08-01 21:20:32'),
(31, 1, 1, 1, 'Branch Management', 'Restored', 'Restored branch Ikorodu Outlet', 'Branch', 6, '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07032109983\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikoridu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:20:32.000000Z\",\"deleted_at\":\"2026-08-01T22:20:32.000000Z\"}', '{\"id\":6,\"company_id\":1,\"branch_code\":\"BR004\",\"name\":\"Ikorodu Outlet\",\"phone\":\"07038899203\",\"email\":\"Ikd@emmanexitconsult.com\",\"address\":\"Odogunyan, Ikorodu, Lagos.\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-31T15:52:50.000000Z\",\"updated_at\":\"2026-08-01T22:41:51.000000Z\",\"deleted_at\":null}', 'branches', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 21:41:51', '2026-08-01 21:41:51'),
(32, 1, 1, 1, 'Terminal Management', 'Created', 'Terminal Ajah-Pos1 created', 'Terminal', 11, '[]', '{\"company_id\":1,\"branch_id\":\"4\",\"terminal_code\":\"Ajah-Pos1\",\"terminal_name\":\"Front Counter POS\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":null,\"status\":true,\"updated_at\":\"2026-08-01T23:42:04.000000Z\",\"created_at\":\"2026-08-01T23:42:04.000000Z\",\"id\":11}', 'terminals', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 22:42:04', '2026-08-01 22:42:04'),
(33, 1, 1, 1, 'Terminal Management', 'Updated', 'Updated terminal Ajah-Pos1', 'Terminal', 11, '{\"id\":11,\"company_id\":1,\"branch_id\":4,\"terminal_code\":\"Ajah-Pos1\",\"terminal_name\":\"Front Counter POS\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-01T23:42:04.000000Z\",\"updated_at\":\"2026-08-01T23:42:04.000000Z\",\"deleted_at\":null}', '{\"id\":11,\"company_id\":1,\"branch_id\":4,\"terminal_code\":\"Ajah-Pos1\",\"terminal_name\":\"Front Counter POS\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":\"192.168.0.23\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-01T23:42:04.000000Z\",\"updated_at\":\"2026-08-02T00:13:56.000000Z\",\"deleted_at\":null}', 'terminals/11', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:13:56', '2026-08-01 23:13:56'),
(34, 1, 1, 1, 'Terminal Management', 'Updated', 'Updated terminal Ajah-Pos1', 'Terminal', 11, '{\"id\":11,\"company_id\":1,\"branch_id\":4,\"terminal_code\":\"Ajah-Pos1\",\"terminal_name\":\"Front Counter POS\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":\"192.168.0.23\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-01T23:42:04.000000Z\",\"updated_at\":\"2026-08-02T00:13:56.000000Z\",\"deleted_at\":null}', '{\"id\":11,\"company_id\":1,\"branch_id\":4,\"terminal_code\":\"Ajah-Pos1\",\"terminal_name\":\"Front Counter POS\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":\"192.168.0.24\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-01T23:42:04.000000Z\",\"updated_at\":\"2026-08-02T00:33:26.000000Z\",\"deleted_at\":null}', 'terminals/11', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:33:26', '2026-08-01 23:33:26'),
(35, 1, 1, 1, 'Terminal Management', 'Disabled', 'Disabled terminal Ajah-Pos1', 'Terminal', 11, '{\"status\":true}', '{\"status\":false}', 'terminals/11/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:35:59', '2026-08-01 23:35:59'),
(36, 1, 1, 1, 'Terminal Management', 'Enabled', 'Enabled terminal Ajah-Pos1', 'Terminal', 11, '{\"status\":false}', '{\"status\":true}', 'terminals/11/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:36:05', '2026-08-01 23:36:05'),
(37, 1, 1, 1, 'Terminal Management', 'Disabled', 'Disabled terminal Ajah-Pos1', 'Terminal', 11, '{\"status\":true}', '{\"status\":false}', 'terminals/11/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:37:33', '2026-08-01 23:37:33'),
(38, 1, 1, 1, 'Terminal Management', 'Enabled', 'Enabled terminal Ajah-Pos1', 'Terminal', 11, '{\"status\":false}', '{\"status\":true}', 'terminals/11/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:37:38', '2026-08-01 23:37:38'),
(39, 1, 1, 1, 'Terminal Management', 'Deleted', 'Deleted terminal Ajah-Pos1', 'Terminal', 11, NULL, NULL, 'terminals/11', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-01 23:42:15', '2026-08-01 23:42:15'),
(40, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"d-m-Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:22.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:50:22', '2026-08-02 00:50:22'),
(41, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:22.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:50.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:50:50', '2026-08-02 00:50:50'),
(42, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:50.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:57.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:50:57', '2026-08-02 00:50:57'),
(43, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:50:57.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:51:04.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:51:04', '2026-08-02 00:51:04'),
(44, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:51:04.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":false,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:52:25.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:52:25', '2026-08-02 00:52:25'),
(45, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":false,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:52:25.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:52:44.000000Z\"}', 'settings/settings', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 00:52:44', '2026-08-02 00:52:44'),
(46, 1, 1, 1, 'Document Sequences', 'Updated', 'Updated category document sequence.', 'DocumentSequence', 1, '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 08:38:45', '2026-08-02 08:38:45'),
(47, 1, 1, 1, 'Document Sequences', 'Updated', 'Updated supplier document sequence.', 'DocumentSequence', 4, '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"_\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T09:40:36.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 08:40:36', '2026-08-02 08:40:36'),
(48, 1, 1, 1, 'Document Sequences', 'Updated', 'Updated supplier document sequence.', 'DocumentSequence', 4, '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"_\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T09:40:36.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:31:00.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 09:31:00', '2026-08-02 09:31:00');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(49, 1, 1, 1, 'Document Sequences', 'Updated', 'Updated supplier document sequence.', 'DocumentSequence', 4, '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:31:00.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"_\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:31:21.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 09:31:21', '2026-08-02 09:31:21'),
(50, 1, 1, 1, 'Document Sequences', 'Updated', 'Updated supplier document sequence.', 'DocumentSequence', 4, '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"_\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:31:21.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":4,\"company_id\":1,\"document_type\":\"supplier\",\"prefix\":\"SUP\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:33:00.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 09:33:00', '2026-08-02 09:33:00'),
(51, 1, 1, 1, 'Document Sequences', 'Disabled', 'Disabled category document sequence.', 'DocumentSequence', 1, '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":false,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:33:07.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 09:33:07', '2026-08-02 09:33:07'),
(52, 1, 1, 1, 'Document Sequences', 'Enabled', 'Enabled category document sequence.', 'DocumentSequence', 1, '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":false,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:33:07.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":1,\"company_id\":1,\"document_type\":\"category\",\"prefix\":\"CAT\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T10:34:24.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 09:34:24', '2026-08-02 09:34:24'),
(53, 1, 1, 1, 'Payment Methods', 'Created', 'Created payment method Cash-Flow.', 'PaymentMethod', 7, NULL, NULL, 'payment-methods', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 10:53:45', '2026-08-02 10:53:45'),
(54, 1, 1, 1, 'Payment Methods', 'Updated', 'Updated Cash payment method.', 'PaymentMethod', 1, '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"success\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T10:51:36.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"primary\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T12:22:09.000000Z\",\"deleted_at\":null}', 'payment-methods/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:22:09', '2026-08-02 11:22:09'),
(55, 1, 1, 1, 'Payment Methods', 'Updated', 'Updated Cash payment method.', 'PaymentMethod', 1, '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"primary\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T12:22:09.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"warning\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T12:22:23.000000Z\",\"deleted_at\":null}', 'payment-methods/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:22:23', '2026-08-02 11:22:23'),
(56, 1, 1, 1, 'Payment Methods', 'Updated', 'Updated Cash payment method.', 'PaymentMethod', 1, '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"warning\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T12:22:23.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"name\":\"Cash\",\"code\":\"CASH\",\"icon\":\"bi-cash\",\"color\":\"success\",\"requires_reference\":false,\"is_cash\":true,\"allow_change\":true,\"display_order\":1,\"status\":true,\"created_at\":\"2026-08-02T10:51:36.000000Z\",\"updated_at\":\"2026-08-02T12:22:31.000000Z\",\"deleted_at\":null}', 'payment-methods/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:22:31', '2026-08-02 11:22:31'),
(57, 1, 1, 1, 'Payment Methods', 'Disabled', 'Cash-Flow payment method status changed.', 'PaymentMethod', 7, NULL, NULL, 'payment-methods/7/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:23:44', '2026-08-02 11:23:44'),
(58, 1, 1, 1, 'Payment Methods', 'Enabled', 'Cash-Flow payment method status changed.', 'PaymentMethod', 7, NULL, NULL, 'payment-methods/7/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:23:48', '2026-08-02 11:23:48'),
(59, 1, 1, 1, 'Payment Methods', 'Deleted', 'Deleted Cash-Flow payment method.', 'PaymentMethod', 7, NULL, NULL, 'payment-methods/7', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:33:09', '2026-08-02 11:33:09'),
(60, 1, 1, 1, 'Payment Methods', 'Disabled', 'Cash payment method status changed.', 'PaymentMethod', 1, NULL, NULL, 'payment-methods/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:42:28', '2026-08-02 11:42:28'),
(61, 1, 1, 1, 'Payment Methods', 'Enabled', 'Cash payment method status changed.', 'PaymentMethod', 1, NULL, NULL, 'payment-methods/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 11:43:07', '2026-08-02 11:43:07'),
(62, 1, 1, 1, 'Product Categories', 'Created', 'Created product category: Building', 'ProductCategory', 13, NULL, '{\"id\":13,\"company_id\":1,\"category_code\":\"CAT000012\",\"name\":\"Building\",\"description\":\"Furniture and Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:18.000000Z\",\"updated_at\":\"2026-08-02T15:53:18.000000Z\",\"deleted_at\":null}', 'product-categories', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 14:53:18', '2026-08-02 14:53:18'),
(63, 1, 1, 1, 'Product Categories', 'Created', 'Created product category: Building', 'ProductCategory', 14, NULL, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture and Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:53:48.000000Z\",\"deleted_at\":null}', 'product-categories', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 14:53:48', '2026-08-02 14:53:48'),
(64, 1, 1, 1, 'Product Categories', 'Updated', 'Updated category: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery and Consultant.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:54:59.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:59:27.000000Z\",\"deleted_at\":null}', 'product-categories/14', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 14:59:27', '2026-08-02 14:59:27'),
(65, 1, 1, 1, 'Product Categories', 'Disabled', 'Category status changed: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:59:27.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:59:32.000000Z\",\"deleted_at\":null}', 'product-categories/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 14:59:32', '2026-08-02 14:59:32'),
(66, 1, 1, 1, 'Product Categories', 'Enabled', 'Category Enabled: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T15:59:32.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:02:13.000000Z\",\"deleted_at\":null}', 'product-categories/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 15:02:13', '2026-08-02 15:02:13'),
(67, 1, 1, 1, 'Product Categories', 'Disabled', 'Category Disabled: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:02:13.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:09:47.000000Z\",\"deleted_at\":null}', 'product-categories/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 15:09:47', '2026-08-02 15:09:47'),
(68, 1, 1, 1, 'Product Categories', 'Enabled', 'Category Enabled: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:09:47.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:10:44.000000Z\",\"deleted_at\":null}', 'product-categories/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 15:10:44', '2026-08-02 15:10:44'),
(69, 1, 1, 1, 'Product Categories', 'Disabled', 'Category Disabled: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:10:44.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:10:50.000000Z\",\"deleted_at\":null}', 'product-categories/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 15:10:50', '2026-08-02 15:10:50'),
(70, 1, 1, 1, 'Product Categories', 'Deleted', 'Deleted category: Building', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:10:50.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:14:57.000000Z\",\"deleted_at\":\"2026-08-02T16:14:57.000000Z\"}', 'product-categories/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-02 15:14:57', '2026-08-02 15:14:57'),
(71, 1, 1, 1, 'Units', 'Created', 'Created unit: TEXT', 'Unit', 14, NULL, NULL, 'units', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:02:30', '2026-08-03 14:02:30'),
(72, 1, 1, 1, 'Units', 'Updated', 'Updated unit: Piece', 'Unit', 1, '{\"id\":1,\"company_id\":1,\"unit_code\":\"UNT000001\",\"name\":\"Piece\",\"short_name\":\"PCS\",\"description\":null,\"status\":true,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-03T14:35:02.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"unit_code\":\"UNT000001\",\"name\":\"Piece\",\"short_name\":\"PCS\",\"description\":\"Piece\",\"status\":true,\"created_by\":null,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-03T15:02:59.000000Z\",\"deleted_at\":null}', 'units/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:02:59', '2026-08-03 14:02:59'),
(73, 1, 1, 1, 'Units', 'Updated', 'Updated unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"TEXT\",\"short_name\":\"TXT\",\"description\":\"TEXT\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-03T15:02:30.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-03T15:03:28.000000Z\",\"deleted_at\":null}', 'units/14', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:03:28', '2026-08-03 14:03:28'),
(74, 1, 1, 1, 'Units', 'Disabled', 'Unit Disabled: Text', 'Unit', 14, NULL, NULL, 'units/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:03:52', '2026-08-03 14:03:52'),
(75, 1, 1, 1, 'Units', 'Enabled', 'Unit Enabled: Text', 'Unit', 14, NULL, NULL, 'units/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:03:56', '2026-08-03 14:03:56'),
(76, 1, 1, 1, 'Units', 'Deleted', 'Deleted unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-03T15:03:56.000000Z\",\"deleted_at\":null}', '[]', 'units/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-03 14:04:02', '2026-08-03 14:04:02'),
(77, 1, 1, 1, 'Tax Rates', 'Created', 'Created tax rate: Test  Rate', 'TaxRate', 5, NULL, NULL, 'tax-rates', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:12:59', '2026-08-04 08:12:59'),
(78, 1, 1, 1, 'Tax Rates', 'Deleted', 'Deleted tax rate: Test  Rate', 'TaxRate', 5, NULL, NULL, 'tax-rates/5', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:30:41', '2026-08-04 08:30:41'),
(79, 1, 1, 1, 'Tax Rates', 'Created', 'Created tax rate: Test  Rate', 'TaxRate', 6, NULL, NULL, 'tax-rates', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:30:58', '2026-08-04 08:30:58'),
(80, 1, 1, 1, 'Tax Rates', 'Deleted', 'Deleted tax rate: Test  Rate', 'TaxRate', 6, NULL, NULL, 'tax-rates/6', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:41:21', '2026-08-04 08:41:21'),
(81, 1, 1, 1, 'Tax Rates', 'Created', 'Created tax rate: Test  Rate', 'TaxRate', 7, NULL, NULL, 'tax-rates', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:41:38', '2026-08-04 08:41:38'),
(82, 1, 1, 1, 'Tax Rates', 'Deleted', 'Deleted tax rate: Test  Rate', 'TaxRate', 7, NULL, NULL, 'tax-rates/7', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:41:46', '2026-08-04 08:41:46'),
(83, 1, 1, 1, 'Units', 'Restored', 'Restored unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-03T15:04:02.000000Z\",\"deleted_at\":\"2026-08-03T15:04:02.000000Z\"}', '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:42:57.000000Z\",\"deleted_at\":null}', 'units', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:42:57', '2026-08-04 08:42:57'),
(84, 1, 1, 1, 'Units', 'Deleted', 'Deleted unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:42:57.000000Z\",\"deleted_at\":null}', '[]', 'units/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:43:11', '2026-08-04 08:43:11'),
(85, 1, 1, 1, 'Units', 'Restored', 'Restored unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:43:11.000000Z\",\"deleted_at\":\"2026-08-04T09:43:11.000000Z\"}', '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:43:28.000000Z\",\"deleted_at\":null}', 'units', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:43:28', '2026-08-04 08:43:28'),
(86, 1, 1, 1, 'Units', 'Deleted', 'Deleted unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:43:28.000000Z\",\"deleted_at\":null}', '[]', 'units/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:45:31', '2026-08-04 08:45:31'),
(87, 1, 1, 1, 'Units', 'Restored', 'Restored unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:45:31.000000Z\",\"deleted_at\":\"2026-08-04T09:45:31.000000Z\"}', '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:45:46.000000Z\",\"deleted_at\":null}', 'units', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:45:46', '2026-08-04 08:45:46'),
(88, 1, 1, 1, 'Units', 'Deleted', 'Deleted unit: Text', 'Unit', 14, '{\"id\":14,\"company_id\":1,\"unit_code\":\"UNT000014\",\"name\":\"Text\",\"short_name\":\"TXT\",\"description\":\"Text\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-03T15:02:30.000000Z\",\"updated_at\":\"2026-08-04T09:45:46.000000Z\",\"deleted_at\":null}', '[]', 'units/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:48:18', '2026-08-04 08:48:18'),
(89, 1, 1, 1, 'Product Categories', 'Restored', 'Restored product category: TEXT', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"Building\",\"description\":\"Furniture , Upholstery.\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-02T16:14:57.000000Z\",\"deleted_at\":\"2026-08-02T16:14:57.000000Z\"}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"TEXT\",\"description\":\"TEXT\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-04T09:48:40.000000Z\",\"deleted_at\":null}', 'product-categories', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:48:40', '2026-08-04 08:48:40'),
(90, 1, 1, 1, 'Product Categories', 'Deleted', 'Deleted category: TEXT', 'ProductCategory', 14, '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"TEXT\",\"description\":\"TEXT\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-04T09:48:40.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"company_id\":1,\"category_code\":\"CAT000011\",\"name\":\"TEXT\",\"description\":\"TEXT\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-02T15:53:48.000000Z\",\"updated_at\":\"2026-08-04T09:48:45.000000Z\",\"deleted_at\":\"2026-08-04T09:48:45.000000Z\"}', 'product-categories/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:48:45', '2026-08-04 08:48:45'),
(91, 1, 1, 1, 'Tax Rates', 'Updated', 'Updated tax rate: No Tax', 'TaxRate', 1, '{\"id\":1,\"company_id\":1,\"name\":\"No Tax\",\"rate\":\"0.00\",\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\"}', '{\"id\":1,\"company_id\":1,\"name\":\"No Tax\",\"rate\":\"0.10\",\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-04T09:49:00.000000Z\"}', 'tax-rates/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:49:00', '2026-08-04 08:49:00'),
(92, 1, 1, 1, 'Tax Rates', 'Updated', 'Updated tax rate: No Tax', 'TaxRate', 1, '{\"id\":1,\"company_id\":1,\"name\":\"No Tax\",\"rate\":\"0.10\",\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-04T09:49:00.000000Z\"}', '{\"id\":1,\"company_id\":1,\"name\":\"No Tax\",\"rate\":\"0.00\",\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-04T09:49:11.000000Z\"}', 'tax-rates/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:49:11', '2026-08-04 08:49:11'),
(93, 1, 1, 1, 'Tax Rates', 'Disabled', 'Tax rate Disabled: No Tax', 'TaxRate', 1, NULL, NULL, 'tax-rates/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:49:14', '2026-08-04 08:49:14'),
(94, 1, 1, 1, 'Tax Rates', 'Enabled', 'Tax rate Enabled: No Tax', 'TaxRate', 1, NULL, NULL, 'tax-rates/1/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 08:49:18', '2026-08-04 08:49:18'),
(95, 1, 1, 1, 'Discounts', 'Created', 'Created discount: Test Discount', 'Discount', 5, NULL, NULL, 'discounts', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:06:31', '2026-08-04 10:06:31'),
(96, 1, 1, 1, 'Discounts', 'Updated', 'Updated discount: Test Discount', 'Discount', 5, '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":0,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:06:31.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":0,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:06:31.000000Z\",\"deleted_at\":null}', 'discounts/5', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:28:42', '2026-08-04 10:28:42'),
(97, 1, 1, 1, 'Discounts', 'Updated', 'Updated discount: Test Discount', 'Discount', 5, '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":0,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:06:31.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:48.000000Z\",\"deleted_at\":null}', 'discounts/5', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:29:48', '2026-08-04 10:29:48'),
(98, 1, 1, 1, 'Discounts', 'Disabled', 'Disabled discount: Test Discount', 'Discount', 5, '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:48.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":false,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:57.000000Z\",\"deleted_at\":null}', 'discounts/5/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:29:57', '2026-08-04 10:29:57'),
(99, 1, 1, 1, 'Discounts', 'Enabled', 'Enabled discount: Test Discount', 'Discount', 5, '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":false,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:57.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:59.000000Z\",\"deleted_at\":null}', 'discounts/5/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:29:59', '2026-08-04 10:29:59'),
(100, 1, 1, 1, 'Discounts', 'Deleted', 'Deleted discount: Test Discount', 'Discount', 5, '{\"id\":5,\"company_id\":1,\"name\":\"Test Discount\",\"is_automatic\":1,\"type\":\"Percentage\",\"value\":\"2.00\",\"start_date\":\"2026-08-04T00:00:00.000000Z\",\"end_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":true,\"created_at\":\"2026-08-04T11:06:31.000000Z\",\"updated_at\":\"2026-08-04T11:29:59.000000Z\",\"deleted_at\":null}', NULL, 'discounts/5', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 10:30:03', '2026-08-04 10:30:03'),
(101, 1, 1, 1, 'Products', 'Created', 'Created product: Test Coke', 'Product', 13, NULL, NULL, 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 13:11:14', '2026-08-04 13:11:14'),
(102, 1, 1, 1, 'Products', 'Updated', 'Updated product: Test Coke', 'Product', 13, '{\"id\":13,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":null,\"cost_price\":\"4500.00\",\"selling_price\":\"5000.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Emmanex\",\"manufacturer\":\"Emmanex\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"100.00\",\"weight\":\"30.00\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-04T14:11:14.000000Z\",\"updated_at\":\"2026-08-04T14:11:14.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":13,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785852936_6a71f408d6ce2.jpg\",\"cost_price\":\"4500.00\",\"selling_price\":\"5000.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"100.00\",\"weight\":\"30.00\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-04T14:11:14.000000Z\",\"updated_at\":\"2026-08-04T14:15:36.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/13', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-04 13:15:36', '2026-08-04 13:15:36'),
(103, 1, 1, 1, 'Products', 'Created', 'Created product: Test Coke', 'Product', 14, NULL, NULL, 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-05 09:40:12', '2026-08-05 09:40:12'),
(104, 1, 1, 1, 'Products', 'Updated', 'Updated product: Test Coke', 'Product', 14, '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4500.00\",\"selling_price\":\"5000.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:40:12.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:40:43.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/14', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-05 09:40:43', '2026-08-05 09:40:43'),
(105, 1, 1, 1, 'Products', 'Disabled', 'Disabled product: Test Coke', 'Product', 14, '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:40:43.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":false,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:53:43.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-05 09:53:43', '2026-08-05 09:53:43'),
(106, 1, 1, 1, 'Products', 'Enabled', 'Enabled product: Test Coke', 'Product', 14, '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":false,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:53:43.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:53:48.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/14/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-05 09:53:48', '2026-08-05 09:53:48'),
(107, 1, 1, 1, 'Products', 'Deleted', 'Deleted product: Test Coke', 'Product', 14, '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-05T10:53:48.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', NULL, 'products/14', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-05 09:53:51', '2026-08-05 09:53:51'),
(108, 1, 1, 1, 'Account', 'Updated', 'User updated their profile.', 'User', 1, '{\"first_name\":\"System\",\"last_name\":\"Owner\",\"email\":\"owner@emmanexitconsult.com\"}', '{\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"owner@emmanexitconsult.com\"}', 'account/profile', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-08 08:27:42', '2026-08-08 08:27:42'),
(109, 1, 1, 1, 'Account', 'Password Changed', 'User changed their password.', 'User', 1, NULL, NULL, 'account/password', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-08 08:30:00', '2026-08-08 08:30:00'),
(110, 1, 1, 1, 'Users', 'Created', 'Created user Maxwell Akinkunmi Akinyooye', 'User', 17, NULL, '{\"company_id\":1,\"branch_id\":\"2\",\"role_id\":\"3\",\"employee_no\":\"MG-2026-001\",\"first_name\":\"Maxwell\",\"last_name\":\"Akinyooye\",\"other_name\":\"Akinkunmi\",\"username\":\"maxwell\",\"email\":\"maxwell@gmail.com\",\"phone\":\"08034271855\",\"gender\":\"Male\",\"date_of_birth\":\"2017-09-27T00:00:00.000000Z\",\"employment_date\":\"2026-08-03T00:00:00.000000Z\",\"address\":\"Ibadan\",\"notes\":\"Branch manager of lekki branch.\",\"status\":true,\"force_password_change\":true,\"password_changed_at\":null,\"updated_at\":\"2026-08-09T08:43:51.000000Z\",\"created_at\":\"2026-08-09T08:43:51.000000Z\",\"id\":17}', 'users/store', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 07:43:51', '2026-08-09 07:43:51'),
(111, 1, 1, 1, 'Stock', 'Updated', 'Stock adjusted for product ID 1 at branch ID 1', 'ProductStock', 1, '{\"quantity\":\"100.00\"}', '{\"quantity\":110}', 'stock', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 11:06:03', '2026-08-09 11:06:03'),
(112, 1, 1, 1, 'Stock', 'Updated', 'Stock adjusted for product ID 1 at branch ID 1', 'ProductStock', 1, '{\"quantity\":\"110.00\"}', '{\"quantity\":90}', 'stock', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 11:37:17', '2026-08-09 11:37:17'),
(113, 1, 1, 1, 'Terminal Management', 'Updated', 'Updated terminal BR001-POS01', 'Terminal', 1, '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"terminal_code\":\"BR001-POS01\",\"terminal_name\":\"Head Office POS 1\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"terminal_code\":\"BR001-POS01\",\"terminal_name\":\"Head Office POS 1\",\"description\":\"Main Checkout\",\"device_name\":\"Desktop POS\",\"ip_address\":\"192.168.0.23\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-08-09T15:46:14.000000Z\",\"deleted_at\":null}', 'terminals/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 14:46:14', '2026-08-09 14:46:14');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(114, 1, 1, 1, 'Terminal Management', 'Updated', 'Updated terminal BR001-POS01', 'Terminal', 1, '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"terminal_code\":\"BR001-POS01\",\"terminal_name\":\"Head Office POS 1\",\"description\":\"Main Checkout\",\"device_name\":\"Desktop POS\",\"ip_address\":\"192.168.0.23\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-08-09T15:46:14.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"terminal_code\":\"BR001-POS01\",\"terminal_name\":\"Head Office POS 1\",\"description\":\"Main Checkout\",\"device_name\":\"Desktop POS\",\"ip_address\":\"192.168.0.23\",\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-08-09T15:46:14.000000Z\",\"deleted_at\":null}', 'terminals/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 14:46:15', '2026-08-09 14:46:15'),
(115, 1, 1, 1, 'User Management', 'Updated', 'Updated user Main Cashier', 'User', 5, '{\"id\":5,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"EMP0005\",\"first_name\":\"Main\",\"other_name\":null,\"last_name\":\"Cashier\",\"username\":\"cashier\",\"email\":\"cashier@emmanexitconsult.com\",\"is_owner\":false,\"email_verified_at\":\"2026-07-29T11:37:11.000000Z\",\"two_factor_enabled\":false,\"phone\":null,\"profile_photo\":null,\"gender\":null,\"date_of_birth\":null,\"employment_date\":\"2026-07-29T00:00:00.000000Z\",\"address\":null,\"notes\":null,\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-29T11:37:12.000000Z\",\"updated_at\":\"2026-07-29T11:37:12.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"EMP0005\",\"first_name\":\"Main\",\"other_name\":null,\"last_name\":\"Cashier\",\"username\":\"cashier\",\"email\":\"cashier@emmanexitconsult.com\",\"is_owner\":false,\"email_verified_at\":\"2026-07-29T11:37:11.000000Z\",\"two_factor_enabled\":false,\"phone\":null,\"profile_photo\":null,\"gender\":null,\"date_of_birth\":\"1991-06-12T00:00:00.000000Z\",\"employment_date\":\"2026-07-29T00:00:00.000000Z\",\"address\":null,\"notes\":null,\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-29T11:37:12.000000Z\",\"updated_at\":\"2026-08-09T15:53:48.000000Z\",\"deleted_at\":null}', 'users/5', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 14:53:48', '2026-08-09 14:53:48'),
(116, 1, 1, 1, 'User Management', 'Updated', 'Updated user Main Cashier', 'User', 5, '{\"id\":5,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"EMP0005\",\"first_name\":\"Main\",\"other_name\":null,\"last_name\":\"Cashier\",\"username\":\"cashier\",\"email\":\"cashier@emmanexitconsult.com\",\"is_owner\":false,\"email_verified_at\":\"2026-07-29T11:37:11.000000Z\",\"two_factor_enabled\":false,\"phone\":null,\"profile_photo\":null,\"gender\":null,\"date_of_birth\":\"1991-06-12T00:00:00.000000Z\",\"employment_date\":\"2026-07-29T00:00:00.000000Z\",\"address\":null,\"notes\":null,\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-29T11:37:12.000000Z\",\"updated_at\":\"2026-08-09T15:53:48.000000Z\",\"deleted_at\":null}', '{\"id\":5,\"company_id\":1,\"branch_id\":1,\"role_id\":5,\"employee_no\":\"EMP0005\",\"first_name\":\"Main\",\"other_name\":null,\"last_name\":\"Cashier\",\"username\":\"cashier\",\"email\":\"cashier@emmanexitconsult.com\",\"is_owner\":false,\"email_verified_at\":\"2026-07-29T11:37:11.000000Z\",\"two_factor_enabled\":false,\"phone\":null,\"profile_photo\":null,\"gender\":null,\"date_of_birth\":\"1991-06-12T00:00:00.000000Z\",\"employment_date\":\"2026-07-29T00:00:00.000000Z\",\"address\":null,\"notes\":null,\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-29T11:37:12.000000Z\",\"updated_at\":\"2026-08-09T15:53:48.000000Z\",\"deleted_at\":null}', 'users/5', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 14:53:49', '2026-08-09 14:53:49'),
(117, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-02T01:52:44.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket Ng\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-09T16:23:25.000000Z\"}', 'settings/general', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 15:23:25', '2026-08-09 15:23:25'),
(118, 1, 1, 1, 'Document Sequences', 'Disabled', 'Disabled order document sequence.', 'DocumentSequence', 5, '{\"id\":5,\"company_id\":1,\"document_type\":\"order\",\"prefix\":\"ORD\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-08-03T14:22:19.000000Z\",\"updated_at\":\"2026-08-03T14:22:19.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":5,\"company_id\":1,\"document_type\":\"order\",\"prefix\":\"ORD\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":false,\"created_at\":\"2026-08-03T14:22:19.000000Z\",\"updated_at\":\"2026-08-09T16:34:55.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/5/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 15:34:55', '2026-08-09 15:34:55'),
(119, 1, 1, 1, 'Document Sequences', 'Enabled', 'Enabled order document sequence.', 'DocumentSequence', 5, '{\"id\":5,\"company_id\":1,\"document_type\":\"order\",\"prefix\":\"ORD\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":false,\"created_at\":\"2026-08-03T14:22:19.000000Z\",\"updated_at\":\"2026-08-09T16:34:55.000000Z\",\"use_date_in_sequence\":0}', '{\"id\":5,\"company_id\":1,\"document_type\":\"order\",\"prefix\":\"ORD\",\"suffix\":null,\"separator\":\"-\",\"current_number\":1,\"number_length\":6,\"reset_frequency\":\"Never\",\"last_reset_at\":null,\"status\":true,\"created_at\":\"2026-08-03T14:22:19.000000Z\",\"updated_at\":\"2026-08-09T16:34:59.000000Z\",\"use_date_in_sequence\":0}', 'document-sequences/5/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 15:34:59', '2026-08-09 15:34:59'),
(120, 1, 1, 1, 'Payment Methods', 'Disabled', 'POS payment method status changed.', 'PaymentMethod', 2, NULL, NULL, 'payment-methods/2/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 15:43:36', '2026-08-09 15:43:36'),
(121, 1, 1, 1, 'Payment Methods', 'Enabled', 'POS payment method status changed.', 'PaymentMethod', 2, NULL, NULL, 'payment-methods/2/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 15:43:40', '2026-08-09 15:43:40'),
(122, 1, 1, 1, 'Products', 'Updated', 'Updated product: Peak Milk 500g', 'Product', 4, '{\"id\":4,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000004\",\"barcode\":\"100000000004\",\"sku\":\"PEAK500\",\"qr_code\":null,\"name\":\"Peak Milk 500g\",\"description\":null,\"image\":null,\"cost_price\":\"4200.00\",\"selling_price\":\"4800.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Peak\",\"manufacturer\":\"FrieslandCampina\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":4,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000004\",\"barcode\":\"100000000004\",\"sku\":\"PEAK500\",\"qr_code\":null,\"name\":\"Peak Milk 500g\",\"description\":\"Peak Milk 500g\",\"image\":null,\"cost_price\":\"4200.00\",\"selling_price\":\"4800.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Peak\",\"manufacturer\":\"FrieslandCampina\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-09T17:32:26.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 16:32:26', '2026-08-09 16:32:26'),
(123, 1, 1, 1, 'Products', 'Restored', 'Restored product: Three Crown Evaporated Milk', 'Product', 14, '{\"id\":14,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000011\",\"barcode\":\"123456\",\"sku\":\"Tcoke50cl\",\"qr_code\":null,\"name\":\"Test Coke\",\"description\":\"Test Coke\",\"image\":\"1785926412_6a73130c53070.jpg\",\"cost_price\":\"4000.00\",\"selling_price\":\"4200.00\",\"discount_id\":null,\"unit_id\":8,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coke\",\"manufacturer\":\"Cocacola\",\"expiry_date\":\"2028-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"5.00\",\"maximum_stock\":\"10.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-09T18:19:44.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":14,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000011\",\"barcode\":\"TH123456\",\"sku\":\"3crown\",\"qr_code\":null,\"name\":\"Three Crown Evaporated Milk\",\"description\":\"Three Crown Evaporated Milk\",\"image\":\"1786299584_6a78c4c0726c3.png\",\"cost_price\":\"1500.00\",\"selling_price\":\"1700.00\",\"discount_id\":null,\"unit_id\":5,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"expiry_date\":\"2026-08-27T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"500.00\",\"maximum_stock\":\"1000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-05T10:40:12.000000Z\",\"updated_at\":\"2026-08-09T18:19:44.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 17:19:44', '2026-08-09 17:19:44'),
(124, 1, 1, 1, 'Products', 'Created', 'Created product: Three Crown Evaporated Milk', 'Product', 15, NULL, NULL, 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 17:39:05', '2026-08-09 17:39:05'),
(125, 1, 1, 1, 'Products', 'Created', 'Created product: Three Crown Evaporated Milk', 'Product', 16, NULL, NULL, 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 17:44:33', '2026-08-09 17:44:33'),
(126, 1, 1, 1, 'Products', 'Created', 'Created product: Three Crown Evaporated Milk', 'Product', 19, NULL, NULL, 'products', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-09 17:52:05', '2026-08-09 17:52:05'),
(127, 1, 1, 1, 'Inventory', 'Stock Transferred', 'Transferred 2 product(s) from Head Office to Ajah Outlet New. Reference: TRF-20260811095105-Z8MMFQ', 'Branch', 1, NULL, '{\"reference_no\":\"TRF-20260811095105-Z8MMFQ\",\"source_branch_id\":1,\"destination_branch_id\":4,\"items\":[{\"stock_id\":13,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"quantity\":10,\"source_balance\":140,\"destination_balance\":10},{\"stock_id\":10,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"quantity\":10,\"source_balance\":90,\"destination_balance\":10}]}', 'stock-transfer/transfer', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-11 08:51:05', '2026-08-11 08:51:05'),
(128, 1, 1, 1, 'Inventory', 'Stock Transferred', 'Transferred 3 product(s) from Head Office to Ikorodu Outlet. Reference: TRF-20260811103939-GTPV70', 'Branch', 1, NULL, '{\"reference_no\":\"TRF-20260811103939-GTPV70\",\"source_branch_id\":1,\"destination_branch_id\":6,\"items\":[{\"stock_id\":13,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"quantity\":5,\"source_balance\":135,\"destination_balance\":5},{\"stock_id\":10,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"quantity\":5,\"source_balance\":85,\"destination_balance\":5},{\"stock_id\":9,\"product_id\":9,\"product_name\":\"Premier Soap\",\"quantity\":10,\"source_balance\":90,\"destination_balance\":10}]}', 'stock-transfer/transfer', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(129, 1, 1, 1, 'Inventory', 'Stock Transferred', 'Transferred 5 product(s) from Head Office to Ajah Outlet New. Reference: TRF-20260814111511-MPNNZ9', 'Branch', 1, NULL, '{\"reference_no\":\"TRF-20260814111511-MPNNZ9\",\"source_branch_id\":1,\"destination_branch_id\":4,\"items\":[{\"stock_id\":9,\"product_id\":9,\"product_name\":\"Premier Soap\",\"quantity\":10,\"source_balance\":80,\"destination_balance\":10},{\"stock_id\":8,\"product_id\":8,\"product_name\":\"Mama Gold Rice 50kg\",\"quantity\":5,\"source_balance\":95,\"destination_balance\":5},{\"stock_id\":7,\"product_id\":7,\"product_name\":\"Family Bread\",\"quantity\":5,\"source_balance\":95,\"destination_balance\":5},{\"stock_id\":6,\"product_id\":6,\"product_name\":\"Dangote Sugar 1kg\",\"quantity\":5,\"source_balance\":95,\"destination_balance\":5},{\"stock_id\":5,\"product_id\":5,\"product_name\":\"Indomie Chicken Noodles\",\"quantity\":10,\"source_balance\":90,\"destination_balance\":10}]}', 'stock-transfer/transfer', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(130, 1, 1, 1, 'Stock Count', 'Created', 'Created stock count SC-000001', 'StockCount', 1, NULL, '{\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000001\",\"count_date\":\"2026-08-14T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Stock Count\",\"created_by\":1,\"updated_at\":\"2026-08-14T11:18:15.000000Z\",\"created_at\":\"2026-08-14T11:18:15.000000Z\",\"id\":1}', 'stock-count', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-14 10:18:15', '2026-08-14 10:18:15'),
(131, 1, 1, 1, 'Stock Count', 'Updated', 'Updated stock count SC-000001', 'StockCount', 1, '{\"id\":1,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000001\",\"count_date\":\"2026-08-14T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Stock Count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-14T11:18:15.000000Z\",\"updated_at\":\"2026-08-14T11:18:15.000000Z\"}', '{\"id\":1,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000001\",\"count_date\":\"2026-08-14T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Test Stock Count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-14T11:18:15.000000Z\",\"updated_at\":\"2026-08-14T12:54:30.000000Z\"}', 'stock-count/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-14 11:54:30', '2026-08-14 11:54:30'),
(132, 1, 1, 1, 'Stock Count', 'Deleted', 'Deleted stock count SC-000001', 'StockCount', 1, '{\"id\":1,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000001\",\"count_date\":\"2026-08-14T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Test Stock Count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-14T11:18:15.000000Z\",\"updated_at\":\"2026-08-14T12:54:30.000000Z\"}', NULL, 'stock-count/1', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-14 11:55:02', '2026-08-14 11:55:02'),
(133, 1, 1, 1, 'Stock Count', 'Created', 'Created stock count SC-000002', 'StockCount', 2, NULL, '{\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000002\",\"count_date\":\"2026-08-15T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Stock count\",\"created_by\":1,\"updated_at\":\"2026-08-15T09:50:57.000000Z\",\"created_at\":\"2026-08-15T09:50:57.000000Z\",\"id\":2}', 'stock-count', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 08:50:57', '2026-08-15 08:50:57'),
(134, 1, 1, 1, 'Stock Count', 'Updated', 'Updated stock count SC-000002', 'StockCount', 2, '{\"id\":2,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000002\",\"count_date\":\"2026-08-15T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Stock count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-15T09:50:57.000000Z\",\"updated_at\":\"2026-08-15T09:50:57.000000Z\"}', '{\"id\":2,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000002\",\"count_date\":\"2026-08-15T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Test Stock count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-15T09:50:57.000000Z\",\"updated_at\":\"2026-08-15T09:51:11.000000Z\"}', 'stock-count/2', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 08:51:11', '2026-08-15 08:51:11'),
(135, 1, 1, 1, 'Stock Count', 'Deleted', 'Deleted stock count SC-000002', 'StockCount', 2, '{\"id\":2,\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000002\",\"count_date\":\"2026-08-15T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Test Stock count\",\"created_by\":1,\"completed_by\":null,\"completed_at\":null,\"created_at\":\"2026-08-15T09:50:57.000000Z\",\"updated_at\":\"2026-08-15T09:51:11.000000Z\"}', NULL, 'stock-count/2', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 08:51:15', '2026-08-15 08:51:15'),
(136, 1, 1, 1, 'Stock Count', 'Created', 'Created stock count SC-000003', 'StockCount', 3, NULL, '{\"company_id\":1,\"branch_id\":4,\"reference_no\":\"SC-000003\",\"count_date\":\"2026-08-15T00:00:00.000000Z\",\"status\":\"Draft\",\"notes\":\"Test stock count\",\"created_by\":1,\"updated_at\":\"2026-08-15T09:53:31.000000Z\",\"created_at\":\"2026-08-15T09:53:31.000000Z\",\"id\":3}', 'stock-count', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 08:53:31', '2026-08-15 08:53:31'),
(137, 1, 1, 1, 'Stock Count', 'Started', 'Started stock count SC-000003', 'StockCount', 3, '{\"status\":\"Draft\"}', '{\"status\":\"In Progress\"}', 'stock-count/3/start', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 10:11:18', '2026-08-15 10:11:18'),
(138, 1, 1, 1, 'Stock Count', 'Completed', 'Completed stock count SC-000003', 'StockCount', 3, '{\"status\":\"In Progress\"}', '{\"status\":\"Completed\",\"completed_by\":1,\"completed_at\":\"2026-08-15T12:11:39.000000Z\"}', 'stock-count/3/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(139, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Regular Customers (REGULAR)', 'CustomerGroup', 2, NULL, '{\"company_id\":1,\"name\":\"Regular Customers\",\"code\":\"REGULAR\",\"description\":\"Customers who purchase regularly\",\"discount_percentage\":\"2.00\",\"credit_limit\":\"50000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:09:30.000000Z\",\"created_at\":\"2026-08-16T03:09:30.000000Z\",\"id\":2}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:09:30', '2026-08-16 02:09:30'),
(140, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: VIP Customers (VIP)', 'CustomerGroup', 3, NULL, '{\"company_id\":1,\"name\":\"VIP Customers\",\"code\":\"VIP\",\"description\":\"High-value customers\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"200000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:10:10.000000Z\",\"created_at\":\"2026-08-16T03:10:10.000000Z\",\"id\":3}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:10:10', '2026-08-16 02:10:10'),
(141, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Wholesale Customers (WHOLESALE)', 'CustomerGroup', 4, NULL, '{\"company_id\":1,\"name\":\"Wholesale Customers\",\"code\":\"WHOLESALE\",\"description\":\"Bulk\\/wholesale buyers\",\"discount_percentage\":\"8.00\",\"credit_limit\":\"1000000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:10:56.000000Z\",\"created_at\":\"2026-08-16T03:10:56.000000Z\",\"id\":4}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:10:56', '2026-08-16 02:10:56'),
(142, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Retailers (RETAILER)', 'CustomerGroup', 5, NULL, '{\"company_id\":1,\"name\":\"Retailers\",\"code\":\"RETAILER\",\"description\":\"Businesses buying for resale\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"500000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:14:03.000000Z\",\"created_at\":\"2026-08-16T03:14:03.000000Z\",\"id\":5}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:14:03', '2026-08-16 02:14:03'),
(143, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Corporate Customers (CORPORATE)', 'CustomerGroup', 6, NULL, '{\"company_id\":1,\"name\":\"Corporate Customers\",\"code\":\"CORPORATE\",\"description\":\"Companies and organizations\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"2000000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:14:42.000000Z\",\"created_at\":\"2026-08-16T03:14:42.000000Z\",\"id\":6}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:14:42', '2026-08-16 02:14:42'),
(144, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Distributors (DISTRIBUTOR)', 'CustomerGroup', 7, NULL, '{\"company_id\":1,\"name\":\"Distributors\",\"code\":\"DISTRIBUTOR\",\"description\":\"Large-volume distribution customers\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"5000000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:15:27.000000Z\",\"created_at\":\"2026-08-16T03:15:27.000000Z\",\"id\":7}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:15:27', '2026-08-16 02:15:27'),
(145, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 8, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"50000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:16:13.000000Z\",\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"id\":8}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:16:13', '2026-08-16 02:16:13'),
(146, 1, 1, 1, 'customer_groups', 'update', 'Updated customer group: Staff (STAFF)', 'CustomerGroup', 8, '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"50000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:16:13.000000Z\"}', '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:21:19.000000Z\"}', 'customers/groups/8', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:21:19', '2026-08-16 02:21:19'),
(147, 1, 1, 1, 'customer_groups', 'disable', 'Disabled customer group: Staff (STAFF)', 'CustomerGroup', 8, '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:21:19.000000Z\"}', '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:23:51.000000Z\"}', 'customers/groups/8/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:23:51', '2026-08-16 02:23:51'),
(148, 1, 1, 1, 'customer_groups', 'enable', 'Enabled customer group: Staff (STAFF)', 'CustomerGroup', 8, '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:23:51.000000Z\"}', '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:23:56.000000Z\"}', 'customers/groups/8/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:23:56', '2026-08-16 02:23:56'),
(149, 1, 1, 1, 'customer_groups', 'delete', 'Deleted customer group: Staff (STAFF)', 'CustomerGroup', 8, '{\"id\":8,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employees\\/staff purchases\",\"discount_percentage\":\"10.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:16:13.000000Z\",\"updated_at\":\"2026-08-16T03:23:56.000000Z\"}', NULL, 'customers/groups/8', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:24:11', '2026-08-16 02:24:11'),
(150, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 9, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"30000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:24:39.000000Z\",\"created_at\":\"2026-08-16T03:24:39.000000Z\",\"id\":9}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:24:39', '2026-08-16 02:24:39'),
(151, 1, 1, 1, 'customer_groups', 'delete', 'Deleted customer group: Staff (STAFF)', 'CustomerGroup', 9, '{\"id\":9,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"30000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:24:39.000000Z\",\"updated_at\":\"2026-08-16T03:24:39.000000Z\"}', NULL, 'customers/groups/9', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:32:48', '2026-08-16 02:32:48'),
(152, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 10, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:33:12.000000Z\",\"created_at\":\"2026-08-16T03:33:12.000000Z\",\"id\":10}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:33:12', '2026-08-16 02:33:12'),
(153, 1, 1, 1, 'customer_groups', 'delete', 'Deleted customer group: Staff (STAFF)', 'CustomerGroup', 10, '{\"id\":10,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:33:12.000000Z\",\"updated_at\":\"2026-08-16T03:33:12.000000Z\"}', NULL, 'customers/groups/10', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:34:10', '2026-08-16 02:34:10'),
(154, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 11, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:34:32.000000Z\",\"created_at\":\"2026-08-16T03:34:32.000000Z\",\"id\":11}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:34:32', '2026-08-16 02:34:32'),
(155, 1, 1, 1, 'customer_groups', 'delete', 'Deleted customer group: Staff (STAFF)', 'CustomerGroup', 11, '{\"id\":11,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:34:32.000000Z\",\"updated_at\":\"2026-08-16T03:34:32.000000Z\"}', NULL, 'customers/groups/11', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:37:21', '2026-08-16 02:37:21'),
(156, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 12, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:40:11.000000Z\",\"created_at\":\"2026-08-16T03:40:11.000000Z\",\"id\":12}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:40:11', '2026-08-16 02:40:11'),
(157, 1, 1, 1, 'customer_groups', 'delete', 'Deleted customer group: Staff (STAFF)', 'CustomerGroup', 12, '{\"id\":12,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:40:11.000000Z\",\"updated_at\":\"2026-08-16T03:40:11.000000Z\"}', NULL, 'customers/groups/12', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:40:18', '2026-08-16 02:40:18'),
(158, 1, 1, 1, 'customer_groups', 'create', 'Created customer group: Staff (STAFF)', 'CustomerGroup', 13, NULL, '{\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:40:32.000000Z\",\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"id\":13}', 'customers/groups', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:40:32', '2026-08-16 02:40:32'),
(159, 1, 1, 1, 'customers', 'create', 'Created customer: Femi Akinyooye', 'Customer', 6, NULL, '{\"company_id\":1,\"customer_group_id\":2,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T03:50:25.000000Z\",\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"id\":6}', 'customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 02:50:25', '2026-08-16 02:50:25'),
(160, 1, 1, 1, 'customers', 'update', 'Updated customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T03:50:25.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Registered\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T04:44:09.000000Z\",\"deleted_at\":null}', 'customers/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 03:44:09', '2026-08-16 03:44:09'),
(161, 1, 1, 1, 'customer_groups', 'disable', 'Disabled customer group: Corporate Customers (CORPORATE)', 'CustomerGroup', 6, '{\"id\":6,\"company_id\":1,\"name\":\"Corporate Customers\",\"code\":\"CORPORATE\",\"description\":\"Companies and organizations\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"2000000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:14:42.000000Z\",\"updated_at\":\"2026-08-16T03:14:42.000000Z\"}', '{\"id\":6,\"company_id\":1,\"name\":\"Corporate Customers\",\"code\":\"CORPORATE\",\"description\":\"Companies and organizations\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"2000000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:14:42.000000Z\",\"updated_at\":\"2026-08-16T05:12:09.000000Z\"}', 'customers/groups/6/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:12:09', '2026-08-16 04:12:09'),
(162, 1, 1, 1, 'customer_groups', 'enable', 'Enabled customer group: Corporate Customers (CORPORATE)', 'CustomerGroup', 6, '{\"id\":6,\"company_id\":1,\"name\":\"Corporate Customers\",\"code\":\"CORPORATE\",\"description\":\"Companies and organizations\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"2000000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:14:42.000000Z\",\"updated_at\":\"2026-08-16T05:12:09.000000Z\"}', '{\"id\":6,\"company_id\":1,\"name\":\"Corporate Customers\",\"code\":\"CORPORATE\",\"description\":\"Companies and organizations\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"2000000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:14:42.000000Z\",\"updated_at\":\"2026-08-16T05:12:23.000000Z\"}', 'customers/groups/6/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:12:23', '2026-08-16 04:12:23'),
(163, 1, 1, 1, 'customers', 'update', 'Updated customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Registered\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T04:44:09.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:13:14.000000Z\",\"deleted_at\":null}', 'customers/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:13:14', '2026-08-16 04:13:14'),
(164, 1, 1, 1, 'customer_groups', 'disable', 'Disabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T03:40:32.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:30:32.000000Z\"}', 'customers/groups/13/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:30:32', '2026-08-16 04:30:32'),
(165, 1, 1, 1, 'customer_groups', 'enable', 'Enabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:30:32.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:30:36.000000Z\"}', 'customers/groups/13/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:30:36', '2026-08-16 04:30:36'),
(166, 1, 1, 1, 'customer_groups', 'disable', 'Disabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:30:36.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:33:42.000000Z\"}', 'customers/groups/13/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:33:42', '2026-08-16 04:33:42'),
(167, 1, 1, 1, 'customer_groups', 'enable', 'Enabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:33:42.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:33:45.000000Z\"}', 'customers/groups/13/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:33:45', '2026-08-16 04:33:45'),
(168, 1, 1, 1, 'customers', 'disable', 'Disabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:13:14.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:37:42.000000Z\",\"deleted_at\":null}', 'customers/6/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:37:42', '2026-08-16 04:37:42');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(169, 1, 1, 1, 'customers', 'disable', 'Disabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:37:42.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:37:42.000000Z\",\"deleted_at\":null}', 'customers/6/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:42:06', '2026-08-16 04:42:06'),
(170, 1, 1, 1, 'customer_groups', 'disable', 'Disabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:33:45.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:45:11.000000Z\"}', 'customers/groups/13/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:45:11', '2026-08-16 04:45:11'),
(171, 1, 1, 1, 'customer_groups', 'enable', 'Enabled customer group: Staff (STAFF)', 'CustomerGroup', 13, '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:45:11.000000Z\"}', '{\"id\":13,\"company_id\":1,\"name\":\"Staff\",\"code\":\"STAFF\",\"description\":\"Employee\",\"discount_percentage\":\"5.00\",\"credit_limit\":\"20000.00\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:40:32.000000Z\",\"updated_at\":\"2026-08-16T05:45:14.000000Z\"}', 'customers/groups/13/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:45:14', '2026-08-16 04:45:14'),
(172, 1, 1, 1, 'customers', 'enable', 'Enabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:37:42.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:50.000000Z\",\"deleted_at\":null}', 'customers/6/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:53:50', '2026-08-16 04:53:50'),
(173, 1, 1, 1, 'customers', 'disable', 'Disabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:50.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:54.000000Z\",\"deleted_at\":null}', 'customers/6/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:53:54', '2026-08-16 04:53:54'),
(174, 1, 1, 1, 'customers', 'enable', 'Enabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:54.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T11:06:44.000000Z\",\"deleted_at\":null}', 'customers/6/enable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:06:44', '2026-08-16 10:06:44'),
(175, 1, 1, 1, 'customers', 'delete', 'Deleted customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T11:06:44.000000Z\",\"deleted_at\":null}', NULL, 'customers/6', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:14:45', '2026-08-16 10:14:45'),
(176, 1, 1, 1, 'customers', 'create', 'Created customer: Femi Akinyooye', 'Customer', 7, NULL, '{\"company_id\":1,\"customer_group_id\":7,\"customer_code\":\"CUS-00002\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T11:18:38.000000Z\",\"created_at\":\"2026-08-16T11:18:38.000000Z\",\"id\":7}', 'customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:18:38', '2026-08-16 10:18:38'),
(177, 1, 1, 1, 'customers', 'update', 'Updated customer: Clement Elugbaju', 'Customer', 7, '{\"id\":7,\"company_id\":1,\"customer_group_id\":7,\"branch_id\":null,\"customer_code\":\"CUS-00002\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-16T11:18:38.000000Z\",\"updated_at\":\"2026-08-16T11:18:38.000000Z\",\"deleted_at\":null}', '{\"id\":7,\"company_id\":1,\"customer_group_id\":7,\"branch_id\":null,\"customer_code\":\"CUS-00002\",\"first_name\":\"Clement\",\"last_name\":\"Elugbaju\",\"email\":\"clement@gmail.com\",\"phone\":\"07038899203\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T11:18:38.000000Z\",\"updated_at\":\"2026-08-16T11:19:57.000000Z\",\"deleted_at\":null}', 'customers/7', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:19:57', '2026-08-16 10:19:57'),
(178, 1, 1, 1, 'customers', 'delete', 'Deleted customer: Clement Elugbaju', 'Customer', 7, '{\"id\":7,\"company_id\":1,\"customer_group_id\":7,\"branch_id\":null,\"customer_code\":\"CUS-00002\",\"first_name\":\"Clement\",\"last_name\":\"Elugbaju\",\"email\":\"clement@gmail.com\",\"phone\":\"07038899203\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T11:18:38.000000Z\",\"updated_at\":\"2026-08-16T11:19:57.000000Z\",\"deleted_at\":null}', NULL, 'customers/7', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:25:12', '2026-08-16 10:25:12'),
(179, 1, 1, 1, 'customers', 'create', 'Created customer: Clement Elugbaju', 'Customer', 8, NULL, '{\"company_id\":1,\"customer_group_id\":7,\"customer_code\":\"CUS-00003\",\"first_name\":\"Clement\",\"last_name\":\"Elugbaju\",\"email\":\"clement@gmail.com\",\"phone\":\"07038899203\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T11:25:41.000000Z\",\"created_at\":\"2026-08-16T11:25:41.000000Z\",\"id\":8}', 'customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:25:41', '2026-08-16 10:25:41'),
(180, 1, 1, 1, 'customers', 'restore', 'Restored customer: Femi Akinyooye', 'Customer', 6, NULL, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T11:34:35.000000Z\",\"deleted_at\":null}', 'customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:34:35', '2026-08-16 10:34:35'),
(181, 1, 1, 1, 'customers', 'create', 'Created customer: Clement Elugbaju', 'Customer', 9, NULL, '{\"company_id\":1,\"customer_group_id\":7,\"customer_code\":\"CUS-00007\",\"first_name\":\"Clement\",\"last_name\":\"Elugbaju\",\"email\":\"clement@gmail.com\",\"phone\":\"07038899203\",\"address\":\"Ibadan\",\"credit_limit\":\"5000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Business\",\"loyalty_points\":0,\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-16T11:35:39.000000Z\",\"created_at\":\"2026-08-16T11:35:39.000000Z\",\"id\":9}', 'customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 10:35:39', '2026-08-16 10:35:39'),
(182, 1, 1, 1, 'Suppliers', 'Created', 'Created supplier: Friezland Group of Companies', 'Supplier', 1, NULL, '{\"company_id\":1,\"supplier_code\":\"SUP-00001\",\"name\":\"Friezland Group of Companies\",\"contact_person\":\"Mr Adeleke Abayomi\",\"email\":\"info@friezland.com\",\"phone\":\"07032109983\",\"alternate_phone\":\"07032109983\",\"address\":\"17, Ojokoro avenue, abeokuta, Ogun State.\",\"city\":\"Abeokuta\",\"state\":\"Ogun\",\"country\":\"Nigeria\",\"tax_number\":\"29839393\",\"payment_terms\":\"30 days\",\"credit_limit\":\"1000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Friezland.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"updated_at\":\"2026-08-16T12:27:31.000000Z\",\"created_at\":\"2026-08-16T12:27:31.000000Z\",\"id\":1}', 'purchase/suppliers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:27:31', '2026-08-16 11:27:31'),
(183, 1, 1, 1, 'Suppliers', 'Created', 'Created supplier: Nigerian Breweries', 'Supplier', 2, NULL, '{\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Bunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"updated_at\":\"2026-08-16T12:35:20.000000Z\",\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"id\":2}', 'purchase/suppliers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:35:20', '2026-08-16 11:35:20'),
(184, 1, 1, 1, 'Suppliers', 'Updated', 'Updated supplier: Nigerian Breweries', 'Supplier', 2, '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Bunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:35:20.000000Z\",\"deleted_at\":null}', '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:38:43.000000Z\",\"deleted_at\":null}', 'purchase/suppliers/2', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:38:43', '2026-08-16 11:38:43'),
(185, 1, 1, 1, 'Suppliers', 'Disabled', 'Disabled supplier: Nigerian Breweries', 'Supplier', 2, '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:38:43.000000Z\",\"deleted_at\":null}', '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:44:11.000000Z\",\"deleted_at\":null}', 'purchase/suppliers/2/status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:44:11', '2026-08-16 11:44:11'),
(186, 1, 1, 1, 'Suppliers', 'Enabled', 'Enabled supplier: Nigerian Breweries', 'Supplier', 2, '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:44:11.000000Z\",\"deleted_at\":null}', '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:44:16.000000Z\",\"deleted_at\":null}', 'purchase/suppliers/2/status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:44:16', '2026-08-16 11:44:16'),
(187, 1, 1, 1, 'Suppliers', 'Deleted', 'Deleted supplier: Nigerian Breweries', 'Supplier', 2, '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:44:16.000000Z\",\"deleted_at\":null}', NULL, 'purchase/suppliers/2', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:44:19', '2026-08-16 11:44:19'),
(188, 1, 1, 1, 'Suppliers', 'Restored', 'Restored supplier: Nigerian Breweries', 'Supplier', 2, '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerian Breweries, Off Alakia Road, Ibadan.\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:44:19.000000Z\",\"deleted_at\":\"2026-08-16T12:44:19.000000Z\"}', '{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerial Breweries, Off Alakia Road, Ibadan\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:45:37.000000Z\",\"deleted_at\":null}', 'purchase/suppliers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 11:45:37', '2026-08-16 11:45:37'),
(189, 1, 1, 1, 'purchases', 'create', 'Created purchase order: PO-202608-00001', 'PurchaseOrder', 1, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00001\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-28T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"2450000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"2450000.00\",\"notes\":null,\"created_by\":1,\"updated_at\":\"2026-08-16T15:16:43.000000Z\",\"created_at\":\"2026-08-16T15:16:43.000000Z\",\"id\":1}', 'purchase/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 14:16:43', '2026-08-16 14:16:43'),
(190, 1, 1, 1, 'purchases', 'update', 'Updated purchase order: PO-202608-00001', 'PurchaseOrder', 1, '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00001\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-28T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"2450000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"2450000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-16T15:16:43.000000Z\",\"updated_at\":\"2026-08-16T15:16:43.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":1,\"purchase_order_id\":1,\"product_id\":6,\"quantity\":\"1000.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1450000.00\",\"created_at\":\"2026-08-16T15:16:43.000000Z\",\"updated_at\":\"2026-08-16T15:16:43.000000Z\"},{\"id\":2,\"purchase_order_id\":1,\"product_id\":19,\"quantity\":\"1000.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-16T15:16:43.000000Z\",\"updated_at\":\"2026-08-16T15:16:43.000000Z\"}]}', '{\"id\":1,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00001\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-28T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"3450000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"3450000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-16T15:16:43.000000Z\",\"updated_at\":\"2026-08-17T11:41:31.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":3,\"purchase_order_id\":1,\"product_id\":6,\"quantity\":\"1000.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1450000.00\",\"created_at\":\"2026-08-17T11:41:31.000000Z\",\"updated_at\":\"2026-08-17T11:41:31.000000Z\"},{\"id\":4,\"purchase_order_id\":1,\"product_id\":19,\"quantity\":\"1000.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T11:41:31.000000Z\",\"updated_at\":\"2026-08-17T11:41:31.000000Z\"},{\"id\":5,\"purchase_order_id\":1,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T11:41:31.000000Z\",\"updated_at\":\"2026-08-17T11:41:31.000000Z\"}]}', 'purchase/orders/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-17 10:41:31', '2026-08-17 10:41:31'),
(191, 1, 1, 1, 'purchases', 'create', 'Created purchase order: PO-202608-00002', 'PurchaseOrder', 3, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":null,\"created_by\":1,\"updated_at\":\"2026-08-17T13:06:44.000000Z\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"id\":3}', 'purchase/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-17 12:06:44', '2026-08-17 12:06:44'),
(192, 1, 1, 1, 'purchases', 'update', 'Updated purchase order: PO-202608-00002', 'PurchaseOrder', 3, '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":6,\"purchase_order_id\":3,\"product_id\":1,\"quantity\":\"1000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"500000.00\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\"},{\"id\":7,\"purchase_order_id\":3,\"product_id\":6,\"quantity\":\"1500.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2175000.00\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\"},{\"id\":8,\"purchase_order_id\":3,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\"},{\"id\":9,\"purchase_order_id\":3,\"product_id\":19,\"quantity\":\"1500.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1500000.00\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\"},{\"id\":10,\"purchase_order_id\":3,\"product_id\":10,\"quantity\":\"1000.00\",\"unit_cost\":\"7800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"7800000.00\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:06:44.000000Z\"}]}', '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":\"5 products - 12,975,000\",\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":11,\"purchase_order_id\":3,\"product_id\":1,\"quantity\":\"1000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":12,\"purchase_order_id\":3,\"product_id\":6,\"quantity\":\"1500.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2175000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":13,\"purchase_order_id\":3,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":14,\"purchase_order_id\":3,\"product_id\":19,\"quantity\":\"1500.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":15,\"purchase_order_id\":3,\"product_id\":10,\"quantity\":\"1000.00\",\"unit_cost\":\"7800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"7800000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"}]}', 'purchase/orders/3', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(193, 1, 1, 1, 'purchases', 'submit', 'Submitted purchase order for approval: PO-202608-00002', 'PurchaseOrder', 3, '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":\"5 products - 12,975,000\",\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":11,\"purchase_order_id\":3,\"product_id\":1,\"quantity\":\"1000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":12,\"purchase_order_id\":3,\"product_id\":6,\"quantity\":\"1500.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2175000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":13,\"purchase_order_id\":3,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":14,\"purchase_order_id\":3,\"product_id\":19,\"quantity\":\"1500.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":15,\"purchase_order_id\":3,\"product_id\":10,\"quantity\":\"1000.00\",\"unit_cost\":\"7800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"7800000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"}],\"supplier\":{\"id\":1,\"company_id\":1,\"supplier_code\":\"SUP-00001\",\"name\":\"Friezland Group of Companies\",\"contact_person\":\"Mr Adeleke Abayomi\",\"email\":\"info@friezland.com\",\"phone\":\"07032109983\",\"alternate_phone\":\"07032109983\",\"address\":\"17, Ojokoro avenue, abeokuta, Ogun State.\",\"city\":\"Abeokuta\",\"state\":\"Ogun\",\"country\":\"Nigeria\",\"tax_number\":\"29839393\",\"payment_terms\":\"30 days\",\"credit_limit\":\"1000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Friezland.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:27:31.000000Z\",\"updated_at\":\"2026-08-16T12:27:31.000000Z\",\"deleted_at\":null},\"branch\":{\"id\":1,\"company_id\":1,\"branch_code\":\"BR001\",\"name\":\"Head Office\",\"phone\":\"08012345678\",\"email\":\"headoffice@emmanexitconsult.com\",\"address\":\"Lagos, Nigeria\",\"is_head_office\":true,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null}}', '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Pending\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":\"5 products - 12,975,000\",\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T14:47:32.000000Z\",\"deleted_at\":null}', 'purchase/orders/3/submit', 'PATCH', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-17 13:47:32', '2026-08-17 13:47:32'),
(194, 1, 1, 1, 'purchases', 'approve', 'Approved purchase order: PO-202608-00002', 'PurchaseOrder', 3, '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Pending\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":\"5 products - 12,975,000\",\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T14:47:32.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":11,\"purchase_order_id\":3,\"product_id\":1,\"quantity\":\"1000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":12,\"purchase_order_id\":3,\"product_id\":6,\"quantity\":\"1500.00\",\"unit_cost\":\"1450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2175000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":13,\"purchase_order_id\":3,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":14,\"purchase_order_id\":3,\"product_id\":19,\"quantity\":\"1500.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1500000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"},{\"id\":15,\"purchase_order_id\":3,\"product_id\":10,\"quantity\":\"1000.00\",\"unit_cost\":\"7800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"7800000.00\",\"created_at\":\"2026-08-17T13:07:24.000000Z\",\"updated_at\":\"2026-08-17T13:07:24.000000Z\"}],\"supplier\":{\"id\":1,\"company_id\":1,\"supplier_code\":\"SUP-00001\",\"name\":\"Friezland Group of Companies\",\"contact_person\":\"Mr Adeleke Abayomi\",\"email\":\"info@friezland.com\",\"phone\":\"07032109983\",\"alternate_phone\":\"07032109983\",\"address\":\"17, Ojokoro avenue, abeokuta, Ogun State.\",\"city\":\"Abeokuta\",\"state\":\"Ogun\",\"country\":\"Nigeria\",\"tax_number\":\"29839393\",\"payment_terms\":\"30 days\",\"credit_limit\":\"1000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Friezland.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:27:31.000000Z\",\"updated_at\":\"2026-08-16T12:27:31.000000Z\",\"deleted_at\":null},\"branch\":{\"id\":1,\"company_id\":1,\"branch_code\":\"BR001\",\"name\":\"Head Office\",\"phone\":\"08012345678\",\"email\":\"headoffice@emmanexitconsult.com\",\"address\":\"Lagos, Nigeria\",\"is_head_office\":true,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null}}', '{\"id\":3,\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"order_number\":\"PO-202608-00002\",\"order_date\":\"2026-08-17T00:00:00.000000Z\",\"expected_date\":\"2026-08-31T00:00:00.000000Z\",\"status\":\"Approved\",\"subtotal\":\"12975000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"12975000.00\",\"notes\":\"5 products - 12,975,000\",\"created_by\":1,\"approved_by\":1,\"approved_at\":\"2026-08-17T15:12:56.000000Z\",\"created_at\":\"2026-08-17T13:06:44.000000Z\",\"updated_at\":\"2026-08-17T15:12:56.000000Z\",\"deleted_at\":null}', 'purchase/orders/3/approve', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-17 14:12:56', '2026-08-17 14:12:56'),
(195, 1, 1, 1, 'purchases', 'create', 'Created purchase order: PO-202608-00003', 'PurchaseOrder', 4, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":2,\"order_number\":\"PO-202608-00003\",\"order_date\":\"2026-08-18T00:00:00.000000Z\",\"expected_date\":\"2026-09-01T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"1000000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"1000000.00\",\"notes\":null,\"created_by\":1,\"updated_at\":\"2026-08-18T12:55:29.000000Z\",\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"id\":4}', 'purchase/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-18 11:55:29', '2026-08-18 11:55:29'),
(196, 1, 1, 1, 'purchases', 'submit', 'Submitted purchase order for approval: PO-202608-00003', 'PurchaseOrder', 4, '{\"id\":4,\"company_id\":1,\"branch_id\":1,\"supplier_id\":2,\"order_number\":\"PO-202608-00003\",\"order_date\":\"2026-08-18T00:00:00.000000Z\",\"expected_date\":\"2026-09-01T00:00:00.000000Z\",\"status\":\"Draft\",\"subtotal\":\"1000000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"1000000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"updated_at\":\"2026-08-18T12:55:29.000000Z\",\"deleted_at\":null,\"items\":[{\"id\":16,\"purchase_order_id\":4,\"product_id\":2,\"quantity\":\"2000.00\",\"unit_cost\":\"500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1000000.00\",\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"updated_at\":\"2026-08-18T12:55:29.000000Z\"}],\"supplier\":{\"id\":2,\"company_id\":1,\"supplier_code\":\"SUP-00002\",\"name\":\"Nigerian Breweries\",\"contact_person\":\"Mrs Afonja Omowunmi\",\"email\":\"info@nigbreweries.com\",\"phone\":\"08034271855\",\"alternate_phone\":\"08034271855\",\"address\":\"Nigerial Breweries, Off Alakia Road, Ibadan\",\"city\":\"Ibadan\",\"state\":\"Oyo\",\"country\":\"Nigeria\",\"tax_number\":\"09030922\",\"payment_terms\":\"30 days\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"notes\":\"Nigerian Breweries.\",\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T12:35:20.000000Z\",\"updated_at\":\"2026-08-16T12:45:37.000000Z\",\"deleted_at\":null},\"branch\":{\"id\":1,\"company_id\":1,\"branch_code\":\"BR001\",\"name\":\"Head Office\",\"phone\":\"08012345678\",\"email\":\"headoffice@emmanexitconsult.com\",\"address\":\"Lagos, Nigeria\",\"is_head_office\":true,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null}}', '{\"id\":4,\"company_id\":1,\"branch_id\":1,\"supplier_id\":2,\"order_number\":\"PO-202608-00003\",\"order_date\":\"2026-08-18T00:00:00.000000Z\",\"expected_date\":\"2026-09-01T00:00:00.000000Z\",\"status\":\"Pending\",\"subtotal\":\"1000000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"1000000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"updated_at\":\"2026-08-18T12:55:37.000000Z\",\"deleted_at\":null}', 'purchase/orders/4/submit', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-18 11:55:37', '2026-08-18 11:55:37'),
(197, 1, 1, 1, 'purchases', 'cancel', 'Cancelled purchase order: PO-202608-00003', 'PurchaseOrder', 4, '{\"id\":4,\"company_id\":1,\"branch_id\":1,\"supplier_id\":2,\"order_number\":\"PO-202608-00003\",\"order_date\":\"2026-08-18T00:00:00.000000Z\",\"expected_date\":\"2026-09-01T00:00:00.000000Z\",\"status\":\"Pending\",\"subtotal\":\"1000000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"1000000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"updated_at\":\"2026-08-18T12:55:37.000000Z\",\"deleted_at\":null}', '{\"id\":4,\"company_id\":1,\"branch_id\":1,\"supplier_id\":2,\"order_number\":\"PO-202608-00003\",\"order_date\":\"2026-08-18T00:00:00.000000Z\",\"expected_date\":\"2026-09-01T00:00:00.000000Z\",\"status\":\"cancelled\",\"subtotal\":\"1000000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"shipping\":\"0.00\",\"total\":\"1000000.00\",\"notes\":null,\"created_by\":1,\"approved_by\":null,\"approved_at\":null,\"created_at\":\"2026-08-18T12:55:29.000000Z\",\"updated_at\":\"2026-08-18T12:55:43.000000Z\",\"deleted_at\":null}', 'purchase/orders/4/cancel', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-18 11:55:43', '2026-08-18 11:55:43'),
(198, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000001', 'GoodsReceived', 2, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000001\",\"received_date\":\"2026-08-28T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-21T13:02:33.000000Z\",\"created_at\":\"2026-08-21T13:02:33.000000Z\",\"id\":2}', 'purchase/received', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-21 12:02:33', '2026-08-21 12:02:33'),
(199, 1, 1, 1, 'Products', 'Updated', 'Updated product: Coca-Cola 50cl', 'Product', 1, '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-23T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T09:53:46.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 08:53:46', '2026-08-22 08:53:46'),
(200, 1, 1, 1, 'Users', 'Disabled', 'Disabled user Maxwell Akinkunmi Akinyooye', 'User', 17, '{\"status\":true}', '{\"id\":17,\"company_id\":1,\"branch_id\":2,\"role_id\":3,\"employee_no\":\"MG-2026-001\",\"first_name\":\"Maxwell\",\"other_name\":\"Akinkunmi\",\"last_name\":\"Akinyooye\",\"username\":\"maxwell\",\"email\":\"maxwell@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"08034271855\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"2017-09-27T00:00:00.000000Z\",\"employment_date\":\"2026-08-03T00:00:00.000000Z\",\"address\":\"Ibadan\",\"notes\":\"Branch manager of lekki branch.\",\"status\":false,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-08-09T08:43:51.000000Z\",\"updated_at\":\"2026-08-22T11:10:51.000000Z\",\"deleted_at\":null}', 'users/17/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 10:10:51', '2026-08-22 10:10:51'),
(201, 1, 1, 1, 'Users', 'Enabled', 'Enabled user Maxwell Akinkunmi Akinyooye', 'User', 17, '{\"status\":false}', '{\"id\":17,\"company_id\":1,\"branch_id\":2,\"role_id\":3,\"employee_no\":\"MG-2026-001\",\"first_name\":\"Maxwell\",\"other_name\":\"Akinkunmi\",\"last_name\":\"Akinyooye\",\"username\":\"maxwell\",\"email\":\"maxwell@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"08034271855\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"2017-09-27T00:00:00.000000Z\",\"employment_date\":\"2026-08-03T00:00:00.000000Z\",\"address\":\"Ibadan\",\"notes\":\"Branch manager of lekki branch.\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-08-09T08:43:51.000000Z\",\"updated_at\":\"2026-08-22T11:10:57.000000Z\",\"deleted_at\":null}', 'users/17/toggle-status', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 10:10:57', '2026-08-22 10:10:57');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(202, 1, 1, 1, 'Products', 'Updated', 'Updated product: Coca-Cola 50cl', 'Product', 1, '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-23T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T09:53:46.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-23T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T09:53:46.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 10:47:55', '2026-08-22 10:47:55'),
(203, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000002', 'GoodsReceived', 3, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000002\",\"received_date\":\"2026-08-22T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-22T12:11:37.000000Z\",\"created_at\":\"2026-08-22T12:11:37.000000Z\",\"id\":3}', 'purchase/received', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(204, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:40:40', '2026-08-22 12:40:40'),
(205, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:41:30', '2026-08-22 12:41:30'),
(206, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:42:25', '2026-08-22 12:42:25'),
(207, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:40:40.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:45:09.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:45:09', '2026-08-22 12:45:09'),
(208, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:45:09.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:45:09.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:45:41', '2026-08-22 12:45:41'),
(209, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:45:09.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:47:56.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:47:56', '2026-08-22 12:47:56'),
(210, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:47:56.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1595.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:50:47.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:50:47', '2026-08-22 12:50:47'),
(211, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000003', 'GoodsReceived', 4, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000003\",\"received_date\":\"2026-08-23T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-22T13:51:24.000000Z\",\"created_at\":\"2026-08-22T13:51:24.000000Z\",\"id\":4}', 'purchase/received', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:51:24', '2026-08-22 12:51:24'),
(212, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Fanta 50cl', 'Product', 2, '{\"id\":2,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000002\",\"barcode\":\"100000000002\",\"sku\":\"FANTA50CL\",\"qr_code\":null,\"name\":\"Fanta 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Fanta\",\"manufacturer\":\"NBC\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":2,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000002\",\"barcode\":\"100000000002\",\"sku\":\"FANTA50CL\",\"qr_code\":null,\"name\":\"Fanta 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Fanta\",\"manufacturer\":\"NBC\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2100.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:55:45.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/2/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 12:55:45', '2026-08-22 12:55:45'),
(213, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000004', 'GoodsReceived', 5, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000004\",\"received_date\":\"2026-08-22T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-22T14:03:30.000000Z\",\"created_at\":\"2026-08-22T14:03:30.000000Z\",\"id\":5}', 'purchase/received', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 13:03:30', '2026-08-22 13:03:30'),
(214, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Three Crown Evaporated Milk', 'Product', 19, '{\"id\":19,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000011\",\"barcode\":\"TH123456\",\"sku\":null,\"qr_code\":null,\"name\":\"Three Crown Evaporated Milk\",\"description\":\"Three Crown Evaporated Milk\",\"image\":\"1786301525_6a78cc5535908.png\",\"cost_price\":\"1000.00\",\"selling_price\":\"1200.00\",\"discount_id\":null,\"unit_id\":5,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"expiry_date\":\"2027-11-25T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"100.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-09T18:52:05.000000Z\",\"updated_at\":\"2026-08-09T18:52:05.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":19,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000011\",\"barcode\":\"TH123456\",\"sku\":null,\"qr_code\":null,\"name\":\"Three Crown Evaporated Milk\",\"description\":\"Three Crown Evaporated Milk\",\"image\":\"1786301525_6a78cc5535908.png\",\"cost_price\":\"1000.00\",\"selling_price\":\"1200.00\",\"discount_id\":null,\"unit_id\":5,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"expiry_date\":\"2027-11-25T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"100.00\",\"maximum_stock\":\"1635.00\",\"weight\":null,\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-08-09T18:52:05.000000Z\",\"updated_at\":\"2026-08-22T14:10:17.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/19/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 13:10:17', '2026-08-22 13:10:17'),
(215, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000005', 'GoodsReceived', 6, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000005\",\"received_date\":\"2026-08-22T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-22T14:14:09.000000Z\",\"created_at\":\"2026-08-22T14:14:09.000000Z\",\"id\":6}', 'purchase/received', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 13:14:09', '2026-08-22 13:14:09'),
(216, 1, 1, 1, 'Products', 'Updated', 'Updated maximum stock for product: Pampers Size 3', 'Product', 10, '{\"id\":10,\"company_id\":1,\"product_category_id\":9,\"product_code\":\"PRD000010\",\"barcode\":\"100000000010\",\"sku\":\"PAMP001\",\"qr_code\":null,\"name\":\"Pampers Size 3\",\"description\":null,\"image\":null,\"cost_price\":\"7800.00\",\"selling_price\":\"8600.00\",\"discount_id\":1,\"unit_id\":2,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Pampers\",\"manufacturer\":\"P&G\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":10,\"company_id\":1,\"product_category_id\":9,\"product_code\":\"PRD000010\",\"barcode\":\"100000000010\",\"sku\":\"PAMP001\",\"qr_code\":null,\"name\":\"Pampers Size 3\",\"description\":null,\"image\":null,\"cost_price\":\"7800.00\",\"selling_price\":\"8600.00\",\"discount_id\":1,\"unit_id\":2,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Pampers\",\"manufacturer\":\"P&G\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1085.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T14:16:04.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/10/maximum-stock', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 13:16:04', '2026-08-22 13:16:04'),
(217, 1, 1, 1, 'purchases', 'create', 'Created goods received: GR-000006', 'GoodsReceived', 7, NULL, '{\"company_id\":1,\"branch_id\":1,\"purchase_order_id\":3,\"supplier_id\":1,\"receipt_number\":\"GR-000006\",\"received_date\":\"2026-08-22T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"received_by\":1,\"updated_at\":\"2026-08-22T14:16:15.000000Z\",\"created_at\":\"2026-08-22T14:16:15.000000Z\",\"id\":7}', 'purchase/received', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-22 13:16:15', '2026-08-22 13:16:15'),
(218, 1, 1, 1, 'purchases', 'create', 'Created purchase return: PRN-000001', 'PurchaseReturn', 5, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"purchase_order_id\":3,\"return_number\":\"PRN-000001\",\"return_date\":\"2026-08-26T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"created_by\":1,\"updated_at\":\"2026-08-26T11:23:49.000000Z\",\"created_at\":\"2026-08-26T11:23:49.000000Z\",\"id\":5}', 'purchase/returns', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-26 10:23:50', '2026-08-26 10:23:50'),
(219, 1, 1, 1, 'purchases', 'create', 'Created purchase return: PRN-000002', 'PurchaseReturn', 6, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"purchase_order_id\":3,\"return_number\":\"PRN-000002\",\"return_date\":\"2026-08-26T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"created_by\":1,\"updated_at\":\"2026-08-26T12:35:10.000000Z\",\"created_at\":\"2026-08-26T12:35:10.000000Z\",\"id\":6}', 'purchase/returns', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-26 11:35:10', '2026-08-26 11:35:10'),
(220, 1, 1, 1, 'purchases', 'create', 'Created purchase return: PRN-000003', 'PurchaseReturn', 7, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"purchase_order_id\":3,\"return_number\":\"PRN-000003\",\"return_date\":\"2026-08-26T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":null,\"created_by\":1,\"reason\":\"Damage\",\"updated_at\":\"2026-08-26T13:05:19.000000Z\",\"created_at\":\"2026-08-26T13:05:19.000000Z\",\"id\":7}', 'purchase/returns', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-26 12:05:19', '2026-08-26 12:05:19'),
(221, 1, 1, 1, 'purchases', 'create', 'Created purchase return: PRN-000004', 'PurchaseReturn', 8, NULL, '{\"company_id\":1,\"branch_id\":1,\"supplier_id\":1,\"purchase_order_id\":3,\"return_number\":\"PRN-000004\",\"return_date\":\"2026-08-27T00:00:00.000000Z\",\"status\":\"Completed\",\"notes\":\"50 items returned each for Pampers and Fanta 50cl\",\"created_by\":1,\"reason\":\"Expired\",\"updated_at\":\"2026-08-27T10:44:50.000000Z\",\"created_at\":\"2026-08-27T10:44:50.000000Z\",\"id\":8}', 'purchase/returns', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 09:44:50', '2026-08-27 09:44:50'),
(222, 1, 1, 1, 'customers', 'create', 'Created customer: Miracle Peter', 'Customer', 10, NULL, '{\"company_id\":1,\"customer_group_id\":6,\"customer_code\":\"CUS-00010\",\"first_name\":\"Miracle\",\"last_name\":\"Peter\",\"email\":\"miracle.kingsbranding@gmail.com\",\"phone\":\"08104786432\",\"address\":\"Ibadan\",\"credit_limit\":\"2000000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Corporate\",\"loyalty_points\":0,\"status\":true,\"created_by\":1,\"updated_at\":\"2026-08-27T14:04:26.000000Z\",\"created_at\":\"2026-08-27T14:04:26.000000Z\",\"id\":10}', 'sales/orders/customers', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 13:04:26', '2026-08-27 13:04:26'),
(223, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000001', 'Order', 4, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":10,\"cashier_id\":1,\"order_no\":\"ORD-000001\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T14:18:09.000000Z\",\"created_at\":\"2026-08-27T14:18:09.000000Z\",\"id\":4}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 13:18:09', '2026-08-27 13:18:09'),
(224, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000002', 'Order', 5, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":10,\"cashier_id\":1,\"order_no\":\"ORD-000002\",\"subtotal\":\"3100.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"3100.00\",\"amount_paid\":\"0.00\",\"balance\":\"3100.00\",\"total_items\":2,\"total_quantity\":\"3.00\",\"change_given\":\"0.00\",\"grand_total\":\"3100.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T22:34:16.000000Z\",\"created_at\":\"2026-08-27T22:34:16.000000Z\",\"id\":5}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 21:34:16', '2026-08-27 21:34:16'),
(225, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000003', 'Order', 6, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000003\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"0.00\",\"balance\":\"90000.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"90000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:34:37.000000Z\",\"created_at\":\"2026-08-27T23:34:37.000000Z\",\"id\":6}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:34:37', '2026-08-27 22:34:37'),
(226, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000004', 'Order', 7, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000004\",\"subtotal\":\"180000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"180000.00\",\"amount_paid\":\"0.00\",\"balance\":\"180000.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"180000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:41:53.000000Z\",\"created_at\":\"2026-08-27T23:41:53.000000Z\",\"id\":7}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:41:53', '2026-08-27 22:41:53'),
(227, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000005', 'Order', 8, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000005\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"0.00\",\"balance\":\"90000.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"90000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:43:09.000000Z\",\"created_at\":\"2026-08-27T23:43:09.000000Z\",\"id\":8}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:43:09', '2026-08-27 22:43:09'),
(228, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000006', 'Order', 9, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000006\",\"subtotal\":\"180000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"180000.00\",\"amount_paid\":\"0.00\",\"balance\":\"180000.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"180000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:43:28.000000Z\",\"created_at\":\"2026-08-27T23:43:28.000000Z\",\"id\":9}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:43:28', '2026-08-27 22:43:28'),
(229, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000007', 'Order', 10, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000007\",\"subtotal\":\"180000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"180000.00\",\"amount_paid\":\"0.00\",\"balance\":\"180000.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"180000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:47:25.000000Z\",\"created_at\":\"2026-08-27T23:47:25.000000Z\",\"id\":10}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:47:25', '2026-08-27 22:47:25'),
(230, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000008', 'Order', 11, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000008\",\"subtotal\":\"180000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"180000.00\",\"amount_paid\":\"0.00\",\"balance\":\"180000.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"180000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:49:13.000000Z\",\"created_at\":\"2026-08-27T23:49:13.000000Z\",\"id\":11}', 'sales/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:49:13', '2026-08-27 22:49:13'),
(231, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000009', 'Order', 12, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000009\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:52:00.000000Z\",\"created_at\":\"2026-08-27T23:52:00.000000Z\",\"id\":12}', 'sales/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:52:00', '2026-08-27 22:52:00'),
(232, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000010', 'Order', 13, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000010\",\"subtotal\":\"2400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"2400.00\",\"amount_paid\":\"0.00\",\"balance\":\"2400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"2400.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:52:27.000000Z\",\"created_at\":\"2026-08-27T23:52:27.000000Z\",\"id\":13}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:52:27', '2026-08-27 22:52:27'),
(233, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000011', 'Order', 14, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000011\",\"subtotal\":\"2400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"2400.00\",\"amount_paid\":\"0.00\",\"balance\":\"2400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"2400.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-27T23:55:34.000000Z\",\"created_at\":\"2026-08-27T23:55:34.000000Z\",\"id\":14}', 'sales/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 22:55:34', '2026-08-27 22:55:34'),
(234, 1, 1, 1, 'orders', 'update', 'Updated sales order: ORD-000009', 'Order', 12, NULL, '{\"id\":12,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000009\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"2400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"2400.00\",\"amount_paid\":\"0.00\",\"balance\":\"2400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"2400.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-27T23:52:00.000000Z\",\"updated_at\":\"2026-08-28T00:03:26.000000Z\",\"deleted_at\":null}', 'sales/orders/12', 'PUT', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:03:26', '2026-08-27 23:03:26'),
(235, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000012', 'Order', 15, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000012\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"0.00\",\"balance\":\"90000.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"90000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T00:03:59.000000Z\",\"created_at\":\"2026-08-28T00:03:59.000000Z\",\"id\":15}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:03:59', '2026-08-27 23:03:59'),
(236, 1, 1, 1, 'orders', 'update', 'Updated sales order: ORD-000012', 'Order', 15, NULL, '{\"id\":15,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000012\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"91200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"91200.00\",\"amount_paid\":\"0.00\",\"balance\":\"91200.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"91200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T00:03:59.000000Z\",\"updated_at\":\"2026-08-28T00:04:16.000000Z\",\"deleted_at\":null}', 'sales/orders/15', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:04:16', '2026-08-27 23:04:16'),
(237, 1, 1, 1, 'sales_orders', 'delete', 'Deleted sales order: ORD-000012', 'Order', 15, '{\"id\":15,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000012\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"91200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"91200.00\",\"amount_paid\":\"0.00\",\"balance\":\"91200.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"91200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T00:03:59.000000Z\",\"updated_at\":\"2026-08-28T00:04:16.000000Z\",\"deleted_at\":null}', NULL, 'sales/orders/15', 'DELETE', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:17:11', '2026-08-27 23:17:11'),
(238, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000013', 'Order', 16, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000013\",\"subtotal\":\"183300.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"183300.00\",\"amount_paid\":\"0.00\",\"balance\":\"183300.00\",\"total_items\":2,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"183300.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T00:20:42.000000Z\",\"created_at\":\"2026-08-28T00:20:42.000000Z\",\"id\":16}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:20:42', '2026-08-27 23:20:42'),
(239, 1, 1, 1, 'sales_orders', 'Completed', 'Completed sales order: ORD-000013', 'Order', 16, '{\"id\":16,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000013\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"183300.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"183300.00\",\"amount_paid\":\"0.00\",\"balance\":\"183300.00\",\"total_items\":2,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"183300.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-28T00:20:42.000000Z\",\"updated_at\":\"2026-08-28T00:20:42.000000Z\",\"deleted_at\":null}', '{\"id\":16,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000013\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"183300.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"183300.00\",\"amount_paid\":\"184000.00\",\"balance\":\"0.00\",\"total_items\":2,\"total_quantity\":\"4.00\",\"change_given\":\"700.00\",\"grand_total\":\"183300.00\",\"completed_at\":\"2026-08-28T00:51:21.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T00:20:42.000000Z\",\"updated_at\":\"2026-08-28T00:51:21.000000Z\",\"deleted_at\":null}', 'sales/orders/16/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-27 23:51:21', '2026-08-27 23:51:21'),
(240, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000014', 'Order', 17, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000014\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"0.00\",\"balance\":\"90000.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"90000.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T08:37:23.000000Z\",\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"id\":17}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 07:37:23', '2026-08-28 07:37:23'),
(241, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000001', 'Invoice', 1, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":null,\"order_id\":17,\"invoice_no\":\"INV-000001\",\"invoice_date\":\"2026-08-28T00:00:00.000000Z\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"0.00\",\"balance\":\"90000.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"grand_total\":\"90000.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T08:37:23.000000Z\",\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"id\":1}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 07:37:23', '2026-08-28 07:37:23'),
(242, 1, 1, 1, 'orders', 'update', 'Updated sales order: ORD-000014', 'Order', 17, NULL, '{\"id\":17,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000014\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"91650.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"91650.00\",\"amount_paid\":\"0.00\",\"balance\":\"91650.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"91650.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"updated_at\":\"2026-08-28T08:39:36.000000Z\",\"deleted_at\":null}', 'sales/orders/17', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 07:39:36', '2026-08-28 07:39:36'),
(243, 1, 1, 1, 'invoices', 'update', 'Updated invoice: INV-000001', 'Invoice', 1, NULL, '{\"id\":1,\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"order_id\":17,\"customer_id\":null,\"invoice_no\":\"INV-000001\",\"invoice_date\":\"2026-08-28T00:00:00.000000Z\",\"subtotal\":\"91650.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"91650.00\",\"amount_paid\":\"0.00\",\"balance\":\"91650.00\",\"total_quantity\":\"2.00\",\"total_items\":2,\"grand_total\":\"91650.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"updated_at\":\"2026-08-28T08:39:36.000000Z\",\"deleted_at\":null}', 'sales/orders/17', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 07:39:36', '2026-08-28 07:39:36');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(244, 1, 1, 1, 'sales_orders', 'Completed', 'Completed sales order: ORD-000014', 'Order', 17, '{\"id\":17,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000014\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"91650.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"91650.00\",\"amount_paid\":\"0.00\",\"balance\":\"91650.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"91650.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"updated_at\":\"2026-08-28T08:39:36.000000Z\",\"deleted_at\":null}', '{\"id\":17,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000014\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"91650.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"91650.00\",\"amount_paid\":\"92000.00\",\"balance\":\"0.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"change_given\":\"350.00\",\"grand_total\":\"91650.00\",\"completed_at\":\"2026-08-28T10:20:27.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T08:37:23.000000Z\",\"updated_at\":\"2026-08-28T10:20:27.000000Z\",\"deleted_at\":null}', 'sales/orders/17/complete', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 09:20:27', '2026-08-28 09:20:27'),
(245, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000015', 'Order', 18, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":1,\"customer_id\":6,\"cashier_id\":1,\"order_no\":\"ORD-000015\",\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"0.00\",\"balance\":\"983500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T10:23:30.000000Z\",\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"id\":18}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(246, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000002', 'Invoice', 2, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":1,\"customer_id\":6,\"order_id\":18,\"invoice_no\":\"INV-000002\",\"invoice_date\":\"2026-08-28T00:00:00.000000Z\",\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"0.00\",\"balance\":\"983500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"grand_total\":\"983500.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T10:23:30.000000Z\",\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"id\":2}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(247, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000015', 'Order', 18, '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"0.00\",\"balance\":\"983500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T10:23:30.000000Z\",\"deleted_at\":null}', '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"150000.00\",\"balance\":\"833500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T10:47:04.000000Z\",\"deleted_at\":null}', 'sales/orders/18/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 09:47:04', '2026-08-28 09:47:04'),
(248, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000015', 'Order', 18, '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"150000.00\",\"balance\":\"833500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T10:47:04.000000Z\",\"deleted_at\":null}', '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"250000.00\",\"balance\":\"733500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T10:51:43.000000Z\",\"deleted_at\":null}', 'sales/orders/18/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 09:51:43', '2026-08-28 09:51:43'),
(249, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000015', 'Order', 18, '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"250000.00\",\"balance\":\"733500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T10:51:43.000000Z\",\"deleted_at\":null}', '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"450000.00\",\"balance\":\"533500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T11:06:21.000000Z\",\"deleted_at\":null}', 'sales/orders/18/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 10:06:21', '2026-08-28 10:06:21'),
(250, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000015', 'Order', 18, '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"450000.00\",\"balance\":\"533500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T11:06:21.000000Z\",\"deleted_at\":null}', '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"950000.00\",\"balance\":\"33500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T11:07:01.000000Z\",\"deleted_at\":null}', 'sales/orders/18/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 10:07:01', '2026-08-28 10:07:01'),
(251, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000016', 'Order', 19, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":10,\"cashier_id\":1,\"order_no\":\"ORD-000016\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T11:08:09.000000Z\",\"created_at\":\"2026-08-28T11:08:09.000000Z\",\"id\":19}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 10:08:09', '2026-08-28 10:08:09'),
(252, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000003', 'Invoice', 3, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":10,\"order_id\":19,\"invoice_no\":\"INV-000003\",\"invoice_date\":\"2026-08-28T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"grand_total\":\"1200.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-28T11:08:09.000000Z\",\"created_at\":\"2026-08-28T11:08:09.000000Z\",\"id\":3}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 10:08:09', '2026-08-28 10:08:09'),
(253, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000015', 'Order', 18, '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"950000.00\",\"balance\":\"33500.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T11:07:01.000000Z\",\"deleted_at\":null}', '{\"id\":18,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000015\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"983500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"983500.00\",\"amount_paid\":\"983500.00\",\"balance\":\"0.00\",\"total_items\":4,\"total_quantity\":\"45.00\",\"change_given\":\"0.00\",\"grand_total\":\"983500.00\",\"completed_at\":\"2026-08-28T11:11:22.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":\"Items totalled to 983,500, with no discount or tax\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-28T10:23:30.000000Z\",\"updated_at\":\"2026-08-28T11:11:22.000000Z\",\"deleted_at\":null}', 'sales/orders/18/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(254, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000017', 'Order', 20, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":2,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000017\",\"subtotal\":\"522000.00\",\"discount\":\"2.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"521998.00\",\"amount_paid\":\"0.00\",\"balance\":\"521998.00\",\"total_items\":3,\"total_quantity\":\"65.00\",\"change_given\":\"0.00\",\"grand_total\":\"521998.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-29T13:02:14.000000Z\",\"created_at\":\"2026-08-29T13:02:14.000000Z\",\"id\":20}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(255, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000004', 'Invoice', 4, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":2,\"customer_id\":9,\"order_id\":20,\"invoice_no\":\"INV-000004\",\"invoice_date\":\"2026-08-29T00:00:00.000000Z\",\"subtotal\":\"522000.00\",\"discount\":\"2.00\",\"tax\":\"0.00\",\"total\":\"521998.00\",\"amount_paid\":\"0.00\",\"balance\":\"521998.00\",\"total_items\":3,\"total_quantity\":\"65.00\",\"grand_total\":\"521998.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-08-29T13:02:14.000000Z\",\"created_at\":\"2026-08-29T13:02:14.000000Z\",\"id\":4}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(256, 1, 1, 1, 'sales_orders', 'Payment', 'Recorded payment for sales order: ORD-000017', 'Order', 20, '{\"id\":20,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000017\",\"customer_id\":9,\"cashier_id\":1,\"subtotal\":\"522000.00\",\"discount\":\"2.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"521998.00\",\"amount_paid\":\"0.00\",\"balance\":\"521998.00\",\"total_items\":3,\"total_quantity\":\"65.00\",\"change_given\":\"0.00\",\"grand_total\":\"521998.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":2,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-08-29T13:02:14.000000Z\",\"updated_at\":\"2026-08-29T13:02:14.000000Z\",\"deleted_at\":null}', '{\"id\":20,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000017\",\"customer_id\":9,\"cashier_id\":1,\"subtotal\":\"522000.00\",\"discount\":\"2.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"521998.00\",\"amount_paid\":\"150000.00\",\"balance\":\"371998.00\",\"total_items\":3,\"total_quantity\":\"65.00\",\"change_given\":\"0.00\",\"grand_total\":\"521998.00\",\"completed_at\":null,\"payment_status\":\"Partial\",\"order_status\":\"Held\",\"sales_channel\":\"POS\",\"terminal_id\":2,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-29T13:02:14.000000Z\",\"updated_at\":\"2026-08-29T13:02:39.000000Z\",\"deleted_at\":null}', 'sales/orders/20/part-payment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-29 12:02:39', '2026-08-29 12:02:39'),
(257, 1, 1, 1, 'Terminal Management', 'Created', 'Terminal Lek-Pos2 created', 'Terminal', 13, '[]', '{\"company_id\":1,\"branch_id\":\"2\",\"terminal_code\":\"Lek-Pos2\",\"terminal_name\":\"Lekki-Pos2\",\"description\":\"Main Checkout\",\"device_name\":\"Dell Optilex\",\"ip_address\":null,\"status\":true,\"updated_at\":\"2026-08-30T16:19:56.000000Z\",\"created_at\":\"2026-08-30T16:19:56.000000Z\",\"id\":13}', 'terminals', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 15:19:56', '2026-08-30 15:19:56'),
(258, 1, 1, 1, 'Terminal Management', 'Created', 'Terminal Lek-Pos3 created', 'Terminal', 14, '[]', '{\"company_id\":1,\"branch_id\":\"2\",\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"id\":14}', 'terminals', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 15:20:14', '2026-08-30 15:20:14'),
(259, 1, 1, 1, 'Terminal Assignments', 'Assigned', 'Assigned cashier: Paul Olusogo Awolola to terminal: Lekki Branch POS 1', 'TerminalAssignment', 1, '[]', '{\"id\":1,\"company_id\":1,\"branch_id\":2,\"terminal_id\":3,\"user_id\":15,\"assigned_at\":\"2026-08-30T16:43:28.000000Z\",\"unassigned_at\":null,\"status\":\"Active\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-30T16:43:28.000000Z\",\"updated_at\":\"2026-08-30T16:43:28.000000Z\"}', 'users/15/terminal-assignment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 15:43:28', '2026-08-30 15:43:28'),
(260, 1, 1, 1, 'Terminal Assignments', 'Changed Assignment', 'Changed terminal assignment for cashier: Paul Olusogo Awolola to terminal: Lekki-Pos3', 'TerminalAssignment', 2, '{\"id\":1,\"company_id\":1,\"branch_id\":2,\"terminal_id\":3,\"user_id\":15,\"assigned_at\":\"2026-08-30T16:43:28.000000Z\",\"unassigned_at\":null,\"status\":\"Active\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-30T16:43:28.000000Z\",\"updated_at\":\"2026-08-30T16:43:28.000000Z\"}', '{\"id\":2,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"user_id\":15,\"assigned_at\":\"2026-08-30T16:57:55.000000Z\",\"unassigned_at\":null,\"status\":\"Active\",\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-30T16:57:55.000000Z\",\"updated_at\":\"2026-08-30T16:57:55.000000Z\"}', 'users/15/terminal-assignment', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 15:57:55', '2026-08-30 15:57:55'),
(261, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Paul Olusogo Awolola', 'User', 15, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/15/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 16:01:55', '2026-08-30 16:01:55'),
(262, 1, 2, 15, 'Account', 'Password Changed', 'User changed their password.', 'User', 15, NULL, NULL, 'account/password', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-30 16:02:34', '2026-08-30 16:02:34'),
(263, 1, 1, 1, 'Users', 'Password Reset', 'Reset password for Maxwell Akinkunmi Akinyooye', 'User', 17, '{\"password\":\"********\",\"force_password_change\":true}', '{\"password\":\"********\",\"force_password_change\":true}', 'users/17/reset-password', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 05:54:27', '2026-08-31 05:54:27'),
(264, 1, 2, 17, 'Account', 'Password Changed', 'User changed their password.', 'User', 17, NULL, NULL, 'account/password', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 05:55:33', '2026-08-31 05:55:33'),
(265, 1, 1, 1, 'Authorization', 'Permissions Updated', 'Updated permissions for role Branch Manager', 'Role', 3, '{\"permissions\":[1,4,6,10,14,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,71,72,73,74,75,76,79,80,66,67,68,69,70]}', '{\"permissions\":[1,4,6,10,14,25,31,35,39,40,41,42,43,44,45,46,47,50,51,52,53,54,56,57,58,59,60,61,62,63,64,65,71,72,73,74,75,76,79,80,66,67,68,69,70,77,78]}', 'roles/3/permissions', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 05:58:30', '2026-08-31 05:58:30'),
(266, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 1, NULL, '{\"id\":1,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"50000.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"50000.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T10:44:00.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I met 50000 in the drawer as at 11am\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T10:44:00.000000Z\",\"updated_at\":\"2026-08-31T10:44:00.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 09:44:00', '2026-08-31 09:44:00'),
(267, 1, 1, 1, 'Inventory', 'Stock Transferred', 'Transferred 11 product(s) from Head Office to Lekki Branch. Reference: TRF-20260831110507-GZTMGC', 'Branch', 1, NULL, '{\"reference_no\":\"TRF-20260831110507-GZTMGC\",\"source_branch_id\":1,\"destination_branch_id\":2,\"items\":[{\"stock_id\":13,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"quantity\":10,\"source_balance\":1605,\"destination_balance\":10},{\"stock_id\":10,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"quantity\":10,\"source_balance\":1020,\"destination_balance\":10},{\"stock_id\":9,\"product_id\":9,\"product_name\":\"Premier Soap\",\"quantity\":10,\"source_balance\":70,\"destination_balance\":10},{\"stock_id\":8,\"product_id\":8,\"product_name\":\"Mama Gold Rice 50kg\",\"quantity\":10,\"source_balance\":75,\"destination_balance\":10},{\"stock_id\":7,\"product_id\":7,\"product_name\":\"Family Bread\",\"quantity\":10,\"source_balance\":85,\"destination_balance\":10},{\"stock_id\":6,\"product_id\":6,\"product_name\":\"Dangote Sugar 1kg\",\"quantity\":10,\"source_balance\":1525,\"destination_balance\":10},{\"stock_id\":5,\"product_id\":5,\"product_name\":\"Indomie Chicken Noodles\",\"quantity\":10,\"source_balance\":80,\"destination_balance\":10},{\"stock_id\":4,\"product_id\":4,\"product_name\":\"Peak Milk 500g\",\"quantity\":10,\"source_balance\":90,\"destination_balance\":10},{\"stock_id\":3,\"product_id\":3,\"product_name\":\"Sprite 50cl\",\"quantity\":10,\"source_balance\":90,\"destination_balance\":10},{\"stock_id\":2,\"product_id\":2,\"product_name\":\"Fanta 50cl\",\"quantity\":10,\"source_balance\":2040,\"destination_balance\":10},{\"stock_id\":1,\"product_id\":1,\"product_name\":\"Coca-Cola 50cl\",\"quantity\":10,\"source_balance\":980,\"destination_balance\":10}]}', 'stock-transfer/transfer', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(268, 1, 2, 17, 'orders', 'create', 'Created sales order: ORD-000018', 'Order', 21, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":17,\"order_no\":\"ORD-000018\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-08-31T11:09:28.000000Z\",\"created_at\":\"2026-08-31T11:09:28.000000Z\",\"id\":21}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:09:28', '2026-08-31 10:09:28'),
(269, 1, 2, 17, 'invoices', 'create', 'Created invoice: INV-000005', 'Invoice', 5, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"order_id\":21,\"invoice_no\":\"INV-000005\",\"invoice_date\":\"2026-08-31T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"grand_total\":\"700.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-08-31T11:09:28.000000Z\",\"created_at\":\"2026-08-31T11:09:28.000000Z\",\"id\":5}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:09:28', '2026-08-31 10:09:28'),
(270, 1, 2, 17, 'orders', 'create', 'Created sales order: ORD-000019', 'Order', 22, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":17,\"order_no\":\"ORD-000019\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-08-31T11:10:48.000000Z\",\"created_at\":\"2026-08-31T11:10:48.000000Z\",\"id\":22}', 'sales/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:10:48', '2026-08-31 10:10:48'),
(271, 1, 2, 17, 'invoices', 'create', 'Created invoice: INV-000006', 'Invoice', 6, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"order_id\":22,\"invoice_no\":\"INV-000006\",\"invoice_date\":\"2026-08-31T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"grand_total\":\"700.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-08-31T11:10:48.000000Z\",\"created_at\":\"2026-08-31T11:10:48.000000Z\",\"id\":6}', 'sales/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:10:48', '2026-08-31 10:10:48'),
(272, 1, 2, 17, 'sales_orders', 'Completed', 'Completed sales order: ORD-000019', 'Order', 22, '{\"id\":22,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000019\",\"customer_id\":null,\"cashier_id\":17,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"0.00\",\"balance\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"created_at\":\"2026-08-31T11:10:48.000000Z\",\"updated_at\":\"2026-08-31T11:10:48.000000Z\",\"deleted_at\":null}', '{\"id\":22,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000019\",\"customer_id\":null,\"cashier_id\":17,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":\"2026-08-31T11:15:05.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":17,\"created_at\":\"2026-08-31T11:10:48.000000Z\",\"updated_at\":\"2026-08-31T11:15:05.000000Z\",\"deleted_at\":null}', 'sales/orders/22/complete', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 10:15:05', '2026-08-31 10:15:05'),
(273, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 2, NULL, '{\"id\":2,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"50000.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"50000.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T12:58:19.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I met 50000 in the drawer as at 11am\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T12:58:19.000000Z\",\"updated_at\":\"2026-08-31T12:58:19.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 11:58:19', '2026-08-31 11:58:19'),
(274, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 3, NULL, '{\"id\":3,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"50920.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"50920.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T13:03:30.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I opened the drawer as at 11am with exactly 50,920\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T13:03:30.000000Z\",\"updated_at\":\"2026-08-31T13:03:30.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 12:03:30', '2026-08-31 12:03:30'),
(275, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 3, '{\"id\":3,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"50920.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"50920.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T13:03:30.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I opened the drawer as at 11am with exactly 50,920\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T13:03:30.000000Z\",\"updated_at\":\"2026-08-31T13:03:30.000000Z\"}', '{\"id\":3,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"50920.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"50920.00\",\"actual_balance\":\"50920.00\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-08-31T13:03:30.000000Z\",\"closed_at\":\"2026-08-31T13:14:15.000000Z\",\"opening_remarks\":\"I opened the drawer as at 11am with exactly 50,920\",\"closing_remarks\":\"I closed the drawer as at 8pm with exactly 50920 confirl by my manager\",\"created_at\":\"2026-08-31T13:03:30.000000Z\",\"updated_at\":\"2026-08-31T13:14:15.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/3/close', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 12:14:15', '2026-08-31 12:14:15'),
(276, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 4, NULL, '{\"id\":4,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"52335.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"52335.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T13:15:28.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I opened the drawer with 52335 at exactly 2pm\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T13:15:28.000000Z\",\"updated_at\":\"2026-08-31T13:15:28.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 12:15:28', '2026-08-31 12:15:28'),
(277, 1, 2, 15, 'cash_drawer', 'Cash In', 'Recorded cash in transaction.', 'CashDrawerTransaction', 6, NULL, '{\"id\":6,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"cash_drawer_id\":4,\"payment_id\":null,\"order_id\":null,\"created_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"transaction_type\":\"Cash In\",\"amount\":\"15000.00\",\"balance_before\":\"52335.00\",\"balance_after\":\"67335.00\",\"reference_no\":null,\"remarks\":\"I Collected 15000 from terminal 2\",\"created_at\":\"2026-08-31T13:21:19.000000Z\",\"updated_at\":\"2026-08-31T13:21:19.000000Z\"}', 'cash-drawer/cash-in', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 12:21:19', '2026-08-31 12:21:19'),
(278, 1, 2, 15, 'cash_drawer', 'Cash Out', 'Recorded cash out transaction.', 'CashDrawerTransaction', 7, NULL, '{\"id\":7,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"cash_drawer_id\":4,\"payment_id\":null,\"order_id\":null,\"created_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"transaction_type\":\"Cash Out\",\"amount\":\"5000.00\",\"balance_before\":\"67335.00\",\"balance_after\":\"62335.00\",\"reference_no\":null,\"remarks\":\"gave 5000 to terminal 2, as at 3pm\",\"created_at\":\"2026-08-31T13:23:29.000000Z\",\"updated_at\":\"2026-08-31T13:23:29.000000Z\"}', 'cash-drawer/cash-out', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-31 12:23:29', '2026-08-31 12:23:29');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(279, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 4, '{\"id\":4,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"52335.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"15000.00\",\"cash_out\":\"5000.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"62335.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-08-31T13:15:28.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I opened the drawer with 52335 at exactly 2pm\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T13:15:28.000000Z\",\"updated_at\":\"2026-08-31T13:23:29.000000Z\"}', '{\"id\":4,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"52335.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"15000.00\",\"cash_out\":\"5000.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"62335.00\",\"actual_balance\":\"62335.00\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-08-31T13:15:28.000000Z\",\"closed_at\":\"2026-09-02T05:05:18.000000Z\",\"opening_remarks\":\"I opened the drawer with 52335 at exactly 2pm\",\"closing_remarks\":null,\"created_at\":\"2026-08-31T13:15:28.000000Z\",\"updated_at\":\"2026-09-02T05:05:18.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/4/close', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-02 04:05:18', '2026-09-02 04:05:18'),
(280, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 5, NULL, '{\"id\":5,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"41320.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"41320.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-02T10:44:52.000000Z\",\"closed_at\":null,\"opening_remarks\":\"Opened the drawer with 41,320 as at 11am\",\"closing_remarks\":null,\"created_at\":\"2026-09-02T10:44:52.000000Z\",\"updated_at\":\"2026-09-02T10:44:52.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-02 09:44:52', '2026-09-02 09:44:52'),
(281, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000020 completed.', 'Order', 28, NULL, '{\"id\":28,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000020\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"4250.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"4250.00\",\"amount_paid\":\"4250.00\",\"balance\":\"0.00\",\"total_items\":4,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"4250.00\",\"completed_at\":\"2026-09-02T12:38:01.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":50,\"company_id\":1,\"order_id\":28,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\"},{\"id\":51,\"company_id\":1,\"order_id\":28,\"product_id\":3,\"product_name\":\"Sprite 50cl\",\"product_barcode\":\"100000000003\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\"},{\"id\":52,\"company_id\":1,\"order_id\":28,\"product_id\":6,\"product_name\":\"Dangote Sugar 1kg\",\"product_barcode\":\"100000000006\",\"quantity\":\"1.00\",\"unit_price\":\"1650.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1650.00\",\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\"},{\"id\":53,\"company_id\":1,\"order_id\":28,\"product_id\":1,\"product_name\":\"Coca-Cola 50cl\",\"product_barcode\":\"100000000001\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\"}],\"payments\":[{\"id\":14,\"company_id\":1,\"branch_id\":2,\"order_id\":28,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"4250.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-02T12:38:01.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000009\",\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\"}],\"invoice\":{\"id\":12,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":28,\"customer_id\":null,\"invoice_no\":\"INV-000007\",\"invoice_date\":\"2026-09-02T00:00:00.000000Z\",\"subtotal\":\"4250.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"4250.00\",\"amount_paid\":\"4250.00\",\"balance\":\"0.00\",\"total_quantity\":\"4.00\",\"total_items\":4,\"grand_total\":\"4250.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-02T12:38:01.000000Z\",\"updated_at\":\"2026-09-02T12:38:01.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(282, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 5, '{\"id\":5,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"41320.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"41320.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-02T10:44:52.000000Z\",\"closed_at\":null,\"opening_remarks\":\"Opened the drawer with 41,320 as at 11am\",\"closing_remarks\":null,\"created_at\":\"2026-09-02T10:44:52.000000Z\",\"updated_at\":\"2026-09-02T10:44:52.000000Z\"}', '{\"id\":5,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"41320.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"41320.00\",\"actual_balance\":\"41320.00\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-09-02T10:44:52.000000Z\",\"closed_at\":\"2026-09-03T12:26:16.000000Z\",\"opening_remarks\":\"Opened the drawer with 41,320 as at 11am\",\"closing_remarks\":null,\"created_at\":\"2026-09-02T10:44:52.000000Z\",\"updated_at\":\"2026-09-03T12:26:16.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/5/close', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 11:26:16', '2026-09-03 11:26:16'),
(283, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 6, NULL, '{\"id\":6,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"23250.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"23250.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-03T12:27:46.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I met 23,250 in the drawer as at 10am today.\",\"closing_remarks\":null,\"created_at\":\"2026-09-03T12:27:46.000000Z\",\"updated_at\":\"2026-09-03T12:27:46.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 11:27:46', '2026-09-03 11:27:46'),
(284, 1, 2, 15, 'cash_drawer', 'Cash In', 'Recorded cash in transaction.', 'CashDrawerTransaction', 10, NULL, '{\"id\":10,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"cash_drawer_id\":6,\"payment_id\":null,\"order_id\":null,\"created_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"transaction_type\":\"Cash In\",\"amount\":\"5000.00\",\"balance_before\":\"23250.00\",\"balance_after\":\"28250.00\",\"reference_no\":null,\"remarks\":\"Collected 5,000 from terminal 2- Tolu\",\"created_at\":\"2026-09-03T12:28:30.000000Z\",\"updated_at\":\"2026-09-03T12:28:30.000000Z\"}', 'cash-drawer/cash-in', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 11:28:30', '2026-09-03 11:28:30'),
(285, 1, 2, 15, 'cash_drawer', 'Cash Out', 'Recorded cash out transaction.', 'CashDrawerTransaction', 11, NULL, '{\"id\":11,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"cash_drawer_id\":6,\"payment_id\":null,\"order_id\":null,\"created_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"transaction_type\":\"Cash Out\",\"amount\":\"2500.00\",\"balance_before\":\"28250.00\",\"balance_after\":\"25750.00\",\"reference_no\":null,\"remarks\":\"Gave 2500 cash to teminal2-Tolu\",\"created_at\":\"2026-09-03T12:30:03.000000Z\",\"updated_at\":\"2026-09-03T12:30:03.000000Z\"}', 'cash-drawer/cash-out', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 11:30:03', '2026-09-03 11:30:03'),
(286, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000021 completed.', 'Order', 29, NULL, '{\"id\":29,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000021\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":\"2026-09-03T13:53:32.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T13:53:32.000000Z\",\"updated_at\":\"2026-09-03T13:53:32.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":54,\"company_id\":1,\"order_id\":29,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-03T13:53:32.000000Z\",\"updated_at\":\"2026-09-03T13:53:32.000000Z\"}],\"payments\":[{\"id\":15,\"company_id\":1,\"branch_id\":2,\"order_id\":29,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"1200.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T13:53:33.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000010\",\"created_at\":\"2026-09-03T13:53:33.000000Z\",\"updated_at\":\"2026-09-03T13:53:33.000000Z\"}],\"invoice\":{\"id\":13,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":29,\"customer_id\":null,\"invoice_no\":\"INV-000008\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1200.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T13:53:32.000000Z\",\"updated_at\":\"2026-09-03T13:53:32.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 12:53:33', '2026-09-03 12:53:33'),
(287, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000022 completed.', 'Order', 30, NULL, '{\"id\":30,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000022\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"90000.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"90000.00\",\"completed_at\":\"2026-09-03T14:26:09.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T14:26:09.000000Z\",\"updated_at\":\"2026-09-03T14:26:09.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":55,\"company_id\":1,\"order_id\":30,\"product_id\":8,\"product_name\":\"Mama Gold Rice 50kg\",\"product_barcode\":\"100000000008\",\"quantity\":\"1.00\",\"unit_price\":\"90000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"90000.00\",\"created_at\":\"2026-09-03T14:26:09.000000Z\",\"updated_at\":\"2026-09-03T14:26:09.000000Z\"}],\"payments\":[{\"id\":16,\"company_id\":1,\"branch_id\":2,\"order_id\":30,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"90000.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T14:26:09.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000011\",\"created_at\":\"2026-09-03T14:26:09.000000Z\",\"updated_at\":\"2026-09-03T14:26:09.000000Z\"}],\"invoice\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":30,\"customer_id\":null,\"invoice_no\":\"INV-000009\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"90000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"90000.00\",\"amount_paid\":\"90000.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"90000.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T14:26:09.000000Z\",\"updated_at\":\"2026-09-03T14:26:09.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(288, 1, 2, 17, 'orders', 'create', 'Created sales order: ORD-000023', 'Order', 31, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":17,\"order_no\":\"ORD-000023\",\"subtotal\":\"1400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1400.00\",\"amount_paid\":\"0.00\",\"balance\":\"1400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"1400.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-09-03T14:29:17.000000Z\",\"created_at\":\"2026-09-03T14:29:17.000000Z\",\"id\":31}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 13:29:17', '2026-09-03 13:29:17'),
(289, 1, 2, 17, 'invoices', 'create', 'Created invoice: INV-000010', 'Invoice', 15, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"order_id\":31,\"invoice_no\":\"INV-000010\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"1400.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1400.00\",\"amount_paid\":\"0.00\",\"balance\":\"1400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"grand_total\":\"1400.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"updated_at\":\"2026-09-03T14:29:17.000000Z\",\"created_at\":\"2026-09-03T14:29:17.000000Z\",\"id\":15}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 13:29:17', '2026-09-03 13:29:17'),
(290, 1, 2, 17, 'sales_orders', 'Completed', 'Completed sales order: ORD-000023', 'Order', 31, '{\"id\":31,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000023\",\"customer_id\":null,\"cashier_id\":17,\"subtotal\":\"1400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1400.00\",\"amount_paid\":\"0.00\",\"balance\":\"1400.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"1400.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":null,\"created_at\":\"2026-09-03T14:29:17.000000Z\",\"updated_at\":\"2026-09-03T14:29:17.000000Z\",\"deleted_at\":null}', '{\"id\":31,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000023\",\"customer_id\":null,\"cashier_id\":17,\"subtotal\":\"1400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1400.00\",\"amount_paid\":\"1400.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"1400.00\",\"completed_at\":\"2026-09-03T14:30:47.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":17,\"updated_by\":17,\"created_at\":\"2026-09-03T14:29:17.000000Z\",\"updated_at\":\"2026-09-03T14:30:47.000000Z\",\"deleted_at\":null}', 'sales/orders/31/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 13:30:47', '2026-09-03 13:30:47'),
(291, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000024 completed.', 'Order', 32, NULL, '{\"id\":32,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000024\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":\"2026-09-03T15:04:14.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:04:14.000000Z\",\"updated_at\":\"2026-09-03T15:04:14.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":57,\"company_id\":1,\"order_id\":32,\"product_id\":7,\"product_name\":\"Family Bread\",\"product_barcode\":\"100000000007\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-03T15:04:14.000000Z\",\"updated_at\":\"2026-09-03T15:04:14.000000Z\"}],\"payments\":[{\"id\":18,\"company_id\":1,\"branch_id\":2,\"order_id\":32,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"1200.00\",\"payment_status\":\"Completed\",\"payment_method_id\":3,\"payment_method\":\"Transfer\",\"payment_date\":\"2026-09-03T15:04:14.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"trf393939\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000013\",\"created_at\":\"2026-09-03T15:04:14.000000Z\",\"updated_at\":\"2026-09-03T15:04:14.000000Z\"}],\"invoice\":{\"id\":16,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":32,\"customer_id\":null,\"invoice_no\":\"INV-000011\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1200.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:04:14.000000Z\",\"updated_at\":\"2026-09-03T15:04:14.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:04:14', '2026-09-03 14:04:14'),
(292, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000025 completed.', 'Order', 33, NULL, '{\"id\":33,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000025\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":\"2026-09-03T15:35:52.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:35:52.000000Z\",\"updated_at\":\"2026-09-03T15:35:52.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":58,\"company_id\":1,\"order_id\":33,\"product_id\":9,\"product_name\":\"Premier Soap\",\"product_barcode\":\"100000000009\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-03T15:35:52.000000Z\",\"updated_at\":\"2026-09-03T15:35:52.000000Z\"}],\"payments\":[{\"id\":19,\"company_id\":1,\"branch_id\":2,\"order_id\":33,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"700.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:35:52.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000014\",\"created_at\":\"2026-09-03T15:35:52.000000Z\",\"updated_at\":\"2026-09-03T15:35:52.000000Z\"}],\"invoice\":{\"id\":17,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":33,\"customer_id\":null,\"invoice_no\":\"INV-000012\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"700.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:35:52.000000Z\",\"updated_at\":\"2026-09-03T15:35:52.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(293, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000026 completed.', 'Order', 34, NULL, '{\"id\":34,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000026\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"4800.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"4800.00\",\"amount_paid\":\"4800.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"4800.00\",\"completed_at\":\"2026-09-03T15:41:19.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:41:19.000000Z\",\"updated_at\":\"2026-09-03T15:41:19.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":59,\"company_id\":1,\"order_id\":34,\"product_id\":4,\"product_name\":\"Peak Milk 500g\",\"product_barcode\":\"100000000004\",\"quantity\":\"1.00\",\"unit_price\":\"4800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"4800.00\",\"created_at\":\"2026-09-03T15:41:19.000000Z\",\"updated_at\":\"2026-09-03T15:41:19.000000Z\"}],\"payments\":[{\"id\":20,\"company_id\":1,\"branch_id\":2,\"order_id\":34,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"4800.00\",\"payment_status\":\"Completed\",\"payment_method_id\":3,\"payment_method\":\"Transfer\",\"payment_date\":\"2026-09-03T15:41:19.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"trf4566\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000015\",\"created_at\":\"2026-09-03T15:41:19.000000Z\",\"updated_at\":\"2026-09-03T15:41:19.000000Z\"}],\"invoice\":{\"id\":18,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":34,\"customer_id\":null,\"invoice_no\":\"INV-000013\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"4800.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"4800.00\",\"amount_paid\":\"4800.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"4800.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:41:19.000000Z\",\"updated_at\":\"2026-09-03T15:41:19.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:41:20', '2026-09-03 14:41:20'),
(294, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000027 completed.', 'Order', 35, NULL, '{\"id\":35,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000027\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"250.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"250.00\",\"amount_paid\":\"250.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"250.00\",\"completed_at\":\"2026-09-03T15:42:11.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:42:11.000000Z\",\"updated_at\":\"2026-09-03T15:42:11.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":60,\"company_id\":1,\"order_id\":35,\"product_id\":5,\"product_name\":\"Indomie Chicken Noodles\",\"product_barcode\":\"100000000005\",\"quantity\":\"1.00\",\"unit_price\":\"250.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"250.00\",\"created_at\":\"2026-09-03T15:42:11.000000Z\",\"updated_at\":\"2026-09-03T15:42:11.000000Z\"}],\"payments\":[{\"id\":21,\"company_id\":1,\"branch_id\":2,\"order_id\":35,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"250.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:42:11.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000016\",\"created_at\":\"2026-09-03T15:42:11.000000Z\",\"updated_at\":\"2026-09-03T15:42:11.000000Z\"}],\"invoice\":{\"id\":19,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":35,\"customer_id\":null,\"invoice_no\":\"INV-000014\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"250.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"250.00\",\"amount_paid\":\"250.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"250.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:42:11.000000Z\",\"updated_at\":\"2026-09-03T15:42:11.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(295, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000028 completed.', 'Order', 37, NULL, '{\"id\":37,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000028\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":\"2026-09-03T15:44:26.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:44:26.000000Z\",\"updated_at\":\"2026-09-03T15:44:26.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":62,\"company_id\":1,\"order_id\":37,\"product_id\":1,\"product_name\":\"Coca-Cola 50cl\",\"product_barcode\":\"100000000001\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-03T15:44:26.000000Z\",\"updated_at\":\"2026-09-03T15:44:26.000000Z\"}],\"payments\":[{\"id\":22,\"company_id\":1,\"branch_id\":2,\"order_id\":37,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"700.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:44:26.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"cs346464\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000017\",\"created_at\":\"2026-09-03T15:44:26.000000Z\",\"updated_at\":\"2026-09-03T15:44:26.000000Z\"}],\"invoice\":{\"id\":21,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":37,\"customer_id\":null,\"invoice_no\":\"INV-000015\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"700.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:44:26.000000Z\",\"updated_at\":\"2026-09-03T15:44:26.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(296, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000029 completed.', 'Order', 38, NULL, '{\"id\":38,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000029\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"2400.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"2400.00\",\"amount_paid\":\"2400.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"2.00\",\"change_given\":\"0.00\",\"grand_total\":\"2400.00\",\"completed_at\":\"2026-09-03T15:48:07.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:48:07.000000Z\",\"updated_at\":\"2026-09-03T15:48:07.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":63,\"company_id\":1,\"order_id\":38,\"product_id\":7,\"product_name\":\"Family Bread\",\"product_barcode\":\"100000000007\",\"quantity\":\"2.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2400.00\",\"created_at\":\"2026-09-03T15:48:07.000000Z\",\"updated_at\":\"2026-09-03T15:48:07.000000Z\"}],\"payments\":[{\"id\":23,\"company_id\":1,\"branch_id\":2,\"order_id\":38,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"2400.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:48:07.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000018\",\"created_at\":\"2026-09-03T15:48:07.000000Z\",\"updated_at\":\"2026-09-03T15:48:07.000000Z\"}],\"invoice\":{\"id\":22,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":38,\"customer_id\":null,\"invoice_no\":\"INV-000016\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"2400.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"2400.00\",\"amount_paid\":\"2400.00\",\"balance\":\"0.00\",\"total_quantity\":\"2.00\",\"total_items\":1,\"grand_total\":\"2400.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:48:07.000000Z\",\"updated_at\":\"2026-09-03T15:48:07.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(297, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000030 completed.', 'Order', 39, NULL, '{\"id\":39,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000030\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"700.00\",\"completed_at\":\"2026-09-03T15:49:35.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:49:35.000000Z\",\"updated_at\":\"2026-09-03T15:49:35.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":64,\"company_id\":1,\"order_id\":39,\"product_id\":9,\"product_name\":\"Premier Soap\",\"product_barcode\":\"100000000009\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-03T15:49:35.000000Z\",\"updated_at\":\"2026-09-03T15:49:35.000000Z\"}],\"payments\":[{\"id\":24,\"company_id\":1,\"branch_id\":2,\"order_id\":39,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"700.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:49:35.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000019\",\"created_at\":\"2026-09-03T15:49:35.000000Z\",\"updated_at\":\"2026-09-03T15:49:35.000000Z\"}],\"invoice\":{\"id\":23,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":39,\"customer_id\":null,\"invoice_no\":\"INV-000017\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"amount_paid\":\"700.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"700.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:49:35.000000Z\",\"updated_at\":\"2026-09-03T15:49:35.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(298, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000031 completed.', 'Order', 40, NULL, '{\"id\":40,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000031\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"11450.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"11450.00\",\"amount_paid\":\"11450.00\",\"balance\":\"0.00\",\"total_items\":3,\"total_quantity\":\"3.00\",\"change_given\":\"0.00\",\"grand_total\":\"11450.00\",\"completed_at\":\"2026-09-03T15:57:36.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":65,\"company_id\":1,\"order_id\":40,\"product_id\":7,\"product_name\":\"Family Bread\",\"product_barcode\":\"100000000007\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\"},{\"id\":66,\"company_id\":1,\"order_id\":40,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"product_barcode\":\"100000000010\",\"quantity\":\"1.00\",\"unit_price\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"8600.00\",\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\"},{\"id\":67,\"company_id\":1,\"order_id\":40,\"product_id\":6,\"product_name\":\"Dangote Sugar 1kg\",\"product_barcode\":\"100000000006\",\"quantity\":\"1.00\",\"unit_price\":\"1650.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1650.00\",\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\"}],\"payments\":[{\"id\":25,\"company_id\":1,\"branch_id\":2,\"order_id\":40,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"11450.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-03T15:57:36.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000020\",\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\"}],\"invoice\":{\"id\":24,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":40,\"customer_id\":null,\"invoice_no\":\"INV-000018\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"11450.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"11450.00\",\"amount_paid\":\"11450.00\",\"balance\":\"0.00\",\"total_quantity\":\"3.00\",\"total_items\":3,\"grand_total\":\"11450.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T15:57:36.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 14:57:37', '2026-09-03 14:57:37'),
(299, 1, 1, 1, 'Payment Methods', 'Created', 'Created payment method Card.', 'PaymentMethod', 8, NULL, NULL, 'payment-methods', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 15:02:29', '2026-09-03 15:02:29');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(300, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000032 completed.', 'Order', 41, NULL, '{\"id\":41,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000032\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"8600.00\",\"amount_paid\":\"8600.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"8600.00\",\"completed_at\":\"2026-09-03T16:22:00.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T16:22:00.000000Z\",\"updated_at\":\"2026-09-03T16:22:00.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":68,\"company_id\":1,\"order_id\":41,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"product_barcode\":\"100000000010\",\"quantity\":\"1.00\",\"unit_price\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"8600.00\",\"created_at\":\"2026-09-03T16:22:00.000000Z\",\"updated_at\":\"2026-09-03T16:22:00.000000Z\"}],\"payments\":[{\"id\":26,\"company_id\":1,\"branch_id\":2,\"order_id\":41,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"8600.00\",\"payment_status\":\"Completed\",\"payment_method_id\":8,\"payment_method\":\"Card\",\"payment_date\":\"2026-09-03T16:22:00.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"dccrr333455\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000021\",\"created_at\":\"2026-09-03T16:22:00.000000Z\",\"updated_at\":\"2026-09-03T16:22:00.000000Z\"}],\"invoice\":{\"id\":25,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":41,\"customer_id\":null,\"invoice_no\":\"INV-000019\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"8600.00\",\"amount_paid\":\"8600.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"8600.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T16:22:00.000000Z\",\"updated_at\":\"2026-09-03T16:22:00.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 15:22:00', '2026-09-03 15:22:00'),
(301, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000033 completed.', 'Order', 42, NULL, '{\"id\":42,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000033\",\"customer_id\":10,\"cashier_id\":15,\"subtotal\":\"90000.00\",\"discount\":\"5.00\",\"discount_id\":2,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"89995.00\",\"amount_paid\":\"89995.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"89995.00\",\"completed_at\":\"2026-09-03T21:14:44.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T21:14:44.000000Z\",\"updated_at\":\"2026-09-03T21:14:44.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":69,\"company_id\":1,\"order_id\":42,\"product_id\":8,\"product_name\":\"Mama Gold Rice 50kg\",\"product_barcode\":\"100000000008\",\"quantity\":\"1.00\",\"unit_price\":\"90000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"90000.00\",\"created_at\":\"2026-09-03T21:14:44.000000Z\",\"updated_at\":\"2026-09-03T21:14:44.000000Z\"}],\"payments\":[{\"id\":27,\"company_id\":1,\"branch_id\":2,\"order_id\":42,\"customer_id\":10,\"terminal_id\":14,\"amount\":\"89995.00\",\"payment_status\":\"Completed\",\"payment_method_id\":8,\"payment_method\":\"Card\",\"payment_date\":\"2026-09-03T21:14:44.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"tr3494848494\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000022\",\"created_at\":\"2026-09-03T21:14:44.000000Z\",\"updated_at\":\"2026-09-03T21:14:44.000000Z\"}],\"invoice\":{\"id\":26,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":42,\"customer_id\":10,\"invoice_no\":\"INV-000020\",\"invoice_date\":\"2026-09-03T00:00:00.000000Z\",\"subtotal\":\"90000.00\",\"discount\":\"5.00\",\"tax\":\"0.00\",\"total\":\"89995.00\",\"amount_paid\":\"89995.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"89995.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-03T21:14:44.000000Z\",\"updated_at\":\"2026-09-03T21:14:44.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 20:14:44', '2026-09-03 20:14:44'),
(302, 1, 1, 1, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 1, '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket Ng\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"4.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-09T16:23:25.000000Z\"}', '{\"id\":1,\"company_id\":1,\"company_name\":\"Emmanex Supermarket Ng\",\"company_email\":\"info@emmanexitconsult.com\",\"company_phone\":\"08012345678\",\"company_address\":\"Lagos, Nigeria\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"Emmanex Supermarket\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":true,\"allow_negative_stock\":false,\"low_stock_alert\":5,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":\"Walk-in Customer\",\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"m\\/d\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-03T22:09:39.000000Z\"}', 'settings/general', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 21:09:39', '2026-09-03 21:09:39'),
(303, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000004', 'Order', 46, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000004\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T22:39:38.000000Z\",\"created_at\":\"2026-09-03T22:39:38.000000Z\",\"id\":46}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 21:39:38', '2026-09-03 21:39:38'),
(304, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000005', 'Order', 47, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000005\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:22:52.000000Z\",\"created_at\":\"2026-09-03T23:22:52.000000Z\",\"id\":47}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:22:52', '2026-09-03 22:22:52'),
(305, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000006', 'Order', 48, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000006\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:25:21.000000Z\",\"created_at\":\"2026-09-03T23:25:21.000000Z\",\"id\":48}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:25:21', '2026-09-03 22:25:21'),
(306, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000007', 'Order', 49, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000007\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:29:53.000000Z\",\"created_at\":\"2026-09-03T23:29:53.000000Z\",\"id\":49}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:29:53', '2026-09-03 22:29:53'),
(307, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000008', 'Order', 50, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000008\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:30:37.000000Z\",\"created_at\":\"2026-09-03T23:30:37.000000Z\",\"id\":50}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:30:37', '2026-09-03 22:30:37'),
(308, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000009', 'Order', 51, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000009\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:38:03.000000Z\",\"created_at\":\"2026-09-03T23:38:03.000000Z\",\"id\":51}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:38:03', '2026-09-03 22:38:03'),
(309, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000010', 'Order', 52, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000010\",\"order_status\":\"Held\",\"subtotal\":\"9300.00\",\"total\":\"9300.00\",\"grand_total\":\"9300.00\",\"total_items\":2,\"total_quantity\":\"2.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:40:56.000000Z\",\"created_at\":\"2026-09-03T23:40:56.000000Z\",\"id\":52}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:40:56', '2026-09-03 22:40:56'),
(310, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000011', 'Order', 53, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000011\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:45:02.000000Z\",\"created_at\":\"2026-09-03T23:45:02.000000Z\",\"id\":53}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:45:02', '2026-09-03 22:45:02'),
(311, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000012', 'Order', 54, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000012\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:48:38.000000Z\",\"created_at\":\"2026-09-03T23:48:38.000000Z\",\"id\":54}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:48:38', '2026-09-03 22:48:38'),
(312, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000013', 'Order', 55, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000013\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:53:21.000000Z\",\"created_at\":\"2026-09-03T23:53:21.000000Z\",\"id\":55}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:53:21', '2026-09-03 22:53:21'),
(313, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000014', 'Order', 56, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000014\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-03T23:57:49.000000Z\",\"created_at\":\"2026-09-03T23:57:49.000000Z\",\"id\":56}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 22:57:49', '2026-09-03 22:57:49'),
(314, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000015', 'Order', 57, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000015\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:01:27.000000Z\",\"created_at\":\"2026-09-04T00:01:27.000000Z\",\"id\":57}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:01:27', '2026-09-03 23:01:27'),
(315, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000016', 'Order', 58, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000016\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:05:20.000000Z\",\"created_at\":\"2026-09-04T00:05:20.000000Z\",\"id\":58}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:05:20', '2026-09-03 23:05:20'),
(316, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000017', 'Order', 59, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000017\",\"order_status\":\"Held\",\"subtotal\":\"700.00\",\"total\":\"700.00\",\"grand_total\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:07:57.000000Z\",\"created_at\":\"2026-09-04T00:07:57.000000Z\",\"id\":59}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:07:57', '2026-09-03 23:07:57'),
(317, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000018', 'Order', 60, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000018\",\"order_status\":\"Held\",\"subtotal\":\"700.00\",\"total\":\"700.00\",\"grand_total\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:10:40.000000Z\",\"created_at\":\"2026-09-04T00:10:40.000000Z\",\"id\":60}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:10:40', '2026-09-03 23:10:40'),
(318, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000019', 'Order', 61, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000019\",\"order_status\":\"Held\",\"subtotal\":\"700.00\",\"total\":\"700.00\",\"grand_total\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:11:32.000000Z\",\"created_at\":\"2026-09-04T00:11:32.000000Z\",\"id\":61}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:11:32', '2026-09-03 23:11:32'),
(319, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000020', 'Order', 62, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000020\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:16:36.000000Z\",\"created_at\":\"2026-09-04T00:16:36.000000Z\",\"id\":62}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:16:36', '2026-09-03 23:16:36'),
(320, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000021', 'Order', 63, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000021\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:21:49.000000Z\",\"created_at\":\"2026-09-04T00:21:49.000000Z\",\"id\":63}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:21:49', '2026-09-03 23:21:49'),
(321, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000022', 'Order', 64, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000022\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:22:43.000000Z\",\"created_at\":\"2026-09-04T00:22:43.000000Z\",\"id\":64}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:22:43', '2026-09-03 23:22:43'),
(322, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000023', 'Order', 65, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000023\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:23:27.000000Z\",\"created_at\":\"2026-09-04T00:23:27.000000Z\",\"id\":65}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:23:27', '2026-09-03 23:23:27'),
(323, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000024', 'Order', 66, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000024\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:24:58.000000Z\",\"created_at\":\"2026-09-04T00:24:58.000000Z\",\"id\":66}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:24:58', '2026-09-03 23:24:58'),
(324, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000025', 'Order', 67, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000025\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:27:31.000000Z\",\"created_at\":\"2026-09-04T00:27:31.000000Z\",\"id\":67}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:27:31', '2026-09-03 23:27:31'),
(325, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000026', 'Order', 68, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000026\",\"order_status\":\"Held\",\"subtotal\":\"1200.00\",\"total\":\"1200.00\",\"grand_total\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T00:35:20.000000Z\",\"created_at\":\"2026-09-04T00:35:20.000000Z\",\"id\":68}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-03 23:35:20', '2026-09-03 23:35:20'),
(326, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 6, '{\"id\":6,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"23250.00\",\"cash_sales\":\"107600.00\",\"cash_in\":\"5000.00\",\"cash_out\":\"2500.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"133350.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-03T12:27:46.000000Z\",\"closed_at\":null,\"opening_remarks\":\"I met 23,250 in the drawer as at 10am today.\",\"closing_remarks\":null,\"created_at\":\"2026-09-03T12:27:46.000000Z\",\"updated_at\":\"2026-09-03T15:57:36.000000Z\"}', '{\"id\":6,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"23250.00\",\"cash_sales\":\"107600.00\",\"cash_in\":\"5000.00\",\"cash_out\":\"2500.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"133350.00\",\"actual_balance\":\"133350.00\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-09-03T12:27:46.000000Z\",\"closed_at\":\"2026-09-04T08:05:50.000000Z\",\"opening_remarks\":\"I met 23,250 in the drawer as at 10am today.\",\"closing_remarks\":null,\"created_at\":\"2026-09-03T12:27:46.000000Z\",\"updated_at\":\"2026-09-04T08:05:50.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/6/close', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 07:05:50', '2026-09-04 07:05:50'),
(327, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 7, NULL, '{\"id\":7,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"22340.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"22340.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-04T08:06:06.000000Z\",\"closed_at\":null,\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-04T08:06:06.000000Z\",\"updated_at\":\"2026-09-04T08:06:06.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 07:06:06', '2026-09-04 07:06:06'),
(328, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000027', 'Order', 69, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000027\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T08:24:40.000000Z\",\"created_at\":\"2026-09-04T08:24:40.000000Z\",\"id\":69}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 07:24:40', '2026-09-04 07:24:40'),
(329, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000028', 'Order', 70, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000028\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T08:25:01.000000Z\",\"created_at\":\"2026-09-04T08:25:01.000000Z\",\"id\":70}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 07:25:01', '2026-09-04 07:25:01'),
(330, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000029', 'Order', 71, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000029\",\"order_status\":\"Held\",\"subtotal\":\"8600.00\",\"total\":\"8600.00\",\"grand_total\":\"8600.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T08:28:41.000000Z\",\"created_at\":\"2026-09-04T08:28:41.000000Z\",\"id\":71}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 07:28:41', '2026-09-04 07:28:41'),
(331, 1, 2, 15, 'pos', 'hold_order', 'Sale held: SO-000030', 'Order', 72, NULL, '{\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"customer_id\":null,\"cashier_id\":15,\"order_no\":\"SO-000030\",\"order_status\":\"Held\",\"subtotal\":\"700.00\",\"total\":\"700.00\",\"grand_total\":\"700.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"remarks\":null,\"created_by\":15,\"updated_at\":\"2026-09-04T09:03:52.000000Z\",\"created_at\":\"2026-09-04T09:03:52.000000Z\",\"id\":72}', 'pos/orders/hold', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:03:52', '2026-09-04 08:03:52'),
(332, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000034 completed.', 'Order', 73, NULL, '{\"id\":73,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000034\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"2.50\",\"grand_total\":\"752.50\",\"completed_at\":\"2026-09-04T09:09:17.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:09:17.000000Z\",\"updated_at\":\"2026-09-04T09:09:17.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":98,\"company_id\":1,\"order_id\":73,\"product_id\":9,\"product_name\":\"Premier Soap\",\"product_barcode\":\"100000000009\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-04T09:09:17.000000Z\",\"updated_at\":\"2026-09-04T09:09:17.000000Z\"}],\"payments\":[{\"id\":28,\"company_id\":1,\"branch_id\":2,\"order_id\":73,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"752.50\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-04T09:09:17.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000023\",\"created_at\":\"2026-09-04T09:09:17.000000Z\",\"updated_at\":\"2026-09-04T09:09:17.000000Z\"}],\"invoice\":{\"id\":27,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":73,\"customer_id\":null,\"invoice_no\":\"INV-000021\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"752.50\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:09:17.000000Z\",\"updated_at\":\"2026-09-04T09:09:17.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(333, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000035 completed.', 'Order', 74, NULL, '{\"id\":74,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000035\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"2.50\",\"grand_total\":\"752.50\",\"completed_at\":\"2026-09-04T09:09:32.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:09:32.000000Z\",\"updated_at\":\"2026-09-04T09:09:32.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":99,\"company_id\":1,\"order_id\":74,\"product_id\":9,\"product_name\":\"Premier Soap\",\"product_barcode\":\"100000000009\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-04T09:09:32.000000Z\",\"updated_at\":\"2026-09-04T09:09:32.000000Z\"}],\"payments\":[{\"id\":29,\"company_id\":1,\"branch_id\":2,\"order_id\":74,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"752.50\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-04T09:09:32.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000024\",\"created_at\":\"2026-09-04T09:09:32.000000Z\",\"updated_at\":\"2026-09-04T09:09:32.000000Z\"}],\"invoice\":{\"id\":28,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":74,\"customer_id\":null,\"invoice_no\":\"INV-000022\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"752.50\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:09:32.000000Z\",\"updated_at\":\"2026-09-04T09:09:32.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(334, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000036 completed.', 'Order', 75, NULL, '{\"id\":75,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000036\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"2.50\",\"grand_total\":\"752.50\",\"completed_at\":\"2026-09-04T09:17:39.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:17:39.000000Z\",\"updated_at\":\"2026-09-04T09:17:39.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":100,\"company_id\":1,\"order_id\":75,\"product_id\":9,\"product_name\":\"Premier Soap\",\"product_barcode\":\"100000000009\",\"quantity\":\"1.00\",\"unit_price\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"700.00\",\"created_at\":\"2026-09-04T09:17:39.000000Z\",\"updated_at\":\"2026-09-04T09:17:39.000000Z\"}],\"payments\":[{\"id\":30,\"company_id\":1,\"branch_id\":2,\"order_id\":75,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"752.50\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-04T09:17:39.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000025\",\"created_at\":\"2026-09-04T09:17:39.000000Z\",\"updated_at\":\"2026-09-04T09:17:39.000000Z\"}],\"invoice\":{\"id\":29,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":75,\"customer_id\":null,\"invoice_no\":\"INV-000023\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"700.00\",\"discount\":\"0.00\",\"tax\":\"52.50\",\"total\":\"700.00\",\"amount_paid\":\"752.50\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"752.50\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:17:39.000000Z\",\"updated_at\":\"2026-09-04T09:17:39.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(335, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000037 completed.', 'Order', 76, NULL, '{\"id\":76,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000037\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"645.00\",\"total\":\"8600.00\",\"amount_paid\":\"9245.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"9245.00\",\"completed_at\":\"2026-09-04T09:19:05.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:19:05.000000Z\",\"updated_at\":\"2026-09-04T09:19:05.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":101,\"company_id\":1,\"order_id\":76,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"product_barcode\":\"100000000010\",\"quantity\":\"1.00\",\"unit_price\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"8600.00\",\"created_at\":\"2026-09-04T09:19:05.000000Z\",\"updated_at\":\"2026-09-04T09:19:05.000000Z\"}],\"payments\":[{\"id\":31,\"company_id\":1,\"branch_id\":2,\"order_id\":76,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"9245.00\",\"payment_status\":\"Completed\",\"payment_method_id\":3,\"payment_method\":\"Transfer\",\"payment_date\":\"2026-09-04T09:19:05.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"yr83839929\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000026\",\"created_at\":\"2026-09-04T09:19:05.000000Z\",\"updated_at\":\"2026-09-04T09:19:05.000000Z\"}],\"invoice\":{\"id\":30,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":76,\"customer_id\":null,\"invoice_no\":\"INV-000024\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"645.00\",\"total\":\"8600.00\",\"amount_paid\":\"9245.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"9245.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:19:05.000000Z\",\"updated_at\":\"2026-09-04T09:19:05.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:19:05', '2026-09-04 08:19:05'),
(336, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000038 completed.', 'Order', 77, NULL, '{\"id\":77,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000038\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-09-04T09:22:48.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:22:48.000000Z\",\"updated_at\":\"2026-09-04T09:22:48.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":102,\"company_id\":1,\"order_id\":77,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-04T09:22:48.000000Z\",\"updated_at\":\"2026-09-04T09:22:48.000000Z\"}],\"payments\":[{\"id\":32,\"company_id\":1,\"branch_id\":2,\"order_id\":77,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_method_id\":8,\"payment_method\":\"Card\",\"payment_date\":\"2026-09-04T09:22:48.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"card-2039393030\",\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000027\",\"created_at\":\"2026-09-04T09:22:48.000000Z\",\"updated_at\":\"2026-09-04T09:22:48.000000Z\"}],\"invoice\":{\"id\":31,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":77,\"customer_id\":null,\"invoice_no\":\"INV-000025\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:22:48.000000Z\",\"updated_at\":\"2026-09-04T09:22:48.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:22:48', '2026-09-04 08:22:48'),
(337, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000039 completed.', 'Order', 78, NULL, '{\"id\":78,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000039\",\"customer_id\":10,\"cashier_id\":15,\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"645.00\",\"total\":\"8600.00\",\"amount_paid\":\"9245.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"5.00\",\"grand_total\":\"9245.00\",\"completed_at\":\"2026-09-04T09:57:18.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:57:18.000000Z\",\"updated_at\":\"2026-09-04T09:57:18.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":103,\"company_id\":1,\"order_id\":78,\"product_id\":10,\"product_name\":\"Pampers Size 3\",\"product_barcode\":\"100000000010\",\"quantity\":\"1.00\",\"unit_price\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"8600.00\",\"created_at\":\"2026-09-04T09:57:18.000000Z\",\"updated_at\":\"2026-09-04T09:57:18.000000Z\"}],\"payments\":[{\"id\":33,\"company_id\":1,\"branch_id\":2,\"order_id\":78,\"customer_id\":10,\"terminal_id\":14,\"amount\":\"9245.00\",\"payment_status\":\"Completed\",\"payment_method_id\":1,\"payment_method\":\"Cash\",\"payment_date\":\"2026-09-04T09:57:18.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":null,\"remarks\":null,\"received_by\":15,\"payment_number\":\"PAY-000028\",\"created_at\":\"2026-09-04T09:57:18.000000Z\",\"updated_at\":\"2026-09-04T09:57:18.000000Z\"}],\"invoice\":{\"id\":32,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":78,\"customer_id\":10,\"invoice_no\":\"INV-000026\",\"invoice_date\":\"2026-09-04T00:00:00.000000Z\",\"subtotal\":\"8600.00\",\"discount\":\"0.00\",\"tax\":\"645.00\",\"total\":\"8600.00\",\"amount_paid\":\"9245.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"9245.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-04T09:57:18.000000Z\",\"updated_at\":\"2026-09-04T09:57:18.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-04 08:57:18', '2026-09-04 08:57:18');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(338, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 7, '{\"id\":7,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"22340.00\",\"cash_sales\":\"11502.50\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"33842.50\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-04T08:06:06.000000Z\",\"closed_at\":null,\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-04T08:06:06.000000Z\",\"updated_at\":\"2026-09-04T09:57:18.000000Z\"}', '{\"id\":7,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"22340.00\",\"cash_sales\":\"11502.50\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"33842.50\",\"actual_balance\":\"33842.50\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-09-04T08:06:06.000000Z\",\"closed_at\":\"2026-09-12T22:08:10.000000Z\",\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-04T08:06:06.000000Z\",\"updated_at\":\"2026-09-12T22:08:10.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/7/close', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-12 21:08:10', '2026-09-12 21:08:10'),
(339, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 8, NULL, '{\"id\":8,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"34350.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"34350.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-12T22:33:16.000000Z\",\"closed_at\":null,\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-12T22:33:16.000000Z\",\"updated_at\":\"2026-09-12T22:33:16.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-12 21:33:16', '2026-09-12 21:33:16'),
(340, 1, 2, 15, 'cash_drawer', 'Closed', 'Closed cash drawer.', 'CashDrawer', 8, '{\"id\":8,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":15,\"closed_by\":null,\"opening_balance\":\"34350.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"34350.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-12T22:33:16.000000Z\",\"closed_at\":null,\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-12T22:33:16.000000Z\",\"updated_at\":\"2026-09-12T22:33:16.000000Z\"}', '{\"id\":8,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"opening_balance\":\"34350.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"34350.00\",\"actual_balance\":\"34350.00\",\"variance\":\"0.00\",\"status\":\"Closed\",\"opened_at\":\"2026-09-12T22:33:16.000000Z\",\"closed_at\":\"2026-09-12T23:06:56.000000Z\",\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-12T22:33:16.000000Z\",\"updated_at\":\"2026-09-12T23:06:56.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/8/close', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-12 22:06:56', '2026-09-12 22:06:56'),
(341, 1, 2, 15, 'cash_drawer', 'Opened', 'Opened cash drawer.', 'CashDrawer', 9, NULL, '{\"id\":9,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"opened_by\":{\"id\":15,\"company_id\":1,\"branch_id\":2,\"role_id\":5,\"employee_no\":\"CH-2026-001\",\"first_name\":\"Paul\",\"other_name\":\"Olusogo\",\"last_name\":\"Awolola\",\"username\":\"paul\",\"email\":\"bizcare@gmail.com\",\"is_owner\":false,\"email_verified_at\":null,\"two_factor_enabled\":false,\"phone\":\"07038899203\",\"profile_photo\":null,\"gender\":\"Male\",\"date_of_birth\":\"1987-11-25T00:00:00.000000Z\",\"employment_date\":\"2026-07-06T00:00:00.000000Z\",\"address\":\"Adelu, Ido, Ibadan.\",\"notes\":\"Transfered from Ajah branch\",\"status\":true,\"last_login_at\":null,\"last_activity_at\":null,\"last_login_ip\":null,\"force_password_change\":true,\"password_changed_at\":null,\"created_at\":\"2026-07-30T01:35:56.000000Z\",\"updated_at\":\"2026-08-30T17:02:34.000000Z\",\"deleted_at\":null},\"closed_by\":null,\"opening_balance\":\"12320.00\",\"cash_sales\":\"0.00\",\"cash_in\":\"0.00\",\"cash_out\":\"0.00\",\"cash_refunds\":\"0.00\",\"expected_balance\":\"12320.00\",\"actual_balance\":\"0.00\",\"variance\":\"0.00\",\"status\":\"Open\",\"opened_at\":\"2026-09-14T14:30:09.000000Z\",\"closed_at\":null,\"opening_remarks\":null,\"closing_remarks\":null,\"created_at\":\"2026-09-14T14:30:09.000000Z\",\"updated_at\":\"2026-09-14T14:30:09.000000Z\",\"branch\":{\"id\":2,\"company_id\":1,\"branch_code\":\"BR002\",\"name\":\"Lekki Branch\",\"phone\":\"08087654321\",\"email\":\"lekki@emmanexitconsult.com\",\"address\":\"Lekki, Lagos\",\"is_head_office\":false,\"status\":true,\"created_at\":\"2026-07-29T11:37:09.000000Z\",\"updated_at\":\"2026-07-29T11:37:09.000000Z\",\"deleted_at\":null},\"terminal\":{\"id\":14,\"company_id\":1,\"branch_id\":2,\"terminal_code\":\"Lek-Pos3\",\"terminal_name\":\"Lekki-Pos3\",\"description\":null,\"device_name\":\"Desktop POS\",\"ip_address\":null,\"status\":true,\"last_seen_at\":null,\"created_at\":\"2026-08-30T16:20:14.000000Z\",\"updated_at\":\"2026-08-30T16:20:14.000000Z\",\"deleted_at\":null}}', 'cash-drawer/open', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-14 13:30:09', '2026-09-14 13:30:09'),
(342, 1, 2, 15, 'pos', 'sale_completed', 'POS sale ORD-000040 completed.', 'Order', 79, NULL, '{\"id\":79,\"company_id\":1,\"branch_id\":2,\"order_no\":\"ORD-000040\",\"customer_id\":null,\"cashier_id\":15,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1290.00\",\"completed_at\":\"2026-09-14T14:30:52.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":14,\"receipt_printed\":false,\"remarks\":\"1290\",\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-14T14:30:52.000000Z\",\"updated_at\":\"2026-09-14T14:30:52.000000Z\",\"deleted_at\":null,\"order_items\":[{\"id\":104,\"company_id\":1,\"order_id\":79,\"product_id\":19,\"product_name\":\"Three Crown Evaporated Milk\",\"product_barcode\":\"TH123456\",\"quantity\":\"1.00\",\"unit_price\":\"1200.00\",\"unit_cost\":\"1000.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"created_at\":\"2026-09-14T14:30:52.000000Z\",\"updated_at\":\"2026-09-14T14:30:52.000000Z\"}],\"payments\":[{\"id\":34,\"company_id\":1,\"branch_id\":2,\"order_id\":79,\"customer_id\":null,\"terminal_id\":14,\"amount\":\"1290.00\",\"payment_status\":\"Completed\",\"payment_method_id\":3,\"payment_method\":\"Transfer\",\"payment_date\":\"2026-09-14T14:30:52.000000Z\",\"transaction_reference\":null,\"payment_gateway\":null,\"reference_no\":\"yr8df345\",\"remarks\":\"1290\",\"received_by\":15,\"payment_number\":\"PAY-000029\",\"created_at\":\"2026-09-14T14:30:52.000000Z\",\"updated_at\":\"2026-09-14T14:30:52.000000Z\"}],\"invoice\":{\"id\":33,\"company_id\":1,\"branch_id\":2,\"terminal_id\":14,\"order_id\":79,\"customer_id\":null,\"invoice_no\":\"INV-000027\",\"invoice_date\":\"2026-09-14T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"90.00\",\"total\":\"1200.00\",\"amount_paid\":\"1290.00\",\"balance\":\"0.00\",\"total_quantity\":\"1.00\",\"total_items\":1,\"grand_total\":\"1290.00\",\"payment_status\":\"Paid\",\"invoice_status\":\"Active\",\"remarks\":\"1290\",\"created_by\":15,\"updated_by\":15,\"created_at\":\"2026-09-14T14:30:52.000000Z\",\"updated_at\":\"2026-09-14T14:30:52.000000Z\",\"deleted_at\":null}}', 'pos/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-14 13:30:52', '2026-09-14 13:30:52'),
(343, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000041', 'Order', 80, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"cashier_id\":1,\"order_no\":\"ORD-000041\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-14T14:32:47.000000Z\",\"created_at\":\"2026-09-14T14:32:47.000000Z\",\"id\":80}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-14 13:32:47', '2026-09-14 13:32:47'),
(344, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000028', 'Invoice', 34, NULL, '{\"company_id\":1,\"branch_id\":4,\"terminal_id\":12,\"customer_id\":9,\"order_id\":80,\"invoice_no\":\"INV-000028\",\"invoice_date\":\"2026-09-14T00:00:00.000000Z\",\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"grand_total\":\"1200.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-14T14:32:47.000000Z\",\"created_at\":\"2026-09-14T14:32:47.000000Z\",\"id\":34}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-14 13:32:47', '2026-09-14 13:32:47'),
(345, 1, 1, 1, 'sales_orders', 'Completed', 'Completed sales order: ORD-000041', 'Order', 80, '{\"id\":80,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000041\",\"customer_id\":9,\"cashier_id\":1,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"0.00\",\"balance\":\"1200.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-09-14T14:32:47.000000Z\",\"updated_at\":\"2026-09-14T14:32:47.000000Z\",\"deleted_at\":null}', '{\"id\":80,\"company_id\":1,\"branch_id\":4,\"order_no\":\"ORD-000041\",\"customer_id\":9,\"cashier_id\":1,\"subtotal\":\"1200.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"1200.00\",\"amount_paid\":\"1200.00\",\"balance\":\"0.00\",\"total_items\":1,\"total_quantity\":\"1.00\",\"change_given\":\"0.00\",\"grand_total\":\"1200.00\",\"completed_at\":\"2026-09-14T14:38:08.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":12,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-09-14T14:32:47.000000Z\",\"updated_at\":\"2026-09-14T14:38:08.000000Z\",\"deleted_at\":null}', 'sales/orders/80/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-14 13:38:08', '2026-09-14 13:38:08'),
(346, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000042', 'Order', 81, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":1,\"customer_id\":6,\"cashier_id\":1,\"order_no\":\"ORD-000042\",\"subtotal\":\"3350.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"3350.00\",\"amount_paid\":\"0.00\",\"balance\":\"3350.00\",\"total_items\":3,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"3350.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-16T11:39:51.000000Z\",\"created_at\":\"2026-09-16T11:39:51.000000Z\",\"id\":81}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(347, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000029', 'Invoice', 35, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":1,\"customer_id\":6,\"order_id\":81,\"invoice_no\":\"INV-000029\",\"invoice_date\":\"2026-09-16T00:00:00.000000Z\",\"subtotal\":\"3350.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"3350.00\",\"amount_paid\":\"0.00\",\"balance\":\"3350.00\",\"total_items\":3,\"total_quantity\":\"4.00\",\"grand_total\":\"3350.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-16T11:39:51.000000Z\",\"created_at\":\"2026-09-16T11:39:51.000000Z\",\"id\":35}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(348, 1, 1, 1, 'sales_orders', 'Completed', 'Completed sales order: ORD-000042', 'Order', 81, '{\"id\":81,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000042\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"3350.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"3350.00\",\"amount_paid\":\"0.00\",\"balance\":\"3350.00\",\"total_items\":3,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"3350.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-09-16T11:39:51.000000Z\",\"updated_at\":\"2026-09-16T11:39:51.000000Z\",\"deleted_at\":null}', '{\"id\":81,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000042\",\"customer_id\":6,\"cashier_id\":1,\"subtotal\":\"3350.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"3350.00\",\"amount_paid\":\"3350.00\",\"balance\":\"0.00\",\"total_items\":3,\"total_quantity\":\"4.00\",\"change_given\":\"0.00\",\"grand_total\":\"3350.00\",\"completed_at\":\"2026-09-16T11:40:05.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":1,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-09-16T11:39:51.000000Z\",\"updated_at\":\"2026-09-16T11:40:05.000000Z\",\"deleted_at\":null}', 'sales/orders/81/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 10:40:05', '2026-09-16 10:40:05'),
(349, 1, 1, 1, 'orders', 'create', 'Created sales order: ORD-000043', 'Order', 82, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":2,\"customer_id\":null,\"cashier_id\":1,\"order_no\":\"ORD-000043\",\"subtotal\":\"10500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"10500.00\",\"amount_paid\":\"0.00\",\"balance\":\"10500.00\",\"total_items\":4,\"total_quantity\":\"10.00\",\"change_given\":\"0.00\",\"grand_total\":\"10500.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-16T13:02:21.000000Z\",\"created_at\":\"2026-09-16T13:02:21.000000Z\",\"id\":82}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(350, 1, 1, 1, 'invoices', 'create', 'Created invoice: INV-000030', 'Invoice', 36, NULL, '{\"company_id\":1,\"branch_id\":1,\"terminal_id\":2,\"customer_id\":null,\"order_id\":82,\"invoice_no\":\"INV-000030\",\"invoice_date\":\"2026-09-16T00:00:00.000000Z\",\"subtotal\":\"10500.00\",\"discount\":\"0.00\",\"tax\":\"0.00\",\"total\":\"10500.00\",\"amount_paid\":\"0.00\",\"balance\":\"10500.00\",\"total_items\":4,\"total_quantity\":\"10.00\",\"grand_total\":\"10500.00\",\"payment_status\":\"Pending\",\"invoice_status\":\"Active\",\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"updated_at\":\"2026-09-16T13:02:21.000000Z\",\"created_at\":\"2026-09-16T13:02:21.000000Z\",\"id\":36}', 'sales/orders', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(351, 1, 1, 1, 'sales_orders', 'Completed', 'Completed sales order: ORD-000043', 'Order', 82, '{\"id\":82,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000043\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"10500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"10500.00\",\"amount_paid\":\"0.00\",\"balance\":\"10500.00\",\"total_items\":4,\"total_quantity\":\"10.00\",\"change_given\":\"0.00\",\"grand_total\":\"10500.00\",\"completed_at\":null,\"payment_status\":\"Pending\",\"order_status\":\"Draft\",\"sales_channel\":\"POS\",\"terminal_id\":2,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2026-09-16T13:02:21.000000Z\",\"updated_at\":\"2026-09-16T13:02:21.000000Z\",\"deleted_at\":null}', '{\"id\":82,\"company_id\":1,\"branch_id\":1,\"order_no\":\"ORD-000043\",\"customer_id\":null,\"cashier_id\":1,\"subtotal\":\"10500.00\",\"discount\":\"0.00\",\"discount_id\":null,\"tax_rate_id\":null,\"tax\":\"0.00\",\"total\":\"10500.00\",\"amount_paid\":\"10500.00\",\"balance\":\"0.00\",\"total_items\":4,\"total_quantity\":\"10.00\",\"change_given\":\"0.00\",\"grand_total\":\"10500.00\",\"completed_at\":\"2026-09-16T13:02:34.000000Z\",\"payment_status\":\"Paid\",\"order_status\":\"Completed\",\"sales_channel\":\"POS\",\"terminal_id\":2,\"receipt_printed\":false,\"remarks\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-09-16T13:02:21.000000Z\",\"updated_at\":\"2026-09-16T13:02:34.000000Z\",\"deleted_at\":null}', 'sales/orders/82/complete', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:02:34', '2026-09-16 12:02:34'),
(352, 1, 1, 1, 'sales_returns', 'create', 'Full refund processed for sales order: ORD-000043', 'SalesReturn', 2, NULL, '{\"return_number\":\"RET-000002\",\"order_id\":82,\"refund_amount\":10500,\"return_type\":\"Full\"}', 'sales/returns/orders/82/process', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(353, 1, 1, 1, 'sales_returns', 'partial_return', 'Processed partial return RET-000003 for sales order ORD-000042. Refund amount: 1,900.00. Returned quantity: 2.00.', 'SalesReturn', 3, NULL, '{\"refund_amount\":1900,\"returned_cogs\":1630,\"returned_quantity\":2,\"fully_returned\":false}', 'sales/returns/orders/81/partial', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(354, 1, 1, 1, 'sales_returns', 'partial_return', 'Processed partial return RET-000004 for sales order ORD-000042. Refund amount: 250.00. Returned quantity: 1.00.', 'SalesReturn', 4, NULL, '{\"refund_amount\":250,\"returned_cogs\":180,\"returned_quantity\":1,\"fully_returned\":false}', 'sales/returns/orders/81/partial', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:18:22', '2026-09-16 12:18:22'),
(355, 1, 1, 1, 'Stock', 'Updated', 'Stock adjusted for product ID 19 at branch ID 1', 'ProductStock', 13, '{\"quantity\":\"1605.00\"}', '{\"quantity\":1600}', 'stock', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:34:45', '2026-09-16 12:34:45'),
(356, 1, 1, 1, 'Stock', 'Updated', 'Stock adjusted for product ID 1 at branch ID 1', 'ProductStock', 1, '{\"quantity\":\"980.00\"}', '{\"quantity\":975.02}', 'stock', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-16 12:46:46', '2026-09-16 12:46:46'),
(357, 4, 11, 20, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 2, '{\"id\":2,\"company_id\":4,\"company_name\":\"JustRite Mart\",\"company_email\":\"justritemart@gmail.com\",\"company_phone\":\"08012345678\",\"company_address\":\"12, Alakia, Off New Ife Road.\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":null,\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"d-m-Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-09-17T13:10:35.000000Z\",\"updated_at\":\"2026-09-17T13:10:35.000000Z\"}', '{\"id\":2,\"company_id\":4,\"company_name\":\"JustRite Mart\",\"company_email\":\"justritemart@gmail.com\",\"company_phone\":\"08012345678\",\"company_address\":\"12, Alakia, Off New Ife Road.\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":null,\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"d\\/m\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-09-17T13:10:35.000000Z\",\"updated_at\":\"2026-09-17T13:18:37.000000Z\"}', 'settings/general', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-17 12:18:37', '2026-09-17 12:18:37'),
(358, 4, 11, 20, 'Settings Management', 'Updated', 'Updated company settings', 'Setting', 2, '{\"id\":2,\"company_id\":4,\"company_name\":\"JustRite Mart\",\"company_email\":\"justritemart@gmail.com\",\"company_phone\":\"08012345678\",\"company_address\":\"12, Alakia, Off New Ife Road.\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":null,\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":null,\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"d\\/m\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-09-17T13:10:35.000000Z\",\"updated_at\":\"2026-09-17T13:18:37.000000Z\"}', '{\"id\":2,\"company_id\":4,\"company_name\":\"JustRite Mart\",\"company_email\":\"justritemart@gmail.com\",\"company_phone\":\"08012345678\",\"company_address\":\"12, Alakia, Off New Ife Road.\",\"company_logo\":null,\"currency\":\"NGN\",\"currency_symbol\":\"\\u20a6\",\"tax_rate\":\"7.50\",\"tax_enabled\":true,\"receipt_footer\":\"Thank you for shopping with us.\",\"receipt_header\":\"JustRite Mart\",\"receipt_width\":80,\"print_logo\":true,\"print_barcode\":false,\"allow_negative_stock\":false,\"low_stock_alert\":10,\"allow_price_change\":0,\"allow_price_override\":false,\"enable_discounts\":1,\"allow_discount\":true,\"enable_customer_credit\":false,\"default_customer\":null,\"default_customer_id\":null,\"timezone\":\"Africa\\/Lagos\",\"date_format\":\"d\\/m\\/Y\",\"time_format\":\"h:i A\",\"maintenance_mode\":false,\"status\":true,\"created_at\":\"2026-09-17T13:10:35.000000Z\",\"updated_at\":\"2026-09-17T13:18:53.000000Z\"}', 'settings/general', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-17 12:18:53', '2026-09-17 12:18:53'),
(359, 4, 11, 20, 'Units', 'Created', 'Created unit: Piece', 'Unit', 15, NULL, NULL, 'units', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 08:58:45', '2026-09-21 08:58:45'),
(360, 4, 11, 20, 'Product Categories', 'Created', 'Created product category: Dairy', 'ProductCategory', 15, NULL, '{\"id\":15,\"company_id\":4,\"category_code\":\"CAT000001\",\"name\":\"Dairy\",\"description\":\"Dairy\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":20,\"updated_by\":20,\"created_at\":\"2026-09-21T10:22:40.000000Z\",\"updated_at\":\"2026-09-21T10:22:40.000000Z\",\"deleted_at\":null}', 'product-categories', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 09:22:40', '2026-09-21 09:22:40'),
(361, 4, 11, 20, 'Discounts', 'Created', 'Created discount: None', 'Discount', 6, NULL, NULL, 'discounts', 'POST', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Mobile Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 09:24:17', '2026-09-21 09:24:17'),
(362, 4, 11, 20, 'Products', 'Imported', '1 product(s) imported successfully.', NULL, NULL, NULL, '{\"company_id\":4,\"count\":1,\"products\":[{\"id\":20,\"product_code\":\"PRD-000001\",\"name\":\"Three Crown\",\"sku\":\"SKU-0001\"}]}', 'products/import', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 11:55:14', '2026-09-21 11:55:14'),
(363, 4, 11, 20, 'Products', 'Updated', 'Updated product: Three Crown', 'Product', 20, '{\"id\":20,\"company_id\":4,\"product_category_id\":15,\"product_code\":\"PRD-000001\",\"barcode\":\"12345\",\"sku\":\"SKU-0001\",\"qr_code\":\"QR-0001\",\"name\":\"Three Crown\",\"description\":\"Three Crown\",\"image\":null,\"cost_price\":\"5000.00\",\"selling_price\":\"7500.00\",\"discount_id\":6,\"unit_id\":15,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"expiry_date\":\"2027-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"100.00\",\"weight\":\"0.50\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-09-21T12:55:14.000000Z\",\"updated_at\":\"2026-09-21T12:55:14.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":20,\"company_id\":4,\"product_category_id\":15,\"product_code\":\"PRD-000001\",\"barcode\":\"12345\",\"sku\":\"SKU-0001\",\"qr_code\":\"QR-0001\",\"name\":\"Three Crown\",\"description\":\"Three Crown\",\"image\":\"1789995718_6ab12ac629c4e.png\",\"cost_price\":\"5000.00\",\"selling_price\":\"7500.00\",\"discount_id\":6,\"unit_id\":15,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Three Crown\",\"manufacturer\":\"Three Crown Ltd\",\"expiry_date\":\"2027-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"100.00\",\"weight\":\"0.50\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-09-21T12:55:14.000000Z\",\"updated_at\":\"2026-09-21T13:01:58.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/20', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 12:01:58', '2026-09-21 12:01:58'),
(364, 4, 11, 20, 'Product Categories', 'Created', 'Created product category: Groceries', 'ProductCategory', 16, NULL, '{\"id\":16,\"company_id\":4,\"category_code\":\"CAT000002\",\"name\":\"Groceries\",\"description\":\"Groceries\",\"parent_id\":null,\"image\":null,\"sort_order\":0,\"status\":true,\"created_by\":20,\"updated_by\":20,\"created_at\":\"2026-09-21T13:09:24.000000Z\",\"updated_at\":\"2026-09-21T13:09:24.000000Z\",\"deleted_at\":null}', 'product-categories', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 12:09:24', '2026-09-21 12:09:24'),
(365, 4, 11, 20, 'Products', 'Imported', '1 product(s) imported successfully.', NULL, NULL, NULL, '{\"company_id\":4,\"count\":1,\"products\":[{\"id\":21,\"product_code\":\"PRD-000002\",\"name\":\"Dangote Sugar 1kg\",\"sku\":\"SKU-0002\"}]}', 'products/import', 'POST', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 12:09:46', '2026-09-21 12:09:46'),
(366, 4, 11, 20, 'Products', 'Updated', 'Updated product: Dangote Sugar 1kg', 'Product', 21, '{\"id\":21,\"company_id\":4,\"product_category_id\":16,\"product_code\":\"PRD-000002\",\"barcode\":\"452345\",\"sku\":\"SKU-0002\",\"qr_code\":\"QR-0002\",\"name\":\"Dangote Sugar 1kg\",\"description\":\"Dangote Sugar 1kg\",\"image\":null,\"cost_price\":\"180.00\",\"selling_price\":\"250.00\",\"discount_id\":6,\"unit_id\":15,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":\"2027-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"100.00\",\"weight\":\"0.50\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-09-21T13:09:46.000000Z\",\"updated_at\":\"2026-09-21T13:09:46.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', '{\"id\":21,\"company_id\":4,\"product_category_id\":16,\"product_code\":\"PRD-000002\",\"barcode\":\"452345\",\"sku\":\"SKU-0002\",\"qr_code\":\"QR-0002\",\"name\":\"Dangote Sugar 1kg\",\"description\":\"Dangote Sugar 1kg\",\"image\":\"1789996254_6ab12cde96345.jpeg\",\"cost_price\":\"180.00\",\"selling_price\":\"250.00\",\"discount_id\":6,\"unit_id\":15,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":\"2027-12-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":null,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"100.00\",\"weight\":\"0.50\",\"dimensions\":null,\"created_by\":null,\"updated_by\":null,\"created_at\":\"2026-09-21T13:09:46.000000Z\",\"updated_at\":\"2026-09-21T13:10:54.000000Z\",\"deleted_at\":null,\"reorder_level\":\"0.00\"}', 'products/21', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-21 12:10:54', '2026-09-21 12:10:54'),
(367, 1, 1, 1, 'Products', 'Updated', 'Updated product: Coca-Cola 50cl', 'Product', 1, '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-23T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T09:53:46.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":1,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000001\",\"barcode\":\"100000000001\",\"sku\":\"COKE50CL\",\"qr_code\":null,\"name\":\"Coca-Cola 50cl\",\"description\":null,\"image\":\"1790543689_6ab98749371c7.jpg\",\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Coca-Cola\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-23T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2000.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:14:49.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/1', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:14:49', '2026-09-27 20:14:49'),
(368, 1, 1, 1, 'Products', 'Updated', 'Updated product: Fanta 50cl', 'Product', 2, '{\"id\":2,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000002\",\"barcode\":\"100000000002\",\"sku\":\"FANTA50CL\",\"qr_code\":null,\"name\":\"Fanta 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Fanta\",\"manufacturer\":\"NBC\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2100.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:55:45.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":2,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000002\",\"barcode\":\"100000000002\",\"sku\":\"FANTA50CL\",\"qr_code\":null,\"name\":\"Fanta 50cl\",\"description\":null,\"image\":\"1790543985_6ab9887108da1.jpeg\",\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Fanta\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-27T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"2100.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:19:45.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/2', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:19:45', '2026-09-27 20:19:45'),
(369, 1, 1, 1, 'Products', 'Updated', 'Updated product: Sprite 50cl', 'Product', 3, '{\"id\":3,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000003\",\"barcode\":\"100000000003\",\"sku\":\"SPRITE50CL\",\"qr_code\":null,\"name\":\"Sprite 50cl\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Sprite\",\"manufacturer\":\"NBC\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":3,\"company_id\":1,\"product_category_id\":1,\"product_code\":\"PRD000003\",\"barcode\":\"100000000003\",\"sku\":\"SPRITE50CL\",\"qr_code\":null,\"name\":\"Sprite 50cl\",\"description\":null,\"image\":\"1790544002_6ab9888210fe1.jpeg\",\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Sprite\",\"manufacturer\":\"NBC\",\"expiry_date\":\"2026-09-27T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:20:02.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/3', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:20:02', '2026-09-27 20:20:02'),
(370, 1, 1, 1, 'Products', 'Updated', 'Updated product: Peak Milk 500g', 'Product', 4, '{\"id\":4,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000004\",\"barcode\":\"100000000004\",\"sku\":\"PEAK500\",\"qr_code\":null,\"name\":\"Peak Milk 500g\",\"description\":\"Peak Milk 500g\",\"image\":null,\"cost_price\":\"4200.00\",\"selling_price\":\"4800.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Peak\",\"manufacturer\":\"FrieslandCampina\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-09T17:32:26.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":4,\"company_id\":1,\"product_category_id\":5,\"product_code\":\"PRD000004\",\"barcode\":\"100000000004\",\"sku\":\"PEAK500\",\"qr_code\":null,\"name\":\"Peak Milk 500g\",\"description\":\"Peak Milk 500g\",\"image\":\"1790544024_6ab988982f02b.jpeg\",\"cost_price\":\"4200.00\",\"selling_price\":\"4800.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Peak\",\"manufacturer\":\"FrieslandCampina\",\"expiry_date\":\"2030-10-27T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:20:24.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/4', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:20:24', '2026-09-27 20:20:24'),
(371, 1, 1, 1, 'Products', 'Updated', 'Updated product: Indomie Chicken Noodles', 'Product', 5, '{\"id\":5,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000005\",\"barcode\":\"100000000005\",\"sku\":\"INDM70\",\"qr_code\":null,\"name\":\"Indomie Chicken Noodles\",\"description\":null,\"image\":null,\"cost_price\":\"180.00\",\"selling_price\":\"250.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Indomie\",\"manufacturer\":\"Dufil\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":5,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000005\",\"barcode\":\"100000000005\",\"sku\":\"INDM70\",\"qr_code\":null,\"name\":\"Indomie Chicken Noodles\",\"description\":null,\"image\":\"1790544043_6ab988ab3d54f.jpeg\",\"cost_price\":\"180.00\",\"selling_price\":\"250.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Indomie\",\"manufacturer\":\"Dufil\",\"expiry_date\":\"2029-10-25T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:20:43.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/5', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:20:43', '2026-09-27 20:20:43');
INSERT INTO `activity_logs` (`id`, `company_id`, `branch_id`, `user_id`, `module`, `action`, `description`, `record_type`, `record_id`, `old_values`, `new_values`, `url`, `method`, `user_agent`, `terminal_id`, `ip_address`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(372, 1, 1, 1, 'Products', 'Updated', 'Updated product: Dangote Sugar 1kg', 'Product', 6, '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":null,\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1595.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T13:50:47.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":6,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000006\",\"barcode\":\"100000000006\",\"sku\":\"SUG1KG\",\"qr_code\":null,\"name\":\"Dangote Sugar 1kg\",\"description\":null,\"image\":\"1790544062_6ab988bedab7b.jpeg\",\"cost_price\":\"1450.00\",\"selling_price\":\"1650.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Dangote\",\"manufacturer\":\"Dangote\",\"expiry_date\":\"2030-09-26T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1595.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:21:02.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:21:02', '2026-09-27 20:21:02'),
(373, 1, 1, 1, 'Products', 'Updated', 'Updated product: Family Bread', 'Product', 7, '{\"id\":7,\"company_id\":1,\"product_category_id\":3,\"product_code\":\"PRD000007\",\"barcode\":\"100000000007\",\"sku\":\"BREAD001\",\"qr_code\":null,\"name\":\"Family Bread\",\"description\":null,\"image\":null,\"cost_price\":\"900.00\",\"selling_price\":\"1200.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Local\",\"manufacturer\":\"Bakery\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":7,\"company_id\":1,\"product_category_id\":3,\"product_code\":\"PRD000007\",\"barcode\":\"100000000007\",\"sku\":\"BREAD001\",\"qr_code\":null,\"name\":\"Family Bread\",\"description\":null,\"image\":\"1790544083_6ab988d35c62a.jpeg\",\"cost_price\":\"900.00\",\"selling_price\":\"1200.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Local\",\"manufacturer\":\"Bakery\",\"expiry_date\":\"2026-10-18T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:21:23.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/7', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:21:23', '2026-09-27 20:21:23'),
(374, 1, 1, 1, 'Products', 'Updated', 'Updated product: Mama Gold Rice 50kg', 'Product', 8, '{\"id\":8,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000008\",\"barcode\":\"100000000008\",\"sku\":\"RICE50KG\",\"qr_code\":null,\"name\":\"Mama Gold Rice 50kg\",\"description\":null,\"image\":null,\"cost_price\":\"82000.00\",\"selling_price\":\"90000.00\",\"discount_id\":1,\"unit_id\":11,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Mama Gold\",\"manufacturer\":\"Mama Gold\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":8,\"company_id\":1,\"product_category_id\":2,\"product_code\":\"PRD000008\",\"barcode\":\"100000000008\",\"sku\":\"RICE50KG\",\"qr_code\":null,\"name\":\"Mama Gold Rice 50kg\",\"description\":null,\"image\":\"1790544101_6ab988e5e3018.jpeg\",\"cost_price\":\"82000.00\",\"selling_price\":\"90000.00\",\"discount_id\":1,\"unit_id\":11,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Mama Gold\",\"manufacturer\":\"Mama Gold\",\"expiry_date\":\"2032-10-31T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:21:41.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/8', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:21:41', '2026-09-27 20:21:41'),
(375, 1, 1, 1, 'Products', 'Updated', 'Updated product: Premier Soap', 'Product', 9, '{\"id\":9,\"company_id\":1,\"product_category_id\":7,\"product_code\":\"PRD000009\",\"barcode\":\"100000000009\",\"sku\":\"SOAP001\",\"qr_code\":null,\"name\":\"Premier Soap\",\"description\":null,\"image\":null,\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Premier\",\"manufacturer\":\"PZ\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-07-29T11:37:13.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":9,\"company_id\":1,\"product_category_id\":7,\"product_code\":\"PRD000009\",\"barcode\":\"100000000009\",\"sku\":\"SOAP001\",\"qr_code\":null,\"name\":\"Premier Soap\",\"description\":null,\"image\":\"1790544120_6ab988f8b0af7.jpg\",\"cost_price\":\"500.00\",\"selling_price\":\"700.00\",\"discount_id\":1,\"unit_id\":1,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Premier\",\"manufacturer\":\"PZ\",\"expiry_date\":\"2028-11-30T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"500.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:22:00.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/9', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:22:00', '2026-09-27 20:22:00'),
(376, 1, 1, 1, 'Products', 'Updated', 'Updated product: Pampers Size 3', 'Product', 10, '{\"id\":10,\"company_id\":1,\"product_category_id\":9,\"product_code\":\"PRD000010\",\"barcode\":\"100000000010\",\"sku\":\"PAMP001\",\"qr_code\":null,\"name\":\"Pampers Size 3\",\"description\":null,\"image\":null,\"cost_price\":\"7800.00\",\"selling_price\":\"8600.00\",\"discount_id\":1,\"unit_id\":2,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Pampers\",\"manufacturer\":\"P&G\",\"expiry_date\":null,\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1085.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-08-22T14:16:04.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', '{\"id\":10,\"company_id\":1,\"product_category_id\":9,\"product_code\":\"PRD000010\",\"barcode\":\"100000000010\",\"sku\":\"PAMP001\",\"qr_code\":null,\"name\":\"Pampers Size 3\",\"description\":null,\"image\":\"1790544154_6ab9891a6b244.jpeg\",\"cost_price\":\"7800.00\",\"selling_price\":\"8600.00\",\"discount_id\":1,\"unit_id\":2,\"shelf_location\":null,\"track_stock\":1,\"brand\":\"Pampers\",\"manufacturer\":\"P&G\",\"expiry_date\":\"2028-10-11T00:00:00.000000Z\",\"taxable\":1,\"tax_rate_id\":2,\"status\":true,\"minimum_stock\":\"10.00\",\"maximum_stock\":\"1085.00\",\"weight\":null,\"dimensions\":null,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-07-29T11:37:13.000000Z\",\"updated_at\":\"2026-09-27T21:22:34.000000Z\",\"deleted_at\":null,\"reorder_level\":\"20.00\"}', 'products/10', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-09-27 20:22:34', '2026-09-27 20:22:34');

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
(2, 1, 'BR002', 'Lekki Branch', '08087654321', 'lekki@emmanexitconsult.com', 'Lekki, Lagos', 0, 1, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(4, 1, 'BR003', 'Ajah Outlet New', '07034657383', 'ajah@emmanexitconsult.com', 'Agbado, Ajah express way, Lagos.', 0, 1, '2026-07-31 14:47:21', '2026-08-01 20:36:13', NULL),
(6, 1, 'BR004', 'Ikorodu Outlet', '07038899203', 'Ikd@emmanexitconsult.com', 'Odogunyan, Ikorodu, Lagos.', 0, 1, '2026-07-31 14:52:50', '2026-08-01 21:41:51', NULL),
(11, 4, 'BR789649', 'Head Office', '08012345678', 'justritemart@gmail.com', '12, Alakia, Off New Ife Road.', 1, 1, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(12, 5, 'BR818641', 'Head Office', '08104196102', 'gadgetpadi@gmail.com', 'Ibadan', 1, 1, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL);

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

--
-- Dumping data for table `cash_drawers`
--

INSERT INTO `cash_drawers` (`id`, `company_id`, `branch_id`, `terminal_id`, `opened_by`, `closed_by`, `opening_balance`, `cash_sales`, `cash_in`, `cash_out`, `cash_refunds`, `expected_balance`, `actual_balance`, `variance`, `status`, `opened_at`, `closed_at`, `opening_remarks`, `closing_remarks`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 14, 15, 15, 50920.00, 0.00, 0.00, 0.00, 0.00, 50920.00, 50920.00, 0.00, 'Closed', '2026-08-31 12:03:30', '2026-08-31 12:14:15', 'I opened the drawer as at 11am with exactly 50,920', 'I closed the drawer as at 8pm with exactly 50920 confirl by my manager', '2026-08-31 12:03:30', '2026-08-31 12:14:15'),
(4, 1, 2, 14, 15, 15, 52335.00, 0.00, 15000.00, 5000.00, 0.00, 62335.00, 62335.00, 0.00, 'Closed', '2026-08-31 12:15:28', '2026-09-02 04:05:18', 'I opened the drawer with 52335 at exactly 2pm', NULL, '2026-08-31 12:15:28', '2026-09-02 04:05:18'),
(5, 1, 2, 14, 15, 15, 41320.00, 0.00, 0.00, 0.00, 0.00, 41320.00, 41320.00, 0.00, 'Closed', '2026-09-02 09:44:52', '2026-09-03 11:26:16', 'Opened the drawer with 41,320 as at 11am', NULL, '2026-09-02 09:44:52', '2026-09-03 11:26:16'),
(6, 1, 2, 14, 15, 15, 23250.00, 107600.00, 5000.00, 2500.00, 0.00, 133350.00, 133350.00, 0.00, 'Closed', '2026-09-03 11:27:46', '2026-09-04 07:05:50', 'I met 23,250 in the drawer as at 10am today.', NULL, '2026-09-03 11:27:46', '2026-09-04 07:05:50'),
(7, 1, 2, 14, 15, 15, 22340.00, 11502.50, 0.00, 0.00, 0.00, 33842.50, 33842.50, 0.00, 'Closed', '2026-09-04 07:06:06', '2026-09-12 21:08:10', NULL, NULL, '2026-09-04 07:06:06', '2026-09-12 21:08:10'),
(8, 1, 2, 14, 15, 15, 34350.00, 0.00, 0.00, 0.00, 0.00, 34350.00, 34350.00, 0.00, 'Closed', '2026-09-12 21:33:16', '2026-09-12 22:06:56', NULL, NULL, '2026-09-12 21:33:16', '2026-09-12 22:06:56'),
(9, 1, 2, 14, 15, NULL, 12320.00, 0.00, 0.00, 0.00, 0.00, 12320.00, 0.00, 0.00, 'Open', '2026-09-14 13:30:09', NULL, NULL, NULL, '2026-09-14 13:30:09', '2026-09-14 13:30:09');

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

--
-- Dumping data for table `cash_drawer_transactions`
--

INSERT INTO `cash_drawer_transactions` (`id`, `company_id`, `branch_id`, `terminal_id`, `cash_drawer_id`, `payment_id`, `order_id`, `created_by`, `transaction_type`, `amount`, `balance_before`, `balance_after`, `reference_no`, `remarks`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 14, 3, NULL, NULL, 15, 'Opening', 50920.00, 0.00, 50920.00, NULL, 'Cash drawer opened.', '2026-08-31 12:03:30', '2026-08-31 12:03:30'),
(5, 1, 2, 14, 4, NULL, NULL, 15, 'Opening', 52335.00, 0.00, 52335.00, NULL, 'Cash drawer opened.', '2026-08-31 12:15:28', '2026-08-31 12:15:28'),
(6, 1, 2, 14, 4, NULL, NULL, 15, 'Cash In', 15000.00, 52335.00, 67335.00, NULL, 'I Collected 15000 from terminal 2', '2026-08-31 12:21:19', '2026-08-31 12:21:19'),
(7, 1, 2, 14, 4, NULL, NULL, 15, 'Cash Out', 5000.00, 67335.00, 62335.00, NULL, 'gave 5000 to terminal 2, as at 3pm', '2026-08-31 12:23:29', '2026-08-31 12:23:29'),
(8, 1, 2, 14, 5, NULL, NULL, 15, 'Opening', 41320.00, 0.00, 41320.00, NULL, 'Cash drawer opened.', '2026-09-02 09:44:52', '2026-09-02 09:44:52'),
(9, 1, 2, 14, 6, NULL, NULL, 15, 'Opening', 23250.00, 0.00, 23250.00, NULL, 'Cash drawer opened.', '2026-09-03 11:27:46', '2026-09-03 11:27:46'),
(10, 1, 2, 14, 6, NULL, NULL, 15, 'Cash In', 5000.00, 23250.00, 28250.00, NULL, 'Collected 5,000 from terminal 2- Tolu', '2026-09-03 11:28:30', '2026-09-03 11:28:30'),
(11, 1, 2, 14, 6, NULL, NULL, 15, 'Cash Out', 2500.00, 28250.00, 25750.00, NULL, 'Gave 2500 cash to teminal2-Tolu', '2026-09-03 11:30:03', '2026-09-03 11:30:03'),
(12, 1, 2, 14, 6, 16, 30, 15, 'Sale', 90000.00, 25750.00, 115750.00, 'ORD-000022', NULL, '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(13, 1, 2, 14, 6, 17, 31, 17, 'Sale', 1400.00, 115750.00, 117150.00, 'ORD-000023', 'Cash payment received for sales order: ORD-000023', '2026-09-03 13:30:47', '2026-09-03 13:30:47'),
(14, 1, 2, 14, 6, 19, 33, 15, 'Sale', 700.00, 117150.00, 117850.00, 'ORD-000025', NULL, '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(15, 1, 2, 14, 6, 21, 35, 15, 'Sale', 250.00, 117850.00, 118100.00, 'ORD-000027', NULL, '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(16, 1, 2, 14, 6, 22, 37, 15, 'Sale', 700.00, 118100.00, 118800.00, 'ORD-000028', NULL, '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(17, 1, 2, 14, 6, 23, 38, 15, 'Sale', 2400.00, 118800.00, 121200.00, 'ORD-000029', NULL, '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(18, 1, 2, 14, 6, 24, 39, 15, 'Sale', 700.00, 121200.00, 121900.00, 'ORD-000030', NULL, '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(19, 1, 2, 14, 6, 25, 40, 15, 'Sale', 11450.00, 121900.00, 133350.00, 'ORD-000031', NULL, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(20, 1, 2, 14, 7, NULL, NULL, 15, 'Opening', 22340.00, 0.00, 22340.00, NULL, 'Cash drawer opened.', '2026-09-04 07:06:06', '2026-09-04 07:06:06'),
(21, 1, 2, 14, 7, 28, 73, 15, 'Sale', 752.50, 22340.00, 23092.50, 'ORD-000034', NULL, '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(22, 1, 2, 14, 7, 29, 74, 15, 'Sale', 752.50, 23092.50, 23845.00, 'ORD-000035', NULL, '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(23, 1, 2, 14, 7, 30, 75, 15, 'Sale', 752.50, 23845.00, 24597.50, 'ORD-000036', NULL, '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(24, 1, 2, 14, 7, 33, 78, 15, 'Sale', 9245.00, 24597.50, 33842.50, 'ORD-000039', NULL, '2026-09-04 08:57:18', '2026-09-04 08:57:18'),
(25, 1, 2, 14, 8, NULL, NULL, 15, 'Opening', 34350.00, 0.00, 34350.00, NULL, 'Cash drawer opened.', '2026-09-12 21:33:16', '2026-09-12 21:33:16'),
(26, 1, 2, 14, 9, NULL, NULL, 15, 'Opening', 12320.00, 0.00, 12320.00, NULL, 'Cash drawer opened.', '2026-09-14 13:30:09', '2026-09-14 13:30:09');

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
(1, 'COMP-0001', 'Emmanex Supermarket', 'emmanex-supermarket', 'info@emmanexitconsult.com', '08012345678', 'Lagos, Nigeria', '1788343028_emmanex-logo.png', 'NGN', '₦', 'Africa/Lagos', '2026-07-29', '2027-07-29', 'Active', 'Retail Supermarket', 'RC123456', 'TIN123456789', 1, '2026-09-26 23:06:08', 'Active', '2026-10-26 23:06:08', NULL, NULL, 0, '2026-07-29 10:37:09', '2026-09-27 00:55:55', NULL),
(4, 'COMP-243658', 'JustRite Mart', 'justrite-mart', 'justritemart@gmail.com', '08012345678', '12, Alakia, Off New Ife Road.', NULL, 'NGN', '₦', 'Africa/Lagos', '2026-09-17', '2026-10-17', 'Trial', 'Mini Mart', NULL, NULL, 1, '2026-09-17 12:10:34', 'Active', '2026-10-17 12:10:34', NULL, NULL, 0, '2026-09-17 12:10:34', '2026-09-27 00:55:55', NULL),
(5, 'COMP-313117', 'Gadget Padi', 'gadget-padi', 'gadgetpadi@gmail.com', '08104196102', 'Ibadan', NULL, 'NGN', '₦', 'Africa/Lagos', '2026-09-26', '2026-10-26', 'Trial', 'Mobile & Digital Accessories', NULL, NULL, 1, '2026-09-26 20:02:55', 'Active', '2026-10-26 20:02:55', NULL, NULL, 0, '2026-09-26 20:02:55', '2026-09-27 00:55:55', NULL);

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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `company_id`, `customer_group_id`, `branch_id`, `customer_code`, `first_name`, `last_name`, `email`, `phone`, `address`, `credit_limit`, `current_balance`, `customer_type`, `loyalty_points`, `last_purchase_date`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 1, 2, NULL, 'CUS-00001', 'Femi', 'Akinyooye', 'emmakinyooye@gmail.com', '08104786432', 'Alaro, Ibadan, Oyo', 50000.00, 0.00, 'Online', 0, '2026-09-28', 1, 1, NULL, '2026-08-16 02:50:25', '2026-09-27 23:17:12', NULL),
(9, 1, 7, NULL, 'CUS-00007', 'Clement', 'Elugbaju', 'clement@gmail.com', '07038899203', 'Ibadan', 5000000.00, 0.00, 'Business', 0, NULL, 1, 1, NULL, '2026-08-16 10:35:39', '2026-08-16 10:35:39', NULL),
(10, 1, 6, NULL, 'CUS-00010', 'Miracle', 'Peter', 'miracle.kingsbranding@gmail.com', '08104786432', 'Ibadan', 2000000.00, 0.00, 'Corporate', 0, NULL, 1, 1, NULL, '2026-08-27 13:04:26', '2026-08-27 13:04:26', NULL),
(11, 1, NULL, NULL, 'CUS-000001', 'Paul', 'Awolola', 'paulawolola@gmail.com', '07032109983', 'Alaro Street, Ibadan, Oyo', 0.00, 0.00, 'Online', 0, '2026-09-26', 1, NULL, NULL, '2026-09-26 22:47:27', '2026-09-26 22:47:47', NULL);

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

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `company_id`, `name`, `code`, `description`, `discount_percentage`, `credit_limit`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Walk-in Customers', 'WALKIN', 'Normal one-time/general customers', 0.00, 0.00, 1, 1, NULL, '2026-08-16 02:03:13', '2026-08-16 02:03:13'),
(2, 1, 'Regular Customers', 'REGULAR', 'Customers who purchase regularly', 2.00, 50000.00, 1, 1, NULL, '2026-08-16 02:09:30', '2026-08-16 02:09:30'),
(3, 1, 'VIP Customers', 'VIP', 'High-value customers', 5.00, 200000.00, 1, 1, NULL, '2026-08-16 02:10:10', '2026-08-16 02:10:10'),
(4, 1, 'Wholesale Customers', 'WHOLESALE', 'Bulk/wholesale buyers', 8.00, 1000000.00, 1, 1, NULL, '2026-08-16 02:10:56', '2026-08-16 02:10:56'),
(5, 1, 'Retailers', 'RETAILER', 'Businesses buying for resale', 5.00, 500000.00, 1, 1, NULL, '2026-08-16 02:14:03', '2026-08-16 02:14:03'),
(6, 1, 'Corporate Customers', 'CORPORATE', 'Companies and organizations', 5.00, 2000000.00, 1, 1, 1, '2026-08-16 02:14:42', '2026-08-16 04:12:23'),
(7, 1, 'Distributors', 'DISTRIBUTOR', 'Large-volume distribution customers', 10.00, 5000000.00, 1, 1, NULL, '2026-08-16 02:15:27', '2026-08-16 02:15:27'),
(13, 1, 'Staff', 'STAFF', 'Employee', 5.00, 20000.00, 1, 1, 1, '2026-08-16 02:40:32', '2026-08-16 04:45:14');

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

--
-- Dumping data for table `data_lifecycle_settings`
--

INSERT INTO `data_lifecycle_settings` (`id`, `enabled`, `inactivity_days`, `grace_period_days`, `warning_days`, `automatic_scheduling`, `automatic_purge`, `archive_disk`, `archive_directory`, `archive_retention_days`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 30, 0, '[90,30,7]', 0, 0, 'local', 'company-archives', NULL, 1, '2026-09-27 00:46:41', '2026-09-27 00:53:53');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `company_id`, `name`, `is_automatic`, `type`, `value`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'No Discount', 1, 'Percentage', 0.00, '2026-07-29', '2036-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(2, 1, 'Opening Promotion', 1, 'Percentage', 5.00, '2026-07-29', '2026-08-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(3, 1, 'Manager Discount', 0, 'Percentage', 10.00, '2026-07-29', '2027-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(4, 1, 'Special Customer', 0, 'Fixed', 500.00, '2026-07-29', '2027-07-29', 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(5, 1, 'Test Discount', 1, 'Percentage', 2.00, '2026-08-04', '2026-08-31', 1, '2026-08-04 10:06:31', '2026-08-04 10:30:03', '2026-08-04 10:30:03'),
(6, 4, 'None', 0, 'Percentage', 0.00, '2026-09-21', '2026-09-30', 1, '2026-09-21 09:24:17', '2026-09-21 09:24:17', NULL);

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

--
-- Dumping data for table `document_sequences`
--

INSERT INTO `document_sequences` (`id`, `company_id`, `document_type`, `prefix`, `suffix`, `separator`, `current_number`, `number_length`, `reset_frequency`, `last_reset_at`, `status`, `created_at`, `updated_at`, `use_date_in_sequence`) VALUES
(1, 1, 'category', 'CAT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(2, 1, 'product', 'PRD', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(3, 1, 'customer', 'CUS', NULL, '-', 2, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-09-26 22:47:27', 0),
(4, 1, 'supplier', 'SUP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(5, 1, 'order', 'ORD', NULL, '-', 59, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-09-27 23:17:01', 0),
(6, 1, 'payment', 'PAY', NULL, '-', 44, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-09-27 23:17:12', 0),
(7, 1, 'purchase', 'PUR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(8, 1, 'purchase_return', 'PRN', NULL, '-', 5, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-27 09:44:50', 0),
(9, 1, 'sales_return', 'SRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(10, 1, 'stock_movement', 'STM', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(11, 1, 'stock_adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(12, 1, 'expense', 'EXP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(13, 1, 'unit', 'UNT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(14, 1, 'tax', 'TAX', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(15, 1, 'discount', 'DIS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(16, 1, 'Invoice', 'INV', NULL, '-', 46, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-09-27 23:17:01', 0),
(17, 1, 'Receipt', 'REC', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(18, 1, 'Sales Order', 'SO', NULL, '-', 31, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-09-04 08:03:52', 0),
(19, 1, 'Purchase Order', 'PO', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(20, 1, 'Purchase Return', 'PR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(22, 1, 'stock_transfer', 'ST', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(23, 1, 'stock_count', 'SC', NULL, '-', 4, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-15 08:53:31', 0),
(24, 1, 'goods_received', 'GR', NULL, '-', 7, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-22 13:16:15', 0),
(25, 1, 'Sales Return', 'SR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-03 20:59:24', '2026-09-03 20:59:24', 0),
(26, 1, 'Stock Transfer', 'ST', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-03 20:59:24', '2026-09-03 20:59:24', 0),
(27, 1, 'Stock Adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-03 20:59:24', '2026-09-03 20:59:24', 0),
(28, 4, 'category', 'CAT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(29, 4, 'product', 'PRD', NULL, '-', 3, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-21 12:09:46', 0),
(30, 4, 'customer', 'CUS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(31, 4, 'supplier', 'SUP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(32, 4, 'order', 'ORD', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(33, 4, 'payment', 'PAY', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(34, 4, 'purchase', 'PUR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(35, 4, 'purchase_return', 'PRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(36, 4, 'sales_return', 'SRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(37, 4, 'stock_movement', 'STM', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(38, 4, 'stock_adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(39, 4, 'stock_transfer', 'ST', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(40, 4, 'stock_count', 'SC', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(41, 4, 'expense', 'EXP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(42, 4, 'unit', 'UNT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(43, 4, 'tax', 'TAX', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(44, 4, 'discount', 'DIS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(45, 4, 'goods_received', 'GR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', 0),
(46, 5, 'category', 'CAT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:56', '2026-09-26 20:02:56', 0),
(47, 5, 'product', 'PRD', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(48, 5, 'customer', 'CUS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(49, 5, 'supplier', 'SUP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(50, 5, 'order', 'ORD', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(51, 5, 'payment', 'PAY', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(52, 5, 'purchase', 'PUR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(53, 5, 'purchase_return', 'PRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(54, 5, 'sales_return', 'SRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(55, 5, 'stock_movement', 'STM', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(56, 5, 'stock_adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(57, 5, 'stock_transfer', 'ST', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(58, 5, 'stock_count', 'SC', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(59, 5, 'expense', 'EXP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(60, 5, 'unit', 'UNT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(61, 5, 'tax', 'TAX', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(62, 5, 'discount', 'DIS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0),
(63, 5, 'goods_received', 'GR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', 0);

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

--
-- Dumping data for table `goods_received`
--

INSERT INTO `goods_received` (`id`, `company_id`, `branch_id`, `purchase_order_id`, `supplier_id`, `receipt_number`, `received_date`, `status`, `notes`, `received_by`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 3, 1, 'GR-000002', '2026-08-22', 'Completed', NULL, 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(4, 1, 1, 3, 1, 'GR-000003', '2026-08-23', 'Completed', NULL, 1, '2026-08-22 12:51:24', '2026-08-22 12:51:24'),
(5, 1, 1, 3, 1, 'GR-000004', '2026-08-22', 'Completed', NULL, 1, '2026-08-22 13:03:30', '2026-08-22 13:03:30'),
(6, 1, 1, 3, 1, 'GR-000005', '2026-08-22', 'Completed', NULL, 1, '2026-08-22 13:14:09', '2026-08-22 13:14:09'),
(7, 1, 1, 3, 1, 'GR-000006', '2026-08-22', 'Completed', NULL, 1, '2026-08-22 13:16:15', '2026-08-22 13:16:15');

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

--
-- Dumping data for table `goods_received_items`
--

INSERT INTO `goods_received_items` (`id`, `goods_received_id`, `purchase_order_item_id`, `product_id`, `ordered_quantity`, `received_quantity`, `unit_cost`, `total`, `created_at`, `updated_at`) VALUES
(11, 3, 11, 1, 1000.00, 1000.00, 500.00, 500000.00, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(12, 3, 12, 6, 1500.00, 400.00, 1450.00, 580000.00, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(13, 3, 13, 2, 2000.00, 400.00, 500.00, 200000.00, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(14, 3, 14, 19, 1500.00, 150.00, 1000.00, 150000.00, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(15, 3, 15, 10, 1000.00, 400.00, 7800.00, 3120000.00, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(16, 4, 12, 6, 1500.00, 1100.00, 1450.00, 1595000.00, '2026-08-22 12:51:24', '2026-08-22 12:51:24'),
(17, 5, 13, 2, 2000.00, 1600.00, 500.00, 800000.00, '2026-08-22 13:03:30', '2026-08-22 13:03:30'),
(18, 6, 14, 19, 1500.00, 1350.00, 1000.00, 1350000.00, '2026-08-22 13:14:09', '2026-08-22 13:14:09'),
(19, 7, 15, 10, 1000.00, 600.00, 7800.00, 4680000.00, '2026-08-22 13:16:15', '2026-08-22 13:16:15');

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

INSERT INTO `invoices` (`id`, `company_id`, `branch_id`, `terminal_id`, `order_id`, `customer_id`, `invoice_no`, `invoice_date`, `subtotal`, `discount`, `tax`, `total`, `amount_paid`, `balance`, `total_quantity`, `total_items`, `grand_total`, `payment_status`, `invoice_status`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 4, 12, 17, NULL, 'INV-000001', '2026-08-28', 91650.00, 0.00, 0.00, 91650.00, 92000.00, 0.00, 2.00, 2, 91650.00, 'Paid', 'Active', NULL, 1, 1, '2026-08-28 07:37:23', '2026-08-28 09:20:27', NULL),
(2, 1, 1, 1, 18, 6, 'INV-000002', '2026-08-28', 983500.00, 0.00, 0.00, 983500.00, 983500.00, 0.00, 45.00, 4, 983500.00, 'Paid', 'Active', 'Items totalled to 983,500, with no discount or tax', 1, 1, '2026-08-28 09:23:30', '2026-08-28 10:11:22', NULL),
(3, 1, 4, 12, 19, 10, 'INV-000003', '2026-08-28', 1200.00, 0.00, 0.00, 1200.00, 0.00, 1200.00, 1.00, 1, 1200.00, 'Pending', 'Active', NULL, 1, NULL, '2026-08-28 10:08:09', '2026-08-28 10:08:09', NULL),
(4, 1, 1, 2, 20, 9, 'INV-000004', '2026-08-29', 522000.00, 2.00, 0.00, 521998.00, 150000.00, 371998.00, 65.00, 3, 521998.00, 'Partial', 'Active', NULL, 1, 1, '2026-08-29 12:02:14', '2026-08-29 12:02:39', NULL),
(5, 1, 2, 14, 21, NULL, 'INV-000005', '2026-08-31', 700.00, 0.00, 0.00, 700.00, 0.00, 700.00, 1.00, 1, 700.00, 'Pending', 'Active', NULL, 17, NULL, '2026-08-31 10:09:28', '2026-08-31 10:09:28', NULL),
(6, 1, 2, 14, 22, NULL, 'INV-000006', '2026-08-31', 700.00, 0.00, 0.00, 700.00, 700.00, 0.00, 1.00, 1, 700.00, 'Paid', 'Active', NULL, 17, 17, '2026-08-31 10:10:48', '2026-08-31 10:15:05', NULL),
(12, 1, 2, 14, 28, NULL, 'INV-000007', '2026-09-02', 4250.00, 0.00, 0.00, 4250.00, 4250.00, 0.00, 4.00, 4, 4250.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01', NULL),
(13, 1, 2, 14, 29, NULL, 'INV-000008', '2026-09-03', 1200.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, 1.00, 1, 1200.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 12:53:32', '2026-09-03 12:53:32', NULL),
(14, 1, 2, 14, 30, NULL, 'INV-000009', '2026-09-03', 90000.00, 0.00, 0.00, 90000.00, 90000.00, 0.00, 1.00, 1, 90000.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 13:26:09', '2026-09-03 13:26:09', NULL),
(15, 1, 2, 14, 31, NULL, 'INV-000010', '2026-09-03', 1400.00, 0.00, 0.00, 1400.00, 1400.00, 0.00, 2.00, 1, 1400.00, 'Paid', 'Active', NULL, 17, 17, '2026-09-03 13:29:17', '2026-09-03 13:30:47', NULL),
(16, 1, 2, 14, 32, NULL, 'INV-000011', '2026-09-03', 1200.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, 1.00, 1, 1200.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:04:14', '2026-09-03 14:04:14', NULL),
(17, 1, 2, 14, 33, NULL, 'INV-000012', '2026-09-03', 700.00, 0.00, 0.00, 700.00, 700.00, 0.00, 1.00, 1, 700.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:35:52', '2026-09-03 14:35:52', NULL),
(18, 1, 2, 14, 34, NULL, 'INV-000013', '2026-09-03', 4800.00, 0.00, 0.00, 4800.00, 4800.00, 0.00, 1.00, 1, 4800.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:41:19', '2026-09-03 14:41:19', NULL),
(19, 1, 2, 14, 35, NULL, 'INV-000014', '2026-09-03', 250.00, 0.00, 0.00, 250.00, 250.00, 0.00, 1.00, 1, 250.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:42:11', '2026-09-03 14:42:11', NULL),
(21, 1, 2, 14, 37, NULL, 'INV-000015', '2026-09-03', 700.00, 0.00, 0.00, 700.00, 700.00, 0.00, 1.00, 1, 700.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:44:26', '2026-09-03 14:44:26', NULL),
(22, 1, 2, 14, 38, NULL, 'INV-000016', '2026-09-03', 2400.00, 0.00, 0.00, 2400.00, 2400.00, 0.00, 2.00, 1, 2400.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:48:07', '2026-09-03 14:48:07', NULL),
(23, 1, 2, 14, 39, NULL, 'INV-000017', '2026-09-03', 700.00, 0.00, 0.00, 700.00, 700.00, 0.00, 1.00, 1, 700.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:49:35', '2026-09-03 14:49:35', NULL),
(24, 1, 2, 14, 40, NULL, 'INV-000018', '2026-09-03', 11450.00, 0.00, 0.00, 11450.00, 11450.00, 0.00, 3.00, 3, 11450.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 14:57:36', '2026-09-03 14:57:36', NULL),
(25, 1, 2, 14, 41, NULL, 'INV-000019', '2026-09-03', 8600.00, 0.00, 0.00, 8600.00, 8600.00, 0.00, 1.00, 1, 8600.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 15:22:00', '2026-09-03 15:22:00', NULL),
(26, 1, 2, 14, 42, 10, 'INV-000020', '2026-09-03', 90000.00, 5.00, 0.00, 89995.00, 89995.00, 0.00, 1.00, 1, 89995.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-03 20:14:44', '2026-09-03 20:14:44', NULL),
(27, 1, 2, 14, 73, NULL, 'INV-000021', '2026-09-04', 700.00, 0.00, 52.50, 700.00, 752.50, 0.00, 1.00, 1, 752.50, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:09:17', '2026-09-04 08:09:17', NULL),
(28, 1, 2, 14, 74, NULL, 'INV-000022', '2026-09-04', 700.00, 0.00, 52.50, 700.00, 752.50, 0.00, 1.00, 1, 752.50, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:09:32', '2026-09-04 08:09:32', NULL),
(29, 1, 2, 14, 75, NULL, 'INV-000023', '2026-09-04', 700.00, 0.00, 52.50, 700.00, 752.50, 0.00, 1.00, 1, 752.50, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:17:39', '2026-09-04 08:17:39', NULL),
(30, 1, 2, 14, 76, NULL, 'INV-000024', '2026-09-04', 8600.00, 0.00, 645.00, 8600.00, 9245.00, 0.00, 1.00, 1, 9245.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:19:05', '2026-09-04 08:19:05', NULL),
(31, 1, 2, 14, 77, NULL, 'INV-000025', '2026-09-04', 1200.00, 0.00, 90.00, 1200.00, 1290.00, 0.00, 1.00, 1, 1290.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:22:48', '2026-09-04 08:22:48', NULL),
(32, 1, 2, 14, 78, 10, 'INV-000026', '2026-09-04', 8600.00, 0.00, 645.00, 8600.00, 9245.00, 0.00, 1.00, 1, 9245.00, 'Paid', 'Active', NULL, 15, 15, '2026-09-04 08:57:18', '2026-09-04 08:57:18', NULL),
(33, 1, 2, 14, 79, NULL, 'INV-000027', '2026-09-14', 1200.00, 0.00, 90.00, 1200.00, 1290.00, 0.00, 1.00, 1, 1290.00, 'Paid', 'Active', '1290', 15, 15, '2026-09-14 13:30:52', '2026-09-14 13:30:52', NULL),
(34, 1, 4, 12, 80, 9, 'INV-000028', '2026-09-14', 1200.00, 0.00, 0.00, 1200.00, 0.00, 0.00, 1.00, 1, 1200.00, 'Refunded', 'Refunded', NULL, 1, 1, '2026-09-14 13:32:47', '2026-09-16 10:21:18', NULL),
(35, 1, 1, 1, 81, 6, 'INV-000029', '2026-09-16', 3350.00, 0.00, 0.00, 3350.00, 3350.00, 0.00, 4.00, 3, 3350.00, 'Paid', 'Active', NULL, 1, 1, '2026-09-16 10:39:51', '2026-09-16 10:40:05', NULL),
(36, 1, 1, 2, 82, NULL, 'INV-000030', '2026-09-16', 10500.00, 0.00, 0.00, 10500.00, 0.00, 0.00, 10.00, 4, 10500.00, 'Refunded', 'Refunded', NULL, 1, 1, '2026-09-16 12:02:21', '2026-09-16 12:03:19', NULL),
(37, 1, 1, NULL, 83, 11, 'INV-000031', '2026-09-26', 102000.00, 0.00, 0.00, 102000.00, 102000.00, 0.00, 5.00, 3, 102000.00, 'Paid', 'Active', 'Online Storefront order ORD-000044', NULL, NULL, '2026-09-26 22:47:27', '2026-09-26 22:47:47', NULL),
(38, 1, 1, NULL, 84, 6, 'INV-000032', '2026-09-26', 2400.00, 0.00, 0.00, 2400.00, 2400.00, 0.00, 2.00, 1, 2400.00, 'Paid', 'Active', 'Online Storefront order ORD-000045', NULL, NULL, '2026-09-26 22:58:30', '2026-09-26 22:58:41', NULL),
(39, 1, 1, NULL, 85, 6, 'INV-000033', '2026-09-27', 90000.00, 0.00, 0.00, 90000.00, 90000.00, 0.00, 1.00, 1, 90000.00, 'Paid', 'Active', 'Online Storefront order ORD-000046', NULL, NULL, '2026-09-26 23:05:55', '2026-09-26 23:06:08', NULL),
(40, 1, 1, NULL, 86, 6, 'INV-000034', '2026-09-27', 8600.00, 0.00, 0.00, 8600.00, 8600.00, 0.00, 1.00, 1, 8600.00, 'Paid', 'Active', 'Online Storefront order ORD-000047', NULL, NULL, '2026-09-27 12:41:11', '2026-09-27 12:41:34', NULL),
(41, 1, 1, NULL, 87, 6, 'INV-000035', '2026-09-27', 1200.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, 1.00, 1, 1200.00, 'Paid', 'Active', 'Online Storefront order ORD-000048', NULL, NULL, '2026-09-27 20:45:10', '2026-09-27 20:45:24', NULL),
(42, 1, 1, NULL, 88, 6, 'INV-000036', '2026-09-27', 1400.00, 0.00, 0.00, 1400.00, 1400.00, 0.00, 2.00, 1, 1400.00, 'Paid', 'Active', 'Online Storefront order ORD-000049', NULL, NULL, '2026-09-27 20:57:42', '2026-09-27 20:57:54', NULL),
(43, 1, 1, NULL, 89, 6, 'INV-000037', '2026-09-27', 8600.00, 0.00, 0.00, 13600.00, 0.00, 13600.00, 1.00, 1, 13600.00, 'Pending', 'Active', 'Online Storefront order ORD-000050', NULL, NULL, '2026-09-27 22:43:35', '2026-09-27 22:43:35', NULL),
(44, 1, 1, NULL, 90, 6, 'INV-000038', '2026-09-27', 8600.00, 0.00, 0.00, 13600.00, 0.00, 13600.00, 1.00, 1, 13600.00, 'Pending', 'Active', 'Online Storefront order ORD-000051', NULL, NULL, '2026-09-27 22:44:26', '2026-09-27 22:44:26', NULL),
(45, 1, 1, NULL, 91, 6, 'INV-000039', '2026-09-27', 8600.00, 0.00, 0.00, 13600.00, 0.00, 13600.00, 1.00, 1, 13600.00, 'Pending', 'Active', 'Online Storefront order ORD-000052', NULL, NULL, '2026-09-27 22:45:38', '2026-09-27 22:45:38', NULL),
(46, 1, 1, NULL, 92, 6, 'INV-000040', '2026-09-27', 8600.00, 0.00, 0.00, 14100.00, 0.00, 14100.00, 1.00, 1, 14100.00, 'Pending', 'Active', 'Online Storefront order ORD-000053', NULL, NULL, '2026-09-27 22:47:00', '2026-09-27 22:47:00', NULL),
(47, 1, 1, NULL, 93, 6, 'INV-000041', '2026-09-27', 8600.00, 0.00, 0.00, 13600.00, 13600.00, 0.00, 1.00, 1, 13600.00, 'Paid', 'Active', 'Online Storefront order ORD-000054', NULL, NULL, '2026-09-27 22:51:17', '2026-09-27 22:51:27', NULL),
(48, 1, 1, NULL, 94, 6, 'INV-000042', '2026-09-27', 700.00, 0.00, 0.00, 6200.00, 6200.00, 0.00, 1.00, 1, 6200.00, 'Paid', 'Active', 'Online Storefront order ORD-000055', NULL, NULL, '2026-09-27 22:59:50', '2026-09-27 23:00:03', NULL),
(49, 1, 1, NULL, 95, 6, 'INV-000043', '2026-09-28', 1200.00, 0.00, 0.00, 6200.00, 6200.00, 0.00, 1.00, 1, 6200.00, 'Paid', 'Active', 'Online Storefront order ORD-000056', NULL, NULL, '2026-09-27 23:07:21', '2026-09-27 23:07:29', NULL),
(50, 1, 1, NULL, 96, 6, 'INV-000044', '2026-09-28', 8600.00, 0.00, 0.00, 13600.00, 13600.00, 0.00, 1.00, 1, 13600.00, 'Paid', 'Active', 'Online Storefront order ORD-000057', NULL, NULL, '2026-09-27 23:11:18', '2026-09-27 23:11:25', NULL),
(51, 1, 1, NULL, 97, 6, 'INV-000045', '2026-09-28', 1000.00, 0.00, 0.00, 2000.00, 2000.00, 0.00, 4.00, 1, 2000.00, 'Paid', 'Active', 'Online Storefront order ORD-000058', NULL, NULL, '2026-09-27 23:17:01', '2026-09-27 23:17:12', NULL);

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
(2, 1, 1, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 0.00, 0.00, 90000.00, '2026-08-28 07:39:36', '2026-08-28 07:39:36'),
(3, 1, 1, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 0.00, 0.00, 1650.00, '2026-08-28 07:39:36', '2026-08-28 07:39:36'),
(4, 1, 2, 19, 'Three Crown Evaporated Milk', 'TH123456', 20.00, 1200.00, 0.00, 0.00, 24000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(5, 1, 2, 8, 'Mama Gold Rice 50kg', '100000000008', 10.00, 90000.00, 0.00, 0.00, 900000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(6, 1, 2, 6, 'Dangote Sugar 1kg', '100000000006', 10.00, 1650.00, 0.00, 0.00, 16500.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(7, 1, 2, 10, 'Pampers Size 3', '100000000010', 5.00, 8600.00, 0.00, 0.00, 43000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(8, 1, 3, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-08-28 10:08:09', '2026-08-28 10:08:09'),
(9, 1, 4, 19, 'Three Crown Evaporated Milk', 'TH123456', 50.00, 1200.00, 0.00, 0.00, 60000.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(10, 1, 4, 8, 'Mama Gold Rice 50kg', '100000000008', 5.00, 90000.00, 2.00, 0.00, 449998.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(11, 1, 4, 7, 'Family Bread', '100000000007', 10.00, 1200.00, 0.00, 0.00, 12000.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(12, 1, 5, 2, 'Fanta 50cl', '100000000002', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-08-31 10:09:28', '2026-08-31 10:09:28'),
(13, 1, 6, 2, 'Fanta 50cl', '100000000002', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-08-31 10:10:48', '2026-08-31 10:10:48'),
(32, 1, 12, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(33, 1, 12, 3, 'Sprite 50cl', '100000000003', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(34, 1, 12, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 0.00, 0.00, 1650.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(35, 1, 12, 1, 'Coca-Cola 50cl', '100000000001', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(36, 1, 13, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-03 12:53:32', '2026-09-03 12:53:32'),
(37, 1, 14, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 0.00, 0.00, 90000.00, '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(38, 1, 15, 2, 'Fanta 50cl', '100000000002', 2.00, 700.00, 0.00, 0.00, 1400.00, '2026-09-03 13:29:17', '2026-09-03 13:29:17'),
(39, 1, 16, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-03 14:04:14', '2026-09-03 14:04:14'),
(40, 1, 17, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(41, 1, 18, 4, 'Peak Milk 500g', '100000000004', 1.00, 4800.00, 0.00, 0.00, 4800.00, '2026-09-03 14:41:19', '2026-09-03 14:41:19'),
(42, 1, 19, 5, 'Indomie Chicken Noodles', '100000000005', 1.00, 250.00, 0.00, 0.00, 250.00, '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(44, 1, 21, 1, 'Coca-Cola 50cl', '100000000001', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(45, 1, 22, 7, 'Family Bread', '100000000007', 2.00, 1200.00, 0.00, 0.00, 2400.00, '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(46, 1, 23, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(47, 1, 24, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(48, 1, 24, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(49, 1, 24, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 0.00, 0.00, 1650.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(50, 1, 25, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-03 15:22:00', '2026-09-03 15:22:00'),
(51, 1, 26, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 0.00, 0.00, 90000.00, '2026-09-03 20:14:44', '2026-09-03 20:14:44'),
(52, 1, 27, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(53, 1, 28, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(54, 1, 29, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(55, 1, 30, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-04 08:19:05', '2026-09-04 08:19:05'),
(56, 1, 31, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-04 08:22:48', '2026-09-04 08:22:48'),
(57, 1, 32, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-04 08:57:18', '2026-09-04 08:57:18'),
(58, 1, 33, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-14 13:30:52', '2026-09-14 13:30:52'),
(59, 1, 34, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-14 13:32:47', '2026-09-14 13:32:47'),
(60, 1, 35, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 0.00, 0.00, 1650.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(61, 1, 35, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(62, 1, 35, 5, 'Indomie Chicken Noodles', '100000000005', 2.00, 250.00, 0.00, 0.00, 500.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(63, 1, 36, 7, 'Family Bread', '100000000007', 2.00, 1200.00, 0.00, 0.00, 2400.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(64, 1, 36, 6, 'Dangote Sugar 1kg', '100000000006', 3.00, 1650.00, 0.00, 0.00, 4950.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(65, 1, 36, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 0.00, 0.00, 2400.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(66, 1, 36, 5, 'Indomie Chicken Noodles', '100000000005', 3.00, 250.00, 0.00, 0.00, 750.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(67, 1, 37, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 0.00, 0.00, 2400.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(68, 1, 37, 4, 'Peak Milk 500g', '100000000004', 2.00, 4800.00, 0.00, 0.00, 9600.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(69, 1, 37, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 0.00, 0.00, 90000.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(70, 1, 38, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 0.00, 0.00, 2400.00, '2026-09-26 22:58:30', '2026-09-26 22:58:30'),
(71, 1, 39, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 0.00, 0.00, 90000.00, '2026-09-26 23:05:55', '2026-09-26 23:05:55'),
(72, 1, 40, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 12:41:11', '2026-09-27 12:41:11'),
(73, 1, 41, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-27 20:45:10', '2026-09-27 20:45:10'),
(74, 1, 42, 1, 'Coca-Cola 50cl', '100000000001', 2.00, 700.00, 0.00, 0.00, 1400.00, '2026-09-27 20:57:42', '2026-09-27 20:57:42'),
(75, 1, 43, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 22:43:35', '2026-09-27 22:43:35'),
(76, 1, 44, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 22:44:26', '2026-09-27 22:44:26'),
(77, 1, 45, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 22:45:38', '2026-09-27 22:45:38'),
(78, 1, 46, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 22:47:00', '2026-09-27 22:47:00'),
(79, 1, 47, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 22:51:17', '2026-09-27 22:51:17'),
(80, 1, 48, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 0.00, 0.00, 700.00, '2026-09-27 22:59:50', '2026-09-27 22:59:50'),
(81, 1, 49, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 0.00, 0.00, 1200.00, '2026-09-27 23:07:21', '2026-09-27 23:07:21'),
(82, 1, 50, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 0.00, 0.00, 8600.00, '2026-09-27 23:11:18', '2026-09-27 23:11:18'),
(83, 1, 51, 5, 'Indomie Chicken Noodles', '100000000005', 4.00, 250.00, 0.00, 0.00, 1000.00, '2026-09-27 23:17:01', '2026-09-27 23:17:01');

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
(30, '2026_07_29_140700_alter_activity_logs_table_add_record_information', 2),
(31, '2026_07_29_141430_add_record_columns_to_activity_logs_table', 3),
(32, '2026_07_29_163213_add_additional_fields_to_users_table', 4),
(33, '2026_08_01_224447_add_description_and_last_seen_at_to_terminals_table', 5),
(34, '2026_08_02_010316_add_missing_fields_to_settings_table', 6),
(35, '2026_08_02_092343_add_last_reset_at_to_document_sequences_table', 7),
(36, '2026_08_02_103957_create_payment_methods_table', 8),
(37, '2026_08_02_104254_add_payment_method_id_to_payments_table', 8),
(38, '2026_08_02_104326_remove_payment_method_from_payments_table', 8),
(39, '2026_08_03_100609_add_payment_method_to_payments_table', 9),
(40, '2026_08_03_101122_add_unit_metadata_to_units_table', 10),
(41, '2026_08_04_100012_add_soft_deletes_to_discounts_table', 11),
(42, '2026_08_09_103055_update_stock_movements_for_stock_adjustments', 12),
(43, '2026_08_11_100444_update_stock_movement_types', 13),
(44, '2026_08_14_093916_create_stock_counts_table', 14),
(45, '2026_08_14_093949_create_stock_count_items_table', 14),
(46, '2026_08_15_133231_create_customer_groups_table', 15),
(47, '2026_08_15_134244_add_customer_group_id_to_customers_table', 16),
(48, '2026_08_16_120215_create_suppliers_table', 17),
(49, '2026_08_16_125844_create_purchase_orders_table', 18),
(50, '2026_08_16_125923_create_purchase_order_items_table', 18),
(51, '2026_08_16_125944_create_goods_receiveds_table', 18),
(52, '2026_08_16_130015_create_goods_received_items_table', 18),
(53, '2026_08_16_130034_create_purchase_returns_table', 18),
(54, '2026_08_16_130056_create_purchase_return_items_table', 18),
(59, '2026_08_28_081507_create_invoices_table', 19),
(60, '2026_08_28_081604_create_invoice_items_table', 19),
(61, '2026_08_29_151423_create_sales_returns_table', 20),
(62, '2026_08_29_151437_create_sales_return_payments_table', 20),
(63, '2026_08_30_021155_create_cash_drawers_table', 21),
(64, '2026_08_30_021227_create_cash_drawer_transactions_table', 21),
(65, '2026_08_30_112306_create_terminal_assignments_table', 21),
(66, '2026_09_14_134815_add_unit_cost_to_order_items_table', 22),
(67, '2026_09_16_114806_create_sales_return_items_table', 23),
(68, '2026_09_21_131904_create_sync_devices_table', 24),
(69, '2026_09_21_132116_create_sync_queue_table', 24),
(70, '2026_09_21_132304_create_sync_logs_table', 24),
(71, '2026_09_21_141419_create_sync_mutations_table', 25),
(72, '2026_09_26_203336_create_store_fronts_table', 26),
(73, '2026_09_26_232040_make_cashier_id_nullable_on_orders_table', 27),
(74, '2026_09_26_232431_make_online_sales_user_fields_nullable', 28),
(75, '2026_09_26_232746_make_online_sales_user_fields_nullable', 29),
(76, '2026_09_27_001854_create_platform_admins_table', 30),
(77, '2026_09_27_012938_add_data_lifecycle_fields_to_companies_table', 31),
(78, '2026_09_27_013237_create_data_lifecycle_settings_table', 31),
(79, '2026_09_27_013305_create_company_archives_table', 31),
(80, '2026_09_27_013330_create_company_lifecycle_events_table', 31),
(81, '2026_09_27_213040_add_storefront_public_fields_to_orders_table', 32),
(82, '2026_09_27_220804_create_shipping_settings_table', 33),
(83, '2026_09_27_220814_create_shipping_locations_table', 33),
(84, '2026_09_27_220831_add_shipping_fields_to_orders_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL,
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

INSERT INTO `orders` (`id`, `company_id`, `branch_id`, `order_no`, `public_token`, `customer_id`, `cashier_id`, `subtotal`, `discount`, `discount_id`, `tax_rate_id`, `tax`, `total`, `amount_paid`, `balance`, `total_items`, `total_quantity`, `change_given`, `grand_total`, `completed_at`, `confirmation_email_sent_at`, `payment_status`, `order_status`, `sales_channel`, `terminal_id`, `receipt_printed`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `shipping_method`, `shipping_location_id`, `shipping_location_name`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_fee`, `fulfilment_status`, `tracking_reference`, `shipping_notes`, `shipped_at`, `delivered_at`) VALUES
(17, 1, 4, 'ORD-000014', NULL, NULL, 1, 91650.00, 0.00, NULL, NULL, 0.00, 91650.00, 92000.00, 0.00, 2, 2.00, 350.00, 91650.00, '2026-08-28 09:20:27', NULL, 'Paid', 'Completed', 'POS', 12, 0, NULL, 1, 1, '2026-08-28 07:37:23', '2026-08-28 09:20:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(18, 1, 1, 'ORD-000015', NULL, 6, 1, 983500.00, 0.00, NULL, NULL, 0.00, 983500.00, 983500.00, 0.00, 4, 45.00, 0.00, 983500.00, '2026-08-28 10:11:22', NULL, 'Paid', 'Completed', 'POS', 1, 0, 'Items totalled to 983,500, with no discount or tax', 1, 1, '2026-08-28 09:23:30', '2026-08-28 10:11:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(19, 1, 4, 'ORD-000016', NULL, 10, 1, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 0.00, 1200.00, 1, 1.00, 0.00, 1200.00, NULL, NULL, 'Pending', 'Draft', 'POS', 12, 0, NULL, 1, NULL, '2026-08-28 10:08:09', '2026-08-28 10:08:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(20, 1, 1, 'ORD-000017', NULL, 9, 1, 522000.00, 2.00, NULL, NULL, 0.00, 521998.00, 150000.00, 371998.00, 3, 65.00, 0.00, 521998.00, NULL, NULL, 'Partial', 'Held', 'POS', 2, 0, NULL, 1, 1, '2026-08-29 12:02:14', '2026-08-29 12:02:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(21, 1, 2, 'ORD-000018', NULL, NULL, 17, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 0.00, 700.00, 1, 1.00, 0.00, 700.00, NULL, NULL, 'Pending', 'Draft', 'POS', 14, 0, NULL, 17, NULL, '2026-08-31 10:09:28', '2026-08-31 10:09:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(22, 1, 2, 'ORD-000019', NULL, NULL, 17, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 700.00, 0.00, 1, 1.00, 0.00, 700.00, '2026-08-31 10:15:05', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 17, 17, '2026-08-31 10:10:48', '2026-08-31 10:15:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(28, 1, 2, 'ORD-000020', NULL, NULL, 15, 4250.00, 0.00, NULL, NULL, 0.00, 4250.00, 4250.00, 0.00, 4, 4.00, 0.00, 4250.00, '2026-09-02 11:38:01', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(29, 1, 2, 'ORD-000021', NULL, NULL, 15, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 1200.00, 0.00, 1, 1.00, 0.00, 1200.00, '2026-09-03 12:53:32', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 12:53:32', '2026-09-03 12:53:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(30, 1, 2, 'ORD-000022', NULL, NULL, 15, 90000.00, 0.00, NULL, NULL, 0.00, 90000.00, 90000.00, 0.00, 1, 1.00, 0.00, 90000.00, '2026-09-03 13:26:09', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 13:26:09', '2026-09-03 13:26:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(31, 1, 2, 'ORD-000023', NULL, NULL, 17, 1400.00, 0.00, NULL, NULL, 0.00, 1400.00, 1400.00, 0.00, 1, 2.00, 0.00, 1400.00, '2026-09-03 13:30:47', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 17, 17, '2026-09-03 13:29:17', '2026-09-03 13:30:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(32, 1, 2, 'ORD-000024', NULL, NULL, 15, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 1200.00, 0.00, 1, 1.00, 0.00, 1200.00, '2026-09-03 14:04:14', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:04:14', '2026-09-03 14:04:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(33, 1, 2, 'ORD-000025', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 700.00, 0.00, 1, 1.00, 0.00, 700.00, '2026-09-03 14:35:52', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:35:52', '2026-09-03 14:35:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(34, 1, 2, 'ORD-000026', NULL, NULL, 15, 4800.00, 0.00, NULL, NULL, 0.00, 4800.00, 4800.00, 0.00, 1, 1.00, 0.00, 4800.00, '2026-09-03 14:41:19', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:41:19', '2026-09-03 14:41:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(35, 1, 2, 'ORD-000027', NULL, NULL, 15, 250.00, 0.00, NULL, NULL, 0.00, 250.00, 250.00, 0.00, 1, 1.00, 0.00, 250.00, '2026-09-03 14:42:11', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:42:11', '2026-09-03 14:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(37, 1, 2, 'ORD-000028', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 700.00, 0.00, 1, 1.00, 0.00, 700.00, '2026-09-03 14:44:26', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:44:26', '2026-09-03 14:44:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(38, 1, 2, 'ORD-000029', NULL, NULL, 15, 2400.00, 0.00, NULL, NULL, 0.00, 2400.00, 2400.00, 0.00, 1, 2.00, 0.00, 2400.00, '2026-09-03 14:48:07', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:48:07', '2026-09-03 14:48:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(39, 1, 2, 'ORD-000030', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 700.00, 0.00, 1, 1.00, 0.00, 700.00, '2026-09-03 14:49:35', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:49:35', '2026-09-03 14:49:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(40, 1, 2, 'ORD-000031', NULL, NULL, 15, 11450.00, 0.00, NULL, NULL, 0.00, 11450.00, 11450.00, 0.00, 3, 3.00, 0.00, 11450.00, '2026-09-03 14:57:36', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 14:57:36', '2026-09-03 14:57:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(41, 1, 2, 'ORD-000032', NULL, NULL, 15, 8600.00, 0.00, NULL, NULL, 0.00, 8600.00, 8600.00, 0.00, 1, 1.00, 0.00, 8600.00, '2026-09-03 15:22:00', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 15:22:00', '2026-09-03 15:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(42, 1, 2, 'ORD-000033', NULL, 10, 15, 90000.00, 5.00, 2, NULL, 0.00, 89995.00, 89995.00, 0.00, 1, 1.00, 0.00, 89995.00, '2026-09-03 20:14:44', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-03 20:14:44', '2026-09-03 20:14:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(72, 1, 2, 'SO-000030', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 0.00, 700.00, 0.00, 0.00, 1, 1.00, 0.00, 700.00, NULL, NULL, 'Pending', 'Draft', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:03:52', '2026-09-04 08:08:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(73, 1, 2, 'ORD-000034', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 52.50, 700.00, 752.50, 0.00, 1, 1.00, 2.50, 752.50, '2026-09-04 08:09:17', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:09:17', '2026-09-04 08:09:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(74, 1, 2, 'ORD-000035', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 52.50, 700.00, 752.50, 0.00, 1, 1.00, 2.50, 752.50, '2026-09-04 08:09:32', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:09:32', '2026-09-04 08:09:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(75, 1, 2, 'ORD-000036', NULL, NULL, 15, 700.00, 0.00, NULL, NULL, 52.50, 700.00, 752.50, 0.00, 1, 1.00, 2.50, 752.50, '2026-09-04 08:17:39', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:17:39', '2026-09-04 08:17:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(76, 1, 2, 'ORD-000037', NULL, NULL, 15, 8600.00, 0.00, NULL, NULL, 645.00, 8600.00, 9245.00, 0.00, 1, 1.00, 0.00, 9245.00, '2026-09-04 08:19:05', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:19:05', '2026-09-04 08:19:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(77, 1, 2, 'ORD-000038', NULL, NULL, 15, 1200.00, 0.00, NULL, NULL, 90.00, 1200.00, 1290.00, 0.00, 1, 1.00, 0.00, 1290.00, '2026-09-04 08:22:48', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:22:48', '2026-09-04 08:22:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(78, 1, 2, 'ORD-000039', NULL, 10, 15, 8600.00, 0.00, NULL, NULL, 645.00, 8600.00, 9245.00, 0.00, 1, 1.00, 5.00, 9245.00, '2026-09-04 08:57:18', NULL, 'Paid', 'Completed', 'POS', 14, 0, NULL, 15, 15, '2026-09-04 08:57:18', '2026-09-04 08:57:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(79, 1, 2, 'ORD-000040', NULL, NULL, 15, 1200.00, 0.00, NULL, NULL, 90.00, 1200.00, 1290.00, 0.00, 1, 1.00, 0.00, 1290.00, '2026-09-14 13:30:52', NULL, 'Paid', 'Completed', 'POS', 14, 0, '1290', 15, 15, '2026-09-14 13:30:52', '2026-09-14 13:30:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(80, 1, 4, 'ORD-000041', NULL, 9, 1, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 0.00, 0.00, 1, 1.00, 0.00, 1200.00, '2026-09-14 13:38:08', NULL, 'Refunded', 'Refunded', 'POS', 12, 0, NULL, 1, 1, '2026-09-14 13:32:47', '2026-09-16 10:21:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(81, 1, 1, 'ORD-000042', NULL, 6, 1, 3350.00, 0.00, NULL, NULL, 0.00, 3350.00, 3350.00, 0.00, 3, 4.00, 0.00, 3350.00, '2026-09-16 10:40:05', NULL, 'Paid', 'Completed', 'POS', 1, 0, NULL, 1, 1, '2026-09-16 10:39:51', '2026-09-16 10:40:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(82, 1, 1, 'ORD-000043', NULL, NULL, 1, 10500.00, 0.00, NULL, NULL, 0.00, 10500.00, 0.00, 0.00, 4, 10.00, 0.00, 10500.00, '2026-09-16 12:02:34', NULL, 'Refunded', 'Refunded', 'POS', 2, 0, NULL, 1, 1, '2026-09-16 12:02:21', '2026-09-16 12:03:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(83, 1, 1, 'ORD-000044', NULL, 11, NULL, 102000.00, 0.00, NULL, NULL, 0.00, 102000.00, 102000.00, 0.00, 3, 5.00, 0.00, 102000.00, '2026-09-26 22:47:47', NULL, 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-26 22:47:27', '2026-09-26 22:47:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(84, 1, 1, 'ORD-000045', NULL, 6, NULL, 2400.00, 0.00, NULL, NULL, 0.00, 2400.00, 2400.00, 0.00, 1, 2.00, 0.00, 2400.00, '2026-09-26 22:58:41', NULL, 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-26 22:58:30', '2026-09-26 22:58:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(85, 1, 1, 'ORD-000046', NULL, 6, NULL, 90000.00, 0.00, NULL, NULL, 0.00, 90000.00, 90000.00, 0.00, 1, 1.00, 0.00, 90000.00, '2026-09-26 23:06:08', NULL, 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-26 23:05:55', '2026-09-26 23:06:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(86, 1, 1, 'ORD-000047', NULL, 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 8600.00, 8600.00, 0.00, 1, 1.00, 0.00, 8600.00, '2026-09-27 12:41:34', NULL, 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 12:41:11', '2026-09-27 12:41:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(87, 1, 1, 'ORD-000048', 'ErWD483I7IaAV60zTMxWEKxBElTSu3ciDd8hlgevjZzbHZ3uyvdvuhzTAzv9KJxx', 6, NULL, 1200.00, 0.00, NULL, NULL, 0.00, 1200.00, 1200.00, 0.00, 1, 1.00, 0.00, 1200.00, '2026-09-27 20:45:24', '2026-09-27 20:45:32', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 20:45:10', '2026-09-27 20:45:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(88, 1, 1, 'ORD-000049', 'DsGJpjiCuVTUQaYxWux23Mo3VKd2hMJXXmGN2aXF66bg9Dsse9vucktsmlJQBe2G', 6, NULL, 1400.00, 0.00, NULL, NULL, 0.00, 1400.00, 1400.00, 0.00, 1, 2.00, 0.00, 1400.00, '2026-09-27 20:57:54', '2026-09-27 20:58:01', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 20:57:42', '2026-09-27 20:58:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(89, 1, 1, 'ORD-000050', 'Z911OZH1ccBjrfjE4KJXskjCnxMay2FttjHGRkW3rCm44AeSoL3hZFPBbwQEoYP4', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 13600.00, 0.00, 13600.00, 1, 1.00, 0.00, 13600.00, NULL, NULL, 'Pending', 'Draft', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:43:35', '2026-09-27 22:43:35', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(90, 1, 1, 'ORD-000051', 'MUU1csetosHt8zV2dZxp2SJOzOECeTyt39jWA4TmjZtXAT7MGenBOOTujv6w3Pg6', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 13600.00, 0.00, 13600.00, 1, 1.00, 0.00, 13600.00, NULL, NULL, 'Pending', 'Draft', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:44:26', '2026-09-27 22:44:26', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(91, 1, 1, 'ORD-000052', 'VzZZegmG53RHlLKw6mvB1CHOeJLUYzyc9hV9VD87b6fyascZW4Xhbu2wjIHivEa5', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 13600.00, 0.00, 13600.00, 1, 1.00, 0.00, 13600.00, NULL, NULL, 'Pending', 'Draft', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:45:38', '2026-09-27 22:45:38', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(92, 1, 1, 'ORD-000053', 'AJdG6lOR1TYKNZt6ibFUEJQlt8l94TCZfjv3IpqNajTbKcA3RtqiQyHcGgGsvvVI', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 14100.00, 0.00, 14100.00, 1, 1.00, 0.00, 14100.00, NULL, NULL, 'Pending', 'Draft', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:47:00', '2026-09-27 22:47:00', NULL, 'location', 2, 'Challenge Terminal 1', NULL, NULL, NULL, 5500.00, 'Pending', NULL, NULL, NULL, NULL),
(93, 1, 1, 'ORD-000054', '4eF1SSEEodHXoB38AScPF9OKKR4HuigTQ30k6rwEL1EaH4avmKZq6xh3mDzRQosE', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 13600.00, 13600.00, 0.00, 1, 1.00, 0.00, 13600.00, '2026-09-27 22:51:27', '2026-09-27 22:51:33', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:51:17', '2026-09-27 22:51:33', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(94, 1, 1, 'ORD-000055', 'Y0eE30j0KK6MkXqyQtF4IS5EjE9WVYUEQzf9SKuJm0VKEKCZUTNgHzFovFZSnoKA', 6, NULL, 700.00, 0.00, NULL, NULL, 0.00, 6200.00, 6200.00, 0.00, 1, 1.00, 0.00, 6200.00, '2026-09-27 23:00:03', '2026-09-27 23:00:11', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 22:59:50', '2026-09-27 23:00:11', NULL, 'location', 2, 'Challenge Terminal 1', NULL, NULL, NULL, 5500.00, 'Pending', NULL, NULL, NULL, NULL),
(95, 1, 1, 'ORD-000056', 'zy9WFMQW6Gh9KCXs9NHNkuymYU3DWJcwX8Mj40c3djPfEer6NxkWaO7nul7cGQmI', 6, NULL, 1200.00, 0.00, NULL, NULL, 0.00, 6200.00, 6200.00, 0.00, 1, 1.00, 0.00, 6200.00, '2026-09-27 23:07:29', '2026-09-27 23:07:37', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 23:07:21', '2026-09-27 23:07:37', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(96, 1, 1, 'ORD-000057', '4kqRbr3BUdEUqeZRDHp8x3aOxatAsdpFBztGsH4S1jZur7gLeri1kv2lvTQhULiJ', 6, NULL, 8600.00, 0.00, NULL, NULL, 0.00, 13600.00, 13600.00, 0.00, 1, 1.00, 0.00, 13600.00, '2026-09-27 23:11:25', '2026-09-27 23:11:33', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 23:11:18', '2026-09-27 23:11:33', NULL, 'location', 1, 'Apata', NULL, NULL, NULL, 5000.00, 'Pending', NULL, NULL, NULL, NULL),
(97, 1, 1, 'ORD-000058', 'ksRsQJU0RsL9tKdENFyQK4Gh6ngw9Uyuc9pEuub8Eo7FoDJwI4hPRLZZPIPdNEyV', 6, NULL, 1000.00, 0.00, NULL, NULL, 0.00, 2000.00, 2000.00, 0.00, 1, 4.00, 0.00, 2000.00, '2026-09-27 23:17:12', '2026-09-27 23:17:18', 'Paid', 'Completed', 'Online', NULL, 0, 'Online Storefront checkout.', NULL, NULL, '2026-09-27 23:17:01', '2026-09-27 23:17:18', NULL, 'manual', NULL, NULL, 'Alaro', 'Ibadan', 'Oyo', 1000.00, 'Pending', NULL, NULL, NULL, NULL);

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
(20, 1, 17, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 82000.00, 0.00, 0.00, 90000.00, '2026-08-28 07:39:36', '2026-08-28 07:39:36'),
(21, 1, 17, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 1450.00, 0.00, 0.00, 1650.00, '2026-08-28 07:39:36', '2026-08-28 07:39:36'),
(22, 1, 18, 19, 'Three Crown Evaporated Milk', 'TH123456', 20.00, 1200.00, 1000.00, 0.00, 0.00, 24000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(23, 1, 18, 8, 'Mama Gold Rice 50kg', '100000000008', 10.00, 90000.00, 82000.00, 0.00, 0.00, 900000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(24, 1, 18, 6, 'Dangote Sugar 1kg', '100000000006', 10.00, 1650.00, 1450.00, 0.00, 0.00, 16500.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(25, 1, 18, 10, 'Pampers Size 3', '100000000010', 5.00, 8600.00, 7800.00, 0.00, 0.00, 43000.00, '2026-08-28 09:23:30', '2026-08-28 09:23:30'),
(26, 1, 19, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-08-28 10:08:09', '2026-08-28 10:08:09'),
(27, 1, 20, 19, 'Three Crown Evaporated Milk', 'TH123456', 50.00, 1200.00, 1000.00, 0.00, 0.00, 60000.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(28, 1, 20, 8, 'Mama Gold Rice 50kg', '100000000008', 5.00, 90000.00, 82000.00, 2.00, 0.00, 449998.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(29, 1, 20, 7, 'Family Bread', '100000000007', 10.00, 1200.00, 900.00, 0.00, 0.00, 12000.00, '2026-08-29 12:02:14', '2026-08-29 12:02:14'),
(30, 1, 21, 2, 'Fanta 50cl', '100000000002', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-08-31 10:09:28', '2026-08-31 10:09:28'),
(31, 1, 22, 2, 'Fanta 50cl', '100000000002', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-08-31 10:10:48', '2026-08-31 10:10:48'),
(50, 1, 28, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(51, 1, 28, 3, 'Sprite 50cl', '100000000003', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(52, 1, 28, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 1450.00, 0.00, 0.00, 1650.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(53, 1, 28, 1, 'Coca-Cola 50cl', '100000000001', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(54, 1, 29, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-09-03 12:53:32', '2026-09-03 12:53:32'),
(55, 1, 30, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 82000.00, 0.00, 0.00, 90000.00, '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(56, 1, 31, 2, 'Fanta 50cl', '100000000002', 2.00, 700.00, 500.00, 0.00, 0.00, 1400.00, '2026-09-03 13:29:17', '2026-09-03 13:29:17'),
(57, 1, 32, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-09-03 14:04:14', '2026-09-03 14:04:14'),
(58, 1, 33, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(59, 1, 34, 4, 'Peak Milk 500g', '100000000004', 1.00, 4800.00, 4200.00, 0.00, 0.00, 4800.00, '2026-09-03 14:41:19', '2026-09-03 14:41:19'),
(60, 1, 35, 5, 'Indomie Chicken Noodles', '100000000005', 1.00, 250.00, 180.00, 0.00, 0.00, 250.00, '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(62, 1, 37, 1, 'Coca-Cola 50cl', '100000000001', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(63, 1, 38, 7, 'Family Bread', '100000000007', 2.00, 1200.00, 900.00, 0.00, 0.00, 2400.00, '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(64, 1, 39, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(65, 1, 40, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(66, 1, 40, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(67, 1, 40, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 1450.00, 0.00, 0.00, 1650.00, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(68, 1, 41, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-03 15:22:00', '2026-09-03 15:22:00'),
(69, 1, 42, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 82000.00, 0.00, 0.00, 90000.00, '2026-09-03 20:14:44', '2026-09-03 20:14:44'),
(97, 1, 72, 9, 'Premier Soap', NULL, 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-04 08:03:52', '2026-09-04 08:03:52'),
(98, 1, 73, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(99, 1, 74, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(100, 1, 75, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(101, 1, 76, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-04 08:19:05', '2026-09-04 08:19:05'),
(102, 1, 77, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-09-04 08:22:48', '2026-09-04 08:22:48'),
(103, 1, 78, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-04 08:57:18', '2026-09-04 08:57:18'),
(104, 1, 79, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-09-14 13:30:52', '2026-09-14 13:30:52'),
(105, 1, 80, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-09-14 13:32:47', '2026-09-14 13:32:47'),
(106, 1, 81, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 1450.00, 0.00, 0.00, 1650.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(107, 1, 81, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(108, 1, 81, 5, 'Indomie Chicken Noodles', '100000000005', 2.00, 250.00, 180.00, 0.00, 0.00, 500.00, '2026-09-16 10:39:51', '2026-09-16 10:39:51'),
(109, 1, 82, 7, 'Family Bread', '100000000007', 2.00, 1200.00, 900.00, 0.00, 0.00, 2400.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(110, 1, 82, 6, 'Dangote Sugar 1kg', '100000000006', 3.00, 1650.00, 1450.00, 0.00, 0.00, 4950.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(111, 1, 82, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 1000.00, 0.00, 0.00, 2400.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(112, 1, 82, 5, 'Indomie Chicken Noodles', '100000000005', 3.00, 250.00, 180.00, 0.00, 0.00, 750.00, '2026-09-16 12:02:21', '2026-09-16 12:02:21'),
(113, 1, 83, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 1000.00, 0.00, 0.00, 2400.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(114, 1, 83, 4, 'Peak Milk 500g', '100000000004', 2.00, 4800.00, 4200.00, 0.00, 0.00, 9600.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(115, 1, 83, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 82000.00, 0.00, 0.00, 90000.00, '2026-09-26 22:47:27', '2026-09-26 22:47:27'),
(116, 1, 84, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 1000.00, 0.00, 0.00, 2400.00, '2026-09-26 22:58:30', '2026-09-26 22:58:30'),
(117, 1, 85, 8, 'Mama Gold Rice 50kg', '100000000008', 1.00, 90000.00, 82000.00, 0.00, 0.00, 90000.00, '2026-09-26 23:05:55', '2026-09-26 23:05:55'),
(118, 1, 86, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 12:41:11', '2026-09-27 12:41:11'),
(119, 1, 87, 19, 'Three Crown Evaporated Milk', 'TH123456', 1.00, 1200.00, 1000.00, 0.00, 0.00, 1200.00, '2026-09-27 20:45:10', '2026-09-27 20:45:10'),
(120, 1, 88, 1, 'Coca-Cola 50cl', '100000000001', 2.00, 700.00, 500.00, 0.00, 0.00, 1400.00, '2026-09-27 20:57:42', '2026-09-27 20:57:42'),
(121, 1, 89, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 22:43:35', '2026-09-27 22:43:35'),
(122, 1, 90, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 22:44:26', '2026-09-27 22:44:26'),
(123, 1, 91, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 22:45:38', '2026-09-27 22:45:38'),
(124, 1, 92, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 22:47:00', '2026-09-27 22:47:00'),
(125, 1, 93, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 22:51:17', '2026-09-27 22:51:17'),
(126, 1, 94, 9, 'Premier Soap', '100000000009', 1.00, 700.00, 500.00, 0.00, 0.00, 700.00, '2026-09-27 22:59:50', '2026-09-27 22:59:50'),
(127, 1, 95, 7, 'Family Bread', '100000000007', 1.00, 1200.00, 900.00, 0.00, 0.00, 1200.00, '2026-09-27 23:07:21', '2026-09-27 23:07:21'),
(128, 1, 96, 10, 'Pampers Size 3', '100000000010', 1.00, 8600.00, 7800.00, 0.00, 0.00, 8600.00, '2026-09-27 23:11:18', '2026-09-27 23:11:18'),
(129, 1, 97, 5, 'Indomie Chicken Noodles', '100000000005', 4.00, 250.00, 180.00, 0.00, 0.00, 1000.00, '2026-09-27 23:17:01', '2026-09-27 23:17:01');

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
  `payment_method` enum('Cash','POS','Transfer','Wallet','Credit','Cheque','Card') NOT NULL,
  `payment_date` datetime NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `company_id`, `branch_id`, `order_id`, `customer_id`, `terminal_id`, `amount`, `payment_status`, `payment_method_id`, `payment_method`, `payment_date`, `transaction_reference`, `payment_gateway`, `reference_no`, `remarks`, `received_by`, `payment_number`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 17, NULL, 12, 92000.00, 'Completed', 3, 'Transfer', '2026-08-28 10:20:27', NULL, NULL, 'ORD-000014', 'Payment received for sales order: ORD-000014', 1, 'PAY-000001', '2026-08-28 09:20:27', '2026-08-28 09:20:27'),
(4, 1, 1, 18, 6, 1, 150000.00, 'Completed', 4, 'Wallet', '2026-08-28 10:47:04', NULL, NULL, 'ORD-000015', 'Payment received for sales order: ORD-000015', 1, 'PAY-000002', '2026-08-28 09:47:04', '2026-08-28 09:47:04'),
(5, 1, 1, 18, 6, 1, 100000.00, 'Completed', 3, 'Transfer', '2026-08-28 10:51:43', NULL, NULL, 'ORD-000015', 'Payment received for sales order: ORD-000015', 1, 'PAY-000003', '2026-08-28 09:51:43', '2026-08-28 09:51:43'),
(6, 1, 1, 18, 6, 1, 200000.00, 'Completed', 3, 'Transfer', '2026-08-28 11:06:21', NULL, NULL, 'ORD-000015', 'Payment received for sales order: ORD-000015', 1, 'PAY-000004', '2026-08-28 10:06:21', '2026-08-28 10:06:21'),
(7, 1, 1, 18, 6, 1, 500000.00, 'Completed', 3, 'Transfer', '2026-08-28 11:07:01', NULL, NULL, 'ORD-000015', 'Payment received for sales order: ORD-000015', 1, 'PAY-000005', '2026-08-28 10:07:01', '2026-08-28 10:07:01'),
(8, 1, 1, 18, 6, 1, 33500.00, 'Completed', 3, 'Transfer', '2026-08-28 11:11:22', NULL, NULL, 'ORD-000015', 'Payment received for sales order: ORD-000015', 1, 'PAY-000006', '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(9, 1, 1, 20, 9, 2, 150000.00, 'Completed', 3, 'Transfer', '2026-08-29 13:02:39', NULL, NULL, 'ORD-000017', 'Payment received for sales order: ORD-000017', 1, 'PAY-000007', '2026-08-29 12:02:39', '2026-08-29 12:02:39'),
(12, 1, 2, 22, NULL, 14, 700.00, 'Completed', 1, 'Cash', '2026-08-31 11:15:05', NULL, NULL, 'ORD-000019', 'Payment received for sales order: ORD-000019', 17, 'PAY-000008', '2026-08-31 10:15:05', '2026-08-31 10:15:05'),
(14, 1, 2, 28, NULL, 14, 4250.00, 'Completed', 1, 'Cash', '2026-09-02 12:38:01', NULL, NULL, NULL, NULL, 15, 'PAY-000009', '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(15, 1, 2, 29, NULL, 14, 1200.00, 'Completed', 1, 'Cash', '2026-09-03 13:53:33', NULL, NULL, NULL, NULL, 15, 'PAY-000010', '2026-09-03 12:53:33', '2026-09-03 12:53:33'),
(16, 1, 2, 30, NULL, 14, 90000.00, 'Completed', 1, 'Cash', '2026-09-03 14:26:09', NULL, NULL, NULL, NULL, 15, 'PAY-000011', '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(17, 1, 2, 31, NULL, 14, 1400.00, 'Completed', 1, 'Cash', '2026-09-03 14:30:47', NULL, NULL, 'ORD-000023', 'Payment received for sales order: ORD-000023', 17, 'PAY-000012', '2026-09-03 13:30:47', '2026-09-03 13:30:47'),
(18, 1, 2, 32, NULL, 14, 1200.00, 'Completed', 3, 'Transfer', '2026-09-03 15:04:14', NULL, NULL, 'trf393939', NULL, 15, 'PAY-000013', '2026-09-03 14:04:14', '2026-09-03 14:04:14'),
(19, 1, 2, 33, NULL, 14, 700.00, 'Completed', 1, 'Cash', '2026-09-03 15:35:52', NULL, NULL, NULL, NULL, 15, 'PAY-000014', '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(20, 1, 2, 34, NULL, 14, 4800.00, 'Completed', 3, 'Transfer', '2026-09-03 15:41:19', NULL, NULL, 'trf4566', NULL, 15, 'PAY-000015', '2026-09-03 14:41:19', '2026-09-03 14:41:19'),
(21, 1, 2, 35, NULL, 14, 250.00, 'Completed', 1, 'Cash', '2026-09-03 15:42:11', NULL, NULL, NULL, NULL, 15, 'PAY-000016', '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(22, 1, 2, 37, NULL, 14, 700.00, 'Completed', 1, 'Cash', '2026-09-03 15:44:26', NULL, NULL, 'cs346464', NULL, 15, 'PAY-000017', '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(23, 1, 2, 38, NULL, 14, 2400.00, 'Completed', 1, 'Cash', '2026-09-03 15:48:07', NULL, NULL, NULL, NULL, 15, 'PAY-000018', '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(24, 1, 2, 39, NULL, 14, 700.00, 'Completed', 1, 'Cash', '2026-09-03 15:49:35', NULL, NULL, NULL, NULL, 15, 'PAY-000019', '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(25, 1, 2, 40, NULL, 14, 11450.00, 'Completed', 1, 'Cash', '2026-09-03 15:57:36', NULL, NULL, NULL, NULL, 15, 'PAY-000020', '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(26, 1, 2, 41, NULL, 14, 8600.00, 'Completed', 8, 'Card', '2026-09-03 16:22:00', NULL, NULL, 'dccrr333455', NULL, 15, 'PAY-000021', '2026-09-03 15:22:00', '2026-09-03 15:22:00'),
(27, 1, 2, 42, 10, 14, 89995.00, 'Completed', 8, 'Card', '2026-09-03 21:14:44', NULL, NULL, 'tr3494848494', NULL, 15, 'PAY-000022', '2026-09-03 20:14:44', '2026-09-03 20:14:44'),
(28, 1, 2, 73, NULL, 14, 752.50, 'Completed', 1, 'Cash', '2026-09-04 09:09:17', NULL, NULL, NULL, NULL, 15, 'PAY-000023', '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(29, 1, 2, 74, NULL, 14, 752.50, 'Completed', 1, 'Cash', '2026-09-04 09:09:32', NULL, NULL, NULL, NULL, 15, 'PAY-000024', '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(30, 1, 2, 75, NULL, 14, 752.50, 'Completed', 1, 'Cash', '2026-09-04 09:17:39', NULL, NULL, NULL, NULL, 15, 'PAY-000025', '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(31, 1, 2, 76, NULL, 14, 9245.00, 'Completed', 3, 'Transfer', '2026-09-04 09:19:05', NULL, NULL, 'yr83839929', NULL, 15, 'PAY-000026', '2026-09-04 08:19:05', '2026-09-04 08:19:05'),
(32, 1, 2, 77, NULL, 14, 1290.00, 'Completed', 8, 'Card', '2026-09-04 09:22:48', NULL, NULL, 'card-2039393030', NULL, 15, 'PAY-000027', '2026-09-04 08:22:48', '2026-09-04 08:22:48'),
(33, 1, 2, 78, 10, 14, 9245.00, 'Completed', 1, 'Cash', '2026-09-04 09:57:18', NULL, NULL, NULL, NULL, 15, 'PAY-000028', '2026-09-04 08:57:18', '2026-09-04 08:57:18'),
(34, 1, 2, 79, NULL, 14, 1290.00, 'Completed', 3, 'Transfer', '2026-09-14 14:30:52', NULL, NULL, 'yr8df345', '1290', 15, 'PAY-000029', '2026-09-14 13:30:52', '2026-09-14 13:30:52'),
(38, 1, 4, 80, 9, 12, 1200.00, 'Refunded', 3, 'Transfer', '2026-09-14 14:38:08', NULL, NULL, 'ORD-000041', 'Payment received for sales order: ORD-000041', 1, 'PAY-000030', '2026-09-14 13:38:08', '2026-09-16 10:21:18'),
(39, 1, 1, 81, 6, 1, 3350.00, 'Completed', 8, 'Card', '2026-09-16 11:40:05', NULL, NULL, 'ORD-000042', 'Payment received for sales order: ORD-000042', 1, 'PAY-000031', '2026-09-16 10:40:05', '2026-09-16 10:40:05'),
(40, 1, 1, 82, NULL, 2, 10500.00, 'Refunded', 3, 'Transfer', '2026-09-16 13:02:34', NULL, NULL, 'ORD-000043', 'Payment received for sales order: ORD-000043', 1, 'PAY-000032', '2026-09-16 12:02:34', '2026-09-16 12:03:19'),
(41, 1, 1, 83, 11, NULL, 102000.00, 'Completed', 3, 'Transfer', '2026-09-26 23:47:47', 'SF-83-COBK6FO0P4AG', 'Paystack', 'ORD-000044', 'Paystack online payment. Channel: card. Order: ORD-000044', NULL, 'PAY-000033', '2026-09-26 22:47:47', '2026-09-26 22:47:47'),
(42, 1, 1, 84, 6, NULL, 2400.00, 'Completed', 3, 'Transfer', '2026-09-26 23:58:41', 'SF-84-NA3FR2BEYHUX', 'Paystack', 'ORD-000045', 'Paystack online payment. Channel: card. Order: ORD-000045', NULL, 'PAY-000034', '2026-09-26 22:58:41', '2026-09-26 22:58:41'),
(43, 1, 1, 85, 6, NULL, 90000.00, 'Completed', 3, 'Card', '2026-09-27 00:06:08', 'SF-85-DPQOBB2RTVAX', 'Paystack', 'ORD-000046', 'Paystack online payment. Channel: card. Order: ORD-000046', NULL, 'PAY-000035', '2026-09-26 23:06:08', '2026-09-26 23:06:08'),
(44, 1, 1, 86, 6, NULL, 8600.00, 'Completed', 3, 'Card', '2026-09-27 13:41:34', 'SF-86-IADNVYRYWIMT', 'Paystack', 'ORD-000047', 'Paystack online payment. Channel: card. Order: ORD-000047', NULL, 'PAY-000036', '2026-09-27 12:41:34', '2026-09-27 12:41:34'),
(45, 1, 1, 87, 6, NULL, 1200.00, 'Completed', 3, 'Card', '2026-09-27 21:45:24', 'SF-87-JLY0A7ZD6Q8T', 'Paystack', 'ORD-000048', 'Paystack online payment. Channel: card. Order: ORD-000048', NULL, 'PAY-000037', '2026-09-27 20:45:24', '2026-09-27 20:45:24'),
(46, 1, 1, 88, 6, NULL, 1400.00, 'Completed', 3, 'Card', '2026-09-27 21:57:54', 'SF-88-FBZSOD6W2OPF', 'Paystack', 'ORD-000049', 'Paystack online payment. Channel: card. Order: ORD-000049', NULL, 'PAY-000038', '2026-09-27 20:57:54', '2026-09-27 20:57:54'),
(47, 1, 1, 93, 6, NULL, 13600.00, 'Completed', 3, 'Card', '2026-09-27 23:51:27', 'SF-93-U88XHLCXEBIY', 'Paystack', 'ORD-000054', 'Paystack online payment. Channel: card. Order: ORD-000054', NULL, 'PAY-000039', '2026-09-27 22:51:27', '2026-09-27 22:51:27'),
(48, 1, 1, 94, 6, NULL, 6200.00, 'Completed', 3, 'Card', '2026-09-28 00:00:03', 'SF-94-DZOPVIZMX5AI', 'Paystack', 'ORD-000055', 'Paystack online payment. Channel: card. Order: ORD-000055', NULL, 'PAY-000040', '2026-09-27 23:00:03', '2026-09-27 23:00:03'),
(49, 1, 1, 95, 6, NULL, 6200.00, 'Completed', 3, 'Card', '2026-09-28 00:07:29', 'SF-95-3PR9F3C03VG7', 'Paystack', 'ORD-000056', 'Paystack online payment. Channel: card. Order: ORD-000056', NULL, 'PAY-000041', '2026-09-27 23:07:29', '2026-09-27 23:07:29'),
(50, 1, 1, 96, 6, NULL, 13600.00, 'Completed', 3, 'Card', '2026-09-28 00:11:25', 'SF-96-4GRJHYKKTL5A', 'Paystack', 'ORD-000057', 'Paystack online payment. Channel: card. Order: ORD-000057', NULL, 'PAY-000042', '2026-09-27 23:11:25', '2026-09-27 23:11:25'),
(51, 1, 1, 97, 6, NULL, 2000.00, 'Completed', 3, 'Card', '2026-09-28 00:17:12', 'SF-97-YIDUCX9FHZ17', 'Paystack', 'ORD-000058', 'Paystack online payment. Channel: card. Order: ORD-000058', NULL, 'PAY-000043', '2026-09-27 23:17:12', '2026-09-27 23:17:12');

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
(1, 1, 'Cash', 'CASH', 'bi-cash', 'success', 0, 1, 1, 1, 1, '2026-08-02 09:51:36', '2026-08-02 11:43:07', NULL),
(3, 1, 'Transfer', 'TRANSFER', 'bi-bank', 'info', 1, 0, 0, 3, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(4, 1, 'Wallet', 'WALLET', 'bi-wallet2', 'warning', 0, 0, 0, 4, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(8, 1, 'Card', 'CARD', 'bi-credit-card', 'dark', 1, 0, 0, 1, 1, '2026-09-03 15:02:29', '2026-09-03 15:02:29', NULL),
(9, 4, 'Cash', 'CASH', 'bi-cash', 'success', 0, 1, 1, 1, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(10, 4, 'POS', 'POS', 'bi-credit-card', 'primary', 1, 0, 0, 2, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(11, 4, 'Transfer', 'TRANSFER', 'bi-bank', 'info', 1, 0, 0, 3, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(12, 4, 'Wallet', 'WALLET', 'bi-wallet2', 'warning', 0, 0, 0, 4, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(13, 4, 'Credit', 'CREDIT', 'bi-person-lines-fill', 'secondary', 0, 0, 0, 5, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(14, 4, 'Cheque', 'CHEQUE', 'bi-receipt', 'dark', 1, 0, 0, 6, 1, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(15, 5, 'Cash', 'CASH', 'bi-cash', 'success', 0, 1, 1, 1, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL),
(16, 5, 'POS', 'POS', 'bi-credit-card', 'primary', 1, 0, 0, 2, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL),
(17, 5, 'Transfer', 'TRANSFER', 'bi-bank', 'info', 1, 0, 0, 3, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL),
(18, 5, 'Wallet', 'WALLET', 'bi-wallet2', 'warning', 0, 0, 0, 4, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL),
(19, 5, 'Credit', 'CREDIT', 'bi-person-lines-fill', 'secondary', 0, 0, 0, 5, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL),
(20, 5, 'Cheque', 'CHEQUE', 'bi-receipt', 'dark', 1, 0, 0, 6, 1, '2026-09-26 20:02:57', '2026-09-26 20:02:57', NULL);

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
(1, 1, 'Dashboard', 'dashboard.view', 'dashboard.view', 'View Dashboard', 'View Dashboard', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:36', NULL),
(2, 1, 'Company', 'company.view', 'company.view', 'View Company', 'View Company', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(3, 1, 'Company', 'company.update', 'company.update', 'Update Company', 'Update Company', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(4, 1, 'Branches', 'branches.view', 'branches.view', 'View Branches', 'View Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(5, 1, 'Branches', 'branches.create', 'branches.create', 'Create Branches', 'Create Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(6, 1, 'Branches', 'branches.update', 'branches.update', 'Update Branches', 'Update Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(7, 1, 'Branches', 'branches.delete', 'branches.delete', 'Delete Branches', 'Delete Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(8, 1, 'Branches', 'branches.analytics', 'branches.analytics', 'Analytics Branches', 'Analytics Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(9, 1, 'Branches', 'branches.export', 'branches.export', 'Export Branches', 'Export Branches', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(10, 1, 'Terminals', 'terminals.view', 'terminals.view', 'View Terminals', 'View Terminals', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(11, 1, 'Terminals', 'terminals.create', 'terminals.create', 'Create Terminals', 'Create Terminals', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(12, 1, 'Terminals', 'terminals.update', 'terminals.update', 'Update Terminals', 'Update Terminals', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(13, 1, 'Terminals', 'terminals.delete', 'terminals.delete', 'Delete Terminals', 'Delete Terminals', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(14, 1, 'Users', 'users.view', 'users.view', 'View Users', 'View Users', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(15, 1, 'Users', 'users.create', 'users.create', 'Create Users', 'Create Users', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(16, 1, 'Users', 'users.update', 'users.update', 'Update Users', 'Update Users', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(17, 1, 'Users', 'users.delete', 'users.delete', 'Delete Users', 'Delete Users', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(18, 1, 'Users', 'users.reset_password', 'users.reset_password', 'Reset Password Users', 'Reset Password Users', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(19, 1, 'Roles', 'roles.view', 'roles.view', 'View Roles', 'View Roles', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(20, 1, 'Roles', 'roles.create', 'roles.create', 'Create Roles', 'Create Roles', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(21, 1, 'Roles', 'roles.update', 'roles.update', 'Update Roles', 'Update Roles', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(22, 1, 'Roles', 'roles.delete', 'roles.delete', 'Delete Roles', 'Delete Roles', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(23, 1, 'Roles', 'roles.assign_permissions', 'roles.assign_permissions', 'Assign Permissions Roles', 'Assign Permissions Roles', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(24, 1, 'Permissions', 'permissions.view', 'permissions.view', 'View Permissions', 'View Permissions', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(25, 1, 'Products', 'products.view', 'products.view', 'View Products', 'View Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(26, 1, 'Products', 'products.create', 'products.create', 'Create Products', 'Create Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(27, 1, 'Products', 'products.update', 'products.update', 'Update Products', 'Update Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(28, 1, 'Products', 'products.delete', 'products.delete', 'Delete Products', 'Delete Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(29, 1, 'Products', 'products.import', 'products.import', 'Import Products', 'Import Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(30, 1, 'Products', 'products.export', 'products.export', 'Export Products', 'Export Products', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(31, 1, 'Categories', 'categories.view', 'categories.view', 'View Categories', 'View Categories', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(32, 1, 'Categories', 'categories.create', 'categories.create', 'Create Categories', 'Create Categories', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(33, 1, 'Categories', 'categories.update', 'categories.update', 'Update Categories', 'Update Categories', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(34, 1, 'Categories', 'categories.delete', 'categories.delete', 'Delete Categories', 'Delete Categories', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(35, 1, 'Units', 'units.view', 'units.view', 'View Units', 'View Units', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(36, 1, 'Units', 'units.create', 'units.create', 'Create Units', 'Create Units', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(37, 1, 'Units', 'units.update', 'units.update', 'Update Units', 'Update Units', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(38, 1, 'Units', 'units.delete', 'units.delete', 'Delete Units', 'Delete Units', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(39, 1, 'Tax Rates', 'tax_rates.view', 'tax_rates.view', 'View Tax Rates', 'View Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(40, 1, 'Tax Rates', 'tax_rates.create', 'tax_rates.create', 'Create Tax Rates', 'Create Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(41, 1, 'Tax Rates', 'tax_rates.update', 'tax_rates.update', 'Update Tax Rates', 'Update Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(42, 1, 'Tax Rates', 'tax_rates.delete', 'tax_rates.delete', 'Delete Tax Rates', 'Delete Tax Rates', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(43, 1, 'Discounts', 'discounts.view', 'discounts.view', 'View Discounts', 'View Discounts', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(44, 1, 'Discounts', 'discounts.create', 'discounts.create', 'Create Discounts', 'Create Discounts', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(45, 1, 'Discounts', 'discounts.update', 'discounts.update', 'Update Discounts', 'Update Discounts', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(46, 1, 'Discounts', 'discounts.delete', 'discounts.delete', 'Delete Discounts', 'Delete Discounts', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(47, 1, 'Inventory', 'inventory.view', 'inventory.view', 'View Inventory', 'View Inventory', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(48, 1, 'Inventory', 'inventory.adjust_stock', 'inventory.adjust_stock', 'Adjust Stock Inventory', 'Adjust Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(49, 1, 'Inventory', 'inventory.transfer_stock', 'inventory.transfer_stock', 'Transfer Stock Inventory', 'Transfer Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(50, 1, 'Inventory', 'inventory.stock_count', 'inventory.stock_count', 'Stock Count Inventory', 'Stock Count Inventory', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(51, 1, 'Inventory', 'inventory.low_stock', 'inventory.low_stock', 'Low Stock Inventory', 'Low Stock Inventory', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(52, 1, 'Customers', 'customers.view', 'customers.view', 'View Customers', 'View Customers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(53, 1, 'Customers', 'customers.create', 'customers.create', 'Create Customers', 'Create Customers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(54, 1, 'Customers', 'customers.update', 'customers.update', 'Update Customers', 'Update Customers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(55, 1, 'Customers', 'customers.delete', 'customers.delete', 'Delete Customers', 'Delete Customers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(56, 1, 'Customers', 'customers.export', 'customers.export', 'Export Customers', 'Export Customers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(57, 1, 'Suppliers', 'suppliers.view', 'suppliers.view', 'View Suppliers', 'View Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(58, 1, 'Suppliers', 'suppliers.create', 'suppliers.create', 'Create Suppliers', 'Create Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(59, 1, 'Suppliers', 'suppliers.update', 'suppliers.update', 'Update Suppliers', 'Update Suppliers', 1, 1, '2026-07-29 10:37:09', '2026-09-27 21:18:37', NULL),
(60, 1, 'Suppliers', 'suppliers.delete', 'suppliers.delete', 'Delete Suppliers', 'Delete Suppliers', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(61, 1, 'Purchases', 'purchases.view', 'purchases.view', 'View Purchases', 'View Purchases', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(62, 1, 'Purchases', 'purchases.create', 'purchases.create', 'Create Purchases', 'Create Purchases', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(63, 1, 'Purchases', 'purchases.update', 'purchases.update', 'Update Purchases', 'Update Purchases', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(64, 1, 'Purchases', 'purchases.delete', 'purchases.delete', 'Delete Purchases', 'Delete Purchases', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(65, 1, 'Purchases', 'purchases.approve', 'purchases.approve', 'Approve Purchases', 'Approve Purchases', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(66, 1, 'Pos', 'pos.sell', 'pos.sell', 'Sell Pos', 'Sell Pos', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(67, 1, 'Pos', 'pos.hold_sale', 'pos.hold_sale', 'Hold Sale Pos', 'Hold Sale Pos', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(68, 1, 'Pos', 'pos.open_orders', 'pos.open_orders', 'Open Orders Pos', 'Open Orders Pos', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(69, 1, 'Pos', 'pos.return_sale', 'pos.return_sale', 'Return Sale Pos', 'Return Sale Pos', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(70, 1, 'Pos', 'pos.cash_drawer', 'pos.cash_drawer', 'Cash Drawer Pos', 'Cash Drawer Pos', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(71, 1, 'Orders', 'orders.view', 'orders.view', 'View Orders', 'View Orders', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(72, 1, 'Orders', 'orders.create', 'orders.create', 'Create Orders', 'Create Orders', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(73, 1, 'Orders', 'orders.update', 'orders.update', 'Update Orders', 'Update Orders', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(74, 1, 'Orders', 'orders.cancel', 'orders.cancel', 'Cancel Orders', 'Cancel Orders', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(75, 1, 'Orders', 'orders.refund', 'orders.refund', 'Refund Orders', 'Refund Orders', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(76, 1, 'Payments', 'payments.view', 'payments.view', 'View Payments', 'View Payments', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(77, 1, 'Payments', 'payments.create', 'payments.create', 'Create Payments', 'Create Payments', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(78, 1, 'Payments', 'payments.refund', 'payments.refund', 'Refund Payments', 'Refund Payments', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(79, 1, 'Reports', 'reports.sales', 'reports.sales', 'Sales Reports', 'Sales Reports', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(80, 1, 'Reports', 'reports.inventory', 'reports.inventory', 'Inventory Reports', 'Inventory Reports', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(81, 1, 'Reports', 'reports.profit_loss', 'reports.profit_loss', 'Profit Loss Reports', 'Profit Loss Reports', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(82, 1, 'Reports', 'reports.tax', 'reports.tax', 'Tax Reports', 'Tax Reports', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(83, 1, 'Settings', 'settings.view', 'settings.view', 'View Settings', 'View Settings', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(84, 1, 'Settings', 'settings.update', 'settings.update', 'Update Settings', 'Update Settings', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(85, 1, 'Document Sequences', 'document_sequences.view', 'document_sequences.view', 'View Document Sequences', 'View Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(86, 1, 'Document Sequences', 'document_sequences.create', 'document_sequences.create', 'Create Document Sequences', 'Create Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(87, 1, 'Document Sequences', 'document_sequences.update', 'document_sequences.update', 'Update Document Sequences', 'Update Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(88, 1, 'Document Sequences', 'document_sequences.delete', 'document_sequences.delete', 'Delete Document Sequences', 'Delete Document Sequences', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(89, 1, 'Payment Methods', 'payment_methods.view', 'payment_methods.view', 'View Payment Methods', 'View Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(90, 1, 'Payment Methods', 'payment_methods.create', 'payment_methods.create', 'Create Payment Methods', 'Create Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(91, 1, 'Payment Methods', 'payment_methods.update', 'payment_methods.update', 'Update Payment Methods', 'Update Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(92, 1, 'Payment Methods', 'payment_methods.delete', 'payment_methods.delete', 'Delete Payment Methods', 'Delete Payment Methods', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(93, 1, 'Audit Logs', 'audit_logs.view', 'audit_logs.view', 'View Audit Logs', 'View Audit Logs', 1, 1, '2026-07-29 10:37:10', '2026-09-27 21:18:37', NULL),
(290, 4, 'Dashboard', 'dashboard.view', 'dashboard.view', 'View Dashboard', 'View Dashboard', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(291, 4, 'Company', 'company.view', 'company.view', 'View Company', 'View Company', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(292, 4, 'Company', 'company.update', 'company.update', 'Update Company', 'Update Company', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(293, 4, 'Branches', 'branches.view', 'branches.view', 'View Branches', 'View Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(294, 4, 'Branches', 'branches.create', 'branches.create', 'Create Branches', 'Create Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(295, 4, 'Branches', 'branches.update', 'branches.update', 'Update Branches', 'Update Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(296, 4, 'Branches', 'branches.delete', 'branches.delete', 'Delete Branches', 'Delete Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(297, 4, 'Branches', 'branches.analytics', 'branches.analytics', 'Analytics Branches', 'Analytics Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(298, 4, 'Branches', 'branches.export', 'branches.export', 'Export Branches', 'Export Branches', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(299, 4, 'Terminals', 'terminals.view', 'terminals.view', 'View Terminals', 'View Terminals', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(300, 4, 'Terminals', 'terminals.create', 'terminals.create', 'Create Terminals', 'Create Terminals', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(301, 4, 'Terminals', 'terminals.update', 'terminals.update', 'Update Terminals', 'Update Terminals', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(302, 4, 'Terminals', 'terminals.delete', 'terminals.delete', 'Delete Terminals', 'Delete Terminals', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(303, 4, 'Users', 'users.view', 'users.view', 'View Users', 'View Users', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(304, 4, 'Users', 'users.create', 'users.create', 'Create Users', 'Create Users', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(305, 4, 'Users', 'users.update', 'users.update', 'Update Users', 'Update Users', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(306, 4, 'Users', 'users.delete', 'users.delete', 'Delete Users', 'Delete Users', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(307, 4, 'Users', 'users.reset_password', 'users.reset_password', 'Reset Password Users', 'Reset Password Users', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(308, 4, 'Roles', 'roles.view', 'roles.view', 'View Roles', 'View Roles', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(309, 4, 'Roles', 'roles.create', 'roles.create', 'Create Roles', 'Create Roles', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(310, 4, 'Roles', 'roles.update', 'roles.update', 'Update Roles', 'Update Roles', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(311, 4, 'Roles', 'roles.delete', 'roles.delete', 'Delete Roles', 'Delete Roles', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(312, 4, 'Roles', 'roles.assign_permissions', 'roles.assign_permissions', 'Assign Permissions Roles', 'Assign Permissions Roles', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(313, 4, 'Permissions', 'permissions.view', 'permissions.view', 'View Permissions', 'View Permissions', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(314, 4, 'Products', 'products.view', 'products.view', 'View Products', 'View Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(315, 4, 'Products', 'products.create', 'products.create', 'Create Products', 'Create Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(316, 4, 'Products', 'products.update', 'products.update', 'Update Products', 'Update Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(317, 4, 'Products', 'products.delete', 'products.delete', 'Delete Products', 'Delete Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(318, 4, 'Products', 'products.import', 'products.import', 'Import Products', 'Import Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(319, 4, 'Products', 'products.export', 'products.export', 'Export Products', 'Export Products', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(320, 4, 'Categories', 'categories.view', 'categories.view', 'View Categories', 'View Categories', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(321, 4, 'Categories', 'categories.create', 'categories.create', 'Create Categories', 'Create Categories', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(322, 4, 'Categories', 'categories.update', 'categories.update', 'Update Categories', 'Update Categories', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(323, 4, 'Categories', 'categories.delete', 'categories.delete', 'Delete Categories', 'Delete Categories', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(324, 4, 'Units', 'units.view', 'units.view', 'View Units', 'View Units', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(325, 4, 'Units', 'units.create', 'units.create', 'Create Units', 'Create Units', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(326, 4, 'Units', 'units.update', 'units.update', 'Update Units', 'Update Units', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(327, 4, 'Units', 'units.delete', 'units.delete', 'Delete Units', 'Delete Units', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(328, 4, 'Tax Rates', 'tax_rates.view', 'tax_rates.view', 'View Tax Rates', 'View Tax Rates', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(329, 4, 'Tax Rates', 'tax_rates.create', 'tax_rates.create', 'Create Tax Rates', 'Create Tax Rates', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(330, 4, 'Tax Rates', 'tax_rates.update', 'tax_rates.update', 'Update Tax Rates', 'Update Tax Rates', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(331, 4, 'Tax Rates', 'tax_rates.delete', 'tax_rates.delete', 'Delete Tax Rates', 'Delete Tax Rates', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(332, 4, 'Discounts', 'discounts.view', 'discounts.view', 'View Discounts', 'View Discounts', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(333, 4, 'Discounts', 'discounts.create', 'discounts.create', 'Create Discounts', 'Create Discounts', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(334, 4, 'Discounts', 'discounts.update', 'discounts.update', 'Update Discounts', 'Update Discounts', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(335, 4, 'Discounts', 'discounts.delete', 'discounts.delete', 'Delete Discounts', 'Delete Discounts', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(336, 4, 'Inventory', 'inventory.view', 'inventory.view', 'View Inventory', 'View Inventory', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(337, 4, 'Inventory', 'inventory.adjust_stock', 'inventory.adjust_stock', 'Adjust Stock Inventory', 'Adjust Stock Inventory', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(338, 4, 'Inventory', 'inventory.transfer_stock', 'inventory.transfer_stock', 'Transfer Stock Inventory', 'Transfer Stock Inventory', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(339, 4, 'Inventory', 'inventory.stock_count', 'inventory.stock_count', 'Stock Count Inventory', 'Stock Count Inventory', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(340, 4, 'Inventory', 'inventory.low_stock', 'inventory.low_stock', 'Low Stock Inventory', 'Low Stock Inventory', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(341, 4, 'Customers', 'customers.view', 'customers.view', 'View Customers', 'View Customers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(342, 4, 'Customers', 'customers.create', 'customers.create', 'Create Customers', 'Create Customers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(343, 4, 'Customers', 'customers.update', 'customers.update', 'Update Customers', 'Update Customers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(344, 4, 'Customers', 'customers.delete', 'customers.delete', 'Delete Customers', 'Delete Customers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(345, 4, 'Customers', 'customers.export', 'customers.export', 'Export Customers', 'Export Customers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(346, 4, 'Customer Groups', 'customer_groups.view', 'customer_groups.view', 'View Customer Groups', 'View Customer Groups', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(347, 4, 'Customer Groups', 'customer_groups.create', 'customer_groups.create', 'Create Customer Groups', 'Create Customer Groups', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(348, 4, 'Customer Groups', 'customer_groups.update', 'customer_groups.update', 'Update Customer Groups', 'Update Customer Groups', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(349, 4, 'Customer Groups', 'customer_groups.delete', 'customer_groups.delete', 'Delete Customer Groups', 'Delete Customer Groups', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(350, 4, 'Suppliers', 'suppliers.view', 'suppliers.view', 'View Suppliers', 'View Suppliers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(351, 4, 'Suppliers', 'suppliers.create', 'suppliers.create', 'Create Suppliers', 'Create Suppliers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(352, 4, 'Suppliers', 'suppliers.update', 'suppliers.update', 'Update Suppliers', 'Update Suppliers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(353, 4, 'Suppliers', 'suppliers.delete', 'suppliers.delete', 'Delete Suppliers', 'Delete Suppliers', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(354, 4, 'Purchases', 'purchases.view', 'purchases.view', 'View Purchases', 'View Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(355, 4, 'Purchases', 'purchases.create', 'purchases.create', 'Create Purchases', 'Create Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(356, 4, 'Purchases', 'purchases.update', 'purchases.update', 'Update Purchases', 'Update Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(357, 4, 'Purchases', 'purchases.delete', 'purchases.delete', 'Delete Purchases', 'Delete Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(358, 4, 'Purchases', 'purchases.approve', 'purchases.approve', 'Approve Purchases', 'Approve Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(359, 4, 'Purchases', 'purchases.submit', 'purchases.submit', 'Submit Purchases', 'Submit Purchases', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(360, 4, 'Pos', 'pos.sell', 'pos.sell', 'Sell Pos', 'Sell Pos', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(361, 4, 'Pos', 'pos.hold_sale', 'pos.hold_sale', 'Hold Sale Pos', 'Hold Sale Pos', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(362, 4, 'Pos', 'pos.open_orders', 'pos.open_orders', 'Open Orders Pos', 'Open Orders Pos', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(363, 4, 'Pos', 'pos.return_sale', 'pos.return_sale', 'Return Sale Pos', 'Return Sale Pos', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(364, 4, 'Pos', 'pos.cash_drawer', 'pos.cash_drawer', 'Cash Drawer Pos', 'Cash Drawer Pos', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(365, 4, 'Orders', 'orders.view', 'orders.view', 'View Orders', 'View Orders', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(366, 4, 'Orders', 'orders.create', 'orders.create', 'Create Orders', 'Create Orders', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(367, 4, 'Orders', 'orders.update', 'orders.update', 'Update Orders', 'Update Orders', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(368, 4, 'Orders', 'orders.cancel', 'orders.cancel', 'Cancel Orders', 'Cancel Orders', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(369, 4, 'Orders', 'orders.refund', 'orders.refund', 'Refund Orders', 'Refund Orders', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(370, 4, 'Payments', 'payments.view', 'payments.view', 'View Payments', 'View Payments', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(371, 4, 'Payments', 'payments.create', 'payments.create', 'Create Payments', 'Create Payments', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(372, 4, 'Payments', 'payments.refund', 'payments.refund', 'Refund Payments', 'Refund Payments', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(373, 4, 'Reports', 'reports.sales', 'reports.sales', 'Sales Reports', 'Sales Reports', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(374, 4, 'Reports', 'reports.inventory', 'reports.inventory', 'Inventory Reports', 'Inventory Reports', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(375, 4, 'Reports', 'reports.profit_loss', 'reports.profit_loss', 'Profit Loss Reports', 'Profit Loss Reports', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(376, 4, 'Reports', 'reports.tax', 'reports.tax', 'Tax Reports', 'Tax Reports', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(377, 4, 'Settings', 'settings.view', 'settings.view', 'View Settings', 'View Settings', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(378, 4, 'Settings', 'settings.update', 'settings.update', 'Update Settings', 'Update Settings', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(379, 4, 'Document Sequences', 'document_sequences.view', 'document_sequences.view', 'View Document Sequences', 'View Document Sequences', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(380, 4, 'Document Sequences', 'document_sequences.create', 'document_sequences.create', 'Create Document Sequences', 'Create Document Sequences', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(381, 4, 'Document Sequences', 'document_sequences.update', 'document_sequences.update', 'Update Document Sequences', 'Update Document Sequences', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(382, 4, 'Document Sequences', 'document_sequences.delete', 'document_sequences.delete', 'Delete Document Sequences', 'Delete Document Sequences', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(383, 4, 'Payment Methods', 'payment_methods.view', 'payment_methods.view', 'View Payment Methods', 'View Payment Methods', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(384, 4, 'Payment Methods', 'payment_methods.create', 'payment_methods.create', 'Create Payment Methods', 'Create Payment Methods', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(385, 4, 'Payment Methods', 'payment_methods.update', 'payment_methods.update', 'Update Payment Methods', 'Update Payment Methods', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(386, 4, 'Payment Methods', 'payment_methods.delete', 'payment_methods.delete', 'Delete Payment Methods', 'Delete Payment Methods', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(387, 4, 'Audit Logs', 'audit_logs.view', 'audit_logs.view', 'View Audit Logs', 'View Audit Logs', 1, 1, '2026-09-17 12:10:34', '2026-09-27 21:18:37', NULL),
(388, 5, 'Dashboard', 'dashboard.view', 'dashboard.view', 'View Dashboard', 'View Dashboard', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(389, 5, 'Company', 'company.view', 'company.view', 'View Company', 'View Company', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(390, 5, 'Company', 'company.update', 'company.update', 'Update Company', 'Update Company', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(391, 5, 'Branches', 'branches.view', 'branches.view', 'View Branches', 'View Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(392, 5, 'Branches', 'branches.create', 'branches.create', 'Create Branches', 'Create Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(393, 5, 'Branches', 'branches.update', 'branches.update', 'Update Branches', 'Update Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(394, 5, 'Branches', 'branches.delete', 'branches.delete', 'Delete Branches', 'Delete Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(395, 5, 'Branches', 'branches.analytics', 'branches.analytics', 'Analytics Branches', 'Analytics Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(396, 5, 'Branches', 'branches.export', 'branches.export', 'Export Branches', 'Export Branches', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(397, 5, 'Terminals', 'terminals.view', 'terminals.view', 'View Terminals', 'View Terminals', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(398, 5, 'Terminals', 'terminals.create', 'terminals.create', 'Create Terminals', 'Create Terminals', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(399, 5, 'Terminals', 'terminals.update', 'terminals.update', 'Update Terminals', 'Update Terminals', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(400, 5, 'Terminals', 'terminals.delete', 'terminals.delete', 'Delete Terminals', 'Delete Terminals', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(401, 5, 'Users', 'users.view', 'users.view', 'View Users', 'View Users', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(402, 5, 'Users', 'users.create', 'users.create', 'Create Users', 'Create Users', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(403, 5, 'Users', 'users.update', 'users.update', 'Update Users', 'Update Users', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(404, 5, 'Users', 'users.delete', 'users.delete', 'Delete Users', 'Delete Users', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(405, 5, 'Users', 'users.reset_password', 'users.reset_password', 'Reset Password Users', 'Reset Password Users', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(406, 5, 'Roles', 'roles.view', 'roles.view', 'View Roles', 'View Roles', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(407, 5, 'Roles', 'roles.create', 'roles.create', 'Create Roles', 'Create Roles', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(408, 5, 'Roles', 'roles.update', 'roles.update', 'Update Roles', 'Update Roles', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(409, 5, 'Roles', 'roles.delete', 'roles.delete', 'Delete Roles', 'Delete Roles', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(410, 5, 'Roles', 'roles.assign_permissions', 'roles.assign_permissions', 'Assign Permissions Roles', 'Assign Permissions Roles', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(411, 5, 'Permissions', 'permissions.view', 'permissions.view', 'View Permissions', 'View Permissions', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(412, 5, 'Products', 'products.view', 'products.view', 'View Products', 'View Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(413, 5, 'Products', 'products.create', 'products.create', 'Create Products', 'Create Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(414, 5, 'Products', 'products.update', 'products.update', 'Update Products', 'Update Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(415, 5, 'Products', 'products.delete', 'products.delete', 'Delete Products', 'Delete Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(416, 5, 'Products', 'products.import', 'products.import', 'Import Products', 'Import Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(417, 5, 'Products', 'products.export', 'products.export', 'Export Products', 'Export Products', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:37', NULL),
(418, 5, 'Categories', 'categories.view', 'categories.view', 'View Categories', 'View Categories', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(419, 5, 'Categories', 'categories.create', 'categories.create', 'Create Categories', 'Create Categories', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(420, 5, 'Categories', 'categories.update', 'categories.update', 'Update Categories', 'Update Categories', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(421, 5, 'Categories', 'categories.delete', 'categories.delete', 'Delete Categories', 'Delete Categories', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(422, 5, 'Units', 'units.view', 'units.view', 'View Units', 'View Units', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(423, 5, 'Units', 'units.create', 'units.create', 'Create Units', 'Create Units', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(424, 5, 'Units', 'units.update', 'units.update', 'Update Units', 'Update Units', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(425, 5, 'Units', 'units.delete', 'units.delete', 'Delete Units', 'Delete Units', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(426, 5, 'Tax Rates', 'tax_rates.view', 'tax_rates.view', 'View Tax Rates', 'View Tax Rates', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(427, 5, 'Tax Rates', 'tax_rates.create', 'tax_rates.create', 'Create Tax Rates', 'Create Tax Rates', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(428, 5, 'Tax Rates', 'tax_rates.update', 'tax_rates.update', 'Update Tax Rates', 'Update Tax Rates', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(429, 5, 'Tax Rates', 'tax_rates.delete', 'tax_rates.delete', 'Delete Tax Rates', 'Delete Tax Rates', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(430, 5, 'Discounts', 'discounts.view', 'discounts.view', 'View Discounts', 'View Discounts', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(431, 5, 'Discounts', 'discounts.create', 'discounts.create', 'Create Discounts', 'Create Discounts', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(432, 5, 'Discounts', 'discounts.update', 'discounts.update', 'Update Discounts', 'Update Discounts', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(433, 5, 'Discounts', 'discounts.delete', 'discounts.delete', 'Delete Discounts', 'Delete Discounts', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(434, 5, 'Inventory', 'inventory.view', 'inventory.view', 'View Inventory', 'View Inventory', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(435, 5, 'Inventory', 'inventory.adjust_stock', 'inventory.adjust_stock', 'Adjust Stock Inventory', 'Adjust Stock Inventory', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(436, 5, 'Inventory', 'inventory.transfer_stock', 'inventory.transfer_stock', 'Transfer Stock Inventory', 'Transfer Stock Inventory', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(437, 5, 'Inventory', 'inventory.stock_count', 'inventory.stock_count', 'Stock Count Inventory', 'Stock Count Inventory', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(438, 5, 'Inventory', 'inventory.low_stock', 'inventory.low_stock', 'Low Stock Inventory', 'Low Stock Inventory', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(439, 5, 'Customers', 'customers.view', 'customers.view', 'View Customers', 'View Customers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(440, 5, 'Customers', 'customers.create', 'customers.create', 'Create Customers', 'Create Customers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(441, 5, 'Customers', 'customers.update', 'customers.update', 'Update Customers', 'Update Customers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(442, 5, 'Customers', 'customers.delete', 'customers.delete', 'Delete Customers', 'Delete Customers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(443, 5, 'Customers', 'customers.export', 'customers.export', 'Export Customers', 'Export Customers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(444, 5, 'Customer Groups', 'customer_groups.view', 'customer_groups.view', 'View Customer Groups', 'View Customer Groups', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(445, 5, 'Customer Groups', 'customer_groups.create', 'customer_groups.create', 'Create Customer Groups', 'Create Customer Groups', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(446, 5, 'Customer Groups', 'customer_groups.update', 'customer_groups.update', 'Update Customer Groups', 'Update Customer Groups', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(447, 5, 'Customer Groups', 'customer_groups.delete', 'customer_groups.delete', 'Delete Customer Groups', 'Delete Customer Groups', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(448, 5, 'Suppliers', 'suppliers.view', 'suppliers.view', 'View Suppliers', 'View Suppliers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(449, 5, 'Suppliers', 'suppliers.create', 'suppliers.create', 'Create Suppliers', 'Create Suppliers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(450, 5, 'Suppliers', 'suppliers.update', 'suppliers.update', 'Update Suppliers', 'Update Suppliers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(451, 5, 'Suppliers', 'suppliers.delete', 'suppliers.delete', 'Delete Suppliers', 'Delete Suppliers', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(452, 5, 'Purchases', 'purchases.view', 'purchases.view', 'View Purchases', 'View Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(453, 5, 'Purchases', 'purchases.create', 'purchases.create', 'Create Purchases', 'Create Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(454, 5, 'Purchases', 'purchases.update', 'purchases.update', 'Update Purchases', 'Update Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(455, 5, 'Purchases', 'purchases.delete', 'purchases.delete', 'Delete Purchases', 'Delete Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(456, 5, 'Purchases', 'purchases.approve', 'purchases.approve', 'Approve Purchases', 'Approve Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(457, 5, 'Purchases', 'purchases.submit', 'purchases.submit', 'Submit Purchases', 'Submit Purchases', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(458, 5, 'Pos', 'pos.sell', 'pos.sell', 'Sell Pos', 'Sell Pos', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(459, 5, 'Pos', 'pos.hold_sale', 'pos.hold_sale', 'Hold Sale Pos', 'Hold Sale Pos', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(460, 5, 'Pos', 'pos.open_orders', 'pos.open_orders', 'Open Orders Pos', 'Open Orders Pos', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(461, 5, 'Pos', 'pos.return_sale', 'pos.return_sale', 'Return Sale Pos', 'Return Sale Pos', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(462, 5, 'Pos', 'pos.cash_drawer', 'pos.cash_drawer', 'Cash Drawer Pos', 'Cash Drawer Pos', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(463, 5, 'Orders', 'orders.view', 'orders.view', 'View Orders', 'View Orders', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(464, 5, 'Orders', 'orders.create', 'orders.create', 'Create Orders', 'Create Orders', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(465, 5, 'Orders', 'orders.update', 'orders.update', 'Update Orders', 'Update Orders', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(466, 5, 'Orders', 'orders.cancel', 'orders.cancel', 'Cancel Orders', 'Cancel Orders', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(467, 5, 'Orders', 'orders.refund', 'orders.refund', 'Refund Orders', 'Refund Orders', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(468, 5, 'Payments', 'payments.view', 'payments.view', 'View Payments', 'View Payments', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(469, 5, 'Payments', 'payments.create', 'payments.create', 'Create Payments', 'Create Payments', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(470, 5, 'Payments', 'payments.refund', 'payments.refund', 'Refund Payments', 'Refund Payments', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(471, 5, 'Reports', 'reports.sales', 'reports.sales', 'Sales Reports', 'Sales Reports', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(472, 5, 'Reports', 'reports.inventory', 'reports.inventory', 'Inventory Reports', 'Inventory Reports', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(473, 5, 'Reports', 'reports.profit_loss', 'reports.profit_loss', 'Profit Loss Reports', 'Profit Loss Reports', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(474, 5, 'Reports', 'reports.tax', 'reports.tax', 'Tax Reports', 'Tax Reports', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(475, 5, 'Settings', 'settings.view', 'settings.view', 'View Settings', 'View Settings', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(476, 5, 'Settings', 'settings.update', 'settings.update', 'Update Settings', 'Update Settings', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(477, 5, 'Document Sequences', 'document_sequences.view', 'document_sequences.view', 'View Document Sequences', 'View Document Sequences', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(478, 5, 'Document Sequences', 'document_sequences.create', 'document_sequences.create', 'Create Document Sequences', 'Create Document Sequences', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(479, 5, 'Document Sequences', 'document_sequences.update', 'document_sequences.update', 'Update Document Sequences', 'Update Document Sequences', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(480, 5, 'Document Sequences', 'document_sequences.delete', 'document_sequences.delete', 'Delete Document Sequences', 'Delete Document Sequences', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(481, 5, 'Payment Methods', 'payment_methods.view', 'payment_methods.view', 'View Payment Methods', 'View Payment Methods', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(482, 5, 'Payment Methods', 'payment_methods.create', 'payment_methods.create', 'Create Payment Methods', 'Create Payment Methods', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(483, 5, 'Payment Methods', 'payment_methods.update', 'payment_methods.update', 'Update Payment Methods', 'Update Payment Methods', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(484, 5, 'Payment Methods', 'payment_methods.delete', 'payment_methods.delete', 'Delete Payment Methods', 'Delete Payment Methods', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(485, 5, 'Audit Logs', 'audit_logs.view', 'audit_logs.view', 'View Audit Logs', 'View Audit Logs', 1, 1, '2026-09-26 20:02:55', '2026-09-27 21:18:38', NULL),
(486, 1, 'Customer Groups', 'customer_groups.view', 'customer_groups.view', 'View Customer Groups', 'View Customer Groups', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(487, 1, 'Customer Groups', 'customer_groups.create', 'customer_groups.create', 'Create Customer Groups', 'Create Customer Groups', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(488, 1, 'Customer Groups', 'customer_groups.update', 'customer_groups.update', 'Update Customer Groups', 'Update Customer Groups', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(489, 1, 'Customer Groups', 'customer_groups.delete', 'customer_groups.delete', 'Delete Customer Groups', 'Delete Customer Groups', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(490, 1, 'Purchases', 'purchases.submit', 'purchases.submit', 'Submit Purchases', 'Submit Purchases', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(491, 1, 'Shipping', 'shipping.view', 'shipping.view', 'View Shipping', 'View Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(492, 1, 'Shipping', 'shipping.manage', 'shipping.manage', 'Manage Shipping', 'Manage Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(493, 1, 'Shipping', 'shipping.orders', 'shipping.orders', 'Orders Shipping', 'Orders Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(494, 4, 'Shipping', 'shipping.view', 'shipping.view', 'View Shipping', 'View Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(495, 4, 'Shipping', 'shipping.manage', 'shipping.manage', 'Manage Shipping', 'Manage Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(496, 4, 'Shipping', 'shipping.orders', 'shipping.orders', 'Orders Shipping', 'Orders Shipping', 1, 1, '2026-09-27 21:18:37', '2026-09-27 21:18:37', NULL),
(497, 5, 'Shipping', 'shipping.view', 'shipping.view', 'View Shipping', 'View Shipping', 1, 1, '2026-09-27 21:18:38', '2026-09-27 21:18:38', NULL),
(498, 5, 'Shipping', 'shipping.manage', 'shipping.manage', 'Manage Shipping', 'Manage Shipping', 1, 1, '2026-09-27 21:18:38', '2026-09-27 21:18:38', NULL),
(499, 5, 'Shipping', 'shipping.orders', 'shipping.orders', 'Orders Shipping', 'Orders Shipping', 1, 1, '2026-09-27 21:18:38', '2026-09-27 21:18:38', NULL);

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

--
-- Dumping data for table `platform_admins`
--

INSERT INTO `platform_admins` (`id`, `first_name`, `last_name`, `email`, `password`, `access_level`, `status`, `two_factor_enabled`, `last_login_at`, `last_activity_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Platform', 'Owner', 'admin@eitc.com.ng', '$2y$12$S9uJREr/Xt/oDTqWaWdFKOuSZ.vKewCn/3oDApjMPDuT1VCq61u6W', 'owner', 1, 0, '2026-09-26 23:58:50', '2026-09-26 23:58:50', NULL, '2026-09-26 23:41:08', '2026-09-26 23:58:50');

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
(1, 1, 1, 'PRD000001', '100000000001', 'COKE50CL', NULL, 'Coca-Cola 50cl', NULL, '1790543689_6ab98749371c7.jpg', 500.00, 700.00, 1, 1, NULL, 1, 'Coca-Cola', 'NBC', '2026-09-23', 1, 2, 1, 10.00, 2000.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:14:49', NULL, 20.00),
(2, 1, 1, 'PRD000002', '100000000002', 'FANTA50CL', NULL, 'Fanta 50cl', NULL, '1790543985_6ab9887108da1.jpeg', 500.00, 700.00, 1, 1, NULL, 1, 'Fanta', 'NBC', '2026-09-27', 1, 2, 1, 10.00, 2100.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:19:45', NULL, 20.00),
(3, 1, 1, 'PRD000003', '100000000003', 'SPRITE50CL', NULL, 'Sprite 50cl', NULL, '1790544002_6ab9888210fe1.jpeg', 500.00, 700.00, 1, 1, NULL, 1, 'Sprite', 'NBC', '2026-09-27', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:20:02', NULL, 20.00),
(4, 1, 5, 'PRD000004', '100000000004', 'PEAK500', NULL, 'Peak Milk 500g', 'Peak Milk 500g', '1790544024_6ab988982f02b.jpeg', 4200.00, 4800.00, 1, 1, NULL, 1, 'Peak', 'FrieslandCampina', '2030-10-27', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:20:24', NULL, 20.00),
(5, 1, 2, 'PRD000005', '100000000005', 'INDM70', NULL, 'Indomie Chicken Noodles', NULL, '1790544043_6ab988ab3d54f.jpeg', 180.00, 250.00, 1, 1, NULL, 1, 'Indomie', 'Dufil', '2029-10-25', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:20:43', NULL, 20.00),
(6, 1, 2, 'PRD000006', '100000000006', 'SUG1KG', NULL, 'Dangote Sugar 1kg', NULL, '1790544062_6ab988bedab7b.jpeg', 1450.00, 1650.00, 1, 1, NULL, 1, 'Dangote', 'Dangote', '2030-09-26', 1, 2, 1, 10.00, 1595.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:21:02', NULL, 20.00),
(7, 1, 3, 'PRD000007', '100000000007', 'BREAD001', NULL, 'Family Bread', NULL, '1790544083_6ab988d35c62a.jpeg', 900.00, 1200.00, 1, 1, NULL, 1, 'Local', 'Bakery', '2026-10-18', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:21:23', NULL, 20.00),
(8, 1, 2, 'PRD000008', '100000000008', 'RICE50KG', NULL, 'Mama Gold Rice 50kg', NULL, '1790544101_6ab988e5e3018.jpeg', 82000.00, 90000.00, 1, 11, NULL, 1, 'Mama Gold', 'Mama Gold', '2032-10-31', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:21:41', NULL, 20.00),
(9, 1, 7, 'PRD000009', '100000000009', 'SOAP001', NULL, 'Premier Soap', NULL, '1790544120_6ab988f8b0af7.jpg', 500.00, 700.00, 1, 1, NULL, 1, 'Premier', 'PZ', '2028-11-30', 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:22:00', NULL, 20.00),
(10, 1, 9, 'PRD000010', '100000000010', 'PAMP001', NULL, 'Pampers Size 3', NULL, '1790544154_6ab9891a6b244.jpeg', 7800.00, 8600.00, 1, 2, NULL, 1, 'Pampers', 'P&G', '2028-10-11', 1, 2, 1, 10.00, 1085.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-09-27 20:22:34', NULL, 20.00),
(19, 1, 5, 'PRD000011', 'TH123456', NULL, NULL, 'Three Crown Evaporated Milk', 'Three Crown Evaporated Milk', '1786301525_6a78cc5535908.png', 1000.00, 1200.00, NULL, 5, NULL, 1, 'Three Crown', 'Three Crown Ltd', '2027-11-25', 1, NULL, 1, 100.00, 1635.00, NULL, NULL, NULL, NULL, '2026-08-09 17:52:05', '2026-08-22 13:10:17', NULL, 0.00),
(20, 4, 15, 'PRD-000001', '12345', 'SKU-0001', 'QR-0001', 'Three Crown', 'Three Crown', '1789995718_6ab12ac629c4e.png', 5000.00, 7500.00, 6, 15, NULL, 1, 'Three Crown', 'Three Crown Ltd', '2027-12-31', 1, NULL, 1, 10.00, 100.00, 0.50, NULL, NULL, NULL, '2026-09-21 11:55:14', '2026-09-21 12:01:58', NULL, 0.00),
(21, 4, 16, 'PRD-000002', '452345', 'SKU-0002', 'QR-0002', 'Dangote Sugar 1kg', 'Dangote Sugar 1kg', '1789996254_6ab12cde96345.jpeg', 180.00, 250.00, 6, 15, NULL, 1, 'Dangote', 'Dangote', '2027-12-31', 1, NULL, 1, 10.00, 100.00, 0.50, NULL, NULL, NULL, '2026-09-21 12:09:46', '2026-09-21 12:10:54', NULL, 0.00);

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
(10, 1, 'CAT000010', 'Stationery', 'Office and school supplies.', NULL, NULL, 0, 1, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(14, 1, 'CAT000011', 'TEXT', 'TEXT', NULL, NULL, 0, 1, 1, 1, '2026-08-02 14:53:48', '2026-08-04 08:48:45', '2026-08-04 08:48:45'),
(15, 4, 'CAT000001', 'Dairy', 'Dairy', NULL, NULL, 0, 1, 20, 20, '2026-09-21 09:22:40', '2026-09-21 09:22:40', NULL),
(16, 4, 'CAT000002', 'Groceries', 'Groceries', NULL, NULL, 0, 1, 20, 20, '2026-09-21 12:09:24', '2026-09-21 12:09:24', NULL);

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
(1, 1, 1, 1, 973.02, 0.00, 973.02, 10.00, 2000.00, '2026-07-29 10:37:13', '2026-09-27 20:57:54'),
(2, 1, 1, 2, 2040.00, 0.00, 2040.00, 10.00, 2100.00, '2026-07-29 10:37:13', '2026-09-27 20:19:45'),
(3, 1, 1, 3, 90.00, 0.00, 90.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 20:20:02'),
(4, 1, 1, 4, 88.00, 0.00, 88.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 20:20:24'),
(5, 1, 1, 5, 76.00, 0.00, 76.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 23:17:12'),
(6, 1, 1, 6, 1525.00, 0.00, 1524.00, 10.00, 1595.00, '2026-07-29 10:37:13', '2026-09-27 20:21:02'),
(7, 1, 1, 7, 83.00, 0.00, 83.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 23:07:29'),
(8, 1, 1, 8, 73.00, 0.00, 73.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 20:21:41'),
(9, 1, 1, 9, 69.00, 0.00, 69.00, 10.00, 500.00, '2026-07-29 10:37:13', '2026-09-27 23:00:03'),
(10, 1, 1, 10, 1017.00, 0.00, 1017.00, 10.00, 1085.00, '2026-07-29 10:37:13', '2026-09-27 23:11:25'),
(13, 1, 1, 19, 1595.00, 0.00, 1595.00, 100.00, 1635.00, '2026-08-09 17:52:05', '2026-09-27 20:45:24'),
(20, 1, 6, 19, 5.00, 0.00, 5.00, 100.00, 1635.00, '2026-08-11 09:39:39', '2026-08-22 13:10:17'),
(21, 1, 6, 10, 5.00, 0.00, 5.00, 10.00, 1085.00, '2026-08-11 09:39:39', '2026-09-27 20:22:34'),
(22, 1, 6, 9, 10.00, 0.00, 10.00, 10.00, 500.00, '2026-08-11 09:39:39', '2026-09-27 20:22:00'),
(23, 1, 4, 9, 9.00, 0.00, 10.00, 10.00, 500.00, '2026-08-14 10:15:11', '2026-09-27 20:22:00'),
(24, 1, 4, 8, 0.00, 0.00, 0.00, 10.00, 500.00, '2026-08-14 10:15:11', '2026-09-27 20:21:41'),
(25, 1, 4, 7, 4.00, 0.00, 4.00, 10.00, 500.00, '2026-08-14 10:15:11', '2026-09-27 20:21:23'),
(26, 1, 4, 6, 1.00, 0.00, 1.00, 10.00, 1595.00, '2026-08-14 10:15:11', '2026-09-27 20:21:02'),
(27, 1, 4, 5, 15.00, 0.00, 10.00, 10.00, 500.00, '2026-08-14 10:15:11', '2026-09-27 20:20:43'),
(28, 1, 2, 19, 6.00, 0.00, 6.00, 100.00, 1635.00, '2026-08-31 10:05:07', '2026-09-14 13:30:52'),
(29, 1, 2, 10, 6.00, 0.00, 6.00, 10.00, 1085.00, '2026-08-31 10:05:07', '2026-09-27 20:22:34'),
(30, 1, 2, 9, 5.00, 0.00, 5.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:22:00'),
(31, 1, 2, 8, 8.00, 0.00, 8.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:21:41'),
(32, 1, 2, 7, 6.00, 0.00, 6.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:21:23'),
(33, 1, 2, 6, 8.00, 0.00, 8.00, 10.00, 1595.00, '2026-08-31 10:05:07', '2026-09-27 20:21:02'),
(34, 1, 2, 5, 9.00, 0.00, 9.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:20:43'),
(35, 1, 2, 4, 9.00, 0.00, 9.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:20:24'),
(36, 1, 2, 3, 9.00, 0.00, 9.00, 10.00, 500.00, '2026-08-31 10:05:07', '2026-09-27 20:20:02'),
(37, 1, 2, 2, 7.00, 0.00, 7.00, 10.00, 2100.00, '2026-08-31 10:05:07', '2026-09-27 20:19:45'),
(38, 1, 2, 1, 8.00, 0.00, 8.00, 10.00, 2000.00, '2026-08-31 10:05:07', '2026-09-27 20:14:49'),
(39, 4, 11, 20, 25.00, 0.00, 25.00, 10.00, 100.00, '2026-09-21 11:55:14', '2026-09-21 12:01:58'),
(40, 4, 11, 21, 25.00, 0.00, 25.00, 10.00, 100.00, '2026-09-21 12:09:46', '2026-09-21 12:10:54');

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

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `company_id`, `branch_id`, `supplier_id`, `order_number`, `order_date`, `expected_date`, `status`, `subtotal`, `discount`, `tax`, `shipping`, `total`, `notes`, `created_by`, `approved_by`, `approved_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 'PO-202608-00001', '2026-08-17', '2026-08-28', 'Draft', 3450000.00, 0.00, 0.00, 0.00, 3450000.00, NULL, 1, NULL, NULL, '2026-08-16 14:16:43', '2026-08-17 11:54:28', '2026-08-17 11:54:28'),
(3, 1, 1, 1, 'PO-202608-00002', '2026-08-17', '2026-08-31', 'Completed', 12975000.00, 0.00, 0.00, 0.00, 12975000.00, '5 products - 12,975,000', 1, 1, '2026-08-17 14:12:56', '2026-08-17 12:06:44', '2026-08-22 13:16:15', NULL),
(4, 1, 1, 2, 'PO-202608-00003', '2026-08-18', '2026-09-01', 'cancelled', 1000000.00, 0.00, 0.00, 0.00, 1000000.00, NULL, 1, NULL, NULL, '2026-08-18 11:55:29', '2026-08-18 11:55:43', NULL);

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

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `product_id`, `quantity`, `unit_cost`, `discount`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(3, 1, 6, 1000.00, 1450.00, 0.00, 0.00, 1450000.00, '2026-08-17 10:41:31', '2026-08-17 10:41:31'),
(4, 1, 19, 1000.00, 1000.00, 0.00, 0.00, 1000000.00, '2026-08-17 10:41:31', '2026-08-17 10:41:31'),
(5, 1, 2, 2000.00, 500.00, 0.00, 0.00, 1000000.00, '2026-08-17 10:41:31', '2026-08-17 10:41:31'),
(11, 3, 1, 1000.00, 500.00, 0.00, 0.00, 500000.00, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(12, 3, 6, 1500.00, 1450.00, 0.00, 0.00, 2175000.00, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(13, 3, 2, 2000.00, 500.00, 0.00, 0.00, 1000000.00, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(14, 3, 19, 1500.00, 1000.00, 0.00, 0.00, 1500000.00, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(15, 3, 10, 1000.00, 7800.00, 0.00, 0.00, 7800000.00, '2026-08-17 12:07:24', '2026-08-17 12:07:24'),
(16, 4, 2, 2000.00, 500.00, 0.00, 0.00, 1000000.00, '2026-08-18 11:55:29', '2026-08-18 11:55:29');

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

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `company_id`, `branch_id`, `supplier_id`, `purchase_order_id`, `goods_received_id`, `return_number`, `return_date`, `status`, `reason`, `notes`, `created_by`, `approved_by`, `approved_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 1, 1, 1, 3, NULL, 'PRN-000001', '2026-08-26', 'Completed', 'Expired', 'Expired Products', 1, NULL, NULL, '2026-08-26 10:23:49', '2026-08-26 10:23:49', NULL),
(6, 1, 1, 1, 3, NULL, 'PRN-000002', '2026-08-26', 'Completed', 'Damage', 'Damaged Products', 1, NULL, NULL, '2026-08-26 11:35:10', '2026-08-26 11:35:10', NULL),
(7, 1, 1, 1, 3, NULL, 'PRN-000003', '2026-08-26', 'Completed', 'Damage', 'Damaged Products', 1, NULL, NULL, '2026-08-26 12:05:19', '2026-08-26 12:05:19', NULL),
(8, 1, 1, 1, 3, NULL, 'PRN-000004', '2026-08-27', 'Completed', 'Expired', '50 items returned each for Pampers and Fanta 50cl', 1, NULL, NULL, '2026-08-27 09:44:50', '2026-08-27 09:44:50', NULL);

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

--
-- Dumping data for table `purchase_return_items`
--

INSERT INTO `purchase_return_items` (`id`, `purchase_return_id`, `goods_received_item_id`, `product_id`, `quantity`, `unit_cost`, `total`, `created_at`, `updated_at`) VALUES
(5, 5, 11, 1, 50.00, 500.00, 25000.00, '2026-08-26 10:23:50', '2026-08-26 10:23:50'),
(6, 6, 11, 1, 50.00, 500.00, 25000.00, '2026-08-26 11:35:10', '2026-08-26 11:35:10'),
(7, 7, 12, 6, 50.00, 1450.00, 72500.00, '2026-08-26 12:05:19', '2026-08-26 12:05:19'),
(8, 8, 13, 2, 50.00, 500.00, 25000.00, '2026-08-27 09:44:50', '2026-08-27 09:44:50'),
(9, 8, 15, 10, 50.00, 7800.00, 390000.00, '2026-08-27 09:44:50', '2026-08-27 09:44:50');

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
(7, 1, 'accountant', 'accountant', 'Accountant', 'Handles financial operations.', 1, 0, '2026-07-29 10:37:09', '2026-07-29 11:14:01', NULL),
(30, 4, 'owner', 'owner', 'Owner', 'System owner with unrestricted access.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(31, 4, 'administrator', 'administrator', 'Administrator', 'Company administrator.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(32, 4, 'branch_manager', 'branch_manager', 'Branch Manager', 'Manages a business branch.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(33, 4, 'supervisor', 'supervisor', 'Supervisor', 'Supervises daily business operations.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(34, 4, 'cashier', 'cashier', 'Cashier', 'Processes customer sales.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(35, 4, 'inventory_manager', 'inventory_manager', 'Inventory Manager', 'Manages inventory and stock.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(36, 4, 'accountant', 'accountant', 'Accountant', 'Handles financial operations.', 1, 0, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(37, 5, 'owner', 'owner', 'Owner', 'System owner with unrestricted access.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(38, 5, 'administrator', 'administrator', 'Administrator', 'Company administrator.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(39, 5, 'branch_manager', 'branch_manager', 'Branch Manager', 'Manages a business branch.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(40, 5, 'supervisor', 'supervisor', 'Supervisor', 'Supervises daily business operations.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(41, 5, 'cashier', 'cashier', 'Cashier', 'Processes customer sales.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(42, 5, 'inventory_manager', 'inventory_manager', 'Inventory Manager', 'Manages inventory and stock.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL),
(43, 5, 'accountant', 'accountant', 'Accountant', 'Handles financial operations.', 1, 0, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL);

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

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `company_id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(2, 1, 1, 2, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(3, 1, 1, 3, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(4, 1, 1, 4, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(5, 1, 1, 5, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(6, 1, 1, 6, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(7, 1, 1, 7, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(8, 1, 1, 8, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(9, 1, 1, 9, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(10, 1, 1, 10, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(11, 1, 1, 11, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(12, 1, 1, 12, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(13, 1, 1, 13, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(14, 1, 1, 14, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(15, 1, 1, 15, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(16, 1, 1, 16, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(17, 1, 1, 17, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(18, 1, 1, 18, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(19, 1, 1, 19, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(20, 1, 1, 20, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(21, 1, 1, 21, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(22, 1, 1, 22, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(23, 1, 1, 23, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(24, 1, 1, 24, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(25, 1, 1, 25, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(26, 1, 1, 26, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(27, 1, 1, 27, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(28, 1, 1, 28, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(29, 1, 1, 29, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(30, 1, 1, 30, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(31, 1, 1, 31, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(32, 1, 1, 32, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(33, 1, 1, 33, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(34, 1, 1, 34, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(35, 1, 1, 35, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(36, 1, 1, 36, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(37, 1, 1, 37, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(38, 1, 1, 38, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(39, 1, 1, 39, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(40, 1, 1, 40, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(41, 1, 1, 41, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(42, 1, 1, 42, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(43, 1, 1, 43, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(44, 1, 1, 44, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(45, 1, 1, 45, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(46, 1, 1, 46, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(47, 1, 1, 47, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(48, 1, 1, 48, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(49, 1, 1, 49, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(50, 1, 1, 50, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(51, 1, 1, 51, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(52, 1, 1, 52, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(53, 1, 1, 53, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(54, 1, 1, 54, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(55, 1, 1, 55, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(56, 1, 1, 56, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(57, 1, 1, 57, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(58, 1, 1, 58, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(59, 1, 1, 59, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(60, 1, 1, 60, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(61, 1, 1, 61, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(62, 1, 1, 62, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(63, 1, 1, 63, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(64, 1, 1, 64, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(65, 1, 1, 65, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(66, 1, 1, 66, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(67, 1, 1, 67, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(68, 1, 1, 68, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(69, 1, 1, 69, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(70, 1, 1, 70, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(71, 1, 1, 71, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(72, 1, 1, 72, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(73, 1, 1, 73, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(74, 1, 1, 74, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(75, 1, 1, 75, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(76, 1, 1, 76, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(77, 1, 1, 77, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(78, 1, 1, 78, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(79, 1, 1, 79, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(80, 1, 1, 80, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(81, 1, 1, 81, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(82, 1, 1, 82, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(83, 1, 1, 83, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(84, 1, 1, 84, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(85, 1, 1, 85, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(86, 1, 1, 86, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(87, 1, 1, 87, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(88, 1, 1, 88, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(89, 1, 1, 89, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(90, 1, 1, 90, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(91, 1, 1, 91, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(92, 1, 1, 92, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(93, 1, 1, 93, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(94, 1, 2, 1, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(95, 1, 2, 2, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(96, 1, 2, 3, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(97, 1, 2, 4, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(98, 1, 2, 5, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(99, 1, 2, 6, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(100, 1, 2, 7, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(101, 1, 2, 8, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(102, 1, 2, 9, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(103, 1, 2, 10, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(104, 1, 2, 11, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(105, 1, 2, 12, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(106, 1, 2, 13, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(107, 1, 2, 14, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(108, 1, 2, 15, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(109, 1, 2, 16, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(110, 1, 2, 17, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(111, 1, 2, 18, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(112, 1, 2, 19, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(113, 1, 2, 20, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(114, 1, 2, 21, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(115, 1, 2, 22, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(116, 1, 2, 23, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(117, 1, 2, 24, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(118, 1, 2, 25, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(119, 1, 2, 26, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(120, 1, 2, 27, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(121, 1, 2, 28, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(122, 1, 2, 29, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(123, 1, 2, 30, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(124, 1, 2, 31, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(125, 1, 2, 32, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(126, 1, 2, 33, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(127, 1, 2, 34, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(128, 1, 2, 35, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(129, 1, 2, 36, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(130, 1, 2, 37, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(131, 1, 2, 38, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(132, 1, 2, 39, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(133, 1, 2, 40, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(134, 1, 2, 41, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(135, 1, 2, 42, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(136, 1, 2, 43, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(137, 1, 2, 44, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(138, 1, 2, 45, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(139, 1, 2, 46, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(140, 1, 2, 47, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(141, 1, 2, 48, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(142, 1, 2, 49, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(143, 1, 2, 50, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(144, 1, 2, 51, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(145, 1, 2, 52, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(146, 1, 2, 53, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(147, 1, 2, 54, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(148, 1, 2, 55, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(149, 1, 2, 56, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(150, 1, 2, 57, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(151, 1, 2, 58, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(152, 1, 2, 59, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(153, 1, 2, 60, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(154, 1, 2, 61, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(155, 1, 2, 62, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(156, 1, 2, 63, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(157, 1, 2, 64, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(158, 1, 2, 65, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(159, 1, 2, 66, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(160, 1, 2, 67, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(161, 1, 2, 68, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(162, 1, 2, 69, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(163, 1, 2, 70, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(164, 1, 2, 71, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(165, 1, 2, 72, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(166, 1, 2, 73, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(167, 1, 2, 74, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(168, 1, 2, 75, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(169, 1, 2, 76, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(170, 1, 2, 77, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(171, 1, 2, 78, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(172, 1, 2, 79, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(173, 1, 2, 80, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(174, 1, 2, 81, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(175, 1, 2, 82, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(176, 1, 2, 83, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(177, 1, 2, 84, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(178, 1, 2, 85, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(179, 1, 2, 86, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(180, 1, 2, 87, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(181, 1, 2, 88, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(182, 1, 2, 89, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(183, 1, 2, 90, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(184, 1, 2, 91, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(185, 1, 2, 92, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(186, 1, 2, 93, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(187, 1, 3, 1, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(188, 1, 3, 4, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(189, 1, 3, 6, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(190, 1, 3, 10, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(191, 1, 3, 14, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(192, 1, 3, 25, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(198, 1, 3, 31, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(202, 1, 3, 35, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(206, 1, 3, 39, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(207, 1, 3, 40, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(208, 1, 3, 41, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(209, 1, 3, 42, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(210, 1, 3, 43, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(211, 1, 3, 44, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(212, 1, 3, 45, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(213, 1, 3, 46, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(214, 1, 3, 47, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(217, 1, 3, 50, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(218, 1, 3, 51, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(219, 1, 3, 52, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(220, 1, 3, 53, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(221, 1, 3, 54, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(223, 1, 3, 56, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(224, 1, 3, 57, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(225, 1, 3, 58, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(226, 1, 3, 59, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(227, 1, 3, 60, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(228, 1, 3, 61, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(229, 1, 3, 62, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(230, 1, 3, 63, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(231, 1, 3, 64, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(232, 1, 3, 65, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(233, 1, 3, 71, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(234, 1, 3, 72, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(235, 1, 3, 73, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(236, 1, 3, 74, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(237, 1, 3, 75, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(238, 1, 3, 76, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(239, 1, 3, 79, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(240, 1, 3, 80, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(241, 1, 3, 66, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(242, 1, 3, 67, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(243, 1, 3, 68, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(244, 1, 3, 69, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(245, 1, 3, 70, '2026-07-29 11:20:42', '2026-08-31 05:58:30'),
(246, 1, 4, 1, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(247, 1, 4, 25, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(248, 1, 4, 47, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(249, 1, 4, 52, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(250, 1, 4, 71, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(251, 1, 4, 79, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(252, 1, 4, 66, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(253, 1, 4, 67, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(254, 1, 4, 68, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(255, 1, 5, 1, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(256, 1, 5, 52, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(257, 1, 5, 53, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(258, 1, 5, 25, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(259, 1, 5, 71, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(260, 1, 5, 72, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(261, 1, 5, 76, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(262, 1, 5, 77, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(263, 1, 5, 66, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(264, 1, 5, 67, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(265, 1, 5, 68, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(266, 1, 5, 69, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(267, 1, 5, 70, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(268, 1, 6, 1, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(269, 1, 6, 25, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(270, 1, 6, 26, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(271, 1, 6, 27, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(272, 1, 6, 28, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(273, 1, 6, 29, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(274, 1, 6, 30, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(275, 1, 6, 31, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(276, 1, 6, 32, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(277, 1, 6, 33, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(278, 1, 6, 34, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(279, 1, 6, 35, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(280, 1, 6, 36, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(281, 1, 6, 37, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(282, 1, 6, 38, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(283, 1, 6, 47, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(284, 1, 6, 48, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(285, 1, 6, 49, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(286, 1, 6, 50, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(287, 1, 6, 51, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(288, 1, 6, 57, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(289, 1, 6, 58, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(290, 1, 6, 59, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(291, 1, 6, 60, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(292, 1, 6, 61, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(293, 1, 6, 62, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(294, 1, 6, 63, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(295, 1, 6, 64, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(296, 1, 6, 65, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(297, 1, 6, 80, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(298, 1, 7, 1, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(299, 1, 7, 76, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(300, 1, 7, 77, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(301, 1, 7, 78, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(302, 1, 7, 71, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(303, 1, 7, 52, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(304, 1, 7, 79, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(305, 1, 7, 80, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(306, 1, 7, 81, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(307, 1, 7, 82, '2026-07-29 11:20:43', '2026-07-29 11:20:43'),
(312, 1, 3, 77, '2026-08-31 05:58:30', '2026-08-31 05:58:30'),
(313, 1, 3, 78, '2026-08-31 05:58:30', '2026-08-31 05:58:30'),
(952, 4, 30, 290, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(953, 4, 30, 291, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(954, 4, 30, 292, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(955, 4, 30, 293, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(956, 4, 30, 294, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(957, 4, 30, 295, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(958, 4, 30, 296, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(959, 4, 30, 297, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(960, 4, 30, 298, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(961, 4, 30, 299, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(962, 4, 30, 300, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(963, 4, 30, 301, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(964, 4, 30, 302, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(965, 4, 30, 303, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(966, 4, 30, 304, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(967, 4, 30, 305, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(968, 4, 30, 306, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(969, 4, 30, 307, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(970, 4, 30, 308, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(971, 4, 30, 309, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(972, 4, 30, 310, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(973, 4, 30, 311, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(974, 4, 30, 312, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(975, 4, 30, 313, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(976, 4, 30, 314, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(977, 4, 30, 315, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(978, 4, 30, 316, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(979, 4, 30, 317, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(980, 4, 30, 318, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(981, 4, 30, 319, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(982, 4, 30, 320, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(983, 4, 30, 321, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(984, 4, 30, 322, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(985, 4, 30, 323, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(986, 4, 30, 324, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(987, 4, 30, 325, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(988, 4, 30, 326, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(989, 4, 30, 327, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(990, 4, 30, 328, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(991, 4, 30, 329, '2026-09-17 12:10:34', '2026-09-17 12:10:34'),
(992, 4, 30, 330, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(993, 4, 30, 331, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(994, 4, 30, 332, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(995, 4, 30, 333, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(996, 4, 30, 334, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(997, 4, 30, 335, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(998, 4, 30, 336, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(999, 4, 30, 337, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1000, 4, 30, 338, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1001, 4, 30, 339, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1002, 4, 30, 340, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1003, 4, 30, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1004, 4, 30, 342, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1005, 4, 30, 343, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1006, 4, 30, 344, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1007, 4, 30, 345, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1008, 4, 30, 346, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1009, 4, 30, 347, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1010, 4, 30, 348, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1011, 4, 30, 349, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1012, 4, 30, 350, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1013, 4, 30, 351, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1014, 4, 30, 352, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1015, 4, 30, 353, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1016, 4, 30, 354, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1017, 4, 30, 355, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1018, 4, 30, 356, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1019, 4, 30, 357, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1020, 4, 30, 358, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1021, 4, 30, 359, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1022, 4, 30, 360, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1023, 4, 30, 361, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1024, 4, 30, 362, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1025, 4, 30, 363, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1026, 4, 30, 364, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1027, 4, 30, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1028, 4, 30, 366, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1029, 4, 30, 367, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1030, 4, 30, 368, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1031, 4, 30, 369, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1032, 4, 30, 370, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1033, 4, 30, 371, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1034, 4, 30, 372, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1035, 4, 30, 373, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1036, 4, 30, 374, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1037, 4, 30, 375, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1038, 4, 30, 376, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1039, 4, 30, 377, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1040, 4, 30, 378, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1041, 4, 30, 379, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1042, 4, 30, 380, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1043, 4, 30, 381, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1044, 4, 30, 382, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1045, 4, 30, 383, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1046, 4, 30, 384, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1047, 4, 30, 385, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1048, 4, 30, 386, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1049, 4, 30, 387, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1050, 4, 31, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1051, 4, 31, 291, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1052, 4, 31, 292, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1053, 4, 31, 293, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1054, 4, 31, 294, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1055, 4, 31, 295, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1056, 4, 31, 296, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1057, 4, 31, 297, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1058, 4, 31, 298, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1059, 4, 31, 299, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1060, 4, 31, 300, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1061, 4, 31, 301, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1062, 4, 31, 302, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1063, 4, 31, 303, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1064, 4, 31, 304, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1065, 4, 31, 305, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1066, 4, 31, 306, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1067, 4, 31, 307, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1068, 4, 31, 308, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1069, 4, 31, 309, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1070, 4, 31, 310, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1071, 4, 31, 311, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1072, 4, 31, 312, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1073, 4, 31, 313, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1074, 4, 31, 314, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1075, 4, 31, 315, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1076, 4, 31, 316, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1077, 4, 31, 317, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1078, 4, 31, 318, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1079, 4, 31, 319, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1080, 4, 31, 320, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1081, 4, 31, 321, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1082, 4, 31, 322, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1083, 4, 31, 323, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1084, 4, 31, 324, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1085, 4, 31, 325, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1086, 4, 31, 326, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1087, 4, 31, 327, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1088, 4, 31, 328, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1089, 4, 31, 329, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1090, 4, 31, 330, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1091, 4, 31, 331, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1092, 4, 31, 332, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1093, 4, 31, 333, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1094, 4, 31, 334, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1095, 4, 31, 335, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1096, 4, 31, 336, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1097, 4, 31, 337, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1098, 4, 31, 338, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1099, 4, 31, 339, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1100, 4, 31, 340, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1101, 4, 31, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1102, 4, 31, 342, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1103, 4, 31, 343, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1104, 4, 31, 344, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1105, 4, 31, 345, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1106, 4, 31, 346, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1107, 4, 31, 347, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1108, 4, 31, 348, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1109, 4, 31, 349, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1110, 4, 31, 350, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1111, 4, 31, 351, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1112, 4, 31, 352, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1113, 4, 31, 353, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1114, 4, 31, 354, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1115, 4, 31, 355, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1116, 4, 31, 356, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1117, 4, 31, 357, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1118, 4, 31, 358, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1119, 4, 31, 359, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1120, 4, 31, 360, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1121, 4, 31, 361, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1122, 4, 31, 362, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1123, 4, 31, 363, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1124, 4, 31, 364, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1125, 4, 31, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1126, 4, 31, 366, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1127, 4, 31, 367, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1128, 4, 31, 368, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1129, 4, 31, 369, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1130, 4, 31, 370, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1131, 4, 31, 371, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1132, 4, 31, 372, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1133, 4, 31, 373, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1134, 4, 31, 374, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1135, 4, 31, 375, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1136, 4, 31, 376, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1137, 4, 31, 377, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1138, 4, 31, 378, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1139, 4, 31, 379, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1140, 4, 31, 380, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1141, 4, 31, 381, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1142, 4, 31, 382, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1143, 4, 31, 383, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1144, 4, 31, 384, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1145, 4, 31, 385, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1146, 4, 31, 386, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1147, 4, 31, 387, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1148, 4, 32, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1149, 4, 32, 293, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1150, 4, 32, 295, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1151, 4, 32, 299, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1152, 4, 32, 303, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1153, 4, 32, 314, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1154, 4, 32, 315, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1155, 4, 32, 316, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1156, 4, 32, 317, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1157, 4, 32, 318, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1158, 4, 32, 319, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1159, 4, 32, 320, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1160, 4, 32, 321, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1161, 4, 32, 322, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1162, 4, 32, 323, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1163, 4, 32, 324, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1164, 4, 32, 325, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1165, 4, 32, 326, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1166, 4, 32, 327, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1167, 4, 32, 328, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1168, 4, 32, 329, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1169, 4, 32, 330, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1170, 4, 32, 331, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1171, 4, 32, 332, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1172, 4, 32, 333, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1173, 4, 32, 334, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1174, 4, 32, 335, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1175, 4, 32, 336, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1176, 4, 32, 337, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1177, 4, 32, 338, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1178, 4, 32, 339, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1179, 4, 32, 340, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1180, 4, 32, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1181, 4, 32, 342, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1182, 4, 32, 343, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1183, 4, 32, 344, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1184, 4, 32, 345, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1185, 4, 32, 350, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1186, 4, 32, 351, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1187, 4, 32, 352, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1188, 4, 32, 353, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1189, 4, 32, 354, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1190, 4, 32, 355, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1191, 4, 32, 356, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1192, 4, 32, 357, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1193, 4, 32, 358, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1194, 4, 32, 359, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1195, 4, 32, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1196, 4, 32, 366, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1197, 4, 32, 367, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1198, 4, 32, 368, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1199, 4, 32, 369, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1200, 4, 32, 370, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1201, 4, 32, 373, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1202, 4, 32, 374, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1203, 4, 32, 360, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1204, 4, 32, 361, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1205, 4, 32, 362, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1206, 4, 32, 363, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1207, 4, 32, 364, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1208, 4, 33, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1209, 4, 33, 314, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1210, 4, 33, 336, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1211, 4, 33, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1212, 4, 33, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1213, 4, 33, 373, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1214, 4, 33, 360, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1215, 4, 33, 361, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1216, 4, 33, 362, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1217, 4, 34, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1218, 4, 34, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1219, 4, 34, 342, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1220, 4, 34, 314, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1221, 4, 34, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1222, 4, 34, 366, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1223, 4, 34, 370, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1224, 4, 34, 371, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1225, 4, 34, 360, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1226, 4, 34, 361, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1227, 4, 34, 362, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1228, 4, 34, 363, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1229, 4, 34, 364, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1230, 4, 35, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1231, 4, 35, 314, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1232, 4, 35, 315, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1233, 4, 35, 316, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1234, 4, 35, 317, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1235, 4, 35, 318, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1236, 4, 35, 319, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1237, 4, 35, 320, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1238, 4, 35, 321, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1239, 4, 35, 322, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1240, 4, 35, 323, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1241, 4, 35, 324, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1242, 4, 35, 325, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1243, 4, 35, 326, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1244, 4, 35, 327, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1245, 4, 35, 336, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1246, 4, 35, 337, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1247, 4, 35, 338, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1248, 4, 35, 339, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1249, 4, 35, 340, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1250, 4, 35, 350, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1251, 4, 35, 351, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1252, 4, 35, 352, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1253, 4, 35, 353, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1254, 4, 35, 354, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1255, 4, 35, 355, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1256, 4, 35, 356, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1257, 4, 35, 357, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1258, 4, 35, 358, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1259, 4, 35, 359, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1260, 4, 35, 374, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1261, 4, 36, 290, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1262, 4, 36, 370, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1263, 4, 36, 371, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1264, 4, 36, 372, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1265, 4, 36, 365, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1266, 4, 36, 341, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1267, 4, 36, 373, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1268, 4, 36, 374, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1269, 4, 36, 375, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1270, 4, 36, 376, '2026-09-17 12:10:35', '2026-09-17 12:10:35'),
(1271, 5, 37, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1272, 5, 37, 389, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1273, 5, 37, 390, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1274, 5, 37, 391, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1275, 5, 37, 392, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1276, 5, 37, 393, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1277, 5, 37, 394, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1278, 5, 37, 395, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1279, 5, 37, 396, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1280, 5, 37, 397, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1281, 5, 37, 398, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1282, 5, 37, 399, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1283, 5, 37, 400, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1284, 5, 37, 401, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1285, 5, 37, 402, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1286, 5, 37, 403, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1287, 5, 37, 404, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1288, 5, 37, 405, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1289, 5, 37, 406, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1290, 5, 37, 407, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1291, 5, 37, 408, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1292, 5, 37, 409, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1293, 5, 37, 410, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1294, 5, 37, 411, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1295, 5, 37, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1296, 5, 37, 413, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1297, 5, 37, 414, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1298, 5, 37, 415, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1299, 5, 37, 416, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1300, 5, 37, 417, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1301, 5, 37, 418, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1302, 5, 37, 419, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1303, 5, 37, 420, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1304, 5, 37, 421, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1305, 5, 37, 422, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1306, 5, 37, 423, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1307, 5, 37, 424, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1308, 5, 37, 425, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1309, 5, 37, 426, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1310, 5, 37, 427, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1311, 5, 37, 428, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1312, 5, 37, 429, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1313, 5, 37, 430, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1314, 5, 37, 431, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1315, 5, 37, 432, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1316, 5, 37, 433, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1317, 5, 37, 434, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1318, 5, 37, 435, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1319, 5, 37, 436, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1320, 5, 37, 437, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1321, 5, 37, 438, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1322, 5, 37, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1323, 5, 37, 440, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1324, 5, 37, 441, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1325, 5, 37, 442, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1326, 5, 37, 443, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1327, 5, 37, 444, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1328, 5, 37, 445, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1329, 5, 37, 446, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1330, 5, 37, 447, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1331, 5, 37, 448, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1332, 5, 37, 449, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1333, 5, 37, 450, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1334, 5, 37, 451, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1335, 5, 37, 452, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1336, 5, 37, 453, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1337, 5, 37, 454, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1338, 5, 37, 455, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1339, 5, 37, 456, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1340, 5, 37, 457, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1341, 5, 37, 458, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1342, 5, 37, 459, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1343, 5, 37, 460, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1344, 5, 37, 461, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1345, 5, 37, 462, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1346, 5, 37, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1347, 5, 37, 464, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1348, 5, 37, 465, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1349, 5, 37, 466, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1350, 5, 37, 467, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1351, 5, 37, 468, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1352, 5, 37, 469, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1353, 5, 37, 470, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1354, 5, 37, 471, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1355, 5, 37, 472, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1356, 5, 37, 473, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1357, 5, 37, 474, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1358, 5, 37, 475, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1359, 5, 37, 476, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1360, 5, 37, 477, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1361, 5, 37, 478, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1362, 5, 37, 479, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1363, 5, 37, 480, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1364, 5, 37, 481, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1365, 5, 37, 482, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1366, 5, 37, 483, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1367, 5, 37, 484, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1368, 5, 37, 485, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1369, 5, 38, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1370, 5, 38, 389, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1371, 5, 38, 390, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1372, 5, 38, 391, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1373, 5, 38, 392, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1374, 5, 38, 393, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1375, 5, 38, 394, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1376, 5, 38, 395, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1377, 5, 38, 396, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1378, 5, 38, 397, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1379, 5, 38, 398, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1380, 5, 38, 399, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1381, 5, 38, 400, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1382, 5, 38, 401, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1383, 5, 38, 402, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1384, 5, 38, 403, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1385, 5, 38, 404, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1386, 5, 38, 405, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1387, 5, 38, 406, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1388, 5, 38, 407, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1389, 5, 38, 408, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1390, 5, 38, 409, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1391, 5, 38, 410, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1392, 5, 38, 411, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1393, 5, 38, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1394, 5, 38, 413, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1395, 5, 38, 414, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1396, 5, 38, 415, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1397, 5, 38, 416, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1398, 5, 38, 417, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1399, 5, 38, 418, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1400, 5, 38, 419, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1401, 5, 38, 420, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1402, 5, 38, 421, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1403, 5, 38, 422, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1404, 5, 38, 423, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1405, 5, 38, 424, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1406, 5, 38, 425, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1407, 5, 38, 426, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1408, 5, 38, 427, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1409, 5, 38, 428, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1410, 5, 38, 429, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1411, 5, 38, 430, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1412, 5, 38, 431, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1413, 5, 38, 432, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1414, 5, 38, 433, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1415, 5, 38, 434, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1416, 5, 38, 435, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1417, 5, 38, 436, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1418, 5, 38, 437, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1419, 5, 38, 438, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1420, 5, 38, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1421, 5, 38, 440, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1422, 5, 38, 441, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1423, 5, 38, 442, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1424, 5, 38, 443, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1425, 5, 38, 444, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1426, 5, 38, 445, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1427, 5, 38, 446, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1428, 5, 38, 447, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1429, 5, 38, 448, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1430, 5, 38, 449, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1431, 5, 38, 450, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1432, 5, 38, 451, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1433, 5, 38, 452, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1434, 5, 38, 453, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1435, 5, 38, 454, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1436, 5, 38, 455, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1437, 5, 38, 456, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1438, 5, 38, 457, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1439, 5, 38, 458, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1440, 5, 38, 459, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1441, 5, 38, 460, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1442, 5, 38, 461, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1443, 5, 38, 462, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1444, 5, 38, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1445, 5, 38, 464, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1446, 5, 38, 465, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1447, 5, 38, 466, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1448, 5, 38, 467, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1449, 5, 38, 468, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1450, 5, 38, 469, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1451, 5, 38, 470, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1452, 5, 38, 471, '2026-09-26 20:02:56', '2026-09-26 20:02:56');
INSERT INTO `role_permissions` (`id`, `company_id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1453, 5, 38, 472, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1454, 5, 38, 473, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1455, 5, 38, 474, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1456, 5, 38, 475, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1457, 5, 38, 476, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1458, 5, 38, 477, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1459, 5, 38, 478, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1460, 5, 38, 479, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1461, 5, 38, 480, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1462, 5, 38, 481, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1463, 5, 38, 482, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1464, 5, 38, 483, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1465, 5, 38, 484, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1466, 5, 38, 485, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1467, 5, 39, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1468, 5, 39, 391, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1469, 5, 39, 393, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1470, 5, 39, 397, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1471, 5, 39, 401, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1472, 5, 39, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1473, 5, 39, 413, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1474, 5, 39, 414, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1475, 5, 39, 415, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1476, 5, 39, 416, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1477, 5, 39, 417, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1478, 5, 39, 418, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1479, 5, 39, 419, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1480, 5, 39, 420, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1481, 5, 39, 421, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1482, 5, 39, 422, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1483, 5, 39, 423, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1484, 5, 39, 424, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1485, 5, 39, 425, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1486, 5, 39, 426, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1487, 5, 39, 427, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1488, 5, 39, 428, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1489, 5, 39, 429, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1490, 5, 39, 430, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1491, 5, 39, 431, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1492, 5, 39, 432, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1493, 5, 39, 433, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1494, 5, 39, 434, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1495, 5, 39, 435, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1496, 5, 39, 436, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1497, 5, 39, 437, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1498, 5, 39, 438, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1499, 5, 39, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1500, 5, 39, 440, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1501, 5, 39, 441, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1502, 5, 39, 442, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1503, 5, 39, 443, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1504, 5, 39, 448, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1505, 5, 39, 449, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1506, 5, 39, 450, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1507, 5, 39, 451, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1508, 5, 39, 452, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1509, 5, 39, 453, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1510, 5, 39, 454, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1511, 5, 39, 455, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1512, 5, 39, 456, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1513, 5, 39, 457, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1514, 5, 39, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1515, 5, 39, 464, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1516, 5, 39, 465, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1517, 5, 39, 466, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1518, 5, 39, 467, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1519, 5, 39, 468, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1520, 5, 39, 471, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1521, 5, 39, 472, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1522, 5, 39, 458, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1523, 5, 39, 459, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1524, 5, 39, 460, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1525, 5, 39, 461, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1526, 5, 39, 462, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1527, 5, 40, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1528, 5, 40, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1529, 5, 40, 434, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1530, 5, 40, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1531, 5, 40, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1532, 5, 40, 471, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1533, 5, 40, 458, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1534, 5, 40, 459, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1535, 5, 40, 460, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1536, 5, 41, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1537, 5, 41, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1538, 5, 41, 440, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1539, 5, 41, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1540, 5, 41, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1541, 5, 41, 464, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1542, 5, 41, 468, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1543, 5, 41, 469, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1544, 5, 41, 458, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1545, 5, 41, 459, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1546, 5, 41, 460, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1547, 5, 41, 461, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1548, 5, 41, 462, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1549, 5, 42, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1550, 5, 42, 412, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1551, 5, 42, 413, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1552, 5, 42, 414, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1553, 5, 42, 415, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1554, 5, 42, 416, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1555, 5, 42, 417, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1556, 5, 42, 418, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1557, 5, 42, 419, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1558, 5, 42, 420, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1559, 5, 42, 421, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1560, 5, 42, 422, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1561, 5, 42, 423, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1562, 5, 42, 424, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1563, 5, 42, 425, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1564, 5, 42, 434, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1565, 5, 42, 435, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1566, 5, 42, 436, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1567, 5, 42, 437, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1568, 5, 42, 438, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1569, 5, 42, 448, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1570, 5, 42, 449, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1571, 5, 42, 450, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1572, 5, 42, 451, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1573, 5, 42, 452, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1574, 5, 42, 453, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1575, 5, 42, 454, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1576, 5, 42, 455, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1577, 5, 42, 456, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1578, 5, 42, 457, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1579, 5, 42, 472, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1580, 5, 43, 388, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1581, 5, 43, 468, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1582, 5, 43, 469, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1583, 5, 43, 470, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1584, 5, 43, 463, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1585, 5, 43, 439, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1586, 5, 43, 471, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1587, 5, 43, 472, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1588, 5, 43, 473, '2026-09-26 20:02:56', '2026-09-26 20:02:56'),
(1589, 5, 43, 474, '2026-09-26 20:02:56', '2026-09-26 20:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Draft',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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

--
-- Dumping data for table `sales_returns`
--

INSERT INTO `sales_returns` (`id`, `company_id`, `branch_id`, `terminal_id`, `order_id`, `invoice_id`, `customer_id`, `return_number`, `return_type`, `order_total`, `amount_paid`, `balance`, `refund_amount`, `refund_method`, `return_status`, `reason`, `remarks`, `processed_by`, `processed_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 12, 80, 34, 9, 'RET-000001', 'Completed', 1200.00, 1200.00, 0.00, 1200.00, NULL, 'Completed', NULL, 'Full refund processed for sales order: ORD-000041', 1, NULL, 1, NULL, '2026-09-16 10:21:18', '2026-09-16 10:21:18'),
(2, 1, 1, 2, 82, 36, NULL, 'RET-000002', 'Completed', 10500.00, 10500.00, 0.00, 10500.00, 'Transfer', 'Completed', 'Full refund', 'Full refund processed for sales order: ORD-000043', 1, '2026-09-16 13:03:19', 1, 1, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(3, 1, 1, 1, 81, 35, 6, 'RET-000003', 'Completed', 3350.00, 3350.00, 0.00, 1900.00, 'Card', 'Completed', 'Partial return', 'Partial return processed for sales order:', 1, '2026-09-16 13:16:43', 1, 1, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(4, 1, 1, 1, 81, 35, 6, 'RET-000004', 'Completed', 3350.00, 3350.00, 0.00, 250.00, 'Card', 'Completed', 'Partial return', 'Partial return processed for sales order:', 1, '2026-09-16 13:18:22', 1, 1, '2026-09-16 12:18:22', '2026-09-16 12:18:22');

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

--
-- Dumping data for table `sales_return_items`
--

INSERT INTO `sales_return_items` (`id`, `company_id`, `sales_return_id`, `order_item_id`, `product_id`, `product_name`, `product_barcode`, `quantity`, `unit_price`, `unit_cost`, `discount`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 109, 7, 'Family Bread', '100000000007', 2.00, 1200.00, 900.00, 0.00, 0.00, 2400.00, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(2, 1, 2, 110, 6, 'Dangote Sugar 1kg', '100000000006', 3.00, 1650.00, 1450.00, 0.00, 0.00, 4950.00, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(3, 1, 2, 111, 19, 'Three Crown Evaporated Milk', 'TH123456', 2.00, 1200.00, 1000.00, 0.00, 0.00, 2400.00, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(4, 1, 2, 112, 5, 'Indomie Chicken Noodles', '100000000005', 3.00, 250.00, 180.00, 0.00, 0.00, 750.00, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(5, 1, 3, 106, 6, 'Dangote Sugar 1kg', '100000000006', 1.00, 1650.00, 1450.00, 0.00, 0.00, 1650.00, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(6, 1, 3, 108, 5, 'Indomie Chicken Noodles', '100000000005', 1.00, 250.00, 180.00, 0.00, 0.00, 250.00, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(7, 1, 4, 108, 5, 'Indomie Chicken Noodles', '100000000005', 1.00, 250.00, 180.00, 0.00, 0.00, 250.00, '2026-09-16 12:18:22', '2026-09-16 12:18:22');

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

--
-- Dumping data for table `sales_return_payments`
--

INSERT INTO `sales_return_payments` (`id`, `sales_return_id`, `payment_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 38, 1200.00, '2026-09-16 10:21:18', '2026-09-16 10:21:18'),
(2, 2, 40, 10500.00, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(3, 3, 39, 1900.00, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(4, 4, 39, 250.00, '2026-09-16 12:18:22', '2026-09-16 12:18:22');

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
('9cRPMthg3WU1B55OtXfflPEhIPMEv4Z2GsEVFNGK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEVROXBZVFJaSGZYRVhpdEpSVVBoYjRENW9DWm5OQWhCNXhJYzJCZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmUvZW1tYW5leC9vcmRlci9Ec0dKcGppQ3VWVFVRYVl4V3V4MjNNbzNWS2QyaE1KWFhtR04yYVhGNjZiZzlEc3NlOXZ1Y2t0c21sSlFCZTJHIjtzOjU6InJvdXRlIjtzOjI4OiJzdG9yZWZyb250LnB1YmxpYy5vcmRlci5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790546316),
('Wjua7fBhxfJ78vuP17LRyos1Lhogpetcw3zYnMCL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW9GeXNaU2dMbnlNOHphaG9tbVB4UGl5THZQeWFjYlBhU2RXaTU2cyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmUvZW1tYW5leC9vcmRlci9rc1JzUUpVMFJzTDl0S2RFTkZ5UUs0R2g2bmd3OVV5dWM5cEV1dWI4RW83Rm9ESndJNGhQUkxaWlBJUGRORXlWIjtzOjU6InJvdXRlIjtzOjI4OiJzdG9yZWZyb250LnB1YmxpYy5vcmRlci5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790554656),
('ylavpfNZlfsekImI5s9yUz8dYFb5wVdsnQLnsMyz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6Im52RjJDT25HeGpENWw4S0lJQ3V2bnZhdklXMlFlZWFwR0FPT1NwUlMiO3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wbGF0Zm9ybSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjExNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3N0b3JlL2VtbWFuZXgvY2hlY2tvdXQvcGF5bWVudC9jYWxsYmFjaz9yZWZlcmVuY2U9U0YtOTctWUlEVUNYOUZIWjE3JnRyeHJlZj1TRi05Ny1ZSURVQ1g5RkhaMTciO3M6NToicm91dGUiO3M6MzU6InN0b3JlZnJvbnQucHVibGljLmNoZWNrb3V0LmNhbGxiYWNrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjE5OiJFbW1hbmV4IFN1cGVybWFya2V0IjtzOjEyOiJjb21wYW55X2NvZGUiO3M6OToiQ09NUC0wMDAxIjtzOjk6ImJyYW5jaF9pZCI7aToxO3M6ODoiY3VycmVuY3kiO3M6MzoiTkdOIjtzOjE1OiJjdXJyZW5jeV9zeW1ib2wiO3M6Mzoi4oKmIjtzOjg6InRpbWV6b25lIjtzOjEyOiJBZnJpY2EvTGFnb3MiO30=', 1790554638);

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

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_id`, `company_name`, `company_email`, `company_phone`, `company_address`, `company_logo`, `currency`, `currency_symbol`, `tax_rate`, `tax_enabled`, `receipt_footer`, `receipt_header`, `receipt_width`, `print_logo`, `print_barcode`, `allow_negative_stock`, `low_stock_alert`, `allow_price_change`, `allow_price_override`, `enable_discounts`, `allow_discount`, `enable_customer_credit`, `default_customer`, `default_customer_id`, `timezone`, `date_format`, `time_format`, `maintenance_mode`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Emmanex Supermarket Ng', 'info@emmanexitconsult.com', '08012345678', 'Lagos, Nigeria', NULL, 'NGN', '₦', 7.50, 1, 'Thank you for shopping with us.', 'Emmanex Supermarket', 80, 1, 1, 0, 5, 0, 0, 1, 1, 0, 'Walk-in Customer', NULL, 'Africa/Lagos', 'm/d/Y', 'h:i A', 0, 1, '2026-07-29 10:37:13', '2026-09-03 21:09:39'),
(2, 4, 'JustRite Mart', 'justritemart@gmail.com', '08012345678', '12, Alakia, Off New Ife Road.', NULL, 'NGN', '₦', 7.50, 1, 'Thank you for shopping with us.', 'JustRite Mart', 80, 1, 0, 0, 10, 0, 0, 1, 1, 0, NULL, NULL, 'Africa/Lagos', 'd/m/Y', 'h:i A', 0, 1, '2026-09-17 12:10:35', '2026-09-17 12:18:53'),
(3, 5, 'Gadget Padi', 'gadgetpadi@gmail.com', '08104196102', 'Ibadan', NULL, 'NGN', '₦', 7.50, 1, 'Thank you for shopping with us.', NULL, 80, 1, 0, 0, 10, 0, 0, 1, 1, 0, NULL, NULL, 'Africa/Lagos', 'd-m-Y', 'h:i A', 0, 1, '2026-09-26 20:02:56', '2026-09-26 20:02:56');

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

--
-- Dumping data for table `shipping_locations`
--

INSERT INTO `shipping_locations` (`id`, `company_id`, `name`, `description`, `shipping_fee`, `sort_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Apata', 'Apata, Bitmore Junction', 5000.00, 1, 1, 1, 1, '2026-09-27 21:45:50', '2026-09-27 21:59:22'),
(2, 1, 'Challenge Terminal 1', 'Challenge Terminal 1', 5500.00, 2, 1, 1, 1, '2026-09-27 21:56:07', '2026-09-27 21:56:07');

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

--
-- Dumping data for table `shipping_settings`
--

INSERT INTO `shipping_settings` (`id`, `company_id`, `enabled`, `shipping_mode`, `manual_shipping_fee`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'manual', 1000.00, 1, 1, '2026-09-27 21:32:05', '2026-09-27 23:16:25');

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

--
-- Dumping data for table `stock_counts`
--

INSERT INTO `stock_counts` (`id`, `company_id`, `branch_id`, `reference_no`, `count_date`, `status`, `notes`, `created_by`, `completed_by`, `completed_at`, `created_at`, `updated_at`) VALUES
(3, 1, 4, 'SC-000003', '2026-08-15', 'Completed', 'Test stock count', 1, 1, '2026-08-15 11:11:39', '2026-08-15 08:53:31', '2026-08-15 11:11:39');

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

--
-- Dumping data for table `stock_count_items`
--

INSERT INTO `stock_count_items` (`id`, `stock_count_id`, `product_id`, `system_quantity`, `counted_quantity`, `variance`, `unit_cost`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 10.00, 15.00, 5.00, 180.00, NULL, '2026-08-15 10:11:18', '2026-08-15 11:11:39'),
(2, 3, 6, 5.00, 4.00, -1.00, 1450.00, NULL, '2026-08-15 10:11:18', '2026-08-15 11:11:39'),
(3, 3, 7, 5.00, 4.00, -1.00, 900.00, NULL, '2026-08-15 10:11:18', '2026-08-15 11:11:39'),
(4, 3, 8, 5.00, 3.00, -2.00, 82000.00, NULL, '2026-08-15 10:11:18', '2026-08-15 11:11:39'),
(5, 3, 9, 10.00, 9.00, -1.00, 500.00, NULL, '2026-08-15 10:11:18', '2026-08-15 11:11:39');

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

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `company_id`, `branch_id`, `product_id`, `movement_type`, `order_id`, `reference_no`, `unit_cost`, `quantity`, `stock_before`, `balance_after`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(15, 1, 1, 19, 'Transfer Out', NULL, 'TRF-20260811103939-GTPV70', 1000.00, 5.00, 140.00, 135.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(16, 1, 6, 19, 'Transfer In', NULL, 'TRF-20260811103939-GTPV70', 1000.00, 5.00, 0.00, 5.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(17, 1, 1, 10, 'Transfer Out', NULL, 'TRF-20260811103939-GTPV70', 7800.00, 5.00, 90.00, 85.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(18, 1, 6, 10, 'Transfer In', NULL, 'TRF-20260811103939-GTPV70', 7800.00, 5.00, 0.00, 5.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(19, 1, 1, 9, 'Transfer Out', NULL, 'TRF-20260811103939-GTPV70', 500.00, 10.00, 100.00, 90.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(20, 1, 6, 9, 'Transfer In', NULL, 'TRF-20260811103939-GTPV70', 500.00, 10.00, 0.00, 10.00, 'Items transferred by Femi.', 1, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(21, 1, 1, 9, 'Transfer Out', NULL, 'TRF-20260814111511-MPNNZ9', 500.00, 10.00, 90.00, 80.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(22, 1, 4, 9, 'Transfer In', NULL, 'TRF-20260814111511-MPNNZ9', 500.00, 10.00, 0.00, 10.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(23, 1, 1, 8, 'Transfer Out', NULL, 'TRF-20260814111511-MPNNZ9', 82000.00, 5.00, 100.00, 95.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(24, 1, 4, 8, 'Transfer In', NULL, 'TRF-20260814111511-MPNNZ9', 82000.00, 5.00, 0.00, 5.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(25, 1, 1, 7, 'Transfer Out', NULL, 'TRF-20260814111511-MPNNZ9', 900.00, 5.00, 100.00, 95.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(26, 1, 4, 7, 'Transfer In', NULL, 'TRF-20260814111511-MPNNZ9', 900.00, 5.00, 0.00, 5.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(27, 1, 1, 6, 'Transfer Out', NULL, 'TRF-20260814111511-MPNNZ9', 1450.00, 5.00, 100.00, 95.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(28, 1, 4, 6, 'Transfer In', NULL, 'TRF-20260814111511-MPNNZ9', 1450.00, 5.00, 0.00, 5.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(29, 1, 1, 5, 'Transfer Out', NULL, 'TRF-20260814111511-MPNNZ9', 180.00, 10.00, 100.00, 90.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(30, 1, 4, 5, 'Transfer In', NULL, 'TRF-20260814111511-MPNNZ9', 180.00, 10.00, 0.00, 10.00, '#5 item transfered', 1, '2026-08-14 10:15:11', '2026-08-14 10:15:11'),
(31, 1, 4, 5, 'Adjustment', NULL, 'SC-000003', 180.00, 5.00, 10.00, 15.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(32, 1, 4, 6, 'Adjustment', NULL, 'SC-000003', 1450.00, -1.00, 5.00, 4.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(33, 1, 4, 7, 'Adjustment', NULL, 'SC-000003', 900.00, -1.00, 5.00, 4.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(34, 1, 4, 8, 'Adjustment', NULL, 'SC-000003', 82000.00, -2.00, 5.00, 3.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(35, 1, 4, 9, 'Adjustment', NULL, 'SC-000003', 500.00, -1.00, 10.00, 9.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39'),
(36, 1, 1, 1, 'Purchase', NULL, 'GR-000002', 500.00, 1000.00, 90.00, 1090.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(37, 1, 1, 6, 'Purchase', NULL, 'GR-000002', 1450.00, 400.00, 95.00, 495.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(38, 1, 1, 2, 'Purchase', NULL, 'GR-000002', 500.00, 400.00, 100.00, 500.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(39, 1, 1, 19, 'Purchase', NULL, 'GR-000002', 1000.00, 150.00, 135.00, 285.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(40, 1, 1, 10, 'Purchase', NULL, 'GR-000002', 7800.00, 400.00, 85.00, 485.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 11:11:37', '2026-08-22 11:11:37'),
(41, 1, 1, 6, 'Purchase', NULL, 'GR-000003', 1450.00, 1100.00, 495.00, 1595.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 12:51:24', '2026-08-22 12:51:24'),
(42, 1, 1, 2, 'Purchase', NULL, 'GR-000004', 500.00, 1600.00, 500.00, 2100.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 13:03:30', '2026-08-22 13:03:30'),
(43, 1, 1, 19, 'Purchase', NULL, 'GR-000005', 1000.00, 1350.00, 285.00, 1635.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 13:14:09', '2026-08-22 13:14:09'),
(44, 1, 1, 10, 'Purchase', NULL, 'GR-000006', 7800.00, 600.00, 485.00, 1085.00, 'Goods received against purchase order PO-202608-00002', 1, '2026-08-22 13:16:15', '2026-08-22 13:16:15'),
(45, 1, 1, 1, 'Return', NULL, 'PRN-000001', 500.00, -50.00, 1090.00, 1040.00, 'Purchase return against purchase order PO-202608-00002', 1, '2026-08-26 10:23:50', '2026-08-26 10:23:50'),
(46, 1, 1, 1, 'Return', NULL, 'PRN-000002', 500.00, -50.00, 1040.00, 990.00, 'Purchase return against purchase order PO-202608-00002', 1, '2026-08-26 11:35:10', '2026-08-26 11:35:10'),
(47, 1, 1, 6, 'Return', NULL, 'PRN-000003', 1450.00, -50.00, 1595.00, 1545.00, 'Purchase return against purchase order PO-202608-00002', 1, '2026-08-26 12:05:19', '2026-08-26 12:05:19'),
(48, 1, 1, 2, 'Return', NULL, 'PRN-000004', 500.00, -50.00, 2100.00, 2050.00, 'Purchase return against purchase order PO-202608-00002', 1, '2026-08-27 09:44:50', '2026-08-27 09:44:50'),
(49, 1, 1, 10, 'Return', NULL, 'PRN-000004', 7800.00, -50.00, 1085.00, 1035.00, 'Purchase return against purchase order PO-202608-00002', 1, '2026-08-27 09:44:50', '2026-08-27 09:44:50'),
(50, 1, 4, 8, 'Sale', NULL, 'ORD-000013', 82000.00, 2.00, 3.00, 1.00, 'Sales Order completed: ORD-000013', 1, '2026-08-27 23:51:21', '2026-08-27 23:51:21'),
(51, 1, 4, 6, 'Sale', NULL, 'ORD-000013', 1450.00, 2.00, 4.00, 2.00, 'Sales Order completed: ORD-000013', 1, '2026-08-27 23:51:21', '2026-08-27 23:51:21'),
(56, 1, 4, 8, 'Sale', 17, 'ORD-000014', 82000.00, 1.00, 1.00, 0.00, 'Sales Order completed: ORD-000014', 1, '2026-08-28 09:20:27', '2026-08-28 09:20:27'),
(57, 1, 4, 6, 'Sale', 17, 'ORD-000014', 1450.00, 1.00, 2.00, 1.00, 'Sales Order completed: ORD-000014', 1, '2026-08-28 09:20:27', '2026-08-28 09:20:27'),
(58, 1, 1, 19, 'Sale', 18, 'ORD-000015', 1000.00, 20.00, 1635.00, 1615.00, 'Sales Order completed: ORD-000015', 1, '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(59, 1, 1, 8, 'Sale', 18, 'ORD-000015', 82000.00, 10.00, 95.00, 85.00, 'Sales Order completed: ORD-000015', 1, '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(60, 1, 1, 6, 'Sale', 18, 'ORD-000015', 1450.00, 10.00, 1545.00, 1535.00, 'Sales Order completed: ORD-000015', 1, '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(61, 1, 1, 10, 'Sale', 18, 'ORD-000015', 7800.00, 5.00, 1035.00, 1030.00, 'Sales Order completed: ORD-000015', 1, '2026-08-28 10:11:22', '2026-08-28 10:11:22'),
(62, 1, 1, 19, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 1000.00, 10.00, 1615.00, 1605.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(63, 1, 2, 19, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 1000.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(64, 1, 1, 10, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 7800.00, 10.00, 1030.00, 1020.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(65, 1, 2, 10, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 7800.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(66, 1, 1, 9, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 80.00, 70.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(67, 1, 2, 9, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(68, 1, 1, 8, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 82000.00, 10.00, 85.00, 75.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(69, 1, 2, 8, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 82000.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(70, 1, 1, 7, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 900.00, 10.00, 95.00, 85.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(71, 1, 2, 7, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 900.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(72, 1, 1, 6, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 1450.00, 10.00, 1535.00, 1525.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(73, 1, 2, 6, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 1450.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(74, 1, 1, 5, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 180.00, 10.00, 90.00, 80.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(75, 1, 2, 5, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 180.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(76, 1, 1, 4, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 4200.00, 10.00, 100.00, 90.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(77, 1, 2, 4, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 4200.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(78, 1, 1, 3, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 100.00, 90.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(79, 1, 2, 3, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(80, 1, 1, 2, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 2050.00, 2040.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(81, 1, 2, 2, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(82, 1, 1, 1, 'Transfer Out', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 990.00, 980.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(83, 1, 2, 1, 'Transfer In', NULL, 'TRF-20260831110507-GZTMGC', 500.00, 10.00, 0.00, 10.00, '10 items each across all product.', 1, '2026-08-31 10:05:07', '2026-08-31 10:05:07'),
(86, 1, 2, 2, 'Sale', 22, 'ORD-000019', 500.00, 1.00, 10.00, 9.00, 'Sales Order completed: ORD-000019', 17, '2026-08-31 10:15:05', '2026-08-31 10:15:05'),
(87, 1, 2, 19, 'Sale', 28, 'ORD-000020', 1000.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(88, 1, 2, 3, 'Sale', 28, 'ORD-000020', 500.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(89, 1, 2, 6, 'Sale', 28, 'ORD-000020', 1450.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(90, 1, 2, 1, 'Sale', 28, 'ORD-000020', 500.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-02 11:38:01', '2026-09-02 11:38:01'),
(91, 1, 2, 19, 'Sale', 29, 'ORD-000021', 1000.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 12:53:33', '2026-09-03 12:53:33'),
(92, 1, 2, 8, 'Sale', 30, 'ORD-000022', 82000.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 13:26:09', '2026-09-03 13:26:09'),
(93, 1, 2, 2, 'Sale', 31, 'ORD-000023', 500.00, 2.00, 9.00, 7.00, 'Sales Order completed: ORD-000023', 17, '2026-09-03 13:30:47', '2026-09-03 13:30:47'),
(94, 1, 2, 7, 'Sale', 32, 'ORD-000024', 900.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 14:04:14', '2026-09-03 14:04:14'),
(95, 1, 2, 9, 'Sale', 33, 'ORD-000025', 500.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 14:35:52', '2026-09-03 14:35:52'),
(96, 1, 2, 4, 'Sale', 34, 'ORD-000026', 4200.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 14:41:20', '2026-09-03 14:41:20'),
(97, 1, 2, 5, 'Sale', 35, 'ORD-000027', 180.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 14:42:11', '2026-09-03 14:42:11'),
(98, 1, 2, 1, 'Sale', 37, 'ORD-000028', 500.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 14:44:26', '2026-09-03 14:44:26'),
(99, 1, 2, 7, 'Sale', 38, 'ORD-000029', 900.00, 2.00, 9.00, 7.00, 'POS Sale', 15, '2026-09-03 14:48:07', '2026-09-03 14:48:07'),
(100, 1, 2, 9, 'Sale', 39, 'ORD-000030', 500.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 14:49:35', '2026-09-03 14:49:35'),
(101, 1, 2, 7, 'Sale', 40, 'ORD-000031', 900.00, 1.00, 7.00, 6.00, 'POS Sale', 15, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(102, 1, 2, 10, 'Sale', 40, 'ORD-000031', 7800.00, 1.00, 10.00, 9.00, 'POS Sale', 15, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(103, 1, 2, 6, 'Sale', 40, 'ORD-000031', 1450.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 14:57:36', '2026-09-03 14:57:36'),
(104, 1, 2, 10, 'Sale', 41, 'ORD-000032', 7800.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 15:22:00', '2026-09-03 15:22:00'),
(105, 1, 2, 8, 'Sale', 42, 'ORD-000033', 82000.00, 1.00, 9.00, 8.00, 'POS Sale', 15, '2026-09-03 20:14:44', '2026-09-03 20:14:44'),
(106, 1, 2, 9, 'Sale', 73, 'ORD-000034', 500.00, 1.00, 8.00, 7.00, 'POS Sale', 15, '2026-09-04 08:09:17', '2026-09-04 08:09:17'),
(107, 1, 2, 9, 'Sale', 74, 'ORD-000035', 500.00, 1.00, 7.00, 6.00, 'POS Sale', 15, '2026-09-04 08:09:32', '2026-09-04 08:09:32'),
(108, 1, 2, 9, 'Sale', 75, 'ORD-000036', 500.00, 1.00, 6.00, 5.00, 'POS Sale', 15, '2026-09-04 08:17:39', '2026-09-04 08:17:39'),
(109, 1, 2, 10, 'Sale', 76, 'ORD-000037', 7800.00, 1.00, 8.00, 7.00, 'POS Sale', 15, '2026-09-04 08:19:05', '2026-09-04 08:19:05'),
(110, 1, 2, 19, 'Sale', 77, 'ORD-000038', 1000.00, 1.00, 8.00, 7.00, 'POS Sale', 15, '2026-09-04 08:22:48', '2026-09-04 08:22:48'),
(111, 1, 2, 10, 'Sale', 78, 'ORD-000039', 7800.00, 1.00, 7.00, 6.00, 'POS Sale', 15, '2026-09-04 08:57:18', '2026-09-04 08:57:18'),
(112, 1, 2, 19, 'Sale', 79, 'ORD-000040', 1000.00, 1.00, 7.00, 6.00, 'POS Sale', 15, '2026-09-14 13:30:52', '2026-09-14 13:30:52'),
(116, 1, 4, 7, 'Sale', 80, 'ORD-000041', 900.00, 1.00, 4.00, 3.00, 'Sales Order completed: ORD-000041', 1, '2026-09-14 13:38:08', '2026-09-14 13:38:08'),
(117, 1, 4, 7, 'Return', 80, 'RET-000001', 900.00, 1.00, 3.00, 4.00, 'Stock returned from sales refund: ORD-000041', 1, '2026-09-16 10:21:18', '2026-09-16 10:21:18'),
(118, 1, 1, 6, 'Sale', 81, 'ORD-000042', 1450.00, 1.00, 1525.00, 1524.00, 'Sales Order completed: ORD-000042', 1, '2026-09-16 10:40:05', '2026-09-16 10:40:05'),
(119, 1, 1, 7, 'Sale', 81, 'ORD-000042', 900.00, 1.00, 85.00, 84.00, 'Sales Order completed: ORD-000042', 1, '2026-09-16 10:40:05', '2026-09-16 10:40:05'),
(120, 1, 1, 5, 'Sale', 81, 'ORD-000042', 180.00, 2.00, 80.00, 78.00, 'Sales Order completed: ORD-000042', 1, '2026-09-16 10:40:05', '2026-09-16 10:40:05'),
(121, 1, 1, 7, 'Sale', 82, 'ORD-000043', 900.00, 2.00, 84.00, 82.00, 'Sales Order completed: ORD-000043', 1, '2026-09-16 12:02:34', '2026-09-16 12:02:34'),
(122, 1, 1, 6, 'Sale', 82, 'ORD-000043', 1450.00, 3.00, 1524.00, 1521.00, 'Sales Order completed: ORD-000043', 1, '2026-09-16 12:02:34', '2026-09-16 12:02:34'),
(123, 1, 1, 19, 'Sale', 82, 'ORD-000043', 1000.00, 2.00, 1605.00, 1603.00, 'Sales Order completed: ORD-000043', 1, '2026-09-16 12:02:34', '2026-09-16 12:02:34'),
(124, 1, 1, 5, 'Sale', 82, 'ORD-000043', 180.00, 3.00, 78.00, 75.00, 'Sales Order completed: ORD-000043', 1, '2026-09-16 12:02:34', '2026-09-16 12:02:34'),
(125, 1, 1, 7, 'Return', 82, 'RET-000002', 900.00, 2.00, 82.00, 84.00, 'Stock returned from sales refund: ORD-000043', 1, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(126, 1, 1, 6, 'Return', 82, 'RET-000002', 1450.00, 3.00, 1521.00, 1524.00, 'Stock returned from sales refund: ORD-000043', 1, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(127, 1, 1, 19, 'Return', 82, 'RET-000002', 1000.00, 2.00, 1603.00, 1605.00, 'Stock returned from sales refund: ORD-000043', 1, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(128, 1, 1, 5, 'Return', 82, 'RET-000002', 180.00, 3.00, 75.00, 78.00, 'Stock returned from sales refund: ORD-000043', 1, '2026-09-16 12:03:19', '2026-09-16 12:03:19'),
(129, 1, 1, 6, 'Return', 81, 'RET-000003', 1450.00, 1.00, 1524.00, 1525.00, 'Partial return for sales order ORD-000042.', 1, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(130, 1, 1, 5, 'Return', 81, 'RET-000003', 180.00, 1.00, 78.00, 79.00, 'Partial return for sales order ORD-000042.', 1, '2026-09-16 12:16:43', '2026-09-16 12:16:43'),
(131, 1, 1, 5, 'Return', 81, 'RET-000004', 180.00, 1.00, 79.00, 80.00, 'Partial return for sales order ORD-000042.', 1, '2026-09-16 12:18:22', '2026-09-16 12:18:22'),
(132, 1, 1, 19, 'Damage', NULL, NULL, 1000.00, 5.00, 1605.00, 1600.00, '5 damaged items', NULL, '2026-09-16 12:34:45', '2026-09-16 12:34:45'),
(133, 1, 1, 1, 'Expired', NULL, NULL, 500.00, 4.98, 980.00, 975.02, NULL, NULL, '2026-09-16 12:46:46', '2026-09-16 12:46:46'),
(134, 1, 1, 19, 'Sale', 83, 'ORD-000044', 1000.00, 2.00, 1600.00, 1598.00, 'Online Storefront order completed: ORD-000044', NULL, '2026-09-26 22:47:47', '2026-09-26 22:47:47'),
(135, 1, 1, 4, 'Sale', 83, 'ORD-000044', 4200.00, 2.00, 90.00, 88.00, 'Online Storefront order completed: ORD-000044', NULL, '2026-09-26 22:47:47', '2026-09-26 22:47:47'),
(136, 1, 1, 8, 'Sale', 83, 'ORD-000044', 82000.00, 1.00, 75.00, 74.00, 'Online Storefront order completed: ORD-000044', NULL, '2026-09-26 22:47:47', '2026-09-26 22:47:47'),
(137, 1, 1, 19, 'Sale', 84, 'ORD-000045', 1000.00, 2.00, 1598.00, 1596.00, 'Online Storefront order completed: ORD-000045', NULL, '2026-09-26 22:58:41', '2026-09-26 22:58:41'),
(138, 1, 1, 8, 'Sale', 85, 'ORD-000046', 82000.00, 1.00, 74.00, 73.00, 'Online Storefront order completed: ORD-000046', NULL, '2026-09-26 23:06:08', '2026-09-26 23:06:08'),
(139, 1, 1, 10, 'Sale', 86, 'ORD-000047', 7800.00, 1.00, 1020.00, 1019.00, 'Online Storefront order completed: ORD-000047', NULL, '2026-09-27 12:41:34', '2026-09-27 12:41:34'),
(140, 1, 1, 19, 'Sale', 87, 'ORD-000048', 1000.00, 1.00, 1596.00, 1595.00, 'Online Storefront order completed: ORD-000048', NULL, '2026-09-27 20:45:24', '2026-09-27 20:45:24'),
(141, 1, 1, 1, 'Sale', 88, 'ORD-000049', 500.00, 2.00, 975.02, 973.02, 'Online Storefront order completed: ORD-000049', NULL, '2026-09-27 20:57:54', '2026-09-27 20:57:54'),
(142, 1, 1, 10, 'Sale', 93, 'ORD-000054', 7800.00, 1.00, 1019.00, 1018.00, 'Online Storefront order completed: ORD-000054', NULL, '2026-09-27 22:51:27', '2026-09-27 22:51:27'),
(143, 1, 1, 9, 'Sale', 94, 'ORD-000055', 500.00, 1.00, 70.00, 69.00, 'Online Storefront order completed: ORD-000055', NULL, '2026-09-27 23:00:03', '2026-09-27 23:00:03'),
(144, 1, 1, 7, 'Sale', 95, 'ORD-000056', 900.00, 1.00, 84.00, 83.00, 'Online Storefront order completed: ORD-000056', NULL, '2026-09-27 23:07:29', '2026-09-27 23:07:29'),
(145, 1, 1, 10, 'Sale', 96, 'ORD-000057', 7800.00, 1.00, 1018.00, 1017.00, 'Online Storefront order completed: ORD-000057', NULL, '2026-09-27 23:11:25', '2026-09-27 23:11:25'),
(146, 1, 1, 5, 'Sale', 97, 'ORD-000058', 180.00, 4.00, 80.00, 76.00, 'Online Storefront order completed: ORD-000058', NULL, '2026-09-27 23:17:12', '2026-09-27 23:17:12');

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
  `enabled_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `storefronts`
--

INSERT INTO `storefronts` (`id`, `company_id`, `name`, `slug`, `status`, `enabled_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'Gadget Padi', 'gadget-padi', 'Active', '2026-09-26 20:46:04', 21, 21, '2026-09-26 20:02:57', '2026-09-26 20:48:43'),
(2, 4, 'JustRite Mart', 'justrite-mart', 'Active', '2026-09-26 20:53:54', 20, 20, '2026-09-26 20:53:38', '2026-09-26 20:53:54'),
(3, 1, 'Emmanex Supermarket', 'emmanex', 'Active', '2026-09-26 21:35:17', 1, 1, '2026-09-26 21:35:03', '2026-09-26 21:35:17');

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

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_id`, `supplier_code`, `name`, `contact_person`, `email`, `phone`, `alternate_phone`, `address`, `city`, `state`, `country`, `tax_number`, `payment_terms`, `credit_limit`, `current_balance`, `notes`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'SUP-00001', 'Friezland Group of Companies', 'Mr Adeleke Abayomi', 'info@friezland.com', '07032109983', '07032109983', '17, Ojokoro avenue, abeokuta, Ogun State.', 'Abeokuta', 'Ogun', 'Nigeria', '29839393', '30 days', 1000000.00, 0.00, 'Friezland.', 1, 1, 1, '2026-08-16 11:27:31', '2026-08-16 11:27:31', NULL),
(2, 1, 'SUP-00002', 'Nigerian Breweries', 'Mrs Afonja Omowunmi', 'info@nigbreweries.com', '08034271855', '08034271855', 'Nigerial Breweries, Off Alakia Road, Ibadan', 'Ibadan', 'Oyo', 'Nigeria', '09030922', '30 days', 2000000.00, 0.00, 'Nigerian Breweries.', 1, 1, 1, '2026-08-16 11:35:20', '2026-08-16 11:45:37', NULL);

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
(1, 1, NULL, NULL, '1c77e876-5fd7-4306-b8d5-8ff3ee1ea905', 'EMNEX Sync Test Device', 'local', '1.0.0', '1.0.0', '$2y$12$pduDpZNlFml7eufd.mr49O/KxLhJBHvra6rweqdeYy0vouqAKRe3u', '2026-09-22 08:17:42', 1, '2026-09-22 08:17:42', NULL, '2026-09-22 08:17:42', '2026-09-22 08:17:42');

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
(1, 1, 'No Tax', 0.00, 1, '2026-07-29 10:37:13', '2026-08-04 08:49:18'),
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

INSERT INTO `terminals` (`id`, `company_id`, `branch_id`, `terminal_code`, `terminal_name`, `description`, `device_name`, `ip_address`, `status`, `last_seen_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'BR001-POS01', 'Head Office POS 1', 'Main Checkout', 'Desktop POS', '192.168.0.23', 1, NULL, '2026-07-29 10:37:09', '2026-08-09 14:46:14', NULL),
(2, 1, 1, 'BR001-POS02', 'Head Office POS 2', NULL, 'Desktop POS', NULL, 1, NULL, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(3, 1, 2, 'BR002-POS01', 'Lekki Branch POS 1', NULL, 'Desktop POS', NULL, 1, NULL, '2026-07-29 10:37:09', '2026-07-29 10:37:09', NULL),
(11, 1, 4, 'Ajah-Pos1', 'Front Counter POS', 'Main Checkout', 'Dell Optilex', '192.168.0.24', 1, NULL, '2026-08-01 22:42:04', '2026-08-01 23:42:15', '2026-08-01 23:42:15'),
(12, 1, 4, 'Ajah-01', 'Front Counter-Ajah01', 'Dell Optilex', 'Dell Optilex', '192.168.0.23', 1, NULL, '2026-08-27 13:06:31', '2026-08-27 13:06:31', NULL),
(13, 1, 2, 'Lek-Pos2', 'Lekki-Pos2', 'Main Checkout', 'Dell Optilex', NULL, 1, NULL, '2026-08-30 15:19:56', '2026-08-30 15:19:56', NULL),
(14, 1, 2, 'Lek-Pos3', 'Lekki-Pos3', NULL, 'Desktop POS', NULL, 1, NULL, '2026-08-30 15:20:14', '2026-08-30 15:20:14', NULL),
(17, 4, 11, 'BR789649-POS01', 'Head Office POS 1', NULL, 'Desktop POS', NULL, 1, NULL, '2026-09-17 12:10:34', '2026-09-17 12:10:34', NULL),
(18, 5, 12, 'BR818641-POS01', 'Head Office POS 1', NULL, 'Desktop POS', NULL, 1, NULL, '2026-09-26 20:02:55', '2026-09-26 20:02:55', NULL);

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

--
-- Dumping data for table `terminal_assignments`
--

INSERT INTO `terminal_assignments` (`id`, `company_id`, `branch_id`, `terminal_id`, `user_id`, `assigned_at`, `unassigned_at`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 3, 15, '2026-08-30 16:57:55', '2026-08-30 15:57:55', 'Inactive', 1, 1, '2026-08-30 15:43:28', '2026-08-30 15:57:55'),
(2, 1, 2, 14, 15, '2026-08-30 15:57:55', NULL, 'Active', 1, 1, '2026-08-30 15:57:55', '2026-08-30 15:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `units` (`id`, `company_id`, `unit_code`, `name`, `short_name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'UNT000001', 'Piece', 'PCS', 'Piece', 1, NULL, 1, '2026-07-29 10:37:13', '2026-08-03 14:02:59', NULL),
(2, 1, 'UNT000002', 'Pack', 'PK', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(3, 1, 'UNT000003', 'Carton', 'CTN', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(4, 1, 'UNT000004', 'Bottle', 'BTL', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(5, 1, 'UNT000005', 'Can', 'CAN', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(6, 1, 'UNT000006', 'Kilogram', 'KG', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(7, 1, 'UNT000007', 'Gram', 'G', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(8, 1, 'UNT000008', 'Litre', 'LTR', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(9, 1, 'UNT000009', 'Millilitre', 'ML', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(10, 1, 'UNT000010', 'Dozen', 'DOZ', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(11, 1, 'UNT000011', 'Bag', 'BAG', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(12, 1, 'UNT000012', 'Roll', 'ROL', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(13, 1, 'UNT000013', 'Box', 'BOX', NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-08-03 13:35:02', NULL),
(14, 1, 'UNT000014', 'Text', 'TXT', 'Text', 1, 1, 1, '2026-08-03 14:02:30', '2026-08-04 08:48:18', '2026-08-04 08:48:18'),
(15, 4, 'UNT000001', 'Piece', 'PCS', 'Piece', 1, 20, 20, '2026-09-21 08:58:45', '2026-09-21 08:58:45', NULL);

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `branch_id`, `role_id`, `employee_no`, `first_name`, `other_name`, `last_name`, `username`, `email`, `is_owner`, `email_verified_at`, `two_factor_enabled`, `phone`, `password`, `profile_photo`, `gender`, `date_of_birth`, `employment_date`, `address`, `notes`, `status`, `last_login_at`, `last_activity_at`, `last_login_ip`, `force_password_change`, `password_changed_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 'EMP0001', 'Femi', NULL, 'Akinyooye', 'owner', 'owner@emmanexitconsult.com', 1, '2026-07-29 10:37:10', 0, NULL, '$2y$12$TglPMRngPpJdy87jIqPCD.lS8NkqbWo.x4OzoBqn.OX/eY55OhJYy', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:10', '2026-08-08 08:30:00', NULL),
(2, 1, 1, 2, 'EMP0002', 'System', NULL, 'Administrator', 'admin', 'admin@emmanexitconsult.com', 0, '2026-07-29 10:37:10', 0, NULL, '$2y$12$zPemhQB4t0by5HjwdteQX.Zfuas6VQ3BuaQzN8SALTxqhG6zQvRJ6', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(3, 1, 1, 3, 'EMP0003', 'Branch', NULL, 'Manager', 'manager', 'manager@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$VG6ccScaNLrU.r011G.DMueH3D1TuNPUKaJa/eT3JWQe.PkUdy4cK', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(4, 1, 1, 4, 'EMP0004', 'Branch', NULL, 'Supervisor', 'supervisor', 'supervisor@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$Mnb.9S7tdyOowvwKXTlK9edKlg0UC8jM4R.AOw5Y4.kwnHCf32Uz6', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:11', '2026-07-29 10:37:11', NULL),
(5, 1, 1, 5, 'EMP0005', 'Main', NULL, 'Cashier', 'cashier', 'cashier@emmanexitconsult.com', 0, '2026-07-29 10:37:11', 0, NULL, '$2y$12$T1ovqUxatrDaNNgfTtkRUOGZtYbvmkVjao8EU/1LCJFH1KA0M.1qO', NULL, NULL, '1991-06-12', '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:12', '2026-08-09 14:53:48', NULL),
(6, 1, 1, 6, 'EMP0006', 'Inventory', NULL, 'Manager', 'inventory', 'inventory@emmanexitconsult.com', 0, '2026-07-29 10:37:12', 0, NULL, '$2y$12$lWJtwgUPhnO44mwKMNifgeZiD.oVJwv9QqHYPCMNMOSpP0IhCHNAC', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:12', '2026-07-29 10:37:12', NULL),
(7, 1, 1, 7, 'EMP0007', 'Company', NULL, 'Accountant', 'accountant', 'accountant@emmanexitconsult.com', 0, '2026-07-29 10:37:12', 0, NULL, '$2y$12$Aj3KYFJ24AXQQWWE3taN.uWPk/7eQSkS9oH84LMpPHxJ6nq1vXS5i', NULL, NULL, NULL, '2026-07-29', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL),
(15, 1, 2, 5, 'CH-2026-001', 'Paul', 'Olusogo', 'Awolola', 'paul', 'bizcare@gmail.com', 0, NULL, 0, '07038899203', '$2y$12$Sstz2CJuURgxEXVIu/DD3.yNOZrTmaT/UcICvHI7J4Qa5RX/e4AYu', NULL, 'Male', '1987-11-25', '2026-07-06', 'Adelu, Ido, Ibadan.', 'Transfered from Ajah branch', 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-30 00:35:56', '2026-08-30 16:02:34', NULL),
(17, 1, 2, 3, 'MG-2026-001', 'Maxwell', 'Akinkunmi', 'Akinyooye', 'maxwell', 'maxwell@gmail.com', 0, NULL, 0, '08034271855', '$2y$12$YS766Mx5bkWAuuDym1EBy.OtUEY3ZGb0OJ7pkrLEZtXraADh8iMf.', NULL, 'Male', '2017-09-27', '2026-08-03', 'Ibadan', 'Branch manager of lekki branch.', 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-08-09 07:43:51', '2026-08-31 05:55:33', NULL),
(20, 4, 11, 30, 'EMP349474', 'Maxwell', NULL, 'Akinkunmi', 'maxwell', 'maxwell@yahoo.com', 0, NULL, 0, '07034657383', '$2y$12$DnDbvBNCMCu.7hVSTvvNQ.JO2HhoafnjfpozoB1WoZy8okDawKHHS', NULL, NULL, NULL, '2026-09-17', NULL, NULL, 1, NULL, NULL, NULL, 0, '2026-09-17 12:10:35', NULL, '2026-09-17 12:10:35', '2026-09-17 12:10:35', NULL),
(21, 5, 12, 37, 'EMP610845', 'Miracle', NULL, 'Peter', 'miracle', 'miracle.kingsbranding@gmail.com', 0, NULL, 0, '08104196102', '$2y$12$NsRo4hk8yz7zCsjcECKGU.r1X9mzpR.aL2chVg5abmvy9Q724eThC', NULL, NULL, NULL, '2026-09-26', NULL, NULL, 1, NULL, NULL, NULL, 0, '2026-09-26 20:02:56', NULL, '2026-09-26 20:02:56', '2026-09-26 20:02:56', NULL);

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
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`);

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
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_orders_company_id_order_number_unique` (`company_id`,`order_number`),
  ADD KEY `sales_orders_branch_id_foreign` (`branch_id`),
  ADD KEY `sales_orders_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_orders_created_by_foreign` (`created_by`),
  ADD KEY `sales_orders_company_id_order_date_index` (`company_id`,`order_date`),
  ADD KEY `sales_orders_company_id_status_index` (`company_id`,`status`);

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
  ADD UNIQUE KEY `tax_rates_company_id_name_unique` (`company_id`,`name`);

--
-- Indexes for table `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terminals_company_id_terminal_code_unique` (`company_id`,`terminal_code`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cash_drawer_transactions`
--
ALTER TABLE `cash_drawer_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_archives`
--
ALTER TABLE `company_archives`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `data_lifecycle_settings`
--
ALTER TABLE `data_lifecycle_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods_received`
--
ALTER TABLE `goods_received`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `goods_received_items`
--
ALTER TABLE `goods_received_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

--
-- AUTO_INCREMENT for table `platform_admins`
--
ALTER TABLE `platform_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1590;

--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_locations`
--
ALTER TABLE `shipping_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `storefronts`
--
ALTER TABLE `storefronts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sync_devices`
--
ALTER TABLE `sync_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sync_logs`
--
ALTER TABLE `sync_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sync_mutations`
--
ALTER TABLE `sync_mutations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sync_queue`
--
ALTER TABLE `sync_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `terminal_assignments`
--
ALTER TABLE `terminal_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- Constraints for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD CONSTRAINT `sales_orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `sales_orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

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
