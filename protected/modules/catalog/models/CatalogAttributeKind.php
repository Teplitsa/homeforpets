<?php

/**
 * This is the model class for table "catalog_attribute_kind".
 *
 * The followings are the available columns in table 'catalog_attribute_kind':
 * @property string $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property CatalogAttributeValue[] $catalogAttributeValues
 */
class CatalogAttributeKind extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogAttributeKind the static model class
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
		return 'catalog_attribute_kind';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
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
			'catalogAttributeValues' => array(self::HAS_MANY, 'CatalogAttributeValue', 'id_attribute_kind'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
		);
	}


	public static function getListed() 
	{
		$subitems = array();
		foreach(CatalogAttributeKind::model()->findAll() as $model) {
			$subitems[$model->id] = $model->title;
		}
		return $subitems;
	}
}