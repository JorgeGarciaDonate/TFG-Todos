<?php

class Session {
    
    // Método estático para verificar si existe una variable de sesión
    public static function exists($nombre) {
        return (isset($_SESSION[$nombre])) ? true : false;
    }
    
    // Método estático para establecer una variable de sesión
    public static function put($nombre, $value) {
        return $_SESSION[$nombre] = $value;
    }
    
    // Método estático para obtener el valor de una variable de sesión
    public static function get($nombre) {
        return $_SESSION[$nombre];
    }
    
    // Método estático para eliminar una variable de sesión
    public static function delete($nombre) {
        if(self::exists($nombre)) {
            unset($_SESSION[$nombre]);
        }
    }

    // Método estático para almacenar un mensaje flash en la sesión
    public static function flash($nombre, $string = '') {
        if(self::exists($nombre)) {
            // Si existe un mensaje flash con el nombre dado, se guarda su valor en una variable temporal
            $session = self::get($nombre);
            // Luego se elimina el mensaje flash de la sesión
            self::delete($nombre);
            // Se devuelve el mensaje flash
            return $session;
        } else {
            // Si no existe un mensaje flash con el nombre dado, se guarda el nuevo mensaje en la sesión
            self::put($nombre, $string);
        }
    }        
}
