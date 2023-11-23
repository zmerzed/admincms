-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2023 at 07:53 PM
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
  `low_quantity_level` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `is_delete` smallint(6) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `low_quantity_level`, `category`, `created_at`, `updated_at`, `is_delete`, `status`) VALUES
(1, 'Coca Cola Bundle', 35, 25, 'drinks', '2023-09-15', '2023-11-15', NULL, 'Stocked'),
(2, 'Potato', 74, 30, 'kitchen', '2023-09-15', '2023-11-15', NULL, 'Stocked'),
(3, 'Table Plate', 38, 15, 'kitchen', '2023-09-15', '2023-11-13', NULL, 'Stocked'),
(4, 'Shrimp package', 194, 25, 'kitchen', '2023-09-15', '2023-09-15', NULL, 'Stocked'),
(5, 'Nestea Drink', 51, 40, 'drinks', '2023-09-15', '2023-11-13', NULL, NULL),
(8, 'UFC Ketchup', 43, 30, 'kitchen', '2023-09-15', '2023-11-15', NULL, 'Stocked'),
(9, 'Japanese Knife', 33, 60, 'kitchen', '2023-09-15', '2023-11-15', NULL, NULL),
(10, 'Magnolia Hotdog', 22, 50, 'kitchen', '2023-09-15', '2023-11-15', NULL, NULL),
(11, '1 Dozen Egg', 22, 60, 'kitchen', '2023-09-15', '2023-11-15', NULL, NULL),
(12, 'Tempura Pack', 25, 40, 'kitchen', '2023-09-15', '2023-11-15', NULL, NULL),
(16, 'Purefoods French Fries', 10, 40, 'kitchen', '2023-01-18', '2023-09-15', NULL, 'Alerted'),
(17, 'Magnolia Chicken Nuggets', 25, 40, 'kitchen', '2023-10-01', '2023-11-15', NULL, 'Stocked'),
(19, 'Lobster', 30, 35, 'kitchen', '2023-11-14', '2023-11-15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_logs`
--

CREATE TABLE `product_logs` (
  `id` int(11) NOT NULL,
  `mode` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_logs`
--

INSERT INTO `product_logs` (`id`, `mode`, `quantity`, `product_id`, `created_at`) VALUES
(1, 'in', 1, 1, '2023-10-16'),
(2, 'in', 50, 1, '2023-10-16'),
(3, 'out', 10, 1, '2023-10-16'),
(4, 'in', 5, 5, '2023-10-16'),
(5, 'out', 4, 5, '2023-10-16'),
(6, 'in', 5, 12, '2023-10-17'),
(7, 'out', 2, 12, '2023-10-17'),
(8, 'in', 1, 1, '2023-10-17'),
(9, 'out', 1, 1, '2023-10-17'),
(10, 'in', 10, 1, '2023-10-17'),
(12, 'out', 5, 1, '2023-10-17'),
(13, 'out', 20, 1, '2023-10-28'),
(14, 'out', 1, 16, '2023-11-10'),
(15, 'in', 1, 1, '2023-11-10'),
(16, 'in', 20, 4, '2023-11-10'),
(17, 'in', 5, 3, '2023-11-11'),
(18, 'in', 3, 17, '2023-11-11'),
(19, 'in', 1, 17, '2023-11-11'),
(20, 'in', 1, 17, '2023-11-11'),
(21, 'out', 1, 17, '2023-11-11'),
(22, 'out', 50, 5, '2023-11-13'),
(23, 'in', 20, 17, '2023-11-13'),
(24, 'in', 30, 3, '2023-11-13'),
(25, 'out', 40, 1, '2023-11-14'),
(26, 'in', 20, 16, '2023-11-14'),
(27, 'out', 15, 16, '2023-11-14'),
(28, 'out', 7, 2, '2023-11-15'),
(29, 'in', 70, 2, '2023-11-15'),
(30, 'out', 15, 1, '2023-11-15'),
(31, 'out', 20, 8, '2023-11-15'),
(32, 'in', 30, 1, '2023-11-15'),
(33, 'in', 30, 8, '2023-11-15'),
(34, 'in', 200, 4, '2023-09-15'),
(35, 'out', 30, 4, '2023-09-15'),
(36, 'in', 250, 16, '2023-09-15'),
(37, 'out', 255, 16, '2023-09-15');

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
  `access_level` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `phone_number`, `access_level`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'password', '+639945181366', 1, NULL, NULL),
(2, 'guest', 'guestuser', 'password', '+639945181366', 2, '2023-09-26', '2023-10-17'),
(16, 'magie', 'staff', 'staff', '09345236458', 2, '2023-11-14', '2023-11-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_logs`
--
ALTER TABLE `product_logs`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_logs`
--
ALTER TABLE `product_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
