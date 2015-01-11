<?php
Yii::import('zii.widgets.CPortlet');
class AdminmenuWidget extends CPortlet
{
	public function	init() 
	{
		$this->title = 'Конфигурация';
		return parent::init();
	}

	public function	run() 
	{
		$this->render('adminmenu');
		return parent::run();
	}

}
?>