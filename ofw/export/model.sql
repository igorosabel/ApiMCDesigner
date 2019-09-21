/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave única de cada usuario',
  `user` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de usuario',
  `pass` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contraseña cifrada del usuario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `level` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave única de cada nivel de un diseño',
  `id_design` INT(11) NOT NULL COMMENT 'Id del diseño al que pertenece el nivel',
  `name` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del nivel',
  `height` INT(11) NOT NULL DEFAULT '1' COMMENT 'Altura o piso del nivel dentro del diseño',
  `data` TEXT NULL COMMENT 'Datos del diseño del nivel',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `note` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave única de cada nota',
  `id_level` INT(11) NOT NULL COMMENT 'Id del nivel donde va la nota',
  `pos_x` INT(11) NOT NULL DEFAULT '1' COMMENT 'Posición X de la nota',
  `pos_y` INT(11) NOT NULL DEFAULT '1' COMMENT 'Posición Y de la nota',
  `data` TEXT NULL COMMENT 'Contenido de la nota',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `design` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave única de cada diseño',
  `id_user` INT(11) NOT NULL COMMENT 'Id del usuario que hace el diseño',
  `name` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del diseño',
  `slug` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre del diseño',
  `size_x` INT(11) NOT NULL DEFAULT '0' COMMENT 'Anchura del diseño',
  `size_y` INT(11) NOT NULL DEFAULT '0' COMMENT 'Altura del diseño',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `level`
  ADD KEY `fk_level_design_idx` (`id_design`),
  ADD CONSTRAINT `fk_level_design` FOREIGN KEY (`id_design`) REFERENCES `design` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `note`
  ADD KEY `fk_note_level_idx` (`id_level`),
  ADD CONSTRAINT `fk_note_level` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `design`
  ADD KEY `fk_design_user_idx` (`id_user`),
  ADD CONSTRAINT `fk_design_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
