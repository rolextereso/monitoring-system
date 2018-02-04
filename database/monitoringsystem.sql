-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2018 at 05:21 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

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
CREATE DEFINER=`root`@`localhost` FUNCTION `report_product_by_month_year` (`product_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
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

CREATE DEFINER=`root`@`localhost` FUNCTION `report_project_by_month_year` (`project_id` INT, `date_save` DATE) RETURNS FLOAT BEGIN
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

CREATE DEFINER=`root`@`localhost` FUNCTION `report_rental_by_month_year` (`rental_id_` INT, `date_save` DATE) RETURNS FLOAT BEGIN
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
(27, 'rolex', 'ambacon'),
(28, 'rolex', 'Ambacon'),
(29, 'sfs', 'sf'),
(30, 'c', 'c'),
(31, 'g', 'g'),
(32, 'hb', 'bd'),
(33, 'd', 'd'),
(34, 's', 's'),
(35, 'f', 'f'),
(36, 'sdfs', 'sdf'),
(37, 'd', 'd'),
(38, 'dfdf', 'sdf'),
(39, 'df', 'df'),
(40, 'x', 'x'),
(41, 'd', 'd'),
(42, 'Rolex', 'Ambacon'),
(43, 'Christine', 'Silago'),
(44, 'xxx', 'xxx'),
(45, 'd', 'd'),
(46, 'cddd', 'c'),
(47, 'd', 'd'),
(48, 'g', 'g'),
(49, 'sfd', 'sdf'),
(50, 't', 't'),
(51, 't', 't'),
(52, 'y', 'y'),
(53, 'y', 'y'),
(59, 'd', 'd'),
(61, 'df', 'df'),
(62, 'g', 'g'),
(63, 'g', 'g'),
(64, 's', 's'),
(65, 's', 's'),
(66, 's', 's'),
(67, 's', 's'),
(68, 's', 's'),
(69, 'd', 'd'),
(70, 's', 's'),
(71, 'f', 'f'),
(72, 'f', 'f'),
(73, 's', 's'),
(74, 'xxxxx', 'xxxx'),
(75, 'sss', 'sss'),
(76, 'sss', 'sss'),
(77, 'sss', 'sss'),
(78, 'hhh', 'hh'),
(79, 's', 's'),
(80, 'f', 'f'),
(81, 's', 's'),
(82, 's', 'df'),
(83, 's', 'df'),
(84, 'f', 'd'),
(85, 'df', 'df'),
(86, 'df', 'dd'),
(87, 'gs', 'gs'),
(88, 'df', 'df'),
(89, 'fgf', 'fgfgf'),
(90, 'ddd', 'ddd'),
(91, 'ghgh', 'ghgh'),
(92, 'ddfd', 'dfdf'),
(93, 'sss', 'sss'),
(94, 'gggg', 'ggg'),
(95, 'sdf', 'dfs'),
(96, 'Rolly', 'Ambacon'),
(97, 'sample', 'sample'),
(98, 'sample', 'sample'),
(99, 'rs', 'rs'),
(100, 'sdf', 'sf'),
(101, 'f', 'f'),
(102, 'ssf', 'sdf'),
(103, 'sx', 'sx'),
(104, 'rolex', 'ambacom'),
(105, 'rental', 'retnal'),
(106, 'CX', 'CX'),
(107, 'sf', 'sf');

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
(3, '3424242', 'Grass cutter', 2, 1000, 'Set', 4),
(4, '24344342', 'Abuno', 1, 1000, 'Sack', 4),
(6, NULL, 'Abuno', 2, NULL, 'Sack', 5),
(7, '54674343443', 'Grass cutter', 2, 13000, 'pc', 6),
(8, '2342423324', 'Abuno', 12, 1000, 'Sack', 6),
(9, '2342234344465', 'Vermi Worm', 4, 100, 'kg', 7),
(10, NULL, 'Abuno', 3, NULL, '1', 8);

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
(5, ' top:572px;left:641px', 'img/location_map_pic/buley-library.jpeg', 'Administration Building'),
(7, ' top:713px;left:696px', 'img/location_map_pic/social_hall.jpg', 'Social Hall'),
(9, ' top:733px;left:610px', 'img/location_map_pic/buley-library.jpeg', 'Supply Office'),
(10, ' top:450px;left:546px', 'img/location_map_pic/social_hall.jpg', 'HomeTech Building');

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
(71, 'Product 1', 86, '2018-01-30 18:16:07', 1, 23, 'kg', 'Y', '18-01300716', 'Y'),
(72, 'Product 2', 87, '2018-01-30 18:16:07', 1, 23, 'kg', 'Y', '18-01300716', 'Y'),
(73, 'Product 3', 88, '2018-01-30 18:16:07', 1, 23, 'kg', 'Y', '18-01300716', 'Y'),
(77, 'Charcoal', 92, '2018-02-01 15:34:13', 1, 23, 'kg', 'Y', '18-02011334', ''),
(78, 'Coconut Seedling', 93, '2018-02-01 15:34:13', 1, 23, 'pcs', 'Y', '18-02011334', 'Y'),
(79, 'Product 3', 94, '2018-02-01 15:34:13', 1, 23, 'pcs', 'Y', '18-02011334', ''),
(80, 'Vermi Waste', 95, '2018-02-01 18:00:21', 1, 24, 'kg', 'Y', '18-02012100', ''),
(81, 'Vermi Worm', 96, '2018-02-01 18:00:21', 1, 24, 'kg', 'Y', '18-02012100', 'Y'),
(82, 'Pineapple(small)', 97, '2018-02-04 03:31:50', 5, 25, 'kg', 'Y', '18-02045031', 'Y'),
(83, 'Pineapple(medium)', 98, '2018-02-04 03:31:50', 5, 25, 'kg', 'Y', '18-02045031', 'Y'),
(84, 'Pineapple(Large)', 99, '2018-02-04 03:31:50', 5, 25, 'kg', 'Y', '18-02045031', 'Y');

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
(19, 10, '2018-01-08 14:55:39', 1),
(23, 10, '2018-01-08 18:18:16', 1),
(24, 10, '2018-01-08 18:18:16', 1),
(25, 10, '2018-01-08 18:18:16', 1),
(26, 10, '2018-01-11 14:34:34', 1),
(27, 10, '2018-01-11 14:34:34', 1),
(28, 10, '2018-01-11 14:34:34', 1),
(29, 10, '2018-01-12 16:45:45', 1),
(30, 10, '2018-01-12 16:45:45', 1),
(31, 10, '2018-01-12 16:45:45', 1),
(32, 10, '2018-01-12 16:48:50', 1),
(33, 10, '2018-01-12 16:48:50', 1),
(34, 10, '2018-01-12 16:48:50', 1),
(35, 10, '2018-01-12 16:54:20', 1),
(36, 10, '2018-01-12 16:54:20', 1),
(37, 10, '2018-01-12 16:54:20', 1),
(38, 10, '2018-01-12 17:54:37', 1),
(39, 10, '2018-01-12 17:54:37', 1),
(40, 10, '2018-01-12 17:54:37', 1),
(50, 10, '2018-01-12 18:16:08', 1),
(51, 10, '2018-01-12 18:16:08', 1),
(52, 10, '2018-01-12 18:16:08', 1),
(56, 10, '2018-01-12 18:19:37', 1),
(57, 10, '2018-01-12 18:19:37', 1),
(58, 10, '2018-01-12 18:19:37', 1),
(59, 0, '2018-01-12 18:21:43', 1),
(60, 0, '2018-01-12 18:21:43', 1),
(61, 0, '2018-01-12 18:21:43', 1),
(62, 10, '2018-01-12 18:26:52', 1),
(63, 10, '2018-01-12 18:26:52', 1),
(64, 10, '2018-01-12 18:26:52', 1),
(65, 10, '2018-01-12 18:29:31', 1),
(66, 10, '2018-01-12 18:29:31', 1),
(67, 10, '2018-01-12 18:29:31', 1),
(68, 10, '2018-01-12 18:30:41', 1),
(69, 10, '2018-01-12 18:30:41', 1),
(70, 10, '2018-01-12 18:30:41', 1),
(71, 10, '2018-01-12 18:31:53', 1),
(72, 10, '2018-01-12 18:31:53', 1),
(73, 10, '2018-01-12 18:31:53', 1),
(77, 10, '2018-01-30 16:07:25', 1),
(78, 10, '2018-01-30 16:07:25', 1),
(79, 10, '2018-01-30 16:07:25', 1),
(83, 10, '2018-01-30 16:32:21', 1),
(84, 10, '2018-01-30 16:32:21', 1),
(85, 10, '2018-01-30 16:32:21', 1),
(86, 10, '2018-01-30 18:16:07', 1),
(87, 10, '2018-01-30 18:16:07', 1),
(88, 10, '2018-01-30 18:16:07', 1),
(89, 10, '2018-02-01 15:31:31', 1),
(90, 10, '2018-02-01 15:31:31', 1),
(91, 10, '2018-02-01 15:31:31', 1),
(92, 10, '2018-02-01 15:34:13', 1),
(93, 100, '2018-02-01 15:34:13', 1),
(94, 10, '2018-02-01 15:34:13', 1),
(95, 30, '2018-02-01 18:00:21', 1),
(96, 130, '2018-02-01 18:00:21', 1),
(97, 100, '2018-02-04 03:31:50', 5),
(98, 150, '2018-02-04 03:31:50', 5),
(99, 200, '2018-02-04 03:31:50', 5);

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
(23, 'Agricultural', 'Coconut', '                                        ', 'Y', 1, '2018-01-30 18:16:07', 1),
(24, 'Agricultural', 'Vermi', 'Vermiculture Production                      ', 'Y', 1, '2018-02-01 18:00:21', 1),
(25, 'Agricultural', 'Pineapple', 'DA project for pineapple                     ', 'Y', 5, '2018-02-04 03:31:50', 5);

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
(201, '18-01300716', 23, 'Product 1 (production costs)', 10, 'N', 1, '2018-01-30 18:16:07'),
(202, '18-01300716', 23, 'Product 2 (production costs)', 0, 'N', 1, '2018-01-30 18:16:07'),
(203, '18-01300716', 23, 'Product 3 (production costs)', 0, 'N', 1, '2018-01-30 18:16:07'),
(204, '18-01300716', 23, 'Marketing Expenses ', 10, 'N', 1, '2018-01-30 18:16:07'),
(205, '18-01300716', 23, 'Other Marketing Expenses ', 0, 'N', 1, '2018-01-30 18:16:07'),
(206, '18-01300716', 23, 'Other Related Marketing Expenses ', 0, 'N', 1, '2018-01-30 18:16:07'),
(207, '18-01300716', 23, 'Salaries other than Labor ', 0, 'N', 1, '2018-01-30 18:16:07'),
(208, '18-01300716', 23, 'Other Administrative Expenses ', 0, 'N', 1, '2018-01-30 18:16:07'),
(209, '18-01300716', 23, 'Registration, Fees, Licenses ', 0, 'N', 1, '2018-01-30 18:16:07'),
(210, '18-01300716', 23, 'Others ', 0, 'N', 1, '2018-01-30 18:16:07'),
(211, '18-02013131', 23, 'Product 1 (production costs)', 10, 'N', 1, '2018-02-01 15:31:31'),
(212, '18-02013131', 23, 'Product 2 (production costs)', 10, 'N', 1, '2018-02-01 15:31:31'),
(213, '18-02013131', 23, 'Product 3 (production costs)', 10, 'N', 1, '2018-02-01 15:31:31'),
(214, '18-02013131', 23, 'Marketing Expenses ', 101, 'N', 1, '2018-02-01 15:31:31'),
(215, '18-02013131', 23, 'Other Marketing Expenses ', 10, 'N', 1, '2018-02-01 15:31:31'),
(216, '18-02013131', 23, 'Other Related Marketing Expenses ', 10, 'N', 1, '2018-02-01 15:31:31'),
(217, '18-02013131', 23, 'Salaries other than Labor ', 10, 'N', 1, '2018-02-01 15:31:31'),
(218, '18-02013131', 23, 'Other Administrative Expenses ', 10, 'N', 1, '2018-02-01 15:31:31'),
(219, '18-02013131', 23, 'Registration, Fees, Licenses ', 10, 'N', 1, '2018-02-01 15:31:31'),
(220, '18-02013131', 23, 'Others ', 10, 'N', 1, '2018-02-01 15:31:31'),
(221, '18-02011334', 23, 'Charcoal (production costs)', 100, 'N', 1, '2018-02-01 15:34:13'),
(222, '18-02011334', 23, 'Coconut Seedling (production costs)', 1000, 'N', 1, '2018-02-01 15:34:13'),
(223, '18-02011334', 23, 'Product 3 (production costs)', 10, 'N', 1, '2018-02-01 15:34:13'),
(224, '18-02011334', 23, 'Marketing Expenses ', 10, 'N', 1, '2018-02-01 15:34:13'),
(225, '18-02011334', 23, 'Other Marketing Expenses ', 10, 'N', 1, '2018-02-01 15:34:13'),
(226, '18-02011334', 23, 'Other Related Marketing Expenses ', 10, 'N', 1, '2018-02-01 15:34:13'),
(227, '18-02011334', 23, 'Salaries other than Labor ', 10, 'N', 1, '2018-02-01 15:34:13'),
(228, '18-02011334', 23, 'Other Administrative Expenses ', 10, 'N', 1, '2018-02-01 15:34:13'),
(229, '18-02011334', 23, 'Registration, Fees, Licenses ', 10, 'N', 1, '2018-02-01 15:34:13'),
(230, '18-02011334', 23, 'Others ', 10, 'N', 1, '2018-02-01 15:34:13'),
(231, '18-02012100', 24, 'Vermi Waste (production costs)', 4000, 'N', 1, '2018-02-01 18:00:21'),
(232, '18-02012100', 24, 'Vermi Worm (production costs)', 3000, 'N', 1, '2018-02-01 18:00:21'),
(233, '18-02012100', 24, 'Marketing Expenses ', 100, 'N', 1, '2018-02-01 18:00:21'),
(234, '18-02012100', 24, 'Other Marketing Expenses ', 100, 'N', 1, '2018-02-01 18:00:21'),
(235, '18-02012100', 24, 'Other Related Marketing Expenses ', 100, 'N', 1, '2018-02-01 18:00:21'),
(236, '18-02012100', 24, 'Salaries other than Labor ', 190, 'N', 1, '2018-02-01 18:00:21'),
(237, '18-02012100', 24, 'Other Administrative Expenses ', 0, 'N', 1, '2018-02-01 18:00:21'),
(238, '18-02012100', 24, 'Registration, Fees, Licenses ', 0, 'N', 1, '2018-02-01 18:00:21'),
(239, '18-02012100', 24, 'Others ', 0, 'N', 1, '2018-02-01 18:00:21'),
(240, '18-02045031', 25, 'Pineapple(small) (production costs)', 1000, 'N', 5, '2018-02-04 03:31:50'),
(241, '18-02045031', 25, 'Pineapple(medium) (production costs)', 1000, 'N', 5, '2018-02-04 03:31:50'),
(242, '18-02045031', 25, 'Pineapple(Large) (production costs)', 1000, 'N', 5, '2018-02-04 03:31:50'),
(243, '18-02045031', 25, 'Marketing Expenses ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(244, '18-02045031', 25, 'Other Marketing Expenses ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(245, '18-02045031', 25, 'Other Related Marketing Expenses ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(246, '18-02045031', 25, 'Salaries other than Labor ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(247, '18-02045031', 25, 'Other Administrative Expenses ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(248, '18-02045031', 25, 'Registration, Fees, Licenses ', 1000, 'N', 5, '2018-02-04 03:31:50'),
(249, '18-02045031', 25, 'Others ', 1000, 'N', 5, '2018-02-04 03:31:50');

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
(2, '18-01300716', '2018-01-01', '2018-01-31', 1, '2018-01-30 18:16:07', 'N', 23),
(4, '18-02011334', '2018-02-01', '2018-05-31', 1, '2018-02-01 15:34:13', 'Y', 23),
(5, '18-02012100', '2018-02-01', '2018-04-30', 1, '2018-02-01 18:00:21', 'Y', 24),
(6, '18-02045031', '2018-02-01', '2018-07-31', 5, '2018-02-04 03:31:50', 'Y', 25);

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
(4, 'Southern Leyte State University', 2, 'For Coconut use', '2018-01-30 21:08:28', 1, 'Y', '180152-0352', '2018-02-03 00:49:20'),
(5, 'Southern Leyte State University', 2, 'For Coconut Use', '2018-02-02 16:10:54', 1, 'Y', '180242-3742', NULL),
(6, 'Southern Leyte State University', 4, 'For coconut', '2018-02-01 16:57:18', 1, 'Y', '180232-5632', NULL),
(7, 'Southern Leyte State University', 5, 'For Production of Worm', '2018-02-01 18:45:06', 1, 'Y', '180233-4433', NULL),
(8, 'Southern Leyte State University', 4, 'For coconut use only', '2018-02-04 02:53:22', 3, 'Y', '180230-5230', '2018-02-03 19:00:05');

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
(4, 'Tractor', '180106-4206', 'Blue                                                                                   ', 100, 'set', 'Y', 'N', 1, 'Y', 'N', 'RE180202-3713'),
(6, 'Tractor', '180109-4209', 'Red', 100, 'Set', 'N', 'Y', 1, 'Y', 'Y', ''),
(7, 'Grass cutter', '180126-4126', 'Silver(honda brand)', 100, 'set', 'Y', 'Y', 1, 'Y', 'Y', ''),
(8, 'Screw Driver', '180139-3739', 'Yellow', 20, 'set', 'Y', 'Y', 1, 'Y', 'N', 'RE180201-5538'),
(9, 'Projector', '180214-2614', 'Acer Brand(white)', 200, 'pcs', 'Y', 'Y', 5, 'Y', 'N', 'RE180204-1515');

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
(50, 7, '2018-02-09', 800, '2018-02-01 20:28:18', 1, 100, 'RE180201-5827', '2018-02-02', 81, 'Y', 8),
(51, 8, '2018-02-03', 40, '2018-02-01 22:39:13', 1, 101, 'RE180201-5538', NULL, 82, 'Y', 2),
(52, 7, '2018-02-03', 200, '2018-02-02 14:21:25', 1, 102, 'RE180202-1021', '2018-02-03', 83, 'Y', 2),
(53, 6, '2018-02-07', 100, '2018-02-02 15:11:12', 1, 104, 'RE180202-4210', '2018-02-02', 85, 'Y', 6),
(54, 4, '2018-02-03', 200, '2018-02-02 15:11:12', 1, 104, 'RE180202-4210', '2018-02-02', 85, 'Y', 2),
(55, 4, '2018-02-10', 900, '2018-02-02 15:14:10', 1, 105, 'RE180202-3713', NULL, 86, 'Y', 9),
(56, 9, '2018-02-14', 2400, '2018-02-04 04:15:27', 5, 107, 'RE180204-1515', NULL, 88, 'N', 12);

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
(77, '89088668', 10000, 'cash', '2018-02-01 16:21:43', 1, 96, 'N'),
(78, '686865464646', 100, 'cash', '2018-02-01 17:18:09', 1, 97, 'N'),
(79, '1322342424', 1000, 'cash', '2018-03-01 17:21:53', 1, 98, 'Y'),
(80, '353534434', 360, 'cash', '2018-02-01 20:07:50', 1, 99, 'N'),
(81, '24242424242', 800, 'cash', '2018-02-01 20:28:18', 1, 100, 'N'),
(82, '112131111', 40, 'cash', '2018-02-01 22:39:13', 1, 101, 'N'),
(83, '2323232', 200, 'cash', '2018-02-02 14:21:25', 1, 102, 'Y'),
(84, '23224324', 300, 'cash', '2018-02-02 14:54:20', 1, 103, 'N'),
(85, '111111111111', 300, 'cash', '2018-02-02 15:11:12', 1, 104, 'Y'),
(86, '22222222222', 900, 'cash', '2018-02-02 15:14:10', 1, 105, 'N'),
(87, '', 10, '', '2018-02-04 01:55:50', 1, 106, 'N'),
(88, '', 2400, '', '2018-02-04 04:15:27', 1, 107, 'N');

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
(1, 78, 100, 10000, 77, '180201-2221', 'Y'),
(2, 77, 10, 100, 78, '180201-4917', 'Y'),
(3, 78, 10, 1000, 79, '180201-3321', 'Y'),
(4, 80, 12, 360, 80, '180201-3407', 'Y'),
(5, 80, 10, 300, 84, '180202-5153', 'Y'),
(6, 77, 1, 10, 87, '180204-3355', 'N');

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
(1, 'Rolly', 'Tereso', 'rolex', 'jã#ïÔ®í5NB¬¹Àp—', 'My Case Number', 'Y', 'img/Christmas-Hat-PNG-HD.png', 1, '2017-12-19 17:47:37'),
(2, 'Sample', 'Sample', 'Sample', '96ÀžY‰ì:Wü¯D	‚', '098', 'Y', 'img/logo2.png', 2, '2018-01-18 22:34:41'),
(3, 'Joselito', 'Rojas', 'jose', 'ÃBFª×:DñdÃ4ÉO²} ', 'My CCF case number', 'Y', NULL, 5, '2018-01-26 17:32:37'),
(4, 'Wade', 'Lim', 'wade', 'v”×®%u¶pHÚ!:Ú', 'case number', 'Y', NULL, 3, '2018-01-31 16:51:14'),
(5, 'Darlyn`', 'Rasonable', 'Darlyn', '½ª;ÇXèQ6J#ùø', '098', 'Y', NULL, 2, '2018-02-04 03:11:21');

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
(363, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 2),
(364, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 2),
(365, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 2),
(366, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 2),
(367, 11, 'Y', 'Y', 'X', 'Y', 'X', 'Y', 'X', 2),
(368, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 2),
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
(419, 3, 'Y', 'X', 'X', 'X', 'X', 'N', 'X', 5),
(420, 4, 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 5),
(421, 5, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 5),
(422, 6, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 5),
(423, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 5),
(424, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 5),
(425, 9, 'Y', 'Y', 'Y', 'Y', 'X', 'Y', 'Y', 5),
(426, 10, 'Y', 'X', 'X', 'X', 'X', 'Y', 'X', 5),
(427, 11, 'Y', 'N', 'X', 'Y', 'X', 'N', 'X', 5),
(428, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 5),
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
(440, 12, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 7);

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
  ADD PRIMARY KEY (`customer_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `expenses_breakdown`
--
ALTER TABLE `expenses_breakdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location_marks`
--
ALTER TABLE `location_marks`
  MODIFY `id_marks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `project_budget`
--
ALTER TABLE `project_budget`
  MODIFY `project_budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `project_duration`
--
ALTER TABLE `project_duration`
  MODIFY `project_duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `purchase_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rental_specific`
--
ALTER TABLE `rental_specific`
  MODIFY `rental_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

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
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fkmodule` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`),
  ADD CONSTRAINT `fkuser_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
