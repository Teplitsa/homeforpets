<?php
Yii::import('application.modules.catalog.models.CatalogCategory');

Yii::app()->clientScript->registerScript("catalog-tree","
	$(document).on('click','.hit-area',function(){
		var li = $(this).closest('li'),
			ul = $(li).children('ul');
		
		if (li.hasClass('collapsable'))
			li.addClass('expandable').removeClass('collapsable');
		else
			li.addClass('collapsable').removeClass('expandable');
			
		ul.toggle();
		
		return false;
	});
",CClientScript::POS_READY);
		
class CatalogTreeWidget extends CWidget 
{
	private $categories = array();
    
	public function run()
	{
		// Берем текущий запрос для определения активного пункта меню
        $request=Yii::app()->request->requestUri;
		
		//echo $request.'<br/>';
        $pieces=explode ('/', $request);
        // Если это товар (адрес содержит .html)
        if(strstr(end($pieces), '.')){
             // Убираем из адреса ид товара
             $request=substr ($request, 0, strlen($request)-strlen(end($pieces))-1);
        }
        
		$this->categories=CatalogCategory::model()->findAll(array('select'=>'id,link,title,parent_id','order'=>'sort_order'));
		$category_tree = $this->getCategoryTree(0, '/catalog', $pieces);
		
		$this->render('catalogtree', array('category_tree'=>$category_tree));
		
		return parent::run();
	}
	
	//выборка дочерних подкатегорий
	private function getCategoryChilds($id_category){
		$category_data = array();
		foreach ($this->categories as $category) {
			if ($category->parent_id==$id_category) {
				$category_data[]=$category;
			}
		}
		return $category_data;
	}
	
    private function getCategoryTree($id_category, $pathPrefix, $pieces='')
	{
		$tree_html = "";
        // если есть подкатегории
        if ($categories = $this->getCategoryChilds($id_category))
		{
			$tree_html.= "<ul>";
			$i = 0;
			foreach ($categories as $category)
			{
				$i++;
				// По умолчанию - закрыто
				$expanded = false;
				$link = $pathPrefix.'/'.$category->link;
				//Первый уровень через капс
			   
				$title = "<span>" . $category->title . "</span>";

					// Если запрос соответствует ссылке пункта меню - делаем его активным
				$liClass = array();
				$childrensHtml = "";
			   
				if (in_array($category->link, $pieces)) 
					$liClass[] = "active"; 
				
				// Получаем дочернее дерево
				if ($childrensHtml = $this->getCategoryTree($category->id, $link, $pieces))
				{			
					if (in_array("active", $liClass))
						$liClass[] = "collapsable";
					else
						$liClass[] = "expandable";
						
					$liClass[] = "has-child";
				}
				if($liClass || $childrensHtml)
				  $tree_html .= "<li class=\"".implode(" ", $liClass)."\">";
				else $tree_html.='<li>';
				
				if (in_array("has-child", $liClass))
					$title = "<span class=\"hit-area\"></span>" . $title;
					
				
				$tree_html.= CHtml::link($title, $link);		
				$tree_html.= $childrensHtml;
				$tree_html.= "</li>";
			}
			$tree_html.= "</ul>";
        }
        return $tree_html;
    }
	private function getCategoryTree2($id_category, $pathPrefix, $request='')
	{
		$tree_html = "";
        // если есть подкатегории
        if($categories = $this->getCategoryChilds($id_category))
		{
			$tree_html.= "<ul>";
			$i = 0;
            foreach ($categories as $category)
			{
				$i++;
                 // По умолчанию - закрыто
                $expanded = false;
                $link = $pathPrefix.'/'.$category->link;
				//Первый уровень через капс
				if ($id_category==0) 
					$title = mb_strtoupper($category->title,"UTF-8");
				else 
					$title = $category->title;

                // Если запрос соответствует ссылке пункта меню - делаем его активным
				$a_class = $li_class = $childrens = "";
                if($request==$link) 
				{
					$a_class.= " active";
					$active_node = true;
				}
                // Получаем дочернее дерево
                if ($childrens = $this->getCategoryTree($category->id, $link, $request))
				{
					$a_class.= " toggle";
					if (strpos($childrens,"class=\"active\"")) $li_class.= " collapsable";
					else $li_class.= " expandable";
				}
				if ($i == count($categories)) $li_class.=" last";
                $tree_html.= "<li class=\"".trim($li_class)."\">";
			
				 $tree_html.= CHtml::link($title, $link, array("class"=>trim($a_class)));
				
				$tree_html.= $childrens;
				$tree_html.= "</li>";
            }
			$tree_html.= "</ul>";
        }
        return $tree_html;
    }
}
?>