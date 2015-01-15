<?php

class CatalogModule extends CWebModule
{
    // правила роутинга для модуля
    public $urlRules=array(
        	array(
				'class' => 'application.modules.catalog.components.CatalogUrlRule',
				'connectionID' => 'db',
			),
    );
    
	public function init()
	{

		// импортируем модели и компоненты
		$this->setImport(array(
			'catalog.models.*',
			'catalog.components.*',
		));

        // прописываем пути к контроллерам и вьюшкам в зависимости от того,
        // фронтенд это или бакенд
		$this->controllerPath=$this->getControllerPath().DIRECTORY_SEPARATOR.Yii::app()->branch;
		$this->viewPath=$this->getViewPath().DIRECTORY_SEPARATOR.Yii::app()->branch;
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// Если что=нибудь понадобится сделать до запуска
            // любого действия любого контроллера - можно сделать здесь
			return true;
		}
		else
			return false;
	}
}
