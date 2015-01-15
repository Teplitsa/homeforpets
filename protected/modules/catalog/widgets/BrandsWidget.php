<?php
Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.CatalogBrands');
Yii::import('application.modules.catalog.models.CatalogProduct');
/*
Класс виджета для вывода списка брендов
*/
class BrandsWidget extends CWidget {
    
	public $name;
	
	public function	run() {

        $brand_list=CatalogBrands::arrayWidget();
        if($this->name=="brands-carusel")
		{
		 $allBrands = CatalogBrands::model()->findAll();
		  
		 $this->render('brandsCarusel', array(
             'brand_list'=>$allBrands,
        ));
		}
		else
		$this->render('brands', array(
             'brand_list'=>$brand_list,
        ));
		return parent::run();
	}
}
?>
