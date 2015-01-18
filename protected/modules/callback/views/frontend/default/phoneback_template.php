<p>Здравствуйте, с сайта <a href="<?php echo $this->createAbsoluteUrl('/');?>">&laquo;<?php echo CHtml::encode(Yii::app()->config->sitename); ?>&raquo;</a> поступила просьба перезвонить.</p>
<p><b><u>Данные заявки:</u></b></p>
<p><b>Имя:</b> <?php echo $model->name; ?></p>
<p><b>Контактный телефон:</b> <?php echo $model->phone; ?></p>