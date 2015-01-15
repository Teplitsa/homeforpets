<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('complectation_id')); ?>:</b>
	<?php echo CHtml::encode($data->complectation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_correction')); ?>:</b>
	<?php echo CHtml::encode($data->price_correction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correction_type')); ?>:</b>
	<?php echo CHtml::encode($data->correction_type); ?>
	<br />


</div>