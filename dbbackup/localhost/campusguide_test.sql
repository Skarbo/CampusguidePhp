-- Sun, 07 Oct 2012 14:30:49 GMT
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
  `building_address` varchar(255) DEFAULT NULL COMMENT 'Address: streetname, city, postal, country',
  `building_location` varchar(255) DEFAULT NULL COMMENT 'Address GPS location',
  `building_position` varchar(255) DEFAULT NULL COMMENT '4 GPS positions: center, topleft, topright, bottomright',
  `building_updated` datetime DEFAULT NULL,
  `building_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`building_id`),
  KEY `facility_id` (`facility_id`),
  CONSTRAINT `FK_BUILDING_FACILITY` FOREIGN KEY (`facility_id`) REFERENCES `facility` (`facility_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=597 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building: ~1 rows (approximately)
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` (`building_id`, `facility_id`, `building_name`, `building_address`, `building_location`, `building_position`, `building_updated`, `building_registered`) VALUES 
	(596, 728, 'Test Building', 'streetname|city|postal|country', '10.1,20.1', '30.1,40.1|50.1,60.1|70.1,80.1', NULL, '2012-10-04 13:50:04')
;
/*!40000 ALTER TABLE `building` ENABLE KEYS */;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_element: ~0 rows (approximately)


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_section: ~3 rows (approximately)
/*!40000 ALTER TABLE `building_section` DISABLE KEYS */;
INSERT INTO `building_section` (`section_id`, `building_id`, `section_name`, `section_coordinates`, `section_updated`, `section_registered`) VALUES 
	(269, 596, 'Section Test', '100,200|300,400', '0000-00-00 00:00:00', '2012-10-04 13:50:04'),
	(270, 596, 'Section Test', '100,200|300,400', '0000-00-00 00:00:00', '2012-10-04 13:50:04'),
	(271, 596, 'Section Test', '100,200|300,400', '0000-00-00 00:00:00', '2012-10-04 13:50:04')
;
/*!40000 ALTER TABLE `building_section` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=1179 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.debug: ~11 rows (approximately)
/*!40000 ALTER TABLE `debug` DISABLE KEYS */;
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES 
	(1168, 8, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/building/596_overview_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsCampusguideImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:144\n#3 BuildingCmsCampusguideImageController->getImageLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:170\n#4 BuildingCmsCampusguideImageController->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:116\n#5 BuildingCmsCampusguideImageView->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php:38\n#6 View->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\view.php:103\n#7 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:40\n#8 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#9 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#10 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php(170): BuildingCmsCampusguideImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php(116): BuildingCmsCampusguideImageController->getImageLastModified()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php(38): BuildingCmsCampusguideImageController->getLastModified()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\view.php(103): BuildingCmsCampusguideImageView->getLastModified()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(40): View->draw(Object(DivXhtml))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#9 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1169, 8, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/building/596_overview_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsCampusguideImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:144\n#3 BuildingCmsCampusguideImageView->getImagePath C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php:49\n#4 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:43\n#5 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#6 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#7 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php(49): BuildingCmsCampusguideImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(43): BuildingCmsCampusguideImageView->getImagePath()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#6 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1170, 8, 1, 'Array\n(\n    [0] => Image path\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/building/default_overview_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 47, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:47\n#3 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#4 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#5 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#4 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1171, 9, 1, 'Array\n(\n    [0] => Image path\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/facility/728_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 47, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:47\n#3 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#4 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#5 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(FacilityCmsCampusguideImageController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#4 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1172, 9, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/building/596_map_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsCampusguideImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:144\n#3 BuildingCmsCampusguideImageController->getImageLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:170\n#4 BuildingCmsCampusguideImageController->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:116\n#5 BuildingCmsCampusguideImageView->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php:38\n#6 View->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\view.php:103\n#7 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:40\n#8 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#9 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#10 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php(170): BuildingCmsCampusguideImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php(116): BuildingCmsCampusguideImageController->getImageLastModified()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php(38): BuildingCmsCampusguideImageController->getLastModified()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\view.php(103): BuildingCmsCampusguideImageView->getLastModified()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(40): View->draw(Object(DivXhtml))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#9 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1173, 9, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/building/596_map_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsCampusguideImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\campusguide\\cms\\building_cms_campusguide_image_controller.php:144\n#3 BuildingCmsCampusguideImageView->getImagePath C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php:49\n#4 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:43\n#5 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#6 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#7 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\campusguide\\cms\\building_cms_campusguide_image_view.php(49): BuildingCmsCampusguideImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(43): BuildingCmsCampusguideImageView->getImagePath()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#6 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1174, 9, 1, 'Array\n(\n    [0] => Image path\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/building/596_map_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 47, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:47\n#3 Controller->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php:351\n#4 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#5 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): Controller->render(Object(DivXhtml))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingCmsCampusguideImageController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#4 {main}', 'string, string', '2012-10-07 11:10:13'),
	(1175, 10, 1, 'Array\n(\n    [0] => Image path\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/facility/728_200x100.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 47, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:47\n#3 AbstractController->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php:351\n#4 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:586\n#5 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(586): AbstractController->render(Object(DivXhtml))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(FacilityCmsCampusguideImageController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): Api->doRequest(Array)\n#4 {main}', 'string, string', '2012-10-07 11:29:10'),
	(1176, 11, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo/image/3/building/596_overview_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php:144\n#3 BuildingCmsImageController->getImageLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php:170\n#4 BuildingCmsImageController->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php:116\n#5 BuildingCmsImageView->getLastModified C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\cms\\building_cms_image_view.php:38\n#6 AbstractView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\abstract_view.php:103\n#7 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:40\n#8 AbstractController->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php:351\n#9 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:586\n#10 AbstractApi->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php(170): BuildingCmsImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php(116): BuildingCmsImageController->getImageLastModified()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\cms\\building_cms_image_view.php(38): BuildingCmsImageController->getLastModified()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\view\\abstract_view.php(103): BuildingCmsImageView->getLastModified()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(40): AbstractView->draw(Object(DivXhtml))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php(351): ImageView->draw(Object(DivXhtml))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(586): AbstractController->render(Object(DivXhtml))\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(540): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): AbstractApi->doRequest(Array)\n#9 {main}', 'string, string', '2012-10-07 16:16:50'),
	(1177, 11, 1, 'Array\n(\n    [0] => Get image\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo/image/3/building/596_overview_150x75.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php', 144, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 BuildingCmsImageController->getImage C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\image\\cms\\building_cms_image_controller.php:144\n#3 BuildingCmsImageView->getImagePath C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\cms\\building_cms_image_view.php:49\n#4 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:43\n#5 AbstractController->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php:351\n#6 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:586\n#7 AbstractApi->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image\\cms\\building_cms_image_view.php(49): BuildingCmsImageController->getImage()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php(43): BuildingCmsImageView->getImagePath()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php(351): ImageView->draw(Object(DivXhtml))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(586): AbstractController->render(Object(DivXhtml))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(540): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): AbstractApi->doRequest(Array)\n#6 {main}', 'string, string', '2012-10-07 16:16:50'),
	(1178, 12, 1, 'Array\n(\n    [0] => Image path\n    [1] => C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide/image/3/facility/728_200x100.png\n)\n', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 47, '#1 DebugException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 ImageView->draw C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php:47\n#3 AbstractController->render C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php:351\n#4 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:586\n#5 AbstractApi->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(586): AbstractController->render(Object(DivXhtml))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(540): AbstractApi->doControllerViewRender(Object(FacilityCmsImageController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', 'string, string', '2012-10-07 16:30:49')
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.error: ~18 rows (approximately)
/*!40000 ALTER TABLE `error` DISABLE KEYS */;
INSERT INTO `error` (`error_id`, `error_kill`, `error_code`, `error_message`, `error_file`, `error_line`, `error_occured`, `error_url`, `error_backtrack`, `error_trace`, `error_query`, `error_exception`, `error_updated`, `error_registered`) VALUES 
	(1, 0, 0, 'Controller mapping \"building\" does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php', 504, 8, 'api_rest.php?/building', NULL, '#0 \\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): Api->doRequest(Array)\n#1 {main}', NULL, 'Exception', '2012-10-07 11:43:07', '2012-10-01 09:47:13'),
	(3, 0, 0, 'Schedule type in Queue argument not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php', 118, 8, 'command.php?/queue', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#5 {main}', NULL, 'Exception', '2012-10-01 20:42:07', '2012-10-01 20:38:44'),
	(11, 0, 0, 'Timeedit url \"http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/types/group_search_many.htm\" is not correct', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\url\\schedule\\timeedit\\types_timeedit_schedule_url_website_handler.php', 41, 1, 'command.php?/queue', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php(124): TypesTimeeditScheduleUrlWebsiteHandler->getTypesUrl(\'http://localhos...\', \'room\', \'1\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(141): TypesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(TypesTimeeditScheduleUrlWebsiteHandler), \'room\', \'multieplpages\', \'1\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', NULL, 'Exception', NULL, '2012-10-01 20:43:02'),
	(14, 0, 0, 'Types URL handler not given for website type\"timeedit_edit\"', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php', 110, 4, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#5 {main}', NULL, 'Exception', '2012-10-02 10:09:50', '2012-10-02 10:04:18'),
	(18, 0, 0, 'Algorithm for type \"timeedit_test\" not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php', 112, 1, 'command.php?%2Fqueue=&mode=3', '#1 HandlerException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\handler_exception.php:11\n#2 TypesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\types_schedule_website_handler.php:113\n#3 ScheduleQueueHandler->handleTypes C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:141\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:85\n#5 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:45\n#6 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#7 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(141): TypesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(TypesTestTimeeditScheduleUrlWebsiteHandler), \'program\', \'multieplpages\', \'1\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(85): ScheduleQueueHandler->handleTypes(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(45): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#6 {main}', NULL, 'HandlerException', NULL, '2012-10-02 10:11:06'),
	(19, 0, 0, 'Could not include class \"WebTestCase\" (C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\case\\test\\web_test_case.php) called from C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\web_test.php:4', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\util\\initialize_util.php', 66, 3, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(10): InitializeUtil::getClassPathFile(\'WebTestCase\', \'C:\\Users\\Kris L...\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\web_test.php(4): __autoload(\'WebTestCase\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\controller\\campusguide_controller_test.php(4): __autoload(\'WebTest\')\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\controller\\command\\campusguide\\queue_campusguide_command_controller_test.php(17): __autoload(\'CampusguideCont...\')\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(11): require_once(\'C:\\Users\\Kris L...\')\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\test\\handler\\website\\url\\schedule\\timeedit\\entries_timeedit_schedule_url_website_handler_test.php(37): __autoload(\'QueueCampusguid...\')\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(121): EntriesTimeeditScheduleUrlWebsiteHandlerTest->getEntriesUrl(\'http://localhos...\', Object(RoomScheduleListModel), 1349273569, 1349705569)\n#9 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349273569, 1349705569)\n#10 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#11 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#12 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#13 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#14 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#15 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#16 {main}', NULL, 'Exception', '2012-10-03 16:12:50', '2012-10-03 14:22:34'),
	(20, 0, 0, 'Algorithm for type \"timeedit_test\" not given', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php', 112, 2, 'command.php?%2Fqueue=&mode=3', '#1 HandlerException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\handler_exception.php:11\n#2 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:113\n#3 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#4 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#5 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#6 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349267093, 1349699093)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#7 {main}', NULL, 'HandlerException', '2012-10-03 14:24:53', '2012-10-03 14:24:51'),
	(22, 0, 0, 'Webpage (\"http://localhost:8008/KrisSkarbo/CampusGuide/example/timeedit/entries/%s\") does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php', 43, 4, 'command.php?%2Fqueue=&mode=3', '#1 ParserException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\parser_exception.php:12\n#2 WebsiteParser->parseUrl C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:44\n#3 WebsiteParser->parse C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php:64\n#4 EntriesScheduleWebsiteHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php:122\n#5 ScheduleQueueHandler->handleEntries C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:237\n#6 ScheduleQueueHandler->handle C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php:186\n#7 QueueCampusguideCommandController->handleQueue C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:103\n#8 QueueCampusguideCommandController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php:77\n#9 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#10 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\parser\\website_parser.php(64): WebsiteParser->parseUrl(\'http://localhos...\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(122): WebsiteParser->parse(\'http://localhos...\', Object(EntriesTimeeditScheduleWebsiteAlgorithmParser))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(237): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349267677, 1349699677)\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#9 {main}', NULL, 'ParserException', '2012-10-03 14:34:37', '2012-10-03 14:25:59'),
	(28, 0, 0, 'Missing argument 2 for EntriesScheduleResultWebsiteHandler::__construct(), called in C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php on line 138 and defined', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\result\\schedule\\entries_schedule_result_website_handler.php', 21, 2, 'command.php?%2Fqueue=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\result\\schedule\\entries_schedule_result_website_handler.php(21): Api->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 21, Array)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\website\\schedule\\entries_schedule_website_handler.php(138): EntriesScheduleResultWebsiteHandler->__construct(\'exceeding\')\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(240): EntriesScheduleWebsiteHandler->handle(Object(WebsiteScheduleModel), Object(EntriesTimeeditScheduleUrlWebsiteHandlerTest), Object(RoomScheduleListModel), 1349283834, 1349715834)\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\handler\\queue\\schedule_queue_handler.php(186): ScheduleQueueHandler->handleEntries(Object(QueueModel))\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(103): ScheduleQueueHandler->handle(Object(QueueModel))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\command\\campusguide\\queue_campusguide_command_controller.php(77): QueueCampusguideCommandController->handleQueue(Object(QueueModel))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): QueueCampusguideCommandController->request()\n#7 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(QueueCampusguideCommandController))\n#8 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\command.php(108): Api->doRequest(Array)\n#9 {main}', NULL, 'ErrorException', '2012-10-03 19:03:55', '2012-10-03 19:03:22'),
	(29, 0, 0, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'IN ( NULL )\' at line 1', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php', 154, 8, 'api_rest.php?%2Ffacilities%2Fremove%2F577=&mode=3', '#1 DbException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\db_exception.php:13\n#2 PdoDbApi->querySelect C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:154\n#3 PdoDbApi->query C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:77\n#4 StandardDbDao->getForeign C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php:245\n#5 StandardRestController->doRemoveCommand C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:418\n#6 StandardRestController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:554\n#7 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#8 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php(77): PdoDbApi->querySelect(Object(SelectQueryDbCore))\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php(245): PdoDbApi->query(Object(SelectQueryDbCore))\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php(418): StandardDbDao->getForeign(Array)\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php(554): StandardRestController->doRemoveCommand()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): StandardRestController->request()\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(FacilitiesCampusguideRestController))\n#6 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): Api->doRequest(Array)\n#7 {main}', 'SELECT `facility`.*, IFNULL( ( SELECT COUNT( `building`.building_id ) FROM building WHERE `building`.facility_id = `facility`.facility_id ), 0 ) AS facility_buildings FROM `facility` WHERE IN ( :_0 )\nArray\n(\n    [_0] => \n)\n', 'DbException', '2012-10-04 13:07:39', '2012-10-04 13:05:06'),
	(31, 0, 0, 'Building is not valid', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php', 213, 14, 'api_rest.php?/buildings/edit/530&mode=3', '#1 ValidatorException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\validator_exception.php:10\n#2 Validator->doValidate C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php:213\n#3 BuildingsCampusguideRestController->getModelPost C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\rest\\campusguide\\buildings_campusguide_rest_controller.php:92\n#4 StandardRestController->doEditCommand C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:388\n#5 StandardRestController->request C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:550\n#6 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#7 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\src\\controller\\rest\\campusguide\\buildings_campusguide_rest_controller.php(92): Validator->doValidate(Object(BuildingModel), \'Building is not...\')\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php(388): BuildingsCampusguideRestController->getModelPost()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php(550): StandardRestController->doEditCommand()\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): StandardRestController->request()\n#4 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingsCampusguideRestController))\n#5 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): Api->doRequest(Array)\n#6 {main}', NULL, 'ValidatorException', '2012-10-04 13:45:18', '2012-10-04 13:05:07'),
	(32, 0, 0, 'Missing argument 2 for ErrorHandler::handle(), called in C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php on line 414 and defined', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\handler\\error_handler.php', 61, 1, 'api_rest.php?%2Ffacilities%2Fremove%2F577=&mode=3', NULL, '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\handler\\error_handler.php(61): Api->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 61, Array)\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(414): ErrorHandler->handle(Object(BadrequestException))\n#2 [internal function]: Api->doExceptionHandling(Object(BadrequestException))\n#3 {main}', NULL, 'ErrorException', NULL, '2012-10-06 12:28:05'),
	(33, 0, 0, 'Id \"577\" does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php', 509, 1, 'api_rest.php?%2Ffacilities%2Fremove%2F577=&mode=3', '#1 BadrequestException->__construct C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\badrequest_exception.php:11\n#2 StandardRestController->beforeIsEditDelete C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:509\n#3 StandardRestController->before C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:484\n#4 Api->doControllerViewRender C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:568\n#5 Api->doRequest C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php(484): StandardRestController->beforeIsEditDelete()\n#1 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(568): StandardRestController->before()\n#2 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(FacilitiesCampusguideRestController))\n#3 C:\\Users\\Kris Laptop Windows\\Dropbox\\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): Api->doRequest(Array)\n#4 {main}', NULL, 'BadrequestException', NULL, '2012-10-06 12:28:05'),
	(34, 0, 0, 'str_replace() expects at least 3 parameters, 2 given', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\handler\\error_handler.php', 93, 1, 'api_rest.php?/buildings/edit/530&mode=3', NULL, '#0 [internal function]: Api->doErrorHandling(2, \'str_replace() e...\', \'C:\\Users\\Kris L...\', 93, Array)\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\handler\\error_handler.php(93): str_replace(\'C:\\Users\\Kris L...\', \'#1 BadrequestEx...\')\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(414): ErrorHandler->handle(Object(BadrequestException))\n#3 [internal function]: Api->doExceptionHandling(Object(BadrequestException))\n#4 {main}', NULL, 'ErrorException', NULL, '2012-10-06 12:56:50'),
	(35, 0, 0, 'Unknown command \"edit\"', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php', 562, 4, 'api_rest.php?/buildings/edit/530&mode=3', '#1 BadrequestException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\badrequest_exception.php:11\n#2 StandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard_rest_controller.php:563\n#3 Api->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:571\n#4 Api->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php:540', '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(571): StandardRestController->request()\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api.php(540): Api->doControllerViewRender(Object(BuildingsCampusguideRestController))\n#2 \\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): Api->doRequest(Array)\n#3 {main}', NULL, 'BadrequestException', '2012-10-06 12:58:16', '2012-10-06 12:56:50'),
	(38, 0, 0, 'Unknown command \"\"', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php', 562, 3, 'api_rest.php?', '#1 BadrequestException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\badrequest_exception.php:11\n#2 AbstractStandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:563\n#3 AbstractApi->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:571\n#4 AbstractApi->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:540', '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(571): AbstractStandardRestController->request()\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(540): AbstractApi->doControllerViewRender(Object(FacilitiesRestController))\n#2 \\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): AbstractApi->doRequest(Array)\n#3 {main}', NULL, 'BadrequestException', '2012-10-07 16:19:08', '2012-10-07 11:42:42'),
	(41, 0, 0, 'Image does not exist', '\\Scripting\\KrisSkarbo\\CampusGuide\\src\\view\\image_view.php', 46, 4, 'image.php?/facility/728/&mode=3', NULL, '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\abstract_controller.php(351): ImageView->draw(Object(DivXhtml))\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(586): AbstractController->render(Object(DivXhtml))\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(540): AbstractApi->doControllerViewRender(Object(FacilityCmsImageController))\n#3 \\Scripting\\KrisSkarbo\\CampusGuide\\image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', NULL, 'Exception', '2012-10-07 16:25:27', '2012-10-07 16:11:25'),
	(45, 0, 0, 'Controller mapping \"building\" does not exist', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php', 504, 1, 'api_rest.php?/building/get', NULL, '#0 \\Scripting\\KrisSkarbo\\CampusGuide\\api_rest.php(138): AbstractApi->doRequest(Array)\n#1 {main}', NULL, 'Exception', NULL, '2012-10-07 16:19:18')
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
) ENGINE=InnoDB AUTO_INCREMENT=729 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.facility: ~1 rows (approximately)
/*!40000 ALTER TABLE `facility` DISABLE KEYS */;
INSERT INTO `facility` (`facility_id`, `facility_name`, `facility_updated`, `facility_registered`) VALUES 
	(728, 'Test Facility', NULL, '2012-10-04 13:50:04')
;
/*!40000 ALTER TABLE `facility` ENABLE KEYS */;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.queue: ~0 rows (approximately)


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Class/group';


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Course';


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_room: ~0 rows (approximately)


-- Dumping structure for table campusguide_test.schedule_website
DROP TABLE IF EXISTS `schedule_website`;
CREATE TABLE `schedule_website` (
  `website_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `website_url` varchar(255) NOT NULL,
  `website_type` varchar(50) NOT NULL COMMENT 'Pre-defined type',
  `website_parsed` datetime DEFAULT NULL,
  `website_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_website: ~0 rows (approximately)


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
