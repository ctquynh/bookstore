<?php

$controller = filter_input(INPUT_GET,'controller');
if (empty($controller)) {
    $controller = 'index';
}
$controller_name = $controller;

require_once("Controller/{$controller_name}.php");

$controllerObj = new $controller_name();
$controllerObj->run();

?>