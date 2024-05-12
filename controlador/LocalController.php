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
if (isset($_POST['list-view'])) {
   $controller = new LocalController();
    $locales = $controller->allLocales();

   if ($locales) {
      echo json_encode($locales);   
   }
}