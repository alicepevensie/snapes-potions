-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2020 at 01:00 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snapes_potions`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) UNSIGNED NOT NULL,
  `unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`name`, `image`, `description`, `amount`, `unit`) VALUES
('Alihotsy', '4964438bf441f190b0b561c2873fb3d6.png', 'Alternative name: Hyena tree. Non-sentient. Pink stem. Leaves induce hysteria and uncontrollable laughter.', 888, 'plant'),
('Boomslang skin', 'dd3a9c9d660886781121c36cc8c0ea26.png', 'Boomslang Skin is skin shed from a Boomslang snake. The skin is mostly green in males and brown in females, and serves as an atypical potion ingredient. Brown or green.', 1, 'skins'),
('Dittany', 'dittany.png', 'Dittany is a powerful healing herb and restorative and may be eaten raw to cure shallow wounds. Alternative name: Burning Bush. Non-sentient. Stem is dark green in colour. Leaves are dark green in colour. It sometimes releases flammable vapours', 57, 'herbs'),
('Fluxweed', 'bcc012c2c86e6c2a76ccd21f0be3ea29.png', 'Fluxweed was a magical plant and member of the mustard family known for its healing properties.', 60, 'plant'),
('Horn of Bicorn', 'f7583f0fbcae4f45d8b81e7b7ebddae9.png', 'Bicorns possess two large horns. These horns are shed annually and are gathered when the Bicorn is not looking. Curly, tan coloured.', 2, 'horns'),
('Knotgrass', '2a4e71731276e0697d90a36186f8d75b.png', 'Knotgrass is a plant with magical properties. It is used in Potion-making, and is an essential ingredient in the making of the Polyjuice Potion, as well as in the brewing of the alcoholic beverage Knotgrass Mead.', 3, 'plant'),
('Lacewing fly', 'd15dfbb6b9d6885d37506b80deade096.png', 'Lacewing flies, or just lacewings, are small green insects named for their large, transparent, laced wings. Lacewing flies are sold at the Magical Menagerie. Lacewing flies are not on the Restricted Register.', 15, 'flies'),
('Leech', '3ae3b8b59e7688e09320f3081ed966b2.png', 'Leeches are small slug-like invertebrates that live in water. They feed on human blood and/or that of other small invertebrates. Leech spit contains an anticoagulant (a substance that prevents blood clotting), allowing them to feed for longer than blood would normally flow.', 100, 'leeches'),
('Mandrake', 'mandrake.png', 'Mandrake, or Mandragora, is a powerful restorative. It is used to turn people who have been transfigured or cursed to their original state. The cry of the Mandrake is fatal to anyone who hears it.', 15, 'plant'),
('Unicorn hair', 'unicornhair.png', 'Can bind bandages, silver color.', 25, 'hair');

-- --------------------------------------------------------

--
-- Table structure for table `potions`
--

