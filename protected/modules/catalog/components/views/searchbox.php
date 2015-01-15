<?Yii::app()->clientScript->registerScript('searchbox', "
    {$sliders_js_functions}
	
	$('.clear-searchbox').click(function(){
	
	
	   $( '.slider-range-price' ).slider({
			range: true,
			min: ".number_format($priceRange['min'], 0, '', '').",
			max: ".number_format($priceRange['max']+1, 0, '', '').",
			values: [ ".number_format($priceRange['min'], 0, '', '').", ".number_format($priceRange['max']+1, 0, '', '')." ],
			slide: function( event, ui ) {
				$( '#amount' ).val(ui.values[ 0 ]);
				$( '#amount2' ).val(ui.values[ 1 ]);
			}
	  });
	  $( '#amount' ).val( $( '.slider-range' ).slider( 'values', 0 ) );
	  $( '#amount2' ).val( $( '.slider-range' ).slider( 'values', 1 ) );
	
	
	
	 
	   $('.empty').val(0);
	  $('#fast-find-form').submit();
	 
	});
	
	$(document).on('click', '.toggler', function(){
		if ($(this).hasClass('collapsable'))
			$(this).addClass('expandable').removeClass('collapsable');
		else
			$(this).addClass('collapsable').removeClass('expandable');
			
		$(this).next().toggle();
		return false;
	});
	
", CClientScript::POS_READY);
?>
<?php $fastfindform=$this->beginWidget('CActiveForm', array(
	'id'=>'fast-find-form',
    'enableAjaxValidation'=>false,
    'action'=>'/catalog/default/selection/',
    'method'=>'get',
)); ?>
<div class="searchbox">
	<div class="searchboxinner">
		<input type="hidden" name="selectionParameters[category]" value="<?=$selectionParameters['category']?>"/>
		<div class="row">
			<div class="price">
				<div class="title">Цена:</div>
				<div class="info">
					<label for="price-amount">от</label>
					<input id="price-amount" type="text" class="inpprice"  name="selectionParameters[pricefrom]" value="<?=number_format($priceRange['min']-1, 0, '', '')?>" /> 
					<label for="price-amount2">до</label>                   
											<input id="price-amount2" type="text" class="inpprice" name="selectionParameters[priceto]" value="<?=number_format($priceRange['max']+1, 0, '', '')?>"  />
					<div class="slider-range-price"></div>
				</div>
			</div>
			<div class="brand">
				Производитель:
				<?php echo CHtml::dropDownList('selectionParameters[brand][]', $selectionParameters['brand'], $brand_list, array('empty'=>'Все производители')); ?>
			</div>
		</div>
		<div class="additional">
			<div class="toggler expandable"><a href="#">Дополнительные параметры</a></div>
			<div style="display: none;">
				<?php foreach($attributes as $attribite):?>
				<div class="row">
					<div class="title"><?php echo $attribite->title;?>:</div>
					<div class="info">
						<?php if($attribite->id_attribute_kind==3 || $attribite->id_attribute_kind==4):?>
                        <?php 
							$values = ($attribite->alphasort ? $attribite->values_sorted : $attribite->values);
                            foreach($values as $value)
							{
								if(isset($allExistedParametersCategory[$attribite->id]) && in_array($value->id, $allExistedParametersCategory[$attribite->id]))
								{
									echo CHtml::checkBox('selectionParameters[attributes]['.$attribite->name.'][]', in_array($value->id, $selectionParameters['attributes'][$attribite->name]), array('id'=>$attribite->name.$value->id, 'value'=>$value->id));
									echo CHtml::label($value->value, $attribite->name.$value->id, array('class' => 'for-checkbox'));      
									echo "<br/>";
								}
                            }
						?>
                        <?elseif($attribite->id_attribute_kind==1):?>
							<label for="<?=$attribite->name;?>-amount">от</label>
							<input id="<?=$attribite->name;?>-amount" type="text" class="inptext" name="selectionParameters[attributes][<?=$attribite->name;?>][min]" value="<?=$selectionParameters['attributes'][$attribite->name]['min'];?>" />
							<label for="<?=$attribite->name;?>-amount2">до</label>
							<input id="<?=$attribite->name;?>-amount2" type="text" class="inptext" name="selectionParameters[attributes][<?=$attribite->name;?>][max]" value="<?=$selectionParameters['attributes'][$attribite->name]['max'];?>"  />
                            <div id="slider-range-<?=$attribite->name;?>" class="slider-attr"></div>
						<?endif?>
						<div class="clear"></div>
                    </div>
				</div>
                <?php endforeach?>
			</div>
		</div>
							
							
		<div class="buttons">
			<input class="send" type="submit" value=""/>	
			<?php echo CHtml::link('Сбросить', '#', array('class' => 'clear-searchbox')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>