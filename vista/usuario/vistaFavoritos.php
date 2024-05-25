<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

//obtener id del usuario que ha iniciado sesion para que los favoritos se asocien solo a ese usuario
$userId = $_SESSION['user'];

$localController = new LocalController();
$favoritos = $localController->getFavoritos($userId);

$localesFavoritos = [];
if (!empty($favoritos)) {
    foreach ($favoritos as $favorito) {
        $localFavorito = $localController->getLocalById($favorito);
        if ($localFavorito) {
            $localesFavoritos[] = $localFavorito;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/eliminarFav.js"></script>
  <!--   <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/dashlite.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../assets/js/mapaApi.js" defer></script> -->
    <title>Favoritos</title>
</head>
<body>
    <h1>Mis Locales Favoritos</h1>
    <div class="favoritos-container">
        <?php if (empty($localesFavoritos)): ?>
            <p>No tienes locales favoritos guardados.</p>
        <?php else: ?>
            <?php foreach ($localesFavoritos as $local): ?>
                <div class="favorito-item">
                    <h3><?php echo $local['nombre_local']; ?></h3>
                    <p><?php echo $local['descripcion']; ?></p>
                    <p>Tipo de local: <?php echo $local['tipo_local']; ?></p>
                    <p>Hora apertura: <?php echo $local['hora_apertura']; ?> - Hora cierre: <?php echo $local['hora_cierre']; ?></p>
                    <p>Abierto: <?php echo $local['dias_abierto']; ?></p>
                    <p>Tipo de música: <?php echo $local['genero_musical']; ?></p>
                    <p>Edad media: <?php echo $local['edad_recomendada']; ?></p>
                    <p>Precio medio: <?php echo $local['precio_rango']; ?></p>
                    <button class="remove-favorite" data-local-id="<?php echo $local['local_id']; ?>">Eliminar</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
</body>
</html>
