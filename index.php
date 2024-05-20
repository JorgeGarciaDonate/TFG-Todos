<?php 
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT .DS."TFG-TODOS". DS. "core" . DS . "init.php");
Redirect::to("vista/");
?>