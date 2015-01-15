<?php $this->widget('zii.widgets.CListView', array(
        'id'=>'product-list',
        'dataProvider'=>$productDataProvider,
		'ajaxUpdate'=>false,
        'template'=>'
			<div style="float:left;margin:5px;" class="ajax-list-view">'.'Сортировка: '.CHtml::link('По наименованию',$title_sort,array('class'=>'sort-link'.$title_link_class)).' '.CHtml::link('По цене',$price_sort,array('class'=>'sort-link'.$price_link_class)).'
			</div>
			<div class="clear"></div>
			{items}
			<div class="clear"></div>
			{pager}
		',
        'itemView'=>'_productview',
		'pagerCssClass'=>'pager',
		'pager'=>array(
			'cssFile'=>'/css/style.css',
			'header'=>'',
			'prevPageLabel'=>'&#9668;',
			'nextPageLabel'=>'&#9658;',
			'firstPageLabel'=>'<<',
			'lastPageLabel'=>'>>',
		),
        'emptyText'=>'',
    )); ?>