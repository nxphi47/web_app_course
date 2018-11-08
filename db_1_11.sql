-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2018 at 10:59 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `f38ee`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dev_name` text COLLATE utf8_unicode_ci NOT NULL,
  `dev_phone` int(11) NOT NULL,
  `dev_address` text COLLATE utf8_unicode_ci NOT NULL,
  `postal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `dev_name`, `dev_phone`, `dev_address`, `postal`) VALUES
(1, 1, 'Xuan Phi', 12345678, '30 Nanyang Link', 637717);

-- --------------------------------------------------------

--
-- Table structure for table `credit_cards`
--

CREATE TABLE IF NOT EXISTS `credit_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pay_name` text COLLATE utf8_unicode_ci NOT NULL,
  `pay_card_num` int(11) NOT NULL,
  `pay_card_expire` date NOT NULL,
  `cv2` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `credit_cards`
--

INSERT INTO `credit_cards` (`id`, `user_id`, `pay_name`, `pay_card_num`, `pay_card_expire`, `cv2`) VALUES
(17, 1, 'xuan phi nguyen', 2147483647, '2018-10-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `stars`, `note`) VALUES
(1, 1, 4, 'The website presents lots of nice food and beverage and the service is wonderful. Nice!'),
(2, 2, 5, 'This restaurant serves the best pizza locally like no other. Would really recommend their pizzas to everyone visiting Singapore.'),
(3, 3, 5, 'Their service is great! My child was on my lap when a waitress came and brought a baby chair for me. I was really surprised and grateful for that action. Cheerios to that staff!'),
(4, 4, 4, 'I ordered a delivery to my office when it was Christmas. The food came in after 30 mins. It was understandable though because it was seasonal period. However, I still received the $10 vouchers for my next order! It was great that Pizzarino honour their word and it shows how committed they are.');

-- --------------------------------------------------------

--
-- Table structure for table `job_app`
--

CREATE TABLE IF NOT EXISTS `job_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci NOT NULL,
  `ic` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `experience` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `job_app`
--

INSERT INTO `job_app` (`id`, `fname`, `lname`, `ic`, `note`, `experience`, `phone`, `email`) VALUES
(10, 'Nguyen', 'Phi', 'G1190229W', '', 'askdjaskldjalksjdasd', 84834978, 'nxphi47@gmail.com'),
(11, '', '', '', '', '', 0, ''),
(12, '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `diet` int(11) DEFAULT '0' COMMENT '0=normal,1=vegetarian,2=halal',
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `promoted_price` float DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `ingredients` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=83 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `type`, `diet`, `unit`, `price`, `promoted_price`, `note`, `desc`, `ingredients`, `thumbnail`, `images`) VALUES
(30, 'Original Pizzarino', 'pizza', 1, 'piece', 10, 8, 'some random note', 'Pizza originated from Italy, with Singapore flavor .', 'carbohydrate:10g,pine apple:15g', 'pizza_1.jpg', 'pizza_1.jpg'),
(31, 'Tomato delight', 'pizza', 2, 'piece', 8, 6, '', 'Pizza with  hearty fill of tomatoes catered to tomato lovers.', '', 'pizza_2.jpg', 'pizza_2.jpg'),
(33, 'Mexican pizza', 'pizza', 0, 'piece', 7, 0, '', 'This mexican dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_4.jpg', 'pizza_4.jpg'),
(34, 'One of a kind', 'pizza', 0, 'piece', 7, 0, '', 'This exotic dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_5.jpg', 'pizza_5.jpg'),
(35, 'Cool kidz', 'pizza', 0, 'piece', 6, 0, '', 'This unique dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_6.jpg', 'pizza_6.jpg'),
(36, 'Cheesy mozzarella', 'pizza', 1, 'piece', 7, 0, '', 'Cheesy mozzerella pizza you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_7.jpg', 'pizza_7.jpg'),
(37, 'Thin crust', 'pizza', 0, 'piece', 8, 0, '', 'Known for our thin crust. Our restaurant serves it crisp and delicious. Order or take in now!', '', 'pizza_8.jpg', 'pizza_10.jpg'),
(38, 'Spinach treat', 'pizza', 1, 'piece', 8, 0, '', 'This spinach dish you can order today and in the office and at home. Hot pizza fit for a snack at lunchtime, and treats for friends. And if you believe one online survey, almost 80 % of Internet users called pizza favorite meal.', '', 'pizza_9.jpg', 'pizza_9.jpg'),
(39, 'Fish delight', 'pasta', 2, 'Plate', 12, 11, '', '', '', 'pasta_1.jpg', 'pasta_1.jpg'),
(40, 'Lobster alfredo', 'pasta', 2, 'Plate', 11, 15, '', '', '', 'pasta_2.jpg', 'pasta_2.jpg'),
(41, 'Bolognese ', 'pasta', 0, 'Plate', 12, 11, '', '', '', 'pasta_3.jpg', 'pasta_3.jpg'),
(42, 'Beef delight', 'pasta', 2, 'Plate', 14, 13, '', '', '', 'pasta_4.jpg', 'pasta_4.jpg'),
(43, 'Bow tie farfalle', 'pasta', 0, 'Plate', 14, 13, '', 'Interesting mix of strawberries and cheese with bow tie pasta. Served deliciously hot or cold.', '', 'pasta_5.jpg', 'pasta_5.jpg'),
(44, 'Baked rice- chicken', 'pasta', 0, 'Plate', 12, 0, '', '', '', 'pasta_6.jpg', 'pasta_6.jpg'),
(45, 'Baked rice- ham', 'pasta', 0, 'Plate', 12, 0, '', '', '', 'pasta_7.jpg', 'pasta_7.jpg'),
(46, 'Shrooms delight', 'pasta', 2, 'Plate', 11, 0, '', '', '', 'pasta_8.jpg', 'pasta_8.jpg'),
(47, 'Tomato Soup pasta', 'pasta', 2, 'Plate', 11, 0, '', '', '', 'pasta_9.jpg', 'pasta_9.jpg'),
(48, 'Sprite', 'Beverage', 0, 'Bottle', 2, 0, '', '', '', 'beverage_1.jpg', 'beverage_1.jpg'),
(49, 'Coca-cola', 'Beverage', 0, 'Bottle', 2, 0, '', '', '', 'beverage_2.jpg', 'beverage_2.jpg'),
(50, 'Root beer', 'Beverage', 0, 'Bottle', 2, 0, '', '', '', 'beverage_3.jpg', 'beverage_3.jpg'),
(51, 'Orange fanta', 'Beverage', 0, 'Bottle', 2, 0, '', '', '', 'beverage_4.jpg', 'beverage_4.jpg'),
(52, '7-up', 'Beverage', 0, 'Bottle', 2, 0, '', '', '', 'beverage_5.jpg', 'beverage_5.jpg'),
(54, 'Mushroom soup', 'Beverage', 1, 'Bowl', 4, 2, '', '', '', 'soup_2.jpg', 'soup_2.jpg'),
(55, 'Green tea', 'Beverage', 0, 'cup', 2, 0, '', '', '', 'beverage_7.jpg', 'beverage_7.jpg'),
(56, 'Set meal', 'promotion', 0, 'Set', 10, 8, '', 'Come and enjoy a delightful meal this Christmas! Includes a pizza and your choice of beverage.', '', 'banner_1.jpg', 'banner_1.jpg'),
(57, 'Family of 3-4 deal', 'Promotion', 0, 'Set', 90, 88, 'Come and have a delightful meal with your loved ones this Christmas! Bolognese spaghetti, cheesy capsicum pizza, 1/2 honey ham, and a bowl of salad. Serves 3-4 people.', '', '', 'banner_2.jpg', 'banner_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cv2` int(11) NOT NULL,
  `is_paid` int(11) NOT NULL DEFAULT '0',
  `paid_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`cart_id`, `user_id`, `order_items`, `note`, `total`, `delivery_subtotal`, `orders_subtotal`, `dev_name`, `dev_phone`, `dev_address`, `postal`, `pay_name`, `pay_card_num`, `pay_card_expire`, `cv2`, `is_paid`, `paid_date`) VALUES
(31, 1, 'item=31#quantity=2#comment=asfasfsaf@item=33#quantity=1#comment=hello@item=30#quantity=1#comment=asfasf', '', 34.2, 1.2, 33, 'Nguyen Xuan Phi', 84834978, '30 nanyang link, block 39, #1-731', 637717, 'Nguyen Xuan Phi', 1234567890, '2018-10-30', 5125, 1, '2018-10-26 18:33:07'),
(37, 1, 'item=31#quantity=1#comment=@item=36#quantity=1#comment=@item=39#quantity=1#comment=@item=38#quantity=1#comment=@item=37#quantity=1#comment=@item=42#quantity=1#comment=', '', 54.2, 1.2, 53, 'Nguyen Xuan Phi', 84834978, '30 nanyang link, block 39, #1-731', 637717, 'Nguyen Xuan Phi', 1234567890, '2018-10-31', 133, 1, '2018-10-30 17:29:40'),
(38, 1, 'item=31#quantity=1#comment=@item=36#quantity=1#comment=@item=39#quantity=1#comment=@item=38#quantity=1#comment=@item=37#quantity=1#comment=@item=42#quantity=1#comment=', '', 54.2, 1.2, 53, 'Nguyen Xuan Phi', 84834978, '30 nanyang link, block 39, #1-731', 637717, 'Nguyen Xuan Phi', 1234567890, '2018-11-01', 133, 1, '2018-10-30 17:30:10'),
(39, 1, 'item=31#quantity=1#comment=@item=36#quantity=1#comment=@item=39#quantity=1#comment=@item=38#quantity=1#comment=@item=37#quantity=1#comment=@item=42#quantity=1#comment=', '', 54.2, 1.2, 53, 'Nguyen Xuan Phi', 84834978, '30 nanyang link, block 39, #1-731', 637717, 'Nguyen Xuan Phi', 1234567890, '2018-11-22', 133, 1, '2018-10-30 17:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart` (`cart_id`),
  KEY `item` (`item_id`),
  KEY `user_order_item` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `user_id`, `cart_id`, `item_id`, `quantity`, `comment`) VALUES
