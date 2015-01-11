<?php
/**
 * Controller for edit site configuration
 */
class ConfigController extends BackEndController
{
    /**
     * Default action of controller, edits site configuration
     *
     * @throws CHttpException
     */
	public function actionIndex()
	{
		if (($model = Config::model()->find()) === null)
			throw new CHttpException(404, 'The requested page does not exist.');

        if (isset($_POST['Config']))
        {
            $model->attributes = $_POST['Config'];
            if ($model->save())
				Yii::app()->user->setFlash('success',"Изменения успешно сохранены!");   
        }

        $this->render('update', array(
            'model' => $model,
        ));
	}
}
