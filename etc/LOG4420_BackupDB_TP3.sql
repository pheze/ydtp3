-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 26 Octobre 2009 à 17:41
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `log4420a2009`
--

-- --------------------------------------------------------

--
-- Structure de la table `tp3_achats`
--

CREATE TABLE IF NOT EXISTS `tp3_achats` (
  `id` int(11) NOT NULL auto_increment,
  `utilisateur` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  `siege` int(11) NOT NULL,
  `rangee` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `achats`
--


-- --------------------------------------------------------

--
-- Structure de la table `tp3_arenas`
--

CREATE TABLE IF NOT EXISTS `tp3_arenas` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `largeur` int(11) NOT NULL,
  `profondeur` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `tp3_arenas`
--

INSERT INTO `tp3_arenas` (`id`, `nom`, `largeur`, `profondeur`) VALUES
(1, 'Air Canada Centre', 10, 12),
(2, 'Centre Bell', 11, 8),
(3, 'Scotiabank Place', 12, 12),
(4, 'Verizon Center', 6, 20),
(5, 'HSBC Arena', 8, 14),
(6, 'Madison Square Garden', 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tp3_matchs`
--

CREATE TABLE IF NOT EXISTS `tp3_matchs` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(50) NOT NULL,
  `arena` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `tp3_matchs`
--

INSERT INTO `tp3_matchs` (`id`, `description`, `arena`, `date`, `prix`) VALUES
(1, 'Canadiens de Montreal vs New Jersey Devils', 1, '2009-12-07', 100),
(2, 'Canadiens de Montreal vs New York Islanders', 3, '2009-12-08', 1850),
(3, 'Canadiens de Montreal vs Pittsburgh Penguins', 5, '2009-12-09', 5),
(4, 'Canadiens de Montreal vs Philadelphia Flyers', 3, '2009-12-10', 70),
(5, 'Canadiens de Montreal vs New York Rangers', 2, '2009-12-11', 450),
(6, 'Canadiens de Montreal vs New York Islanders', 4, '2009-12-12', 222),
(7, 'Canadiens de Montreal vs New Jersey Devils', 6, '2009-12-13', 199),
(8, 'Canadiens de Montreal vs New Jersey Devils', 6, '2009-12-14', 110),
(9, 'Canadiens de Montreal vs Pittsburgh Penguins', 1, '2009-12-15', 514),
(10, 'Canadiens de Montreal vs New York Rangers', 5, '2009-12-16', 300);

-- --------------------------------------------------------

--
-- Structure de la table `tp3_reservations`
--

CREATE TABLE IF NOT EXISTS `tp3_reservations` (
  `id` int(11) NOT NULL auto_increment,
  `utilisateur` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  `siege` int(11) NOT NULL,
  `rangee` int(11) NOT NULL,
  `expiration` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tp3_reservations`
--


-- --------------------------------------------------------

--
-- Structure de la table `tp3_utilisateurs`
--

CREATE TABLE IF NOT EXISTS `tp3_utilisateurs` (
  `id` int(11) NOT NULL auto_increment,
  `role` int(11) NOT NULL,
  `utilisateur` varchar(50) NOT NULL,
  `motdepasse` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `courriel` varchar(50) NOT NULL,
  `jour` int(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `sexe` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tp3_utilisateurs`
--

INSERT INTO `tp3_utilisateurs` (`id`, `role`, `utilisateur`, `motdepasse`, `prenom`, `nom`, `courriel`, `jour`, `mois`, `annee`, `sexe`, `theme`) VALUES
(1, 2, 'admin', 'admin', 'Yejamais', 'Troptard', 'luc-rozon.smith-cambell@caramail.fr', 1, 1, 1901, 1, 'Standard');