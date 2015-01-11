<div class="h1bg">
    <div class="h1pic">
        <h1>Отправка сообщения администрации сайта</h1>
    </div>
</div>

<?php if (Yii::app()->user->hasFlash('callback_message')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('callback_message'); ?>
</div>
<?php else: ?>
    <?php $this->renderPartial('_form', array('model' => $model));?>
<?php endif; ?>
