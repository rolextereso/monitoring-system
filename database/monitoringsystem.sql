-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2017 at 10:48 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
create database `monitoringsystem`;
use monitoringsystem;
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `customer_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`) VALUES
(3, 'df', 'df'),
(4, 's', 's'),
(5, 'd', 'd'),
(6, 'd', 'd'),
(7, 'd', 'd'),
(8, 'h', 'h'),
(9, 'df', 'fg'),
(10, 'df', 'fg'),
(11, 'd', 'd'),
(12, 'd', 'd'),
(13, 'd', 'd'),
(14, 'd', 'd'),
(15, 'd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(45) DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit_of_measurement` varchar(45) DEFAULT NULL,
  `product_status` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `created_on`, `created_by`, `project_id`, `unit_of_measurement`, `product_status`) VALUES
(2, 'Coconut Seedling', 4, '2017-12-11 17:37:54', NULL, 1, 'seedling', 'Y'),
(3, 'Vinegar', 5, '2017-12-11 17:39:09', NULL, 1, 'Gallon', 'N'),
(4, 'Charcoal', 6, '2017-12-11 17:41:58', NULL, 1, 'Taro', 'N'),
(5, 'Vermi Worm', 7, '2017-12-11 17:46:13', NULL, 2, 'Kilo', 'Y'),
(6, 'Vermi Compost', 8, '2017-12-11 18:57:39', NULL, 2, 'Kilo', 'Y'),
(7, 'sample', 9, '2017-12-11 18:58:59', NULL, 2, 'kilo', 'Y'),
(8, 'Bamboo Chair', 10, '2017-12-11 21:20:06', NULL, 4, 'strands', 'N'),
(13, 'Sample', 15, '2017-12-11 22:05:26', NULL, 2, 'kilo', 'Y'),
(14, 'sample1', 16, '2017-12-11 22:49:47', NULL, 1, 'seedling', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `price_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `created_updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`price_id`, `price`, `created_updated_on`, `created_by`) VALUES
(1, 10, '2017-12-11 17:36:07', 0),
(2, 10, '2017-12-11 17:36:14', 0),
(3, 10, '2017-12-11 17:37:03', 0),
(4, 10, '2017-12-11 17:37:54', 0),
(5, 100, '2017-12-11 17:39:09', 0),
(6, 20, '2017-12-11 17:41:58', 0),
(7, 100, '2017-12-11 17:46:13', 0),
(8, 1000, '2017-12-11 18:57:39', 0),
(9, 20, '2017-12-11 18:58:59', 0),
(10, 10, '2017-12-11 21:20:06', 0),
(15, 1000, '2017-12-11 22:05:26', 0),
(16, 10, '2017-12-11 22:49:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(45) DEFAULT NULL,
  `project_description` varchar(45) DEFAULT NULL,
  `project_status` enum('Y','N') DEFAULT 'Y',
  `project_incharge` int(11) DEFAULT NULL,
  `project_started` date DEFAULT NULL,
  `project_ended` date DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_description`, `project_status`, `project_incharge`, `project_started`, `project_ended`, `created_on`, `created_by`) VALUES
(1, 'Coconut', '                                             ', 'N', 1, '2017-12-11', '0000-00-00', '2017-12-11 17:35:30', NULL),
(2, 'Vermi', '', 'Y', 1, '2017-12-12', NULL, '2017-12-11 17:45:42', NULL),
(3, 'Goats', '                                             ', 'Y', 1, '2017-12-12', NULL, '2017-12-11 21:13:24', NULL),
(4, 'Bamboos', '                                             ', 'N', 1, '2017-12-11', '0000-00-00', '2017-12-11 21:17:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_record`
--

CREATE TABLE `sales_record` (
  `sales_id` int(11) NOT NULL,
  `or_number` varchar(45) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `mode_of_payment` varchar(45) DEFAULT NULL,
  `sold_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_record`
--

INSERT INTO `sales_record` (`sales_id`, `or_number`, `total_amount`, `mode_of_payment`, `sold_date`, `user_id`, `customer_id`) VALUES
(5, 'ddddd', 1000, 'cash', '2017-12-12 20:51:33', 1, 3),
(6, '11111', 1000, 'cash', '2017-12-12 20:53:26', 1, 4),
(7, 'sfsf', 1000, 'cash', '2017-12-12 22:34:29', 1, 5),
(8, '222222', 1000, 'cash', '2017-12-12 22:35:26', 1, 6),
(9, 'dfdfd', 10, 'cash', '2017-12-12 22:50:19', 1, 7),
(10, 'fgfgfg', 40, 'cash', '2017-12-12 22:51:03', 1, 8),
(11, 'dfsf', 0, 'cash', '2017-12-13 14:58:24', 1, 9),
(12, 'dfsf', 0, 'cash', '2017-12-13 14:58:33', 1, 10),
(13, 'd', 0, 'cash', '2017-12-13 15:00:58', 1, 11),
(14, '1', 0, 'cash', '2017-12-13 15:01:53', 1, 12),
(15, '1', 0, 'cash', '2017-12-13 15:01:58', 1, 13),
(16, 'd', 1080, 'cash', '2017-12-13 16:03:08', 1, 14),
(17, 'd', 1010, 'cash', '2017-12-13 16:06:29', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `sales_specific`
--

CREATE TABLE `sales_specific` (
  `sales_specific_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `or_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_specific`
--

INSERT INTO `sales_specific` (`sales_specific_id`, `product_id`, `quantity`, `amount`, `or_number`) VALUES
(5, 2, 2, 20, 5),
(6, 14, 1, 10, 5),
(7, 5, 1, 100, 6),
(8, 14, 1, 10, 6),
(9, 2, 1, 10, 6),
(10, 14, 1, 10, 7),
(11, 2, 1, 10, 7),
(12, 6, 1, 1, 8),
(13, 14, 1, 10, 8),
(14, 2, 2, 20, 8),
(15, 2, 1, 10, 9),
(16, 2, 4, 40, 10),
(17, 2, 2, 20, 11),
(18, 2, 2, 20, 12),
(19, 2, 1, 10, 13),
(20, 2, 1, 10, 14),
(21, 2, 1, 10, 15),
(22, 7, 4, 80, 16),
(23, 13, 1, 1, 16),
(24, 13, 1, 1, 17),
(25, 2, 1, 10, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `hint` text,
  `status` enum('Y','N') DEFAULT 'N',
  `profile_pic` varchar(45) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `hint`, `status`, `profile_pic`, `user_type`, `created_on`) VALUES
(1, 'Rolly', 'Tereso', 'admin', 'ƒ¡‡X¼“ÇÃ²üÀ‰£', '111', 'N', 'img/Christmas-Hat-PNG-HD.png', 1, '2017-12-11 17:35:10'),
(2, 'Christine', 'Gondaya', 'christine', 'skÜ…°Ï’ôÇä¥kO\0', 'Case Number', 'N', NULL, 1, '2017-12-12 17:24:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `sub_prod_idx` (`project_id`),
  ADD KEY `fuser_idx` (`created_by`),
  ADD KEY `fprice_idx` (`product_price`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `f_userk_idx` (`created_by`);

--
-- Indexes for table `sales_record`
--
ALTER TABLE `sales_record`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `fuserId_idx` (`user_id`),
  ADD KEY `fk_customer_idx` (`customer_id`);

--
-- Indexes for table `sales_specific`
--
ALTER TABLE `sales_specific`
  ADD PRIMARY KEY (`sales_specific_id`),
  ADD KEY `fk_pro_idx` (`product_id`),
  ADD KEY `fk_sale_idx` (`or_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fprice` FOREIGN KEY (`product_price`) REFERENCES `product_price` (`price_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fuser` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_prod` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `f_userk` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_record`
--
ALTER TABLE `sales_record`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fuserId` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_specific`
--
ALTER TABLE `sales_specific`
  ADD CONSTRAINT `fk_pro` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale` FOREIGN KEY (`or_number`) REFERENCES `sales_record` (`sales_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
