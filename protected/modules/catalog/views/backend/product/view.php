<?

$cs=Yii::app()->clientScript;
//Подключаем специальный css
$cs->registerCssFile('/css/catalog/admin/catalog_admin.css');

// Подключаем фанси-бокс
$cs->registerScriptFile('/js/jquery.fancybox.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/fancybox/jquery.fancybox.css');

Yii::app()->clientScript->registerScript('images', "
  $('a[rel=example_group]').fancybox({
		openEffect  : 'none',
		closeEffect	: 'none',
		helpers : {
			overlay : {
				locked : false
			}
		}
	});
", CClientScript::POS_READY);

// Показать-скрыть
$cs->registerScript('showhide', "
  $('a.showhide').click(function(){
      if ( $(this).next().css('display') == 'none' ) {
            $(this).next().animate({height: 'show'}, 400);
            $(this).text('Скрыть');
      } else {
            $(this).next().animate({height: 'hide'}, 200);
            $(this).text('Показать');
      }
		return false;
	});
", CClientScript::POS_READY);

// Показать-скрыть (добавление сопутствующих товаров)
$cs->registerScript('shadd', "
  $('a.shadd').click(function(){
      if ( $(this).next().css('display') == 'none' ) {
            $(this).next().animate({height: 'show'}, 400);
      } else {
            $(this).next().animate({height: 'hide'}, 200);
      }
		return false;
	});
", CClientScript::POS_READY);

?>
<h1><?php echo $model->title; ?></h1>
<?echo CHtml::link('Просмотр на сайте', $model->fullLink, array('class'=>'view_on_site', 'target'=>'_blank'));?>
<?echo CHtml::link('Редактировать животное', array('update', 'id'=>$model->id), array('class'=>'add_element'));?>
<?//echo CHtml::link('Создать дубликат животного', array('duplicate', 'id'=>$model->id), array('class'=>'add_element'));?>
<div class="osn_photo">
    <h2>Основное фото</h2>
    <?php
        if($model->photo){
            echo CHtml::link(CHtml::image('/upload/catalog/product/medium/' . $model->photo, $model->title, array('width' => '30%')) , array('/upload/catalog/product/' . $model->photo), array('rel' => 'example_group'));
        } else{echo CHtml::image('/images/nophoto.jpg', $model->title, array('width' => '30%'));}
    ?>
</div>
<div class="dop_photo">
    <?php if ($model->catalogImages): ?>
		 <h2>Дополнительные фото</h2>
		<?php foreach ($model->catalogImages as $image) :?>
        <?php echo CHtml::link(CHtml::image('/upload/catalog/product/moreimages/small/' . $image->image, $model->title), '/upload/catalog/product/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
        <?php
            endforeach;
        endif; ?>
</div>
<div class="clear"></div>
<table class="viewinfo">
    <tr>
        <td>Город:</td><td><?php echo $model->city;?></td>
    </tr>
    <tr>
        <td>Возраст:</td><td><?php echo $model->getAgeDesc();?></td>
    </tr>
    <tr>
        <td>Пол:</td><td><?php echo $model->getSexDesc();?></td>
    </tr>
    <tr>
        <td>Стерилизация и прививки:</td><td><?php echo $model->getMedDesc();?></td>
    </tr>
    <tr>
        <td>Отображение на сайте:</td><td><? echo ($model->hide ? 'Нет' : 'Да');?></td>
    </tr>
    <tr>
        <td>Количество просмотров:</td><td><?php echo (int)$model->views;?></td>
    </tr>
</table>
<h3>Описание</h3>
<a href="#" class="showhide">Показать</a>
<div style="display: none;"><?=$model->description;?></div>