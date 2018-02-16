-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2018 at 11:36 PM
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
-- Database: `enrolment`
--

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
(347, 3, 'Y', 'Y', 'X', 'X', 'X', 'Y', 'X', 1),
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
(359, 3, 'Y', 'N', 'X', 'X', 'X', 'Y', 'X', 2),
(360, 4, 'Y', 'N', 'Y', 'Y', 'N', 'Y', 'Y', 2),
(361, 5, 'Y', 'N', 'Y', 'Y', 'X', 'Y', 'Y', 2),
(362, 6, 'Y', 'N', 'X', 'X', 'X', 'Y', 'X', 2),
(363, 7, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 2),
(364, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 2),
(365, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 2),
(366, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 2),
(367, 11, 'Y', 'N', 'X', 'Y', 'X', 'Y', 'X', 2),
(368, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 2),
(369, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 3),
(370, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 3),
(371, 3, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 3),
(372, 4, 'Y', 'Y', 'N', 'N', 'N', 'N', 'Y', 3),
(373, 5, 'Y', 'Y', 'N', 'N', 'X', 'N', 'Y', 3),
(374, 6, 'Y', 'Y', 'X', 'X', 'X', 'N', 'X', 3),
(375, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 3),
(376, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 3),
(377, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 3),
(378, 10, 'N', 'X', 'X', 'X', 'X', 'Y', 'X', 3),
(379, 11, 'N', 'N', 'X', 'N', 'X', 'N', 'X', 3),
(380, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 3),
(393, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 4),
(394, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 4),
(395, 3, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 4),
(396, 4, 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 4),
(397, 5, 'N', 'N', 'N', 'N', 'X', 'N', 'Y', 4),
(398, 6, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 4),
(399, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 4),
(400, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 4),
(401, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 4),
(402, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 4),
(403, 11, 'Y', 'Y', 'X', 'N', 'X', 'Y', 'X', 4),
(404, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 4),
(417, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 5),
(418, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 5),
(419, 3, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 5),
(420, 4, 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 5),
(421, 5, 'N', 'N', 'N', 'N', 'X', 'N', 'Y', 5),
(422, 6, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 5),
(423, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 5),
(424, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 5),
(425, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 5),
(426, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 5),
(427, 11, 'N', 'N', 'X', 'N', 'X', 'N', 'X', 5),
(428, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 5),
(429, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 7),
(430, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 7),
(431, 3, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 7),
(432, 4, 'Y', 'N', 'Y', 'Y', 'N', 'Y', 'Y', 7),
(433, 5, 'Y', 'N', 'N', 'N', 'X', 'N', 'Y', 7),
(434, 6, 'Y', 'N', 'X', 'X', 'X', 'N', 'X', 7),
(435, 7, 'Y', 'Y', 'X', 'X', 'X', 'X', 'X', 7),
(436, 8, 'N', 'X', 'X', 'X', 'X', 'X', 'X', 7),
(437, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 7),
(438, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 7),
(439, 11, 'Y', 'N', 'X', 'N', 'X', 'N', 'X', 7),
(440, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 7),
(441, 1, 'Y', 'X', 'X', 'N', 'N', 'N', 'X', 6),
(442, 2, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 6),
(443, 3, 'N', 'N', 'X', 'X', 'X', 'Y', 'X', 6),
(444, 4, 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 6),
(445, 5, 'N', 'N', 'N', 'N', 'X', 'N', 'Y', 6),
(446, 6, 'N', 'N', 'X', 'X', 'X', 'N', 'X', 6),
(447, 7, 'N', 'N', 'X', 'X', 'X', 'X', 'X', 6),
(448, 8, 'Y', 'X', 'X', 'X', 'X', 'X', 'X', 6),
(449, 9, 'Y', 'N', 'Y', 'N', 'X', 'Y', 'Y', 6),
(450, 10, 'N', 'X', 'X', 'X', 'X', 'N', 'X', 6),
(451, 11, 'Y', 'Y', 'X', 'N', 'X', 'Y', 'X', 6),
(452, 12, 'Y', 'N', 'X', 'X', 'X', 'X', 'X', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role`),
  ADD KEY `fkuser_type_idx` (`user_type_id`),
  ADD KEY `fkmodule_idx` (`module_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;
--
-- Constraints for dumped tables
--

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
