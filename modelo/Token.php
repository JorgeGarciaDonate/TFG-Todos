<?php

class Token {    
    // Método estático para generar un token único y guardarlo en la sesión
    public static function generate() {
        // Genera un token único utilizando md5(uniqid()) y lo guarda en la sesión con el nombre especificado en la configuración
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }
    
    // Método estático para verificar si un token dado coincide con el token almacenado en la sesión
    public static function check($token) {
        // Obtiene el nombre del token de la configuración
        $tokenName = Config::get('session/token_name');
        // Verifica si el token existe en la sesión y si coincide con el token dado
        if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
            // Si el token coincide, elimina el token de la sesión (ya que generalmente se usa solo una vez) y devuelve true
            Session::delete($tokenName);
            return true;
        }
        
        // Si el token no coincide o no existe en la sesión, devuelve false
        return false;
    }
           
}
