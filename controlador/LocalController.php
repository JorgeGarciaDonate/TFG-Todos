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
