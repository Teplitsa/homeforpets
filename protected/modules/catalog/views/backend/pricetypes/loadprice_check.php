<?php
    $this->breadcrumbs=array(
        'Каталог'=>array('/catalog'),
        'Загрузка прайс-листа',
    );
?>
<h1>Загрузка прайс-листа</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

        <!--h3>Будут изменены следующие товары:</h3-->

        <?/*php
        $this->widget('ext.admingrid.MyGridView', array(
            'id'=>'changeprice-check-grid',
            'dataProvider'=>$productsProvider,
            'columns'=>array(
                array(
                    'header'=>'Наименование',
                    'type'=>'raw',
                    'name'=>'title',
                    'value'=>'CHtml::link(CHtml::encode($data["title"]), array("product/view", "id"=>$data["id"]))',
                ),
                array('header'=>'Артикул',
                    'name'=>'article',
                ),
                array('header'=>'Валюта',
                    'name'=>'currency',
                ),
                array('header'=>'Старая цена',
                    'name'=>'old_price',
                ),
                array('header'=>'Новая цена',
                    'name'=>'new_price',
                ),
            ),
        ));*/ ?>

		<h3>Не будут изменены следующие товары:</h3>

        <?php
        $this->widget('ext.admingrid.MyGridView', array(
            'id'=>'changeprice-check-grid',
            'dataProvider'=>$productsNoChangeProvider,
            'columns'=>array(
                array(
                    'header'=>'Наименование',
                    'type'=>'raw',
                    'name'=>'title',
                    'value'=>'CHtml::link(CHtml::encode($data["title"]), array("product/view", "id"=>$data["id"]))',
                ),  
				array('header'=>'Артикул',
                    'name'=>'article',
                ),
				array('header'=>'Причина не применения изменений',
                    'name'=>'error',
                ),
            ),
        )); ?>

		<h3>Не будут изменены следующие товары комплектации типа "Флаг":</h3>

        <?php
        $this->widget('ext.admingrid.MyGridView', array(
            'id'=>'changeprice-check-grid',
            'dataProvider'=>$complectNoChangeProvider,
            'columns'=>array(
                array(
                    'header'=>'Товар',
                    'type'=>'raw',
                    'name'=>'product',
                    'value'=>'CHtml::link(CHtml::encode($data["product"]), array("product/view", "id"=>$data["id"]))',
                ),  
				array('header'=>'Наименование',
                    'name'=>'title',
                ),  
				array('header'=>'Артикул',
                    'name'=>'article',
                ), 
				array('header'=>'Причина не применения изменений',
                    'name'=>'error',
                ),
            ),
        )); ?>
		
		<h3>Не будут изменены следующие товары комплектации типа "Список":</h3>

        <?php
        $this->widget('ext.admingrid.MyGridView', array(
            'id'=>'changeprice-check-grid',
            'dataProvider'=>$complectListNoChangeProvider,
            'columns'=>array(
                array(
                    'header'=>'Товар',
                    'type'=>'raw',
                    'name'=>'product',
                    'value'=>'CHtml::link(CHtml::encode($data["product"]), array("product/view", "id"=>$data["id"]))',
                ),  
				array('header'=>'Значение',
                    'name'=>'value',
                ),  
				array('header'=>'Наименование',
                    'name'=>'title',
                ),    
				array('header'=>'Артикул',
                    'name'=>'article',
                ),  
				array('header'=>'Причина не применения изменений',
                    'name'=>'error',
                ),
            ),
        )); ?>
		
        <div class="row buttons">
            <?php echo CHtml::hiddenField('pricetype', $pricetype->id); ?>
            <?php echo CHtml::hiddenField('filename', $filename); ?>
            <?php echo CHtml::submitButton('Применить', array('name'=>'accept')); ?>
            <?php echo CHtml::submitButton('Отмена', array('name'=>'cancel')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>
</div>
