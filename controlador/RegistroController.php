<?php
require_once(__DIR__ . '/../modelo/Usuario.php');

class RegistroController {    
    public function login($nombre_usuario,$password) {
        $usuario = new Usuario();
       if($usuario->login($nombre_usuario,$password)){
        return true;
       }
       return false;
    }
    public function createUser($user_data) {
        $usuario = new Usuario();
        $sign_up_successful = $usuario -> create($user_data);
        if($sign_up_successful){
            return true;
        }   
        return false;
    }
    public function logOut(){
        $usuario = new Usuario();
        if($usuario -> logOut()){
            Redirect::to("../index.php");
            exit();
        }
    }
    public function find($valor) {
        $usuario = new Usuario(); 
        return $usuario->find($valor);
    }
}
if (isset($_POST['botonLog'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];    

    if (empty($nombre_usuario) || empty($password)) {
        echo json_encode(array('success' => false, 'message' => 'Completa todos los campos'));
        exit(); 
    }

    $controller = new RegistroController();
    $loginResult = $controller->login($nombre_usuario, $password);

    if ($loginResult === true) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false));
    }
}

if (isset($_POST['botonCreate'])) {
    $nombre = $_POST['nombre'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $apellido = $_POST['apellido'];
    $fecha_de_nacimiento = $_POST['fecha_de_nacimiento'];

    // Cambiar el formato de la fecha de nacimiento de "d/m/Y" a "Y-m-d" para MySQL
    $fecha_nacimiento_obj = date_create_from_format('d/m/Y', $fecha_de_nacimiento);
    if (!$fecha_nacimiento_obj) {
        echo json_encode(array('success' => false, 'message' => 'Invalid date of birth format.'));
        exit;
    }
    $fecha_nacimiento_mysql = $fecha_nacimiento_obj->format('Y-m-d');

    $controller = new RegistroController();
    if($controller->find($email) ){
        echo json_encode(array('success' => false, 'message' => 'The email already exists.'));
    } 
    else if($controller->find($nombre_usuario)){
        echo json_encode(array('success' => false, 'message' => 'The username already exists.'));
    } else {
        $userData = array(
            'nombre'=> $nombre,
            'nombre_usuario' => $nombre_usuario,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'apellido' => $apellido,
            'fecha_de_nacimiento' => $fecha_nacimiento_mysql
        );    

        $sign_up_successful = $controller->createUser($userData);

        if ($sign_up_successful==true) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error creating the user.'));
        }
    }
}




?>
