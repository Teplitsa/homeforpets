<?php

/**
 * This is the model class for table "catalog_pricetypes".
 *
 * The followings are the available columns in table 'catalog_pricetypes':
 * @property integer $id
 * @property string $name
 * @property integer $ident_field
 * @property integer $price_field
 */
class CatalogPricetypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogPricetypes the static model class
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
		return 'catalog_pricetypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, ident_field, price_field , brand_id', 'required'),
			array('ident_field, price_field', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('brand_id', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ident_field, price_field,  brand_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'ident_field' => 'Поле артикула',
			'price_field' => 'Поле цены',
			'brand_id' => 'Бренд',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ident_field',$this->ident_field);
		$criteria->compare('price_field',$this->price_field);
		$criteria->compare('brand_id',$this->brand_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function loadDataFromFile($filename){

        $data=array();

        $phpExcelPath = Yii::getPathOfAlias('ext.excel');

        // Выключаем автоподгрузку классов
        spl_autoload_unregister(array('YiiBase','autoload'));
        //Подключаем библиотеку
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

        // Включаем автоподгрузку файлов
        spl_autoload_register(array('YiiBase','autoload'));

        foreach($sheetData as $row){
            if(!empty($row[$this->ident_field]))// && !empty($row[$this->price_field]))
                                $data[trim($row[$this->ident_field])]=0+$row[$this->price_field];
        }

        return $data;

    }

    // Получаем массив изменяемых товаров для подтверждения действия
    public function  getProductsToChangeArray($filename){
        $productsToChange=array();

        $price_data=$this->loadDataFromFile($filename);

        $articles=array_keys($price_data);
        $criteria=new CDbCriteria;
        $criteria->compare('article', $articles);
        $criteria->compare('brand', $this->brand_id);
        $criteria->order='sort_order ASC';

        if($products=CatalogProduct::model()->findAll($criteria)){
            foreach($products as $product){
                $prod=array(
                    'id'=>$product->id,
                    'title'=>$product->title,
                    'article'=>$product->article,
                    'currency'=>$product->thisCurrency->prefix,
                    'old_price'=>$product->price,
                    'new_price'=>$price_data[trim($product->article)],
                );
                $productsToChange[]=$prod;
            }
        }
        return $productsToChange;
    }
	
    // Получаем массив изменяемых товаров для подтверждения действия
    public function  getProductsToNoChangeArray($filename){
        $noChange=array();
		$productsToChange=array();
		$complectsToChange=array();
		$complectsListToChange=array();

        $price_data=$this->loadDataFromFile($filename);

        $articles=array_keys($price_data);
        $criteria=new CDbCriteria;
        $criteria->compare('brand', $this->brand_id);
        $criteria->order='sort_order ASC';

        if($products=CatalogProduct::model()->findAll($criteria)){
            foreach($products as $product){		
				$error=null;
				if ($product->article=='') 
					{
					$error='Не указан артикул';
					}
				else
					{
					if (in_array($product->article,$articles)) 
						{
						if (($price_data[trim($product->article)]=='')||(!is_numeric($price_data[trim($product->article)])))
							{
							$error='Цена пустая';
							}
						}
					else
						{
						$error='Артикул указан, но в прайс-листе не найден соответствующий';
						}					
					}
				if ($error!=null)
					{
					$prod=array(
						'id'=>$product->id,
						'title'=>$product->title,
						'article'=>$product->article,
						'error'=>$error,
						);
					$productsToChange[]=$prod;
					}
            }
        }
		$noChange[]=$productsToChange;

        if($complects=CatalogComplectation::model()->findAll(array('condition'=>'type = 1','order'=>'sort_order ASC'))){
            foreach($complects as $complect)
				{	
					if (count($complect->product)>0)
						{
							if ($complect->product->brand==$this->brand_id)
							{
								{
								$error=null;
								if ($complect->article=='') 
									{
									$error='Не указан артикул';
									}
								else
									{
									if (in_array($complect->article,$articles)) 
										{
										if (($price_data[trim($complect->article)]=='')||(!is_numeric($price_data[trim($complect->article)])))
											{
											$error='Цена пустая';
											}
										}
									else
										{
										$error='Артикул указан, но в прайс-листе не найден соответствующий';
										}					
									}
								if (($error!=null)&&((($complect->article!='')||($complect->article!=0))||(($complect->price_correction!='')||($complect->price_correction!=0))))
									{
									$prod=array(
										'id'=>$complect->product_id,
										'product'=>$complect->product->title,
										'title'=>$complect->title,
										'article'=>$complect->article,
										'error'=>$error,
										);
									$complectsToChange[]=$prod;
									}
								}
							}
						}
					 
				}
			}
		$noChange[]=$complectsToChange;
		
        if($complectsList=CatalogComplectation::model()->findAll(array('condition'=>'type = 2','order'=>'sort_order ASC'))){
            foreach($complectsList as $complectList)
				{	 
					
					if (count($complectList->product)>0)
						{
							if ($complectList->product->brand==$this->brand_id)
							{
								if ($values=CatalogComplectationValues::model()->findAll(array('condition'=>'complectation_id = :id','params'=>array(':id'=>$complectList->id),'order'=>'sort_order ASC')))
								{
								foreach($values as $value)
									{
										$error=null;
										if ($value->article=='') 
											{
											$error='Не указан артикул';
											}
										else
											{
											if (in_array($value->article,$articles)) 
												{
												if (($price_data[trim($value->article)]=='')||(!is_numeric($price_data[trim($value->article)])))
													{
													$error='Цена пустая';
													}
												}
											else
												{
												$error='Артикул указан, но в прайс-листе не найден соответствующий';
												}					
											}
										if (($error!=null)&&((($value->article!='')||($value->article!=0))||(($value->price_correction!='')||($value->price_correction!=0))))
											{
											$prod=array(
												'id'=>$complectList->product_id,
												'product'=>$complectList->product->title,
												'value'=>$value->value,
												'title'=>$complectList->title,
												'article'=>$value->article,
												'error'=>$error,
												);
											$complectsListToChange[]=$prod;
											}
									}
								}
							}
						}
					 
				}
			}
		$noChange[]=$complectsListToChange;
		
        return $noChange;
    }	

    // Применяем изменения согласно загруженному прайс-листу
    public function acceptParameters($filename){
        $success=true;
        $price_data=$this->loadDataFromFile($filename);

        $articles=array_keys($price_data);
        $criteria=new CDbCriteria;
        $criteria->compare('article', $articles);
		$criteria->compare('brand', $this->brand_id);

        if($products=CatalogProduct::model()->findAll($criteria)){
            foreach($products as $product){
                $product->price=$price_data[trim($product->article)];
                if(!$product->save()) $success=false;
            }
        } else $success=false;
		/*
		if($complects=CatalogComplectation::model()->findAll(array('condition'=>'type = 1','order'=>'sort_order ASC'))){
            foreach($complects as $complect)
				{	
				if (count($complect->product)>0)
					{
					if ($complect->product->brand==$this->brand_id)
						{
						if (in_array($complect->article,$articles))
							{
							$complect->price_correction=$price_data[trim($complect->article)];	
							if(!$complect->save()) $success=false;
							}
						}
					}
				}
			} else $success=false;
			
		if($complectsList=CatalogComplectation::model()->findAll(array('condition'=>'type = 2','order'=>'sort_order ASC'))){
            foreach($complectsList as $complectList)
				{	 
					
					if (count($complectList->product)>0)
						{
							if ($complectList->product->brand==$this->brand_id)
							{
								if ($values=CatalogComplectationValues::model()->findAll(array('condition'=>'complectation_id = :id','params'=>array(':id'=>$complectList->id),'order'=>'sort_order ASC')))
								{
								foreach($values as $value)
									{
									if (in_array($value->article,$articles))
										{
										$value->price_correction=$price_data[trim($value->article)];	
										if(!$value->save()) $success=false;
										}
									}
								}
							}
						}
					}
			} else $success=false;
    */
        return $success;
    }

    public static function getTypelist(){
        $typesArray=array();

        $types=CatalogPricetypes::model()->findAll();
        foreach($types as $type){
            $typesArray[$type->id]=$type->name;
        }
        return $typesArray;
    }
	
    public static function getBrandlist(){
        $brandsArray=array();

        $brands=CatalogBrands::model()->findAll(array('order'=>'name ASC'));
        foreach($brands as $brand){
           $brandsArray[$brand->id]=$brand->name;
        }
        return $brandsArray;
    }
	
    public function getBrands(){
		
		$this->brand_id = $this->brand_id === null ? 0 : $this->brand_id;
		$lists=CatalogPricetypes::model()->getBrandlist();
		if (count(CatalogBrands::model()->findByPK($this->brand_id)) == 0) return false;
		else return $lists[$this->brand_id];
    }

}