<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once (ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

$registroController = new RegistroController();
if($registroController->logout()){
    Redirect::to("./login.php");
}

?>

