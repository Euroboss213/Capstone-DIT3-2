-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 02:21 PM
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
(17, 13, 'Baugbog', 'Warren', 'Abuhan', '', 'scholarship', '', 'For Pickup', '', '2025-04-27 19:13:43', 'indigency');

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
(4, 'Germain', 'Agapito', 'Tan', '', '2002-10-14', 'Manila', NULL, 'Male', 'namimili kung baddie', 'Filipino/Taiwanese', 'Iglesia ni Chris Brown', 'nanonood ng fliptop sa ojt', '09294456211', 'Pasayy', 'Yes', 'PWD-4344-1414', 'Yes', 'Yes', '', 'Yes', 99999999.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', 'VIN-1442-5234', 'Negative', 'Yes', '2025-04-21 07:48:14', NULL, NULL),
(6, 'Ronald', 'Bong', 'Querubin', '', '2025-04-22', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Iglesia ni Chris Brown', 'nanonood ng fliptop sa ojt', '09294456211', 'makati', 'Yes', '', 'Yes', 'Yes', '', 'Yes', 123123.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', 'VIN-1234-1235', 'Negative', 'Yes', '2025-04-22 08:40:08', NULL, NULL),
(9, 'Warren', 'Abuhan', 'Baugbog', '', '2003-09-07', 'Manila', NULL, 'Male', 'Single', 'Filipino', 'Catholic', 'Student', '9208649935', 'Blk lot 49 Phase 1A', 'No', '', 'No', 'No', '', 'No', 15000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', 'VIN-9876-5432', 'Negative', 'Yes', '2025-04-27 13:06:16', NULL, NULL);

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
(11, 'germain@gmail.com', '$2y$10$5f8yN8AeT0fZ7SvxyVL.O.KzhkqFYoK87zW6JIE.OrwYdU3TBp6ce', 'Germain', 'Agapito', 'Tan', '', 'user', 4, NULL, NULL),
(12, 'rbq@gmail.com', '$2y$10$go/gIXJci.F5iXWS2wcAl.xEXUjXDEjg45GL0xQYZasCh9ivZfhPG', 'Ronald', 'Bong', 'Querubin', '', 'user', 6, 'votersid', 'VIN-1234-1235'),
(13, 'warren@reqwest.com', '$2y$10$lxr4ncRoGM9uSgC5hzklYeyZiRG8eZOj75VsbXKL5jChSI72E6Bne', 'Warren', 'Abuhan', 'Baugbog', '', 'user', 9, 'votersid', 'VIN-9876-5432');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `indigency`
--
ALTER TABLE `indigency`
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
-- AUTO_INCREMENT for table `indigency`
--
ALTER TABLE `indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `indigency`
--
ALTER TABLE `indigency`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_residence` FOREIGN KEY (`residence_id`) REFERENCES `residences` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
