<?php

/**
 * This is the model class for table "catalog_category_existparam".
 *
 * The followings are the available columns in table 'catalog_category_existparam':
 * @property integer $id
 * @property integer $category_id
 * @property string $existparam
 */
class CatalogCategoryExistparam extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogCategoryExistparam the static model class
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
		return 'catalog_category_existparam';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('existparam', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, existparam', 'safe', 'on'=>'search'),
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
			'category_id' => 'Category',
			'existparam' => 'Existparam',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('existparam',$this->existparam,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getParams($categoryIds){

        $existedParameters=array();
        // Выбираем все массивы с используемыми значениями для всех категорий
        $criteria=new CDbCriteria;
        $criteria->compare('category_id', $categoryIds);
        $category_existparams=CatalogCategoryExistparam::model()->findAll($criteria);

        foreach($category_existparams as $category_existparam){
            $serialisedParamArray=$category_existparam->existparam;
            $paramArray=unserialize($serialisedParamArray);
            foreach($paramArray as $paramname=>$values){
                foreach($values as $value){

                    // Если массив значений для даного еще не создан - создаем его
                    if(!isset($existedParameters[$paramname])){$existedParameters[$paramname]=array();}

                    // Если текущее значение еще не присутствует в массиве - добавляем его
                    if(!in_array($value, $existedParameters[$paramname])){
                        $existedParameters[$paramname][]=$value;
                    }
                }
            }
        }
        
        return $existedParameters;
    }
}