CREATE TABLE `act_area`  (
  `idarea` int NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idarea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_categoria_actividad`  (
  `idcategoria_actividad` int NOT NULL AUTO_INCREMENT,
  `nombre_c` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idcategoria_actividad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_dependencia`  (
  `id_dependencia` int NOT NULL AUTO_INCREMENT,
  `nombre_dep` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_dependencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_estado`  (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_medio_solicitud`  (
  `idmedio_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_solicitud` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmedio_solicitud`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_periodo`  (
  `id_periodo` int NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `pe_estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  PRIMARY KEY (`id_periodo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_registro`  (
  `idregistro` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nro_carta` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fec_atencion` date NULL DEFAULT NULL,
  `detalle_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fec_registro` date NULL DEFAULT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tipo_doc` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_dependencia` int NOT NULL,
  `id_solicitante` int NOT NULL,
  `idmedio_solicitud` int NOT NULL,
  `id_tipo_asistencia` int NOT NULL,
  `idcategoria_actividad` int NOT NULL,
  `id_estado` int NOT NULL,
  `id_periodo` int NOT NULL,
  `id_usuario` int NULL,
  PRIMARY KEY (`idregistro`) USING BTREE,
  INDEX `fk_registro_categoria_actividad1`(`idcategoria_actividad` ASC) USING BTREE,
  INDEX `fk_registro_dependencia1`(`id_dependencia` ASC) USING BTREE,
  INDEX `fk_registro_estado1`(`id_estado` ASC) USING BTREE,
  INDEX `fk_registro_medio_solicitud1`(`idmedio_solicitud` ASC) USING BTREE,
  INDEX `fk_registro_periodo1`(`id_periodo` ASC) USING BTREE,
  INDEX `fk_registro_solicitante1`(`id_solicitante` ASC) USING BTREE,
  INDEX `fk_registro_tipo_asistencia1`(`id_tipo_asistencia` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_solicitante`  (
  `id_solicitante` int NOT NULL AUTO_INCREMENT,
  `nombre_solicitante` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `dni_solicitante` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cargo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_solicitante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `act_tipo_asistencia`  (
  `id_tipo_asistencia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_asistencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `automatizar`  (
  `idautomatizar` int NOT NULL AUTO_INCREMENT,
  `descripcionautomatizar` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fechaautomatizar` date NOT NULL,
  `estadoautomatizar` tinyint NOT NULL DEFAULT 1,
  PRIMARY KEY (`idautomatizar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

CREATE TABLE `modulo`  (
  `id_modulo` int NOT NULL AUTO_INCREMENT,
  `nombremodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `urlmodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idmodulopadre` int NULL DEFAULT NULL,
  `iconomodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estadomodulo` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_modulo`) USING BTREE,
  INDEX `idmodulopadre`(`idmodulopadre` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `perfil`  (
  `id_perfil` int NOT NULL AUTO_INCREMENT,
  `nombreperfil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estadoperfil` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_perfil`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `permiso`  (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `idperfilpermiso` int NULL DEFAULT NULL,
  `idmodulo` int NULL DEFAULT NULL,
  `estadopermiso` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_permiso`) USING BTREE,
  INDEX `fk_permiso_perfil`(`idperfilpermiso` ASC) USING BTREE,
  INDEX `permiso_idmodulo`(`idmodulo` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 436 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `responsables`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `siaf_correlativo`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `correlativo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `tb_siaf`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `comprobante_pago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expediente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipo_giro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `partida_especifica` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `monto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_pase` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orden_compra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orden_servicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `planilla_viatico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `recibo_honorarios` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `exp_sgd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `asunto_sgd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `observacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_tramite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `tipo_giro`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_giro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `usuario`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `clave` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  `dni` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idperfil_usuario` int NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_clave` int NOT NULL DEFAULT 0,
  `fecha_clave` date NULL DEFAULT NULL,
  `ultimo_login` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `idarea` int NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  INDEX `id_perfil`(`idperfil_usuario` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1087 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_1` FOREIGN KEY (`idcategoria_actividad`) REFERENCES `act_categoria_actividad` (`idcategoria_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_2` FOREIGN KEY (`id_dependencia`) REFERENCES `act_dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `act_estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_4` FOREIGN KEY (`idmedio_solicitud`) REFERENCES `act_medio_solicitud` (`idmedio_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_5` FOREIGN KEY (`id_periodo`) REFERENCES `act_periodo` (`id_periodo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_6` FOREIGN KEY (`id_solicitante`) REFERENCES `act_solicitante` (`id_solicitante`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `act_registro_ibfk_7` FOREIGN KEY (`id_tipo_asistencia`) REFERENCES `act_tipo_asistencia` (`id_tipo_asistencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `act_registro` ADD CONSTRAINT `usario_registro` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `modulo` ADD CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`idmodulopadre`) REFERENCES `modulo` (`id_modulo`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `permiso` ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`idperfilpermiso`) REFERENCES `perfil` (`id_perfil`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `permiso` ADD CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id_modulo`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `usuario` ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idperfil_usuario`) REFERENCES `perfil` (`id_perfil`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `usuario` ADD CONSTRAINT `area_usuario` FOREIGN KEY (`idarea`) REFERENCES `act_area` (`idarea`) ON DELETE NO ACTION ON UPDATE NO ACTION;

