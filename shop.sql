-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 16 juin 2018 à 17:37
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `parent` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `parent`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Playstation', 'game', 6, 0, 0, 1, 0),
(2, 'informatique', 'info', 1, 0, 0, 0, 0),
(3, 'Electronique ', '', 2, 0, 0, 0, 0),
(4, 'Games', 'pour les jeux', 3, 0, 0, 0, 0),
(5, 'PC Portable', 'pc portable', 0, 0, 0, 0, 0),
(6, 'PS3', 'Console', 2, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `C_id` int(11) NOT NULL AUTO_INCREMENT,
  `Comments` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `C_Date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`C_id`),
  KEY `items_comment` (`item_id`),
  KEY `user_comments` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`C_id`, `Comments`, `Status`, `C_Date`, `item_id`, `user_id`) VALUES
(7, 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggdssssssssssssfffsffffff', 1, '0000-00-00', 9, 1),
(8, 'drfgggggggggggggggggggg', 0, '2018-03-05', 10, 7),
(9, 'salam', 0, '2018-05-18', 9, 1),
(10, 'f', 1, '2018-05-18', 9, 1),
(11, 'ch7al taman', 1, '2018-06-13', 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `item_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`item_ID`),
  KEY `member_1` (`Member_ID`),
  KEY `cat_1` (`Cat_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Status`, `tel`, `Approve`, `Cat_ID`, `Member_ID`, `avatar`, `tags`) VALUES
(9, 'Playstation 3', 'console', '1 $', '2018-03-04', 'japon', '1', '0', 1, 1, 1, '', ''),
(10, 'nintando', 'console', '1 $', '2018-03-06', 'Europe', '3', '0', 1, 1, 8, '', ''),
(11, 'accessoire ps3', ':)', '10', '2018-05-23', 'uk', '2', '0', 1, 6, 3, '', 'console'),
(12, 'jeu video', 'jeu', '50', '2018-05-23', 'japon', '1', '0', 1, 4, 9, '', 'kamal, jeu, jeu_video'),
(13, 'accessoire ps4', ':) ch haja mzyana', '100', '2018-05-23', 'japon', '2', '0', 1, 1, 1, '706604004_1-2-facebook-download-png.png', 'youssef, console, jeu_video'),
(14, 'God Of War', 'jeu video', '70', '2018-05-23', 'maroc', '2', '0', 1, 4, 1, '516296387_God-of-War-PNG-Transparent-Image.png', 'jeu_video,game,ps3'),
(16, 'drfgd', 'drft', '10', '2018-06-12', 'japon', '2', '0', 1, 6, 3, '290710449_1-2-facebook-download-png.png', 'console'),
(18, 'pls5', 'msdklmls,dsdml,s', '100', '2018-06-12', 'japon', '1', '0', 1, 1, 1, '352264404_1-2-facebook-download-png.png', 'console'),
(19, 'accessoire ps3', ':)', '10', '2018-06-13', 'fk', '3', '0', 1, 2, 10, '59295654_God-of-War-PNG-Transparent-Image.png', 'console'),
(20, 'accessoire ps7', 'Consolemsjqsmldj,', '100', '2018-06-13', 'maroc', '4', '0', 1, 2, 7, '209167480_God-of-War-PNG-Transparent-Image.png', ''),
(21, 'War', 'jeu video', '10', '2018-06-13', 'maroc', '1', '0669508710', 1, 2, 8, '799316407_1-2-facebook-download-png.png', 'jeu_video,game,ps3'),
(22, 'accessoire ps310', ':)', '10', '2018-06-16', 'fk', '4', '0669508710', 1, 3, 7, '458007812_1-2-facebook-download-png.png', 'console');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TO IDENTIFY USER',
  `UserName` varchar(255) NOT NULL COMMENT 'username to login',
  `password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL DEFAULT '',
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'identify user group',
  `Truststatus` int(11) NOT NULL DEFAULT '0' COMMENT 'seller Rank',
  `Regstatus` int(11) NOT NULL DEFAULT '0' COMMENT 'user approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`userID`, `UserName`, `password`, `Email`, `FullName`, `GroupID`, `Truststatus`, `Regstatus`, `Date`, `avatar`) VALUES
(1, 'youssef', '279bb4f3f260fa9d294167f7dc460d9aa26906b6', 'ysfbel7@gmail.com', 'youssef belghiti', 1, 0, 1, '0000-00-00', '96099853_God-of-War-PNG-Transparent-Image.png'),
(3, 'karim', 'c984aed014aec7623a54f0591da07a85fd4b762d', 'ysf@gmail.com', '', 0, 0, 1, '2018-01-10', ''),
(7, 'youss', 'e9361cbb1a796ac719f6116cceb357037935b9b2', 'ysfbel7@gmail.com', '', 0, 0, 1, '2018-01-25', ''),
(8, 'yous', 'e9361cbb1a796ac719f6116cceb357037935b9b2', 'ysf@gmail.com', '', 0, 0, 1, '2018-01-25', ''),
(9, 'kamal', '5a478022f33905d2d40410e006fb1aa8564b280c', 'kamal@k.com', '', 1, 0, 1, '2018-05-21', ''),
(10, 'gggg', 'e9361cbb1a796ac719f6116cceb357037935b9b2', 'you@hotmail.com', 'gg', 0, 0, 1, '2018-05-23', '962525_a.jpg'),
(11, 'jdfd1', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'you_@hotmail.com', 'ch haja', 0, 0, 1, '2018-05-23', '667938_a.jpg'),
(12, 'odfjkl', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'chhaja.chhaja@c.com', 'chhaja', 0, 0, 1, '2018-05-24', '712738037_img.png'),
(13, 'kamal1', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'kamal@k.com', 'kamal kamal', 0, 0, 1, '2018-06-12', '516876221_God-of-War-PNG-Transparent-Image.png'),
(14, 'yyyyy', '011c945f30ce2cbafc452f39840f025693339c42', 'you_bel1@hotmail.com', 'youssef belghiti', 0, 0, 1, '2018-06-13', '342437744_1-2-facebook-download-png.png');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
