<?php $this->widget('zii.widgets.CListView', array(
	'id' => 'product-list',
	'dataProvider' => $dataProvider,
	'ajaxUpdate' => false,
	'template' => '{items}',
	'itemView' => '_productview',
	'emptyText' => 'Нет животных',
)); ?>
<?php if ($dataProvider->totalItemCount - $offset > 6):?>
<div class="more"><a href="/catalog/default/category/link/<?php echo $category->link; ?>" data-offset="<?php echo ($offset+6);?>">Посмотреть еще</a></div>
<?php endif; ?>