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
			'move'=>'application.modules.catalog.components.SSortable.SSortableAction',
            'order' => array(
                'class' => 'ext.RGridView.RGridViewAction',
                'model' => 'CatalogProduct',
                'orderField' => 'sort_order',
            ),
		);
	} 

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

        Yii::import('application.modules.user.models.User');

        // Пометим, куда возвращаться после редактирования отзывов
        Yii::app()->user->returnUrl=$this->createUrl('view', array('id'=>$id));

        $model=$this->loadModel($id);

        $this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]=$model->title;
		$this->breadcrumbs[]='Просмотр';

        // Берем варианты комплектации для товара
        $complectation=new CatalogComplectation();

        $criteria=new CDbCriteria;
		$criteria->compare('product_id', $id);

        $complectationProvider=new CActiveDataProvider($complectation, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'sort_order',
            ),
		));

        $relatedProvider=new CArrayDataProvider($model->related_products);

        // Список всех товаров для добавления сопутствующих
        $products_to_related=new CatalogProduct('search');
        $products_to_related->unsetAttributes();

		if(isset($_GET['CatalogProduct']))
			$products_to_related->attributes=$_GET['CatalogProduct'];

        $reviewsProvider=new CArrayDataProvider($model->reviews);

		$this->render('view',array(
			'model'=>$model,
            'complectationProvider'=>$complectationProvider,
            'relatedProvider'=>$relatedProvider,
            'products_to_related'=>$products_to_related,
            'reviewsProvider'=> $reviewsProvider,
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

	public function actionDeleteAttribut($id)
	{
		if(Yii::app()->request->requestType=='GET')
		{
			$model=CatalogProductAttribute::model()->findByPk($id);
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('product/update', 'id'=>$model->id_product));
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

    public function actionEditprice(){
 		if(Yii::app()->request->isPostRequest)
		{
            $id=substr($_POST['elementid'], 1);
            if($model = $this->loadModel($id)){
                $model->price=$_POST['value'];
                $model->save();
                echo $model->price;
            }
            else
                        throw new CHttpException(400,'Incorrect id.');

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

	/**
	 * Добавление связи между товарами (сопутствующего товара)
     *
	 */
	public function actionAddRelation($id, $product)
	{
		if(Yii::app()->request->isPostRequest)
		{
            // Нельзя делать связь продукта с самим с собой
            if($id<>$product){
                // Загружаем исходный продукт
                $thisProd=$this->loadModel($product);

				// Загружаем связываемый продукт
				$productToRelation=$this->loadModel($id);

                // Проверяем, нет ли уже запрашиваемой связи
                $find=false;
                foreach($thisProd->related_products as $related_product){
                    if($related_product->id==$id) $find=true;
                }

                // Проверяем, нет ли обратной связи
                $findBack=false;
                foreach($productToRelation->related_products as $relatedBack_product){
                    if($relatedBack_product->id==$product) $findBack=true;
                }

                // Если не нашли
                if(!$find){
                     // Создаем новую связь
                    $relation=new CatalogRelatedproducts();
                    $relation->product_id=$product;
                    $relation->related_product=$id;
                    $relation->save();
                } 
				if(!$findBack){
					// Устанавливаем обратную связь
                    $relationBack=new CatalogRelatedproducts();
                    $relationBack->product_id=$id;
                    $relationBack->related_product=$product;
                    $relationBack->save();
				} 
				if($find && $findBack){throw new CHttpException(400, 'Связь между данными товарами уже установлена');}

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

            } else {throw new CHttpException(400, 'Нельзя связать товар сам с собой');}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

	}

	/**
	 * Удаление связи между товарами (сопутствующего товара)
     *
	 */
	public function actionDeleteRelation($id, $product)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$relations = CatalogRelatedproducts::model()->findAll(array(
                        'condition'=>'(product_id=:product_id AND related_product=:related_product) OR (product_id=:related_product AND related_product=:product_id)',
                        'params'=>array('product_id'=>$product, 'related_product'=>$id),
            ));

            // Удаляем все связи двух данных товаров друг с другом
            foreach($relations as $relation) $relation->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    public function actionDuplicate($id){
        $model=$this->loadModel($id);

        $parameters = new DuplicateForm;
        $parameters->photo_duplicate=1;
        $parameters->images_duplicate=1;
        $parameters->attributes_duplicate=1;
        $parameters->complectations_duplicate=1;

        if (isset($_POST['DuplicateForm'])) {
            $parameters->attributes = $_POST['DuplicateForm'];
            if ($parameters->validate()) {

                $errors=array();// Сюда будем собирать ошибки

                // Создаем копию модели
                $new_model= new CatalogProduct();
                $new_model->attributes=$model->attributes;
                // Если не велели копировать фотку - очищаем соответствующее поле
                if(!$parameters->photo_duplicate){$new_model->photo='';}

                // Делаем уникальную ссылку для нового товара
                $i=2;
                $new_model->link=$model->link.'-'.$i;
                while($check=CatalogProduct::model()->find('link=:link', array(':link'=>$new_model->link))){
                  $i++;
                  $new_model->link=$model->link.'-'.$i;
                }
                // Записываем модель
                if($new_model->save()){$success=true;}else{$success=false;$errors=array_merge($errors, $new_model->errors);}

                // Дальше продолжаем только при успешной записи модели
                if($success){

                    // Если надо копировать картинку, и есть что копировать
                    if($parameters->photo_duplicate && $model->photo){
                        $imagefile=Yii::app()->file->set($model->folder . '/' . $model->photo);
                        $imagefile_medium=Yii::app()->file->set($model->folder . '/medium/' . $model->photo);
                        $imagefile_small=Yii::app()->file->set($model->folder . '/small/' . $model->photo);

                        $new_model->photo=md5(time().$imagefile->filename).'.'.$imagefile->extension;

                        $new_imagefile=$imagefile->copy($new_model->photo);
                        $new_imagefile_medium=$imagefile_medium->copy($new_model->photo);
                        $new_imagefile_small=$imagefile_small->copy($new_model->photo);

                        // Записываем модель
                        if($new_model->save()){$success=($success && true);}else{$success=false;$errors=array_merge($errors, $new_model->errors);}
                    }

                    // Если надо копировать дополнительные изображения
                    if($parameters->images_duplicate){
                        foreach($model->catalogImages as $adv_image){
                            $new_adv_image=new CatalogImage();
                            $new_adv_image->attributes=$adv_image->attributes;
                            $new_adv_image->id_product=$new_model->id;

                            $adv_imagefile=Yii::app()->file->set($model->folder . '/moreimages/' . $adv_image->image);
                            $adv_imagefile_medium=Yii::app()->file->set($model->folder . '/moreimages/medium/' . $adv_image->image);
                            $adv_imagefile_small=Yii::app()->file->set($model->folder . '/moreimages/small/' . $adv_image->image);

                            $new_adv_image->image=md5(time().$adv_imagefile->filename).'.'.$adv_imagefile->extension;

                            $new_adv_imagefile=$adv_imagefile->copy($new_adv_image->image);
                            $new_adv_imagefile_medium=$adv_imagefile_medium->copy($new_adv_image->image);
                            $new_adv_imagefile_small=$adv_imagefile_small->copy($new_adv_image->image);

                            // Записываем модель
                            if($new_adv_image->save()){$success=($success && true);}else{$success=false;$errors=array_merge($errors, $new_adv_image->errors);}

                        }
                    }

                    // Если надо копировать атрибуты
                    if($parameters->attributes_duplicate){
                        foreach($model->productAttrubute as $attribute){
                            $new_attribute=new CatalogProductAttribute();
                            $new_attribute->attributes=$attribute->attributes;
                            $new_attribute->id_product=$new_model->id;

                            // Записываем модель
                            if($new_attribute->save()){$success=($success && true);}else{$success=false;$errors=array_merge($errors, $new_attribute->errors);}
                        }
                    }

                    // Если надо копировать варианты комплектации
                    if($parameters->complectations_duplicate){
                        foreach($model->complectations as $complectation){
                            $new_complectation=new CatalogComplectation();
                            //$complectation->product_id=$model->id;
                            $new_complectation->product_id=$new_model->id;
                            $new_complectation->attributes=$complectation->attributes;
                            $new_complectation->product_id=$new_model->id;

                            // Делаем уникальное имя для комплектации
                            $i=2;
                            $new_complectation->name=$complectation->name.'-'.$i;
                            while($check=CatalogComplectation::model()->find('name=:name', array(':name'=>$new_complectation->name))){
                                $i++;
                                $new_complectation->name=$complectation->name.'-'.$i;
                            }

                            // Записываем модель комплектации
                            if($new_complectation->save()){$success=($success && true);}else{$success=false;$errors=array_merge($errors, $new_complectation->errors);}

                            // Дублируем все значения варианта комплектации
                            foreach($complectation->complectationValues as $value){
                                $new_value=new CatalogComplectationValues();
                                $new_value->attributes=$value->attributes;
                                $new_value->complectation_id=$new_complectation->id;

                                // Записываем модель значения варианта комплектации
                                if($new_value->save()){$success=($success && true);}else{$success=false;$errors=array_merge($errors, $new_value->errors);}
                            }
                        }
                    }
                }

                if($success){
                    Yii::app()->user->setFlash('duplicate_message', 'Дубликат товара <b>'.$model->title.'</b> успешно создан! '.CHtml::link('Перейти к редактированию товара', array('update', 'id'=>$new_model->id)));
                }else{

                    $error_message='<ul>';
                    foreach($errors as $attribute_errors){
                        foreach($attribute_errors as $error){$error_message.='<li>'.$error.'</li>';}
                    }
                    $error_message.='</ul>';
                    Yii::app()->user->setFlash('duplicate_errors', 'При создании дубликата товара <b>'.$model->title.'</b> произошли ошибки:'.$error_message);
                }
                $this->refresh();
            }
        }
        $this->render('duplicate_settings', array(
            'model' => $model,
            'parameters'=> $parameters,
        ));
    }

    // Получаем список коллекций бренда для ajax
    public function actionChangeBrand($id){
		$str=array();
		if ($collections = CatalogBrandsCollections::arrayDropList($id))
			{
			
			foreach($collections as $coll_id=>$coll_name)
				{
					echo '<option value="'.$coll_id.'">'.$coll_name.'</option>';
				}
			}
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
