-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2014 at 10:22 PM
-- Server version: 5.1.63-0ubuntu0.11.04.1
-- PHP Version: 5.3.5-1ubuntu7.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `server_check`
--

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`id`, `server_name`, `ip_address`, `status`, `create_date`) VALUES
(8, 'VOIP Server 2', '209.40.98.14', 1, '2014-03-30'),
(6, 'VOIP Server', '209.40.98.13', 1, '2014-03-30'),
(9, 'Device Server', '103.31.155.138', 1, '2014-03-30'),
(10, 'Device Server 2', '209.190.50.198', 1, '2014-03-30'),
(11, 'non', '234.22.1.1', 0, '2014-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `create_date`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2014-03-29');



CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mail_status` tinyint(1) NOT NULL,
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`id`, `server_name`, `ip_address`, `port`, `provider`, `email`, `phone`, `status`, `mail_status`, `create_date`) VALUES
(8, 'VOIP Server 2', '209.40.98.14', '', '', '', '', 1, 0, '2014-03-30'),
(6, 'VOIP Server', '209.40.98.13', '', '', '', '', 1, 0, '2014-03-30'),
(10, 'Device Server 2', '209.190.50.198', '', '', 'bokul@horoppa.com', '', 0, 1, '2014-03-30'),
(14, 'Device Server', '103.31.155.138', '1670', 'test', 'bokul@horoppa.com', '01717251417', 1, 0, '2014-04-04');