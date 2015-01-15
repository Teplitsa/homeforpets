<h1>Создание дубликата товара <br/> &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php if (Yii::app()->user->hasFlash('duplicate_message')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('duplicate_message'); ?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('duplicate_errors')): ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('duplicate_errors'); ?>
    </div>

<?php else:?>

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'duplicate-settings-form',
        'enableAjaxValidation'=>false,
    )); ?>


        <?php echo $form->errorSummary($parameters); ?>

        <div class="row">
            <?php echo $form->labelEx($parameters,'photo_duplicate'); ?>
            <?php echo $form->checkBox($parameters,'photo_duplicate'); ?>
            <?php echo $form->error($parameters,'photo_duplicate'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($parameters,'images_duplicate'); ?>
            <?php echo $form->checkBox($parameters,'images_duplicate'); ?>
            <?php echo $form->error($parameters,'images_duplicate'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($parameters,'attributes_duplicate'); ?>
            <?php echo $form->checkBox($parameters,'attributes_duplicate'); ?>
            <?php echo $form->error($parameters,'attributes_duplicate'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($parameters,'complectations_duplicate'); ?>
            <?php echo $form->checkBox($parameters,'complectations_duplicate'); ?>
            <?php echo $form->error($parameters,'complectations_duplicate'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Создать дубликат'); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
<?php endif; ?>