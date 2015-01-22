<?php

/**
 * This is the model class for table "catalog_product".
 *
 * The followings are the available columns in table 'catalog_product':
 * @property string $id
 * @property string $photo
 * @property string $description
 * @property string $id_category
 * @property integer $sort_order
 * @property integer $date_added
 * @property integer $on_main
 *
 * The followings are the available model relations:
 * @property CatalogImage[] $catalogImages
 * @property CatalogCategory $idCategory
 */
class CatalogProduct extends CActiveRecord
{
    public $variation = NULL;
    public $images = NULL;
    // Фолдер для картинок
    public $folder = 'upload/catalog/product';

	public $medList = array(
		1 => 'Привит', 
		2 => 'Стерилизован', 
		3 => 'Привит и стерилизован',
	);

	public $termsList = array(
		1 => 'С самовыгулом', 
		2 => 'Без самовыгула', 
		3 => 'Будка',
		4 => 'Дом',
	);
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_product';
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'ext.SSortable.SSortableBehavior',
                'categoryField' => 'id_category',
                'titleField' => 'title',
			),
		);

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, link', 'required', 'except' => 'response'),
			array('age_y, age_m, age_w, sex, medical, terms, attach, clear', 'numerical', 'integerOnly'=>true),
			array('photo, title, link, city, curator_name, curator_phone, owner_name, owner_phone, size, color', 'length', 'max'=>256),
			array('id_category', 'length', 'max' => 11),
            array('link', 'unique', 'message' => 'Животное со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('keywords, description, sort_order, on_main, hit, recomended, hide, noyml, state', 'safe'),
			array('photo', 'file', 'types' => 'gif, jpg, jpeg, png', 'allowEmpty' => true,),
			array('id, photo, description, id_category, sort_order, on_main', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

            // Картинки товара
			'catalogImages' => array(self::HAS_MANY, 'CatalogImage', 'id_product'),

            // Категория товара
			'idCategory' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category'),

            // Категория товара
			'idCategoryFast' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category', 'with' => array('parentShort')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Кличка',
            'link' => 'Ссылка',
            'keywords' => 'Ключевые слова',
			'photo' => 'Фотография',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'currency' => 'Валюта',
            'priceprofile' => 'Ценовой профиль',
			'description' => 'История',
			'id_category' => 'Категория',
			'sort_order' => 'Сортировка',
			'date_added' => 'Дата добавления',
            'article'=>'Артикул',
            'on_main'=>'На главной',
            'recomended'=>'Рекомендуемый',
            'hit'=>'Хит продаж',
            'views'=>'Количество просмотров',
            'brand'=>'Производителя',
            'brand_collection'=>'Коллекция бренда',
            'hide'=>'Отображать на сайте?',
            'noyml'=>'Выгрузка в Яндекс.Маркет',
            'state'=>'Состояние',
            'age_y' => 'Возраст (лет)',
            'age_m' => 'Возраст (месяцев)',
            'age_w' => 'Возраст (недель)',
            'sex' => 'Пол',
            'city' => 'Город',
            'medical' => 'Стерилизован, привит',
            'terms' => 'Условия проживания',
            'curator_name' => 'Имя куратора',
            'curator_phone' => 'Телефон куратора',
            'owner_name' => 'Имя дополнительного куратора',
            'owner_phone' => 'Телефон дополнительного куратора',
            'attach' => 'Пристроили?',
            'color' => 'Цвет(Окрас)',
            'size' => 'Размер',
            'clear' => 'Обработан от паразитов?',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($without=0)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		/*if(isset($_GET['id']))
			$this->id_category=$_GET['id'];
		else $this->id_category=0;*/

        if($without){
          $criteria->condition='id<>:without';
          $criteria->params=array(':without'=>$without);
        }

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('id_category',$this->id_category);
        if($this->on_main) $criteria->compare('on_main',$this->on_main);
		$criteria->compare('date_added',$this->date_added);
		$criteria->compare('attach',$this->attach);

		/*$criteria->with=array('idCategory');
		$criteria->compare('idCategory.sort_order',$this->id_category,true);*/
	
		$sort = new CSort();
        $sort->defaultOrder = 't.sort_order DESC';
		/*$sort->attributes = array( 
                'category' => array(
					'asc'=> 'idCategory.sort_order',
					'desc' => 'idCategory.sort_order desc',
                ),
            );*/
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
			'sort' =>$sort,
		));
	}

    //**********************************************************************
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            // Читаем конфигурацию каталога
            $catalog_config=CatalogConfig::model()->findByPk(1);

            //Перед записью загружаем картинки

            // Если это не новая запись - Берем старую модель для удаления старой картинки
            if(!$this->isNewRecord)
            {
               $old_model=CatalogProduct::model()->findByPk($this->id);
               $old_image=$old_model->photo;
            }else{
                $old_image='';
                // тут же записываем дату создания
                $this->date_added=time();
            }
			$this->article=trim($this->article);
			
			if	($photo = CUploadedFile::getInstance($this, 'photo') or $photo = CUploadedFile::getInstance(new ResponseForm, 'photo')){
				$name = md5(time().$photo).'.'.$photo->getExtensionName();
				$this->photo = $name;
				$photo->saveAs($this->folder . '/' . $name);
                if(isset($catalog_config->watermark_image) && !$catalog_config->no_watermark){
                    Yii::app()->ih
                        ->load($this->folder . '/' . $this->photo)
                        ->watermark($this->folder . '/watermark/'.$catalog_config->watermark_image , $catalog_config->watermark_x, $catalog_config->watermark_y)
                        ->save();
                }
				Yii::app()->ih
					->load($this->folder . '/' . $this->photo)
					->adaptiveThumb($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
					->save($this->folder . '/medium/' . $this->photo, false, 100)
					->reload()
					->adaptiveThumb($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
					->save($this->folder . '/small/' . $this->photo, false, 100);

                if($old_image){
                        //Удаляем старые картинки
                        @unlink($this->folder . '/' .$old_image);
                        @unlink($this->folder . '/medium/' .$old_image);
                        @unlink($this->folder . '/small/' .$old_image);
                }
			}else {if(!$this->photo) $this->photo = $old_image;}

            $productImages=new CatalogImage;

			if	($productImagesUpload = CUploadedFile::getInstances($productImages, 'image')){
				foreach($productImagesUpload as $file){
					$productImages=new CatalogImage;
					$productImagesName = md5(time().$file->name).'.'.$file->getExtensionName();
					$productImages->image = $productImagesName;
					$file->saveAs($this->folder . '/moreimages/' . $productImagesName);
					$this->images[] = $productImages;
                    if(isset($catalog_config->watermark_image) && !$catalog_config->no_watermark){
                        Yii::app()->ih
                            ->load($this->folder . '/moreimages/' . $productImagesName)
                            ->watermark($this->folder . '/watermark/'.$catalog_config->watermark_image , $catalog_config->watermark_x, $catalog_config->watermark_y)
                            ->save();
                    }
					Yii::app()->ih
						->load($this->folder . '/moreimages/' . $productImagesName)
						->adaptiveThumb($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
						->save($this->folder . '/moreimages/small/' . $productImagesName, false, 100)
						->reload()
						->adaptiveThumb($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
						->save($this->folder . '/moreimages/medium/' .$productImagesName, false, 100);
				}
			}
				
			return true;
		}
		else
			return false;
	}

    //**********************************************************************
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
    protected function afterSave(){
        parent::afterSave();

		if (!empty($this->images)) {
			foreach($this->images as $image) {
				$image->id_product = $this->id;
				$image->save();
			}
		}
		
		$attached = self::model()->count('attach=:attach', array(':attach' => 1));
		$this->dbConnection->createCommand()->update('catalog_config', array('attached' => $attached));
    }

    //**********************************************************************
    // Удаляем связанные модели
    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем дополнительные картинки товара
			foreach ($this->catalogImages as $image) {
				@unlink ($this->folder . '/moreimages/' . $image->image);
				@unlink ($this->folder . '/moreimages/medium/' . $image->image);
				@unlink ($this->folder . '/moreimages/small/'  . $image->image);

                $image->delete();
			}

            // Удаляем основную картинку товара и все ее копии
            @unlink ($this->folder . '/' . $this->photo);
            @unlink ($this->folder . '/medium/' . $this->photo);
            @unlink ($this->folder . '/small/' . $this->photo);

            return true;
        }
        else
            return false;
    }


    //**********************************************************************
	public function getImages(){
		$attribute='';
		foreach($this->catalogImages as $image){
			$attribute.='{url: "/images/catalog/fasad/'.$image->image.'"},';
		}
		return $attribute;
	}

    //**********************************************************************
    //возвращает максимальное значение поля сортировки
	public function getMaxSortOrder(){
		$models=CatalogProduct::model()->findAll();
		foreach($models as $model) {
			$sort_orders[]=$model->sort_order;
		}
        if(!empty($sort_orders)){
            arsort($sort_orders);
            $max_order=current($sort_orders);
        } else{$max_order=0;}

		return $max_order;
	}

    //**********************************************************************
    // Увеличение количества просмотров на 1
    public function incViews(){
        $this->views++;
        $this->save();
    }

    //*********************************************************************
    // Возвращает полную ссылку на товар.
    public function getFullLink(){
            if(isset($this->idCategory)){
                         // возвращаем путь к категории товара и прибавляем в конце id
                        return '/catalog'.CatalogCategory::getCategoryRoute($this->idCategory->link)."/".$this->link.'.html';
            }  else {return '/catalog/'.$this->link.'.html';}
    }

    //*********************************************************************
    // Возвращает полную ссылку на товар.
    public function getFullLinkFast(){
            if(isset($this->idCategoryFast)){
                         // возвращаем путь к категории товара и прибавляем в конце id
                        return '/catalog'.CatalogCategory::getCategoryRouteFast($this->idCategoryFast).'/'.$this->link.'.html';
            }  else {return '/catalog/'.$this->link.'.html';}
    }

    public static function selectionProvider($params = array())
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort_order DESC';
		$criteria->addCondition('hide = 0 OR hide is NULL');
		$criteria->addCondition('attach = 0');
		if (!empty($params))
		{
			if (isset($params['sex']) and $params['sex'])
				$criteria->compare('sex', $params['sex']);
				
			if (isset($params['city']) and $params['city'])
				$criteria->compare('city', $params['city']);
				
			if (isset($params['ageFrom']) and $params['ageFrom'] and isset($params['ageFromUnit']) and $params['ageFromUnit'])
			{
				$from = (int)$params['ageFrom'] * (int)$params['ageFromUnit'];
				$criteria->addCondition('(age_y * 365 + age_m * 30 + age_w * 7) >= '.$from);
			}
			
			if (isset($params['ageTo']) and $params['ageTo'] and isset($params['ageToUnit']) and $params['ageToUnit'])
			{
				$to = (int)$params['ageTo'] * (int)$params['ageToUnit'];
				$criteria->addCondition('(age_y * 365 + age_m * 30 + age_w * 7) <= '.$to);
			}
			
			if (isset($params['category']) and $params['category'])
			{
				$criteria->compare('id_category', $params['category']);
				if ($params['category'] == 1 and isset($params['color']) and $params['color'])
					$criteria->compare('color', $params['color']);
					
				if ($params['category'] == 2 and isset($params['size']) and $params['size'])
					$criteria->compare('size', $params['size']);
			}
			
			if (isset($params['medical']) and $params['medical'])
				$criteria->compare('medical', $params['medical']);
		}
		
		$dataProvider = new CActiveDataProvider('CatalogProduct', array(
			'criteria' => $criteria,
			'pagination' => false,
		));
		
		return $dataProvider;
	}
	
	public function getSexDesc()
	{
		$result = 'Не указан';
		if ($this->sex == 1)
			$result = 'Самка';
		elseif ($this->sex == 2)
			$result = 'Самец';
		
		return $result;
	}
	
	public function getAgeDesc()
	{
		$result = '';
		if (!$this->age_y and !$this->age_m and !$this->age_w)
			$result = 'Не указан';
		else
		{
			if ($this->age_y)
				$result = $this->age_y . ' ' . $this->getYearWordForm($this->age_y);
			if ($this->age_m)
			{
				if ($result)
					$result .= ' ';
				
				$result .= $this->age_m . ' ' . $this->getMonthWordForm($this->age_m);
			}
			if ($this->age_w)
			{
				if ($result)
					$result .= ' ';
				
				$result .= $this->age_w . ' ' . $this->getWeekWordForm($this->age_w);
			}
		}	
		return $result;
	}
	
	private function getYearWordForm($year)
	{
		$result = 'год';
		while ($year > 20)
			$year = substr($year, -(strlen($year) - 1));
		
		if ($year > 1 and $year < 5)
			$result = 'года';
		elseif ($year >= 5)
			$result = 'лет';
			
		return $result;	
	}
	
	private function getMonthWordForm($month)
	{
		$result = 'месяц';
		while ($month > 20)
			$month = substr($month, -(strlen($month) - 1));
		
		if ($month > 1 and $month < 5)
			$result = 'месяца';
		elseif ($month >= 5)
			$result = 'месяцев';
			
		return $result;	
	}
	
	private function getWeekWordForm($week)
	{
		$result = 'неделя';
		while ($week > 20)
			$week = substr($week, -(strlen($week) - 1));
		
		if ($week > 1 and $week < 5)
			$result = 'недели';
		elseif ($week >= 5)
			$result = 'недель';
			
		return $result;	
	}
	
	public function getMedDesc()
	{
		$medList = $this->medList;
		if ($this->sex == 1)
		{
			$medList = array(
				1 => 'Привита', 
				2 => 'Стерилизована', 
				3 => 'Привита и стерилизована',
			);
		}
		return (array_key_exists($this->medical, $medList) ? $medList[$this->medical] : null);
	}
	
	public function getTermsDesc()
	{
		return (array_key_exists($this->terms, $this->termsList) ? $this->termsList[$this->terms] : null);
	}
	
	public static function getAttachCount()
	{
		return self::model()->count('attach=:attach', array(':attach' => 1));
	}
	
	public static function getAttachWordForm($attach)
	{
		$result = 'питомцу';
		while ($attach > 20)
			$attach = substr($attach, -(strlen($attach) - 1));
		
		if ($attach != 1)
			$result = 'питомцам';
			
		return $result;	
	}
	
	public function getCategoryTitle()
	{
		$result = 'Другие животные';
		if ($this->id_category == 1)
			$result = 'Кошки';
		elseif ($this->id_category == 2)
			$result = 'Собаки';

		return $result;
	}
}