<?php
class Hash{
    // Método estático para generar un hash a partir de una cadena y una sal opcional
    public static function make($string, $salt='') {
		// Se utiliza la función hash() con el algoritmo SHA-1 para generar el hash de la cadena
		return hash('sha256', $string);
	}       

	// Método estático para generar una sal aleatoria
	public static function salt($length) {
		// Se utiliza la función random_bytes() para generar una secuencia de bytes aleatorios de longitud especificada
		return random_bytes($length);
	}

	// Método estático para generar un valor único basado en un identificador único
	public static function unique() {
		// Se utiliza el método make() para generar un hash único basado en un identificador único generado por uniqid()
		return self::make(uniqid());
	}
}
?>
