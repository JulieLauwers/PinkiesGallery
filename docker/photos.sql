SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS `pinkie-photos`;

CREATE DATABASE `pinkie-photos` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `pinkie-photos`;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(55) NOT NULL,
    `email` VARCHAR(125) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

INSERT INTO `users` VALUES (1, 'Pinkie', 'julie.lauwers02@gmail.com', '$2y$10$syJeny9vqStu1wJxrOKm6e2pzRjj2/mRCFKZFCiMsQG...', 'admin', now());
INSERT INTO `users` VALUES (2, 'Bart', 'bart.delrue@mail.com', '$2y$10$800PPZ5EQfuuIahHDnJZ3uagr6ULOcMuD/X5A/0YuSx...', 'admin', now());

CREATE TABLE `photos` (
  `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `path` VARCHAR(255) NOT NULL,
    `name` VARCHAR(125) NOT NULL,
    `extension` VARCHAR(10) NOT NULL,
    `location` VARCHAR(75) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

INSERT INTO `photos` VALUES (1, 'Sea view with sun in the sky', '../../img/', 'ZonStrandZee', '.jpg', 'Wenduine', now());

CREATE TABLE `messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(50) NOT NULL,
    `question` VARCHAR(500) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

INSERT INTO `messages` VALUES (1, 'test@test.com', 'Your skills' ,'Do you have alot of skills with photography?', now());
