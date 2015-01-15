<div class="image_block">
    <div class="image">
        <a class="thumb">
            <span>
                <?echo CHtml::image('/upload/catalog/product/moreimages/small/'.$data->image);?>
            </span>
        </a>
    </div>
    <? echo CHtml::link('', array('image/delete','id' => $data->id), array('class' => 'delete'));?>

</div>