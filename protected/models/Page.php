<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $parent_id
 * @property string $title
 * @property string $content
 */
class Page extends CActiveRecord
{
    /**
     * @var array
     */
    public static $layouts = array(
        'main' => 'Обычный шаблон',
        'first_page' => 'Шаблон главной страницы',
    );

    /**
     * @var array
     */
    public static $views = array(
        'view' => 'Страница с заголовком',
        'notitle' => 'Страница без заголовка',
    );

    /**
     * Returns the static model of the specified AR class.
     * @return Page the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title, parent_id, link', 'required'),
            array('link','unique', 'message' => 'Страница со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('parent_id', 'length', 'max' => 11),
            array('title', 'length', 'max' => 512),
            array('content, keywords, description, layout, view', 'safe'),
            array('id, parent_id, title, content, link', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'childs' => array(self::HAS_MANY, 'Page', 'parent_id'),
            'parent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent_id' => 'Родительская страница',
            'link' => 'Ссылка',
            'title' => 'Заголовок',
            'layout' => 'Макет страницы (layout)',
            'view' => 'Вид страницы (view)',
            'content' => 'Текст',
            'children' => 'Подстраницы',
            'keywords' => 'Ключевые слова (метатег keywords)',
            'description' => 'Описание (метатег description)',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('link', $this->link, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns breadcrumbs array
     *
     * @param integer $parentId	ID of parent page
     * @param string $empty
     *
     * @return array
     */
    public static function getBreadcrumbs($parentId = 0, $empty = null)
    {
        $result = array();
        if ($parentId and $parent = self::model()->findByPk($parentId))
        {
            if ($empty !== null)
                $result[$parent->title] = array('page/index', 'parentId' => $parent->id);
            else
                $result[] = $parent->title;

            while ($parent = self::model()->findByPk($parent->parent_id))
            {
                $result[$parent->title] = array('page/index', 'parentId' => $parent->id);
            }
        }

        if ($parentId == 0 and $empty === null)
            $result[] = 'Страницы';
        else
            $result['Страницы'] = array('page/index');

        $result = array_reverse($result);
        if ($empty)
            $result[] = $empty;

        return $result;
    }

    /**
     * Returns list of page info pairs (id => title)
     * @param int $excludeId the ID of current record
     * @param int $parentId the ID of parent record
     * @param null $prefix
     *
     * @return array
     */
    public static function getListed($excludeId = 0, $parentId = 0, $prefix = null)
    {
        $result = array();
        if ($pages = self::model()->with('childs')->findAllByAttributes(array('parent_id' => $parentId), array('condition' => 't.id != ' . $excludeId)))
        {
            foreach ($pages as $page)
            {

                $result[$page->id] = $prefix . $page->title;
                if ($page->childs)
                    $result += self::getListed($excludeId, $page->id, $prefix . "--");
            }
        }

        return $result;
    }

    /**
     * Returns page full link
     *
     * @return string
     */
    public function getFullLink()
    {
        $result = '/' . $this->link;
        if ($parent = $this->parent)
        {
            $result = '/' . $parent->link . $result;
            while ($parent = $parent->parent)
            {
                $result = '/' . $parent->link . $result;
            }
        }

        return $result;
    }

    /**
     * Returns breadcrumbs pairs (title => link)
     *
     * @return array
     */
    public function getFrontBreadcrumbs()
    {
        $result = array();
        if ($parent = $this->parent)
        {
            $result[$parent->title] = $parent->getFullLink();
            while ($parent = $parent->parent)
            {
                $result[$parent->title] = $parent->getFullLink();
            }
        }
        $result = array_reverse($result);
        $result[] = $this->title;

        return $result;
    }
}