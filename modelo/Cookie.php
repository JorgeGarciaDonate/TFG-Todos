<?php 
class Cookie {
    // Método estático para verificar si existe una cookie con el nombre dado
    public static function exists($nombre) {
        // Devuelve true si la cookie existe, de lo contrario devuelve false
        return (isset($_COOKIE[$nombre])) ? true : false;
    }

    // Método estático para obtener el valor de una cookie con el nombre dado
    public static function get($nombre) {
        // Devuelve el valor de la cookie con el nombre especificado
        return $_COOKIE[$nombre];
    }

    // Método estático para establecer una cookie
    public static function put($nombre, $valor, $extincion) {
        // Establece una cookie con el nombre, valor y tiempo de caducidad especificados
        // El tiempo de caducidad se calcula sumando el tiempo actual (time()) y el tiempo de caducidad especificado
        // '/' indica que la cookie está disponible en todo el sitio
        // Devuelve true si la cookie se estableció correctamente, de lo contrario devuelve false
        if(setcookie($nombre, $valor, time() + $extincion, '/')) {
            return true;
        }
        return false;
    }

    // Método estático para eliminar una cookie
    public static function delete($nombre) {
        // Llama al método put con un valor vacío y un tiempo de caducidad pasado (time() - 1) para eliminar la cookie
        self::put($nombre, '', time() - 1);
    }
}
