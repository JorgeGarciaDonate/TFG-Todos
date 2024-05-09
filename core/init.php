<?php
// Se inicia la sesión PHP
session_start();

// Configuración global de la aplicación
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'cheersy'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800 // Tiempo en segundos (una semana)
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
);

// Función de autocarga para clases PHP
spl_autoload_register(function($class) {
    if (is_file(__DIR__ . '/../modelo/' . $class . '.php')) {
        require_once __DIR__ . '/../modelo/' . $class . '.php';
    }
    if (is_file(__DIR__ . '/../controlador/' . $class . '.php')){
        require_once __DIR__ . '/../controlador/' . $class . '.php';
    }    
});

// Control de cookies para la sesión de recordatorio
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    // Si existe una cookie de recordatorio y no hay una sesión activa
    // Se obtiene el hash de la cookie
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    // Se verifica en la base de datos si el hash coincide con algún registro
    $hashCheck = DB::getInstance()->get('ior_user_sessions', array('hash', '=', $hash));

    if ($hashCheck->count()) {
        // Si hay un registro con el hash
        // Se instancia un nuevo objeto de usuario con el ID obtenido del registro
        $user = new Usuario($hashCheck->first()->user_id);
        // Se inicia sesión automáticamente para el usuario correspondiente
        $user->login();
    }
}
?>
