-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 01:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reqwest`
--

-- --------------------------------------------------------

--
-- Table structure for table `certresidency`
--

CREATE TABLE `certresidency` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `purpose` text NOT NULL,
  `supporting_document` varchar(255) DEFAULT NULL,
  `status` enum('Ongoing','Returned','For Pickup','Completed') NOT NULL DEFAULT 'Ongoing',
  `comment` text DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certresidency`
--

INSERT INTO `certresidency` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `address`, `purpose`, `supporting_document`, `status`, `comment`, `reply`, `date_requested`, `document_type`) VALUES
(56, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Blk lot 49 Phase 1A', 'asdfasdfasdf', 'uploads/1748253865_BAPS_-BARANGAY-APPOINTMENT-SYSTEM-FOR-LOCAL-BARANGAYS-OF-CALOOCAN-CITY.pdf', 'Completed', 'completed', NULL, '2025-05-26 18:04:25', 'Residency'),
(57, 12, 'Querubin', 'Ronald', 'Bong', '', '09294456211', 'makati', 'adfasdqwezxxcv', 'uploads/1748255042_REQWEST.pdf', 'Completed', 'Completed', NULL, '2025-05-26 18:24:02', 'Residency'),
(59, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Blk lot 49 Phase 1A', 'adfasdfa', 'uploads/1750308819_Resume.pdf', 'Ongoing', 'its time to pickup', '', '2025-06-19 12:53:39', 'Residency');

-- --------------------------------------------------------

--
-- Table structure for table `good_moral`
--

CREATE TABLE `good_moral` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `purpose` text NOT NULL,
  `supporting_document` varchar(255) DEFAULT NULL,
  `status` enum('Ongoing','Returned','For Pickup','Completed') DEFAULT 'Ongoing',
  `comment` text DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `good_moral`
--

INSERT INTO `good_moral` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `purpose`, `supporting_document`, `status`, `comment`, `reply`, `date_requested`, `document_type`) VALUES
(16, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'asdfasdqwer', '../uploads/1748253882_JPSP+-+2022+-+524.pdf', 'Completed', 'completed', NULL, '2025-05-26 18:04:42', 'Good Moral'),
(17, 12, 'Querubin', 'Ronald', 'Bong', '', 'etyvbcxb', '../uploads/1748255064_PaperIEEEBesartPrebrezeLast.pdf', 'Completed', 'Completed', NULL, '2025-05-26 18:24:24', 'Good Moral'),
(18, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'adsfasdf', '../uploads/1750311203_Resume.pdf', 'For Pickup', 'comment', 'afdasdfasfd', '2025-06-19 13:33:23', 'Good Moral');

-- --------------------------------------------------------

--
-- Table structure for table `indigency`
--

CREATE TABLE `indigency` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `purpose` text NOT NULL,
  `supporting_document` varchar(255) DEFAULT NULL,
  `status` enum('Ongoing','Returned','For Pickup','Completed') NOT NULL DEFAULT 'Ongoing',
  `comment` text DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `indigency`
--

INSERT INTO `indigency` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `purpose`, `supporting_document`, `status`, `comment`, `reply`, `date_requested`, `document_type`) VALUES
(78, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'Financial Assisstance', '../uploads/1748252329_GROUP-2_RRL.pdf', 'Completed', 'completed', NULL, '2025-05-26 17:38:49', 'Indigency'),
(79, 12, 'Querubin', 'Ronald', 'Bong', '', 'adsfasdfasdf', '../uploads/1748255032_(IJITC)-DOCU-GO-JULY-PUBLICATION.pdf', 'Completed', 'Completed', NULL, '2025-05-26 18:23:52', 'Indigency'),
(80, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'adfadfs', '', 'Returned', 'comment for history', NULL, '2025-06-10 13:14:58', 'Indigency');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `document_type` varchar(100) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `actor_role` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `sent_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `request_id`, `document_type`, `actor_id`, `actor_role`, `message`, `is_read`, `sent_to`, `created_at`) VALUES
(86, 78, 'Indigency', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Indigency.', 1, 10, '2025-05-26 09:38:49'),
(88, 56, 'Residency', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Residency.', 1, 10, '2025-05-26 10:04:25'),
(89, 16, 'Good Moral', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Good Moral.', 1, 10, '2025-05-26 10:04:42'),
(92, 79, 'Indigency', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Indigency.', 1, 10, '2025-05-26 10:23:52'),
(93, 57, 'Residency', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Residency.', 1, 10, '2025-05-26 10:24:02'),
(94, 31, 'Barangay Permit', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Barangay Permit.', 1, 10, '2025-05-26 10:24:14'),
(95, 17, 'Good Moral', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Good Moral.', 1, 10, '2025-05-26 10:24:24'),
(96, 79, 'indigency', 10, 'admin', 'Your request for Certificate of Indigency has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:19'),
(97, 31, 'permit', 10, 'admin', 'Your request for Certificate of Barangay Permit has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:29'),
(98, 57, 'certresidency', 10, 'admin', 'Your request for Certificate of Residency has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:37'),
(99, 17, 'good_moral', 10, 'admin', 'Your request for Certificate of Good Moral has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:46'),
(136, 80, 'indigency', 17, 'admin', 'Your request for Certificate of Indigency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:03:37'),
(137, 80, 'indigency', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Indigency.', 0, 17, '2025-06-19 06:03:54'),
(138, 32, 'permit', 17, 'admin', 'Your request for Certificate of Barangay Permit has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:08:55'),
(139, 32, 'permit', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Barangay Permit.', 0, 17, '2025-06-19 06:09:06'),
(140, 18, 'good_moral', 17, 'admin', 'Your request for Certificate of Good Moral has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:16:21'),
(141, 18, 'permit', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Barangay Permit.', 0, 17, '2025-06-19 06:16:33'),
(142, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:18:37'),
(143, 59, 'certresidency', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Residency.', 0, 17, '2025-06-19 06:18:47'),
(144, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-19 06:22:35'),
(145, 59, 'certresidency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Residency.', 0, 13, '2025-06-19 06:23:26'),
(146, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:27:02'),
(147, 59, 'certresidency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Residency.', 0, 13, '2025-06-19 06:28:30'),
(148, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:29:01'),
(149, 59, 'certresidency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Residency.', 0, 13, '2025-06-19 06:32:33'),
(150, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:33:05'),
(151, 59, 'certresidency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Residency.', 0, 13, '2025-06-19 06:37:48'),
(152, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:38:38'),
(153, 59, 'certresidency', 17, 'admin', 'Your request for Certificate of Residency has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-19 06:41:42'),
(154, 18, 'good_moral', 17, 'admin', 'Your request for Certificate of Good Moral has been Returned. Please read the comment.', 0, 13, '2025-06-19 06:47:38'),
(155, 18, 'good_moral', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Good Moral.', 0, 13, '2025-06-19 06:52:51'),
(156, 18, 'good_moral', 17, 'admin', 'Your request for Certificate of Good Moral has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-19 07:01:33'),
(157, 59, 'certresidency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Residency.', 0, 13, '2025-06-19 07:03:06'),
(158, 59, 'certresidency', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Residency.', 0, 17, '2025-06-19 07:04:46'),
(159, 32, 'permit', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Barangay Permit.', 0, 17, '2025-06-19 07:07:48'),
(160, 80, 'indigency', 13, 'user', 'Warren A. Baugbog (USER ID NO.(13)) have re-submitted a request for Certificate of Indigency.', 0, 17, '2025-06-19 07:09:29'),
(161, 80, 'indigency', 17, 'admin', 'Your request for Certificate of Indigency has been Returned. Please read the comment.', 0, 13, '2025-06-19 07:10:05'),
(162, 32, 'permit', 17, 'admin', 'Your request for Certificate of Barangay Permit has been Returned. Please read the comment.', 0, 13, '2025-06-19 07:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `permit`
--

CREATE TABLE `permit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `contact_number` varchar(15) NOT NULL,
  `permit_type` varchar(50) NOT NULL,
  `purpose` text NOT NULL,
  `supporting_document` varchar(255) DEFAULT NULL,
  `status` enum('Ongoing','Returned','For Pickup','Completed') NOT NULL DEFAULT 'Ongoing',
  `comment` text DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permit`
--

INSERT INTO `permit` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `permit_type`, `purpose`, `supporting_document`, `status`, `comment`, `reply`, `date_requested`, `document_type`) VALUES
(28, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Employment', 'adfadfafadfdf', NULL, 'Completed', 'jhfrftirif', NULL, '2025-05-19 19:04:00', 'Barangay Permit'),
(31, 12, 'Querubin', 'Ronald', 'Bong', '', '09294456211', 'Employment', 'bgfetsdfg', NULL, 'Completed', 'Completed', NULL, '2025-05-26 18:24:14', 'Barangay Permit'),
(32, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Employment', 'adfs', '../uploads/6853a11d42978_Resume.pdf', 'Returned', 'comment', NULL, '2025-06-19 13:33:17', 'Barangay Permit');

-- --------------------------------------------------------

--
-- Table structure for table `request_history`
--

CREATE TABLE `request_history` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `date_requested` datetime DEFAULT NULL,
  `document_type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `supporting_document` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `actor` int(5) DEFAULT NULL,
  `actor_role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_history`
