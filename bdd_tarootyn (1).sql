-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 21 nov. 2022 à 21:36
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_tarootyn`
--

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id_group` int(11) NOT NULL,
  `name_group` text DEFAULT NULL,
  `last_score` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `previous_score` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`id_group`, `name_group`, `last_score`, `description`, `previous_score`) VALUES
(54, 'les bg', 0, 'ok', 0),
(57, 'team', 0, 'team', 0),
(62, 'boss', 0, 'boss', 0),
(63, 'courageux', 4, 'courageux', 0),
(70, 'ynov', 6, 'ynov', 0),
(71, 'mentalistes', 0, 'mentalistes', 0),
(72, 'ynoviens', 47, 'Nous sommes des étudiants de ynov très motivés à réussir ce projet merveilleux, vive TAROOTYN !', 0);

-- --------------------------------------------------------

--
-- Structure de la table `invit`
--

CREATE TABLE `invit` (
  `id_invit` int(11) NOT NULL,
  `id_group_invit` int(11) NOT NULL,
  `id_user_invited` int(11) NOT NULL,
  `host_pseudo` text NOT NULL,
  `name_group` text NOT NULL,
  `invited` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `invit`
--

INSERT INTO `invit` (`id_invit`, `id_group_invit`, `id_user_invited`, `host_pseudo`, `name_group`, `invited`) VALUES
(20, 54, 3, 'victor', 'les bg', 'melaine'),
(39, 71, 19, 'natalie', 'mentalistes', 'jeremie'),
(40, 71, 9, 'natalie', 'mentalistes', 'jean');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id_task` int(11) NOT NULL,
  `isvalid` tinyint(1) NOT NULL,
  `name_task` text NOT NULL,
  `category` text NOT NULL,
  `difficulty` text NOT NULL,
  `isdaily` tinyint(1) NOT NULL,
  `chosen_day` text DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `last_valid_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id_task`, `isvalid`, `name_task`, `category`, `difficulty`, `isdaily`, `chosen_day`, `id_user`, `last_valid_date`) VALUES
(5, 0, 'manger', 'alimentation', '3', 0, 'Mardi', 3, NULL),
(23, 0, 'Trier mes mails', 'travail', '2', 0, NULL, 19, '2022-11-21'),
(24, 0, 'randonner', 'sport', '4', 0, 'Mercredi', 20, '2022-11-21'),
(28, 1, 'Trier mes mails', 'travail', '2', 1, NULL, 16, '2022-11-21'),
(29, 0, 'Déclarer ta flamme à Jésus', 'important', '5', 0, 'Lundi', 16, '2022-11-21'),
(31, 0, 'manger un plat sain', 'alimentation', '2', 0, 'Mardi', 16, '2022-11-21'),
(32, 0, 'discuter', 'social', '1', 0, NULL, 16, '2022-11-21'),
(33, 0, 'Promener Felix', 'loisir', '4', 0, NULL, 16, '2022-11-21'),
(34, 0, 'Faire 100 squats', 'sport', '5', 0, 'Mardi', 16, '2022-11-21');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_group` int(11) DEFAULT NULL,
  `pseudo` text NOT NULL,
  `email` text NOT NULL,
  `pwd` text NOT NULL,
  `last_task_creation` date DEFAULT NULL,
  `last_connexion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `id_group`, `pseudo`, `email`, `pwd`, `last_task_creation`, `last_connexion`) VALUES
(3, NULL, 'melaine', 'meldd@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2022-11-13', NULL),
(9, NULL, 'jean', 'mon@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2022-11-15', NULL),
(10, 54, 'victor', 'victor@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL),
(11, NULL, 'marie', 'marie52@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL),
(12, 71, 'natalie', 'natalie72@gmail.com', 'd9a14eac7d1f34fcf8e2a10a7770c63ab532e69f', '2022-11-21', '2022-11-21'),
(14, 57, 'violette', 'violette85@gmail.com', '60740796027422fbca411daea8c9a522c416ef57', NULL, '2022-11-20'),
(15, 72, 'lili', 'lilirose@gmail.com', 'b419e450efc447f700707dd63cfce1b5687f5e6d', NULL, '2022-11-21'),
(16, 72, 'lea', 'lea.catlover@gmail.com', '55f63a97aee05dec574284677eb868c83b3fba7c', '2022-11-21', '2022-11-21'),
(19, 62, 'jeremie', 'jerem@hotmail.com', 'aa5d8c8bb73d4465608582ffc8dcd3cb76639f53', '2022-11-20', '2022-11-21'),
(20, 63, 'lina', 'lina@hotmail.com', '1ceea5aafbb637c63f1f2ffd35ea6919cbc8da14', '2022-11-20', '2022-11-21');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id_group`);

--
-- Index pour la table `invit`
--
ALTER TABLE `invit`
  ADD PRIMARY KEY (`id_invit`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `FK_taskusers` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `FK_groupusers` (`id_group`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `invit`
--
ALTER TABLE `invit`
  MODIFY `id_invit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_taskusers` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_groupusers` FOREIGN KEY (`id_group`) REFERENCES `groupes` (`id_group`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
