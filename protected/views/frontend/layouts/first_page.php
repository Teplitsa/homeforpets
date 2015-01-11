<?php $this->beginContent('//layouts/main_layout'); ?>
<div class="inner">
    <div class="advs">
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'preimuschestva-na-glavnoj')); ?>
    </div>
</div>
<div class="test-access">
    <div class="cbg"></div>
    <div class="inner">
        <div class="info">
            <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'dostupy-na-glavnoj')); ?>
            <div class="info-lnb"></div>
            <div class="info-lnt"></div>
        </div>
        <a class="btn" href="/manage">Войти</a>
    </div>
</div>
<div class="inner">
    <div class="services">
        <h1>Наши услуги</h1>
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'uslugi-na-glavnoj')); ?>
    </div>
</div>
<div class="inner">
    <?php echo $content; ?>
    <div class="clear"></div>
</div>
<?php $this->endContent(); ?>