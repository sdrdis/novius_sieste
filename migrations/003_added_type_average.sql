ALTER TABLE  `novius_sieste_sets` ADD  `set_type` BOOLEAN NOT NULL AFTER  `set_nb_sleeping`;
ALTER TABLE  `novius_sieste_datas` ADD  `data_capt_average` FLOAT NOT NULL AFTER  `data_capt_value`;
ALTER TABLE  `novius_sieste_sets` CHANGE  `set_type`  `set_type` ENUM(  'periodic',  'boom' ) NOT NULL