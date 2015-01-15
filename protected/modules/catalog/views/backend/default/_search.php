<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>'/manage/catalog/product/search',
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id',array('maxlength'=>256)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('maxlength'=>256)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'price'); ?>
        <?php echo $form->textField($model,'price',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'id_category'); ?>
        <?php echo $form->dropDownList($model,'id_category', CatalogCategory::getAllCategoriesList(), array('empty'=>'Не важно')); ?>
    </div>


    <div class="row">
        <?php echo $form->label($model,'on_main'); ?>
        <?php echo $form->checkBox($model,'on_main'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Поиск'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->