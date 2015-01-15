<?
// Скрипт для отображения рейтинга
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.rating.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.rating.css');
Yii::app()->clientScript->registerScript('rating', "
    $('div.rating-input').rating({
        image: '/css/img/stars.png',
        click: function(val){
            $('#r-input').val(val);
        }
    });

", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-reviews-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> Обязательные поля.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="open mt15">
	    <div class="addcomment mb5">

                <?php echo $form->labelEx($model,'rating'); ?>
                <div class="field">
                    <div class="rating-input">
                        <input type="hidden" class="val" value="<?=$model->rating;?>"/>

                    </div>
                <?php echo $form->hiddenField($model,'rating', array('id'=>'r-input')); ?>
                <?php echo $form->error($model,'rating'); ?>
                </div>
                <div class="clear"></div>

                <?php echo $form->labelEx($model,'text'); ?>
                <div class="field">
                <?php echo $form->textArea($model,'text',array('size'=>60,'maxlength'=>1000)); ?>
                <?php echo $form->error($model,'text'); ?>
                </div>
                <div class="clear"></div>

                <label for="">&nbsp;</label><div class="field">
                    <table border=0>
                        <tr>
                            <td align="center">
                                <?php $this->widget('CCaptcha', array(
                                    'clickableImage'=>true,
                                    'showRefreshButton'=>false,
                                    'imageOptions'=>array('class'=>'imgpointer'),
                                )); ?>
                            </td>
                            <td width="10px"></td>

                            <td align="left" valign="top">
                                <span class="label">Введите код:</span><br/>
                                    <?php echo $form->textField($model,'verifyCode', array('class'=>'impt')); ?>
                                    <?php echo $form->error($model,'verifyCode'); ?>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="field">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->