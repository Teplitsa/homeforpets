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
			'idCategoryFast' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category','with'=>array('parentShort'),),

            // Атрибуты товара
			'productAttrubute' => array(self::HAS_MANY, 'CatalogProductAttribute', 'id_product',
                                        'order'=>'idAttribute.sort_order',
                                        'with'=>array('idAttribute','trueValue'),
            ),

            // Варианты комплектации
            'complectations' => array(self::HAS_MANY, 'CatalogComplectation', 'product_id', 'order'=>'sort_order',),

            // Валюта цены товара
            'thisCurrency' => array(self::HAS_ONE, 'CatalogCurrency', array('id'=>'currency')),

            // Ценовой профиль
            'thisPriceprofile' => array(self::HAS_ONE, 'CatalogPriceprofile', array('id'=>'priceprofile')),

            // Бренд
            'thisBrand' => array(self::HAS_ONE, 'CatalogBrands', array('id'=>'brand')),

			// Коллекция бренда
            'thisBrandCollection' => array(self::HAS_ONE, 'CatalogBrandsCollections', array('id'=>'brand_collection')),

            // Связанные (сопутствующие товары) товары
            'related_products' => array(self::MANY_MANY, 'CatalogProduct', 'catalog_relatedproducts(product_id, related_product)'),

            // Отзывы
            'reviews' => array(self::HAS_MANY, 'CatalogReviews', 'product_id'),
			
			// Ямаркет
            'yaMarket' => array(self::HAS_ONE, 'YamarketOffersettings', 'product_id'),

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
            'owner_name' => 'Имя приютивщего',
            'owner_phone' => 'Телефон приютивщего',
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

		/*$criteria->with=array('idCategory');
		$criteria->compare('idCategory.sort_order',$this->id_category,true);*/
	
		$sort = new CSort();
        $sort->defaultOrder = 't.sort_order ASC';
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
    // записывает атрибуты товара в базу данных
    public function productAttributeSave($postProductAttributes){

                // преобразуем полученный массив с целью преобразовать элементы с множественными значениями
                // в формат, удобный для разбора
                foreach($postProductAttributes as $id_attrib=>$postProductAttribute){
                    foreach($postProductAttribute as $field=>$attr_values){
                        foreach($attr_values as $key=>$attr_value){
                            $newPostProductAttributes[$id_attrib][$key][$field]=$attr_value;
                        }
                    }

                }
				
                // id атрибутов, существующих для данной категории
                $exist_attrs=array();

                // выбираем все существующие типы атрибутов
                //$existingAttributes=CatalogAttribute::model()->findAll();
                $existingAttributes=$this->idCategory->use_attribute;
                foreach($existingAttributes as $existingAttribute){
                    // Сохраняем id текущего атрибута для последующего удаления лишних значений атрибутов
                    $exist_attrs[]=$existingAttribute->id;

                    // если в пост-запросе не существует данного типа атрибута
                    if (!isset($newPostProductAttributes[$existingAttribute->id])){
                        // создаем его и обнуляем
                        $newPostProductAttributes[$existingAttribute->id][0]['value']=0;
                    }

                    //выбираем все значения данного аттрибута для данного товара
                    $attr_values=CatalogProductAttribute::model()->findAll(
                              'id_attribute=:id_attribute AND id_product=:id_product',
                              array('id_attribute'=>$existingAttribute->id, 'id_product'=>$this->id)
                    );

                    //устанавливаем на начало указатель массива значений атрибута
                    reset($newPostProductAttributes[$existingAttribute->id]);

                    // если значения для данного атрибута существуют

                    foreach($attr_values as $attr_value){

                        // если значения еще не кончились - записываем
                        if($current_value=each($newPostProductAttributes[$existingAttribute->id])){
                            $attr_value->attributes=$current_value['value'];
                            $attr_value->save();
                        } else{
                            // если больше нечего записывать - удаляем лишние значения из базы
                            $attr_value->delete();
                        }

                    }

                    // если все еще остались незаписанные значения - записываем
                    while($current_value=each($newPostProductAttributes[$existingAttribute->id])){
                        $attr=new CatalogProductAttribute;
                        $attr->attributes=$current_value['value'];
                        $attr->id_product=$this->id;
                        $attr->id_attribute=$existingAttribute->id;
                        $attr->save();
                    }




                }
        // Удаляем лишние значения атрибутов
        $condition='id_product=:id_product';
        foreach($exist_attrs as $attr_id){$condition.=' AND id_attribute<>'.$attr_id;}
        $excess_attrvalues=CatalogProductAttribute::model()->findAll(
            $condition,
            array('id_product'=>$this->id)
        );
        foreach($excess_attrvalues as $value) $value->delete();

    }
	
	public function getProductAttributes(){
		$attribute=array();
		foreach($this->productAttrubute as $attr){
			$attribute[$attr->id_attribute]=$attr;
		}
		return $attribute;
	}

    // Получить значение атрибута товара с заданным именем
    // Возвращает значение атрибута. Для типа "Список" возвращает id значения
    // Для типа "Множественный выбор" возвращает массив из id значений
    // если значение не установлено - возвращает false
    public function getProductAttributeValue($attribute_name,$filter=false){
        if($attr=CatalogAttribute::model()->find('name=:name', array('name'=>$attribute_name))){
            // Перебираем все значения атрибутов данного товара
            foreach($this->productAttrubute as $attribute_value){
                // Если находим значения требуемого атрибута - запоминаем в массив
                if($attribute_value->id_attribute==$attr->id){
					//в фильтр выводим ид для тип "Список"
					if ($filter)
						$all_values[]=$attribute_value->value;
					else {
						//если тип не "Список"
						if ($attribute_value->idAttribute->id_attribute_kind!=3)
							$all_values[]=$attribute_value->value;
						else {
							if ($value=CatalogAttributeValue::model()->findByPk($attribute_value->value))
								$all_values[]=$value->value;
						}
					}
                }
            }

            // Если найдено хотя бы одно значение - возвращаем
            if(isset($all_values)){
				//echo var_dump($all_values);
                // Если массив состоит только из одного элемента - возвращаем только его
                if(count($all_values)==1){
                    return $all_values[0];
                }else{
                    //...иначе возвращаем весь массив
                    return $all_values;
                }

            }else{
               return false;
            }
        }else{
            return false;
        }

    }

    /*
     * Возвращает массив из всех значений цены, брендов и атрибутов, которые существуют
     * для товаров из массива $products
     * Массив имеет вид $parameters[$id_attribute]=$values[], где $values - массив существующих значений
     * $id_attribute - id атрибута
     * Для цены и бренда массивы значений возвращаются соответственно
     * в элементах $parameters['price'] и $parameters['brand']
     * В случае, если ни одного значения не найдено - возвращает пустой массив
     */
    public static function getAllExistedParameters($products){
        $parameters=array();
        if(!empty($products)){
            foreach($products as $product){

                // Если массивы для цены и бренда еще не созданы - создаем их
                if(!isset($parameters['price'])){$parameters['price']=array();}
                if(!isset($parameters['brand'])){$parameters['brand']=array();}

                // Берем значение цены, если такого значения еще нет
                if(!in_array($product->price, $parameters['price'])){
                    $parameters['price'][]=$product->price;
                }

                // Берем значение бренда, если такого значения еще нет
                if(!in_array($product->brand, $parameters['brand'])){
                    $parameters['brand'][]=$product->brand;
                }

                // Берем значения атрибутов
                foreach($product->productAttrubute as $attribute_value){
                    // Если массив значений для даного еще не создан - создаем его
                    if(!isset($parameters[$attribute_value->id_attribute])){$parameters[$attribute_value->id_attribute]=array();}

                    // Если текущее значение еще не присутствует в массиве - добавляем его
                    if(!in_array($attribute_value->value, $parameters[$attribute_value->id_attribute])){
                        $parameters[$attribute_value->id_attribute][]=$attribute_value->value;
                    }

                }
            }

        }

        return $parameters;
    }

    //**********************************************************************
    // Отдает значения атрибутов товара пригодными для вывода. Массивом вида
    // $outAttrs[$name]['title'] - Название атрибута $outAttrs[$name]['value'] - Значение атрибута
    // где $name - имя атрибута
    // Если указано значение $limit - выводит только первые $limit атрибутов
    public function outAttrs($limit=-1){
        $outAttrs=array();
        $count=0;
        foreach($this->productAttrubute as $attribute){
            if($limit>=0 && $count>=$limit) break;
                $outAttrs[$attribute->idAttribute->name]['title']=$attribute->idAttribute->title;

                switch($attribute->idAttribute->id_attribute_kind){
                    case 3:
                        // Если значение типа Список - берем соответствующее значение
                        $outAttrs[$attribute->idAttribute->name]['value']=$attribute->trueValue['value'];
                        break;
                    case 4:
                        // Если значение типа - множественный выбор, то ячейка value возвращается массивом
                        $outAttrs[$attribute->idAttribute->name]['value'][]=$attribute->trueValue['value'];
                        break;
                    case 5:
                        // Если значение типа Флаг - преобразуем в "Да" и "Нет"
                        if($attribute->value){
                            $outAttrs[$attribute->idAttribute->name]['value']='Да';
                        }else{$outAttrs[$attribute->idAttribute->name]['value']='Нет';}
                        break;
                    default:
                        $outAttrs[$attribute->idAttribute->name]['value']=$attribute->value;
                        break;
                }
                $count++;
            // Если значение типа Список или Множественный выбор - берем соответствующее значение
            /*if($attribute->idAttribute->id_attribute_kind==3 || $attribute->idAttribute->id_attribute_kind==4){
                $outAttrs[$attribute->idAttribute->name]['value']=$attribute->trueValue['value'];
            }else{

                // Если значение типа Флаг - преобразуем в "Да" и "Нет"
                if($attribute->idAttribute->id_attribute_kind==5){
                    if($attribute->value){
                        $outAttrs[$attribute->idAttribute->name]['value']='Да';
                    }else{$outAttrs[$attribute->idAttribute->name]['value']='Нет';}

                }else{$outAttrs[$attribute->idAttribute->name]['value']=$attribute->value;}
            }*/

        }
        return $outAttrs;
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
			
			if	($photo = CUploadedFile::getInstance($this, 'photo')){
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

			// Пристроили
			if ($this->attach and $this->id_category < 4)
				$this->id_category += 3;
				
			// Обратно вернули
			if (!$this->attach and $this->id_category > 3)
				$this->id_category -= 3;
				
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
            foreach($this->productAttrubute as $a)
                $a->delete();
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

            // Удаляем все комплектации товара
            if(isset($this->complectations)){
                foreach($this->complectations as $complectation){
                   $complectation->delete();
                }
            }
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
    // Форматирует цену $decimals знаков после запятой, $decpoint - символ, отделяющий десятичную часть
    // $groupspace - разделитель для групп разрядов. По умолчанию - 123456,78
    public function priceFormat($decimals=2, $decpoint=',', $groupspace=''){
        return number_format($this->price, $decimals, $decpoint, $groupspace);
    }

    // Выводит отформатированную цену с добавленным префиксом валюты
    public function outPrice($template='{price}', $decimals=2, $decpoint=',', $groupspace=''){
        if($this->thisCurrency->beforeprefix){
            return $this->thisCurrency->prefix.str_replace('{price}', $this->priceFormat($decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', $this->priceFormat($decimals, $decpoint, $groupspace), $template).$this->thisCurrency->prefix;
        }
    }

    //**********************************************************************
    // Выводит отформатированную цену с добавленным префиксом валюты и применением ценового профоля
    public function outPriceProfiled($template='{price}', $decimals=2, $decpoint=',', $groupspace=''){
        // Проверяем, установлен ли ценовой профиль
        if(isset($this->thisPriceprofile)){
            $factor=$this->thisPriceprofile->factor;
            $corrector=$this->thisPriceprofile->corrector;
        } else {
            // Иначе присваиваем значения по умолчанию
            $factor=1;
            $corrector=0;
        }
        if($this->thisCurrency->beforeprefix){
            return $this->thisCurrency->prefix.str_replace('{price}', number_format(($this->price*$factor+$corrector), $decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', number_format(($this->price*$factor+$corrector), $decimals, $decpoint, $groupspace), $template).$this->thisCurrency->prefix;
        }
    }

    //**********************************************************************
    // Выводит отформатированную и пересчитанную цену
    // $currency_id - в какой валюте показывать цену (d валюты внутри системы, а не цифровой код!)
    public function outPriceCounted($currency_id=0, $template='{price}', $decimals=2, $decpoint=',', $groupspace='', $outprefix=true){

        $prefix='';
        $beforeprefix=0;
        // Если указано выводить префикс
        if($outprefix){

            // Берем указанную валюту
            if($currency=CatalogCurrency::model()->find(array('select'=>'prefix,beforeprefix','condition'=>'id=:id','params'=>array(':id'=>$currency_id)))){
                // Если валюта найдена - берем установку для префикса
                $prefix=$currency->prefix;
                $beforeprefix=$currency->beforeprefix;
            }

        }

        if($beforeprefix){
            return $prefix.str_replace('{price}', number_format($this->currencyPriceProfiled($currency_id), $decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', number_format($this->currencyPriceProfiled($currency_id), $decimals, $decpoint, $groupspace), $template).$prefix;
        }
    }

    //**********************************************************************
    // Возвращает пересчитанную цену в указанную валюту
    // Параметр $currency - id валюты внутри системы, а не цифровой код!
    public function currencyPrice($currency_id=0){

        // Загружаем указанную валюту
        if($currency=CatalogCurrency::model()->findByPk($currency_id)){
            // Берем курс найденной валюты
            $tocorse=$currency->getCurse();
        }else{
            // Если не удалось - ставим курс единицей
            $tocorse=1;
        }

        // Если для товара установлена валюта
        if(isset($this->thisCurrency)){

            // Пересчитываем цену по курсу и возвращаем
            return $this->price*$this->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем wye без изменений
            return $this->price;
        }
    }

    //**********************************************************************
    // Возвращает пересчитанную цену в указанную валюту с учетом ценового профиля
    // Параметр $currency - id валюты внутри системы, а не цифровой код!
    public function currencyPriceProfiled($currency_id=0){

        // Проверяем, установлен ли ценовой профиль
        if(isset($this->thisPriceprofile)){
            // Если установлен - применяем
            $price=$this->price*$this->thisPriceprofile->factor+$this->thisPriceprofile->corrector;
        } else {
            // Иначе оставляем цену без изменений
            $price=$this->price;
        }

        // Загружаем указанную валюту
        if($currency=CatalogCurrency::model()->find(array('select'=>'id','condition'=>'id=:id', 'params'=>array(':id'=>$currency_id)))){
            // Берем курс найденной валюты
            $tocorse=$currency->getCurse();
        }else{
            // Если не удалось - ставим курс единицей
            $tocorse=1;
        }

        // Если для товара установлена валюта
        if(isset($this->thisCurrency)){

            // Пересчитываем цену по курсу и возвращаем
            return $price*$this->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем цену без изменений
            return $price;
        }
    }

    //**********************************************************************
    // Форматирует старую цену по аналогии с priceFormat
    public function old_priceFormat($currency_id=0, $decimals=2, $decpoint=',', $groupspace=''){
        return number_format($this->currencyOldPrice($currency_id), $decimals, $decpoint, $groupspace);
    }
	
    //**********************************************************************
    // Возвращает пересчитанную цену в указанную валюту
    // Параметр $currency - id валюты внутри системы, а не цифровой код!
    public function currencyOldPrice($currency_id=0){

        // Загружаем указанную валюту
        if($currency=CatalogCurrency::model()->findByPk($currency_id)){
            // Берем курс найденной валюты
            $tocorse=$currency->getCurse();
        }else{
            // Если не удалось - ставим курс единицей
            $tocorse=1;
        }

        // Если для товара установлена валюта
        if(isset($this->thisCurrency)){

            // Пересчитываем цену по курсу и возвращаем
            return $this->old_price*$this->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем wye без изменений
            return $this->old_price;
        }
    }
	
    //**********************************************************************
    // Возвращает минимальную и максимальную цену с учетом валюты и ценового профиля
    // для данной категории и всех ее дочерних категорий
    public static function getCurrencyPriceProfiledRange($category_id=0, $currency_id=0){
        $category=new CatalogCategory();
        $category->id=$category_id;

        // Получаем массив из всей id подкатегорий, присоединяем к нему id текущей категории
        $allCategoryIds=array_merge($category->allChildIds, (array)$category_id);

        // критерии для выбора товаров
        $criteria=new CDbCriteria;
        $criteria->compare('id_category', $allCategoryIds);

        $products=CatalogProduct::model()->findAll($criteria);
        $min=0;
        $max=0;
        foreach($products as $product){
            $price=$product->currencyPriceProfiled($currency_id);
            if(!$min) $min=$price;
            if(!$max) $max=$price;
            if($price>$max) $max=$price;
            if($price<$min) $min=$price;
        }

        return compact('min', 'max');
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

    public function getRating(){

        $quantity=0;
        $sumrating=0;
        foreach($this->reviews as $review){
            if(isset($review->rating)){
                $sumrating=$sumrating+$review->rating;
                $quantity++;
            }
        }
        if($quantity){
            return $sumrating/$quantity;
        } else {return 0;}

    }

    public static function selectionProducts($selectionParameters=array(),$sort=''){
        // если переданы параметры для отбора
        if(!empty($selectionParameters)){

            // берем указанную категорию
            $category=new CatalogCategory();
            $category->id=$selectionParameters['category'];
            $allCategoryIds=array_merge($category->allChildIds, (array)$category->id);

            // Формируем критерии отбора
            $criteria=new CDbCriteria;
			$criteria->select='t.title,t.photo,t.price,t.link, t.article, t.state';
			if ($sort) $criteria->order='t.'.str_replace('.',' ',$sort);
			else $criteria->order='t.sort_order ASC';
            $criteria->with=array('productAttrubute','idCategoryFast');
            $criteria->condition='(hide=0 OR hide is NULL)';
			
			if((isset($selectionParameters['pricefrom'])) && (isset($selectionParameters['priceto'])) ) {
                   
					$criteria->compare('price','>='.$selectionParameters['pricefrom']);
				    $criteria->compare('price','<='.$selectionParameters['priceto']);;
              } 
            $criteria->compare('id_category', $allCategoryIds);

            // Если указан бренд - добавляем к критерию
            if(isset($selectionParameters['brand'])){
                if($selectionParameters['brand'][0]){
                    $criteria->compare('brand',  $selectionParameters['brand']);
                }
            }

            
            // Выбираем все товары, удовлетворяющие критериям
            $allprod=CatalogProduct::model()->findAll($criteria);

            // Отбираем товары, удовлетворяющие параметрам поиска
            $selectedProd=array();
            foreach($allprod as $product)
			{
                // Признак, берем ли данный продукт в выборку
                $addthis = true;
                // Проверяем по диапазону цены
                if(isset($selectionParameters['attributes']))
				{
                    foreach($selectionParameters['attributes'] as $attr_key => $attr_values)
					{
                        
						// Берем значения данного атрибута у товара
                        $product_attr_values = $product->getProductAttributeValue($attr_key, true);

                        // Если переданы минимальное и максимальное значения
                        if (isset($attr_values['min']) && isset($attr_values['max']))
						{
							if ($product_attr_values)
							{
								$values = (array)$product_attr_values;
								foreach($values as $val)
								{
									$addthis = ($addthis && $val>=$attr_values['min'] && $val<=$attr_values['max']);
								}
							}
                        }
						else
						{
                            // Если значения атрибута товара пересекаются с массивом требуемых значений
                            $addthis=($addthis && array_intersect((array)$product_attr_values, $attr_values));
                        }

                    }
                }
               
                if($addthis) $selectedProd[]=$product;
            }

        } else {
            // Если параметры не переданы - берем все
            $criteria=new CDbCriteria;
            $criteria->order='sort_order ASC';
            $selectedProd=CatalogProduct::model()->findAll($criteria);
        }

        return $selectedProd;
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
		elseif ($this->sex == 2)
			$result = 'Собаки';

		return $result;
	}
}