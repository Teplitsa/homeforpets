<?
$cs=Yii::app()->clientScript;

// Скрипт для отображения рейтинга
$cs->registerScriptFile('/js/jquery.rating.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.rating.css');

$cs->registerScript('rating', "
    $('div.rating').rating({
        image: '/css/img/stars-16.png',
        width: 16,
        readOnly: true
    });

", CClientScript::POS_READY);

//подгрузка товаров
$cs->registerScript('more_products', "
        $('a.showhide').live('click',function(){
			id = $(this);
            $.ajax({
				
				url:'/catalog/brands/moreProducts?id='+$(this).attr('name')+'&brand='+$(this).attr('href')+'&coll='+$(this).attr('id'),
				success:function(data) {
						id.before(data);
						id.attr('name',parseInt(id.attr('name'))+5);
						id.remove();
						$('div.rating').rating({
							image: '/css/img/stars-16.png',
							width: 16,
							readOnly: true
						});
					return false;
				},
			});
            return false;
        });
 

", CClientScript::POS_READY);
?>
<div class="brands">
	<? if(isset($model->collections)):?>
		<h1>Бренд <?=$model->name;?></h1>

		<? if($model->text):?>
			<h2>Описание бренда</h2>
			<?=$model->text;?>
		<?endif;?>
		<? if($model->collections):?>
			<h2>Коллекции бренда</h2>
			<ul class="collections">
			<? foreach($model->collections as $collection):?>
				<li>
				<?if ($collection['link']):?>
						<?=CHtml::link($collection['name'], array('/catalog/brands/'.$model['link'].'/'.$collection['link']));?>
				<?else:?>
						<span><?=$collection['name'];?></span>
				<?endif;?>
				</li>
			<?endforeach;?>
			</ul>
		<?endif;?>
	<?else:?>
		<h1>Коллекция <?=$model->name;?> (<?=$model->thisBrand->name;?>)</h1>

		<? if($model->text):?>
			<h2>Описание коллекции</h2>
			<?=$model->text;?>
		<?endif;?>
	<?endif;?>
	<div class="clear"></div>
	
	<?php if ((isset($categories))&&($categories!=null)): ?>
		<h2>Категории товаров</h2>
		<ul class="categories">
			<? foreach($categories as $category):?>
				<li>
				<?if ($category['link']):?>
						<?=CHtml::link($category['title'], '#'.$category['link']);?>
				<?else:?>
						<span><?=$category['title'];?></span>
				<?endif;?>
				</li>
			<?endforeach;?>
		</ul>
	<?endif;?>
	
	<?php if (isset($products)): ?>
	<div class="stock">
		<? $i=1;$k=0;
			$brand=$model->link;
			$coll='';
			if (isset($model->thisBrand)) 
				{
				 $brand=$model->thisBrand->link;
				 $coll=$model->link;
				}
			
			foreach ($products as $product)
			{	
				$k++;
				if ($i==1) 
					{
					if ($k>1) echo '</div>';
					echo '<div class="'.$product->idCategory->link.'">';
					
					echo '<h2><a name="'.$product->idCategory->link.'"></a>'.$categories[$product->id_category]['title'].'</h2>';
					// echo '<div class="clear"></div>';
					}
				if ($i==6) 
					{echo '<a href="'.$brand.'" id="'.$coll.'" name="'.($k-1).'" class="showhide">Еще товары категории</a>';
						//echo '<div style="display: none;float:left;">';
					 };	
				//echo $i.'/'.$categories[$product->id_category]['count'];
				if ($i<6) $this->renderPartial('/default/_productview',array('data'=>$product));
				//if (($i>10)&&($i==$categories[$product->id_category]['count'])) echo '</div>';
				if ($i==$categories[$product->id_category]['count']) $i=0;
				if ($k==count($products)) echo '</div>';
				$i++;
			}
		?>
	</div>
	<?php endif; ?>
</div>