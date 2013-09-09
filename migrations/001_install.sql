CREATE TABLE `novius_sieste_datas` (
  `data_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data_set_id` int(10) unsigned NOT NULL,
  `data_capt_id` int(10) unsigned NOT NULL,
  `data_capt_value` float NOT NULL,
  PRIMARY KEY (`data_id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
