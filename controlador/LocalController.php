<?php
require_once(__DIR__ . '/../modelo/Local.php');

 class LocalController{

 public function allLocales(){
    $listLocales=(new Local())->allLocales();
    return $listLocales;
 }
}
if (isset($_POST['list-view'])) {
   $controller = new LocalController();
    $locales = $controller->allLocales();

   if ($locales) {
      echo json_encode($locales);   
   }
}