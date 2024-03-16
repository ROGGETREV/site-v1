-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 16 mars 2024 à 12:55
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
(2, 'This website is NOT DONE. You can\'t access it, and you can\'t become a beta tester.', 'secondary');

-- --------------------------------------------------------

--
-- Structure de la table `allowedmd5hashes`
--

CREATE TABLE `allowedmd5hashes` (
  `id` int(11) NOT NULL,
  `md5` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `allowedsecurityversions`
--

CREATE TABLE `allowedsecurityversions` (
  `id` int(11) NOT NULL,
  `ver` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Elon Musk', 'real', 2, 5, 'Accepted', 'face', '2008', 1710357425);

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
(42, 4, 6, 0, 1710541368, 0);

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
(6, 'FIYgRdNJ7ABDO57KRnYWO0TJCIa2ip0F', 0, 1710546779);

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
(4, 2, 6, 'sent from db real', 'welcum to roget', 1, 0, 1710521479);

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
(14, 2, 2),
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
(27, 4, 3);

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
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `created`) VALUES
(1, '12095dee1f97c04c9bb8634ab9e2f078d3b6779c023968036f8cf397f18510ce1961e143fd8ece9ce800bd6732f20491ea0d6c6db0200b2a72ea8e0288bce439b55db744065f4289fb8bf07618f33a85b2d5f9056f033ed3426cd137161ac373c98aeda8', 2, '04347fea7a3e48394b39ce4aec3c0430c17256ff9a65e6cdedcf4b1dc48083f346bc79b7c5a7a225012670ed0847aba298bee3a6acdb3a3a13f4d1b9020c216a', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710005353),
(2, '61c10d85e6743104a0da8efb1f9dcda0aa741d52a69912f2a259f5ebef4e1aaf9ead2de1e47b04da8dc6dac0c49da2f48a37e4b46a57728e8adb167b398e8bda797f0e33b92c45898c0ede2eabd5b123e8fe21367852ac163b8dc9d9216eec28911c6b7f', 5, '9aa0302a4724f2d36f3db6376f0467cf5a9e09073d300148129915e4b6b357da7fb42e6c38e32b1715f8929afc566aefacf99755d17bc97a72116bdd606e510a', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 1710092291),
(3, '71c1189b12e6d7ac77aa4d9d5747909afaa71807575d03bb1f23260bc106b735c76533828347ab229993f8ef070316d491dfe91a751a602b1ddbc575cc1de1bb0c60d6ecbc73ec6dd84435f159eda26abeb6255db5ef4d05b82cf9dd7ed6062ff034d5bd', 3, 'f13c186523d579443c7e28e1a79145d447aa53725f493c9cafe97cad6075fcd266b6d64c0f04de947fc9f61f1888b6a8a3cfb4cb76760435c8af60ca49769d76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710344584),
(4, 'fd991180db958f4b1ff843ad8bf4a02250b5523592717c468bb1f1703f15b30b9a6fac18336c6a35313b87a600027b82de294a1789073f31e881e78575548894e10aa1bc1b821141efafa640471ccdd9effcf21171bcf421dc17f6713d2c52085b5dfa68', 2, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710367547),
(5, '294a36ecc74d30948015c5f866fd1d9301dec223f14572629dc8d6515c9c1528af0179eebaf041df6839ce629785bbf1d443062c6446e768b32bc225395c88bd0477fe884a874a4a6e57fc386e657707f411b05bc2c2ebfa86d876c6f144695969a28052', 6, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 1710521241),
(6, '14767ca8fcb2f90921f310626699bfafdfb683c8c6443cf748fab184a236fc56a274089688a6108c777e30c74ede7a103deffcf0cbea9cb71557837ffca7a700bb6845765baba2d99d7e04a4e108fc635f5cba3e1d1efc76312003b795de0cecd26e9cb4', 2, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710528115),
(7, 'd7cf97337bbc1e24c6727925a504ca4ab0daa6ea3d6f2577ffef9119c635a4cee886700ed951ac44f2335887208e2b6f2c528f94831dda97e6cfb08a2fc8397a161b44cd36c0f6852b76d24b384de26cb3464f9efab58507b4f19feebed5276222aca373', 7, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (X11; Linux x86_64; rv:123.0) Gecko/20100101 Firefox/123.0', 1710536698),
(8, '844080840c4bc5b5a250effd46cd0ef9626f7a581a7e236be1f3c4ab6eae5fcf5635dca6b6a957d002155fd40d48a28a15d187e0ace116dfc771e469b202c7dc6fbf4444efc532c9682966d159ee974f2d8bc7bba64e8c81710821553ab97faa5180ee26', 8, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710537229),
(9, 'f28defac478a8035ba4783cb015982a68ac114b80abc4a997dd67d0732bea9dd8e22aac0c6932580679ec18e8335cd5c1fa177d524df8ebdc87dff8541f99210fd5f92a77925829c48f5f35753d601ee51d7259faa9a91e4f1da4cd88bb4d9277bdcccc0', 9, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0', 1710537569),
(10, '896585481aa85654728a934ec106312457d167f6674e712d359cfb8d8664c0ac4fc00c28eb35a0b91319271831977bdee023e731cc4d01a79db67a1af76c29d810215fff1457a1b34f36ba2b1a79cc9e177828297b3466bf1366def2dff567128645231b', 4, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 1710541146),
(11, 'd6082a5d33871f0304364dde9ce6c0d6bbbd41b7c3578d2ac2100fcf9601124d9070a56d4833b2947d1bb54289faafb0c3ec93d0cadf759cd58f7395d5f7086bb47073394526d4d95d5fad87868bfe4aa32a088903a63dd1c4f91b904e06d0d48d6c8959', 7, '4e53c4ef3d174812ca8768d9f9cc9107846c7a6e9bda98654bfc9633e155faf2f9405579df59ce5ea6ba6cf932fc5ea32286045a947499955a0944f68970c09e', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1710545185);

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
  `discord_verified` tinyint(1) NOT NULL DEFAULT 0,
  `discord_id` varchar(100) NOT NULL DEFAULT '0',
  `discord_access_token` varchar(100) NOT NULL DEFAULT '',
  `discord_refresh_token` varchar(100) NOT NULL DEFAULT '',
  `discord_expires_in` int(11) NOT NULL DEFAULT 0,
  `discord_time_since_no_verification` int(11) NOT NULL DEFAULT 0,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banreason` varchar(100) NOT NULL DEFAULT '',
  `lastRender` int(11) NOT NULL DEFAULT 0,
  `bodyColors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '\'{"head":24,"torso":23,"leftarm":24,"rightarm":24,"leftleg":119,"rightleg":119}\'',
  `chatAuthentication` varchar(1000) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `buildersclub`, `lastonline`, `nuggets`, `description`, `renderYear`, `discord_verified`, `discord_id`, `discord_access_token`, `discord_refresh_token`, `discord_expires_in`, `discord_time_since_no_verification`, `banned`, `banreason`, `lastRender`, `bodyColors`, `chatAuthentication`, `created`) VALUES
(1, 'ROBLOX', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'OutrageousBuildersClub', 1709153342, 99999999, 'This account is not used. Please go to nolanwhy\'s account for the owner.', '2008', 0, '0', '', '', 0, 1999999949, 0, '', 1710542018, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1709051501),
(2, 'nolanwhy', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1710589792, 99999999, 'I am the owner, and only developer of ROGGET!', '2008', 1, '544207551219105792', 'z8tKvd6YScSgarQnwkTStsI2m6QvVG', 'TTarDJb2vMTX969E8NbJzN0dy2sJ6L', 1710947145, 1999999949, 0, '', 1710587908, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1709051501),
(3, 'builderman', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1710452648, 99999999, 'buildrmen', '2016', 1, '', '', '', 1773520754, 1773520754, 0, '', 1710542020, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1709051501),
(4, 'Shedletsky2', '$2y$12$POWubxjDbdUvMRq0Pd6J7ObIUslk/7TS/7GyxcohDwgN9I.sOYKyK', 'Administrator', 'OutrageousBuildersClub', 1710546772, 99999989, 'I\'m new to ROGGET!', '2008', 1, '715950519188717640', 'llRiKZrzSerIpGAfqCqLNwSPURAlwi', 'NhBLikLfQmU0c0Whnlfx2b9CFKaS8z', 1711145946, 1999999949, 0, '', 1710542021, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1709132544),
(5, 'alix20152', '$2y$12$CObHAI6xFNYHSSTj5ZEd5.Jr39xGEqYLP0DUwQswaK74v.WApPZYW', 'User', 'None', 1710092308, 99999999, 'I\'m new to ROGGET!', '2011edited2016', 1, '1188133355057852488', 'F3XWI4mquV4sPMCOqwEygUyeILO7Ur', 'txhopRKzZehUsJV8Cp9qU9cSidZYFm', 1710271403, 1999999949, 0, '', 1710542021, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1709313658),
(6, 'copy', '$2y$12$A6ojvI9DtgSQYq/yS9wM3.Kaue6P7VJEHk9.y/F0joOf1N3u.UkP6', 'User', 'None', 1710543732, 99999989, 'I\'m new to ROGGET!', '2011', 1, '523559687384203328', 'hq0dgDNq12GpNcJ9ZdiUsGfmW6g23h', 'Gn4YYFpZUsOpDRVzXQcJ0fhLbUqv2T', 1711126111, 1710521241, 0, '', 1710542022, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1710521241),
(7, 'LeGamer', '$2y$12$yCkKHpWCRQOHXSHO4mr3y.T9DCmGYsg6CP6Jpf6pc2g8sfVzTIzCu', 'User', 'None', 1710545901, 99999984, 'I\'m new to ROGGET!', '2011', 1, '786635042142420993', 'QnmCim8rOcOsvLOE3KzBAUkWi8gkUj', 'uGKmUbvutStdkhZqGNaAIDH4OP4dWX', 1711141545, 1710536698, 1, 'Trisomique', 1710542022, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1710536698),
(8, 'Powerm1nt', '$2y$12$zgOwO.ztbkoMXTsfthyauuH9rRT.y4WSO6QLwrz.w9UylsKrTOUvu', 'User', 'None', 1710537430, 99999994, 'I\'m new to ROGGET!', '2008', 1, '967171856073392219', 'HtFgXRV4SKM5z0KlgxB2YvSwbPZEqu', '3aKKMyXJMxIPcO1BRC9wflyH5xZufK', 1711142055, 1710537229, 0, '', 1710542023, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1710537229),
(9, 'LazyAdmin', '$2y$12$.sAKKiwP1aoaS5UpcDVdvOC0m73o1kgloIYWwVQdOjLH0PDxuB.7.', 'User', 'None', 1710547355, 99999984, 'I\'m new to ROGGET!', '2016', 1, '1134256002959671368', 'C4RSeUxYPvPckrld4B12SYeqbplYMb', 'oZFO0W4feyReC78xQc9aYLF9zrVEnM', 1711142391, 1710537569, 0, '', 1710547333, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 1710537569);

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
(6, 2, 2),
(9, 6, 3),
(11, 6, 2),
(12, 6, 1),
(13, 2, 1),
(14, 4, 1),
(15, 4, 3),
(17, 9, 1),
(18, 2, 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `allowedmd5hashes`
--
ALTER TABLE `allowedmd5hashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `allowedsecurityversions`
--
ALTER TABLE `allowedsecurityversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `invitekeys`
--
ALTER TABLE `invitekeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `owneditems`
--
ALTER TABLE `owneditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `renderqueue`
--
ALTER TABLE `renderqueue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `wearing`
--
ALTER TABLE `wearing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
