

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usernameHash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailHash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emailHash` (`emailHash`),
  KEY `usernameHash` (`usernameHash`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `accounts` (
  `accountID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountName` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usernameHash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailHash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordHash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`accountID`),
  KEY `userID` (`userID`),
  KEY `usernameHash` (`usernameHash`),
  KEY `emailHash` (`emailHash`),
  KEY `passwordHash` (`passwordHash`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
