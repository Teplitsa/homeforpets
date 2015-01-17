<h2>Здравствуйте, с сайта <a href="<?php echo $this->createAbsoluteUrl('/');?>">&laquo;<?php echo CHtml::encode(Yii::app()->config->sitename); ?>&raquo;</a> отправлено предложение животного.</h2>
<p>
	<b>Имя куратора:</b> <?php echo $product->curator_name; ?>
	<br/>
	<b>Телефон куратора:</b> <?php echo $product->curator_phone; ?>
	<br/>
	<br/>
	<b>Вид животного:</b> <?php echo $product->getCategoryTitle(); ?>
	<br/>
	<b>Кличка:</b> <?php echo $product->title; ?>
	<br/>
	<b>Возраст:</b> <?php echo $product->getAgeDesc(); ?>
	<br/>
	<b>Пол:</b> <?php echo $product->getSexDesc(); ?>
	<br/>
	<b>Город:</b> <?php echo $product->city; ?>
	<br/>
	<b>Условия проживания:</b> <?php echo $product->getTermsDesc(); ?>
	<br/>
	<b>Стерилизация и прививки:</b> <?php echo $product->getMedDesc(); ?>
	<?php if ($product->id_category == 1): ?>	
	<br/>
	<b>Цвет(Окрас):</b> <?php echo $product->color; ?>
	<?php elseif ($product->id_category == 2): ?>	
	<br/>
	<b>Размер:</b> <?php echo $product->size; ?>
	<?php endif; ?>
</p>
