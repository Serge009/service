<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
date_default_timezone_set("Europe/Kiev");
/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
*/

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';


$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();


$response = $kernel->handle($request);

try{

    $data = $request->getQueryString() . " " . "Time " . date("d-m-Y H:i:s") . "\nInput\n\t" . $request->request->get("data") . "\n"
            . "Output\n\t" . $response->getContent() . "\n\n";
    file_put_contents("app/logs/service.log", $data, FILE_APPEND);

} catch (Exception $e){}

$response->send();
$kernel->terminate($request, $response);

/*
use Symfony\Component\ClassLoader\ApcClassLoader;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';

require_once __DIR__.'/app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
*/