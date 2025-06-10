-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 12:43 PM
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
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certresidency`
--

INSERT INTO `certresidency` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `address`, `purpose`, `supporting_document`, `status`, `comment`, `date_requested`, `document_type`) VALUES
(56, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Blk lot 49 Phase 1A', 'asdfasdfasdf', 'uploads/1748253865_BAPS_-BARANGAY-APPOINTMENT-SYSTEM-FOR-LOCAL-BARANGAYS-OF-CALOOCAN-CITY.pdf', 'Completed', 'completed', '2025-05-26 18:04:25', 'Residency'),
(57, 12, 'Querubin', 'Ronald', 'Bong', '', '09294456211', 'makati', 'adfasdqwezxxcv', 'uploads/1748255042_REQWEST.pdf', 'Completed', 'Completed', '2025-05-26 18:24:02', 'Residency');

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
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `good_moral`
--

INSERT INTO `good_moral` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `purpose`, `supporting_document`, `status`, `comment`, `date_requested`, `document_type`) VALUES
(16, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'asdfasdqwer', '../uploads/1748253882_JPSP+-+2022+-+524.pdf', 'Completed', 'completed', '2025-05-26 18:04:42', 'Good Moral'),
(17, 12, 'Querubin', 'Ronald', 'Bong', '', 'etyvbcxb', '../uploads/1748255064_PaperIEEEBesartPrebrezeLast.pdf', 'Completed', 'Completed', '2025-05-26 18:24:24', 'Good Moral');

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
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `indigency`
--

INSERT INTO `indigency` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `purpose`, `supporting_document`, `status`, `comment`, `date_requested`, `document_type`) VALUES
(78, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'Financial Assisstance', '../uploads/1748252329_GROUP-2_RRL.pdf', 'Completed', 'completed', '2025-05-26 17:38:49', 'Indigency'),
(79, 12, 'Querubin', 'Ronald', 'Bong', '', 'adsfasdfasdf', '../uploads/1748255032_(IJITC)-DOCU-GO-JULY-PUBLICATION.pdf', 'Completed', 'Completed', '2025-05-26 18:23:52', 'Indigency'),
(80, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'adfadf', '', 'For Pickup', 'this is for pickup\r\n', '2025-06-10 13:14:58', 'Indigency');

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
(74, 28, 'permit', 10, 'admin', 'Admin updated your request for Certificate of Barangay Permit. Please check the status and comments.', 1, 13, '2025-05-19 11:16:07'),
(86, 78, 'Indigency', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Indigency.', 1, 10, '2025-05-26 09:38:49'),
(87, 78, 'indigency', 10, 'admin', 'Your request for Certificate of Indigency has been Completed. Thank you for using REQWEST.', 1, 13, '2025-05-26 09:40:54'),
(88, 56, 'Residency', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Residency.', 1, 10, '2025-05-26 10:04:25'),
(89, 16, 'Good Moral', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Good Moral.', 1, 10, '2025-05-26 10:04:42'),
(90, 16, 'good_moral', 10, 'admin', 'Your request for Certificate of Good Moral has been Completed. Thank you for using REQWEST.', 1, 13, '2025-05-26 10:05:42'),
(91, 56, 'certresidency', 10, 'admin', 'Your request for Certificate of Residency has been Completed. Thank you for using REQWEST.', 1, 13, '2025-05-26 10:05:57'),
(92, 79, 'Indigency', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Indigency.', 1, 10, '2025-05-26 10:23:52'),
(93, 57, 'Residency', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Residency.', 1, 10, '2025-05-26 10:24:02'),
(94, 31, 'Barangay Permit', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Barangay Permit.', 1, 10, '2025-05-26 10:24:14'),
(95, 17, 'Good Moral', 12, 'user', 'Ronald Querubin (USER ID NO.(12)) have submitted a request for Certificate of Good Moral.', 1, 10, '2025-05-26 10:24:24'),
(96, 79, 'indigency', 10, 'admin', 'Your request for Certificate of Indigency has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:19'),
(97, 31, 'permit', 10, 'admin', 'Your request for Certificate of Barangay Permit has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:29'),
(98, 57, 'certresidency', 10, 'admin', 'Your request for Certificate of Residency has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:37'),
(99, 17, 'good_moral', 10, 'admin', 'Your request for Certificate of Good Moral has been Completed. Thank you for using REQWEST.', 1, 12, '2025-05-26 10:26:46'),
(100, 80, 'Indigency', 13, 'user', 'Warren Baugbog (USER ID NO.(13)) have submitted a request for Certificate of Indigency.', 1, 17, '2025-06-10 05:14:58'),
(101, 80, 'indigency', 17, 'admin', 'Your request for Certificate of Indigency has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-10 06:51:28'),
(102, 80, 'indigency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Indigency.', 0, 13, '2025-06-10 06:52:34'),
(103, 80, 'indigency', 17, 'admin', 'Your request for Certificate of Indigency has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-10 06:52:40'),
(104, 80, 'indigency', 17, 'admin', 'Alen Jerru C. Ganotice submitted a request for Certificate of Indigency.', 0, 13, '2025-06-10 06:55:03'),
(105, 80, 'indigency', 10, 'admin', 'Your request for Certificate of Indigency has been Approved. Please read the comment before picking up.', 0, 13, '2025-06-10 10:35:29');

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
  `date_requested` datetime DEFAULT current_timestamp(),
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permit`
--

