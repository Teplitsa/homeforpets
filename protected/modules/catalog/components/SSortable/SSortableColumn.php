<?php
class SSortableColumn extends CButtonColumn
{

	public $disableSortable = false;
	
function __construct($grid) {
	parent::__construct($grid);
	//Уберем сортировку по колонкам, она уже не нужна
	if($this->disableSortable){
		foreach ($grid->columns as $key=>$column){
			if(is_object($column))
				if(get_class($column)=='CDataColumn')
					$column->sortable = false;
		}
	}
	
	//CVarDumper::dump($this->grid->dataProvider->getSort()->orderBy,2,true);
	
	$this->template = '{moveup}{movedown}';
	
	$imgPath = $this->publish();
	
	$move =<<< EOD
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
EOD;
	
	
	
	
	$this->buttons = array(
		'moveup' => array(
			'label'  => 'Вверх',
			'url'   => 'array("block/move", "method"=>"up", "id" => $data->id)',
			'imageUrl'  => $imgPath.'/up.png',
			'options' => array('class' => 'moveup'),
			'click' => $move,
		),
		'movedown' => array(
			'label'  => 'Вниз',
			'url'   => 'array("block/move", "method"=>"down", "id" => $data->id)',
			'imageUrl'  => $imgPath.'/down.png',
			'options' => array('class' => 'movedown'),
			'click' => $move,
		),
	);
	
}

	private function publish(){
			//Путь кпапке с редактором и файловым менеджером
			$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images';
			//Путь опубликованных файлов
			return Yii::app()->getAssetManager()->publish($dir);
	}
	
	
}
?>