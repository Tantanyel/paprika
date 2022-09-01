SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(0, 'admin', '21232f297a57a5a743894a0e4a801fc3');

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `num` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `brends` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `num` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `num` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `zakaz` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tovar` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adr` text COLLATE utf8_unicode_ci NOT NULL,
  `com` text COLLATE utf8_unicode_ci NOT NULL,
  `oplata` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cena` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vipol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `items` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `photo` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `art` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `catalog` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brend` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cena` int(255) NOT NULL,
  `skid` int(255) NOT NULL,
  `opisanie` text COLLATE utf8_unicode_ci NOT NULL,
  `param` text COLLATE utf8_unicode_ci NOT NULL,
  `sostav` text COLLATE utf8_unicode_ci NOT NULL,
  `osncolor` text COLLATE utf8_unicode_ci NOT NULL,
  `colors` text COLLATE utf8_unicode_ci NOT NULL,
  `razm` text COLLATE utf8_unicode_ci NOT NULL,
  `razcol1` text COLLATE utf8_unicode_ci NOT NULL,
  `razcol2` text COLLATE utf8_unicode_ci NOT NULL,
  `razcol3` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `adr` text COLLATE utf8_unicode_ci NOT NULL,
  `map` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `wa` text COLLATE utf8_unicode_ci NOT NULL,
  `viber` text COLLATE utf8_unicode_ci NOT NULL,
  `soc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `contacts` (`id`, `email`, `phone`, `wa` , `viber` , `soc`) VALUES
(0, '123|123|123', '123|123|123', '123|123|123', '123|123|123', '123|123|123');

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `vop` text COLLATE utf8_unicode_ci NOT NULL,
  `otv` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `otz` text COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `otv` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `photo` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `num` int(255) NOT NULL,
  `collection` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `info` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `dost` text COLLATE utf8_unicode_ci NOT NULL,
  `opl` text COLLATE utf8_unicode_ci NOT NULL,
  `voz` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `info` (`id`, `dost`, `opl`, `voz`) VALUES
(0, 'доставка', 'оплата', 'возврат');


CREATE TABLE IF NOT EXISTS `about` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `about` (`id`, `about`) VALUES
(0, 'о нас html');