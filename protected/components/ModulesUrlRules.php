<?php
/**
 * Getting routing rules from application modules
 */
class ModulesUrlRules
{
    public function getModuleRules($event)
	{
		$route = Yii::app()->getRequest()->getPathInfo();
		$module = substr($route, 0, strpos($route, '/'));
		if (Yii::app()->hasModule($module))
        {
			$module = Yii::app()->getModule($module);
            if (isset($module->urlRules))
				Yii::app()->getUrlManager()->addRules($module->urlRules);
        }
		return true;
    }
}
?>