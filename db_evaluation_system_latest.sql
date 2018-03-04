-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2018 at 01:51 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_evaluation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal`
--

CREATE TABLE `tbl_appraisal` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraisal` int(11) UNSIGNED NOT NULL,
  `id_property` int(11) UNSIGNED NOT NULL,
  `id_appraiser` int(11) UNSIGNED NOT NULL,
  `appraisal_status` tinyint(1) NOT NULL COMMENT '0=Available for Appraisal\n1=Requested for Appraisal\n2=Appraisal Completed\n3=Re-appraise\n4=Publish\n5=Sold',
  `remarks` varchar(255) DEFAULT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appraisal`
--

INSERT INTO `tbl_appraisal` (`create_date`, `update_date`, `id_appraisal`, `id_property`, `id_appraiser`, `appraisal_status`, `remarks`, `ind_deleted`) VALUES
('2018-02-28 14:46:29', '2018-02-28 07:11:53', 3, 3, 5, 2, 'Pa appraise po', 0),
('2018-02-28 16:59:57', '2018-03-01 06:40:17', 4, 4, 5, 2, '', 0),
('2018-03-02 12:25:39', '2018-03-02 04:28:53', 5, 5, 5, 2, 'Please appraise', 0),
('2018-03-04 10:04:42', '0000-00-00 00:00:00', 6, 8, 5, 1, '', 1),
('2018-03-04 13:25:58', '0000-00-00 00:00:00', 7, 8, 5, 1, '', 0),
('2018-03-04 13:34:54', '2018-03-04 05:45:51', 8, 9, 5, 2, 'Pa appraise po', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_details`
--

CREATE TABLE `tbl_appraisal_details` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraisal_details` int(11) UNSIGNED NOT NULL,
  `id_appraisal` int(11) UNSIGNED NOT NULL,
  `id_comparable_property` int(11) UNSIGNED NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appraisal_details`
--

