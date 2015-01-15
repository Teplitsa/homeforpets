<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('/js/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.fancybox-1.3.4.css');

Yii::app()->clientScript->registerScript('images', "
	$('.previews a').click(function(){

	    var Medium = $(this).attr('href');
	    var path=$(this).children('img').attr('src');
		parts = path.split( '/' );
		var Input = parts[parts.length-1];
		var big='';
		for(i=1; i<=parts.length-3; i++){
		    big=big+'/'+parts[i];
		}
		big=big+'/'+Input;

		$('a#bigPhoto').attr({ href: big});
		$('a#bigPhoto').find('img').attr({ src: Medium});
		return false;
	});

  $('a[rel=example_group]').fancybox({
		overlayShow: true,
		overlayOpacity: 0.5,
		zoomSpeedIn: 300,
		zoomSpeedOut:300
	});
", CClientScript::POS_READY);

?>
<div class="catalog-category">
	<div class="product-view">
		<h1><span><?php echo $model->title; ?></span></h1>
		<div class="left">
			<div class="image">
				<?php echo CHtml::link(CHtml::image('/upload/catalog/product/medium/' . $model->photo, $model->title) , array('/upload/catalog/product/' . $model->photo), array('rel'=>'example_group')); ?>
			</div>
			<?php if (isset($model->catalogImages)): $k = 0;?>
				<div class="previews">
					<?php foreach ($model->catalogImages as $image): $k++;?>
						<?php echo CHtml::link(CHtml::image('/upload/catalog/product/moreimages/medium/' . $image->image, $model->title), '/upload/catalog/product/moreimages/' . $image->image, array('rel'=>'example_group')); ?>
						<?php if ($k == 4) break; ?> 
					<?php endforeach; ?>
				</div>		
			<?php endif; ?> 
		</div><div class="right">
			<div class="title"><?php echo $model->title;?></div>
			<div class="age"><?php echo $model->getAgeDesc();?></div>
			<div class="sex"><?php echo $model->getSexDesc();?></div>
			<div class="city">г. <?php echo $model->city;?></div>
			<?php if ($medDesc = $model->getMedDesc()): ?>
				<div class="med"><?php echo $medDesc;?></div>
			<?php endif; ?> 
			<?php if ($termDesc = $model->getTermsDesc()): ?>
				<div class="terms"><?php echo $termDesc;?></div>
			<?php endif; ?>
			<div class="track-line"></div>
			<h3>Куратор и передержка</h3>
			<?php if ($model->curator_name): ?>
				<div class="cur"><?php echo $model->curator_name;?></div>
			<?php endif; ?>
			<?php if ($model->curator_phone): ?>
				<div class="phone"><?php echo $model->curator_phone;?></div>
			<?php endif; ?>
			<?php if ($model->owner_name): ?>
				<div class="cur"><?php echo $model->owner_name;?></div>
			<?php endif; ?>
			<?php if ($model->owner_phone): ?>
				<div class="phone"><?php echo $model->owner_phone;?></div>
			<?php endif; ?>
			<?php if ($attrs = $model->outAttrs()): $k = 0;?>
			<table>
				<tr>
				<?php foreach($attrs as $attr): ?>
					<?php 
						$value = "";
						if (is_array($attr['value']))
							$value = implode(', ', $attr['value']);
						else
							$value = $attr['value'];
					?>
					<?php if ($value): $k++;?>
						<td class="label"><?php echo $attr['title'];?></td>
						<td class="value"><?php echo $value; ?></td>				    
						<?php if ($k % 2 == 0): ?>
							</tr><tr>
						<?php else: ?>
							<td class="empty"></td>
						<?php endif; ?>
					 <?endif;?>
				<?php endforeach?>
				</tr>
			</table>
			<?php endif; ?>   
			<a href="/styles" class="s-btn">Добавить в избранное</a><br/>
			<a href="/styles" class="s-btn">Перезвонить мне</a>
		</div>
		<div class="clear"></div>
		<div class="info">
		<?if ($model->description):?>
			<h2>История питомца:</h2>
			<?php echo $model->description; ?>
		<?endif;?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