(5, 1, 31, 31, 2, 'asfasfsaf'),
(6, 1, 31, 33, 1, 'hello'),
(7, 1, 31, 30, 1, 'asfasf'),
(8, 1, 37, 31, 1, ''),
(9, 1, 37, 36, 1, ''),
(10, 1, 37, 39, 1, ''),
(11, 1, 37, 38, 1, ''),
(12, 1, 37, 37, 1, ''),
(13, 1, 37, 42, 1, ''),
(14, 1, 38, 31, 1, ''),
(15, 1, 38, 36, 1, ''),
(16, 1, 38, 39, 1, ''),
(17, 1, 38, 38, 1, ''),
(18, 1, 38, 37, 1, ''),
(19, 1, 38, 42, 1, ''),
(20, 1, 39, 31, 1, ''),
(21, 1, 39, 36, 1, ''),
(22, 1, 39, 39, 1, ''),
(23, 1, 39, 38, 1, ''),
(24, 1, 39, 37, 1, ''),
(25, 1, 39, 42, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `size` char(50) NOT NULL,
  `price` float(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `size`, `price`) VALUES
(1, 'justJava', 'single', 2.00),
(2, 'cafeauLait', 'single', 2.00),
(3, 'cafeauLait', 'doub', 3.00),
(4, 'icedCapp', 'single', 4.75),
(5, 'icedCapp', 'doub', 5.75);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `itemset` text COLLATE utf8_unicode_ci,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `admin` int(11) NOT NULL,
  `confirm` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `uname`, `password`, `email`, `pay_name`, `pay_card_num`, `pay_card_expire`, `cv2`, `dev_name`, `dev_phone`, `dev_address`, `postal`, `notes`, `admin`, `confirm`) VALUES
(0, 'placeholder', 'placeholder', 'admin_place_holder_do_not_use_this', 'placeholder', 'placeholder@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(1, 'Phi', 'Nguyen', 'nxphi47', 'e10adc3949ba59abbe56e057f20f883e', 'nxphi47@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(2, 'John', 'Parsons', 'JPson', '12345', 'johnparsons@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(3, 'Megan', 'Fox', 'Megan', '12345', 'megan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(4, 'Pearly', 'Lee', 'Pearly Lee', '12345', 'pearly@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(5, 'Joyce', 'Teo', 'Joyce', '84fed1e3ee4f91c38fcf6b530ff202e4', '123@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
(6, 'sadf', 'Teo', 'lkfnerih;', '92e751833a88c67c4d2b071946053365', 'adf@adf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addr_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD CONSTRAINT `user_card` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `user_feedback` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `cart` FOREIGN KEY (`cart_id`) REFERENCES `orders` (`cart_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `item` FOREIGN KEY (`item_id`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_order_items` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
