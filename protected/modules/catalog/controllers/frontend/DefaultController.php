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
		$criteria->order = 'sort_order DESC';
		$criteria->limit = 9;
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

            $this->render('product',array(
                'model'=>$model,
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
		$model=CatalogProduct::model()->with('idCategoryFast','catalogImages')->findByPk($id);
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