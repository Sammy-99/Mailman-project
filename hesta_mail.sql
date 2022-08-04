-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cc_bcc`;
CREATE TABLE `cc_bcc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_id` int NOT NULL,
  `cc_id` int DEFAULT NULL,
  `bcc_id` int DEFAULT NULL,
  `cc_read` int NOT NULL DEFAULT '0',
  `bcc_read` int NOT NULL DEFAULT '0',
  `delete_by_cc` int NOT NULL DEFAULT '0',
  `delete_by_bcc` int NOT NULL DEFAULT '0',
  `permanent_del_by_cc` int NOT NULL DEFAULT '0',
  `permanent_del_by_bcc` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `email_inbox`;
CREATE TABLE `email_inbox` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `reciever_id` int DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `attachment_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `cc_bcc_draft_participants` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `is_draft` tinyint NOT NULL DEFAULT '0',
  `is_read` tinyint NOT NULL DEFAULT '0',
  `delete_by_sender` tinyint NOT NULL DEFAULT '0',
  `delete_by_reciever` tinyint NOT NULL DEFAULT '0',
  `permanent_deleted_by_sender` tinyint NOT NULL DEFAULT '0',
  `permanent_deleted_by_reciever` tinyint NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `secondary_email` varchar(55) NOT NULL,
  `user_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2022-08-04 05:32:00
