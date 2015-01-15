<?php

class CatalogUrlRule extends CBaseUrlRule
// Класс правила роутинга для каталога
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return false;  // не применяем данное правило
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {

        if (preg_match('%^(/?([\w\-.]+))+$%', $pathInfo, $matches))
        {
			//разбиваем путь по слешам и берем последнюю составляющую пути
			$pages=preg_split("/\//",$pathInfo);
			//$element = end($pages);
            $element_arr=explode ('.', end($pages));
            $element=$element_arr[0];
			if (in_array('brands',$pages))
				{
				if (count($pages)==3)
					{
					if($brand = CatalogBrands::model()->find(array('select'=>'id','condition'=>'link=:link', 'params'=>array(':link'=>$element),))){
						return 'catalog/brands/index/view/'.$element;	
						}
					else return false;
						
					}
				elseif(count($pages)==4)
					{
					return 'catalog/brands/index/view/'.$pages[2].'/coll/'.$element;	
					}
				else 
					{
					return false;
					}
				}
			else{
			if($page = CatalogCategory::model()->find(array('select'=>'id','condition'=>'link=:link', 'params'=>array(':link'=>$element),))){

				// если есть - преобразуем адрес
				return '/catalog/default/category/link/'.$element;
			} else {
				// если такой категории нет - проверяем, может быть есть такой товар
                if($product = CatalogProduct::model()->find(array('select'=>'id','condition'=>'link=:link', 'params'=>array(':link'=>$element),))){
                    // если есть - преобразуем адрес
                    return '/catalog/default/product/id/'.$product->id;
                }else{
					// если нет - не применяем правило
					return false;	
					
                }

			}
			}
        }
        return false;  // не применяем данное правило
    }


}
?>