<li>
    <!--<span class="stars small"><span class="rating"></span></span>-->
    <div class="rating-small"  title="<?=$data->rating;?>">
        <input type="hidden" class="val" value="<?=$data->rating;?>"/>
    </div>
    <span class="price">Цена: <b><?=$data->outPriceCounted(1, '{price}', 0);?></b></span>
    <div class="imgbox3">
        <div class="in">
                                    <? if ($data->photo != '') {
                                            echo CHtml::link(CHtml::image('/upload/catalog/product/small/' . $data->photo, $data->title), $data->fullLink);//$this->createUrl('product', array('id' => $data->id)));
                                        } else {
                                            echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), $data->fullLink); //$this->createUrl('product', array('id' => $data->id)));
                                        }

                                    ?>
        </div>
    </div>
    <?=$data->title;?>
</li>
