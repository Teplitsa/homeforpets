<?php

class m150111_124333_base extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("

			CREATE TABLE IF NOT EXISTS `area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

			INSERT INTO `area` (`id`, `name`, `title`) VALUES
			(3, 'telefony-v-shapke', 'Телефоны в шапке'),
			(7, 'preimuschestva-na-glavnoj', 'Преимущества на главной'),
			(8, 'dostupy-na-glavnoj', 'Доступы на главной'),
			(9, 'uslugi-na-glavnoj', 'Услуги на главной'),
			(10, 'sotsseti-v-shapke', 'Соцсети в шапке');

			CREATE TABLE IF NOT EXISTS `area_block` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `area_id` int(11) DEFAULT NULL,
			  `visible` tinyint(1) DEFAULT NULL,
			  `content` text,
			  `view` varchar(255) DEFAULT NULL,
			  `css_class` varchar(255) NOT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `AREA` (`area_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

			INSERT INTO `area_block` (`id`, `name`, `title`, `area_id`, `visible`, `content`, `view`, `css_class`, `sort_order`) VALUES
			(18, 'individualnyj-dizajn', 'Индивидуальный дизайн', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 20),
			(19, 'prostota-upravlenija-sajtom', 'Простота управления сайтом', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 30),
			(17, 'telefony', 'Телефоны', 3, 1, '<div>\r\n	+7(499)674-76-44, +7(8412)250-404</div>\r\n', 'areablocknotitle', '', 10),
			(20, 'vozmozhnost-rasshirenija-funktsionala', 'Возможность расширения  функционала', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit&nbsp;</div>\r\n', 'areablock', '', 40),
			(21, 'garantijnoe-obsluzhivanie', 'Гарантийное обслуживание', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 50),
			(22, 'zagolovok', 'Заголовок', 8, 1, '<h2>\r\n	Здесь можно протестировать панель администратора</h2>\r\n', 'areablocknotitle', '', 60),
			(23, 'login-parol', 'Логин-пароль', 8, 1, '<p>\r\n	Логин:&nbsp;<span>demo</span>&nbsp;&nbsp;Пароль:&nbsp;<span>12345</span></p>\r\n', 'areablocknotitle', '', 70),
			(24, 'sovremennyj-dizajn', 'Современный дизайн', 9, 1, '<div>\r\n	Современный дизайн</div>\r\n', 'areablocknotitle', 'design', 80),
			(25, 'panel-administratora', 'Панель администратора', 9, 1, '<div>\r\n	Панель администратора</div>\r\n', 'areablocknotitle', 'panel', 90),
			(26, 'ustanovka-na-rabochij-hosting', 'Установка на рабочий хостинг', 9, 1, '<div>\r\n	Установка на рабочий хостинг</div>\r\n', 'areablocknotitle', 'hosting', 100),
			(27, 'html-verstka', 'HTML - верстка', 9, 1, '<div>\r\n	HTML - верстка</div>\r\n', 'areablocknotitle', 'makeup', 110),
			(28, 'kontent-menedzhment', 'Контент менеджмент', 9, 1, '<div>\r\n	Контент менеджмент</div>\r\n', 'areablocknotitle', 'management', 120),
			(29, 'tehnicheskaja-podderzhka', 'Техническая поддержка', 9, 1, '<div>\r\n	Техническая поддержка</div>\r\n', 'areablocknotitle', 'support', 130),
			(30, 'odnoklassniki', 'Одноклассники', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 140),
			(31, 'odnoklassniki2', 'Одноклассники2', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 150),
			(32, 'odnoklassniki3', 'Одноклассники3', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 160);

			CREATE TABLE IF NOT EXISTS `callback_config` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `enabled` tinyint(1) NOT NULL,
			  `type` varchar(255) NOT NULL,
			  `host` varchar(255) NOT NULL,
			  `username` varchar(255) NOT NULL,
			  `password` varchar(255) NOT NULL,
			  `port` varchar(255) NOT NULL,
			  `encryption` varchar(255) NOT NULL,
			  `sender` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

			INSERT INTO `callback_config` (`id`, `enabled`, `type`, `host`, `username`, `password`, `port`, `encryption`, `sender`) VALUES
				(1, 1, 'php', '', '', '', '', '', 'Сайт Визитка');

			CREATE TABLE IF NOT EXISTS `config` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
			  `sitename` varchar(255) DEFAULT NULL,
			  `author` varchar(255) DEFAULT NULL,
			  `adminonly` int(11) DEFAULT NULL,
			  `mainpage_id` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

			INSERT INTO `config` (`id`, `sitename`, `author`, `adminonly`, `mainpage_id`) VALUES
				(1, 'Сайт Визитка', 'plusodin-web', 0, 16);

			CREATE TABLE IF NOT EXISTS `menu` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(128) NOT NULL,
			  `name` varchar(128) NOT NULL,
			  `items_template` varchar(255) DEFAULT NULL,
			  `activeitem_class` varchar(255) DEFAULT NULL,
			  `firstitem_class` varchar(255) DEFAULT NULL,
			  `lastitem_class` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `NAME` (`name`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

			INSERT INTO `menu` (`id`, `title`, `name`, `items_template`, `activeitem_class`, `firstitem_class`, `lastitem_class`) VALUES
				(1, 'Главное меню', 'main', '<div class=\"item-layout\"><span class=\"bullet\"></span>{menu}</div>', '', 'home', '');

			CREATE TABLE IF NOT EXISTS `menu_item` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(128) NOT NULL DEFAULT '',
			  `link` varchar(128) NOT NULL DEFAULT '',
			  `parent_id` int(11) NOT NULL,
			  `menu_id` int(11) unsigned NOT NULL,
			  `sort_order` int(11) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `PARENT` (`parent_id`),
			  KEY `MENU` (`menu_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33;

			INSERT INTO `menu_item` (`id`, `title`, `link`, `parent_id`, `menu_id`, `sort_order`) VALUES
				(22, 'О компании', '/about', 0, 1, 80),
			(27, 'Контактная информация', '/contact', 0, 1, 110),
			(28, 'Главная', '/', 0, 1, 20),
			(29, 'Наполнение сайта', '/content', 0, 1, 90),
			(32, 'Услуги', '/service', 0, 1, 100);

			CREATE TABLE IF NOT EXISTS `page` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) unsigned NOT NULL,
			  `link` varchar(128) NOT NULL DEFAULT '',
			  `title` varchar(512) NOT NULL DEFAULT '',
			  `content` longtext,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `view` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `LINK` (`link`),
			  KEY `PARENT` (`parent_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

			INSERT INTO `page` (`id`, `parent_id`, `link`, `title`, `content`, `keywords`, `description`, `layout`, `view`) VALUES
				(16, 0, 'main', 'Главная', '', 'Главная', 'Главная', 'first_page', 'notitle'),
			(28, 0, 'about', 'О кампании', '<p>\r\n	<i>Страница в разработке.</i></p>\r\n', 'О кампании', 'О кампании', 'main', 'view'),
			(30, 0, 'content', 'Наполнение сайта', '<p>\r\n	<em>Страница в разработке.</em></p>\r\n', 'Наполнение сайта', 'Наполнение сайта', 'main', 'view'),
			(36, 0, 'service', 'Услуги', '<p>\r\n	<em>Страница в разработке.</em></p>\r\n', 'Услуги', 'Услуги', 'main', 'view'),
			(37, 0, 'contact', 'Контактная информация', '<p>\r\n	<em>Страница в разработке.</em></p>\r\n', 'Контактная информация', 'Контактная информация', 'main', 'view');

			CREATE TABLE IF NOT EXISTS `tbl_migration` (
				`version` varchar(255) NOT NULL,
			  `apply_time` int(11) DEFAULT NULL,
			  PRIMARY KEY (`version`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `user` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
			  `username` varchar(255) DEFAULT NULL,
			  `email` varchar(255) NOT NULL,
			  `password` varchar(255) DEFAULT NULL,
			  `salt` varchar(255) NOT NULL,
			  `role` varchar(255) DEFAULT NULL,
			  `status` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

			INSERT INTO `user` (`id`, `username`, `email`, `password`, `salt`, `role`, `status`) VALUES
				(1, 'admin', 'dimon9107@yandex.ru', '2656a196fb1f511628fe61365bf596db', '54862c1be6f582.03655350', 'admin', 1);

		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("

			DROP TABLE `area`;
			DROP TABLE `area_block`;
			DROP TABLE `callback_config`;
			DROP TABLE `config`;
			DROP TABLE `menu`;
			DROP TABLE `menu_item`;
			DROP TABLE `page`;
			DROP TABLE `user`;

		")->execute();
	}
}