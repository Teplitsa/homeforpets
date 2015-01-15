<?php

class PricetypesController extends BackEndController
{

    // Загрузка прайс-листа
    public function actionLoadprice(){
        $loadprice=new LoadpriceForm();
        if(isset($_POST['LoadpriceForm']))
        {
            $loadprice->attributes=$_POST['LoadpriceForm'];
            // Валидация формы
            if ($loadprice->validate()) {

                // Загружаем файл
                if	($file_price = CUploadedFile::getInstance($loadprice, 'filename')){
                    $name='upload/catalog/pricelist.'.$file_price->getExtensionName();
                    $file_price->saveAs($name);
                } else throw new CHttpException(400,'Нет файла для загрузки!');

                if(!$pricetype=CatalogPricetypes::model()->findByPk($loadprice->pricetype))
                    throw new CHttpException(400,'Не найден тип прайс-листа!');

                // Формируем вывод товаров, подлежащих изменению
                //$products_change=$pricetype->getProductsToChangeArray($name);				
                //$productsProvider = new CArrayDataProvider($products_change);

				$products_NoChange=$pricetype->getProductsToNoChangeArray($name);
				$productsNoChangeProvider = new CArrayDataProvider($products_NoChange[0],array('pagination'=>false,));
				$complectNoChangeProvider = new CArrayDataProvider($products_NoChange[1],array('pagination'=>false,));
				$complectListNoChangeProvider = new CArrayDataProvider($products_NoChange[2],array('pagination'=>false,));
				
				//$complect_NoChange=$pricetype->getComplectToNoChangeArray($name);
				//$complectNoChangeProvider = new CArrayDataProvider($complect_NoChange,array('pagination'=>false,));
				
                $this->render('loadprice_check', array(
                    //'productsProvider'=>$productsProvider,
                    'productsNoChangeProvider'=>$productsNoChangeProvider,
                    'complectNoChangeProvider'=>$complectNoChangeProvider,
                    'complectListNoChangeProvider'=>$complectListNoChangeProvider,
                    'filename'=>$name,
                    'pricetype'=>$pricetype,
                ));
            }
			else
			{
			$this->render('loadprice', array(
					'model'=>$loadprice,
				));
			}
        }
		
        // Если нажата кнопка подтверждения
        if(isset($_POST['accept'])){
            // Применяем изменения

            if(isset($_POST['filename'])) $filename=$_POST['filename']; else $filename='';
            if(!file_exists($filename)) throw new CHttpException(400,'Не найден файл прайс-листа!');

            if(isset($_POST['pricetype'])){
                if(!$pricetype=CatalogPricetypes::model()->findByPk($_POST['pricetype']))
                    throw new CHttpException(400,'Не найден тип прайс-листа!');
            } else throw new CHttpException(400,'Тип прайс-листа неизвестен!');

            if($pricetype->acceptParameters($filename)) Yii::app()->user->setFlash('success',"Изменения применены!");
                else Yii::app()->user->setFlash('error',"Изменения применены не полностью! Неизвестная ошибка!");

            //Удаляем файл
            @unlink($filename);
			
			$this->render('loadprice', array(
            'model'=>$loadprice,
        ));

        }
		
        // Если нажата кнопка отмены
        if(isset($_POST['cancel'])){
            // Отмена изменений

            if(isset($_POST['filename'])) $filename=$_POST['filename']; else $filename='';

            //Удаляем файл
            @unlink($filename);

            Yii::app()->user->setFlash('cancel',"Загрузка отменена!");
			
			$this->render('loadprice', array(
            'model'=>$loadprice,
        ));
        }
		
		if((!isset($_POST['LoadpriceForm']))&&(!isset($_POST['cancel']))&&(!isset($_POST['accept'])))
		 {
		 $this->render('loadprice', array(
            'model'=>$loadprice, ));
		 }
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CatalogPricetypes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogPricetypes']))
		{
			$model->attributes=$_POST['CatalogPricetypes'];
			if($model->save())
				$this->redirect('admin');
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogPricetypes']))
		{
			$model->attributes=$_POST['CatalogPricetypes'];
			if($model->save())
                $this->redirect('admin');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

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
		$dataProvider=new CActiveDataProvider('CatalogPricetypes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CatalogPricetypes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogPricetypes']))
			$model->attributes=$_GET['CatalogPricetypes'];

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
		$model=CatalogPricetypes::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-pricetypes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
