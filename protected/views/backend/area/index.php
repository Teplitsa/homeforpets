<?php
Yii::app()->clientScript->registerScript('area_delete', "
    $('#area-list a.delete_area').on('click', function() {
        if (!confirm('Вы уверены в удалении области вывода?'))
            return false;
        var th = this;
        var afterDelete = function(){};
        $.fn.yiiListView.update('area-list', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function(data) {
                $.fn.yiiListView.update('area-list');
                afterDelete(th,true,data);
            },
            error: function(XHR) {
                return afterDelete(th,false,XHR);
            }
        });
        return false;
    });
", CClientScript::POS_READY);
$this->breadcrumbs = array(
    'Управление информационными блоками',
);
?>
<h1>Управление информационными блоками</h1>
<?php echo CHtml::link('+ Добавить область вывода', array('area/create'), array('class' => 'add_element')); ?>
<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'area-list',
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
