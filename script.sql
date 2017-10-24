-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: custsql-ipg48.eigbox.net
-- Tiempo de generación: 24-06-2017 a las 16:22:22
-- Versión del servidor: 5.6.32
-- Versión de PHP: 4.4.9
--
-- Base de datos: `androidplus`
--
CREATE DATABASE `androidplus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `androidplus`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

CREATE TABLE `chofer` (
  `idchofer` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `contrasena` varchar(150) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`idchofer`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcar la base de datos para la tabla `chofer`
--

INSERT INTO `chofer` VALUES (1, 'Prueba Prueba', 'Cajamarca', '333333', '22121212', '123', '1');
INSERT INTO `chofer` VALUES (5, 'Edwin Chacha Condor', 'jr. revilla perez 280', '974852806', '48140187', '123', '1');
INSERT INTO `chofer` VALUES (6, 'ELMER CHUQUILIN FIGUEROA ', 'JR. SAN ISIDRO 370', '950242009', '42543279', '123', '1');
INSERT INTO `chofer` VALUES (7, 'WALTER GONZALES BACON', '', '969982261', '48627604', '123', '1');
INSERT INTO `chofer` VALUES (8, 'JORGE LUIS PEREZ CELIS', '', '989920927', '32869917', '123', '1');
INSERT INTO `chofer` VALUES (9, 'JULIAN AGUILAR CHAUPE', '', '979875366', '45310001', '123', '1');
INSERT INTO `chofer` VALUES (10, 'Willam Estacio Ocas', NULL, '930434716', '47863779', '123', '1');
INSERT INTO `chofer` VALUES (11, 'Prueba', 'Cajamarca', '21020192', '12312345', 'hola', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `dni` char(8) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apaterno` varchar(45) DEFAULT NULL,
  `amaterno` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `contrasena` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `dni_UNIQUE` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Volcar la base de datos para la tabla `cliente`
--

