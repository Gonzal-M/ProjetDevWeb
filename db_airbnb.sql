-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 14 juin 2020 à 18:12
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_airbnb`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(5) NOT NULL,
  `id_compte` int(5) DEFAULT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `descript` text DEFAULT NULL,
  `nb_places` varchar(2) DEFAULT NULL,
  `numerorue` int(2) DEFAULT NULL,
  `nomrue` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codepostal` int(5) DEFAULT NULL,
  `prix` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `id_compte`, `titre`, `descript`, `nb_places`, `numerorue`, `nomrue`, `ville`, `codepostal`, `prix`) VALUES
(23, 20, 'Paris Ynov Campus', 'Votre Ynov Campus de Paris fait peau neuve dans un b&acirc;timent construit sur mesure. Votre Ynov Campus a &eacute;t&eacute; con&ccedil;u pour vous offrir un cadre de vie exceptionnel, garantissant de remarquables conditions d&rsquo;&eacute;tudes. Venez &eacute;tudier l&#039;informatique chez nous !', '18', 12, 'Rue Anatole France', 'Nanterre', 92000, '60'),
(26, 20, 'Louvre', 'Vous vous appr&ecirc;tez &agrave; visiter le plus grand mus&eacute;e du monde, fr&eacute;quent&eacute; chaque ann&eacute;e par pr&egrave;s de 10 millions de visiteurs, dont la mission principale est d&rsquo;assurer la conservation, l&rsquo;&eacute;ducation et la transmission d&rsquo;un patrimoine aux g&eacute;n&eacute;rations futures.', '10', 1, 'Rue de Rivoli', 'Paris', 75001, '17'),
(28, 20, 'Palais des Festivals', 'Le palais des festivals et des congr&egrave;s de Cannes est un ensemble de b&acirc;timents inaugur&eacute; en 1982 puis r&eacute;nov&eacute; entre 2013 et 2015 qui accueille le Festival de Cannes, un festival de cin&eacute;ma international se d&eacute;roulant chaque ann&eacute;e en mai &agrave; Cannes durant douze jours.', '2', 1, 'Boulevard de la Croisette', 'Cannes', 6400, '50');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(5) NOT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL,
  `nomphoto` text DEFAULT NULL,
  `solde` int(5) DEFAULT NULL,
  `presentation` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `prenom`, `nom`, `email`, `tel`, `mdp`, `nomphoto`, `solde`, `presentation`) VALUES
(20, 'Annonces', 'Test', 'annonces.test@gmail.com', '01 23 45 67 89', 'test', 'female-place-holder-profile-image.jpg', 2242, 'Compte de test responsable de la cr&eacute;ation d&#039;annonces ~ '),
(21, 'Client', 'Test', 'client.test@gmail.com', '01 23 45 67 89', 'test', 'person-gray-photo-placeholder-man-vector-22808082.jpg', 98757, 'Compte de test responsable de la location de biens');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(5) NOT NULL,
  `id_annonce` int(5) DEFAULT NULL,
  `nomphoto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id_photo`, `id_annonce`, `nomphoto`) VALUES
(40, 23, 'ynov1.jpg'),
(41, 23, 'ynov2.jpg'),
(42, 23, 'ynov3.jpg'),
(49, 26, 'Louvre1.jpg'),
(50, 26, 'Louvre2.jpg'),
(51, 26, 'Louvre3.jpg'),
(55, 28, 'cannes1.jpg'),
(56, 28, 'cannes2.jpg'),
(57, 28, 'cannes3.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(5) NOT NULL,
  `id_annonce` int(5) DEFAULT NULL,
  `date_arrive` date DEFAULT NULL,
  `date_depart` date DEFAULT NULL,
  `id_client` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_annonce`, `date_arrive`, `date_depart`, `id_client`) VALUES
(2, 26, '2020-06-21', '2020-06-27', 21),
(3, 28, '2020-06-28', '2020-07-04', 21),
(5, 23, '2020-06-14', '2020-06-20', 21);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `id_compte` (`id_compte`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_annonce` (`id_annonce`),
  ADD KEY `id_client` (`id_client`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`);

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `compte` (`id_compte`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
