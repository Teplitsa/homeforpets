<?
class BaseCatalogController extends FrontEndController
{
    public $catalog_config;

    public function __construct($id,$module=null)
    {
        parent::__construct($id, $module);

        // загружаем конфигурацию каталога
        $this->catalog_config=CatalogConfig::model()->findByPk(1);
    }

}
?>