INSERT INTO `cliente` VALUES (13, '11111111', 'Prueba', 'Materno', 'Paterno', '999999999', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `cliente` VALUES (33, '11111113', 'Nombres', 'Apellido Paterno', 'Apellido Materno', '978987567', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `cliente` VALUES (34, '12345678', 'Martín', 'Suárez', 'Barrueto', '987654321', 'c147e6a0f1da24e71ae717f3b8548e89');
INSERT INTO `cliente` VALUES (42, '87654321', 'Prueba', 'Prueba', 'Prueba', '123456789', 'c893bad68927b457dbed39460e6afd62');
INSERT INTO `cliente` VALUES (43, '70408005', 'Henry Bravo ', 'Bravo', 'Sánchez', '973772738', '1c7a92ae351d4e21ebdfb897508f59d6');
INSERT INTO `cliente` VALUES (44, '14214212', 'prueba', 'apl', 'mat', NULL, NULL);
INSERT INTO `cliente` VALUES (45, '48140187', 'edwin', 'chacha', 'condor', '974852806', '92dc3e752b495c4ee795307bacc4ea2b');
INSERT INTO `cliente` VALUES (46, '26698460', 'Víctor', 'chacha', 'vargas', '987010948', '61f16cdd46e10f5c1b46743a8a9b6e30');
INSERT INTO `cliente` VALUES (49, '54327143', 'victor', '', '', '', NULL);
INSERT INTO `cliente` VALUES (50, '42543279', 'elmer', 'chugden', 'figueroa', '950242009', 'ccd6cc844309f0d7a26995f7c5d5b2ef');
INSERT INTO `cliente` VALUES (66, '77771111', 'hola', 'prueba', 'prueba', '12312345', '202cb962ac59075b964b07152d234b70');
INSERT INTO `cliente` VALUES (67, '48031701', 'isaias josue ', 'briones', 'torres ', '995961526', '58e8ff9846f59599dc357f831184e22d');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idempleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `apellidop` varchar(200) DEFAULT NULL,
  `apellidom` varchar(200) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `user` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `dni` char(8) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  PRIMARY KEY (`idempleado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `empleado`
--

INSERT INTO `empleado` VALUES (1, 'Administrador', 'Administrador', 'Administardor', 'henry.b@bravos.pe', 'admin', '87be28929312a94de8a29a87d6f72573d15cccd9', '1', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_rol`
--

CREATE TABLE `empleado_rol` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idrol` int(10) NOT NULL,
  `idempleado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_rol_rol1_idx` (`idrol`),
  KEY `fk_empleado_rol_empleado1_idx` (`idempleado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `empleado_rol`
--

INSERT INTO `empleado_rol` VALUES (2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maneja`
--

CREATE TABLE `maneja` (
  `idmaneja` int(11) NOT NULL,
  `idmovilidad` int(11) NOT NULL,
  `idchofer` int(11) NOT NULL,
  PRIMARY KEY (`idmaneja`),
  KEY `fk_maneja_movilidad1_idx` (`idmovilidad`),
  KEY `fk_maneja_chofer1_idx` (`idchofer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `maneja`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad`
--

CREATE TABLE `movilidad` (
  `idmovilidad` int(11) NOT NULL AUTO_INCREMENT,
  `nplaca` varchar(45) DEFAULT NULL,
  `color` char(1) DEFAULT NULL,
  `longitud` varchar(100) DEFAULT NULL,
  `latitud` varchar(100) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `idchofer` int(11) DEFAULT NULL,
  `interno` int(11) NOT NULL,
  PRIMARY KEY (`idmovilidad`),
  UNIQUE KEY `interno` (`interno`),
  KEY `fk_movilidad_chofer1_idx` (`idchofer`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Volcar la base de datos para la tabla `movilidad`
--

INSERT INTO `movilidad` VALUES (1, 'P0001', NULL, '-78.508818333333', '-7.1641616666667', 'car.png', '1', 1, 1);
INSERT INTO `movilidad` VALUES (12, 'M1E-661', NULL, '-78.5134854', '-7.1517224', '2016-05-28-20-17-36-942.jpg', '3', 5, 2);
INSERT INTO `movilidad` VALUES (13, 'F2U-638', NULL, '-78.50352313594435', '-7.1611791084725045', NULL, '3', 6, 3);
INSERT INTO `movilidad` VALUES (14, 'AJX-102', NULL, '-78.5136709', '-7.1517016', NULL, '3', 7, 4);
INSERT INTO `movilidad` VALUES (15, 'D1P-560', NULL, '-78.52211', '-7.1515598', NULL, '3', 8, 5);
INSERT INTO `movilidad` VALUES (16, 'M1O-619', NULL, '-78.5135045', '-7.1517491', NULL, '3', 9, 6);
INSERT INTO `movilidad` VALUES (17, 'A9C-649', NULL, '-78.5140814', '-7.1604884', NULL, '3', 10, 7);
INSERT INTO `movilidad` VALUES (19, 'PLA-01', NULL, '-78.50352313594435', '-7.1611791084725045', NULL, '3', 11, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `idrecurso` int(10) NOT NULL,
  PRIMARY KEY (`idpermiso`),
  KEY `fk_permiso_recurso1_idx` (`idrecurso`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

--
-- Volcar la base de datos para la tabla `permiso`
--

INSERT INTO `permiso` VALUES (60, 'index', 'Permisos', 1);
INSERT INTO `permiso` VALUES (61, 'add', 'Agregar permiso', 2);
INSERT INTO `permiso` VALUES (62, 'edit', 'Editar permiso', 2);
INSERT INTO `permiso` VALUES (63, 'index', 'roles', 2);
INSERT INTO `permiso` VALUES (64, 'index', 'reservas', 3);
INSERT INTO `permiso` VALUES (65, 'movilidad', 'movilidades', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `idrecurso` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrecurso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `recurso`
--

INSERT INTO `recurso` VALUES (1, 'Administrador\\Controller\\Index');
INSERT INTO `recurso` VALUES (2, 'Administrador\\Controller\\Rol');
INSERT INTO `recurso` VALUES (3, 'Reserva\\Controller\\Index');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `rol`
--

INSERT INTO `rol` VALUES (2, 'ADMINISTRADOR', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idrol` int(10) NOT NULL,
  `idpermiso` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rol_permiso_rol1_idx` (`idrol`),
  KEY `fk_rol_permiso_permiso1_idx` (`idpermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Volcar la base de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` VALUES (59, 2, 60);
INSERT INTO `rol_permiso` VALUES (60, 2, 61);
INSERT INTO `rol_permiso` VALUES (61, 2, 62);
INSERT INTO `rol_permiso` VALUES (62, 2, 63);
INSERT INTO `rol_permiso` VALUES (63, 2, 65);
INSERT INTO `rol_permiso` VALUES (64, 2, 64);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `idruta` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idmovilidad` int(11) DEFAULT NULL,
  `latitudo` varchar(100) DEFAULT NULL,
  `latitudd` varchar(100) DEFAULT NULL,
  `longitudo` varchar(100) DEFAULT NULL,
  `longitudd` varchar(100) DEFAULT NULL,
  `precio` decimal(7,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `origen` varchar(200) DEFAULT NULL,
  `destino` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idruta`),
  KEY `fk_ruta_cliente_idx` (`idcliente`),
  KEY `fk_ruta_movilidad1_idx` (`idmovilidad`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `ruta`
--

INSERT INTO `ruta` VALUES (1, 66, 1, '-7.1648168', '0', '-78.5053519', '0', -1.00, '3', 'Progreso 742, Cajamarca, Peru', '0');
INSERT INTO `ruta` VALUES (2, 66, 1, '-7.1648317', '-7.1670774680686', '-78.5053933', '-78.505114652216', -1.00, '4', 'Progreso 742, Cajamarca, Peru', 'Jr. Emacipación 294, Cajamarca, Peru');
INSERT INTO `ruta` VALUES (3, 43, 1, '-7.1648583', '-7.1685967076123', '-78.5053283', '-78.502501510084', -1.00, '4', 'Progreso 742, Cajamarca, Peru', 'Mártires De Uchuracay 640, Cajamarca, Peru');
INSERT INTO `ruta` VALUES (4, 43, 1, '-7.1648583', '0', '-78.5053283', '0', -1.00, '3', 'Progreso 742, Cajamarca, Peru', '0');
INSERT INTO `ruta` VALUES (5, 43, 1, '-7.1648133', '-7.1648719503669', '-78.5054033', '-78.505476079881', -1.00, '4', 'Progreso 742, Cajamarca, Peru', 'Progreso 742, Cajamarca, Peru');
INSERT INTO `ruta` VALUES (6, 43, 1, '-7.1648517', '-7.1676646063514', '-78.5053267', '-78.506061471999', -1.00, '4', 'Progreso 742, Cajamarca, Peru', 'Jr. Emacipación 238, Cajamarca, Peru');
INSERT INTO `ruta` VALUES (7, 46, 1, '-7.1613002', '0', '-78.5031959', '0', -1.00, '3', 'Prol San Luis, Cajamarca, Peru', '0');
INSERT INTO `ruta` VALUES (8, 46, 1, '-7.1566403', '-7.1578418330662', '-78.5168665', '-78.509574830532', -1.00, '4', 'Galería Plaza, Amalia Puga, Cajamarca, Peru', 'Miguel Grau 857, Cajamarca, Peru');
INSERT INTO `ruta` VALUES (12, 34, 1, '-7.17392', '-7.1714495510109', '-78.5128017', '-78.510336242616', -1.00, '6', 'Av Independencia 1018-1054, Cajamarca, Perú', 'Diego Ferre 123');

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `empleado_rol`
--
ALTER TABLE `empleado_rol`
  ADD CONSTRAINT `fk_empleado_rol_empleado1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleado_rol_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `maneja`
--
ALTER TABLE `maneja`
  ADD CONSTRAINT `fk_maneja_chofer1` FOREIGN KEY (`idchofer`) REFERENCES `chofer` (`idchofer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_maneja_movilidad1` FOREIGN KEY (`idmovilidad`) REFERENCES `movilidad` (`idmovilidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movilidad`
--
ALTER TABLE `movilidad`
  ADD CONSTRAINT `fk_movilidad_chofer1` FOREIGN KEY (`idchofer`) REFERENCES `chofer` (`idchofer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `fk_permiso_recurso1` FOREIGN KEY (`idrecurso`) REFERENCES `recurso` (`idrecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `fk_rol_permiso_permiso1` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_permiso_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `fk_ruta_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ruta_movilidad1` FOREIGN KEY (`idmovilidad`) REFERENCES `movilidad` (`idmovilidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;
