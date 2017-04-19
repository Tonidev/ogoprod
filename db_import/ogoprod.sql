SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `admin` (
  `login` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`login`, `pass`) VALUES
('admin', 'f6fdffe48c908deb0f4c3bd36c032e72');

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chpu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chpu` (`chpu`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_photo` int(11) NOT NULL,
  `avatar` text,
  `author` text NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `vk_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) DEFAULT NULL,
  `url` text,
  `url_mini` text,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `chpu` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `content` text,
  `id_photo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_url_uindex` (`chpu`),
  KEY `post_photo_id_fk` (`id_photo`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `promo_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `email` text,
  `phone` text,
  `name` text,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `vk_id` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


INSERT INTO `album` (`id`, `name`, `description`, `status`, `date`, `chpu`) VALUES (13, 'Команда', 'Фото для розділу "Команда"', '5', CURRENT_TIMESTAMP, 'komanda');
INSERT INTO `photo` (`id`, `id_album`, `url`, `url_mini`, `description`, `timestamp`, `status`, `position`) VALUES
  (53, 0, '/photo/0/53.jpg', '/photo/0/53.min.jpg', '', '2017-04-13 16:26:26', 1, 1),
  (54, 0, '/photo/0/54.jpg', '/photo/0/54.min.jpg', '', '2017-04-13 16:31:04', 1, 1),
  (76, 13, '/img/team/vad.jpg', '/img/team/vad-mini.jpg', 'Вадим Оголяр', '2017-04-18 18:29:08', 1, 1),
  (77, 13, '/img/team/arch.jpg', '/img/team/arch-mini.jpg', 'Арчіл Сванідзе', '2017-04-18 18:29:42', 1, 2),
  (78, 13, '/img/team/anna.jpg', '/img/team/anna-mini.jpg', 'Анна Vie', '2017-04-18 18:30:15', 1, 3);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
