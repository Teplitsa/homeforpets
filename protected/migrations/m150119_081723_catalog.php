<?php

class m150119_081723_catalog extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("
		
			CREATE TABLE IF NOT EXISTS `catalog_category` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
			  `title` varchar(256) NOT NULL,
			  `long_title` varchar(256) NOT NULL,
			  `link` varchar(256) NOT NULL,
			  `image` varchar(256) DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `product_view` int(1) NOT NULL,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `text` text,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `FK_catalog_category` (`parent_id`),
			  KEY `title` (`title`(255)),
			  KEY `link` (`link`(255))
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

			CREATE TABLE IF NOT EXISTS `catalog_config` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `text` text,
			  `layout` varchar(255) DEFAULT NULL,
			  `cat_perpage` int(11) DEFAULT NULL,
			  `product_perpage` int(11) DEFAULT NULL,
			  `c_image_small_w` int(11) DEFAULT NULL,
			  `c_image_small_h` int(11) DEFAULT NULL,
			  `p_image_middle_w` int(11) DEFAULT NULL,
			  `p_image_middle_h` int(11) DEFAULT NULL,
			  `p_image_small_w` int(11) DEFAULT NULL,
			  `p_image_small_h` int(11) DEFAULT NULL,
			  `watermark_image` varchar(1000) DEFAULT NULL,
			  `watermark_x` int(11) DEFAULT NULL,
			  `watermark_y` int(11) DEFAULT NULL,
			  `no_watermark` int(11) DEFAULT NULL,
			  `attached` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

			CREATE TABLE IF NOT EXISTS `catalog_image` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_product` int(11) unsigned NOT NULL,
			  `image` varchar(256) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `FK_catalog_image` (`id_product`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

			CREATE TABLE IF NOT EXISTS `catalog_product` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_type` int(10) unsigned NOT NULL,
			  `number` varchar(64) NOT NULL,
			  `link` varchar(255) NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `keywords` text NOT NULL,
			  `photo` varchar(255) DEFAULT NULL,
			  `description` text,
			  `id_category` int(11) unsigned NOT NULL,
			  `sort_order` int(11) NOT NULL,
			  `date_added` int(11) NOT NULL,
			  `on_main` int(1) DEFAULT NULL,
			  `recomended` int(1) DEFAULT NULL,
			  `hit` int(1) DEFAULT NULL,
			  `price` float DEFAULT '0',
			  `currency` int(11) NOT NULL,
			  `priceprofile` int(11) DEFAULT NULL,
			  `article` varchar(255) DEFAULT NULL,
			  `old_price` float DEFAULT NULL,
			  `views` int(11) DEFAULT NULL,
			  `brand` int(11) DEFAULT NULL,
			  `brand_collection` int(11) DEFAULT NULL,
			  `hide` int(11) DEFAULT NULL,
			  `noyml` int(11) DEFAULT '1',
			  `state` int(11) NOT NULL,
			  `age_y` int(11) NOT NULL,
			  `age_m` int(11) NOT NULL,
			  `age_w` int(11) NOT NULL,
			  `sex` tinyint(1) NOT NULL,
			  `city` varchar(255) NOT NULL,
			  `medical` tinyint(1) NOT NULL,
			  `terms` tinyint(1) NOT NULL,
			  `curator_name` varchar(255) NOT NULL,
			  `curator_phone` varchar(255) NOT NULL,
			  `owner_name` varchar(255) NOT NULL,
			  `owner_phone` varchar(255) NOT NULL,
			  `attach` tinyint(1) NOT NULL,
			  `color` varchar(255) NOT NULL,
			  `size` varchar(255) NOT NULL,
			  `clear` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `FK_catalog_product` (`id_category`),
			  KEY `brand` (`brand`),
			  KEY `hide` (`hide`),
			  KEY `title` (`title`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			
			INSERT INTO `catalog_config` (`id`, `title`, `keywords`, `description`, `text`, `layout`, `cat_perpage`, `product_perpage`, `c_image_small_w`, `c_image_small_h`, `p_image_middle_w`, `p_image_middle_h`, `p_image_small_w`, `p_image_small_h`, `watermark_image`, `watermark_x`, `watermark_y`, `no_watermark`, `attached`) VALUES
(1, 'Каталог животных', 'Каталог животных', 'Каталог животных', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n', '//layouts/main_layout', 20, 20, 200, 200, 536, 536, 220, 220, 'a716f49112379c4e237e5a224eb3b55f.png', 50, 50, 1, 0);

			
		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("

			DROP TABLE `catalog_category`;
			DROP TABLE `catalog_config`;
			DROP TABLE `catalog_image`;
			DROP TABLE `catalog_product`;

		")->execute();
	}
}