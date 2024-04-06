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
(1, 'Oh my god. This is too skibidi! I am sigmaing!', 'danger');

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
(1, 'Skibidi Toilet Simulator', 'Um what the sigma', 2, 50, '', 'Accepted', '2008', '2016L', 0, 1710711655, 1710711655);

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

-- --------------------------------------------------------

--
-- Structure de la table `owneditems`
--

CREATE TABLE `owneditems` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `mobileVersion` enum('None','2.271.97572') NOT NULL DEFAULT 'None',
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
