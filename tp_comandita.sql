-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2023 a las 16:11:50
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
(1006, 'Laura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `id` int(11) NOT NULL,
  `codigopedido` varchar(5) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `tiempocalculado` time DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`id`, `codigopedido`, `idproducto`, `tiempocalculado`, `estado`) VALUES
(1, '11re2', 4, '-00:00:01', 1),
(2, '11re2', 8, '-00:00:01', 1);

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
  `codigomesa` varchar(5) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigomesa`, `estado`) VALUES
(10000, '5f6ah', 1),
(10001, 'js6dy', 5),
(10002, '2gte4', 5);

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
  `fecha` datetime DEFAULT NULL,
  `precioFinal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `codigoPedido`, `idCliente`, `codigoMesa`, `idEmpleado`, `fecha`, `precioFinal`) VALUES
(1, '11re2', 1001, '5f6ah', 2, '2023-11-10 17:20:12', 4400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `sector` int(11) NOT NULL,
  `tiempopreparacion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `sector`, `tiempopreparacion`) VALUES
(1, 'milanesa napolitana', 5000, 2, '00:40:00'),
(2, 'pizza fugazzeta', 3500, 2, '00:20:00'),
(3, 'ensalada capresse', 1800, 2, '00:15:00'),
(4, 'flan', 1500, 1, '00:30:00'),
(5, 'helado', 1000, 1, '00:05:00'),
(6, 'Golden', 1700, 4, '00:09:00'),
(7, 'Stout', 1700, 4, '00:09:00'),
(8, 'daikiri', 2900, 3, '00:15:00'),
(9, 'papas fritas', 1000, 2, '00:05:00');

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
(4, 'cerveceria');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `nombre` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `estado`, `clave`, `fechaCreacion`, `nombre`, `usuario`) VALUES
(1, 1, '1', '123456', '2023-11-26', 'andrea', 'andrea2020'),
(2, 2, '1', '123456aa', '2023-11-26', 'esteban', 'esteban182'),
(3, 2, '1', '123456a', '2023-11-26', 'candela', 'candela564'),
(4, 3, '1', '123456cv', '2023-11-26', 'julieta', 'julix404'),
(5, 4, '1', '123456ad', '2023-11-26', 'romina', 'romi1'),
(6, 5, '1', '123456a', '2023-11-26', 'juan', 'juan'),
(7, 2, '1', 'askjhas', '2023-11-06', 'pepe', 'pepe'),
(8, 5, '1', 'mortyciano', '2023-11-06', 'Morty', 'mortyman'),
(9, 6, '1', 'effy', '2023-11-06', 'Effy', 'effyciana'),
(10, 2, '1', 'arrival', '2023-11-06', 'Gonzalo', 'gonza2020'),
(11, 1, '1', '$2y$10$XtL339RpGxqE8', '2023-11-06', 'pablo', 'pacho1'),
(12, 2, '3', '$2y$10$XYmNQtsgIy8d3', '2023-11-06', 'erica', 'ericavh'),
(13, 2, '3', 'pampa', '2023-11-06', 'erica', 'ericavh');

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10003;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;