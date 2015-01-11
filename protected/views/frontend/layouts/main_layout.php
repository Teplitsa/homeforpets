<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php if ($this->title) echo CHtml::encode($this->title), ' - ', CHtml::encode(Yii::app()->config->sitename);?></title>
	<meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>"/>
	<meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
	<meta name="language" content="ru" />
	<meta name="author" content="<?php echo CHtml::encode(Yii::app()->config->author); ?>"/>
	<link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="inner">
				<div class="top">
					<a href="/" class="logo"><img src="/images/logo.png" alt=""/></a>
					<div class="title"><span class="bullet"></span><?php echo CHtml::encode(Yii::app()->config->sitename); ?></div>
					<div class="phones"><?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'telefony-v-shapke')); ?></div>
				</div>
			</div>
			<div class="banners">
				<div class="banner" style="background-image: url('/images/banner.jpg');"></div>
			</div>
			<div class="inner">
				<div class="bot">
					<div class="menu">
						<?php $this->widget('application.widgets.OutMenu', array('name' => 'main')); ?>
					</div>
					<div class="social">
						<?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'sotsseti-v-shapke')); ?>
					</div>
				</div>
				<div class="line"></div>
			</div>
		</header>
		<div class="content">
			<?php echo $content; ?>
		</div>
		<div class="empty"></div>
	</div>
	<footer>
		<div class="inner">
			<a href="/" class="logo"><img src="/images/logo_footer.png" alt=""/></a>
			<div class="title"><span class="bullet"></span><?php echo CHtml::encode(Yii::app()->config->sitename); ?></div>
			<a href="http://plus1dev.ru/" class="dev"><img src="/images/logo_po.png" alt=""/></a>
		</div>
	</footer>
</body>
</html>