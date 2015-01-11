<?php
/**
 * Controller is the customized frontend controller class.
 * All frontend controller classes for this application should extend from this base class.
 */
class FrontEndController extends BaseController
{
    public function beforeAction(CAction $action)
    {
        // Если заход на страницу авторизации или на заглушку - пускаем
		if (in_array($action->id, array('login', 'cap')))
			return parent::beforeAction($action);
        // Если установлено "Закрыть общий доступ к сайту" и при этом смотрит не админ -
        // Показываем заглушку
		if (Yii::app()->config->adminonly and Yii::app()->user->isGuest)
			$this->redirect('/site/cap');
		   
		return parent::beforeAction($action);
    }
}
?>