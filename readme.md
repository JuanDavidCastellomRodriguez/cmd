# Proyecto Corporación Minuto de Dios - Goepark

Para cambios realizados en la estructura de la base de datos
por favor escribir aqui fecha y escritp de actualización


#27/03/2017
```mysql
alter table habitaciones add id_tipo_visita int(11) not null;
alter table unidades_sanitarias add id_tipo_visita int(11) not null;
alter table cocinas add id_tipo_visita int(11) not null;


```

#30/03/2017
```mysql
DROP TABLE IF EXISTS `orden_servicios`;

CREATE TABLE `orden_servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consecutivo` int(11) NOT NULL,
  `observaciones` varchar(200) NOT NULL DEFAULT '',
  `presupuesto` double(11,0) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_orden_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#___________________________________
DROP TABLE IF EXISTS `fases`;

CREATE TABLE `fases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_orden_servicio` int(11) NOT NULL,
  `nombre_fase` int(11) NOT NULL,
  `id_vereda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `observaciones` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fase_orden_servicio` (`id_orden_servicio`),
  KEY `fk_fases_usuarios` (`id_usuario`),
  KEY `fk_fase_vereda` (`id_vereda`),
  CONSTRAINT `fk_fase_vereda` FOREIGN KEY (`id_vereda`) REFERENCES `veredas` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `fk_fases_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `fk_fase_orden_servicio` FOREIGN KEY (`id_orden_servicio`) REFERENCES `orden_servicios` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#________________________
ALTER TABLE subsidios CHANGE id_vereda id_fase INT(11);


```


