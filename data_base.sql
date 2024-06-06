-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 mai 2024 à 20:21
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
-- Base de données : `educomm`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `ID_administrateur` int(11) NOT NULL,
  `cin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`ID_administrateur`, `cin`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `ID_annonce` int(11) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `Type_utilisateur` varchar(50) NOT NULL,
  `Type_annonce` varchar(100) NOT NULL,
  `Contenu` text NOT NULL,
  `Titre` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `ID_filiere` int(11) NOT NULL,
  `ID_niveau` int(11) NOT NULL,
  `Statut` varchar(50) NOT NULL,
  `ID_local` int(11) DEFAULT NULL,
  `Date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chef_filiere`
--

CREATE TABLE `chef_filiere` (
  `ID_chef_filiere` int(11) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `ID_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `ID_enseignant` int(11) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `ID_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `ID_etudiant` int(11) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `ID_filiere` int(11) NOT NULL,
  `ID_niveau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `ID_filiere` int(11) NOT NULL,
  `Nom_filiere` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`ID_filiere`, `Nom_filiere`) VALUES
(1, 'Génie informatique'),
(2, 'Bâtiment et travaux publics'),
(3, 'Finance et Ingénierie décisionnelle'),
(4, 'Génie énergétique et environnement'),
(5, 'Génie mécanique'),
(6, 'Génie électrique'),
(7, 'Génie industriel');

-- --------------------------------------------------------

--
-- Structure de la table `local`
--

CREATE TABLE `local` (
  `ID_local` int(11) NOT NULL,
  `Nom_local` varchar(100) NOT NULL,
  `Type_local` varchar(50) NOT NULL,
  `Capacite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `local`
--

INSERT INTO `local` (`ID_local`, `Nom_local`, `Type_local`, `Capacite`) VALUES
(1, 'Amphi 1', 'Amphi', 500),
(2, 'Amphi 2', 'Amphi ', 500),
(3, 'Amphi 3', 'Amphi', 500),
(11, 'Salle 1', 'Salle', 60),
(12, 'Salle 2', 'Salle', 70),
(13, 'Salle 3', 'Salle', 80);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `ID_niveau` int(11) NOT NULL,
  `Libelle_niveau` varchar(100) NOT NULL,
  `ID_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`ID_niveau`, `Libelle_niveau`, `ID_filiere`) VALUES
(1, 'Génie informatique 1', 1),
(2, 'Génie informatique 2', 1),
(3, 'Génie informatique 3', 1),
(4, 'Finance et Ingénierie décisionnelle 1', 3),
(5, 'Finance et Ingénierie décisionnelle 2', 3),
(6, 'Finance et Ingénierie décisionnelle 3', 3),
(7, 'Génie énergétique et environnement 1', 4),
(8, 'Génie énergétique et environnement 2', 4),
(9, 'Génie énergétique et environnement 3', 4),
(10, 'Génie mécanique 1', 5),
(11, 'Génie mécanique 2', 5),
(12, 'Génie mécanique 3', 5),
(13, 'Génie électrique 1', 6),
(14, 'Génie électrique 2', 6),
(15, 'Génie électrique 3', 6),
(16, 'Génie industriel 1', 7),
(17, 'Génie industriel 2', 7),
(18, 'Génie industriel 3', 7),
(19, 'Bâtiment et travaux publics 1', 2),
(20, 'Bâtiment et travaux publics 2', 2),
(21, 'Bâtiment et travaux publics 3', 2);

-- --------------------------------------------------------

--
-- Structure de la table `secretaire_departement`
--

CREATE TABLE `secretaire_departement` (
  `ID_secretaire` int(11) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `ID_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `cin` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL,
  `type_utilisateur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`cin`, `nom`, `prenom`, `email`, `mot_de_passe`, `type_utilisateur`) VALUES
('admin', 'admin', 'admin', 'admin@gmail.com', '$2y$10$e96s7JwuCpxLN8/Yxj3EtuIUjRPf4fDq2OW4/YNxEbGLstxqu6/Zy', 'administrateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`ID_administrateur`),
  ADD KEY `cin` (`cin`);

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`ID_annonce`),
  ADD KEY `annonce_ibfk_1` (`cin`),
  ADD KEY `annonce_ibfk_2` (`ID_filiere`),
  ADD KEY `annonce_ibfk_3` (`ID_local`),
  ADD KEY `annonce_ibfk_4` (`ID_niveau`);

--
-- Index pour la table `chef_filiere`
--
ALTER TABLE `chef_filiere`
  ADD PRIMARY KEY (`ID_chef_filiere`),
  ADD KEY `cin` (`cin`),
  ADD KEY `ID_filiere` (`ID_filiere`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`ID_enseignant`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`ID_etudiant`),
  ADD KEY `cin` (`cin`),
  ADD KEY `ID_filiere` (`ID_filiere`),
  ADD KEY `ID_niveau` (`ID_niveau`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`ID_filiere`);

--
-- Index pour la table `local`
--
ALTER TABLE `local`
  ADD PRIMARY KEY (`ID_local`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`ID_niveau`),
  ADD KEY `ID_filiere` (`ID_filiere`);

--
-- Index pour la table `secretaire_departement`
--
ALTER TABLE `secretaire_departement`
  ADD PRIMARY KEY (`ID_secretaire`),
  ADD KEY `cin` (`cin`),
  ADD KEY `ID_filiere` (`ID_filiere`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`cin`),
  ADD UNIQUE KEY `cin` (`cin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `ID_administrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `ID_annonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `chef_filiere`
--
ALTER TABLE `chef_filiere`
  MODIFY `ID_chef_filiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `ID_enseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `ID_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `ID_filiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `local`
--
ALTER TABLE `local`
  MODIFY `ID_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `ID_niveau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `secretaire_departement`
--
ALTER TABLE `secretaire_departement`
  MODIFY `ID_secretaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `administrateur_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `utilisateur` (`cin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `utilisateur` (`cin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`ID_filiere`) REFERENCES `filiere` (`ID_filiere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`ID_local`) REFERENCES `local` (`ID_local`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_4` FOREIGN KEY (`ID_niveau`) REFERENCES `niveau` (`ID_niveau`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `chef_filiere`
--
ALTER TABLE `chef_filiere`
  ADD CONSTRAINT `chef_filiere_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `utilisateur` (`cin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chef_filiere_ibfk_2` FOREIGN KEY (`ID_filiere`) REFERENCES `filiere` (`ID_filiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `utilisateur` (`cin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`ID_filiere`) REFERENCES `filiere` (`ID_filiere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_3` FOREIGN KEY (`ID_niveau`) REFERENCES `niveau` (`ID_niveau`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD CONSTRAINT `niveau_ibfk_1` FOREIGN KEY (`ID_filiere`) REFERENCES `filiere` (`ID_filiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `secretaire_departement`
--
ALTER TABLE `secretaire_departement`
  ADD CONSTRAINT `secretaire_departement_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `utilisateur` (`cin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `secretaire_departement_ibfk_2` FOREIGN KEY (`ID_filiere`) REFERENCES `filiere` (`ID_filiere`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
