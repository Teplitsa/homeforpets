<?php

Yii::import('zii.widgets.CPortlet');
class CatalogAdminmenuWidget extends CPortlet 
{
	public function	init() 
	{
		$this->title = 'Каталог животных';
		return parent::init();
	}

	public function	run() {
		$this->render('catalog_adminmenu');
		return parent::run();
	}

}
?>
