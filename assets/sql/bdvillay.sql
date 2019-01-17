-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 09 Février 2018 à 16:59
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdvillay`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter` (
  `idProf` int(11) NOT NULL,
  `idBts` int(11) NOT NULL,
  `idEpreuve` int(11) NOT NULL,
  `heureDebut` varchar(250) NOT NULL,
  `etat` varchar(5) DEFAULT NULL,
  `idSalle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `affecter`
--

INSERT INTO `affecter` (`idProf`, `idBts`, `idEpreuve`, `heureDebut`, `etat`, `idSalle`) VALUES
(1, 1, 1, '2', '1', 2),
(2, 1, 1, '1', '1', 2);

-- --------------------------------------------------------

--
-- Structure de la table `bts`
--

CREATE TABLE `bts` (
  `idBts` int(11) NOT NULL,
  `codeBts` varchar(10) NOT NULL,
  `libelleBts` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bts`
--

INSERT INTO `bts` (`idBts`, `codeBts`, `libelleBts`) VALUES
(1, 'sio2', 'Systefuiozefoze io2'),
(2, 'com2', 'desmadames'),
(3, 'sio1', 'Systefuiozefoze io1'),
(4, 'com1', 'desmadames1');

-- --------------------------------------------------------

--
-- Structure de la table `comporter`
--

CREATE TABLE `comporter` (
  `dateEpreuve` date DEFAULT NULL,
  `heureDebut` time DEFAULT NULL,
  `duree` int(11) NOT NULL,
  `idBts` int(11) NOT NULL,
  `idEpreuve` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comporter`
--

INSERT INTO `comporter` (`dateEpreuve`, `heureDebut`, `duree`, `idBts`, `idEpreuve`) VALUES
('2000-01-01', '08:00:00', 4, 1, 1),
(NULL, NULL, 1, 1, 2),
(NULL, NULL, 3, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `enseigner`
--

CREATE TABLE `enseigner` (
  `idProf` int(11) NOT NULL,
  `idBts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `enseigner`
--

INSERT INTO `enseigner` (`idProf`, `idBts`) VALUES
(1, 1),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `epreuve`
--

CREATE TABLE `epreuve` (
  `idEpreuve` int(11) NOT NULL,
  `codeEpreuve` varchar(10) NOT NULL,
  `libelleEpreuve` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `epreuve`
--

INSERT INTO `epreuve` (`idEpreuve`, `codeEpreuve`, `libelleEpreuve`) VALUES
(1, 'FR', 'français'),
(2, 'Maths', 'mathematiques');

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE `occuper` (
  `idBts` int(11) NOT NULL,
  `idEpreuve` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `occuper`
--

INSERT INTO `occuper` (`idBts`, `idEpreuve`, `idSalle`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `prof`
--

CREATE TABLE `prof` (
  `idProf` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `nbConvoc` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prof`
--

INSERT INTO `prof` (`idProf`, `nom`, `prenom`, `nbConvoc`) VALUES
(1, 'Lajoie', 'Benjamin', 0),
(2, 'Ayrault', 'Frédérique', 0);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `idSalle` int(11) NOT NULL,
  `numSalle` varchar(4) NOT NULL,
  `capacite` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`idSalle`, `numSalle`, `capacite`) VALUES
(1, 'A31', 31),
(2, 'A34', 26);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD PRIMARY KEY (`idProf`,`idBts`,`idEpreuve`,`heureDebut`),
  ADD KEY `FK_affecter_idBts_idEpreuve` (`idBts`,`idEpreuve`),
  ADD KEY `FK_affecter_idSalle` (`idSalle`);

--
-- Index pour la table `bts`
--
ALTER TABLE `bts`
  ADD PRIMARY KEY (`idBts`);

--
-- Index pour la table `comporter`
--
ALTER TABLE `comporter`
  ADD PRIMARY KEY (`idBts`,`idEpreuve`),
  ADD KEY `FK_comporter_idEpreuve` (`idEpreuve`);

--
-- Index pour la table `enseigner`
--
ALTER TABLE `enseigner`
  ADD PRIMARY KEY (`idProf`,`idBts`),
  ADD KEY `FK_enseigner_idBts` (`idBts`);

--
-- Index pour la table `epreuve`
--
ALTER TABLE `epreuve`
  ADD PRIMARY KEY (`idEpreuve`);

--
-- Index pour la table `occuper`
--
ALTER TABLE `occuper`
  ADD PRIMARY KEY (`idBts`,`idEpreuve`,`idSalle`),
  ADD KEY `FK_occuper_idSalle` (`idSalle`);

--
-- Index pour la table `prof`
--
ALTER TABLE `prof`
  ADD PRIMARY KEY (`idProf`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`idSalle`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `bts`
--
ALTER TABLE `bts`
  MODIFY `idBts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `epreuve`
--
ALTER TABLE `epreuve`
  MODIFY `idEpreuve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `prof`
--
ALTER TABLE `prof`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `idSalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_affecter_idBts_idEpreuve` FOREIGN KEY (`idBts`,`idEpreuve`) REFERENCES `comporter` (`idBts`, `idEpreuve`),
  ADD CONSTRAINT `FK_affecter_idProf` FOREIGN KEY (`idProf`) REFERENCES `prof` (`idProf`),
  ADD CONSTRAINT `FK_affecter_idSalle` FOREIGN KEY (`idSalle`) REFERENCES `salle` (`idSalle`);

--
-- Contraintes pour la table `comporter`
--
ALTER TABLE `comporter`
  ADD CONSTRAINT `FK_comporter_idBts` FOREIGN KEY (`idBts`) REFERENCES `bts` (`idBts`),
  ADD CONSTRAINT `FK_comporter_idEpreuve` FOREIGN KEY (`idEpreuve`) REFERENCES `epreuve` (`idEpreuve`);

--
-- Contraintes pour la table `enseigner`
--
ALTER TABLE `enseigner`
  ADD CONSTRAINT `FK_enseigner_idBts` FOREIGN KEY (`idBts`) REFERENCES `bts` (`idBts`),
  ADD CONSTRAINT `FK_enseigner_idProf` FOREIGN KEY (`idProf`) REFERENCES `prof` (`idProf`);

--
-- Contraintes pour la table `occuper`
--
ALTER TABLE `occuper`
  ADD CONSTRAINT `FK_occuper_idBts_idEpreuve` FOREIGN KEY (`idBts`,`idEpreuve`) REFERENCES `comporter` (`idBts`, `idEpreuve`),
  ADD CONSTRAINT `FK_occuper_idSalle` FOREIGN KEY (`idSalle`) REFERENCES `salle` (`idSalle`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
