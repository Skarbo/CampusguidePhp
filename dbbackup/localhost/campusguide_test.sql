-- Wed, 03 Oct 2012 17:03:22 GMT
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
-- Dumping database structure for campusguide_test
DROP DATABASE IF EXISTS `campusguide_test`;
CREATE DATABASE `campusguide_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `campusguide_test`;


-- Dumping structure for table campusguide_test.building
DROP TABLE IF EXISTS `building`;
CREATE TABLE `building` (
  `building_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `facility_id` smallint(6) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `building_coordinates` text NOT NULL,
  `building_address` varchar(255) DEFAULT NULL COMMENT 'Address: streetname, city, postal, country',
  `building_location` varchar(255) DEFAULT NULL COMMENT 'Address GPS location',
  `building_position` varchar(255) DEFAULT NULL COMMENT '4 GPS positions: center, topleft, topright, bottomright',
  `building_updated` datetime DEFAULT NULL,
  `building_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`building_id`),
  KEY `facility_id` (`facility_id`),
  CONSTRAINT `FK_BUILDING_FACILITY` FOREIGN KEY (`facility_id`) REFERENCES `facility` (`facility_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=486 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.building_element
DROP TABLE IF EXISTS `building_element`;
CREATE TABLE `building_element` (
  `element_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `floor_id` smallint(6) NOT NULL,
  `section_id` smallint(6) DEFAULT NULL,
  `element_type` varchar(50) NOT NULL DEFAULT '' COMMENT 'Predefined',
  `element_type_group` varchar(50) NOT NULL DEFAULT '' COMMENT 'Predefined',
  `element_name` varchar(255) NOT NULL,
  `element_coordinates` text NOT NULL,
  `element_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `element_updated` datetime DEFAULT NULL,
  `element_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`element_id`),
  KEY `section_id` (`section_id`),
  KEY `floor_id` (`floor_id`),
  CONSTRAINT `FK_ELEMENT_FLOOR` FOREIGN KEY (`floor_id`) REFERENCES `building_floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ELEMENT_SECTION` FOREIGN KEY (`section_id`) REFERENCES `building_section` (`section_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_element: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.building_element_type
DROP TABLE IF EXISTS `building_element_type`;
CREATE TABLE `building_element_type` (
  `type_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `type_group_id` smallint(6) DEFAULT NULL,
  `type_icon` varchar(255) DEFAULT '',
  `type_updated` datetime DEFAULT NULL,
  `type_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`),
  KEY `type_group_id` (`type_group_id`),
  CONSTRAINT `FK_ELEMENT_GROUP` FOREIGN KEY (`type_group_id`) REFERENCES `building_element_type_group` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_element_type: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.building_element_type_group
DROP TABLE IF EXISTS `building_element_type_group`;
CREATE TABLE `building_element_type_group` (
  `group_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_updated` datetime DEFAULT NULL,
  `group_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_element_type_group: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.building_floor
DROP TABLE IF EXISTS `building_floor`;
CREATE TABLE `building_floor` (
  `floor_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `building_id` smallint(6) NOT NULL,
  `floor_name` varchar(255) NOT NULL,
  `floor_coordinates` text NOT NULL,
  `floor_order` tinyint(4) NOT NULL,
  `floor_main` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Main floor',
  `floor_updated` datetime DEFAULT NULL,
  `floor_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`floor_id`),
  KEY `building_id` (`building_id`),
  CONSTRAINT `FK_FLOOR_BUILDING` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_floor: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.building_section
DROP TABLE IF EXISTS `building_section`;
CREATE TABLE `building_section` (
  `section_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `building_id` smallint(6) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_coordinates` text NOT NULL,
  `section_updated` datetime NOT NULL,
  `section_registered` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`section_id`),
  KEY `building_id` (`building_id`),
  CONSTRAINT `FK_SECTION_BUILDING` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_section: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.debug
DROP TABLE IF EXISTS `debug`;
CREATE TABLE `debug` (
  `debug_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `debug_session` smallint(6) NOT NULL DEFAULT '0',
  `debug_level` mediumint(1) NOT NULL COMMENT 'Predefined level',
  `debug_data` text NOT NULL COMMENT 'Debug data',
  `debug_file` varchar(255) NOT NULL DEFAULT '',
  `debug_line` smallint(6) NOT NULL DEFAULT '0',
  `debug_backtrack` longtext,
  `debug_trace` longtext,
  `debug_type` varchar(50) NOT NULL DEFAULT '' COMMENT 'Data type',
  `debug_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`debug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.debug: ~14 rows (approximately)
/*!40000 ALTER TABLE `debug` DISABLE KEYS */;
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES 
	(338, 177, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries_room.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349274176, 1349706176)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 16:22:56'),
	(339, 178, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries_room.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349274305, 1349706305)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 16:25:05'),
	(340, 179, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries_room.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349274336, 1349706336)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 16:25:36'),
	(341, 180, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries_room.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349274403, 1349706403)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 16:26:43'),
	(342, 181, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/toomanyweeks.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:127\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(127): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 19:03:22'),
	(343, 181, 1, 'Array\n(\n    [0] => Parse entries exceed\n    [1] => 1\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 135, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:135\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', 'string, integer', '2012-10-03 19:03:22'),
	(344, 181, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/toomanyweeks.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:127\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(127): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 19:03:22'),
	(345, 181, 1, 'Array\n(\n    [0] => Parse entries exceed\n    [1] => 2\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 135, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:135\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', 'string, integer', '2012-10-03 19:03:22'),
	(346, 181, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/toomanyweeks.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:127\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(127): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 19:03:22'),
	(347, 181, 1, 'Array\n(\n    [0] => Parse entries exceed\n    [1] => 3\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 135, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:135\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', 'string, integer', '2012-10-03 19:03:22'),
	(348, 181, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/toomanyweeks.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:127\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(127): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 19:03:22'),
	(349, 181, 1, 'Array\n(\n    [0] => Parse entries exceed\n    [1] => 4\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 135, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:135\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', 'string, integer', '2012-10-03 19:03:22'),
	(350, 181, 1, 'Array\n(\n    [0] => Website parser\n    [1] => http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/toomanyweeks.htm\n    [2] => EntriesTimeeditScheduleWebsiteAlgorithmParser\n)\n', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 61, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:61\n#3 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:127\n#4 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#5 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#6 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#7 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#8 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#9 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(127): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#8 {main}', 'string, string, string', '2012-10-03 19:03:22'),
	(351, 181, 1, 'Array\n(\n    [0] => Parse entries exceed\n    [1] => 5\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 135, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:135\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:240\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', 'string, integer', '2012-10-03 19:03:22')
;
/*!40000 ALTER TABLE `debug` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.error
DROP TABLE IF EXISTS `error`;
CREATE TABLE `error` (
  `error_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `error_kill` mediumint(1) NOT NULL DEFAULT '0' COMMENT 'Error killed response',
  `error_code` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Error PHP code',
  `error_message` text NOT NULL,
  `error_file` varchar(255) NOT NULL DEFAULT '',
  `error_line` smallint(6) NOT NULL DEFAULT '0',
  `error_occured` smallint(6) NOT NULL DEFAULT '1',
  `error_url` varchar(255) NOT NULL DEFAULT '',
  `error_backtrack` longtext,
  `error_trace` longtext,
  `error_query` text,
  `error_exception` varchar(50) NOT NULL DEFAULT '',
  `error_updated` timestamp NULL DEFAULT NULL,
  `error_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`error_id`),
  UNIQUE KEY `error_unique` (`error_file`,`error_line`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.error: ~9 rows (approximately)
/*!40000 ALTER TABLE `error` DISABLE KEYS */;
INSERT INTO `error` (`error_id`, `error_kill`, `error_code`, `error_message`, `error_file`, `error_line`, `error_occured`, `error_url`, `error_backtrack`, `error_trace`, `error_query`, `error_exception`, `error_updated`, `error_registered`) VALUES 
	(1, 0, 0, 'Controller mapping \"\" does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php', 504, 4, 'command.php?queue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#1 {main}', NULL, 'Exception', '2012-10-02 10:04:09', '2012-10-01 09:47:13'),
	(3, 0, 0, 'Schedule type in Queue argument not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php', 118, 8, 'command.php?/queue', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#5 {main}', NULL, 'Exception', '2012-10-01 20:42:07', '2012-10-01 20:38:44'),
	(11, 0, 0, 'Timeedit url \"http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/types/group_search_many.htm\" is not correct', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\url\\schedule\\timeedit\\types_timeedit_schedule_url_website_handler.php', 41, 1, 'command.php?/queue', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php(124): TypesTimeeditScheduleUrlWebsiteHandler->getTypesUrl(\'http://localhos...\', \'room\', \'1\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(141): TypesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(TypesTimeeditScheduleUrlWebsiteHandler), \'room\', \'multieplpages\', \'1\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', NULL, 'Exception', NULL, '2012-10-01 20:43:02'),
	(14, 0, 0, 'Types URL handler not given for website type\"timeedit_edit\"', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php', 110, 4, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#5 {main}', NULL, 'Exception', '2012-10-02 10:09:50', '2012-10-02 10:04:18'),
	(18, 0, 0, 'Algorithm for type \"timeedit_test\" not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php', 112, 1, 'command.php?%2Fqueue=&mode=3', '#1 HandlerException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\handler_exception.php:11\n#2 TypesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php:113\n#3 ScheduleQueueHandler->handleTypes C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:141\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:85\n#5 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:45\n#6 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#7 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(141): TypesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(TypesTestTimeeditScheduleUrlWebsiteHandler), \'program\', \'multieplpages\', \'1\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#6 {main}', NULL, 'HandlerException', NULL, '2012-10-02 10:11:06'),
	(19, 0, 0, 'Could not include class \"WebTestCase\" (C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\case\\test\\web_test_case.php) called from C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\web_test.php:4', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\util\\initialize_util.php', 66, 3, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(10): InitializeUtil::getClassPathFile(\'WebTestCase\', \'C:\\Users\\Kris L...\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\web_test.php(4): __autoload(\'WebTestCase\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\controller\\campusguide_controller_test.php(4): __autoload(\'WebTest\')\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\controller\\command\\campusguide\\queue_campusguide_command_controller_test.php(17): __autoload(\'CampusguideCont...\')\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\handler\\website\\url\\schedule\\timeedit\\entries_timeedit_schedule_url_website_handler_test.php(37): __autoload(\'QueueCampusguid...\')\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(121): EntriesTimeeditScheduleUrlWebsiteHandlerTest->getEntriesUrl(\'http://localhos...\', Object(RoomScheduleListModel), 1349273569, 1349705569)\n#9 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349273569, 1349705569)\n#10 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#11 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#12 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#13 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#14 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#15 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#16 {main}', NULL, 'Exception', '2012-10-03 16:12:50', '2012-10-03 14:22:34'),
	(20, 0, 0, 'Algorithm for type \"timeedit_test\" not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 112, 2, 'command.php?%2Fqueue=&mode=3', '#1 HandlerException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\handler_exception.php:11\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:113\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349267093, 1349699093)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', NULL, 'HandlerException', '2012-10-03 14:24:53', '2012-10-03 14:24:51'),
	(22, 0, 0, 'Webpage (\"http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries/%s\") does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 43, 4, 'command.php?%2Fqueue=&mode=3', '#1 ParserException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\parser_exception.php:12\n#2 WebsiteParser->parseUrl C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:44\n#3 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:64\n#4 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#5 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#6 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#7 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#8 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#9 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#10 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php(64): WebsiteParser->parseUrl(\'http://localhos...\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349267677, 1349699677)\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#9 {main}', NULL, 'ParserException', '2012-10-03 14:34:37', '2012-10-03 14:25:59'),
	(28, 0, 0, 'Missing argument 2 for EntriesScheduleResultWebsiteHandler::__construct(), called in C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php on line 138 and defined', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\result\\schedule\\entries_schedule_result_website_handler.php', 21, 1, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\result\\schedule\\entries_schedule_result_website_handler.php(21): Api->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 21, Array)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(138): EntriesScheduleResultWebsiteHandler->__construct(\'exceeding\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283802, 1349715802)\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#9 {main}', NULL, 'ErrorException', NULL, '2012-10-03 19:03:22')
;
/*!40000 ALTER TABLE `error` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.facility
DROP TABLE IF EXISTS `facility`;
CREATE TABLE `facility` (
  `facility_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `facility_name` varchar(255) NOT NULL,
  `facility_updated` datetime DEFAULT NULL,
  `facility_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`facility_id`)
) ENGINE=InnoDB AUTO_INCREMENT=705 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.facility: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.queue
DROP TABLE IF EXISTS `queue`;
CREATE TABLE `queue` (
  `queue_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `queue_type` char(50) NOT NULL COMMENT 'Predefined value',
  `queue_priority` tinyint(1) NOT NULL DEFAULT '0',
  `queue_arguments` text NOT NULL,
  `building_id` smallint(6) DEFAULT NULL,
  `website_id` smallint(6) DEFAULT NULL,
  `schedule_type` varchar(50) DEFAULT NULL COMMENT 'Predefined values',
  `queue_occurence` tinyint(4) NOT NULL DEFAULT '1',
  `queue_error` tinyint(4) NOT NULL DEFAULT '0',
  `queue_updated` datetime DEFAULT NULL,
  `queue_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`queue_id`),
  KEY `building_id` (`building_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_QUEUE_BUILDING` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_QUEUE_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.queue: ~1 rows (approximately)
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` (`queue_id`, `queue_type`, `queue_priority`, `queue_arguments`, `building_id`, `website_id`, `schedule_type`, `queue_occurence`, `queue_error`, `queue_updated`, `queue_registered`) VALUES 
	(46, 'schedule_entries', 1, 'types%5B0%5D=441&types%5B1%5D=442&types%5B2%5D=443&types%5B3%5D=444&types%5B4%5D=445&weeks%5B0%5D=1349283802&weeks%5B1%5D=1349715802&codes_pr=0', NULL, 218, 'room', 1, 0, '2012-10-03 19:03:22', '2012-10-03 19:03:22')
;
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.schedule_entry
DROP TABLE IF EXISTS `schedule_entry`;
CREATE TABLE `schedule_entry` (
  `entry_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_id` smallint(6) NOT NULL,
  `entry_type` varchar(255) NOT NULL DEFAULT '',
  `entry_time_start` time DEFAULT NULL,
  `entry_time_end` time DEFAULT NULL,
  `entry_updated` datetime DEFAULT NULL,
  `entry_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`),
  KEY `schedule_type` (`entry_type`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_entry_faculty
DROP TABLE IF EXISTS `schedule_entry_faculty`;
CREATE TABLE `schedule_entry_faculty` (
  `entry_id` smallint(6) NOT NULL,
  `faculty_id` smallint(6) NOT NULL,
  `entry_faculty_updated` timestamp NULL DEFAULT NULL,
  `entry_faculty_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`,`faculty_id`),
  KEY `FK_SCHEDULE_ENTRY_FACULTY_FACULTY` (`faculty_id`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_FACULTY_ENTRY` FOREIGN KEY (`entry_id`) REFERENCES `schedule_entry` (`entry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCHEDULE_ENTRY_FACULTY_FACULTY` FOREIGN KEY (`faculty_id`) REFERENCES `schedule_faculty` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry_faculty: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_entry_group
DROP TABLE IF EXISTS `schedule_entry_group`;
CREATE TABLE `schedule_entry_group` (
  `entry_id` smallint(6) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0',
  `entry_group_updated` timestamp NULL DEFAULT NULL,
  `entry_group_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`,`group_id`),
  KEY `FK_SCHEDULE_ENTRY_GROUP_GROUP` (`group_id`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_GROUP_ENTRY` FOREIGN KEY (`entry_id`) REFERENCES `schedule_entry` (`entry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCHEDULE_ENTRY_GROUP_GROUP` FOREIGN KEY (`group_id`) REFERENCES `schedule_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry_group: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_entry_occurence
DROP TABLE IF EXISTS `schedule_entry_occurence`;
CREATE TABLE `schedule_entry_occurence` (
  `entry_id` smallint(6) NOT NULL DEFAULT '0',
  `entry_occurence_date` date NOT NULL,
  `entry_occurence_updated` datetime DEFAULT NULL,
  `entry_occurence_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`,`entry_occurence_date`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_OCCURENCE_ENTRY` FOREIGN KEY (`entry_id`) REFERENCES `schedule_entry` (`entry_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry_occurence: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_entry_program
DROP TABLE IF EXISTS `schedule_entry_program`;
CREATE TABLE `schedule_entry_program` (
  `entry_id` smallint(6) NOT NULL DEFAULT '0',
  `program_id` smallint(6) NOT NULL DEFAULT '0',
  `entry_program_updated` timestamp NULL DEFAULT NULL,
  `entry_program_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`,`program_id`),
  KEY `FK_SCHEDULE_ENTRY_PROGRAM_PRGORAM` (`program_id`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_PROGRAM_ENTRY` FOREIGN KEY (`entry_id`) REFERENCES `schedule_entry` (`entry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCHEDULE_ENTRY_PROGRAM_PROGRAM` FOREIGN KEY (`program_id`) REFERENCES `schedule_program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry_program: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_entry_room
DROP TABLE IF EXISTS `schedule_entry_room`;
CREATE TABLE `schedule_entry_room` (
  `entry_id` smallint(6) NOT NULL DEFAULT '0',
  `room_id` smallint(6) NOT NULL DEFAULT '0',
  `entry_room_updated` timestamp NULL DEFAULT NULL,
  `entry_room_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`,`room_id`),
  KEY `FK_SCHEDULE_ENTRY_ROOM_ROOM` (`room_id`),
  CONSTRAINT `FK_SCHEDULE_ENTRY_ROOM_ENTRY` FOREIGN KEY (`entry_id`) REFERENCES `schedule_entry` (`entry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCHEDULE_ENTRY_ROOM_ROOM` FOREIGN KEY (`room_id`) REFERENCES `schedule_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_entry_room: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_faculty
DROP TABLE IF EXISTS `schedule_faculty`;
CREATE TABLE `schedule_faculty` (
  `faculty_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_id` smallint(6) NOT NULL,
  `room_id` smallint(6) DEFAULT NULL,
  `faculty_code` varchar(255) DEFAULT NULL COMMENT 'Schedule code',
  `faculty_type` varchar(255) NOT NULL DEFAULT '',
  `faculty_name` varchar(100) NOT NULL,
  `faculty_name_short` varchar(50) NOT NULL DEFAULT '',
  `faculty_phone` varchar(50) NOT NULL DEFAULT '',
  `faculty_email` varchar(255) NOT NULL DEFAULT '',
  `faculty_updated` datetime DEFAULT NULL,
  `faculty_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`faculty_id`),
  UNIQUE KEY `faculty_code` (`faculty_code`,`website_id`),
  KEY `facuilty_room` (`room_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_SCHEDULE_FACULTY_ROOM` FOREIGN KEY (`room_id`) REFERENCES `schedule_room` (`room_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_SCHEDULE_FACULTY_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_faculty: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_group
DROP TABLE IF EXISTS `schedule_group`;
CREATE TABLE `schedule_group` (
  `group_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_id` smallint(6) NOT NULL DEFAULT '0',
  `group_code` varchar(255) DEFAULT NULL COMMENT 'Schedule code',
  `group_name` varchar(100) NOT NULL,
  `group_name_short` varchar(50) NOT NULL DEFAULT '',
  `group_updated` datetime DEFAULT NULL,
  `group_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `website_id_group_code` (`website_id`,`group_code`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_SCHEDULE_GROUP_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=266 DEFAULT CHARSET=utf8 COMMENT='Class/group';


-- Dumping data for table campusguide_test.schedule_group: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_program
DROP TABLE IF EXISTS `schedule_program`;
CREATE TABLE `schedule_program` (
  `program_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_id` smallint(6) NOT NULL,
  `program_code` varchar(255) DEFAULT NULL COMMENT 'Schedule code',
  `program_name` varchar(100) NOT NULL DEFAULT '',
  `program_name_short` varchar(50) NOT NULL DEFAULT '',
  `program_updated` datetime DEFAULT NULL,
  `program_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`program_id`),
  UNIQUE KEY `program_code` (`program_code`,`website_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_SCHEDULE_PROGRAM_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 COMMENT='Course';


-- Dumping data for table campusguide_test.schedule_program: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_room
DROP TABLE IF EXISTS `schedule_room`;
CREATE TABLE `schedule_room` (
  `room_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_id` smallint(6) NOT NULL,
  `element_id` smallint(6) DEFAULT NULL COMMENT 'Building element',
  `room_code` varchar(50) DEFAULT NULL COMMENT 'Schedule code',
  `room_name` varchar(100) NOT NULL,
  `room_name_short` varchar(50) NOT NULL DEFAULT '',
  `room_updated` datetime DEFAULT NULL,
  `room_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `website_id_room_code` (`website_id`,`room_code`),
  KEY `room_element` (`element_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `FK_SCHEDULE_ROOM_ELEMENT` FOREIGN KEY (`element_id`) REFERENCES `building_element` (`element_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_SCHEDULE_ROOM_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=446 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_room: ~5 rows (approximately)
/*!40000 ALTER TABLE `schedule_room` DISABLE KEYS */;
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES 
	(441, 218, NULL, 101, 'A622', 'A622', NULL, '2012-10-03 19:03:22'),
	(442, 218, NULL, 102, 'JacobEides', 'JacobEides', NULL, '2012-10-03 19:03:22'),
	(443, 218, NULL, 103, 'A726', 'A726', NULL, '2012-10-03 19:03:22'),
	(444, 218, NULL, NULL, 'Room Name', 'Room Name Short', NULL, '2012-10-03 19:03:22'),
	(445, 218, NULL, NULL, 'Room Name', 'Room Name Short', NULL, '2012-10-03 19:03:22')
;
/*!40000 ALTER TABLE `schedule_room` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.schedule_website
DROP TABLE IF EXISTS `schedule_website`;
CREATE TABLE `schedule_website` (
  `website_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_url` varchar(255) NOT NULL,
  `website_type` varchar(50) NOT NULL COMMENT 'Pre-defined type',
  `website_parsed` datetime DEFAULT NULL,
  `website_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_website: ~1 rows (approximately)
/*!40000 ALTER TABLE `schedule_website` DISABLE KEYS */;
INSERT INTO `schedule_website` (`website_id`, `website_url`, `website_type`, `website_parsed`, `website_registered`) VALUES 
	(218, 'http://localhost:8008/KrisSkarbo/CampusGuide/%s', 'timeedit_test', NULL, '2012-10-03 19:03:22')
;
/*!40000 ALTER TABLE `schedule_website` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.schedule_website_building
DROP TABLE IF EXISTS `schedule_website_building`;
CREATE TABLE `schedule_website_building` (
  `website_id` smallint(6) NOT NULL,
  `building_id` smallint(6) NOT NULL,
  `website_building_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`website_id`,`building_id`),
  KEY `FK_SCHEDULE_WEBSITE_BUILDING_BUILDING` (`building_id`),
  CONSTRAINT `FK_SCHEDULE_WEBSITE_BUILDING_BUILDING` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCHEDULE_WEBSITE_BUILDING_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `schedule_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_website_building: ~0 rows (approximately)


/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
