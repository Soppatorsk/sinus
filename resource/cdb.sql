-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2023 at 01:51 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sinus_skate`
--
CREATE DATABASE IF NOT EXISTS `sinus_skate` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sinus_skate`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `SP_MakeOrder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MakeOrder` (IN `in_Email` VARCHAR(100), OUT `out_OrderID` INT)   BEGIN

DECLARE _customerID INT;

SELECT CustomerID INTO _customerID FROM customers
WHERE Email = in_Email;

INSERT INTO orders (CustomerID)
VALUES (_customerID);

SELECT LAST_INSERT_ID() INTO out_OrderID ;

END$$

DROP PROCEDURE IF EXISTS `SP_PlaceOrder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PlaceOrder` (IN `_OrderID` INT, IN `_ProductID` INT, IN `_Qty` INT)   BEGIN

DECLARE _price INT;
DECLARE totalPrice INT;

SELECT Price INTO @_price FROM products
WHERE ProductID = _ProductID;

SET @totalPrice = @_price * _Qty;

INSERT INTO orderdetails (OrderID, ProductID, Price, Qty, TotalPrice)
VALUES (_OrderID, _ProductID, @_price, _Qty, @totalPrice);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`, `Description`) VALUES
(1, 'Hoodie', 'A Hoodie'),
(2, 'Cap', 'A Cap'),
(3, 'T-Shirt', 'A T-Shirt'),
(4, 'Wheels', 'Wheels'),
(5, 'Boards', 'Boards');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `FirstName` varchar(10) NOT NULL,
  `LastName` varchar(10) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `ZipCode` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE `orderdetails` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `TotalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL COMMENT 'FK to CustomerID in customers',
  `OrderDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productimages`
--

