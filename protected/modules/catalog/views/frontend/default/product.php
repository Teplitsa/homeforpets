<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.fancybox.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/fancybox/jquery.fancybox.css');

Yii::app()->clientScript->registerScript('images', "
  $('a[rel=example_group]').fancybox({
		openEffect  : 'none',
		closeEffect	: 'none',
		helpers : {
			overlay : {
				locked : false
			}
		}
	});
", CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('catalog-products-fav', "
	
	$(document).on('click', '.add-favorite',function(){
		var link = $(this);
		var op = 'add';
		if ($(link).hasClass('added'))
			op = 'remove';
			
		$.ajax({
			type: 'POST',
			url: '/catalog/favorite/'+op+'/id/'+link.data('id'),
			success: function(data){
				if (data != '0')
					$('header .s-btn.favorite').css('display' , 'inline-block');
				else
					$('header .s-btn.favorite').hide();
					
				if (op == 'add')
					$(link).addClass('added').html('<img src=\"/images/favorite.png\" alt=\"\">Удалить из избранного');
				else
					$(link).removeClass('added').html('<img src=\"/images/favorite.png\" alt=\"\">Добавить в избранное');
			},
			error: function(){},
		});
		return false;
	});
	
",CClientScript::POS_READY);
?>
<div class="catalog-category">
	<div class="product-view">
		<h1><span><?php echo $model->title; ?></span></h1>
		<div class="left">
			<div class="image">
				<?php
					if ($model->photo)
						echo CHtml::link(CHtml::image('/upload/catalog/product/medium/' . $model->photo, $model->title) , array('/upload/catalog/product/' . $model->photo), array('rel'=>'example_group')); 
					else
						echo CHtml::image('/images/nophoto.jpg', $model->title);
				?>
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
			<?php if ($model->color): ?>
				<div class="color"><?php echo $model->color;?></div>
			<?php endif; ?>
			<div class="city">г. <?php echo $model->city;?></div>
			<?php if ($medDesc = $model->getMedDesc()): ?>
				<div class="med"><?php echo $medDesc;?></div>
			<?php endif; ?> 
			<?php if ($termDesc = $model->getTermsDesc()): ?>
				<div class="terms"><?php echo $termDesc;?></div>
			<?php endif; ?>
			<?php if ($model->clear): ?>
				<div class="bug">Обработан<?php echo ($model->sex == 1 ? 'а' : '');?> от паразитов</div>
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
			<?/*php if ($attrs = $model->outAttrs()): $k = 0;?>
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
			<?php endif; */?>   
			<?php $favIds = (Yii::app()->session['favorite'] ? Yii::app()->session['favorite'] : array());?>
			<a href="/styles" class="s-btn add-favorite<?php echo (in_array($model->id, $favIds) ? ' added' : ''); ?>" data-id="<?php echo $model->id;?>"><img src="/images/favorite.png" alt=""><?php echo (in_array($model->id, $favIds) ? 'Убрать из избранного' : 'Добавить в избранное'); ?></a><br/>
			<!--a href="/styles" class="s-btn">Перезвонить мне</a-->
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
