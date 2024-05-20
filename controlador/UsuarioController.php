<?php

class UsuarioController{
  public function getNombreById($usuario_id){
    $usuario = (new Usuario)->getNombreById($usuario_id);
    return $usuario;
  }
     
}
