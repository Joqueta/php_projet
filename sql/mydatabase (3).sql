-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 mars 2025 à 21:23
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mydatabase`
--

-- --------------------------------------------------------

--
-- Structure de la table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `attachments`
--

INSERT INTO `attachments` (`id`, `task_id`, `file_name`, `file_path`, `file_type`, `file_size`, `uploaded_at`) VALUES
(1, 6, 'subject-php.pdf', '../uploads/6145793eb38ae3f205e1d44fe38a51fb.pdf', 'application/pdf', 29782, '2025-03-01 16:33:29'),
(2, 8, 'Fondamentaux de la cybersécurité.pdf', '../uploads/f7db96e9f6a7013403a7da5ce2325b66.pdf', 'application/pdf', 176122, '2025-03-02 12:01:05');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'PHP', '2025-03-01 16:18:03'),
(2, 'JavaScript', '2025-03-01 16:18:03'),
(3, 'HTML', '2025-03-01 16:18:03'),
(4, 'CSS', '2025-03-01 16:18:03'),
(5, 'SQL', '2025-03-01 16:18:03'),
(6, 'Python', '2025-03-01 16:18:03'),
(7, 'C#', '2025-03-01 16:18:03');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `task_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 0, 1, 'Super app', '2025-03-01 16:03:43'),
(2, 0, 1, 'Bonjour', '2025-03-01 16:04:05'),
(3, 0, 1, 'test', '2025-03-02 11:55:47');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `importance` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `category_id`, `title`, `description`, `importance`, `due_date`, `created_at`) VALUES
(4, 1, 2, 'jsp', 'jsp', 'Moyenne', NULL, '2025-03-01 16:19:08'),
(5, 1, 1, 'devoir', 'Partiel', 'Haute', NULL, '2025-03-01 16:29:21'),
(6, 1, 0, 'test', 'test', 'Basse', NULL, '2025-03-01 16:33:29'),
(8, 1, 0, 'cyber', 'cyber', 'Basse', NULL, '2025-03-02 12:01:05');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'test', '$2y$10$Y4oPABn7CVyDysSc5ktsd.6vxU9sfofe74fWnc.l5FSWvxGG5tcjC', 'test@gmail.com', 'admin'),
(2, '123', '$2y$10$2gDfTMLvfL3990XKN75oOOyzWK5JLuUpFA3xT4ekKPvKpBtmAg99i', '123@gmail.com', 'user'),
(3, 'joqueta', '$2y$10$TNBpzcTtCv5PVEVBr.MK7.ZLf9KIXe9WFgCTxZeOzyvkMBYs0Tk/e', 'fritzi.joqueta@gmail.com', 'admin'),
(4, '456', '$2y$10$xZCzHMs9jrndzusc/wOVRew.dR6BPhqhz9txKK4y.t6U.H3BWy0WW', '456@gmail.com', 'user'),
(5, 'jean', '$2y$10$tlZFtb4b2xmt4r5.YJT34OZnbsoh58TmsQTDmTSieCMZrk/EhJxHu', 'jean@test.com', 'user'),
(6, 'jacques', '$2y$10$p9JthfBzkl/pKchM.Y/92O2ZnW/4O5eODwWVRytyRcAZt1v91IQni', 'jacques@test.com', 'admin'),
(8, 'emie', '$2y$10$A06ZKM8/h7cL9gp1st0DK.heWPM2qxYUguIAL/I9sqBMy//qqOt1S', 'emie@gmaiil.com', 'user'),
(9, 'rio', '$2y$10$5fWnJJPI.Kx9B9vxd.dSa.7A9Jb5WUSoAPTy96g2ZdZPyB3Q2O9Oy', 'rio@gmail.com', 'user'),
(10, 'carre', '$2y$10$a9OhIuyVurn8N1S4ZWioEugm0gT5cSjy27B7h2Myi1s5aBGnJOQqC', 'carre@gmail.com', 'user'),
(11, 'harpper', '$2y$10$1EsrQsNKdVdJsFDp7ilsbuxXXWJRd86hAbCL44YbrYsBJpvKd/8DC', 'harpper@gamil.com', 'user'),
(12, 'pauline', '$2y$10$tgZqz98fN6Poz0VwkCnBcOnjkjQa0Ur6Xq.gi8YYjAk3TJGMO5OZu', 'pauline@gmail.com', 'user'),
(13, 'goa', '$2y$10$LHs7O8.7Wr4rpzzHfuMtFOkk2CO8IkGkue.B4Wke51GbTFGrCghCK', 'goa@gmail.com', 'user'),
(14, 'rosario', '$2y$10$BhujfrKnbgTXbANJMKZoKOkouXOA0qRoEZ2lw8SqE0QCisxb16QUa', 'rosario@gmail.com', 'user'),
(15, 'hgcng', '$2y$10$eAaumJE5l86TU.71pZoPZuLoT.p8bfi.RdVF84vFJ4YxgzYdZp2TK', 'nhtdjdj@jghjhh', 'user'),
(16, 'tedxytc', '$2y$10$m9YxDKRFiPbQt0lSPVPcouLOs39a03UVPcr2gxwNzADWiFvZJxXwa', 'rexcyju@yfcvhj', 'user'),
(17, 'azerty', '$2y$10$84Hjaurvlajg98UBrjYoQetgaWerX1JmoPgpuSJo3swAe8w9T2ZrS', 'qsdf@gmail.com', 'user'),
(18, 'sdxfcgbhj', '$2y$10$jc6BcoLPVwoFbpImkxZgXemc74KYmx9D.bGv0CEbXE5rNBEuK/cSi', 'rxydcvgih@gmail.com', 'user'),
(19, 'gcvyhvbkjb', '$2y$10$vx/p9c2ZAfaEBiLXdsqahOva/YGg/v.kHfBGHZcT83NQWyvv1ouHO', 'dxrtcfyvbhuinjo@gmail.com', 'user'),
(20, 'ushcbnIOSJDNCOKQS', '$2y$10$8kW77McltNXXk7a3jseHbOwqWx1lNFHDYjZwK6UNnZGnuHVdVHvp2', 'zuiebofciq@gmail.com', 'user'),
(21, 'AIJEFNzkefô', '$2y$10$s8gO57EqUec2Z2duFMsHL.aT0aZDccOc5I.2/7h64iTmHbQJG36dm', 'hbfvijdsbv@gmail.com', 'user'),
(22, 'yzehbfoizbef', '$2y$10$f1dhL0LlixWMHQSqc1GBweudfChLgi1ga50dDEp8yXTdK9SJcrBFK', 'sjehfhsd@gmail.com', 'user'),
(23, 'auyzhvejh', '$2y$10$mQmf/JcHX7vKWSgoeqLmFOOpHfcakL6Qsjp9wk4P/atGEtBcTjoDG', 'azjhvejh@gmail.com', 'user'),
(24, 'admin', '$2y$10$tmx.vUc8Z1XLq8lBvcG43Oivw44.KBGqdQGBp6CoyluGtf.WoYpIi', 'admin@gmail.com', 'admin'),
(25, 'zack', '$2y$10$11XIArTdqJGmVNLboPlRs.e6Xxnma2Hy4h6iT0MjIr9VYckCricm.', 'zack@test.com', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
