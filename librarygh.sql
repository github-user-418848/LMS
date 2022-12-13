-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 06:39 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarygh`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `isbn` char(13) NOT NULL,
  `title` varchar(80) NOT NULL,
  `author` varchar(80) NOT NULL,
  `category` varchar(80) NOT NULL,
  `copies` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `isbn`, `title`, `author`, `category`, `copies`) VALUES
(2, '6900152484442', 'V for Vendetta', 'Alan Moore', 'Comics', 13),
(4, '9783161484100', 'Mike Tyson : Undisputed Truth', 'Larry Sloman, Mike Tyson', 'Sports', 190),
(5, '9789996245442', 'When Breath Becomes Air', 'Paul Kalanithi', 'Comics', 9),
(6, '9885691200700', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 20),
(19, '1234', '1234', '1234', 'Comics', 0),
(20, '123', 'test', 'test', 'Medical', 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_issue_log`
--

CREATE TABLE `book_issue_log` (
  `id` int(11) NOT NULL,
  `member_name` varchar(80) CHARACTER SET utf8mb4 NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `copies` int(10) NOT NULL,
  `date_requested` date NOT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_issue_log`
--

INSERT INTO `book_issue_log` (`id`, `member_name`, `book_isbn`, `copies`, `date_requested`, `due_date`) VALUES
(7, 'student@student.com', '123', 2, '2022-12-13', '0000-00-00'),
(8, 'student@student.com', '1234', 3, '2022-12-13', '2022-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(80) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Comics'),
(4, 'Fiction'),
(3, 'Medical'),
(2, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `pending_book_requests`
--

CREATE TABLE `pending_book_requests` (
  `id` int(11) NOT NULL,
  `member_name` varchar(80) CHARACTER SET utf8mb4 NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `copies` int(10) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `is_active` varchar(10) NOT NULL,
  `is_admin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `is_active`, `is_admin`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$12$Wbeg2Cm.4bPU.dBC82lwiuk2eX/fkyd.TBnhph1cb/9MG7rCCOBC2', 'true', 'true'),
(2, 'student@student.com', 'student@student.com', '$2y$12$tpLULnqJpjvnNaQ5.PYlp.RXrpg/WhPsVJUg76spIijFFJrImXvK2', 'true', 'false'),
(4, 'user@user.com', 'user', '$2y$12$tpLULnqJpjvnNaQ5.PYlp.RXrpg/WhPsVJUg76spIijFFJrImXvK2', 'true', 'false'),
(5, 'asd', 'asd@asd.asd', '$2y$12$gEhflZ2vmCz3Y79CgWKZ7e55Gz3kCfyaidZnKyRXl.Aky6fGlJOzG', 'false', 'true'),
(6, 'test@test.test', 'test', '$2y$12$8Cwctjh0CaeCFa5Xnd/LPuzZxYGAt2bqAeWz8QMnK1rJwNhbTYGE6', 'true', 'false'),
(7, 'asd@asd.asd', 'addsd', '$2y$12$V8g1zmJC22qqCsowl.D4led4edK3sMtTH5TqdDf88yGsy/LXhQE2O', 'true', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `book_issue_log`
--
ALTER TABLE `book_issue_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_isbn` (`book_isbn`),
  ADD KEY `member_name` (`member_name`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_isbn` (`book_isbn`),
  ADD KEY `member_name` (`member_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `book_issue_log`
--
ALTER TABLE `book_issue_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_issue_log`
--
ALTER TABLE `book_issue_log`
  ADD CONSTRAINT `book_issue_log_ibfk_1` FOREIGN KEY (`book_isbn`) REFERENCES `book` (`isbn`),
  ADD CONSTRAINT `book_issue_log_ibfk_2` FOREIGN KEY (`member_name`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  ADD CONSTRAINT `pending_book_requests_ibfk_1` FOREIGN KEY (`book_isbn`) REFERENCES `book` (`isbn`),
  ADD CONSTRAINT `pending_book_requests_ibfk_2` FOREIGN KEY (`member_name`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
