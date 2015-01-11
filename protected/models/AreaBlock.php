<?php

/**
 * This is the model class for table "area_block".
 *
 * The followings are the available columns in table 'area_block':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $area_id
 * @property integer $visible
 * @property string $content
 * @property string $view
 * @property string $css_class
 */
class AreaBlock extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return AreaBlock the static model class
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
        return 'area_block';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('area_id, visible', 'numerical', 'integerOnly'=>true),
            array('name, title, view, css_class', 'length', 'max'=>255),
            array('name, title', 'required'),
            array('name', 'unique', 'message' => 'Блок с именем {value} уже существует!'),
            array('name', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, title, area_id, visible, content', 'safe', 'on'=>'search'),
        );
    }

    public function behaviors()
    {
        return array(
            'SSortableBehavior' => array(
                'class' => 'ext.SSortable.SSortableBehavior',
                'categoryField' => 'area_id',
            ),
        );

    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'area' => array(self::BELONGS_TO, 'Area', 'area_id'),
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
            'area_id' => 'Область вывода',
            'visible' => 'Отображать',
            'content' => 'Содержание',
            'view' => 'Вид (view) для отображения виджета блока',
            'css_class' => 'CSS-класс блока',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name,true);
        $criteria->compare('title', $this->title,true);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('visible', $this->visible);
        $criteria->compare('content', $this->content,true);
        $criteria->compare('css_class', $this->css_class,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns available block view file names
     * @return array
     */
    public function getViews()
    {
        return array(
           'areablock' => 'Блок с заголовком',
           'areablocknotitle' => 'Блок без заголовка',
        );
    }
}