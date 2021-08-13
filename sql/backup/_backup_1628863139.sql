SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE category;

CREATE TABLE `category` (
  `id_category` int(50) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(24) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO category VALUES("1","pemandangan");
INSERT INTO category VALUES("2","pantai");
INSERT INTO category VALUES("3","gunung");
INSERT INTO category VALUES("4","makanan");



DROP TABLE image;

CREATE TABLE `image` (
  `id_image` int(50) NOT NULL,
  `id_user` int(25) DEFAULT NULL,
  `title` varchar(24) DEFAULT NULL,
  `download` int(50) DEFAULT NULL,
  `upload_data` date NOT NULL,
  PRIMARY KEY (`id_image`),
  KEY `image_ibfk_1` (`id_user`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO image VALUES("11521146","895193516","gagal kabur","0","2021-08-12");
INSERT INTO image VALUES("13991180","315980911","Sertifikat VAKSIN","1","2021-08-13");
INSERT INTO image VALUES("34915788","312114908","letmein","1","2021-08-11");



DROP TABLE image_category;

CREATE TABLE `image_category` (
  `id_image` int(50) DEFAULT NULL,
  `id_category` int(50) DEFAULT NULL,
  KEY `image_category_ibfk_2` (`id_image`),
  KEY `image_category_ibfk_3` (`id_category`),
  CONSTRAINT `image_category_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `image_category_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO image_category VALUES("34915788","4");
INSERT INTO image_category VALUES("11521146","2");
INSERT INTO image_category VALUES("13991180","1");



DROP TABLE like_image;

CREATE TABLE `like_image` (
  `id_user` int(25) DEFAULT NULL,
  `id_image` int(50) DEFAULT NULL,
  `like` tinyint(1) DEFAULT NULL,
  KEY `like_image_ibfk_1` (`id_user`),
  KEY `like_image_ibfk_2` (`id_image`),
  CONSTRAINT `like_image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `like_image_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO like_image VALUES("895193516","34915788","1");
INSERT INTO like_image VALUES("312114908","11521146","1");
INSERT INTO like_image VALUES("315980911","13991180","1");



DROP TABLE link_image;

CREATE TABLE `link_image` (
  `id_image` int(50) DEFAULT NULL,
  `temp_img` varbinary(50) NOT NULL,
  `raw_img` varchar(50) NOT NULL,
  KEY `link_image_ibfk_1` (`id_image`),
  CONSTRAINT `link_image_ibfk_1` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO link_image VALUES("34915788","img/temp/34915788temp.jpg","img/raw/34915788raw.jpg");
INSERT INTO link_image VALUES("11521146","img/temp/11521146temp.jpg","img/raw/11521146raw.jpg");
INSERT INTO link_image VALUES("13991180","img/temp/13991180temp.jpg","img/raw/13991180raw.jpg");



DROP TABLE profile;

CREATE TABLE `profile` (
  `id_profile` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` int(25) DEFAULT NULL,
  `fullname` varchar(24) DEFAULT NULL,
  `gender` char(2) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `country` varchar(24) DEFAULT NULL,
  `imgprofile` varchar(30) DEFAULT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_profile`),
  KEY `profile_ibfk_1` (`id_user`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO profile VALUES("11","312114908","sidiq","","888888888888","indonesia","img/profile/312114908.jpeg","2021-08-12 20:06:07");
INSERT INTO profile VALUES("12","895193516","sidiq","","","","","2021-08-12 20:05:51");
INSERT INTO profile VALUES("13","315980911","JuliaditS","","","","img/profile/315980911.png","2021-08-13 16:35:18");
INSERT INTO profile VALUES("14","414376750","aaaa","","","","","2021-08-13 20:55:13");



DROP TABLE user;

CREATE TABLE `user` (
  `id_user` int(25) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('master','client') DEFAULT 'client',
  PRIMARY KEY (`id_user`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO user VALUES("312114908","admin@gmail.com","$2y$10$equawzjsRd02fSJGAS9xau.N3Y4fxzF.81pisdia095AAm39Tnj7C","master");
INSERT INTO user VALUES("315980911","juliadit@email.com","$2y$10$YrA0xEW3OqgHCfLU9BRCSeRDriuFoLNaLeNTP0pPyFmevt8.fUBGy","master");
INSERT INTO user VALUES("414376750","aaaa@gmail.com","$2y$10$YniBXgxWm5xGHvZk/eqX1OcKMf/k6i5.uj3ruJdi8KAqSjQL6HBkO","client");
INSERT INTO user VALUES("895193516","sidiq@gmail.com","$2y$10$xAhw6Dy4AcGZ232EuSn6vOsA8j.RJgaBPIpZtAR8p9C6KNB9Un9TS","client");



SET FOREIGN_KEY_CHECKS = 1;