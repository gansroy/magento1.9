<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE {$this->getTable('fyb_window_tiers')}(
  `id` int(10) unsigned NOT NULL auto_increment,
  `min_area_size` decimal(12,4) NOT NULL,
  `max_area_size` decimal(12,4) NOT NULL,
  `price_per_square_meter` decimal(12,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `fyb_window_tiers` (`id`, `min_area_size`, `max_area_size`, `price_per_square_meter`) VALUES
(1, '0.0000', '2.0000', '50.0000'),
(2, '2.0000', '5.0000', '45.0000'),
(3, '5.0000', '9999999.0000', '40.0000');


");

$installer->endSetup(); 