INSERT INTO `tbl_appraisal_details` (`create_date`, `update_date`, `delete_date`, `id_appraisal_details`, `id_appraisal`, `id_comparable_property`, `ind_deleted`) VALUES
('2018-02-28 15:11:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 97, 3, 97, NULL),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 98, 3, 98, NULL),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 99, 3, 99, NULL),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 101, 4, 101, NULL),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 102, 4, 102, NULL),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 103, 4, 103, NULL),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 104, 5, 104, NULL),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 105, 5, 105, NULL),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 106, 5, 106, NULL),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 107, 8, 107, NULL),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 108, 8, 108, NULL),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 109, 8, 109, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_property_picture`
--

CREATE TABLE `tbl_appraisal_property_picture` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_property_picture` int(11) UNSIGNED NOT NULL,
  `id_property` int(11) UNSIGNED NOT NULL,
  `picture_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appraisal_property_picture`
--

INSERT INTO `tbl_appraisal_property_picture` (`create_date`, `update_date`, `id_property_picture`, `id_property`, `picture_path`) VALUES
('2018-03-02 17:33:31', NULL, 4, 4, 'assets/image/appraise/20180302053331.jpg'),
('2018-03-02 17:33:38', NULL, 5, 4, 'assets/image/appraise/20180302053338.jpg'),
('2018-03-02 17:33:49', NULL, 6, 4, 'assets/image/appraise/20180302053349.jpg'),
('2018-03-04 10:04:32', NULL, 7, 8, 'assets/image/appraise/20180304100432.jpg'),
('2018-03-04 13:50:05', NULL, 8, 9, 'assets/image/appraise/20180304015005.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraiser`
--

CREATE TABLE `tbl_appraiser` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraiser` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `contact_num` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_signedin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ind_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appraiser`
--

INSERT INTO `tbl_appraiser` (`create_date`, `update_date`, `id_appraiser`, `id_user`, `first_name`, `middle_name`, `last_name`, `contact_num`, `address`, `profile_image`, `last_signedin`, `ind_deleted`) VALUES
('2018-02-13 05:10:55', '0000-00-00 00:00:00', 4, 5, 'John', '', 'Doe', NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
('2018-02-27 14:28:33', '0000-00-00 00:00:00', 5, 6, 'Paul', '', 'Cruz', NULL, NULL, 'assets/image/avatar/20180227022833.jpg', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraise_property`
--

CREATE TABLE `tbl_appraise_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_appraise_property` int(11) UNSIGNED NOT NULL,
  `id_appraisal` int(11) NOT NULL,
  `inspection_date` date DEFAULT NULL,
  `appraisal_date` date DEFAULT NULL,
  `id_house_model` int(11) DEFAULT NULL,
  `registry_of_deeds` varchar(255) DEFAULT NULL,
  `number_of_storeys` int(11) DEFAULT NULL,
  `effective_age` int(11) DEFAULT NULL,
  `total_ecolife` int(11) DEFAULT NULL,
  `remaining_ecolife` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `house_value` double NOT NULL,
  `ave_lot_value` double DEFAULT NULL,
  `total_lot_value` double DEFAULT NULL,
  `total_house_value` double DEFAULT NULL,
  `total_property_value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appraise_property`
--

INSERT INTO `tbl_appraise_property` (`create_date`, `update_date`, `id_appraise_property`, `id_appraisal`, `inspection_date`, `appraisal_date`, `id_house_model`, `registry_of_deeds`, `number_of_storeys`, `effective_age`, `total_ecolife`, `remaining_ecolife`, `remarks`, `house_value`, `ave_lot_value`, `total_lot_value`, `total_house_value`, `total_property_value`) VALUES
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 8, 3, '2018-02-28', '2018-02-28', 3, '1', 2, 5, 20, 15, '', 0, 40000, 2000000, 37500, 2037500),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 9, 4, '2018-03-01', '2018-03-01', 3, '1', 2, 5, 20, 15, '', 0, 60000, 6000000, 37500, 6037500),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 10, 5, '2018-03-01', '2018-03-02', 2, 'Markina', 2, 5, 30, 25, '', 50000, 9166.67, 458333.5, 41666.67, 500000.17),
('2018-03-04 13:45:51', NULL, 11, 8, '2018-03-04', '2018-03-04', 3, 'San Juan', 1, 5, 20, 15, '', 50000, 30000, 1200000, 37500, 1237500);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barangay`
--

CREATE TABLE `tbl_barangay` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_barangay` int(11) UNSIGNED NOT NULL,
  `barangay_code` varchar(45) NOT NULL,
  `barangay_description` varchar(255) NOT NULL,
  `id_city` int(11) UNSIGNED NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_barangay`
--

INSERT INTO `tbl_barangay` (`create_date`, `update_date`, `delete_date`, `id_barangay`, `barangay_code`, `barangay_description`, `id_city`, `ind_deleted`) VALUES
('2018-02-10 15:02:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'MRKN HGHTS', 'Marikina Heights', 1, 0),
('2018-02-10 15:03:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'CPCN 1', 'Concepcion Uno', 1, 0),
('2018-02-10 15:09:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'CPCN 2', 'Concepcion Dos', 1, 0),
('2018-02-28 14:40:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'PC', 'Pedro Cruz', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_city` int(11) UNSIGNED NOT NULL,
  `city_code` varchar(45) NOT NULL,
  `city_description` varchar(255) NOT NULL,
  `id_province` int(11) UNSIGNED NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`create_date`, `update_date`, `delete_date`, `id_city`, `city_code`, `city_description`, `id_province`, `ind_deleted`) VALUES
('2018-02-10 14:36:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'MRKN', 'Marikina', 1, 0),
('2018-02-10 15:05:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'MND', 'Mandaluyong', 1, 0),
('2018-02-10 15:05:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'PSG', 'Pasig', 1, 0),
('2018-02-28 14:40:18', '2018-02-28 06:40:25', '0000-00-00 00:00:00', 4, 'SJ', 'San Juan', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comparable_property`
--

CREATE TABLE `tbl_comparable_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_comparable_property` int(11) UNSIGNED NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `id_property_location` int(11) NOT NULL,
  `property_type` tinyint(1) NOT NULL,
  `lot_value` double NOT NULL,
  `id_appraiser` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_comparable_property`
--

INSERT INTO `tbl_comparable_property` (`create_date`, `update_date`, `id_comparable_property`, `property_name`, `id_property_location`, `property_type`, `lot_value`, `id_appraiser`) VALUES
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 97, 'Polinar', 130, 1, 40000, 0),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 98, 'Alaysa', 131, 1, 10000, 0),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 99, 'Dela Cruz', 132, 1, 70000, 0),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 101, 'Gestiada', 135, 1, 10000, 0),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 102, 'Cruz', 136, 1, 80000, 0),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 103, 'Villareal', 137, 1, 90000, 0),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 104, 'Dansalan', 139, 1, 9000, 0),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 105, 'Dansalan2', 140, 1, 8500, 0),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 106, 'Dansalan 3', 141, 1, 10000, 0),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 107, 'Prop 1', 146, 1, 20000, 0),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 108, 'Prop 2', 147, 1, 30000, 0),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 109, 'Prop 3', 148, 1, 40000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_house_model`
--

CREATE TABLE `tbl_house_model` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_house_model` int(10) UNSIGNED NOT NULL,
  `house_model` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_house_model`
--

INSERT INTO `tbl_house_model` (`create_date`, `update_date`, `delete_date`, `id_house_model`, `house_model`, `description`, `ind_deleted`) VALUES
('2018-02-13 12:29:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'Cottage', 'Cottage', 0),
('2018-02-13 12:31:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'Bungalow', 'Bungalow', 0),
('2018-02-13 12:32:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'Mansion', 'Mansion', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property`
--

