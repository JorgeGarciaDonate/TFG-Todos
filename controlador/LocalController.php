<?php
require_once(__DIR__ . '/../modelo/Local.php');

class LocalController{

    public function allLocales(){
        $listLocales=(new Local())->allLocales();
        return $listLocales;
    }
    public function getDatoslocal($local_id){
        $datos = (new Local())->getDatoslocal($local_id);
        return $datos; 
    }
    public function update($array,$local_id){
    if((new Local())->update($array,$local_id)){
        return true;
    }
    return false;
    }
    public function create($array){
        if((new Local())->create(($array))){
            return true;
        }
        return false;
    }
    public function delete($local_id){
        if((new Local())->delete($local_id)){
            return true;
        }
        return false;
    }
    public function deleteFotos($local_id){
        if((new Local())->deleteFotos($local_id)){
            return true;
        }
        return false;
    }
    public function getLocalesByUsuario_id($usuario_id){
    $locales = (new Local())->getLocalesByUsuario_id($usuario_id);
    if($locales){
        return $locales;
    }
    return false;
    }

    public function coordLocales(){
    $coordLocales=(new Local())->coordenadasLocales();
    return $coordLocales;
    }

    public function getLocalById($localId) {
    $local = (new Local())->getLocalById($localId);
    
    if ($local !== false) {
        return (array) $local; // Convertir el objeto a array asociativo
    } else {
        return false;
    }
    }

    public function getFavoritos($userId) {
    if (isset($_COOKIE['favorites_' . $userId])) {
        return json_decode($_COOKIE['favorites_' . $userId], true);
    } else {
        return [];
    }
    }

    // Establecer los favoritos del usuario en las cookies
    public function setFavoritos($userId, $favoritos) {
    setcookie('favorites_' . $userId, json_encode($favoritos), time() + (60 * 60 * 24 * 30), "/");
    }

    // Añadir local a favoritos
    public function addFavorito($userId, $localId) {
    $favoritos = $this->getFavoritos($userId);
    if (!in_array($localId, $favoritos)) {
        $favoritos[] = $localId;
        $this->setFavoritos($userId, $favoritos);
        return true;
    } else {
        return false;
    }
    }

    // Eliminar local de favoritos
    public function removeFavorito($userId, $localId) {
    $favoritos = $this->getFavoritos($userId);
    if (($key = array_search($localId, $favoritos)) !== false) {
        unset($favoritos[$key]);
        $this->setFavoritos($userId, array_values($favoritos));
        return true;
    } else {
        return false;
    }
    }
 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $controller = new LocalController();
 
   if (isset($_POST['action'])) {
       if ($_POST['action'] === 'allLocales') {
           $locales = $controller->allLocales();
           echo json_encode($locales);
       }
 
       if ($_POST['action'] === 'addFavorite') {
           if (isset($_POST['localId'])) {
               if (session_status() == PHP_SESSION_NONE) {
                   session_start();
               }
               $userId = $_SESSION['user'];
               $localId = $_POST['localId'];
               $success = $controller->addFavorito($userId, $localId);
               echo json_encode(['success' => $success]);
           }
       }
 
       if ($_POST['action'] === 'removeFavorite') {
           if (isset($_POST['localId'])) {
               if (session_status() == PHP_SESSION_NONE) {
                   session_start();
               }
               $userId = $_SESSION['user'];
               $localId = $_POST['localId'];
               $success = $controller->removeFavorito($userId, $localId);
               echo json_encode(['success' => $success]);
           }
       }
 
       if ($_POST['action'] === 'getFavoritos') {
           if (session_status() == PHP_SESSION_NONE) {
               session_start();
           }
           $userId = $_SESSION['user'];
           $favoritos = $controller->getFavoritos($userId);
           $localesFavoritos = [];
           foreach ($favoritos as $favorito) {
               $localFavorito = $controller->getLocalById($favorito);
               if ($localFavorito) {
                   $localesFavoritos[] = $localFavorito;
               }
           }
           echo json_encode($localesFavoritos);
       }
   }
 }
 
