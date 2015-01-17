<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
   CClientScript::POS_READY);	
?>
<div class="catalog-category">
	<h1><span>Результаты подбора</span></h1>
	<?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="flash-success">
            <?php  echo Yii::app()->user->getFlash('success');?>
        </div>
    <?php endif; ?>
	<?php $this->widget('application.modules.catalog.components.SearchboxWidget', array('params' => $params));?>		
	<div class="products">
		<?php $this->widget('zii.widgets.CListView', array(
			'id'=>'product-list',
			'dataProvider'=>$dataProvider,
			'ajaxUpdate'=>false,
			'template'=>'{items}',
			'itemView'=>'_productview',
			'emptyText'=>'Животных не найдено',
		)); ?>
	</div>
	<div class="clear"></div>
</div>