-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 05:53 PM
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
(20, 'coke', 160, 30, 'kitchen', '2023-01-10', '2023-03-08', NULL, 'Stocked'),
(21, 'potato', 72, 25, 'kitchen', '2023-01-10', '2023-02-12', NULL, 'Stocked'),
(22, 'shrimp', 90, 50, 'kitchen', '2023-01-10', '2023-03-14', NULL, 'Stocked'),
(23, 'Nestea', 171, 60, 'kitchen', '2023-01-10', '2023-04-02', NULL, 'Stocked'),
(24, 'UFC ketchup', 90, 30, 'kitchen', '2023-01-10', '2023-04-02', NULL, 'Stocked'),
(25, 'Magnolia Hotdog', 149, 20, 'kitchen', '2023-01-10', '2023-03-22', NULL, 'Stocked'),
(26, 'French Fries', 160, 60, 'kitchen', '2023-01-10', '2023-04-02', NULL, 'Stocked'),
(27, 'Calamares', 126, 40, 'kitchen', '2023-01-10', '2023-04-02', NULL, 'Stocked'),
(28, 'Fish Fillet', 25, 50, 'kitchen', '2023-01-10', '2023-04-02', NULL, 'Alerted'),
(29, 'Lumpia', 69, 40, 'kitchen', '2023-01-10', '2023-03-14', NULL, 'Stocked');

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
(41, 'out', 10, 25, '2023-01-15'),
(42, 'out', 25, 23, '2023-01-15'),
(43, 'out', 10, 21, '2023-01-15'),
(44, 'out', 20, 26, '2023-01-15'),
(45, 'out', 50, 22, '2023-01-15'),
(46, 'out', 50, 26, '2023-01-19'),
(47, 'out', 60, 26, '2023-01-19'),
(48, 'out', 20, 29, '2023-01-19'),
(49, 'in', 40, 29, '2023-01-19'),
(50, 'in', 60, 25, '2023-01-19'),
(51, 'out', 100, 20, '2023-01-24'),
(52, 'in', 50, 25, '2023-01-24'),
(53, 'in', 150, 23, '2023-01-24'),
(54, 'out', 120, 25, '2023-01-27'),
(55, 'out', 120, 27, '2023-01-27'),
(56, 'out', 90, 23, '2023-01-27'),
(57, 'in', 150, 29, '2023-01-27'),
(58, 'in', 150, 26, '2023-01-27'),
(59, 'in', 50, 24, '2023-01-27'),
(60, 'in', 90, 21, '2023-01-27'),
(61, 'in', 60, 25, '2023-01-27'),
(62, 'in', 150, 22, '2023-01-27'),
(63, 'in', 150, 20, '2023-01-27'),
(64, 'in', 120, 27, '2023-01-27'),
(65, 'in', 50, 27, '2023-01-27'),
(66, 'out', 65, 20, '2023-02-02'),
(67, 'out', 65, 23, '2023-02-02'),
(68, 'out', 45, 21, '2023-02-02'),
(69, 'out', 50, 24, '2023-02-02'),
(70, 'out', 80, 26, '2023-02-02'),
(71, 'out', 45, 22, '2023-02-02'),
(72, 'out', 56, 29, '2023-02-06'),
(73, 'out', 50, 29, '2023-02-06'),
(74, 'out', 30, 24, '2023-02-06'),
(75, 'out', 60, 26, '2023-02-06'),
(76, 'out', 60, 27, '2023-02-12'),
(77, 'out', 35, 22, '2023-02-12'),
(78, 'out', 21, 25, '2023-02-12'),
(79, 'out', 25, 20, '2023-02-12'),
(80, 'out', 13, 21, '2023-02-12'),
(81, 'out', 24, 27, '2023-02-12'),
(82, 'in', 120, 23, '2023-02-24'),
(83, 'in', 100, 26, '2023-02-24'),
(84, 'out', 60, 22, '2023-03-08'),
(85, 'out', 50, 28, '2023-03-08'),
(86, 'in', 50, 20, '2023-03-08'),
(87, 'out', 30, 25, '2023-03-08'),
(88, 'in', 40, 24, '2023-03-08'),
(89, 'in', 120, 24, '2023-03-08'),
(90, 'out', 80, 27, '2023-03-08'),
(91, 'out', 90, 29, '2023-03-14'),
(92, 'out', 70, 22, '2023-03-14'),
(93, 'out', 120, 23, '2023-03-14'),
(94, 'in', 150, 24, '2023-03-14'),
(95, 'in', 120, 26, '2023-03-14'),
(96, 'out', 150, 26, '2023-03-14'),
(97, 'in', 200, 28, '2023-03-22'),
(98, 'in', 150, 23, '2023-03-22'),
(99, 'in', 120, 25, '2023-03-22'),
(100, 'out', 150, 24, '2023-03-22'),
(101, 'out', 90, 26, '2023-03-25'),
(102, 'in', 150, 26, '2023-04-02'),
(103, 'out', 30, 26, '2023-04-02'),
(104, 'out', 20, 23, '2023-04-02'),
(105, 'out', 120, 24, '2023-04-02'),
(106, 'out', 200, 28, '2023-04-02'),
(107, 'in', 50, 27, '2023-04-02');

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
(2, 'guest', 'user', 'password', '+639945181366', 2, '2023-09-26', '2023-02-22');

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_logs`
--
ALTER TABLE `product_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
