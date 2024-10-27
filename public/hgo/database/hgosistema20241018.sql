-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 27-10-2024 a las 12:34:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hgosistema`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarJoin` (IN `tablaNombre` VARCHAR(50))   BEGIN
     SELECT concat(TF.tablaforanea,' ', TF.alias) as seleccion, concat(TF.alias,'.', TF.nombre, ' = ', TP.alias,'.', TP.nombre ) as nombre FROM
 	(SELECT tablaprincipal, alias, nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND primarykey IN ('MUL')) AS TP INNER JOIN
 	(SELECT alias, tablaforanea, nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND primarykey IN ('PRI')) AS TF
 	ON TP.nombre = TF.nombre;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarOrLike` (IN `tablaNombre` VARCHAR(50))   BEGIN
 	SELECT seleccion FROM (
 		(SELECT CONCAT(alias, '.', nombre) AS seleccion FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND tablaforanea = tablaNombre AND primarykey IN ('PRI')) UNION
 		(SELECT CONCAT(alias, '.', nombre) AS seleccion FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND nombre like '%precio%') UNION
 		(SELECT CONCAT(alias, '.', nombre) AS seleccion FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND nombre like '%nombre%')        
 	) AS T WHERE seleccion IS NOT NULL;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarSelect` (IN `tablaNombre` VARCHAR(50))   BEGIN
 	SELECT seleccion, SUBSTRING(nombre, 2) as nombre, tipodato, primarykey  FROM (
     
 		SELECT concat(alias, '.', nombre) AS seleccion, nombre, tipodato, primarykey 
        FROM tconfigdatabase 
		WHERE tablaprincipal = tablaNombre AND tablaforanea = tablaNombre AND primarykey NOT IN ('MUL') 
         
		UNION
         
 		SELECT concat(alias, '.', nombre) AS seleccion, nombre, tipodato, primarykey 
        FROM tconfigdatabase 
		WHERE tablaprincipal = tablaNombre AND tablaforanea != tablaNombre AND (primarykey IN ('PRI') OR nombre like '%nombre%') 
         
		UNION
         
        SELECT concat('CONCAT(', GROUP_CONCAT(seleccion separator ','' - '','), ')') AS seleccion, ' concatenado', 'varchar', '' 
        FROM 
 		(
 			(SELECT CONCAT('''['',',alias, '.', nombre,','']''') AS seleccion, nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND nombre like '%precio%') 
            UNION
 			(SELECT concat(alias, '.', nombre) AS seleccion, nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND (nombre LIKE '%nombre%' OR nombre LIKE '%rasonsocial%'))
 		) as p 
        
        UNION
         
 		SELECT concat('CONCAT(', GROUP_CONCAT(concat(alias, '.', nombre) separator ','' - '','), ')') AS seleccion, ' concatenadodetalle', 'varchar', '' 
        FROM tconfigdatabase 
		WHERE (tablaprincipal = tablaNombre AND (concat = 1 and orden != 0)) OR (tablaprincipal = tablaNombre AND ((nombre LIKE '%nombre%' OR nombre LIKE '%rasonsocial%')))
         
 	) AS T WHERE seleccion IS NOT NULL;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarSelectSimple` (IN `tablaNombre` VARCHAR(50))   BEGIN
 	SELECT concat(alias, '.', nombre) AS seleccion, SUBSTRING(nombre, 2) as nombre, tipodato, primarykey FROM tconfigdatabase 
     WHERE tablaprincipal = tablaNombre AND tablaforanea = tablaNombre;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarTablaPK` (IN `tablaNombre` VARCHAR(50))   BEGIN
     SELECT nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND tablaforanea = tablaNombre AND primarykey IN ('PRI');
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarWhere` (IN `tablaNombre` VARCHAR(50))   BEGIN
     SELECT nombre FROM tconfigdatabase WHERE tablaprincipal = tablaNombre AND tablaforanea = tablaNombre AND primarykey IN ('PRI', 'MUL');
 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tauditoria`
--

