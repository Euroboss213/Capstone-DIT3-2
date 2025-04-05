-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 01:45 PM
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
-- Database: `admin`
--

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
(1, 'John', 'Doe', 'Smith', 'Jr.', '1990-05-15', 'Manila', 35, 'Male', 'Single', 'Filipino', 'Christian', 'Engineer', '09171234567', '1234 Sample St., Barangay 1, Manila', 'Yes', 'PWD12345', 'No', 'No', 'SPID1234', 'Yes', 25000.00, 'Yes', '1', '101', 'Sample St.', 'Jane Doe', 'Mother', '09182345678', '5678 Emergency Ave, Manila', '123456789012', 'PH123456', 'SSS123456', 'PAGIBIG123', 'TIN123456789', 'VOTER12345', 'Negative', 'Yes', '2025-04-05 17:27:17', NULL, 'Alive'),
(2, 'Maria', 'Delos Santos', 'Reyes', '', '1985-08-20', 'Cebu', 40, 'Female', 'Married', 'Filipino', 'Christian', 'Teacher', '09234567890', '2345 Sample St., Barangay 2, Cebu', 'No', NULL, 'Yes', 'No', NULL, 'Yes', 30000.00, 'Yes', '2', '202', 'Main St.', 'Carlos Reyes', 'Husband', '09213456789', '6789 Emergency Rd., Cebu', '234567890123', 'PH234567', 'SSS234567', 'PAGIBIG234', 'TIN234567890', 'VOTER23456', 'Negative', 'Yes', '2025-04-05 17:27:17', NULL, 'Alive'),
(3, 'Luis', 'Fernandez', 'Gutierrez', 'III', '2000-12-01', 'Davao', 24, 'Male', 'Single', 'Filipino', 'Muslim', 'Student', '09335678901', '4567 Example St., Barangay 3, Davao', 'No', NULL, 'No', 'No', NULL, 'No', 15000.00, 'No', '3', '303', 'Main Road', 'Maria Gutierrez', 'Mother', '09312345678', '1234 Emergency Ave, Davao', '345678901234', 'PH345678', 'SSS345678', 'PAGIBIG345', 'TIN345678901', 'VOTER34567', 'Negative', 'Yes', '2025-04-05 17:27:17', NULL, 'Alive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `residences`
--
ALTER TABLE `residences`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
