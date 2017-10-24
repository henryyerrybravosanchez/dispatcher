-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-11-2016 a las 16:00:43
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bddocumentario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta`
--

CREATE TABLE `alerta` (
  `idalerta` int(11) NOT NULL,
  `mensaje` varchar(1000) DEFAULT NULL,
  `destinatario` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--
-- en uso(#1932 - Table 'bddocumentario.almacen' doesn't exist in engine)
-- Error leyendo datos: (#1932 - Table 'bddocumentario.almacen' doesn't exist in engine)

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `idoficina` int(11) NOT NULL,
  `saldo` decimal(16,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`idoficina`, `saldo`) VALUES
(1, '599.0000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `apellidop` varchar(15) DEFAULT NULL,
  `apellidom` varchar(15) DEFAULT NULL,
  `dni` char(8) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `razon` varchar(45) DEFAULT NULL,
  `ruc` char(11) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `apellidop`, `apellidom`, `dni`, `direccion`, `razon`, `ruc`, `telefono`, `correo`, `estado`) VALUES
(1, 'CLientito', 'PAterno', 'Amterno', '70292922', 'cajaamrca', 'perus', '122233333', NULL, NULL, '2'),
(2, 'Prueba', 'Apellido', 'Paterno', '121221', 'Pauca', NULL, '88888888888', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fechaingreso` datetime DEFAULT NULL,
  `fechaaprobacion` datetime DEFAULT NULL,
  `fechapago` datetime DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL,
  `idaprobacion` int(11) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `idoficina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idempleado`, `descripcion`, `fechaingreso`, `fechaaprobacion`, `fechapago`, `fecharegistro`, `idaprobacion`, `estado`, `idoficina`) VALUES
