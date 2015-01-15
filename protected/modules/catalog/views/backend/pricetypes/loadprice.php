<?php
    $this->breadcrumbs=array(
        'Каталог'=>array('/catalog'),
        'Загрузка прайс-листа',
    );
?>
<h1>Загрузка прайс-листа</h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="flash-success">
    <?php  echo Yii::app()->user->getFlash('success');?>
</div>
<?php endif?>

<?php if(Yii::app()->user->hasFlash('cancel')):?>
<div class="flash-notice">
    <?php  echo Yii::app()->user->getFlash('cancel');?>
</div>
<?php endif?>

<?php if(Yii::app()->user->hasFlash('error')):?>
<div class="flash-error">
    <?php  echo Yii::app()->user->getFlash('error');?>
</div>
<?php endif?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'catalog-product-form',
        'htmlOptions'=>array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'pricetype'); ?>
        <?php echo $form->dropDownList($model,'pricetype', CatalogPricetypes::getTypelist(), array('empty'=>'Выберите тип прайс-листа')); ?>
        <?php echo $form->error($model,'pricetype'); ?>
    </div>

    <?php echo CHtml::link('Редактировать типы прайс-листов','admin');?>

    <div class="row">
        <?php echo $form->labelEx($model,'filename'); ?>
        <?php echo $form->fileField($model,'filename'); ?>
        <?php echo $form->error($model,'filename'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Загрузить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
