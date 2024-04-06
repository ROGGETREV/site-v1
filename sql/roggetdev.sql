-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 avr. 2024 à 23:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `roggetdev`
--

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL DEFAULT '',
  `color` enum('primary','secondary','success','danger','warning','info','light','dark') NOT NULL DEFAULT 'primary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `alerts`
--

INSERT INTO `alerts` (`id`, `content`, `color`) VALUES
(1, 'This website is NOT DONE. You can\'t access it, and you can\'t become a beta tester.', 'danger');

-- --------------------------------------------------------

--
-- Structure de la table `allowedmd5hashes`
--

CREATE TABLE `allowedmd5hashes` (
  `id` int(11) NOT NULL,
  `md5` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `allowedmd5hashes`
--

INSERT INTO `allowedmd5hashes` (`id`, `md5`) VALUES
(1, '3c45307cc2eecf57d6b81a8af359df54'),
(2, '7d67b8b86b04462f9d303004eeb071c5');

-- --------------------------------------------------------

--
-- Structure de la table `allowedsecurityversions`
--

CREATE TABLE `allowedsecurityversions` (
  `id` int(11) NOT NULL,
  `ver` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `allowedsecurityversions`
--

INSERT INTO `allowedsecurityversions` (`id`, `ver`) VALUES
(1, '0.271.1pcplayer'),
(2, '0.271.9androidapp');

-- --------------------------------------------------------

--
-- Structure de la table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creator` int(11) NOT NULL,
  `nuggets` int(11) NOT NULL DEFAULT 0,
  `moderation` enum('Pending','Accepted','Refused') NOT NULL,
  `type` enum('hat','head','shirt','pants','tshirt','face') NOT NULL DEFAULT 'tshirt',
  `renderYear` enum('2008','2011','2011edited2016','2016') NOT NULL DEFAULT '2008',
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `description`, `creator`, `nuggets`, `moderation`, `type`, `renderYear`, `created`) VALUES
(1, 'I HATE YOMI SHIRT', 'This is so true...', 2, 5, 'Accepted', 'shirt', '2008', 1709135565),
(2, 'noob tshirt', 'real', 2, 5, 'Accepted', 'tshirt', '2008', 1710357425),
(3, 'Elon Musk', 'real', 2, 5, 'Accepted', 'face', '2008', 1710357425),
(4, 'LeTrisomique', 'Ahhh il est moche!', 9, 25, 'Accepted', 'tshirt', '2011', 1711316980),
(5, 'Dog', 'This is a dog', 2, 5, 'Accepted', 'tshirt', '2008', 1711888842);

-- --------------------------------------------------------

--
-- Structure de la table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT 0,
  `requesttime` int(11) NOT NULL DEFAULT 0,
  `responsetime` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `friendships`
--

INSERT INTO `friendships` (`id`, `user1`, `user2`, `accepted`, `requesttime`, `responsetime`) VALUES
(2, 1, 3, 1, 0, 0),
(4, 4, 2, 1, 0, 0),
(21, 4, 3, 0, 1709143347, 0),
(22, 4, 1, 0, 1709143352, 0),
(23, 1, 2, 1, 1709153326, 1709153339),
(26, 2, 699, 0, 1709301217, 0),
(32, 5, 2, 1, 1709313892, 1709313912),
(37, 3, 2, 1, 1710452633, 1710452646),
(38, 2, 6, 1, 1710521338, 1710521406),
(39, 2, 7, 1, 1710536726, 0),
(40, 2, 8, 1, 1710536726, 0),
(41, 7, 8, 1, 1710536726, 0),
(42, 4, 6, 0, 1710541368, 0),
(46, 10, 12, 0, 1711221027, 0),
(48, 10, 11, 0, 1711221077, 0),
(51, 11, 2, 1, 1711282935, 1711477738),
(52, 13, 2, 1, 1711283306, 1712073897),
(53, 10, 13, 0, 1711309425, 0),
(54, 10, 1, 0, 1711309429, 0),
(55, 10, 3, 0, 1711309449, 0),
(63, 2, 9, 1, 1711319201, 1711319204),
(64, 2, 15, 1, 1711378907, 1711378914),
(65, 10, 9, 0, 1711379621, 0),
(66, 16, 1, 0, 1711402143, 0),
(70, 10, 2, 1, 1711474918, 1711544042),
(71, 10, 15, 0, 1711489187, 0),
(73, 2, 12, 0, 1711997546, 0),
(74, 17, 6, 0, 1712427310, 0),
(75, 2, 17, 1, 1712427622, 1712427740),
(76, 17, 3, 0, 1712427744, 0),
(77, 17, 5, 0, 1712427747, 0);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `creator` int(11) NOT NULL,
  `maxplayers` int(11) NOT NULL DEFAULT 50,
  `genre` varchar(50) NOT NULL,
  `moderation` enum('Pending','Accepted','Refused') NOT NULL DEFAULT 'Pending',
  `renderYear` enum('2008','2011','2011edited2016','2016') NOT NULL DEFAULT '2008',
  `gameClient` enum('2011E','2016L') NOT NULL DEFAULT '2011E',
  `players` int(11) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `name`, `description`, `creator`, `maxplayers`, `genre`, `moderation`, `renderYear`, `gameClient`, `players`, `created`, `updated`) VALUES
(1, 'The Normal Elevator', 'Um what the sigma', 2, 50, '', 'Accepted', '2008', '2016L', 0, 1710711655, 1710711655);

-- --------------------------------------------------------

--
-- Structure de la table `invitekeys`
--

CREATE TABLE `invitekeys` (
  `id` int(11) NOT NULL,
  `invitekey` varchar(100) NOT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invitekeys`
--

INSERT INTO `invitekeys` (`id`, `invitekey`, `used`, `created`) VALUES
(1, 'phoebereal', 1, 0),
(2, 'OPI77lcLZLlJ1V5fXJGmKUxDyBwFtgTO', 1, 1710520777),
(3, 'YKYZZXrsG6meyuc4gs1GO0jOYVTKbpps', 1, 1710536681),
(4, 'Y1lAsLNL4mXlHwCVosl56NJsUP2kLbhH', 1, 1710536698),
(5, 'Dte4xprhlW1sqbGSxuC71MAXetf8iG1l', 1, 1710537555),
(6, 'FIYgRdNJ7ABDO57KRnYWO0TJCIa2ip0F', 1, 1710546779),
(7, 'vjsgc70YzLfs9GkSrhdDels8IZv4anRQ', 1, 1711220490),
(8, '7UtORgMUvwhPBwKLrxRgyxIJKTUX0ZOO', 1, 1711220516),
(9, 'fUXydrJpRNVZQEwQOKrjPXfWZpeWQTyI', 1, 1711283020),
(10, 'cJGMiKeLiC2Hf0ToTWDgGReT7H1M8rCu', 1, 1711283429),
(11, '0W6Gm7pP6aOmYoaY8bK1Ds5yhaa7AZU4', 1, 1711378402),
(12, 'EJxnL0y29jjRS8RNffxStdEoFL4sK5L8', 1, 1711378436),
(13, 'zOAIMXwJsFJ0kpvlSHtChNH1ATDFbcgZ', 1, 1712427107);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `subject` varchar(70) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `hasBeenRead` int(11) NOT NULL DEFAULT 0,
  `reply` int(11) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user1`, `user2`, `subject`, `content`, `hasBeenRead`, `reply`, `created`) VALUES
(1, 1, 2, 'Fun fact', 'I shitted in my pants (pululu) i am for reaal. Never meant to take my booty shit I got poo all my juicy bits', 1, 0, 1710451585),
(2, 2, 1, 'What', 'Tf??', 0, 1, 1710451585),
(3, 1, 2, 'REAL!', 'Nugget', 0, 1, 1710451585),
(4, 2, 6, 'sent from db real', 'welcum to roget', 1, 0, 1710521479),
(5, 1, 2, 'You have earned 100000049 nuggets!', 'User alix20152 (ID 5) has bought your item: \"I HATE #### SHIRT\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711548352),
(6, 1, 2, 'You have bought I HATE #### SHIRT for 100000049 nuggets.', 'You have bought an item: \"I HATE #### SHIRT\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1711548352),
(7, 1, 9, 'You have earned 100000099 nuggets!', 'User nolanwhy (ID 2) has bought your item: \"LeTrisomique\" at 25 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711548410),
(8, 1, 2, 'You have bought LeTrisomique for 100000099 nuggets.', 'You have bought an item: \"LeTrisomique\" at 25 nuggets from user LazyAdmin (ID 9).\nThe item has been given to you.', 1, 0, 1711548410),
(9, 1, 9, 'You have earned 25 nuggets!', 'User nolanwhy (ID 2) has bought your item: \"LeTrisomique\" at 25 nuggets.\nThe nuggets has been given to you.', 0, 0, 1711548448),
(10, 1, 2, 'You have bought LeTrisomique for 25 nuggets.', 'You have bought an item: \"LeTrisomique\" at 25 nuggets from user LazyAdmin (ID 9).\nThe item has been given to you.', 1, 0, 1711548448),
(11, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"Elon Musk\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711653621),
(12, 1, 10, 'You have bought Elon Musk for 5 nuggets.', 'You have bought an item: \"Elon Musk\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1711653621),
(13, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"I HATE #### SHIRT\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711653639),
(14, 1, 10, 'You have bought I HATE #### SHIRT for 5 nuggets.', 'You have bought an item: \"I HATE #### SHIRT\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1711653639),
(15, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"noob tshirt\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711653644),
(16, 1, 10, 'You have bought noob tshirt for 5 nuggets.', 'You have bought an item: \"noob tshirt\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1711653644),
(17, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"noob tshirt\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1711653647),
(18, 1, 10, 'You have bought noob tshirt for 5 nuggets.', 'You have bought an item: \"noob tshirt\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1711653647),
(19, 1, 9, 'You have earned 25 nuggets!', 'User alix20152 (ID 5) has bought your item: \"LeTrisomique\" at 25 nuggets.\nThe nuggets has been given to you.', 0, 0, 1711807953),
(20, 1, 5, 'You have bought LeTrisomique for 25 nuggets.', 'You have bought an item: \"LeTrisomique\" at 25 nuggets from user LazyAdmin (ID 9).\nThe item has been given to you.', 1, 0, 1711807953),
(21, 1, 2, 'You have earned 5 nuggets!', 'User hadi (ID 12) has bought your item: \"Elon Musk\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1712067915),
(22, 1, 12, 'You have bought Elon Musk for 5 nuggets.', 'You have bought an item: \"Elon Musk\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 0, 0, 1712067915),
(23, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"Dog\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1712069102),
(24, 1, 10, 'You have bought Dog for 5 nuggets.', 'You have bought an item: \"Dog\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1712069102),
(25, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"Elon Musk\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1712074945),
(26, 1, 10, 'You have bought Elon Musk for 5 nuggets.', 'You have bought an item: \"Elon Musk\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1712074945),
(27, 1, 2, 'You have earned 5 nuggets!', 'User Lahza (ID 10) has bought your item: \"Dog\" at 5 nuggets.\nThe nuggets has been given to you.', 1, 0, 1712078934),
(28, 1, 10, 'You have bought Dog for 5 nuggets.', 'You have bought an item: \"Dog\" at 5 nuggets from user nolanwhy (ID 2).\nThe item has been given to you.', 1, 0, 1712078934);

-- --------------------------------------------------------

--
-- Structure de la table `owneditems`
--

CREATE TABLE `owneditems` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `owneditems`
--

INSERT INTO `owneditems` (`id`, `user`, `item`) VALUES
(10, 2, 1),
(12, 3, 1),
(15, 2, 3),
(16, 6, 3),
(17, 7, 3),
(18, 7, 1),
(19, 7, 2),
(20, 8, 3),
(21, 9, 3),
(22, 9, 2),
(23, 9, 1),
(24, 6, 1),
(25, 6, 2),
(26, 4, 1),
(27, 4, 3),
(29, 13, 1),
(30, 13, 2),
(31, 13, 3),
(34, 14, 3),
(35, 14, 2),
(36, 14, 1),
(42, 9, 4),
(45, 15, 4),
(46, 15, 3),
(51, 5, 2),
(53, 5, 3),
(54, 16, 3),
(56, 2, 2),
(66, 10, 4),
(68, 5, 1),
(70, 2, 4),
(72, 10, 1),
(74, 10, 2),
(75, 5, 4),
(76, 12, 3),
(78, 10, 3),
(79, 10, 5);

-- --------------------------------------------------------

--
-- Structure de la table `renderqueue`
--

CREATE TABLE `renderqueue` (
  `id` int(11) NOT NULL,
  `remote` int(11) NOT NULL DEFAULT 0,
  `type` enum('user','place') NOT NULL DEFAULT 'user',
  `client` enum('2011') NOT NULL DEFAULT '2011',
  `script` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `renderqueue`
--

INSERT INTO `renderqueue` (`id`, `remote`, `type`, `client`, `script`) VALUES
(12, 2, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=2\"\r\nplr:LoadCharacter()\r\n\r\n'),
(13, 5, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=5\"\r\nplr:LoadCharacter()\r\n\r\n'),
(14, 4, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=4\"\r\nplr:LoadCharacter()\r\n\r\n'),
(15, 12, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=12\"\r\nplr:LoadCharacter()\r\n\r\n'),
(16, 3, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=3\"\r\nplr:LoadCharacter()\r\n\r\n'),
(17, 17, 'user', '2011', 'local plr = game.Players:CreateLocalPlayer(0)\r\nplr.CharacterAppearance = \"http://shitblx.cf/Game/CharacterFetch.ashx?userId=17\"\r\nplr:LoadCharacter()\r\n\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `sessKey` varchar(1000) NOT NULL,
  `userId` int(11) NOT NULL,
  `ip` varchar(1000) NOT NULL,
  `userAgent` varchar(1000) NOT NULL,
  `mobileVersion` enum('None','2.271.97572') NOT NULL DEFAULT 'None',
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `mobileVersion`, `created`) VALUES
(1, 'a6988aede76687e1768cce072828002e78315d5334f2df91d479cde8b8899f194af09ce871d989e3e4351b6c17be1c713ca07175da075f0c5d8224d7a3946e6ffac656b2b0e848dafe094a60d8268b939564071d19f63f99ab8542a649acf4da2c566ca1', 2, 'deb8de37ad6900f98037390b2e5350a391e2e3b8001ed4457f324e09d1a90e4d0a3b3116f5261f15fbf150e985c3401b6cd89bf1fe2fdd79ef301df04dea643d', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'None', 1712156234),
(3, '9618ecdc9d16d1e93bceee14b29445e2f4a11698f0c60d78d0e138ef44d2e9e5b22fc962fad6c52a7961187279dfd210fa1a4576b5cad3867f6e205565ad6bf7fc2e0f11d54cf71e3da0232364ccbdfa5d50d1ca3a977ca63490f1e30219eadec16f7190', 3, 'e847835ccf9ea67396e28724efdfa207c49dbdda50c302a19a76e7323b915d132ed3d83a43debf173106b46ea2b3f6c8ae1e8eb549fd0c125e590a4778cc1a26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'None', 1712425556),
(4, '45e61c826f38f27e389df2a169ead486ed6b95862254afe5155af96f4157f6d4a27013aa0d8a501666186a4124830cd32742f95461438a68c13dbfcd0e06a32afc97e2afef75e148ade03c972b0fa06f54ed62e0c5ce071aee8b3f737a3b95c625225bad', 17, '7f6a4fdf68f35b001302da9e1ac55bda251867a6179a741545eaebadcf4c965179f0c89219c36e506b5e0f4d9539fc789f807adbc1f69e81d408997850c88670', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Mobile Safari/537.36', 'None', 1712427204),
(5, '1083206411a49192d621503f693e12c2b72dc6bb9b7f206d9be98732ada44aada78eeff5e06916727ded2ee2ac43ae92f5cb963a985ae6019852694b882d56247f5cee5f5e3bfd065c76638dc7a7b69ad1331ad6f58a60cffefa69bfca70fa86928225b0', 2, '234b14550cb6e1c8344142aec7759711ba3e98d66441d48518cfd9fdb86642983718332ce305956111a0287a3c82817b6fed76dce9d8da6bdd3f0b1eb47c11a8', 'Mozilla/5.0 (3679MB; 720x1384; 281x283; 360x692; Samsung SM-G950F; 9) AppleWebKit/537.36 (KHTML, like Gecko)  ROBLOX Android App 2.271.97572 Phone Hybrid() GooglePlayStore', '2.271.97572', 1712427230);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(10000) NOT NULL,
  `permission` enum('User','Moderator','Administrator') NOT NULL DEFAULT 'User',
  `buildersclub` enum('None','BuildersClub','TurboBuildersClub','OutrageousBuildersClub') NOT NULL,
  `lastonline` int(11) NOT NULL DEFAULT 0,
  `nuggets` int(11) NOT NULL DEFAULT 0,
  `description` varchar(1000) NOT NULL DEFAULT 'I''m new to ROGGET!',
  `renderYear` enum('2008','2011','2011edited2016','2016') NOT NULL DEFAULT '2008',
  `discord_verify_required` int(11) NOT NULL DEFAULT 1,
  `discord_verified` tinyint(1) NOT NULL DEFAULT 0,
  `discord_id` varchar(100) NOT NULL DEFAULT '0',
  `discord_access_token` varchar(100) NOT NULL DEFAULT '',
  `discord_refresh_token` varchar(100) NOT NULL DEFAULT '',
  `discord_expires_in` int(11) NOT NULL DEFAULT 0,
  `discord_time_since_no_verification` int(11) NOT NULL DEFAULT 0,
  `discord_last_server_check` int(11) NOT NULL DEFAULT 0,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banreason` varchar(100) NOT NULL DEFAULT '',
  `lastRender` int(11) NOT NULL DEFAULT 0,
  `bodyColors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '\'{"head":24,"torso":23,"leftarm":24,"rightarm":24,"leftleg":119,"rightleg":119}\'',
  `chatAuthentication` varchar(1000) NOT NULL DEFAULT '',
  `verified` int(11) NOT NULL DEFAULT 0,
  `theme` enum('dark','light') NOT NULL DEFAULT 'dark',
  `gameAuthentication` varchar(1000) NOT NULL,
  `csrfWarns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`csrfWarns`)),
  `playedGames` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`playedGames`)),
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `buildersclub`, `lastonline`, `nuggets`, `description`, `renderYear`, `discord_verify_required`, `discord_verified`, `discord_id`, `discord_access_token`, `discord_refresh_token`, `discord_expires_in`, `discord_time_since_no_verification`, `discord_last_server_check`, `banned`, `banreason`, `lastRender`, `bodyColors`, `chatAuthentication`, `verified`, `theme`, `gameAuthentication`, `csrfWarns`, `playedGames`, `created`) VALUES
(1, 'ROBLOX', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'OutrageousBuildersClub', -1712425598, 99999999, 'This account is not used. Please go to nolanwhy\'s account for the owner.', '2008', 0, 0, '0', '', '', 0, 2147483647, 0, 0, '', 1710601408, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '5df17fd93428e888d6cf164d0810793d5f68fe9f', '[]', '[]', 1709051501),
(2, 'nolanwhy', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1712430503, 100000039, 'I am the owner, and only developer of ROGGET!', '2016', 1, 1, '544207551219105792', 'cuxKiwjQ9MZ8S0y3nHqlj8jDxtDuhj', 'iWau0berseCyHw4D2kUa5CYH87LNXv', 1712757288, 1711221965, 1712428935, 0, '', 1712170618, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '4a1b40f11c50a2a00ba5e039c16a1baabd0c5fae', '[]', '[1]', 1709051501),
(3, 'builderman', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1712425995, 99999999, 'buildrmen', '2016', 0, 0, '', '', '', 1773520754, 2147483647, 0, 0, '', 1712425643, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', 'ff61292b5518521ef569a42a25b7629d3dd275d4', '[]', '[]', 1709051501),
(4, 'Shedletsky2', '$2y$12$POWubxjDbdUvMRq0Pd6J7ObIUslk/7TS/7GyxcohDwgN9I.sOYKyK', 'Administrator', 'OutrageousBuildersClub', 1711822299, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '715950519188717640', 'ANF2DCPR60Qb2JZRg2i9isUWKSaS5S', '0lZvquPaDQbrLPt9djK950jlNgwBaX', 1711749214, 2147483647, 1711144427, 0, '', 1711821590, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', '[]', '[]', 1709132544),
(5, 'alix20152', '$2y$12$CObHAI6xFNYHSSTj5ZEd5.Jr39xGEqYLP0DUwQswaK74v.WApPZYW', 'User', 'None', 1712084723, 99999954, 'I\'m new to ROGGET!', '2016', 0, 0, '1188133355057852488', 'F3XWI4mquV4sPMCOqwEygUyeILO7Ur', 'txhopRKzZehUsJV8Cp9qU9cSidZYFm', 1710271403, 2147483647, 0, 0, '', 1711807979, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '16bcd0d70554b8b982c566351e2a97477900a64c', '[]', '[]', 1709313658),
(6, 'copy', '$2y$12$A6ojvI9DtgSQYq/yS9wM3.Kaue6P7VJEHk9.y/F0joOf1N3u.UkP6', 'User', 'None', 1710616916, 99999999, 'I\'m new to ROGGET!', '2011', 1, 0, '523559687384203328', 'hq0dgDNq12GpNcJ9ZdiUsGfmW6g23h', 'Gn4YYFpZUsOpDRVzXQcJ0fhLbUqv2T', 1711126111, 2147483647, 0, 0, '', 1710614656, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', '[]', '[]', 1710521241),
(7, 'LeGamer', '$2y$12$yCkKHpWCRQOHXSHO4mr3y.T9DCmGYsg6CP6Jpf6pc2g8sfVzTIzCu', 'User', 'None', 1711305799, 99999999, 'I\'m new to ROGGET!', '2008', 1, 0, '786635042142420993', 'QnmCim8rOcOsvLOE3KzBAUkWi8gkUj', 'uGKmUbvutStdkhZqGNaAIDH4OP4dWX', 1711141545, 2147483647, 0, 1, 'Trisomique', 1710791092, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', '[]', '[]', 1710536698),
(8, 'Powerm1nt', '$2y$12$zgOwO.ztbkoMXTsfthyauuH9rRT.y4WSO6QLwrz.w9UylsKrTOUvu', 'User', 'None', 1710537430, 99999999, 'I\'m new to ROGGET!', '2008', 1, 0, '967171856073392219', 'HtFgXRV4SKM5z0KlgxB2YvSwbPZEqu', '3aKKMyXJMxIPcO1BRC9wflyH5xZufK', 1711142055, 2147483647, 0, 0, '', 1710601393, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', '[]', '[]', 1710537229),
(9, 'LazyAdmin', '$2y$12$.sAKKiwP1aoaS5UpcDVdvOC0m73o1kgloIYWwVQdOjLH0PDxuB.7.', 'Administrator', 'None', 1711654156, 100000149, 'I\'m new to ROGGET!', '2011edited2016', 1, 1, '1134256002959671368', '8XftO0HR0GVyAlyTyKcQVXJVaKTaZD', 'iYY4MY0Or7oJkq34pv78MAbNld8hVb', 1711476884, 2147483647, 1711389223, 0, '', 1711382793, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', '[]', '[]', 1710537569),
(10, 'Lahza', '$2y$12$yLBLxDE3MGCWPboiMF8Jq.l8.UWuMjO3FrBP/lqnPuZUp2W0AOEpK', 'User', 'None', 1712080938, 99999769, 'I\'m new to ROGGET!', '2016', 1, 1, '1221172754586271834', 'c77T7DRYiPYuKTPCmjRs1VivY3g3Os', 'aGXMBQB1P199BhN9QpxhwInD0WKCQh', 1711825758, 1711220565, 1711795812, 0, '', 1711544079, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '2fac2d7d9d809cf4c0f3abbcd48b8c66d001497c', '[]', '[]', 1711220565),
(11, 'DoggoITA', '$2y$12$qfMEJ8NSKJcSFoc.KMoRIu.r6A13.BGKB2iBALAXLe50UdWnRqVL6', 'User', 'None', 1711283059, 99999999, 'I\'m new to ROGGET!', '2016', 1, 1, '891372299515744306', 'vpFc3Tnf39qd2FuHMYWOYrLMqLj7cX', 'SkB288aomllG3ZbST3rVPr4WrEHJzq', 1711825385, 1711220574, 1711282293, 0, '', 1711221127, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', '[]', '[]', 1711220574),
(12, 'hadi', '$2y$12$XVp5NniVTEEJPjxLfHrKaO8Saip6i3C0cz0kuualMKhxlhxB2dSCy', 'User', 'None', 1712075028, 99999994, 'I\'m new to ROGGET!', '2008', 1, 1, '729738850410299453', 'qXw3071Gx0wKYUtQcfoH9MIBsWTUlR', 'wdDie9GsU2u0I0nMaGHWmO5tUAh8nU', 1711825466, 1711220592, 1711566067, 0, '', 1711997533, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', 'cd78d23d2950d862ddf12fc379b4a85579cd597f', '[]', '[]', 1711220592),
(13, 'newuser', '$2y$12$4Qay0qeelPg.ndhNjXPNI.6gXfv/me0pnyER1Twe3FyHQMkwqG4OG', 'User', 'None', 1711566623, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '670690147716825118', 'sqx2Bz0ldOfIhkcVBeyEclOrRQVNmw', '4kQxY2ApauINcnFweeYpAVCLeTWdGF', 1711887902, 1711283055, 1711285400, 0, '', 1711283377, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', '[]', '[]', 1711283055),
(14, 'Lookbehindyou', '$2y$12$6yeZvB6kfOS1gXgFsFflmuPYNUSJf7W/P7XKnon9gPzeESTnSeT.S', 'User', 'None', 1711283703, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '932317692789149776', '9LpFXj7AdHlAWxsIJCFo78lxZHGu3E', 'OGdZYuHzeG7kJ0Ovaiep1fuseQJu0p', 1711888367, 1711283450, 1711283568, 0, '', 0, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', '[]', '[]', 1711283450),
(15, 'mohamedfaitcaca', '$2y$12$cubYh4CrOOMFM/Iy8kqJC.X1lccp7H3EfT.zF2jt.3r6GWhg.8O3S', 'User', 'None', 1711388568, 99999969, 'I\'m new to ROGGET!', '2016', 1, 1, '1085584581530493039', '0FlTTYzHzJxkP9L05ohzKF25YIRR5v', 'd23UDPufrZgLen0cwnf3FmVi0OhH8H', 1711983450, 1711378556, 1711388564, 0, '', 1711378869, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', '[]', '[]', 1711378556),
(16, 'Kelbaz', '$2y$12$rg69Fapteq73WbiAAJxJoON6mdEtQvK0rdVs5qWax/J.r3WASo.YG', 'User', 'None', 1711985557, 99999994, 'I\'m new to ROGGET!', '2016', 1, 1, '465943316538589194', 'GwWOTnfZzb9eLYmqi8NBOuIBbulKLe', 'u6zu3Pn0p0mSf9WIT8rTz9j2s2DdTI', 1711983530, 1711378690, 1711479838, 0, '', 1711393961, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', '[]', '[]', 1711378690),
(17, 'rat', '$2y$12$FEeJ0doY9mcJQGlB6bgBKepKUux6cc7/LktjaDnSllejPsk3noJEi', 'User', 'None', 1712433570, 0, 'I\'m new to ROGGET!', '2011edited2016', 1, 1, '1196138118177357945', 'dtXeLcjiHklpvzjw49DG9rOXZ6BygM', 'MoWlKOJlvpepm6mXAqiiT5WtjfsMha', 1713032039, 1712427204, 1712427240, 0, '', 1712427776, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', 'cbbd70979d7ecc61d86e6d0cad61e4594bcd0b82', '[]', '[]', 1712427204);

-- --------------------------------------------------------

--
-- Structure de la table `wearing`
--

CREATE TABLE `wearing` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wearing`
--

INSERT INTO `wearing` (`id`, `user`, `item`) VALUES
(9, 6, 3),
(11, 6, 2),
(12, 6, 1),
(13, 2, 1),
(14, 4, 1),
(15, 4, 3),
(19, 7, 3),
(20, 7, 1),
(21, 7, 2),
(22, 13, 1),
(27, 9, 4),
(28, 15, 4),
(29, 15, 3),
(35, 9, 3),
(37, 5, 1),
(40, 16, 3),
(60, 10, 1),
(61, 10, 4),
(62, 10, 2),
(66, 5, 2),
(67, 12, 3),
(68, 10, 3),
(69, 10, 5),
(70, 2, 4),
(71, 3, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `allowedmd5hashes`
--
ALTER TABLE `allowedmd5hashes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `allowedsecurityversions`
--
ALTER TABLE `allowedsecurityversions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invitekeys`
--
ALTER TABLE `invitekeys`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `owneditems`
--
ALTER TABLE `owneditems`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `renderqueue`
--
ALTER TABLE `renderqueue`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wearing`
--
ALTER TABLE `wearing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `allowedmd5hashes`
--
ALTER TABLE `allowedmd5hashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `allowedsecurityversions`
--
ALTER TABLE `allowedsecurityversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `invitekeys`
--
ALTER TABLE `invitekeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `owneditems`
--
ALTER TABLE `owneditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `renderqueue`
--
ALTER TABLE `renderqueue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `wearing`
--
ALTER TABLE `wearing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
