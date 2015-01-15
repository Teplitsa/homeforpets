<?php

/**
 * This is the model class for table "catalog_reviews".
 *
 * The followings are the available columns in table 'catalog_reviews':
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property string $text
 * @property integer $rating
 * @property integer $date
 */
class CatalogReviews extends CActiveRecord
{
    // Проверочный код для капчи
    public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogReviews the static model class
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
		return 'catalog_reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('product_id, text', 'required'),
            array('rating', 'numerical'),
			array('product_id, user_id, date, published', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>1000),
            array(
                'verifyCode',
                'captcha',
                'message'=>'Неверный защитный код',
                // авторизованным пользователям код можно не вводить
                'allowEmpty'=>Yii::app()->getModule('user')->isAdmin() || !extension_loaded('gd')
            ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, user_id, text, rating, date', 'safe', 'on'=>'search'),
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
            // Товар
			'product' => array(self::BELONGS_TO, 'CatalogProduct', 'product_id'),

            // Пользователь
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Товар',
			'user_id' => 'Пользователь',
			'text' => 'Текст отзыва',
			'rating' => 'Оценка',
			'date' => 'Дата',
            'published'=>'Опубликовано',
            'verifyCode' => 'Проверочный код',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('date',$this->date);
        $criteria->order='date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>30,
            ),
		));
	}

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->date=time();
                if(!isset($this->user_id))
                    $this->user_id=Yii::app()->user->id;
            }
            return true;
        }
        else
            return false;
    }
}