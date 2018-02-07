-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 02 Juin 2015 à 19:34
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bibliotheque_universitaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `archive`
--

CREATE TABLE IF NOT EXISTS `archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_auteur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identite_lecteur` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE IF NOT EXISTS `auteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `cycle`
--

CREATE TABLE IF NOT EXISTS `cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_livres` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `cycle`
--

INSERT INTO `cycle` (`id`, `libelle`, `nombre_livres`, `duree`) VALUES
(1, 'Cycle 1', 5, 15),
(2, 'Cycle 2', 10, 15),
(3, 'Cycle 3', 999999999, 999999999);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE IF NOT EXISTS `emprunt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecteur_emprunteur_id` int(11) DEFAULT NULL,
  `date_debut` date NOT NULL,
  `exemplaire_emprunte_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F9FD484B20EDBCFB` (`exemplaire_emprunte_id`),
  KEY `IDX_F9FD484B197358D8` (`lecteur_emprunteur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Structure de la table `exemplaire`
--

CREATE TABLE IF NOT EXISTS `exemplaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livres_dupliques_id` int(11) DEFAULT NULL,
  `cote` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_11A53F429BBDBAC4` (`livres_dupliques_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- Structure de la table `faculte`
--

CREATE TABLE IF NOT EXISTS `faculte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code_postal` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `lecteur`
--

CREATE TABLE IF NOT EXISTS `lecteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculte_choisie_id` int(11) DEFAULT NULL,
  `cycle_choisi_id` int(11) DEFAULT NULL,
  `nom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DE6EF0A49E8D16C5` (`faculte_choisie_id`),
  KEY `IDX_DE6EF0A462ED4A9B` (`cycle_choisi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE IF NOT EXISTS `livre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notice` longtext COLLATE utf8_unicode_ci NOT NULL,
  `nombre_exemplaires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Contenu de la table `livre`
--

-- --------------------------------------------------------

--
-- Structure de la table `livre_auteur`
--

CREATE TABLE IF NOT EXISTS `livre_auteur` (
  `livre_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  PRIMARY KEY (`livre_id`,`auteur_id`),
  KEY `IDX_A11876B537D925CB` (`livre_id`),
  KEY `IDX_A11876B560BB6FE6` (`auteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livre_theme`
--

CREATE TABLE IF NOT EXISTS `livre_theme` (
  `livre_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`livre_id`,`theme_id`),
  KEY `IDX_4767F6E37D925CB` (`livre_id`),
  KEY `IDX_4767F6E59027487` (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecteurs_reservant_id` int(11) DEFAULT NULL,
  `livre_reserve_id` int(11) DEFAULT NULL,
  `date_reservation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C454C68234AA877B` (`lecteurs_reservant_id`),
  KEY `IDX_C454C6826FBF8299` (`livre_reserve_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'ROLE_USER'),
(2, 'ROLE_ADMIN'),
(3, 'ROLE_LECTEUR'),
(4, 'ROLE_CONSERVATEUR'),
(5, 'ROLE_PRET'),
(6, 'ROLE_INSCRIPTION');

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lecteur_associe_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA179772CC9128F` (`lecteur_associe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `lecteur_associe_id`) VALUES
(1, 'clossetb', 'Welcome1', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `FK_F9FD484B197358D8` FOREIGN KEY (`lecteur_emprunteur_id`) REFERENCES `lecteur` (`id`),
  ADD CONSTRAINT `FK_F9FD484B20EDBCFB` FOREIGN KEY (`exemplaire_emprunte_id`) REFERENCES `exemplaire` (`id`);

--
-- Contraintes pour la table `exemplaire`
--
ALTER TABLE `exemplaire`
  ADD CONSTRAINT `FK_11A53F429BBDBAC4` FOREIGN KEY (`livres_dupliques_id`) REFERENCES `livre` (`id`);

--
-- Contraintes pour la table `lecteur`
--
ALTER TABLE `lecteur`
  ADD CONSTRAINT `FK_DE6EF0A462ED4A9B` FOREIGN KEY (`cycle_choisi_id`) REFERENCES `cycle` (`id`),
  ADD CONSTRAINT `FK_DE6EF0A49E8D16C5` FOREIGN KEY (`faculte_choisie_id`) REFERENCES `faculte` (`id`);

--
-- Contraintes pour la table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD CONSTRAINT `FK_A11876B537D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A11876B560BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livre_theme`
--
ALTER TABLE `livre_theme`
  ADD CONSTRAINT `FK_4767F6E37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4767F6E59027487` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_C454C68234AA877B` FOREIGN KEY (`lecteurs_reservant_id`) REFERENCES `lecteur` (`id`),
  ADD CONSTRAINT `FK_C454C6826FBF8299` FOREIGN KEY (`livre_reserve_id`) REFERENCES `livre` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_2DA179772CC9128F` FOREIGN KEY (`lecteur_associe_id`) REFERENCES `lecteur` (`id`);

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
