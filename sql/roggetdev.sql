-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 mars 2024 à 22:45
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
(2, 'This website is NOT DONE. You can\'t access it, and you can\'t become a beta tester.', 'secondary'),
(3, 'For beta testers, 2008 and 2011 renders are temporarily down.', 'danger');

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
(4, 'LeTrisomique', 'Ahhh il est moche!', 9, 25, 'Accepted', 'tshirt', '2011', 1711316980);

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
(50, 2, 12, 0, 1711229022, 0),
(51, 11, 2, 1, 1711282935, 1711477738),
(52, 13, 2, 0, 1711283306, 0),
(53, 10, 13, 0, 1711309425, 0),
(54, 10, 1, 0, 1711309429, 0),
(55, 10, 3, 0, 1711309449, 0),
(63, 2, 9, 1, 1711319201, 1711319204),
(64, 2, 15, 1, 1711378907, 1711378914),
(65, 10, 9, 0, 1711379621, 0),
(66, 16, 1, 0, 1711402143, 0),
(70, 10, 2, 1, 1711474918, 1711544042),
(71, 10, 15, 0, 1711489187, 0);

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
  `gameClient` enum('2010L','2011E','2016L') NOT NULL DEFAULT '2011E',
  `created` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `name`, `description`, `creator`, `maxplayers`, `genre`, `moderation`, `renderYear`, `gameClient`, `created`, `updated`) VALUES
