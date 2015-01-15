<?php

/**
 * This is the model class for table "catalog_product_attribute".
 *
 * The followings are the available columns in table 'catalog_product_attribute':
 * @property string $id
 * @property string $id_product
 * @property string $id_attribute
 * @property string $title
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CatalogAttribute $idAttribute
 * @property CatalogProduct $idProduct
 */
class CatalogProductAttribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogProductAttribute the static model class
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
		return 'catalog_product_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_attribute', 'required'),
			array('id_product, id_attribute', 'length', 'max'=>11),
			array('value, image', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_product, id_attribute, value, image', 'safe', 'on'=>'search'),
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
			'idAttribute' => array(self::BELONGS_TO, 'CatalogAttribute', 'id_attribute'),
			'idProduct' => array(self::BELONGS_TO, 'CatalogProduct', 'id_product'),
            'trueValue' => array(self::HAS_ONE, 'CatalogAttributeValue', array('id'=>'value')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_product' => 'Id Product',
			'id_attribute' => 'Id Attribute',
			'value' => 'Значение',
			'image' => 'Картинка',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_attribute',$this->id_attribute,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}