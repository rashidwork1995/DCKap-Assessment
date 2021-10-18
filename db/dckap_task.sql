-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2021 at 04:50 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dckap_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `dckap_cart`
--

CREATE TABLE `dckap_cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `product_id` varchar(10) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `cart_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dckap_cart`
--

INSERT INTO `dckap_cart` (`id`, `user_id`, `product_id`, `qty`, `cart_status`, `created_date`, `is_delete`) VALUES
(1, '3', '1', 1, 1, '2021-10-17 19:29:58', 0),
(2, '3', '5', 1, 1, '2021-10-17 19:30:11', 0),
(3, '4', '1', 1, 1, '2021-10-17 19:45:28', 0),
(4, '4', '2', 2, 1, '2021-10-17 19:45:44', 0),
(5, '5', '1', 1, 1, '2021-10-17 19:49:11', 0),
(6, '5', '2', 3, 1, '2021-10-17 19:49:23', 0),
(7, '3', '3', 1, 0, '2021-10-17 20:05:46', 0),
(8, '3', '2', 2, 0, '2021-10-17 20:05:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dckap_order`
--

CREATE TABLE `dckap_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `product_details` varchar(255) DEFAULT NULL,
  `Total_amount` varchar(255) DEFAULT NULL,
  `payment_type` varchar(10) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0 COMMENT '0-active,1-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dckap_order`
--

