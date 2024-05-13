-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 03:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `has_image` tinyint(1) NOT NULL,
  `comments` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `is_profile_image` tinyint(1) DEFAULT NULL,
  `is_cover_image` tinyint(1) DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post`, `image`, `has_image`, `comments`, `likes`, `is_profile_image`, `is_cover_image`, `date`, `user_id`) VALUES
(1, 'dagfve', '', 0, NULL, NULL, 0, 0, '2024-05-12 08:51:13', 1),
(2, 'egewgew324e123', '', 0, NULL, NULL, 0, 0, '2024-05-12 08:51:17', 1),
(3, '', '../upload/1/BkR97ynVOmKRX6A.jpg', 1, NULL, NULL, 0, 0, '2024-05-12 08:53:36', 1),
(4, '', '../upload/1/Ngil92GjV0uKeay.jpg', 1, NULL, NULL, 1, 0, '2024-05-12 08:53:49', 1),
(5, '', '../upload/1/f7M93BJYQdlTNw9.jpg', 1, NULL, NULL, 0, 1, '2024-05-12 08:53:59', 1),
(6, '', '../upload/2/exKdqeio3RuPHci.jpg', 1, NULL, NULL, 1, 0, '2024-05-12 08:56:12', 2),
(7, 'freqwfrefr', '../upload/2/8ag8dR20KdFyMvN.jpg', 1, NULL, NULL, 1, 0, '2024-05-12 08:56:23', 2),
(8, '', '../upload/1/ci4ReW2W8OWB2QB.jpg', 1, NULL, NULL, 1, 0, '2024-05-13 01:28:59', 1),
(9, '', '../upload/1/iJ8UfDKBxKThQN9.jpg', 1, NULL, NULL, 0, 1, '2024-05-13 01:29:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` char(13) DEFAULT NULL,
  `profile_image` varchar(1000) DEFAULT NULL,
  `cover_image` varchar(1000) DEFAULT NULL,
  `url_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `gender`, `email`, `password`, `phone`, `profile_image`, `cover_image`, `url_address`, `created_at`, `updated_at`) VALUES
(1, 'Ahmed', 'Moahmed', 'Male', '123A@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, '../upload/1/ci4ReW2W8OWB2QB.jpg', '../upload/1/iJ8UfDKBxKThQN9.jpg', 'ahmed.moahmed', '2024-05-12 08:51:07', '2024-05-12 08:51:07'),
(2, 'Lolo', 'Mohamed', 'Female', '121212@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, '../upload/2/8ag8dR20KdFyMvN.jpg', NULL, 'lolo.mohamed', '2024-05-12 08:55:55', '2024-05-12 08:55:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `likes` (`likes`),
  ADD KEY `data` (`date`),
  ADD KEY `comments` (`comments`),
  ADD KEY `has_image` (`has_image`),
  ADD KEY `fk_posts_users1_idx` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `email` (`email`),
  ADD KEY `first_Name` (`first_name`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `gender` (`gender`),
  ADD KEY `url_address` (`url_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
