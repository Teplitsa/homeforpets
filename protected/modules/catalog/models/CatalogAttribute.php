<?php

/**
 * This is the model class for table "catalog_attribute".
 *
 * The followings are the available columns in table 'catalog_attribute':
 * @property string $id
 * @property string $title
 * @property string $id_attribute_kind
 * @property integer $required
 *
 * The followings are the available model relations:
 * @property CatalogAttributeValue $idAttributeKind
 * @property CatalogProductAttribute[] $catalogProductAttributes
 */
class CatalogAttribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogAttribute the static model class
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
		return 'catalog_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, name, id_attribute_kind', 'required'),
			array('required, alphasort', 'numerical', 'integerOnly'=>true),
			array('title, name', 'length', 'max'=>256),
            array('name','unique', 'message' => 'Атрибут с именем {value} уже существует!'),
            array('name', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('id_attribute_kind', 'length', 'max'=>11),
			array('on_filter, on_table', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, id_attribute_kind, required, on_filter, on_table', 'safe', 'on'=>'search'),
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
			'kind' => array(self::BELONGS_TO, 'CatalogAttributeKind', 'id_attribute_kind'),
			'ProductAttributes' => array(self::HAS_MANY, 'CatalogProductAttribute', 'id_attribute'),
			'values' => array(self::HAS_MANY, 'CatalogAttributeValue', 'id_attribute', 'order'=>'sort_order',),
            'values_sorted' => array(self::HAS_MANY, 'CatalogAttributeValue', 'id_attribute',
                                        'order'=>'values_sorted.value ASC',
            ),

            // категории товаров, в которых используется данный атрибут
            'use_category' => array(self::MANY_MANY, 'CatalogCategory', 'catalog_category_attribute(id_attribute, id_category)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'name' => 'Имя',
			'title' => 'Заголовок',
			'id_attribute_kind' => 'Тип',
			'required' => 'Обязательно для заполнения',
            'alphasort' => 'Сортировать значения по алфавиту',
            'on_filter' => 'Использовать в фильтре',
            'on_table' => 'Показывать в таблице',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('id_attribute_kind',$this->id_attribute_kind,true);
		$criteria->compare('required',$this->required);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'sort_order',
            ),
		));
	}

    public function behaviors(){
      return array(
            /*'CAdvancedArBehavior' => array(
                'class' => 'application.extensions.EAdvancedArBehavior.EAdvancedArBehavior',
            ),*/
		    'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
			),
      );
    }

    //**********************************************************************
    // Удаляем связанные модели
    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем значения атрибутов товаров
            if(isset($this->ProductAttributes)){
                foreach($this->ProductAttributes as $attribute) $attribute->delete();
            }

            // Удаляем наборы значений атрибутов
            if(isset($this->values)){
                foreach($this->values as $value) $value->delete();
            }

            return true;
        }
        else
            return false;
    }

}


