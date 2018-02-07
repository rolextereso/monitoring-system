-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2018 at 09:18 PM
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
CREATE DEFINER=`root`@`localhost` FUNCTION `report_product_by_month` (`product_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(ss.amount)  INTO total
				FROM products pe 
				inner JOIN sales_specific ss ON ss.product_id=pe.product_id 
				inner JOIN sales_record sre ON ss.or_number=sre.sales_id   
				WHERE  pe.product_id=product_id  AND MONTH(sre.date_save)=MONTH(date_save)
				AND YEAR(sre.date_save)=YEAR(date_save)
				GROUP BY product_name, MONTH(sre.date_save), YEAR(sre.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `report_product_by_year` (`product_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(ss.amount)  INTO total
				FROM products pe 
				inner JOIN sales_specific ss ON ss.product_id=pe.product_id 
				inner JOIN sales_record sre ON ss.or_number=sre.sales_id   
				WHERE  pe.product_id=product_id  
				AND YEAR(sre.date_save)=YEAR(date_save)
				GROUP BY product_name, YEAR(sre.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `report_project_by_month` (`project_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(ss.amount)  INTO total
				FROM products pe 
				inner JOIN sales_specific ss ON ss.product_id=pe.product_id 
				inner JOIN sales_record sre ON ss.or_number=sre.sales_id   
				WHERE  pe.project_id=project_id  AND MONTH(sre.date_save)=MONTH(date_save)
				AND YEAR(sre.date_save)=YEAR(date_save)
				GROUP BY project_id, MONTH(sre.date_save), YEAR(sre.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `report_project_by_year` (`project_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(ss.amount)  INTO total
				FROM products pe 
				inner JOIN sales_specific ss ON ss.product_id=pe.product_id 
				inner JOIN sales_record sre ON ss.or_number=sre.sales_id   
				WHERE  pe.project_id=project_id  
				AND YEAR(sre.date_save)=YEAR(date_save)
				GROUP BY project_id, YEAR(sre.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `report_rental_by_month` (`rental_id_` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(rs.rental_fee_amount)  INTO total
				FROM rental_specific rs 
				inner JOIN rental_items ri ON rs.rental_id=ri.rental_id
				inner JOIN sales_record sr ON rs.sales_id=sr.sales_id   
				WHERE  ri.rental_id=rental_id_ AND MONTH(sr.date_save)=MONTH(date_save)
				AND YEAR(sr.date_save)=YEAR(date_save) AND rs.paid='Y'
				GROUP BY ri.rental_id, MONTH(sr.date_save), YEAR(sr.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `report_rental_by_year` (`rental_id_` INT, `date_save` DATE) RETURNS FLOAT BEGIN
		DECLARE total FLOAT DEFAULT 0.0;
		SELECT 
				SUM(rs.rental_fee_amount)  INTO total
				FROM rental_specific rs 
				inner JOIN rental_items ri ON rs.rental_id=ri.rental_id
				inner JOIN sales_record sr ON rs.sales_id=sr.sales_id   
				WHERE  ri.rental_id=rental_id_ 
				AND YEAR(sr.date_save)=YEAR(date_save) AND rs.paid='Y'
				GROUP BY ri.rental_id, YEAR(sr.date_save);

RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_revenue_all_project` () RETURNS FLOAT BEGIN
   DECLARE total FLOAT DEFAULT 0.0;
   SELECT  
		SUM(ss.amount)  INTO total
        FROM products p 
		INNER JOIN sales_specific ss ON ss.product_id=p.product_id 
		INNER JOIN sales_record sr ON ss.or_number=sr.sales_id 
		WHERE YEAR(sr.date_save)= YEAR(CURRENT_DATE()) ;

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
(124, 'Christine Gondaya', 'Silago'),
(125, 'Rolly Tereso', 'Ambacon');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_breakdown`
--

CREATE TABLE `expenses_breakdown` (
  `id` int(11) NOT NULL,
  `ORNumber` varchar(45) DEFAULT NULL,
  `item_description` varchar(145) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `amount_per_unit` float DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `purchase_request_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses_breakdown`
--

INSERT INTO `expenses_breakdown` (`id`, `ORNumber`, `item_description`, `qty`, `amount_per_unit`, `unit`, `purchase_request_id`) VALUES
(11, '1313313131313', 'Abuno', 1, 1110, 'Sack', 9),
(12, NULL, 'Abuno', 1, NULL, 'sack', 10);

-- --------------------------------------------------------

--
-- Table structure for table `location_marks`
--

CREATE TABLE `location_marks` (
  `id_marks` int(11) NOT NULL,
  `position_marks` varchar(45) DEFAULT NULL,
  `image` varchar(245) DEFAULT NULL,
  `establisment_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_marks`
--

INSERT INTO `location_marks` (`id_marks`, `position_marks`, `image`, `establisment_name`) VALUES
(4, ' top:661px;left:416px', 'img/location_map_pic/SCSU_ani.gif', 'Art and Science Building'),
(7, ' top:713px;left:696px', 'img/location_map_pic/social_hall.jpg', 'Social Hall'),
(9, ' top:733px;left:610px', 'img/location_map_pic/buley-library.jpeg', 'Supply Office'),
(10, ' top:450px;left:546px', 'img/location_map_pic/social_hall.jpg', 'HomeTech Building'),
(13, ' top:555px;left:638px', 'img/location_map_pic/2018-02-07_2247.png', 'Administration Building'),
(14, ' top:249px;left:196px', 'img/location_map_pic/ambacon.jpg', 'Ambacon Barangay Hall');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(45) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `status`) VALUES
(1, 'Location Map', 'Y'),
(2, 'Rental or Product Selection', 'Y'),
(3, 'Transaction List', 'Y'),
(4, 'Project List', 'Y'),
(5, 'Rental Item List', 'Y'),
(6, 'Rented Items', 'Y'),
(7, 'Reports', 'Y'),
(8, 'Gate Pass', 'Y'),
(9, 'Users Setting', 'Y'),
(10, 'Admin Setting', 'Y'),
(11, 'Purchase Requests', 'Y'),
(12, 'User Logs', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `owner_info`
--

CREATE TABLE `owner_info` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(145) DEFAULT NULL,
  `owner_address` varchar(145) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner_info`
--

INSERT INTO `owner_info` (`id`, `owner_name`, `owner_address`, `contact_no`, `logo`) VALUES
(1, 'Southern Leyte State University-CAES', 'Brgy. Ambacon, Hinunangan, Southern Leyte', '0865754344', 'img/setting_assets/logo.png');

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
  `product_status` enum('Y','N') DEFAULT 'Y',
  `project_specific_id` varchar(45) DEFAULT NULL,
  `for_gate_pass` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `created_on`, `created_by`, `project_id`, `unit_of_measurement`, `product_status`, `project_specific_id`, `for_gate_pass`) VALUES
(88, 'Product 1', 103, '2018-02-06 21:59:47', 5, 27, 'seedling', 'Y', '18-02064759', 'Y'),
(89, 'Product 2', 104, '2018-02-06 21:59:47', 5, 27, 'seedling', 'Y', '18-02064759', 'Y'),
(90, 'Product 3', 105, '2018-02-06 21:59:47', 5, 27, 'seedling', 'Y', '18-02064759', 'Y');

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
(103, 210, '2018-02-06 21:59:47', 5),
(104, 210, '2018-02-06 21:59:47', 5),
(105, 120, '2018-02-06 21:59:47', 5);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_type` varchar(45) DEFAULT NULL,
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

INSERT INTO `projects` (`project_id`, `project_type`, `project_name`, `project_description`, `project_status`, `project_incharge`, `created_on`, `created_by`) VALUES
(27, 'Non-Agricultural', 'Rubber', '                                        ', 'Y', 5, '2018-02-06 21:59:47', 5);

-- --------------------------------------------------------

--
-- Table structure for table `project_budget`
--

CREATE TABLE `project_budget` (
  `project_budget_id` int(11) NOT NULL,
  `project_specific_id` varchar(45) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `release` enum('Y','N') DEFAULT 'N',
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_budget`
--

INSERT INTO `project_budget` (`project_budget_id`, `project_specific_id`, `project_id`, `description`, `amount`, `release`, `created_by`, `created_on`) VALUES
(260, '18-02064759', 27, 'Product 1 (production costs)', 1110, 'N', 5, '2018-02-06 21:59:47'),
(261, '18-02064759', 27, 'Product 2 (production costs)', 2220, 'N', 5, '2018-02-06 21:59:47'),
(262, '18-02064759', 27, 'Product 3 (production costs)', 1110, 'N', 5, '2018-02-06 21:59:47'),
(263, '18-02064759', 27, 'Marketing Expenses ', 10, 'N', 5, '2018-02-06 21:59:47'),
(264, '18-02064759', 27, 'Other Marketing Expenses ', 10, 'N', 5, '2018-02-06 21:59:47'),
(265, '18-02064759', 27, 'Other Related Marketing Expenses ', 101, 'N', 5, '2018-02-06 21:59:47'),
(266, '18-02064759', 27, 'Salaries other than Labor ', 10, 'N', 5, '2018-02-06 21:59:47'),
(267, '18-02064759', 27, 'Other Administrative Expenses ', 10, 'N', 5, '2018-02-06 21:59:47'),
(268, '18-02064759', 27, 'Registration, Fees, Licenses ', 10, 'N', 5, '2018-02-06 21:59:47'),
(269, '18-02064759', 27, 'Others ', 10, 'N', 5, '2018-02-06 21:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `project_duration`
--

CREATE TABLE `project_duration` (
  `project_duration_id` int(11) NOT NULL,
  `project_specific_id` varchar(45) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Y','N') DEFAULT 'Y',
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_duration`
--

INSERT INTO `project_duration` (`project_duration_id`, `project_specific_id`, `from_date`, `to_date`, `created_by`, `created_on`, `status`, `project_id`) VALUES
(8, '18-02064759', '2018-02-07', '2018-07-31', 5, '2018-02-06 21:59:47', 'Y', 27);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `purchase_request_id` int(11) NOT NULL,
  `entity_name` varchar(45) DEFAULT NULL,
  `project_duration_id` int(11) DEFAULT NULL,
  `purpose` varchar(45) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `approved` enum('Y','N','O') DEFAULT 'O',
  `pr_no` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_request`
--

INSERT INTO `purchase_request` (`purchase_request_id`, `entity_name`, `project_duration_id`, `purpose`, `created_on`, `created_by`, `approved`, `pr_no`, `updated_on`) VALUES
(9, 'Southern Leyte State University', 8, 'For rubber project', '2018-02-06 22:03:07', 5, 'Y', '180242-0242', '2018-02-07 06:25:44'),
(10, 'Southern Leyte State University', 8, 'For Rubber Project', '2018-02-07 18:36:43', 1, 'Y', '180203-3603', '2018-02-08 02:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `rental_items`
--

CREATE TABLE `rental_items` (
  `rental_id` int(11) NOT NULL,
  `item_name` varchar(45) DEFAULT NULL,
  `item_code` varchar(45) DEFAULT NULL,
  `item_description` varchar(100) DEFAULT NULL,
  `rental_fee` double DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `per_day` enum('Y','N') DEFAULT 'N',
  `need_gate_pass` enum('N','Y') DEFAULT 'N',
  `created_by` int(11) DEFAULT NULL,
  `status` enum('N','Y') DEFAULT NULL,
  `availability` enum('N','Y') DEFAULT 'Y',
  `transaction_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='			';

--
-- Dumping data for table `rental_items`
--

INSERT INTO `rental_items` (`rental_id`, `item_name`, `item_code`, `item_description`, `rental_fee`, `unit`, `per_day`, `need_gate_pass`, `created_by`, `status`, `availability`, `transaction_id`) VALUES
(10, 'Grass Cutter', '180225-0125', 'Brand:Honda,Color: Red', 100, 'set', 'Y', 'Y', 5, 'Y', 'Y', ''),
(11, 'Projector', '180209-2509', 'Brand: Acer, Color: White', 100, 'set', 'Y', 'Y', 5, 'Y', 'Y', ''),
(12, 'Tractor', '180214-4114', 'Brand: Honda', 200, 'item', 'Y', 'Y', 6, 'Y', 'Y', '');

-- --------------------------------------------------------

--
-- Table structure for table `rental_specific`
--

CREATE TABLE `rental_specific` (
  `rental_specific_id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `rental_fee_amount` double DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(45) DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `paid` enum('N','Y') DEFAULT 'N',
  `no_of_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_specific`
--

INSERT INTO `rental_specific` (`rental_specific_id`, `rental_id`, `date_return`, `rental_fee_amount`, `updated_on`, `created_by`, `customer_id`, `transaction_id`, `date_returned`, `sales_id`, `paid`, `no_of_days`) VALUES
(74, 10, '2018-02-09', 300, '2018-02-06 22:02:14', 5, 124, 'RE180206-0302', '2018-02-08', 113, 'Y', 3),
(75, 10, '2018-02-09', 200, '2018-02-07 17:44:46', 1, 124, 'RE180207-2944', '2018-02-08', 115, 'Y', 2),
(76, 11, '2018-02-10', 300, '2018-02-07 17:51:41', 1, 124, 'RE180207-5650', '2018-02-08', 116, 'Y', 3),
(77, 10, '2018-02-16', 900, '2018-02-07 18:11:40', 1, 124, 'RE180207-3011', '2018-02-08', 117, 'Y', 9),
(78, 12, '2018-02-13', 1200, '2018-02-07 18:42:34', 6, 125, 'RE180207-1042', '2018-02-08', 118, 'Y', 6),
(79, 10, '2018-02-10', 300, '2018-02-07 18:55:36', 1, 125, 'RE180207-1955', '2018-02-08', 119, 'Y', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sales_record`
--

CREATE TABLE `sales_record` (
  `sales_id` int(11) NOT NULL,
  `or_number` varchar(45) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `mode_of_payment` varchar(45) DEFAULT NULL,
  `date_save` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `printing_status` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_record`
--

INSERT INTO `sales_record` (`sales_id`, `or_number`, `total_amount`, `mode_of_payment`, `date_save`, `user_id`, `customer_id`, `printing_status`) VALUES
(112, '1242342311', 630, 'cash', '2018-02-06 22:00:56', 5, 124, 'Y'),
(113, 'RE98654435233', 300, 'cash', '2018-02-06 22:02:14', 1, 124, 'N'),
(114, '990075757665', 420, 'cash', '2018-02-06 22:22:28', 1, 124, 'N'),
(115, '23423422333', 200, 'cash', '2018-02-07 17:44:46', 1, 124, 'N'),
(116, '121232333', 300, 'cash', '2018-02-07 17:51:41', 1, 124, 'N'),
(117, '234242424', 900, 'cash', '2018-02-07 18:11:40', 1, 124, 'N'),
(118, '23424242', 1200, 'cash', '2018-02-07 18:42:34', 1, 125, 'N'),
(119, '34553535', 300, 'cash', '2018-02-07 18:55:36', 1, 125, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `sales_specific`
--

CREATE TABLE `sales_specific` (
  `sales_specific_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `or_number` int(11) DEFAULT NULL,
  `transaction_id` varchar(45) DEFAULT NULL,
  `paid` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_specific`
--

INSERT INTO `sales_specific` (`sales_specific_id`, `product_id`, `quantity`, `amount`, `or_number`, `transaction_id`, `paid`) VALUES
(14, 88, 3, 630, 112, '180206-1100', 'Y'),
(15, 89, 2, 420, 114, '180206-1222', 'Y');

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
(1, 'Rolly', 'Tereso', 'rolex', 'jã#ïÔ®í5NB¬¹Àp—', 'My CCF case number', 'Y', 'img/Christmas-Hat-PNG-HD.png', 1, '2017-12-19 17:47:37'),
(2, 'Sample', 'Sample', 'Sample', '96ÀžY‰ì:Wü¯D	‚', '098', 'Y', 'img/logo2.png', 2, '2018-01-18 22:34:41'),
(3, 'Joselito', 'Rojas', 'jose', 'ÃBFª×:DñdÃ4ÉO²} ', 'My CCF case number', 'Y', NULL, 5, '2018-01-26 17:32:37'),
(4, 'Wade', 'Lim', 'wade', 'v”×®%u¶pHÚ!:Ú', 'case number', 'Y', NULL, 3, '2018-01-31 16:51:14'),
(5, 'Darlyn', 'Rasonable', 'Darlyn', '½ª;ÇXèQ6J#ùø', '098', 'Y', NULL, 2, '2018-02-04 03:11:21'),
(6, 'Jomar', 'Delute', 'jomar', 'c­(¯kÙîâ¤ãÔ˜wåH', 'My CCF case number', 'Y', NULL, 2, '2018-02-07 18:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `msg` text,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `msg`, `created_on`, `user_id`) VALUES
(37, 'Logout', '2018-02-06 21:26:42', 1),
(38, 'Login', '2018-02-06 21:26:50', 5),
(39, 'Logout', '2018-02-06 21:27:12', 5),
(40, 'Login', '2018-02-06 21:27:19', 1),
(41, 'Logout', '2018-02-06 21:27:50', 1),
(42, 'Login', '2018-02-06 21:27:58', 5),
(43, 'Made product selection with transaction id: 180206-1100', '2018-02-06 22:00:56', 5),
(44, 'Made rental selection with transaction id: RE180206-0302', '2018-02-06 22:02:14', 5),
(45, 'Logout', '2018-02-06 22:06:07', 5),
(46, 'Login', '2018-02-06 22:09:36', 1),
(47, 'Login', '2018-02-06 22:16:15', 1),
(48, 'Saved payment for sales selection with OR number: 1242342311', '2018-02-06 22:18:28', 1),
(49, 'Made product selection with transaction id: 180206-1222', '2018-02-06 22:22:28', 1),
(50, 'Logout', '2018-02-06 22:40:07', 1),
(51, 'Login', '2018-02-06 22:40:14', 1),
(52, 'Logout', '2018-02-06 22:57:08', 1),
(53, 'Login', '2018-02-06 22:57:12', 1),
(54, 'Logout', '2018-02-06 22:57:17', 1),
(55, 'Login', '2018-02-06 22:57:24', 5),
(56, 'Login', '2018-02-07 14:18:53', 1),
(57, 'Logout', '2018-02-07 14:23:33', 1),
(58, 'Login', '2018-02-07 14:23:39', 5),
(59, 'Login', '2018-02-07 14:25:40', 3),
(60, 'Login', '2018-02-07 14:26:33', 1),
(61, 'Saved payment for rental selection with OR number: RE98654435233', '2018-02-07 14:27:50', 3),
(62, 'Saved payment for sales selection with OR number: 990075757665', '2018-02-07 14:34:31', 3),
(63, 'Logout', '2018-02-07 14:52:44', 5),
(64, 'Login', '2018-02-07 14:52:49', 1),
(65, 'Logout', '2018-02-07 14:54:17', 1),
(66, 'Logout', '2018-02-07 14:56:03', 1),
(67, 'Login', '2018-02-07 14:56:09', 5),
(68, 'Logout', '2018-02-07 15:12:45', 5),
(69, 'Login', '2018-02-07 15:12:51', 1),
(70, 'Logout', '2018-02-07 15:24:51', 1),
(71, 'Login', '2018-02-07 15:24:57', 5),
(72, 'Create rental item with an item code: 180209-2509, item name: Projector, item desc: Brand: Acer, Color: White, unit:set, rental fee: 100, status: Y, gate_pass=Y and rental fee per day: Y', '2018-02-07 15:26:05', 5),
(73, 'Edit rental item with an item code: 180225-0125, item name: Grass Cutter, item desc: Brand:Honda,Color: Red, unit:set, rental fee: 100, status: Y, gate_pass=Y and rental fee per day: Y', '2018-02-07 15:30:21', 5),
(74, 'Logout', '2018-02-07 17:13:50', 5),
(75, 'Login', '2018-02-07 17:13:54', 1),
(76, 'Made rental selection with transaction id: RE180207-2944', '2018-02-07 17:44:46', 1),
(77, 'Made rental selection with transaction id: RE180207-5650', '2018-02-07 17:51:41', 1),
(78, 'Saved payment for rental selection with OR number: 23423422333', '2018-02-07 18:02:54', 1),
(79, 'Saved payment for rental selection with OR number: 121232333', '2018-02-07 18:03:31', 1),
(80, 'Made rental selection with transaction id: RE180207-3011', '2018-02-07 18:11:40', 1),
(81, 'Login', '2018-02-07 18:19:23', 5),
(82, 'Logout', '2018-02-07 18:40:29', 5),
(83, 'Login', '2018-02-07 18:40:51', 6),
(84, 'Create rental item with an item code: 180214-4114, item name: Tractor, item desc: Brand: Honda, unit:item, rental fee: 200, status: Y, gate_pass=Y and rental fee per day: Y', '2018-02-07 18:41:46', 6),
(85, 'Made rental selection with transaction id: RE180207-1042', '2018-02-07 18:42:34', 6),
(86, 'Saved payment for rental selection with OR number: 23424242', '2018-02-07 18:44:42', 1),
(87, 'Logout', '2018-02-07 18:46:24', 6),
(88, 'Login', '2018-02-07 18:46:31', 5),
(89, 'Saved payment for rental selection with OR number: 234242424', '2018-02-07 18:47:02', 1),
(90, 'Made rental selection with transaction id: RE180207-1955', '2018-02-07 18:55:36', 1),
(91, 'Saved payment for rental selection with OR number: 34553535', '2018-02-07 20:15:34', 1),
(92, 'Logout', '2018-02-07 20:17:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `view_page` enum('Y','N','X') DEFAULT 'N',
  `view_command` enum('Y','N','X') DEFAULT 'N',
  `edit_command` enum('Y','N','X') DEFAULT 'N',
  `add_command` enum('Y','N','X') DEFAULT 'N',
  `delete_command` enum('Y','N','X') DEFAULT 'N',
  `save_changes` enum('Y','N','X') DEFAULT 'N',
  `edit_changes` enum('Y','N','X') DEFAULT 'N',
  `user_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role`, `module_id`, `view_page`, `view_command`, `edit_command`, `add_command`, `delete_command`, `save_changes`, `edit_changes`, `user_type_id`) VALUES
(345, 1, 'Y', 'X', 'X', 'Y', 'Y', 'Y', 'X', 1),
(346, 2, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 1),
(347, 3, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 1),
(348, 4, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 1),
(349, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 1),
(350, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 1),
(351, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 1),
(352, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 1),
(353, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 1),
(354, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 1),
(355, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 1),
(356, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 1),
(357, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 2),
(358, 2, 'Y', 'N', 'X', 'X', 'X', 'Y', 'X', 2),
(359, 3, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 2),
(360, 4, 'Y', 'N', 'Y', 'N', 'N', 'Y', 'Y', 2),
(361, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 2),
(362, 6, 'Y', 'N', 'X', 'X', 'X', 'Y', 'X', 2),
(363, 7, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 2),
(364, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 2),
(365, 9, 'Y', 'Y', 'Y', 'N', 'X', 'Y', 'Y', 2),
(366, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 2),
(367, 11, 'Y', 'N', 'X', 'Y', 'X', 'Y', 'X', 2),
(368, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 2),
(369, 1, 'Y', 'X', 'X', 'Y', 'Y', 'Y', 'X', 3),
(370, 2, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 3),
(371, 3, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 3),
(372, 4, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 3),
(373, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 3),
(374, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 3),
(375, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 3),
(376, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 3),
(377, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 3),
(378, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 3),
(379, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 3),
(380, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 3),
(393, 1, 'Y', 'X', 'X', 'Y', 'Y', 'Y', 'X', 4),
(394, 2, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 4),
(395, 3, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 4),
(396, 4, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 4),
(397, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 4),
(398, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 4),
(399, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 4),
(400, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 4),
(401, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 4),
(402, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 4),
(403, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 4),
(404, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 4),
(417, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 5),
(418, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 5),
(419, 3, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 5),
(420, 4, 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 5),
(421, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 5),
(422, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 5),
(423, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 5),
(424, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 5),
(425, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 5),
(426, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 5),
(427, 11, 'Y', 'N', 'X', 'Y', 'X', 'N', 'X', 5),
(428, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 5),
(429, 1, 'Y', 'X', 'X', 'Y', 'Y', 'Y', 'X', 7),
(430, 2, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 7),
(431, 3, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 7),
(432, 4, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 7),
(433, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 7),
(434, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 7),
(435, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 7),
(436, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 7),
(437, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 7),
(438, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 7),
(439, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 7),
(440, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 7),
(441, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 6),
(442, 2, 'Y', 'N', 'X', 'X', 'X', 'N', 'X', 6),
(443, 3, 'N', 'X', 'X', 'X', 'X', 'Y', 'X', 6),
(444, 4, 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 6),
(445, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 6),
(446, 6, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 6),
(447, 7, 'N', 'N', 'X', 'X', 'X', 'X', 'X', 6),
(448, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 6),
(449, 9, 'Y', 'N', 'N', 'N', 'X', 'Y', 'Y', 6),
(450, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 6),
(451, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 6),
(452, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type` varchar(45) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type`, `status`) VALUES
(1, 'Administrator', 'Y'),
(2, 'Project Head', 'Y'),
(3, 'Campus Dean', 'Y'),
(4, 'Accounting', 'Y'),
(5, 'Cashier', 'Y'),
(6, 'Supply Officer', 'Y'),
(7, 'IGP Director', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `c_name` (`customer_name`,`customer_address`);

--
-- Indexes for table `expenses_breakdown`
--
ALTER TABLE `expenses_breakdown`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_proj_idx` (`purchase_request_id`);

--
-- Indexes for table `location_marks`
--
ALTER TABLE `location_marks`
  ADD PRIMARY KEY (`id_marks`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `owner_info`
--
ALTER TABLE `owner_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `sub_prod_idx` (`project_id`),
  ADD KEY `fuser_idx` (`created_by`),
  ADD KEY `fprice_idx` (`product_price`),
  ADD KEY `product_name` (`product_name`);

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
  ADD UNIQUE KEY `project_name_UNIQUE` (`project_name`),
  ADD KEY `f_userk_idx` (`created_by`);

--
-- Indexes for table `project_budget`
--
ALTER TABLE `project_budget`
  ADD PRIMARY KEY (`project_budget_id`),
  ADD KEY `fkproject_idx` (`project_id`);

--
-- Indexes for table `project_duration`
--
ALTER TABLE `project_duration`
  ADD PRIMARY KEY (`project_duration_id`),
  ADD KEY `fk_usser_idx` (`created_by`),
  ADD KEY `fk_project_idx` (`project_id`);

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`purchase_request_id`),
  ADD KEY `fk_proj_idx` (`project_duration_id`),
  ADD KEY `fk_user_idx` (`created_by`);

--
-- Indexes for table `rental_items`
--
ALTER TABLE `rental_items`
  ADD PRIMARY KEY (`rental_id`),
  ADD UNIQUE KEY `item_code_UNIQUE` (`item_code`);

--
-- Indexes for table `rental_specific`
--
ALTER TABLE `rental_specific`
  ADD PRIMARY KEY (`rental_specific_id`),
  ADD KEY `fkusers_idx` (`created_by`),
  ADD KEY `fk_id_idx` (`rental_id`),
  ADD KEY `fkcustomer_idx` (`customer_id`),
  ADD KEY `fkor_idx` (`sales_id`),
  ADD KEY `updated_onidx` (`updated_on`);

--
-- Indexes for table `sales_record`
--
ALTER TABLE `sales_record`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `fk_customer_idx` (`customer_id`),
  ADD KEY `fuserId_idx` (`user_id`),
  ADD KEY `date_saveidx` (`date_save`);

--
-- Indexes for table `sales_specific`
--
ALTER TABLE `sales_specific`
  ADD PRIMARY KEY (`sales_specific_id`),
  ADD KEY `fk_pro_idx` (`product_id`),
  ADD KEY `fk_sale_idx` (`or_number`),
  ADD KEY `amount` (`amount`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_user_type_idx` (`user_type`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`),
  ADD KEY `fk_user_id_idx` (`user_id`),
  ADD KEY `date` (`created_on`,`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role`),
  ADD KEY `fkuser_type_idx` (`user_type_id`),
  ADD KEY `fkmodule_idx` (`module_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `expenses_breakdown`
--
ALTER TABLE `expenses_breakdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `location_marks`
--
ALTER TABLE `location_marks`
  MODIFY `id_marks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `owner_info`
--
ALTER TABLE `owner_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `project_budget`
--
ALTER TABLE `project_budget`
  MODIFY `project_budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- AUTO_INCREMENT for table `project_duration`
--
ALTER TABLE `project_duration`
  MODIFY `project_duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `purchase_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rental_specific`
--
ALTER TABLE `rental_specific`
  MODIFY `rental_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses_breakdown`
--
ALTER TABLE `expenses_breakdown`
  ADD CONSTRAINT `pk_proj` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_request` (`purchase_request_id`);

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
-- Constraints for table `project_budget`
--
ALTER TABLE `project_budget`
  ADD CONSTRAINT `fkproject` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `project_duration`
--
ALTER TABLE `project_duration`
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `fk_usser` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD CONSTRAINT `fk_proj_duration` FOREIGN KEY (`project_duration_id`) REFERENCES `project_duration` (`project_duration_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rental_specific`
--
ALTER TABLE `rental_specific`
  ADD CONSTRAINT `fk_id` FOREIGN KEY (`rental_id`) REFERENCES `rental_items` (`rental_id`),
  ADD CONSTRAINT `fkcustomer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fkor` FOREIGN KEY (`sales_id`) REFERENCES `sales_record` (`sales_id`),
  ADD CONSTRAINT `fkusers` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

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

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`user_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fkmodule` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`),
  ADD CONSTRAINT `fkuser_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
