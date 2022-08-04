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
  `sender_id` int DEFAULT NULL,
  `reciever_id` int DEFAULT NULL,
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

INSERT INTO `cc_bcc` (`id`, `email_id`, `sender_id`, `reciever_id`, `cc_id`, `bcc_id`, `cc_read`, `bcc_read`, `delete_by_cc`, `delete_by_bcc`, `permanent_del_by_cc`, `permanent_del_by_bcc`, `created_at`, `updated_at`) VALUES
(1,	11,	NULL,	NULL,	9,	11,	1,	0,	1,	0,	0,	0,	'2022-07-29 11:39:15',	'2022-07-29 11:39:15'),
(2,	11,	NULL,	NULL,	10,	9,	0,	1,	0,	1,	0,	0,	'2022-07-31 10:52:35',	'2022-07-31 10:52:35'),
(3,	13,	NULL,	NULL,	NULL,	9,	0,	1,	0,	0,	0,	0,	'2022-07-29 09:00:22',	'2022-07-29 09:00:22'),
(4,	23,	NULL,	NULL,	9,	9,	1,	1,	0,	0,	0,	0,	'2022-07-29 11:03:22',	'2022-07-29 11:03:22'),
(5,	24,	NULL,	NULL,	8,	8,	1,	1,	0,	0,	0,	0,	'2022-07-29 10:48:48',	'2022-07-29 10:48:48'),
(6,	25,	NULL,	NULL,	8,	8,	1,	1,	0,	0,	0,	0,	'2022-07-29 11:05:00',	'2022-07-29 11:05:00'),
(7,	27,	NULL,	NULL,	10,	11,	0,	0,	0,	0,	0,	0,	'2022-07-31 10:52:35',	'2022-07-31 10:52:35'),
(8,	27,	NULL,	NULL,	NULL,	9,	0,	1,	0,	0,	0,	0,	'2022-07-29 11:41:41',	'2022-07-29 11:41:41'),
(9,	37,	NULL,	NULL,	9,	11,	1,	1,	0,	0,	0,	0,	'2022-08-01 09:55:42',	'2022-08-01 09:55:42'),
(10,	39,	NULL,	NULL,	10,	11,	1,	0,	0,	0,	0,	0,	'2022-08-01 10:03:01',	'2022-08-01 10:03:01'),
(11,	41,	NULL,	NULL,	9,	NULL,	1,	0,	0,	0,	0,	0,	'2022-08-01 10:05:12',	'2022-08-01 10:05:12'),
(12,	46,	NULL,	NULL,	9,	NULL,	1,	0,	0,	0,	0,	0,	'2022-08-01 10:23:44',	'2022-08-01 10:23:44'),
(13,	54,	NULL,	NULL,	11,	NULL,	1,	0,	0,	0,	0,	0,	'2022-08-01 10:38:53',	'2022-08-01 10:38:53');

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

