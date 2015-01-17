<?php $this->beginContent('//layouts/main_layout'); ?>
    <?php $this->widget('application.modules.catalog.components.CatalogCatToMainWidget'); ?>
	<div class="clear"></div>
	<?php $this->widget('application.modules.catalog.components.SearchboxWidget'); ?>
	<div class="clear"></div>
<?php $this->endContent(); ?>