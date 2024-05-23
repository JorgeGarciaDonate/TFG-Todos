<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT . DS . "core" . DS . "init.php");
$usuario = (new Usuario())->getDatosUsuario(2);
print_r($usuario);

?>
