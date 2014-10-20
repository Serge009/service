<?php
error_reporting(0);
set_time_limit(0);
ini_set("default_socket_timeout", 5);

function http_send($host, $packet)
{
    if (!($sock = fsockopen($host,80,$err_no,$err_str)))
        die($err_no.': '.$err_str);

    fwrite($sock, $packet);
    return stream_get_contents($sock);
}

$host="kurs.com.ua";//"www.matrix-soft.org";
$path= "/ajax/valyuta_nalichnie/all/usd/09.10.2014/0";
$packet  = "GET {$path} HTTP/1.0\r\n";
$packet .= "Host: {$host}\r\n";
$packet .= "Connection: close\r\n\r\n";

echo(http_send($host, $packet));