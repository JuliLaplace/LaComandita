-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2023 a las 22:07:46
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_comandita`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`) VALUES
(1001, 'Julieta'),
(1002, 'Matias'),
(1003, 'Juan'),
(1004, 'Ariel'),
(1005, 'Victoria'),
(1006, 'Esteban');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `id` int(11) NOT NULL,
  `codigoPedido` varchar(5) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `tiempoCalculado` time DEFAULT NULL,
  `estadoProducto` varchar(20) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`id`, `codigoPedido`, `idProducto`, `cantidad`, `tiempoCalculado`, `estadoProducto`, `fechaCreacion`, `fechaModificacion`, `fechaBaja`) VALUES
(1, '11re2', 8, 0, '00:05:00', 'finalizado', '2023-11-15 19:32:18', '2023-11-20 21:23:17', NULL),
(2, '11re2', 8, 0, '00:10:00', 'finalizado', '2023-11-15 19:32:28', '2023-11-20 21:25:43', NULL),
(3, 'hajs6', 8, 0, '00:15:00', 'finalizado', '2023-11-15 19:32:33', NULL, NULL),
(4, 'hajs6', 4, 0, '00:30:00', 'cancelado', '2023-11-16 19:32:37', NULL, '2023-11-19 01:54:21'),
(5, 'hajs6', 7, 0, '00:09:00', 'cancelado', '2023-11-18 23:41:04', NULL, '2023-11-19 01:53:39'),
(6, '11re2', 9, 0, NULL, 'finalizado', '2023-11-19 05:52:52', NULL, NULL),
(7, '1111', 1, 1, NULL, 'finalizado', '2023-12-03 19:15:52', NULL, NULL),
(8, '1111', 1, 1, NULL, 'finalizado', '2023-12-03 19:31:50', NULL, NULL),
(9, '1111', 1, 1, NULL, 'finalizado', '2023-12-03 19:46:24', NULL, NULL),
(10, '1234', 1, 1, NULL, 'finalizado', '2023-12-03 19:57:21', NULL, NULL),
(11, '1234', 2, 2, NULL, 'finalizado', '2023-12-03 19:58:04', NULL, NULL),
(12, '12345', 6, 1, '00:20:00', 'finalizado', '2023-12-03 19:58:22', '2023-12-03 20:38:14', NULL),
(13, '12345', 8, 1, '00:10:00', 'finalizado', '2023-12-03 19:58:54', '2023-12-03 21:43:30', NULL),
(14, '1234', 8, 1, NULL, 'finalizado', '2023-12-03 19:59:53', NULL, NULL),
(15, '12121', 8, 1, NULL, 'finalizado', '2023-12-03 20:00:23', NULL, NULL),
(16, '12121', 8, 1, NULL, 'finalizado', '2023-12-03 20:00:52', NULL, NULL),
(17, '12121', 8, 1, NULL, 'finalizado', '2023-12-03 22:27:15', NULL, NULL),
(18, 'ped13', 1, 1, NULL, 'finalizado', '2023-12-04 14:44:17', NULL, NULL),
(19, 'ped3', 2, 2, NULL, 'finalizado', '2023-12-04 14:45:03', NULL, NULL),
(20, 'ped1', 6, 1, '00:24:00', 'finalizado', '2023-12-04 14:45:16', '2023-12-05 04:16:21', NULL),
(21, 'ped1', 8, 1, '00:20:00', 'finalizado', '2023-12-04 14:45:24', '2023-12-05 04:17:11', NULL),
(22, 'laaaa', 8, 1, '00:20:00', 'finalizado', '2023-12-05 00:33:14', '2023-12-05 03:40:18', NULL),
(28, 'ped3', 8, 1, NULL, 'finalizado', '2023-12-05 15:41:42', NULL, NULL),
(29, 'ped3', 8, 1, NULL, 'finalizado', '2023-12-05 15:41:59', NULL, NULL),
(30, 'p1', 8, 1, '00:30:00', 'finalizado', '2023-12-05 16:38:56', '2023-12-05 18:01:27', NULL),
(31, 'p1', 1, 1, '00:10:00', 'finalizado', '2023-12-05 16:41:14', '2023-12-05 18:01:27', NULL),
(32, 'p1', 6, 1, '00:38:00', 'finalizado', '2023-12-05 16:41:47', '2023-12-05 18:01:27', NULL),
(33, 'p1', 2, 2, '00:50:00', 'finalizado', '2023-12-05 16:42:07', '2023-12-05 18:01:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `sector` int(11) NOT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `clave` varchar(20) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `nombre` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `sector`, `estado`, `clave`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`, `nombre`, `usuario`) VALUES
(1, 6, '1', 'michis', '2023-12-01 20:52:49', NULL, NULL, 'Julieta', 'Julix404'),
(2, 6, '1', 'nomade', '2023-12-13 00:00:00', NULL, NULL, 'Matias', 'MattNmd'),
(3, 6, '1', 'caballo', '2023-12-13 00:00:00', NULL, NULL, 'Erica', 'EricaVH'),
(4, 5, '1', 'sobrecitos', '2023-12-13 00:00:00', NULL, NULL, 'Effy', 'Effyciana'),
(5, 4, '1', 'whiskas', '2023-12-13 00:00:00', NULL, NULL, 'Morty', 'Mortyman'),
(6, 3, '1', 'portal', '2023-12-13 00:00:00', NULL, NULL, 'Rick', 'RickSanchez'),
(7, 2, '1', 'vino', '2023-12-13 00:00:00', NULL, NULL, 'Beth', 'BethSanchez'),
(8, 1, '1', 'telefono', '2023-12-13 00:00:00', NULL, NULL, 'Summer', 'SummerSmith');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `resena` varchar(66) NOT NULL,
  `codigoPedido` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `nota`, `resena`, `codigoPedido`) VALUES
