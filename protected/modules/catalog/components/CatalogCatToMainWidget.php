<?php

Yii::import('zii.widgets.CListView');
Yii::import('application.modules.catalog.models.CatalogCategory');
/*
Класс виджета для вывода категорий на главную страницу

*/
class CatalogCatToMainWidget extends CListView {

    public $itemView='application.modules.catalog.components.views.cattomain';
    public $template='{items}<div class="clear"></div>';
	public $htmlOptions = array(
		'class' => 'catalog-categories',
	);
	public $itemsCssClass = 'categories';

	public function	init() {

        // устанавливаем условие для отбора - корневые категории
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', 0);
		$criteria->limit = 3;

        $this->dataProvider = new CActiveDataProvider('CatalogCategory', array(
            'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
            'pagination' => false,
        ));
        
		return parent::init();
	}

	public function	run() {

		return parent::run();
        
	}

}
?>
