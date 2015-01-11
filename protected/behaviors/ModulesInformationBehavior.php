<?php

/**
 * Gets modules information
 */
class ModulesInformationBehavior extends CBehavior
{
	/**
	 * @var array $modulesMenus List of paths for modules menu widgets
	 */
    public $modulesMenus = array();

    function __construct()
    {
        foreach (Yii::app()->modules as $module => $value)
        {
			$path = 'application.modules.' . $module . '.components.' . ucwords($module) . 'AdminmenuWidget';
            if (file_exists(YiiBase::getPathOfAlias($path) . '.php'))
				$this->modulesMenus[$module] = $path;
        }
    }
}
?>