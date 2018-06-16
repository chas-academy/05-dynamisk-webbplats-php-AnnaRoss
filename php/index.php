<?php

use App\Core\Connection;
use App\Core\Request;
use App\Core\Router;

function autoloader($classname)
{
    $lastSlash = strpos($classname, '\\') + 1;
    $classname = substr($classname, $lastSlash);
    $filePathWithoutExtension = str_replace('\\', '/', $classname);
    $filename = __DIR__ . '/src/' . $filePathWithoutExtension . '.php';
    require_once($filename);
}

spl_autoload_register('autoloader');

$router = new Router();
$response = $router->getRoute(new Request());
echo $response;