if (isset($_POST['botonUpdateDatos'])) {
  $localController = new LocalController();
  $nombre = $_POST['nombre'];
  $tipo_local = $_POST['tipo_local'];
  $genero_musical = $_POST['genero_musical'];
  $precio_rango = $_POST['precio_rango'];
  $edad_recomendada = $_POST['edad_recomendada'];
  $descripcion = $_POST['descripcion'];
  $local_id = $_POST['local_id'];

  $localDatos = array(
      'nombre_local'=> $nombre,
      'tipo_local' => $tipo_local,
      'genero_musical' => $genero_musical,
      'precio_rango' => $precio_rango,
      'edad_recomendada' => $edad_recomendada,
      'descripcion' => $descripcion,
      'local_id' => $local_id
  );
  $actualizacion = $localController -> update($localDatos,$local_id);
  
  if ($actualizacion) {
      echo json_encode(['success' => true]);
  } else {
      echo json_encode(['success' => false]);
  }

}
if (isset($_POST['botonUpdateHorario'])) {
  $localController = new LocalController();
  $dias_abierto = $_POST['dias_abierto'];
  $hora_apertura = $_POST['hora_apertura'];
  $hora_cierre = $_POST['hora_cierre'];
  $local_id = $_POST['local_id'];

  $localDatos = array(
      'dias_abierto'=> $dias_abierto,
      'hora_apertura' => $hora_apertura,
      'hora_cierre' => $hora_cierre,
      'local_id' => $local_id
  );
  $actualizacion = $localController -> update($localDatos,$local_id);
  
  if ($actualizacion) {
      echo json_encode(['success' => true]);
  } else {
      echo json_encode(['success' => false]);
  }

}
if (isset($_POST['borrarLocal'])) {
    $local_id = $_POST['local_id'];
    $localController = new LocalController();
    $delete= $localController->delete($local_id);
    if($delete){
        header('Location:../index.php '); 
        exit;
    }
    
}


//FUNCION PARA LOS FILTROS

if (isset($_POST['aplicarFiltros']) && $_POST['aplicarFiltros'] === 'true') {
    // Recibir los filtros del request
    $hora_apertura = isset($_POST['hora_apertura']) ? $_POST['hora_apertura'] : null;
    $hora_cierre = isset($_POST['hora_cierre']) ? $_POST['hora_cierre'] : null;
    $dias_abierto = isset($_POST['dias_abierto']) ? explode(',', $_POST['dias_abierto']) : null;
    $tipo_local = isset($_POST['tipo_local']) ? $_POST['tipo_local'] : null;
    $musica_en_vivo = isset($_POST['musica_en_vivo']) ? $_POST['musica_en_vivo'] : false;
    $genero_musical = isset($_POST['genero_musical']) ? explode(',', $_POST['genero_musical']) : null;
    $edad_recomendada = isset($_POST['edad_recomendada']) ? $_POST['edad_recomendada'] : null;
    $precio_rango = isset($_POST['precio_rango']) ? $_POST['precio_rango'] : null;
    
    // Construir la consulta SQL
    $query = "SELECT * FROM locales";
    $conditions = [];
    $params = [];
    

    

    if ($hora_apertura) {
        $conditions[] = "hora_apertura >= '$hora_apertura:00'";
        $params[] = $hora_apertura;
    }
    if ($hora_cierre) {
        $conditions[] = "hora_cierre <= '$hora_cierre:00'";
        $params[] = $hora_cierre;
    }
    if ($dias_abierto) {
        if ($dias_abierto[0] === '') {
        }
        else {
            $dias_abierto_sql = implode("','", $dias_abierto);
            $conditions[] = "dias_abierto = ('$dias_abierto_sql')";
        }
    } 
     
    if ($tipo_local) {
        $conditions[] = "tipo_local = '$tipo_local'";
    }
    if ($musica_en_vivo) {
        if($musica_en_vivo === true){
            $conditions[] = "musica_en_vivo = 1";
        }
        else if($musica_en_vivo === false){
            $conditions[] = "musica_en_vivo = 0";
        }

    }
    if ($genero_musical) {
        if ($genero_musical[0] === '') {
        } else {
            $genero_musical_sql = implode("','", $genero_musical);
            $conditions[] = "genero_musical = ('$genero_musical_sql')";
        }
    }
    if ($edad_recomendada) {
        $conditions[] = "edad_recomendada <= '$edad_recomendada'";
    }
    if ($precio_rango) {
        if ($precio_rango === '50+') {
            $conditions[] = "precio_rango = '50+'";
        } else if($precio_rango === '20-50') {
            $conditions[] = "precio_rango = '20-50'";
        }else if($precio_rango === '0-20'){
            $conditions[] = "precio_rango = '0-20'";
        }
    }

    // Unir condiciones si hay alguna
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }


    $db = DB::getInstance();
    $local = new Local();
    $valores = [];

    // Ejecutar la consulta
    try {
        $datos = $db->query($query);
        if($datos){
            $valores = $local->arrayDatos($datos->results());
        }
        if ($valores) {
            echo json_encode(['success' => true, 'data' => $valores]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron resultados.']);
        }
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error en la consulta a la base de datos.']);
    }
} 
