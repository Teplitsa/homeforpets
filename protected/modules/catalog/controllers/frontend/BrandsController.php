<?php

class BrandsController extends FrontEndController
{
	public function actionIndex($view='',$coll='')
	{
		// шаблон
		$this->layout='//layouts/brands';
		
        // устанавливаем условие для отбора - бренд
        $criteria=new CDbCriteria;
        $criteria->compare('link', $view);

		if ($brand = CatalogBrands::model()->find($criteria))
			{
		
			$products_criteria=new CDbCriteria;
			
			if ($coll) 
				{
				if ($collection = CatalogBrandsCollections::model()->find(array('condition'=>'link=:link AND brand_id=:brand_id','params'=>array(':link'=>$coll,':brand_id'=>$brand->id))))
					{
					$products_criteria->condition='(brand=:brand_id) AND (brand_collection=:coll_id) AND (hide=0 OR hide is NULL)';
					$products_criteria->params=array(':brand_id'=>$brand->id,':coll_id'=>$collection->id);
			
					$this->breadcrumbs[$brand->name]=array('/catalog/brands/'.$brand->link);
					$this->breadcrumbs[]=$collection->name;
					$model=$collection;
					}
				}
			else
				{
				$products_criteria->condition='brand=:brand_id AND (hide=0 OR hide is NULL)';
				$products_criteria->params=array(':brand_id'=>$brand->id);
				
				$this->breadcrumbs[]=$brand->name;
				$model=$brand;
				}
			
			$products_criteria->with='idCategory';
			$products_criteria->order='idCategory.sort_order ASC, t.sort_order ASC';
			//$products_criteria->order='t.id_category ASC';

			$productsToShow=CatalogProduct::model()->findAll($products_criteria);

			$catArray=array();
			$i=0;
			foreach($productsToShow as $product){
				if (isset( $catArray[$product->idCategory->id]['count'])) $i=$catArray[$product->idCategory->id]['count'];
				else $i=0;
				$i++;
				$catArray[$product->idCategory->id]['count']=$i;
				$catArray[$product->idCategory->id]['title']=$product->idCategory->title;	
				$catArray[$product->idCategory->id]['link']=$product->idCategory->link;		
			}
			
			$this->render('index',array(
				'model'=>$model,
				'products'=>$productsToShow,
				'categories'=>$catArray,
			));
		}
		else
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
	}
	// Получаем список доп. товаров
    public function actionMoreProducts($id,$brand,$coll=''){
		// устанавливаем условие для отбора - бренд
        $criteria=new CDbCriteria;
        $criteria->compare('link', $brand);

		if ($brand = CatalogBrands::model()->find($criteria))
			{
		
			$products_criteria=new CDbCriteria;
			
			if ($coll) 
				{
				if ($collection = CatalogBrandsCollections::model()->find(array('condition'=>'link=:link','params'=>array(':link'=>$coll))))
					{
					$products_criteria->condition='brand=:brand_id AND brand_collection=:coll_id AND (hide=0 OR hide is NULL)';
					$products_criteria->params=array(':brand_id'=>$brand->id,':coll_id'=>$collection->id);
					}
				}
			else
				{
				$products_criteria->condition='brand=:brand_id AND (hide=0 OR hide is NULL)';
				$products_criteria->params=array(':brand_id'=>$brand->id);
				
				}
			
			$products_criteria->with='idCategory';
			$products_criteria->order='idCategory.sort_order ASC, t.sort_order ASC';
			//$products_criteria->order='t.id_category ASC';
			$productsToShowAll=CatalogProduct::model()->findAll($products_criteria);
			
			$catArray=array();
			$i=0;
			foreach($productsToShowAll as $product){
				if (isset( $catArray[$product->idCategory->id]['count'])) $i=$catArray[$product->idCategory->id]['count'];
				else $i=0;
				$i++;
				$catArray[$product->idCategory->id]['count']=$i;	
			}
			$counter=0;
			$limit=5;
			$success=false;
			foreach ($catArray as $item)
				{
					$counter+=$item['count'];
					if ($id<=$counter) 
						{
						if (!$success)
							{
							$limit=$counter-$id;
							//echo $limit;
							$success=true;
							}
						//break;
						}
					if ($limit>5) $limit=5;
				}
			if (!$success)
				{
				if ($id<=$counter) $limit=$counter-$id;
				if ($limit>5) $limit=5;
				}
			
			$products_criteria->limit=$limit;
			$products_criteria->offset=$id;
			
			$productsToShow=CatalogProduct::model()->findAll($products_criteria);
			
			$id+=$limit;
			$counter=0;
			foreach ($catArray as $item)
				{
					$counter+=$item['count'];
					if ($id==$counter) $id=0;
				}
			if ($id==$counter) $id=0;
			
			$this->renderPartial('more',array(
				'products'=>$productsToShow,
				'categories'=>$catArray,
				'id'=>$id,
				'brand'=>$brand->link,
				'coll'=>$coll,
			));
		}
		else
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
    }
}
?>