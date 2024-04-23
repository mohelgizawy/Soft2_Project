-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 12:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fci_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `download_pdf_attendance`
--

CREATE TABLE `download_pdf_attendance` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `time_of_attendance` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_of_attendance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `download_pdf_attendance`
--

INSERT INTO `download_pdf_attendance` (`id`, `subject_id`, `teacher_id`, `time_of_attendance`, `date_of_attendance`) VALUES
(1, 3, 2, '2024-04-23 09:17:52', '2024-04-23'),
(2, 3, 2, '2024-04-23 09:26:51', '2024-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stage` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `password`, `image`, `stage`, `phone`) VALUES
(1, 'Cofa Student', 'cofaStudent@ci.menofia.edu.eg', '233ca90b69c27f9bd218a6384a308345', '1713863158.png', '3', '01018178072');

-- --------------------------------------------------------

--
-- Table structure for table `student_with_subject`
--

CREATE TABLE `student_with_subject` (
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `weekly_attented` int(2) DEFAULT 0,
  `number_of_attendance` int(11) DEFAULT 0,
  `voted` int(2) DEFAULT 0,
  `student_id` int(11) NOT NULL,
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_with_subject`
--

INSERT INTO `student_with_subject` (`subject_id`, `teacher_id`, `weekly_attented`, `number_of_attendance`, `voted`, `student_id`, `session_token`) VALUES
(3, 2, 1, 1, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `teacher_avg_rate` float DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `session_attented` tinyint(1) DEFAULT 0,
  `ip_getWay` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `Day` varchar(255) DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `teacher_avg_rate`, `teacher_id`, `session_attented`, `ip_getWay`, `time`, `Day`, `session_token`) VALUES
(1, 'Network 1 ', NULL, 1, 1, NULL, 9, 'Sun', NULL),
(2, 'Discrete', NULL, 1, 1, NULL, 1, 'Sun', NULL),
(3, 'OOP', NULL, 2, 1, NULL, 11, 'Wed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `teacher_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `password`, `image`, `role`, `phone`, `teacher_token`) VALUES
(1, 'CofaTeacher', 'cofaTeacher@ci.menofia.edu.eg', '233ca90b69c27f9bd218a6384a308345', NULL, 'instructor', '01018178072', 'cofa12'),
(2, 'GizawyTeacher', 'GizawyTeacher@gmail.com', 'e8bf992ce219318cfeb5c517c8b0e251', '1713863644.jpg', 'doctor', '01010101010', 'Gizawy12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `download_pdf_attendance`
--
ALTER TABLE `download_pdf_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_with_subject`
--
ALTER TABLE `student_with_subject`
  ADD PRIMARY KEY (`subject_id`,`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `download_pdf_attendance`
--
ALTER TABLE `download_pdf_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `download_pdf_attendance`
--
ALTER TABLE `download_pdf_attendance`
  ADD CONSTRAINT `download_pdf_attendance_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `student_with_subject` (`subject_id`),
  ADD CONSTRAINT `download_pdf_attendance_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `student_with_subject` (`teacher_id`);

--
-- Constraints for table `student_with_subject`
--
ALTER TABLE `student_with_subject`
  ADD CONSTRAINT `student_with_subject_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`),
  ADD CONSTRAINT `student_with_subject_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `student_with_subject_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
