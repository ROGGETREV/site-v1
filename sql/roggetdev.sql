-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 08 mars 2024 à 18:19
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

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
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `description`, `creator`, `nuggets`, `moderation`, `created`) VALUES
(1, 'Testing', 'Woah! ROGGET is the best revival', 2, 5, 'Accepted', 1709135565);

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
(3, 2, 3, 1, 0, 0),
(4, 4, 2, 1, 0, 0),
(21, 4, 3, 0, 1709143347, 0),
(22, 4, 1, 0, 1709143352, 0),
(23, 1, 2, 1, 1709153326, 1709153339),
(26, 2, 699, 0, 1709301217, 0),
(32, 5, 2, 1, 1709313892, 1709313912);

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
(1, 'phoebereal', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `renderqueue`
--

CREATE TABLE `renderqueue` (
  `id` int(11) NOT NULL,
  `remote` int(11) NOT NULL DEFAULT 0,
  `type` enum('user','place') NOT NULL DEFAULT 'user',
  `client` enum('2010') NOT NULL DEFAULT '2010'
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
(7, 'c81cae2a793954fc0d8a9c93fec96b60645127337553061ae0b3da191ca7321f033803182662ef510223a91fc73a50b4b87602b5d9df6914a526b79a75fe06351af1f3e9e0078a1f565554400b6251a943166ddd0236ac1d0c7b9d4c8fbae1710ed6e6f0', 2, '2f8748abdbb42c16f5d62251f8adea1f65443b6ed0ec063b49be332a6c8cc200892828deee3bbc44bffff040677446dfe0fe5d9dc5a2150d342dd93456b54e22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1709066727),
(8, 'abe0971bff7c6db49e60a843211864b4bf5ce73dbff1ce9377df138137c589ffc8a45be66ae22933e1b6f0802e6115392ed155e5f91dc5a40a0d8a6255c02344b79d9636a68badcf2d3057cd2912edbc58bfc1e5fa8c7d02ae0d8f6522774f376a3ada49', 1, '2f8748abdbb42c16f5d62251f8adea1f65443b6ed0ec063b49be332a6c8cc200892828deee3bbc44bffff040677446dfe0fe5d9dc5a2150d342dd93456b54e22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1709105608),
(9, '8a1bc65a6a5d68d1eaa5d05974f4e8dd6c9931c32673fa5566d53481ed0cfe7b26abece4edc5f62f21b350ef871341d508c80f781392a95d6d6b9a75fedb8617b7c8ba55426697aa560f131346b407a60109db4c44cc123668da521686379a1025a5c36a', 4, 'b182641f4f3abfccd9e190b0c438263a2d5663802448d7c91d35bd400ef5add4b51d338dc23836aa34f9d761dfb84c57d28978771804082c2677a50a5dc7b319', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 1709133743),
(11, '2f9563777133d8ea4aa9fecf80250bde9bffbc5950fc9146e575e097b444d440a49e5fdba9487397ee3793ae70fc4150a96f62d4b2b81ec020132bfecc0067f6b5a7e483d1522bb05f9e7bacd589c6318f41c528717b1b7930e735d6392f3500ddebac2d', 1, '2f8748abdbb42c16f5d62251f8adea1f65443b6ed0ec063b49be332a6c8cc200892828deee3bbc44bffff040677446dfe0fe5d9dc5a2150d342dd93456b54e22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1709142060),
(12, '8a91ed9ac7d0f9acf83cc88a000516f19f77e16ed4c7a0c118fcea24780cb670d755dc11f959230456cb29b8ef4556c2aed28a12125b02d227a73138a389fa99f93398c43f64a73aa37a880de46e7652acce4538edd206a57ba32c925faa38e81a8d3ec8', 5, '06ef526d445e658c22903efca7131da09766aec6837cd39167144ac56a23f560298d51239f322fb8b69e0ef6c1db8e5edf4e3c617204866ad69605b251d154a5', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 1709313658),
(13, '8eb1e59000658817c3d76b406550f65088e48ffc0a84309add8789f7535494af7ea2bb445d9c5c987ada4aa960a0bbccf750017d58f7fbe52170efef6bb57ca24916859a10ff5471dc3472402ec7dfcff87ed881f317fadcccf67e4357fb929222ad5ddf', 2, '2f8748abdbb42c16f5d62251f8adea1f65443b6ed0ec063b49be332a6c8cc200892828deee3bbc44bffff040677446dfe0fe5d9dc5a2150d342dd93456b54e22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1709672019);

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
  `discord_access_token` varchar(100) NOT NULL,
  `discord_refresh_token` varchar(100) NOT NULL,
  `discord_expires_in` int(11) NOT NULL DEFAULT 0,
  `discord_time_since_no_verification` int(11) NOT NULL DEFAULT 0,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banreason` varchar(100) NOT NULL,
  `lastRender` int(11) NOT NULL DEFAULT 0,
  `bodyColors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{"head":24,"torso":23,"leftarm":24,"rightarm":24,"leftleg":28,"rightleg":28}' CHECK (json_valid(`bodyColors`)),
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `buildersclub`, `lastonline`, `nuggets`, `description`, `renderYear`, `discord_verified`, `discord_id`, `discord_access_token`, `discord_refresh_token`, `discord_expires_in`, `discord_time_since_no_verification`, `banned`, `banreason`, `lastRender`, `bodyColors`, `created`) VALUES
(1, 'ROBLOX', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'OutrageousBuildersClub', 1709153342, 0, 'This account is not used. Please go to nolanwhy\'s account for the owner.', '2008', 0, '0', '', '', 0, 1999999949, 0, '', 1709666709, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":28,\"rightleg\":28}', 1709051501),
(2, 'nolanwhy', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1709914605, 0, 'I am the owner, and only developer of ROGGET!', '2011', 1, '544207551219105792', 'zpa9Q8MbtYtcIknQ5hpIbAQYmsHMkB', '6uHk5wQ2iMGhLxQAkcuKGSJbApF41T', 1710206202, 1999999949, 0, '', 1709826636, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":28,\"rightleg\":28}', 1709051501),
(3, 'builderman', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'BuildersClub', 1, 0, 'I\'m new to ROGGET!', '2016', 0, '0', '', '', 0, 1999999949, 0, '', 1709817143, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":28,\"rightleg\":28}', 1709051501),
(4, 'Shedletsky2', '$2y$12$POWubxjDbdUvMRq0Pd6J7ObIUslk/7TS/7GyxcohDwgN9I.sOYKyK', 'Administrator', 'OutrageousBuildersClub', 1709650063, 0, 'I\'m new to ROGGET!', '2008', 1, '715950519188717640', 'TG1npDxA1nwocqW4nPInWjrEjhRmMD', 'VAS2DIUTzjffbXBijkbjm22pZWJn5L', 1710253098, 1999999949, 0, '', 1709666714, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":28,\"rightleg\":28}', 1709132544),
(5, 'alix20152', '$2y$12$CObHAI6xFNYHSSTj5ZEd5.Jr39xGEqYLP0DUwQswaK74v.WApPZYW', 'User', 'None', 1709666817, 0, 'I\'m new to ROGGET!', '2011edited2016', 1, '1188133355057852488', 'F3XWI4mquV4sPMCOqwEygUyeILO7Ur', 'txhopRKzZehUsJV8Cp9qU9cSidZYFm', 1710271403, 1999999949, 0, '', 1709668063, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":28,\"rightleg\":28}', 1709313658);

--
-- Index pour les tables déchargées
--

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
-- AUTO_INCREMENT pour les tables déchargées
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `invitekeys`
--
ALTER TABLE `invitekeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `renderqueue`
--
ALTER TABLE `renderqueue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
