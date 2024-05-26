<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT . DS . "core" . DS . "init.php");

$local = (new Usuario())->es_propietario(81);
echo $local;
?>
