CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Smartphone'),
(2, 'Ordinateur'),
(3, 'Carte graphique'),
(4, 'Mémoire RAM'),
(5, 'Alimentation'),
(6, 'SSD'),
(7, 'Boîtier'),
(8, 'Clavier'),
(9, 'Processeur'),
(10, 'Écouteurs'),
(11, 'Alimentation'),
(12, 'Boîtier'),
(13, 'Processeur'),
(14, 'Mémoire RAM'),
(15, 'Clavier'),
(16, 'SSD'),
(17, 'Carte graphique'),
(18, 'Smartphone'),
(19, 'Ordinateur portable'),
(20, 'Écouteurs'),
(21, 'Alimentation'),
(22, 'Boîtier'),
(23, 'Processeur'),
(24, 'Mémoire RAM'),
(25, 'Clavier'),
(26, 'SSD'),
(27, 'Carte graphique'),
(28, 'Smartphone'),
(29, 'Ordinateur portable'),
(30, 'Écouteurs'),
(31, 'Alimentation'),
(32, 'Boîtier'),
(33, 'Processeur'),
(34, 'Mémoire RAM'),
(35, 'Clavier'),
(36, 'SSD'),
(37, 'Carte graphique'),
(38, 'Smartphone'),
(39, 'Ordinateur portable'),
(40, 'Écouteurs'),
(41, 'Alimentation'),
(42, 'Boîtier'),
(43, 'Processeur'),
(44, 'Mémoire RAM'),
(45, 'Clavier'),
(46, 'SSD'),
(47, 'Carte graphique'),
(48, 'Smartphone'),
(49, 'Ordinateur portable'),
(50, 'Écouteurs'),
(51, 'Alimentation'),
(52, 'Boîtier'),
(53, 'Processeur'),
(54, 'Mémoire RAM'),
(55, 'Clavier'),
(56, 'SSD'),
(57, 'Carte graphique'),
(58, 'Smartphone'),
(59, 'Ordinateur portable'),
(60, 'Écouteurs');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produits_categories` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `created_at`, `categorie_id`) VALUES
(1, 'Alimentation 1', '550W 80+ Bronze', 128.45, '2025-09-17 22:56:49', 1),
(2, 'Boîtier 2', 'ATX moyen tour', 230.91, '2025-09-17 22:56:49', 2),
(3, 'Processeur 3', '8 cœurs', 797.82, '2025-09-17 22:56:49', 3),
(4, 'Mémoire RAM 4', '8Go DDR4', 101.72, '2025-09-17 22:56:49', 4),
(5, 'Clavier 5', 'Mécanique RGB', 123.10, '2025-09-17 22:56:49', 5),
(6, 'SSD 6', '1To NVMe', 256.68, '2025-09-17 22:56:49', 6),
(7, 'SSD 7', '1To NVMe', 291.49, '2025-09-17 22:56:49', 6),
(8, 'Boîtier 8', 'Mini-ITX compact', 348.10, '2025-09-17 22:56:49', 2),
(9, 'Mémoire RAM 9', '8Go DDR4', 115.13, '2025-09-17 22:56:49', 4),
(10, 'Smartphone 10', 'Compact 5.8\", 64Go', 1132.37, '2025-09-17 22:56:49', 8),
(11, 'Smartphone 11', 'Écran 6.5\", 128Go', 153.98, '2025-09-17 22:56:49', 8),
(12, 'Clavier 12', 'Membrane compact', 93.30, '2025-09-17 22:56:49', 5),
(13, 'SSD 13', '1To NVMe', 179.70, '2025-09-17 22:56:49', 6),
(14, 'Carte graphique 14', '6GB GDDR6 budget', 726.89, '2025-09-17 22:56:49', 7),
(15, 'SSD 15', '1To NVMe', 304.40, '2025-09-17 22:56:49', 6),
(16, 'Carte graphique 16', '12GB GDDR6X - très performant', 670.06, '2025-09-17 22:56:49', 7),
(17, 'SSD 17', '512Go NVMe', 248.58, '2025-09-17 22:56:49', 6),
(18, 'Alimentation 18', '750W 80+ Gold', 246.95, '2025-09-17 22:56:49', 1),
(19, 'Alimentation 19', '750W 80+ Gold', 246.73, '2025-09-17 22:56:49', 1),
(20, 'Clavier 20', 'Membrane compact', 173.17, '2025-09-17 22:56:49', 5),
(21, 'Ordinateur portable 21', '17\" gamer, 32Go RAM, RTX GPU', 709.26, '2025-09-17 22:56:49', 9),
(22, 'Alimentation 22', '750W 80+ Gold', 176.60, '2025-09-17 22:56:49', 1),
(23, 'Boîtier 23', 'Full Tower gaming', 246.78, '2025-09-17 22:56:49', 2),
(24, 'Carte graphique 24', '12GB GDDR6X - très performant', 247.08, '2025-09-17 22:56:49', 7),
(25, 'Alimentation 25', '550W 80+ Bronze', 222.87, '2025-09-17 22:56:49', 1),
(26, 'Boîtier 26', 'ATX moyen tour', 223.12, '2025-09-17 22:56:49', 2),
(27, 'Mémoire RAM 27', '16Go DDR4', 65.32, '2025-09-17 22:56:49', 4),
(28, 'Mémoire RAM 28', '32Go DDR4', 34.92, '2025-09-17 22:56:49', 4),
(29, 'SSD 29', '256Go NVMe', 137.08, '2025-09-17 22:56:49', 6),
(30, 'Carte graphique 30', '6GB GDDR6 budget', 768.69, '2025-09-17 22:56:49', 7),
(31, 'Smartphone 31', 'Écran 6.5\", 128Go', 653.99, '2025-09-17 22:56:49', 8),
(32, 'Ordinateur portable 32', '14\" ultraportable, 16Go RAM, SSD 1To', 626.39, '2025-09-17 22:56:49', 9),
(33, 'Smartphone 33', 'Écran 6.5\", 128Go', 556.38, '2025-09-17 22:56:49', 8),
(34, 'Clavier 34', 'Ergonomique sans fil', 30.60, '2025-09-17 22:56:49', 5),
(35, 'Clavier 35', 'Ergonomique sans fil', 141.84, '2025-09-17 22:56:49', 5),
(36, 'Écouteurs 36', 'Bluetooth, réduction du bruit', 155.92, '2025-09-17 22:56:49', 10),
(37, 'Carte graphique 37', '12GB GDDR6X - très performant', 981.34, '2025-09-17 22:56:49', 7),
(38, 'Écouteurs 38', 'Bluetooth, réduction du bruit', 14.95, '2025-09-17 22:56:49', 10),
(39, 'Processeur 39', '12 cœurs hautes performances', 738.80, '2025-09-17 22:56:49', 3),
(40, 'SSD 40', '256Go NVMe', 290.87, '2025-09-17 22:56:49', 6),
(41, 'Clavier 41', 'Membrane compact', 23.43, '2025-09-17 22:56:49', 5),
(42, 'Ordinateur portable 42', '15.6\" Full HD, 8Go RAM, SSD 512Go', 569.14, '2025-09-17 22:56:49', 9),
(43, 'Mémoire RAM 43', '16Go DDR4', 55.09, '2025-09-17 22:56:49', 4),
(44, 'Clavier 44', 'Membrane compact', 125.72, '2025-09-17 22:56:49', 5),
(45, 'SSD 45', '1To NVMe', 74.44, '2025-09-17 22:56:49', 6),
(46, 'Clavier 46', 'Mécanique RGB', 185.21, '2025-09-17 22:56:49', 5),
(47, 'Smartphone 47', 'Écran 6.5\", 128Go', 1158.39, '2025-09-17 22:56:49', 8),
(48, 'Carte graphique 48', '12GB GDDR6X - très performant', 1113.86, '2025-09-17 22:56:49', 7),
(49, 'Smartphone 49', 'Compact 5.8\", 64Go', 967.87, '2025-09-17 22:56:49', 8),
(50, 'Smartphone 50', 'Compact 5.8\", 64Go', 927.22, '2025-09-17 22:56:49', 8),
(51, 'Ordinateur portable 51', '17\" gamer, 32Go RAM, RTX GPU', 1223.77, '2025-09-17 22:56:49', 9),
(52, 'Boîtier 52', 'Full Tower gaming', 389.46, '2025-09-17 22:56:49', 2),
(53, 'Smartphone 53', 'Écran 6.5\", 128Go', 430.62, '2025-09-17 22:56:49', 8),
(54, 'Ordinateur portable 54', '14\" ultraportable, 16Go RAM, SSD 1To', 625.06, '2025-09-17 22:56:49', 9),
(55, 'SSD 55', '512Go NVMe', 319.00, '2025-09-17 22:56:49', 6),
(56, 'Carte graphique 56', '6GB GDDR6 budget', 171.31, '2025-09-17 22:56:49', 7),
(57, 'Alimentation 57', '550W 80+ Bronze', 221.75, '2025-09-17 22:56:49', 1),
(58, 'Mémoire RAM 58', '32Go DDR4', 177.83, '2025-09-17 22:56:49', 4),
(59, 'Smartphone 59', 'Compact 5.8\", 64Go', 146.95, '2025-09-17 22:56:49', 8),
(60, 'Boîtier 60', 'ATX moyen tour', 45.76, '2025-09-17 22:56:49', 2),
(61, 'Mémoire RAM 61', '8Go DDR4', 96.55, '2025-09-17 22:56:49', 4),
(62, 'Alimentation 62', '750W 80+ Gold', 192.08, '2025-09-17 22:56:49', 1),
(63, 'Boîtier 63', 'ATX moyen tour', 213.60, '2025-09-17 22:56:49', 2),
(64, 'Clavier 64', 'Mécanique RGB', 93.63, '2025-09-17 22:56:49', 5),
(65, 'SSD 65', '256Go NVMe', 143.78, '2025-09-17 22:56:49', 6),
(66, 'Smartphone 66', 'Compact 5.8\", 64Go', 995.09, '2025-09-17 22:56:49', 8),
(67, 'Clavier 67', 'Membrane compact', 46.90, '2025-09-17 22:56:49', 5),
(68, 'Écouteurs 68', 'Filaire, bonne basse', 249.26, '2025-09-17 22:56:49', 10),
(69, 'Alimentation 69', '550W 80+ Bronze', 222.12, '2025-09-17 22:56:49', 1),
(70, 'Clavier 70', 'Ergonomique sans fil', 33.64, '2025-09-17 22:56:49', 5),
(71, 'Écouteurs 71', 'Bluetooth, réduction du bruit', 174.37, '2025-09-17 22:56:49', 10),
(72, 'Ordinateur portable 72', '14\" ultraportable, 16Go RAM, SSD 1To', 1983.86, '2025-09-17 22:56:49', 9),
(73, 'Écouteurs 73', 'Intra-auriculaire sport', 178.88, '2025-09-17 22:56:49', 10),
(74, 'Boîtier 74', 'Mini-ITX compact', 83.47, '2025-09-17 22:56:49', 2),
(75, 'Smartphone 75', 'Compact 5.8\", 64Go', 927.52, '2025-09-17 22:56:49', 8),
(76, 'Processeur 76', '4 cœurs', 344.63, '2025-09-17 22:56:49', 3),
(77, 'Boîtier 77', 'Mini-ITX compact', 202.42, '2025-09-17 22:56:49', 2),
(78, 'Processeur 78', '4 cœurs', 788.46, '2025-09-17 22:56:49', 3),
(79, 'Smartphone 79', 'Flagship, 256Go, charge rapide', 1118.28, '2025-09-17 22:56:49', 8),
(80, 'Ordinateur portable 80', '17\" gamer, 32Go RAM, RTX GPU', 1581.88, '2025-09-17 22:56:49', 9),
(81, 'Clavier 81', 'Mécanique RGB', 58.14, '2025-09-17 22:56:49', 5),
(82, 'Carte graphique 82', '8GB GDDR6', 1119.66, '2025-09-17 22:56:49', 7),
(83, 'Smartphone 83', 'Écran 6.5\", 128Go', 298.70, '2025-09-17 22:56:49', 8),
(84, 'Mémoire RAM 84', '8Go DDR4', 88.02, '2025-09-17 22:56:49', 4),
(85, 'Processeur 85', '12 cœurs hautes performances', 303.68, '2025-09-17 22:56:49', 3),
(86, 'Ordinateur portable 86', '14\" ultraportable, 16Go RAM, SSD 1To', 1532.06, '2025-09-17 22:56:49', 9),
(87, 'Ordinateur portable 87', '15.6\" Full HD, 8Go RAM, SSD 512Go', 1578.94, '2025-09-17 22:56:49', 9),
(88, 'Smartphone 88', 'Compact 5.8\", 64Go', 712.06, '2025-09-17 22:56:49', 8),
(89, 'Processeur 89', '8 cœurs', 121.54, '2025-09-17 22:56:49', 3),
(90, 'Smartphone 90', 'Flagship, 256Go, charge rapide', 399.69, '2025-09-17 22:56:49', 8),
(91, 'Processeur 91', '8 cœurs', 109.78, '2025-09-17 22:56:49', 3),
(92, 'Smartphone 92', 'Écran 6.5\", 128Go', 920.65, '2025-09-17 22:56:49', 8),
(93, 'Alimentation 93', '550W 80+ Bronze', 226.71, '2025-09-17 22:56:49', 1),
(94, 'Clavier 94', 'Ergonomique sans fil', 143.64, '2025-09-17 22:56:49', 5),
(95, 'Ordinateur portable 95', '15.6\" Full HD, 8Go RAM, SSD 512Go', 1733.37, '2025-09-17 22:56:49', 9),
(96, 'Processeur 96', '8 cœurs', 121.89, '2025-09-17 22:56:49', 3),
(97, 'Carte graphique 97', '12GB GDDR6X - très performant', 232.59, '2025-09-17 22:56:49', 7),
(98, 'Boîtier 98', 'Mini-ITX compact', 99.07, '2025-09-17 22:56:49', 2),
(99, 'Ordinateur portable 99', '14\" ultraportable, 16Go RAM, SSD 1To', 1286.01, '2025-09-17 22:56:49', 9),
(100, 'Carte graphique 100', '12GB GDDR6X - très performant', 737.49, '2025-09-17 22:56:49', 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `pseudo`, `password`, `created_at`, `is_admin`, `banned`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$GAamOmuXGLqnLZnV40pN0.mh7QG4N9KbU8ACVIoJ0Wvj0.tqbA.U2', '2025-09-17 23:00:11', 1, 0),
(2, 'test', 'test', 'test', '$2y$10$hIQU4n61vNSaA8zVe6rdbOd/o7nED44aze/N9C2AvfJCMW492BK8y', '2025-09-17 23:05:14', 0, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produits_categories` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
