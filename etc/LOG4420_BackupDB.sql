-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 21 Septembre 2009 à 11:44
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `log4420a2009`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE IF NOT EXISTS `achats` (
  `id` int(11) NOT NULL auto_increment,
  `utilisateur` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `achats`
--


-- --------------------------------------------------------

--
-- Structure de la table `arenas`
--

CREATE TABLE IF NOT EXISTS `arenas` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `sieges` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `arenas`
--

INSERT INTO `arenas` (`id`, `nom`, `sieges`) VALUES
(1, 'Air Canada Centre', 85),
(2, 'Centre Bell', 120),
(3, 'Scotiabank Place', 180),
(4, 'Verizon Center', 40),
(5, 'HSBC Arena', 220),
(6, 'Madison Square Garden', 70);

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(50) NOT NULL,
  `arena` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` int(11) NOT NULL,
  `places` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `matchs`
--

INSERT INTO `matchs` (`id`, `description`, `arena`, `date`, `prix`, `places`) VALUES
(1, 'Canadiens de Montréal  vs New Jersey Devils', 1, '2009-12-07', 100, 85),
(2, 'Canadiens de Montréal vs New York Islanders', 3, '2009-12-08', 1850, 180),
(3, 'Canadiens de Montréal vs Pittsburgh Penguins', 5, '2009-12-09', 5, 220),
(4, 'Canadiens de Montréal vs Philadelphia Flyers', 3, '2009-12-10', 70, 180),
(5, 'Canadiens de Montréal vs New York Rangers', 2, '2009-12-11', 450, 120),
(6, 'Canadiens de Montréal vs New York Islanders', 4, '2009-12-12', 222, 40),
(7, 'Canadiens de Montréal vs New Jersey Devils', 6, '2009-12-13', 199, 70),
(8, 'Canadiens de Montréal vs New Jersey Devils', 6, '2009-12-14', 110, 70),
(9, 'Canadiens de Montréal vs Pittsburgh Penguins', 1, '2009-12-15', 514, 85),
(10, 'Canadiens de Montréal vs New York Rangers', 5, '2009-12-16', 300, 220);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL auto_increment,
  `utilisateur` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `expiration` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `reservations`
--


-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
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
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `role`, `utilisateur`, `motdepasse`, `prenom`, `nom`, `courriel`, `jour`, `mois`, `annee`, `sexe`, `theme`) VALUES
(1, 2, 'admin', 'admin', 'Yvon', 'Gagné', 'fireball33482738829@hotmail.com', 1, 1, 1901, 1, 'Standard');
