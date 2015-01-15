<?
// Скрипт для открытия-закрытия части формы
$cs=Yii::app()->clientScript;
$cs->registerScript('pricecorr', "
  $('#typelist').change(function(){
      if ( $(this).val()==1) {
            $('#pricecorr').show();
            $('#list_type').hide();
      } else {
            $('#pricecorr').hide();
            $('#list_type').show();
      }
	    return false;
	});
", CClientScript::POS_READY);
$cs->registerScriptFile('/js/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#complTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);
?>
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-complectation-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('id'=>'complTitle','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('id'=>'slug','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->types, array('id'=>'typelist')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

    <div id="pricecorr" <?if(isset($model->type) && $model->type<>1) echo 'style="display: none;"';?>>
			
		<div class="row">
			<?php echo $form->labelEx($model,'article'); ?>
			<?php echo $form->textField($model,'article',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'article'); ?>
		</div>

        <div class="row">
            <?php echo $form->labelEx($model,'correction_type'); ?>
            <?php echo $form->dropDownList($model,'correction_type', $model->correctionTypes); ?>
            <?php echo $form->error($model,'correction_type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'price_correction'); ?>
            <?php echo $form->textField($model,'price_correction'); ?>
            <?php echo $form->error($model,'price_correction'); ?>
        </div>

    </div>

    <div id="list_type" <?if(isset($model->type) && $model->type<>2) echo 'style="display: none;"';?>>

        <div class="row">
            <?php echo $form->labelEx($model,'display_type'); ?>
            <?php echo $form->dropDownList($model,'display_type', $model->displayTypes); ?>
            <?php echo $form->error($model,'display_type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'hide_notused'); ?>
            <?php echo $form->checkBox($model,'hide_notused'); ?>
            <?php echo $form->error($model,'hide_notused'); ?>
        </div>

    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->