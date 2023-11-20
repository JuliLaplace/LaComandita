-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2023 a las 22:55:33
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
  `tiempoCalculado` time DEFAULT NULL,
  `estadoProducto` varchar(20) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`id`, `codigoPedido`, `idProducto`, `tiempoCalculado`, `estadoProducto`, `fechaCreacion`, `fechaModificacion`, `fechaBaja`) VALUES
(1, '11re2', 8, '00:05:00', 'en proceso', '2023-11-15 19:32:18', '2023-11-20 21:23:17', NULL),
(2, '11re2', 8, '00:10:00', 'en proceso', '2023-11-15 19:32:28', '2023-11-20 21:25:43', NULL),
(3, 'hajs6', 8, '00:15:00', 'pendiente', '2023-11-15 19:32:33', NULL, NULL),
(4, 'hajs6', 4, '00:30:00', 'cancelado', '2023-11-16 19:32:37', NULL, '2023-11-19 01:54:21'),
(5, 'hajs6', 7, '00:09:00', 'cancelado', '2023-11-18 23:41:04', NULL, '2023-11-19 01:53:39'),
(6, '11re2', 9, NULL, 'pendiente', '2023-11-19 05:52:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `sector` int(11) NOT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `clave` varchar(20) NOT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `nombre` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `sector`, `estado`, `clave`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`, `nombre`, `usuario`) VALUES
(1, 5, '1', 'coraline', '2023-11-26', NULL, '2023-11-19 17:58:40', 'andrea', 'andrea2020'),
(2, 2, '1', '123456aa', '2023-11-26', NULL, NULL, 'esteban', 'esteban182'),
(3, 2, '1', '123456a', '2023-11-26', NULL, NULL, 'candela', 'candela564'),
(4, 3, '1', 'morty', '2023-11-26', NULL, NULL, 'julieta', 'julix404'),
(5, 4, '1', '123456ad', '2023-11-26', NULL, NULL, 'romina', 'romi1'),
(6, 5, '1', '123456a', '2023-11-26', NULL, NULL, 'juan', 'juan11'),
(7, 2, '1', 'askjhas', '2023-11-06', NULL, NULL, 'pepe', 'pepeLoco'),
(8, 5, '1', 'mortyciano', '2023-11-06', NULL, NULL, 'Morty', 'mortyman1'),
(9, 6, '1', 'effy', '2023-11-06', NULL, NULL, 'Effy', 'effyciana'),
(10, 2, '1', 'arrival', '2023-11-06', NULL, NULL, 'Gonzalo', 'gonza2020'),
(11, 1, '1', '$2y$10$XtL339RpGxqE8', '2023-11-06', NULL, NULL, 'pablo', 'pacho1'),
(12, 2, '3', '$2y$10$XYmNQtsgIy8d3', '2023-11-06', '2023-11-16 05:15:38', NULL, 'erica', 'ericavh'),
(13, 2, '3', 'pampa', '2023-11-06', '2023-11-16 05:15:38', NULL, 'erica', 'ericavh'),
(14, 6, '1', 'nomade1', '2023-11-13', NULL, NULL, 'matias', 'mattnmd'),
(15, 6, '1', 'acro123', '2023-11-13', NULL, NULL, 'florencia', 'florricci'),
(16, 1, '3', 'tc2000', '2023-11-16', '2023-11-19 18:00:35', NULL, 'nicolas', 'NicolasV');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `notaMozo` int(11) NOT NULL,
  `notaCocina` int(11) NOT NULL,
  `notaMesa` int(11) NOT NULL,
  `notaRestaurante` int(11) NOT NULL,
  `resena` varchar(66) NOT NULL,
  `codigoPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `notaMozo`, `notaCocina`, `notaMesa`, `notaRestaurante`, `resena`, `codigoPedido`) VALUES
(0, 7, 8, 4, 7, 'Esto es una prueba', 11);

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
(3, 'cancelado');

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
(10000, '5f6ah', 1, '2023-11-09 10:34:14', NULL, NULL),
(10001, 'js6dy', 1, '2023-11-08 10:34:19', NULL, '2023-11-20 19:22:59'),
(10002, '2gte4', 1, '2023-11-03 10:34:21', NULL, NULL),
(10003, 'a5sg3', 1, '2023-11-16 16:02:32', NULL, NULL),
(10004, 'ase23', 1, '2023-11-16 16:04:06', NULL, NULL),
(10005, 'ase24', 1, '2023-11-20 19:12:38', NULL, NULL);

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
  `tiempoEstimado` time NOT NULL,
  `foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `codigoPedido`, `idCliente`, `codigoMesa`, `idEmpleado`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`, `precioFinal`, `estado`, `tiempoEstimado`, `foto`) VALUES
(1, '11re2', 1001, '5f6ah', 2, '2023-11-10 17:20:12', NULL, '2023-11-19 05:24:32', 6800.00, 2, '00:10:00', '1-11re2.jpg'),
(2, 'hajs6', 1006, 'a5sg3', 8, '2023-11-18 14:21:12', NULL, '2023-11-19 01:54:21', 2900.00, 1, '00:30:00', NULL),
(3, 'pep12', 1005, 'ase23', 8, '2023-11-18 21:19:43', NULL, NULL, 0.00, 1, '00:00:00', NULL),
(4, 'pap11', 1004, 'js6dy', 8, '2023-11-20 19:31:03', NULL, '2023-11-20 19:32:26', 0.00, 1, '00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `sector` int(11) NOT NULL,
  `tiempopreparacion` time NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `sector`, `tiempopreparacion`, `fechaCreacion`, `fechaBaja`, `fechaModificacion`) VALUES
(1, 'milanesa a caballo', 5500, 2, '00:30:00', '2023-11-09 01:53:31', NULL, '2023-11-16 06:50:13'),
(2, 'hamburguesa caballo', 3500, 2, '00:20:00', '2023-11-02 01:53:43', NULL, NULL),
(3, 'ensalada capresse', 1800, 2, '00:15:00', '2023-11-03 01:53:47', NULL, NULL),
(4, 'flan', 1500, 1, '00:30:00', '2023-11-01 01:53:51', NULL, NULL),
(5, 'helado', 1000, 1, '00:05:00', '2023-11-02 01:53:54', '2023-11-16 06:16:47', NULL),
(6, 'corona', 1700, 4, '00:09:00', '2023-11-01 01:54:06', NULL, NULL),
(7, 'stout', 1700, 4, '00:09:00', '2023-11-01 01:54:11', NULL, NULL),
(8, 'daikiri', 2900, 3, '00:15:00', '2023-11-04 01:54:13', NULL, NULL),
(9, 'papas fritas', 1000, 2, '00:05:00', '2023-11-01 01:54:16', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `estadomesa`
--
ALTER TABLE `estadomesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estadopedido`
--
ALTER TABLE `estadopedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estadousuario`
--
ALTER TABLE `estadousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10006;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
