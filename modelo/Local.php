<?php
require_once __DIR__ . '\DB.php';
class Local
{

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
        return true;
    }

    // Método para actualizar los datos de un local
    public function update($fields = array(), $id = null)
    {
        // Si no se proporciona un ID y el local está logueado, se usa el ID del local actual
        if ($id) {
            $id = $this->data()->id;
        }
        // Se intenta actualizar los datos del local en la base de datos
        if (!$this->_db->update('locales', $id, $fields)) {
            throw new Exception('Ha habido un problema actualizando el local.');
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

    // Método para obtener una lista de todos los locales con sus ubicaciones
    /*    public function allLocales()
    {
        $query = "SELECT * 
              FROM locales l
              LEFT JOIN ubicaciones u ON l.ubicacion_id = u.ubicacion_id";

        // Se ejecuta la consulta
        if ($this->_db->query($query)) {
            $data = [];

            // Iterar sobre los resultados utilizando $this->_db->results()
            foreach ($this->_db->results() as $result) {
                $local_id = $result->local_id;
                $hora_apertura = $result->hora_apertura;
                $hora_cierre = $result->hora_cierre;
                $dias_abierto = $result->dias_abierto;
                $nombre_local = $result->nombre_local;
                $tipo_local = $result->tipo_local;
                $ubicacion_id = $result->ubicacion_id;
                $musica_en_vivo = $result->musica_en_vivo;
                $descripcion = $result->descripcion;
                $genero_musical = $result->genero_musical;
                $edad_recomendada = $result->edad_recomendada;
                $precio_rango = $result->precio_rango;
                $usuario_id = $result->usuario_id;

                // Obtener los datos de ubicación
                $calle = $result->calle;
                $num_calle = $result->num_calle;
                $zona = $result->zona;
                $ciudad = $result->ciudad;
                $cod_postal = $result->cod_postal;
                $latitud = $result->latitud;
                $longitud = $result->longitud;

                // Construir el array de datos para el local, incluyendo los datos de ubicación
                $data[] = [
                    'local_id' => $local_id,
                    'hora_apertura' => $hora_apertura,
                    'hora_cierre' => $hora_cierre,
                    'dias_abierto' => $dias_abierto,
                    'nombre_local' => $nombre_local,
                    'tipo_local' => $tipo_local,
                    'ubicacion' => [
                        'ubicacion_id' => $ubicacion_id,
                        'calle' => $calle,
                        'num_calle' => $num_calle,
                        'zona' => $zona,
                        'ciudad' => $ciudad,
                        'cod_postal' => $cod_postal,
                        'latitud' => $latitud,
                        'longitud' => $longitud
                    ],
                    'musica_en_vivo' => $musica_en_vivo,
                    'descripcion' => $descripcion,
                    'genero_musical' => $genero_musical,
                    'edad_recomendada' => $edad_recomendada,
                    'precio_rango' => $precio_rango,
                    'usuario_id' => $usuario_id
                ];
            }
            return $data;
        } else {
            // Si ocurre un error al ejecutar la consulta, lanzar una excepción
            throw new Exception("Error al obtener los locales.");
        }
    } */


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
