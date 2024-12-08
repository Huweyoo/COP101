-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 10:44 PM
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
-- Database: `aqualensedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `PARAMETERS` enum('ph','o2','nh3','temp') NOT NULL,
  `READINGS` decimal(5,3) DEFAULT NULL,
  `DATECREATED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safe_range`
--

CREATE TABLE `safe_range` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `PH_MIN` decimal(5,3) DEFAULT NULL,
  `PH_MAX` decimal(5,3) DEFAULT NULL,
  `TEMP_MIN` decimal(5,3) DEFAULT NULL,
  `TEMP_MAX` decimal(5,3) DEFAULT NULL,
  `AMMONIA_MIN` decimal(5,3) DEFAULT NULL,
  `AMMONIA_MAX` decimal(5,3) DEFAULT NULL,
  `DO_MIN` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `safe_range`
--

INSERT INTO `safe_range` (`ID`, `USER_ID`, `PH_MIN`, `PH_MAX`, `TEMP_MIN`, `TEMP_MAX`, `AMMONIA_MIN`, `AMMONIA_MAX`, `DO_MIN`) VALUES
(1, 1, 4.000, 6.000, 25.000, 30.000, 1.000, 2.000, 5.000);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `PH_LEVEL` decimal(5,3) DEFAULT NULL,
  `TEMPERATURE` decimal(5,3) DEFAULT NULL,
  `AMMONIA_LEVEL` decimal(5,3) DEFAULT NULL,
  `DO_LEVEL` decimal(5,3) DEFAULT NULL,
  `LAST_SAVED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `FNAME` varchar(30) NOT NULL,
  `LNAME` varchar(30) NOT NULL,
  `MNAME` varchar(30) NOT NULL,
  `USERNAME` varchar(25) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `CONTACT` varchar(11) NOT NULL,
  `DATECREATED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USERID`, `FNAME`, `LNAME`, `MNAME`, `USERNAME`, `PASSWORD`, `EMAIL`, `CONTACT`, `DATECREATED`) VALUES
(1, 'Japhet', 'Ruiz', 'Nun', 'japet', '$2y$10$d.qCUmqVhieY7NCiJ1.SKOPTi1LgWBsNplulkafS/4kg1DG3ShWFa', 'japzuir@gmail.com', '09123456789', '2024-12-08 03:02:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `safe_range`
--
ALTER TABLE `safe_range`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safe_range`
--
ALTER TABLE `safe_range`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USERID`);

--
-- Constraints for table `safe_range`
--
ALTER TABLE `safe_range`
  ADD CONSTRAINT `safe_range_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USERID`);

--
-- Constraints for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD CONSTRAINT `sensor_data_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USERID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
