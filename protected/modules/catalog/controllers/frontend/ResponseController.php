<?php

class ResponseController extends BaseCatalogController
{
	public function actionIndex()
	{
		$this->metaInfoGenerate('Предложить животное', 'Предложить животное', 'Предложить животное');
		
		$model = new ResponseForm;
		if (isset($_POST['ResponseForm']))
		{
			$model->attributes = $_POST['ResponseForm'];
			if ($model->validate())
			{
				$product = new CatalogProduct('response');
				$product->attributes = $model->getProductAttributes();
				if ($product->save())
				{
					$admin = User::model()->findByPk(1);
					$body = $this->renderPartial('template', array_merge(array('product' => $product)), true);
					if (Yii::app()->getModule('callback')->sendMessage($admin->email, 'Предложение животного с сайта '.Yii::app()->config->sitename, $body))
						Yii::app()->user->setFlash('callback_message', 'Ваше предложение успешно отправлено администратору сайта.');
					else
						Yii::app()->user->setFlash('callback_message', 'В данный момент отправка предложения невозможна.');
				}
			}
		}
		$this->render('index', array('model' => $model));
	}
}