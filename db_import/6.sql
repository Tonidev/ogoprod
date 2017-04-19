INSERT INTO `album` (`id`, `name`, `description`, `status`, `date`, `chpu`) VALUES (13, 'Команда', 'Фото для розділу "Команда"', '5', CURRENT_TIMESTAMP, 'komanda');
INSERT INTO `photo` (`id`, `id_album`, `url`, `url_mini`, `description`, `timestamp`, `status`, `position`) VALUES
  (76, 13, '/img/team/vad.jpg', '/img/team/vad-mini.jpg', 'Вадим Оголяр', '2017-04-18 18:29:08', 1, 1),
  (77, 13, '/img/team/arch.jpg', '/img/team/arch-mini.jpg', 'Арчіл Сванидзе', '2017-04-18 18:29:42', 1, 2),
  (78, 13, '/img/team/anna.jpg', '/img/team/anna-mini.jpg', 'Анна Vie', '2017-04-18 18:30:15', 1, 3);
