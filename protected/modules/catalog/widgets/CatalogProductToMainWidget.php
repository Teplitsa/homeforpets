<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.*');
/*
 *Класс виджета для вывода товаров на главную страницу
 *
*/
class CatalogProductToMainWidget extends CPortlet {

	public function	run() {

        // устанавливаем условие для отбора
        $criteria=new CDbCriteria;
        $criteria->select='t.title,t.photo,t.price,t.link, t.article, t.state';
        $criteria->compare('on_main', true);
        $criteria->with=array('idCategoryFast');

        /*$dataProvider = new CActiveDataProvider('CatalogProduct', array(
            'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
            'pagination'=>false,
        ));*/
        $products=CatalogProduct::model()->findAll($criteria);

        // Тасуем продукты
        if(is_array($products)) shuffle($products);

		$this->render('prodtomain',array(
                           'products'=>$products,
        ));
        
		return parent::run();
        
	}

}
?>