(1, 'test', 'real', 2, 50, '', 'Accepted', '2008', '2016L', 1710711655, 1710711655);

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
(12, 'EJxnL0y29jjRS8RNffxStdEoFL4sK5L8', 1, 1711378436);

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
(10, 1, 2, 'You have bought LeTrisomique for 25 nuggets.', 'You have bought an item: \"LeTrisomique\" at 25 nuggets from user LazyAdmin (ID 9).\nThe item has been given to you.', 1, 0, 1711548448);

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
(64, 10, 2),
(65, 10, 3),
(66, 10, 4),
(67, 10, 1),
(68, 5, 1),
(70, 2, 4);

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
(1, 'a4529437eb45184cf4b56c7590b19cfcf7d30e7a85ad8c50870219cd5fe1135c614ea8748587354e277eca9d0fbbe91e6272ebc731e544776c25f6c38e70abcccca7997bb11cb00952eaa5ab660aa972ff078054e34a415781ba9daa2d2fb462157d3a93', 2, '320f41128af30cff9ddcc2df217d9397342dfc074a09793978281b7463a2f5932e27caf974d77ed430a613de09e36fbff003ef3322a1f9cb26ee64f54c7d4429', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711306752),
(2, '5c54b961101ce3847ac4fe940d0dc0124cc24376e207a8ed855f0562466eba62531e61ba19ae2a7ad639f1d972695a904616c369b64b07319abaeaa8e5dd4d13b01cddb77da5ae5da3f01fbe609103f422376e601cb4ceeda991d419c7b183119741ceb6', 10, '46b5360cf03009be0ed8713e26542bf158f06c8591a7261045c48bc95962bb0e822f1497327233347a2a68ffee6fd20f78a2f6034632989668c4426178727335', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0', 1711308686),
(3, '8839168332b1fc8e97bdaa38c4808e330459c32333434fc0b871c7b85b3aada66dcda184623e6cebcf94bfb7a9ed91c7e2d23e57fafb3f28b9b48fccba5129ebfebefca18cb292fe73f8dda25f8957938de6c625ae1f761743da5e1bfcbe817b752dc020', 2, '48cefb4f6bc4a8b493a9a53192ef86d9899b33524a5fc7ac728b7b8d711a6349ccddeee28b69cd97c8495ffb0fcd2b6a42fa95d1f731c4b49092b998032b1548', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711311996),
(4, 'bd1d15202c585f8b0c5fff8dcb3e15eb0268c7cca5ffbfc17bc8802d84754a85c4733b92a86a133695a1340b824d81b225e19bd844bf58cbf97c657591ff0d1d4856e467a5e70d393d19c09347aa15ed8ad890aa1c8db1e573b80d784326998b61fa4c52', 9, '406474cc5b6a558bcbea2cc03c23c42730fa6617e7e71fce857318eed76b57449045614884a130ac2c1c5d960334550a57a5c5b3314b3ce7b550a7db75005993', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 1711316758),
(5, '892c47e874aea8988a7e395e81f9f241bd9dd5687c240512aef6c884e9a502c108c27bfdee736884e16c53d504fe41d472472d40a83518f7cfe5db1bba07f93fd8c11f8cdf68f6d7c76897a82bf6d52f962906042964392f6816953dedfcc3729c92b125', 15, '6a9c16cb0c1b8d343ba020b548b49b165ed7ea0104ecfb51e0beeb8e167a1ebfca1f5432c9baa451d00bb7a85c743620beec4936a7a6ae8fae1d4b4ece5c7e77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711378556),
(6, 'fa11a5f9b733d37582012a99693671f1cd93bdde72281cd15abd3d32d52f9eb5bd746529db3da8db1137b42e9002549a0f4b69e7cb1a7eab62cad020ebb28fa56e6810362e6192d09ab887a5e017ed93c60068df191a718992f5f3fe258bef8916463c65', 16, '94ad49d2d04bf33a9cb9fc0bc23ee77ebdc3d6bb7d79c9351a75b8552a423ff089f34f41915815a6d3faa6e60195dbe70baa485741d69165675ac154dd1b9f78', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Mobile Safari/537.36', 1711378690),
(7, '6dbe3c7457832bf0b163de8a2ffeb6b3bdbb843998e27c7af78b6e15d7f767ec7b9cc39f6b2d8d89e7b804e268cb3ed1bd5d925ad40d927aeda22d51fb12a0315bcd5551fd00031335cd09aadc479ccc5e3c756f6a154319e68cf538609d72dc0bfa2c26', 9, '73b333c8d92b145228d040562afba5e282c6542127d50d4f80918d0b1c04681182e579d64f0e4ab5466f462284b3ec0c038aaef01cbe01a04a16822a3fc07b6d', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 1711382778),
(8, '177b527c0756cc18712e7c1b941c3bc47c49b564c8a49a44b46ac999e5a8e7c7799124f8f8137d4438048ca148458a08b661983d11575394eef67f94770b00c12b29536bc2e73105b9219a8cdf4bcdfe6d5367184dbbb08f4ec76159e88d5bfb73ef4701', 5, 'ca6fb732aa7ec8f935fb2b6ce2691c2cfd6b6a24aa59daf1a1700553ba01af4ace1d7ab019ed06294a6ba6060f48d754356060a0053e8634a2c91cd17d9c3eac', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 1711386447),
(9, 'dc11172a5804cfc0217f5b9763ada9735b7d0d30e0a89c3056ce3317f587bbb51f69b5991ec91724462ab3f488a20d1cf570b3bdf29fc2a2234bb62a5118a345bd87459dd574c1d2d700b820c309c27c21d5ba04a21d655de444089b0d9cb4898ec02a73', 16, 'dee9ee511e7941c4d4de8a584cb4d211eb043882c414be42bcdd09da9504182e68fab46ab8cbad45f93b473af99b8449981cefa95808b37163d54c87b57fb2ec', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711389263),
(10, '8188a0158b274615b012c9aa054b35e6e0163da1f40c60c012a7c788a2dac5681d35cd10c862d749000724ec0a28c216c920068a4397d7655f8e708d7bdb8c5f5737ff8f96bd67a2a6e1f2e035139b6285a4aeda94dafd026147ce5149000fc334f5eb5f', 16, 'd026364051c61c9ea964c9cb7df180439457cf75d01d872e5c3654820bf8f9faa3f45ee265d9e30a2cad4022014203ccb8a6c02c2ee8da338b0ede429430b27a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711389726),
(11, '2bff7d6f82f5b1b3282cdf50c7925c2316f3401ff375a0fb0a12e3fed3a91879124ba6214caefeaa7ef69d14f5fe98f7ae006063c78b5e54a27289bd1cf03e24b8db80a92e8693974c147b07db36dba66add78af72ef7e0edf5dc21b8c38db9e92d741db', 2, 'a34d7d74fd15f40298cfad10c75aa83c0e719644aeb2785ee23c646fa03dff3f1ae54ce44ff84923a70fffa6761c1bbe48dc359bac09422261b220b580f615bf', 'Mozilla/5.0 (3631MB; 1080x2199; 403x402; 360x733; Samsung SM-A226B; 13) AppleWebKit/537.36 (KHTML, like Gecko)  ROBLOX Android App 2.271.97572 Phone Hybrid() GooglePlayStore', 1711391719),
(12, 'cebdc497249b7605b06a573c61abf4fd12a4165a98da67874e738e409acba92c04a636a188c6db62dd55fe63139fbacc34f2fba7216ecda812a77603e5cb5ce917ded160495443c205d553b0447ff1151b2a1679ceacd4369144787b9c5fc0dbe9a5a516', 12, 'c7812286f1dae10c704b3e701c9e9eb53978fbba16ece2adbfb5df56c2260a9959633129c374d8e3468193043513fd8f6b7be7a1682dc100cd8a5c16bfe09c5e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1711566067),
(13, '975efd846fce2bfbc844d7e519f2ec326370f6ae0e9e43e18e943529468644e1a5b0927391cf23370cfcb7b39a290a8a6406ab883dfd0cd6b79bd59737ae062e3bdaace2ada6094c271bfe29a882ba42cd9f51c3ceac72d37605057474fd44a09662cb0d', 13, 'c087f47294a33515ddaf9531a5a703b8c9c36f940c6bbad57f3dbd7a17985a7ffb8bea4288834ee256ff6480f880716330510321fa266508dcdc5058660f5705', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.0', 1711566458);

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
  `created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `buildersclub`, `lastonline`, `nuggets`, `description`, `renderYear`, `discord_verify_required`, `discord_verified`, `discord_id`, `discord_access_token`, `discord_refresh_token`, `discord_expires_in`, `discord_time_since_no_verification`, `discord_last_server_check`, `banned`, `banreason`, `lastRender`, `bodyColors`, `chatAuthentication`, `verified`, `theme`, `gameAuthentication`, `created`) VALUES
(1, 'ROBLOX', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'OutrageousBuildersClub', 1711306714, 99999999, 'This account is not used. Please go to nolanwhy\'s account for the owner.', '2008', 0, 0, '0', '', '', 0, 2147483647, 0, 0, '', 1710601408, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', 'nigga', 1709051501),
(2, 'nolanwhy', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1711575793, 99999999, 'I am the owner, and only developer of ROGGET!', '2011', 1, 1, '544207551219105792', 'XyfrzYGrOvl1ZLDaURDGoJilA5wPGn', 'GIJLFgP2Y5tvZL2GRmwLSoRBEWWZCN', 1711826946, 1711221965, 1711575792, 0, '', 1711543349, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '818dc39d1900a0262c84a99ff2565392ee53765eb8ef7fb57e76cc718525d85b574672d577eb15618c919a47fc29e3d96d9730a6645e258e002c501939864cd33063d2ff273bca210abbc66a34e2803914df54a3faf89648e91ea59dce1b99da70e9df59', 1709051501),
(3, 'builderman', '$2y$12$91Gkb.GUjpD7KNPEQlC.JOSLpfnUp8UMQQuqPw/cJnwzqMA4J8Rvi', 'Administrator', 'TurboBuildersClub', 1710452648, 99999999, 'buildrmen', '2016', 1, 0, '', '', '', 1773520754, 2147483647, 0, 0, '', 1710601413, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', 1709051501),
(4, 'Shedletsky2', '$2y$12$POWubxjDbdUvMRq0Pd6J7ObIUslk/7TS/7GyxcohDwgN9I.sOYKyK', 'Administrator', 'OutrageousBuildersClub', 1711144514, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '715950519188717640', 'ANF2DCPR60Qb2JZRg2i9isUWKSaS5S', '0lZvquPaDQbrLPt9djK950jlNgwBaX', 1711749214, 2147483647, 1711144427, 0, '', 1711144489, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', 1709132544),
(5, 'alix20152', '$2y$12$CObHAI6xFNYHSSTj5ZEd5.Jr39xGEqYLP0DUwQswaK74v.WApPZYW', 'User', 'None', 1711548357, 99999979, 'I\'m new to ROGGET!', '2016', 0, 0, '1188133355057852488', 'F3XWI4mquV4sPMCOqwEygUyeILO7Ur', 'txhopRKzZehUsJV8Cp9qU9cSidZYFm', 1710271403, 2147483647, 0, 0, '', 1711386697, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', 'b06ce254b3207ad5d8455bd4726a85f1e4382db73a0c6652040900ac36c8593d42c94e7f0c537328886c2f642b3223aa87cd87b0a820be3038f4fbf89759dad444333ce862880c20c4e3f22e5d99c7a7577d25492dd845c9a4fed5d1aab98625d6566623', 1709313658),
(6, 'copy', '$2y$12$A6ojvI9DtgSQYq/yS9wM3.Kaue6P7VJEHk9.y/F0joOf1N3u.UkP6', 'User', 'None', 1710616916, 99999999, 'I\'m new to ROGGET!', '2011', 1, 0, '523559687384203328', 'hq0dgDNq12GpNcJ9ZdiUsGfmW6g23h', 'Gn4YYFpZUsOpDRVzXQcJ0fhLbUqv2T', 1711126111, 2147483647, 0, 0, '', 1710614656, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', 1710521241),
(7, 'LeGamer', '$2y$12$yCkKHpWCRQOHXSHO4mr3y.T9DCmGYsg6CP6Jpf6pc2g8sfVzTIzCu', 'User', 'None', 1711305799, 99999999, 'I\'m new to ROGGET!', '2008', 1, 0, '786635042142420993', 'QnmCim8rOcOsvLOE3KzBAUkWi8gkUj', 'uGKmUbvutStdkhZqGNaAIDH4OP4dWX', 1711141545, 2147483647, 0, 1, 'Trisomique', 1710791092, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', 1710536698),
(8, 'Powerm1nt', '$2y$12$zgOwO.ztbkoMXTsfthyauuH9rRT.y4WSO6QLwrz.w9UylsKrTOUvu', 'User', 'None', 1710537430, 99999999, 'I\'m new to ROGGET!', '2008', 1, 0, '967171856073392219', 'HtFgXRV4SKM5z0KlgxB2YvSwbPZEqu', '3aKKMyXJMxIPcO1BRC9wflyH5xZufK', 1711142055, 2147483647, 0, 0, '', 1710601393, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', '', 1710537229),
(9, 'LazyAdmin', '$2y$12$.sAKKiwP1aoaS5UpcDVdvOC0m73o1kgloIYWwVQdOjLH0PDxuB.7.', 'Administrator', 'None', 1711548487, 100000124, 'I\'m new to ROGGET!', '2011edited2016', 1, 1, '1134256002959671368', '8XftO0HR0GVyAlyTyKcQVXJVaKTaZD', 'iYY4MY0Or7oJkq34pv78MAbNld8hVb', 1711476884, 2147483647, 1711389223, 0, '', 1711382793, '{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}', '', 0, 'dark', 'ab129e5f626df9c373d9a738e49fad964f5148ba8daa5f80b8f3c8a7a1f56f5f387a0aa120d542b9b8bdf6943346a13218b0cc563929f970bc841a9ed13fdf2a024899ee7879c365466f1dbc027fe725f7829bec94ca31d1600867f0cb5cd9327b732a65', 1710537569),
(10, 'Lahza', '$2y$12$yLBLxDE3MGCWPboiMF8Jq.l8.UWuMjO3FrBP/lqnPuZUp2W0AOEpK', 'User', 'None', 1711571038, 99999804, 'I\'m new to ROGGET!', '2016', 1, 1, '1221172754586271834', 'c77T7DRYiPYuKTPCmjRs1VivY3g3Os', 'aGXMBQB1P199BhN9QpxhwInD0WKCQh', 1711825758, 1711220565, 1711571038, 0, '', 1711544079, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', 'e7980eddc88691014c64fd08a6bf4d4006ae460377ca60ec760d3c5846017edde815b38404d66c0b7981980fc6b4d58bbdb41a75d75d1d600aa146f82e689db6cfd1651f69ac6ab897a337063a9ea51c3d6a68c0a97d219843a8cc594ae8fbd47af5fbfd', 1711220565),
(11, 'DoggoITA', '$2y$12$qfMEJ8NSKJcSFoc.KMoRIu.r6A13.BGKB2iBALAXLe50UdWnRqVL6', 'User', 'None', 1711283059, 99999999, 'I\'m new to ROGGET!', '2016', 1, 1, '891372299515744306', 'vpFc3Tnf39qd2FuHMYWOYrLMqLj7cX', 'SkB288aomllG3ZbST3rVPr4WrEHJzq', 1711825385, 1711220574, 1711282293, 0, '', 1711221127, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', 1711220574),
(12, 'hadi', '$2y$12$XVp5NniVTEEJPjxLfHrKaO8Saip6i3C0cz0kuualMKhxlhxB2dSCy', 'User', 'None', 1711566434, 99999999, 'I\'m new to ROGGET!', '2011edited2016', 1, 1, '729738850410299453', 'qXw3071Gx0wKYUtQcfoH9MIBsWTUlR', 'wdDie9GsU2u0I0nMaGHWmO5tUAh8nU', 1711825466, 1711220592, 1711566067, 0, '', 1711229159, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', 'eb4b54fc85798eec206e674cf406867a54c6d9f4ec79d5a487cf33b6f8aee129440a981fa174ba2f7584708e27d0c6aff29a26b6b115cfbdb62f89eed188cb8e69492c9b4bbe1c779b8a9211f42d4cd23f2f0f51d129c635b2ad4711525a0a0fcbee5859', 1711220592),
(13, 'newuser', '$2y$12$4Qay0qeelPg.ndhNjXPNI.6gXfv/me0pnyER1Twe3FyHQMkwqG4OG', 'User', 'None', 1711566623, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '670690147716825118', 'sqx2Bz0ldOfIhkcVBeyEclOrRQVNmw', '4kQxY2ApauINcnFweeYpAVCLeTWdGF', 1711887902, 1711283055, 1711285400, 0, '', 1711283377, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', 1711283055),
(14, 'Lookbehindyou', '$2y$12$6yeZvB6kfOS1gXgFsFflmuPYNUSJf7W/P7XKnon9gPzeESTnSeT.S', 'User', 'None', 1711283703, 99999999, 'I\'m new to ROGGET!', '2008', 1, 1, '932317692789149776', '9LpFXj7AdHlAWxsIJCFo78lxZHGu3E', 'OGdZYuHzeG7kJ0Ovaiep1fuseQJu0p', 1711888367, 1711283450, 1711283568, 0, '', 0, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', 1711283450),
(15, 'mohamedfaitcaca', '$2y$12$cubYh4CrOOMFM/Iy8kqJC.X1lccp7H3EfT.zF2jt.3r6GWhg.8O3S', 'User', 'None', 1711388568, 99999969, 'I\'m new to ROGGET!', '2016', 1, 1, '1085584581530493039', '0FlTTYzHzJxkP9L05ohzKF25YIRR5v', 'd23UDPufrZgLen0cwnf3FmVi0OhH8H', 1711983450, 1711378556, 1711388564, 0, '', 1711378869, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '', 1711378556),
(16, 'Kelbaz', '$2y$12$rg69Fapteq73WbiAAJxJoON6mdEtQvK0rdVs5qWax/J.r3WASo.YG', 'User', 'None', 1711479847, 99999994, 'I\'m new to ROGGET!', '2016', 1, 1, '465943316538589194', 'GwWOTnfZzb9eLYmqi8NBOuIBbulKLe', 'u6zu3Pn0p0mSf9WIT8rTz9j2s2DdTI', 1711983530, 1711378690, 1711479838, 0, '', 1711393961, '\'{\"head\":24,\"torso\":23,\"leftarm\":24,\"rightarm\":24,\"leftleg\":119,\"rightleg\":119}\'', '', 0, 'dark', '94d5b36b66bd58e711df0beaacf557132348cad80f99a5c87d6d631f3651fb78738b0e33cfa763ece729827278e18cd4da9f88061e2da33e015df3ad20d14afe7b7fb2ec0e94f95fbb8826cda680e56e6b6da0b0ef9485c82faf61f83a0a76b9aa68eff4', 1711378690);

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
(18, 2, 3),
(19, 7, 3),
(20, 7, 1),
(21, 7, 2),
(22, 13, 1),
(27, 9, 4),
(28, 15, 4),
(29, 15, 3),
(35, 9, 3),
(36, 5, 2),
(37, 5, 1),
(40, 16, 3),
(56, 10, 2),
(59, 10, 3),
(60, 10, 1),
(61, 10, 4);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `invitekeys`
--
ALTER TABLE `invitekeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `owneditems`
--
ALTER TABLE `owneditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `renderqueue`
--
ALTER TABLE `renderqueue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `wearing`
--
ALTER TABLE `wearing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
