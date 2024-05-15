<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <!-- Page Title  -->
    <title>Registro</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    

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
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../assets/img/logo.png" srcset="../assets/img/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../assets/img/logo-dark.png" srcset="../assets/img/logo-dark2x.png 2x" alt="logo-dark">
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
                                    <!-- Hoa apertura, cierre, dias abierto, nombre, tipo local, ubicacion, musica en vivo, descripcion, genero musical, edad recomentada, precio_rango,  -->
                                    <div class="form-group">
                                        <label class="form-label" for="nombre">Nombre</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="nombre" placeholder="Introduce el nombre del local">
                                        </div>
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
                                    </div> 
                                    <div class="form-group">
                                        <label class="form-label">Género músical</label>
                                        <div class="form-control-wrap">
                                            <div class="checkbox-list">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="reggaeton" value="REGGAETON">
                                                    <label class="custom-control-label" for="reggaeton">Reggaeton</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="techno" value="TECHNO">
                                                    <label class="custom-control-label" for="techno">Techno</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="electrónica" value="ELECTRÓNICA">
                                                    <label class="custom-control-label" for="electrónica">Electrónica</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rock" value="ROCK">
                                                    <label class="custom-control-label" for="rock">Rock</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="pop" value="POP">
                                                    <label class="custom-control-label" for="pop">Pop</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="jazz" value="JAZZ">
                                                    <label class="custom-control-label" for="jazz">Jazz</label>
                                                </div>                                               
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="hora_apertura">Hora apertura</label>
                                        <div class="form-control-wrap">
                                            <input type="time" id="hora_apertura" name="hora_apertura" min="00:00" max="23:59" required>
                                        </div>
                                        <label class="form-label" for="hora_cierre">Hora cierre</label>
                                        <div class="form-control-wrap">
                                            <input type="time" id="hora_cierre" name="hora_cierre" min="00:00" max="23:59" required>
                                        </div>
                                    </div>                                                                                                          
                                    <div class="form-group">
                                        <label class="form-label">Días de apertura</label>
                                        <div class="form-control-wrap">
                                            <div class="checkbox-list">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="lunes" value="LUNES">
                                                    <label class="custom-control-label" for="lunes">Lunes</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="martes" value="MARTES">
                                                    <label class="custom-control-label" for="martes">Martes</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="miercoles" value="MIÉRCOLES">
                                                    <label class="custom-control-label" for="miercoles">Miércoles</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="jueves" value="JUEVES">
                                                    <label class="custom-control-label" for="jueves">Jueves</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="viernes" value="VIERNES">
                                                    <label class="custom-control-label" for="viernes">Viernes</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="sabado" value="SÁBADO">
                                                    <label class="custom-control-label" for="sabado">Sábado</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="domingo" value="DOMINGO">
                                                    <label class="custom-control-label" for="domingo">Domingo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="form-label" for="calle">Calle</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="calle" placeholder="Escribe la calle">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="num_calle">Número</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" id="num_calle" min="1" step="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="cod_postal">Código Postal</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" id="cod_postal" min="1" step="1">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label class="form-label" for="ciudad">Ciudad</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="ciudad" placeholder="Escribe la ciudad">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="barrio">Barrio</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="barrio" placeholder="Escribe la barrio">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block" id="botonAlta">Registrarse</button>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Help</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-start">
                                        <p class="text-soft">&copy; 2022 Dashlite. All Rights Reserved.</p>
                                    </div>
                                </div>
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


</html>
