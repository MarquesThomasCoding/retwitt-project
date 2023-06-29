-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 29 juin 2023 à 12:48
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `retwitt`
--

-- --------------------------------------------------------

--
-- Structure de la table `saved`
--

CREATE TABLE `saved` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `twitt_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `saved`
--

INSERT INTO `saved` (`id`, `user_id`, `twitt_id`) VALUES
(10, 17, 111),
(11, 18, 114),
(14, 17, 114);

-- --------------------------------------------------------

--
-- Structure de la table `twitts`
--

CREATE TABLE `twitts` (
  `id` int NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `media` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tag` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `twitts`
--

INSERT INTO `twitts` (`id`, `content`, `media`, `tag`, `date`, `userid`) VALUES
(110, 'Vous aimez quel genre de musique ?', '', 'musique', '2023-06-11 19:42:31', 7),
(111, 'Trop beau les renards des neiges !', '', 'animaux', '2023-06-11 19:43:13', 8),
(114, 'Voici le schéma de la carte Raspberry Pi', '50858665218_87c17948df_o.jpg', 'innovation', '2023-06-26 11:57:58', 7);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `pseudo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `img` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `pseudo`, `nom`, `mail`, `mdp`, `img`) VALUES
(7, 'Vico', 'Victor', 'vico@mail.com', '$2y$10$SqcaeX.WoHNGDmQHOfRbyevu5pyNFNUN2a8x1aKTjcI8ZiGjQSAE.', ''),
(8, 'ThomLuck', 'Thomas', 'thomluck@gmail.com', '$2y$10$LFqBvbc.OI1R4eyfMgGcoeYqKILbCbYEPJaz53FKRzmuqJ1OQ8p1S', ''),
(17, 'ThomLeLuck', 'Tommy', 'thomleluck@retwitt.fr', '$2y$10$Q04yAi2LEhYyjqJI/i4BmeVumSWr41b7glJO4Py8Jame7hM/mQH4K', 'Logo.PNG'),
(18, 'Hope', 'Espe', 'hope@mail.com', '$2y$10$P3LaExlKAfvlM31OjLU1NuUm5jfQq2nMCaq.GPpoZigYqn.tiiqZq', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `saved`
--
ALTER TABLE `saved`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `twitts`
--
ALTER TABLE `twitts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `saved`
--
ALTER TABLE `saved`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `twitts`
--
ALTER TABLE `twitts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
