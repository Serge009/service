<?php
/**
 * Created by PhpStorm.
 * User: РѕР»РµРі
 * Date: 06.10.14
 * Time: 16:36
 */

require_once("config.php");
set_time_limit(3000);
require_once("model.php");
$model = new Model();
$i = 0;
$currencies = $model->selectCurrency();

$bank = array();
$userAgent = array("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36",
    "Opera/9.80 (Windows NT 6.1; WOW64; Edition Ukraine Local) Presto/2.12.388 Version/12.16",
    "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 YaBrowser/14.8.1985.11875 Safari/537.36",
    "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36 OPR/16.0.1196.62");
$headers = array
(
    'Accept: 	application/json, text/javascript, */*; q=0.01',
    'Accept-Encoding:	gzip, deflate',
    'Accept-Encoding: deflate',
    'Accept-Language:	ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
    'Host:	kurs.com.ua',
    'User-Agent : '.$userAgent[3],
    'Referer:	http://kurs.com.ua/banki',
    'X-Requested-With:	XMLHttpRequest'
);


$urlConst = "http://kurs.com.ua/ajax/valyuta_nalichnie/all/";
$todayDate = date("d.m.Y");
foreach($currencies as $key => $currency) {
    $ch = curl_init();
    $sleep = 1;
    $currency = strtolower($currency["code"]);
    $url = $urlConst.$currency."/".$todayDate."/0";
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,

        CURLOPT_RETURNTRANSFER => True,
    ));
    $result = curl_exec($ch);
    //

    $result = json_decode($result);
    //var_dump($result);
    echo "<h1>" . $url . "</h1>";
    var_dump($result);
    echo "<hr />";
    $i++;
    sleep($sleep);
    curl_close($ch);
}


//require_once("select.php");