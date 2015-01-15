<?php 
Yii::app()->clientScript->registerScript('catalog-products', "
	
	$(document).on('click', '.add-favorite',function(){
		var link = $(this);
		$.ajax({
			type: 'POST',
			url: '/catalog/favorite/add/id/'+link.data('id'),
			success: function(data){
				if (data)
				{
					link.hide();
					link.next().show();
					$('header .s-btn.favorite').css('display' , 'inline-block');
				}
			},
			error: function(){},
		});
		return false;
	});
	
	$(document).on('click', '.add-favorite-hover',function(){
		var link = $(this);
		$.ajax({
			type: 'POST',
			url: '/catalog/favorite/remove/id/'+link.data('id'),
			success: function(data){
				link.hide();
				link.prev().show();
				if (data == '0')
					$('header .s-btn.favorite').hide();
			},
			error: function(){},
		});
		return false;
	});
	
",CClientScript::POS_READY);
?>
<div class="catalog-category">
	<h1><span>Избранное</span></h1>
	<div class="products">
		<?php $this->widget('zii.widgets.CListView', array(
			'id' => 'product-list',
			'dataProvider' => $dataProvider,
			'ajaxUpdate' => false,
			'template' => '{items}',
			'itemView' => '/default/_productview',
			'emptyText' => 'Нет животных',
		)); ?>
	</div>
	<div class="clear"></div>
</div>