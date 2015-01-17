<?php

/**
 * ResponseForm class.
 */
class ResponseForm extends CFormModel
{
	public $name;
	public $phone;
	public $title;
	public $age_y;
	public $age_m;
	public $age_w;
	public $sex;
	public $city;
	public $medical;
	public $terms1;
	public $terms2;
	public $description;
	public $id_category;
	public $color;
	public $size;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
            array('name, phone, city, id_category', 'required'),
			array('sex, medical, terms1, terms2, id_category', 'numerical', 'integerOnly' => true),
			array('age_y, age_m, age_w', 'numerical', 'integerOnly' => true, 'message' => 'Годы, месяцы, недели возраста должны быть числом.'),
			array('city, color, size', 'length', 'max' => 256),
			array('title, sex, medical, terms1, terms2, id_category, age_y, age_m, age_w, description', 'safe'),
		);
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Ваше Имя',
            'phone' => 'Ваш телефон',
            'title' => 'Кличка',
            'age_y' => 'Возраст',
            'sex' => 'Пол',
            'city' => 'Город',
            'medical' => 'Стерилизация и прививки',
            'terms1' => 'Условия проживания',
            'terms2' => 'Условия проживания',
            'description' => 'История животного',
            'id_category' => 'Тип животного',
            'color' => 'Цвет(Окрас)',
            'size' => 'Размер',
		);
	}
	
	public function getProductAttributes()
	{
		$attributes = array();
		$attributes['title'] = $this->title;
		$attributes['id_category'] = $this->id_category;
		$attributes['age_y'] = $this->age_y;
		$attributes['age_m'] = $this->age_m;
		$attributes['age_w'] = $this->age_w;
		$attributes['sex'] = $this->sex;
		$attributes['city'] = $this->city;
		$attributes['medical'] = $this->medical;
		if ($this->id_category == 1)
			$attributes['terms'] = $this->terms1;
		if ($this->id_category == 2)
			$attributes['terms'] = $this->terms2;
		$attributes['description'] = $this->description;
		$attributes['curator_name'] = $this->name;
		$attributes['curator_phone'] = $this->phone;
		if ($this->id_category == 1)
			$attributes['color'] = $this->color;
		if ($this->id_category == 2)
			$attributes['size'] = $this->size;
		$attributes['hide'] = 1;
			
		return $attributes;
	}
}