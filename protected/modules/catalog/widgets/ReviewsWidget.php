<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.user.models.User');
/*
 *Класс виджета для вывода товаров на главную страницу
 *
*/
class ReviewsWidget extends CWidget {

    public $product_id;

	public function	run() {

        // устанавливаем условие для отбора
        $criteria=new CDbCriteria;
        $criteria->order='date ASC';
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('published', 1);

        $dataProvider = new CActiveDataProvider('CatalogReviews', array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));

        $this->render('reviews',array(
            'dataProvider'=>$dataProvider,
        ));

        return parent::run();
	}

}
?>
