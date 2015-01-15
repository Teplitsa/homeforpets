<div class="comment">
    <span class="date"><?=date('d.m.Y', $data->date)?></span>
    Пользователь: <?=$data->user->username?>
    <div class="clear"></div>
    <div class="mv5">
        <div class="ocenka">Оценка товара</div>
        <div class="fl ml5">
            <div class="rating_review"  title="<?=$data->rating;?>">
                <input type="hidden" class="val" value="<?=$data->rating;?>"/>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <p><?=$data->text;?></p>

</div>
