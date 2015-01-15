<?php
Yii::app()->clientScript->registerScript('check-all',"
	$(document).on('click', '.check-all', function(){
		$(this).next('ul').find('.check-all').prop('checked', $(this).prop('checked'));
		return true;
	});
", CClientScript::POS_READY);
?>
<h2>Категории, в которых используется атрибут</h2>
<?php $this->widget('CTreeView', array('data' => $data_tree)); ?>