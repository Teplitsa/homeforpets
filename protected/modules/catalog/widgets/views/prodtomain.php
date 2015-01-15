<?Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '//$(".flash-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
   CClientScript::POS_READY
);

Yii::app()->clientScript->registerScript('ajax-addtocart',"
	$('.order').click(function(event){
	  event.preventDefault();
	  product_url = $(this).attr('href');
	  $.ajax({
	    type: 'POST',
	    url: product_url,
		data: {'ajax':'ok'},
		dataType: 'JSON',
		}).done(function(data){
		
		 if(data.message)
		   {
		     
		     $('.flash-success').text(data.message);
			 $('.flash-success').dialog({
			   resizeble:false,
			   modal: true,
			   buttons: {
			         'Продолжить': function(){
					 $(this).dialog('close');
					 },
					 'Оформить заказ': function(){
					 location.href='/order/cart';
					 }
					}
				  }
				);
			$('.ui-dialog').css('width','368px');
			  
			 
			 }
			
									  
			 $('.cartwidget .price').text(data.product_count);
		   }
		
		);
	       
	
	});
	
", CClientScript::POS_READY);
	?>
	
        <div class="flash-success">
            <?php  echo Yii::app()->user->getFlash('success');?>
        </div>
     
        <?foreach($products as $product):?>
        <div class="product">
            <? $fullLink=$product->fullLinkFast;?>
            
            <a href="<?=$fullLink;?>">
                <? if ($product->photo != '') {
                echo CHtml::image('/upload/catalog/product/medium/' . $product->photo, $product->title);
            } else {
                echo CHtml::image('/images/nophoto.jpg', $product->title);
            }

                ?>
				<br><span><?=$product->title;?></span>
            </a>
			<div class="info">
			 <span>
			   <?if ($product->article):?>
					Артикул: <?=$product->article;?>
				<?endif;?>&nbsp;	
			  </span>
			  <span style="color:#<?php echo $product->stateColor[$product->state];?>;"><?php echo $product->stateList[$product->state];?></span>
			
			</div>
            <div class="cart">
				<span><?=$product->price;?> руб.</span>
				<a class="order" href="/order/cart/add/product_id/<? echo $product->id; ?>">Купить</a>
			</div>
        </div>
        <?endforeach?>