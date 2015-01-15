<?php

/**
 * Модель вариантов комплектаций
 *
 */
class CatalogComplectation extends CActiveRecord
{
    // Типы. Флаг - галка, Список - выпадающий список
    public $types=array('1'=>'Флаг', '2'=>'Список');
	
    // Типы коррекции цены. 'Плюс' - пробавить значение к цене, 'Минус' - отнять значение
    // 'Равно' - установить это значение вместо текущего
    public $correctionTypes=array('0'=>'Без коррекции', '1'=>'Плюс', '2'=>'Минус', '3'=>'Равно');

    // То же самое, но в символьном виде
    public $correctionSymbol=array('0'=>'', '1'=>'+', '2'=>'-', '3'=>'=');

    // Типы отображения списков (Выпадающий или радиокнопки)
    public $displayTypes=array('0'=>'Выпадающий список', '1'=>'Радиокнопки');

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return имя таблицы
	 */
	public function tableName()
	{
		return 'catalog_complectation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('product_id, name, title','required'),
            array(
                'name',
                'unique',
                'criteria'=>array(
                        'condition'=>'product_id=:product_id',
                        'params'=>array('product_id'=>$this->product->id),
                    ),
                'message' => 'Вариант комплектации с именем {value} уже существует!',
            ),
            array('name', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('type, value, product_id, correction_type, display_type, hide_notused', 'numerical', 'integerOnly'=>true),
            array('price_correction', 'numerical', 'min'=>0),
            array('type', 'numerical', 'min'=>1),
			array('name, title, article', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title, type, value, product_id, article', 'safe', 'on'=>'search'),
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
            'complectationValues' => array(self::HAS_MANY, 'CatalogComplectationValues', 'complectation_id', 'order'=>'sort_order',),
            'thisValue' => array(self::HAS_ONE, 'CatalogComplectationValues', array('id'=>'value')),
            'product' => array(self::BELONGS_TO, 'CatalogProduct', 'product_id','with'=>array('thisCurrency','thisPriceprofile'),),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'product_id',
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
			'name' => 'Имя',
			'title' => 'Название',
			'type' => 'Тип',
			'value' => 'Значение',
			'article' => 'Артикул',
			'product_id' => 'Товар',
			'price_correction' => 'Величина коррекции цены',
			'correction_type' => 'Тип коррекции цены',
            'display_type' => 'Варианты отображения',
            'hide_notused' => 'Не показывать значение "Не выбрано"'
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
		if (($this->type<>1) && ($this->type<>2)) $this->type=1;

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('value',$this->value);
		$criteria->compare('product_id',$this->product_id);

		
		
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

    // Возвращает массив значений варианта комплектации для использования в dropList
    public function arrayValuesForList(){
        if(isset($this->hide_notused) && $this->hide_notused){
            $arrayValues['values']=array();
            $arrayValues['options']=array();
        } else {
            $arrayValues['values']=array(
                '0'=>'Не выбрано',
            );
            $arrayValues['options']=array(
                '0'=>array('title'=>''),
            );
        }

        foreach($this->complectationValues as $value){
            if($value->correction_type<>0){
                $correction='('.$value->outCorrSymbol().' '.$value->outPriceCorrectionCounted(1,'{price}',0, ',',' ').'р.)';
            } else{
                $correction='';
            }

            $arrayValues['values'][$value->id]=$value->value.'    '.$correction;
            $arrayValues['options'][$value->id]=array('title'=>$value->outCorrSymbol().$value->outPriceCorrectionCounted(1,'{price}',0));
        }
        return $arrayValues;
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
        if(isset($this->product->thisCurrency)){

            // Пересчитываем величину коррекции по курсу и возвращаем
            return $this->price_correction*$this->product->thisCurrency->getCurse()/$tocorse;

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
        if(isset($this->product->thisPriceprofile)){
            // Если установлен - применяем
            $price=$this->price_correction*$this->product->thisPriceprofile->factor+$this->product->thisPriceprofile->corrector;
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
        if(isset($this->product->thisCurrency)){

            // Пересчитываем величину коррекции по курсу и возвращаем
            return $price*$this->product->thisCurrency->getCurse()/$tocorse;

        }else{
           // Иначе возвращаем величину коррекции без изменений
            return $this->price_correction;
        }
    }

    // Выводит отформатированную величину коррекции с добавленным префиксом валюты
    public function outPriceCorrection($template='{price}', $decimals=2, $decpoint=',', $groupspace=''){
        if($this->product->thisCurrency->beforeprefix){
            return $this->product->thisCurrency->prefix.str_replace('{price}', number_format($this->price_correction, $decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', number_format($this->price_correction, $decimals, $decpoint, $groupspace), $template).$this->product->thisCurrency->prefix;
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

    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем все значения данной комплектации

            if(isset($this->complectationValues)){
                foreach($this->complectationValues as $value){
                   $value->delete();
                }
            }
            return true;
        }
        else
            return false;
    }
}