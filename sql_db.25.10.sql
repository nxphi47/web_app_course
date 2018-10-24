-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2018 at 09:27 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

CREATE TABLE `highlights` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_app`
--

CREATE TABLE `job_app` (
  `id` int(11) NOT NULL,
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci NOT NULL,
  `ic` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `experience` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `promoted_price` float DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `ingredients` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `type`, `unit`, `price`, `promoted_price`, `note`, `desc`, `ingredients`, `thumbnail`, `images`) VALUES
(30, 'Original Pizzarino', 'pizza', 'piece', 10, 6, 'some random note', 'Pizza originated from Italy, with Singapore flavors…..', 'carbohydrate:10g,pine apple:15g', 'pizza_1_tn.jpg', 'pizza_1.jpg'),
(31, 'Tomato delight', 'pizza', 'piece', 8, 6, '', 'Pizza with  hearty fill of tomatoes catered to tomato lovers.', '', 'pizza_2_tn.jpg', 'pizza_2.jpg'),
(33, 'Mexican pizza', 'pizza', 'piece', 7, 0, '', 'This mexican dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_4_tn.jpg', 'pizza_4.jpg'),
(34, 'One of a kind', 'pizza', 'piece', 7, 0, '', 'This exotic dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_5_tn.jpg', 'pizza_5.jpg'),
(35, 'Cool kidz', 'pizza', 'piece', 6, 0, '', 'This unique dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_6_tn.jpg', 'pizza_6.jpg'),
(36, 'Cheesy mozzarella', 'pizza', 'piece', 7, 0, '', 'Cheesy mozzerella pizza you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_7_tn.jpg', 'pizza_7.jpg'),
(37, 'Thin crust', 'pizza', 'piece', 8, 0, '', 'Known for our thin crust. Our restaurant serves it crisp and delicious. Order or take in now!', '', 'pizza_8_tn.jpg', 'pizza_8.jpg'),
(38, 'Spinach treat', 'pizza', 'piece', 8, 0, '', 'This spinach dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_9_tn.jpg', 'pizza_9.jpg'),
(39, 'Fish delight', 'pasta', 'Plate', 12, 11, '', '', '', 'pasta_1_tn.jpg', 'pasta_1.jpg'),
(40, 'Lobster alfredo', 'pasta', 'Plate', 11, 15, '', '', '', 'pasta_2_tn.jpg', 'pasta_2.jpg'),
(41, 'Bolognese ', 'pasta', 'Plate', 12, 11, '', '', '', 'pasta_3_tn.jpg', 'pasta_3.jpg'),
(42, 'Beef delight', 'pasta', 'Plate', 14, 13, '', '', '', 'pasta_4_tn.jpg', 'pasta_4.jpg'),
(43, 'Bow tie farfalle', 'pasta', 'Plate', 14, 13, '', 'Interesting mix of strawberries and cheese with bow tie pasta. Served deliciously hot or cold.', '', 'pasta_5_tn.jpg', 'pasta_5.jpg'),
(44, 'Baked rice- chicken', 'pasta', 'Plate', 12, 0, '', '', '', 'pasta_6_tn.jpg', 'pasta_6.jpg'),
(45, 'Baked rice- ham', 'pasta', 'Plate', 12, 0, '', '', '', 'pasta_7_tn.jpg', 'pasta_7.jpg'),
(46, 'Shrooms delight', 'pasta', 'Plate', 11, 0, '', '', '', 'pasta_8_tn.jpg', 'pasta_8.jpg'),
(47, 'Tomato Soup pasta', 'pasta', 'Plate', 11, 0, '', '', '', 'pasta_9_tn.jpg', 'pasta_9.jpg'),
(48, 'Sprite', 'Beverage', 'Bottle', 2, 0, '', '', '', 'beverage_1_tn.jpg', 'beverage_1.jpg'),
(49, 'Coca-cola', 'Beverage', 'Bottle', 2, 0, '', '', '', 'beverage_2_tn.jpg', 'beverage_2.jpg'),
(50, 'Root beer', 'Beverage', 'Bottle', 2, 0, '', '', '', 'beverage_3_tn.jpg', 'beverage_3.jpg'),
(51, 'Orange fanta', 'Beverage', 'Bottle', 2, 0, '', '', '', 'beverage_4_tn.jpg', 'beverage_4.jpg'),
(52, '7-up', 'Beverage', 'Bottle', 2, 0, '', '', '', 'beverage_5_tn.jpg', 'beverage_5.jpg'),
(54, 'Mushroom soup', 'Beverage', 'Bowl', 4, 2, '', '', '', 'soup_2_tn.jpg', 'soup_2.jpg'),
(55, 'Green tea', 'Beverage', 'cup', 2, 0, '', '', '', 'beverage_7_tn.jpg', 'beverage_7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_items` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `total` float NOT NULL,
  `delivery_subtotal` float NOT NULL,
  `orders_subtotal` float NOT NULL,
  `dev_name` text COLLATE utf8_unicode_ci NOT NULL,
  `dev_phone` int(11) NOT NULL,
  `dev_address` text COLLATE utf8_unicode_ci NOT NULL,
  `postal` int(11) DEFAULT NULL,
  `pay_name` text COLLATE utf8_unicode_ci NOT NULL,
  `pay_card_num` int(11) NOT NULL,
  `pay_card_expire` date NOT NULL,
  `cv2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `itemset` text COLLATE utf8_unicode_ci,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci NOT NULL,
  `uname` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `pay_name` text COLLATE utf8_unicode_ci,
  `pay_card_num` int(11) DEFAULT NULL,
  `pay_card_expire` date DEFAULT NULL,
  `cv2` text COLLATE utf8_unicode_ci,
  `dev_name` text COLLATE utf8_unicode_ci,
  `dev_phone` int(11) DEFAULT NULL,
  `dev_address` int(11) DEFAULT NULL,
  `postal` int(11) DEFAULT NULL,
  `notes` int(11) DEFAULT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `uname`, `password`, `email`, `pay_name`, `pay_card_num`, `pay_card_expire`, `cv2`, `dev_name`, `dev_phone`, `dev_address`, `postal`, `notes`, `admin`) VALUES
(1, 'Phi', 'Nguyen', 'nxphi47', 'e10adc3949ba59abbe56e057f20f883e', 'nxphi47@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Ha', 'Uyen', 'hauyen', 'e10adc3949ba59abbe56e057f20f883e', 'hauyen@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 'Hello world fi', 'xuan phi', 'xuanphi001', 'e10adc3949ba59abbe56e057f20f883e', 'xuanphi001@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_app`
--
ALTER TABLE `job_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
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
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_app`
--
ALTER TABLE `job_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
