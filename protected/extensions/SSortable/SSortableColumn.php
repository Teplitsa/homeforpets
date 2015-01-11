<?php

/**
 * Class SSortableColumn
 * Sortable grid column
 */
class SSortableColumn extends CButtonColumn
{
	/**
	 * @var bool
	 */
	public $disableSortable = false;

	/**
	 * @var string
	 */
    public $controller;

	/**
	 * @var string
	 */
	public $template = '{moveup}{movedown}';

	/**
	 * @var string
	 */
	public $imagePath = null;

	/**
	 * Constructor
	 *
	 * @param CGridView $grid
	 */
	function __construct($grid)
	{
		parent::__construct($grid);
		//Уберем сортировку по колонкам, она уже не нужна
		if ($this->disableSortable)
		{
			foreach ($grid->columns as $key => $column)
			{
				if(is_object($column))
					if(get_class($column) == 'CDataColumn')
						$column->sortable = false;
			}
		}

		$jsClick = "
			function() {
				$.fn.yiiGridView.update('{$this->grid->id}', {
					type:'POST',
					url:$(this).attr('href'),
					success:function() {
						$.fn.yiiGridView.update('{$this->grid->id}');
					}
				});
				return false;
			}
		";

		$this->buttons = array(
			'moveup' => array(
				'label'  => 'Вверх',
				'options' => array('class' => 'moveup'),
				'click' => $jsClick,
			),
			'movedown' => array(
				'label'  => 'Вниз',
				'options' => array('class' => 'movedown'),
				'click' => $jsClick,
			),
		);
	}

	/**
	 * Initialization
	 */
	public function init()
	{
		if ($this->imagePath === null)
			$this->imagePath = $this->publish();

		$movePath = '';
		if ($this->controller)
			$movePath .= $this->controller.'/';

		$this->buttons['moveup']['url'] = 'array("' . $movePath . 'move", "method" => "up", "id" => $data->id)';
		$this->buttons['moveup']['imageUrl'] = $this->imagePath . '/up.png';

		$this->buttons['movedown']['url'] = 'array("' . $movePath . 'move", "method" => "down", "id" => $data->id)';
		$this->buttons['movedown']['imageUrl'] = $this->imagePath . '/down.png';

		parent::init();
	}

	/**
	 * @return mixed
	 */
	private function publish()
	{
		$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images';
		return Yii::app()->getAssetManager()->publish($dir);
	}
}
?>