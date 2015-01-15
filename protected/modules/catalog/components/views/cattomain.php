<?php if ($data->customImage !== null): ?>
<div class="category">
	<div class="image">
		<?php echo CHtml::link(CHtml::image('/images/' . $data->customImage, $data->title), '/catalog/' . $data->link); ?>
	</div>
	<div class="title">
		<?php echo CHtml::link($data->title, '/catalog/'.$data->link); ?>
	</div>
</div>
<?php endif; ?>