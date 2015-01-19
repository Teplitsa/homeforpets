<?php

class ProductController extends BackEndController
{
	/**
	 * Контроллер товаровъ
     *
	 */
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			'move'=>'ext.SSortable.SSortableAction',
		);
	} 

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        // Пометим, куда возвращаться после редактирования отзывов
        Yii::app()->user->returnUrl=$this->createUrl('view', array('id'=>$id));

        $model=$this->loadModel($id);

        $this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]=$model->title;
		$this->breadcrumbs[]='Просмотр';

        // Список всех товаров для добавления сопутствующих
        $products_to_related=new CatalogProduct('search');
        $products_to_related->unsetAttributes();

		if(isset($_GET['CatalogProduct']))
			$products_to_related->attributes=$_GET['CatalogProduct'];


		$this->render('view',array(
			'model'=>$model,
            'products_to_related'=>$products_to_related,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id_category)
	{
		$model=new CatalogProduct;
		$model->id_category=$id_category;
		$this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]='Добавление товара';

        // Дополнительные фото
		$productImages=new CatalogImage;
        $criteria=new CDbCriteria;
        $criteria->compare('id_product', -1);
        $photoDataProvider=new CActiveDataProvider('CatalogImage', array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));

		$folder = 'images/catalog';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogProduct']))
		{
			$model->attributes=$_POST['CatalogProduct'];
			// Чтобы красиво написано было
			//$model->noyml=!$model->noyml;
			$model->hide=!$model->hide;
			if($model->save()) {
                // записываем атрибуты товара, переданные из формы
                if(isset($_POST['CatalogProductAttribute'])){$model->productAttributeSave($_POST['CatalogProductAttribute']);}
                
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'productImages'=>$productImages,
            'photoDataProvider'=>$photoDataProvider,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        // Дополнительные фото
        $productImages=new CatalogImage;
        $criteria=new CDbCriteria;
        $criteria->compare('id_product', $id);
        $photoDataProvider=new CActiveDataProvider('CatalogImage', array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));

		$this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]=$model->title;
		$this->breadcrumbs[]='Редактирование';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogProduct']))
		{
			$model->attributes=$_POST['CatalogProduct'];
			// Чтобы красиво написано было
		    //$model->noyml=!$model->noyml;
			$model->hide=!$model->hide;
			//$model->hide=!$this->hide;

           // if(isset($_POST['CatalogProductAttribute'])){
              //  $model->productAttrubute=$_POST['CatalogProductAttribute'];
            //}
			if($model->save()) {

                // записываем атрибуты товара, переданные из формы
                if(isset($_POST['CatalogProductAttribute'])){
                    $model->productAttributeSave($_POST['CatalogProductAttribute']);
                }

				$this->redirect(array('view','id'=>$model->id));

			}
		}
        //print_r($model->productAttrubute);

		$this->render('update',array(
			'model'=>$model,
			'productImages'=>$productImages,
            'photoDataProvider'=>$photoDataProvider,
		));
	}

	/**
	 * Удаление
     *
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);

			// Удаляем товар
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CatalogProduct');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Поиск и фильтрация товаров.
	 */
	public function actionSearch()
	{
		$model=new CatalogProduct('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogProduct']))
			$model->attributes=$_GET['CatalogProduct'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CatalogProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionPublicate(){
		if (isset($_POST['id'])) {
			if ($model=$this->loadModel($_POST['id'])) {
				if (isset($_POST['yam'])) {
					if ($_POST['yam']==='true')	
						$model->noyml=0;
					else 
						$model->noyml=1;
					if ($model->save())	Yii::app()->end();
					else throw new CHttpException(404,'Not save model.');
				}
				if (isset($_POST['hide'])) {
					if ($_POST['hide']==='true')	$model->hide=0;
					else $model->hide=1;
					if ($model->save())	Yii::app()->end();
					else throw new CHttpException(404,'Not save model.');
				}
			} else throw new CHttpException(404,'Unknown model.');
		} else throw new CHttpException(404,'Bad request.');
	}
}
