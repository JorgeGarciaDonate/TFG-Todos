<?php
require_once __DIR__ . '/../modelo/DB.php';
class Foto {

    private $_db, // Objeto de la clase DB
            $_data;

    public function __construct($usuario = null) {
        $this->_db = DB::getInstance();            
    }

    // Método para crear un nuevo usuario
    public function create($fields = array()) {
        $tabla = "fotos";
        // Se intenta insertar los datos del usuario en la base de datos
        if (!$this->_db->insert($tabla, $fields)) {
            throw new Exception('Ha habido un problema en la creación de la foto.');
        }
        return $this->_db->getPdo()->lastInsertId();
    }
    public function delete($foto_id){
        $tabla = "fotos";
        if(!$this->_db->delete($tabla,array('foto_id', '=', $foto_id))){
            throw new Exception('Ha habido un problema en el borrado de la ubicacion.');
        }
        return true;
    }

    // Método para actualizar los datos de la ubicación
    public function update($fields = array(), $id = null) {       
        if (!$this->_db->update('fotos','foto', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando el usuario.');
        }
        return true;
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
