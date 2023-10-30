-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-10-2023 a las 12:08:50
-- Versión del servidor: 8.0.26-0ubuntu0.20.04.2
-- Versión de PHP: 8.0.10

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

--
-- Volcado de datos para la tabla `subscription`
--

INSERT INTO `subscription` (`public_id`, `private_id`, `alias`) VALUES
('b649ea9f-73f0-11ee-97d1-0242ac110002', 'b649eaee-73f0-11ee-97d1-0242ac110002', 'admin'),
('be0efd8e-73f2-11ee-97d1-0242ac110002', 'be0efe14-73f2-11ee-97d1-0242ac110002', 'admin'),
('f9cb17b0-7436-11ee-9b3c-0242ac110002', 'f9cb183b-7436-11ee-9b3c-0242ac110002', 'admin'),
('7d0d4fca-73ef-11ee-97d1-0242ac110002', '7d0d501c-73ef-11ee-97d1-0242ac110002', 'usuario');

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
  `tiempo_modificacion` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `switch`
--

INSERT INTO `switch` (`public_id`, `private_id`, `alias`, `nombre`, `estado`, `tiempo_modificacion`) VALUES
('7d0d4fca-73ef-11ee-97d1-0242ac110002', '7d0d501c-73ef-11ee-97d1-0242ac110002', 'admin', 'Primer switch', 0, '2023-10-26 11:04:52'),
('b649ea9f-73f0-11ee-97d1-0242ac110002', 'b649eaee-73f0-11ee-97d1-0242ac110002', 'usuario', 'Segundo switch', 0, '2023-10-26 11:13:38'),
('be0efd8e-73f2-11ee-97d1-0242ac110002', 'be0efe14-73f2-11ee-97d1-0242ac110002', 'usuario', 'Tercer switch', 1, '2023-10-26 11:28:10'),
('f9cb17b0-7436-11ee-9b3c-0242ac110002', 'f9cb183b-7436-11ee-9b3c-0242ac110002', 'usuario', 'PRUEBA', 0, '2023-10-26 19:36:36');

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
  ADD CONSTRAINT `fk_subscription_switch` FOREIGN KEY (`public_id`,`private_id`) REFERENCES `switch` (`public_id`, `private_id`),
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
