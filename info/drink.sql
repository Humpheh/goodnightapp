-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2014 at 11:03 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `goodnighthack`
--

-- --------------------------------------------------------

--
-- Table structure for table `drink`
--

CREATE TABLE IF NOT EXISTS `drink` (
`drink_id` bigint(20) unsigned NOT NULL,
  `drink_name` varchar(100) NOT NULL,
  `drink_percent` float NOT NULL,
  `drink_congener` float DEFAULT NULL,
  `drink_picture` varchar(200) DEFAULT NULL,
  `drink_calories` int(11) DEFAULT NULL,
  `drink_type1` varchar(100) DEFAULT NULL,
  `drink_type2` varchar(100) DEFAULT NULL,
  `drink_type1_ml` float DEFAULT NULL,
  `drink_type2_ml` float DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `drink`
--

INSERT INTO `drink` (`drink_id`, `drink_name`, `drink_percent`, `drink_congener`, `drink_picture`, `drink_calories`, `drink_type1`, `drink_type2`, `drink_type1_ml`, `drink_type2_ml`) VALUES
(1, 'beer', 5, 1, 'guiness.png', 408, '1/2 pint', '1 pint', 284, 568),
(2, 'cider', 5, 1, 'cider.png', 350, '1/2 pint', '1 pint', 284, 568),
(3, 'champagne', 12, 5, 'champagne.png', 712, '1/2 glass', '1 glass', 67.5, 125),
(4, 'white_wine', 12, 5, 'white_wine.png', 840, 'standard glass', 'large glass', 175, 250),
(5, 'red_wine', 12, 8, 'red_wine.png', 840, 'standard glass', 'large glass', 175, 250),
(6, 'gin', 37.5, 3, 'gin.png', 2080, '1 shot', '2 shots', 25, 50),
(7, 'vodka', 37.5, 2, 'vodka.png', 2080, '1 shot', '2 shots', 25, 50),
(8, 'tequilla', 37.5, 4, 'tequilla.png', 2080, '1 shot', '2 shots', 25, 50),
(9, 'rum', 40, 7, 'rum.png', 2440, '1 shot', '2 shots', 25, 50),
(10, 'whiskey', 40, 6, 'whiskey.png', 2440, '1 shot', '2 shots', 25, 50),
(11, 'alcopops', 4, 3, 'alcopops.png', 615, '1/2 pint ', '1 pint', 284, 568),
(12, 'cream_liqueur', 17, 3, 'baileys.png', 3500, '1 shot ', '2 shots', 25, 50),
(13, 'water', 0, -2, 'water.png', 0, '1 bottle', '1 large bottle', 250, 500),
(14, 'soft_drink', 0, -2, 'coke.png', 139, '1/2 pint', 'pint', 284, 568);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drink`
--
ALTER TABLE `drink`
 ADD UNIQUE KEY `drink_id` (`drink_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drink`
--
ALTER TABLE `drink`
MODIFY `drink_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
