<?php

/**
 * This is the model class for table "catalog_attribute_value".
 *
 * The followings are the available columns in table 'catalog_attribute_value':
 * @property string $id
 * @property string $id_attribute
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CatalogAttributeKind $idAttributeKind
 */
class CatalogAttributeValue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogAttributeValue the static model class
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
		return 'catalog_attribute_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_attribute, value', 'required'),
			array('id_attribute', 'length', 'max'=>11),
			array('value', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_attribute, value', 'safe', 'on'=>'search'),
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
			'attribute' => array(self::BELONGS_TO, 'CatalogAttribute', 'id_attribute'),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'id_attribute',
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
			'id_attribute' => 'Атрибут',
			'value' => 'Значение',
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
		if(isset($_GET['id']))
			$this->id_attribute=$_GET['id'];
		else $this->id_attribute=0;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_attribute',$this->id_attribute);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'sort_order',
            ),
		));
	}
}