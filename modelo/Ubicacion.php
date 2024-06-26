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

    // Método para crear una nueva ubicacion
    public function create($fields = array()) {
        $tabla = "ubicaciones";
        // Se intenta insertar los datos de la ubicacion en la base de datos
        if (!$this->_db->insert($tabla, $fields)) {
            throw new Exception('Ha habido un problema en la creación de la ubicacion.');
        }
        return $this->_db->getPdo()->lastInsertId();
    }
    public function delete($ubicacion_id){
        $tabla = "ubicaciones";
        if(!$this->_db->delete($tabla,array('ubicacion_id', '=', $ubicacion_id))){
            throw new Exception('Ha habido un problema en el borrado de la ubicacion.');
        }
        return true;
    }

    // Método para actualizar los datos de la ubicación
    public function update($fields = array(), $id = null) {       
        if (!$this->_db->update('ubicaciones','ubicacion', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando la ubicación.');
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
     // Método para obtener datos de un ubicacion
     public function getDatosUbicacion($ubicacion_id) {
        $tabla = "ubicaciones";
        $datos = $this->_db->query("SELECT * FROM $tabla WHERE ubicacion_id = $ubicacion_id " );
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
                'ubicacion_id' => $dato -> ubicacion_id,
                'calle' => $dato -> calle,
                'num_calle' => $dato -> num_calle,
                'zona' => $dato -> zona,
                'ciudad' => $dato -> ciudad,
                'cod_postal' => $dato -> cod_postal,
                'latitud' => $dato -> latitud,
                'longitud' => $dato -> longitud
            ];
        }
        return $valores;
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
