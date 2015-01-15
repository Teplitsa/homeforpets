<?
$cs=Yii::app()->clientScript;

// Скрипт для отображения рейтинга
$cs->registerScriptFile('/js/jquery.rating.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.rating.css');

$cs->registerScript('rating', "
    $('div.rating').rating({
        image: '/css/img/stars-16.png',
        width: 16,
        readOnly: true
    });

", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
   CClientScript::POS_READY);	
?>
<h1>Результаты подбора товаров</h1>
	<?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="flash-success">
            <?php  echo Yii::app()->user->getFlash('success');?>
        </div>
        <?php endif; ?>
<?	$this->widget('application.modules.catalog.components.SearchboxWidget', array(
                                                                                     //'view'=>'searchboxright',
                                                                                      'selectionParameters'=>$selectionParameters,
                                                                                     // 'selectedProd'=>$this->productsToShow,
                                                                                     //'category'=>$this->category,
                                                                                     
                                                                                   ));
        ?>		
<div class="products">

    <?php $this->widget('zii.widgets.CListView', array(
        'id'=>'product-list',
        'dataProvider'=>$dataProvider,
		'ajaxUpdate'=>false,
        'template'=>'
			
			<div class="clear"></div>
			{items}
			<div class="clear"></div>
			{pager}
		',
        'itemView'=>'_productview',
		'pagerCssClass'=>'pager',
		'pager'=>array(
			'cssFile'=>'/css/style.css',
			'header'=>'',
			'prevPageLabel'=>'&#9668;',
			'nextPageLabel'=>'&#9658;',
			'firstPageLabel'=>'<<',
			'lastPageLabel'=>'>>',
		),
        'emptyText'=>'',
    )); ?>
	
	
</div>