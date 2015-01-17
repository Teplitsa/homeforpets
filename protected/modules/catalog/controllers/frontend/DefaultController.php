<?php

class DefaultController extends BaseCatalogController
{
    public $category=0;
    public $productsToShow;

	public function actionIndex()
	{   
		$this->redirect('/');
        $this->metaInfoGenerate($this->catalog_config->title, $this->catalog_config->keywords, $this->catalog_config->description);
		$this->render('index');
	}

	public function actionCategory($link, $offset = 0)
	{
		$category = $this->loadCategoryModel($link);
		$this->metaInfoGenerate($category->title, $category->keywords, $this->catalog_config->description);
		$this->category = $category->id;
		$criteria = new CDbCriteria;
		$criteria->compare('id_category', $category->id);
		$criteria->addCondition('hide=0 OR hide is NULL');
		$criteria->addCondition('attach=0');
		$criteria->order = 'sort_order ASC';
		$criteria->limit = 6;
		$criteria->offset = $offset;
		$dataProvider = new CActiveDataProvider('CatalogProduct', array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	    if ($this->catalog_config->layout) 
			$this->layout = $this->catalog_config->layout;
       
		if (Yii::app()->request->isAjaxRequest)
			$this->renderPartial('_more', array(
				'dataProvider' => $dataProvider,
				'category' => $category,
				'offset' => $offset,
			));
		else
			$this->render('view',array(
				'dataProvider' => $dataProvider,
				'category' => $category,
				'offset' => $offset,
			));
	}

	public function actionProduct($id)
	{
	    
		$model=$this->loadProductModelFast($id);
        if(!$model->hide){

            // Увеличиваем количество просмотров на 1
            $model->incViews();

            $this->breadcrumbs=CatalogCategory::getBreadcrumbs($model->id_category, true);
            $this->breadcrumbs[]=$model->title;

            // формируем заголовок и метатеги старницы
            $this->metaInfoGenerate($model->title, $model->keywords, $this->catalog_config->description);

            //$cs=Yii::app()->clientScript;
            // Подключаем свой скрипт
            //$cs->registerScriptFile('/js/jquery.jcarousel.js', CClientScript::POS_HEAD);
            //$cs->registerScriptFile('/js/jquery.fancybox.js', CClientScript::POS_HEAD);
            //$cs->registerCssFile('/css/fancy.css');
            //$cs->registerCssFile('/css/tango/skin.css');

            //$review=new CatalogReviews();

            $this->render('product',array(
                'model'=>$model,
                //'review'=>$review,
            ));

        } else throw new CHttpException(404,'The requested page does not exist.');
	}

    public function actionSelection()
	{
        $params = array();
        if (isset($_GET['params']))
           $params = $_GET['params'];
        
        $dataProvider = CatalogProduct::selectionProvider($params);
        $this->render('selectionresults', array(
			'dataProvider' => $dataProvider,
			'params' => $params,
        ));
    }

    public function actionSearchbox(){
        if(isset($_POST['selectionParameters'])){
            $selectionParameters=$_POST['selectionParameters'];
        }else{$selectionParameters=array();}

        // Если не передан параметр "Категория" - устанавливаем ее корневой
        if(!isset($selectionParameters['category'])){
            $selectionParameters['category']=0;
        }

        // Создаем корневую категорию
        $root_category=new CatalogCategory();
        $root_category->id=0;

        $category=CatalogCategory::model()->with('use_attribute')->findByPk($selectionParameters['category']);
        if(!$category){
            $category=$root_category;
        }

        // Берем id всех подкатегорий
        $allCategoryIds=array_merge($category->allChildIds, (array)$category->id);

        /*
        // Выбираем все товары из категории
        $criteria=new CDbCriteria;
        $criteria->compare('id_category', $allCategoryIds);
        $allprod=CatalogProduct::model()->findAll($criteria);

        // Берем все существующие значения в категории
        $allExistedParametersCategory=CatalogProduct::getAllExistedParameters($allprod);
        */
        
        // Выбираем все существующие параметры категории
        $allExistedParametersCategory=CatalogCategoryExistparam::getParams($allCategoryIds);
        
		
        // Отбираем товары по заданным критериям
        $selectedProd=CatalogProduct::selectionProducts($selectionParameters);

        // Берем существующие значения параметров из выборки
        $existedParameters=CatalogProduct::getAllExistedParameters($selectedProd);
        print_r($existedParameters);
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
            }
        }
        
