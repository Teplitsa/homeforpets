<?php

/**
 * Class DefaultController
 */
class DefaultController extends BackEndController
{
    /**
     * Edits callback config
     */
    public function actionIndex()
    {
        $model = CallbackConfig::model()->find();
        if (isset($_POST['CallbackConfig']))
        {
            $model->attributes = $_POST['CallbackConfig'];
            if ($model->save())
                Yii::app()->user->setFlash('success', "Изменения успешно сохранены!");
        }
        $this->render('form', array('model' => $model));
    }
}