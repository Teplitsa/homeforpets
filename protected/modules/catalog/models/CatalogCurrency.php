<?php

/**
 * This is the model class for table "catalog_currency".
 *
 * The followings are the available columns in table 'catalog_currency':
 * @property integer $id
 * @property string $title
 * @property double $cursetorub
 * @property string $prefix
 * @property integer $beforeprefix
 * @property integer $curseauto
 */
class CatalogCurrency extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogCurrency the static model class
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
		return 'catalog_currency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, code', 'required'),
			array('beforeprefix, curseauto', 'numerical', 'integerOnly'=>true),
			array('cursetorub', 'numerical'),
			array('title', 'length', 'max'=>255),
			array('prefix', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, cursetorub, prefix, beforeprefix, curseauto', 'safe', 'on'=>'search'),
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
			'title' => 'Название валюты',
            'code' => 'Цифровой код валюты',
			'cursetorub' => 'Курс к рублю',
			'prefix' => 'Обозначение',
			'beforeprefix' => 'Ставить впереди суммы',
			'curseauto' => 'Получать курс автоматически',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('cursetorub',$this->cursetorub);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('beforeprefix',$this->beforeprefix);
		$criteria->compare('curseauto',$this->curseauto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    // Возвращает значение курса данной валюты
    public function getCurse(){

             // Если указано брать курс автоматически
            if($this->curseauto){
                Yii::import('application.modules.catalog.extensions.cbr.CBRCurrency');

                // Берем курс с сайта cbr.ru
                $cbr = new CBRCurrency();

                // Если установлен курс - берем его
                if(isset($cbr->currency[$this->code]['value'])){
                    $curse=$cbr->currency[$this->code]['value']/$cbr->currency[$this->code]['nominal'];

                } else{
                    // Если курса не найдено - устанавливаем его в единицу
                    $curse=1;
                }
            } else {
                // Иначе берем ручной курс, если он установлен
                if(!isset($this->cursetorub)){
                    // а если не установлен - делаем курс единицей
                    $curse=1;
                }else{
                    $curse=$this->cursetorub;
                }
            }

            return $curse;
    }

    // Делает массив для dropList
    public static function arrayDropList(){
        $currencyArray=array();
        $currency=CatalogCurrency::model()->findAll();
        foreach($currency as $cur){
            $currencyArray[$cur->id]=$cur->title;
        }
        return $currencyArray;
    }
}