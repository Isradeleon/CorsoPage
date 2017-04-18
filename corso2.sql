SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(45) NULL ,
  `tipo_usuario` TINYINT NOT NULL ,
  `remember_token` VARCHAR(100) NULL ,
  `movil` TINYINT(1) NOT NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
;


-- -----------------------------------------------------
-- Table `gerentes`
-- -----------------------------------------------------
CREATE  TABLE `gerentes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `ap_paterno` VARCHAR(45) NOT NULL ,
  `ap_materno` VARCHAR(45) NOT NULL ,
  `direccion` VARCHAR(100) NOT NULL ,
  `rfc` VARCHAR(45) NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `usuario_id` INT NOT NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_gerentes_usuarios1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_gerentes_usuarios1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `vendedores`
-- -----------------------------------------------------
CREATE  TABLE `vendedores` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `ap_paterno` VARCHAR(45) NOT NULL ,
  `ap_materno` VARCHAR(45) NOT NULL ,
  `direccion` VARCHAR(100) NOT NULL ,
  `rfc` VARCHAR(45) NULL ,
  `curp` VARCHAR(45) NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `contacto` VARCHAR(45) NOT NULL ,
  `usuario_id` INT NOT NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_vendedores_usuarios1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_vendedores_usuarios1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `secretarias`
-- -----------------------------------------------------
CREATE  TABLE `secretarias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `ap_paterno` VARCHAR(45) NOT NULL ,
  `ap_materno` VARCHAR(45) NOT NULL ,
  `direccion` VARCHAR(100) NOT NULL ,
  `rfc` VARCHAR(45) NULL ,
  `curp` VARCHAR(45) NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `usuario_id` INT NOT NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_secretarias_usuarios1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_secretarias_usuarios1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `clientes`
-- -----------------------------------------------------
CREATE  TABLE `clientes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `ap_paterno` VARCHAR(45) NOT NULL ,
  `ap_materno` VARCHAR(45) NOT NULL ,
  `contacto` VARCHAR(45) NOT NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
;


-- -----------------------------------------------------
-- Table `casas`
-- -----------------------------------------------------
CREATE  TABLE `casas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `numero_exterior` VARCHAR(45) NOT NULL ,
  `numero_interior` VARCHAR(45) NULL ,
  `calle_o_avenida` VARCHAR(45) NOT NULL ,
  `colonia` VARCHAR(45) NOT NULL ,
  `superficie` VARCHAR(45) NOT NULL ,
  `eje_x_mapa` VARCHAR(45) NOT NULL ,
  `eje_y_mapa` VARCHAR(45) NOT NULL ,
  `num_habitaciones` INT NOT NULL ,
  `num_banos` INT NOT NULL ,
  `detalles` VARCHAR(200) NOT NULL ,
  `precio_estimado` DECIMAL(12,2) NOT NULL ,
  `precio_evaluado` DECIMAL(12,2) NULL ,
  `fecha_ultima_evaluacion` DATE NULL ,
  `disponibilidad` TINYINT NOT NULL ,
  `ciudad` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
;


-- -----------------------------------------------------
-- Table `citas`
-- -----------------------------------------------------
CREATE  TABLE `citas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `vendedor_id` INT NOT NULL ,
  `secretaria_id` INT NOT NULL ,
  `cliente_id` INT NOT NULL ,
  `casa_id` INT NOT NULL ,
  `tipo_cita` TINYINT NOT NULL ,
  `fecha_hora` DATETIME NOT NULL ,
  `venta_docs_id` INT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `status` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_citas_vendedores1_idx` (`vendedor_id` ASC) ,
  INDEX `fk_citas_secretarias1_idx` (`secretaria_id` ASC) ,
  INDEX `fk_citas_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_citas_casas1_idx` (`casa_id` ASC) ,
  CONSTRAINT `fk_citas_vendedores1`
    FOREIGN KEY (`vendedor_id` )
    REFERENCES `vendedores` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_citas_secretarias1`
    FOREIGN KEY (`secretaria_id` )
    REFERENCES `secretarias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_citas_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_citas_casas1`
    FOREIGN KEY (`casa_id` )
    REFERENCES `casas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `notarios`
-- -----------------------------------------------------
CREATE  TABLE `notarios` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `ap_paterno` VARCHAR(45) NOT NULL ,
  `ap_materno` VARCHAR(45) NOT NULL ,
  `cedula` VARCHAR(100) NULL ,
  `deleted_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
;


-- -----------------------------------------------------
-- Table `ventas`
-- -----------------------------------------------------
CREATE  TABLE `ventas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `vendedor_id` INT NOT NULL ,
  `secretaria_id` INT NOT NULL ,
  `cliente_id` INT NOT NULL ,
  `casa_id` INT NOT NULL ,
  `tipo_pago` TINYINT NOT NULL ,
  `status` TINYINT NOT NULL ,
  `fecha_inicio` DATE NOT NULL ,
  `fecha_cierre` DATE NULL ,
  `notario_id` INT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `monto` DECIMAL(12,2) NOT NULL ,
  `monto_cubierto` DATETIME NULL ,
  `n_credito_o_banco` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ventas_vendedores1_idx` (`vendedor_id` ASC) ,
  INDEX `fk_ventas_secretarias1_idx` (`secretaria_id` ASC) ,
  INDEX `fk_ventas_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_ventas_casas1_idx` (`casa_id` ASC) ,
  INDEX `fk_ventas_notarios1_idx` (`notario_id` ASC) ,
  CONSTRAINT `fk_ventas_vendedores1`
    FOREIGN KEY (`vendedor_id` )
    REFERENCES `vendedores` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ventas_secretarias1`
    FOREIGN KEY (`secretaria_id` )
    REFERENCES `secretarias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ventas_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ventas_casas1`
    FOREIGN KEY (`casa_id` )
    REFERENCES `casas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ventas_notarios1`
    FOREIGN KEY (`notario_id` )
    REFERENCES `notarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `documentos`
-- -----------------------------------------------------
CREATE  TABLE `documentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `venta_id` INT NOT NULL ,
  `acta_nacimiento` VARCHAR(100) NULL ,
  `fecha_entrega_acta` DATE NULL ,
  `ine` VARCHAR(100) NULL ,
  `fecha_entrega_ine` DATE NULL ,
  `escrituras` VARCHAR(100) NULL ,
  `fecha_entrega_escrituras` DATE NULL ,
  INDEX `fk_documentos_ventas1_idx` (`venta_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_documentos_ventas1`
    FOREIGN KEY (`venta_id` )
    REFERENCES `ventas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `fotos_casa`
-- -----------------------------------------------------
CREATE  TABLE `fotos_casa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `string_foto` VARCHAR(100) NOT NULL ,
  `casa_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_fotos_casa_casas1_idx` (`casa_id` ASC) ,
  CONSTRAINT `fk_fotos_casa_casas1`
    FOREIGN KEY (`casa_id` )
    REFERENCES `casas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Table `datos`
-- -----------------------------------------------------
CREATE  TABLE `datos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `telefono` VARCHAR(45) NULL ,
  `correo` VARCHAR(45) NULL ,
  `facebook` VARCHAR(45) NULL ,
  `lat` VARCHAR(100) NULL ,
  `lng` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
;
