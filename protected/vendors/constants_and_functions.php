<?php
/**
 * Additional php constants and functions
 */
 
// Page url rules
defined('STRIP_LAST_SLASH') or define('STRIP_LAST_SLASH', 1);
defined('ADD_LAST_SLASH') or define('ADD_LAST_SLASH', 0);

// Возвращает дату с русским названием месяца
/**
 * Get date with russian month name
 * @param integer $timestamp 
 * @param string $postfix 
 * @return string
 */
function rusDate($timestamp = 0, $postfix = "")
{
    $day = date('d', $timestamp);
    $mounth = date('m', $timestamp);
    $year = date('Y', $timestamp);

    $rusMounthList = array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря',
    );

    return $day." ".$rusMounthList[$mounth]." ".$year." ".$postfix;
}
?>