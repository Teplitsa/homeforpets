<?php

// todo доделать шестой тип

class InputAttributesForm extends CWidget {

    public $productAttributes;
    public $category;

    public function run() {

        //выбираем все существующие атрибуты для товаров
        $catalogAttribute=CatalogAttribute::model()->findAll();

        if(isset($this->category->use_attribute)){
            // для каждого атрибута выводим форму
            foreach ($this->category->use_attribute as $attribute){


                // если значений данного атрибута нет - дополняем пустым шаблоном
                 if(!$this->existAttribute($attribute)){
                        $attr=new CatalogProductAttribute;
                        $attr->id_attribute=$attribute->id;
                        $this->productAttributes[]=$attr;
                    }

                // выводим форму для атрибута
                $this->render('inputattributes', array('attribute'=>$attribute, 'productAttributes'=>$this->productAttributes));

            }
        }

        
        parent::run();
       
    }


    // функция построения списков возможных значений. Возвращает массив $valuesList[id варианта]=значение варианта
    public function getValuesList($attribute){
        $valuesList=array();
        foreach($attribute->values as $var){
            $valuesList[$var->id]=$var->value;
        }
        return $valuesList;
    }

    //формирует массив из значений, если их несколько
    public function getMultiplyValues($attribute){
      foreach($this->productAttributes as $value){
           if($value->id_attribute==$attribute->id){
               $values_array[]=$value->value;
           }
      }
        return $values_array;
    }

    // проверяет существование атрибута в переданной модели
    private function existAttribute($attribute){
        foreach($this->productAttributes as $value){
            if($value->id_attribute==$attribute->id) return true;
        }

        return false;
    }
}

?>