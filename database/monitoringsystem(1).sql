-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2018 at 04:02 PM
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
CREATE DEFINER=`root`@`localhost` FUNCTION `report_product_by_month_year` (`product_id` INT, `sold_date` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(ss.amount)  INTO total
				FROM products pe 
				inner JOIN sales_specific ss ON ss.product_id=pe.product_id 
				inner JOIN sales_record sre ON ss.or_number=sre.sales_id   
				WHERE  pe.product_id=product_id  AND MONTH(sre.sold_date)=MONTH(sold_date)
				AND YEAR(sre.sold_date)=YEAR(sold_date)
				GROUP BY product_name, MONTH(sre.sold_date), YEAR(sre.sold_date);

RETURN total;
END$$

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
(16, 'Rolly Tereso', 'Ambacon'),
(17, 'Rolex', 'Ambacon'),
(18, 'Rolex', 'Ambacon'),
(19, 'Rolex', 'Ambacon'),
(20, 'rolex', 'ambacon'),
(21, 'rolex', 'ambacon'),
(22, 'Rolex', 'ambacon'),
(23, 'Rolly', 'Ambacon'),
(24, 'Rolex', 'Ambacon'),
(25, 's', 's'),
(26, 'r', 'r'),
(27, 'rolex', 'ambacon');

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
(10, 'Goat Meat', 10, '2017-12-18 22:57:44', NULL, 4, 'kilo', 'Y'),
(17, 'Product 1', 17, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y'),
(18, 'Product 2', 18, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y'),
(19, 'Product 3', 19, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y');

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
(10, 200, '2017-12-18 22:57:44', 0),
(17, 10, '2018-01-08 14:55:39', 1),
(18, 10, '2018-01-08 14:55:39', 1),
(19, 10, '2018-01-08 14:55:39', 1);

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
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_description`, `project_status`, `project_incharge`, `created_on`, `created_by`) VALUES
(1, 'Coconut', '                                             ', 'Y', 1, '2017-12-15 14:17:37', NULL),
(2, 'Vinegar', 'This is a project of DA                      ', 'Y', 1, '2017-12-15 14:18:20', NULL),
(3, 'Vermi', '                                             ', 'N', 1, '2017-12-18 14:30:00', NULL),
(4, 'Goat', '                                             ', 'Y', 1, '2017-12-18 14:30:58', NULL),
(5, 's', '                                             ', 'Y', 1, '2017-12-18 15:30:20', NULL),
(8, 'Kuhol', '                                        ', 'Y', 1, '2018-01-08 14:55:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_duration`
--

CREATE TABLE `project_duration` (
  `project_duration_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL,
  `month` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `release` enum('Y','N') DEFAULT 'N',
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_duration`
--

INSERT INTO `project_duration` (`project_duration_id`, `project_id`, `description`, `month`, `amount`, `release`, `created_by`, `created_on`) VALUES
(1, 8, 'Product 1', '2018-01-07', 10, 'N', 1, '2018-01-08 14:55:39'),
(2, 8, 'Product 2', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(3, 8, 'Product 3', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(4, 8, 'Marketing Expenses', '2018-01-07', 10, 'N', 1, '2018-01-08 14:55:39'),
(5, 8, 'Other Marketing Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(6, 8, 'Other Related Marketing Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(7, 8, 'Salaries other than Labor', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(8, 8, 'Other Administrative Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(9, 8, 'Registration, Fees, Licenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(10, 8, 'Others', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39');

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
(19, '1112212121', 300, 'cash', '2017-12-19 19:09:19', 1, 19, 'Y'),
(20, 'dfdfdfd', 100, 'cash', '2017-12-19 19:10:04', 1, 20, 'N'),
(21, '131243424', 200, 'cash', '2017-12-19 19:13:31', 1, 21, 'Y'),
(22, '32323424', 100, 'cash', '2017-12-19 22:52:47', 1, 22, 'Y'),
(23, '1212121', 100, 'cash', '2017-12-19 22:53:14', 1, 23, 'Y'),
(24, '433433', 100, 'cash', '2017-12-19 22:54:25', 1, 24, 'N'),
(25, '342424', 100, 'cash', '2018-03-19 22:57:50', 1, 25, 'N'),
(26, '3242424', 100, 'cash', '2018-02-19 22:58:08', 1, 26, 'N'),
(27, '21312313', 300, 'cash', '2017-12-31 16:35:22', 1, 27, 'Y');

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
(43, 1, 3, 300, 19),
(44, 8, 1, 100, 20),
(45, 10, 1, 200, 21),
(46, 1, 1, 100, 22),
(47, 2, 1, 100, 23),
(48, 2, 1, 100, 24),
(49, 1, 1, 100, 25),
(50, 1, 1, 100, 26),
(51, 1, 3, 300, 27);

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
(1, 'Rolly', 'Tereso', 'rolex', 'jã#ïÔ®í5NB¬¹Àp—', 'My Case Number', 'Y', 'img/Christmas-Hat-PNG-HD.png', 1, '2017-12-19 17:47:37');

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
-- Indexes for table `project_duration`
--
ALTER TABLE `project_duration`
  ADD PRIMARY KEY (`project_duration_id`),
  ADD KEY `fkproject_idx` (`project_id`);

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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `project_duration`
--
ALTER TABLE `project_duration`
  MODIFY `project_duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- Constraints for table `project_duration`
--
ALTER TABLE `project_duration`
  ADD CONSTRAINT `fkproject` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

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
