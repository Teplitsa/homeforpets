<div class="content2">

	<div class="m7">
        <?php
        $this->breadcrumbs=array(
            'Catalog Reviews'=>array('index'),
            'Create',
        );

        ?>

        <h1>Добавление отзыва</h1>

        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
	</div>

</div>