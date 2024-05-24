<?php
require_once __DIR__ . '/../modelo/DB.php';
class Usuario {

    private $_db, // Objeto de la clase DB
            $_data, // Datos del usuario
            $_sessionName, // Nombre de la sesión
            $_cookieName, // Nombre de la cookie
            $_isLoggedIn; // Estado de inicio de sesión

    // Constructor de la clase
    public function __construct($usuario = null) {
        // Se instancia la clase DB
        $this->_db = DB::getInstance();
        // Se obtienen el nombre de la sesión y el nombre de la cookie de la configuración
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        
        // Si no se proporciona un usuario
        if (!$usuario) {
            // Se verifica si existe una sesión activa
            if (Session::exists($this->_sessionName)) {
                // Se obtiene el ID de usuario de la sesión
                $usuario = Session::get($this->_sessionName);
                // Si se encuentra el usuario, se establece como "logueado"
                if ($this->find($usuario)) {
                    $this->_isLoggedIn = true;
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            // Si se proporciona un usuario, se busca en la base de datos
            $this->find($usuario);
        }
    }

    // Método para crear un nuevo usuario
    public function create($fields = array()) {
        $tabla = "usuarios";
        // Se intenta insertar los datos del usuario en la base de datos
        if (!$this->_db->insert($tabla, $fields)) {
            throw new Exception('Ha habido un problema en la creación del usuario.');
        }
        return true;
    }

    // Método para actualizar los datos de un usuario
    public function update($fields = array(), $id = null) {
        // Si no se proporciona un ID y el usuario está logueado, se usa el ID del usuario actual
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->usuario_id;
        }
        // Se intenta actualizar los datos del usuario en la base de datos
        if (!$this->_db->update('usuarios', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando el usuario.');
        }
        return true;
    }

    // Método para buscar un usuario por nombre de usuario o correo electrónico
    public function find($usuario = null) {
        if ($usuario) {
            // Se determina si el usuario es un nombre de usuario o un correo electrónico
            $field = (is_numeric($usuario)) ? 'usuario_id' : 'nombre_usuario' ;
            // Se busca el usuario en la base de datos
            $data = $this->_db->get('usuarios', array($field, '=', $usuario));

            // Si se encuentra el usuario, se almacenan sus datos en la propiedad _data
            if ($data->count()) {
                $this->_data = $data->first();
                return $this;
            } else {
                // Si no se encuentra el usuario por nombre de usuario, se intenta buscar por correo electrónico
                $data = $this->_db->get('usuarios', array('email', '=', $usuario));
                if ($data->count()) {
                    $this->_data = $data->first();
                    return $this; 
                }
            }
        }
        return false;
    }

    // Método para iniciar sesión de usuario
    public function login($nombre_usuario = null, $password = null, $remember = false) {
        // Si no se proporciona un nombre de usuario y contraseña y el usuario ya está logueado, se renueva la sesión
        if (!$nombre_usuario && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->usuario_id);
        } else {
            // Si se proporciona un nombre de usuario y contraseña, se intenta iniciar sesión
            $usuario = $this->find($nombre_usuario);
            if ($usuario) {
                // Se verifica la contraseña
                if ($this->data()->password_hash === Hash::make($password, $this->data()->password_salt)) {
                    
                    Session::put($this->_sessionName, $this->data()->usuario_id);
                    return true;
                }
            } 
        }

        return false;
    }
    // Método para obtener datos del usuario
    public function getDatosUsuario($usuario_id) {
        $tabla = "usuarios";
        $datos = $this->_db->query("SELECT * FROM $tabla WHERE usuario_id = $usuario_id " );
        $valores = [];
        
        if ($datos) {
            $valores = $this->arrayDatos($datos->results());
        } else {
            throw new Exception("Oops! Something went wrong.");
        }
    
        return $valores;
    }
    
    public function arrayDatos($datos){
        $valores = [];
        foreach ($datos as $dato) {           

            $valores[] = [
                'usuario_id' => $dato -> id,
                'nombre' => $dato -> nombre,
                'apellido' => $dato -> apellido,
                'nombre_usuario' => $dato -> nombre_usuario,
                'email' => $dato -> email,
                'fecha_de_nacimiento' => $dato -> fecha_de_nacimiento,
                'telefono' => $dato -> telefono,
                'es_propietario' => $dato -> es_propietario,
                'dni' => $dato -> dni
            ];
        }
        return $valores;
    }
    
    public function getNombreById($id) {
        if (!empty($id)) {
            $tabla =  "usuarios";
            $nombre = $this->_db->get($tabla, array('usuario_id', '=', $id));
            if ($nombre->count() > 0) {
                return $nombre->first()->nombre;
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }
    //Metodo para obtener el nombre de usuario a partir del Id
    public function getNombre_usuarioById($id) {
        if (!empty($id)) {
            $tabla =  "usuarios";
            $nombre = $this->_db->get($tabla, array('usuario_id', '=', $id));
            if ($nombre->count() > 0) {
                return $nombre->first()->nombre_usuario;
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }
        
    // Método para obtener el correo electrónico a partir de un ID de usuario
    public function getEmailById($id) {
        if (!empty($id)) {
            $tabla = "usuarios";
            $usuario = $this->_db->get($tabla, array('usuario_id', '=', $id));
            if ($usuario->count() > 0) {
                return $usuario->first()->email;
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }

    // Método para obtener una lista de todos los usuarios
    public function allusuariosList() {
        $tabla = "usuarios";
        // Se ejecuta una consulta para obtener todos los usuarios de la base de datos
        if ($this->_db->query("SELECT * FROM " . $tabla)) {
            return $this->_db->query("SELECT * FROM " . $tabla);
        }
        // Si ocurre un error al ejecutar la consulta, se lanza una excepción
        if ($this->_db->query("SELECT * FROM " . $tabla)) {
            throw new Exception("Oops! Algo ha ido mal.");
        }
    }

    // Método para obtener una lista de usuarios con opciones de filtrado y ordenación
    public function allusuariosListUpgrade($fields = array(), $order = NULL) {
        $tabla = "usuarios";

        // Si no se proporcionan campos de filtrado, se obtienen todos los usuarios de la base de datos
        if ($fields == NULL) {
            if (!$this->_db->query("SELECT * FROM " . $tabla)) {
                throw new Exception("No se puede ejecutar la query.");
            }
            return $this->_db->query("SELECT * FROM " . $tabla);
        } else {
            // Si se proporcionan campos de filtrado, se ejecuta una consulta con estos campos y la ordenación especificada
            if (!$this->_db->getByParams($tabla, $fields, $order)) {
                throw new Exception("No se puede ejecutar la query.");
            }
            return $this->_db->getByParams($tabla, $fields, $order);
        }
    }

    // Método para verificar si existe un usuario
    public function exists() {
        // Devuelve true si existen datos del usuario, de lo contrario, devuelve false
        return (!empty($this->_data)) ? true : false;
    }

    // Método para cerrar sesión de usuario
    public function logout() {
        // Se eliminan la sesión y la cookie
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
        return true;
    }

    // Método para obtener los datos del usuario
    public function data() {
        return $this->_data;
    }

    // Método para verificar si un usuario está logueado
    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}
?>
