<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class CallbackAdminmenuWidget
 */
class CallbackAdminmenuWidget extends CPortlet
{
    /**
     * Initialization
     */
    public function	init()
    {
        $this->title = 'Обратная связь';
        return parent::init();
    }

    /**
     * Running
     *
     * @throws CException
     */
    public function	run()
    {
        $this->render('adminmenu');
        return parent::run();
    }

}
?>