DROP TABLE IF EXISTS `productimages`;
CREATE TABLE `productimages` (
  `id` int(11) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productimages`
--

INSERT INTO `productimages` (`id`, `url`) VALUES
(1, 'hoodie-ash.png'),
(2, 'hoodie-fire.png'),
(3, 'hoodie-green.png'),
(4, 'hoodie-ocean.png'),
(5, 'hoodie-purple.png'),
(6, 'hoodie-ash.png'),
(7, 'hoodie-fire.png'),
(8, 'hoodie-green.png'),
(9, 'hoodie-ocean.png'),
(10, 'hoodie-purple.png'),
(11, 'hoodie-ash.png'),
(12, 'hoodie-fire.png'),
(13, 'hoodie-green.png'),
(14, 'hoodie-ocean.png'),
(15, 'hoodie-purple.png'),
(16, 'sinus-cap-blue.png'),
(17, 'sinus-cap-green.png'),
(18, 'sinus-cap-purple.png'),
(19, 'sinus-cap-red.png'),
(20, 'sinus-cap-blue.png'),
(21, 'sinus-cap-green.png'),
(22, 'sinus-cap-purple.png'),
(23, 'sinus-cap-red.png'),
(24, 'sinus-cap-blue.png'),
(25, 'sinus-cap-green.png'),
(26, 'sinus-cap-purple.png'),
(27, 'sinus-cap-red.png'),
(28, 'sinus-tshirt-blue.png'),
(29, 'sinus-tshirt-pink.png'),
(30, 'sinus-tshirt-purple.png'),
(31, 'sinus-tshirt-yellow.png'),
(32, 'sinus-tshirt-grey.png'),
(33, 'sinus-tshirt-blue.png'),
(34, 'sinus-tshirt-pink.png'),
(35, 'sinus-tshirt-purple.png'),
(36, 'sinus-tshirt-yellow.png'),
(37, 'sinus-tshirt-grey.png'),
(38, 'sinus-tshirt-blue.png'),
(39, 'sinus-tshirt-grey.png'),
(40, 'sinus-tshirt-pink.png'),
(41, 'sinus-tshirt-purple.png'),
(42, 'sinus-tshirt-yellow.png'),
(43, 'sinus-wheel-spinner.png'),
(44, 'sinus-wheel-rocket.png'),
(45, 'sinus-wheel-wave.png'),
(43, 'sinus-skateboard-eagle.png'),
(44, 'sinus-skateboard-fire.png'),
(45, 'sinus-skateboard-gretasfury.png'),
(46, 'sinus-skateboard-ink.png'),
(47, 'sinus-skateboard-logo.png'),
(48, 'sinus-skateboard-northern_lights.png'),
(49, 'sinus-skateboard-plastic.png'),
(50, 'sinus-skateboard-polar.png'),
(51, 'sinus-skateboard-purple.png'),
(52, 'sinus-skateboard-eagle.png'),
(53, 'sinus-skateboard-fire.png'),
(54, 'sinus-skateboard-yellow.png'),
(55, 'sinus-skateboard-gretasfury.png'),
(1, 'juholt.png'),
(1, 'evilKermit.jpg'),
(27, 'trumpRedCap.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL COMMENT 'FK to catrgory on CategoryID',
  `Colour` varchar(10) NOT NULL,
  `Size` varchar(20) DEFAULT NULL,
  `Price` int(11) NOT NULL,
  `Description` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `CategoryID`, `Colour`, `Size`, `Price`, `Description`) VALUES
(1, 1, 'Black', 'Large', 599, 'Juholts favorit.'),
(2, 1, 'Red', 'Large', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(3, 1, 'Green', 'Large', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(4, 1, 'Blue', 'Large', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(5, 1, 'Purple', 'Large', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(6, 1, 'Black', 'Medium', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(7, 1, 'Red', 'Medium', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(8, 1, 'Green', 'Medium', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(9, 1, 'Blue', 'Medium', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(10, 1, 'Purple', 'Medium', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(11, 1, 'Black', 'Small', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(12, 1, 'Red', 'Small', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(13, 1, 'Green', 'Small', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(14, 1, 'Blue', 'Small', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(15, 1, 'Purple', 'Small', 599, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(16, 2, 'Blue', 'Small', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(17, 2, 'Green', 'Small', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(18, 2, 'Purple', 'Small', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(19, 2, 'Red', 'Small', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(20, 2, 'Blue', 'Medium', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(21, 2, 'Green', 'Medium', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(22, 2, 'Purple', 'Medium', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(23, 2, 'Red', 'Medium', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(24, 2, 'Blue', 'Large', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(25, 2, 'Green', 'Large', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(26, 2, 'Purple', 'Large', 499, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(27, 2, 'Red', 'Large', 499, 'Make America Great Again. Donald Trump'),
(28, 3, 'Blue', 'Large', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(29, 3, 'Pink', 'Large', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(30, 3, 'Purple', 'Large', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(31, 3, 'Yellow', 'Large', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(32, 3, 'Black', 'Large', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(33, 3, 'Blue', 'Medium', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(34, 3, 'Pink', 'Medium', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(35, 3, 'Purple', 'Medium', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(36, 3, 'Yellow', 'Medium', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(37, 3, 'Black', 'Medium', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(38, 3, 'Blue', 'Small', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(39, 3, 'Black', 'Small', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(40, 3, 'Pink', 'Small', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(41, 3, 'Purple', 'Small', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(42, 3, 'Yellow', 'Small', 299, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(43, 4, 'White', NULL, 799, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(44, 4, 'Red', NULL, 799, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(45, 4, 'Black', NULL, 799, 'Lorem ipsum dolor sit amet. Est voluptate voluptatum a velit galisum eos repellat laboriosam sed vo'),
(46, 5, 'Motive', NULL, 1099, 'Ink'),
(47, 5, 'Motive', NULL, 1099, 'Wood Logo'),
(48, 5, 'Motive', NULL, 1099, 'Northern Lights'),
(49, 5, 'Motive', NULL, 1099, 'Plastic'),
(50, 5, 'Motive', NULL, 1099, 'Polar'),
(51, 5, 'Motive', NULL, 1099, 'Purple'),
(52, 5, 'Motive', NULL, 1099, 'Eagle'),
(53, 5, 'Motive', NULL, 1099, 'Fire'),
(54, 5, 'Motive', NULL, 1099, 'Yellow'),
(55, 5, 'Motive', NULL, 1099, 'Gretas Fury');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
