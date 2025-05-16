CREATE TABLE `users` (
     `id` int unsigned NOT NULL AUTO_INCREMENT,
     `first_name` varchar(100) NOT NULL,
     `last_name` varchar(100) NOT NULL,
     `email` varchar(150) NOT NULL,
     `phone` varchar(20) NOT NULL,
     `password` varchar(255) NOT NULL,
     `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`),
     UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci