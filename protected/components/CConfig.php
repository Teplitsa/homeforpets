<?php
/**
 * Site configuration component
 */
class CConfig extends CApplicationComponent
{
	/**
	 * $var array $_params
	 */
    private $_params = array();
	
	/**
	 * Component initialization
	 */
	public function init()
	{
		if ($config = Config::model()->find())
			$this->_params = $config->attributes;
	}

    /**
	 * Redefine magic get
     * @param string $param
     * @return mixed|null
     */
    public function __get($param)
    {
		if (array_key_exists($param, $this->_params))
			return $this->_params[$param];
        else
			return parent::__get($param);
    }
}