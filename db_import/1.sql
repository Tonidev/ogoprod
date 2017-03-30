SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `admin` (
  `login` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11)   NOT NULL AUTO_INCREMENT,
  `id_photo` int(11) NOT NULL,
  `avatar` text,
  `author` text NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `vk_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `id_photo`, `avatar`, `author`, `text`, `status`, `vk_id`) VALUES
(1, 3, 'https://pp.userapi.com/c5740/v5740887/7b0/TVJUekjrCjo.jpg', 'Владимipъ Сударьковъ', 'ЕЕЕЕееееееееееееееееЕЕЕЕЕЕЕЕЕЕеееееее\nБОИИИиииииииИИИииииИИИииииИИИИиииииИИИии', 1, ''),
(2, 3, 'https://pp.userapi.com/c5740/v5740887/7b0/TVJUekjrCjo.jpg', 'Владимipъ Сударьковъ', 'ЕЕЕЕееееееееееееееееЕЕЕЕЕЕЕЕЕЕеееееее\nБОИИИиииииииИИИииииИИИииииИИИИиииииИИИии', 1, '');

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) DEFAULT NULL,
  `url` text,
  `url_mini` text,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `photo` (`id`, `id_album`, `url`, `url_mini`, `description`, `timestamp`, `status`) VALUES
(1, NULL, 'http://files.geometria.ru/pics/original/060/185/60185508.jpg', NULL, 'Фото №1 трататата тут типо описание и всё понятно', '2017-03-26 22:32:24', 1),
(2, NULL, 'http://files2.geometria.ru/pics/original/058/021/58021259.jpg', NULL, 'Фото №2 трататата тут типо описание и всё понятно', '2017-03-26 22:32:24', 1),
(3, NULL, 'http://files2.geometria.ru/pics/original/058/021/58021475.jpg', NULL, 'Фото №3 трататата тут типо описание и всё понятно', '2017-03-26 22:32:41', 1);

CREATE TABLE IF NOT EXISTS `promo_code` (
  `code` varchar(64) NOT NULL,
  `email` text,
  `phone` text,
  `name` text,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `vk_id` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
