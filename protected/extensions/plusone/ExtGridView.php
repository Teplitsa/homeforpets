<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * Class ExtGridView
 * Extended grid view
 */
class ExtGridView extends CGridView
{
	/**
	 * @var string Default grid css
	 */
	public $cssFile = '/css/admin/gridstyles.css';
}

/**
 * Class ExtButtonColumn
 * Extended button column
 */
class ExtButtonColumn extends CButtonColumn
{
	/**
	 * @var string Default buttons template
	 */
	public $template = '{update}{delete}';

	/**
	 * Initialization
	 */
	public function init()
	{
		$this->buttons = CMap::mergeArray(
			$this->buttons,
			array(
				'view' => array(
					'imageUrl' => '/images/admin/view_grid.png',
				),
				'update' => array(
					'imageUrl' => '/images/admin/edit.png',
				),
				'delete' => array(
					'imageUrl' => '/images/admin/del.png',
				),
			)
		);

		parent::init();
	}
}
?>