<?php 
   define("DS", DIRECTORY_SEPARATOR);
   define("ROOT", dirname(__FILE__) . DS);
   require_once (ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");
   $usuarioController = new UsuarioController();
    new RegistroController();
    if(!$_SESSION['user']){
        Redirect::to('../index.php');
    }
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/dashlite.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--     <script src="../assets/js/mapaApi.js" defer></script>
 -->    <!--checkbox en listado si hay una sesion-->
   <!--  <script> var isLoggedIn = <?php echo $isLoggedIn; ?>; </script>
    <script>var locations = <?php echo json_encode($locales); ?>; </script>
    <script> var data = <?php echo json_encode($data); ?>; </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/lsrc-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <!--  <script src="../assets/js/verLocales.js"></script> -->
    <script src="../assets/js/bundle.js"></script>

    <!-- Agrega el script de Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="./index.php"  class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Alta Local</h4>
                                        <div class="nk-block-des">
                                            <p>Dar de alta local en Cheersy</p>
                                        </div>
                                    </div>
                                </div>
                                <form id="altaForm" action="#" method="post">
                                    <?php if (!$usuarioController->es_propietario($_SESSION['user'])){ ?>
                                    <div class="form-group">
                                        <label class="form-label" for="dni">DNI del propietario</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="dni" placeholder="Introduce tu dni">
                                        </div>
                                        <div class="error-msg text-danger" id="error-dni"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="telefono">Teléfono</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="telefono" placeholder="Introduce tu número de telefono">
                                        </div>
                                        <div class="error-msg text-danger" id="error-telefono"></div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="form-label" for="nombre">Nombre</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="nombre" placeholder="Introduce el nombre del local">
                                        </div>
                                        <div class="error-msg text-danger" id="error-nombre"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="tipo_local">Tipo de local</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control form-control-lg" id="tipo_local">
                                                <option value="BAR">BAR</option>
                                                <option value="PUB">PUB</option>
                                                <option value="DISCOTECA">DISCOTECA</option>
                                                <option value="RESTAURANTE">RESTAURANTE</option>
                                            </select>
                                        </div>
                                        <div class="error-msg text-danger" id="error-local"></div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="form-label">Género músical</label>
                                        <div class="checkbox-group" id="genero_musical">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="REGGAETON" id="reggaeton" >
                                                <label class="form-check-label" for="reggaeton">REGGAETON</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="TECHNO" id="techno" >
                                                <label class="form-check-label" for="techno">TECHNO</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="ELECTRÓNICA" id="electronica"  >
                                                <label class="form-check-label" for="electronica">ELECTRÓNICA</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="ROCK" id="rock" >
                                                <label class="form-check-label" for="rock">ROCK</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="POP" id="pop" >
                                                <label class="form-check-label" for="pop">POP</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="JAZZ" id="jazz" >
                                                <label class="form-check-label" for="jazz">JAZZ</label>
                                            </div>
                                        </div>
                                        <div class="error-msg text-danger" id="error-genero"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="musica_en_vivo">Musica en vivo</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control form-control-lg" id="musica_en_vivo">
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="error-msg text-danger" id="error-musica"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="precio_rango">Rango de precio</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control form-control-lg" id="precio_rango">
                                                <option value="0-20">0-20</option>
                                                <option value="20-50">20-50</option>
                                                <option value="50+">50+</option>
                                            </select>
                                        </div>
                                        <div class="error-msg text-danger" id="error-precio"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="hora_apertura">Hora apertura</label>
                                        <div class="form-control-wrap">
                                            <input type="time" id="hora_apertura" name="hora_apertura" min="00:00" max="23:59" >
                                        </div>
                                        <div class="error-msg text-danger" id="error-horaap"></div>
                                        <label class="form-label" for="hora_cierre">Hora cierre</label>
                                        <div class="form-control-wrap">
                                            <input type="time" id="hora_cierre" name="hora_cierre" min="00:00" max="23:59" >
                                        </div>
                                        <div class="error-msg text-danger" id="error-horaci"></div>
                                    </div>                                                                                                          
                                    <div class="form-group">
                                        <label class="form-label">Días de apertura</label>
                                        <div class="form-control-wrap">
                                            <div class="checkbox-group" id="dias_abierto">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="LUNES" id="lunes" >
                                                    <label class="form-check-label" for="lunes">LUNES</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="MARTES" id="martes" >
                                                    <label class="form-check-label" for="martes">MARTES</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="MIÉRCOLES" id="miercoles" >
                                                    <label class="form-check-label" for="miercoles">MIÉRCOLES</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="JUEVES" id="jueves" >
                                                    <label class="form-check-label" for="jueves">JUEVES</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="VIERNES" id="viernes" >
                                                    <label class="form-check-label" for="viernes">VIERNES</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="SÁBADO" id="sabado" >
                                                    <label class="form-check-label" for="sabado">SÁBADO</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="DOMINGO" id="domingo" >
                                                    <label class="form-check-label" for="domingo">DOMINGO</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-msg text-danger" id="error-dias"></div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="form-label" for="edad_recomendada">Edad recomendada</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="edad_recomendada" placeholder="Escribe la edad recomendad">
                                        </div>
                                        <div class="error-msg text-danger" id="error-edad"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="descripcion">Descrpicion</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="descripcion" placeholder="Escribe una descripcion">
                                        </div>
                                        <div class="error-msg text-danger" id="error-desc"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="web">Web</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="web" placeholder="Escribe una direccion web">
                                        </div>
                                        <div class="error-msg text-danger" id="error-web"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="foto">Foto</label>
                                        <div class="form-control-wrap">
                                            <input type="file" class="form-control form-control-lg" id="foto" name="foto" accept="image/*">
                                        </div>
                                        <div class="error-msg text-danger" id="error-web"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="calle">Calle</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="calle" placeholder="Escribe la calle">
                                        </div>
                                        <div class="error-msg text-danger" id="error-calle"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="num_calle">Número</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" id="num_calle" min="1" step="1">
                                        </div>
                                        <div class="error-msg text-danger" id="error-num"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="cod_postal">Código Postal</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" id="cod_postal" min="1" step="1">
                                        </div>
                                        <div class="error-msg text-danger" id="error-cod"></div>
                                    </div>    
                                    <div class="form-group">
                                        <label class="form-label" for="ciudad">Ciudad</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="ciudad" placeholder="Escribe la ciudad">
                                        </div>
                                        <div class="error-msg text-danger" id="error-ciudad"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="barrio">Barrio</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="barrio" placeholder="Escribe la barrio">
                                        </div>
                                        <div class="error-msg text-danger" id="error-barrio"></div>
                                    </div>
                                    <input type="hidden" id="usuario_id" value="<?php echo $_SESSION['user']; ?>">
                                    <div class="error-msg text-danger" id="error-message"></div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block" id="altaForm" name="botonAlta">Registrarse</button>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="../assets/js/bundle.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/alta.js"></script>
</body>
<footer>
    <ul class="Redes">
        <li>
            <a href="https://www.instagram.com/cheersy.app/"><img class=""
                    src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 15.png" alt="logo"></a>
        </li>
        <li>
            <a href="https://www.facebook.com/profile.php?id=61553869796205"><img class=""
                    src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 16.png" alt="logo"></a>
        </li>
    </ul>
</footer>

</html>
