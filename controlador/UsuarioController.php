<?php
require_once(__DIR__ . '/../modelo/Usuario.php');

class UsuarioController{
  public function getNombreById($usuario_id){
    $usuario = (new Usuario())->getNombreById($usuario_id);
    return $usuario;
  }
  public function getNombre_usuarioById($usuario_id){
    $usuario = (new Usuario())->getNombre_usuarioById($usuario_id);
    return $usuario;
  }
  public function getDatosUsuario($usuario_id){
    $datos = (new Usuario())->getDatosUsuario($usuario_id);
    return $datos;
  }
  public function getEmailById($usuario_id){
    $usuario = (new Usuario())->getEmailById($usuario_id);
    return $usuario;
  }
  public function update($datos,$usuario_id){
    $usuario = (new Usuario())->update($datos,$usuario_id);
    if($usuario){
      return true;
    }
    return false;
  }
  public function es_propietario($usuario_id) {
    $usuario = (new Usuario())->es_propietario($usuario_id);
    return $usuario;
}
public function delete($usuario_id){
  if((new Usuario())->delete($usuario_id)){
      return true;
  }
  return false;
}

     
}
if (isset($_POST['botonUpdate'])) {
  $nombre = $_POST['nombre'];
  $nombre_usuario = $_POST['nombre_usuario'];
  $telefono = $_POST['telefono'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  $usuario_id = $_POST['usuario_id'];

  if (!empty($fecha_nacimiento) && strtotime($fecha_nacimiento)) {
      $fecha_nacimiento_formatted = date('Y-m-d', strtotime($fecha_nacimiento));

      $controller = new UsuarioController();
      
      $userData = array(
          'nombre' => $nombre,
          'nombre_usuario' => $nombre_usuario,
          'telefono' => $telefono,
          'fecha_de_nacimiento' => $fecha_nacimiento_formatted,
          'apellido' => $apellido,
          'dni' => $dni       
      );

      $update_successful = $controller->update($userData, $usuario_id);

      if ($update_successful) {
          echo json_encode(array('success' => true));
      } else {
          echo json_encode(array('success' => false, 'message' => 'Error updating the user.'));
      }
  } else {
      echo json_encode(array('success' => false, 'message' => 'Invalid date format.'));
  }
}
if (isset($_POST['borrarUsuario'])) {
  $usuario_id = $_POST['usuario_id'];
  $usuarioController = new UsuarioController();
  $localController = new LocalController();
  $ubicacionController = new UbicacionController();
  
  try {
      if ($usuarioController->es_propietario($usuario_id)) {
          $locales = $localController->getLocalesByUsuario_id($usuario_id);
          foreach ($locales as $local) {
              $local_id = $local['local_id'];
              $ubicacion_id = $local['ubicacion_id'];
              
              if ($localController->deleteFotos($local_id)) {
                  if ($localController->delete($local_id)) {
                      if (!$ubicacionController->delete($ubicacion_id)) {
                          throw new Exception("Error deleting location");
                      }
                  } else {
                      throw new Exception("Error deleting local");
                  }
              } else {
                  throw new Exception("Error deleting photos");
              }
          }
      }
      if ($usuarioController->delete($usuario_id)) {
          header('Location:../vista/registro/logout.php');
          exit;
      } else {
          throw new Exception("Error deleting user");
      }
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }
}