INSERT INTO `permit` (`id`, `user_id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `permit_type`, `purpose`, `supporting_document`, `status`, `comment`, `date_requested`, `document_type`) VALUES
(28, 13, 'Baugbog', 'Warren', 'Abuhan', '', '09208649935', 'Employment', 'adfadfafadfdf', NULL, 'Completed', 'jhfrftirif', '2025-05-19 19:04:00', 'Barangay Permit'),
(31, 12, 'Querubin', 'Ronald', 'Bong', '', '09294456211', 'Employment', 'bgfetsdfg', NULL, 'Completed', 'Completed', '2025-05-26 18:24:14', 'Barangay Permit');

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
  `residence_id` int(11) DEFAULT NULL,
  `id_options` varchar(255) DEFAULT NULL,
  `id_selected` varchar(255) DEFAULT NULL,
  `acc_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `suffix`, `role`, `residence_id`, `id_options`, `id_selected`, `acc_status`) VALUES
(10, 'admin@gmail.com', '$2y$10$nYLVXnzM1yIpUVPjF1Gr3uJovJy8yItEWIp4lBiFEubeZywQrLi/m', 'Super', 'User', 'Admin', '', 'superadmin', NULL, NULL, NULL, NULL),
(12, 'rbq@gmail.com', '$2y$10$go/gIXJci.F5iXWS2wcAl.xEXUjXDEjg45GL0xQYZasCh9ivZfhPG', 'Ronald', 'Bong', 'Querubin', '', 'user', 6, 'votersid', 'VIN-1234-1235', 'active'),
(13, 'warren@gmail.com', '$2y$10$4.K4I1cIc0wAchh/0XlRbOckVx/8/.xHsVP6mq5/WmUFCLZfJDjWi', 'Warren', 'Abuhan', 'Baugbog', '', 'user', 9, 'votersid', 'VIN-9876-5432', 'active'),
(17, 'alen@gmail.com', '$2y$10$wnunbknQrgGa.xrImNPZnuRf2CKpEwveKaBE9dkcmTubimISttN2i', 'Alen Jerru', 'Cui', 'Ganotice', '', 'admin', NULL, NULL, NULL, 'active'),
(18, 'nonok@official.com', '$2y$10$gqHgmyPwNpSj54A230YOB.dSeZql3zRto7ydQYVQUrT6x6EvGDbFm', 'Kagawad', 'Nonok', 'Boooy', '', 'admin', NULL, NULL, NULL, 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `good_moral`
--
ALTER TABLE `good_moral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `indigency`
--
ALTER TABLE `indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `permit`
--
ALTER TABLE `permit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_residence` FOREIGN KEY (`residence_id`) REFERENCES `residences` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
