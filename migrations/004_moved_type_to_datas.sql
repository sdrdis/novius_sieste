ALTER TABLE  `novius_sieste_datas` ADD  `data_type` SET(  'periodic',  'boom',  'boom_from_others' ) NOT NULL;
ALTER TABLE `novius_sieste_sets` DROP `set_type`;