<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cursetorub')); ?>:</b>
	<?php echo CHtml::encode($data->cursetorub); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prefix')); ?>:</b>
	<?php echo CHtml::encode($data->prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('beforeprefix')); ?>:</b>
	<?php echo CHtml::encode($data->beforeprefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('curseauto')); ?>:</b>
	<?php echo CHtml::encode($data->curseauto); ?>
	<br />


</div>