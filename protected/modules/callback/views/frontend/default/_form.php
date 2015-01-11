<div class="fotoport">
    <?php $form = $this->beginWidget('CActiveForm', array(
                          'id' => 'review-form',
                          'htmlOptions' => array('enctype' => 'multipart/form-data'),
                       'action' => '/callback'
                     )); ?>

    <table id="form">
        <tr>
            <td class="form_lable"></td>
            <td class="form_title">
                Все поля обязательны для заполнения
                <?php echo $form->errorSummary($model); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'name'); ?></td>
            <td><?php echo $form->textField($model, 'name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td><?php echo $form->textField($model, 'email'); ?></td>
        </tr>
        <tr>
            <td class="top"><?php echo $form->labelEx($model, 'text'); ?></td>
            <td><?php echo $form->textArea($model, 'text', array('class' => 'txt', 'rows' => 6, 'cols' => 50)); ?></td>
        </tr>
        <?/*php if (extension_loaded('gd')): ?>
        <tr>
            <td></td>
            <td><? $this->widget('CCaptcha', array('captchaAction'=>'/callback/default/captcha', 'buttonLabel'=>'Обновить картинку'))?></td>
        </tr>
        <tr>

            <td><?=CHtml::activeLabelEx($model, 'verifyCode')?></td>
            <td>

                <?=CHtml::activeTextField($model, 'verifyCode', array('id' => 'captcha'))?>
            </td>

        </tr>
        <?php endif; */?>
        <tr>
            <td></td>
            <td class="button"><?php echo CHtml::submitButton('Отправить сообщение', array('class' => 'send')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
