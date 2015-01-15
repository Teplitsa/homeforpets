<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.*');

/*
Класс виджета для вывода формы быстрого подбора товаров
*/
class SearchboxWidget extends CPortlet {

    public $view='searchbox';
    //public $category=0;
    public $selectionParameters=array();
    public $selectedProd;
	private $categories=array();
    

	public function	run() {

        $root_category=new CatalogCategory();
        $root_category->id=0;

        $selectionParameters=$this->selectionParameters;

        // Если не передан параметр "Категория" - устанавливаем ее корневой
        if(!isset($selectionParameters['category'])){
            $selectionParameters['category']=0;
        }

        $category=CatalogCategory::model()->with(array('use_attribute','allChilds'))->findByPk($selectionParameters['category']);
        if(!$category){
            $category=$root_category;
        }
		
		//получение всех категорий
		$this->categories=CatalogCategory::model()->findAll(array('select'=>'id,title,parent_id','order'=>'sort_order'));
		
        // Берем id всех подкатегорий новое
        $allCategoryIds=array_merge($this->getAllChildIds($category->id), (array)$category->id);
		//echo  var_dump($allCategoryIdsNew).'<br/>';
		
        // Берем id всех подкатегорий
        //$allCategoryIds=array_merge($category->allChildIds, (array)$category->id);
		//echo  var_dump($allCategoryIds);
        
		/*
        // Выбираем все товары из категории
        $criteria=new CDbCriteria;
        $criteria->compare('id_category', $allCategoryIds);
        $allprod=CatalogProduct::model()->findAll($criteria);

        // Берем все существующие значения в категории
        $allExistedParametersCategory=CatalogProduct::getAllExistedParameters($allprod);*/

        // Выбираем все существующие параметры категории
		
        $allExistedParametersCategory=CatalogCategoryExistparam::getParams($allCategoryIds);

        if($this->view=='searchboxright'){	
            // Отбираем товары по заданным критериям
            //$selectedProd=CatalogProduct::selectionProducts($selectionParameters);

            // Берем существующие значения параметров из выборки
            $existedParameters=CatalogProduct::getAllExistedParameters($this->selectedProd);

        }else{$existedParameters=array();}

        // Ставим диапазон цен
        $priceRange=array(
            'min'=>(isset($allExistedParametersCategory['price']) ? min($allExistedParametersCategory['price']) : 0),
            'max'=>(isset($allExistedParametersCategory['price']) ? max($allExistedParametersCategory['price']) : 0),
        );

        // Если какие-то параметры не переданы - выставляем умолчания
        if(!isset($selectionParameters['pricefrom'])) $selectionParameters['pricefrom']=$priceRange['min'];
        if(!isset($selectionParameters['priceto'])) $selectionParameters['priceto']=$priceRange['max']+1;
        if(!isset($selectionParameters['brand'])) $selectionParameters['brand']=array();
         
		 
		 $powermin = isset($selectionParameters['powermin'])? $selectionParameters['powermin'] : 100;
		 $powermax = isset($selectionParameters['powermax'])? $selectionParameters['powermax'] : 2000;
		 $type_instr = isset($selectionParameters['attributes']['tip-instrumenta']) ? $selectionParameters['attributes']['tip-instrumenta'][0] : 0;
        // Обработчики событий для слайдеров
        $sliders_js_functions="
		
		
		$( '.slider-range-price' ).slider({
			range: true,
			min: ".number_format($priceRange['min'], 0, '', '').",
			max: ".number_format($priceRange['max']+1, 0, '', '').",
			values: [ ".$selectionParameters['pricefrom'].", ".$selectionParameters['priceto']." ],
			slide: function( event, ui ) {
				$( '#price-amount' ).val(ui.values[ 0 ]);
				$( '#price-amount2' ).val(ui.values[ 1 ]);
			}
	   });
	   
	  $( '#price-amount' ).val( $( '.slider-range-price' ).slider( 'values', 0 ) );
	  $( '#price-amount2' ).val( $( '.slider-range-price' ).slider( 'values', 1 ) );
	
	$('.empty').val(". $type_instr.");
        ";

        // Отбираем атрибуты
        $attributes=array();
        $attrRanges=array();
        foreach($category->use_attribute as $attr){
            if($attr->id_attribute_kind==3 || $attr->id_attribute_kind==4){
                $attributes[]=$attr;
                if(!isset($selectionParameters['attributes'][$attr->name])){
                    $selectionParameters['attributes'][$attr->name]=array();
                }
            }
            if($attr->id_attribute_kind==1){
                $attributes[]=$attr;
                $attrRanges[$attr->name]=array(
                    'min'=>(isset($allExistedParametersCategory[$attr->id]) ? floor(min($allExistedParametersCategory[$attr->id])) : 0),
                    'max'=>(isset($allExistedParametersCategory[$attr->id]) ? max($allExistedParametersCategory[$attr->id]) : 0),
                );
                if(!isset($selectionParameters['attributes'][$attr->name])){
                    $selectionParameters['attributes'][$attr->name]=array(
                        'min'=>$attrRanges[$attr->name]['min'],
                        'max'=>$attrRanges[$attr->name]['max']+1,
                    );

                }
				//echo $attrRanges[$attr->name]['min'];die();
                // Добавляем обработчик слайдера для каждого атрибута этого типа
                $sliders_js_functions.="
                                        $( '#slider-range-".$attr->name."' ).slider({
                                            range: true,
                                            min: ".number_format(floatval($attrRanges[$attr->name]['min']), 0, '', '').",
                                            max: ".number_format(floatval($attrRanges[$attr->name]['max'])+1, 0, '', '').",
                                            values: [ ".floatval($selectionParameters['attributes'][$attr->name]['min']).", ".floatval($selectionParameters['attributes'][$attr->name]['max'])." ],
                                            slide: function( event, ui ) {
                                                $( '#".$attr->name."-amount' ).val(ui.values[ 0 ]);
                                                $( '#".$attr->name."-amount2' ).val(ui.values[ 1 ]);
                                            }
                                        });
                                        $( '#".$attr->name."-amount' ).val( $( '#slider-range-".$attr->name."' ).slider( 'values', 0 ) );
                                        $( '#".$attr->name."-amount2' ).val( $( '#slider-range-".$attr->name."' ).slider( 'values', 1 ) );
                ";
            }
        }

        //$category_list=$root_category->allChildsList;
        $category_list=$this->getAllChildsList($root_category->id);
        //$brand_list=CatalogBrands::arrayDropList($category->id);
        $brand_list = CatalogBrands::arrayDropListProd();
		
		$this->render($this->view, array(
             'category_list'=>$category_list,
             'brand_list'=>$brand_list,
             'priceRange'=>$priceRange,
             'selectionParameters'=>$selectionParameters,
             'existedParameters'=>$existedParameters,
             'allExistedParametersCategory'=>$allExistedParametersCategory,
             'attributes'=>$attributes,
             'attrRanges'=>$attrRanges,
            'sliders_js_functions'=>$sliders_js_functions,
        ));
		return parent::run();
	}
	
	//выборка дочерних подкатегорий
	private function getAllChildIds($id_category){
		$allchilds=array();
		foreach ($this->categories as $category) {
			if ($category->parent_id==$id_category) {
				$allchilds[]=$category->id;
				$allchilds=array_merge($allchilds, $this->getAllChildIds($category->id));
			}
		}		
		return $allchilds;
	}
    //****************************************************************************
    // Возвращает массив из дочерних категорий для построения select-списка
    private function getAllChildsList($id_category,$spaced=0){
        $allchilds=array();
		
		foreach ($this->categories as $category) {
			if ($category->parent_id==$id_category) {
				$allchilds[$category->id]=str_repeat ('___', $spaced).$category->title;
				$allchilds=$allchilds+$this->getAllChildsList($category->id,$spaced+1);
			}
		}		

        return $allchilds;
    }
    //****************************************************************************
}
?>