CREATE TABLE `tauditoria` (
  `nidauditoria` int(11) NOT NULL,
  `nidservicio` int(11) DEFAULT NULL,
  `scampo_modificado` varchar(50) DEFAULT NULL,
  `svalor_anterior` text DEFAULT NULL,
  `svalor_nuevo` text DEFAULT NULL,
  `tfecha_modificacion` datetime DEFAULT current_timestamp(),
  `susuario_modificacion` varchar(50) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tauditoria`
--

INSERT INTO `tauditoria` (`nidauditoria`, `nidservicio`, `scampo_modificado`, `svalor_anterior`, `svalor_nuevo`, `tfecha_modificacion`, `susuario_modificacion`, `bestado`) VALUES
(2, 30, 'sobservacioningreso', 'SE RECOGIO DE LA VIA EXPRESA QWE LUCAS', 'SE RECOGIO DE LA VIA EXPRESA QWE LUCAS LUCAS', '2024-10-14 23:26:59', 'Renato', b'1'),
(3, 30, 'sobservacionsalida', 'EL CLIENTE LO RECOGIO DE LA TIENDA QWE', 'EL CLIENTE LO RECOGIO DE LA TIENDA QWE 234', '2024-10-14 23:45:37', 'Renato', b'1'),
(4, 31, 'sobservacioningreso', 'PRUEBAS INGRESO', 'PRUEBAS INGRESO CON OBCERVACIONES', '2024-10-15 00:52:10', 'Renato', b'1'),
(5, 31, 'nidcondicion', '4', '3', '2024-10-15 00:52:30', 'Renato', b'1'),
(6, 30, 'NO LO SE', 'TAMPOCO', 'NI MENOS', '0000-00-00 00:00:00', 'RENATO', b'1'),
(7, 32, NULL, NULL, NULL, '2024-10-16 16:47:39', NULL, NULL),
(8, 32, NULL, NULL, NULL, '2024-10-16 16:47:39', NULL, NULL),
(9, 32, NULL, NULL, NULL, '2024-10-16 16:49:05', NULL, NULL),
(10, 32, NULL, NULL, NULL, '2024-10-16 16:56:19', NULL, NULL),
(11, 32, 'sobservacionsalida', 'PRUEBAS 123', 'PRUEBAS 123 QUE FUE', '2024-10-16 22:03:56', 'BACILIDES', b'1'),
(12, 32, 'sobservacionsalida', 'PRUEBAS 123 QUE FUE', 'PRUEBAS 123 QUE FUE NUEVOS VALORES', '2024-10-16 22:16:42', 'BACILIDES', b'1'),
(13, 33, 'sobservacioningreso', 'ASD', 'ASD QUE FUE', '2024-10-17 21:45:55', '123', b'1'),
(14, 33, 'sobservacioningreso', 'ASD', 'ASD QUE FUE - ', '2024-10-17 21:49:10', '123', b'1'),
(15, 33, 'nidneumatico', '5', '2 - ', '2024-10-17 21:53:23', '123', b'1'),
(16, 33, 'nidneumatico', '5', '2 - ', '2024-10-17 21:55:38', '123', b'1'),
(17, 33, '0', NULL, '{\"sidclientetext\":\"BASILIDES\",\"nidbandatext\":\"TDE2-12\",\"nidtiposerviciotext\":\"NIEVITO\",\"nidneumaticotext\":\"CONTINENTAL\",\"nidubicaciontext\":\"REENCAUCHADORA\",\"nidreencauchadoratext\":\"CARLITOS\",\"nidcondiciontext\":\"RECHAZADO\"} - ', '2024-10-17 21:55:38', '123', b'1'),
(18, 33, 'nidneumatico', '5', '', '2024-10-17 21:56:49', '123', b'1'),
(19, 33, '0', NULL, '', '2024-10-17 21:56:49', '123', b'1'),
(20, 33, 'nidneumatico', '5', '1 - ', '2024-10-17 22:00:21', '123', b'1'),
(21, 33, 'nidneumatico', '5', '', '2024-10-17 22:01:32', '123', b'1'),
(22, 33, '0', NULL, '', '2024-10-17 22:01:32', '123', b'1'),
(23, 33, 'nidneumatico', '1', '', '2024-10-17 22:04:06', '123', b'1'),
(24, 33, '0', NULL, '', '2024-10-17 22:04:06', '123', b'1'),
(25, 33, 'sobservacioningreso', 'ASD', '', '2024-10-17 22:08:01', '123', b'1'),
(26, 33, 'nidubicacion', '4', '', '2024-10-17 22:08:01', '123', b'1'),
(27, 33, '0', NULL, '', '2024-10-17 22:08:01', '123', b'1'),
(28, 33, 'sobservacioningreso', 'ASD', '', '2024-10-17 22:08:41', '123', b'1'),
(29, 33, '0', NULL, '', '2024-10-17 22:08:41', '123', b'1'),
(30, 33, 'sobservacioningreso', 'ASD', '', '2024-10-17 22:09:46', '123', b'1'),
(31, 33, '0', NULL, '', '2024-10-17 22:09:46', '123', b'1'),
(32, 33, 'sobservacionsalida', 'ASD', '', '2024-10-17 22:10:52', '123', b'1'),
(33, 33, 'nidubicacion', '4', 'TIENDA', '2024-10-17 22:15:18', '123', b'1'),
(34, 33, 'nidubicacion', '1', 'MECANICO', '2024-10-17 22:19:23', '123', b'1'),
(35, 33, 'nidubicacion', '3', '4', '2024-10-17 22:21:43', '123', b'1'),
(36, 33, 'nidubicacion', '4', '3-MECANICO', '2024-10-17 22:23:46', '123', b'1'),
(37, 33, 'nidubicacion', '3', '1-TIENDA', '2024-10-17 22:25:55', '123', b'1'),
(38, 34, 'splaca', 'QWE', 'X3L-652-ninguna', '2024-10-17 17:31:30', 'RENATO', b'1'),
(39, 34, 'sobservacioningreso', '', 'CORRECCION DATOS-ninguna', '2024-10-17 17:31:30', 'RENATO', b'1'),
(40, 34, 'snumero', '123', '11R22.5-ninguna', '2024-10-17 17:31:30', 'RENATO', b'1'),
(41, 34, 'scodigo', '123', '2309AS7173-ninguna', '2024-10-17 17:31:30', 'RENATO', b'1'),
(42, 34, 'nidubicacion', '3', '2-TALLER', '2024-10-17 17:32:34', 'RENATO', b'1'),
(43, 34, 'sobservacionsalida', '', 'LISTO PARA ENTREGA-ninguna', '2024-10-17 17:32:34', 'RENATO', b'1'),
(44, 34, 'nidubicacion', '2', '1-TIENDA', '2024-10-17 17:41:52', 'RENATO', b'1'),
(45, 34, 'sobservacionsalida', 'LISTO PARA ENTREGA', 'CLIENTE RECOGIO EL PEDIDO-ninguna', '2024-10-17 17:41:52', 'RENATO', b'1'),
(46, 34, 'nidubicacion', '1', '2-TALLER', '2024-10-17 18:00:30', 'BACILIDES', b'1'),
(47, 34, 'susuario', 'RENATO', 'BACILIDES-ninguna', '2024-10-17 18:00:30', 'BACILIDES', b'1'),
(48, 34, 'nidubicacion', '2', '3-MECANICO', '2024-10-17 18:06:53', 'RENATO', b'1'),
(49, 34, 'susuario', 'BACILIDES', 'RENATO-ninguna', '2024-10-17 18:06:53', 'RENATO', b'1'),
(50, 34, 'sobservacioningreso', 'CORRECCION DATOS', 'SE RECEPCIONO COPN OBSERVACIONES 3 HUECOS', '2024-10-17 18:12:42', 'RENATO', b'1'),
(51, 34, 'nidtiposervicio', '4', '2-PASADADEBANDA', '2024-10-17 18:13:31', 'RENATO', b'1'),
(52, 38, 'sobservacioningreso', '', 'SE TRASLADO AL TALLER DE RICHAR', '2024-10-18 18:11:51', '', b'1'),
(53, 38, 'sobservacionsalida', '', 'EL CLIENTE RECOGIO SU LLANTA', '2024-10-18 18:15:58', 'RENATO', b'1'),
(54, 38, 'susuario', '', 'RENATO', '2024-10-18 18:15:58', 'RENATO', b'1'),
(55, 38, 'sobservacioningreso', 'SE TRASLADO AL TALLER DE RICHAR', 'SE TRASLADO AL TALLER DE RICHAR, TUVO UN PEQUEÑO DEFECTO', '2024-10-18 18:16:51', 'RENATO', b'1'),
(56, 39, 'sobservacioningreso', '', 'SE CAMBIO DE REENCAUCHADORA', '2024-10-18 18:25:12', 'RENATO', b'1'),
(57, 39, 'nidreencauchadora', '4', '2-HGO', '2024-10-18 18:25:12', 'RENATO', b'1'),
(58, 41, 'splaca', 'ASDASD', 'X3LL-618', '2024-10-26 07:05:38', 'RENATO', b'1'),
(59, 41, 'sobservacioningreso', '', 'CORRECCION DE PLACA', '2024-10-26 07:05:38', 'RENATO', b'1'),
(60, 41, 'splaca', 'X3LL-618', 'X3L-618', '2024-10-26 21:59:19', 'RENATO', b'1'),
(61, 40, 'bformaestado', NULL, '1', '2024-10-26 22:55:41', 'RENATO', b'1'),
(62, 39, 'bformaestado', NULL, '0', '2024-10-26 22:56:21', 'RENATO', b'1'),
(63, 41, 'bformaestado', '1', '0', '2024-10-27 06:28:28', 'RENATO', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbanda`
--

CREATE TABLE `tbanda` (
  `nidbanda` int(11) NOT NULL,
  `snombrebanda` varchar(45) DEFAULT NULL,
  `smarca` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tbanda`
--

INSERT INTO `tbanda` (`nidbanda`, `snombrebanda`, `smarca`, `bestado`) VALUES
(1, 'GOODYEAR GOODYEAR', 'GOODYEAR', b'0'),
(2, 'MCR', 'MCR', b'1'),
(3, 'TDE2-12', 'TDE2-12', b'1'),
(4, 'MDE', 'MDE', b'1'),
(5, 'PRUEBAS', 'PRUEBAS', b'0'),
(6, 'PRUEBAS 02', 'PRUEBAS 02', b'0'),
(7, 'TDE2-12', 'TDE2-12', b'1'),
(8, 'PRUEBAB', 'NO IMPORTA', b'0'),
(9, 'PRUEBAS', '', b'1'),
(10, 'PRUEBAS HOY', '', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tcliente`
--

CREATE TABLE `tcliente` (
  `sidcliente` varchar(15) NOT NULL,
  `snombrecliente` varchar(45) DEFAULT NULL,
  `sdireccion` varchar(45) DEFAULT NULL,
  `stelefono` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tcliente`
--

INSERT INTO `tcliente` (`sidcliente`, `snombrecliente`, `sdireccion`, `stelefono`, `bestado`) VALUES
('0710', 'TATO10', '', '', b'1'),
('0711', 'TATO11', '', '', b'1'),
('0712', 'TATO12', '', '', b'1'),
('0713', 'GUIDO', '', '', b'1'),
('0777', 'TATOOO', '', '', b'1'),
('0778', 'TATO08', 'CUSCO', '987878787', b'1'),
('0779', 'TATO09', '', '', b'1'),
('0810', 'LUCAS10', '', '', b'1'),
('0888', 'LUCAS', '', '', b'1'),
('0889', 'LUCAS09', '', '', b'1'),
('10239480689', 'GIL BEDOYA CARLOS ALBERTO', 'CUSCO', '94848487', b'1'),
('12121212', 'RAFAELA', '', '', b'1'),
('1212121213', 'RAFAELA', 'MADRID', '98989898', b'1'),
('123644555', 'GUIDO', '', '', b'1'),
('154813155111', 'MARCO AURELIO', 'CUSCO', '950545454', b'1'),
('20350447521', 'TRANSVIAL E.I.R.L.', 'CUSCO', '9884525110', b'1'),
('20450551326', 'MULTISERVICIOS SANTA INES EMPRESA INDIVIDUAL ', 'SAN SEBASTIAN', '98787485212', b'1'),
('20600598334', 'RAPIFAC SA', 'CALLE HIPOLITO HUNANUE', '98754546521', b'1'),
('20601369886', 'CORPORACION GRIFERA J&F S.R.L.', 'AV. CUSCO SAYLLA', '9875454478', b'1'),
('23655498', 'JUAN FELIX', '', '', b'1'),
('25312602', 'PABLO BENGOCHEA', '', '', b'1'),
('32565456', 'GABIELA', '', '', b'1'),
('42253441', 'RENATO', 'CUSCO', '9888471542', b'1'),
('43253442', 'BASILIDES', 'CUSCO', '987457548', b'1'),
('43253456', 'LOPEZ', 'CUSCO', '987548754', b'1'),
('43253478', 'FREDY CHOQUE', '', '', b'1'),
('44887878', 'MELIZA', 'WANCHAQ', '945857485', b'1'),
('456', 'PRUEBAS', 'ASD', '123', b'1'),
('45875496', 'RENE', '', '', b'1'),
('54988798', 'SAIUL', '', '', b'1'),
('65487899', 'BRANDON', '', '', b'1'),
('8844778874', 'JOSE CARLOS', '', '', b'0'),
('89879898', 'ADA', 'CUSCO', '987546587', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tcondicion`
--

CREATE TABLE `tcondicion` (
  `nidcondicion` tinyint(1) NOT NULL,
  `snombrecondicion` varchar(25) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tcondicion`
--

INSERT INTO `tcondicion` (`nidcondicion`, `snombrecondicion`, `bestado`) VALUES
(1, 'TERMINADO', b'1'),
(2, 'ENTREGADO', b'1'),
(3, 'RECHAZADO', b'1'),
(4, 'RECEPCIONADO', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tconfigdatabase`
--

CREATE TABLE `tconfigdatabase` (
  `id` int(11) NOT NULL,
  `tablaprincipal` varchar(100) NOT NULL,
  `tablaforanea` varchar(100) NOT NULL,
  `tablaforaneafk` varchar(100) DEFAULT NULL,
  `indice_campos` tinyint(2) DEFAULT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tipodato` varchar(50) DEFAULT NULL,
  `primarykey` varchar(3) DEFAULT NULL,
  `incremental` tinyint(2) DEFAULT NULL,
  `concat` bit(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  `indice_tablas` tinyint(2) DEFAULT NULL,
  `alias_tablas` varchar(100) DEFAULT NULL,
  `alias_campos` varchar(100) DEFAULT NULL,
  `variable_constructor` varchar(100) DEFAULT NULL,
  `variable_model` varchar(100) DEFAULT NULL,
  `variable_nombre` varchar(100) DEFAULT NULL,
  `variable_nombre_capital` varchar(100) DEFAULT NULL,
  `tconfigdatabase` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tconfigdatabase`
--

INSERT INTO `tconfigdatabase` (`id`, `tablaprincipal`, `tablaforanea`, `tablaforaneafk`, `indice_campos`, `alias`, `nombre`, `tipodato`, `primarykey`, `incremental`, `concat`, `orden`, `indice_tablas`, `alias_tablas`, `alias_campos`, `variable_constructor`, `variable_model`, `variable_nombre`, `variable_nombre_capital`, `tconfigdatabase`, `indice`) VALUES
(0, 'tauditoria', 'tauditoria', 'tauditoria', 1, 't0', 'nidauditoria', 'int', 'PRI', 0, b'0', 0, 0, 'tauditoria t0', 't0.nidauditoria', 'auditoria', 'AuditoriaModel', 'idauditoria', 'Idauditoria', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tservicio', 2, 't0', 'nidservicio', 'int', 'MUL', 0, b'0', 0, 0, 'tauditoria t0', 't0.nidservicio', 'servicio', 'AuditoriaModel', 'idservicio', 'Idservicio', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 3, 't0', 'scampo_modificado', 'varchar', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.scampo_modificado', 'auditoria', 'AuditoriaModel', 'campo_modificado', 'Campo_Modificado', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 4, 't0', 'svalor_anterior', 'text', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.svalor_anterior', 'auditoria', 'AuditoriaModel', 'valor_anterior', 'Valor_Anterior', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 5, 't0', 'svalor_nuevo', 'text', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.svalor_nuevo', 'auditoria', 'AuditoriaModel', 'valor_nuevo', 'Valor_Nuevo', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 6, 't0', 'tfecha_modificacion', 'datetime', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.tfecha_modificacion', 'auditoria', 'AuditoriaModel', 'fecha_modificacion', 'Fecha_Modificacion', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 7, 't0', 'susuario_modificacion', 'varchar', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.susuario_modificacion', 'auditoria', 'AuditoriaModel', 'usuario_modificacion', 'Usuario_Modificacion', NULL, NULL),
(0, 'tauditoria', 'tauditoria', 'tauditoria', 8, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tauditoria t0', 't0.bestado', 'auditoria', 'AuditoriaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 1, 't1', 'nidservicio', 'int', 'PRI', 0, b'0', 0, 1, 'tservicio t1', 't1.nidservicio', 'servicio', 'ServicioModel', 'idservicio', 'Idservicio', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tcliente', 2, 't1', 'sidcliente', 'varchar', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.sidcliente', 'cliente', 'ServicioModel', 'idcliente', 'Idcliente', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 3, 't1', 'tfecharecepcion', 'date', '', 0, b'0', 0, 1, 'tservicio t1', 't1.tfecharecepcion', 'servicio', 'ServicioModel', 'fecharecepcion', 'Fecharecepcion', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tbanda', 4, 't1', 'nidbanda', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidbanda', 'banda', 'ServicioModel', 'idbanda', 'Idbanda', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 5, 't1', 'splaca', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.splaca', 'servicio', 'ServicioModel', 'placa', 'Placa', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 6, 't1', 'sobservacioningreso', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.sobservacioningreso', 'servicio', 'ServicioModel', 'observacioningreso', 'Observacioningreso', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'ttiposervicio', 7, 't1', 'nidtiposervicio', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidtiposervicio', 'tiposervicio', 'ServicioModel', 'idtiposervicio', 'Idtiposervicio', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tmedida', 8, 't1', 'nidmedida', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidmedida', 'medida', 'ServicioModel', 'idmedida', 'Idmedida', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tmarca', 9, 't1', 'nidmarca', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidmarca', 'marca', 'ServicioModel', 'idmarca', 'Idmarca', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 10, 't1', 'scodigo', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.scodigo', 'servicio', 'ServicioModel', 'codigo', 'Codigo', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tubicacion', 11, 't1', 'nidubicacion', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidubicacion', 'ubicacion', 'ServicioModel', 'idubicacion', 'Idubicacion', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'treencauchadora', 12, 't1', 'nidreencauchadora', 'int', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidreencauchadora', 'reencauchadora', 'ServicioModel', 'idreencauchadora', 'Idreencauchadora', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 13, 't1', 'tfechatienda', 'date', '', 0, b'0', 0, 1, 'tservicio t1', 't1.tfechatienda', 'servicio', 'ServicioModel', 'fechatienda', 'Fechatienda', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tcondicion', 14, 't1', 'nidcondicion', 'tinyint', 'MUL', 0, b'0', 0, 1, 'tservicio t1', 't1.nidcondicion', 'condicion', 'ServicioModel', 'idcondicion', 'Idcondicion', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 15, 't1', 'tfechaentrega', 'date', '', 0, b'0', 0, 1, 'tservicio t1', 't1.tfechaentrega', 'servicio', 'ServicioModel', 'fechaentrega', 'Fechaentrega', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 16, 't1', 'sobservacionsalida', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.sobservacionsalida', 'servicio', 'ServicioModel', 'observacionsalida', 'Observacionsalida', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 17, 't1', 'susuario', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.susuario', 'servicio', 'ServicioModel', 'usuario', 'Usuario', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 18, 't1', 'bformaestado', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.bformaestado', 'servicio', 'ServicioModel', 'formaestado', 'Formaestado', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 19, 't1', 'sdocrefrencia', 'varchar', '', 0, b'0', 0, 1, 'tservicio t1', 't1.sdocrefrencia', 'servicio', 'ServicioModel', 'docrefrencia', 'Docrefrencia', NULL, NULL),
(0, 'tauditoria', 'tservicio', 'tservicio', 20, 't1', 'bestado', 'bit', '', 0, b'0', 0, 1, 'tservicio t1', 't1.bestado', 'servicio', 'ServicioModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tbanda', 'tbanda', 1, 't2', 'nidbanda', 'int', 'PRI', 0, b'0', 0, 2, 'tbanda t2', 't2.nidbanda', 'banda', 'BandaModel', 'idbanda', 'Idbanda', NULL, NULL),
(0, 'tauditoria', 'tbanda', 'tbanda', 2, 't2', 'snombrebanda', 'varchar', '', 0, b'0', 0, 2, 'tbanda t2', 't2.snombrebanda', 'banda', 'BandaModel', 'nombrebanda', 'Nombrebanda', NULL, NULL),
(0, 'tauditoria', 'tbanda', 'tbanda', 3, 't2', 'smarca', 'varchar', '', 0, b'0', 0, 2, 'tbanda t2', 't2.smarca', 'banda', 'BandaModel', 'marca', 'Marca', NULL, NULL),
(0, 'tauditoria', 'tbanda', 'tbanda', 4, 't2', 'bestado', 'bit', '', 0, b'0', 0, 2, 'tbanda t2', 't2.bestado', 'banda', 'BandaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tcondicion', 'tcondicion', 1, 't3', 'nidcondicion', 'tinyint', 'PRI', 0, b'0', 0, 3, 'tcondicion t3', 't3.nidcondicion', 'condicion', 'CondicionModel', 'idcondicion', 'Idcondicion', NULL, NULL),
(0, 'tauditoria', 'tcondicion', 'tcondicion', 2, 't3', 'snombrecondicion', 'varchar', '', 0, b'0', 0, 3, 'tcondicion t3', 't3.snombrecondicion', 'condicion', 'CondicionModel', 'nombrecondicion', 'Nombrecondicion', NULL, NULL),
(0, 'tauditoria', 'tcondicion', 'tcondicion', 3, 't3', 'bestado', 'bit', '', 0, b'0', 0, 3, 'tcondicion t3', 't3.bestado', 'condicion', 'CondicionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tmarca', 'tmarca', 1, 't4', 'nidmarca', 'int', 'PRI', 0, b'0', 0, 4, 'tmarca t4', 't4.nidmarca', 'marca', 'MarcaModel', 'idmarca', 'Idmarca', NULL, NULL),
(0, 'tauditoria', 'tmarca', 'tmarca', 2, 't4', 'snombremarca', 'varchar', '', 0, b'0', 0, 4, 'tmarca t4', 't4.snombremarca', 'marca', 'MarcaModel', 'nombremarca', 'Nombremarca', NULL, NULL),
(0, 'tauditoria', 'tmarca', 'tmarca', 3, 't4', 'bestado', 'bit', '', 0, b'0', 0, 4, 'tmarca t4', 't4.bestado', 'marca', 'MarcaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tmedida', 'tmedida', 1, 't5', 'nidmedida', 'int', 'PRI', 0, b'0', 0, 5, 'tmedida t5', 't5.nidmedida', 'medida', 'MedidaModel', 'idmedida', 'Idmedida', NULL, NULL),
(0, 'tauditoria', 'tmedida', 'tmedida', 2, 't5', 'snombremedida', 'varchar', '', 0, b'0', 0, 5, 'tmedida t5', 't5.snombremedida', 'medida', 'MedidaModel', 'nombremedida', 'Nombremedida', NULL, NULL),
(0, 'tauditoria', 'tmedida', 'tmedida', 3, 't5', 'bestado', 'bit', '', 0, b'0', 0, 5, 'tmedida t5', 't5.bestado', 'medida', 'MedidaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'treencauchadora', 'treencauchadora', 1, 't6', 'nidreencauchadora', 'int', 'PRI', 0, b'0', 0, 6, 'treencauchadora t6', 't6.nidreencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'idreencauchadora', 'Idreencauchadora', NULL, NULL),
(0, 'tauditoria', 'treencauchadora', 'treencauchadora', 2, 't6', 'snombrereencauchadora', 'varchar', '', 0, b'0', 0, 6, 'treencauchadora t6', 't6.snombrereencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'nombrereencauchadora', 'Nombrereencauchadora', NULL, NULL),
(0, 'tauditoria', 'treencauchadora', 'treencauchadora', 3, 't6', 'sdireccion', 'varchar', '', 0, b'0', 0, 6, 'treencauchadora t6', 't6.sdireccion', 'reencauchadora', 'ReencauchadoraModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'tauditoria', 'treencauchadora', 'treencauchadora', 4, 't6', 'bestado', 'bit', '', 0, b'0', 0, 6, 'treencauchadora t6', 't6.bestado', 'reencauchadora', 'ReencauchadoraModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'ttiposervicio', 'ttiposervicio', 1, 't7', 'nidtiposervicio', 'int', 'PRI', 0, b'0', 0, 7, 'ttiposervicio t7', 't7.nidtiposervicio', 'tiposervicio', 'TiposervicioModel', 'idtiposervicio', 'Idtiposervicio', NULL, NULL),
(0, 'tauditoria', 'ttiposervicio', 'ttiposervicio', 2, 't7', 'snombretiposervicio', 'varchar', '', 0, b'0', 0, 7, 'ttiposervicio t7', 't7.snombretiposervicio', 'tiposervicio', 'TiposervicioModel', 'nombretiposervicio', 'Nombretiposervicio', NULL, NULL),
(0, 'tauditoria', 'ttiposervicio', 'ttiposervicio', 3, 't7', 'bestado', 'bit', '', 0, b'0', 0, 7, 'ttiposervicio t7', 't7.bestado', 'tiposervicio', 'TiposervicioModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tubicacion', 'tubicacion', 1, 't8', 'nidubicacion', 'int', 'PRI', 0, b'0', 0, 8, 'tubicacion t8', 't8.nidubicacion', 'ubicacion', 'UbicacionModel', 'idubicacion', 'Idubicacion', NULL, NULL),
(0, 'tauditoria', 'tubicacion', 'tubicacion', 2, 't8', 'snombretipoubicacion', 'varchar', '', 0, b'0', 0, 8, 'tubicacion t8', 't8.snombretipoubicacion', 'ubicacion', 'UbicacionModel', 'nombretipoubicacion', 'Nombretipoubicacion', NULL, NULL),
(0, 'tauditoria', 'tubicacion', 'tubicacion', 3, 't8', 'bestado', 'bit', '', 0, b'0', 0, 8, 'tubicacion t8', 't8.bestado', 'ubicacion', 'UbicacionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tauditoria', 'tcliente', 'tcliente', 1, 't9', 'sidcliente', 'varchar', 'PRI', 0, b'0', 0, 9, 'tcliente t9', 't9.sidcliente', 'cliente', 'ClienteModel', 'idcliente', 'Idcliente', NULL, NULL),
(0, 'tauditoria', 'tcliente', 'tcliente', 2, 't9', 'snombrecliente', 'varchar', '', 0, b'0', 0, 9, 'tcliente t9', 't9.snombrecliente', 'cliente', 'ClienteModel', 'nombrecliente', 'Nombrecliente', NULL, NULL),
(0, 'tauditoria', 'tcliente', 'tcliente', 3, 't9', 'sdireccion', 'varchar', '', 0, b'0', 0, 9, 'tcliente t9', 't9.sdireccion', 'cliente', 'ClienteModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'tauditoria', 'tcliente', 'tcliente', 4, 't9', 'stelefono', 'varchar', '', 0, b'0', 0, 9, 'tcliente t9', 't9.stelefono', 'cliente', 'ClienteModel', 'telefono', 'Telefono', NULL, NULL),
(0, 'tauditoria', 'tcliente', 'tcliente', 5, 't9', 'bestado', 'bit', '', 0, b'0', 0, 9, 'tcliente t9', 't9.bestado', 'cliente', 'ClienteModel', 'estado', 'Estado', NULL, NULL),
(0, 'tbanda', 'tbanda', 'tbanda', 1, 't0', 'nidbanda', 'int', 'PRI', 0, b'0', 0, 0, 'tbanda t0', 't0.nidbanda', 'banda', 'BandaModel', 'idbanda', 'Idbanda', NULL, NULL),
(0, 'tbanda', 'tbanda', 'tbanda', 2, 't0', 'snombrebanda', 'varchar', '', 0, b'0', 0, 0, 'tbanda t0', 't0.snombrebanda', 'banda', 'BandaModel', 'nombrebanda', 'Nombrebanda', NULL, NULL),
(0, 'tbanda', 'tbanda', 'tbanda', 3, 't0', 'smarca', 'varchar', '', 0, b'0', 0, 0, 'tbanda t0', 't0.smarca', 'banda', 'BandaModel', 'marca', 'Marca', NULL, NULL),
(0, 'tbanda', 'tbanda', 'tbanda', 4, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tbanda t0', 't0.bestado', 'banda', 'BandaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tcliente', 'tcliente', 'tcliente', 1, 't0', 'sidcliente', 'varchar', 'PRI', 0, b'0', 0, 0, 'tcliente t0', 't0.sidcliente', 'cliente', 'ClienteModel', 'idcliente', 'Idcliente', NULL, NULL),
(0, 'tcliente', 'tcliente', 'tcliente', 2, 't0', 'snombrecliente', 'varchar', '', 0, b'0', 0, 0, 'tcliente t0', 't0.snombrecliente', 'cliente', 'ClienteModel', 'nombrecliente', 'Nombrecliente', NULL, NULL),
(0, 'tcliente', 'tcliente', 'tcliente', 3, 't0', 'sdireccion', 'varchar', '', 0, b'0', 0, 0, 'tcliente t0', 't0.sdireccion', 'cliente', 'ClienteModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'tcliente', 'tcliente', 'tcliente', 4, 't0', 'stelefono', 'varchar', '', 0, b'0', 0, 0, 'tcliente t0', 't0.stelefono', 'cliente', 'ClienteModel', 'telefono', 'Telefono', NULL, NULL),
(0, 'tcliente', 'tcliente', 'tcliente', 5, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tcliente t0', 't0.bestado', 'cliente', 'ClienteModel', 'estado', 'Estado', NULL, NULL),
(0, 'tcondicion', 'tcondicion', 'tcondicion', 1, 't0', 'nidcondicion', 'tinyint', 'PRI', 0, b'0', 0, 0, 'tcondicion t0', 't0.nidcondicion', 'condicion', 'CondicionModel', 'idcondicion', 'Idcondicion', NULL, NULL),
(0, 'tcondicion', 'tcondicion', 'tcondicion', 2, 't0', 'snombrecondicion', 'varchar', '', 0, b'0', 0, 0, 'tcondicion t0', 't0.snombrecondicion', 'condicion', 'CondicionModel', 'nombrecondicion', 'Nombrecondicion', NULL, NULL),
(0, 'tcondicion', 'tcondicion', 'tcondicion', 3, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tcondicion t0', 't0.bestado', 'condicion', 'CondicionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tmarca', 'tmarca', 'tmarca', 1, 't0', 'nidmarca', 'int', 'PRI', 0, b'0', 0, 0, 'tmarca t0', 't0.nidmarca', 'marca', 'MarcaModel', 'idmarca', 'Idmarca', NULL, NULL),
(0, 'tmarca', 'tmarca', 'tmarca', 2, 't0', 'snombremarca', 'varchar', '', 0, b'0', 0, 0, 'tmarca t0', 't0.snombremarca', 'marca', 'MarcaModel', 'nombremarca', 'Nombremarca', NULL, NULL),
(0, 'tmarca', 'tmarca', 'tmarca', 3, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tmarca t0', 't0.bestado', 'marca', 'MarcaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tmedida', 'tmedida', 'tmedida', 1, 't0', 'nidmedida', 'int', 'PRI', 0, b'0', 0, 0, 'tmedida t0', 't0.nidmedida', 'medida', 'MedidaModel', 'idmedida', 'Idmedida', NULL, NULL),
(0, 'tmedida', 'tmedida', 'tmedida', 2, 't0', 'snombremedida', 'varchar', '', 0, b'0', 0, 0, 'tmedida t0', 't0.snombremedida', 'medida', 'MedidaModel', 'nombremedida', 'Nombremedida', NULL, NULL),
(0, 'tmedida', 'tmedida', 'tmedida', 3, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tmedida t0', 't0.bestado', 'medida', 'MedidaModel', 'estado', 'Estado', NULL, NULL),
(0, 'treencauchadora', 'treencauchadora', 'treencauchadora', 1, 't0', 'nidreencauchadora', 'int', 'PRI', 0, b'0', 0, 0, 'treencauchadora t0', 't0.nidreencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'idreencauchadora', 'Idreencauchadora', NULL, NULL),
(0, 'treencauchadora', 'treencauchadora', 'treencauchadora', 2, 't0', 'snombrereencauchadora', 'varchar', '', 0, b'0', 0, 0, 'treencauchadora t0', 't0.snombrereencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'nombrereencauchadora', 'Nombrereencauchadora', NULL, NULL),
(0, 'treencauchadora', 'treencauchadora', 'treencauchadora', 3, 't0', 'sdireccion', 'varchar', '', 0, b'0', 0, 0, 'treencauchadora t0', 't0.sdireccion', 'reencauchadora', 'ReencauchadoraModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'treencauchadora', 'treencauchadora', 'treencauchadora', 4, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'treencauchadora t0', 't0.bestado', 'reencauchadora', 'ReencauchadoraModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 1, 't0', 'nidservicio', 'int', 'PRI', 0, b'0', 0, 0, 'tservicio t0', 't0.nidservicio', 'servicio', 'ServicioModel', 'idservicio', 'Idservicio', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tcliente', 2, 't0', 'sidcliente', 'varchar', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.sidcliente', 'cliente', 'ServicioModel', 'idcliente', 'Idcliente', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 3, 't0', 'tfecharecepcion', 'date', '', 0, b'0', 0, 0, 'tservicio t0', 't0.tfecharecepcion', 'servicio', 'ServicioModel', 'fecharecepcion', 'Fecharecepcion', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tbanda', 4, 't0', 'nidbanda', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidbanda', 'banda', 'ServicioModel', 'idbanda', 'Idbanda', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 5, 't0', 'splaca', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.splaca', 'servicio', 'ServicioModel', 'placa', 'Placa', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 6, 't0', 'sobservacioningreso', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.sobservacioningreso', 'servicio', 'ServicioModel', 'observacioningreso', 'Observacioningreso', NULL, NULL),
(0, 'tservicio', 'tservicio', 'ttiposervicio', 7, 't0', 'nidtiposervicio', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidtiposervicio', 'tiposervicio', 'ServicioModel', 'idtiposervicio', 'Idtiposervicio', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tmedida', 8, 't0', 'nidmedida', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidmedida', 'medida', 'ServicioModel', 'idmedida', 'Idmedida', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tmarca', 9, 't0', 'nidmarca', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidmarca', 'marca', 'ServicioModel', 'idmarca', 'Idmarca', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 10, 't0', 'scodigo', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.scodigo', 'servicio', 'ServicioModel', 'codigo', 'Codigo', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tubicacion', 11, 't0', 'nidubicacion', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidubicacion', 'ubicacion', 'ServicioModel', 'idubicacion', 'Idubicacion', NULL, NULL),
(0, 'tservicio', 'tservicio', 'treencauchadora', 12, 't0', 'nidreencauchadora', 'int', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidreencauchadora', 'reencauchadora', 'ServicioModel', 'idreencauchadora', 'Idreencauchadora', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 13, 't0', 'tfechatienda', 'date', '', 0, b'0', 0, 0, 'tservicio t0', 't0.tfechatienda', 'servicio', 'ServicioModel', 'fechatienda', 'Fechatienda', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tcondicion', 14, 't0', 'nidcondicion', 'tinyint', 'MUL', 0, b'0', 0, 0, 'tservicio t0', 't0.nidcondicion', 'condicion', 'ServicioModel', 'idcondicion', 'Idcondicion', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 15, 't0', 'tfechaentrega', 'date', '', 0, b'0', 0, 0, 'tservicio t0', 't0.tfechaentrega', 'servicio', 'ServicioModel', 'fechaentrega', 'Fechaentrega', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 16, 't0', 'sobservacionsalida', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.sobservacionsalida', 'servicio', 'ServicioModel', 'observacionsalida', 'Observacionsalida', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 17, 't0', 'susuario', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.susuario', 'servicio', 'ServicioModel', 'usuario', 'Usuario', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 18, 't0', 'bformaestado', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.bformaestado', 'servicio', 'ServicioModel', 'formaestado', 'Formaestado', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 19, 't0', 'sdocrefrencia', 'varchar', '', 0, b'0', 0, 0, 'tservicio t0', 't0.sdocrefrencia', 'servicio', 'ServicioModel', 'docrefrencia', 'Docrefrencia', NULL, NULL),
(0, 'tservicio', 'tservicio', 'tservicio', 20, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tservicio t0', 't0.bestado', 'servicio', 'ServicioModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tbanda', 'tbanda', 1, 't1', 'nidbanda', 'int', 'PRI', 0, b'0', 0, 1, 'tbanda t1', 't1.nidbanda', 'banda', 'BandaModel', 'idbanda', 'Idbanda', NULL, NULL),
(0, 'tservicio', 'tbanda', 'tbanda', 2, 't1', 'snombrebanda', 'varchar', '', 0, b'0', 0, 1, 'tbanda t1', 't1.snombrebanda', 'banda', 'BandaModel', 'nombrebanda', 'Nombrebanda', NULL, NULL),
(0, 'tservicio', 'tbanda', 'tbanda', 3, 't1', 'smarca', 'varchar', '', 0, b'0', 0, 1, 'tbanda t1', 't1.smarca', 'banda', 'BandaModel', 'marca', 'Marca', NULL, NULL),
(0, 'tservicio', 'tbanda', 'tbanda', 4, 't1', 'bestado', 'bit', '', 0, b'0', 0, 1, 'tbanda t1', 't1.bestado', 'banda', 'BandaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tcondicion', 'tcondicion', 1, 't2', 'nidcondicion', 'tinyint', 'PRI', 0, b'0', 0, 2, 'tcondicion t2', 't2.nidcondicion', 'condicion', 'CondicionModel', 'idcondicion', 'Idcondicion', NULL, NULL),
(0, 'tservicio', 'tcondicion', 'tcondicion', 2, 't2', 'snombrecondicion', 'varchar', '', 0, b'0', 0, 2, 'tcondicion t2', 't2.snombrecondicion', 'condicion', 'CondicionModel', 'nombrecondicion', 'Nombrecondicion', NULL, NULL),
(0, 'tservicio', 'tcondicion', 'tcondicion', 3, 't2', 'bestado', 'bit', '', 0, b'0', 0, 2, 'tcondicion t2', 't2.bestado', 'condicion', 'CondicionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tmarca', 'tmarca', 1, 't3', 'nidmarca', 'int', 'PRI', 0, b'0', 0, 3, 'tmarca t3', 't3.nidmarca', 'marca', 'MarcaModel', 'idmarca', 'Idmarca', NULL, NULL),
(0, 'tservicio', 'tmarca', 'tmarca', 2, 't3', 'snombremarca', 'varchar', '', 0, b'0', 0, 3, 'tmarca t3', 't3.snombremarca', 'marca', 'MarcaModel', 'nombremarca', 'Nombremarca', NULL, NULL),
(0, 'tservicio', 'tmarca', 'tmarca', 3, 't3', 'bestado', 'bit', '', 0, b'0', 0, 3, 'tmarca t3', 't3.bestado', 'marca', 'MarcaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tmedida', 'tmedida', 1, 't4', 'nidmedida', 'int', 'PRI', 0, b'0', 0, 4, 'tmedida t4', 't4.nidmedida', 'medida', 'MedidaModel', 'idmedida', 'Idmedida', NULL, NULL),
(0, 'tservicio', 'tmedida', 'tmedida', 2, 't4', 'snombremedida', 'varchar', '', 0, b'0', 0, 4, 'tmedida t4', 't4.snombremedida', 'medida', 'MedidaModel', 'nombremedida', 'Nombremedida', NULL, NULL),
(0, 'tservicio', 'tmedida', 'tmedida', 3, 't4', 'bestado', 'bit', '', 0, b'0', 0, 4, 'tmedida t4', 't4.bestado', 'medida', 'MedidaModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'treencauchadora', 'treencauchadora', 1, 't5', 'nidreencauchadora', 'int', 'PRI', 0, b'0', 0, 5, 'treencauchadora t5', 't5.nidreencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'idreencauchadora', 'Idreencauchadora', NULL, NULL),
(0, 'tservicio', 'treencauchadora', 'treencauchadora', 2, 't5', 'snombrereencauchadora', 'varchar', '', 0, b'0', 0, 5, 'treencauchadora t5', 't5.snombrereencauchadora', 'reencauchadora', 'ReencauchadoraModel', 'nombrereencauchadora', 'Nombrereencauchadora', NULL, NULL),
(0, 'tservicio', 'treencauchadora', 'treencauchadora', 3, 't5', 'sdireccion', 'varchar', '', 0, b'0', 0, 5, 'treencauchadora t5', 't5.sdireccion', 'reencauchadora', 'ReencauchadoraModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'tservicio', 'treencauchadora', 'treencauchadora', 4, 't5', 'bestado', 'bit', '', 0, b'0', 0, 5, 'treencauchadora t5', 't5.bestado', 'reencauchadora', 'ReencauchadoraModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'ttiposervicio', 'ttiposervicio', 1, 't6', 'nidtiposervicio', 'int', 'PRI', 0, b'0', 0, 6, 'ttiposervicio t6', 't6.nidtiposervicio', 'tiposervicio', 'TiposervicioModel', 'idtiposervicio', 'Idtiposervicio', NULL, NULL),
(0, 'tservicio', 'ttiposervicio', 'ttiposervicio', 2, 't6', 'snombretiposervicio', 'varchar', '', 0, b'0', 0, 6, 'ttiposervicio t6', 't6.snombretiposervicio', 'tiposervicio', 'TiposervicioModel', 'nombretiposervicio', 'Nombretiposervicio', NULL, NULL),
(0, 'tservicio', 'ttiposervicio', 'ttiposervicio', 3, 't6', 'bestado', 'bit', '', 0, b'0', 0, 6, 'ttiposervicio t6', 't6.bestado', 'tiposervicio', 'TiposervicioModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tubicacion', 'tubicacion', 1, 't7', 'nidubicacion', 'int', 'PRI', 0, b'0', 0, 7, 'tubicacion t7', 't7.nidubicacion', 'ubicacion', 'UbicacionModel', 'idubicacion', 'Idubicacion', NULL, NULL),
(0, 'tservicio', 'tubicacion', 'tubicacion', 2, 't7', 'snombretipoubicacion', 'varchar', '', 0, b'0', 0, 7, 'tubicacion t7', 't7.snombretipoubicacion', 'ubicacion', 'UbicacionModel', 'nombretipoubicacion', 'Nombretipoubicacion', NULL, NULL),
(0, 'tservicio', 'tubicacion', 'tubicacion', 3, 't7', 'bestado', 'bit', '', 0, b'0', 0, 7, 'tubicacion t7', 't7.bestado', 'ubicacion', 'UbicacionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tservicio', 'tcliente', 'tcliente', 1, 't8', 'sidcliente', 'varchar', 'PRI', 0, b'0', 0, 8, 'tcliente t8', 't8.sidcliente', 'cliente', 'ClienteModel', 'idcliente', 'Idcliente', NULL, NULL),
(0, 'tservicio', 'tcliente', 'tcliente', 2, 't8', 'snombrecliente', 'varchar', '', 0, b'0', 0, 8, 'tcliente t8', 't8.snombrecliente', 'cliente', 'ClienteModel', 'nombrecliente', 'Nombrecliente', NULL, NULL),
(0, 'tservicio', 'tcliente', 'tcliente', 3, 't8', 'sdireccion', 'varchar', '', 0, b'0', 0, 8, 'tcliente t8', 't8.sdireccion', 'cliente', 'ClienteModel', 'direccion', 'Direccion', NULL, NULL),
(0, 'tservicio', 'tcliente', 'tcliente', 4, 't8', 'stelefono', 'varchar', '', 0, b'0', 0, 8, 'tcliente t8', 't8.stelefono', 'cliente', 'ClienteModel', 'telefono', 'Telefono', NULL, NULL),
(0, 'tservicio', 'tcliente', 'tcliente', 5, 't8', 'bestado', 'bit', '', 0, b'0', 0, 8, 'tcliente t8', 't8.bestado', 'cliente', 'ClienteModel', 'estado', 'Estado', NULL, NULL),
(0, 'ttiposervicio', 'ttiposervicio', 'ttiposervicio', 1, 't0', 'nidtiposervicio', 'int', 'PRI', 0, b'0', 0, 0, 'ttiposervicio t0', 't0.nidtiposervicio', 'tiposervicio', 'TiposervicioModel', 'idtiposervicio', 'Idtiposervicio', NULL, NULL),
(0, 'ttiposervicio', 'ttiposervicio', 'ttiposervicio', 2, 't0', 'snombretiposervicio', 'varchar', '', 0, b'0', 0, 0, 'ttiposervicio t0', 't0.snombretiposervicio', 'tiposervicio', 'TiposervicioModel', 'nombretiposervicio', 'Nombretiposervicio', NULL, NULL),
(0, 'ttiposervicio', 'ttiposervicio', 'ttiposervicio', 3, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'ttiposervicio t0', 't0.bestado', 'tiposervicio', 'TiposervicioModel', 'estado', 'Estado', NULL, NULL),
(0, 'tubicacion', 'tubicacion', 'tubicacion', 1, 't0', 'nidubicacion', 'int', 'PRI', 0, b'0', 0, 0, 'tubicacion t0', 't0.nidubicacion', 'ubicacion', 'UbicacionModel', 'idubicacion', 'Idubicacion', NULL, NULL),
(0, 'tubicacion', 'tubicacion', 'tubicacion', 2, 't0', 'snombretipoubicacion', 'varchar', '', 0, b'0', 0, 0, 'tubicacion t0', 't0.snombretipoubicacion', 'ubicacion', 'UbicacionModel', 'nombretipoubicacion', 'Nombretipoubicacion', NULL, NULL),
(0, 'tubicacion', 'tubicacion', 'tubicacion', 3, 't0', 'bestado', 'bit', '', 0, b'0', 0, 0, 'tubicacion t0', 't0.bestado', 'ubicacion', 'UbicacionModel', 'estado', 'Estado', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 1, 't0', 'nusuarioid', 'int', 'PRI', 0, b'0', 0, 0, 'tusuario t0', 't0.nusuarioid', 'usuario', 'UsuarioModel', 'usuarioid', 'Usuarioid', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 2, 't0', 'susuarionrodoc', 'varchar', '', 0, b'0', 0, 0, 'tusuario t0', 't0.susuarionrodoc', 'usuario', 'UsuarioModel', 'usuarionrodoc', 'Usuarionrodoc', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 3, 't0', 'susuariotipodoc', 'varchar', '', 0, b'0', 0, 0, 'tusuario t0', 't0.susuariotipodoc', 'usuario', 'UsuarioModel', 'usuariotipodoc', 'Usuariotipodoc', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 4, 't0', 'susuarionombre', 'varchar', '', 0, b'0', 0, 0, 'tusuario t0', 't0.susuarionombre', 'usuario', 'UsuarioModel', 'usuarionombre', 'Usuarionombre', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 5, 't0', 'susuariotelefono', 'varchar', '', 0, b'0', 0, 0, 'tusuario t0', 't0.susuariotelefono', 'usuario', 'UsuarioModel', 'usuariotelefono', 'Usuariotelefono', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 6, 't0', 'susuariopassword', 'varchar', '', 0, b'0', 0, 0, 'tusuario t0', 't0.susuariopassword', 'usuario', 'UsuarioModel', 'usuariopassword', 'Usuariopassword', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 7, 't0', 'nusuariotiporol', 'tinyint', '', 0, b'0', 0, 0, 'tusuario t0', 't0.nusuariotiporol', 'usuario', 'UsuarioModel', 'usuariotiporol', 'Usuariotiporol', NULL, NULL),
(0, 'tusuario', 'tusuario', 'tusuario', 8, 't0', 'busuarioestado', 'bit', '', 0, b'0', 0, 0, 'tusuario t0', 't0.busuarioestado', 'usuario', 'UsuarioModel', 'usuarioestado', 'Usuarioestado', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tconfiguraciones`
--

CREATE TABLE `tconfiguraciones` (
  `stabla` varchar(100) NOT NULL,
  `stablaforeing` varchar(100) NOT NULL,
  `salias` varchar(2) NOT NULL,
  `bnombre` bit(1) NOT NULL,
  `nnombre` int(11) DEFAULT NULL,
  `snombre` varchar(100) NOT NULL,
  `bconcat` bit(1) NOT NULL,
  `norden` int(11) NOT NULL,
  `stipodato` varchar(45) NOT NULL,
  `sprimarykey` varchar(10) NOT NULL,
  `sincremental` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tconfiguraciones`
--

INSERT INTO `tconfiguraciones` (`stabla`, `stablaforeing`, `salias`, `bnombre`, `nnombre`, `snombre`, `bconcat`, `norden`, `stipodato`, `sprimarykey`, `sincremental`) VALUES
('tbanda', 'tbanda', 't0', b'1', 1, 'nidbanda', b'0', 0, 'int', 'PRI', 'auto_increment'),
('tbanda', 'tbanda', 't0', b'0', 0, 'snombrebanda', b'1', 1, 'varchar', '', ''),
('tcliente', 'tcliente', 't0', b'1', 1, 'sidcliente', b'1', 1, 'varchar', 'PRI', ''),
('tcliente', 'tcliente', 't0', b'0', 0, 'srasonsocial', b'1', 2, 'varchar', '', ''),
('tcondicion', 'tcondicion', 't0', b'1', 1, 'nidcondicion', b'0', 0, 'tinyint', 'PRI', 'auto_increment'),
('tcondicion', 'tcondicion', 't0', b'0', 0, 'snombrecondicion', b'1', 1, 'varchar', '', ''),
('tneumatico', 'tneumatico', 't0', b'1', 1, 'nidneumatico', b'0', 0, 'int', 'PRI', 'auto_increment'),
('tneumatico', 'tneumatico', 't0', b'0', 0, 'smarca', b'1', 1, 'varchar', '', ''),
('tneumatico', 'tneumatico', 't0', b'0', 0, 'sdescripcion', b'1', 2, 'varchar', '', ''),
('treencauchadora', 'treencauchadora', 't0', b'1', 1, 'nidrencauchadora', b'0', 0, 'int', 'PRI', 'auto_increment'),
('treencauchadora', 'treencauchadora', 't0', b'0', 0, 'snombrereencauchadora', b'1', 1, 'varchar', '', ''),
('tservicio', 'tservicio', 't0', b'1', 1, 'nidservicio', b'0', 0, 'int', 'PRI', 'auto_increment'),
('tservicio', 'tcliente', 't1', b'0', 0, 'sidcliente', b'1', 4, 'varchar', 'MUL', ''),
('tservicio', 'tcliente', 't1', b'0', 0, 'srasonsocial', b'1', 5, 'varchar', '', ''),
('tservicio', 'tubicacion', 't2', b'0', 0, 'snombretipoubicacion', b'1', 3, 'varchar', '', ''),
('tservicio', 'tneumatico', 't5', b'0', 0, 'scodigo', b'1', 1, 'varchar', '', ''),
('tservicio', 'tneumatico', 't5', b'0', 0, 'smarca', b'1', 2, 'varchar', '', ''),
('ttiposervicio', 'ttiposervicio', 't0', b'1', 1, 'nidtiposervicio', b'0', 0, 'int', 'PRI', 'auto_increment'),
('ttiposervicio', 'ttiposervicio', 't0', b'0', 0, 'snombretiposervicio', b'1', 1, 'varchar', '', ''),
('tubicacion', 'tubicacion', 't0', b'1', 1, 'nidubicacion', b'0', 0, 'int', 'PRI', 'auto_increment'),
('tubicacion', 'tubicacion', 't0', b'0', 0, 'snombretipoubicacion', b'1', 1, 'varchar', '', ''),
('tusuario', 'tusuario', 't0', b'1', 1, 'sidusuario', b'0', 0, 'varchar', 'PRI', ''),
('tusuario', 'tusuario', 't0', b'0', 0, 'snombreusuario', b'1', 1, 'varchar', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tconfiguracionestemporal`
--

CREATE TABLE `tconfiguracionestemporal` (
  `id` int(11) DEFAULT NULL,
  `stabla` varchar(100) DEFAULT NULL,
  `stablaforeing` varchar(100) DEFAULT NULL,
  `salias` varchar(2) DEFAULT NULL,
  `bnombre` bit(1) DEFAULT NULL,
  `nnombre` int(11) DEFAULT NULL,
  `snombre` varchar(100) DEFAULT NULL,
  `bconcat` bit(1) DEFAULT NULL,
  `norden` int(11) DEFAULT NULL,
  `stipodato` varchar(45) DEFAULT NULL,
  `sprimarykey` varchar(45) DEFAULT NULL,
  `sincremental` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tconfiguracionestemporal`
--

INSERT INTO `tconfiguracionestemporal` (`id`, `stabla`, `stablaforeing`, `salias`, `bnombre`, `nnombre`, `snombre`, `bconcat`, `norden`, `stipodato`, `sprimarykey`, `sincremental`) VALUES
(0, 'tbanda', 'tbanda', 't0', b'1', 1, 'nidbanda', b'0', 0, 'int', 'PRI', 'auto_increment'),
(1, 'tbanda', 'tbanda', 't0', b'0', 0, 'snombrebanda', b'0', 0, 'varchar', '', ''),
(2, 'tbanda', 'tbanda', 't0', b'0', 0, 'smarca', b'0', 0, 'varchar', '', ''),
(3, 'tbanda', 'tbanda', 't0', b'0', 0, 'bestado', b'0', 0, 'bit', '', ''),
(4, 'tcliente', 'tcliente', 't0', b'1', 1, 'sidcliente', b'0', 0, 'varchar', 'PRI', ''),
(5, 'tcliente', 'tcliente', 't0', b'0', 0, 'srasonsocial', b'0', 0, 'varchar', '', ''),
(6, 'tcliente', 'tcliente', 't0', b'0', 0, 'sdireccion', b'0', 0, 'varchar', '', ''),
(7, 'tcliente', 'tcliente', 't0', b'0', 0, 'stelefono', b'0', 0, 'varchar', '', ''),
(8, 'tcliente', 'tcliente', 't0', b'0', 0, 'bestado', b'0', 0, 'bit', '', ''),
(9, 'tcondicion', 'tcondicion', 't0', b'1', 1, 'nidcondicion', b'0', 0, 'tinyint', 'PRI', 'auto_increment'),
(10, 'tcondicion', 'tcondicion', 't0', b'0', 0, 'snombrecondicion', b'0', 0, 'varchar', '', ''),
(11, 'tneumatico', 'tneumatico', 't0', b'1', 1, 'nidneumatico', b'0', 0, 'int', 'PRI', 'auto_increment'),
(12, 'tneumatico', 'tneumatico', 't0', b'0', 0, 'scodigo', b'0', 0, 'varchar', '', ''),
(13, 'tneumatico', 'tneumatico', 't0', b'0', 0, 'smarca', b'0', 0, 'varchar', '', ''),
(14, 'tneumatico', 'tneumatico', 't0', b'0', 0, 'sdescripcion', b'0', 0, 'varchar', '', ''),
(15, 'treencauchadora', 'treencauchadora', 't0', b'1', 1, 'nidrencauchadora', b'0', 0, 'int', 'PRI', 'auto_increment'),
(16, 'treencauchadora', 'treencauchadora', 't0', b'0', 0, 'snombrereencauchadora', b'0', 0, 'varchar', '', ''),
(17, 'treencauchadora', 'treencauchadora', 't0', b'0', 0, 'sdireccion', b'0', 0, 'varchar', '', ''),
(18, 'tservicio', 'tservicio', 't0', b'1', 1, 'nidservicio', b'0', 0, 'int', 'PRI', 'auto_increment'),
(19, 'tservicio', 'tservicio', 't0', b'0', 0, 'tfechaingreso', b'0', 0, 'date', '', ''),
(20, 'tservicio', 'tservicio', 't0', b'0', 0, 'sidusuario', b'0', 0, 'varchar', 'MUL', ''),
(21, 'tservicio', 'tservicio', 't0', b'0', 0, 'sobservacioningreso', b'0', 0, 'varchar', '', ''),
(22, 'tservicio', 'tservicio', 't0', b'0', 0, 'sidcliente', b'0', 0, 'varchar', 'MUL', ''),
(23, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidtiposervicio', b'0', 0, 'int', 'MUL', ''),
(24, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidbanda', b'0', 0, 'int', 'MUL', ''),
(25, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidneumatico', b'0', 0, 'int', 'MUL', ''),
(26, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidubicacion', b'0', 0, 'int', 'MUL', ''),
(27, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidrencauchadora', b'0', 0, 'int', 'MUL', ''),
(28, 'tservicio', 'tservicio', 't0', b'0', 0, 'tfecchasalida', b'0', 0, 'date', '', ''),
(29, 'tservicio', 'tservicio', 't0', b'0', 0, 'sobservacionsalida', b'0', 0, 'varchar', '', ''),
(30, 'tservicio', 'tservicio', 't0', b'0', 0, 'nidcondicion', b'0', 0, 'tinyint', 'MUL', ''),
(31, 'tservicio', 'tservicio', 't0', b'0', 0, 'nestado', b'0', 0, 'tinyint', '', ''),
(32, 'tservicio', 'tcliente', 't1', b'1', 1, 'sidcliente', b'0', 0, 'varchar', 'MUL', ''),
(33, 'tservicio', 'tcliente', 't1', b'0', 0, 'srasonsocial', b'0', 0, 'varchar', '', ''),
(34, 'tservicio', 'tcliente', 't1', b'0', 0, 'sdireccion', b'0', 0, 'varchar', '', ''),
(35, 'tservicio', 'tcliente', 't1', b'0', 0, 'stelefono', b'0', 0, 'varchar', '', ''),
(36, 'tservicio', 'tcliente', 't1', b'0', 0, 'bestado', b'0', 0, 'bit', '', ''),
(37, 'tservicio', 'tubicacion', 't2', b'1', 1, 'nidubicacion', b'0', 0, 'int', 'MUL', 'auto_increment'),
(38, 'tservicio', 'tubicacion', 't2', b'0', 0, 'snombretipoubicacion', b'0', 0, 'varchar', '', ''),
(39, 'tservicio', 'tbanda', 't3', b'1', 1, 'nidbanda', b'0', 0, 'int', 'MUL', 'auto_increment'),
(40, 'tservicio', 'tbanda', 't3', b'0', 0, 'snombrebanda', b'0', 0, 'varchar', '', ''),
(41, 'tservicio', 'tbanda', 't3', b'0', 0, 'smarca', b'0', 0, 'varchar', '', ''),
(42, 'tservicio', 'tbanda', 't3', b'0', 0, 'bestado', b'0', 0, 'bit', '', ''),
(43, 'tservicio', 'tcondicion', 't4', b'1', 1, 'nidcondicion', b'0', 0, 'tinyint', 'MUL', 'auto_increment'),
(44, 'tservicio', 'tcondicion', 't4', b'0', 0, 'snombrecondicion', b'0', 0, 'varchar', '', ''),
(45, 'tservicio', 'tneumatico', 't5', b'1', 1, 'nidneumatico', b'0', 0, 'int', 'MUL', 'auto_increment'),
(46, 'tservicio', 'tneumatico', 't5', b'0', 0, 'scodigo', b'0', 0, 'varchar', '', ''),
(47, 'tservicio', 'tneumatico', 't5', b'0', 0, 'smarca', b'0', 0, 'varchar', '', ''),
(48, 'tservicio', 'tneumatico', 't5', b'0', 0, 'sdescripcion', b'0', 0, 'varchar', '', ''),
(49, 'tservicio', 'treencauchadora', 't6', b'1', 1, 'nidrencauchadora', b'0', 0, 'int', 'MUL', 'auto_increment'),
(50, 'tservicio', 'treencauchadora', 't6', b'0', 0, 'snombrereencauchadora', b'0', 0, 'varchar', '', ''),
(51, 'tservicio', 'treencauchadora', 't6', b'0', 0, 'sdireccion', b'0', 0, 'varchar', '', ''),
(52, 'tservicio', 'ttiposervicio', 't7', b'1', 1, 'nidtiposervicio', b'0', 0, 'int', 'MUL', 'auto_increment'),
(53, 'tservicio', 'ttiposervicio', 't7', b'0', 0, 'snombretiposervicio', b'0', 0, 'varchar', '', ''),
(54, 'tservicio', 'tusuario', 't8', b'1', 1, 'sidusuario', b'0', 0, 'varchar', 'MUL', ''),
(55, 'tservicio', 'tusuario', 't8', b'0', 0, 'snombreusuario', b'0', 0, 'varchar', '', ''),
(56, 'ttiposervicio', 'ttiposervicio', 't0', b'1', 1, 'nidtiposervicio', b'0', 0, 'int', 'PRI', 'auto_increment'),
(57, 'ttiposervicio', 'ttiposervicio', 't0', b'0', 0, 'snombretiposervicio', b'0', 0, 'varchar', '', ''),
(58, 'tubicacion', 'tubicacion', 't0', b'1', 1, 'nidubicacion', b'0', 0, 'int', 'PRI', 'auto_increment'),
(59, 'tubicacion', 'tubicacion', 't0', b'0', 0, 'snombretipoubicacion', b'0', 0, 'varchar', '', ''),
(60, 'tusuario', 'tusuario', 't0', b'1', 1, 'sidusuario', b'0', 0, 'varchar', 'PRI', ''),
(61, 'tusuario', 'tusuario', 't0', b'0', 0, 'snombreusuario', b'0', 0, 'varchar', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmarca`
--

CREATE TABLE `tmarca` (
  `nidmarca` int(11) NOT NULL,
  `snombremarca` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tmarca`
--

INSERT INTO `tmarca` (`nidmarca`, `snombremarca`, `bestado`) VALUES
(1, 'AMBERSTONE', b'1'),
(2, 'CONTINENTAL', b'1'),
(3, 'DERUIBO', b'1'),
(4, '295/80R22.5', b'0'),
(5, 'LONGMARCH', b'1'),
(6, 'MICHELIN', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmedida`
--

CREATE TABLE `tmedida` (
  `nidmedida` int(11) NOT NULL,
  `snombremedida` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tmedida`
--

INSERT INTO `tmedida` (`nidmedida`, `snombremedida`, `bestado`) VALUES
(1, '11R22.5', b'1'),
(2, '295/80R22.5', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treencauchadora`
--

CREATE TABLE `treencauchadora` (
  `nidreencauchadora` int(11) NOT NULL,
  `snombrereencauchadora` varchar(45) DEFAULT NULL,
  `sdireccion` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `treencauchadora`
--

INSERT INTO `treencauchadora` (`nidreencauchadora`, `snombrereencauchadora`, `sdireccion`, `bestado`) VALUES
(1, 'RECUS', 'AV. LA CULTURA', b'1'),
(2, 'HGO', 'SAN JERONIMO', b'1'),
(3, 'RICHARD', 'SAN JERONIMO', b'1'),
(4, 'HECTOR', 'SAN SEBASTIAN', b'1'),
(5, 'CARLITOS', 'SAN SEBAS', b'0'),
(6, 'PRUEBAR', 'NO IMPORTA', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tservicio`
--

CREATE TABLE `tservicio` (
  `nidservicio` int(11) NOT NULL,
  `sidcliente` varchar(45) DEFAULT NULL,
  `tfecharecepcion` date DEFAULT NULL,
  `nidbanda` int(11) DEFAULT NULL,
  `splaca` varchar(8) DEFAULT NULL,
  `sobservacioningreso` varchar(150) DEFAULT NULL,
  `nidtiposervicio` int(11) DEFAULT NULL,
  `nidmedida` int(11) DEFAULT NULL,
  `nidmarca` int(11) DEFAULT NULL,
  `scodigo` varchar(21) DEFAULT NULL,
  `nidubicacion` int(11) DEFAULT NULL,
  `nidreencauchadora` int(11) DEFAULT NULL,
  `tfechatienda` date DEFAULT NULL,
  `nidcondicion` tinyint(1) DEFAULT NULL,
  `tfechaentrega` date DEFAULT NULL,
  `sobservacionsalida` varchar(150) DEFAULT NULL,
  `susuario` varchar(25) DEFAULT NULL,
  `bformaestado` varchar(45) DEFAULT NULL,
  `sdocrefrencia` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tservicio`
--

INSERT INTO `tservicio` (`nidservicio`, `sidcliente`, `tfecharecepcion`, `nidbanda`, `splaca`, `sobservacioningreso`, `nidtiposervicio`, `nidmedida`, `nidmarca`, `scodigo`, `nidubicacion`, `nidreencauchadora`, `tfechatienda`, `nidcondicion`, `tfechaentrega`, `sobservacionsalida`, `susuario`, `bformaestado`, `sdocrefrencia`, `bestado`) VALUES
(1, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(2, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(3, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 1, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(4, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(5, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(7, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(8, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(9, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 4, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(10, '20600598334', '2024-10-11', 6, NULL, 'NUEVAS PRUEBAS', 3, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(11, '20600598334', '2024-10-11', 2, NULL, 'NUEVAS PRUEBAS', 6, 1, 1, NULL, 3, 4, '2024-10-19', 3, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(12, '20600598334', '2024-10-11', 3, NULL, 'NUEVAS PRUEBAS DOS', 4, 1, 1, NULL, 1, 4, '2024-10-19', 2, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(13, '20600598334', '2024-10-11', 3, NULL, 'NUEVAS PRUEBAS ULTIMAS', 2, 1, 1, NULL, 4, 2, '2024-10-19', 2, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'0'),
(14, '20600598334', '2024-10-11', 3, NULL, 'NUEVAS PRUEBAS ULTIMAS NUEVO', 2, 1, 1, NULL, 4, 2, '2024-10-19', 2, NULL, 'NUEVAS ENTREGAS', NULL, '1', NULL, b'1'),
(15, '20600598334', '2024-10-11', 3, NULL, 'NUEVO INGRESO DE NUMATICO DE VOLQUETE', 5, 1, 1, NULL, 1, 4, NULL, 2, NULL, '', NULL, '1', NULL, b'0'),
(16, '20600598334', '2024-10-11', 3, NULL, 'NUEVO INGRESO DE NUMATICO DE VOLQUETE, SE LLEVO CARLITOS', 5, 1, 1, NULL, 4, 4, NULL, 2, NULL, '', NULL, '1', NULL, b'0'),
(17, '20600598334', '2024-10-11', 3, NULL, 'NUEVO INGRESO DE NUMATICO DE VOLQUETE, SE LLEVO CARLITOS', 5, 1, 1, NULL, 4, 4, '2024-10-11', 2, NULL, 'SE ENTREGO ALCLIENTE EN HORAS DE LA TARDE', NULL, '1', NULL, b'1'),
(18, '20450551326', '2024-10-11', 4, NULL, 'LLANTA NUEVA GOODYEAR', 3, 1, 1, NULL, 4, 4, NULL, 4, NULL, '', NULL, '1', NULL, b'0'),
(19, '20450551326', '2024-10-11', 4, NULL, 'LLANTA NUEVA GOODYEAR, SE PASO AL TALLER', 3, 1, 1, NULL, 3, 3, NULL, 4, NULL, '', NULL, '1', NULL, b'0'),
(20, '20450551326', '2024-10-11', 4, NULL, 'LLANTA NUEVA GOODYEAR, SE PASO AL TALLER', 3, 1, 1, NULL, 3, 3, NULL, 4, NULL, 'SE ENTREGA LA LLANTA', NULL, '1', NULL, b'0'),
(21, '20450551326', '2024-10-11', 4, NULL, 'CLIENTE DEVOLVIO LLANTA', 3, 1, 1, NULL, 3, 3, NULL, 4, NULL, 'SE ENTREGA LA LLANTA', NULL, '1', NULL, b'0'),
(22, '20450551326', '2024-10-11', 4, NULL, 'CLIENTE DEVOLVIO LLANTA', 3, 1, 1, NULL, 3, 3, '2024-10-12', 4, NULL, 'SE CORRIGE Y SE VUELVE A ENTREGAR', NULL, '1', NULL, b'0'),
(23, '20450551326', '2024-10-11', 4, NULL, 'CLIENTE DEVOLVIO LLANTA', 3, 1, 1, NULL, 3, 3, '2024-10-12', 2, NULL, 'SE CORRIGE Y SE VUELVE A ENTREGAR, SIN EMENDADURAS', NULL, '1', NULL, b'0'),
(24, '20450551326', '2024-10-11', 4, NULL, 'CLIENTE DEVOLVIO LLANTA', 3, 1, 1, '6155253228', 3, 3, '2024-10-12', 2, NULL, 'SE CORRIGE Y SE VUELVE A ENTREGAR, SIN EMENDADURAS', NULL, '1', NULL, b'1'),
(25, '20601369886', '2024-10-12', 3, '-', '295/80R22.5', 1, 1, 1, '6148004916', 1, 2, '2024-10-18', 4, NULL, 'ASDF', NULL, '1', NULL, b'0'),
(26, '20601369886', '2024-10-12', 3, 'BHV-944', '295/80R22.5', 1, 1, 1, '6148004916', 1, 2, NULL, 4, NULL, 'ASDF', NULL, '1', NULL, b'0'),
(27, '20601369886', '2024-10-12', 3, 'BHV-944', 'NINGUNA', 1, 1, 1, '6148004916', 1, 2, NULL, 4, NULL, '', NULL, '1', NULL, b'1'),
(28, '154813155111', '2024-09-05', 7, 'BWE-855', 'SE RECOGIO DE LA VIA EXPRESA', 1, 1, 1, 'B231029018307', 1, 1, NULL, 1, NULL, 'EL CLIENTE LO RECOGIO DE LA TIENDA', NULL, '1', NULL, b'0'),
(29, '154813155111', '2024-09-05', 7, 'BWE-855', 'SE RECOGIO DE LA VIA EXPRESA', 1, 1, 1, 'B231029018307', 1, 1, NULL, 1, NULL, 'EL CLIENTE LO RECOGIO DE LA TIENDA', NULL, '1', NULL, b'0'),
(30, '154813155111', '2024-09-05', 7, 'BWE-855', 'SE RECOGIO DE LA VIA EXPRESA QWE LUCAS LUCAS', 1, 1, 1, 'B231029018307', 1, 1, '2024-10-16', 1, '2024-10-23', 'EL CLIENTE LO RECOGIO DE LA TIENDA QWE 234', NULL, '1', NULL, b'1'),
(31, '10239480689', '2024-10-14', 7, 'B7Z-929', 'PRUEBAS INGRESO CON OBCERVACIONES 13355', 3, 1, 1, 'B210712011571', 1, 2, '2024-10-10', 3, '2024-10-17', 'PRUEBAS SALIDA NUEVAMENTE', 'RENATO', '1', NULL, b'1'),
(32, '20601369886', '2024-10-16', 7, 'X2L-615', 'PRUEBAS DE USUARIO DE SESSION OKOK', 3, 1, 1, 'EEC14667', 1, 2, '2024-10-18', 4, '2024-10-19', 'PRUEBAS 123 QUE FUE NUEVOS VALORES', 'BACILIDES', '1', NULL, b'1'),
(33, '43253442', '2024-10-17', 7, 'ASD', 'ASD', 7, 1, 1, 'ASD', 1, 5, '2024-10-18', 3, '2024-10-18', 'ASD ASDASDASD', '123', '1', NULL, b'1'),
(34, '43253442', '2024-10-17', 7, 'X3L-652', 'SE RECEPCIONO COPN OBSERVACIONES 3 HUECOS', 2, 1, 1, '2309AS7173', 3, 3, '2024-10-18', 4, '2024-10-18', 'CLIENTE RECOGIO EL PEDIDO', 'RENATO', '1', NULL, b'1'),
(35, '20450551326', '2024-10-18', 3, 'S3L-154', '', 5, 1, 1, '5647DFR4E', 1, 2, NULL, 4, NULL, '', 'BACILIDES', '1', NULL, b'1'),
(36, '32565456', '2024-10-17', 6, 'QWE234', '', 4, 1, 1, '5645SD', 2, 3, '2024-10-18', 4, '2024-10-18', '', 'BACILIDES', '1', NULL, b'1'),
(37, '0778', '2024-10-18', 8, '123', '', 9, 1, 1, '123', 3, 3, '2024-10-19', 4, '2024-10-26', '', '', '1', NULL, b'1'),
(38, '123644555', '2024-10-18', 7, 'X3L-157', 'SE TRASLADO AL TALLER DE RICHAR, TUVO UN PEQUEÑO DEFECTO', 3, 1, 1, 'SDF4532112', 2, 3, '2024-10-18', 4, NULL, 'EL CLIENTE RECOGIO SU LLANTA', 'RENATO', '1', NULL, b'1'),
(39, '43253478', '2024-10-18', 7, 'XL3-456', 'SE CAMBIO DE REENCAUCHADORA', 5, 1, 1, 'ASDERE', 1, 2, NULL, 4, NULL, '', 'RENATO', '1', '', b'1'),
(40, '123644555', '2024-10-17', 7, 'ASD', 'ASD', 5, 1, 1, 'ASD', 3, 4, '2024-10-19', 4, '2024-10-24', 'ASD', 'RENATO', '1', '', b'1'),
(41, '123644555', '2024-10-26', 7, 'X3L-618', 'CORRECCION DE PLACA', 1, 2, 1, 'ASDAD', 4, 4, '2024-10-27', 3, '2024-10-27', '', 'RENATO', '0', 'ASDAS', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttiposervicio`
--

CREATE TABLE `ttiposervicio` (
  `nidtiposervicio` int(11) NOT NULL,
  `snombretiposervicio` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ttiposervicio`
--

INSERT INTO `ttiposervicio` (`nidtiposervicio`, `snombretiposervicio`, `bestado`) VALUES
(1, 'REENCAUCHE', b'1'),
(2, 'PASADADEBANDA', b'1'),
(3, 'VULCANIZADO', b'1'),
(4, 'DIBUJADA UNA', b'1'),
(5, 'CURACION', b'1'),
(6, 'GUARDAR', b'0'),
(7, 'NIEVITO', b'0'),
(8, 'PRUEBAS', b'0'),
(9, 'PRUEBAT', b'0'),
(10, 'PRUEBA16', b'0'),
(11, 'PRUEBAS16', b'0'),
(12, 'PRUEAS 1212', b'0'),
(13, 'PASADA123', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tubicacion`
--

CREATE TABLE `tubicacion` (
  `nidubicacion` int(11) NOT NULL,
  `snombretipoubicacion` varchar(45) DEFAULT NULL,
  `bestado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tubicacion`
--

INSERT INTO `tubicacion` (`nidubicacion`, `snombretipoubicacion`, `bestado`) VALUES
(1, 'TIENDA', b'1'),
(2, 'TALLER', b'1'),
(3, 'MECANICO', b'1'),
(4, 'REENCAUCHADORA', b'1'),
(5, 'PRUEBAU', b'0'),
(6, 'PRUEBAM', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuario`
--

CREATE TABLE `tusuario` (
  `nusuarioid` int(11) NOT NULL,
  `susuarionrodoc` varchar(45) DEFAULT NULL,
  `susuariotipodoc` varchar(45) DEFAULT NULL,
  `susuarionombre` varchar(45) DEFAULT NULL,
  `susuariotelefono` varchar(12) DEFAULT NULL,
  `susuariopassword` varchar(64) DEFAULT NULL,
  `nusuariotiporol` tinyint(1) DEFAULT NULL,
  `busuarioestado` bit(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tusuario`
--

INSERT INTO `tusuario` (`nusuarioid`, `susuarionrodoc`, `susuariotipodoc`, `susuarionombre`, `susuariotelefono`, `susuariopassword`, `nusuariotiporol`, `busuarioestado`, `created_at`) VALUES
(1, '43253441', '1', 'RENATO', '988850777', '$2y$10$iPtXwY3efsK/sGKHwCvnXetbP9MjT0jOx1xVf/TlpApLNZzH55Lym', 2, b'1', '2024-10-16 08:39:22'),
(2, '43253442', '1', 'BACILIDES', '988875488', '$2y$10$fvuG2ZYv4nZQUq1kNVZdgOC9Hnfl/DHxHqHDgU3uG.ae0bYdoRxFi', 1, b'1', '2024-10-16 08:47:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tauditoria`
--
ALTER TABLE `tauditoria`
  ADD PRIMARY KEY (`nidauditoria`),
  ADD KEY `nidservicio_idx` (`nidservicio`);

--
-- Indices de la tabla `tbanda`
--
ALTER TABLE `tbanda`
  ADD PRIMARY KEY (`nidbanda`);

--
-- Indices de la tabla `tcliente`
--
ALTER TABLE `tcliente`
  ADD PRIMARY KEY (`sidcliente`);

--
-- Indices de la tabla `tcondicion`
--
ALTER TABLE `tcondicion`
  ADD PRIMARY KEY (`nidcondicion`);

--
-- Indices de la tabla `tmarca`
--
ALTER TABLE `tmarca`
  ADD PRIMARY KEY (`nidmarca`);

--
-- Indices de la tabla `tmedida`
--
ALTER TABLE `tmedida`
  ADD PRIMARY KEY (`nidmedida`);

--
-- Indices de la tabla `treencauchadora`
--
ALTER TABLE `treencauchadora`
  ADD PRIMARY KEY (`nidreencauchadora`);

--
-- Indices de la tabla `tservicio`
--
ALTER TABLE `tservicio`
  ADD PRIMARY KEY (`nidservicio`),
  ADD KEY `sidcliente_idx` (`sidcliente`),
  ADD KEY `nidbanda_idx` (`nidbanda`),
  ADD KEY `idubicacion_idx` (`nidubicacion`),
  ADD KEY `nidtiposervicio_idx` (`nidtiposervicio`),
  ADD KEY `nidrencauchadora_idx` (`nidreencauchadora`),
  ADD KEY `nidcondicion_idx` (`nidcondicion`),
  ADD KEY `nidnumero_idx` (`nidmedida`),
  ADD KEY `nidmarca_idx` (`nidmarca`);

--
-- Indices de la tabla `ttiposervicio`
--
ALTER TABLE `ttiposervicio`
  ADD PRIMARY KEY (`nidtiposervicio`);

--
-- Indices de la tabla `tubicacion`
--
ALTER TABLE `tubicacion`
  ADD PRIMARY KEY (`nidubicacion`);

--
-- Indices de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD PRIMARY KEY (`nusuarioid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tauditoria`
--
ALTER TABLE `tauditoria`
  MODIFY `nidauditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `tbanda`
--
ALTER TABLE `tbanda`
  MODIFY `nidbanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tcondicion`
--
ALTER TABLE `tcondicion`
  MODIFY `nidcondicion` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tmarca`
--
ALTER TABLE `tmarca`
  MODIFY `nidmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tmedida`
--
ALTER TABLE `tmedida`
  MODIFY `nidmedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `treencauchadora`
--
ALTER TABLE `treencauchadora`
  MODIFY `nidreencauchadora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tservicio`
--
ALTER TABLE `tservicio`
  MODIFY `nidservicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `ttiposervicio`
--
ALTER TABLE `ttiposervicio`
  MODIFY `nidtiposervicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tubicacion`
--
ALTER TABLE `tubicacion`
  MODIFY `nidubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  MODIFY `nusuarioid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tauditoria`
--
ALTER TABLE `tauditoria`
  ADD CONSTRAINT `nidservicio` FOREIGN KEY (`nidservicio`) REFERENCES `tservicio` (`nidservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tservicio`
--
ALTER TABLE `tservicio`
  ADD CONSTRAINT `nidbanda` FOREIGN KEY (`nidbanda`) REFERENCES `tbanda` (`nidbanda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidcondicion` FOREIGN KEY (`nidcondicion`) REFERENCES `tcondicion` (`nidcondicion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidmarca` FOREIGN KEY (`nidmarca`) REFERENCES `tmarca` (`nidmarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidmedida` FOREIGN KEY (`nidmedida`) REFERENCES `tmedida` (`nidmedida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidreencauchadora` FOREIGN KEY (`nidreencauchadora`) REFERENCES `treencauchadora` (`nidreencauchadora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidtiposervicio` FOREIGN KEY (`nidtiposervicio`) REFERENCES `ttiposervicio` (`nidtiposervicio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nidubicacion` FOREIGN KEY (`nidubicacion`) REFERENCES `tubicacion` (`nidubicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sidcliente` FOREIGN KEY (`sidcliente`) REFERENCES `tcliente` (`sidcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
