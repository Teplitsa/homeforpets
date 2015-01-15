<?php

/**
 * Модель "Бренды"
 */
class CatalogBrands extends CActiveRecord
{
	public $folder='upload/catalog/brand';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogBrands the static model class
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
		return 'catalog_brands';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'unique', 'message'=>'Бренд {value} уже существует!'),
			array('name, link', 'required'),
			array('name, link, image, country', 'length', 'max'=>255),
			array('text', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, link, image, country, text', 'safe', 'on'=>'search'),
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
			// Коллекции
            'collections' => array(self::HAS_MANY, 'CatalogBrandsCollections', 'brand_id', 'order'=>'sort_order',),
			// Товары
            'productsCount' => array(self::STAT, 'CatalogProduct', 'brand','select'=>'count(*)','condition'=>'hide=0 OR hide is NULL',),
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
			'link' => 'Ссылка',
			'image' => 'Логотип',
			'country' => 'Страна',
			'text' => 'Описание',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'name',
            ),
            'pagination'=>false,
		));
	}
	
	 //**********************************************************************
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            //Перед записью загружаем картинки

            // Если это не новая запись - Берем старую модель для удаления старой картинки
            if(!$this->isNewRecord)
            {
               $old_model=CatalogBrands::model()->findByPk($this->id);
               $old_image=$old_model->image;
            }else{
                $old_image='';
            }
			
			if	($photo = CUploadedFile::getInstance($this, 'image')){
				$name = md5(time().$photo).'.'.$photo->getExtensionName();
				$this->image = $name;
				$photo->saveAs($this->folder . '/' . $name);
		
                if($old_image){
                        //Удаляем старые картинки
                        @unlink($this->folder . '/' .$old_image);
                }
			}else {if(!$this->image) $this->image = $old_image;}

			return true;
		}
		else
			return false;
	}
	
	 //**********************************************************************
    // Удаляем связанные модели
    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем все коллекции
            if(isset($this->collections)){
                foreach($this->collections as $collection){
                   $collection->delete();
                }
            }
            return true;
        }
        else
            return false;
    }
	
    // Делает массив для dropList
    public static function arrayDropList($category=0){
        $brandsArray=array();
		$cat='';
		if ($category!=0) $cat='AND (p.id_category='.$category.')';
		$sql="SELECT b.id,b.name 
			  FROM `catalog_brands` b
			  WHERE EXISTS 
				(SELECT *
                    FROM `catalog_product` p
                      WHERE (p.hide=0 OR p.hide is NULL)
                            AND (p.brand=b.id) ".$cat."
				)
			  ORDER BY b.name";
		$brands=Yii::app()->db->createCommand($sql)->queryAll();	
        //$criteria= new CDbCriteria();
        //$criteria->select='id,name';
        // $criteria->order='name';
        
        //$brands=CatalogBrands::model()->findAll($criteria);
        foreach($brands as $brand){
				$brandsArray[$brand['id']]=$brand['name'];	
        }
        return $brandsArray;
    }
	
	// Делает массив для dropList админка
    public static function arrayDropListProd(){
        $brandsArray=array();
		$sql="SELECT b.id,b.name 
			  FROM `catalog_brands` b
			  ORDER BY b.name";
		$brands=Yii::app()->db->createCommand($sql)->queryAll();	
        //$criteria= new CDbCriteria();
        //$criteria->select='id,name';
        // $criteria->order='name';
        
        //$brands=CatalogBrands::model()->findAll($criteria);
        foreach($brands as $brand){
				$brandsArray[$brand['id']]=$brand['name'];	
        }
        return $brandsArray;
    }
	
	// Делает массив для виджета брендов
    public static function arrayWidget(){
        $brandsArray=array();

		$sql="SELECT b.name,b.link,b.country, count(b.name) as count 
			  FROM `catalog_brands` b
			  INNER JOIN `catalog_product` p 
				ON p.brand=b.id
			  WHERE (p.hide=0 OR p.hide is NULL) 
			  GROUP BY b.name 
			  ORDER BY b.name 
			  ";
	
		
		/*foreach ($brands_d as $brand_d) {
			echo $brand_d['name'].$brand_d['link'].$brand_d['country'].$brand_d['count'].'<br/>';
		}
		
        $criteria= new CDbCriteria();
        $criteria->order='name';
        
        $brands=CatalogBrands::model()->with('productsCount')->findAll($criteria);
		echo count($brands);
        foreach($brands as $brand){
            $brandInfo['name']=$brand->name;
            $brandInfo['link']=$brand->link;
            $brandInfo['country']=$brand->country;
			$brandInfo['count']=$brand->productsCount;
            if ($brandInfo['count']>0) $brandsArray[]=$brandInfo;
		}*/
		if ($brandsArray=Yii::app()->db->createCommand($sql)->queryAll()) {
			return $brandsArray;
		} else {
			return false;
		}
    }
}