# CadastroCRUD
A simple User register in pure PHP + Javascript

SQL to create table:
```sql
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome do usuário',
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Sobrenome do usuário',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação',
  `update_date` timestamp NULL DEFAULT NULL COMMENT 'Data de atualização',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `user_group` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Grupo de usuários',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação',
  `update_date` timestamp NULL DEFAULT NULL COMMENT 'Data de atualização',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `user_has_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `user_id` int(11) NOT NULL COMMENT ' Id do usuário (tabela: user)',
  `group_id` int(11) NOT NULL COMMENT 'Id do grupo (tabela: user_group)',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação',
  `update_date` timestamp NULL DEFAULT NULL COMMENT 'Data de atualização',
  PRIMARY KEY (`id`),
  KEY `user_has_group_user_FK` (`user_id`),
  KEY `user_has_group_user_group_FK` (`group_id`),
  CONSTRAINT `user_has_group_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user_has_group_user_group_FK` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
```
