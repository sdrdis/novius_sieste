CREATE TABLE `novius_sieste_sets` (
  `set_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `set_date` datetime NOT NULL,
  `set_nb_sleeping` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
