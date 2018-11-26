/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Colm
 * Created: Nov 26, 2018
 */

CREATE DATABASE IF NOT EXISTS `newtest`;
USE `newtest`;

-- Dumping structure for table newtest.testinput
CREATE TABLE IF NOT EXISTS `testinput` (
  `input` varchar(200) DEFAULT NULL,
  `image` varchar(2000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table newtest.testinput: 2 rows
/*!40000 ALTER TABLE `testinput` DISABLE KEYS */;
INSERT INTO `testinput` (`input`, `image`) VALUES
	(NULL, '.\\Images/betting-exchnage.png'),
	('This is the row from row number 1 test', NULL);
