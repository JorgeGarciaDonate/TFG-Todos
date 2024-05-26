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

/* require_once(__DIR__ . '/../modelo/Local.php');

class LocalController {
    public function __construct() {
        // Obtener todos los locales al inicializar el controlador
        $this->locales = (new Local())->allLocales();
    }
    public function allLocales(){
      $listLocales=(new Local())->allLocales();
      return $listLocales;
   }
  
   public function coordLocales(){
     $coordLocales=(new Local())->coordenadasLocales();
     return $coordLocales;
   }
}

// Crear una instancia del controlador al iniciar el script
$controller = new LocalController();

// Manejar solicitudes de listado de locales
if (isset($_POST['action']) && $_POST['action'] === 'allLocales') {
   $locales = $controller->allLocales();

   // Devolver los locales como JSON
   echo json_encode($locales);
} */

?>
