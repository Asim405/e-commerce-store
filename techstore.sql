-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 05, 2026 at 02:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




--
-- Database: `techstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'Pakistan',
  `payment_method` varchar(50) DEFAULT NULL,
  `easypaisa_number` varchar(20) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT 0.0,
  `reviews` int(11) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `rating`, `reviews`, `featured`, `created_at`) VALUES
(1, 'Premium Wireless Headphones', 'High-quality wireless headphones with active noise cancellation and premium sound quality.', 299.99, 'assets/images/headphones.jpg', 'Audio', 4.8, 234, 1, '2026-04-04 17:00:17'),
(2, 'True Wireless Earbuds', 'Compact wireless earbuds with long battery life and crystal clear audio.', 149.99, 'assets/images/earbuds.jpg', 'Audio', 4.5, 189, 1, '2026-04-04 17:00:17'),
(3, 'Smart Watch Pro', 'Advanced smartwatch with fitness tracking, heart rate monitor, and smartphone connectivity.', 399.99, 'assets/images/smartwatch.jpg', 'Wearables', 4.7, 456, 1, '2026-04-04 17:00:17'),
(4, 'UltraBook Laptop', 'Powerful and lightweight laptop perfect for work and entertainment.', 1299.99, 'assets/images/laptop.jpg', 'Computers', 4.9, 672, 1, '2026-04-04 17:00:17'),
(5, 'Flagship Smartphone', 'Latest flagship smartphone with cutting-edge camera and performance.', 899.99, 'assets/images/smartphone.jpg', 'Mobile', 4.6, 891, 0, '2026-04-04 17:00:17'),
(6, 'Professional Camera', 'Professional-grade camera for stunning photos and videos.', 1899.99, 'assets/images/camera.jpg', 'Photography', 4.9, 163, 0, '2026-04-04 17:00:17'),
(7, 'Premium Tablet', 'Large display tablet perfect for productivity and entertainment.', 649.99, 'assets/images/tablet.jpg', 'Tablets', 4.7, 521, 0, '2026-04-04 17:00:17'),
(8, 'RGB Gaming Keyboard', 'Mechanical gaming keyboard with customizable RGB lighting.', 179.99, 'assets/images/keyboard.jpg', 'Gaming', 4.4, 387, 0, '2026-04-04 17:00:17');

-- --------------------------------------------------------

-- update the queries for photos which i integrated in the project
UPDATE products SET image = 'assets/images/Premium Wireless He.jpg' WHERE name = 'Premium Wireless Headphones';
UPDATE products SET image = 'assets/images/True Wireless Earbuds.jpg' WHERE name = 'True Wireless Earbuds';
UPDATE products SET image = 'assets/images/Smart Watch Pro.jpg' WHERE name = 'Smart Watch Pro';
UPDATE products SET image = 'assets/images/UltraBook Laptop.jpg' WHERE name = 'UltraBook Laptop';
UPDATE products SET image = 'assets/images/Flagship Smartphone.jpg' WHERE name = 'Flagship Smartphone';
UPDATE products SET image = 'assets/images/Professional Camera.jpg' WHERE name = 'Professional Camera';
UPDATE products SET image = 'assets/images/Premium Tablet.jpg' WHERE name = 'Premium Tablet';
UPDATE products SET image = 'assets/images/RGB Gaming Keyboard.jpg' WHERE name = 'RGB Gaming Keyboard';
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
