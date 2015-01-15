<?php
Yii::app()->clientScript->registerScript('brands',"
	var container = $('.brands-container .brands-list'),
							total = container.children().length,
							width = container.children().outerWidth(true),
							index = 0;
							
						container.css('width', total * width);
						$('.brands a.prev').addClass('disabled');
						if (total <= 5)
							$('.brands a.next').addClass('disabled');
							
						$(document).on('click', '.brands a.next', function(){
							if (!$(this).hasClass('disabled'))
							{
								if (index < total - 5) {
									index += 1; 
									container.animate({'marginLeft' : width*(-index)}, 500);
								}
								manageControls();
							}
							return false;
						}).on('click', '.brands a.prev', function(){
							if (!$(this).hasClass('disabled'))
							{
								if (index > 0) {
									index -= 1;
									container.animate({'marginLeft' : width*(-index)}, 500);
								}
								manageControls();
							}
							return false;
						});
						
						var manageControls = function(){
							if (index == 0)
								$('.brands a.prev').addClass('disabled'); 
							else
								$('.brands a.prev').removeClass('disabled'); 
							
							if (index == total-5 )
								$('.brands a.next').addClass('disabled'); 
							else
								$('.brands a.next').removeClass('disabled');
						}
	
", CClientScript::POS_READY);
?>
<a href="#" class="prev"></a>
<div class="brands-container">
	<div class="brands-list">
		<? foreach ($brand_list as $brand):?>
			<?if ($brand['image']):?>
				<?php echo CHtml::link(CHtml::image('/upload/catalog/brand/'.$brand['image'],$brand['name']), '');?>
			<?else:?>
				<?=CHtml::link(CHtml::image(Yii::app()->request->baseUrl .'/images/nophoto.jpg',$brand['name']), array('/catalog/brands/'.$brand['link']));?>
			<?endif;?>
				
		<?endforeach;?>
	</div>
</div>
<a href="#" class="next"></a>