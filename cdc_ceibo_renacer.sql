-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2021 a las 19:08:59
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cdc_ceibo_renacer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manzana`
--

CREATE TABLE `manzana` (
  `id_manzana` int(11) NOT NULL,
  `id_sector` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `morador`
--

CREATE TABLE `morador` (
  `id_morador` int(11) NOT NULL,
  `id_vivienda` int(11) NOT NULL,
  `id_parentesco` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `morador`
--
DELIMITER $$
CREATE TRIGGER `tr_updRegistradosVivienda` AFTER INSERT ON `morador` FOR EACH ROW BEGIN
        UPDATE vivienda SET i_registrados = i_registrados + 1
        WHERE vivienda.id_vivienda = NEW.id_vivienda;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentesco`
--

CREATE TABLE `parentesco` (
  `id_parentesco` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `id_sector` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vivienda`
--

CREATE TABLE `vivienda` (
  `id_vivienda` int(11) NOT NULL,
  `id_manzana` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `n_integrantes` int(11) NOT NULL,
  `i_registrados` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `manzana`
--
ALTER TABLE `manzana`
  ADD PRIMARY KEY (`id_manzana`),
  ADD KEY `id_sector` (`id_sector`);

--
-- Indices de la tabla `morador`
--
ALTER TABLE `morador`
  ADD PRIMARY KEY (`id_morador`),
  ADD KEY `id_vivienda` (`id_vivienda`),
  ADD KEY `id_parentesco` (`id_parentesco`);

--
-- Indices de la tabla `parentesco`
--
ALTER TABLE `parentesco`
  ADD PRIMARY KEY (`id_parentesco`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id_sector`);

--
-- Indices de la tabla `vivienda`
--
ALTER TABLE `vivienda`
  ADD PRIMARY KEY (`id_vivienda`),
  ADD KEY `id_manzana` (`id_manzana`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `manzana`
--
ALTER TABLE `manzana`
  MODIFY `id_manzana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `morador`
--
ALTER TABLE `morador`
  MODIFY `id_morador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parentesco`
--
ALTER TABLE `parentesco`
  MODIFY `id_parentesco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `id_sector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vivienda`
--
ALTER TABLE `vivienda`
  MODIFY `id_vivienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `manzana`
--
ALTER TABLE `manzana`
  ADD CONSTRAINT `manzana_ibfk_1` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id_sector`);

--
-- Filtros para la tabla `morador`
--
ALTER TABLE `morador`
  ADD CONSTRAINT `morador_ibfk_1` FOREIGN KEY (`id_vivienda`) REFERENCES `vivienda` (`id_vivienda`),
  ADD CONSTRAINT `morador_ibfk_2` FOREIGN KEY (`id_parentesco`) REFERENCES `parentesco` (`id_parentesco`);

--
-- Filtros para la tabla `vivienda`
--
ALTER TABLE `vivienda`
  ADD CONSTRAINT `vivienda_ibfk_1` FOREIGN KEY (`id_manzana`) REFERENCES `manzana` (`id_manzana`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
