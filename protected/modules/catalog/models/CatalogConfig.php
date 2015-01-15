<?php

/**
 * This is the model class for table "catalog_config".
 *
 * The followings are the available columns in table 'catalog_config':
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class CatalogConfig extends CActiveRecord
{
    public $productImagesFolder='upload/catalog/product';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogConfig the static model class
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
		return 'catalog_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
            array('title, cat_perpage, product_perpage, p_image_middle_w, p_image_middle_h, p_image_small_w, p_image_small_h, c_image_small_w, c_image_small_h, watermark_x, watermark_y', 'required'),
            array('p_image_middle_w, p_image_middle_h, p_image_small_w, p_image_small_h, c_image_small_w, c_image_small_h, watermark_x, watermark_y','numerical', 'integerOnly'=>true),
            array('no_watermark', 'numerical', 'integerOnly'=>true),
			array(
							'watermark_image',
							'file',
							'types' => 'png',
							'allowEmpty' => true,
			),
            // todo сделать для cat_perpage и product_perpage сообщение на нормальном русском языке
            array('cat_perpage, product_perpage','numerical', 'integerOnly'=>true, 'min'=>1),
			array('keywords, description', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('text, layout, attached', 'safe'),
			array('id, title, keywords, description', 'safe', 'on'=>'search'),
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
			'title' => 'Название',
			'keywords' => 'Ключевые слова (метатег keywords)',
			'description' => 'Описание (метатег description)',
            'text' => 'Текстовое описание каталога',
            'layout' => 'Шаблон первой страницы',
            'cat_perpage' => 'Категорий на странице',
            'product_perpage' => 'Товаров на странице',
            'c_image_small_w'=>'Ширина превью',
            'c_image_small_h'=>'Высота превью',
            'p_image_middle_w'=>'Ширина среднего превью',
            'p_image_middle_h'=>'Высота среднего превью',
            'p_image_small_w'=>'Ширина малого превью',
            'p_image_small_h'=>'Высота малого превью',
            'watermark_image'=>'Картинка водяного знака',
            'no_watermark'=>'Не накладывать водяной знак',
            'watermark_x'=>'Отступ по горизонтали',
            'watermark_y'=>'Отступ по вертикали',
            'attached'=>'Кол-во пристроенных',
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
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeSave()
	{
        $catalog_config=CatalogConfig::model()->findByPk($this->id);
        $old_image=$catalog_config->watermark_image;
		if(parent::beforeSave()){
			if	($image = CUploadedFile::getInstance($this, 'watermark_image')){
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->watermark_image = $name;
				$image->saveAs($this->productImagesFolder . '/watermark/' . $name);

                //Удаляем старую картинку
                @unlink($this->productImagesFolder . '/watermark/' . $old_image);
                
			}else {$this->watermark_image = $old_image;}
            return true;
		}
		else
			return false;
	}
}