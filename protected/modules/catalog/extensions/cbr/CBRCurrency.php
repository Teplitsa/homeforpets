<?php
/*
 * Класс для взятия курсов валют с сайта ЦБ РФ по адресу http://www.cbr.ru/scripts/XML_daily.asp?date_req=dd/mm/yyyy
 * Данные скачиваются раз в день и сохраняются в файле по пути, указанном псевдонимом в $filesDir
 * $currency - массив курсов валют.
 * $this->currency[код валюты]['value'] - курс по отношению к рублю
 * $this->currency[код валюты]['nominal'] - номинал валюты, для которого указывается курс
 *  (для долларов номинал 1, но для белорусских рублей, например - 10000)
 * $this->currency[840]['value'] - выдаст курс доллара на сегодня
 */
class CBRCurrency
{
    public $usd;
    public $currency=array();
    public $cbUrl='http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
    public $filesDir='webroot.upload.cbr';
    private $_cbPath;
    private $_cbFile;
    
    public function __construct()
    {

        $cbPath=YiiBase::getPathOfAlias($this->filesDir);

        // Если нет нет соответствующей директории - создаем ее
        if(!file_exists($cbPath)){mkdir($cbPath);}
        
        $this->_cbPath = $cbPath.'/';

        // Задаем имя класса
        $className='C'.date('dmY');

        $this->_cbFile = $this->_cbPath.$className.'.php';

        // Если файл существует...
        if (file_exists($this->_cbFile)) {
            // Подключаем класс
            Yii::import($this->filesDir.'.'.$className);
            eval('$curClass=new '.$className.'();');

            // Берем массив курсов из класса
            $this->currency = $curClass->cur;

        } else {

            // Если файла не существует - формируем его
            $request=$this->cbUrl.date('d/m/Y');

            // Подключаемся к сайту
            $data = file_get_contents($request);
            // Если полученные данные - в формате XML
            if(substr($data, 0, 5)=='<?xml'){

                // Записываем данные в массив и готовим для записи в файл
                $xml = new SimpleXMLElement($data);
                $fileContent = '<?php
                                    class '.$className.'{
                                    public $cur = array(';
                foreach ($xml->Valute as $Currency) {
                    $cur[(integer)$Currency->NumCode]['nominal']=floatval(str_replace(",", ".", (string)$Currency->Nominal));
                    $cur[(integer)$Currency->NumCode]['value']=floatval(str_replace(",", ".", (string)$Currency->Value));
                    $fileContent.=(integer)$Currency->NumCode.' => array("nominal" => '.number_format($cur[(integer)$Currency->NumCode]['nominal'], 4, '.', '').', "value" => '.number_format($cur[(integer)$Currency->NumCode]['value'], 4, '.', '').'), ';

                }
                 $fileContent.= ');} ?>';

                // Сохраняем в файл, чтобы больше не ходить на ресурс
                file_put_contents ($this->_cbFile, $fileContent);

            } else {
                // Иначе выводим ошибку
                throw new CHttpException(400,'Не удалось получить корректные данные о курсах валют с внешнего ресурса по запросу '.$request);
            }

            // Берем значения из сформированного массива
            $this->currency = $cur;
        }
        

    }
}