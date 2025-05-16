-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 12:37 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `actor_role` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `sent_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `pwd` enum('Yes','No') DEFAULT NULL,
  `pwd_id_no` varchar(50) DEFAULT NULL,
  `indigent` enum('Yes','No') DEFAULT NULL,
  `solo_parent` enum('Yes','No') DEFAULT NULL,
  `solo_parent_id_no` varchar(50) DEFAULT NULL,
  `member_4ps` enum('Yes','No') DEFAULT NULL,
  `family_monthly_income` decimal(10,2) DEFAULT NULL,
  `registered_voter` enum('Yes','No') DEFAULT NULL,
  `purok_no` varchar(20) DEFAULT NULL,
  `house_no` varchar(20) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `emergency_full_name` varchar(100) DEFAULT NULL,
  `emergency_relationship` varchar(50) DEFAULT NULL,
  `emergency_contact_no` varchar(20) DEFAULT NULL,
  `emergency_address` text DEFAULT NULL,
  `national_id_no` varchar(50) DEFAULT NULL,
  `philhealth_no` varchar(50) DEFAULT NULL,
  `sss_no` varchar(50) DEFAULT NULL,
  `pagibig_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `voters_id_no` varchar(50) DEFAULT NULL,
  `covid_status` varchar(50) DEFAULT NULL,
  `vaccinated` enum('Yes','No') DEFAULT NULL,
  `date_of_registration` datetime DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `alive_or_deceased` enum('Alive','Deceased') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residences`
--

INSERT INTO `residences` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birth_date`, `birth_place`, `age`, `sex`, `civil_status`, `nationality`, `religion`, `occupation`, `contact_number`, `address`, `pwd`, `pwd_id_no`, `indigent`, `solo_parent`, `solo_parent_id_no`, `member_4ps`, `family_monthly_income`, `registered_voter`, `purok_no`, `house_no`, `street`, `emergency_full_name`, `emergency_relationship`, `emergency_contact_no`, `emergency_address`, `national_id_no`, `philhealth_no`, `sss_no`, `pagibig_no`, `tin_no`, `voters_id_no`, `covid_status`, `vaccinated`, `date_of_registration`, `date_of_death`, `alive_or_deceased`) VALUES
(6, 'Ronald', 'Bong', 'Querubin', '', '2025-04-22', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Iglesia ni Chris Brown', 'nanonood ng fliptop sa ojt', '09294456211', 'makati', 'Yes', '', 'Yes', 'Yes', '', 'Yes', 123123.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', 'VIN-1234-1235', 'Negative', 'Yes', '2025-04-22 08:40:08', NULL, NULL),
(9, 'Warren', 'Abuhan', 'Baugbog', '', '2003-09-07', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Catholic', 'Student', '09208649935', 'Blk lot 49 Phase 1A', 'No', '', 'No', 'No', '', 'No', 15000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', 'VIN-9876-5432', 'Negative', 'Yes', '2025-04-27 13:06:16', NULL, NULL);

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
  `id_selected` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `suffix`, `role`, `residence_id`, `id_options`, `id_selected`) VALUES
(10, 'admin@example.com', '$2y$10$q2ueKAtPQqOPOJfkhyFSvuoRBrZZ8GGuixmixghQYMDojjuPLtab2', 'Super', 'User', 'Admin', '', 'admin', NULL, NULL, NULL),
(12, 'rbq@gmail.com', '$2y$10$go/gIXJci.F5iXWS2wcAl.xEXUjXDEjg45GL0xQYZasCh9ivZfhPG', 'Ronald', 'Bong', 'Querubin', '', 'user', 6, 'votersid', 'VIN-1234-1235'),
(13, 'warren@reqwest.com', '$2y$10$UbYbv3vbjqiPgkufrcRSw.vFrR9lTgWWDHqecDVIzIPn/ay2MRwPK', 'Warren', 'Abuhan', 'Baugbog', '', 'user', 9, 'votersid', 'VIN-9876-5432');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `good_moral`
--
ALTER TABLE `good_moral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `indigency`
--
ALTER TABLE `indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `permit`
--
ALTER TABLE `permit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `indigency` (`id`) ON DELETE CASCADE;

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
