-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 30 mai 2023 à 14:30
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `onlinesnackies`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`,`id_product`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_user`, `id_product`, `date`) VALUES
(1, 7, 5, '2023-05-11 13:28:50'),
(2, 7, 5, '2023-05-11 13:28:50'),
(3, 7, 5, '2023-05-11 13:28:50'),
(4, 7, 5, '2023-05-11 13:28:50'),
(5, 7, 1, '2023-05-11 13:28:50');

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  KEY `id_product` (`id_product`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `price`, `img`) VALUES
(1, 'Pain au chocolat', 14, 1.9, 'pain_chocolat.jpg'),
(2, 'Croissant', 37, 1.6, 'croissant.jpeg'),
(3, 'Orezza', 21, 4.99, 'orezza.jpg'),
(4, 'Zilia', 2, 5.9, 'zilia.png'),
(5, 'Chocolatine', 0, 19.99, 'pain_chocolat.jpg'),
(6, 'Beignet', 19, 2, 'beignet.jpeg'),
(7, 'Eclair café', 18, 1.99, 'eclair.jpg'),
(8, 'Eclair chocolat', 17, 1.99, 'eclair.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `product_history`
--

DROP TABLE IF EXISTS `product_history`;
CREATE TABLE IF NOT EXISTS `product_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity_change` int(11) NOT NULL,
  `price_change` float NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_admin`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product_history`
--

INSERT INTO `product_history` (`id`, `id_admin`, `id_product`, `quantity_change`, `price_change`, `date`) VALUES
(1, 3, 3, 10, 0, '2023-05-10 13:27:18'),
(5, 3, 5, 0, -10, '2023-05-11 07:40:11'),
(6, 1, 5, 94, 0, '2023-05-11 08:44:23'),
(7, 3, 5, -94, 10, '2023-05-11 08:45:26'),
(9, 3, 1, -9, 0, '2023-05-11 11:44:00'),
(10, 3, 2, -12, 0, '2023-05-11 11:44:05'),
(11, 3, 3, -16, 0, '2023-05-11 11:44:17'),
(14, 8, 1, -10, 0, '2023-05-11 13:49:41'),
(15, 3, 5, 2, 0, '2023-05-15 08:18:47'),
(16, 3, 5, 10, 0, '2023-05-15 08:32:23'),
(17, 3, 5, -9, 0, '2023-05-15 12:22:41'),
(18, 3, 5, 9, 0, '2023-05-15 12:33:55'),
(19, 3, 4, -14, 0, '2023-05-15 12:34:00'),
(20, 3, 4, 97, 0, '2023-05-15 12:34:15'),
(21, 3, 4, 0, 0.00999999, '2023-05-15 12:34:22'),
(22, 3, 4, 0, 1, '2023-05-15 12:34:32'),
(23, 3, 4, 0, 0.98, '2023-05-15 12:34:37'),
(24, 3, 4, 0, 0.008, '2023-05-15 12:34:39'),
(25, 3, 4, 0, 0.0009, '2023-05-15 12:34:42'),
(26, 3, 4, 0, 0.000098, '2023-05-15 12:34:45'),
(27, 3, 5, 77, -18.99, '2023-05-15 12:36:04'),
(28, 3, 1, -60, 18, '2023-05-15 12:36:21'),
(29, 8, 1, 84, -18, '2023-05-15 13:43:45'),
(30, 8, 5, -86, 18.99, '2023-05-15 13:55:41'),
(31, 3, 7, 0, -1.01, '2023-05-25 11:38:15'),
(32, 3, 8, 0, -1.01, '2023-05-25 11:38:23');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `budget` float DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `budget`, `isAdmin`) VALUES
(1, 'Aimée', '$2y$10$jKWishipBPwc4BpWUi/3QOoz0MKEfnQjkjGXyTCBP0qV/hAED7R/y', 1, 1),
(2, 'Kévin', '$2y$10$jKWishipBPwc4BpWUi/3QOoz0MKEfnQjkjGXyTCBP0qV/hAED7R/y', 5, 0),
(3, 'Nicow', '$2y$10$jKWishipBPwc4BpWUi/3QOoz0MKEfnQjkjGXyTCBP0qV/hAED7R/y', 142.83, 1),
(4, 'Nicos', '$2y$10$jKWishipBPwc4BpWUi/3QOoz0MKEfnQjkjGXyTCBP0qV/hAED7R/y', 50, 0),
(5, 'N!co', '$2y$10$jKWishipBPwc4BpWUi/3QOoz0MKEfnQjkjGXyTCBP0qV/hAED7R/y', 100, 0),
(7, 'c.fite0504', '$2y$10$GxSNNy1uiJaXELASms78ruMUS4RUzuyIPW1FAiiSUiUfWTYolOQlC', 469.1, 1),
(8, 'Admin', '$2y$10$UfXcS9AtiOlkYt0FqFnlPejacA4nt4vp/vk29540BUyVT5x2fSWbS', 999, 1),
(10, 'Brouette', '$2y$10$2kXwbsVLy.CP0Zy0QfpUgemzsGcxYKnsgS.kN3mh1ftdsbVhx7h.m', 50, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_history`
--

DROP TABLE IF EXISTS `user_history`;
CREATE TABLE IF NOT EXISTS `user_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `budget_change` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_admin` (`admin`,`id_user`),
  KEY `id_user` (`id_user`),
  KEY `id_admin_2` (`admin`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_history`
--

INSERT INTO `user_history` (`id`, `admin`, `id_user`, `budget_change`, `date`) VALUES
(1, 'Nicow', 1, -990, '2023-05-11 09:49:32'),
(2, 'Nicow', 1, 990, '2023-05-11 09:52:54'),
(3, 'Nicow', 7, 450, '2023-05-11 09:53:04'),
(4, 'Admin', 1, -998, '2023-05-11 12:04:23'),
(5, 'Admin', 1, 1, '2023-05-11 13:53:16'),
(6, 'Admin', 3, 450, '2023-05-11 14:00:35'),
(7, 'Nicow', 7, 4999500, '2023-05-15 12:35:02'),
(8, 'Nicow', 5, -1049, '2023-05-15 12:35:11'),
(9, 'Admin', 5, 1099, '2023-05-15 12:49:55'),
(10, 'Admin', 7, -4999500, '2023-05-15 12:50:00'),
(11, 'Admin', 1, -1, '2023-05-15 14:14:52');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_history`
--
ALTER TABLE `product_history`
  ADD CONSTRAINT `product_history_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_history_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
