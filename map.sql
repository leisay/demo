CREATE TABLE `map` (
  `map_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `map_title` varchar(255) NOT NULL,
  `map_content` text NOT NULL,
  `map_lat` double NOT NULL,
  `map_lng` double NOT NULL,
  `map_zoom` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;