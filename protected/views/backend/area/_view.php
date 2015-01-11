<div class="view">
	<h3>
        Область вывода <i><?php echo CHtml::encode($data->title); ?></i>
            <?php
                echo CHtml::link(CHtml::image('/images/admin/edit.png', 'Редактирование'), Yii::app()->createUrl('area/update', array('id' => $data->id)), array('title' => 'Редактирование'));
                if ($data->blocks)
                    echo CHtml::image('/images/admin/del_disable.png', 'Удаление невозможно', array('title' => 'Удаление невозможно'));
                else
                    echo CHtml::link(CHtml::image('/images/admin/del.png', 'Удаление'), Yii::app()->createUrl('area/delete', array('id' => $data->id)), array('class' => 'delete_area', 'title' => 'Удаление'));
            ?>
    </h3>
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
    <div>
    <?php
		$dataProvider = new CArrayDataProvider($data->blocks, array(
            'sort' => array(
                'defaultOrder' => 'sort_order',
            ),
        ));

        $this->widget('ext.plusone.ExtGridView', array(
            'id' => 'block-grid-' . $data->id,
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'name',
                    'type' => 'raw',
                    'header' => 'Имя блока',
                    'value' => 'CHtml::link($data->name, Yii::app()->createUrl("areaBlock/update", array("id"=>$data->id)))',
                ),
                array(
                    'name' => 'title',
                    'type' => 'raw',
                    'header' => 'Заголовок блока',
                    'value' => 'CHtml::link($data->title, Yii::app()->createUrl("areaBlock/update", array("id"=>$data->id)))',
                ),
                array(
                    'name' => 'view',
                    'type' => 'raw',
                    'header' => 'Вид',
                    'value' => 'isset($data->getViews()[$data->view]) ? $data->getViews()[$data->view] : "Не указан"',
                ),
                array(
                    'name' => 'visible',
                    'header' => 'Отображается',
                    'value' => '$data->visible ? "Да" : "Нет"',
                ),
                array(
                    'class' => 'ExtButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'url' => 'Yii::app()->createUrl("areaBlock/update", array("id" => $data->id))',
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("areaBlock/delete", array("id" => $data->id))',
                        ),
                    ),
                    'deleteConfirmation' => 'Вы уверены в удалении блока?',
                ),
                array(
                    'class' => 'ext.SSortable.SSortableColumn',
                    'controller' => 'areaBlock',
                ),
            ),
        ));
        echo CHtml::link('Добавить блок', Yii::app()->createUrl('/areaBlock/create', array('areaId' => $data->id)));
    ?>
    </div>
</div>