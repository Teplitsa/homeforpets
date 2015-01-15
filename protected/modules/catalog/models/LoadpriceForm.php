<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class LoadpriceForm extends CFormModel
{
	public $pricetype;
	public $filename;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
            array('pricetype', 'required', 'message'=>'Выберите {attribute}'),
            array('pricetype', 'numerical', 'integerOnly'=>true),
            array('filename', 'file', 'types'=>'xls,xlsx', 'message'=>'Выберите {attribute}'),
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
			'pricetype' => 'Тип прайс-листа',
            'filename' => 'Файл для загрузки',
		);
	}
}