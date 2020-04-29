-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 04:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloth_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE `clothes` (
  `cloth_name` varchar(50) NOT NULL,
  `cloth_ID` int(11) NOT NULL,
  `cloth_type` varchar(20) NOT NULL,
  `year_released` date NOT NULL,
  `developer` varchar(20) NOT NULL,
  `price` double(5,2) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `num_sold` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clothes`
--

INSERT INTO `clothes` (`cloth_name`, `cloth_ID`, `cloth_type`, `year_released`, `developer`, `price`, `stock_qty`, `image`, `num_sold`) VALUES
('Way Penny Drivers', 7, 'Role-Playing', '2015-02-15', 'Blizzard', 59.99, 37, 'product-images/sh5.jpg', 27),
('Ashmont Way Penny ', 9, 'Role-Playing', '2014-08-22', 'Ubisoft', 22.99, 20, 'product-images/sh1.jpg', 0),
('Super Skinny Jeans', 10, 'jean', '2015-08-23', 'Electronic Arts', 59.99, 17, 'product-images/j1.jpg', 3),
('Mid-Rise Skinny Jeans', 11, 'jean', '2019-04-08', 'Electronic Arts', 69.99, 20, 'product-images/j12.jpg', 0),
('Low-Rise Jean Leggings', 12, 'FPS', '2017-06-22', 'Electronic Arts', 24.99, 0, 'product-images/j4.jpg', 20),
('Ashmont Way Drivers', 13, 'Role-Playing', '2012-07-16', '2K Games', 22.99, 20, 'product-images/sh2.jpg', 0),
('Mid-Rise Boot Jeans', 14, 'FPS', '2019-05-04', '2K Games', 69.99, 18, 'product-images/j10.jpg', 2),
('Stretch High-Rise Jean', 15, 'jean', '2019-07-25', 'Treyarch', 69.99, 20, 'product-images/j13.jpg', 0),
('Stretch Jean Leggings', 18, 'jean', '2017-05-17', 'Rockstar Games', 45.99, 5, 'product-images/j17.jpg', 0),
('High-Rise Jean Leggings', 19, 'jean', '2017-05-17', 'Electronic Arts', 4.99, 5, 'product-images/j16.jpg', 0),
('Curved Hem T-Shirt', 24, 'Fighter', '2018-09-15', 'Electronic Arts', 24.99, 3, 'product-images/s6.jpg', 2),
('Kennebunk Sport Shirt', 25, 'Fighter', '2019-08-16', '2K Games', 47.99, 4, 'product-images/s7.jpg', 1),
('Crewneck Shirt', 26, 'Fighter', '2015-04-23', 'BANDAI NAMCO', 45.99, 10, 'product-images/s8.jpg', 0),
('Sunwash Canvas Shirt', 27, 'Fighter', '2008-01-21', 'Nintindo', 49.99, 10, 'product-images/s10.jpg', 0),
('Stretch Poplin Shirt', 28, 'Fighter', '2015-04-07', 'NetherRealm Studios', 45.99, 10, 'product-images/s11.jpg', 0),
('Comfort Stretch Shirt', 29, 'Fighter', '2008-05-14', 'Capcom', 41.99, 10, 'product-images/s16.jpg', 0),
('Chamois Shirt', 30, 'Fighter', '2013-04-03', 'NetherRealm Studios', 46.99, 10, 'product-images/s17.jpg', 0),
('Signature Seersucker Shirt', 31, 'Fighter', '2017-05-03', 'NetherRealm Studios', 42.99, 10, 'product-images/s20.jpg', 0),
('Cotrell Case Oxfords', 32, 'Role-Playing', '2015-05-23', 'Bethesda', 45.99, 10, 'product-images/sh12.jpg', 0),
('Cotrell Edge Oxfords', 33, 'Role-Playing', '2016-07-08', 'Bethesda', 59.99, 20, 'product-images/sh6.jpg', 0),
('Grand Wing Oxfords', 34, 'Role-Playing', '2019-02-15', 'Guerrilla Games', 24.99, 20, 'product-images/sh15.jpg', 0),
('Mid-Rise Big Jeans', 40, 'jean', '2016-05-15', 'Bungie', 99.99, 1, 'product-images/j19.jpg', 19),
('Super Skin Jean', 41, 'jean', '2020-04-12', 'Electronic Arts', 59.99, 100, 'product-images/j21.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `cloth_ID` varchar(20) NOT NULL,
  `order_date` date NOT NULL,
  `cloth_name` varchar(20) NOT NULL,
  `order_confirmation` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
  `user_pass` varchar(20) NOT NULL,
  `num_purchased_clothes` int(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `user_email`, `user_fname`, `user_lname`, `user_pass`, `num_purchased_clothes`, `is_admin`) VALUES
(12, 'Something@aol.com', 'huy', 'duong', '123456789', 6, 1),
(13, 'Ihaveanother@aol.com', 'si', 'dang', '123456789', 1, 0),
(16, 'Something2@aol.com', 'james', 'camamel', '123456789', 0, 0),
(17, 'Something10@aol.com', 'si', 'dang1', '123456789', 8, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`cloth_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clothes`
--
ALTER TABLE `clothes`
  MODIFY `cloth_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