(9, 1, 'Compritas ', '2016-11-25 10:01:36', '2016-11-25 10:01:36', '2016-11-25 10:01:36', '2016-11-16 10:02:02', 2, '3', 0),
(10, 1, 'Compras para nuevo almacen', '2016-11-16 12:53:31', NULL, NULL, '2016-11-16 12:53:59', NULL, '4', 0),
(11, 1, 'Compritas del super', '2016-11-19 12:06:14', NULL, NULL, '2016-11-19 12:09:48', NULL, '1', 0),
(12, 2, 'Nueva comprita', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 13:22:58', NULL, '1', 1),
(13, 2, 'Nueva comprita', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 13:24:56', NULL, '1', 1),
(14, 2, 'Nueva comprita', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 13:26:41', NULL, '1', 1),
(15, 2, 'Nueva comprita', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 14:11:18', NULL, '1', 1),
(16, 2, 'Nueva comprita', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 14:13:53', NULL, '1', 1),
(17, 2, 'Nueva comprototas', '2016-11-19 01:16:30', NULL, NULL, '2016-11-19 14:15:42', NULL, '1', 1),
(18, 2, 'Nueva comprototas', '2016-11-19 01:16:30', '2016-11-19 01:16:30', '2016-11-19 01:16:30', '2016-11-19 14:21:30', 1, '3', 1),
(19, 2, 'dsdsd', '2016-11-28 11:16:23', NULL, NULL, '2016-11-28 11:16:44', NULL, '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `idcontrato` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `sueldo` decimal(7,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `idoficina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contrato`
--

INSERT INTO `contrato` (`idcontrato`, `idempleado`, `fechainicio`, `fechafin`, `sueldo`, `estado`, `idoficina`) VALUES
(1, 3, '2016-11-01', '2016-11-30', '300.00', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `idcotizacion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idoficina` int(11) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso`
--

CREATE TABLE `egreso` (
  `idegreso` int(11) NOT NULL,
  `idresponsable` int(11) DEFAULT NULL,
  `idsolicitante` int(11) DEFAULT NULL,
  `idoficina` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `numerocom` varchar(20) DEFAULT NULL,
  `cantidad` decimal(12,2) DEFAULT NULL,
  `fechaingreso` datetime DEFAULT NULL,
  `fecharespuesta` datetime DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `egreso`
--

INSERT INTO `egreso` (`idegreso`, `idresponsable`, `idsolicitante`, `idoficina`, `descripcion`, `tipo`, `numerocom`, `cantidad`, `fechaingreso`, `fecharespuesta`, `fecharegistro`, `estado`) VALUES
(1, 0, 1, 1, 'para compritas', '1', '1234555', '12.00', '2016-11-19 02:53:42', '0000-00-00 00:00:00', '2016-11-19 20:53:59', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idempleado` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `apellidop` varchar(25) DEFAULT NULL,
  `apellidom` varchar(25) DEFAULT NULL,
  `dni` char(8) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `cargo` char(1) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idempleado`, `nombre`, `apellidop`, `apellidom`, `dni`, `direccion`, `telefono`, `fechanacimiento`, `correo`, `estado`, `cargo`, `password`, `user`) VALUES
(1, 'Henry', 'Bravo', 'Sanchez', '70408005', 'Cajamarca', '12345678', '2016-11-02', 'hbravos.info@gmail.com', '1', '1', '', ''),
(2, 'Levi', 'Arista', 'Nose :v', '12121222', 'CAjamrca', '1233312', '2016-11-11', 'hbravos@unc.edu.pe', '1', '1', '', ''),
(3, 'Administrador', 'Didepti', 'Didepti', '99999999', NULL, NULL, NULL, NULL, NULL, NULL, '87be28929312a94de8a29a87d6f72573d15cccd9', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_rol`
--

CREATE TABLE `empleado_rol` (
  `id` int(10) NOT NULL,
  `idrol` int(10) NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado_rol`
--

INSERT INTO `empleado_rol` (`id`, `idrol`, `idempleado`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idinventario` int(11) NOT NULL,
  `idalmacen` int(11) NOT NULL,
  `idsuministro` int(11) NOT NULL,
  `fechaingreso` datetime DEFAULT NULL,
  `fechasalida` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `preciocompra` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitacion`
--

CREATE TABLE `invitacion` (
  `idinvitacion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idoficina` int(11) NOT NULL,
  `fechaconsulta` date DEFAULT NULL,
  `fechavisita` date DEFAULT NULL,
  `fechapresentacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineacompra`
--

CREATE TABLE `lineacompra` (
  `idlinea` int(11) NOT NULL,
  `idcompra` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lineacompra`
--

INSERT INTO `lineacompra` (`idlinea`, `idcompra`, `nombre`, `cantidad`, `precio`) VALUES
(1, 9, NULL, 2, '1.00'),
(7, 10, 'productito', 4, '1.00'),
(13, 14, 'Nueviyo', 4, '1.00'),
(14, 15, 'Nueviyo', 4, '1.00'),
(15, 17, 'Hola', 3, '23.00'),
(16, 18, 'comprooaksoas', 3, '3.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineacotizacion`
--

CREATE TABLE `lineacotizacion` (
  `idcotizacion` int(11) NOT NULL,
  `idsuministro` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaorden`
--
-- en uso(#1932 - Table 'bddocumentario.lineaorden' doesn't exist in engine)
-- Error leyendo datos: (#1932 - Table 'bddocumentario.lineaorden' doesn't exist in engine)

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineapedido`
--

CREATE TABLE `lineapedido` (
  `idsuministro` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idpedido` int(11) NOT NULL,
  `cantidad` varchar(45) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineatraslado`
--

CREATE TABLE `lineatraslado` (
  `idtraslado` int(11) NOT NULL,
  `idinventario` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaventa`
--

CREATE TABLE `lineaventa` (
  `idlineaventa` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(7,2) DEFAULT NULL,
  `idventa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lineaventa`
--

INSERT INTO `lineaventa` (`idlineaventa`, `descripcion`, `cantidad`, `precio`, `idventa`) VALUES
(1, 'sasa', 5, '4.00', 4),
(2, 'primer pro', 1, '12.00', 4),
(3, 'producto 2', 3, '1.00', 4),
(4, 'dada', 3, '121.00', 4),
(5, 'Producto', 5, '3.00', 4),
(6, 'Carretilla', 1, '2.00', 7),
(7, 'Pic', 2, '3.00', 7),
(8, 'Primero hecho b', 2, '3.00', 10),
(9, 'Esta es una descrpicion muy grande como para que malogre la ', 4, '34.00', 10),
(10, 'Juguestes', 2, '3.00', 11),
(11, 'sasa', 3, '2.00', 12),
(12, 'deli', 1, '3.00', 13),
(13, 'Esta es una descripción grande para estropear la tabla que estan creando esos programadorcitos', 4, '3.00', 13),
(14, 'Comestibl', 4, '1.11', 13),
(15, 'Caramelos', 1, '0.10', 14),
(16, 'Producto 2', 2, '4.00', 14),
(17, 'Producto 3', 4, '1.60', 14),
(18, 'Comida', 2, '3.00', 15),
(19, 'Productos', 3, '4.10', 15),
(20, 'Rico', 5, '3.00', 15),
(21, 'Sandia', 5, '4.00', 15),
(22, 'Podaculo', 1, '2.00', 16),
(23, 'Comidas', 3, '3.00', 16),
(24, 'dd', 1, '3.00', 17),
(25, '2', 3, '1.00', 18),
(26, 'dasa', 4, '3.00', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestra`
--

CREATE TABLE `maestra` (
  `idmaestra` int(11) NOT NULL,
  `igv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficina`
--

CREATE TABLE `oficina` (
  `idoficina` int(11) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `nfactura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `oficina`
--

INSERT INTO `oficina` (`idoficina`, `direccion`, `telefono`, `nfactura`) VALUES
(1, 'Cajamarca', '1234556', 1022);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenservicio`
--

CREATE TABLE `ordenservicio` (
  `idordenservicio` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL,
  `fechapedido` date DEFAULT NULL,
  `idoficina` int(11) NOT NULL,
  `idresponsable` int(11) NOT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(10) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `idrecurso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`, `descripcion`, `idrecurso`) VALUES
(1, 'index', NULL, 1),
(2, 'add', 'agregar', 1),
(4, 'index', NULL, 2),
(5, 'items', NULL, 1),
(6, 'index', NULL, 3),
(7, 'index', 'Lista de proveedores', 1),
(8, 'index', NULL, 5),
(9, 'edit', 'Editar roles', 5),
(10, 'index', 'Lista de proveedores', 4),
(11, 'suministros', 'Suministros ', 4),
(12, 'add', 'Agregar nuevo', 4),
(13, 'edit', 'Editar proveedor', 4),
(14, 'edit', 'Editar ventas', 1),
(15, 'imprimirfactura', 'Imprimir facturas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idsuministro` int(11) NOT NULL,
  `tipo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idsuministro`, `tipo`) VALUES
(1, '1'),
(7, '3'),
(8, '4'),
(9, '0'),
(10, '0'),
(11, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `ruc` char(11) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon` varchar(45) DEFAULT NULL,
  `contacto` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `ruc`, `direccion`, `telefono`, `razon`, `contacto`) VALUES
(1, '1', 'Cajamrca perú', '123456', 'PROVEDORE PRESNTE', 'Contato7'),
(2, '10704080055', 'sm per', '1234568', 'BRAVOS PE', 'hbs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `idproyecto` int(11) NOT NULL,
  `oficina_idoficina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `idrecurso` int(10) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`idrecurso`, `nombre`) VALUES
(1, 'Logistica\\Controller\\Venta'),
(2, 'Logistica\\Controller\\Compra'),
(3, 'Administrador\\Controller\\Index'),
(4, 'Logistica\\Controller\\Proveedor'),
(5, 'Administrador\\Controller\\Rol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(10) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'ADMINISTRADOR', 'Admistrador', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `id` int(10) NOT NULL,
  `idrol` int(10) NOT NULL,
  `idpermiso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`id`, `idrol`, `idpermiso`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 8),
(7, 1, 7),
(8, 1, 9),
(9, 1, 10),
(10, 1, 11),
(11, 1, 12),
(12, 1, 13),
(13, 1, 14),
(14, 1, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idsuministro` int(11) NOT NULL,
  `caracteristicas` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`idsuministro`, `caracteristicas`) VALUES
(2, 'Todo gratis :v'),
(3, 'Todo deli :v'),
(15, '3'),
(16, 'dadmaksmalk ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suministro`
--

CREATE TABLE `suministro` (
  `idsuministro` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `suministro`
--

INSERT INTO `suministro` (`idsuministro`, `nombre`) VALUES
(1, 'Cajita'),
(2, 'servicio de comida'),
(3, 'Sercicio de ayuda'),
(4, 'Productivo'),
(5, 'Pro'),
(6, 'Nuevito'),
(7, 'nuevo'),
(8, 'JEJEE'),
(9, NULL),
(10, NULL),
(11, 'COmida'),
(12, 'COMIDA X2'),
(13, 'DEDE'),
(14, 'nueva comidita'),
(15, 'Cimidata'),
(16, 'Comidota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suministroproveedor`
--

CREATE TABLE `suministroproveedor` (
  `idproveedor` int(11) NOT NULL,
  `idsuministro` int(11) NOT NULL,
  `precio` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `suministroproveedor`
--

INSERT INTO `suministroproveedor` (`idproveedor`, `idsuministro`, `precio`) VALUES
(1, 1, '8.00'),
(2, 1, '3.00'),
(1, 2, '45.00'),
(1, 7, '2.00'),
(1, 8, '1.40'),
(1, 9, '4.00'),
(1, 10, '1.00'),
(1, 11, '3.00'),
(1, 15, '1.00'),
(1, 16, '3.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabaja`
--

CREATE TABLE `trabaja` (
  `idpertenece` varchar(45) NOT NULL,
  `idoficina` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL,
  `fechatrabajo` varchar(45) DEFAULT NULL,
  `asistio` char(1) DEFAULT NULL,
  `cargo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado`
--

CREATE TABLE `traslado` (
  `idtraslado` int(11) NOT NULL,
  `idalmacendestino` int(11) NOT NULL,
  `fechasalida` datetime NOT NULL,
  `fechallegada` datetime DEFAULT NULL,
  `idresponsable` int(11) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idresponsable` int(11) DEFAULT NULL,
  `tipopago` char(1) DEFAULT NULL,
  `monto` decimal(6,2) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `detraccion` decimal(7,2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `numcom` int(11) DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL,
  `fechaventa` date DEFAULT NULL,
  `fechapago` date DEFAULT NULL,
  `debe` decimal(6,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `idoficina` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `ocos` varchar(20) DEFAULT NULL,
  `guia` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idresponsable`, `tipopago`, `monto`, `descripcion`, `detraccion`, `tipo`, `numcom`, `fecharegistro`, `fechaventa`, `fechapago`, `debe`, `estado`, `idoficina`, `idcliente`, `ocos`, `guia`) VALUES
(4, 1, '1', '160.00', 'd', '1.00', '1', 12333, '2016-11-23 02:36:19', '2016-11-22', '2016-11-22', '12.00', NULL, 1, 0, NULL, NULL),
(7, 1, '1', '300.00', 'Primera venta', '20.00', '1', 23333, '2016-11-23 19:14:15', '2016-11-23', '2016-11-23', '200.00', NULL, 1, 0, NULL, NULL),
(10, 1, '3', '34.00', NULL, NULL, '2', NULL, '2016-11-23 21:28:37', '2016-11-23', '2016-11-23', NULL, NULL, 1, 1, '123456', '111111'),
(11, 1, '1', '3.00', NULL, '4.00', '1', NULL, '2016-11-23 16:22:34', '2016-11-23', '2016-11-23', NULL, NULL, 1, 1, NULL, NULL),
(12, 1, '2', '2.00', NULL, '33.00', '2', NULL, '2016-11-23 16:23:31', '2016-11-23', '2016-11-23', NULL, NULL, 1, 1, '121212', '12121'),
(13, 2, '1', '7.11', NULL, '10.00', '1', NULL, '2016-11-24 10:15:53', '2016-11-24', '2016-11-24', NULL, NULL, 1, 1, '12345', '122224'),
(14, 1, '1', '14.50', NULL, '3.00', '2', NULL, '2016-11-24 10:23:42', '2016-11-24', '2016-11-24', NULL, NULL, 1, 1, '121212', '3455'),
(15, 1, '1', '53.30', NULL, '10.00', '1', 56, '2016-11-24 14:17:58', '2016-11-24', '2016-11-24', NULL, NULL, 1, 2, '124345', '1222'),
(16, 1, '3', '11.00', NULL, '12.00', '2', 1021, '2016-11-28 09:27:09', '2016-11-28', '2016-11-28', '0.00', '2', 1, 1, '1223', '32121'),
(17, 1, '3', '3.00', NULL, '1.00', '1', 10021, '2016-11-28 10:15:40', '2016-11-28', '2016-11-28', '0.00', '2', 1, 1, '12121', '2222'),
(18, 1, '2', '3.00', NULL, '1.00', '1', 4667, '2016-11-28 10:18:38', '2016-11-28', '2016-11-28', NULL, '3', 1, 1, '11111', '2345'),
(19, 1, '3', '12.00', NULL, '2.00', '2', 10002, '2016-11-28 10:26:02', '2016-11-28', '2016-11-28', '12.00', '2', 1, 1, '12121', '2121212');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`idalerta`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`idoficina`),
  ADD KEY `fk_caja_oficina_idx` (`idoficina`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `fk_compra_empleado1_idx` (`idempleado`),
  ADD KEY `fk_compra_caja1_idx` (`idoficina`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`idcontrato`),
  ADD KEY `fk_empleado-contrato_empleado1_idx` (`idempleado`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`idcotizacion`),
  ADD KEY `fk_cotizacion_cliente1_idx` (`idcliente`);

--
-- Indices de la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD PRIMARY KEY (`idegreso`),
  ADD KEY `fk_egreso_caja1_idx` (`idoficina`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idempleado`);

--
-- Indices de la tabla `empleado_rol`
--
ALTER TABLE `empleado_rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empleado_rol_rol1_idx` (`idrol`),
  ADD KEY `fk_empleado_rol_empleado1_idx` (`idempleado`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idinventario`),
  ADD KEY `fk_inventario_almacen1_idx` (`idalmacen`),
  ADD KEY `fk_inventario_producto1_idx` (`idsuministro`);

--
-- Indices de la tabla `invitacion`
--
ALTER TABLE `invitacion`
  ADD PRIMARY KEY (`idinvitacion`),
  ADD KEY `fk_invitacion_cliente1_idx` (`idcliente`),
  ADD KEY `fk_invitacion_oficina1_idx` (`idoficina`);

--
-- Indices de la tabla `lineacompra`
--
ALTER TABLE `lineacompra`
  ADD PRIMARY KEY (`idlinea`),
  ADD KEY `fk_lineacompra_compra1_idx` (`idcompra`);

--
-- Indices de la tabla `lineacotizacion`
--
ALTER TABLE `lineacotizacion`
  ADD PRIMARY KEY (`idcotizacion`,`idsuministro`),
  ADD KEY `fk_lineacotizacion_suministro1_idx` (`idsuministro`);

--
-- Indices de la tabla `lineapedido`
--
ALTER TABLE `lineapedido`
  ADD PRIMARY KEY (`idpedido`,`idproveedor`,`idsuministro`),
  ADD KEY `fk_lineapedido_suministro-proveedor1_idx` (`idsuministro`,`idproveedor`);

--
-- Indices de la tabla `lineatraslado`
--
ALTER TABLE `lineatraslado`
  ADD KEY `fk_lineatraslado_traslado1_idx` (`idtraslado`),
  ADD KEY `fk_lineatraslado_inventario1_idx` (`idinventario`);

--
-- Indices de la tabla `lineaventa`
--
ALTER TABLE `lineaventa`
  ADD PRIMARY KEY (`idlineaventa`),
  ADD KEY `fk_lineaventa_venta1_idx` (`idventa`);

--
-- Indices de la tabla `maestra`
--
ALTER TABLE `maestra`
  ADD PRIMARY KEY (`idmaestra`);

--
-- Indices de la tabla `oficina`
--
ALTER TABLE `oficina`
  ADD PRIMARY KEY (`idoficina`);

--
-- Indices de la tabla `ordenservicio`
--
ALTER TABLE `ordenservicio`
  ADD PRIMARY KEY (`idordenservicio`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idpedido`),
  ADD KEY `fk_pedido_caja1_idx` (`idoficina`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `fk_permiso_recurso1_idx` (`idrecurso`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idsuministro`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`idproyecto`),
  ADD KEY `fk_proyecto_oficina1_idx` (`oficina_idoficina`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`idrecurso`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rol_permiso_rol1_idx` (`idrol`),
  ADD KEY `fk_rol_permiso_permiso1_idx` (`idpermiso`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idsuministro`);

--
-- Indices de la tabla `suministro`
--
ALTER TABLE `suministro`
  ADD PRIMARY KEY (`idsuministro`);

--
-- Indices de la tabla `suministroproveedor`
--
ALTER TABLE `suministroproveedor`
  ADD PRIMARY KEY (`idsuministro`,`idproveedor`),
  ADD KEY `fk_producto-proveedor_proveedor1_idx` (`idproveedor`);

--
-- Indices de la tabla `trabaja`
--
ALTER TABLE `trabaja`
  ADD PRIMARY KEY (`idpertenece`),
  ADD KEY `fk_pertenece_oficina1_idx` (`idoficina`),
  ADD KEY `fk_pertenece_empleado1_idx` (`idempleado`);

--
-- Indices de la tabla `traslado`
--
ALTER TABLE `traslado`
  ADD PRIMARY KEY (`idtraslado`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_caja1_idx` (`idoficina`),
  ADD KEY `fk_venta_cliente1_idx` (`idcliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alerta`
--
ALTER TABLE `alerta`
  MODIFY `idalerta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `idcontrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `idcotizacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `egreso`
--
ALTER TABLE `egreso`
  MODIFY `idegreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idempleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `empleado_rol`
--
ALTER TABLE `empleado_rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idinventario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lineacompra`
--
ALTER TABLE `lineacompra`
  MODIFY `idlinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `lineaventa`
--
ALTER TABLE `lineaventa`
  MODIFY `idlineaventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `maestra`
--
ALTER TABLE `maestra`
  MODIFY `idmaestra` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `oficina`
--
ALTER TABLE `oficina`
  MODIFY `idoficina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ordenservicio`
--
ALTER TABLE `ordenservicio`
  MODIFY `idordenservicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `idproyecto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `idrecurso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `suministro`
--
ALTER TABLE `suministro`
  MODIFY `idsuministro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `traslado`
--
ALTER TABLE `traslado`
  MODIFY `idtraslado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `fk_caja_oficina` FOREIGN KEY (`idoficina`) REFERENCES `oficina` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_caja1` FOREIGN KEY (`idoficina`) REFERENCES `caja` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_empleado1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_empleado-contrato_empleado1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `fk_cotizacion_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD CONSTRAINT `fk_egreso_caja1` FOREIGN KEY (`idoficina`) REFERENCES `caja` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado_rol`
--
ALTER TABLE `empleado_rol`
  ADD CONSTRAINT `fk_empleado_rol_empleado1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleado_rol_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_almacen1` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`idalmacen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventario_producto1` FOREIGN KEY (`idsuministro`) REFERENCES `producto` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `invitacion`
--
ALTER TABLE `invitacion`
  ADD CONSTRAINT `fk_invitacion_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invitacion_oficina1` FOREIGN KEY (`idoficina`) REFERENCES `oficina` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lineacompra`
--
ALTER TABLE `lineacompra`
  ADD CONSTRAINT `fk_lineacompra_compra1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lineacotizacion`
--
ALTER TABLE `lineacotizacion`
  ADD CONSTRAINT `fk_lineacotizacion_cotizacion1` FOREIGN KEY (`idcotizacion`) REFERENCES `cotizacion` (`idcotizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lineacotizacion_suministro1` FOREIGN KEY (`idsuministro`) REFERENCES `suministro` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lineapedido`
--
ALTER TABLE `lineapedido`
  ADD CONSTRAINT `fk_lineapedido_pedido1` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lineapedido_suministro-proveedor1` FOREIGN KEY (`idsuministro`,`idproveedor`) REFERENCES `suministroproveedor` (`idsuministro`, `idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lineatraslado`
--
ALTER TABLE `lineatraslado`
  ADD CONSTRAINT `fk_lineatraslado_inventario1` FOREIGN KEY (`idinventario`) REFERENCES `inventario` (`idinventario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lineatraslado_traslado1` FOREIGN KEY (`idtraslado`) REFERENCES `traslado` (`idtraslado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lineaventa`
--
ALTER TABLE `lineaventa`
  ADD CONSTRAINT `fk_lineaventa_venta1` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_caja1` FOREIGN KEY (`idoficina`) REFERENCES `caja` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `fk_permiso_recurso1` FOREIGN KEY (`idrecurso`) REFERENCES `recurso` (`idrecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_suministro1` FOREIGN KEY (`idsuministro`) REFERENCES `suministro` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `fk_proyecto_oficina1` FOREIGN KEY (`oficina_idoficina`) REFERENCES `oficina` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `fk_rol_permiso_permiso1` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_permiso_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `fk_servicio_suministro1` FOREIGN KEY (`idsuministro`) REFERENCES `suministro` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `suministroproveedor`
--
ALTER TABLE `suministroproveedor`
  ADD CONSTRAINT `fk_producto-proveedor_proveedor1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_suministro-proveedor_suministro1` FOREIGN KEY (`idsuministro`) REFERENCES `suministro` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `trabaja`
--
ALTER TABLE `trabaja`
  ADD CONSTRAINT `fk_pertenece_empleado1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pertenece_oficina1` FOREIGN KEY (`idoficina`) REFERENCES `oficina` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_caja1` FOREIGN KEY (`idoficina`) REFERENCES `caja` (`idoficina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
