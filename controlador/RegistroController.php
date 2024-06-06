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
    $password_hash = Hash::make($password); 
    $controller = new RegistroController();
    $loginResult = $controller->login($nombre_usuario, $password);

    if (empty($nombre_usuario) || empty($password)) {
        echo json_encode(array('success' => false, 'message' => 'Completa todos los campos'));
        exit(); 
    }
    $controller = new RegistroController();
    if (!$controller->find($nombre_usuario) && !$controller->find($password_hash)) {
        echo json_encode(array('success' => false, 'message' => 'El nombre de usuario y la contraseña no son correctos.'));
    }
    else if (!$controller->find($nombre_usuario)) {
        echo json_encode(array('success' => false, 'message' => 'El nombre de usuario no es correcto.'));
    }
    else if ($loginResult === true) {
        echo json_encode(array('success' => true));
    }
    else {
        echo json_encode(array('success' => false, 'message' => ' La contraseña no es correcta.'));
    }     
}

if (isset($_POST['botonCreate'])) {
    $nombre = $_POST['nombre'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $apellido = $_POST['apellido'];
    $fecha_de_nacimiento = $_POST['fecha_de_nacimiento'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('success' => false, 'message' => 'Formato de email invalido'));
        exit;
    }


    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        echo json_encode(array('success' => false, 'message' => 'La contraseña debe tener minimo una letra mayúscula, una minúscula y un número.'));
        exit;
    }

    $fecha_nacimiento_obj = date_create_from_format('d/m/Y', $fecha_de_nacimiento);
    if (!$fecha_nacimiento_obj) {
        echo json_encode(array('success' => false, 'message' => 'Formato de fecha invalida.'));
        exit;
    }
    $fecha_nacimiento_mysql = $fecha_nacimiento_obj->format('Y-m-d');
    $hoy = new DateTime();
    $diff = $hoy->diff($fecha_nacimiento_obj);
    if ($diff->y < 18) {
        echo json_encode(array('success' => false, 'message' => 'Debes de ser mayor de edad'));
        exit;
    }

    $controller = new RegistroController();
    if ($controller->find($email)) {
        echo json_encode(array('success' => false, 'message' => 'El email ya está registrado.'));
    } else if ($controller->find($nombre_usuario)) {
        echo json_encode(array('success' => false, 'message' => 'El nombre de usuario ya existe.'));
    } else {
        $userData = array(
            'nombre' => $nombre,
            'nombre_usuario' => $nombre_usuario,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'apellido' => $apellido,
            'fecha_de_nacimiento' => $fecha_nacimiento_mysql
        );

        $sign_up_successful = $controller->createUser($userData);

        if ($sign_up_successful == true) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error en la creación del usuario.'));
        }
    }
}
if (isset($_POST['botonAlta'])) {
    try {
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $tipo_local = isset($_POST['tipo_local']) ? $_POST['tipo_local'] : '';
        $generos = isset($_POST['genero_musical']) && is_array($_POST['genero_musical']) ? implode(', ', $_POST['genero_musical']) : '';
        $precio_rango = isset($_POST['precio_rango']) ? $_POST['precio_rango'] : '';
        $hora_apertura = isset($_POST['hora_apertura']) ? $_POST['hora_apertura'] : '';
        $hora_cierre = isset($_POST['hora_cierre']) ? $_POST['hora_cierre'] : '';
        $diasApertura = isset($_POST['dias_abierto']) && is_array($_POST['dias_abierto']) ? implode(', ', $_POST['dias_abierto']) : '';
        $calle = isset($_POST['calle']) ? trim($_POST['calle']) : '';
        $num_calle = isset($_POST['num_calle']) ? $_POST['num_calle'] : '';
        $cod_postal = isset($_POST['cod_postal']) ? $_POST['cod_postal'] : '';
        $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : '';
        $barrio = isset($_POST['barrio']) ? trim($_POST['barrio']) : '';
        $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
        $edad_recomendada = isset($_POST['edad_recomendada']) ? $_POST['edad_recomendada'] : '';
        $musica_en_vivo = isset($_POST['musica_en_vivo']) ? $_POST['musica_en_vivo'] : '';
        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
        $web = isset($_POST['web']) ? trim($_POST['web']) : '';
        $dni = isset($_POST['dni']) ? trim($_POST['dni']) : '';
        $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
        $web = isset($_POST['web']) ? $_POST['web'] : '';
        $latitud = isset($_POST['latitud']) ? $_POST['latitud'] : '';
        $longitud = isset($_POST['longitud']) ? $_POST['longitud'] : '';
        $uploadDir = '../assets/img/locales/'; // Define la carpeta donde se guardarán las imágenes
        $foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;

        // Asegurarse de que el directorio exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if($dni && $telefono){
            // Actualizar usuario
            $usuario = new Usuario();
            if ($usuario_id) {
                $usuarioChanges = [
                    'es_propietario' => 1,
                    'telefono' => $telefono,
                    'dni' => $dni                
                ];
                $usuarioUpdate = $usuario->update($usuarioChanges, $usuario_id);
            }
        }
        

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

            if ($local_id) {
                // Guardar la imagen
                $uploadDir = '../assets/img/locales/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $uploadFile = $uploadDir. basename($foto['name']);
                if (move_uploaded_file($foto['tmp_name'], $uploadFile)) {
                    // Guardar la ruta de la foto en la base de datos
                    $fotoModel = new Foto();
                    $fotoCreate = [
                        'nombre_foto' => basename($foto['name']),
                        'local_id' => $local_id
                    ];
                    $result = $fotoModel->create($fotoCreate);
                } else {
                    echo json_encode(['success' => false, 'essage' => 'Error al mover el archivo subido.']);
                    exit;
                }

                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'essage' => 'Error al insertar los datos del local.']);
                }
            } else {
                echo json_encode(['success' => false, 'essage' => 'Error al insertar los datos del local.']);
            }
        } else {
            echo json_encode(['success' => false, 'essage' => 'Error al insertar los datos de ubicación.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'essage' => 'Error: '. $e->getMessage()]);
    }
}

?>

