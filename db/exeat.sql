-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2022 at 06:01 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exeat`
--

-- --------------------------------------------------------

--
-- Table structure for table `exeat`
--

CREATE TABLE `exeat` (
  `exeat_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exeat_number` text NOT NULL,
  `reason` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exeat`
--

INSERT INTO `exeat` (`exeat_id`, `student_id`, `exeat_number`, `reason`, `start_date`, `end_date`, `status`) VALUES
(10, 1, '2022102410138', 'r1', '2022-10-26', '2022-10-23', 'On Exeat'),
(11, 2, '2022102410155', 'r2', '2022-10-24', '2022-10-23', 'On Exeat'),
(13, 4, '2022102414636', 'New Reason', '2022-10-24', '0000-00-00', 'Reported');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `form_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `form_name`) VALUES
(1, 'Form 1'),
(2, 'Form 2'),
(3, 'Form 3');

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

CREATE TABLE `house` (
  `house_id` int(11) NOT NULL,
  `house_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_id`, `house_name`) VALUES
(1, 'House 1'),
(2, 'House 2'),
(3, 'House 3');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_index_num` text NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `guardian_name` text NOT NULL,
  `guardian_ph` text NOT NULL,
  `house_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `photo_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_index_num`, `first_name`, `middle_name`, `last_name`, `guardian_name`, `guardian_ph`, `house_id`, `form_id`, `photo_id`) VALUES
(1, '45874', 'Carlos', 'Semeho', 'Edorh', 'Sister ', '+233245820054', 2, 1, 'media_2101953709_10-24-2022_0147am.jpg'),
(2, '444', 'Doris', 'None', 'Apasu', 'Carlos', '+233245820054', 2, 2, 'media_364801002_10-24-2022_0447am.png'),
(3, '123546985', 'fr', 'gb', 'gbg', 'juj', 'uju', 1, 1, ''),
(4, '8758', 'First', 'Middle', 'Last', 'Guardian', 'Contact', 1, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exeat`
--
ALTER TABLE `exeat`
  ADD PRIMARY KEY (`exeat_id`),
  ADD KEY `fk_foreign_key_student_id` (`student_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_foreign_key_house_id` (`house_id`),
  ADD KEY `fk_foreign_key_form_id` (`form_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exeat`
--
ALTER TABLE `exeat`
  MODIFY `exeat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `house`
--
ALTER TABLE `house`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exeat`
--
ALTER TABLE `exeat`
  ADD CONSTRAINT `fk_foreign_key_student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_foreign_key_form_id` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`),
  ADD CONSTRAINT `fk_foreign_key_house_id` FOREIGN KEY (`house_id`) REFERENCES `house` (`house_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
