<?php

/**
 * This is the model class for table "catalog_brands_collections".
 *
 * The followings are the available columns in table 'catalog_brands_collections':
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property integer $brand_id
 * @property string $text
 * @property integer $sort_order
 */
class CatalogBrandsCollections extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogBrandsCollections the static model class
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
		return 'catalog_brands_collections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, link, brand_id', 'required'),
			array('brand_id', 'numerical', 'integerOnly'=>true),
			array('name, link', 'length', 'max'=>255),
			array('text', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, link, brand_id, text', 'safe', 'on'=>'search'),
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
            // Бренд
            'thisBrand' => array(self::HAS_ONE, 'CatalogBrands', array('id'=>'brand_id')),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'brand_id',
			),
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
			'brand_id' => 'Производитель',
			'text' => 'Описание',
			'sort_order' => 'Sort Order',
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
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	    // Делает массив для dropList
    public static function arrayDropList($id){
        $collectionsArray=array();

        $criteria= new CDbCriteria();
		$criteria->compare('brand_id',$id);
        $criteria->order='name';
        
        $collections=CatalogBrandsCollections::model()->findAll($criteria);
        foreach($collections as $collection){
            $collectionsArray[$collection->id]=$collection->name;
        }
        return $collectionsArray;
    }
}