        $root_category=new CatalogCategory();
        $root_category->id=0;
        $category_list=$root_category->allChildsList;
        $brand_list=CatalogBrands::arrayDropList();
        $priceRange=array(
            'min'=>(isset($allExistedParametersCategory['price']) ? min($allExistedParametersCategory['price']) : 0),
            'max'=>(isset($allExistedParametersCategory['price']) ? max($allExistedParametersCategory['price']) : 0),
        );

        // Если какие-то параметры не переданы - выставляем умолчания
        if(!isset($selectionParameters['pricefrom'])) $selectionParameters['pricefrom']=$priceRange['min'];
        if(!isset($selectionParameters['priceto'])) $selectionParameters['priceto']=$priceRange['max']+1;
        if(!isset($selectionParameters['brand'])) $selectionParameters['brand']=array();
        
        $this->renderPartial('application.modules.catalog.components.views.searchboxinner', array(
                                                                                     'category_list'=>$category_list,
                                                                                     'brand_list'=>$brand_list,
                                                                                     'priceRange'=>$priceRange,
                                                                                     'selectionParameters'=>$selectionParameters,
                                                                                     'existedParameters'=>$existedParameters,
                                                                                     'allExistedParametersCategory'=>$allExistedParametersCategory,
                                                                                     'attributes'=>$attributes,
                                                                                     'attrRanges'=>$attrRanges,
                                                                                   ));

    }

    // Собираем используемые параметры категорий
    public function actionParamindex(){
        // Очищаем всю таблицу
        CatalogCategoryExistparam::model()->deleteAll();
		
		$criteria=new CDbCriteria;
		$criteria->select='id';
		$criteria->with=array('catalogProductsForExist');
		
        $categories=CatalogCategory::model()->findAll($criteria);
        foreach($categories as $category){
            $existParameters=$category->getExistingParameters();
            $categoryExistingParams=new CatalogCategoryExistparam();
            $categoryExistingParams->category_id=$category->id;
            $categoryExistingParams->existparam=serialize($existParameters);
            $categoryExistingParams->save();
        }

        echo "Индексирование прошло успешно!";
    }

	public function loadCategoryModel($link)
	{
		$model=CatalogCategory::model()->findByAttributes(array('link'=>$link));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadCategoryModelFast($link)
	{
		$model=CatalogCategory::model()->with('products')->findByAttributes(array('link'=>$link));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadProductModel($id)
	{
		$model=CatalogProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadProductModelFast($id)
	{
		$model=CatalogProduct::model()->with('related_products','productAttrubute','idCategoryFast','catalogImages')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    public function createUrl($route,$params=array(),$ampersand='&'){
        // если формируем ссылку на категорию
        if($route=='category'){
            if(isset($params['link'])){return '/catalog'.CatalogCategory::getCategoryRoute($params['link']);}
        }

        // если формируем ссылку на товар
        if($route=='product'){
            // если передано id товара
            if(isset($params['id'])){
                // если существует такой продукт
                if($product=CatalogProduct::model()->find(array('condition'=>'id=:id', 'params'=>array(':id'=>$params['id']),))){

                    // берем категорию продукта
                    $category=CatalogCategory::model()->with('parentShort')->findByPk($product->id_category);

                    // возвращаем путь к категории товара и прибавляем в конце id
                    return '/catalog'.CatalogCategory::getCategoryRouteFast($category).'/'.$product->id;
                }
            }
        }
        // если условия не сработали - формируем адрес обычным образом
        return parent::createUrl($route,$params,$ampersand);
    }
}