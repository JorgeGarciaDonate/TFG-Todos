<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT . DS . "core" . DS . "init.php");
$LocalController = new LocalController();
$local=$LocalController->allLocales();
print_r($local);

?>