--

INSERT INTO `request_history` (`id`, `request_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `purpose`, `date_requested`, `document_type`, `status`, `comment`, `reply`, `supporting_document`, `updated_at`, `actor`, `actor_role`) VALUES
(1, 80, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfadf', '2025-06-10 13:14:58', 'Indigency', 'Ongoing', 'comment for history', 'asdf', '', '2025-06-19 06:03:54', NULL, NULL),
(2, 32, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adf', '2025-06-19 13:33:17', 'Barangay Permit', 'Ongoing', 'comment', 'sdfdafff', '../uploads/6853a11d42978_Resume.pdf', '2025-06-19 06:09:06', NULL, NULL),
(3, 18, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adsfasdf', '2025-06-19 13:33:23', 'Good Moral', 'Ongoing', 'comment', 'afdasdfasfd', '../uploads/1750311203_Resume.pdf', '2025-06-19 06:16:33', NULL, NULL),
(4, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdf', '2025-06-19 12:53:39', 'Residency', 'Ongoing', 'comment again', 'sifee', 'uploads/1750308819_Resume.pdf', '2025-06-19 06:18:47', NULL, NULL),
(5, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdf', '2025-06-19 12:53:39', 'Residency', 'Ongoing', 'its time to pickup', '', 'uploads/1750308819_Resume.pdf', '2025-06-19 06:37:48', NULL, NULL),
(6, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdf', '2025-06-19 12:53:39', 'Residency', 'Returned', 'its time to pickup', '', 'uploads/1750308819_Resume.pdf', '2025-06-19 06:38:38', NULL, NULL),
(7, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdf', '2025-06-19 12:53:39', 'Residency', 'For Pickup', 'its time to pickup', 'sifee', 'uploads/1750308819_Resume.pdf', '2025-06-19 06:41:42', NULL, NULL),
(8, 18, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adsfasdf', '2025-06-19 13:33:23', 'Good Moral', 'Ongoing', 'comment', 'afdasdfasfd', '../uploads/1750311203_Resume.pdf', '2025-06-19 06:52:51', NULL, NULL),
(9, 18, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adsfasdf', '2025-06-19 13:33:23', 'Good Moral', 'For Pickup', 'comment', 'afdasdfasfd', '../uploads/1750311203_Resume.pdf', '2025-06-19 07:01:33', 17, 'admin'),
(10, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdf', '2025-06-19 12:53:39', 'Residency', 'Ongoing', 'its time to pickup', 'sifee', 'uploads/1750308819_Resume.pdf', '2025-06-19 07:03:06', 17, 'admin'),
(11, 59, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfasdfa', '2025-06-19 12:53:39', 'Residency', 'Ongoing', 'its time to pickup', '', 'uploads/1750308819_Resume.pdf', '2025-06-19 07:04:46', 13, 'user'),
(12, 32, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfs', '2025-06-19 13:33:17', 'Barangay Permit', 'Ongoing', 'comment', NULL, '../uploads/6853a11d42978_Resume.pdf', '2025-06-19 07:07:48', 13, 'user'),
(13, 80, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfadfs', '2025-06-10 13:14:58', 'Indigency', 'Ongoing', 'comment for history', NULL, '', '2025-06-19 07:09:29', 13, 'user'),
(14, 80, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfadfs', '2025-06-10 13:14:58', 'Indigency', 'Returned', 'comment for history', '', '', '2025-06-19 07:10:05', 17, 'admin'),
(15, 32, 13, 'Warren', 'Abuhan', 'Baugbog', '', 'adfs', '2025-06-19 13:33:17', 'Barangay Permit', 'Returned', 'comment', '', '../uploads/6853a11d42978_Resume.pdf', '2025-06-19 07:11:31', 17, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `residences`
--

CREATE TABLE `residences` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` enum('Male','Female','Other') DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `pwd` enum('Yes','No') DEFAULT NULL,
  `pwd_id_no` varchar(50) DEFAULT NULL,
  `indigent` enum('Yes','No') DEFAULT NULL,
  `solo_parent` enum('Yes','No') DEFAULT NULL,
  `solo_parent_id_no` varchar(50) DEFAULT NULL,
  `member_4ps` enum('Yes','No') DEFAULT NULL,
  `family_monthly_income` decimal(10,2) DEFAULT NULL,
  `voters_id_no` varchar(50) DEFAULT NULL,
  `covid_status` varchar(50) DEFAULT NULL,
  `vaccinated` enum('Yes','No') DEFAULT NULL,
  `date_of_registration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residences`
--

INSERT INTO `residences` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birth_date`, `birth_place`, `age`, `sex`, `civil_status`, `nationality`, `religion`, `occupation`, `contact_number`, `address`, `house_no`, `street_name`, `municipality`, `province`, `pwd`, `pwd_id_no`, `indigent`, `solo_parent`, `solo_parent_id_no`, `member_4ps`, `family_monthly_income`, `voters_id_no`, `covid_status`, `vaccinated`, `date_of_registration`) VALUES
(6, 'Ronald', 'Bong', 'Querubin', '', '2025-04-22', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Christian', 'nanonood ng fliptop sa ojt', '09294456211', 'makati', NULL, NULL, NULL, NULL, 'No', NULL, 'No', 'No', NULL, 'Yes', 123123.00, 'VIN-1234-1235', 'Negative', 'Yes', '2025-04-22 08:40:08'),
(9, 'Warren', 'Abuhan', 'Baugbog', '', '2003-09-07', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Catholic', 'Student', '09208649935', 'Blk lot 49 Phase 1A', NULL, NULL, NULL, NULL, 'No', '', 'No', 'No', '', 'No', 15000.00, 'VIN-9876-5432', 'Negative', 'Yes', '2025-04-27 13:06:16'),
(13, 'Germain', 'Agapito', 'Tan', '', '2007-06-06', 'Manila', NULL, 'Female', 'Single', 'Filipino', 'Roman Catholic', 'Student', '09208649935', '1234 Sample St., Barangay 1, Manila', NULL, NULL, NULL, NULL, 'No', NULL, 'No', 'No', NULL, 'No', 13444.00, 'VIN-9098-9871', 'Negative', 'No', '2025-06-06 13:45:55'),
(16, 'Lester', 'James', 'Mapa', '', '2003-03-09', 'Quezon City', 22, 'Female', 'Married', 'Filipino', 'Roman Catholic', 'Teacher', '09234567890', '848 Valdez St., Sampaloc, Manila', '848', 'Valdez St.', 'Sampaloc', 'Manila', 'Yes', 'PWD-6786-9877', 'No', 'Yes', 'SP-8979-9811', 'Yes', 150000.00, 'VIN-9098-9800', 'Positive', 'No', '2025-06-09 15:12:30'),
(20, 'John', 'Doe', 'Smith', '', '2000-11-16', 'Manila', 24, 'Female', 'Married', 'Filipino', 'Christian', 'Engineer', '09208649935', '101 Valdez St., Sampaloc, Manila', '101', 'Valdez St.', 'Sampaloc', 'Manila', 'Yes', 'PWD-6786-9875', 'No', 'Yes', 'SP-8979-9810', 'Yes', 99999999.99, 'VIN-1234-1231', 'Positive', 'No', '2025-06-09 16:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `position` varchar(20) DEFAULT NULL,
  `residence_id` int(11) DEFAULT NULL,
  `id_options` varchar(255) DEFAULT NULL,
  `id_selected` varchar(255) DEFAULT NULL,
  `acc_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `suffix`, `role`, `position`, `residence_id`, `id_options`, `id_selected`, `acc_status`) VALUES
