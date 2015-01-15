<?php

/**
 * Модель Значений вариантов комплектации
 */
class CatalogComplectationValues extends CActiveRecord
{
    // Типы коррекции цены. 'Плюс' - пробавить значение к цене, 'Минус' - отнять значение
    // 'Равно' - установить это значение вместо текущего
    public $correctionTypes=array('0'=>'Без коррекции', '1'=>'Плюс', '2'=>'Минус', '3'=>'Равно');

    // То же самое, но в символьном виде
    public $correctionSymbol=array('0'=>'', '1'=>'+', '2'=>'-', '3'=>'=');

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_complectation_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('value','required'),
			array('complectation_id, correction_type, sort_order', 'numerical', 'integerOnly'=>true),
			array('price_correction', 'numerical', 'min'=>0),
			array('value, article', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, complectation_id, value, price_correction, correction_type, article', 'safe', 'on'=>'search'),
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
            'complectation' => array(self::BELONGS_TO, 'CatalogComplectation', 'complectation_id'),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'complectation_id',
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
			'complectation_id' => 'Вариант комплектации',
			'value' => 'Значение',
			'article' => 'Артикул',
			'price_correction' => 'Величина коррекции цены',
			'correction_type' => 'Тип коррекции цены',
            'sort_order' => 'Порядок сортировки',
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
		$criteria->compare('complectation_id',$this->complectation_id);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('price_correction',$this->price_correction);
		$criteria->compare('correction_type',$this->correction_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    // Безопасно выводит тип коррекции, защищая от ошибки в случае, если значение в базе null
    public function outCorrType(){
        if(isset($this->correctionTypes[$this->correction_type])){
            return $this->correctionTypes[$this->correction_type];
        } else {return "Не установлено";}
    }

    // То же самое для символьного вида
    public function outCorrSymbol(){
        if(isset($this->correctionSymbol[$this->correction_type])){
            return $this->correctionSymbol[$this->correction_type];
        } else {return "Не установлено";}
    }

    // Возвращает пересчитанную в указанную валюту величину коррекции
    // Параметр $currency - id валюты внутри системы, а не цифровой код!
    public function currencyPriceCorrection($currency_id=0){

        // Загружаем указанную валюту
        if($currency=CatalogCurrency::model()->findByPk($currency_id)){
            // Берем курс найденной валюты
            $tocorse=$currency->getCurse();
        }else{
            // Если не удалось - ставим курс единицей
            $tocorse=1;
        }

        // Если для товара установлена валюта
        if(isset($this->complectation->product->thisCurrency)){

            // Пересчитываем величину коррекции по курсу и возвращаем
            return $this->price_correction*$this->complectation->product->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем величину коррекции без изменений
            return $this->price_correction;
        }
    }

    //**********************************************************************
    // Возвращает пересчитанную цену в указанную валюту с учетом ценового профиля
    // Параметр $currency - id валюты внутри системы, а не цифровой код!
    public function currencyPriceProfiled($currency_id=0){

        // Проверяем, установлен ли ценовой профиль
        if(isset($this->complectation->product->thisPriceprofile)){
            // Если установлен - применяем
            $price=$this->price_correction*$this->complectation->product->thisPriceprofile->factor+$this->complectation->product->thisPriceprofile->corrector;
        }else{
            // Иначе - берем цену как есть
            $price=$this->price_correction;
        }

        // Загружаем указанную валюту
        if($currency=CatalogCurrency::model()->findByPk($currency_id)){
            // Берем курс найденной валюты
            $tocorse=$currency->getCurse();
        }else{
            // Если не удалось - ставим курс единицей
            $tocorse=1;
        }

        // Если для товара установлена валюта
        if(isset($this->complectation->product->thisCurrency)){

            // Пересчитываем величину коррекции по курсу и возвращаем
            return $price*$this->complectation->product->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем величину коррекции без изменений
            return $this->price_correction;
        }
    }

    // Выводит отформатированную величину коррекции с добавленным префиксом валюты
    public function outPriceCorrection($template='{price}', $decimals=2, $decpoint=',', $groupspace=''){
        if($this->complectation->product->thisCurrency->beforeprefix){
            return $this->complectation->product->thisCurrency->prefix.str_replace('{price}', number_format($this->price_correction, $decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', number_format($this->price_correction, $decimals, $decpoint, $groupspace), $template).$this->complectation->product->thisCurrency->prefix;
        }
    }

    // Выводит отформатированную и пересчитанную величину коррекции
    // $currency_id - в какой валюте показывать цену (d валюты внутри системы, а не цифровой код!)
    public function outPriceCorrectionCounted($currency_id=0, $template='{price}', $decimals=2, $decpoint=',', $groupspace=''){

        return str_replace('{price}', number_format($this->currencyPriceProfiled($currency_id), $decimals, $decpoint, $groupspace), $template);

    }

    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->article=trim($this->article);
            // Если установлено "Без коррекции" - убираем значение коррекции
            if($this->correction_type==0){$this->price_correction='';}
			return true;
		}
		else
			return false;
	}
}