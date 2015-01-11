<?php

/**
 * Class AreaBlockController
 * Manage site area blocks
 */
class AreaBlockController extends BackEndController
{
    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'move' => 'ext.SSortable.SSortableAction',
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($areaId)
    {
        $model = new AreaBlock;
        $model->area_id = $areaId;
        $model->visible = 1;

        if (isset($_POST['AreaBlock']))
        {
            $model->attributes = $_POST['AreaBlock'];
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/area'));
        }

        $this->render('create',array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['AreaBlock']))
        {
            $model->attributes = $_POST['AreaBlock'];
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/area'));
        }

        $this->render('update',array(
            'model' => $model,

        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
     * @throws CHttpException
     *
     * @return AreaBlock
     */
    public function loadModel($id)
    {
        $model = AreaBlock::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }
}