(10, 'admin@gmail.com', '$2y$10$nYLVXnzM1yIpUVPjF1Gr3uJovJy8yItEWIp4lBiFEubeZywQrLi/m', 'Super', 'User', 'Admin', '', 'superadmin', NULL, NULL, NULL, NULL, NULL),
(12, 'rbq@gmail.com', '$2y$10$go/gIXJci.F5iXWS2wcAl.xEXUjXDEjg45GL0xQYZasCh9ivZfhPG', 'Ronald', 'Bong', 'Querubin', '', 'user', NULL, 6, 'votersid', 'VIN-1234-1235', 'active'),
(13, 'warren@gmail.com', '$2y$10$4.K4I1cIc0wAchh/0XlRbOckVx/8/.xHsVP6mq5/WmUFCLZfJDjWi', 'Warren', 'Abuhan', 'Baugbog', '', 'user', NULL, 9, 'votersid', 'VIN-9876-5432', 'active'),
(17, 'alen@gmail.com', '$2y$10$wnunbknQrgGa.xrImNPZnuRf2CKpEwveKaBE9dkcmTubimISttN2i', 'Alen Jerru', 'Cui', 'Ganotice', '', 'admin', NULL, NULL, NULL, NULL, 'active'),
(20, 'nonok@official.com', '$2y$10$36AKExRSWMG8e109PrA6JuLUDlWE3EcAitN4aYUS2tcPiLxUPqFSq', 'Kuya', 'Nonok', 'Boooy', '', 'admin', 'Chairman', NULL, NULL, NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certresidency`
--
ALTER TABLE `certresidency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_certResidency_user_id` (`user_id`);

--
-- Indexes for table `good_moral`
--
ALTER TABLE `good_moral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_goodMoral_user_id` (`user_id`);

--
-- Indexes for table `indigency`
--
ALTER TABLE `indigency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permit`
--
ALTER TABLE `permit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `request_history`
--
ALTER TABLE `request_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_history_user` (`user_id`);

--
-- Indexes for table `residences`
--
ALTER TABLE `residences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residence_id` (`residence_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certresidency`
--
ALTER TABLE `certresidency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `good_moral`
--
ALTER TABLE `good_moral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `indigency`
--
ALTER TABLE `indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `permit`
--
ALTER TABLE `permit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `request_history`
--
ALTER TABLE `request_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certresidency`
--
ALTER TABLE `certresidency`
  ADD CONSTRAINT `fk_certResidency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `good_moral`
--
ALTER TABLE `good_moral`
  ADD CONSTRAINT `fk_goodMoral_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `indigency`
--
ALTER TABLE `indigency`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `permit`
--
ALTER TABLE `permit`
  ADD CONSTRAINT `fk_permit_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `request_history`
--
ALTER TABLE `request_history`
  ADD CONSTRAINT `fk_history_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_residence` FOREIGN KEY (`residence_id`) REFERENCES `residences` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
