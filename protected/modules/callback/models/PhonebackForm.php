<?php

/**
 * Class PhonebackForm
 */
class PhonebackForm extends CFormModel
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $phone;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('name, company, phone', 'required'),
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
            'name' => 'Ваше имя',
            'company' => 'Название организации',
            'phone' => 'Контактный телефон',
        );
    }
}