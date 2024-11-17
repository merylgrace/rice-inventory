-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 04:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rice_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylogs`
--

CREATE TABLE `activitylogs` (
  `LogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ActivityType` varchar(50) DEFAULT NULL,
  `ActivityDescription` text DEFAULT NULL,
  `ActivityTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activitylogs`
--

INSERT INTO `activitylogs` (`LogID`, `UserID`, `ActivityType`, `ActivityDescription`, `ActivityTime`) VALUES
(1, 3, 'Add Rice', 'Added Valencia with quantity 12 and price 1150.', '2024-11-16 08:17:37'),
(2, 3, 'Add Rice', 'Added Broken with quantity 10 and price 1050.', '2024-11-16 08:20:16'),
(3, 3, 'Add Rice', 'Added Sticky with quantity 8 and price 1300.', '2024-11-16 08:25:02'),
(4, 3, 'Add Rice', 'Added Swan with quantity 2 and price 23.', '2024-11-17 07:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `RiceID` int(11) NOT NULL,
  `RiceName` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`RiceID`, `RiceName`, `Quantity`, `Price`, `created_at`) VALUES
(1, 'Jasmine', 10, 1200.00, '2024-11-15 15:16:42'),
(2, 'Princess Bea', 20, 1150.00, '2024-11-15 15:28:41'),
(3, 'Princess Bea', 20, 1150.00, '2024-11-16 14:46:54'),
(4, 'Valencia', 12, 1150.00, '2024-11-16 15:17:37'),
(5, 'Broken', 10, 1050.00, '2024-11-16 15:20:16'),
(6, 'Sticky', 8, 1300.00, '2024-11-16 15:25:02'),
(7, 'Swan', 2, 23.00, '2024-11-17 14:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `inventoryupdates`
--

CREATE TABLE `inventoryupdates` (
  `UpdateID` int(11) NOT NULL,
  `RiceID` int(11) DEFAULT NULL,
  `UpdatedQuantity` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(10) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `RoleID`, `created_at`, `updated_at`) VALUES
(3, 'meyr', '$2y$10$QYNrgt926V9qc/iLSoHX6uIQlfoux/wudT0v98/664LtIuaWwgDne', 1, '2024-11-15 14:49:59', '2024-11-15 14:49:59'),
(4, 'say', '$2y$10$zFtDZnz1qAM.PwHccNpi2uNvBUdY.sc683MxRGRY32KUBtOqoCSnu', 1, '2024-11-17 15:24:21', '2024-11-17 15:24:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitylogs`
--
ALTER TABLE `activitylogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`RiceID`);

--
-- Indexes for table `inventoryupdates`
--
ALTER TABLE `inventoryupdates`
  ADD PRIMARY KEY (`UpdateID`),
  ADD KEY `RiceID` (`RiceID`),
  ADD KEY `fk_user_id` (`UserID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `username` (`UserName`),
  ADD KEY `FK_RoleID` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitylogs`
--
ALTER TABLE `activitylogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `RiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventoryupdates`
--
ALTER TABLE `inventoryupdates`
  MODIFY `UpdateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitylogs`
--
ALTER TABLE `activitylogs`
  ADD CONSTRAINT `activitylogs_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `inventoryupdates`
--
ALTER TABLE `inventoryupdates`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventoryupdates_ibfk_1` FOREIGN KEY (`RiceID`) REFERENCES `inventory` (`RiceID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_RoleID` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