CREATE TABLE `tbl_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_property` int(11) UNSIGNED NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `id_seller` int(11) UNSIGNED NOT NULL,
  `id_property_location` int(11) UNSIGNED NOT NULL,
  `property_type` tinyint(1) NOT NULL COMMENT '0=Lot\n1=House and Lot',
  `property_status` tinyint(1) NOT NULL COMMENT '0=Available for Appraisal\n1=Requested for Appraisal\n2=Appraisal Completed\n3=Re-appraise\n4=Publish\n5=Sold',
  `tct_number` varchar(255) NOT NULL,
  `lot_area` double NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_property`
--

INSERT INTO `tbl_property` (`create_date`, `update_date`, `delete_date`, `id_property`, `property_name`, `id_seller`, `id_property_location`, `property_type`, `property_status`, `tct_number`, `lot_area`, `ind_deleted`) VALUES
('2018-02-28 14:41:36', '2018-02-28 07:11:53', '0000-00-00 00:00:00', 3, 'Cruz Property', 1, 117, 1, 4, '1', 50, 0),
('2018-02-28 16:59:47', '2018-03-01 06:40:17', '0000-00-00 00:00:00', 4, 'Navarro', 1, 133, 1, 4, '2', 100, 0),
('2018-03-02 12:25:20', '2018-03-02 04:28:53', '0000-00-00 00:00:00', 5, 'DMCI', 1, 138, 1, 4, '1234ABC', 50, 0),
('2018-03-03 01:16:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Paul Property', 2, 142, 1, 0, '123456789', 100, 0),
('2018-03-03 01:16:33', '0000-00-00 00:00:00', '2018-03-02 18:49:02', 7, 'Paul Property', 2, 143, 1, 0, '123456789', 100, 1),
('2018-03-04 10:04:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'sample property', 3, 144, 0, 1, '1', 50, 0),
('2018-03-04 13:34:38', '2018-03-04 05:45:51', '0000-00-00 00:00:00', 9, 'Sample again', 3, 145, 1, 4, '1', 40.25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property_location`
--

