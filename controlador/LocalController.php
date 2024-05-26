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
   if (isset($_POST['action']) && $_POST['action'] === 'allLocales') {
       $controller = new LocalController();
       $locales = $controller->allLocales();
       
       if ($locales) {
           echo json_encode($locales);
       }
   }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addFavorite') {
   if (isset($_POST['localId'])) {
       if (session_status() == PHP_SESSION_NONE) {
         session_start();
       }
       $userId = $_SESSION['user'];
       $localId = $_POST['localId'];
       $controller = new LocalController();
       $success = $controller->addFavorito($userId, $localId); 
       if ($success) {
         echo json_encode(['success' => true]);
       } else {
           echo json_encode(['success' => false]);
       }
     } 
 }
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'removeFavorite') {
   if (isset($_POST['localId'])) {
       //lógica para obtener el ID de usuario
       if (session_status() == PHP_SESSION_NONE) {
         session_start();
       }
       $userId = $_SESSION['user'];      
       $localId = $_POST['localId'];
       $controller = new LocalController();
       $success = $controller->removeFavorito($userId, $localId);
       if ($success) {
           echo json_encode(['success' => true]);
       } else {
           echo json_encode(['success' => false]);
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


