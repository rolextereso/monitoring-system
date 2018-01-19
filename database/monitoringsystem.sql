-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2018 at 12:08 AM
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
(95, 'sdf', 'dfs');

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
  `project_specific_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `created_on`, `created_by`, `project_id`, `unit_of_measurement`, `product_status`, `project_specific_id`) VALUES
(1, 'Coconut Seedling', 1, '2017-12-15 14:18:40', NULL, 1, 'Seedling', 'Y', NULL),
(2, 'Vinegar/Suka', 2, '2017-12-15 14:19:30', NULL, 1, 'Gallon', 'N', NULL),
(3, 'Charcoal', 3, '2017-12-18 14:26:56', NULL, 1, 'Taro', 'N', NULL),
(4, 'Bunot', 4, '2017-12-18 14:27:19', NULL, 1, 'pieces', 'N', NULL),
(5, 'Lukay', 5, '2017-12-18 14:27:59', NULL, 1, 'pieces', 'N', NULL),
(6, 'bagol', 6, '2017-12-18 14:28:26', NULL, 1, 'pieces', 'Y', NULL),
(7, 'Vermi Worm', 7, '2017-12-18 14:31:34', NULL, 3, 'kilo', 'Y', NULL),
(8, 'Vermi Compost', 8, '2017-12-18 14:38:06', NULL, 3, 'kilo', 'Y', NULL),
(9, 'Vermi mud', 9, '2017-12-18 14:39:27', NULL, 3, 'kilo', 'Y', NULL),
(10, 'Goat Meat', 10, '2017-12-18 22:57:44', NULL, 4, 'kilo', 'Y', NULL),
(17, 'Product 1', 17, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y', NULL),
(18, 'Product 2', 18, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y', NULL),
(19, 'Product 3', 19, '2018-01-08 14:55:39', 1, 8, 'kg', 'Y', NULL),
(23, 'Product 1', 23, '2018-01-08 18:18:16', 1, 10, 'g', 'Y', NULL),
(24, 'Product 2', 24, '2018-01-08 18:18:16', 1, 10, 'g', 'Y', NULL),
(25, 'Product 3', 25, '2018-01-08 18:18:16', 1, 10, 'g', 'Y', NULL),
(26, 'Product 1', 26, '2018-01-11 14:34:34', 1, 11, 'Kg', 'Y', NULL),
(27, 'Product 2', 27, '2018-01-11 14:34:34', 1, 11, 'kg', 'Y', NULL),
(28, 'Product 3', 28, '2018-01-11 14:34:34', 1, 11, 'kg', 'Y', NULL),
(29, 'Product 1', 29, '2018-01-12 16:45:45', 1, 11, 'kg', 'Y', NULL),
(30, 'Product 2', 30, '2018-01-12 16:45:45', 1, 11, 'kg', 'Y', NULL),
(31, 'Product 3', 31, '2018-01-12 16:45:45', 1, 11, 'kg', 'Y', NULL),
(32, 'Product 1', 32, '2018-01-12 16:48:50', 1, 11, 'g', 'Y', NULL),
(33, 'Product 2', 33, '2018-01-12 16:48:50', 1, 11, 'g', 'Y', NULL),
(34, 'Product 3', 34, '2018-01-12 16:48:50', 1, 11, 'g', 'Y', NULL),
(35, 'Product 1', 35, '2018-01-12 16:54:20', 1, 11, 'kg', 'Y', NULL),
(36, 'Product 2', 36, '2018-01-12 16:54:20', 1, 11, 'kg', 'Y', NULL),
(37, 'Product 3', 37, '2018-01-12 16:54:20', 1, 11, 'kg', 'Y', NULL),
(50, 'Product 1', 50, '2018-01-12 18:16:08', 1, 15, '', 'Y', '18-01120816'),
(51, 'Product 2', 51, '2018-01-12 18:16:08', 1, 15, '', 'Y', '18-01120816'),
(52, 'Product 3', 52, '2018-01-12 18:16:08', 1, 15, '', 'Y', '18-01120816'),
(59, 'Product 1', 59, '2018-01-12 18:21:43', 1, 18, '', 'Y', '18-01124321'),
(60, 'Product 2', 60, '2018-01-12 18:21:43', 1, 18, '', 'Y', '18-01124321'),
(61, 'Product 3', 61, '2018-01-12 18:21:43', 1, 18, '', 'Y', '18-01124321');

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
(73, 10, '2018-01-12 18:31:53', 1);

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
(1, 'Non-Agricultural', 'Coconut', '                                             ', 'Y', 1, '2017-12-15 14:17:37', NULL),
(2, NULL, 'Vinegar', 'This is a project of DA                      ', 'Y', 1, '2017-12-15 14:18:20', NULL),
(3, NULL, 'Vermi', '                                             ', 'Y', 1, '2017-12-18 14:30:00', NULL),
(4, 'Agricultural', 'Goats', '                                             ', 'Y', 1, '2017-12-18 14:30:58', NULL),
(5, NULL, 's', '                                             ', 'Y', 1, '2017-12-18 15:30:20', NULL),
(8, NULL, 'Kuhol', '                                        ', 'Y', 1, '2018-01-08 14:55:39', NULL),
(10, 'Agricultural', 'sample', '                                        ', 'Y', 1, '2018-01-08 18:18:16', NULL),
(11, 'Agricultural', 'Samento', '                                        ', 'Y', 1, '2018-01-11 14:34:34', NULL),
(15, 'Agricultural', 'Coffee', '                                        ', 'Y', 1, '2018-01-12 18:16:08', NULL),
(17, 'Agricultural', 'd', '                                        ', 'Y', 1, '2018-01-12 18:19:37', NULL),
(18, 'Agricultural', 'f', '                                        ', 'Y', 1, '2018-01-12 18:21:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_duration`
--

