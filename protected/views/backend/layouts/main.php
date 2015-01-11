<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/screen.css" media="screen, projection" />
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css" />

	<title><?php echo "Панель администратора - " . CHtml::encode(Yii::app()->config->sitename);?></title>
</head>
<body>
	<div id="wrapper">
		<div class="header">
			<div class="header_body">
				<?php echo CHtml::link('', '/manage', array('class' => 'logo')); ?>
				<div class="site_action">
					<?php echo CHtml::link('Просмотр сайта', Yii::app()->homeUrl, array('target' => '_blank')); ?>
				</div>
					<p class="name"><?php echo CHtml::encode(Yii::app()->config->sitename); ?></p>
					<p>Панель администратора</p>
				<div class="mainmenu">
					<div>
					<?php $this->widget('zii.widgets.CMenu',array(
						'items' => array(
							array('label' => 'Информационные страницы', 'url' => array('//page/')),
							array('label' => 'Информационные блоки', 'url' => array('//area/')),
							array('label' => 'Меню', 'url' => array('//menu/')),
							array('label' => 'Выход (admin)', 'url' => array('/main/logout'))
						),
					)); ?>
					</div>
				</div><!-- mainmenu -->
				<div class="clear"></div>
			</div>
		</div>
		<div class="bodyr">
			<div class="container">
				<?php echo $content; ?>
			</div>
		</div>
		<div class="clear"></div>
		<div class="prokladka"></div>
	</div>
	<div class="footer">
		Система управления контентом разработана в <a href="http://plusodin-web.ru">Студии</a>
	</div>
</body>
</html>