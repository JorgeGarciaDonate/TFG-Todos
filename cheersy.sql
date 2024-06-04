CREATE DATABASE cheersy;

USE cheersy;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 24-04-2024 a las 11:57:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de datos: `cheersy`

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `fotos`

CREATE TABLE `fotos` (
  `foto_id` int(11) NOT NULL,
  `local_id` int(11) DEFAULT NULL,
  `nombre_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `locales`

CREATE TABLE `locales` (
  `local_id` int(11) NOT NULL,
  `hora_apertura` time DEFAULT NULL,
  `hora_cierre` time DEFAULT NULL,
  `dias_abierto` set('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO','DOMINGO','TODOS') DEFAULT NULL,
  `nombre_local` varchar(100) DEFAULT NULL,
  /* `tipo_local` enum('BAR','PUB','DISCOTECA','RESTAURANTE') DEFAULT NULL, */
  `dias_abierto` enum('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO','DOMINGO','TODOS') DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL,
  `musica_en_vivo` tinyint(1) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  /* `genero_musical` set('REGGAETON','TECHNO','ELECTRÓNICA','ROCK','POP','JAZZ') DEFAULT NULL, */
  `genero_musical` enum('REGGAETON','TECHNO','ELECTRÓNICA','ROCK','POP','JAZZ') DEFAULT NULL;
  `edad_recomendada` tinyint(3) UNSIGNED DEFAULT NULL,
  `precio_rango` enum('0-20','20-50','50+') DEFAULT NULL,
  `web` varchar(500) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `locales`
INSERT INTO `locales` (`local_id`, `hora_apertura`, `hora_cierre`, `dias_abierto`, `nombre_local`, `tipo_local`, `ubicacion_id`, `musica_en_vivo`, `descripcion`, `genero_musical`, `edad_recomendada`, `precio_rango`, `web`,  `usuario_id`) VALUES
/* (1, '18:00:00', '06:00:00', 'SÁBADO', 'Bonded', 'PUB', 1, 0, NULL, 'REGGAETON', 25, '20-50', 'https://www.instagram.com/bonded.club/?hl=es', 1), */
(1, '18:00:00', '06:00:00', 'SÁBADO DOMINGO', 'Bonded', 'PUB', 1, 0, NULL, 'REGGAETON', 25, '20-50', 'https://www.instagram.com/bonded.club/?hl=es', 1),
(2, '20:00:00', '03:00:00', '', 'Panthera', 'PUB', 2, 0, NULL, 'TECHNO', 26, '50+', 'https://www.pantheramadrid.com/', 2),
(3, '12:00:00', '02:00:00', 'MARTES', 'Maddock', 'RESTAURANTE', 3, 0, NULL, 'REGGAETON', 25, '20-50', 'http://maddock.restaurant/', 3),
(4, '00:00:00', '06:00:00', 'MARTES', 'Fitz Club', 'DISCOTECA', 4, 1, NULL, 'JAZZ', 27, '20-50', 'https://fitzclubmadrid.com/', 1),
(5, '23:00:00', '06:00:00', 'MIÉRCOLES', 'Kapital', 'DISCOTECA', 5, 0, NULL, 'REGGAETON', 22, '0-20', 'https://teatrokapital.com/', 4),
(6, '00:00:00', '06:00:00', 'MIÉRCOLES', 'Vandido', 'DISCOTECA', 6, 0, NULL, 'REGGAETON', 28, '20-50', 'https://vandidoclub.com/', 1),
(7, '12:00:00', '06:00:00', '', 'Joy Eslava', 'DISCOTECA', 7, 0, NULL, 'REGGAETON', 23, '0-20', 'https://teatroeslava.com/', 5),
(8, '00:00:00', '06:00:00', 'VIERNES', 'Medias Puri', 'DISCOTECA', 8, 1, NULL, 'POP', 28, '20-50', 'https://mediaspuri.com/', 6),
(9, '23:30:00', '05:30:00', 'VIERNES', 'Uñas Chung Lee', 'DISCOTECA', 9, 1, NULL, 'POP', 27, '20-50', 'https://unaschunglee.com/', 6),
(10, '12:00:00', '03:00:00', 'LUNES', 'Moreira Beach', 'PUB', 10, 0, NULL, 'POP', 26, '20-50', 'https://www.instagram.com/moreirabeachoasiz/?hl=es', 7),
(11, '00:00:00', '06:00:00', 'LUNES', 'Teatro Barceló', 'DISCOTECA', 11, 0, NULL, 'REGGAETON', 25, '20-50', 'https://teatrobarcelo.com/', 5),
(12, '23:30:00', '06:00:00', 'JUEVES', 'Marusha', 'PUB', 12, 0, NULL, 'REGGAETON', 37, '20-50', 'https://www.instagram.com/marusha_society/?hl=es', 8),
(13, '23:30:00', '06:00:00', 'JUEVES', 'Muy Bendito', 'PUB', 12, 0, NULL, 'REGGAETON', 38, '50+', 'https://www.instagram.com/benditoclub_madrid/', 8),
(14, '13:00:00', '02:30:00', '', 'La Fonda Lironda', 'BAR', 13, 1, NULL, 'POP', 41, '50+', 'https://grupocarbon.es/restaurantes/fonda-lironda/', 9),
(15, '13:00:00', '00:00:00', '', 'Salvaje Bless', 'RESTAURANTE', 14, 1, NULL, 'REGGAETON', 40, '50+', 'https://www.blesscollectionhotels.com/es/madrid/bless-hotel-madrid/gastronomia/salvaje', 10),
(16, '00:00:00', '06:00:00', 'JUEVES', 'LAB The Club', 'PUB', 15, 0, NULL, 'REGGAETON', 24, '20-50', 'https://www.labtheclub.com/', 11),
(17, '20:00:00', '02:00:00', 'MIÉRCOLES', 'Punch Room', 'BAR', 16, 0, NULL, 'ELECTRÓNICA', 29, '0-20', 'https://www.editionhotels.com/es/madrid/restaurants-and-bars/punch-room/', 12),
(18, '00:00:00', '06:00:00', '', 'Opium Madrid', 'DISCOTECA', 17, 0, NULL, '', 30, '0-20', 'https://opiummadrid.com/', 13),
(19, '20:00:00', '02:00:00', 'MARTES', 'Nômâda', 'RESTAURANTE', 18, 1, NULL, 'POP', 33, '50+', 'https://www.nomadamadrid.es/', 14),
(20, '00:30:00', '06:00:00', 'MARTES', 'Îstar Club', 'PUB', 19, 0, NULL, 'ELECTRÓNICA', 30, '0-20', 'https://istarmadrid.com/', 15),
(21, '18:00:00', '06:00:00', 'MIÉRCOLES', 'Marabú', 'RESTAURANTE', 20, 1, NULL, 'REGGAETON', 33, '20-50', 'https://marabuponzano.es/', 33),
(22, '00:00:00', '06:00:00', 'MIÉRCOLES', 'Panda Club', 'PUB', 21, 0, NULL, 'REGGAETON', 30, '0-20', 'https://pandamadrid.com/club/', 17),
(23, '13:00:00', '02:00:00', '', 'QuintoElemento', 'RESTAURANTE', 22, 1, NULL, 'POP', 41, '50+', 'https://quintoelementorestaurante.com/', 4),
(24, '00:30:00', '06:00:00', 'VIERNES', 'La Bresh Madrid', 'DISCOTECA', 23, 1, NULL, 'REGGAETON', 28, '20-50', 'https://www.fiestabresh.com/', 18),
(25, '18:00:00', '02:00:00', '', 'Pompä Retiro', 'BAR', 24, 0, NULL, 'REGGAETON', 33, '20-50', 'https://floridapark.es/', 19),
(26, '00:00:00', '06:00:00', 'VIERNES', 'Lula Club', 'DISCOTECA', 25, 0, NULL, '', 35, '20-50', 'https://lula.club/', 20),
(27, '21:00:00', '06:00:00', 'JUEVES', 'El Club de los Famosos', 'DISCOTECA', 26, 0, NULL, 'REGGAETON', 33, '0-20', 'https://www.gabana.es/', 21),
(28, '17:00:00', '04:00:00', '', 'Harrison 1933', 'BAR', 27, 1, NULL, 'JAZZ', 40, '0-20', 'https://larrumba.com/restaurantes/harrison/', 22),
(29, '21:00:00', '06:00:00', '', 'Sala Siroco', 'DISCOTECA', 28, 0, NULL, 'POP', 29, '20-50', 'https://siroco.es/', 23),
(30, '23:30:00', '05:30:00', '', 'Toni2 Piano Bar', 'BAR', 29, 0, NULL, 'POP', 40, '0-20', 'https://toni2.es/', 24),
(31, '23:00:00', '05:30:00', 'LUNES', 'El Amante', 'PUB', 30, 0, NULL, 'ELECTRÓNICA', 31, '0-20', 'https://www.instagram.com/elamantebarclub/?hl=es', 25),
(32, '21:00:00', '05:00:00', 'JUEVES', 'Liberty Supper Club', 'PUB', 39, 0, NULL, 'REGGAETON', 26, '0-20', 'https://libertysupperclub.com/', 16),
(33, '23:30:00', '03:30:00', 'JUEVES', 'Mamá No Lo Sabe', 'PUB', 31, 0, NULL, 'POP', 35, '0-20', 'https://www.instagram.com/mamanolosabe_madrid/?hl=es', 26),
(34, '23:00:00', '06:00:00', 'JUEVES', 'B12 The Bar Lab', 'BAR', 32, 0, NULL, 'REGGAETON', 20, '0-20', 'https://www.b12madrid.com/', 27),
(35, '19:00:00', '04:00:00', '', 'The Jungle Jazz Club', 'PUB', 33, 0, NULL, 'JAZZ', 40, '0-20', 'https://www.thejunglejazzclub.com/', 28),
(36, '19:00:00', '03:30:00', '', 'Bárbara Ann', 'BAR', 34, 0, NULL, 'POP', 37, '0-20', 'https://barbaraann.es/?utm_source=google_business_profile&utm_medium=gbp_view_website', 32),
(37, '13:00:00', '02:30:00', '', 'Peyote San', 'DISCOTECA', 35, 0, NULL, 'REGGAETON', 38, '0-20', 'https://larrumba.com/', 29),
(38, '17:00:00', '02:30:00', '', 'La Lianta', 'BAR', 36, 0, NULL, '', 28, '0-20', 'https://grupolalala.com/locales/cervecerias/la-lianta-ponzano', 8),
(39, '13:00:00', '02:30:00', '', 'Habanera', 'RESTAURANTE', 37, 0, NULL, '', 30, '0-20', 'https://larrumba.com/restaurantes/habanera/', 29),
(40, '20:00:00', '02:30:00', '', 'Pointer Madrid', 'RESTAURANTE', 38, 0, NULL, 'REGGAETON', 23, '0-20', 'https://www.pointermadrid.com/', 30);

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `ubicaciones`

CREATE TABLE `ubicaciones` (
  `ubicacion_id` int(11) NOT NULL,
  `calle` varchar(150) DEFAULT NULL,
  `num_calle` varchar(10) DEFAULT NULL,
  `zona` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `cod_postal` varchar(10) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `ubicaciones`

INSERT INTO `ubicaciones` (`ubicacion_id`, `calle`, `num_calle`, `zona`, `ciudad`, `cod_postal`, `latitud`, `longitud`) VALUES
(1, 'Calle Miguel Ángel', '9', 'Chamberí', 'Madrid', '28010', 40.435731, -3.691698),
(2, 'Calle Miguel Ángel', '21', 'Chamberí', 'Madrid', '28010', 40.436122, -3.691836),
(3, 'General Martínez Campos', '26', 'Barrio Almagro', 'Madrid', '28010', 40.435089, -3.690175),
(4, 'Calle Princesa', '1', 'Arguelles', 'Madrid', '28008', 40.423269, -3.713214),
(5, 'Atocha', '125', 'Palos de Moguer', 'Madrid', '28012', 40.406399, -3.690660),
(6, 'Goya', '79', 'Recoletos', 'Madrid', '28001', 40.424989, -3.679602),
(7, 'Arenal', '11', 'Sol', 'Madrid', '28013', 40.415443, -3.708067),
(8, 'Tirso de Molina', '1', 'Lavapies', 'Madrid', '28012', 40.412309, -3.703185),
(9, 'Hilarion Eslava', '36', 'Moncloa', 'Madrid', '28015', 40.439597, -3.715876),
(10, 'Av. Premios Nobel', '3', 'Torrejón de Ardoz', 'Madrid', '28850', 40.445047, -3.714920),
(11, 'C. de Barceló', '11', 'Justicia', 'Madrid', '28004', 40.424869, -3.699778),
(12, 'Juan Bravo', '35', 'Goya', 'Madrid', '28006', 40.435535, -3.684227),
(13, 'Calle de Génova', '27', 'Justicia', 'Madrid', '28004', 40.426533, -3.694008),
(14, 'C. de Velázquez', '62', 'Lista', 'Madrid', NULL, 40.427306, -3.689127),
(15, 'Estación de Chamartín Planta Ático', 's/n', 'Hispanoámerica', 'Madrid', '28001', 40.472398, -3.684334),
(16, 'Pl. de Celenque', '2', 'Sol', 'Madrid', '28036', 40.416974, -3.705087),
(17, 'José Abascal', '56', 'Ríos Rosas', 'Madrid', '28013', 40.439393, -3.697706),
(18, 'Serrano', '43', 'Recoletos', 'Madrid', '28001', 40.432545, -3.688908),
(19, 'Serrano', '41', 'Recoletos', 'Madrid', '28001', 40.432539, -3.689139),
(20, 'Juan Bravo', '31', 'Goya', 'Madrid', '28006', 40.435540, -3.684455),
(21, 'C. de Ponzano', '37', 'Chamberí', 'Madrid', '28010', 40.436222, -3.699980),
(22, 'Hernani', '75', 'Cuatro Caminos', 'Madrid', '28020', 40.436758, -3.712603),
(23, 'C. de Atocha', '125', 'Palos de Moguer', 'Madrid', '28012', 40.406399, -3.690660),
(24, 'P.º Bajo de la Virgen del Puerto', 's/n', 'Arganzuela', 'Madrid', '28005', 40.415834, -3.709029),
(25, 'P.º de Panamá', NULL, 'Ibiza', 'Madrid', '28026', 40.445742, -3.667653),
(26, 'Calle Gran Vía', '54', 'Justicia', 'Madrid', '28013', 40.420565, -3.706833),
(27, 'Calle San Vicente Ferrer', '33', 'Tribunal', 'Madrid', '28004', 40.426600, -3.701579),
(28, 'Calle Recoletos', '16', 'Recoletos', 'Madrid', '28001', 40.422613, -3.688392),
(29, 'Calle San Dimas', '3', 'Noviciado', 'Madrid', '28015', 40.415631, -3.703150),
(30, 'Calle del Almirante', '9', 'Chueca', 'Madrid', '28004', 40.423347, -3.693172),
(31, 'Calle de Santiago', '3', 'Opera', 'Madrid', '28013', 40.411960, -3.703420),
(32, 'Calle de Castelló', '117', 'Avenida América', 'Madrid', '28001', 40.433727, -3.677752),
(33, 'Calle de Joaquín Costa', '27', 'Nueva España', 'Madrid', '28002', 40.427788, -3.694352),
(34, 'Calle Jorge Juan', '20', 'Recoletos', 'Madrid', '28001', 40.424389, -3.685800),
(35, 'Plaza Tirso de Molina', '1', 'Lavapiés', 'Madrid', '28012', 40.411980, -3.703550),
(36, 'Calle Santa Teresa', '8', 'Alamgro', 'Madrid', '28004', 40.415739, -3.707459),
(37, 'Calle Marqués de la Ensenada', '16', 'Chamberí', 'Madrid', '28004', 40.421665, -3.701522),
(38, 'Calle de Ponzano', '10', 'Justicia', 'Madrid', '28010', 40.434047, -3.699858),
(39, 'Calle Génova', '28', 'Justicia', 'Madrid', '28004', 40.426429, -3.694229);

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `usuarios`

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `fecha_de_nacimiento` date DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `password_hash` char(64) NOT NULL,
  `password_salt` char(16) NOT NULL,
  `es_propietario` tinyint(1) DEFAULT NULL,
  `dni` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `usuarios`

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `apellido`, `email`, `fecha_de_nacimiento`, `telefono`, `nombre_usuario`, `password_hash`, `password_salt`, `es_propietario`, `dni`) VALUES
(1, 'Alberto', 'Hidalgo', 'alberto.hidalgo@gmail.com', '1987-04-15', '611234567', 'albertohidalgo', '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e', '', 1, '98765432B'),
(2, 'Enrique', 'Sierra', 'kikesierra@yahoo.com', '1986-08-22', '622345678', 'kikesierra', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '', 1, '87654321C'),
(3, 'Mario', 'Gutierrez', 'mariogutierrez@gmail.com', '1985-11-28', '633456789', 'mario.gutierrez', '65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5', '', 1, '23456789D'),
(4, 'Nacho', 'Gonzalez', 'nachogonzalez@gmail.com', '1984-02-01', '644567890', 'nachogonzalez', '6ca13d52ca70c883e0f0bb101e425a89e8624de51db2d2392593af6a84118090', '', 1, '34567890E'),
(5, 'David', 'De las Heras', 'davidheras13@correo.com', '1983-06-09', '655678901', 'davidheras13', '1c8bfe8f801d79745c4631d09fff36c82aa37fc4cce4fc946683d7b336b63032', '', 1, '45678901F'),
(6, 'Pedro', 'Trapote', 'pedrotapote@gmail.com', '1982-09-14', '666789012', 'pedrotrapote', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', '', 1, '56789012G'),
(7, 'Iñaki', 'Fernandez', 'ifernandez@gmail.com', '1981-12-20', '677890123', 'ifernandez', '6382deaf1f5dc6e792b76db4a4a7bf2ba468884e000b25e7928e621e27fb23cb', '', 1, '67890123H'),
(8, 'Grupo Moreira', '', 'gmoreira@gmail.com', '1980-03-25', '688901234', 'grupo_moreira', 'e4ad93ca07acb8d908a3aa41e920ea4f4ef4f26e7f86cf8291c5db289780a5ae', '', 1, '78901234J'),
(9, 'Grupo Lalala', '', 'glalala@hotmail.com', '1979-07-02', '699012345', 'lalala3', '280d44ab1e9f79b5cce2dd4f58f5fe91f0fbacdac9f7447dffc318ceb79f2d02', '', 1, '89012345K'),
(10, 'Grupo Carbón Negro', '', 'carbonnegro@gmail.com', '1978-10-07', '610123456', 'carbon_negro', 'a941a4c4fd0c01cddef61b8be963bf4c1e2b0811c037ce3f1835fddf6ef6c223', '', 1, '90123456L'),
(11, 'Fermin', 'Azkue', 'femin.azkue@gmail.com', '1977-01-12', '621234567', 'ferminazkue', 'c775e7b757ede630cd0aa1113bd102661ab38829ca52a6422ab782862f268646', '', 1, '01234567M'),
(12, 'Miguel Angel', 'Flores', 'miguelflores@gmail.com', '1976-04-18', '632345678', 'miguelflores', '04e77bf8f95cb3e1a36a59d1e93857c411930db646b46c218a0352e432023cf2', '', 1, '34567890N'),
(13, 'Enrique', 'Curt gómez', 'enriquecurt@gmail.com', '1975-07-24', '643456789', 'enriquecurt', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', '', 1, '45678901P'),
(14, 'Ramón', 'Bordas', 'ramonbordas@gmail.com', '1974-11-01', '654567890', 'ramonbordas', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '', 1, '56789012Q'),
(15, 'Alfonso', 'Perez', 'aperez@htmail.com', '1972-04-05', '676789012', 'alfonsoperez', '000c285457fc971f862a79b786476c78812c8897063c6fa9c045f579a3b2d63f', '', 1, '78901234S'),
(16, 'Boramy', 'Hour', 'boramy@gmail.com', '1970-10-19', '698901234', 'boramy', '8f0e2f76e22b43e2855189877e7dc1e1e7d98c226c95db247cd1d547928334a9', '', 1, '90123456U'),
(17, 'Carlos', 'Escudero Segura', 'carlosescudero@gmail.com', '1969-01-24', '609012345', 'carlosescudero', '0bb09d80600eec3eb9d7793a6f859bedde2a2d83899b70bd78e961ed674b32f4', '', 1, '01234567V'),
(18, 'Carlos', 'Velaz Rey', 'carlosvelazrey@gmail.com', '1968-05-02', '620123456', 'carlosvelaz', 'fc613b4dfd6736a7bd268c8a0e74ed0d1c04a959f59dd74ef2874983fd443fc9', '', 1, '12345678W'),
(19, 'Jaime', 'Martin James', 'jmartin@hotmail.com', '1966-10-09', '642345678', 'jaimemartinj', '221b37fcdb52d0f7c39bbd0be211db0e1c00ca5fbecd5788780463026c6b964b', '', 1, '34567890Y'),
(20, 'Rubén', 'Labarzana', 'ruben.labarzana@gmail.com', '1965-01-15', '653456789', 'rubenlabarzana', '74fca0325b5fdb3a34badb40a2581cfbd5344187e8d3432952a5abc0929c1246', '', 1, '45678901Z'),
(21, 'Iñigo', 'Onieva', 'inigoonieva@hotmail.com', '1964-04-22', '664567890', 'ionieva', 'a9c43be948c5cabd56ef2bacffb77cdaa5eec49dd5eb0cc4129cf3eda5f0e74c', '', 1, '56789012A'),
(22, 'Joe', 'Fournier', 'joefournier2@gmail.com', '1963-07-30', '675678901', 'joefournier2', 'a01edad91c00abe7be5b72b5e36bf4ce3c6f26e8bce3340eba365642813ab8b6', '', 1, '67890123B'),
(23, 'Carlos', 'Moreno', 'cmoreno@gmail.com', '1962-11-06', '686789012', 'carlosmoreno', '65c21921ca10a8502757efc9aa552874d181c6206feb2845a921eb57f5e518d4', '', 1, '78901234C'),
(24, 'Miguel Angel', 'Calvate', 'mangelcalvate@gmail.com', '1960-05-12', '608901234', 'mangelcalvate', 'cede333b0ff2c5317c0b7030db6f46ffd24d2d2f2fb96f49ca9769cf4b3e15ad', '', 1, '90123456E'),
(25, 'Antonio', 'Tejero', 'antoniotejero@gmail.com', '1982-02-16', '619012345', 'antoniotejero', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '', 1, '01234567F'),
(26, 'Raquel', 'Meroño', 'raqelmerono@hotmail.com', '1983-07-21', '630123456', 'raquelmerono', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', 1, '12345678G'),
(27, 'Luis', 'Díaz Córdoba', 'luisdiazcord3@gmail.com', '1984-10-28', '652345678', 'luisdcordoba', '203b70b5ae883932161bbd0bded9357e763e63afce98b16230be33f0b94c2cc5', '', 1, '34567890J'),
(28, 'Javier', 'Fernadéz de Valderrama', 'jfernandez@yahoo.com', '1985-12-03', '663456789', 'javierferval', '27cc6994fc1c01ce6659c6bddca9b69c4c6a9418065e612c69d110b3f7b11f8a', '', 1, '45678901K'),
(29, 'Grupo Paraguas', '', 'empresa@grupoparaguas.es', '1987-01-09', '674567890', 'paraguasgroup', 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', '', 1, '56789012L'),
(30, 'Grupo larrumba', '', 'grupolarrumba@gmail.com', '1989-02-15', '685678901', 'glarruemba', '9b0eb22aef89516d6fb4b31ccf008a68abe0d10a3fc606316389613eccf96854', '', 1, '67890123M'),
(31, 'Gonzalo', 'Barandiaran', 'gbarandiaran@hotmail.com', '1989-02-15', '607890123', 'gonzalobarandiaran', 'de847752bf50ff0aae49e7fcf81d189ac72a7db8086664f6737dc77442b35ee7', '', 1, '89012345P'),
(32, 'Leandro', 'Cersosimo', 'leandrocersimo33@gmail.com', '1996-04-10', '618901234', 'leandrocersosimo33', '48e1336dc302bd93351f91cb794526c2a9081ca906c09574e5bdefe11873384d', '', 1, '90123456Q'),
(33, 'Grupo Viva las Vegas', '', 'grupovlv@gmail.com', '1962-05-29', '684025915', 'grupo_vlv', '1b6b6ead3524c10a589485b908c270925407f02e3cb5e3a187a0ce9b6d50d31c', '', 1, '90123251F'),
(34, 'Joe', 'Fish', 'joefish@hotmail.com', '1967-04-28', '657924351', 'fishjoe', 'd37c0f1c9f139928d0e4ce1e399b44495fd5b25640f3da74735c46563d69bd72', '', 1, '90123495R');

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `valoraciones`

CREATE TABLE `valoraciones` (
  `valoracion_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `local_id` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `nota` tinyint(3) UNSIGNED DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Índices para tablas volcadas

INSERT INTO `fotos` (`foto_id`, `local_id`, `nombre_foto`) VALUES
(1, 1,  'Bonded'),
(2, 2,  'Panthera'),
(3, 3,  'Maddock'),
(4, 4,  'Fitz Club'),
(5, 5,  'Kapital'),
(6, 6,  'Vandido'),
(7, 7,  'Joy Eslava'),
(8, 8,  'Medias Puri'),
(9, 9,  'Uñas Chung Lee'),
(10, 10,  'Moreira Beach'),
(11, 11,  'Teatro Barceló'),
(12, 12,  'Marusha'),
(13, 13,  'Muy Bendito'),
(14, 14,  'La Fonda Lironda'),
(15, 15,  'Salvaje Bless'),
(16, 16,  'LAB The Club'),
(17, 17,  'Punch Room'),
(18, 18,  'Opium Madrid'),
(19, 19,  'Nômâda'),
(20, 20,  'Îstar Club'),
(21, 21,  'Marabú'),
(22, 22,  'Panda Club'),
(23, 23,  'QuintoElemento'),
(24, 24,  'La Bresh Madrid'),
(25, 25,  'Pömpa Retiro'),
(26, 26,  'Lula Club'),
(27, 27,  'El Club de los Famosos'),
(28, 28,  'Harrison 1933'),
(29, 29,  'Sala Siroco'),
(30, 30,  'Toni2 Piano Bar'),
(31, 31,  'El Amante'),
(32, 32,  'Liberty Supper Club'),
(33, 33,  'Mamá No Lo Sabe'),
(34, 34,  'B12 The Bar Lab'),
(35, 35,  'The Jungle Jazz Club'),
(36, 36,  'Bárbara Ann'),
(37, 37,  'Peyote San'),
(38, 38,  'Peyote San'),
(39, 39,  'Habanera'),
(40, 40,  'Pointer Madrid');


-- Indices de la tabla `fotos`

ALTER TABLE `fotos`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `local_id` (`local_id`);

-- Indices de la tabla `locales`

ALTER TABLE `locales`
  ADD PRIMARY KEY (`local_id`),
  ADD KEY `ubicacion_id` (`ubicacion_id`),
  ADD KEY `usuario_id` (`usuario_id`);

-- Indices de la tabla `ubicaciones`

ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`ubicacion_id`),
  ADD KEY `idx_latitud_longitud` (`latitud`,`longitud`);

-- Indices de la tabla `usuarios`

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `idx_email` (`email`);

-- Indices de la tabla `valoraciones`

ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`valoracion_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `local_id` (`local_id`);

-- AUTO_INCREMENT de las tablas volcadas

-- AUTO_INCREMENT de la tabla `fotos`

ALTER TABLE `fotos`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT de la tabla `locales`

ALTER TABLE `locales`
  MODIFY `local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

-- AUTO_INCREMENT de la tabla `ubicaciones`

ALTER TABLE `ubicaciones`
  MODIFY `ubicacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

-- AUTO_INCREMENT de la tabla `usuarios`

ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

-- AUTO_INCREMENT de la tabla `valoraciones`

ALTER TABLE `valoraciones`
  MODIFY `valoracion_id` int(11) NOT NULL AUTO_INCREMENT;

-- Restricciones para tablas volcadas

-- Filtros para la tabla `fotos`

ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`local_id`) REFERENCES `locales` (`local_id`);

-- Filtros para la tabla `locales`

ALTER TABLE `locales`
  ADD CONSTRAINT `locales_ibfk_1` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`ubicacion_id`),
  ADD CONSTRAINT `locales_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

-- Filtros para la tabla `valoraciones`

ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`local_id`) REFERENCES `locales` (`local_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
