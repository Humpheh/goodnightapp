-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2014 at 11:10 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`session_id` bigint(20) unsigned NOT NULL,
  `session_user_id` bigint(20) unsigned DEFAULT NULL,
  `session_timestart` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_timefinish` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessiondrink`
--

CREATE TABLE IF NOT EXISTS `sessiondrink` (
`sessdr_id` bigint(20) unsigned NOT NULL,
  `sessdr_session_id` bigint(20) unsigned DEFAULT NULL,
  `sessdr_drink_id` bigint(20) unsigned DEFAULT NULL,
  `sessdr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sessdr_volume` int(11) DEFAULT NULL,
  `sessdr_ebac_before` float NOT NULL,
  `sessdr_ebac_after` float NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` bigint(20) unsigned NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_weight` int(11) DEFAULT NULL,
  `user_gender` enum('none','male','female') DEFAULT NULL,
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_weight`, `user_gender`, `user_created`) VALUES
(1, 'Dom', '$2a$07$afsnu3rnw9i3r80m93091OMRHYVK3LMntEz8Jj9HtVS9R/znqyZJS', 80, 'male', '2014-11-08 21:32:01'),
(2, 'humph', '$2a$07$afsnu3rnw9i3r80m93091OMRHYVK3LMntEz8Jj9HtVS9R/znqyZJS', 90, 'male', '2014-11-08 21:38:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drink`
--
ALTER TABLE `drink`
 ADD UNIQUE KEY `drink_id` (`drink_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
 ADD UNIQUE KEY `session_id` (`session_id`), ADD KEY `session_user_id` (`session_user_id`);

--
-- Indexes for table `sessiondrink`
--
ALTER TABLE `sessiondrink`
 ADD UNIQUE KEY `sessdr_id` (`sessdr_id`), ADD KEY `sessdr_session_id` (`sessdr_session_id`), ADD KEY `sessdr_drink_id` (`sessdr_drink_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drink`
--
ALTER TABLE `drink`
MODIFY `drink_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
MODIFY `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sessiondrink`
--
ALTER TABLE `sessiondrink`
MODIFY `sessdr_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `session`
--
ALTER TABLE `session`
ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`session_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessiondrink`
--
ALTER TABLE `sessiondrink`
ADD CONSTRAINT `sessiondrink_ibfk_1` FOREIGN KEY (`sessdr_session_id`) REFERENCES `session` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sessiondrink_ibfk_2` FOREIGN KEY (`sessdr_drink_id`) REFERENCES `drink` (`drink_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
