-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2026 at 01:05 PM
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
(173, 1, 1, 1, 'customers', 'disable', 'Disabled customer: Femi Akinyooye', 'Customer', 6, '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":true,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:50.000000Z\",\"deleted_at\":null}', '{\"id\":6,\"company_id\":1,\"customer_group_id\":2,\"branch_id\":null,\"customer_code\":\"CUS-00001\",\"first_name\":\"Femi\",\"last_name\":\"Akinyooye\",\"email\":\"emmakinyooye@gmail.com\",\"phone\":\"07032689329\",\"address\":\"Ibadan\",\"credit_limit\":\"50000.00\",\"current_balance\":\"0.00\",\"customer_type\":\"Walk-in\",\"loyalty_points\":0,\"last_purchase_date\":null,\"status\":false,\"created_by\":1,\"updated_by\":1,\"created_at\":\"2026-08-16T03:50:25.000000Z\",\"updated_at\":\"2026-08-16T05:53:54.000000Z\",\"deleted_at\":null}', 'customers/6/disable', 'PATCH', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', NULL, '127.0.0.1', NULL, NULL, NULL, '2026-08-16 04:53:54', '2026-08-16 04:53:54');

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
(6, 1, 'BR004', 'Ikorodu Outlet', '07038899203', 'Ikd@emmanexitconsult.com', 'Odogunyan, Ikorodu, Lagos.', 0, 1, '2026-07-31 14:52:50', '2026-08-01 21:41:51', NULL);

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
(6, 1, 2, NULL, 'CUS-00001', 'Femi', 'Akinyooye', 'emmakinyooye@gmail.com', '07032689329', 'Ibadan', 50000.00, 0.00, 'Walk-in', 0, NULL, 0, 1, 1, '2026-08-16 02:50:25', '2026-08-16 04:53:54', NULL);

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
(5, 1, 'Test Discount', 1, 'Percentage', 2.00, '2026-08-04', '2026-08-31', 1, '2026-08-04 10:06:31', '2026-08-04 10:30:03', '2026-08-04 10:30:03');

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
(3, 1, 'customer', 'CUS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(4, 1, 'supplier', 'SUP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(5, 1, 'order', 'ORD', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-09 15:34:59', 0),
(6, 1, 'payment', 'PAY', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(7, 1, 'purchase', 'PUR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(8, 1, 'purchase_return', 'PRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(9, 1, 'sales_return', 'SRN', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(10, 1, 'stock_movement', 'STM', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(11, 1, 'stock_adjustment', 'ADJ', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(12, 1, 'expense', 'EXP', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(13, 1, 'unit', 'UNT', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(14, 1, 'tax', 'TAX', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(15, 1, 'discount', 'DIS', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-03 13:22:19', '2026-08-03 13:22:19', 0),
(16, 1, 'Invoice', 'INV', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(17, 1, 'Receipt', 'REC', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(18, 1, 'Sales Order', 'SO', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(19, 1, 'Purchase Order', 'PO', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(20, 1, 'Purchase Return', 'PR', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(22, 1, 'stock_transfer', 'ST', NULL, '-', 1, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-09 11:49:56', 0),
(23, 1, 'stock_count', 'SC', NULL, '-', 4, 6, 'Never', NULL, 1, '2026-08-09 11:49:56', '2026-08-15 08:53:31', 0);

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
(47, '2026_08_15_134244_add_customer_group_id_to_customers_table', 16);

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
  `payment_status` enum('Pending','Completed','Failed','Cancelled','Refunded') NOT NULL DEFAULT 'Completed',
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` datetime NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED NOT NULL,
  `payment_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` enum('Cash','POS','Transfer','Wallet','Credit','Cheque') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 1, 'POS', 'POS', 'bi-credit-card', 'primary', 1, 0, 0, 2, 1, '2026-08-02 09:51:36', '2026-08-09 15:43:40', NULL),
(3, 1, 'Transfer', 'TRANSFER', 'bi-bank', 'info', 1, 0, 0, 3, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(4, 1, 'Wallet', 'WALLET', 'bi-wallet2', 'warning', 0, 0, 0, 4, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(5, 1, 'Credit', 'CREDIT', 'bi-person-lines-fill', 'secondary', 0, 0, 0, 5, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(6, 1, 'Cheque', 'CHEQUE', 'bi-receipt', 'dark', 1, 0, 0, 6, 1, '2026-08-02 09:51:36', '2026-08-02 09:51:36', NULL),
(7, 1, 'Cash-Flow', 'Cash-Flow', 'bi-cash', 'dark', 1, 1, 1, 1, 1, '2026-08-02 10:53:45', '2026-08-02 11:33:09', '2026-08-02 11:33:09');

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
(4, 1, 5, 'PRD000004', '100000000004', 'PEAK500', NULL, 'Peak Milk 500g', 'Peak Milk 500g', NULL, 4200.00, 4800.00, 1, 1, NULL, 1, 'Peak', 'FrieslandCampina', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-08-09 16:32:26', NULL, 20.00),
(5, 1, 2, 'PRD000005', '100000000005', 'INDM70', NULL, 'Indomie Chicken Noodles', NULL, NULL, 180.00, 250.00, 1, 1, NULL, 1, 'Indomie', 'Dufil', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(6, 1, 2, 'PRD000006', '100000000006', 'SUG1KG', NULL, 'Dangote Sugar 1kg', NULL, NULL, 1450.00, 1650.00, 1, 1, NULL, 1, 'Dangote', 'Dangote', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(7, 1, 3, 'PRD000007', '100000000007', 'BREAD001', NULL, 'Family Bread', NULL, NULL, 900.00, 1200.00, 1, 1, NULL, 1, 'Local', 'Bakery', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(8, 1, 2, 'PRD000008', '100000000008', 'RICE50KG', NULL, 'Mama Gold Rice 50kg', NULL, NULL, 82000.00, 90000.00, 1, 11, NULL, 1, 'Mama Gold', 'Mama Gold', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(9, 1, 7, 'PRD000009', '100000000009', 'SOAP001', NULL, 'Premier Soap', NULL, NULL, 500.00, 700.00, 1, 1, NULL, 1, 'Premier', 'PZ', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(10, 1, 9, 'PRD000010', '100000000010', 'PAMP001', NULL, 'Pampers Size 3', NULL, NULL, 7800.00, 8600.00, 1, 2, NULL, 1, 'Pampers', 'P&G', NULL, 1, 2, 1, 10.00, 500.00, NULL, NULL, 1, 1, '2026-07-29 10:37:13', '2026-07-29 10:37:13', NULL, 20.00),
(19, 1, 5, 'PRD000011', 'TH123456', NULL, NULL, 'Three Crown Evaporated Milk', 'Three Crown Evaporated Milk', '1786301525_6a78cc5535908.png', 1000.00, 1200.00, NULL, 5, NULL, 1, 'Three Crown', 'Three Crown Ltd', '2027-11-25', 1, NULL, 1, 100.00, 500.00, NULL, NULL, NULL, NULL, '2026-08-09 17:52:05', '2026-08-09 17:52:05', NULL, 0.00);

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
(14, 1, 'CAT000011', 'TEXT', 'TEXT', NULL, NULL, 0, 1, 1, 1, '2026-08-02 14:53:48', '2026-08-04 08:48:45', '2026-08-04 08:48:45');

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
(1, 1, 1, 1, 90.00, 0.00, 90.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-09 11:37:17'),
(2, 1, 1, 2, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(3, 1, 1, 3, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(4, 1, 1, 4, 100.00, 0.00, 100.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-07-29 10:37:13'),
(5, 1, 1, 5, 90.00, 0.00, 90.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-14 10:15:11'),
(6, 1, 1, 6, 95.00, 0.00, 95.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-14 10:15:11'),
(7, 1, 1, 7, 95.00, 0.00, 95.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-14 10:15:11'),
(8, 1, 1, 8, 95.00, 0.00, 95.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-14 10:15:11'),
(9, 1, 1, 9, 80.00, 0.00, 80.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-14 10:15:11'),
(10, 1, 1, 10, 85.00, 0.00, 85.00, 20.00, 500.00, '2026-07-29 10:37:13', '2026-08-11 09:39:39'),
(13, 1, 1, 19, 135.00, 0.00, 135.00, 100.00, 500.00, '2026-08-09 17:52:05', '2026-08-11 09:39:39'),
(20, 1, 6, 19, 5.00, 0.00, 5.00, 100.00, 500.00, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(21, 1, 6, 10, 5.00, 0.00, 5.00, 20.00, 500.00, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(22, 1, 6, 9, 10.00, 0.00, 10.00, 20.00, 500.00, '2026-08-11 09:39:39', '2026-08-11 09:39:39'),
(23, 1, 4, 9, 9.00, 0.00, 10.00, 20.00, 500.00, '2026-08-14 10:15:11', '2026-08-15 11:11:39'),
(24, 1, 4, 8, 3.00, 0.00, 5.00, 20.00, 500.00, '2026-08-14 10:15:11', '2026-08-15 11:11:39'),
(25, 1, 4, 7, 4.00, 0.00, 5.00, 20.00, 500.00, '2026-08-14 10:15:11', '2026-08-15 11:11:39'),
(26, 1, 4, 6, 4.00, 0.00, 5.00, 20.00, 500.00, '2026-08-14 10:15:11', '2026-08-15 11:11:39'),
(27, 1, 4, 5, 15.00, 0.00, 10.00, 20.00, 500.00, '2026-08-14 10:15:11', '2026-08-15 11:11:39');

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
(187, 1, 3, 1, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(188, 1, 3, 4, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(189, 1, 3, 6, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(190, 1, 3, 10, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(191, 1, 3, 14, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(192, 1, 3, 25, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(193, 1, 3, 26, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(194, 1, 3, 27, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(195, 1, 3, 28, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(196, 1, 3, 29, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(197, 1, 3, 30, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(198, 1, 3, 31, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(199, 1, 3, 32, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(200, 1, 3, 33, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(201, 1, 3, 34, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(202, 1, 3, 35, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(203, 1, 3, 36, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(204, 1, 3, 37, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(205, 1, 3, 38, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(206, 1, 3, 39, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(207, 1, 3, 40, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(208, 1, 3, 41, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(209, 1, 3, 42, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(210, 1, 3, 43, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(211, 1, 3, 44, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(212, 1, 3, 45, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(213, 1, 3, 46, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(214, 1, 3, 47, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(215, 1, 3, 48, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(216, 1, 3, 49, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(217, 1, 3, 50, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(218, 1, 3, 51, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(219, 1, 3, 52, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(220, 1, 3, 53, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(221, 1, 3, 54, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(222, 1, 3, 55, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(223, 1, 3, 56, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(224, 1, 3, 57, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(225, 1, 3, 58, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(226, 1, 3, 59, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(227, 1, 3, 60, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(228, 1, 3, 61, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(229, 1, 3, 62, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(230, 1, 3, 63, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(231, 1, 3, 64, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(232, 1, 3, 65, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(233, 1, 3, 71, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(234, 1, 3, 72, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(235, 1, 3, 73, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(236, 1, 3, 74, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(237, 1, 3, 75, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(238, 1, 3, 76, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(239, 1, 3, 79, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(240, 1, 3, 80, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(241, 1, 3, 66, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(242, 1, 3, 67, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(243, 1, 3, 68, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(244, 1, 3, 69, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
(245, 1, 3, 70, '2026-07-29 11:20:42', '2026-07-29 11:20:42'),
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
(307, 1, 7, 82, '2026-07-29 11:20:43', '2026-07-29 11:20:43');

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
('Ct4dBvoW6H24iRluYkeJdRI4Zu8TwXJxsb9YGics', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6IkFHMnc2cFM4U2JVNk5rOTFURHdDdDRJSWpUNUY4N1RzVlQwYUpDVUwiO3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo2NjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2N1c3RvbWVycy90YWJsZT9wYWdlPTEmc2VhcmNoPSZzdGF0dXM9JnR5cGU9IjtzOjU6InJvdXRlIjtzOjE1OiJjdXN0b21lcnMudGFibGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6MTk6IkVtbWFuZXggU3VwZXJtYXJrZXQiO3M6MTI6ImNvbXBhbnlfY29kZSI7czo5OiJDT01QLTAwMDEiO3M6OToiYnJhbmNoX2lkIjtpOjE7czo4OiJjdXJyZW5jeSI7czozOiJOR04iO3M6MTU6ImN1cnJlbmN5X3N5bWJvbCI7czozOiLigqYiO3M6ODoidGltZXpvbmUiO3M6MTI6IkFmcmljYS9MYWdvcyI7fQ==', 1786854450),
('hp1AqKZt9a3ltGuiUJ8epIe7oZypSiPNdk4Fy5R0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6Imt2N2E5ZDdDZHJrUEhNaWFzNGx5RlJDVEJHRjliRnI4bExKR3NBSVciO3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lcnMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo2NjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2N1c3RvbWVycy90YWJsZT9wYWdlPTEmc2VhcmNoPSZzdGF0dXM9JnR5cGU9IjtzOjU6InJvdXRlIjtzOjE1OiJjdXN0b21lcnMudGFibGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6MTk6IkVtbWFuZXggU3VwZXJtYXJrZXQiO3M6MTI6ImNvbXBhbnlfY29kZSI7czo5OiJDT01QLTAwMDEiO3M6OToiYnJhbmNoX2lkIjtpOjE7czo4OiJjdXJyZW5jeSI7czozOiJOR04iO3M6MTU6ImN1cnJlbmN5X3N5bWJvbCI7czozOiLigqYiO3M6ODoidGltZXpvbmUiO3M6MTI6IkFmcmljYS9MYWdvcyI7fQ==', 1786854707),
('HPBHk6fpDvFDM5Yw7ZlOGzhyI5SgIryctHciNGWj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiREtTY3lhNWlPcmJkZVR4RnZvUDJyVThOcnBFYmVZakVQcm5nekNscSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1786878322),
('ttcM9XVEGYaxUH8kc4pfk1GgebghOJGJ3rBtXIJe', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6IlN1d2c5dnJ2NlhBc0tlcUpzb2RyTUtLMnFKVTBQck8xTmRLN2tMYVQiO3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lcnMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo2NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2N1c3RvbWVycy9ncm91cHMvdGFibGU/cGFnZT0xJnNlYXJjaD0mc3RhdHVzPSI7czo1OiJyb3V0ZSI7czoyMjoiY3VzdG9tZXJzLmdyb3Vwcy50YWJsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxOToiRW1tYW5leCBTdXBlcm1hcmtldCI7czoxMjoiY29tcGFueV9jb2RlIjtzOjk6IkNPTVAtMDAwMSI7czo5OiJicmFuY2hfaWQiO2k6MTtzOjg6ImN1cnJlbmN5IjtzOjM6Ik5HTiI7czoxNToiY3VycmVuY3lfc3ltYm9sIjtzOjM6IuKCpiI7czo4OiJ0aW1lem9uZSI7czoxMjoiQWZyaWNhL0xhZ29zIjt9', 1786859829);

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
(1, 1, 'Emmanex Supermarket Ng', 'info@emmanexitconsult.com', '08012345678', 'Lagos, Nigeria', NULL, 'NGN', '₦', 4.50, 1, 'Thank you for shopping with us.', 'Emmanex Supermarket', 80, 1, 1, 0, 5, 0, 0, 1, 1, 0, 'Walk-in Customer', NULL, 'Africa/Lagos', 'm/d/Y', 'h:i A', 0, 1, '2026-07-29 10:37:13', '2026-08-09 15:23:25');

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
(35, 1, 4, 9, 'Adjustment', NULL, 'SC-000003', 500.00, -1.00, 10.00, 9.00, 'Stock Count adjustment - SC-000003', 1, '2026-08-15 11:11:39', '2026-08-15 11:11:39');

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
(11, 1, 4, 'Ajah-Pos1', 'Front Counter POS', 'Main Checkout', 'Dell Optilex', '192.168.0.24', 1, NULL, '2026-08-01 22:42:04', '2026-08-01 23:42:15', '2026-08-01 23:42:15');

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
(14, 1, 'UNT000014', 'Text', 'TXT', 'Text', 1, 1, 1, '2026-08-03 14:02:30', '2026-08-04 08:48:18', '2026-08-04 08:48:18');

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
(15, 1, 2, 5, 'CH-2026-001', 'Paul', 'Olusogo', 'Awolola', 'paul', 'bizcare@gmail.com', 0, NULL, 0, '07038899203', '$2y$12$oiRFD5rOZ2yz1vUPcinKKOS0rE1v7HXXTZphze3o0z7fOTNfpidp6', NULL, 'Male', '1987-11-25', '2026-07-06', 'Adelu, Ido, Ibadan.', 'Transfered from Ajah branch', 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-30 00:35:56', '2026-07-31 13:58:33', NULL),
(17, 1, 2, 3, 'MG-2026-001', 'Maxwell', 'Akinkunmi', 'Akinyooye', 'maxwell', 'maxwell@gmail.com', 0, NULL, 0, '08034271855', '$2y$12$6H0IvKIF6TgHzAAZpR5Q1uomvytbt36RZi8z63bdACmTXUKHXEDrO', NULL, 'Male', '2017-09-27', '2026-08-03', 'Ibadan', 'Branch manager of lekki branch.', 1, NULL, NULL, NULL, 1, NULL, NULL, '2026-08-09 07:43:51', '2026-08-09 07:43:51', NULL);

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
  ADD UNIQUE KEY `settings_company_id_unique` (`company_id`),
  ADD KEY `settings_default_customer_id_foreign` (`default_customer_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `settings_default_customer_id_foreign` FOREIGN KEY (`default_customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

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
