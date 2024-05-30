<?php
require_once __DIR__ . '\DB.php';
class Local{

    private $_db, // Objeto de la clase DB
        $_data, // Datos del local
        $_sessionName, // Nombre de la sesión
        $_cookieName; // Nombre de la cookie


    // Constructor de la clase
    public function __construct()
    {
        // Se instancia la clase DB
        $this->_db = DB::getInstance();
        // Se obtienen el nombre de la sesión y el nombre de la cookie de la configuración
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
    }

    // Método para crear un nuevo local
    public function create($fields = array())
    {
        $tabla = "locales";
        // Se intenta insertar los datos del local en la base de datos
        if (!$this->_db->insert($tabla, $fields)) {
            throw new Exception('Ha habido un problema en la creación del local.');
        }
        return $this->_db->getPdo()->lastInsertId();
    }
    public function delete($local_id){
        $tabla = "locales";
        if(!$this->_db->delete($tabla,array('local_id', '=', $local_id))){
            throw new Exception('Ha habido un problema en el borrado del local.');
        }
        return true;
    }
    public function deleteFotos($local_id){
        $tabla = "fotos";
        if(!$this->_db->delete($tabla,array('local_id', '=', $local_id))){
            throw new Exception('Ha habido un problema en el borrado de fotos.');
        }
        return true;
    }

    // Método para actualizar los datos de un local
    public function update($fields = array(), $local_id = null){
        // Si no se proporciona un ID, se usa el ID del local actual
        if (!$local_id) {
            $local_id = $this->data()->local_id;
        }
        // Se intenta actualizar los datos del local en la base de datos
        if (!$this->_db->update('locales', 'local', $local_id, $fields)) {
            throw new Exception('Ha habido un problema actualizando el local.');
        }
        else{
            return true;
        }
    }


    // Método para buscar un local por nombre de local 
    public function find($local = null)
    {
        if ($local) {
            // Se determina si el local es un nombre de local o un correo electrónico
            $field = (is_numeric($local)) ? 'local_id' : 'nombre_local';
            // Se busca el local en la base de datos
            $data = $this->_db->get('locales', array($field, '=', $local));

            // Si se encuentra el local, se almacenan sus datos en la propiedad _data
            if ($data->count()) {
                $this->_data = $data->first();
                return $this;
            }
        }
        return false;
    }

