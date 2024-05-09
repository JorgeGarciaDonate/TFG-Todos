<?php


if(isset($_POST['redireccion'])) {
    // Obtener el valor de "redireccion"
    $destino = $_POST['redireccion'];

    // Realizar la redirección basada en el valor de "redireccion"
    if($destino == "registro") {
        header("Location: ../vista/registro/registro.php");
        exit();
    } elseif($destino == "login") {
        header("Location: ../vista/registro/login.php");
        exit();
    }
} 

