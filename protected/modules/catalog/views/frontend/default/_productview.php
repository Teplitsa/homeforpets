<?php if ((($index + 1) == 4) or (($index + 1) == 7) or ($index  == 0 and Yii::app()->request->isAjaxRequest)):?>
	<div class="track-line"></div>
<?php endif; ?>
<div class="product<?php echo (($index + 1) % 3 == 0 ? " nm3" : "") . (($index + 1) % 2 == 0 ? " nm2" : "");?>">
	<a href="<?php echo $data->fullLinkFast;?>">
		<div class="image">
        <?php 
			if ($data->photo != '')
                echo CHtml::image('/upload/catalog/product/medium/' . $data->photo, $data->title);
            else
                echo CHtml::image('/images/nophoto.jpg', $data->title);
        ?>
			<?php $favIds = (Yii::app()->session['favorite'] ? Yii::app()->session['favorite'] : array());?>
			<img src="/images/add-fav.png" class="add-favorite" data-id="<?php echo $data->id;?>" alt="Добавить в избранное" title="Добавить в избранное" style="display:<?php echo (in_array($data->id, $favIds) ? 'none' : 'block'); ?>"/>
			<img src="/images/add-fav-hover.png" class="add-favorite-hover" data-id="<?php echo $data->id;?>" alt="Убрать из избранного" title="Убрать из избранного" style="display:<?php echo (in_array($data->id, $favIds) ? 'block' : 'none'); ?>;"/>
		</div>
		<div class="title"><?php echo $data->title;?></div>
		<div class="age"><?php echo $data->getAgeDesc();?></div>
		<div class="sex"><?php echo $data->getSexDesc();?></div>
	</a>
</div>