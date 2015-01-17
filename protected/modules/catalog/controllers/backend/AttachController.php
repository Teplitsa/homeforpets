<?php

class AttachController extends BackEndController
{
	/**
	 * Вывод категории (подкатегории и товары)
	 */
	public function actionIndex($id = 0)
	{
        if (!$category = $this->loadModel($id))
		{
            $category  = new CatalogCategory();
            $category->id = 0;
            $category->title = 'Каталог животных';
        }
		$this->breadcrumbs = CatalogCategory::getParents($category->id);
		$this->breadcrumbs[] = $category->title;


        $category_criteria=new CDbCriteria;

		$category_criteria->compare('parent_id',$category->id);

		$categoryDataProvider=new CActiveDataProvider('CatalogCategory', array(
			'criteria'=>$category_criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
			'pagination'=>false,
		));

        $products=new CatalogProduct('search');
        $products->unsetAttributes();

        $products->id_category=$category->id;
        $products->attach = 1;

		if(isset($_GET['CatalogProduct']))
			$products->attributes=$_GET['CatalogProduct'];

		$this->render('index',array(
            'products'=>$products,
            'categoryDataProvider'=>$categoryDataProvider,
			'category'=>$category,
		));
	}

	/**
	 * Загружаем модель категории
	 */
	public function loadModel($id)
	{
		$model=CatalogCategory::model()->findByPk($id);
		/*if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');*/
		return $model;
	}
}