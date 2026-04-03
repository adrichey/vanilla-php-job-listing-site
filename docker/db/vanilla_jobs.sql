SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `vanilla_jobs`;
CREATE DATABASE `vanilla_jobs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `vanilla_jobs`;

DROP TABLE IF EXISTS `listings`;
CREATE TABLE `listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `salary` int(11) NOT NULL,
  `salary_frequency` varchar(45) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `requirements` longtext DEFAULT NULL,
  `benefits` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `listings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `listings` (`id`, `user_id`, `title`, `description`, `tags`, `company`, `salary`, `salary_frequency`, `address`, `city`, `state`, `zip_code`, `phone`, `email`, `requirements`, `benefits`, `created_at`, `updated_at`) VALUES
(1,	1,	'Senior Software Engineer',	'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.',	'C#, .NET, Azure, CI, CD, TDD', 'Dot Net Shoppe',	12000000,	'annually',	'123 Dot Net Rd',	'Redmond',	'WA',	'98033',	'+15559876543',	'dotnetshoppe@fakeemail.com',	'Bachelor\'s in Computer Science or a related field.\r\n\r\n8 years of experience in an object-oriented language.',	'401k with match, HSA, Paid healthcare',	'2026-03-31 19:27:24',	'2026-04-02 16:14:04'),
(2,	1,	'Marketing Specialist',	'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.',	'Marketing, UX, UI, Ad Campaigns, Advertising',	'Ad Agency',	7200000,	'annually',	'98 Agency St',	'Baltimore',	'MD',	'21290',	'+18165551236',	'adagency@fakeemail.com',	'BA in Marketing or Business.\r\n\r\n3 years experience.',	'401K, retreats, paid healthcare',	'2026-03-31 19:27:24',	'2026-04-02 16:14:04'),
(3,	1,	'Web Developer',	'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.',	'PHP, JS, LAMP, Photoshop, Templating',	'Small Dev Agency',	3550,	'hourly',	'31 Hatch Peppet Dr',	'Santa Fe',	'NM',	'87501',	'+18165557777',	'smallagency@fakeemail.com',	'BA in Comp Sci or equivalent work experience. This is an entry-level position, and we are also looking for teachable people.',	'Free snacks and coffee, remote work',	'2026-03-31 19:27:24',	'2026-04-02 16:14:04'),
(4,	1,	'Junior Software Engineer',	'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.',	'Python, OOP, PostgreSQL',	'Big Data Company, LLC',	7500000,	'annually',	'68 Data Way',	'Redmond',	'WA',	'98033',	'+15551234567',	'bigdata@fakeemail.com',	'Bachelor\'s degree, experience with Python',	'401k, free lunch Friday, paid healthcare, unlimited PTO',	'2026-03-31 19:27:24',	'2026-04-02 16:14:04');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `city`, `state`, `zip_code`, `created_at`, `updated_at`) VALUES
(1,	'John Doe',	'user1@fakeemail.com',	'$2y$12$94ciKe0TKSR.yS1VpuygIumOnQehUGCldRY0RtbGhLjBh8Mz9W0VO',	'Baltimore',	'MD',	'21290',	'2026-03-31 19:27:24',	'2026-04-02 16:14:04');
