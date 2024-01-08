-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-10-2023 a las 13:01:36
-- Versión del servidor: 8.0.26-0ubuntu0.20.04.2
-- Versión de PHP: 8.0.10
create database tswblog;

CREATE USER 'tswuser'@'localhost' IDENTIFIED BY 'tswblogpass';
GRANT ALL PRIVILEGES ON tswblog.* TO 'tswuser'@'localhost' WITH GRANT OPTION;
use tswblog;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tswblog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscription`
--

CREATE TABLE `subscription` (
  `public_id` varchar(50) NOT NULL,
  `private_id` varchar(50) NOT NULL,
  `alias` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `switch`
--

CREATE TABLE `switch` (
  `public_id` varchar(50) NOT NULL,
  `private_id` varchar(50) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` int DEFAULT '0',
  `descripcion` varchar(400) DEFAULT NULL,
  `tiempo_modificacion` timestamp NULL DEFAULT NULL,
  `encendido_hasta` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `switch`
--

INSERT INTO `switch` (`public_id`, `private_id`, `alias`, `nombre`, `estado`, `descripcion`, `tiempo_modificacion`, `encendido_hasta`) VALUES
('9a928291-77dc-11ee-bd78-0242ac110002', '9a9282de-77dc-11ee-bd78-0242ac110002', 'admin', 'Prueba 2', 1, 'DESCRIPCION', '2023-10-31 11:43:26', '2023-10-31 13:13:26'),
('ad913e6f-77dc-11ee-bd78-0242ac110002', 'ad913ef3-77dc-11ee-bd78-0242ac110002', 'admin', 'Prueba 1', 1, '', '2023-10-31 11:25:51', '2023-10-31 12:54:51'),
('b649ea9f-73f0-11ee-97d1-0242ac110002', 'b649eaee-73f0-11ee-97d1-0242ac110002', 'usuario', 'Segundo switch', 1, NULL, '2023-10-31 11:25:51', '2023-10-31 12:54:51'),
('be0efd8e-73f2-11ee-97d1-0242ac110002', 'be0efe14-73f2-11ee-97d1-0242ac110002', 'usuario', 'Tercer switch', 1, NULL, '2023-10-31 11:25:51', '2023-10-31 12:54:51'),
('f9cb17b0-7436-11ee-9b3c-0242ac110002', 'f9cb183b-7436-11ee-9b3c-0242ac110002', 'usuario', 'PRUEBA', 1, NULL, '2023-10-31 11:25:51', '2023-10-31 12:54:51');

--
-- Disparadores `switch`
--
DELIMITER $$
CREATE TRIGGER `switch_id_generator` BEFORE INSERT ON `switch` FOR EACH ROW BEGIN
    -- Generar valores aleatorios para public_id y private_id
    SET NEW.public_id = UUID();
    SET NEW.private_id = UUID();
    SET NEW.estado = 0;
    SET NEW.tiempo_modificacion = CURRENT_TIMESTAMP();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `passwd`, `email`) VALUES
('admin', 'admin', 'admin@gmail.com'),
('user1', 'user1', 'user1@gmail.com'),
('usuario', 'usuario', 'usuario@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`public_id`,`private_id`,`alias`),
  ADD KEY `fk_subscription_user` (`alias`);

--
-- Indices de la tabla `switch`
--
ALTER TABLE `switch`
  ADD PRIMARY KEY (`public_id`,`private_id`,`alias`),
  ADD KEY `fk_switch` (`alias`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `fk_subscription_switch` FOREIGN KEY (`public_id`,`private_id`) REFERENCES `switch` (`public_id`, `private_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subscription_user` FOREIGN KEY (`alias`) REFERENCES `users` (`username`);

--
-- Filtros para la tabla `switch`
--
ALTER TABLE `switch`
  ADD CONSTRAINT `fk_switch` FOREIGN KEY (`alias`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
