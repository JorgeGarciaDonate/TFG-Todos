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

if (isset($_POST['botonAlta'])) {
    /* try { */
        $nombre = $_POST['nombre'];
        $tipo_local = $_POST['tipo_local'];
        $generos = implode(', ', $_POST['generos']); 
        $precio_rango = $_POST['precio_rango'];
        $hora_apertura = $_POST['hora_apertura'];
        $hora_cierre = $_POST['hora_cierre'];
        $diasApertura = implode(', ', $_POST['dias_apertura']); 
        $calle = $_POST['calle'];
        $num_calle = $_POST['num_calle'];
        $cod_postal = $_POST['cod_postal'];
        $ciudad = $_POST['ciudad'];
        $barrio = $_POST['barrio'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
        $usuario_id = $_POST['usuario_id'];
        $edad_recomendada = $_POST['edad_recomendada'];
        $musica_en_vivo = $_POST['musica_en_vivo'];
        $descripcion =$_POST['descripcion'];
        $foto =$_FILES['foto'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $web = $_POST['web'];
        $uploadDir = 'assets/img/locales'; // Define la carpeta donde se guardarán las imágenes

        $usuario = new Usuario();
        if($usuario_id){
            $usuarioChanges = [
                'es_propietario' => 1,
                'telefono' => $telefono,
                'dni' => $dni                
            ];
        }
        $usuarioUpdate = $usuario ->update($usuarioChanges,$usuario_id);
        

        // Inserta los datos de la ubicación
        $ubicacion = new Ubicacion();
        $altaUbicacion = [
            'calle' => $calle,
            'num_calle' => $num_calle,
            'cod_postal' => $cod_postal,
            'ciudad' => $ciudad,
            'zona' => $barrio,
            'latitud' => $latitud,
            'longitud' => $longitud
        ];
        $ubicacion_id = $ubicacion->create($altaUbicacion);


        if ($ubicacion_id) {
            // Inserta los datos del local con el ubicacion_id
            $local = new Local();
            $altaLocal = [
                'nombre_local' => $nombre,
                'tipo_local' => $tipo_local,
                'genero_musical' => $generos,
                'precio_rango' => $precio_rango,
                'hora_apertura' => $hora_apertura,
                'hora_cierre' => $hora_cierre,
                'dias_abierto' => $diasApertura,
                'ubicacion_id' => $ubicacion_id,
                'usuario_id' => $usuario_id,
                'descripcion' => $descripcion,
                'musica_en_vivo' => $musica_en_vivo,
                'edad_recomendada' => $edad_recomendada,
                'web' => $web
            ];
            $local_id = $local->create($altaLocal);
            if ($foto['error'] == UPLOAD_ERR_OK) {
                $uploadFile = $uploadDir . basename($foto['name']);
                
                if (move_uploaded_file($foto['tmp_name'], $uploadFile)) {
                    echo "Archivo subido con éxito.\n";
                    
                    $fotoModel = new Foto();
                    if($foto){
                        $fotoCreate = [
                            'nombre_foto' => $foto,
                            'local_id' => $local_id
                        ];
                    }
                    $result = $fotoModel->create($fotoCreate);
                }
            } 
            

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar los datos del local.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al insertar los datos de ubicación.']);
        }
    /* } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    } */
}/*  else {
    echo json_encode(['success' => false, 'message' => 'No se ha enviado el formulario correctamente.']);
} */
?>

