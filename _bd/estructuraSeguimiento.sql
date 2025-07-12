-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2025 a las 17:31:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicios_consulta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id_carpeta` int(11) NOT NULL,
  `nombre_carpeta` varchar(100) NOT NULL,
  `id_carpeta_padre` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_fuente` int(11) DEFAULT NULL,
  `id_meta` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `codigo_categoria` varchar(20) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_de_costos`
--

CREATE TABLE `centro_de_costos` (
  `idCentro` int(11) NOT NULL,
  `codigocen` varchar(50) NOT NULL,
  `nombrecen` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1 COMMENT '1: Activo, 0: Inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id_certificado` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `codigo_transaccion` varchar(20) DEFAULT NULL,
  `fecha` date NOT NULL,
  `detalle` text DEFAULT NULL,
  `modificacion` decimal(15,2) DEFAULT 0.00,
  `certificacion_monto` decimal(15,2) DEFAULT 0.00,
  `certificacion_rebaja` decimal(15,2) DEFAULT 0.00,
  `certificacion_ampliacion` decimal(15,2) DEFAULT 0.00,
  `estado` tinyint(1) DEFAULT 1,
  `id_centro_costos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificadores`
--

CREATE TABLE `clasificadores` (
  `id_clasificador` int(11) NOT NULL,
  `codigo_clasificador` varchar(20) NOT NULL,
  `nombre_clasificador` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglose`
--

CREATE TABLE `desglose` (
  `nombre_desglose` varchar(100) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_fuente` int(11) NOT NULL,
  `id_meta` int(11) NOT NULL,
  `id_centro_costos` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_seguimiento`
--

CREATE TABLE `detalle_seguimiento` (
  `id_detalle` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_fuente` int(11) DEFAULT NULL,
  `id_meta` int(11) DEFAULT NULL,
  `id_clasificador` int(11) DEFAULT NULL,
  `PIA` decimal(15,2) DEFAULT 0.00,
  `estado` tinyint(1) DEFAULT 1,
  `PIM` decimal(15,2) DEFAULT 0.00,
  `PIM_acumulado` decimal(15,2) DEFAULT 0.00,
  `certificado_acumulado` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuentes_financiamiento`
--

CREATE TABLE `fuentes_financiamiento` (
  `id_fuente` int(11) NOT NULL,
  `codigo_fuente` varchar(20) NOT NULL,
  `nombre_fuente` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicializaciones_presupuestales`
--

CREATE TABLE `inicializaciones_presupuestales` (
  `id_inicializacion` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_fuente` int(11) NOT NULL,
  `id_meta` int(11) NOT NULL,
  `id_clasificador` int(11) NOT NULL,
  `id_centro_costos` int(11) NOT NULL,
  `valor_pia` decimal(18,2) DEFAULT 0.00,
  `valor_pim` decimal(18,2) DEFAULT 0.00,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

CREATE TABLE `metas` (
  `id_meta` int(11) NOT NULL,
  `codigo_meta` varchar(20) NOT NULL,
  `nombre_meta` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `codigo_actividad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pim_iniciales`
--

CREATE TABLE `pim_iniciales` (
  `id_pim_inicial` int(11) NOT NULL,
  `id_certificado` int(11) NOT NULL,
  `id_centro_costos` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_fuente` int(11) NOT NULL,
  `id_meta` int(11) NOT NULL,
  `id_clasificador` int(11) NOT NULL,
  `monto_pim` decimal(18,2) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas_presupuestales`
--

CREATE TABLE `programas_presupuestales` (
  `id_programa` int(11) NOT NULL,
  `codigo_programa` varchar(20) NOT NULL,
  `nombre_programa` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id_carpeta`),
  ADD KEY `id_carpeta_padre` (`id_carpeta_padre`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_fuente` (`id_fuente`),
  ADD KEY `id_meta` (`id_meta`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `codigo_categoria` (`codigo_categoria`);

--
-- Indices de la tabla `centro_de_costos`
--
ALTER TABLE `centro_de_costos`
  ADD PRIMARY KEY (`idCentro`);

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id_certificado`),
  ADD UNIQUE KEY `codigo_transaccion` (`codigo_transaccion`,`fecha`),
  ADD KEY `id_detalle` (`id_detalle`),
  ADD KEY `fk_id_centro_costos` (`id_centro_costos`);

--
-- Indices de la tabla `clasificadores`
--
ALTER TABLE `clasificadores`
  ADD PRIMARY KEY (`id_clasificador`),
  ADD UNIQUE KEY `codigo_clasificador` (`codigo_clasificador`);

--
-- Indices de la tabla `desglose`
--
ALTER TABLE `desglose`
  ADD PRIMARY KEY (`id_categoria`,`id_programa`,`id_fuente`,`id_meta`,`id_centro_costos`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_fuente` (`id_fuente`),
  ADD KEY `id_meta` (`id_meta`),
  ADD KEY `id_centro_costos` (`id_centro_costos`);

--
-- Indices de la tabla `detalle_seguimiento`
--
ALTER TABLE `detalle_seguimiento`
  ADD PRIMARY KEY (`id_detalle`),
  ADD UNIQUE KEY `id_categoria` (`id_categoria`,`id_programa`,`id_fuente`,`id_meta`,`id_clasificador`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_fuente` (`id_fuente`),
  ADD KEY `id_meta` (`id_meta`),
  ADD KEY `id_clasificador` (`id_clasificador`);

--
-- Indices de la tabla `fuentes_financiamiento`
--
ALTER TABLE `fuentes_financiamiento`
  ADD PRIMARY KEY (`id_fuente`),
  ADD UNIQUE KEY `codigo_fuente` (`codigo_fuente`);

--
-- Indices de la tabla `inicializaciones_presupuestales`
--
ALTER TABLE `inicializaciones_presupuestales`
  ADD PRIMARY KEY (`id_inicializacion`);

--
-- Indices de la tabla `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id_meta`),
  ADD UNIQUE KEY `codigo_meta` (`codigo_meta`);

--
-- Indices de la tabla `pim_iniciales`
--
ALTER TABLE `pim_iniciales`
  ADD PRIMARY KEY (`id_pim_inicial`),
  ADD KEY `fk_certificado` (`id_certificado`),
  ADD KEY `fk_centro_costos` (`id_centro_costos`);

--
-- Indices de la tabla `programas_presupuestales`
--
ALTER TABLE `programas_presupuestales`
  ADD PRIMARY KEY (`id_programa`),
  ADD UNIQUE KEY `codigo_programa` (`codigo_programa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id_carpeta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centro_de_costos`
--
ALTER TABLE `centro_de_costos`
  MODIFY `idCentro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasificadores`
--
ALTER TABLE `clasificadores`
  MODIFY `id_clasificador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_seguimiento`
--
ALTER TABLE `detalle_seguimiento`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fuentes_financiamiento`
--
ALTER TABLE `fuentes_financiamiento`
  MODIFY `id_fuente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inicializaciones_presupuestales`
--
ALTER TABLE `inicializaciones_presupuestales`
  MODIFY `id_inicializacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metas`
--
ALTER TABLE `metas`
  MODIFY `id_meta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pim_iniciales`
--
ALTER TABLE `pim_iniciales`
  MODIFY `id_pim_inicial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas_presupuestales`
--
ALTER TABLE `programas_presupuestales`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD CONSTRAINT `carpetas_ibfk_1` FOREIGN KEY (`id_carpeta_padre`) REFERENCES `carpetas` (`id_carpeta`) ON DELETE CASCADE,
  ADD CONSTRAINT `carpetas_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL,
  ADD CONSTRAINT `carpetas_ibfk_3` FOREIGN KEY (`id_programa`) REFERENCES `programas_presupuestales` (`id_programa`) ON DELETE SET NULL,
  ADD CONSTRAINT `carpetas_ibfk_4` FOREIGN KEY (`id_fuente`) REFERENCES `fuentes_financiamiento` (`id_fuente`) ON DELETE SET NULL,
  ADD CONSTRAINT `carpetas_ibfk_5` FOREIGN KEY (`id_meta`) REFERENCES `metas` (`id_meta`) ON DELETE SET NULL;

--
-- Filtros para la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `certificados_ibfk_1` FOREIGN KEY (`id_detalle`) REFERENCES `detalle_seguimiento` (`id_detalle`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_centro_costos` FOREIGN KEY (`id_centro_costos`) REFERENCES `centro_de_costos` (`idCentro`);

--
-- Filtros para la tabla `desglose`
--
ALTER TABLE `desglose`
  ADD CONSTRAINT `desglose_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `desglose_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programas_presupuestales` (`id_programa`),
  ADD CONSTRAINT `desglose_ibfk_3` FOREIGN KEY (`id_fuente`) REFERENCES `fuentes_financiamiento` (`id_fuente`),
  ADD CONSTRAINT `desglose_ibfk_4` FOREIGN KEY (`id_meta`) REFERENCES `metas` (`id_meta`),
  ADD CONSTRAINT `desglose_ibfk_5` FOREIGN KEY (`id_centro_costos`) REFERENCES `centro_de_costos` (`idCentro`);

--
-- Filtros para la tabla `detalle_seguimiento`
--
ALTER TABLE `detalle_seguimiento`
  ADD CONSTRAINT `detalle_seguimiento_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_seguimiento_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programas_presupuestales` (`id_programa`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_seguimiento_ibfk_3` FOREIGN KEY (`id_fuente`) REFERENCES `fuentes_financiamiento` (`id_fuente`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_seguimiento_ibfk_4` FOREIGN KEY (`id_meta`) REFERENCES `metas` (`id_meta`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_seguimiento_ibfk_5` FOREIGN KEY (`id_clasificador`) REFERENCES `clasificadores` (`id_clasificador`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pim_iniciales`
--
ALTER TABLE `pim_iniciales`
  ADD CONSTRAINT `fk_centro_costos` FOREIGN KEY (`id_centro_costos`) REFERENCES `centro_de_costos` (`idCentro`),
  ADD CONSTRAINT `fk_certificado` FOREIGN KEY (`id_certificado`) REFERENCES `certificados` (`id_certificado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
