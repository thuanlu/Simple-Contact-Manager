-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2025 at 06:33 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simplecontactmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `phone` varchar(20) default NULL,
  `email` varchar(100) default NULL,
  `note` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `phone`, `email`, `note`) VALUES
(1, 'Lu Minh Thuan', '0365110212', 'luminhthuan.iuh@gmail.com', 'Thuận 22 tuổi yêu đời'),
(3, 'Minh Trí', '0445698787', 'tri@gmail.com', 'Trí là sinh viên năm 4 khoa công nghệ thông tin');
