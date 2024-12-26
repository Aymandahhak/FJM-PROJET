-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 25 déc. 2024 à 21:04
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetg`
--

-- --------------------------------------------------------

--
-- Structure de la table `achievement`
--
-- Step 1: Create the 'projetg' database (if it doesn't exist)
CREATE DATABASE IF NOT EXISTS `projetg` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Step 2: Use the 'projetg' database
USE `projetg`;


DROP TABLE IF EXISTS `achievement`;

CREATE TABLE `achievement` (
  `achievement_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `achievement_date` date DEFAULT NULL,
  `achievement_image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT 'bi-award'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `achievement`
--

INSERT INTO `achievement` (`achievement_id`, `player_id`, `title`, `description`, `achievement_date`, `achievement_image`, `icon`) VALUES
(1, 1, 'Champion Régional', 'Victoire avec l’équipe U15', '2023-06-15', 'champion.jpg', 'bi-award'),
(2, 2, 'Meilleur Milieu', 'Distinction lors du tournoi national', '2023-12-10', 'best_player.jpg', 'bi-award'),
(3, 3, 'Défenseur de l’Année', 'Performance exceptionnelle en 2024', '2024-10-20', 'defender.jpg', 'bi-award'),
(4, 4, 'Gant d’Or', 'Meilleur gardien du tournoi régional', '2024-07-12', 'golden_glove.jpg', 'bi-award'),
(5, 5, 'Meilleur Buteur', '15 buts en une saison', '2024-08-30', 'top_scorer.jpg', 'bi-award');

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(200) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `email`, `password`, `created_at`, `image`, `role`) VALUES
(1, 'Ahmed El Mansouri', 'admin@domain.com', 'admin123', '2024-12-23 18:40:25', 'uploads/admins/admin1.jpg', 'admin'),
(2, 'Fatima Zahra', 'moderator@domain.com', 'mod123', '2024-12-23 18:40:25', 'uploads/admins/admin2.jpg', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `carrieres`
--

CREATE TABLE `carrieres` (
  `id_carreire` int(11) NOT NULL,
  `id_entraineur` int(11) NOT NULL,
  `club` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `carrieres`
--

INSERT INTO `carrieres` (`id_carreire`, `id_entraineur`, `club`, `description`) VALUES
(1, 1, 'Wydad Casablanca', 'Entraîneur principal depuis 5 ans.'),
(2, 2, 'FUS Rabat', 'Assistant entraîneur avec spécialisation en stratégie.'),
(3, 3, 'KAC Marrakech', 'Entraîneur de fitness et condition physique.');

-- --------------------------------------------------------

--
-- Structure de la table `contacts_player`
--

CREATE TABLE `contacts_player` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `heure` varchar(100) DEFAULT NULL,
  `courLundi` varchar(100) DEFAULT NULL,
  `courMardi` varchar(100) DEFAULT NULL,
  `courMercredi` varchar(100) DEFAULT NULL,
  `courJeudi` varchar(100) DEFAULT NULL,
  `courVendredi` varchar(100) DEFAULT NULL,
  `courSamedi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE `diplomes` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `annee` int(11) DEFAULT NULL,
  `entraineur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `diplomes`
--

INSERT INTO `diplomes` (`id`, `titre`, `annee`, `entraineur_id`) VALUES
(1, 'Licence UEFA', 2020, 1),
(2, 'Diplôme en Coaching', 2019, 2),
(3, 'Certificat Fitness', 2021, 3),
(4, 'master', 2022, 1);

-- --------------------------------------------------------

--
-- Structure de la table `emails`
--

CREATE TABLE `emails` (
  `email_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `emails`
--

