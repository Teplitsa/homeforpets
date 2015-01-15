<?
Yii::app()->clientScript->registerScript('rating_review', "
    $('div.rating_review').rating({
        image: '/css/img/stars-16.png',
        width: 16,
        readOnly: true
    });

", CClientScript::POS_READY);
?>
    <div class="comments">
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'reviews-list',
            'dataProvider'=>$dataProvider,
            'template'=>"{items}",
            'itemView'=>'_review',
            'emptyText'=>'Отзывов пока нет',
        )); ?>
    </div>

