-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2021 at 08:30 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cources`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `name`) VALUES
(1, 'avg()'),
(2, 'Initialize a Laraval application'),
(3, 'routes/'),
(4, '$ npm install express'),
(5, 'Asynchronous'),
(6, 'Node Package Manager'),
(7, 'testing node.js/JavaScript expressions'),
(8, 'up() and down()');

-- --------------------------------------------------------

--
-- Table structure for table `cources`
--

CREATE TABLE `cources` (
  `id` int(11) NOT NULL,
  `name` char(250) NOT NULL,
  `image` char(250) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cources`
--

INSERT INTO `cources` (`id`, `name`, `image`, `price`, `description`, `quiz_id`) VALUES
(8, 'nodejs', '5666354861632279706.jpeg', 300, 'Learn Node.js by building real-world applications with Node JS, Express, MongoDB, Jest, and more!', 4),
(11, 'laravel', '3647154831632359986.jpeg', 200, 'PHP with Laravel for beginners - Become a Master in Laravel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` char(50) NOT NULL,
  `cource_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `cource_id`) VALUES
(5, 'Accessing API from Browser  Weather App', 8),
(6, 'Installing and Exploring Nodejs', 8),
(7, 'MongoDB and Promises', 8),
(9, 'Laravel Fundamentals - Routes', 11),
(10, 'Laravel Fundamentals - Controllers', 11),
(11, 'Laravel Fundamentals - Views', 11);

-- --------------------------------------------------------

--
-- Table structure for table `matrials`
--

CREATE TABLE `matrials` (
  `id` int(11) NOT NULL,
  `name` varchar(600) NOT NULL,
  `videos` varchar(300) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matrials`
--

INSERT INTO `matrials` (`id`, `name`, `videos`, `lesson_id`) VALUES
(3, 'Installing MongoDB on Windows', '16107355021632335639.mp4', 7),
(4, 'Section Intro  Installing and Exploring Nodejs', '5610859581632336101.mp4', 6),
(5, 'Section Intro Accessing API from Browser', '4780816461632335914.mp4', 5),
(6, 'Installing MongoDB on macOS and Linux', '20512629851632336175.mp4', 7),
(10, 'Naming Routes', '8503806701632360501.mp4', 9),
(11, 'Creating Controllers', '8896255891632360527.mp4', 10),
(12, 'Passing data to views', '3331511051632360550.mp4', 11),
(13, 'Route Introduction', '8897891551632360941.mp4', 9);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `name` varchar(600) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `name`, `quiz_id`, `answer_id`) VALUES
(1, '1. Which method returns the average value of a given key ?', 1, 1),
(2, '2. Bootstrap directory in Laravel is used to', 1, 2),
(3, '3. Where is the routing file located in Laravel ?', 1, 3),
(4, '4. Which of following methods are used in database migrations classes?', 1, 8),
(5, '1. Node.js is ________ by default.', 4, 5),
(6, '2. To install Node.js express module', 4, 4),
(7, '3. What npm stands for?', 4, 6),
(8, '4. Node.js terminal (REPL) is used for _________.', 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `id` int(11) NOT NULL,
  `name` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`id`, `name`) VALUES
(1, 'laravelQuiz'),
(4, 'nodejsQuiz');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` char(250) NOT NULL,
  `email` char(250) NOT NULL,
  `password` char(250) NOT NULL,
  `phone` char(50) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role_id`) VALUES
(2, 'karimali', 'karimali@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '01140358383', 1),
(4, 'ahmed', 'ahmed@gmail.com', '005282aa6747a2c82d09065d1194dd20', '01112345358', 2),
(5, 'Abdelkarim', 'Abdelkarim@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '01140358383', 1),
(6, 'mostafa', 'mostafa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '01112345358', 2),
(7, 'ali', 'ali@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '01140358383', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_cources`
--

CREATE TABLE `users_cources` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cource_id` int(11) NOT NULL,
  `is_accepted` char(11) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_cources`
--

INSERT INTO `users_cources` (`id`, `user_id`, `cource_id`, `is_accepted`) VALUES
(1, 4, 8, 'yes'),
(3, 7, 11, 'yes'),
(4, 7, 8, 'yes'),
(5, 7, 8, 'no'),
(6, 7, 8, 'no'),
(7, 7, 11, 'no'),
(8, 7, 11, 'no'),
(9, 7, 8, 'no'),
(10, 7, 8, 'no'),
(11, 7, 11, 'no'),
(12, 7, 11, 'no'),
(37, 6, 11, 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cources`
--
ALTER TABLE `cources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cource_id` (`cource_id`),
  ADD KEY `cource_id_2` (`cource_id`),
  ADD KEY `matrial_id` (`cource_id`);

--
-- Indexes for table `matrials`
--
ALTER TABLE `matrials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_answer` (`answer_id`),
  ADD KEY `question_quiz` (`quiz_id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users_cources`
--
ALTER TABLE `users_cources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_couce` (`user_id`),
  ADD KEY `couce_user` (`cource_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cources`
--
ALTER TABLE `cources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `matrials`
--
ALTER TABLE `matrials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_cources`
--
ALTER TABLE `users_cources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cources`
--
ALTER TABLE `cources`
  ADD CONSTRAINT `cource_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lesson_cource` FOREIGN KEY (`cource_id`) REFERENCES `cources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matrials`
--
ALTER TABLE `matrials`
  ADD CONSTRAINT `lesson_matrial` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `question_answer` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_user` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_cources`
--
ALTER TABLE `users_cources`
  ADD CONSTRAINT `couce_user` FOREIGN KEY (`cource_id`) REFERENCES `cources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_couce` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
