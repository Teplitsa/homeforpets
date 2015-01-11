<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property string $id
 * @property string $title
 * @property string $name
 *
 * The followings are the available model relations:
 * @property MenuItem[] $menuItems
 */
class Menu extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Menu the static model class
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
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
			array('title, name', 'required'),
            array('title, name, items_template, activeitem_class', 'length', 'max' => 255),
            array(
				'name, activeitem_class, firstitem_class, lastitem_class', 
				'match', 
				'pattern' => '/^([a-z0-9_\-])+$/', 
				'message' => 'Поле {attribute} может содержать латинские буквы, цифры, знаки "-" и "_"',
			),
            array('name', 'unique'),
            array('id, title, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'items' => array(self::HAS_MANY, 'MenuItem', 'menu_id', 'order' => 'sort_order'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'name' => 'Имя',
            'items_template' => 'Шаблон вывода пункта меню',
            'activeitem_class' => 'Имя CSS-класса активного пункта меню',
            'firstitem_class' => 'Имя CSS-класса первого пункта меню',
            'lastitem_class' => 'Имя CSS-класса последнего пункта меню',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('name', $this->name, true);
        $criteria->with = 'items';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

	/**
	 * Returns list of menu pairs (id => title)
	 * @return array
	 */
    public static function getListed()
    {
        return CHtml::listData(self::model()->findAll(), 'id', 'title');
    }
}