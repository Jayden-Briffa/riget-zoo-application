-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for rza
CREATE DATABASE IF NOT EXISTS `rza` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `rza`;

-- Dumping structure for table rza.hotel_bookings
CREATE TABLE IF NOT EXISTS `hotel_bookings` (
  `hotel_booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_cost` float DEFAULT '0',
  `stay_date` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hotel_booking_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `hotel_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table rza.hotel_bookings: ~4 rows (approximately)
DELETE FROM `hotel_bookings`;
/*!40000 ALTER TABLE `hotel_bookings` DISABLE KEYS */;
INSERT INTO `hotel_bookings` (`hotel_booking_id`, `user_id`, `total_cost`, `stay_date`, `created_at`) VALUES
	(39, 1, 60, '2025-02-07', '2025-02-05 10:22:56'),
	(40, 1, 40, '2025-02-16', '2025-02-05 10:23:00'),
	(41, 1, 60, '2025-02-06', '2025-02-05 16:01:46'),
	(42, 1, 60, '2025-02-06', '2025-02-05 16:01:47');
/*!40000 ALTER TABLE `hotel_bookings` ENABLE KEYS */;

-- Dumping structure for table rza.hotel_nights
CREATE TABLE IF NOT EXISTS `hotel_nights` (
  `hotel_night_id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_booking_id` int(11) NOT NULL,
  `night_date` varchar(10) NOT NULL,
  PRIMARY KEY (`hotel_night_id`),
  KEY `hotel_booking_id` (`hotel_booking_id`),
  CONSTRAINT `hotel_nights_ibfk_1` FOREIGN KEY (`hotel_booking_id`) REFERENCES `hotel_bookings` (`hotel_booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

-- Dumping data for table rza.hotel_nights: ~11 rows (approximately)
DELETE FROM `hotel_nights`;
/*!40000 ALTER TABLE `hotel_nights` DISABLE KEYS */;
INSERT INTO `hotel_nights` (`hotel_night_id`, `hotel_booking_id`, `night_date`) VALUES
	(61, 39, '2025-02-07'),
	(62, 39, '2025-02-08'),
	(63, 39, '2025-02-09'),
	(64, 40, '2025-02-16'),
	(65, 40, '2025-02-17'),
	(66, 41, '2025-02-06'),
	(67, 41, '2025-02-07'),
	(68, 41, '2025-02-08'),
	(69, 42, '2025-02-06'),
	(70, 42, '2025-02-07'),
	(71, 42, '2025-02-08');
/*!40000 ALTER TABLE `hotel_nights` ENABLE KEYS */;

-- Dumping structure for table rza.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `running_spend` float DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table rza.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `first_name`, `surname`, `email`, `password`, `running_spend`, `created_at`) VALUES
	(1, 'John', 'Doe', 'johndoe@email.com', '$2y$12$xRTYKUaCL.4XfovOPeTyT.AmomBZE11r9OHuZSpBMIYiiOxt1GtZy', 220, '2025-01-27 14:37:36'),
	(2, 'Jayden', 'Briffa', 'jaydenbriffa@outlook.com', '$2y$12$Zwc.rnsSUjgw9RLDHQV3fOH40.g4vATiZaif20vT6KptCmIgHS7Rm', 300, '2025-02-05 16:04:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table rza.zoo_bookings
CREATE TABLE IF NOT EXISTS `zoo_bookings` (
  `zoo_booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `adult_tickets` int(11) DEFAULT '0',
  `child_tickets` int(11) DEFAULT '0',
  `total_cost` float DEFAULT '0',
  `visit_date` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`zoo_booking_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `zoo_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table rza.zoo_bookings: ~3 rows (approximately)
DELETE FROM `zoo_bookings`;
/*!40000 ALTER TABLE `zoo_bookings` DISABLE KEYS */;
INSERT INTO `zoo_bookings` (`zoo_booking_id`, `user_id`, `adult_tickets`, `child_tickets`, `total_cost`, `visit_date`, `created_at`) VALUES
	(5, 1, 2, 1, 40, '2025-02-25', '2025-02-05 11:40:32'),
	(6, 1, 1, 1, 25, '2025-02-06', '2025-02-05 13:44:56'),
	(7, 1, 1, 2, 35, '2025-02-06', '2025-02-05 16:01:07');
/*!40000 ALTER TABLE `zoo_bookings` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
