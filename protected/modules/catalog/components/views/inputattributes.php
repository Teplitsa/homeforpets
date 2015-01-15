
<div class="row">
    <?
        // выводим метку атрибута
        print CHtml::tag('p', array('class'=>'label'), $attribute->title);

        //print_r($valueProductAttribute);
        if($attribute->kind->id==4){
             print CHtml::checkBoxList('CatalogProductAttribute['.$attribute->id.'][value]', $this->getMultiplyValues($attribute), $this->getValuesList($attribute), array('style' => 'margin: 4px 1px 0 2px;', 'labelOptions' => array('style' => 'display:inline;vertical-align: top;')));
        }else{
            foreach($productAttributes as $value){

                if($value->id_attribute==$attribute->id){


                    // выводим поле ввода в зависимости от типа атрибута
                    switch($attribute->kind->id){
                        case 1:
                                print CHtml::textField('CatalogProductAttribute['.$attribute->id.'][value][]', $value->attributes['value']);
                                break;
                        case 2:
                                print CHtml::textArea('CatalogProductAttribute['.$attribute->id.'][value][]', $value->attributes['value']);
                                break;
                        case 3:
                                print CHtml::dropDownList('CatalogProductAttribute['.$attribute->id.'][value][]', $value->attributes['value'], $this->getValuesList($attribute));
                                break;
                        case 5:
                                print CHtml::checkBox('CatalogProductAttribute['.$attribute->id.'][value][]', $value->attributes['value']);
                                break;
                        case 6:
                                print "шестой";
                                break;
                    }

                }
            }
        }

    ?>
</div>