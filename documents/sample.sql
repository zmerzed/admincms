-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 01:41 PM
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
-- Database: `simsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `category`, `created_at`, `updated_at`) VALUES
(1, 'shrimp', 200, 'kitchen', '2023-10-07', '2023-10-07'),
(2, 'patatas', 231, 'kitchen', '2023-10-07', '2023-10-07'),
(4, 'onion', 9, 'kitchen', '2023-10-07', '2023-10-07'),
(5, 'carrots', 10, 'kitchen', '2023-10-07', '2023-10-07'),
(7, 'fish fillet', 12, 'kitchen', '2023-10-07', '2023-10-07'),
(8, 'black pepper', 2, 'kitchen', '2023-10-07', '2023-10-07'),
(9, 'UFC ketchup', 1, 'kitchen', '2023-10-07', '2023-10-07'),
(10, 'coke', 12, 'kitchen', '2023-10-07', '2023-10-07'),
(11, 'sprite', 1, 'kitchen', '2023-10-07', '2023-10-07'),
(12, 'royal', 5, 'kitchen', '2023-10-07', '2023-10-07'),
(13, 'sisig', 17, 'kitchen', '2023-10-07', '2023-10-07'),
(14, 'calamares', 8, 'kitchen', '2023-10-07', '2023-10-07'),
(15, 'powder', 2, 'kitchen', '2023-10-07', '2023-10-07'),
(16, 'diswashing liqiud', 1, 'kitchen', '2023-10-07', '2023-10-07'),
(17, 'ahos', 7, 'kitchen', '2023-10-07', '2023-10-07'),
(18, 'sibuyas dahon', 12, 'kitchen', '2023-10-07', '2023-10-07'),
(19, 'brown sugar', 1, 'kitchen', '2023-10-07', '2023-10-07'),
(20, 'mayonnaise', 23, 'kitchen', '2023-10-07', '2023-10-07'),
(21, 'shrimp', 200, 'kitchen', '2023-10-13', '2023-10-13'),
(22, 'shrimp', 21, 'kitchen', '2023-10-13', '2023-10-13'),
(23, 'orion', 12, 'kitchen', '2023-10-13', '2023-10-13'),
(24, 'bottled water', 15, 'furniture', '2023-10-14', '2023-10-14'),
(25, 'sibuyas dahon', 5, 'kitchen', '2023-10-14', '2023-10-14'),
(26, 'banana', 8, 'furniture', '2023-10-14', '2023-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `access_level` int(2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `phone_number`, `access_level`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'password', NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
