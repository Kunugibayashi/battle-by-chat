CREATE TABLE `sessions` (
  `id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` blob,
  `expires` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat_characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(7) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '#ffffff',
  `backgroundcolor` varchar(7) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '#000000',
  `tag` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`),
  CONSTRAINT `chat_characters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `send_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `chat_character_key` int(10) unsigned NOT NULL,
  `chat_character_fullname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `to_chat_character_key` int(10) unsigned NOT NULL,
  `to_chat_character_fullname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_character_id` (`to_chat_character_key`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `send_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `received_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `chat_character_key` int(10) unsigned NOT NULL,
  `chat_character_fullname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `from_chat_character_key` int(10) unsigned NOT NULL,
  `from_chat_character_fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_character_id` (`from_chat_character_key`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `received_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `informations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `detail` text COLLATE utf8mb4_general_ci NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat_rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `information` varchar(1023) COLLATE utf8mb4_general_ci NOT NULL,
  `published` int(1) unsigned NOT NULL DEFAULT '1',
  `readonly` int(1) unsigned NOT NULL DEFAULT '1',
  `displayno` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_key` char(40) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `chat_room_key` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_room_title` varchar(15) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `chat_room_information` varchar(1023) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(7) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inherit',
  `backgroundcolor` varchar(11) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'transparent',
  `chat_character_key` int(10) unsigned NOT NULL DEFAULT '0',
  `fullname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_entry_key` (`entry_key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat_log_warehouses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_key` char(40) COLLATE utf8mb4_general_ci NOT NULL,
  `chat_room_title` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `characters` text COLLATE utf8mb4_general_ci,
  `logs` longtext COLLATE utf8mb4_general_ci,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_room_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `chat_character_id` int(10) unsigned NOT NULL,
  `entry_key` char(40) COLLATE utf8mb4_general_ci NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_entries_ibuk_1` (`chat_character_id`),
  KEY `chat_roomid` (`chat_room_id`),
  KEY `userid` (`user_id`),
  CONSTRAINT `chat_entries_ibfk_1` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chat_entries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chat_entries_ibfk_3` FOREIGN KEY (`chat_character_id`) REFERENCES `chat_characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `battle_turns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vs_fukoku_key` int(10) unsigned NOT NULL DEFAULT '0',
  `vs_before_key` int(10) unsigned NOT NULL,
  `vs_after_key` int(10) unsigned NOT NULL,
  `battle_status` int(4) unsigned NOT NULL,
  `battle_turn_count` int(8) unsigned NOT NULL DEFAULT '0',
  `attack_chat_character_key` int(10) unsigned NOT NULL DEFAULT '0',
  `defense_chat_character_key` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `battle_save_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `battle_turn_id` int(10) unsigned NOT NULL,
  `chat_character_id` int(10) unsigned NOT NULL,
  `enemy_chat_character_key` int(10) unsigned DEFAULT NULL,
  `limit_skill_code` int(10) unsigned NOT NULL,
  `passive_skill_code` int(10) unsigned NOT NULL,
  `battle_skill1_code` int(10) unsigned NOT NULL,
  `battle_skill2_code` int(10) unsigned NOT NULL,
  `battle_skill3_code` int(10) unsigned NOT NULL,
  `battle_skill4_code` int(10) unsigned NOT NULL,
  `battle_skill5_code` int(10) unsigned NOT NULL,
  `battle_skill6_code` int(10) unsigned NOT NULL,
  `battle_skill7_code` int(10) unsigned NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `battle_turn_id` (`battle_turn_id`),
  CONSTRAINT `battle_save_skills_ibfk_1` FOREIGN KEY (`battle_turn_id`) REFERENCES `battle_turns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `battle_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_log_id` int(10) unsigned NOT NULL,
  `status` text COLLATE utf8mb4_general_ci,
  `narration` text COLLATE utf8mb4_general_ci,
  `memo` text COLLATE utf8mb4_general_ci,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_log_id` (`chat_log_id`),
  CONSTRAINT `battle_logs_ibfk_1` FOREIGN KEY (`chat_log_id`) REFERENCES `chat_logs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `battle_characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `battle_turn_id` int(10) unsigned NOT NULL,
  `chat_character_id` int(10) unsigned NOT NULL,
  `strength` int(4) unsigned NOT NULL,
  `dexterity` int(4) unsigned NOT NULL,
  `stamina` int(4) unsigned NOT NULL,
  `spirit` int(4) unsigned NOT NULL,
  `hp` int(11) NOT NULL,
  `sp` int(11) NOT NULL,
  `combo` int(11) NOT NULL DEFAULT '0',
  `continuous_turn_count` int(2) unsigned NOT NULL DEFAULT '0',
  `is_limit` int(1) NOT NULL DEFAULT '0',
  `limit_skill_code` int(10) unsigned NOT NULL DEFAULT '0',
  `permanent_strength` int(4) unsigned NOT NULL DEFAULT '0',
  `temporary_strength` int(4) unsigned NOT NULL DEFAULT '0',
  `permanent_hit_rate` int(8) unsigned NOT NULL DEFAULT '0',
  `temporary_hit_rate` int(8) unsigned NOT NULL DEFAULT '0',
  `permanent_dodge_rate` int(8) unsigned NOT NULL DEFAULT '0',
  `temporary_dodge_rate` int(8) unsigned NOT NULL DEFAULT '0',
  `defense_skill_code` int(10) unsigned NOT NULL DEFAULT '0',
  `defense_skill_attribute` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_character_id` (`chat_character_id`),
  KEY `battle_turn_id` (`battle_turn_id`),
  CONSTRAINT `battle_characters_ibfk_1` FOREIGN KEY (`chat_character_id`) REFERENCES `chat_characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `battle_characters_ibfk_2` FOREIGN KEY (`battle_turn_id`) REFERENCES `battle_turns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `battle_character_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_character_id` int(10) unsigned NOT NULL,
  `level` int(4) unsigned NOT NULL DEFAULT '0',
  `strength` int(4) unsigned NOT NULL DEFAULT '0',
  `dexterity` int(4) unsigned NOT NULL DEFAULT '0',
  `stamina` int(4) unsigned NOT NULL DEFAULT '0',
  `spirit` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `chat_character_id` (`chat_character_id`),
  CONSTRAINT `battle_character_statuses_ibfk_1` FOREIGN KEY (`chat_character_id`) REFERENCES `chat_characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