INSERT INTO `dckap_order` (`id`, `order_id`, `user_id`, `product_details`, `Total_amount`, `payment_type`, `created_date`, `is_delete`) VALUES
(1, 'ORD68992509', '3', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"5\";}', '250', '1', '2021-10-17 19:30:39', 0),
(2, 'ORD1527194164', '4', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', '550', '1', '2021-10-17 19:46:16', 0),
(3, 'ORD1451926442', '5', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', '750', '1', '2021-10-17 19:49:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dckap_product`
--

CREATE TABLE `dckap_product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` varchar(5000) NOT NULL,
  `spec` varchar(5000) DEFAULT NULL,
  `featues` varchar(5000) DEFAULT NULL,
  `guest_price` varchar(100) DEFAULT NULL,
  `customer_price` varchar(100) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(10) DEFAULT NULL,
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dckap_product`
--

INSERT INTO `dckap_product` (`id`, `product_id`, `product_name`, `description`, `spec`, `featues`, `guest_price`, `customer_price`, `created_date`, `created_by`, `is_delete`) VALUES
(1, 'PROD2010591150', 'Petite Table Lamp', 'Color: Multicolor', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '120', '150', '2021-10-17 19:02:01', '7', 0),
(2, 'PROD905540492', 'Petite Table', 'Color: Multicolor', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '170', '200', '2021-10-17 19:03:31', '7', 0),
(3, 'PROD1721512180', 'Table Lamp', 'Color: Multicolor', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '200', '210', '2021-10-17 19:04:45', '7', 0),
(4, 'PROD1646544741', 'LAMP', 'Color: Multicolor', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '130', '150', '2021-10-17 19:06:09', '7', 0),
(5, 'PROD1665364838', 'Lamps', 'Best quality Table Lamp', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '80', '100', '2021-10-17 19:28:22', '1', 0),
(6, 'PROD2084074784', 'Table Lamps', 'Color: Multicolor', 'W x H: 10 cm x 16 cm', 'Power Source: Non-Rechargeable Battery', '230', '250', '2021-10-17 19:53:26', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dckap_product_file`
--

CREATE TABLE `dckap_product_file` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_original_name` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL COMMENT '1-image,2-doc',
  `default_image` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-view on product page',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(10) DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-active,1-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dckap_product_file`
--

INSERT INTO `dckap_product_file` (`id`, `product_id`, `file_original_name`, `file_name`, `type`, `default_image`, `created_date`, `created_by`, `is_delete`) VALUES
(1, 1, 'product-16-2.jpg', '616c732950ef2product-16-2.jpg', '1', 1, '2021-10-17 19:02:01', '7', 0),
(2, 1, 'product-7-2.jpg', '616c732959f8bproduct-7-2.jpg', '1', 0, '2021-10-17 19:02:01', '7', 0),
(3, 1, 'product-7-1.jpg', '616c732961282product-7-1.jpg', '1', 0, '2021-10-17 19:02:01', '7', 0),
(4, 1, 'doc.pdf', '616c73297fcd6doc.pdf', '2', 0, '2021-10-17 19:02:01', '7', 0),
(5, 2, 'product-16-2.jpg', '616c73837496dproduct-16-2.jpg', '1', 1, '2021-10-17 19:03:31', '7', 0),
(6, 2, 'product-7-2.jpg', '616c73839857fproduct-7-2.jpg', '1', 0, '2021-10-17 19:03:31', '7', 0),
(7, 2, 'product-7-1.jpg', '616c7383bc733product-7-1.jpg', '1', 0, '2021-10-17 19:03:31', '7', 0),
(8, 2, 'doc.pdf', '616c7383d21e2doc.pdf', '2', 0, '2021-10-17 19:03:31', '7', 0),
(9, 3, 'product-7-2.jpg', '616c73cd182d6product-7-2.jpg', '1', 1, '2021-10-17 19:04:45', '7', 0),
(10, 3, 'product-7-1.jpg', '616c73cd26d39product-7-1.jpg', '1', 0, '2021-10-17 19:04:45', '7', 0),
(11, 4, 'product-7-2.jpg', '616c74214e099product-7-2.jpg', '1', 1, '2021-10-17 19:06:09', '7', 0),
(12, 5, 'product-16-2.jpg', '616c79560ba2cproduct-16-2.jpg', '1', 1, '2021-10-17 19:28:22', '1', 0),
(13, 5, 'product-7-2.jpg', '616c79561a1afproduct-7-2.jpg', '1', 0, '2021-10-17 19:28:22', '1', 0),
(14, 5, 'product-7-1.jpg', '616c79562a4eaproduct-7-1.jpg', '1', 0, '2021-10-17 19:28:22', '1', 0),
(15, 5, 'doc.pdf', '616c79563b755doc.pdf', '2', 0, '2021-10-17 19:28:22', '1', 0),
(16, 6, 'product-16-2.jpg', '616c7f36f3d5eproduct-16-2.jpg', '1', 1, '2021-10-17 19:53:27', '1', 0),
(17, 6, 'product-7-2.jpg', '616c7f371c63fproduct-7-2.jpg', '1', 0, '2021-10-17 19:53:27', '1', 0),
(18, 6, 'doc.pdf', '616c7f373e70cdoc.pdf', '2', 0, '2021-10-17 19:53:27', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dckap_user`
--

CREATE TABLE `dckap_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_type` tinyint(4) DEFAULT NULL COMMENT '1-admin,2-user',
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dckap_user`
--

INSERT INTO `dckap_user` (`id`, `email`, `mobile_number`, `name`, `password`, `address`, `user_type`, `created_date`, `is_delete`) VALUES
(1, 'admin@gmail.com', '1234567890', 'Admin', 'e6e061838856bf47e1de730719fb2609', 'Columbus, OHIO, US', 1, '2021-10-17 18:52:09', 0),
(2, 'user@gmail.com', '0987654321', 'User', 'ba5ef51294fea5cb4eadea5306f3ca3b', 'Columbus, OHIO, US', 2, '2021-10-17 19:20:58', 0),
(3, 'testuser@gmail.com', '1234567891', 'Test User', '11055975f856b0b7fe95f3a12986e7f1', 'Columbus, Ohio, US', 2, '2021-10-17 19:23:43', 0),
(4, 'usertest@gmail.com', '5987412301', 'User Test', '1e1113834cd38334f4be5bb14053e42c', 'Columbus,Ohio, US', 2, '2021-10-17 19:44:28', 0),
(5, 'test1@gmail.com', '1234587960', 'Test 1', '06d09a188ecbd28dc62ca3f71b9f0cd8', 'Columbus,Ohio,US', 2, '2021-10-17 19:48:23', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dckap_cart`
--
ALTER TABLE `dckap_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dckap_order`
--
ALTER TABLE `dckap_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dckap_product`
--
ALTER TABLE `dckap_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dckap_product_file`
--
ALTER TABLE `dckap_product_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dckap_user`
--
ALTER TABLE `dckap_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dckap_cart`
--
ALTER TABLE `dckap_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dckap_order`
--
ALTER TABLE `dckap_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dckap_product`
--
ALTER TABLE `dckap_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dckap_product_file`
--
ALTER TABLE `dckap_product_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `dckap_user`
--
ALTER TABLE `dckap_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
