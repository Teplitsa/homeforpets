<div class="topmarket podbor">
	<div class="topmarketinner">
		<div class="topcontainer">
			<div class="blocktitle">Бренды</div>
			<ul class="brands">
            <? foreach ($brand_list as $brand):?>
				<li>
				<?if ($brand['link']):?>
					<?=CHtml::link($brand['name'], array('/catalog/brands/'.$brand['link']));?>
				<?else:?>
					<span><?=$brand['name'];?></span>
				<?endif;?>
				<?if ($brand['country']):?>
					<span style="color:gray;"> /<?=$brand['country'];?>(<?=$brand['count'];?>)</span>
				<?endif;?>
				</li>
            <?endforeach;?>
			</ul>
		</div>
	</div>
</div>
<div class="cartshad"></div>