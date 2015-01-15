<?php

/**
 * Модель Ценового профиля
 *
 */
class CatalogPriceprofile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogPriceprofile the static model class
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
		return 'catalog_priceprofile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'required'),
			array('factor', 'numerical', 'min'=>0),
            array('corrector', 'numerical'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, factor, corrector', 'safe', 'on'=>'search'),
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
            'product' => array(self::BELONGS_TO, 'CatalogProduct', 'priceprofile'),
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
			'factor' => 'Множитель',
			'corrector' => 'Коррекция',
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
		$criteria->compare('factor',$this->factor);
		$criteria->compare('corrector',$this->corrector);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
		));
	}

    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            // Если не установлено значение множителя - устанавливаем в 1
            if(!$this->factor){$this->factor=1;}
            // Если не установлено значение коррекции - устанавливаем в 0
            if(!$this->corrector){$this->corrector=0;}
			return true;
		}
		else
			return false;
	}

    // Делает массив для dropList
    public static function arrayDropList(){
        $priceprofileArray=array();
        $priceprofiles=CatalogPriceprofile::model()->findAll();
        foreach($priceprofiles as $profile){
            $priceprofileArray[$profile->id]=$profile->name;
        }
        return $priceprofileArray;
    }
}