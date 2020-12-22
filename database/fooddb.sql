-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2020 at 01:30 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fooddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `path`, `type`, `date_created`, `date_updated`) VALUES
(3, 'gondol.jpg', 'food_5fd8a5abb005f7.90992114.jpg', 'image/jpeg', '2020-12-15 12:01:47', '2020-12-15 12:01:47'),
(21, 'wine.jpg', 'food_5fd676eb5bb034.95930018.jpg', 'image/jpeg', '2020-12-15 09:37:52', NULL),
(22, 'gondol.jpg', 'food_5fd69b5f71c2a3.35889347.jpg', 'image/jpeg', '2020-12-15 09:38:03', NULL),
(23, 'workshop.jpg', 'food_5fd9bc23808a08.34955465.jpg', 'image/jpeg', '2020-12-16 07:49:55', '2020-12-16 07:49:55'),
(24, 'salmon.jpg', 'food_5fd747d3d342d0.57300890.jpg', 'image/jpeg', '2020-12-15 09:38:17', NULL),
(25, 'croissant.jpg', 'food_5fd7493d3952c4.51237109.jpg', 'image/jpeg', '2020-12-15 09:38:23', NULL),
(26, 'salmon.jpg', 'food_5fd876a12c6171.23170245.jpg', 'image/jpeg', '2020-12-15 09:38:44', NULL),
(27, 'cherries.jpg', 'food_5fd87bf1128117.03672850.jpg', 'image/jpeg', '2020-12-15 09:03:45', NULL),
(28, 'popsicle.jpg', 'food_5fd87d1daf5c57.27180560.jpg', 'image/jpeg', '2020-12-15 09:08:45', NULL),
(34, 'workshop.jpg', 'food_5fd9f11295e2a7.73747710.jpg', 'image/jpeg', '2020-12-16 11:35:46', NULL),
(42, 'croissant.jpg', 'food_5fdb39d676ee37.69378580.jpg', 'image/jpeg', '2020-12-17 10:58:30', NULL),
(43, 'cherries.jpg', 'food_5fdb4c6a353a50.26418287.jpg', 'image/jpeg', '2020-12-17 12:17:46', NULL),
(44, 'wine.jpg', 'food_5fdc97b59c5454.26122177.jpg', 'image/jpeg', '2020-12-18 11:51:17', NULL),
(45, 'workshop.jpg', 'food_5fdc987c3567b6.47690095.jpg', 'image/jpeg', '2020-12-18 11:54:36', NULL),
(46, 'workshop.jpg', 'food_5fdcb8732c2318.93478934.jpg', 'image/jpeg', '2020-12-18 14:10:59', NULL),
(47, 'salmon.jpg', 'food_5fdcb88a8b7d66.66027861.jpg', 'image/jpeg', '2020-12-18 14:11:22', NULL),
(48, 'sandwich.jpg', 'food_5fdcbd72062ad6.42594832.jpg', 'image/jpeg', '2020-12-18 14:32:18', NULL),
(49, 'sandwich.jpg', 'food_5fdcbe50437b25.53763848.jpg', 'image/jpeg', '2020-12-18 14:36:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `user_id`, `title`, `description`, `date_created`, `date_updated`, `file_id`) VALUES
(3, 1, 'Rice and Stew very plenty title 2', 'Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.  ', '2020-12-04 10:19:10', '2020-12-16 07:47:08', 3),
(5, 1, 'Cherries Interrupted', 'em ipsum text praesLorem ipsum text praesent tincidunt ipsum lipsum. What else?.', '2020-12-04 10:52:31', NULL, 3),
(7, 1, 'Rice and Stew', 'Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.', '2020-12-04 13:38:56', '2020-12-16 07:47:29', 3),
(20, 1, 'New fAKE fOOD double double', 'Cras ultricies ligula sed magna dictum porta. Vivamus suscipit tortor eget felis ', '2020-12-14 11:00:47', '2020-12-16 07:47:39', 23),
(21, 1, 'Justice food', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia =', '2020-12-14 11:09:07', '2020-12-16 07:47:51', 24),
(23, 1, 'test UPLoad', 'Sed porttitor lectus nibh. Sed porttitor lectus nibh. Nulla porttitor accumsan ', '2020-12-15 08:41:05', '2020-12-16 07:48:18', 26),
(25, 1, 'new food three', 'Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam ', '2020-12-15 09:08:45', '2020-12-16 07:48:44', 28),
(26, 3, 'Facials', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin molestie malesuada. Done', '2020-12-18 14:10:59', NULL, 46),
(27, 3, 'Soup Now', 'Curabitur aliquet quam id dui posuere blandit. Vivamus suscipit tortor eget felis porttitor volutpat. Nulla quis lorem ut libero malesuada feugiat. Nulla quis lorem ut libero malesuada feugiat. Nulla porttitor', '2020-12-18 14:11:22', NULL, 47);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `feature_img` int(11) NOT NULL,
  `enable_section` tinyint(2) DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `section_title`, `main_title`, `subtitle`, `description`, `feature_img`, `enable_section`, `date_created`, `date_updated`) VALUES
(5, 'About', 'About Tedikom Foods', 'I Am Who I Am!', 'About Us', 'Nulla quis lorem ut libero malesuada feugiat. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Donec rutrum congue leo eget malesuada. Nulla porttitor accumsan tincidunt. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Donec sollicitudin molestie malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Pellentesque in ipsum id orci porta dapibus. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.\r\n\r\nVestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vivamus suscipit tortor eget felis porttitor volutpat. Lo', 34, 1, '2020-12-19 16:08:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_img` int(11) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1,
  `activated` tinyint(2) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `surname`, `username`, `email`, `password`, `profile_img`, `role`, `activated`, `date_created`, `date_updated`) VALUES
(3, 'Edidiong', 'Ubong', 'EdiUb', 'justice@gmail.com', '$2y$10$.5DSytwhXUxIZoy9iBEgOOYQO1MfKVjySvT1LCl1ZvRdTSIfccvca', 42, 0, 1, '2020-12-18 14:37:58', NULL),
(4, 'Junk2', 'Junk2', 'Junk2Me', 'Junk2@gmail.com', '$2y$10$/hg4zlpMM899jUwkbqbgaembxf3YkQHU7hOzwf/a3xmqp9bs0Xwr6', 43, 1, 0, '2020-12-18 08:14:41', NULL),
(8, 'Jamie', 'Jamie', 'Jamie', 'Jamie@gmail.com', '$2y$10$btFRZlGjgKxLLEkMcP5PuuGLEWBjQSHR/XErI26t8ceBJH/NOZdE2', 48, 1, 0, '2020-12-18 14:34:31', NULL),
(9, 'Angie', 'Angie', 'Angie', 'angie@gmail.com', '$2y$10$kdvHOU8eFfm81Xgqra7t5.3l.HTSP3ALbX4cEC346Ry1Lb8qNvBV2', 49, 1, 1, '2020-12-18 14:52:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feature_img` (`feature_img`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `profile_img` (`profile_img`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`feature_img`) REFERENCES `files` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`profile_img`) REFERENCES `files` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
