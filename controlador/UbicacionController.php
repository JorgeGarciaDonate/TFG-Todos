<?php
require_once(__DIR__ . '/../modelo/Ubicacion.php');

class UbicacionController{
  public function getDatosUbicacion($ubicacion_id){
    $datos = (new Ubicacion())->getDatosUbicacion($ubicacion_id);
    return $datos;
  }
  public function update($datos,$ubicacion_id){
    $actualizacion = (new Ubicacion())->update($datos,$ubicacion_id);
    if($actualizacion){
      return true;
    }
    return false;
  }
}
if (isset($_POST['botonUpdateUbicacion'])) {
  $calle = $_POST['calle'];
  $num_calle = $_POST['num_calle'];
  $zona = $_POST['zona'];
  $ciudad = $_POST['ciudad'];
  $cod_postal = $_POST['cod_postal'];
  $ubicacion_id = $_POST['ubicacion_id'];
  $longitud = $_POST['longitud'];
  $latitud = $_POST['latitud'];

      $controller = new UbicacionController();
      
      $ubicacionData = array(
          'calle' => $calle,
          'num_calle' => $num_calle,
          'zona' => $zona,
          'ciudad' => $ciudad,
          'cod_postal' => $cod_postal,
          'ubicacion_id' => $ubicacion_id,
          'longitud' => $longitud,
          'latitud' => $latitud   
      );

      $update_successful = $controller->update($ubicacionData, $ubicacion_id);

      if ($update_successful) {
          echo json_encode(array('success' => true));
      } else {
          echo json_encode(array('success' => false, 'message' => 'Error updating the user.'));
      }
} 