INSERT INTO `emails` (`email_id`, `user_id`, `sender_name`, `email_subject`, `email_time`) VALUES
(1, 1, 'Admin Team', 'Welcome to the system', '2024-12-23 08:00:00'),
(2, 2, 'Support', 'Password Reset', '2024-12-23 09:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

CREATE TABLE `entraineur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `nationalite` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `entraineur`
--

INSERT INTO `entraineur` (`id`, `nom`, `age`, `nationalite`, `email`, `password`, `photo`, `poste`, `role`) VALUES
(1, 'Mohamed Bensalah', 40, 'Maroc', 'mohamed.bensalah@example.com', 'password123', 'coach1.jpg', 'Head Coach', 'entraineur'),
(2, 'Hassan El Khayat', 35, 'Maroc', 'hassan.elkhayat@example.com', 'password123', 'coach2.jpg', 'Assistant Coach', 'entraineur'),
(3, 'Youssef Amrani', 38, 'Maroc', 'youssef.amrani@example.com', 'password123', 'coach3.jpg', 'Fitness Coach', 'entraineur');

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` enum('active','blessee','repos') DEFAULT 'active',
  `physical_condition` int(11) DEFAULT 100,
  `performance` int(11) DEFAULT 100,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_entraineur` int(11) DEFAULT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `hometown` varchar(255) NOT NULL,
  `dream` varchar(255) NOT NULL,
  `achievements` text DEFAULT NULL,
  `medical_status` text DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `nom`, `age`, `position`, `status`, `physical_condition`, `performance`, `created_at`, `updated_at`, `id_entraineur`, `height`, `weight`, `hometown`, `dream`, `achievements`, `medical_status`, `email`, `password`, `image_path`, `role`) VALUES
(1, 'Ali El Fassi', 15, 'Attaquant', 'active', 95, 90, '2024-12-23 18:36:47', '2024-12-23 18:45:25', 1, 1.7, 60, 'Casablanca', 'Jouer pour le Wydad', 'Champion régional', 'Healthy', 'ali.fassi@example.com', 'password123', 'ali.jpg', 'joueur'),
(2, 'Omar Benjelloun', 16, 'Milieu', 'active', 90, 85, '2024-12-23 18:36:47', '2024-12-23 18:45:25', 2, 1.75, 65, 'Rabat', 'Devenir pro', 'Meilleur joueur 2023', 'Healthy', 'omar.benjelloun@example.com', 'password123', 'omar.jpg', 'joueur'),
(3, 'Rachid El Idrissi', 14, 'Défenseur', 'active', 85, 80, '2024-12-23 18:36:47', '2024-12-23 18:45:25', 1, 1.8, 70, 'Fès', 'Représenter l’équipe nationale', 'Deux fois champion junior', 'Healthy', 'rachid.elidrissi@example.com', 'password123', 'rachid.jpg', 'joueur'),
(4, 'Karim Ait Bihi', 17, 'Gardien', 'active', 88, 82, '2024-12-23 18:36:47', '2024-12-23 18:45:25', 3, 1.85, 75, 'Marrakech', 'Jouer en Europe', NULL, 'Healthy', 'karim.aitbihi@example.com', 'password123', 'karim.jpg', 'joueur'),
(5, 'Yassir Ouazzani', 18, 'Attaquant', 'active', 92, 87, '2024-12-23 18:36:47', '2024-12-23 18:44:38', 2, 1.78, 68, 'Tanger', 'Gagner la CAN', NULL, 'Healthy', 'yassir.ouazzani@example.com', 'password123', 'yassir.jpg', 'joueur');

-- --------------------------------------------------------

--
-- Structure de la table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `match_date` date DEFAULT NULL,
  `opponent` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `match_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matches`
--

INSERT INTO `matches` (`id`, `match_date`, `opponent`, `location`, `match_type`, `created_at`) VALUES
(1, '2025-11-12', NULL, NULL, NULL, '2024-11-23 17:52:01'),
(2, '2024-12-17', NULL, NULL, NULL, '2024-11-23 17:52:01'),
(3, '2024-12-25', 'Manchester United', 'Old Trafford', 'Friendly', '2024-12-23 09:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `medical_status`
--

CREATE TABLE `medical_status` (
  `medical_status_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `conditionP` varchar(255) NOT NULL,
  `injury_history` text DEFAULT NULL,
  `fitness_level` varchar(50) DEFAULT NULL,
  `last_checkup_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `cleared_to_play` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `medical_status`
--

INSERT INTO `medical_status` (`medical_status_id`, `player_id`, `conditionP`, `injury_history`, `fitness_level`, `last_checkup_date`, `notes`, `cleared_to_play`) VALUES
(4, 1, 'Healthy', 'Minor knee sprain in 2023', 'Excellent', '2024-12-15', 'Player is cleared for the upcoming season.', 1),
(5, 21, 'Healthy', 'None', 'Excellent', '2024-12-22', 'Ready for next match.', 1),
(1, 1, 'Healthy', 'Sprained ankle - 2023', 'Excellent', '2024-12-20', 'Player fully recovered and fit to play.', 1),
(2, 2, 'Healthy', 'None', 'Excellent', '2024-12-18', 'No medical issues.', 1),
(3, 3, 'Healthy', 'Minor muscle strain - 2024', 'Good', '2024-12-19', 'Player advised to monitor recovery.', 1),
(4, 4, 'Healthy', 'Fractured finger - 2022', 'Good', '2024-12-20', 'Cleared to play.', 1),
(5, 5, 'Healthy', 'None', 'Excellent', '2024-12-21', 'No issues.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `metier` varchar(15) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id`, `nom`, `email`, `metier`, `image`) VALUES
(9, 'Saaid Slimani', 'saaidSlimani@gmail.com', 'employeur', 'uploads/2024/12/23/6769b3f580133-walid.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `message_content` text DEFAULT NULL,
  `message_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_content` text DEFAULT NULL,
  `notification_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `preinscriptions`
--

CREATE TABLE `preinscriptions` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position_preferree` varchar(50) NOT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `preinscriptions`
--

INSERT INTO `preinscriptions` (`id`, `nom`, `prenom`, `date_naissance`, `adresse`, `telephone`, `email`, `position_preferree`, `experience`, `date_inscription`) VALUES
(1, 'Amrani', 'Mehdi', '2010-05-12', 'Casablanca', '+212600112233', 'mehdi.amrani@example.com', 'Attaquant', 'Club junior local', '2024-12-23 18:41:23'),
(2, 'Berrada', 'Salma', '2008-09-25', 'Rabat', '+212600223344', 'salma.berrada@example.com', 'Milieu', 'Équipe scolaire', '2024-12-23 18:41:23');

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `activity_type` enum('Training','Match','Recovery','Educational') NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `title`, `description`, `date`, `time`, `location`, `activity_type`, `player_id`) VALUES
(1, 'Morning Training Session', 'Ball control drills and passing techniques', '2024-12-21', '08:00:00', 'Training Ground A', 'Training', 1),
(2, 'Friendly Match', 'Friendly match with local club', '2024-12-22', '15:00:00', 'Stadium B', 'Match', 1),
(3, 'Fitness and Recovery', 'Fitness workout and physiotherapy', '2024-12-23', '10:00:00', 'Fitness Center', '', 1),
(4, 'Tactical Session', 'Tactical play and set pieces', '2024-12-24', '11:00:00', 'Training Ground A', 'Training', 1),
(5, 'Evening Training', 'Focus on agility and stamina', '2024-12-23', '17:00:00', 'Field B', 'Training', 21),
(1, 'Séance Matinale', 'Dribbles et passes', '2024-12-24', '08:00:00', 'Terrain A', 'Training', 1),
(2, 'Match Amical', 'Contre l’équipe locale', '2024-12-25', '15:00:00', 'Stade B', 'Match', 2),
(3, 'Récupération', 'Physiothérapie et étirements', '2024-12-26', '10:00:00', 'Centre de Fitness', 'Recovery', 3),
(4, 'Tactiques', 'Préparation pour la défense', '2024-12-27', '11:00:00', 'Terrain B', 'Training', 4),
(5, 'Entraînement Intensif', 'Agilité et endurance', '2024-12-28', '17:00:00', 'Terrain C', 'Training', 5);

