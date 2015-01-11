<?php
Yii::import('zii.widgets.CMenu');
/**
 * Site menu widget
 */
class OutMenu extends CMenu
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $limit = 0;

    /**
     * @var integer
     */
    public $offset = 0;

    /**
     * Menu initialization
     */
    public function init()
    {
        $this->id = $this->name;
        $this->activateParents = true;
        if ($menu = Menu::model()->findByAttributes(array('name' => $this->name)))
        {
            if ($menu->firstitem_class)
                $this->firstItemCssClass = $menu->firstitem_class;

            if ($menu->lastitem_class)
                $this->lastItemCssClass = $menu->lastitem_class;

            if ($menu->items_template)
                $this->itemTemplate = $menu->items_template;

            if ($menu->activeitem_class)
                $this->activeCssClass = $menu->activeitem_class;

            $criteria = new CDbCriteria;
            $criteria->compare('t.menu_id', $menu->id);
            $criteria->compare('t.parent_id', 0);
            $criteria->order = 't.sort_order';
            $criteria->with = 'childs';
            if ($this->limit)
                $criteria->limit = $this->limit;

            if ($this->offset)
                $criteria->offset = $this->offset;



            if ($items = MenuItem::model()->findAll($criteria))
                $this->items = $this->parseMenuItems($items);
        }
        else
            $this->items = array(
                array(
                    'label' => 'Меню с именем ' . $this->name . ' не существует!',
                    'url' => '#',
                    'active' => false,
                ),
            );

        $this->items = $this->normalizeItems($this->items, Yii::app()->request->url, $hasActiveChild);
    }

    /**
     * @param array $item
     * @param string $route
     * @return bool
     */
    protected function isItemActive($item, $route)
    {
        $pos = mb_strpos($route, $item['url'], 0, "UTF-8");
        $active = ($item['url'] == '/' and $route == $item['url']);
        $active = ($active or ($pos !== false and $pos === 0 and $item['url'] != '/'));
        return $active;
    }

    /**
     * @param MenuItem $items
     * @return array
     */
    private function parseMenuItems($items)
    {
        $result = array();
        if ($items)
            foreach ($items as $item)
                $result[] = array(
                    'label' => $item['title'],
                    'url' => $item['link'],
                    'items' => $this->parseMenuItems($item->childs),
                );

        return $result;
    }

    /**
     * Menu running
     */
    public function	run()
    {
        return parent::run();
    }
}
?>