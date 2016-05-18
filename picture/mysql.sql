CREATE TABLE `google_map_book` (
  `map_sn` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `map_title` varchar(255) NOT NULL,
  `map_content` text NOT NULL,
  `map_lat` double NOT NULL,
  `map_lng` double NOT NULL,
  `map_zoom` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`map_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `google_map_img` (
  `files_sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `col_sn` smallint(5) unsigned NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL,
  `kind` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` mediumint(8) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  PRIMARY KEY (`files_sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;