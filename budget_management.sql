-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2023 at 07:03 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budget_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_data`
--

CREATE TABLE `all_data` (
  `category_id` int(11) DEFAULT NULL,
  `data_id` int(11) NOT NULL,
  `country` varchar(40) DEFAULT NULL,
  `bps_date` date DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_amount` float DEFAULT NULL,
  `approval_amount` float DEFAULT NULL,
  `balance_amount` float DEFAULT NULL,
  `title` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_data`
--

INSERT INTO `all_data` (`category_id`, `data_id`, `country`, `bps_date`, `invoice_date`, `invoice_amount`, `approval_amount`, `balance_amount`, `title`) VALUES
(1, 71, 'malesia', '2023-03-01', '2023-03-01', 889, 56, 8956, 'jhkbjo'),
(1, 72, 'malesia', '2023-03-01', '2023-03-01', 889, 56, 8956, 'jhkbjo'),
(1, 73, 'malesia', '2023-03-01', '2023-03-01', 889, 56, 8956, 'jhkbjo'),
(1, 74, 'malesia', '2023-03-01', '2023-03-01', 889, 56, 8956, 'jhkbjo'),
(1, 75, 'malesia', '2023-03-01', '2023-03-01', 889, 8563, 8956, 'helmets'),
(1, 76, 'malesia', '2023-03-01', '2023-03-01', 889, 8563, 8956, 'helmet'),
(1, 77, 'malesia', '2023-03-01', '2023-03-01', 889, 8563, 8956, 'ros');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'patent'),
(2, 'design'),
(3, 'tradename'),
(4, 'copyrights'),
(5, 'others');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_data`
--
ALTER TABLE `all_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_data`
--
ALTER TABLE `all_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_data`
--
ALTER TABLE `all_data`
  ADD CONSTRAINT `all_data_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