CREATE TABLE `potions` (
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `effect` text NOT NULL,
  `category` enum('potion','draught','antidote','elixir','paste','pomade','secretion','balm','solution','essence','mixture','gas','concoction','unclassified') NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `potions`
--

INSERT INTO `potions` (`name`, `image`, `description`, `effect`, `category`, `amount`) VALUES
('Amorentia', 'amorentia.jpg', 'Mother-of-pearl sheen\r\nSpiralling steam\r\nScent is multi-faceted and varies based on what the person likes', 'Love Potion that causes a powerful infatuation or obsession in the drinker', 'elixir', 1),
('Cure for Boils', '6bf762004ecc4d6719e2a8061d8bc838.PNG', 'Being an effective remedie against pustules, hives, boils and many other scrofulous conditions. This is a robust potion of powerful character. Care should be taken when brewing. Prepared incorrectly this potion has been known to cause boils, rather than cure them. Blue. Has pink smoke when made successfully.', 'Cures boils', 'potion', 0),
('Polyjuice Potion', 'polyjuice-potion.jpg', 'Before addition of final ingredient: Thick and mud-like, Bubbles slowly\r\nAfter addition of final ingredient: Taste and colour vary depending on the person being turned into', 'Allows a human drinker to temporarily assume the form of another person.\r\nAttempts to transform into animals or part-humans will not reverse automatically.', 'potion', 1),
('Rat Tonic', 'rat-tonic.png', 'A Rat tonic was a healing potion for rats. It was used to treat ageing rats. Green-coloured.', 'Heals rats. Abnormal growth of the rat if too much is drunk.', 'potion', 0);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `potion_name` varchar(255) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL,
  `ingredient_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`potion_name`, `ingredient_name`, `ingredient_amount`) VALUES
('Polyjuice Potion', 'Boomslang skin', 3),
('Polyjuice Potion', 'Fluxweed', 3),
('Polyjuice Potion', 'Horn of Bicorn', 1),
('Polyjuice Potion', 'Knotgrass', 2),
('Polyjuice Potion', 'Lacewing fly', 1),
('Polyjuice Potion', 'Leech', 4);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_instructions`
--

CREATE TABLE `recipe_instructions` (
  `potion_recipe` varchar(255) NOT NULL,
  `step` int(11) NOT NULL,
  `step_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe_instructions`
--

INSERT INTO `recipe_instructions` (`potion_recipe`, `step`, `step_description`) VALUES
('Polyjuice Potion', 1, 'Add 3 measures of fluxweed to the cauldron (must have been picked on a full moon).'),
('Polyjuice Potion', 2, 'Add 2 bundles of knotgrass to the cauldron.'),
('Polyjuice Potion', 3, 'Stir 4 times, clockwise.'),
('Polyjuice Potion', 4, 'Wave your wand then let potion brew for 80 minutes (for a Pewter Cauldron. A Brass Cauldron will only require 68, and a copper one only 60.)'),
('Polyjuice Potion', 5, 'Add 4 leeches to the cauldron.'),
('Polyjuice Potion', 6, 'Add 2 scoops of lacewing flies to the mortar, crush to a fine paste, then add 2 measures of the crushed lacewings to the cauldron.'),
('Polyjuice Potion', 7, 'Heat for 30 seconds on a low heat.'),
('Polyjuice Potion', 8, 'Wave your wand to complete this stage of the potion.'),
('Polyjuice Potion', 9, 'Add 3 measures of boomslang skin to the cauldron.'),
('Polyjuice Potion', 10, 'Add 1 measure of bicorn horn to the mortar, crush to a fine powder, then add one measure of the crushed horn to the cauldron.'),
('Polyjuice Potion', 11, 'Heat for 20 seconds at a high temperature.'),
('Polyjuice Potion', 12, 'Wave your wand then let potion brew for 24 hours (for a Pewter Cauldron. A Brass Cauldron will only require 1224 minutes, and a copper one only 18 hours).'),
('Polyjuice Potion', 13, 'Add 1 additional scoop of lacewings to the cauldron.'),
('Polyjuice Potion', 14, 'Stir 3 times, counter-clockwise.'),
('Polyjuice Potion', 15, 'Split potion into multiple doses, if desired, then add the pieces of the person you wish to become.'),
('Polyjuice Potion', 16, 'Wave your wand to complete the potion');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` date NOT NULL,
  `house` enum('Slytherin','Ravenclaw','Hufflepuff','Gryffindor') NOT NULL,
  `status` enum('Professor','Student','Other') NOT NULL,
  `access` tinyint(4) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `birth_date`, `created_at`, `house`, `status`, `access`, `password`) VALUES
(2, 'Severus', 'Snape', 'ProfessorSnape', '1960-01-09', '2019-12-31', 'Slytherin', 'Professor', 1, '08eccd0059b1f6d24dcdf16d216f9af1'),
(3, 'Jovana', 'Rakočević', 'alicepevensie', '1999-01-27', '2019-12-31', 'Hufflepuff', 'Student', 1, '10a5284f28ccede502e60ee86096c6a7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `image` (`image`) USING HASH;

--
-- Indexes for table `potions`
--
ALTER TABLE `potions`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `image_name` (`image`) USING HASH;

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`potion_name`,`ingredient_name`),
  ADD KEY `ingredient_name` (`ingredient_name`);

--
-- Indexes for table `recipe_instructions`
--
ALTER TABLE `recipe_instructions`
  ADD PRIMARY KEY (`potion_recipe`,`step`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`ingredient_name`) REFERENCES `ingredients` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_3` FOREIGN KEY (`potion_name`) REFERENCES `potions` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_instructions`
--
ALTER TABLE `recipe_instructions`
  ADD CONSTRAINT `recipe_instructions_ibfk_1` FOREIGN KEY (`potion_recipe`) REFERENCES `recipes` (`potion_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
