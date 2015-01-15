
					    <div class="blocktitle">Подбор товара</div>
                        <?php $fastfindform=$this->beginWidget('CActiveForm', array(
                            'id'=>'fast-find-form',
                            'enableAjaxValidation'=>false,
                            'action'=>'/catalog/default/selection/',
                            'method'=>'get',
                        )); ?>
                            <? print CHtml::dropDownList('selectionParameters[category]', $selectionParameters['category'], $category_list, array('class'=>'empty','empty'=>'Все категории')); ?>

                            <div class="bld">Цена</div>
                            от <input id="amount" type="text" class="inptext" name="selectionParameters[pricefrom]" value="<?=$selectionParameters['pricefrom'];?>" /> до <input id="amount2" type="text" class="inptext" name="selectionParameters[priceto]" value="<?=$selectionParameters['priceto'];?>"  /> р.
                            <div class="slider-range"></div>
                            <div class="monuf_sw" rel="manuflist"><span>&#9660;</span><a href="#">Производители </a></div>
                            <div class="monuf" id="manuflist">
                                <ul>
                                    <? foreach($brand_list as $brandid=>$brandname):?>
                                        
                                        <?if(isset($allExistedParametersCategory['brand']) && in_array($brandid, $allExistedParametersCategory['brand'])):?>
                                            <?if(isset($existedParameters['brand']) && in_array($brandid, $existedParameters['brand'])){$label_class='active';}else{$label_class='notactive';}?>
                                            <li><? echo CHtml::checkBox('selectionParameters[brand][]', in_array($brandid, $selectionParameters['brand']), array('id'=>'chk'.$brandid, 'value'=>$brandid));?><? echo CHtml::label($brandname, 'chk'.$brandid, array('class'=>$label_class));?></li>
                                        <?endif?>


                                    <?endforeach?>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <?foreach($attributes as $attribite):?>
                                <div class="monuf_sw" rel="<?=$attribite->name;?>"><span>&#9660;</span><a href="#"><?=$attribite->title;?></a></div>
                                <div class="slist" id="<?=$attribite->name;?>">
                                    <?if($attribite->id_attribute_kind==3 || $attribite->id_attribute_kind==4):?>
                                    <ul>
                                        <?
                                            if($attribite->alphasort){
                                                $values=$attribite->values_sorted;
                                            } else {$values=$attribite->values;}
                                            foreach($values as $value):?>
                                                <?if(isset($allExistedParametersCategory[$attribite->id]) && in_array($value->id, $allExistedParametersCategory[$attribite->id])):?>
                                                    <?if(isset($existedParameters[$attribite->id]) && in_array($value->id, $existedParameters[$attribite->id])){$label_class='active';}else{$label_class='notactive';}?>
                                                    <li><? echo CHtml::checkBox('selectionParameters[attributes]['.$attribite->name.'][]', in_array($value->id, $selectionParameters['attributes'][$attribite->name]), array('id'=>$attribite->name.$value->id, 'value'=>$value->id));?><? echo CHtml::label($value->value, $attribite->name.$value->id, array('class'=>$label_class));?></li>
                                                <?endif?>
                                            <?endforeach?>
                                    </ul>
                                    <?elseif($attribite->id_attribute_kind==1):?>

                                        от <input id="<?=$attribite->name;?>-amount" type="text" class="inptext" name="selectionParameters[attributes][<?=$attribite->name;?>][min]" value="<?=$selectionParameters['attributes'][$attribite->name]['min'];?>" /> до <input id="<?=$attribite->name;?>-amount2" type="text" class="inptext" name="selectionParameters[attributes][<?=$attribite->name;?>][max]" value="<?=$selectionParameters['attributes'][$attribite->name]['max'];?>"  />
                                        <div id="slider-range-<?=$attribite->name;?>" class="slider-attr"></div>
                                    <?endif?>
                                    <div class="clear"></div>
                                </div>
                            <?endforeach?>
                            <div class="mt15">
                                <!--<a href="#" class="icon pickup ac"></a>-->
                                <input type="submit" class="submit ac" value="" />
                            </div>
                        <?php $this->endWidget(); ?>

