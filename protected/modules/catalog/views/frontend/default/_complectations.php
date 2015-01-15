<?
// Подсчет цены
// Задаем значения по умолчанию для id поля исходной цены и id блока вывда результирующей цены
if(!isset($original_price)){$original_price='original_price';}
if(!isset($pricevalue)){$pricevalue='pricevalue';}
if(!isset($result_price)){$result_price='result_price';}

// Форматирование чисел для js
Yii::app()->clientScript->registerScriptFile('/js/format.20110630-1100.min.js', CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScript('countprice', "
    function countCorrection() {
	    var val=parseFloat($('#".$original_price."').val().replace(/\s/g, ''));
	    var correction=0;
	    $('.forcount').each(function(i){

	        if($(this).get(0).tagName.toLowerCase()=='select'){
                element=$(this).val();
                title=$(this).find('option[value='+element+']').attr('title');
                if(!title){title='';}
	            sign=title.charAt(0);
	            value=title.substr(1, title.length-1)-0;
	            if(sign=='+') correction=correction+value;
	            if(sign=='-') correction=correction-value;
	            if(sign=='=') val=value;
	        } else {
	            if ($(this).get(0).tagName.toLowerCase()=='input' && $(this).attr('checked')) {
	            	sign=$(this).attr('title').charAt(0);
	                value=$(this).attr('title').substr(1, $(this).attr('title').length-1)-0;

                    if(sign=='+') correction=correction+value;
                    if(sign=='-') correction=correction-value;
                    if(sign=='=') val=value;
	            }
	        }

	    });
	    $('#".$pricevalue."').text(format( '# ##0.##', val+correction));
	    $('#".$result_price."').val(val+correction);

	};
	countCorrection();

	$('.forcount').change(function(){countCorrection();});

", CClientScript::POS_READY);
?>
<?// Вывод вариантов комплектации
foreach($model->complectations as $complectation):?>
<div class="row">
    <?echo CHtml::label($complectation->title, $complectation->name);?>
    <div>
        <? if($complectation->type==1){
            echo CHtml::checkBox($complectation->name, false, array('class'=>'forcount', 'title'=>$complectation->outCorrSymbol().$complectation->outPriceCorrectionCounted(1,'{price}',0)));
            if($complectation->correction_type>0){echo '  ('.$complectation->outCorrSymbol().' '.$complectation->outPriceCorrectionCounted(1,'{price}',0, ',',' ').'р.)';}
            } else{
                $arrayValueList=$complectation->arrayValuesForList();

                if(isset($complectation->hide_notused) && $complectation->hide_notused){$empty=null;} else {$empty='Не выбрано';}
                if(isset($complectation->display_type) && $complectation->display_type==1){
                    echo CHtml::tag('span');
                    $select=true;
                    foreach($arrayValueList['values'] as $key=>$value){
                        echo CHtml::radioButton($complectation->name, $select, array('id'=>$complectation->name.$key,'class'=>'forcount', 'title'=>$arrayValueList['options'][$key]['title'], 'value'=>$key));//'options'=>$arrayValueList['options'], 'empty'=>$empty));
                        echo CHtml::label($value, $complectation->name.$key);
                        echo '<br/>';
                        $select=false;
                    }


                }else{
                    echo CHtml::dropDownList($complectation->name, false, $arrayValueList['values'], array('class'=>'forcount', 'options'=>$arrayValueList['options']));
                }

            }

        ?>
    </div>

</div>
<?endforeach?>
