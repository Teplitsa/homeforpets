<?php
/**
 * Controller is the customized backend controller class.
 * All backend controller classes for this application should extend from this base class.
 */
class BackEndController extends BaseController
{
	public $layout = '//layouts/column2';

    public function filters()
    {
		return array(
			'accessControl',
		);
    }

    public function accessRules()
    {
        return array(
			array('allow',
				'roles' => array('admin'),
			),
            array('deny',
				'users' => array('*'),
            ),
        );
    }

    public function menuWidgets()
    {
		if (file_exists(YiiBase::getPathOfAlias("application.widgets.AdminmenuWidget") . '.php'))
			$this->widget("application.widgets.AdminmenuWidget");
			
		foreach(Yii::app()->modulesMenus as $path)
			$this->widget($path);
    }
}
?>