<?php

class UserController{
  
  public function login($username, $pass, $remember){
    $usuario= new Usuario();
    $log=$usuario->login($username, $pass, $remember)

    if($user){
      $user->exists();
    }
      return $user;
  }     
}
