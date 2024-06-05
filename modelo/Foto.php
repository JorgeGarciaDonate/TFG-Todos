<?php
require_once __DIR__ . '/../modelo/DB.php';
class Foto {

    private $_db,
            $_data;

    public function __construct($usuario = null) {
        $this->_db = DB::getInstance();            
    }

    // Método para crear un nueva foto
    public function create($fields = array()) {
        $tabla = "fotos";
        if (!$this->_db->insert($tabla, $fields)) {
            throw new Exception('Ha habido un problema en la creación de la foto.');
        }
        return $this->_db->getPdo()->lastInsertId();
    }

    //Método para el borrado de fotos
    public function delete($foto_id){
        $tabla = "fotos";
        if(!$this->_db->delete($tabla,array('foto_id', '=', $foto_id))){
            throw new Exception('Ha habido un problema en el borrado de la foto.');
        }
        return true;
    }

    // Método para actualizar los datos de las fotos
    public function update($fields = array(), $id = null) {       
        if (!$this->_db->update('fotos','foto', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando la foto.');
        }
        return true;
    }

    public function getDatosFotos($local_id) {
        $tabla = "fotos";
        $datos = $this->_db->query("SELECT * FROM $tabla WHERE local_id = $local_id " );
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
                'foto_id' => $dato -> foto_id,
                'nombre_foto' => $dato -> nombre_foto,
                'local_id' => $dato -> local_id                
            ];
        }
        return $valores;
    }

    // Método para verificar si existe una foto
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    // Método para obtener los datos de la foto
    public function data() {
        return $this->_data;
    }

}
?>
