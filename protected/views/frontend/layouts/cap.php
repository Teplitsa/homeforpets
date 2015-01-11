<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
        <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>">
        <meta name="description" content="<?php echo CHtml::encode($this->description); ?>">
        <meta name="author" content="<?php echo CHtml::encode(Yii::app()->config->author); ?>">
        <title><?php if($this->title) echo CHtml::encode($this->title)." - "; echo CHtml::encode(Yii::app()->config->sitename);?></title>
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="content">
                <?php echo $content; ?>
            </div>
        </div>
    </body>
</html>