<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once (ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

$userController = new ControllerUser();
if($userController->logout()){
    Redirect::to("./login.php");
}

?>

