<?php

/**
 * Class DefaultController
 */
class DefaultController extends FrontEndController
{
    /**
     * @return array
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'testLimit' => '1',
            ),

        );
    }

    /**
     * Returns form for send message to admin
     *
     * @throws CException
     */
    public function actionIndex()
    {
        $this->metaInfoGenerate('Отправка сообщения', '', '');
        $this->breadcrumbs[] = 'Отправка сообщения';
        $model = new CallbackForm;
        if (isset($_POST['CallbackForm']))
        {
            $model->attributes = $_POST['CallbackForm'];
            if ($model->validate())
            {
                $admin = User::model()->findByPk(1);
                $body = $this->renderPartial('callback_template', array_merge(array('model' => $model)), true);
                if ($this->module->sendMessage($admin->email, 'Сообщение с сайта '.Yii::app()->config->sitename, $body))
                    Yii::app()->user->setFlash('callback_message', 'Ваше сообщение успешно отправлено администратору сайта.');
                else
                    Yii::app()->user->setFlash('callback_message', 'В данный момент отправка сообщений невозможна.');

                $this->refresh();
            }
        }

        $this->render('index', array('model' => $model));
    }


    /**
     * Returns form for phoneback request
     *
     * @throws CException
     */
    public function actionPhoneback()
    {
        $this->metaInfoGenerate('Просьба перезвонить', '', '');
        $this->breadcrumbs[] = 'Просьба перезвонить';
        $model = new PhonebackForm;
        if (isset($_POST['PhonebackForm']))
        {
            $model->attributes = $_POST['PhonebackForm'];
            if ($model->validate())
            {
                $admin = User::model()->findByPk(1);
                $body = $this->renderPartial('phoneback_template', array_merge(array('model' => $model)), true);
                if ($this->module->sendMessage($admin->email, 'Просьба перезвонить '.Yii::app()->config->sitename, $body))
                    Yii::app()->user->setFlash('callback_message', 'Ваше сообщение успешно отправлено администратору сайта.');
                else
                    Yii::app()->user->setFlash('callback_message', 'В данный момент отправка сообщений невозможна.');

                $this->refresh();
            }
        }

        $this->render('phoneback', array('model' => $model));
    }
}