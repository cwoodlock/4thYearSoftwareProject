-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 27, 2019 at 02:47 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

DROP TABLE IF EXISTS `contest`;
CREATE TABLE IF NOT EXISTS `contest` (
  `contestID` int(11) NOT NULL AUTO_INCREMENT,
  `isOpen` tinyint(4) NOT NULL DEFAULT '0',
  `odds_team1` decimal(6,0) NOT NULL,
  `odds_team2` decimal(6,0) NOT NULL,
  `odds_draw` decimal(6,0) NOT NULL,
  `team1` varchar(255) NOT NULL,
  `team2` varchar(255) NOT NULL,
  `memberBets_memberBetID` int(11) NOT NULL,
  `lay_team1` decimal(10,0) NOT NULL,
  `lay_team2` decimal(10,0) NOT NULL,
  `lay_draw` decimal(10,0) NOT NULL,
  PRIMARY KEY (`contestID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contest`
--

INSERT INTO `contest` (`contestID`, `isOpen`, `odds_team1`, `odds_team2`, `odds_draw`, `team1`, `team2`, `memberBets_memberBetID`, `lay_team1`, `lay_team2`, `lay_draw`) VALUES
(1, 0, '1', '3', '10', 'Jack Hermansson', 'Ronalso Souza', 0, '4', '5', '10'),
(2, 0, '5', '6', '7', 'Dmitrii Smoliakov', 'Greg Hardy', 0, '3', '5', '10');

-- --------------------------------------------------------

--
-- Table structure for table `memberbets`
--

DROP TABLE IF EXISTS `memberbets`;
CREATE TABLE IF NOT EXISTS `memberbets` (
  `betID` int(11) NOT NULL AUTO_INCREMENT,
  `contestID` int(11) NOT NULL,
  `usersID` int(11) NOT NULL,
  `betName` varchar(255) NOT NULL,
  `betAmount` int(11) NOT NULL,
  `betOdds` int(11) NOT NULL,
  `betType` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`betID`)
) ENGINE=MyISAM AUTO_INCREMENT=9539 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberbets`
--

INSERT INTO `memberbets` (`betID`, `contestID`, `usersID`, `betName`, `betAmount`, `betOdds`, `betType`) VALUES
(9519, 1, 7, 'Jack Hermansson', 55, 1, 0),
(9532, 1, 7, 'Jack Hermansson', 100, 4, 1),
(9530, 1, 7, 'Jack Hermansson', 100, 1, 0),
(9523, 1, 7, 'Draw', 55, 10, 1),
(9531, 1, 7, 'Jack Hermansson', 25, 4, 1),
(9529, 1, 7, 'Draw', 25, 10, 1),
(9527, 1, 7, 'Ronalso Souza', 55, 3, 0),
(9528, 1, 7, 'Jack Hermansson', 15, 1, 0),
(9533, 1, 7, 'Jack Hermansson', 25, 4, 1),
(9534, 1, 7, 'Jack Hermansson', 11, 4, 1),
(9535, 1, 7, 'Jack Hermansson', 55, 4, 1),
(9536, 1, 7, 'Jack Hermansson', 15, 4, 1),
(9537, 1, 7, 'Jack Hermansson', 25, 1, 0),
(9538, 1, 7, 'Jack Hermansson', 100, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `credit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `validation_code`, `active`, `credit`) VALUES
(7, 'Brian', 'O\'Connor', 'boconnor@gmail.com', 'boconnor', '202cb962ac59075b964b07152d234b70', '723e1ed8f2bf00f4de70ad8728645696', 1, -100);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