-- --------------------------------------------------------

--
-- Structure de la table `specialisations`
--

CREATE TABLE `specialisations` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `progression` int(11) NOT NULL,
  `entraineur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `specialisations`
--

INSERT INTO `specialisations` (`id`, `nom`, `progression`, `entraineur_id`) VALUES
(1, 'Tactic de jeu', 70, 1),
(2, 'Tactic de jeu', 60, 2),
(3, 'Defense Strategy', 80, 5),
(4, 'Attaque', 80, 1),
(5, 'Milieu de Terrain', 75, 2),
(6, 'Défense', 85, 3);

-- --------------------------------------------------------

--
-- Structure de la table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `day` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'images/icon/avatar-01.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `avatar`) VALUES
(1, 'Amine El Fassi', 'amine.elfassi@example.com', 'avatar1.jpg'),
(2, 'Rania Oulidi', 'rania.oulidi@example.com', 'avatar2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

CREATE TABLE `user_settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`achievement_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `carrieres`
--
ALTER TABLE `carrieres`
  ADD PRIMARY KEY (`id_carreire`),
  ADD KEY `id_entraineur` (`id_entraineur`);

--
-- Index pour la table `contacts_player`
--
ALTER TABLE `contacts_player`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entraineur_id` (`entraineur_id`);

--
-- Index pour la table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`email_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `entraineur`
--
ALTER TABLE `entraineur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `preinscriptions`
--
ALTER TABLE `preinscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_group_id` (`group_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `emails`
--
ALTER TABLE `emails`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `entraineur`
--
ALTER TABLE `entraineur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `preinscriptions`
--
ALTER TABLE `preinscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
