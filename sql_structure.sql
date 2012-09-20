-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2012 at 09:40 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mypi`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `officer` int(11) DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `reason` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eventsX`
--

CREATE TABLE IF NOT EXISTS `eventsX` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `officer` int(11) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `name` varchar(64) NOT NULL,
  `guestlist` enum('TRUE','FALSE') NOT NULL,
  `guestsperperson` int(11) NOT NULL DEFAULT '0',
  `listunlocks` datetime DEFAULT NULL COMMENT 'date that all slots become available',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `uploader` int(11) NOT NULL,
  `officer` int(11) DEFAULT NULL,
  `cat` varchar(8) NOT NULL,
  `localname` char(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE IF NOT EXISTS `guests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `event` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `sex` enum('MALE','FEMALE') NOT NULL DEFAULT 'MALE',
  `first` varchar(64) NOT NULL DEFAULT '',
  `last` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(11) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reply` int(11) unsigned DEFAULT NULL,
  `confidential` enum('FALSE','TRUE') CHARACTER SET latin1 NOT NULL,
  `subject` varchar(128) NOT NULL DEFAULT 'No Subject',
  `message` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message_status`
--

CREATE TABLE IF NOT EXISTS `message_status` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL,
  `read` enum('FALSE','TRUE') CHARACTER SET latin1 DEFAULT 'FALSE',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE IF NOT EXISTS `officers` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL DEFAULT '100',
  `name` varchar(60) NOT NULL,
  `title` varchar(60) NOT NULL,
  `subtitle` varchar(60) NOT NULL,
  `member` int(11) unsigned DEFAULT NULL,
  `elected` enum('false','true') NOT NULL DEFAULT 'false',
  `page` tinyint(1) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rushees`
--

CREATE TABLE IF NOT EXISTS `rushees` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) unsigned NOT NULL,
  `first` varchar(32) NOT NULL,
  `last` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `class` int(4) unsigned NOT NULL,
  `dob` date DEFAULT NULL,
  `brother` int(10) unsigned DEFAULT NULL,
  `bid` enum('FALSE','TRUE') NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shouts`
--

CREATE TABLE IF NOT EXISTS `shouts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nameFirst` varchar(50) NOT NULL,
  `nameLast` varchar(50) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `pi` int(11) unsigned DEFAULT NULL,
  `type` enum('BROTHER','AM','ALUM') NOT NULL,
  `dob` date DEFAULT NULL,
  `yog` int(4) unsigned DEFAULT NULL,
  `officer` int(11) unsigned DEFAULT NULL,
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `big` int(11) unsigned DEFAULT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
