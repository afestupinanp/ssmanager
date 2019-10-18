-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2017 a las 03:01:04
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ssmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(24) DEFAULT NULL,
  `realname` text NOT NULL,
  `pswd` varchar(150) DEFAULT NULL,
  `identificacion` int(11) NOT NULL,
  `recuperacion` varchar(50) NOT NULL,
  `permission` int(1) DEFAULT '1',
  `description` varchar(1500) NOT NULL DEFAULT 'Hola, esta es la descripción de tu perfil.',
  `role` varchar(25) NOT NULL DEFAULT 'Miembro',
  `color` varchar(8) NOT NULL DEFAULT '#17750c',
  `gradedirector` varchar(5) NOT NULL DEFAULT 'Null',
  `changepswd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `realname`, `pswd`, `identificacion`, `recuperacion`, `permission`, `description`, `role`, `color`, `gradedirector`, `changepswd`) VALUES
(1, 'jheraldoc', 'José Heraldo Criollo López', 'admin', 10000000, 'test@testmail.com', 2, 'Un saludo de paz y bien. Soy el coordinador académico del Colegio San Francisco de Asís. Espero que tengan un buen día y que Dios les acompañe.', 'Administrador', '#4d9fdd', '', 0),
(2, 'gpatriciaa', 'Gloria Patricia Alzate', 'admin', 10000001, 'test2@testmail.com', 2, 'Un saludo de paz y bien a todos y a todas. Mi nombre es Gloria Patricia Alzate, soy la coordinadora disciplinaria del Colegio San Francisco de Asís. Una gran comunidad te espera. Matrículas abiertas ya.', 'Administradora', '#7e1f89', '', 0),
(3, 'jcarlosj', 'Juan Carlos Jaramillo', 'teacher', 10000002, 'test3@testmail.com', 1, 'Buenas a todos. Mi nombre es Juan Carlos Jaramillo, docente de Desarrollo de Software y Diseño Gráfico, con más de 10 años de experiencia en el Colegio San Francisco de Asís. Un saludo para todos.', 'Docente', '#000000', '11-A', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dates`
--

CREATE TABLE `dates` (
  `cita` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(7) NOT NULL,
  `teacher` varchar(50) NOT NULL,
  `message` varchar(1200) NOT NULL DEFAULT 'No se ha específicado ningún mensaje.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `daymess`
--

CREATE TABLE `daymess` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txt` varchar(1500) DEFAULT NULL,
  `teacher` varchar(50) DEFAULT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `daymess`
--

INSERT INTO `daymess` (`id`, `txt`, `teacher`, `type`) VALUES
(1, '', '', 1),
(2, '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Grado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grades`
--

INSERT INTO `grades` (`id`, `Grado`) VALUES
(1, '11-A'),
(2, '11-B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observator`
--

CREATE TABLE `observator` (
  `observationid` bigint(20) UNSIGNED NOT NULL,
  `cod_student` int(11) DEFAULT NULL,
  `observationteacher` varchar(50) DEFAULT NULL,
  `observationdate` varchar(50) DEFAULT NULL,
  `observations` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `cod_student` bigint(20) UNSIGNED NOT NULL,
  `student` varchar(50) DEFAULT NULL,
  `grado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`cod_student`, `student`, `grado`) VALUES
(1, 'Andrés Felipe Estupiñán Peláez', '11-A'),
(2, 'Carlos Morales Ramírez', '11-A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dates`
--
ALTER TABLE `dates`
  ADD UNIQUE KEY `cita` (`cita`);

--
-- Indices de la tabla `daymess`
--
ALTER TABLE `daymess`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`Grado`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `observator`
--
ALTER TABLE `observator`
  ADD PRIMARY KEY (`observationid`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`cod_student`),
  ADD UNIQUE KEY `cod_student` (`cod_student`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `dates`
--
ALTER TABLE `dates`
  MODIFY `cita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `daymess`
--
ALTER TABLE `daymess`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `observator`
--
ALTER TABLE `observator`
  MODIFY `observationid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `cod_student` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
