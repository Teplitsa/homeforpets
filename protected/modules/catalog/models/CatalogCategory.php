<?php

/**
 * This is the model class for table "catalog_category".
 *
 * The followings are the available columns in table 'catalog_category':
 * @property string $id
 * @property string $title
 * @property string $link
 * @property string $image
 *
 * The followings are the available model relations:
 * @property CatalogProduct[] $catalogProducts
 */
class CatalogCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, link', 'required'),
			array('title, long_title, link, image, layout', 'length', 'max'=>256),
			array('link','unique', 'message' => 'Категория со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('keywords, description, text, product_view, long_title', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, long_title, link, image, parent_id, product_view', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'ext.SSortable.SSortableBehavior',
                'categoryField' => 'parent_id',
			),
		);

	}     

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'products' => array(self::HAS_MANY, 'CatalogProduct', 'id_category'),
			'catalogProductsForExist' => array(self::HAS_MANY, 'CatalogProduct', 'id_category','select'=>'price,brand','condition'=>'hide=0 OR hide is NULL','with'=>'productAttrubute'),
			'parent' => array(self::BELONGS_TO, 'CatalogCategory', 'parent_id'),
			'parentShort' => array(self::HAS_ONE, 'CatalogCategory', 'parent_id','select'=>'parentShort.link,parentShort.parent_id',),
			'childs' => array(self::HAS_MANY, 'CatalogCategory', 'parent_id'), 
			'allChilds' => array(self::HAS_MANY, 'CatalogCategory', 'parent_id','select'=>'t.id,t.title','order'=>'allChilds.sort_order ASC'), 
   
            //атрибуты товаров, которые используются в данной категории
            'use_attribute' => array(self::MANY_MANY, 'CatalogAttribute', 'catalog_category_attribute(id_category, id_attribute)', 'order'=>'use_attribute.sort_order',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родительская категория',
			'title' => 'Заголовок',
			'long_title' => 'Длинный заголовок',
			'link' => 'Ссылка',
			'layout' => 'Шаблон страницы',
			'product_view' => 'Отображение товаров',
			'image' => 'Изображение',
            'keywords' => 'Ключевые слова (метатег keywords)',
            'description' => 'Описание (метатег description)',
            'text' => 'Описание категории',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(isset($_GET['id']))
			$this->parent_id=$_GET['id'];
		else $this->parent_id=0;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));
	}


    protected  function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            foreach($this->catalogProducts as $product)
                $product->delete();

            return true;
        }
        else return false;
    }



    //****************************************************************************
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            // Читаем конфигурацию каталога
            $catalog_config=CatalogConfig::model()->findByPk(1);

            //Перед записью загружаем картинки

            $folder='upload/catalog/category';

            // Если это не новая запись - Берем старую модель для удаления старой картинки
            if(!$this->isNewRecord)
            {
               $old_model=CatalogCategory::model()->findByPk($this->id);
               $old_image=$old_model->image;
            }else{$old_image='';}

            // Сохраняем картинку, если она загружается
			if	($image = CUploadedFile::getInstance($this, 'image')){
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->image = $name;
				$image->saveAs($folder . '/' . $name);
				Yii::app()->ih
					->load($folder . '/' . $this->image)
					//->resize(349, false)
					//->crop(266, 266)
                    ->resizeCanvas($catalog_config->c_image_small_w, $catalog_config->c_image_small_h)
					->save($folder . '/small/' . $this->image,false,100);

                if($old_image){
                        //Удаляем старые картинки
                        @unlink($folder . '/' .$old_image);
                        @unlink($folder . '/small/' .$old_image);
                }

            // если ничего не загружается - записываем старое значение
			}else {$this->image = $old_image;}
			return true;
		}
		else
			return false;
	}


    public function getParentsCount($id)
   {
     $parent_id = $id;
     $Count=0;
       do {

           $cat = CatalogCategory::model()->findByPk($parent_id);
           if($cat==null) break;
           $parent_id = $cat->parent_id;
           $Count++;
       }while($parent_id !=0);
   return $Count;
  }

    //****************************************************************************
	public static function getListed($id=0, $first=true) 
	{
		$subitems = array();
		$space='';
		if($first && $id==0) $subitems[0] = '---';

		foreach(CatalogCategory::model()->findAll('parent_id = ' . $id) as $model) {
			$space.=' ';
			$subitems[$model->id] = $space.$model->title;
			if ($items = CatalogCategory::getListed($model->id))
			foreach ($items as $key=>$value)
				$subitems[$key] = $value;
		}
		return $subitems;
	}

    //****************************************************************************
	public static function getParents($id, $product=false) {
		$data = array();
		if ($id!=0) {
			$parents = CatalogCategory::model()->findByPk($id);
				if ($product==true)$data[$parents->title] = array('/catalog/default/index', 'id'=>$parents->id);
				while ($parents = CatalogCategory::getParent($parents->parent_id)) {
					$data[$parents->title] = array('/catalog/default/index', 'id'=>$parents->id);
				}
			$data['Каталог'] = array('/catalog/default/index');
		}
		return array_reverse($data);
	}

    //****************************************************************************
    // Возвращает массив из id дочерних
    public function getAllChildIds(){
        $allchilds=array();

        // критерии для выбора подкатегорий
        $criteria=new CDbCriteria;
		$criteria->select='id';
        $criteria->compare('parent_id', $this->id);
        $criteria->order='sort_order ASC';

        $thischilds=CatalogCategory::model()->findAll($criteria);

        foreach($thischilds as $thischild){
            $allchilds[]=$thischild->id;
            $allchilds=array_merge($allchilds, $thischild->allChildIds);
        }

        return $allchilds;
    }

    //****************************************************************************
    // Возвращает массив из дочерних категорий для построения select-списка
    public function getAllChildsList($spaced=0){
        $allchilds=array();

        // критерии для выбора подкатегорий
        $criteria=new CDbCriteria;
        $criteria->select='id,title';
        $criteria->compare('parent_id', $this->id);
        $criteria->order='sort_order ASC';

        $thischilds=CatalogCategory::model()->findAll($criteria);
        foreach($thischilds as $thischild){
            $allchilds[$thischild->id]=str_repeat ('___', $spaced).$thischild->title;
            $allchilds=$allchilds+$thischild->getAllChildsList($spaced+1);
        }

        return $allchilds;
    }
    //****************************************************************************
	public static function getParent($id) {
		$parent = CatalogCategory::model()->findByPk($id);
		return $parent;
	}

    //****************************************************************************
	public static function getBreadcrumbs($id, $product=false) {
		$data = array();
		
		if ($id!=0) {
			$parents = CatalogCategory::model()->findByPk($id);
		    $title = CatalogConfig::model()->findByPk(1)->title;
				if ($product==true)$data[$parents->title] = array('/catalog'.CatalogCategory::getCategoryRouteFast($parents));
				while ($parents = CatalogCategory::getParent($parents->parent_id)) {
					//echo $parents->title;
					$data[$parents->title] = array('/catalog'.CatalogCategory::getCategoryRouteFast($parents));
				}
			$data[$title] = array('/catalog');
		}
		//echo 'rtr'.var_dump($data);
		return array_reverse($data);
	}

    //****************************************************************************
	public static function getMenu($id=0) 
	{
		$subitems = array();

		foreach(CatalogCategory::model()->findAll('parent_id = ' . $id) as $model) {
			$subitems[] = array('label' => $model->title, 'url' => '/catalog/'.$model->link, 'active' => (strstr($_SERVER['REQUEST_URI'], '/'.$model->link)) ? true : false );
		}
		return $subitems;
	}

    //****************************************************************************
	public static function getCategoryRoute($link) {
		$criteria= new CDbCriteria();
        $criteria->select=array('t.*');
        $criteria->condition='t.link=:link';
        $criteria->params=array(':link'=>$link);
        //$criteria->with=array('parentShort');
        
        $category=CatalogCategory::model()->find($criteria);
		//echo $category->title.'<br/>';
        //if($category=CatalogCategory::model()->with('parent')->findAll(array('select'=>'t.id,parent.link','condition'=>'t.link=:link','params'=> array(':link'=>$link)))){
        if($category){
            //if (isset($category->parentShort)) {
			if($parent = CatalogCategory::model()->findByPk($category->parent_id)){
                $route=CatalogCategory::getCategoryRoute($parent->link)."/".$link;
                //$route=CatalogCategory::getCategoryRoute($category->parentShort->link)."/".$link;
            }else{$route="/".$link;}
          return $route;
        } else{
            return false;
        }

    }
	
    //****************************************************************************
	public static function getCategoryRouteFast($category) {
		if($category){
            if ($parent = CatalogCategory::model()->findByPk($category->parent_id)) {
                $route=CatalogCategory::getCategoryRouteFast($parent)."/".$category->link;
            }else{$route="/".$category->link;}
          return $route;
        } else{
            return false;
        }

    }

    //****************************************************************************
    //возвращает максимальное значение поля сортировки
	public function getMaxSortOrder(){
		$models=CatalogCategory::model()->findAll();
		foreach($models as $model) {
			$sort_orders[]=$model->sort_order;
		}
        if(!empty($sort_orders)){
            arsort($sort_orders);
            $max_order=current($sort_orders);
        } else{$max_order=0;}

		return $max_order;
	}

    public function getExistingParameters(){
        // Выбираем все товары из категории
        /*$criteria=new CDbCriteria;
        //$criteria->compare('id_category', $this->id);
        //$criteria->compare('hide', 0);
        $criteria->condition='id_category=:id_category AND (hide=0 OR hide is NULL)';
        $criteria->params=array(':id_category'=>$this->id);
        $products=CatalogProduct::model()->findAll($criteria);*/

        // Возвращаем массив используемых значений
        return CatalogProduct::getAllExistedParameters($this->catalogProductsForExist);
		//return CatalogProduct::getAllExistedParameters($products);
    }

    // Строит массив для select-списка корневой категории
    public static function getAllCategoriesList(){
        $root_category=new CatalogCategory();
        $root_category->id=0;
        return $root_category->getAllChildsList(0);
    }
	
	/**
	 * Returns custom category image
	 *
	 * @return string
	 */
	public function getCustomImage()
	{
		return $this->getCustomName() . ".svg";
	}
	
	/**
	 * Returns custom category name
	 *
	 * @return string
	 */
	public function getCustomName()
	{
		$name = 'cat';
		if ($this->id == 2)
			$name = 'dog';
		elseif ($this->id == 3)
			$name = 'bird';
		
		return $name;
	}
}