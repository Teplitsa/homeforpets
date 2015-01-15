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

$cs->registerScript('sort_update', "
	/*$(document).on('click','product-grid a.sort-link',function(){
		var link=$(this);
		$.fn.yiiGridView.update('product-grid',{
			success:function(){
				if (link.hasClass('asc')) {
					link.removeClass('asc').addClass('desc');
					//return!1;
				}
				if (link.hasClass('desc')) {
					link.removeClass('desc').addClass('asc');
					//return!1;
				}
				link.addClass('asc');
				//return!1;
			}
		});
		return!1;
	});*/
",CClientScript::POS_READY);
$cs->registerScript('product-list',"
	$(document).on('click','#product-list a.sort-link',function(){
		var link=$(this);
		var url=link.prop('href');
		$.fn.yiiListView.update('product-list',{
			url: url,
			dataType: 'JSON',
			success:function(data){
				if (data.list) $('#product-list').html(data.list);
			}
		});
		return false;
	});	
	
	$(document).on('click','#product-list .yiiPager a',function(){
		var link=$(this);
		var url=link.prop('href');
		$.fn.yiiListView.update('product-list',{
			url: url,
			dataType: 'JSON',
			success:function(data){
				if (data.list) $('#product-list').html(data.list);
			}
		});
		//console.log(123);
		return false;
	});	
	
", CClientScript::POS_READY);
?>
<h1><?php if (!empty($category->long_title)) echo $category->long_title; else echo $category->title;?></h1>
	<div class="products">
    <?php $this->widget('zii.widgets.CListView', array(
        'id'=>'catalog-list',
        'dataProvider'=>$dataProvider,
        'template'=>'{items}{pager}',
        'itemView'=>'_view',
        'emptyText'=>'',
    )); ?>
	</div>
<?php if (!empty($category->catalogProducts)): ?>
<?Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
   CClientScript::POS_READY
);	?>
	<?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="flash-success">
            <?php  echo Yii::app()->user->getFlash('success');?>
        </div>
        <?php endif; ?>
<?
	$selectionParameters=array();
    // Если переданы параметры - берем их
    if(isset($_GET['selectionParameters'])){
        $selectionParameters=$_GET['selectionParameters'];
    } else {
		$selectionParameters['category']=$category->id;
	}
	$this->widget('application.modules.catalog.components.SearchboxWidget', array(
                                                                                     //'view'=>'searchboxright',
                                                                                      'selectionParameters'=>$selectionParameters,
                                                                                     // 'selectedProd'=>$this->productsToShow,
                                                                                     //'category'=>$this->category,
                                                                                     
                                                                                   ));
        ?>

<div class="products">
	<?if ($category->product_view==0):?>
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
	<?else:?>
	<?php 
		$attr_columns=array();
		$attr_columns[]=array(
				'name'=>'title',
				'header'=>CHtml::link('Наименование',$title_sort,array('class'=>'sort-link'.$title_link_class)),
				'type'=>'raw',
				'headerHtmlOptions'=>array('style'=>'text-align:left;'),
				'value'=>'CHtml::link($data->title, $data->fullLinkFast)',
			);
		$attr_columns[]=array(
				'name'=>'price',
				'header'=>CHtml::link('Цена',$price_sort,array('class'=>'sort-link'.$price_link_class)),
				'value'=>'$data->price." р."',
				'htmlOptions'=>array('style'=>'text-align:center;white-space:nowrap;'),
			);
		$attrs=$category->use_attribute;
		if (count($attrs)>0) {
			
			foreach($attrs as $attribute) {
				if ($attribute->on_table) {
					$attr_column=array();
					$attr_column['header']=$attribute->title;
					$attr_column['value']='$data->getProductAttributeValue("'.$attribute->name.'")';
					$attr_column['htmlOptions']=array('style'=>'text-align:center;');
					$attr_columns[]=$attr_column;
				}
			}
		}
		$attr_columns[]=array(
			'header'=>'',
			'type'=>'raw',
			'value'=>'CHtml::link("В корзину", Yii::app()->createUrl("/order/cart/add/", array("product_id"=>$data->id)),array("class"=>"cart"))',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		);
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'product-grid',
        'dataProvider'=>$productDataProvider,
		//'ajaxUpdate'=>false,
        'template'=>'{pager}<div class="clear"></div>{items}<div class="clear"></div>{pager}',
		'cssFile'=>'/css/style.css',
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
		'columns'=>$attr_columns,
    )); ?>
	<?endif;?>
</div>
<?php endif; ?>
<div class="clear"></div>
<?if ($category->text):?>
	<h2>Описание категории</h2>
	<?php echo $category->text; ?>
<?endif;?>