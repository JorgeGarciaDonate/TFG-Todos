<?php
require_once __DIR__ . '/../modelo/DB.php';
class Ubicacion {

    private $_db, // Objeto de la clase DB
            $_data, // Datos del usuario
            $_sessionName, // Nombre de la sesión
            $_cookieName, // Nombre de la cookie
            $_isLoggedIn; // Estado de inicio de sesión

    public function __construct($usuario = null) {
        $this->_db = DB::getInstance();            
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

    // Método para actualizar los datos de la ubicación
    public function update($fields = array(), $id = null) {       
        if (!$this->_db->update('usuarios', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando el usuario.');
        }
        return true;
    }

    // Método para obtener el id_local a partir de la calle y el numero
    public function getUbicacionId($datos) {
        if ($datos) {
            $ubicacion = $this->_db->get('ubicaciones', array('calle', '=', $datos['calle'], 'num_calle', '=', $datos['num_calle']))->first();
    
            if ($ubicacion) {
                return $ubicacion->ubicacion_id; 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    

    // Método para verificar si existe una ubicación
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    // Método para obtener los datos de la ubicación
    public function data() {
        return $this->_data;
    }

}
?>