CREATE TABLE `project_duration` (
  `project_duration_id` int(11) NOT NULL,
  `project_specific_id` varchar(45) DEFAULT NULL,
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

INSERT INTO `project_duration` (`project_duration_id`, `project_specific_id`, `project_id`, `description`, `month`, `amount`, `release`, `created_by`, `created_on`) VALUES
(1, '18-01081612', 8, 'Product 1', '2018-01-07', 10, 'N', 1, '2018-01-08 14:55:39'),
(2, '18-01081612', 8, 'Product 2', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(3, '18-01081612', 8, 'Product 3', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(4, '18-01081612', 8, 'Marketing Expenses', '2018-01-07', 10, 'N', 1, '2018-01-08 14:55:39'),
(5, '18-01081612', 8, 'Other Marketing Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(6, '18-01081612', 8, 'Other Related Marketing Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(7, '18-01081612', 8, 'Salaries other than Labor', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(8, '18-01081612', 8, 'Other Administrative Expenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(9, '18-01081612', 8, 'Registration, Fees, Licenses', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(10, '18-01081612', 8, 'Others', '2018-01-07', 0, 'N', 1, '2018-01-08 14:55:39'),
(21, '18-01113434', 11, 'Product 1', '2017-10-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(22, '18-01113434', 11, 'Product 1', '2017-11-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(23, '18-01113434', 11, 'Product 1', '2017-12-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(24, '18-01113434', 11, 'Product 1', '2018-01-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(25, '18-01113434', 11, 'Product 2', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(26, '18-01113434', 11, 'Product 2', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(27, '18-01113434', 11, 'Product 2', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(28, '18-01113434', 11, 'Product 2', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(29, '18-01113434', 11, 'Product 3', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(30, '18-01113434', 11, 'Product 3', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(31, '18-01113434', 11, 'Product 3', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(32, '18-01113434', 11, 'Product 3', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(33, '18-01113434', 11, 'Marketing Expenses', '2017-10-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(34, '18-01113434', 11, 'Marketing Expenses', '2017-11-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(35, '18-01113434', 11, 'Marketing Expenses', '2017-12-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(36, '18-01113434', 11, 'Marketing Expenses', '2018-01-01', 10, 'N', 1, '2018-01-11 14:34:34'),
(37, '18-01113434', 11, 'Other Marketing Expenses', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(38, '18-01113434', 11, 'Other Marketing Expenses', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(39, '18-01113434', 11, 'Other Marketing Expenses', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(40, '18-01113434', 11, 'Other Marketing Expenses', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(41, '18-01113434', 11, 'Other Related Marketing Expenses', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(42, '18-01113434', 11, 'Other Related Marketing Expenses', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(43, '18-01113434', 11, 'Other Related Marketing Expenses', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(44, '18-01113434', 11, 'Other Related Marketing Expenses', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(45, '18-01113434', 11, 'Salaries other than Labor', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(46, '18-01113434', 11, 'Salaries other than Labor', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(47, '18-01113434', 11, 'Salaries other than Labor', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(48, '18-01113434', 11, 'Salaries other than Labor', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(49, '18-01113434', 11, 'Other Administrative Expenses', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(50, '18-01113434', 11, 'Other Administrative Expenses', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(51, '18-01113434', 11, 'Other Administrative Expenses', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(52, '18-01113434', 11, 'Other Administrative Expenses', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(53, '18-01113434', 11, 'Registration, Fees, Licenses', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(54, '18-01113434', 11, 'Registration, Fees, Licenses', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(55, '18-01113434', 11, 'Registration, Fees, Licenses', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(56, '18-01113434', 11, 'Registration, Fees, Licenses', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(57, '18-01113434', 11, 'Others', '2017-10-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(58, '18-01113434', 11, 'Others', '2017-11-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(59, '18-01113434', 11, 'Others', '2017-12-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(60, '18-01113434', 11, 'Others', '2018-01-01', 0, 'N', 1, '2018-01-11 14:34:34'),
(131, '18-01120816', 15, 'Product 1 (production costs)', '2018-01-13', 10, 'N', 1, '2018-01-12 18:16:08'),
(132, '18-01120816', 15, 'Product 2 (production costs)', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(133, '18-01120816', 15, 'Product 3 (production costs)', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(134, '18-01120816', 15, 'Marketing Expenses ', '2018-01-13', 10, 'N', 1, '2018-01-12 18:16:08'),
(135, '18-01120816', 15, 'Other Marketing Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(136, '18-01120816', 15, 'Other Related Marketing Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(137, '18-01120816', 15, 'Salaries other than Labor ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(138, '18-01120816', 15, 'Other Administrative Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(139, '18-01120816', 15, 'Registration, Fees, Licenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(140, '18-01120816', 15, 'Others ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:16:08'),
(161, '18-01124321', 18, 'Product 1 (production costs)', '2018-01-13', 10, 'N', 1, '2018-01-12 18:21:43'),
(162, '18-01124321', 18, 'Product 2 (production costs)', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(163, '18-01124321', 18, 'Product 3 (production costs)', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(164, '18-01124321', 18, 'Marketing Expenses ', '2018-01-13', 10, 'N', 1, '2018-01-12 18:21:43'),
(165, '18-01124321', 18, 'Other Marketing Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(166, '18-01124321', 18, 'Other Related Marketing Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(167, '18-01124321', 18, 'Salaries other than Labor ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(168, '18-01124321', 18, 'Other Administrative Expenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(169, '18-01124321', 18, 'Registration, Fees, Licenses ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43'),
(170, '18-01124321', 18, 'Others ', '2018-01-13', 0, 'N', 1, '2018-01-12 18:21:43');

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
(4, 'Tractor', '180106-4206', 'Blue                                                                                   ', 100, 'set', 'Y', 'Y', 1, 'Y', 'N', 'RE180118-0044'),
(6, 'Tractor', '180109-4209', 'Red', 100, 'Set', 'N', 'Y', 1, 'Y', 'N', 'RE180118-4106'),
(7, 'Grass cutter', '180126-4126', 'Silver(honda brand)', 100, 'set', 'Y', 'Y', 1, 'Y', 'N', 'RE180118-3130');

-- --------------------------------------------------------

--
-- Table structure for table `rental_specific`
--

CREATE TABLE `rental_specific` (
  `rental_specific_id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `rental_fee_amount` double DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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

INSERT INTO `rental_specific` (`rental_specific_id`, `rental_id`, `date_return`, `rental_fee_amount`, `created_on`, `created_by`, `customer_id`, `transaction_id`, `date_returned`, `sales_id`, `paid`, `no_of_days`) VALUES
(13, 6, '2018-01-19', 100, '2018-01-16 14:44:20', 1, 59, '180116-4033', '2018-01-17', NULL, 'Y', NULL),
(14, 4, '2018-01-19', 400, '2018-01-16 14:44:20', 1, 59, '180116-4033', '2018-01-17', NULL, 'Y', NULL),
(17, 4, '2018-01-18', 200, '2018-01-16 19:16:06', 1, 61, '180116-5015', '2018-01-17', NULL, 'Y', NULL),
(18, 4, '2018-01-18', 200, '2018-01-16 19:21:37', 1, 62, '180116-1721', '2018-01-17', NULL, 'Y', NULL),
(19, 4, '2018-01-18', 200, '2018-01-16 19:23:54', 1, 63, '180116-4223', '2018-01-17', NULL, 'Y', NULL),
(20, 6, '2018-01-18', 100, '2018-01-16 19:27:47', 1, 64, '180116-2527', '2018-01-17', NULL, 'Y', NULL),
(21, 6, '2018-01-19', 100, '2018-01-16 19:32:21', 1, 65, '180116-0632', '2018-01-17', NULL, 'Y', NULL),
(22, 4, '2018-01-19', 300, '2018-01-16 19:51:09', 1, 66, '180116-4850', '2018-01-17', NULL, 'Y', NULL),
(23, 4, '2018-01-19', 300, '2018-01-16 19:56:02', 1, 67, '180116-4555', '2018-01-17', NULL, 'Y', NULL),
(24, 6, '2018-01-18', 100, '2018-01-16 19:56:34', 1, 68, '180116-1656', '2018-01-17', NULL, 'Y', NULL),
(25, 4, '2018-01-18', 200, '2018-01-16 19:58:31', 1, 69, '180116-1958', '2018-01-17', NULL, 'Y', NULL),
(26, 6, '2018-01-18', 100, '2018-01-16 20:06:22', 1, 70, '180116-0106', '2018-01-17', NULL, 'Y', NULL),
(27, 4, '2018-01-19', 300, '2018-01-17 15:39:43', 1, 71, '180117-1430', '2018-01-17', 52, 'Y', NULL),
(28, 4, '2018-01-19', 300, '2018-01-17 15:39:49', 1, 72, '180117-1430', '2018-01-17', 53, 'Y', NULL),
(29, 4, '2018-01-19', 300, '2018-01-17 15:41:26', 1, 73, '180117-1141', '2018-01-17', 54, 'Y', NULL),
(30, 6, '2018-01-19', 100, '2018-01-17 15:45:44', 1, 74, '262018023-4126', '2018-01-18', 55, 'Y', 3),
(31, 4, '2018-01-19', 300, '2018-01-17 15:45:44', 1, 74, '262018023-4126', '2018-01-18', 55, 'Y', 3),
(34, 7, '2018-01-24', 700, '2018-01-17 16:47:11', 1, 77, 'RE180117-0146', '2018-01-18', 58, 'Y', 7),
(35, 4, '2018-01-19', 200, '2018-01-17 17:53:09', 1, 78, '11201800-4711', '2018-01-18', 59, 'Y', 2),
(36, 6, '2018-01-19', 100, '2018-01-17 17:53:09', 1, 78, '11201800-4711', '2018-01-18', 59, 'Y', 2),
(37, 4, '2018-01-20', 300, '2018-01-17 18:37:13', 1, 79, 'RE180117-5536', '2018-01-18', 60, 'Y', 3),
(38, 7, '2018-01-20', 300, '2018-01-17 18:39:14', 1, 80, 'RE180117-0139', '2018-01-18', 61, 'Y', 3),
(39, 6, '2018-01-20', 100, '2018-01-17 18:52:02', 1, 81, 'RE180117-4351', '2018-01-18', 62, 'Y', 3),
(40, 4, '2018-01-20', 300, '2018-01-17 18:57:11', 1, 82, 'RE180117-0157', '2018-01-18', 63, 'Y', 3),
(41, 6, '2018-01-20', 100, '2018-01-17 19:06:04', 1, 84, 'RE180117-4905', '2018-01-18', 65, 'Y', 3),
(42, 6, '2018-01-20', 100, '2018-01-17 19:07:45', 1, 85, 'RE180117-3407', '2018-01-18', 66, 'Y', 3),
(43, 7, '2018-01-20', 300, '2018-01-18 14:33:50', 1, 86, 'RE180118-2933', '2018-01-18', 67, 'Y', 3),
(44, 4, '2018-01-20', 300, '2018-01-18 14:33:50', 1, 86, 'RE180118-2933', '2018-01-18', 67, 'Y', 3),
(45, 6, '2018-01-20', 100, '2018-01-18 14:53:04', 1, 87, 'RE180118-4952', '2018-01-18', 68, 'Y', 3),
(46, 4, '2018-01-20', 300, '2018-01-18 14:53:04', 1, 87, 'RE180118-4952', '2018-01-18', 68, 'Y', 3),
(47, 4, '2018-01-20', 300, '2018-01-18 15:44:13', 1, 89, 'RE180118-0044', NULL, 70, 'N', 3),
(48, 6, '2018-01-20', 100, '2018-01-18 16:06:49', 1, 90, 'RE180118-4106', NULL, 71, 'N', 2),
(49, 7, '2018-01-22', 400, '2018-01-18 18:30:40', 1, 95, 'RE180118-3130', NULL, 76, 'N', 4);

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
(19, '1112212121', 300, 'cash', '2017-12-19 19:09:19', 1, 19, 'Y'),
(20, 'dfdfdfd', 100, 'cash', '2017-12-19 19:10:04', 1, 20, 'Y'),
(21, '131243424', 200, 'cash', '2017-12-19 19:13:31', 1, 21, 'Y'),
(22, '32323424', 100, 'cash', '2017-12-19 22:52:47', 1, 22, 'Y'),
(23, '1212121', 100, 'cash', '2017-12-19 22:53:14', 1, 23, 'Y'),
(24, '433433', 100, 'cash', '2017-12-19 22:54:25', 1, 24, 'Y'),
(25, '342424', 100, 'cash', '2018-03-19 22:57:50', 1, 25, 'Y'),
(26, '3242424', 100, 'cash', '2018-02-19 22:58:08', 1, 26, 'Y'),
(27, '21312313', 300, 'cash', '2017-12-31 16:35:22', 1, 27, 'Y'),
(28, '1233444', 20, 'cash', '2018-01-09 15:05:59', 1, 28, 'Y'),
(29, '124314433', 100, 'cash', '2018-01-09 16:38:45', 1, 29, 'Y'),
(30, '5757575', 100, 'cash', '2018-01-09 17:30:52', 1, 30, 'Y'),
(31, '46464646', 100, 'cash', '2018-01-09 17:51:33', 1, 31, 'N'),
(32, '', 100, '', '2018-01-09 18:16:49', 1, 32, 'N'),
(33, '233423', 10, 'cash', '2018-01-09 18:17:16', 1, 33, 'N'),
(34, '343434', 10, 'cash', '2018-01-09 18:17:58', 1, 34, 'N'),
(35, '100067877', 100, 'cash', '2018-01-09 18:18:29', 1, 35, 'Y'),
(36, '454433344', 100, 'cash', '2018-01-09 18:19:03', 1, 36, 'Y'),
(37, '', 10, '', '2018-01-09 18:19:21', 1, 37, 'N'),
(38, '45454544', 100, 'cash', '2018-01-09 18:19:42', 1, 38, 'N'),
(39, '898997897', 100, 'cash', '2018-01-09 18:20:03', 1, 39, 'N'),
(40, '', 500, '', '2018-01-09 18:20:24', 1, 40, 'N'),
(41, '1234567890', 110, 'cash', '2018-01-09 18:25:57', 1, 41, 'Y'),
(42, '343434', 210, 'cash', '2018-01-10 15:12:15', 1, 42, 'N'),
(43, '22232322', 450, 'cash', '2018-01-10 15:30:56', 1, 43, 'N'),
(44, '111121', 360, 'cash', '2018-01-10 17:16:39', 1, 44, 'N'),
(45, '556564343', 200, 'cash', '2018-01-10 17:17:13', 1, 45, 'N'),
(46, '23223333', 100, 'cash', '2018-01-12 20:23:16', 1, 46, 'N'),
(47, '342424322322', 100, 'cash', '2018-01-12 21:55:11', 1, 47, 'N'),
(48, '567575657', 100, 'cash', '2018-01-12 21:56:02', 1, 48, 'N'),
(49, '242423444', 200, 'cash', '2018-01-12 21:56:12', 1, 49, 'N'),
(50, '3535353', 100, 'cash', '2018-01-15 22:13:16', 1, 50, 'N'),
(51, '33453444', 100, 'cash', '2018-01-15 22:13:29', 1, 51, 'N'),
(52, '', 300, '', '2018-01-17 15:39:43', 1, 71, 'N'),
(53, '', 300, '', '2018-01-17 15:39:49', 1, 72, 'N'),
(54, '', 300, '', '2018-01-17 15:41:26', 1, 73, 'N'),
(55, '324334645555', 400, 'cash', '2018-01-17 15:45:44', 1, 74, 'N'),
(58, '546433222', 700, 'cash', '2018-01-17 16:47:11', 1, 77, 'N'),
(59, '546465433', 300, 'cash', '2018-01-17 17:53:09', 1, 78, 'N'),
(60, '234242424', 300, 'cash', '2018-01-17 18:37:13', 1, 79, 'N'),
(61, '', 300, '', '2018-01-17 18:39:14', 1, 80, 'N'),
(62, '', 100, '', '2018-01-17 18:52:02', 1, 81, 'N'),
(63, '', 300, '', '2018-01-17 18:57:11', 1, 82, 'N'),
(64, '23424555555333', 10, 'cash', '2018-01-17 18:58:26', 1, 83, 'N'),
(65, '', 100, '', '2018-01-17 19:06:04', 1, 84, 'N'),
(66, '', 100, '', '2018-01-17 19:07:45', 1, 85, 'N'),
(67, '123344444444442', 600, 'cash', '2018-01-18 14:33:50', 1, 86, 'N'),
(68, '56464562342424242424', 400, 'cash', '2018-01-18 14:53:04', 1, 87, 'N'),
(69, '234234545433333', 20, 'cash', '2018-01-18 15:30:13', 1, 88, 'N'),
(70, '', 300, '', '2018-01-18 15:44:13', 1, 89, 'N'),
(71, '', 100, '', '2018-01-18 16:06:49', 1, 90, 'N'),
(72, '', 100, '', '2018-01-18 18:26:45', 1, 91, 'N'),
(73, '', 10, '', '2018-01-18 18:27:50', 1, 92, 'N'),
(74, '', 30, '', '2018-01-18 18:28:08', 1, 93, 'N'),
(75, '', 30, '', '2018-01-18 18:30:21', 1, 94, 'N'),
(76, '', 400, '', '2018-01-18 18:30:40', 1, 95, 'N');

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
(43, 1, 3, 300, 19, NULL, 'Y'),
(44, 8, 1, 100, 20, NULL, 'N'),
(45, 10, 1, 200, 21, NULL, 'N'),
(46, 1, 1, 100, 22, NULL, 'N'),
(47, 2, 1, 100, 23, NULL, 'N'),
(48, 2, 1, 100, 24, NULL, 'N'),
(49, 1, 1, 100, 25, NULL, 'N'),
(50, 1, 1, 100, 26, NULL, 'Y'),
(51, 1, 3, 300, 27, NULL, 'Y'),
(52, 17, 2, 20, 28, NULL, 'N'),
(53, 2, 1, 100, 29, NULL, 'N'),
(54, 1, 1, 100, 30, NULL, 'N'),
(55, 1, 1, 100, 31, '180109-1851', 'Y'),
(56, 2, 1, 100, 32, '180109-4016', 'Y'),
(57, 23, 1, 10, 33, '2020-1649', 'Y'),
(58, 6, 1, 10, 34, '180109-4417', 'Y'),
(59, 8, 1, 100, 35, '180109-0418', 'Y'),
(60, 2, 1, 100, 36, '180109-5418', 'Y'),
(61, 9, 1, 10, 37, '180109-1519', 'Y'),
(62, 1, 1, 100, 38, '180109-3519', 'Y'),
(63, 1, 1, 100, 39, '180109-5719', 'Y'),
(64, 7, 1, 500, 40, '3201802-203', 'Y'),
(65, 23, 1, 10, 41, '180109-4225', 'Y'),
(66, 1, 1, 100, 41, '180109-4225', 'Y'),
(67, 6, 2, 20, 42, '180110-1011', 'Y'),
(68, 3, 3, 90, 42, '180110-1011', 'Y'),
(69, 2, 1, 100, 42, '180110-1011', 'Y'),
(70, 23, 1, 10, 43, '180110-2230', 'Y'),
(71, 9, 2, 20, 43, '180110-2230', 'Y'),
(72, 2, 3, 300, 43, '180110-2230', 'Y'),
(73, 3, 4, 120, 43, '180110-2230', 'Y'),
(74, 8, 1, 100, 44, '180110-2116', 'Y'),
(75, 17, 1, 10, 44, '180110-2116', 'Y'),
(76, 4, 1, 20, 44, '180110-2116', 'Y'),
(77, 3, 1, 30, 44, '180110-2116', 'Y'),
(78, 2, 1, 100, 44, '180110-2116', 'Y'),
(79, 1, 1, 100, 44, '180110-2116', 'Y'),
(80, 2, 1, 100, 45, '180110-0017', 'Y'),
(81, 1, 1, 100, 45, '180110-0017', 'Y'),
(82, 1, 1, 100, 46, '180112-5122', 'Y'),
(83, 1, 1, 100, 47, '180112-2652', 'Y'),
(84, 2, 1, 100, 48, '180112-5655', 'Y'),
(85, 10, 1, 200, 49, '180112-0556', 'Y'),
(86, 1, 1, 100, 50, '180115-0613', 'Y'),
(87, 1, 1, 100, 51, '180115-2213', 'Y'),
(88, 29, 1, 10, 64, '180117-1758', 'Y'),
(89, 52, 1, 10, 69, '180118-0330', 'Y'),
(90, 26, 1, 10, 69, '180118-0330', 'Y'),
(91, 1, 1, 100, 72, '180118-3626', 'N'),
(92, 50, 1, 10, 73, '45201802-2645', 'N'),
(93, 6, 3, 30, 74, '180118-5827', 'N'),
(94, 6, 3, 30, 75, '180118-0730', 'N');

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
(2, 'Sample', 'Sample', 'Sample', '96ÀžY‰ì:Wü¯D	‚', '098', 'Y', 'img/logo2.png', 2, '2018-01-18 22:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role` int(11) NOT NULL,
  `module` varchar(45) DEFAULT NULL,
  `view_page` enum('Y','N') DEFAULT 'N',
  `view_command` enum('Y','N') DEFAULT 'N',
  `edit_command` enum('Y','N') DEFAULT 'N',
  `add_command` enum('Y','N') DEFAULT 'N',
  `delete_command` enum('Y','N') DEFAULT 'N',
  `user_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role`, `module`, `view_page`, `view_command`, `edit_command`, `add_command`, `delete_command`, `user_type_id`) VALUES
(1, 'payment', 'N', 'N', 'Y', 'Y', 'Y', 1);

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
(2, 'IGP Director', 'Y'),
(3, 'Campus Dean', 'Y'),
(4, 'Accounting', 'Y'),
(5, 'Project Assistant', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

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
  ADD UNIQUE KEY `project_name_UNIQUE` (`project_name`),
  ADD KEY `f_userk_idx` (`created_by`);

--
-- Indexes for table `project_duration`
--
ALTER TABLE `project_duration`
  ADD PRIMARY KEY (`project_duration_id`),
  ADD KEY `fkproject_idx` (`project_id`);

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
  ADD KEY `fkor_idx` (`sales_id`);

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
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_user_type_idx` (`user_type`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role`),
  ADD KEY `fkuser_type_idx` (`user_type_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `owner_info`
--
ALTER TABLE `owner_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `project_duration`
--
ALTER TABLE `project_duration`
  MODIFY `project_duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT for table `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rental_specific`
--
ALTER TABLE `rental_specific`
  MODIFY `rental_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `sales_record`
--
ALTER TABLE `sales_record`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `sales_specific`
--
ALTER TABLE `sales_specific`
  MODIFY `sales_specific_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  ADD CONSTRAINT `fkuser_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
