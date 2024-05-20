<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT . DS . "core" . DS . "init.php");
$usuario = (new Usuario)->getNombreById(1);
    echo $usuario;

?>
