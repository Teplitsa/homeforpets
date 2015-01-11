<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property integer $id
 * @property string $sitename
 * @property string $admin_email
 */
class Config extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Siteconfig the static model class
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
        return 'config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('sitename, mainpage_id', 'required'),
            array('sitename, author', 'length', 'max' => 255),
            array('mainpage_id, adminonly', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sitename' => 'Название сайта',
            'author' => 'Автор сайта',
            'adminonly' => 'Закрыть сайт для общего доступа',
            'mainpage_id' => 'Главная страница',
        );
    }
}