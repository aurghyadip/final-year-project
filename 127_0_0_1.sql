-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2017 at 01:43 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--
CREATE DATABASE IF NOT EXISTS `books` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `books`;

-- --------------------------------------------------------

--
-- Table structure for table `booksdb`
--

CREATE TABLE `booksdb` (
  `isbn13` bigint(13) NOT NULL,
  `copies` int(3) DEFAULT NULL,
  `rented` int(3) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booksdb`
--

INSERT INTO `booksdb` (`isbn13`, `copies`, `rented`) VALUES
(9780593078754, 5, 1),
(9780571246922, 3, 0),
(9789312140963, 2, 0),
(9780349122380, 1, 0),
(9780007307753, 1, 0),
(9781841157917, 1, 0),
(9780007453085, 2, 0),
(9781408855102, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `isbn13` bigint(13) NOT NULL,
  `st_id` bigint(11) NOT NULL,
  `rent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`isbn13`, `st_id`, `rent_date`, `due_date`) VALUES
(9780593078754, 16500214006, '2017-10-27 08:55:42', '2017-10-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `studentdb`
--

CREATE TABLE `studentdb` (
  `st_id` bigint(11) NOT NULL,
  `st_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentdb`
--

INSERT INTO `studentdb` (`st_id`, `st_name`) VALUES
(16500214006, 'Aurghyadip Kundu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booksdb`
--
ALTER TABLE `booksdb`
  ADD PRIMARY KEY (`isbn13`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`isbn13`,`st_id`);

--
-- Indexes for table `studentdb`
--
ALTER TABLE `studentdb`
  ADD PRIMARY KEY (`st_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
