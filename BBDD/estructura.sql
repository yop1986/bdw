-- Base de datos:       dw-banco (utf8-spanish-ci)
-- Usuario/Contraseña:  usr_dwbanco / oDg3axSwtWOd3IHm

CREATE TABLE usuarios (
    id smallint UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar(60) NOT NULL,
    correo varchar(120) NOT NULL,
    telefono varchar(11) NOT NULL,
    contrasena varchar(150) NOT NULL,
    creado datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificado datetime DEFAULT NULL,
    activo tinyint(1) NOT NULL DEFAULT 0,
    grupo enum('Administrador','Cliente') NOT NULL DEFAULT 'Cliente',

    CONSTRAINT usuarios_pk_id PRIMARY KEY (id),
    CONSTRAINT usuarios_unq_correo UNIQUE (correo)
);
INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `contrasena`, `creado`, `modificado`, `activo`, `grupo`) VALUES
(1, 'Pablo Godoy', 'pablodavid36@gmail.com', '56940955', '$2y$10$wWcA6CFHg/hm1GrGJEdCcO.MCPWPWZ3QRgdnQ5jXjYeNOnc9HDCHi', '2017-09-13 23:00:49', '2017-09-13 23:07:47', 1, 'Administrador');

CREATE TABLE cuentas (
    id mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar(30) NOT NULL,
    cuenta varchar(14) NOT NULL,
    balance decimal(15,2) NOT NULL,
    reserva decimal(15,2) NOT NULL DEFAULT '0.00',
    creado datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT cuentas_pk_id PRIMARY KEY (id),
    CONSTRAINT cuentas_unq_cuenta UNIQUE (cuenta)
);
#ALTER TABLE cuentas DROP FOREIGN KEY cuentas_fk_usuario
#ALTER TABLE cuentas DROP COLUMN usuario_id
#ALTER TABLE cuentas MODIFY COLUMN cuenta varchar(14) NOT NULL

create table cuentas_usuarios (
    id mediumint unsigned not null auto_increment,
    cuenta_id mediumint unsigned not null, 
    usuario_id smallint unsigned not null,

    constraint ctausr_pk_id primary key (id),
    constraint ctausr_unq_cuenta unique(cuenta_id),
    constraint ctausr_fk_cuenta foreign key (cuenta_id) references cuentas(id),
    constraint ctausr_fk_usuario foreign key (usuario_id) references usuarios(id)
);


CREATE TABLE transacciones (
    id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    correlativo int UNSIGNED NOT NULL,
    monto decimal(15,2) NOT NULL,
    cuenta_id mediumint UNSIGNED NOT NULL,
    estado enum('Solicitado','Autorizado','Rechazado') NOT NULL,
    tipo enum('Deposito','Transferencia') NOT NULL,

    CONSTRAINT transacciones_pk_id PRIMARY KEY (id),
    CONSTRAINT transacciones_fk_cuenta FOREIGN KEY (cuenta_id) REFERENCES cuentas(id)
);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla beneficiarios
--

--  CREATE TABLE beneficiarios (
--      id int UNSIGNED NOT NULL,
--      monto_max decimal(15,2) UNSIGNED NOT NULL,
--      cant_max tinyint(3) UNSIGNED NOT NULL,
--      clave varchar(30) NOT NULL,
--      estado tinyint(1) NOT NULL DEFAULT '0',
--      usuario_id smallint UNSIGNED NOT NULL,
--      cuenta_id mediumint UNSIGNED NOT NULL
--  );
--  
--  
--  --
--  -- Indices de la tabla `beneficiarios`
--  --
--  ALTER TABLE `beneficiarios`
--    ADD PRIMARY KEY (`id`),
--    ADD KEY `beneficiarios_fk_usuario` (`usuario_id`),
--    ADD KEY `beneficiarios_fk_cuenta` (`cuenta_id`);
--
--
--  Filtros para la tabla `beneficiarios`
--
--  
--  ALTER TABLE `beneficiarios`
--    ADD CONSTRAINT `beneficiarios_fk_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`id`),
--    ADD CONSTRAINT `beneficiarios_fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
