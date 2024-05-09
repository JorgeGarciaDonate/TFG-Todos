<?php
require_once(__DIR__ . '/../modelo/Config.php');

class DB{
    private 
            $_pdo, // Objeto PDO para la conexión
            $_query, // Objeto para almacenar la consulta
            $_error = false, // Indicador de error
            $_results, // Resultados de la consulta
            $_count = 0; // Número de filas afectadas

    private static $_instance = null;

    // Constructor privado para prevenir instanciación directa
    private function __construct() {
        // Se intenta establecer la conexión PDO con la base de datos
        try {
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch(PDOException $e) {
            // Se muestra el mensaje de error en caso de fallo en la conexión
            die($e->getMessage());
        }
    }

    // Método estático para obtener la instancia única de la clase
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
   
    // Método para ejecutar consultas preparadas
    public function query($sql, $params = array()) {
        $this->_error = false; // Reinicia el indicador de error
        if($this->_query = $this->_pdo->prepare($sql)) {
            // Se enlazan los parámetros a la consulta preparada
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
           
            // Se ejecuta la consulta
            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ); // Se obtienen los resultados
                $this->_count = $this->_query->rowCount(); // Se cuenta el número de filas afectadas
            } else {
                $this->_error = true; // Se marca como error en caso de fallo en la ejecución
            }
        }

        return $this;
    }   

    // Método para realizar acciones de consulta (SELECT, INSERT, DELETE, UPDATE)
    public function action($action, $table, $where = array()) {
        if(count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    // Método para realizar una consulta SELECT
    public function get($table, $where) {
        return $this->action('SELECT *', $table, $where);
    }

    // Método para realizar una consulta SELECT con parámetros personalizados
    public function getByParams($table, $fields = array(), $sort = null) {
        // Construcción de la consulta con parámetros personalizados
        $sql = "SELECT * FROM ".$table." WHERE ";
        end($fields);
        $last = key($fields);            
        foreach($fields as $key => $field){
            if($key === $last){
                $sql .= $key."='".$field."'";
            } else {
                $sql .= $key."='".$field."' AND ";
            }
        }
        if($sort)
            $sql .= " ".$sort." ";
        if(!$this->query($sql)) {
            return $this->query($sql)->error();
        }
        return $this->query($sql);
    }

    // Método para realizar una consulta DELETE
    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);
    }

    // Método para realizar una consulta INSERT
    public function insert($table, $fields = array()) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = null;
            $x = 1;

            foreach ($fields as $field) {
                $values .= "?";
                if($x < count($fields)) {
                    $values .= ' , ';
                }
                $x++;
            }

            $sql = "INSERT INTO $table (`".implode('`, `', $keys)."`) VALUES ({$values})"; 
            if(!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        return false;
    }

    // Método para realizar una consulta UPDATE
    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    // Método para obtener los resultados de la consulta
    public function results() {
        return $this->_results;
    }

    // Método para obtener el primer resultado de la consulta
    public function first() {
        return $this->results()[0];
    }

    // Método para obtener el estado de error de la consulta
    public function error() {
        return $this->_error;
    }

    // Método para obtener el número de filas afectadas por la consulta
    public function count() {
        return $this->_count;
    }       
}
?>
