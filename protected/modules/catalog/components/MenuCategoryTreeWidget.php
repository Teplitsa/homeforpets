<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.CatalogCategory');
/*
Класс виджета для вывода древовидного меню категорий
*/
class MenuCategoryTreeWidget extends CPortlet {

    public $cssFile;
	private $categories=array();
    
	public function	run() {

        // Берем текущий запрос для определения активного пункта меню
        $request=Yii::app()->request->requestUri;
						
		//echo $request.'<br/>';
        $pieces=explode ('/', $request);
        // Если это товар (адрес содержит .html)
        if(strstr(end($pieces), '.')){
             // Убираем из адреса ид товара
             $request=substr ($request, 0, strlen($request)-strlen(end($pieces))-1);
        }

        //$category_tree = $this->getCategoryTree(0, '/catalog', $request); старый способ
		
		$this->categories=CatalogCategory::model()->findAll(array('select'=>'id,link,title,parent_id','order'=>'sort_order'));
		$category_tree_new = $this->getCategoryTreeNew(0, '/catalog', $request);
												
		//echo var_dump($category_tree_new);
        $treeconfig['data']=$category_tree_new;
        $treeconfig['animated']='fast';
        $treeconfig['unique']=true;
        if($this->cssFile){$treeconfig['cssFile']=$this->cssFile;}

		$this->widget('CTreeView',$treeconfig);
		//$this->render('menucategorytreewidget',array('treeconfig'=>$treeconfig));
		return parent::run();
	}

    private function getCategoryTree($id_category, $pathPrefix, $request=''){


        $tree_data=array();
        //берем все подкатегории
        $categories=CatalogCategory::model()->findAll(array(
													'select'=>'id,link,title',
                                                    'condition'=>'parent_id=:parent_id',
                                                    'order'=>'sort_order',
                                                    'params'=>array('parent_id'=>$id_category),
                                                ));

        // если есть подкатегории
        if(!empty($categories)){
            foreach ($categories as $category){
                 // По умолчанию - закрыто
                $expanded=false;
                
                $link=$pathPrefix.'/'.$category->link;
				
				//Первый уровень через капс
				/*
				if ($id_category==0) {$title=mb_strtoupper($category->title,"UTF-8");}				
				else {$title=$category->title;}
				*/
				$title=$category->title;
                // Если запрос соответствует ссылке пункта меню - делаем его активным
                if($request==$link){
                    $htmlOptions=array('class'=>'active');
                    //$text=CHtml::tag('span',array(),$category->title);
                    $text=CHtml::tag('span',array(),CHtml::link($title, $link));
                    // Если элемент активен - открываем подэлементы
                    $expanded=true;
                }else{
                        $htmlOptions=array();
                        $text=CHtml::link($title, $link);
                }

                // Получаем дочернее дерево
                $children=$this->getCategoryTree($category->id, $link, $request);
                // Определяем, нет ли открытых веток
                foreach($children as $value){
                    // Если хоть одна подветка открыта - открываем всю ветку
                    if($value['expanded']){$expanded=true;}
                } 
                // Формируем элемент массива
                $tree_data[]=array(
                    'text'=>$text,
					//'closed'=>true,
                    // Строим дерево для потомков
                    'children'=>$children,
                    'expanded'=>$expanded,
                    'htmlOptions'=>$htmlOptions,
                );
            }

        }

        return $tree_data;
    }
	
	//выборка дочерних подкатегорий
	private function getCategoryChilds($id_category){
		$category_data=array();
		foreach ($this->categories as $category) {
			if ($category->parent_id==$id_category) {
				$category_data[]=$category;
			}
		}
		return $category_data;
	}
	
    private function getCategoryTreeNew($id_category, $pathPrefix, $request=''){


        $tree_data=array();
        //берем все подкатегории
        $categories=$this->getCategoryChilds($id_category);

        // если есть подкатегории
        if(!empty($categories)){
            foreach ($categories as $category){
                 // По умолчанию - закрыто
                $expanded=false;
                
                $link=$pathPrefix.'/'.$category->link;
				//Первый уровень через капс
				if ($id_category==0) {$title=mb_strtoupper($category->title,"UTF-8");}
				else {$title=$category->title;}

                // Если запрос соответствует ссылке пункта меню - делаем его активным
                if($request==$link){
                    $htmlOptions=array('class'=>'active');
					
                    //$text=CHtml::tag('span',array(),$category->title);

                     $text=CHtml::tag('span',array(),CHtml::link($title, $link));

                    // Если элемент активен - открываем подэлементы
                    $expanded=true;
                }else{
                        $htmlOptions=array();
                        $text=CHtml::link($title, $link);
                }

                // Получаем дочернее дерево
                $children=$this->getCategoryTreeNew($category->id, $link, $request);
                // Определяем, нет ли открытых веток
                foreach($children as $value){
                    // Если хоть одна подветка открыта - открываем всю ветку
                    if($value['expanded'])	{
						$expanded=true;
						//$htmlOptions=array('class'=>'closed');
					} 
                }

                // Формируем элемент массива
                $tree_data[]=array(
                    'text'=>$text,
                    // Строим дерево для потомков
                    'children'=>$children,
                    'expanded'=>$expanded,
                    'htmlOptions'=>$htmlOptions,
                );
            }

        }

        return $tree_data;
    }

}
?>
