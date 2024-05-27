<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

//obtener id del usuario que ha iniciado sesion para que los favoritos se asocien solo a ese usuario

?>
<!DOCTYPE html>
<html lang="es" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/dashlite.css">
    <title>Perfil</title>
    <!-- StyleSheets  -->
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   
    <script src="../../assets/js/MostrarYEliminarFav.js" ></script> 
</head>
<body>        
       
    
    <h3>Mis Locales Favoritos</h3>
    <div id="list-favoritos" ></div>

    <script src="../../assets/js/bundle.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/form/updateProfile.js"></script>  

</body>
</html>
