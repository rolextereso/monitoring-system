-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2017 at 03:43 PM
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
-- Database: `monitoringsystem`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `total_revenue_all_project` () RETURNS FLOAT BEGIN
   DECLARE total FLOAT DEFAULT 0.0;
   SELECT  
		SUM(ss.amount)  INTO total
        FROM products p 
		INNER JOIN sales_specific ss ON ss.product_id=p.product_id 
		INNER JOIN sales_record sr ON ss.or_number=sr.sales_id 
		WHERE YEAR(sr.sold_date)= YEAR(CURRENT_DATE()) ;

RETURN total;
END$$

DELIMITER ;

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
(1, 'Christine Gondaya', 'Silago'),
(2, 'James Ogang', 'Hinunangan'),
(3, 'Christine', 'Hinunangan'),
(4, 'Jacob Tayom', 'Ambacon'),
(5, 'Rolly', 'Ambacon'),
(6, 'Rolly', 'Ambacon'),
(7, 'Sample', 'Sampl'),
(8, 'sample2', 'sample2'),
(9, 'sample4', 'sample4'),
(10, 'sample', 'sampl'),
(11, 'Rolex', 'Ambacon'),
(12, 'XX', 'XX'),
(13, 'Denie', 'Patong'),
(14, 'Christine Gondaya', 'Ambacon'),
(15, 'a', 'a'),
(16, 'Rolly Tereso', 'Ambacon');

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
(1, 'Coconut Seedling', 1, '2017-12-15 14:18:40', NULL, 1, 'Seedling', 'Y'),
(2, 'Vinegar/Suka', 2, '2017-12-15 14:19:30', NULL, 1, 'Gallon', 'Y'),
(3, 'Charcoal', 3, '2017-12-18 14:26:56', NULL, 1, 'Taro', 'Y'),
(4, 'Bunot', 4, '2017-12-18 14:27:19', NULL, 1, 'pieces', 'Y'),
(5, 'Lukay', 5, '2017-12-18 14:27:59', NULL, 1, 'pieces', 'Y'),
(6, 'bagol', 6, '2017-12-18 14:28:26', NULL, 1, 'pieces', 'Y'),
(7, 'Vermi Worm', 7, '2017-12-18 14:31:34', NULL, 3, 'kilo', 'Y'),
(8, 'Vermi Compost', 8, '2017-12-18 14:38:06', NULL, 3, 'kilo', 'Y'),
(9, 'Vermi mud', 9, '2017-12-18 14:39:27', NULL, 3, 'kilo', 'Y'),
(10, 'Goat Meat', 10, '2017-12-18 22:57:44', NULL, 4, 'kilo', 'Y');

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
(1, 100, '2017-12-15 14:18:40', 0),
(2, 100, '2017-12-15 14:19:30', 0),
(3, 30, '2017-12-18 14:26:56', 0),
(4, 20, '2017-12-18 14:27:19', 0),
(5, 10, '2017-12-18 14:27:59', 0),
(6, 10, '2017-12-18 14:28:26', 0),
(7, 500, '2017-12-18 14:31:34', 0),
(8, 100, '2017-12-18 14:38:06', 0),
(9, 10, '2017-12-18 14:39:27', 0),
(10, 200, '2017-12-18 22:57:44', 0);

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
(1, 'Coconut', '                                             ', 'Y', 1, '2017-12-13', '0000-00-00', '2017-12-15 14:17:37', NULL),
(2, 'Vinegar', 'This is a project of DA                      ', 'Y', 1, '2017-12-13', '0000-00-00', '2017-12-15 14:18:20', NULL),
(3, 'Vermi', '                                             ', 'N', 1, '2017-12-18', '0000-00-00', '2017-12-18 14:30:00', NULL),
(4, 'Goat', '                                             ', 'Y', 1, '2017-12-18', '0000-00-00', '2017-12-18 14:30:58', NULL),
(5, 's', '                                             ', 'Y', 1, '2017-12-18', '0000-00-00', '2017-12-18 15:30:20', NULL);

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
  `customer_id` int(11) DEFAULT NULL,
  `printing_status` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_record`
--

INSERT INTO `sales_record` (`sales_id`, `or_number`, `total_amount`, `mode_of_payment`, `sold_date`, `user_id`, `customer_id`, `printing_status`) VALUES
(1, '1121211', 300, 'cash', '2017-12-15 14:20:28', 1, 1, 'Y'),
(2, '121132232', 100, 'cash', '2017-12-15 14:24:21', 1, 2, 'Y'),
(3, '345454333', 400, 'cash', '2017-11-15 14:27:00', 1, 3, 'N'),
(4, '11121121', 900, 'cash', '2017-12-15 16:51:16', 1, 4, 'Y'),
(5, '092883-3434', 50, 'cash', '2017-12-18 16:14:47', 1, 5, 'Y'),
(6, '343422-23', 140, 'cash', '2017-12-18 16:16:12', 1, 6, 'Y'),
(7, '12233433', 610, 'cash', '2017-12-18 21:37:48', 1, 7, 'Y'),
(8, '322242433', 210, 'cash', '2017-12-18 21:38:49', 1, 8, 'Y'),
(9, '345634644', 140, 'cash', '2017-12-18 21:39:33', 1, 9, 'N'),
(10, '2342343', 500, 'cash', '2017-12-18 21:41:18', 1, 10, 'Y'),
(11, '2323344', 130, 'cash', '2017-12-18 22:05:05', 1, 11, 'Y'),
(12, '434242342', 400, 'cash', '2017-12-18 22:17:40', 1, 12, 'N'),
(13, '435354444', 110, 'cash', '2017-12-18 22:29:57', 1, 13, 'N'),
(14, '23423455', 220, 'cash', '2017-12-18 22:58:29', 1, 14, 'N'),
(15, '123123131', 200, 'cash', '2017-12-19 14:15:02', 1, 15, 'N'),
(16, '123133343', 520, 'cash', '2017-12-19 14:19:27', 1, 16, 'N');

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
(1, 2, 1, 100, 1),
(2, 1, 2, 200, 1),
(3, 1, 1, 100, 2),
(4, 2, 1, 100, 3),
(5, 1, 3, 300, 3),
(6, 2, 9, 900, 4),
(7, 6, 1, 10, 5),
(8, 5, 1, 10, 5),
(9, 3, 1, 30, 5),
(10, 5, 1, 10, 6),
(11, 3, 1, 30, 6),
(12, 2, 1, 100, 6),
(13, 7, 1, 500, 7),
(14, 9, 1, 10, 7),
(15, 2, 1, 100, 7),
(16, 1, 1, 100, 8),
(17, 6, 1, 10, 8),
(18, 2, 1, 100, 8),
(19, 6, 1, 10, 9),
(20, 1, 1, 100, 9),
(21, 3, 1, 30, 9),
(22, 8, 1, 100, 10),
(23, 2, 1, 100, 10),
(24, 1, 3, 300, 10),
(25, 3, 1, 30, 11),
(26, 2, 1, 100, 11),
(27, 8, 1, 100, 12),
(28, 2, 2, 200, 12),
(29, 1, 1, 100, 12),
(30, 9, 1, 10, 13),
(31, 1, 1, 100, 13),
(32, 6, 2, 20, 14),
(33, 10, 1, 200, 14),
(34, 1, 2, 200, 15),
(35, 4, 1, 20, 16),
(36, 1, 5, 500, 16);

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
(1, 'Rolly', 'Tereso', 'rolex', 'jã#ïÔ®í5NB¬¹Àp—', 'My Case Number', 'Y', NULL, 1, '2017-12-15 14:15:39'),
(2, 'sample', 'sample', 'sample', '·6 À3¼\nM¨\"xÂ¢ÈÍb', 'sample', 'Y', NULL, 1, '2017-12-18 16:05:23');

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
  ADD KEY `fk_customer_idx` (`customer_id`),
  ADD KEY `fuserId_idx` (`user_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
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