INSERT INTO `email_inbox` (`id`, `sender_id`, `reciever_id`, `subject`, `content`, `attachment_file`, `cc_bcc_draft_participants`, `is_draft`, `is_read`, `delete_by_sender`, `delete_by_reciever`, `permanent_deleted_by_sender`, `permanent_deleted_by_reciever`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	9,	9,	'',	'',	'',	'a:3:{s:2:\"to\";s:17:\"samir@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 07:56:18',	'2022-07-29 07:56:18',	'2022-07-29 07:56:18'),
(2,	9,	0,	'subjjjjjjjj',	'msgg',	'',	'a:3:{s:2:\"to\";s:9:\"reciever@\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 10:08:14',	'2022-07-29 10:08:14',	'2022-07-29 10:08:14'),
(3,	9,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:18:\"ahamad@mailman.com\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	1,	0,	'2022-07-29 09:46:05',	'2022-07-29 09:46:05',	'2022-07-29 09:46:05'),
(4,	9,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:7:\"asdgash\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 07:56:18',	'2022-07-29 07:56:18',	'2022-07-29 07:56:18'),
(5,	9,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:11:\"sadgasdsdas\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-07-29 06:54:26',	NULL),
(6,	9,	10,	'this is subject',	'msgg',	'1659079120-pngfind.com-rocket-png-3268963.png, 1659079120-pngtree-mail-vector-icon-email-address-png-image_8299575.png, 1659079120-mail-outline-glyph-icon-workspace-sign-graph-symbol-for-your-web-site-design-logo-app-ui-vector-illustration-eps10-2GY7484.jpg, 1659079120-rocket-ship-png-1727191.png, 1659079120-pngfind.com-rocket-ship-png-1727191.png, 1659079120-360_F_476400933_A4gKwXtlgQFslfSuDvbV35eQcBIDlYjw.jpg, 1659079120-profile-icon-png-909.png, 1659079120-1657797095-hesta_mail (1).sql, 1659079120-hesta_mail (1).sql, 1659079120-—Pngtree—pencil line black icon_3746331.png',	NULL,	0,	0,	0,	0,	0,	0,	'2022-07-29 10:58:54',	'2022-07-29 10:58:54',	'2022-07-29 10:58:54'),
(7,	10,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:9:\"dsgfhsfdf\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 10:58:40',	'2022-07-29 10:58:40',	'2022-07-29 10:58:40'),
(8,	10,	9,	'this is subject',	'shdgdhsdhj',	'',	'a:3:{s:2:\"to\";s:17:\"samir@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	1,	0,	0,	0,	0,	'2022-07-29 10:58:40',	'2022-07-29 10:58:40',	'2022-07-29 10:58:40'),
(9,	10,	9,	'subject msggg',	'asadasdd',	'',	NULL,	0,	1,	0,	0,	0,	0,	'2022-07-29 11:18:22',	'2022-07-29 11:18:22',	'2022-07-29 11:18:22'),
(11,	9,	10,	'test subject',	'my msggg',	'',	NULL,	0,	0,	1,	0,	0,	0,	'2022-07-31 10:52:35',	'2022-07-31 10:52:35',	'2022-07-31 10:52:35'),
(12,	9,	8,	'Subject to sammy',	'msgg',	'',	NULL,	0,	1,	0,	0,	0,	0,	'2022-07-29 10:51:31',	'2022-07-29 10:51:31',	'2022-07-29 10:51:31'),
(13,	8,	10,	'subject to ahamad and samir',	'msggg here\r\nthnxx',	'1659085175-profile-icon-png-909.png, 1659085175-1657797095-hesta_mail (1).sql, 1659085175-hesta_mail (1).sql',	NULL,	0,	0,	0,	0,	0,	0,	'2022-07-31 10:52:35',	'2022-07-31 10:52:35',	'2022-07-31 10:52:35'),
(14,	9,	10,	'subject to ahamad and samir',	'msggg here\r\nthnxx',	'',	'a:3:{s:2:\"to\";s:18:\"ahamad@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	1,	0,	'2022-07-29 09:42:21',	'2022-07-29 09:42:21',	'2022-07-29 09:42:21'),
(15,	9,	0,	'nn',	'sjdhfjsdfj',	'',	'a:3:{s:2:\"to\";s:9:\"zzzzzzzzz\";s:2:\"cc\";s:18:\"ahamad@mailman.com\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	1,	0,	'2022-07-29 10:07:34',	'2022-07-29 10:07:34',	'2022-07-29 10:07:34'),
(16,	9,	0,	'testing',	'',	'',	'a:3:{s:2:\"to\";s:10:\"sdgsdf@shg\";s:2:\"cc\";s:18:\"ahamad@mailman.com\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 10:06:24',	'2022-07-29 10:06:24',	'2022-07-29 10:06:24'),
(17,	9,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:8:\"sdjhsjdf\";s:2:\"cc\";s:18:\"ahamad@mailman.com\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 11:18:22',	'2022-07-29 11:18:22',	'2022-07-29 11:18:22'),
(18,	9,	0,	'sumer this side',	'',	'',	'a:3:{s:2:\"to\";s:17:\"sumer@mailamn.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 11:06:45',	'2022-07-29 11:06:45',	'2022-07-29 11:06:45'),
(19,	9,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:6:\"hasdjs\";s:2:\"cc\";s:18:\"ahamad@mailman.com\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 10:06:09',	'2022-07-29 10:06:09',	'2022-07-29 10:06:09'),
(20,	9,	0,	'file draft',	'',	'1659089838-hesta_mail (1).sql, 1659089838-—Pngtree—pencil line black icon_3746331.png',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	1,	0,	'2022-07-29 10:17:41',	'2022-07-29 10:17:41',	'2022-07-29 10:17:41'),
(21,	9,	0,	'file attach',	'',	'1659090575-black-friday-spaceman-astronaut-with-alarm-clock-3d-illustration-design.jpg, 1659090575-profile.png',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 10:29:35',	'2022-07-29 10:29:35',	'2022-07-29 10:29:35'),
(22,	9,	0,	'sub',	'msggg',	'',	'a:3:{s:2:\"to\";s:3:\"sub\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-07-29 11:38:31',	'2022-07-29 11:38:31',	'2022-07-29 11:38:31'),
(23,	9,	9,	'Trim',	'msgg',	'1659091092-pngfind.com-rocket-ship-png-1727191.png, 1659091092-360_F_476400933_A4gKwXtlgQFslfSuDvbV35eQcBIDlYjw.jpg, 1659091092-profile-icon-png-909.png, 1659091092-1657797095-hesta_mail (1).sql, 1659091092-hesta_mail (1).sql, 1659091092-—Pngtree—pencil line black icon_3746331.png',	NULL,	0,	1,	0,	0,	0,	0,	'2022-07-29 11:03:22',	'2022-07-29 11:03:22',	'2022-07-29 11:03:22'),
(24,	9,	8,	'sammy testing',	'mmsggg',	'',	NULL,	0,	1,	1,	0,	0,	0,	'2022-07-29 11:19:01',	'2022-07-29 11:19:01',	'2022-07-29 11:19:01'),
(25,	8,	9,	'sammy in CC and BCC',	'msgg',	'1659092695-mail-outline-glyph-icon-workspace-sign-graph-symbol-for-your-web-site-design-logo-app-ui-vector-illustration-eps10-2GY7484.jpg, 1659092695-rocket-ship-png-1727191.png, 1659092695-pngfind.com-rocket-ship-png-1727191.png, 1659092695-360_F_476400933_A4gKwXtlgQFslfSuDvbV35eQcBIDlYjw.jpg, 1659092695-profile-icon-png-909.png',	NULL,	0,	1,	0,	1,	0,	0,	'2022-07-29 11:18:40',	'2022-07-29 11:18:40',	'2022-07-29 11:18:40'),
(26,	9,	9,	'filess',	'msggg',	'1659094813-pngtree-send-and-receive-mail-clipart-vector-png-element-png-image_1725600.jpg',	NULL,	0,	1,	0,	0,	0,	0,	'2022-07-29 11:40:16',	'2022-07-29 11:40:16',	'2022-07-29 11:40:16'),
(27,	9,	8,	'filess testingggggg',	'itss msggg',	'1659094898-pngtree-mail-vector-icon-email-address-png-image_8299575.png, 1659094898-mail-outline-glyph-icon-workspace-sign-graph-symbol-for-your-web-site-design-logo-app-ui-vector-illustration-eps10-2GY7484.jpg, 1659094898-rocket-ship-png-1727191.png, 1659094898-pngfind.com-rocket-ship-png-1727191.png, 1659094898-360_F_476400933_A4gKwXtlgQFslfSuDvbV35eQcBIDlYjw.jpg, 1659094898-profile-icon-png-909.png, 1659094898-1657797095-hesta_mail (1).sql, 1659094898-hesta_mail (1).sql, 1659094898-—Pngtree—pencil line black icon_3746331.png, 1659094898-—Pngtree—key vector icon_3791341.png, 1659094898-pngtree-send-and-receive-mail-clipart-vector-png-element-png-image_1725600.jpg, 1659094898-gmail.png',	NULL,	0,	1,	0,	0,	0,	0,	'2022-07-29 11:42:13',	'2022-07-29 11:42:13',	'2022-07-29 11:42:13'),
(28,	10,	9,	'sdfsdfd',	'asdasd',	'1659333936-astronaut-with-pencil-pen-tool-created-clipping-path-included-jpeg-easy-composite.jpg',	NULL,	0,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 06:05:36',	NULL),
(30,	10,	8,	'this is subject',	'sdfsdf',	'1659338993-hesta_mail (1).sql',	NULL,	0,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 07:29:53',	NULL),
(31,	10,	0,	'',	'',	'1659346922-gmail.png, 1659346775-—Pngtree—pencil line black icon_3746331.png, 1659339025-SRS Mailman.pdf',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	'2022-08-01 09:42:02',	'2022-08-01 09:42:02',	'2022-08-01 09:42:02'),
(32,	10,	0,	'',	'',	'1659339049-SRS Mailman.pdf, 1659339049-rocket-19654.png',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	0,	0,	'2022-08-01 07:31:31',	'2022-08-01 07:31:31',	'2022-08-01 07:31:31'),
(33,	10,	0,	'',	'',	'',	'a:3:{s:2:\"to\";s:16:\"sdfs@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 08:11:25',	NULL),
(34,	10,	0,	'',	'',	'1659346984-profile.png',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 09:43:04',	NULL),
(35,	10,	0,	'',	'msssggg',	'',	'a:3:{s:2:\"to\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 09:47:57',	NULL),
(37,	10,	9,	'email chech',	'msgg',	'1659347429-profile.png, 1659347429-SRS Mailman.pdf, 1659347429-rocket-19654.png, 1659347429-pngfind.com-rocket-png-3268963 (1).png, 1659347429-pngfind.com-rocket-png-3268963.png, 1659347429-pngtree-mail-vector-icon-email-address-png-image_8299575.png, 1659347429-mail-outline-glyph-icon-workspace-sign-graph-symbol-for-your-web-site-design-logo-app-ui-vector-illustration-eps10-2GY7484.jpg',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 09:55:42',	'2022-08-01 09:55:42',	'2022-08-01 09:55:42'),
(39,	10,	9,	'Checking again draft',	'msgg',	'',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:03:14',	'2022-08-01 10:03:14',	'2022-08-01 10:03:14'),
(41,	10,	11,	'again file check',	'msgg',	'1659348305-—Pngtree—pencil line black icon_3746331.png, 1659348305-—Pngtree—key vector icon_3791341.png, 1659348305-pngtree-send-and-receive-mail-clipart-vector-png-element-png-image_1725600.jpg',	NULL,	0,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:05:05',	NULL),
(43,	9,	11,	'Direct mail to  vijay',	'Msg',	'',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:08:34',	'2022-08-01 10:08:34',	'2022-08-01 10:08:34'),
(46,	10,	11,	'checking for  sent',	'msgg',	'1659348871-gmail.png, 1659348871-104069.png',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:23:53',	'2022-08-01 10:23:53',	'2022-08-01 10:23:53'),
(47,	10,	9,	'sssss',	'mmmm',	'1659349500-MailMan Wireframe.pdf, 1659349500-agree-gd670af1da_1920.jpg, 1659349491-MailMan Wireframe.pdf, 1659349491-agree-gd670af1da_1920.jpg',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:25:10',	'2022-08-01 10:25:10',	'2022-08-01 10:25:10'),
(49,	10,	9,	'One',	'msggg \r\ngoes\r\nhere \r\n\r\nthnxx',	'1659349653-gmail.png, 1659349653-104069.png, 1659349603-gmail.png, 1659349603-104069.png',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:27:39',	'2022-08-01 10:27:39',	'2022-08-01 10:27:39'),
(50,	10,	9,	'multiple email',	'msgg',	'1659349745-MailMan Wireframe.pdf, 1659349745-agree-gd670af1da_1920.jpg',	'a:3:{s:2:\"to\";s:17:\"samir@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	1,	0,	0,	0,	'2022-08-01 10:30:45',	'2022-08-01 10:30:45',	'2022-08-01 10:30:45'),
(51,	10,	9,	'multiple email',	'msgg',	'1659349758-MailMan Wireframe.pdf, 1659349758-agree-gd670af1da_1920.jpg, 1659349745-MailMan Wireframe.pdf, 1659349745-agree-gd670af1da_1920.jpg',	NULL,	0,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:29:18',	NULL),
(52,	10,	9,	'My Testing',	'msgggg',	'1659349933-MailMan Wireframe.pdf, 1659349933-agree-gd670af1da_1920.jpg',	'a:3:{s:2:\"to\";s:17:\"samir@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:32:13',	NULL),
(54,	10,	9,	'myyyyyy testttt',	'msgg',	'1659349993-rocket-ship-png-1727191.png, 1659349993-profile-icon-png-909.png',	NULL,	0,	1,	0,	0,	0,	0,	'2022-08-01 10:38:45',	'2022-08-01 10:38:45',	'2022-08-01 10:38:45'),
(55,	10,	0,	'',	'',	'1659350840-profile.png, 1659350840-SRS Mailman.pdf',	'a:3:{s:2:\"to\";s:16:\"sdfs@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:47:20',	NULL),
(56,	10,	9,	'',	'',	'1659350918-profile.png, 1659350918-SRS Mailman.pdf',	'a:3:{s:2:\"to\";s:17:\"samir@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:48:38',	NULL),
(57,	10,	0,	'',	'',	'1659351478-profile.png, 1659351478-SRS Mailman.pdf',	'a:3:{s:2:\"to\";s:16:\"sdfs@mailman.com\";s:2:\"cc\";s:0:\"\";s:3:\"bcc\";s:0:\"\";}',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-01 10:57:58',	NULL);

INSERT INTO `email_trash` (`id`, `inbox_id`, `send_id`, `draft_id`, `table_id`, `permanent_deleted`, `deleted_at`) VALUES
(1,	1,	NULL,	NULL,	NULL,	0,	'2022-07-02 13:36:22'),
(2,	5,	NULL,	NULL,	NULL,	0,	'2022-07-02 19:07:08'),
(3,	NULL,	NULL,	3,	NULL,	0,	'2022-07-02 19:08:47'),
(4,	NULL,	3,	NULL,	NULL,	0,	'2022-07-02 19:09:11'),
(5,	NULL,	6,	NULL,	NULL,	0,	'2022-07-02 19:09:11'),
(6,	3,	NULL,	NULL,	1,	0,	'2022-07-02 19:27:04'),
(7,	4,	NULL,	NULL,	1,	0,	'2022-07-02 19:27:04'),
(8,	NULL,	1,	NULL,	2,	0,	'2022-07-02 19:27:08'),
(9,	NULL,	NULL,	6,	3,	0,	'2022-07-02 19:27:10');

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

INSERT INTO `users` (`id`, `username`, `user_email`, `firstname`, `lastname`, `password`, `secondary_email`, `user_image`, `status`, `created_at`, `updated_at`) VALUES
(8,	'sammy99',	'Sammy@mailman.com',	'Sammy',	'Sammy',	'$2y$10$P9rg4sS7teAJZhMn/POk.OLXOmU.Uf2iUvU1cGk9qWmHYFTrTxGwS',	'samirhestabit99@gmail.com',	'',	1,	NULL,	NULL),
(9,	'samir99',	'samir@mailman.com',	'Samir',	'Ahamad',	'$2y$10$0PAGlEQEUWubycvdBDoKtuOqdg2KLFck4bRKbV9RXvmdXIEgp4342',	'samirhestabit999@gmail.com',	'',	1,	NULL,	NULL),
(10,	'ahamad99',	'ahamad@mailman.com',	'ahmad',	'shah',	'$2y$10$IRQkgDjc57./mGGJueV7OO9vPQ2/VTZjQz8kUBgOSVyFPtlQcNk9C',	'samirahamad999@gmail.com',	'1659019468-black-friday-spaceman-astronaut-with-alarm-clock-3d-illustration-design.jpg',	1,	'2022-07-28 14:44:28',	'2022-07-28 14:44:28'),
(11,	'vijay99',	'vijay@mailman.com',	'vijay',	'pal',	'$2y$10$hXLT/k/GJ77UHG.3Mr5d/uEhzeoiCOQZmzNx4QOeoo6ucvs120pKq',	'vijay@gmail.com',	'',	1,	NULL,	NULL),
(12,	'manish99',	'manish@mailman.com',	'manish',	'kumar',	'$2y$10$Pt.is9iJjDWalmqX01ObF..daRfzyMGzUK4Uv5qo/edHGy7SpnxQ.',	'manish@gmail.com',	'',	1,	NULL,	NULL),
(13,	'samir999',	'anad@mailman.com',	'anand',	'anand',	'$2y$10$55D1A126nEUT7UTTBddJsuahI.rSHdqPqZcOW2vQ1O.SQiQVSqW5.',	'anand@gmail.com',	'',	1,	NULL,	NULL),
(25,	'xakabase21',	'vybovawejo@mailman.com',	'Alan',	'Lloyd',	'$2y$10$Mi0h5ofGRD8HGz8nrkyYmuCvN2h/fMvFJcgFfkjwtVLz7xz7NZ/Dm',	'vybovawejo@yahoo.com',	'',	1,	NULL,	NULL),
(26,	'pinusolapo12',	'vafyq@mailman.com',	'Sopoline',	'Frederick',	'$2y$10$E14dVVqLPU6Kk1aDv30vleLcSs5GWMWr3lEGZ0TuLiJLlFrJreTwy',	'vafyq_99@gmail.com',	'',	1,	NULL,	NULL),
(27,	'ahamad9999',	'ahamadd@mailman.com',	'Clare',	'Livingston',	'$2y$10$eWy2WBlMv.FGYR3.9pIBl.6lviR25ByBNZ8aMHCmIa/PlRGGPcgu.',	'wymo@gmail.com',	'',	1,	NULL,	NULL),
(28,	'sesopyq55',	'wunolajys@mailman.com',	'sdfdf',	'Thornton',	'$2y$10$Tl1X4V45smgI3ZJwgj.xVuYJy/XtK9DbJ2oVYG54/rI1FzyQ6ORMq',	'wunolajys@gmail.com',	'',	1,	NULL,	NULL);

-- 2022-08-04 05:26:48