    // Método para obtener el ID de local a partir de un array de datos de local
    public function getLocalId($localArray)
    {
        if (!empty($localArray['nombre_local'])) {
            $tabla = "locales";
            $local = $this->_db->get($tabla, array('nombre_local', '=', $localArray['nombre_local']));
            if ($local->count() > 0) {
                return $local->first()->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Método para obtener el nombre de local a partir de un ID de local
    public function getNombre_localById($localId)
    {
        if (!empty($localId)) {
            $tabla = "locales";
            $local = $this->_db->get($tabla, array('local_id', '=', $localId));
            if ($local->count() > 0) {
                return $local->first()->nombre_local;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /* public function getTipoLocal(){
        $tabla = "locales";
        $tipo_local = $this->_db->query("SELECT tipo_local FROM $tabla");
        return $tipo_local;
    } */
    //metodo para obtener la info del local en base a su id
    public function getLocalById($localId){
        if (!empty($localId)) {
            $query = "SELECT l.*, u.*, f.foto_id, f.nombre_foto
                    FROM locales l
                    LEFT JOIN ubicaciones u ON l.ubicacion_id = u.ubicacion_id
                    LEFT JOIN fotos f ON l.local_id = f.local_id
                    WHERE l.local_id = ?";

            if ($this->_db->query($query, [$localId])) {
                $result = $this->_db->first();
                
                if ($result) {
                    $local = [
                        'local_id' => $result->local_id,
                        'hora_apertura' => $result->hora_apertura,
                        'hora_cierre' => $result->hora_cierre,
                        'dias_abierto' => $result->dias_abierto,
                        'nombre_local' => $result->nombre_local,
                        'tipo_local' => $result->tipo_local,
                        'ubicacion' => [
                            'ubicacion_id' => $result->ubicacion_id,
                            'calle' => $result->calle,
                            'num_calle' => $result->num_calle,
                            'zona' => $result->zona,
                            'ciudad' => $result->ciudad,
                            'cod_postal' => $result->cod_postal,
                            'latitud' => $result->latitud,
                            'longitud' => $result->longitud
                        ],
                        'musica_en_vivo' => $result->musica_en_vivo,
                        'descripcion' => $result->descripcion,
                        'genero_musical' => $result->genero_musical,
                        'edad_recomendada' => $result->edad_recomendada,
                        'precio_rango' => $result->precio_rango,
                        'web' => $result->web,
                        'usuario_id' => $result->usuario_id,
                        'fotos' => []
                    ];

                    if ($result->foto_id) {
                        $local['fotos'][] = [
                            'foto_id' => $result->foto_id,
                            'nombre_foto' => $result->nombre_foto
                        ];
                    }

                    return $local;
                } else {
                    return false;
                }
            } else {
                throw new Exception("Error al obtener el local.");
            }
        } else {
            return false;
        }
    }

    public function getLocalesByUsuario_id($usuario_id) {
        $tabla = "locales";
        $datos = $this->_db->query("SELECT local_id, nombre_local,ubicacion_id FROM $tabla WHERE usuario_id = $usuario_id " );
        $valores = [];
        foreach ($datos->results() as $dato) {           

            $valores[] = [
                'local_id' => $dato -> local_id,
                'nombre_local' => $dato -> nombre_local,
                'ubicacion_id'=> $dato-> ubicacion_id
            ];
        }
        if ($valores) {
            return $valores;
        } else {
            return new Exception("Oops! Something went wrong.");
        }
        
        
    }
    // Método para obtener datos de un local
    public function getDatoslocal($local_id) {
        $tabla = "locales";
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
                'local_id' => $dato -> local_id,
                'nombre_local' => $dato -> nombre_local,
                'hora_apertura' => $dato -> hora_apertura,
                'hora_cierre' => $dato -> hora_cierre,
                'dias_abierto' => $dato -> dias_abierto,
                'tipo_local' => $dato -> tipo_local,
                'musica_en_vivo' => $dato -> musica_en_vivo,
                'descripcion' => $dato -> descripcion,
                'genero_musical' => $dato -> genero_musical,
                'edad_recomendada' => $dato -> edad_recomendada,
                'precio_rango' => $dato -> precio_rango,
                'usuario_id' => $dato -> usuario_id,
                'web' => $dato->web,
                'ubicacion_id' => $dato -> ubicacion_id
            ];
        }
        return $valores;
    }

    // Método para obtener una lista de todos los locales con sus ubicaciones   
    public function allLocales()
    {
        $query = "SELECT l.*, u.*, f.foto_id, f.nombre_foto
              FROM locales l
              LEFT JOIN ubicaciones u ON l.ubicacion_id = u.ubicacion_id
              LEFT JOIN fotos f ON l.local_id = f.local_id";

        if ($this->_db->query($query)) {
            $data = [];
            $localesMap = [];

            foreach ($this->_db->results() as $result) {
                $local_id = $result->local_id;

                if (!isset($localesMap[$local_id])) {
                    $localesMap[$local_id] = [
                        'local_id' => $result->local_id,
                        'hora_apertura' => $result->hora_apertura,
                        'hora_cierre' => $result->hora_cierre,
                        'dias_abierto' => $result->dias_abierto,
                        'nombre_local' => $result->nombre_local,
                        'tipo_local' => $result->tipo_local,
                        'ubicacion' => [
                            'ubicacion_id' => $result->ubicacion_id,
                            'calle' => $result->calle,
                            'num_calle' => $result->num_calle,
                            'zona' => $result->zona,
                            'ciudad' => $result->ciudad,
                            'cod_postal' => $result->cod_postal,
                            'latitud' => $result->latitud,
                            'longitud' => $result->longitud
                        ],
                        'musica_en_vivo' => $result->musica_en_vivo,
                        'descripcion' => $result->descripcion,
                        'genero_musical' => $result->genero_musical,
                        'edad_recomendada' => $result->edad_recomendada,
                        'precio_rango' => $result->precio_rango,
                        'web' => $result->web,
                        'usuario_id' => $result->usuario_id,
                        'fotos' => []
                    ];
                }

                if ($result->foto_id) {
                    $localesMap[$local_id]['fotos'][] = [
                        'foto_id' => $result->foto_id,
                        'nombre_foto' => $result->nombre_foto
                    ];
                }
            }

            $data = array_values($localesMap);
            return $data;
        } else {
            throw new Exception("Error al obtener los locales.");
        }
    }


    //Metodo para obtener el nombre, latitud y longitud de los locales
    public function coordenadasLocales()
    {
        $consulta = "SELECT l.nombre_local, u.latitud, u.longitud 
                    FROM locales as l 
                    INNER JOIN ubicaciones as u ON l.ubicacion_id = u.ubicacion_id ORDER BY l.nombre_local";
        if ($this->_db->query($consulta)) {
            // Array para almacenar las coordenadas de los locales
            $locales = [];
            foreach ($this->_db->results() as $local) {
                $nombre_local = $local->nombre_local;
                $latitud = $local->latitud;
                $longitud = $local->longitud;

                $locales[] = array(
                    'ubicacion' => [
                        'latitud' => $latitud,
                        'longitud' => $longitud
                    ],
                    'nombre_local' => $nombre_local
                );
            }
            return $locales;
        }
    }



    // Método para obtener una lista de locales con opciones de filtrado y ordenación
    public function allLocalesListUpgrade($fields = array(), $order = NULL)
    {
        $tabla = "locales";

        // Si no se proporcionan campos de filtrado, se obtienen todos los locales de la base de datos
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

    // Método para verificar si existe un local
    public function exists()
    {
        // Devuelve true si existen datos del local, de lo contrario, devuelve false
        return (!empty($this->_data)) ? true : false;
    }

    // Método para obtener los datos del local
    public function data()
    {
        return $this->_data;
    }
}

