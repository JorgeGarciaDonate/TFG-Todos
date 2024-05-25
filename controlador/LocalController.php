<?php
require_once(__DIR__ . '/../modelo/Local.php');

 class LocalController{

 public function allLocales(){
    $listLocales=(new Local())->allLocales();
    return $listLocales;
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
