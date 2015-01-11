<?php

/**
 * Class OutAreaWidget
 * Displays site area blocks
 */
class OutAreaWidget extends CWidget
{
    /**
     * @var string
     */
	public $name;

    /**
     * @var bool
     */
    public $reverse = false;

    /**
     * @var string
     */
    private $defaultBlockView = 'areablock';

    public function run()
    {
        if ($area = Area::model()->findByAttributes(array('name' => $this->name)))
        {
            if ($blocks = $area->blocks)
            {
                if ($this->reverse)
                    $blocks = array_reverse($blocks);

                foreach ($blocks as $block)
                {
                    if ($block->view)
                        $view = $block->view;
                    else
                        $view = $this->defaultBlockView;

                    if ($this->getViewFile($view))
                        $this->render($view, array(
                            'block' => $block,
                        ));
                    else
                        echo $view . " - несуществующий вид блока!";
                }
            }
        }
        else
            echo "Область вывода " . $this->name . " не найдена.";
    }
}

?>