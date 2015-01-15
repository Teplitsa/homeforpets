<div class="product">
	
		
		<?php
			if ($data->image != '') {
				echo CHtml::link(CHtml::image('/upload/catalog/category/small/' . $data->image, $data->title), $this->createUrl('category', array('link'=>$data->link)));
			} else {
				echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), $this->createUrl('category', array('link'=>$data->link)));
			}
		?>
		
		<div class="catname">
			<?php echo CHtml::link($data->title, $this->createUrl('category', array('link'=>$data->link))); ?>
		</div>
	
</div>