CREATE TABLE `tbl_property_location` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_property_location` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `id_barangay` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_property_location`
--

INSERT INTO `tbl_property_location` (`create_date`, `update_date`, `id_property_location`, `address`, `id_barangay`) VALUES
('2018-02-28 14:41:36', '0000-00-00 00:00:00', 117, '521 D. Santiago St., San Juan City Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 130, 'Polinar Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 131, 'Alaysa Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-02-28 15:11:53', '0000-00-00 00:00:00', 132, 'Dela Cruz Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-02-28 16:59:47', '0000-00-00 00:00:00', 133, 'San Juan Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 135, 'Gestiada Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 136, 'Cruz Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-01 14:40:17', '0000-00-00 00:00:00', 137, 'Villareal Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-02 12:25:20', '0000-00-00 00:00:00', 138, '24J Sycamore Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 139, '123J Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 140, '1E Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-02 12:28:53', '0000-00-00 00:00:00', 141, '34I Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-03 01:16:09', '0000-00-00 00:00:00', 142, '17 Street Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-03 01:16:33', '0000-00-00 00:00:00', 143, '17 Street Marikina Heights Marikina Metro Manila National Capital Region', 1),
('2018-03-04 10:04:22', '0000-00-00 00:00:00', 144, 'sample Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-04 13:34:38', '0000-00-00 00:00:00', 145, '521 D. Santiago St Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 146, 'Prop 1 Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 147, 'Prop 2 Pedro Cruz San Juan Metro Manila National Capital Region', 4),
('2018-03-04 13:45:51', '0000-00-00 00:00:00', 148, 'Prop 3 Pedro Cruz San Juan Metro Manila National Capital Region', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_province`
--

CREATE TABLE `tbl_province` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_province` int(11) UNSIGNED NOT NULL,
  `province_code` varchar(45) NOT NULL,
  `province_description` varchar(255) NOT NULL,
  `id_region` int(11) UNSIGNED NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_province`
--

INSERT INTO `tbl_province` (`create_date`, `update_date`, `delete_date`, `id_province`, `province_code`, `province_description`, `id_region`, `ind_deleted`) VALUES
('2018-02-10 14:35:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'MM', 'Metro Manila', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region`
--

CREATE TABLE `tbl_region` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_region` int(11) UNSIGNED NOT NULL,
  `region_code` varchar(45) NOT NULL,
  `region_description` varchar(255) NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_region`
--

INSERT INTO `tbl_region` (`create_date`, `update_date`, `delete_date`, `id_region`, `region_code`, `region_description`, `ind_deleted`) VALUES
('2018-02-10 13:15:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'NCR', 'National Capital Region', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seller`
--

CREATE TABLE `tbl_seller` (
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_seller` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_signedin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ind_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ind_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_seller`
--

INSERT INTO `tbl_seller` (`create_date`, `update_date`, `delete_date`, `id_seller`, `id_user`, `first_name`, `middle_name`, `last_name`, `contact_number`, `address`, `profile_image`, `last_signedin`, `ind_deleted`, `ind_active`) VALUES
('2018-02-08 16:56:49', '2018-02-27 18:30:17', '0000-00-00 00:00:00', 1, 4, 'juan', '', 'dela  cruz', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 1),
('2018-03-03 01:13:33', '2018-03-02 17:14:58', '0000-00-00 00:00:00', 2, 9, 'John Paul', '', 'Escala', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 1),
('2018-03-03 02:50:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 10, 'Lhen', '', 'Balderas', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 1),
('2018-03-04 12:31:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13, 20, 'Patricia', '', 'Cruz', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sell_property`
--

CREATE TABLE `tbl_sell_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_sell_property` int(11) NOT NULL,
  `id_appraisal` int(11) NOT NULL,
  `price` double NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sell_property`
--

INSERT INTO `tbl_sell_property` (`create_date`, `update_date`, `id_sell_property`, `id_appraisal`, `price`, `remarks`, `counter`) VALUES
('2018-02-28 15:47:29', NULL, 1, 3, 2038000, 'PASOK MGA SUKI PRESYONG DIVISORIA', 1),
('2018-03-02 12:34:44', NULL, 2, 5, 600000, 'Please contact me', 0),
('2018-03-02 17:34:28', NULL, 3, 4, 6038000, 'BILI NA!', 0),
('2018-03-04 13:50:25', NULL, 4, 8, 1238000, 'BILI NA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_user` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '0-admin\n1-appraiser\n2-seller',
  `ind_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`create_date`, `update_date`, `id_user`, `email`, `password`, `remember_token`, `user_type`, `ind_deleted`) VALUES
('2018-02-13 05:10:55', '0000-00-00 00:00:00', 0, 'admin@gmail.com', '$2y$10$ca2eanzRzw4NJZBmETJ72u.1TqX1BtWmUPXbW9Wh8Z0vhQnokNG7W', 'rhNNhsqewpBmGPpY3jd7BQYFtKZ1Iyt62VJ0Bw16xTBJvqFoFda9c34ErNRV', 0, 0),
('2018-02-08 16:56:49', '0000-00-00 00:00:00', 4, 'jd@gmail.com', '$2y$10$JmjppASARHTZOj4pOfSGHuwNASzCRSdC/e4idjiSECUqtYlCDM1i2', 'BBvCIedAwzU8O3VqEJOxI6dhssYa9K0NgBbbd9rstAN8CItrSAYDsesi7i5m', 2, 0),
('2018-02-13 05:10:55', '0000-00-00 00:00:00', 5, 'jdoe@gmail.com', '$2y$10$ca2eanzRzw4NJZBmETJ72u.1TqX1BtWmUPXbW9Wh8Z0vhQnokNG7W', 'PxE3QQnRHL0dUdpGh3GEkFjmaBIrzvG14g48jrzatZd9lJAgVvgvnGzMCrJm', 1, 0),
('2018-02-27 14:28:33', '0000-00-00 00:00:00', 6, 'p@c.com', '$2y$10$G0v5ekL356lFbTW1QgPE8uIzd7FaNv0AjH2nkYG8v1dkJLVdzPpZ.', 'NtKDNYXYchDCOdhtW61WyGBLzJl5KqtHG4qafPFd0t2364Nvz1yBndWjr2fn', 1, 0),
('2018-02-28 13:09:21', '2018-02-27 16:00:00', 7, 'pacruz@yahoo.com', '$2y$10$G0v5ekL356lFbTW1QgPE8uIzd7FaNv0AjH2nkYG8v1dkJLVdzPpZ.', 'r9ZzBPBvY95HnkXbqwDfa8en7nEZJU9InKScHSammtNkpxjigDJ1JXJjNz8Y', 0, 0),
('2018-03-03 01:13:33', '0000-00-00 00:00:00', 9, 'jpescala@gmail.com', '$2y$10$NHLfelPc68PwuCcZI0pjce9f8duIhzxqP2lErXH8GZ8rGfQZy.17.', 'nf5uvNjnnuQnPrwQthL86B0NvVIEMFheVRzEia7W6fm6vmC1G2bYg0jr3M6c', 2, 0),
('2018-03-03 02:50:11', '0000-00-00 00:00:00', 10, 'lhen@gmail.com', '$2y$10$s2MusZnFM0TNQQX6MsxUNuBFNzE4jfMWYJLDir8NttELeBdMMQ3LG', NULL, 2, 0),
('2018-03-04 12:31:22', '0000-00-00 00:00:00', 20, 'patricia@yahoo.com', '$2y$10$Y5BGpQgDxUIPRwxXccEBBO.h8VKgJxZR2BzDU7tR6UkVex7uppb9S', 'BsEO2QaSK8twoUoVHZiEKeuhrhRhQKiTYRU6AqFdQzlYl6rjAA9Vm1XHtx9U', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tbl_appraisal`
--
ALTER TABLE `tbl_appraisal`
  ADD PRIMARY KEY (`id_appraisal`);

--
-- Indexes for table `tbl_appraisal_details`
--
ALTER TABLE `tbl_appraisal_details`
  ADD PRIMARY KEY (`id_appraisal_details`);

--
-- Indexes for table `tbl_appraisal_property_picture`
--
ALTER TABLE `tbl_appraisal_property_picture`
  ADD PRIMARY KEY (`id_property_picture`);

--
-- Indexes for table `tbl_appraiser`
--
ALTER TABLE `tbl_appraiser`
  ADD PRIMARY KEY (`id_appraiser`);

--
-- Indexes for table `tbl_appraise_property`
--
ALTER TABLE `tbl_appraise_property`
  ADD PRIMARY KEY (`id_appraise_property`);

--
-- Indexes for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  ADD PRIMARY KEY (`id_barangay`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id_city`);

--
-- Indexes for table `tbl_comparable_property`
--
ALTER TABLE `tbl_comparable_property`
  ADD PRIMARY KEY (`id_comparable_property`);

--
-- Indexes for table `tbl_house_model`
--
ALTER TABLE `tbl_house_model`
  ADD PRIMARY KEY (`id_house_model`);

--
-- Indexes for table `tbl_property`
--
ALTER TABLE `tbl_property`
  ADD PRIMARY KEY (`id_property`);

--
-- Indexes for table `tbl_property_location`
--
ALTER TABLE `tbl_property_location`
  ADD PRIMARY KEY (`id_property_location`);

--
-- Indexes for table `tbl_province`
--
ALTER TABLE `tbl_province`
  ADD PRIMARY KEY (`id_province`);

--
-- Indexes for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD PRIMARY KEY (`id_region`);

--
-- Indexes for table `tbl_seller`
--
ALTER TABLE `tbl_seller`
  ADD PRIMARY KEY (`id_seller`);

--
-- Indexes for table `tbl_sell_property`
--
ALTER TABLE `tbl_sell_property`
  ADD PRIMARY KEY (`id_sell_property`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_appraisal`
--
ALTER TABLE `tbl_appraisal`
  MODIFY `id_appraisal` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_appraisal_details`
--
ALTER TABLE `tbl_appraisal_details`
  MODIFY `id_appraisal_details` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `tbl_appraisal_property_picture`
--
ALTER TABLE `tbl_appraisal_property_picture`
  MODIFY `id_property_picture` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_appraiser`
--
ALTER TABLE `tbl_appraiser`
  MODIFY `id_appraiser` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_appraise_property`
--
ALTER TABLE `tbl_appraise_property`
  MODIFY `id_appraise_property` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  MODIFY `id_barangay` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id_city` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_comparable_property`
--
ALTER TABLE `tbl_comparable_property`
  MODIFY `id_comparable_property` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `tbl_house_model`
--
ALTER TABLE `tbl_house_model`
  MODIFY `id_house_model` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_property`
--
ALTER TABLE `tbl_property`
  MODIFY `id_property` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_property_location`
--
ALTER TABLE `tbl_property_location`
  MODIFY `id_property_location` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT for table `tbl_province`
--
ALTER TABLE `tbl_province`
  MODIFY `id_province` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_region`
--
ALTER TABLE `tbl_region`
  MODIFY `id_region` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_seller`
--
ALTER TABLE `tbl_seller`
  MODIFY `id_seller` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tbl_sell_property`
--
ALTER TABLE `tbl_sell_property`
  MODIFY `id_sell_property` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
