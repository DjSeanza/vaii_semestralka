-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Út 15.Nov 2022, 22:23
-- Verzia serveru: 10.4.25-MariaDB
-- Verzia PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `vaii`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `video` int(11) NOT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `post_time` datetime NOT NULL DEFAULT current_timestamp(),
  `modification_time` datetime DEFAULT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `comments`
--

INSERT INTO `comments` (`id`, `author`, `video`, `reply_to`, `post_time`, `modification_time`, `text`) VALUES
(1, 1, 1, NULL, '2022-11-05 18:32:53', NULL, 'First comment. Yaaay!!'),
(10, 3, 1, 1, '2022-11-06 15:33:39', NULL, 'This is my first reply!');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Uses password_hash',
  `profile_picture` varchar(64) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `profile_picture`, `email`) VALUES
(1, 'admin', '$2y$10$dOvRRFFRIC3Pp8PAp/wUGuk2nXH4AxyXY9XMsi0J.GDHTGcmLb7Oi', NULL, NULL),
(3, 'testAdmin', '$2y$10$dOvRRFFRIC3Pp8PAp/wUGuk2nXH4AxyXY9XMsi0J.GDHTGcmLb7Oi', NULL, NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `author` int(11) NOT NULL,
  `description` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `thumbnail` varchar(300) NOT NULL,
  `video` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `videos`
--

INSERT INTO `videos` (`id`, `title`, `author`, `description`, `post_date`, `thumbnail`, `video`) VALUES
(1, 'First Video!!', 1, 'This is my first video. ', '2022-11-05 18:32:25', 'public/uploads/admin/video1/video1.jpg', 'public/uploads/admin/video1/video1.mp4');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_users_null_fk` (`author`),
  ADD KEY `comments_videos_null_fk` (`video`),
  ADD KEY `comments_comments_id_fk` (`reply_to`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_uniq` (`login`);

--
-- Indexy pre tabuľku `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_users_null_fk` (`author`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_comments_id_fk` FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `comments_users_null_fk` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_videos_null_fk` FOREIGN KEY (`video`) REFERENCES `videos` (`id`);

--
-- Obmedzenie pre tabuľku `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_users_null_fk` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