(1, 7, 'Esto es una prueba', '11'),
(2, 8, 'Hola', '12345'),
(6, 4, 'Todo horrible jeje', 'p1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadomesa`
--

CREATE TABLE `estadomesa` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadomesa`
--

INSERT INTO `estadomesa` (`id`, `estado`) VALUES
(1, 'con cliente esperando pedido'),
(2, 'con cliente comiendo'),
(3, 'con cliente pagando'),
(4, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadopedido`
--

CREATE TABLE `estadopedido` (
  `id` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadopedido`
--

INSERT INTO `estadopedido` (`id`, `estado`) VALUES
(1, 'en proceso'),
(2, 'finalizado'),
(3, 'cancelado'),
(4, 'iniciado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadousuario`
--

CREATE TABLE `estadousuario` (
  `id` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadousuario`
--

INSERT INTO `estadousuario` (`id`, `estado`) VALUES
(1, 'activo'),
(2, 'suspendido'),
(3, 'eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `metodo` varchar(20) NOT NULL,
  `url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `usuario`, `fecha`, `metodo`, `url`) VALUES
(1, 'Julix404', '2023-12-05 14:10:54', 'POST', '/auth/login'),
(2, 'Julix404', '2023-12-05 14:13:49', 'POST', '/auth/login'),
(3, 'anonimo', '2023-12-05 14:43:18', 'POST', '/cliente/espera'),
(4, 'anonimo', '2023-12-05 14:43:39', 'GET', '/pedidos/'),
(5, 'anonimo', '2023-12-05 14:44:01', 'POST', '/auth/login'),
(6, 'anonimo', '2023-12-05 14:44:17', 'GET', '/pedidos/'),
(7, 'anonimo', '2023-12-05 14:50:33', 'GET', '/pedidos/'),
(8, 'anonimo', '2023-12-05 14:52:55', 'GET', '/pedidos/'),
(9, 'anonimo', '2023-12-05 14:53:08', 'GET', '/mesa_mas_usada'),
(10, 'anonimo', '2023-12-05 14:57:34', 'GET', '/mesa_mas_usada'),
(11, 'anonimo', '2023-12-05 14:57:51', 'POST', '/auth/login'),
(12, 'anonimo', '2023-12-05 14:58:07', 'GET', '/mesa_mas_usada'),
(13, 'anonimo', '2023-12-05 14:58:57', 'GET', '/mesa_mas_usada'),
(14, 'anonimo', '2023-12-05 15:00:49', 'GET', '/mesa_mas_usada'),
(15, 'anonimo', '2023-12-05 15:01:17', 'GET', '/mesa_mas_usada'),
(16, 'anonimo', '2023-12-05 15:48:31', 'POST', '/auth/login'),
(17, 'anonimo', '2023-12-05 15:49:39', 'POST', '/auth/login'),
(18, 'anonimo', '2023-12-05 15:52:15', 'POST', '/auth/login'),
(19, 'anonimo', '2023-12-05 15:54:24', 'POST', '/auth/login'),
(20, 'anonimo', '2023-12-05 15:55:06', 'POST', '/auth/login'),
(21, 'anonimo', '2023-12-05 16:01:54', 'GET', '/listar_mesas'),
(22, 'anonimo', '2023-12-05 16:02:40', 'GET', '/listar_mesas'),
(23, 'anonimo', '2023-12-05 16:03:51', 'GET', '/listar_mesas'),
(24, 'Julix404', '2023-12-05 16:04:46', 'GET', '/listar_mesas'),
(25, 'Julix404', '2023-12-05 16:05:40', 'GET', '/encuesta/tres_mejores'),
(26, 'Julix404', '2023-12-05 16:06:03', 'GET', '/encuesta/tres_mejores'),
(27, 'anonimo', '2023-12-05 16:09:00', 'POST', '/auth/login'),
(28, 'Effyciana', '2023-12-05 16:10:50', 'POST', '/pedidos/foto'),
(29, 'Julix404', '2023-12-05 16:11:12', 'GET', '/mesa_mas_usada'),
(30, 'Effyciana', '2023-12-05 16:12:17', 'POST', '/pedidos/foto'),
(31, 'anonimo', '2023-12-05 16:19:34', 'POST', '/auth/login'),
(32, 'Effyciana', '2023-12-05 16:21:37', 'POST', '/pedidos/pedir'),
(33, 'Effyciana', '2023-12-05 16:23:57', 'POST', '/pedidos/pedir'),
(34, 'Effyciana', '2023-12-05 16:24:13', 'POST', '/pedidos/pedir'),
(35, 'Effyciana', '2023-12-05 16:24:44', 'POST', '/pedidos/pedir'),
(36, 'Effyciana', '2023-12-05 16:38:56', 'POST', '/pedidos/pedido'),
(37, 'Effyciana', '2023-12-05 16:41:14', 'POST', '/pedidos/pedido'),
(38, 'Effyciana', '2023-12-05 16:41:47', 'POST', '/pedidos/pedido'),
(39, 'Effyciana', '2023-12-05 16:42:07', 'POST', '/pedidos/pedido'),
(40, 'Effyciana', '2023-12-05 16:43:31', 'POST', '/pedidos/foto'),
(41, 'Effyciana', '2023-12-05 16:43:50', 'GET', '/pedidos/detalles/listar/bar'),
(42, 'anonimo', '2023-12-05 16:45:04', 'POST', '/auth/login'),
(43, 'RickSanchez', '2023-12-05 16:46:19', 'GET', '/pedidos/detalles/listar/bar'),
(44, 'RickSanchez', '2023-12-05 16:46:58', 'GET', '/pedidos/detalles/listar/bar'),
(45, 'RickSanchez', '2023-12-05 16:47:17', 'GET', '/pedidos/detalles/listar/cocina'),
(46, 'anonimo', '2023-12-05 16:48:18', 'POST', '/auth/login'),
(47, 'BethSanchez', '2023-12-05 16:48:27', 'GET', '/pedidos/detalles/listar/cocina'),
(48, 'BethSanchez', '2023-12-05 16:49:21', 'GET', '/pedidos/detalles/listar/candy'),
(49, 'anonimo', '2023-12-05 16:49:24', 'POST', '/auth/login'),
(50, 'SummerSmith', '2023-12-05 16:49:35', 'GET', '/pedidos/detalles/listar/candy'),
(51, 'SummerSmith', '2023-12-05 16:50:34', 'GET', '/pedidos/detalles/listar/cerveza'),
(52, 'anonimo', '2023-12-05 16:50:40', 'POST', '/auth/login'),
(53, 'Mortyman', '2023-12-05 16:50:50', 'GET', '/pedidos/detalles/listar/cerveza'),
(54, 'Mortyman', '2023-12-05 16:55:44', 'POST', '/pedidos/detalles/estado_preparacion'),
(55, 'Mortyman', '2023-12-05 16:56:50', 'POST', '/pedidos/detalles/estado_preparacion'),
(56, 'Mortyman', '2023-12-05 16:58:31', 'POST', '/pedidos/detalles/estado_preparacion'),
(57, 'Mortyman', '2023-12-05 16:58:46', 'POST', '/pedidos/detalles/estado_preparacion'),
(58, 'Mortyman', '2023-12-05 17:01:50', 'POST', '/pedidos/detalles/estado_preparacion'),
(59, 'Mortyman', '2023-12-05 17:04:55', 'POST', '/pedidos/detalles/estado_preparacion'),
(60, 'Mortyman', '2023-12-05 17:05:07', 'POST', '/pedidos/detalles/estado_preparacion'),
(61, 'Mortyman', '2023-12-05 17:05:35', 'POST', '/pedidos/detalles/estado_preparacion'),
(62, 'Mortyman', '2023-12-05 17:07:34', 'POST', '/pedidos/detalles/estado_preparacion'),
(63, 'Mortyman', '2023-12-05 17:07:40', 'POST', '/pedidos/detalles/estado_preparacion'),
(64, 'anonimo', '2023-12-05 17:08:18', 'POST', '/cliente/espera'),
(65, 'anonimo', '2023-12-05 17:08:29', 'POST', '/cliente/espera'),
(66, 'anonimo', '2023-12-05 17:08:57', 'POST', '/cliente/espera'),
(67, 'anonimo', '2023-12-05 17:09:06', 'POST', '/cliente/espera'),
(68, 'anonimo', '2023-12-05 17:21:44', 'POST', '/cliente/espera'),
(69, 'anonimo', '2023-12-05 17:25:42', 'GET', '/pedidos/'),
(70, 'anonimo', '2023-12-05 17:25:53', 'POST', '/auth/login'),
(71, 'Effyciana', '2023-12-05 17:26:02', 'GET', '/pedidos/'),
(72, 'Effyciana', '2023-12-05 17:28:19', 'POST', '/pedidos/demora'),
(73, 'Effyciana', '2023-12-05 17:28:33', 'POST', '/pedidos/demora'),
(74, 'Effyciana', '2023-12-05 17:34:42', 'POST', '/pedidos/demora'),
(75, 'Effyciana', '2023-12-05 17:37:11', 'POST', '/pedidos/demora'),
(76, 'anonimo', '2023-12-05 17:38:47', 'POST', '/auth/login'),
(77, 'Effyciana', '2023-12-05 17:38:49', 'POST', '/pedidos/demora'),
(78, 'Effyciana', '2023-12-05 17:39:05', 'POST', '/pedidos/demora'),
(79, 'anonimo', '2023-12-05 17:39:09', 'POST', '/auth/login'),
(80, 'Julix404', '2023-12-05 17:39:19', 'POST', '/pedidos/demora'),
(81, 'Julix404', '2023-12-05 17:41:32', 'POST', '/pedidos/demora'),
(82, 'anonimo', '2023-12-05 17:43:47', 'POST', '/pedidos/detalles/estado_listo'),
(83, 'anonimo', '2023-12-05 17:46:51', 'POST', '/pedidos/detalles/estado_listo'),
(84, 'anonimo', '2023-12-05 17:47:26', 'POST', '/pedidos/detalles/estado_listo'),
(85, 'anonimo', '2023-12-05 17:47:43', 'POST', '/pedidos/detalles/estado_listo'),
(86, 'anonimo', '2023-12-05 17:48:01', 'POST', '/pedidos/detalles/estado_listo'),
(87, 'anonimo', '2023-12-05 17:48:24', 'POST', '/pedidos/detalles/estado_listo'),
(88, 'anonimo', '2023-12-05 17:49:22', 'POST', '/pedidos/detalles/estado_listo'),
(89, 'anonimo', '2023-12-05 17:49:32', 'POST', '/pedidos/detalles/estado_listo'),
(90, 'anonimo', '2023-12-05 17:49:41', 'POST', '/pedidos/detalles/estado_listo'),
(91, 'anonimo', '2023-12-05 17:50:08', 'POST', '/pedidos/servir'),
(92, 'anonimo', '2023-12-05 17:50:15', 'POST', '/auth/login'),
(93, 'Effyciana', '2023-12-05 17:50:29', 'POST', '/pedidos/servir'),
(94, 'Effyciana', '2023-12-05 17:50:34', 'POST', '/pedidos/servir'),
(95, 'Effyciana', '2023-12-05 17:51:11', 'POST', '/pedidos/servir'),
(96, 'Julix404', '2023-12-05 17:53:29', 'GET', '/listar_mesas'),
(97, 'Effyciana', '2023-12-05 17:54:14', 'GET', '/listar_mesas'),
(98, 'anonimo', '2023-12-05 17:55:24', 'POST', '/pedidos/pagando'),
(99, 'anonimo', '2023-12-05 17:55:34', 'POST', '/auth/login'),
(100, 'Julix404', '2023-12-05 17:55:46', 'POST', '/pedidos/pagando'),
(101, 'anonimo', '2023-12-05 17:55:49', 'POST', '/auth/login'),
(102, 'Effyciana', '2023-12-05 17:56:01', 'POST', '/pedidos/pagando'),
(103, 'Effyciana', '2023-12-05 17:56:26', 'PUT', '/mesas/modificar'),
(104, 'Julix404', '2023-12-05 17:56:39', 'PUT', '/mesas/modificar'),
(105, 'Julix404', '2023-12-05 18:00:57', 'PUT', '/mesas/modificar'),
(106, 'Effyciana', '2023-12-05 18:01:27', 'POST', '/pedidos/pagando'),
(107, 'Julix404', '2023-12-05 18:01:35', 'PUT', '/mesas/modificar'),
(108, 'anonimo', '2023-12-05 18:01:41', 'POST', '/cliente/encuesta'),
(109, 'anonimo', '2023-12-05 18:01:56', 'POST', '/cliente/encuesta'),
(110, 'anonimo', '2023-12-05 18:03:23', 'POST', '/cliente/encuesta'),
(111, 'Julix404', '2023-12-05 18:03:39', 'GET', '/encuesta/tres_mejores'),
(112, 'anonimo', '2023-12-05 18:04:00', 'GET', '/encuesta/tres_mejores'),
(113, 'anonimo', '2023-12-05 18:04:05', 'POST', '/auth/login'),
(114, 'Julix404', '2023-12-05 18:04:12', 'GET', '/encuesta/tres_mejores'),
(115, 'Julix404', '2023-12-05 18:04:35', 'GET', '/encuesta/tres_mejores'),
(116, 'anonimo', '2023-12-05 18:04:47', 'GET', '/mesa_mas_usada'),
(117, 'Julix404', '2023-12-05 18:04:51', 'GET', '/mesa_mas_usada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(5) UNSIGNED NOT NULL,
  `codigoMesa` varchar(5) NOT NULL,
  `estado` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigoMesa`, `estado`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`) VALUES
(10000, 'mesa0', 4, '2023-11-09 10:34:14', NULL, NULL),
(10001, 'mesa2', 4, '2023-11-08 10:34:19', NULL, '2023-11-20 19:22:59'),
(10002, 'mesa3', 4, '2023-11-03 10:34:21', NULL, NULL),
(10003, 'mesa4', 4, '2023-11-16 16:02:32', NULL, NULL),
(10004, 'mesa5', 4, '2023-11-16 16:04:06', NULL, '2023-12-05 04:32:25'),
(10005, 'mesa6', 4, '2023-11-20 19:12:38', NULL, NULL),
(10006, 'mesa1', 4, '2023-12-04 12:32:46', NULL, '2023-12-05 18:01:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `codigoPedido` varchar(5) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `codigoMesa` varchar(5) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `precioFinal` decimal(10,2) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `tiempoEstimado` time DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `codigoPedido`, `idCliente`, `codigoMesa`, `idEmpleado`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`, `precioFinal`, `estado`, `tiempoEstimado`, `foto`) VALUES
(1, '11re2', 1001, 'mesa0', 2, '2023-11-10 17:20:12', NULL, '2023-12-03 07:16:06', 6800.00, 2, '00:10:00', '1-11re2.jpg'),
(2, 'hajs6', 1006, 'mesa1', 8, '2023-11-18 14:21:12', NULL, '2023-11-19 01:54:21', 2900.00, 2, '00:30:00', NULL),
(3, 'pep12', 1005, 'mesa2', 8, '2023-11-18 21:19:43', NULL, NULL, 0.00, 2, NULL, NULL),
(4, 'pap11', 1004, 'mesa3', 8, '2023-11-20 19:31:03', NULL, '2023-11-20 19:32:26', 0.00, 2, NULL, NULL),
(5, 'lalal', 1005, 'mesa4', 4, '2023-12-02 19:59:09', NULL, NULL, 0.00, 2, NULL, NULL),
(6, 'laaaa', 1006, 'mesa5', 4, '2023-12-03 05:11:28', NULL, NULL, 2900.00, 2, '00:20:00', NULL),
(7, '12345', 1001, 'mesa6', 4, '2023-12-03 19:39:40', NULL, NULL, 5800.00, 2, '00:20:00', '7-12345.jpg'),
(8, 'ped1', 1001, 'mesa1', 4, '2023-12-04 14:41:28', NULL, NULL, 17100.00, 2, '00:24:00', NULL),
(9, 'ped2', 1001, 'mesa6', 4, '2023-12-05 00:34:04', NULL, NULL, 0.00, 2, NULL, NULL),
(10, 'ped2', 1001, 'mesa6', 4, '2023-12-05 00:47:00', NULL, NULL, 0.00, 2, NULL, NULL),
(11, 'ped2', 1001, 'mesa5', 4, '2023-12-05 00:47:18', NULL, NULL, 0.00, 2, NULL, NULL),
(12, 'ped2', 1001, 'mesa6', 4, '2023-12-05 00:49:29', NULL, NULL, 0.00, 2, NULL, NULL),
(13, 'ped2', 1001, 'mesa1', 4, '2023-12-05 01:23:34', NULL, NULL, 0.00, 2, NULL, NULL),
(14, 'ped2', 1001, 'mesa2', 4, '2023-12-05 01:24:39', NULL, NULL, 0.00, 2, NULL, NULL),
(15, 'ped2', 1001, 'mesa6', 4, '2023-12-05 01:39:04', NULL, NULL, 0.00, 2, NULL, NULL),
(19, 'ped3', 1001, 'mesa4', 4, '2023-12-05 02:10:37', NULL, NULL, 5800.00, 2, '00:30:00', '19-ped3.jpg'),
(28, 'p1', 1001, 'mesa1', 4, '2023-12-05 16:24:44', NULL, NULL, 17100.00, 2, '00:50:00', '28-p1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `sector` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `sector`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`) VALUES
(1, 'milanesa a caballo', 5500, 2, '2023-12-03 18:41:02', NULL, NULL),
(2, 'hamburguesa de garbanzo', 3500, 2, '2023-12-03 18:41:02', NULL, NULL),
(3, 'ensalada capresse', 1800, 2, '2023-12-03 18:41:02', NULL, NULL),
(4, 'flan', 1500, 1, '2023-12-03 18:41:02', NULL, NULL),
(5, 'helado', 1000, 1, '2023-12-03 18:41:03', NULL, NULL),
(6, 'corona', 1700, 4, '2023-12-03 18:41:03', NULL, NULL),
(7, 'stout', 1700, 4, '2023-12-03 18:41:03', NULL, NULL),
(8, 'daikiri', 2900, 3, '2023-12-03 18:41:03', NULL, NULL),
(9, 'papas fritas', 1500, 2, '2023-12-03 18:41:03', NULL, NULL),
(10, 'tiramisu', 2000, 1, '2023-12-03 18:41:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `id` int(11) NOT NULL,
  `sector` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`id`, `sector`) VALUES
(1, 'candybar'),
(2, 'cocina'),
(3, 'barra'),
(4, 'cerveceria'),
(5, 'salon'),
(6, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`id`, `tipo`) VALUES
(1, 'socio'),
(2, 'mozo'),
(3, 'bartender'),
(4, 'coinero'),
(5, 'cervecero'),
(6, 'candyman');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadomesa`
--
ALTER TABLE `estadomesa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadopedido`
--
ALTER TABLE `estadopedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadousuario`
--
ALTER TABLE `estadousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estadomesa`
--
ALTER TABLE `estadomesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estadopedido`
--
ALTER TABLE `estadopedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estadousuario`
--
ALTER TABLE `estadousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10007;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
