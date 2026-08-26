-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 26, 2026 at 10:00 PM
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
-- Database: `tomtroc`
--
CREATE DATABASE IF NOT EXISTS `tomtroc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tomtroc`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `author` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `cover`, `is_available`, `created_at`) VALUES
(1, 1, 'Esther', 'Alabaster', 'Roman graphique, très bon état.', 'books/esther.jpg', 1, '2026-05-19 12:42:21'),
(2, 2, 'The Kinfolk Table', 'Nathan Williams', 'Cuisine et art de vivre, quelques pages cornées.', 'books/kinfolk-table.jpg', 1, '2026-06-07 05:23:34'),
(3, 3, 'Wabi Sabi', 'Beth Kempton', 'Essai sur l\'art japonais de l\'imperfection.', 'books/wabi-sabi.jpg', 1, '2026-07-28 14:29:12'),
(4, 4, 'Milk & honey', 'Rupi Kaur', 'Recueil de poésie contemporaine.', 'books/milk-and-honey.jpg', 1, '2026-08-11 08:23:50'),
(5, 2, 'Dune', 'Frank Herbert', 'Science-fiction, tome 1 du cycle, très bon état.', 'books/dune.jpg', 1, '2026-06-13 14:15:16'),
(6, 3, 'Sapiens', 'Yuval Noah Harari', 'Essai, une brève histoire de l\'humanité.', 'books/sapiens.jpg', 0, '2026-08-13 18:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `created_at`) VALUES
(1, 'Emma', 'emma.leroy@gmail.com', '$2y$10$t.t0ROX80AIP7h37mPVx7eUOzl7sW551bLjdkXy1Dxe.Hi.WTCoLm', NULL, '2026-05-14 09:32:42'),
(2, 'Hugo', 'hugo.martin@hotmail.fr', '$2y$10$Vp03oXOPqsOJQjVY7pi2weV8aL1ZN8LTKVgZj.Zur5mBzCqEnxooq', NULL, '2026-06-01 14:15:16'),
(3, 'Chloe', 'chloe.dubois@gmail.com', '$2y$10$9HvK0hvBuNNzUdbFfBT14OSKUdfXqk1EATF5UXsH3FLWAeSd5s11S', NULL, '2026-07-24 18:45:00'),
(4, 'Leo', 'leo.bernard@outlook.com', '$2y$10$c/5rR2iRcOqxgCTlKk/EMuddBJJ9fUMBVlUiFPSScBFnym2xGxEee', NULL, '2026-08-03 11:05:58'),
(6, 'Gilles BG', 'gilles-bg@gmail.com', '$2y$10$iV6aOyNpZpffIr7yZ7jhAO1zEZMHOIg2A1alv4tPoBEhwVu/Yr/qK', NULL, '2026-08-25 22:21:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_books_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `uq_users_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
