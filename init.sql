CREATE TABLE `administrador` (
    `id_admin` int(11) NOT NULL, `nombre_completo` varchar(100) NOT NULL, `nombre_admin` varchar(60) NOT NULL, `clave` text NOT NULL, `email_admin` varchar(100) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO
    `administrador` (
        `id_admin`, `nombre_completo`, `nombre_admin`, `clave`, `email_admin`
    )
VALUES (
        1, 'Super Administrador', 'Administrador', '2a2e9a58102784ca18e2605a4e727b5f', 'administrador@gmail.com'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
    `id_cliente` int(11) NOT NULL, `nombre_completo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL, `nombre_usuario` varchar(100) COLLATE utf8_spanish2_ci NOT NULL, `email_cliente` varchar(100) COLLATE utf8_spanish2_ci NOT NULL, `clave` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
    `id` int(11) NOT NULL, `fecha` varchar(30) COLLATE utf8_spanish2_ci NOT NULL, `serie` varchar(100) COLLATE utf8_spanish2_ci NOT NULL, `estado_ticket` varchar(60) COLLATE utf8_spanish2_ci NOT NULL, `nombre_usuario` varchar(20) COLLATE utf8_spanish2_ci NOT NULL, `email_cliente` varchar(60) COLLATE utf8_spanish2_ci NOT NULL, `departamento` varchar(70) COLLATE utf8_spanish2_ci NOT NULL, `asunto` varchar(70) COLLATE utf8_spanish2_ci NOT NULL, `mensaje` text COLLATE utf8_spanish2_ci NOT NULL, `solucion` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
ADD PRIMARY KEY (`id_admin`),
ADD UNIQUE KEY `correo` (`email_admin`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
ADD PRIMARY KEY (`id_cliente`),
ADD UNIQUE KEY `id_num` (`email_cliente`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `serie` (`serie`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 2;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

-- Crear tabla de productos
CREATE TABLE `producto` (
    `id_producto` int(11) NOT NULL AUTO_INCREMENT, `nombre` varchar(100) NOT NULL, `stock` int(11) NOT NULL, PRIMARY KEY (`id_producto`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

-- Insert statements for product table
INSERT INTO `producto` (`nombre`, `stock`) VALUES ('Tinta HP', 50);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Tinta Epson', 30);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Tinta Canon', 20);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Tinta Brother', 40);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Tinta Lexmark', 15);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Marca Real 1', 10);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Marca Real 2', 5);

INSERT INTO
    `producto` (`nombre`, `stock`)
VALUES ('Marca Real 3', 25);

INSERT INTO `producto` (`nombre`, `stock`) VALUES ('Teclado', 100);

INSERT INTO `producto` (`nombre`, `stock`) VALUES ('Mouse', 80);