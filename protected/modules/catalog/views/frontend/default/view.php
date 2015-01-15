<?php 
Yii::app()->clientScript->registerScript('catalog-products', "

	$(document).on('click', '.catalog-category .products .more a',function(){
		$.ajax({
			type: 'POST',
			url: $(this).prop('href')+'/offset/'+$(this).data('offset'),
			success: function(data){
				$('.catalog-category .products .more').remove();
				$('.catalog-category .products').append(data);
			},
			error: function(){
				$('.catalog-category .products .more').remove();
			},
		});
		return false;
	});
	
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
	<h1 class="<?php echo $category->getCustomName();?>"><span><?php echo $category->title;?></span></h1>
	<?php
		/*$selectionParameters=array();
		// Если переданы параметры - берем их
		if(isset($_GET['selectionParameters'])){
			$selectionParameters=$_GET['selectionParameters'];
		} else {
			$selectionParameters['category']=$category->id;
		}
		$this->widget('application.modules.catalog.components.SearchboxWidget', array('selectionParameters'=>$selectionParameters));*/
	?>
	<?/*div class="search-form">
		Формочка
	</div*/?>
	<div class="products">
		<?php $this->widget('zii.widgets.CListView', array(
			'id' => 'product-list',
			'dataProvider' => $dataProvider,
			'ajaxUpdate' => false,
			'template' => '{items}',
			'itemView' => '_productview',
			'emptyText' => 'Нет животных',
		)); ?>
		<?//php echo ($dataProvider->totalItemCount - $offset);?>
		<?php if (($dataProvider->totalItemCount - $offset) > 6):?>
		<div class="more"><a href="/catalog/default/category/link/<?php echo $category->link; ?>" data-offset="<?php echo ($offset+6);?>">Посмотреть еще</a></div>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>