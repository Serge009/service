<?php

use Matrix\ServiceBundle\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
date_default_timezone_set("Europe/Kiev");

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';


$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();

AppController::$isDevMode = true;

$response = $kernel->handle($request);

try{

    $data = $request->getQueryString() . " " . "Time " . date("d-m-Y H:i:s") . "\nInput\n\t" . $request->request->get("data") . "\n"
        . "Output\n\t" . $response->getContent() . "\n\n";
    file_put_contents("app/logs/service.log", $data, FILE_APPEND);

} catch (Exception $e){}




$response->send();
$kernel->terminate($request, $response);