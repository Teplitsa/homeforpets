<div class="fotoport">
    <?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'phoneback-form',
		'action' => '/callback/default/phoneback'
	)); ?>
    <table id="form">
        <tr>
	        <td class="form_lable"></td>
            <td class="form_title">
				<?php echo $form->errorSummary($model); ?>
                Все поля обязательны для заполнения
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'name'); ?></td>
            <td><?php echo $form->textField($model, 'name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'company'); ?></td>
            <td><?php echo $form->textField($model, 'company'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'phone'); ?></td>
            <td><?php echo $form->textField($model, 'phone'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td class="button"><?php echo CHtml::submitButton('Отправить', array('class'=>'send')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>