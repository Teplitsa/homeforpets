<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $menu_id
 * @property string $title
 * @property string $link
 *
 * The followings are the available model relations:
 * @property Menu $menu
 */
class MenuItem extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return MenuItem the static model class
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
        return 'menu_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('menu_id, title, link', 'required'),
            array('title, link', 'length', 'max' => 128),
            array('menu_id', 'length', 'max' => 11),
            array('id, title, link, menu_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
		return array(
            'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
            'childs' => array(self::HAS_MANY, 'MenuItem', 'parent_id'),
            'parent' => array(self::BELONGS_TO, 'MenuItem', 'parent_id'),
        );
    }
	
	/**
     * @return array model behaviors
     */
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
     * @return array customized attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'link' => 'Ссылка',
            'menu_id' => 'Меню',
            'children' => 'Пункты',
            'parent_id' => 'Родительский пункт',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('menu_id', $this->menu_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('link', $this->link,true);
		$criteria->order = 'sort_order';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
				'pageSize' => 20,
            ),
        ));
    }
	
	/**
	 * Custom actions before deleting a record
	 * @return boolean
	 */
	protected function beforeDelete()
	{
        if (parent::beforeDelete())
        {
            if ($childs = $this->childs)
                foreach ($childs as $child)
				    $child->delete();

            return true;
        }
        return false;
    }

	/**
	 * Returns breadcrumbs array
	 *
	 * @param integer $parentId	ID of parent menu item
	 * @param integer $menuId ID of menu
	 * @param string $empty	
	 *
	 * @return array breadcrumbs pairs
	 */
    public static function getBreadcrumbs($parentId, $menuId, $empty = null) 
	{
        $result = array();
        if ($parentId and $parent = self::model()->findByPk($parentId))
        {
            if ($empty !== null)
                $result[$parent->title] = array('menuItem/index', 'menuId' => $parent->menu_id, 'parentId' => $parent->id);
			else
				$result[] = $parent->title;
				
            while ($parent = self::model()->findByPk($parent->parent_id))
            {
                $result[$parent->title] = array('menuItem/index', 'menuId' => $parent->menu_id, 'parentId' => $parent->id);
            }
        }
		if ($menuId and $menu = Menu::model()->findByPk($menuId))
		{
			if ($parentId)
				$result[$menu->title] = array('menuItem/index', 'menuId' => $menu->id);
			else
				$result[] = $menu->title;
				
			$result['Управление меню'] = array('menu/index');
		}
		$result = array_reverse($result);
		if ($empty)
			$result[] = $empty;
			
        return $result;
    }

    /**
     * Returns list of menu items pairs (id => title)
     * @param integer $parentId ID of menu item
     * @param string $prefix
     * @return array
     */
    public static function getListed($parentId = 0, $prefix = null)
    {
        $result = array();
        if ($items = self::model()->with('childs')->findAllByAttributes(array('parent_id' => $parentId), array('order' => 't.sort_order')))
        {
            foreach ($items as $item)
            {
                $result[$item->id] = $prefix . $item->title;
                if ($item->childs)
                    $result += self::getListed($item->id, $prefix . "--");
            }
        }
        return $result;
    }
}