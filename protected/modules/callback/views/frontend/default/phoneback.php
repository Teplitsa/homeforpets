<div class="h1bg">
    <div class="h1pic">
        <h1>Просьба перезвонить</h1>
    </div>
</div>
<?php if (Yii::app()->user->hasFlash('callback_message')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('callback_message'); ?>
</div>
<?php else: ?>
    <?php $this->renderPartial('_phoneback', array('model'=>$model));?>
<?php endif; ?>