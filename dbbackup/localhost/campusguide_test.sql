-- Wed, 12 Jun 2013 01:55:04 GMT
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
  `building_overlay` text COMMENT 'Polyline algorithm encoded',
  `building_updated` datetime DEFAULT NULL,
  `building_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`building_id`),
  KEY `facility_id` (`facility_id`),
  CONSTRAINT `FK_BUILDING_FACILITY` FOREIGN KEY (`facility_id`) REFERENCES `facility` (`facility_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=646 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building: ~1 rows (approximately)
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` (`building_id`, `facility_id`, `building_name`, `building_address`, `building_location`, `building_position`, `building_overlay`, `building_updated`, `building_registered`) VALUES
	(645, 777, 'Test Building', 'Nygårdsgaten 112|Bergen|5008|Norway', '60.38426,5.33299', '60.38457,5.33367', '[\"i|poJisp_@~@k@e@kB{@TCs@lAOv@dCT]Ll@}@jA_Ah@\"]', '2013-04-03 01:32:08', '2013-04-01 14:08:58');
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
  `element_data` text NOT NULL,
  `element_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `element_updated` datetime DEFAULT NULL,
  `element_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`element_id`),
  KEY `section_id` (`section_id`),
  KEY `floor_id` (`floor_id`),
  CONSTRAINT `FK_ELEMENT_FLOOR` FOREIGN KEY (`floor_id`) REFERENCES `building_floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ELEMENT_SECTION` FOREIGN KEY (`section_id`) REFERENCES `building_section` (`section_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_element: ~19 rows (approximately)
/*!40000 ALTER TABLE `building_element` DISABLE KEYS */;
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(2, 55, NULL, 'stairs', 'room', 'Test7', '{\"coordinates\":[[\"77.3\",\"67.2\"],[\"317.3\",\"67.2\"],[\"317.3\",\"151.8\"],[\"167.3\",\"151.8\"],[\"167.3\",\"447.8\"],[\"77.3\",\"447.8\"]],\"center\":[\"105.59\",\"250.88\"]}', '', 0, '2013-04-21 14:11:12', '2013-04-03 01:04:23');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(3, 55, NULL, 'class', 'room', 'Test2', '{\"coordinates\":[[\"762.9\",\"445.8\"],[\"762.9\",\"60.8\"],[\"446.9\",\"52.8\"],[\"446.9\",\"148.8\"],[\"643.9\",\"148.8\"],[\"643.9\",\"445.8\"]],\"center\":[\"686.2\",\"248.4\"]}', '{\"names\":[\"Add name test\"]}', 0, '2013-04-21 14:00:22', '2013-04-04 15:56:26');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(4, 55, NULL, 'class', 'room', 'Testing', '{\"coordinates\":[[\"254.89999999999998\",\"213.8\"],[\"525.9\",\"213.8\"],[\"525.9\",\"445.8\"],[\"259.9\",\"445.8\"]],\"center\":[\"360.7\",\"323\"]}', '', 0, '2013-04-21 14:00:22', '2013-04-04 15:56:26');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(5, 55, NULL, 'router', 'device', '', '[\"205.9\",\"406.8\"]', '', 0, '2013-04-21 14:13:41', '2013-04-21 13:17:49');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(6, 55, NULL, 'router', 'device', '', '[\"605.9\",\"423.17\"]', '', 0, NULL, '2013-04-21 14:13:41');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(7, 58, NULL, 'cafeteria', 'room', 'A700', '{\"coordinates\":[[\"1979.14\",\"897.6\"],[\"2147.85\",\"953.84\"],[\"2124.69\",\"1028.27\"],[\"1945.23\",\"975.34\"]],\"center\":[\"2028.47\",\"963.71\"]}', '', 0, '2013-04-25 06:00:22', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(8, 58, NULL, 'class', 'room', 'A701', '{\"coordinates\":[[\"1802.16\",\"685.06\"],[\"1967.56\",\"750.39\"],[\"1936.13\",\"829.79\"],[\"1772.39\",\"770.24\"]],\"center\":[\"1849.36\",\"758.45\"]}', '', 0, '2013-04-24 14:47:21', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(9, 58, NULL, 'class', 'room', 'A702', '{\"coordinates\":[[\"2058.53\",\"699.95\"],[\"2226.41\",\"769.41\"],[\"2152.81\",\"953.84\"],[\"1977.48\",\"894.29\"]],\"center\":[\"2083.36\",\"829.33\"]}', '', 0, '2013-04-24 11:39:39', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(10, 58, NULL, 'auditorium', 'room', 'A704', '{\"coordinates\":[[\"2092.44\",\"615.59\"],[\"2264.45\",\"691.68\"],[\"2228.07\",\"762.8\"],[\"2061.01\",\"694.98\"]],\"center\":[\"2141.14\",\"690.58\"]}', '', 0, '2013-04-24 11:39:49', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(11, 58, NULL, 'class', 'room', 'A705', '{\"coordinates\":[[\"1988.24\",\"306.29\"],[\"2136.27\",\"391.47\"],[\"2047.78\",\"572.59\"],[\"1970.87\",\"748.74\"],[\"1808.78\",\"682.58\"]],\"center\":[\"1954.49\",\"532.27\"]}', '', 0, '2013-04-24 11:40:07', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(12, 58, NULL, 'auditorium', 'room', 'A707', '{\"coordinates\":[[\"1767.43\",\"771.07\"],[\"1939.44\",\"836.4\"],[\"1876.59\",\"993.53\"],[\"1707.05\",\"933.99\"]],\"center\":[\"1802.87\",\"883.29\"]}', '', 0, '2013-04-24 16:25:36', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(13, 58, NULL, 'auditorium', 'room', 'A706', '{\"coordinates\":[[\"2197.47\",\"423.73\"],[\"2345.5\",\"508.91\"],[\"2260.32\",\"689.19\"],[\"2094.92\",\"612.28\"]],\"center\":[\"2203.57\",\"559.05\"]}', '', 0, '2013-04-24 16:25:38', '2013-04-24 11:33:46');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(16, 58, NULL, 'router', 'device', 'A706', '[\"2258.66\",\"492.37\"]', '', 0, '2013-04-25 11:09:24', '2013-04-24 11:43:31');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(17, 58, NULL, 'router', 'device', 'A702', '[\"2129.65\",\"769.41\"]', '', 0, '2013-04-25 13:13:19', '2013-04-24 11:43:31');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(18, 58, NULL, 'router', 'device', 'A707', '[\"1826.14\",\"833.92\"]', '', 0, '2013-04-25 11:09:46', '2013-04-24 11:43:31');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(19, 58, NULL, 'router', 'device', 'A705', '[\"2045.3\",\"357.57\"]', '', 0, '2013-04-25 11:09:39', '2013-04-24 11:43:31');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(20, 58, NULL, 'router', 'device', 'A701', '[\"1840.2\",\"731.37\"]', '{\"macs\":[\"MAC\",\"MAC2\"]}', 0, '2013-04-25 13:30:31', '2013-04-24 11:43:31');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(21, 58, NULL, 'auditorium', 'room', 'A710', '{\"coordinates\":[[\"1946.63\",\"978.93\"],[\"2119.96\",\"1039.8\"],[\"2046.4\",\"1265.55\"],[\"1873.07\",\"1221.58\"]],\"center\":[\"1976.23\",\"1125.63\"]}', '', 0, '2013-04-24 17:06:21', '2013-04-24 17:02:34');
INSERT INTO `building_element` (`element_id`, `floor_id`, `section_id`, `element_type`, `element_type_group`, `element_name`, `element_coordinates`, `element_data`, `element_deleted`, `element_updated`, `element_registered`) VALUES
	(22, 58, NULL, 'stairs', 'room', 'Stairs', '{\"coordinates\":[[\"2141.94\",\"392.15\"],[\"2195.21\",\"424.28\"],[\"2121.65\",\"555.33\"],[\"2071.76\",\"532.5\"]],\"center\":[\"2113.71\",\"474.55\"]}', '', 0, '2013-04-24 17:21:26', '2013-04-24 17:06:40');
/*!40000 ALTER TABLE `building_element` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.building_floor
DROP TABLE IF EXISTS `building_floor`;
CREATE TABLE `building_floor` (
  `floor_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `building_id` smallint(6) NOT NULL,
  `floor_name` varchar(255) NOT NULL,
  `floor_order` tinyint(4) NOT NULL,
  `floor_coordinates` text NOT NULL,
  `floor_main` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Main floor',
  `floor_updated` datetime DEFAULT NULL,
  `floor_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`floor_id`),
  KEY `building_id` (`building_id`),
  CONSTRAINT `FK_FLOOR_BUILDING` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_floor: ~3 rows (approximately)
/*!40000 ALTER TABLE `building_floor` DISABLE KEYS */;
INSERT INTO `building_floor` (`floor_id`, `building_id`, `floor_name`, `floor_order`, `floor_coordinates`, `floor_main`, `floor_updated`, `floor_registered`) VALUES
	(55, 645, 1, 0, '[{\"coordinates\":[[\"43.1\",\"31.7\"],[\"43.1\",\"462.8\"],[\"783.4\",\"462.8\"],[\"783.4\",\"31.7\"]],\"center\":\"\",\"changed\":\"true\",\"deleted\":\"false\"}]', 1, '2013-04-24 11:22:35', '2013-04-01 14:08:58');
INSERT INTO `building_floor` (`floor_id`, `building_id`, `floor_name`, `floor_order`, `floor_coordinates`, `floor_main`, `floor_updated`, `floor_registered`) VALUES
	(57, 645, 2, 1, '[{\"coordinates\":[[\"43.1\",\"31.7\"],[\"43.1\",\"462.8\"],[\"783.4\",\"462.8\"],[\"783.4\",\"31.7\"]],\"center\":[]}]', 0, '2013-04-24 11:22:35', '2013-04-01 14:08:58');
INSERT INTO `building_floor` (`floor_id`, `building_id`, `floor_name`, `floor_order`, `floor_coordinates`, `floor_main`, `floor_updated`, `floor_registered`) VALUES
	(58, 645, 3, 0, '[{\"coordinates\":[[\"1979.97\",\"295.54\"],[\"2359.56\",\"507.25\"],[\"2265.28\",\"696.64\"],[\"2183.41\",\"879.41\"],[\"2089.13\",\"1151.49\"],[\"2053.57\",\"1271.4\"],[\"1632.62\",\"1158.1\"],[\"1700.44\",\"938.12\"],[\"1745.92\",\"807.46\"],[\"1812.91\",\"634.61\"],[\"1891.48\",\"465.9\"]],\"center\":\"\",\"changed\":\"true\",\"deleted\":\"false\"}]', 0, '2013-04-25 13:30:31', '2013-04-24 11:22:35');
/*!40000 ALTER TABLE `building_floor` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.building_navigation_edge
DROP TABLE IF EXISTS `building_navigation_edge`;
CREATE TABLE `building_navigation_edge` (
  `node_left` smallint(6) NOT NULL,
  `node_right` smallint(6) NOT NULL,
  `edge_updated` datetime DEFAULT NULL,
  `edge_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`node_left`,`node_right`),
  KEY `FK_NAVIGATION_EDGE_NODE_RIGHT` (`node_right`),
  CONSTRAINT `FK_NAVIGATION_EDGE_NODE_LEFT` FOREIGN KEY (`node_left`) REFERENCES `building_navigation_node` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_NAVIGATION_EDGE_NODE_RIGHT` FOREIGN KEY (`node_right`) REFERENCES `building_navigation_node` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_navigation_edge: ~21 rows (approximately)
/*!40000 ALTER TABLE `building_navigation_edge` DISABLE KEYS */;
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(212, 211, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(214, 211, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(215, 214, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(216, 211, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(217, 212, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(218, 212, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(219, 213, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(219, 216, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(220, 219, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(221, 211, NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(223, 222, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(224, 223, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(226, 225, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(227, 222, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(228, 222, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(229, 223, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(230, 224, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(231, 224, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(231, 225, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(232, 231, NULL, '2013-04-24 12:08:43');
INSERT INTO `building_navigation_edge` (`node_left`, `node_right`, `edge_updated`, `edge_registered`) VALUES
	(233, 225, NULL, '2013-04-24 12:08:43');
/*!40000 ALTER TABLE `building_navigation_edge` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.building_navigation_node
DROP TABLE IF EXISTS `building_navigation_node`;
CREATE TABLE `building_navigation_node` (
  `node_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `floor_id` smallint(6) NOT NULL,
  `element_id` smallint(6) DEFAULT NULL,
  `node_coordinate` varchar(255) DEFAULT NULL,
  `node_updated` datetime DEFAULT NULL,
  `node_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`node_id`),
  KEY `building_id` (`floor_id`),
  KEY `element_id` (`element_id`),
  CONSTRAINT `BUILDING_NAVIGATION_ELEMENT` FOREIGN KEY (`element_id`) REFERENCES `building_element` (`element_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `BUILDING_NAVIGATION_FLOOR` FOREIGN KEY (`floor_id`) REFERENCES `building_floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.building_navigation_node: ~23 rows (approximately)
/*!40000 ALTER TABLE `building_navigation_node` DISABLE KEYS */;
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(211, 55, NULL, '{\"x\":381,\"y\":188}', '2013-04-10 03:21:36', '2013-04-01 14:29:23');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(212, 55, NULL, '{\"x\":380,\"y\":110}', '2013-04-10 03:21:36', '2013-04-01 14:29:23');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(213, 55, NULL, '{\"x\":586,\"y\":438}', '2013-04-10 03:21:36', '2013-04-01 14:31:06');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(214, 55, NULL, '{\"x\":205,\"y\":189}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(215, 55, NULL, '{\"x\":207,\"y\":428}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(216, 55, NULL, '{\"x\":582,\"y\":189}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(217, 55, 3, '{\"x\":491,\"y\":112}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(218, 55, 2, '{\"x\":280,\"y\":112}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(219, 55, NULL, '{\"x\":584,\"y\":322}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(220, 55, 3, '{\"x\":695,\"y\":322}', '2013-04-10 03:21:36', '2013-04-04 15:56:26');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(221, 55, 4, '{\"x\":386,\"y\":253}', NULL, '2013-04-10 03:21:36');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(222, 58, NULL, '{\"x\":2082,\"y\":570}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(223, 58, NULL, '{\"x\":2036,\"y\":663}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(224, 58, NULL, '{\"x\":1969,\"y\":814}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(225, 58, NULL, '{\"x\":1923,\"y\":938}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(226, 58, NULL, '{\"x\":1872,\"y\":1104}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(227, 58, 13, '{\"x\":2133,\"y\":591}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(228, 58, 11, '{\"x\":2026,\"y\":548}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(229, 58, 10, '{\"x\":2082,\"y\":682}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(230, 58, 8, '{\"x\":1914,\"y\":790}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(231, 58, NULL, '{\"x\":1951,\"y\":862}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(232, 58, 9, '{\"x\":2019,\"y\":892}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
INSERT INTO `building_navigation_node` (`node_id`, `floor_id`, `element_id`, `node_coordinate`, `node_updated`, `node_registered`) VALUES
	(233, 58, 7, '{\"x\":1991,\"y\":955}', '2013-04-24 12:08:43', '2013-04-24 11:43:31');
/*!40000 ALTER TABLE `building_navigation_node` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2837 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.debug: ~4 rows (approximately)
/*!40000 ALTER TABLE `debug` DISABLE KEYS */;
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES
	(2833, 937, 1, 'Array\n(\n    [0] => Building map url\n    [1] => http://maps.googleapis.com/maps/api/staticmap?sensor=false&size=200x100&\n)\n', '/users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php', 309, '#1 DebugException->__construct /users/kristofferskarbo/dropbox/scripting/krisskarbo/krisskarboapi/src/exception/debug_exception.php:16\n#2 BuildingCmsImageController->createBuildingMapUrl /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:309\n#3 BuildingCmsImageController->before /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:337\n#4 AbstractApi->doControllerViewRender /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:530\n#5 AbstractApi->doRequest /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:507', '#0 /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php(337): BuildingCmsImageController->createBuildingMapUrl()\n#1 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(530): BuildingCmsImageController->before()\n#2 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(507): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#3 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/CampusGuide/image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', 'string, string', '2013-06-12 01:55:33');
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES
	(2834, 938, 1, 'Array\n(\n    [0] => Building map url\n    [1] => http://maps.googleapis.com/maps/api/staticmap?sensor=false&size=200x100&\n)\n', '/users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php', 309, '#1 DebugException->__construct /users/kristofferskarbo/dropbox/scripting/krisskarbo/krisskarboapi/src/exception/debug_exception.php:16\n#2 BuildingCmsImageController->createBuildingMapUrl /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:309\n#3 BuildingCmsImageController->before /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:337\n#4 AbstractApi->doControllerViewRender /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:530\n#5 AbstractApi->doRequest /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:507', '#0 /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php(337): BuildingCmsImageController->createBuildingMapUrl()\n#1 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(530): BuildingCmsImageController->before()\n#2 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(507): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#3 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/CampusGuide/image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', 'string, string', '2013-06-12 01:57:25');
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES
	(2835, 939, 1, 'Array\n(\n    [0] => Building map url\n    [1] => http://maps.googleapis.com/maps/api/staticmap?sensor=false&size=200x100&\n)\n', '/users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php', 309, '#1 DebugException->__construct /users/kristofferskarbo/dropbox/scripting/krisskarbo/krisskarboapi/src/exception/debug_exception.php:16\n#2 BuildingCmsImageController->createBuildingMapUrl /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:309\n#3 BuildingCmsImageController->before /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:337\n#4 AbstractApi->doControllerViewRender /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:530\n#5 AbstractApi->doRequest /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:507', '#0 /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php(337): BuildingCmsImageController->createBuildingMapUrl()\n#1 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(530): BuildingCmsImageController->before()\n#2 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(507): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#3 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/CampusGuide/image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', 'string, string', '2013-06-12 03:35:11');
INSERT INTO `debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES
	(2836, 940, 1, 'Array\n(\n    [0] => Building map url\n    [1] => http://maps.googleapis.com/maps/api/staticmap?sensor=false&size=200x100&\n)\n', '/users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php', 309, '#1 DebugException->__construct /users/kristofferskarbo/dropbox/scripting/krisskarbo/krisskarboapi/src/exception/debug_exception.php:16\n#2 BuildingCmsImageController->createBuildingMapUrl /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:309\n#3 BuildingCmsImageController->before /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php:337\n#4 AbstractApi->doControllerViewRender /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:530\n#5 AbstractApi->doRequest /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php:507', '#0 /users/kristofferskarbo/dropbox/scripting/krisskarbo/campusguide/src/controller/image/cms/building_cms_image_controller.php(337): BuildingCmsImageController->createBuildingMapUrl()\n#1 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(530): BuildingCmsImageController->before()\n#2 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/krisskarboapi/src/api/api/abstract_api.php(507): AbstractApi->doControllerViewRender(Object(BuildingCmsImageController))\n#3 /Users/kristofferskarbo/Dropbox/Scripting/KrisSkarbo/CampusGuide/image.php(140): AbstractApi->doRequest(Array)\n#4 {main}', 'string, string', '2013-06-12 03:35:14');
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
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=utf8;


-- Dumping structure for table campusguide_test.facility
DROP TABLE IF EXISTS `facility`;
CREATE TABLE `facility` (
  `facility_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `facility_name` varchar(255) NOT NULL,
  `facility_updated` datetime DEFAULT NULL,
  `facility_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`facility_id`)
) ENGINE=InnoDB AUTO_INCREMENT=778 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.facility: ~1 rows (approximately)
/*!40000 ALTER TABLE `facility` DISABLE KEYS */;
INSERT INTO `facility` (`facility_id`, `facility_name`, `facility_updated`, `facility_registered`) VALUES
	(777, 'Test Facility', NULL, '2013-04-01 14:08:58');
/*!40000 ALTER TABLE `facility` ENABLE KEYS */;


-- Dumping structure for table campusguide_test.log
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(50) NOT NULL,
  `log_text` varchar(255) NOT NULL,
  `website_id` smallint(6) DEFAULT NULL,
  `schedule_type` varchar(50) DEFAULT NULL,
  `log_updated` datetime DEFAULT NULL,
  `log_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `website_id` (`website_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.log: ~48 rows (approximately)
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(1, 'schedule_type', 'Parsed 27 room\'s on page(s) 1, 2, 3 of 13', 1, 'room', NULL, '2013-04-14 11:52:34');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(2, 'schedule_type', 'Parsed 30 room\'s on page(s) 4, 5, 6 of 13', 1, 'room', NULL, '2013-04-14 12:04:08');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(3, 'schedule_type', 'Parsed 30 room\'s on page(s) 7, 8, 9 of 13', 1, 'room', NULL, '2013-04-14 12:04:19');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(4, 'schedule_type', 'Parsed 30 room\'s on page(s) 10, 11, 12 of 13', 1, 'room', NULL, '2013-04-14 12:04:34');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(5, 'schedule_type', 'Parsed 7 room\'s on page(s) 13 of 13', 1, 'room', NULL, '2013-04-14 12:04:38');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(6, 'schedule_type', 'Parsed 27 faculty\'s on page(s) 1, 2, 3 of 40', 1, 'faculty', NULL, '2013-04-14 12:05:35');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(7, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 4, 5, 6 of 40', 1, 'faculty', NULL, '2013-04-14 12:05:40');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(8, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 7, 8, 9 of 40', 1, 'faculty', NULL, '2013-04-14 12:05:46');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(9, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 10, 11, 12 of 40', 1, 'faculty', NULL, '2013-04-14 12:05:50');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(10, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 13, 14, 15 of 40', 1, 'faculty', NULL, '2013-04-14 12:05:53');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(11, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 16, 17, 18 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:02');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(12, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 19, 20, 21 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:06');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(13, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 22, 23, 24 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:09');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(14, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 25, 26, 27 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:13');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(15, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 28, 29, 30 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:19');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(16, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 31, 32, 33 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:50');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(17, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 34, 35, 36 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:54');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(18, 'schedule_type', 'Parsed 30 faculty\'s on page(s) 37, 38, 39 of 40', 1, 'faculty', NULL, '2013-04-14 12:06:58');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(19, 'schedule_type', 'Parsed 2 faculty\'s on page(s) 40 of 40', 1, 'faculty', NULL, '2013-04-14 12:07:00');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(20, 'schedule_type', 'Parsed 28 group\'s on page(s) 1, 2, 3 of 27', 1, 'group', NULL, '2013-04-14 12:07:03');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(21, 'schedule_type', 'Parsed 30 group\'s on page(s) 4, 5, 6 of 27', 1, 'group', NULL, '2013-04-14 12:07:06');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(22, 'schedule_type', 'Parsed 30 group\'s on page(s) 7, 8, 9 of 27', 1, 'group', NULL, '2013-04-14 12:07:09');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(23, 'schedule_type', 'Parsed 30 group\'s on page(s) 10, 11, 12 of 27', 1, 'group', NULL, '2013-04-14 12:07:13');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(24, 'schedule_type', 'Parsed 30 group\'s on page(s) 13, 14, 15 of 27', 1, 'group', NULL, '2013-04-14 12:07:16');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(25, 'schedule_type', 'Parsed 30 group\'s on page(s) 16, 17, 18 of 27', 1, 'group', NULL, '2013-04-14 12:07:20');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(26, 'schedule_type', 'Parsed 30 group\'s on page(s) 19, 20, 21 of 27', 1, 'group', NULL, '2013-04-14 12:07:23');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(27, 'schedule_type', 'Parsed 30 group\'s on page(s) 22, 23, 24 of 27', 1, 'group', NULL, '2013-04-14 12:07:26');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(28, 'schedule_type', 'Parsed 30 group\'s on page(s) 25, 26, 27 of 27', 1, 'group', NULL, '2013-04-14 12:07:29');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(29, 'schedule_type', 'Parsed 8 group\'s on page(s) 28 of 27', 1, 'group', NULL, '2013-04-14 12:07:31');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(30, 'schedule_type', 'Parsed 13 program\'s on page(s) 1, 2, 3 of 56', 1, 'program', NULL, '2013-04-14 12:07:34');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(31, 'schedule_type', 'Parsed 30 program\'s on page(s) 4, 5, 6 of 56', 1, 'program', NULL, '2013-04-14 12:07:37');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(32, 'schedule_type', 'Parsed 30 program\'s on page(s) 7, 8, 9 of 56', 1, 'program', NULL, '2013-04-14 12:07:42');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(33, 'schedule_type', 'Parsed 30 program\'s on page(s) 10, 11, 12 of 56', 1, 'program', NULL, '2013-04-14 12:07:45');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(34, 'schedule_type', 'Parsed 30 program\'s on page(s) 13, 14, 15 of 56', 1, 'program', NULL, '2013-04-14 12:07:50');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(35, 'schedule_type', 'Parsed 30 program\'s on page(s) 16, 17, 18 of 56', 1, 'program', NULL, '2013-04-14 12:07:53');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(36, 'schedule_type', 'Parsed 30 program\'s on page(s) 19, 20, 21 of 56', 1, 'program', NULL, '2013-04-14 12:07:58');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(37, 'schedule_type', 'Parsed 30 program\'s on page(s) 22, 23, 24 of 56', 1, 'program', NULL, '2013-04-14 12:08:01');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(38, 'schedule_type', 'Parsed 29 program\'s on page(s) 25, 26, 27 of 56', 1, 'program', NULL, '2013-04-14 12:08:06');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(39, 'schedule_type', 'Parsed 30 program\'s on page(s) 28, 29, 30 of 56', 1, 'program', NULL, '2013-04-14 12:08:11');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(40, 'schedule_type', 'Parsed 30 program\'s on page(s) 31, 32, 33 of 56', 1, 'program', NULL, '2013-04-14 12:08:23');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(41, 'schedule_type', 'Parsed 30 program\'s on page(s) 34, 35, 36 of 56', 1, 'program', NULL, '2013-04-14 13:04:17');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(42, 'schedule_type', 'Parsed 30 program\'s on page(s) 37, 38, 39 of 56', 1, 'program', NULL, '2013-04-14 13:04:20');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(43, 'schedule_type', 'Parsed 30 program\'s on page(s) 40, 41, 42 of 56', 1, 'program', NULL, '2013-04-14 13:04:23');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(44, 'schedule_type', 'Parsed 30 program\'s on page(s) 43, 44, 45 of 56', 1, 'program', NULL, '2013-04-14 13:04:26');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(45, 'schedule_type', 'Parsed 30 program\'s on page(s) 46, 47, 48 of 56', 1, 'program', NULL, '2013-04-14 13:04:30');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(46, 'schedule_type', 'Parsed 30 program\'s on page(s) 49, 50, 51 of 56', 1, 'program', NULL, '2013-04-14 13:04:33');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(47, 'schedule_type', 'Parsed 30 program\'s on page(s) 52, 53, 54 of 56', 1, 'program', NULL, '2013-04-14 13:04:36');
INSERT INTO `log` (`log_id`, `log_type`, `log_text`, `website_id`, `schedule_type`, `log_updated`, `log_registered`) VALUES
	(48, 'schedule_type', 'Parsed 12 program\'s on page(s) 55, 56 of 56', 1, 'program', NULL, '2013-04-14 13:04:41');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.queue: ~1 rows (approximately)
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` (`queue_id`, `queue_type`, `queue_priority`, `queue_arguments`, `building_id`, `website_id`, `schedule_type`, `queue_occurence`, `queue_error`, `queue_updated`, `queue_registered`) VALUES
	(1, 'building', 0, 'size%5B0%5D=200&size%5B1%5D=100', 645, NULL, NULL, 1, 0, NULL, '2013-06-12 01:53:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_faculty: ~389 rows (approximately)
/*!40000 ALTER TABLE `schedule_faculty` DISABLE KEYS */;
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(1, 1, NULL, 4122000, '', 'Aasen Arne', 'AAA', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(2, 1, NULL, 343000, '', 'Bjørkum Alvhild', 'AAB', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(3, 1, NULL, 334000, '', 'Akselsen Are', 'AAK', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(4, 1, NULL, 2259000, '', 'AAO', 'AAO', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(5, 1, NULL, 2523000, '', 'Birkeland Åsta', 'ABI', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(6, 1, NULL, 2524000, '', 'Birketveit, Anna', 'ABIR', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(7, 1, NULL, 344000, '', 'Bjørset Arve', 'ABJ', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(8, 1, NULL, 2287000, '', 'Anna Brattestad', 'ABR', '', '', NULL, '2013-04-14 12:05:34');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(9, 1, NULL, 401000, '', 'Kosinska Anna D.', 'ADK', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(10, 1, NULL, 2525000, '', 'Mørkrid, Ann Elin', 'AEM', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(11, 1, NULL, 2526000, '', 'Freng, Ada', 'AFR', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(12, 1, NULL, 3785000, '', 'aga', 'aga', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(13, 1, NULL, 361000, '', 'Geitung Atle', 'AGE', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(14, 1, NULL, 2738000, '', 'Eriksen Anne Grete', 'AGER', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(15, 1, NULL, 362000, '', 'Gjerde Asbjørn', 'AGJ', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(16, 1, NULL, 368000, '', 'Halvorsen Arne', 'AHA', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(17, 1, NULL, 379000, '', 'Hodzic Adis', 'AHO', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(18, 1, NULL, 388000, '', 'Instanes Arne', 'AINS', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(19, 1, NULL, 2177000, '', 'Anne Karin Eide', 'AKE', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(20, 1, NULL, 4032000, '', 'KumarAjith', 'AKU', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(21, 1, NULL, 406000, '', 'Kvamme Aasmund', 'AKV', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(22, 1, NULL, 410000, '', 'Leiknes Arve', 'ALE', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(23, 1, NULL, 359000, '', 'Fuglestad Arnt L', 'ALF', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(24, 1, NULL, 395000, '', 'Kampen Anne Lena', 'ALK', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(25, 1, NULL, 369000, '', 'Hashemi Amir Masso', 'AMH', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(26, 1, NULL, 4052000, '', 'Hassas Amir', 'AMIH', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(27, 1, NULL, 3236000, '', 'Lyng Ane', 'AMLY', '', '', NULL, '2013-04-14 12:05:35');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(28, 1, NULL, 420000, '', 'Myking Arvid', 'AMY', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(29, 1, NULL, 2178000, '', 'Audun Pedersen', 'APE', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(30, 1, NULL, 3051000, '', 'Høyland Arnstein', 'ARH', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(31, 1, NULL, 431000, '', 'Rutle Adrian', 'ARU', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(32, 1, NULL, 3453000, '', 'Ryningen Anita', 'ARY', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(33, 1, NULL, 434000, '', 'Sangolt Anny', 'ASA', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(34, 1, NULL, 432000, '', 'Sahajpal Anurag', 'ASAH', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(35, 1, NULL, 4031000, '', 'Bjelland, Anne Sofie Handal', 'ASHB', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(36, 1, NULL, 2795000, '', 'Student assistent', 'assistent', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(37, 1, NULL, 2313000, '', 'Anne Sverdrup', 'ASV', '', '', NULL, '2013-04-14 12:05:39');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(38, 1, NULL, 3421000, '', 'Sæbø Arild', 'ASÆ', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(39, 1, NULL, 2281000, '', 'Haugsdal Arnt-Tore', 'ATH', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(40, 1, NULL, 2390000, '', 'Åsen Arne', 'AÅS', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(41, 1, NULL, 456000, '', 'Aadland Børge', 'BAA', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(42, 1, NULL, 2988000, '', 'Bakke', 'Bakke', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(43, 1, NULL, 2295000, '', 'BEV', 'BEV', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(44, 1, NULL, 365000, '', 'Grung Bjørn', 'BGR', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(45, 1, NULL, 4036000, '', 'Henriksen, Bård', 'BHE', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(46, 1, NULL, 3903000, '', 'Bibliotek', 'Bibliotek', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(47, 1, NULL, 397000, '', 'Kileng Bjarte', 'BKI', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(48, 1, NULL, 341000, '', 'Bjarte Sivertsen', 'BSI', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(49, 1, NULL, 561000, '', 'Tessem Bjørnar', 'BTE', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(50, 1, NULL, 2715000, '', 'Tysseland Bernt', 'BTY', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(51, 1, NULL, 3683000, '', 'Bygstad Arne', 'BygstArne', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(52, 1, NULL, 1344000, '', 'Ahmer Carolyn', 'CAH', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(53, 1, NULL, 3933000, '', 'Bernt, Camilla', 'CBE', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(54, 1, NULL, 342000, '', 'Bjelland Cato', 'CBJ', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(55, 1, NULL, 453000, '', 'Waage Christina Brautaset', 'CBW', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(56, 1, NULL, 381000, '', 'Hosfeld Camilla', 'CDH', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(57, 1, NULL, 375000, '', 'Helgesen Carsten', 'CHE', '', '', NULL, '2013-04-14 12:05:40');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(58, 1, NULL, 2216000, '', 'CHH', 'CHH', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(59, 1, NULL, 411000, '', 'Lien Christian', 'CLI', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(60, 1, NULL, 3931000, '', 'Stokkevåg, Camilla', 'CST', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(61, 1, NULL, 413000, '', 'Lønning Dag A.', 'DAL', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(62, 1, NULL, 4136000, '', 'Blehr Dagfinn', 'DBL', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(63, 1, NULL, 337000, '', 'Bakka Dag E.', 'DEB', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(64, 1, NULL, 2187000, '', 'Diverse', 'Diverse', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(65, 1, NULL, 3711000, '', 'DraLærer21', 'DraLærer02', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(66, 1, NULL, 3705000, '', 'DraLærer1', 'DraLærer1', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(67, 1, NULL, 3707000, '', 'DraLærer3', 'DraLærer3', '', '', NULL, '2013-04-14 12:05:45');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(68, 1, NULL, 2309000, '', 'Adachi Einar', 'EAD', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(69, 1, NULL, 613000, '', 'Gjesdal Elna A.', 'EAG', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(70, 1, NULL, 2566000, '', 'Bergsvik, Eli', 'EBE', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(71, 1, NULL, 423000, '', 'Norman Eva B', 'EBN', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(72, 1, NULL, 3690000, '', 'Bratland E.', 'EBR', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(73, 1, NULL, 350000, '', 'Cimpan E.', 'ECI', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(74, 1, NULL, 3947000, '', 'Eikeland Erik', 'EEIK', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(75, 1, NULL, 2401000, '', 'Ersvær Elisabeth', 'EER', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(76, 1, NULL, 391000, '', 'Johannessen Einar Georg', 'EGJ', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(77, 1, NULL, 364000, '', 'Grahl Madsen Elisabeth', 'EGM', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(78, 1, NULL, 3996000, '', 'Grong, Erlend', 'EGO', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(79, 1, NULL, 3052000, '', 'Holst Erik', 'EHO', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(80, 1, NULL, 545000, '', 'Kildal Eivind', 'EKI', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(81, 1, NULL, 430000, '', 'Rem Eli Lindblad', 'ELR', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(82, 1, NULL, 586000, '', 'Røynstrand E.', 'ERØY', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(83, 1, NULL, 2402000, '', 'Sørheim Edel', 'ESØ', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(84, 1, NULL, 2737000, '', 'Rønneseth Eva', 'EVR', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(85, 1, NULL, 3862000, '', 'Boge Fredrik', 'FBO', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(86, 1, NULL, 1185000, '', 'Conrad Finn Thor', 'FCO', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(87, 1, NULL, 4035000, '', 'Jouleh, Farzan', 'FJU', '', '', NULL, '2013-04-14 12:05:46');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(88, 1, NULL, 3238000, '', 'Kutschwa Frode', 'FKU', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(89, 1, NULL, 3556000, '', 'Mantz, Florian', 'FMA', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(90, 1, NULL, 3725000, '', 'ForL05', 'ForL05', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(91, 1, NULL, 3718000, '', 'ForL101', 'ForL101', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(92, 1, NULL, 3720000, '', 'FyFoL36', 'FyFoL36', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(93, 1, NULL, 3732000, '', 'FysFoL2', 'FysFoL2', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(94, 1, NULL, 3786000, '', 'GAG', 'GAG1', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(95, 1, NULL, 2154000, '', 'Gunhild', 'GAU', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(96, 1, NULL, 1358000, '', 'Haugen Gry', 'GHA', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(97, 1, NULL, 2675000, '', 'Heimly Gisle', 'GHEI', '', '', NULL, '2013-04-14 12:05:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(98, 1, NULL, 596000, '', 'Gholamali Kamalkhani', 'GHK', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(99, 1, NULL, 591000, '', 'Gjerde Asbjørn', 'GJER', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(100, 1, NULL, 595000, '', 'Jevne Geir', 'GJEV', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(101, 1, NULL, 394000, '', 'Kamalkhani Gholamali', 'GKAM', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(102, 1, NULL, 1327000, '', 'Guillermo Leiva', 'GLE', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(103, 1, NULL, 3122000, '', 'Lyngvær Guttorm', 'GLY', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(104, 1, NULL, 360000, '', 'Førland Geir Martin', 'GMF', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(105, 1, NULL, 3484000, '', 'Nielsen Gert', 'GNI', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(106, 1, NULL, 340000, '', 'Berland Geir Omar', 'GOB', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(107, 1, NULL, 1364000, '', 'Sjøholt Gry', 'GSJ', '', '', NULL, '2013-04-14 12:05:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(108, 1, NULL, 4106000, '', 'Taenzer Gabriele', 'GTA', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(109, 1, NULL, 3509000, '', 'Tenge Gunnar', 'GTE', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(110, 1, NULL, 3579000, '', 'Tunestveit Gunnar', 'GTU', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(111, 1, NULL, 2292000, '', 'HAF', 'HAF', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(112, 1, NULL, 2153000, '', 'Hans Martin Straume', 'HAS', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(113, 1, NULL, 352000, '', 'Drange Hans Birger', 'HBD', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(114, 1, NULL, 346000, '', 'Bjånesø Henry', 'HBJ', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(115, 1, NULL, 345000, '', 'Bjørstad Heidi', 'HBJO', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(116, 1, NULL, 441000, '', 'Soleim Harald', 'HBS', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(117, 1, NULL, 2159000, '', 'HCH', 'HCH', '', '', NULL, '2013-04-14 12:05:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(118, 1, NULL, 3928000, '', 'Duesund, Hilde', 'HDU', '', '', NULL, '2013-04-14 12:05:51');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(119, 1, NULL, 3174000, '', 'Erdal Hege', 'HEER', '', '', NULL, '2013-04-14 12:05:51');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(120, 1, NULL, 356000, '', 'Flornes Hans', 'HFL', '', '', NULL, '2013-04-14 12:05:51');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(121, 1, NULL, 357000, '', 'Fosse Haldor', 'HFOS', '', '', NULL, '2013-04-14 12:05:51');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(122, 1, NULL, 568000, '', 'Grahl-Madsen H.', 'HGH', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(123, 1, NULL, 3927000, '', 'Haflidason, Haflidi', 'HHA', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(124, 1, NULL, 560000, '', 'Helstrup Håvard', 'HHE', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(125, 1, NULL, 2898000, '', 'Jonsdottir Helga', 'HJO', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(126, 1, NULL, 1386000, '', 'Kløften Hilde', 'HKL', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(127, 1, NULL, 416000, '', 'Momeni Hassan', 'HMO', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(128, 1, NULL, 614000, '', 'Straume Hans Martin', 'HMS', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(129, 1, NULL, 1407000, '', 'Norheim Henning', 'HNO', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(130, 1, NULL, 425000, '', 'Nysæter Helge', 'HNY', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(131, 1, NULL, 2598000, '', 'Rørvik, Hedvig Kristin', 'HRO', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(132, 1, NULL, 367000, '', 'H.Stord/haugesund', 'HSH', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(133, 1, NULL, 2412000, '', 'Skramstad, Heidi', 'HSK', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(134, 1, NULL, 3583000, '', 'Larsen Ingrid Anette', 'IAL', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(135, 1, NULL, 363000, '', 'Glenjen Ingunn', 'IGLE', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(136, 1, NULL, 366000, '', 'Gurvin Ingmund', 'IGU', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(137, 1, NULL, 2161000, '', 'Ingeleiv Haugen', 'IHA', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(138, 1, NULL, 389000, '', 'Janson Inger', 'IJA', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(139, 1, NULL, 551000, '', 'Kalland Ivar', 'IKA', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(140, 1, NULL, 2150000, '', 'Ingvild Monsen', 'IMO', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(141, 1, NULL, 2278000, '', 'Ingeleiv Haugen', 'INH', '', '', NULL, '2013-04-14 12:05:52');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(142, 1, NULL, 4041000, '', 'Haaland, Ingvild', 'INHA', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(143, 1, NULL, 424000, '', 'Nygård Irene', 'INY', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(144, 1, NULL, 3293000, '', 'Simonsen Inge', 'ISI', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(145, 1, NULL, 2855000, '', 'Valland Ingunn', 'IVA', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(146, 1, NULL, 449000, '', 'Vivås Inge', 'IVI', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(147, 1, NULL, 603000, '', 'Aadland Jon', 'JAA', '', '', NULL, '2013-04-14 12:05:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(148, 1, NULL, 459000, '', 'Aarstad Jarle', 'JAAR', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(149, 1, NULL, 553000, '', 'Bogevik Jon Arne', 'JAB', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(150, 1, NULL, 3552000, '', 'Alme Johan', 'JAL', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(151, 1, NULL, 588000, '', 'Arnes J.', 'JARN', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(152, 1, NULL, 3510000, '', 'Bakke Jan', 'JBA', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(153, 1, NULL, 383000, '', 'Husebø Jan Bernt', 'JBH', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(154, 1, NULL, 2305000, '', 'Diesen Jarle', 'JDI', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(155, 1, NULL, 546000, '', 'Vatne Jon Eivind', 'JEV', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(156, 1, NULL, 3517000, '', 'Kogstad John Gunnar', 'JGK', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(157, 1, NULL, 372000, '', 'Haugen Johannes', 'JHA', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(158, 1, NULL, 393000, '', 'Jørgensen Johnny A.', 'JJO', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(159, 1, NULL, 3536000, '', 'Fosse Jens Kristian', 'JKF', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(160, 1, NULL, 3929000, '', 'Aasen, Johanne L.', 'JLAA', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(161, 1, NULL, 392000, '', 'Johannessen Jan Martin', 'JMJ', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(162, 1, NULL, 3653000, '', 'Økland, Jan-Magnus', 'JMØ', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(163, 1, NULL, 1400000, '', 'Mjånes Jan Ove', 'JOM', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(164, 1, NULL, 2686000, '', 'Heggholmen Kari', 'KAHE', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(165, 1, NULL, 396000, '', 'Khalid Azim Mughal', 'KAMU', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(166, 1, NULL, 605000, '', 'Arntzen Kai', 'KAR', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(167, 1, NULL, 3863000, '', 'Rostad Kari', 'KARO', '', '', NULL, '2013-04-14 12:06:01');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(168, 1, NULL, 3916000, '', 'Vik, Knut-Arne', 'KAV', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(169, 1, NULL, 2163000, '', 'KBE', 'KBE', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(170, 1, NULL, 422000, '', 'Nilsen Kari Birkeland', 'KBN', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(171, 1, NULL, 3686000, '', 'Keith Terry', 'KeithTe', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(172, 1, NULL, 398000, '', 'Kismul Knut Erik', 'KEK', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(173, 1, NULL, 378000, '', 'Hetland Kristin Fanebust', 'KFH', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(174, 1, NULL, 348000, '', 'Børve Kari Grete Nordli', 'KGNB', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(175, 1, NULL, 3512000, '', 'Gravelsæter Kjetil', 'KGRA', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(176, 1, NULL, 371000, '', 'Hauge Kåre Johan', 'KHA', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(177, 1, NULL, 376000, '', 'Helland Knut', 'KHE', '', '', NULL, '2013-04-14 12:06:02');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(178, 1, NULL, 450000, '', 'Voldsund Kari Håvåg', 'KHV', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(179, 1, NULL, 3662000, '', 'Simonsen Kent Inge', 'KIS', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(180, 1, NULL, 2175000, '', 'Kjell Håland', 'KJE', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(181, 1, NULL, 380000, '', 'Holmås Karl Johan', 'KJH', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(182, 1, NULL, 2431000, '', 'Karlsen, Kari', 'KKAR', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(183, 1, NULL, 405000, '', 'Kvamme Kristin', 'KKV', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(184, 1, NULL, 3524000, '', 'Klassestyrt', 'klassen', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(185, 1, NULL, 3572000, '', 'Lysaker Kirsti', 'KLY', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(186, 1, NULL, 3917000, '', 'Leirvik, Kim Nes', 'KNL', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(187, 1, NULL, 3592000, '', 'Nummedal Karl Olav', 'KON', '', '', NULL, '2013-04-14 12:06:04');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(188, 1, NULL, 455000, '', 'Øvsthus Knut', 'KOVS', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(189, 1, NULL, 1184000, '', 'Robbersmyr Kjell', 'KRO', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(190, 1, NULL, 3689000, '', 'Rostad Kari', 'KROS', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(191, 1, NULL, 1339000, '', 'Røed Ketil', 'KRØ', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(192, 1, NULL, 2214000, '', 'KSH', 'KSH', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(193, 1, NULL, 3582000, '', 'Sønnesyn Karoline', 'KSO', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(194, 1, NULL, 2992000, '', 'Karl Tore Hareide', 'KTHA', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(195, 1, NULL, 452000, '', 'Weydahl Karl', 'KWE', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(196, 1, NULL, 567000, '', 'Jordanger Lars Arne', 'LAJ', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(197, 1, NULL, 415000, '', 'Mjøs Leiv B.', 'LBM', '', '', NULL, '2013-04-14 12:06:05');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(198, 1, NULL, 338000, '', 'Berg Lars E.', 'LEB', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(199, 1, NULL, 4051000, '', 'Ekroll Lars', 'LEK', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(200, 1, NULL, 353000, '', 'Elvestad Leif', 'LEL', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(201, 1, NULL, 428000, '', 'Otterå Leif Erik', 'LEO', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(202, 1, NULL, 616000, '', 'Helgeland Lars', 'LHE', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(203, 1, NULL, 2676000, '', 'Kristensen Lars', 'LKR', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(204, 1, NULL, 1359000, '', 'Nerheim Lars Magne', 'LMN', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(205, 1, NULL, 2389000, '', 'Lossius Laila', 'LOL', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(206, 1, NULL, 377000, '', 'Helland Lars Petter', 'LPH', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(207, 1, NULL, 437000, '', 'Sivertsen Lasse', 'LSI', '', '', NULL, '2013-04-14 12:06:06');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(208, 1, NULL, 3219000, '', 'Skordal Linda', 'LSK', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(209, 1, NULL, 444000, '', 'Stokke Leif', 'LSTO', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(210, 1, NULL, 2166000, '', 'MAA', 'MAA', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(211, 1, NULL, 2181000, '', 'Marit Hagevik', 'MAH', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(212, 1, NULL, 2779000, '', 'Sælås Magnhild', 'MASE', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(213, 1, NULL, 3737000, '', 'MatL1', 'MatL1', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(214, 1, NULL, 3738000, '', 'MatL2', 'MatL2', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(215, 1, NULL, 3721000, '', 'MatL203', 'MatL203', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(216, 1, NULL, 3739000, '', 'MatL3', 'MatL3', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(217, 1, NULL, 3740000, '', 'MatL4', 'MatL4', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(218, 1, NULL, 339000, '', 'Berge Magnar', 'MBE', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(219, 1, NULL, 2273000, '', 'Marit Breivik', 'MBR', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(220, 1, NULL, 2731000, '', 'Kahrs Mette Dyksteen', 'MDK', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(221, 1, NULL, 417000, '', 'Monstad Mons E.', 'MEM', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(222, 1, NULL, 3253000, '', 'Parker Matthew Geoffrey', 'MGP', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(223, 1, NULL, 412000, '', 'Lossius Magni Hope', 'MHL', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(224, 1, NULL, 419000, '', 'Murugendran Kanagasundram', 'MKAN', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(225, 1, NULL, 403000, '', 'Kramer Marianne', 'MKRA', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(226, 1, NULL, 617000, '', 'Larsen-Eak M.', 'MLE', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(227, 1, NULL, 555000, '', 'Lie Martin', 'MLIE', '', '', NULL, '2013-04-14 12:06:08');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(228, 1, NULL, 2291000, '', 'Mathiesen Mathias', 'MMA', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(229, 1, NULL, 418000, '', 'Morå Morten', 'MMOR', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(230, 1, NULL, 2180000, '', 'Marianne Nilsen', 'MNI', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(231, 1, NULL, 429000, '', 'Rafii Masoud', 'MRT', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(232, 1, NULL, 3182000, '', 'Simonsen Martin', 'MSI', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(233, 1, NULL, 442000, '', 'Soosaipillai Manuelpillai', 'MSOO', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(234, 1, NULL, 3700000, '', 'MusLærer1', 'MusLærer1', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(235, 1, NULL, 3706000, '', 'MusLærerNN', 'MusLærerNN', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(236, 1, NULL, 458000, '', 'Aarskog Nina', 'NAAR', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(237, 1, NULL, 3714000, '', 'NatL302', 'NatL302', '', '', NULL, '2013-04-14 12:06:09');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(238, 1, NULL, 3715000, '', 'NatL303', 'NatL303', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(239, 1, NULL, 3713000, '', 'NatL305', 'NatL305', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(240, 1, NULL, 3712000, '', 'NatL315', 'NatL315', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(241, 1, NULL, 609000, '', 'Dyrøy Nils', 'NDY', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(242, 1, NULL, 2192000, '', 'NHY', 'NHY', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(243, 1, NULL, 3299000, '', 'Lummen Norbert', 'NLU', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(244, 1, NULL, 1198000, '', 'Ardestani, Nafez', 'NMA', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(245, 1, NULL, 2488000, '', 'Nina Misje Heggøy', 'NMH', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(246, 1, NULL, 550000, '', 'NN', 'NN', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(247, 1, NULL, 564000, '', 'NN1', 'NN1', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(248, 1, NULL, 2235000, '', 'Timelærer kjemi', 'NN1-1', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(249, 1, NULL, 604000, '', 'NN10', 'NN10', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(250, 1, NULL, 1191000, '', 'NN11 vikar maskin- og marin', 'NN11', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(251, 1, NULL, 1183000, '', 'nn12', 'nn12', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(252, 1, NULL, 1194000, '', 'NN13-lab.ass.', 'NN13', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(253, 1, NULL, 2162000, '', 'Timelærer bygg', 'NN2', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(254, 1, NULL, 2164000, '', 'Timelærer bygg', 'NN2-1', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(255, 1, NULL, 2167000, '', 'Timelærer bygg', 'NN2-2', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(256, 1, NULL, 2170000, '', 'Timelærer bygg - FOA161', 'NN2-3', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(257, 1, NULL, 2173000, '', 'Timelærer bygg', 'NN2-4', '', '', NULL, '2013-04-14 12:06:12');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(258, 1, NULL, 566000, '', 'NN3', 'NN3', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(259, 1, NULL, 2141000, '', 'timelærer.øk.adm', 'NN3-1', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(260, 1, NULL, 573000, '', 'NN4', 'NN4', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(261, 1, NULL, 577000, '', 'NN6 mat-lab. data- realfag', 'NN6', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(262, 1, NULL, 592000, '', 'NN.mas.1.kl', 'NN8', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(263, 1, NULL, 594000, '', 'maskin 2.kl.', 'NN9', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(264, 1, NULL, 582000, '', 'NN biolab', 'NNbio', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(265, 1, NULL, 1402000, '', 'NNN', 'NNN', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(266, 1, NULL, 1405000, '', 'NNNN', 'NNNN', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(267, 1, NULL, 336000, '', 'Antonsen Nils Ottar', 'NOA', '', '', NULL, '2013-04-14 12:06:13');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(268, 1, NULL, 2151000, '', 'Nils Riise', 'NRI', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(269, 1, NULL, 597000, '', 'Nymann NN', 'NYMA', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(270, 1, NULL, 349000, '', 'Bøe Olav', 'OBØ', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(271, 1, NULL, 2363000, '', 'Døsvig Ole', 'ODØ', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(272, 1, NULL, 3311000, '', 'Smistad Odd E.', 'OES', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(273, 1, NULL, 2714000, '', 'Bergfjord Ole Jacob', 'OJB', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(274, 1, NULL, 2743000, '', 'Gjellestad Odd Johan', 'OJG', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(275, 1, NULL, 387000, '', 'Innselset Olav Jon', 'OJI', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(276, 1, NULL, 407000, '', 'Kvammen Ove Jan', 'OJK', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(277, 1, NULL, 544000, '', 'Olav Jan Skomedal', 'OJS', '', '', NULL, '2013-04-14 12:06:18');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(278, 1, NULL, 3746000, '', 'Kvalheim Olav', 'OKV', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(279, 1, NULL, 454000, '', 'Øgreid Odd Magne', 'OMØ', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(280, 1, NULL, 1385000, '', 'Olsen Ove Tvedt', 'OTO', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(281, 1, NULL, 2663000, '', 'Michelsen, Per Arne', 'PAM', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(282, 1, NULL, 3901000, '', 'Moen Per Aas', 'PAMO', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(283, 1, NULL, 426000, '', 'Olsen Pål Albert', 'PAO', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(284, 1, NULL, 3733000, '', 'PedL1', 'PedL1', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(285, 1, NULL, 3734000, '', 'PedL2', 'PedL2', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(286, 1, NULL, 3735000, '', 'PedL3', 'PedL3', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(287, 1, NULL, 3736000, '', 'PedL4', 'PedL4', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(288, 1, NULL, 3722000, '', 'PedL406', 'PedL406', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(289, 1, NULL, 2301000, '', 'Ellingsen Pål', 'PELL', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(290, 1, NULL, 602000, '', 'Haaland Per', 'PHAA', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(291, 1, NULL, 390000, '', 'Jensen Per Ivar', 'PIJ', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(292, 1, NULL, 3423000, '', 'Kazmierczak Piotr', 'PKA', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(293, 1, NULL, 402000, '', 'Kosinski Pavel', 'PKO', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(294, 1, NULL, 440000, '', 'Sky Per Kåre', 'PKS', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(295, 1, NULL, 4088000, '', 'Sæterdal Petter', 'PNS', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(296, 1, NULL, 2404000, '', 'Praksislærer', 'Praksislær', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(297, 1, NULL, 435000, '', 'Seip Petter', 'PSE', '', '', NULL, '2013-04-14 12:06:19');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(298, 1, NULL, 569000, '', 'Thorvaldsen Per', 'PTH', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(299, 1, NULL, 2380000, '', 'Gjengedal Ragnar', 'RAG', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(300, 1, NULL, 385000, '', 'Imstøl Rolf Cato', 'RCI', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(301, 1, NULL, 2143000, '', 'Monsen Remy', 'REM', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(302, 1, NULL, 358000, '', 'Fosse Rune', 'RFO', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(303, 1, NULL, 3655000, '', 'Gjesdal, Reidar', 'RGJE', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(304, 1, NULL, 2250000, '', 'Hovland Randi', 'RHO', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(305, 1, NULL, 2282000, '', 'Riera Susana Constanza', 'Riera', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(306, 1, NULL, 399000, '', 'Kjepso Richard', 'RKJ', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(307, 1, NULL, 2937000, '', 'Rolv Kleven', 'RKL', '', '', NULL, '2013-04-14 12:06:48');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(308, 1, NULL, 414000, '', 'Løvaas Rune', 'RLØ', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(309, 1, NULL, 409000, '', 'Laurantsen Roald', 'ROLA', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(310, 1, NULL, 611000, '', 'Pettersen Ragnar', 'RPET', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(311, 1, NULL, 2277000, '', 'Ragnhild Tangen', 'RTA', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(312, 1, NULL, 2176000, '', 'Rune Tjøsvold', 'RTJ', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(313, 1, NULL, 354000, '', 'Engeseth Svein Atle', 'SAE', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(314, 1, NULL, 2138000, '', 'Stud.ass. Øk.adm', 'SAØA', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(315, 1, NULL, 2152000, '', 'Stein Eilertsen', 'SEI', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(316, 1, NULL, 3647000, '', 'Jacobsen Stig Erik', 'SEJ', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(317, 1, NULL, 355000, '', 'Fivelstad Sveinung', 'SFI', '', '', NULL, '2013-04-14 12:06:49');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(318, 1, NULL, 433000, '', 'Samnøy Stig F.', 'SFS', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(319, 1, NULL, 382000, '', 'Hove Svein', 'SHOV', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(320, 1, NULL, 439000, '', 'Skjelde Sissel H.', 'SHS', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(321, 1, NULL, 2760000, '', 'Döpper Siran', 'SID', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(322, 1, NULL, 1336000, '', 'Lillehaug Svein Ivar', 'SIL', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(323, 1, NULL, 557000, '', 'Lillehaug', 'SILer', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(324, 1, NULL, 386000, '', 'Indrebø Stig', 'SIN', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(325, 1, NULL, 3934000, '', 'Mykland, Solfrid', 'SMY', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(326, 1, NULL, 384000, '', 'Høyland Sven-Olai', 'SOH', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(327, 1, NULL, 427000, '', 'Opdal Svein Ole', 'SOO', '', '', NULL, '2013-04-14 12:06:50');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(328, 1, NULL, 1374000, '', 'Kleppe Svein Rune', 'SRK', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(329, 1, NULL, 3209000, '', 'Kalvenes Sigurd Risa', 'SRKA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(330, 1, NULL, 446000, '', 'Såkvitne Sveinung', 'SSA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(331, 1, NULL, 370000, '', 'Hasund Solfrid Sjåstad', 'SSH', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(332, 1, NULL, 443000, '', 'Steinkopf Signe', 'SST', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(333, 1, NULL, 445000, '', 'Syrrist Signe', 'SSY', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(334, 1, NULL, 2424000, '', 'Studentassistent', 'STUDASS', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(335, 1, NULL, 3097000, '', 'student', 'student', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(336, 1, NULL, 2713000, '', 'Studentassisent', 'Studentass', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(337, 1, NULL, 2403000, '', 'Vannes Solveig', 'SVA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(338, 1, NULL, 451000, '', 'Wangsholm Solveig', 'SWA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(339, 1, NULL, 4050000, '', 'SWECO', 'SWECO', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(340, 1, NULL, 4053000, '', 'Aasebø Thomas', 'TAA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(341, 1, NULL, 347000, '', 'Braseth Turid Aarhus', 'TAB', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(342, 1, NULL, 549000, '', 'Heggernes Tarjei', 'TAH', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(343, 1, NULL, 2182000, '', 'Torunn Åkra', 'TAK', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(344, 1, NULL, 612000, '', 'Bjuland Terje', 'TBU', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(345, 1, NULL, 351000, '', 'Dahle Torstein', 'TDA', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(346, 1, NULL, 4037000, '', 'Fykse, Terje', 'TFY', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(347, 1, NULL, 1387000, '', 'Førde Trond', 'TFØ', '', '', NULL, '2013-04-14 12:06:53');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(348, 1, NULL, 558000, '', 'Gjesteland T', 'TGJ', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(349, 1, NULL, 2395000, '', 'Haugen Thomas', 'THAU', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(350, 1, NULL, 3879000, '', 'Røkenes Tone Helene Bergset', 'THBR', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(351, 1, NULL, 3654000, '', 'Impelluso Thomas J.', 'TJI', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(352, 1, NULL, 404000, '', 'Kristensen Terje', 'TKR', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(353, 1, NULL, 587000, '', 'Lisæth T.', 'TLIS', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(354, 1, NULL, 1343000, '', 'Bell Tord Myking', 'TMB', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(355, 1, NULL, 421000, '', 'Natås Terje M.', 'TMN', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(356, 1, NULL, 3951000, '', 'Nordås, Tonje', 'TNO', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(357, 1, NULL, 2285000, '', 'Torill Olsen', 'TOL', '', '', NULL, '2013-04-14 12:06:54');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(358, 1, NULL, 4045000, '', 'Nordås Tonje', 'TONO', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(359, 1, NULL, 438000, '', 'Skauge Tom', 'TOS', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(360, 1, NULL, 2148000, '', 'Tor Visnes', 'TOV', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(361, 1, NULL, 2932000, '', 'Rahman Talal', 'TRA', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(362, 1, NULL, 436000, '', 'Simonsen Terje', 'TSI', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(363, 1, NULL, 1182000, '', 'Skøld Torun', 'TSK', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(364, 1, NULL, 3589000, '', 'Skøld Torunn', 'TSO', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(365, 1, NULL, 447000, '', 'Trovik Trym', 'TTR', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(366, 1, NULL, 1243000, '', 'Trengereid Terje', 'TTRE', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(367, 1, NULL, 2179000, '', 'Turid Visnes', 'TVI', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(368, 1, NULL, 2243000, '', 'Tore Willy Monsen', 'TWM', '', '', NULL, '2013-04-14 12:06:57');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(369, 1, NULL, 559000, '', 'Ågotnes Thomas', 'TÅG', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(370, 1, NULL, 3096000, '', 'Hovland Dag', 'uib-DHO', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(371, 1, NULL, 448000, '', 'Velauthapillai, Dhayalan', 'VDH', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(372, 1, NULL, 2761000, '', 'Vervik', 'Vervik', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(373, 1, NULL, 2699000, '', 'Popsueva Victoria', 'VIP', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(374, 1, NULL, 2140000, '', 'Norman Victor', 'VNO', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(375, 1, NULL, 2231000, '', 'VRS', 'VRS', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(376, 1, NULL, 1401000, '', 'WR Ansatt AI', 'WrAnsAI', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(377, 1, NULL, 3681000, '', 'X', 'X_', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(378, 1, NULL, 3716000, '', 'Y', 'Y_', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(379, 1, NULL, 408000, '', 'Lamo Yngve', 'YLA', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(380, 1, NULL, 3173000, '', 'Villlanger Yngve', 'YVI', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(381, 1, NULL, 3259000, '', 'Wang YI', 'YWA', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(382, 1, NULL, 2358000, '', 'Tikvesa Zenja', 'ZET', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(383, 1, NULL, 3661000, '', 'Aarthun Ørjan', 'ØAA', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(384, 1, NULL, 335000, '', 'Amland Øystein', 'ØAM', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(385, 1, NULL, 2381000, '', 'Fyllingen Ørjan', 'ØFY', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(386, 1, NULL, 3581000, '', 'Haaland Øystein', 'ØHA', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(387, 1, NULL, 1335000, '', 'Jakobsson Øyvind', 'ØJA', '', '', NULL, '2013-04-14 12:06:58');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(388, 1, NULL, 400000, '', 'Knapskog Øyvind', 'ØKN', '', '', NULL, '2013-04-14 12:07:00');
INSERT INTO `schedule_faculty` (`faculty_id`, `website_id`, `room_id`, `faculty_code`, `faculty_type`, `faculty_name`, `faculty_name_short`, `faculty_phone`, `faculty_email`, `faculty_updated`, `faculty_registered`) VALUES
	(389, 1, NULL, 2308000, '', 'Sunde Øyvind', 'ØSU', '', '', NULL, '2013-04-14 12:07:00');
/*!40000 ALTER TABLE `schedule_faculty` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=utf8 COMMENT='Class/group';


-- Dumping data for table campusguide_test.schedule_group: ~268 rows (approximately)
/*!40000 ALTER TABLE `schedule_group` DISABLE KEYS */;
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(1, 1, 269000, '3 kl. Øk.adm (Adm. og ledelse)', '05HADM', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(2, 1, 270000, '3 kl. Bio', '05HBIO', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(3, 1, 331000, '3 kl. Bygg', '05HBYG', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(4, 1, 272000, '3 kl. Data, fordypning i datafag', '05HDATA', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(5, 1, 274000, '3 kl. Automatisering', '05HEAU', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(6, 1, 275000, '3 kl. Elektronikk', '05HEEL', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(7, 1, 277000, '3 kl. El.kraft', '05HELK', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(8, 1, 278000, '3.kl. Energiteknologi', '05HETK', '2013-04-14 12:07:31', '2013-04-14 12:07:02');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(9, 1, 327000, '3 kl. Havbruksteknologi', '05HHAV', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(10, 1, 332000, '3 kl. Informasjonsteknologi', '05HINF', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(11, 1, 280000, '3 kl. Kjemi', '05HKJE', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(12, 1, 276000, '3 kl. Kommunikasjonsteknologi', '05HKOM', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(13, 1, 282000, '3 kl. Allmenn maskinteknikk', '05HMAM', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(14, 1, 283000, '3 kl. Marinteknologi', '05HMMT', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(15, 1, 1328000, 'Markedsføring / Personaladministrasjon', '05HMPA', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(16, 1, 284000, '3 kl. Produksjonsteknikk', '05HMPR', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(17, 1, 286000, '3 kl. Øk.adm (Regnskap)', '05HREGN', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(18, 1, 287000, '3 kl. Øk.adm (samfunnsøkonomi)', '05HSAMFØ', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(19, 1, 289000, '3 kl. Bygg', '06HBY', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(20, 1, 2119000, '3 kl. Logistikk', '06HLOG', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(21, 1, 1380000, 7, 7, NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(22, 1, 297000, '3 kl. Havbruksteknologi', '07HHAV', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(23, 1, 3179000, 'Fordypning i markedsføring', '07HMAR', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(24, 1, 306000, '3 .kl.Bio.', '08HBIO', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(25, 1, 290000, '3 kl. Bygg A+B', '08HBYGG', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(26, 1, 309000, '3 kl. Data', '08HDATA', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(27, 1, 310000, '3 kl. Automatisering', '08HEAU', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(28, 1, 311000, '3 kl. Elektronikk', '08HEEL', NULL, '2013-04-14 12:07:03');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(29, 1, 312000, '1.års påbygning Eiendomsfag', '08HEIE', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(30, 1, 313000, '3 kl. El.kraft', '08HELK', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(31, 1, 314000, '3 kl. Energiteknologi', '08HETK', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(32, 1, 315000, '3 kl. Havbruksteknologi', '08HHAV', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(33, 1, 316000, '3 kl. Informasjonsteknologi', '08HINF', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(34, 1, 317000, '3 kl. Kjemi', '08HKJE', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(35, 1, 318000, '3 kl. Kommunikasjonsteknonlogi', '08HKOM', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(36, 1, 291000, '3 kl. Landmåling og eiendomsdesign', '08HLEIE', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(37, 1, 320000, '3 kl. Allmenn maskinteknikk', '08HMAM', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(38, 1, 3545000, 'Fordypning i markedsføring', '08HMAR', NULL, '2013-04-14 12:07:05');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(39, 1, 321000, '3 kl. Marinteknikk', '08HMMT', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(40, 1, 322000, '3 kl. Produksjonsteknikk', '08HMPR', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(41, 1, 333000, '3 kl. Undervannsteknologi, drift og vedlikehold', '08HUVT', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(42, 1, 2120000, '3 klasse Bio.', '09HBIO', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(43, 1, 307000, '3 klasse Bygg', '09HBYG', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(44, 1, 308000, '2. kl. Bygg B', '09HBYGB', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(45, 1, 2123000, '3 klasse DATA', '09HDATA', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(46, 1, 2124000, '3 klasse Automatisering', '09HEAU', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(47, 1, 2125000, '3 klasse Elektronikk', '09HEEL', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(48, 1, 2126000, '3 klasse El.kraft', '09HELK', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(49, 1, 2127000, '3 klasse Energiteknologi', '09HETK', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(50, 1, 2128000, '1 kl. Havbruksteknologi', '09HHAV', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(51, 1, 2129000, '3 klasse Informasjonsteknologi', '09HINF', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(52, 1, 2130000, '3 klasse Kjemi', '09HKJE', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(53, 1, 2131000, '3 klasse Kommunikasjonsteknonlogi', '09HKOM', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(54, 1, 319000, '3 klasse Landmåling og eiendomsdesign', '09HLEIE', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(55, 1, 2133000, '3 klasse Allmenn maskinteknikk', '09HMAM', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(56, 1, 3915000, 'Fordypning i markedsføring 3. klasse øk.adm.', '09HMAR', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(57, 1, 2134000, '3 klasse Marinteknologi', '09HMMT', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(58, 1, 2135000, '3 klasse Produksjonsteknikk', '09HMPR', NULL, '2013-04-14 12:07:06');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(59, 1, 3483000, 'Master entrepenørskap 2. klasse', '09HMScINNO', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(60, 1, 2137000, '3 klasse Undervannsteknologi, drift og vedlikehold', '09HUVT', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(61, 1, 328000, '2 kl. Økonomisk- administrative fag', '09HØA3', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(62, 1, 1340000, 'Realfagskurs vår08', '09VRealfag', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(63, 1, 329000, '3 kl. Administrasjon og ledelse', '10HADM', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(64, 1, 288000, '2. Klasse Bioingeniør', '10HBIO', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(65, 1, 2121000, '2. Klasse.BYGG', '10HBYG', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(66, 1, 2122000, '2. Klasse BYGG B', '10HBYGB', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(67, 1, 292000, '3. Klasse Data', '10HDATA', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(68, 1, 293000, '3. Klasse Automatisering', '10HEAU', NULL, '2013-04-14 12:07:08');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(69, 1, 294000, '3. Klasse Elektronikk', '10HEEL', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(70, 1, 295000, '3. Klasse El.kraft', '10HELK', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(71, 1, 296000, '3. Klasse Energiteknologi', '10HETK', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(72, 1, 298000, '3. Klasse Informasjonsteknologi', '10HINF', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(73, 1, 2139000, '3 kl Fordypning i innovasjon og entreprenørskap', '10HINNO', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(74, 1, 300000, '3. Klasse Kjemiingeniør', '10HKJE', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(75, 1, 301000, '32. Klasse Kommunikasjonsteknonlogi', '10HKOM', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(76, 1, 2132000, '3. Kl. Landmåling og eiendomsdesign', '10HLEIE', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(77, 1, 281000, '3 kl. Logistikk', '10HLOG', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(78, 1, 302000, '3. Klasse Allmenn maskinteknikk', '10HMAM', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(79, 1, 303000, '3. Klasse Marinteknikk', '10HMMT', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(80, 1, 304000, '3. Klasse Produksjonsteknikk', '10HMPR', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(81, 1, 3086000, 'Master entrepenørskap 2. klasse', '10HMSCINN', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(82, 1, 3831000, 'Master Undervannsteknologi', '10HMUVT', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(83, 1, 2118000, '3 kl. Regnskap', '10HREGN', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(84, 1, 2117000, '3 kl. Samfunnsøkonomi', '10HSAMFØ', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(85, 1, 2868000, '3. Klasse undervannsteknologi, drift og vedlikehold', '10HUVT', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(86, 1, 2136000, '2. Klasse økonomiske- administrative fag', '10HØA3', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(87, 1, 3642000, '2. Klasse bioingeniør', '11HBIO', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(88, 1, 3627000, '2.klasse Bygg A', '11HBYGA', NULL, '2013-04-14 12:07:09');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(89, 1, 3628000, '2.Klasse Bygg B', '11HBYGB', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(90, 1, 3630000, '2. Klasse Data', '11HDATA', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(91, 1, 3638000, '2. Klasse automatisering', '11HEAU', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(92, 1, 3639000, '2. Klasse elektronikk', '11HEEL', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(93, 1, 3641000, '2. Klasse el.kraft', '11HELK', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(94, 1, 3637000, '2. Klasse energiteknologi', '11HETK', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(95, 1, 3631000, '2. Klasse Informasjonsteknologi', '11HINF', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(96, 1, 3643000, '2. Klasse kjemiingeniør', '11HKJE', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(97, 1, 3640000, '2. Klasse kommunikasjonsteknologi', '11HKOM', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(98, 1, 3629000, '2. Klasse Eiendomsdesign', '11HLEIE', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(99, 1, 3633000, '2.Klasse Almenn maskinfag', '11HMAM', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(100, 1, 3634000, '2. Klasse marinfag', '11HMMT', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(101, 1, 3635000, '2. Klasse produksjonsteknikk', '11HMPR', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(102, 1, 3646000, 'Master Entrepenørskap 2. klasse', '11HMSCINN', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(103, 1, 606000, 'Pedagogikk klasse A + B', '11HPED', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(104, 1, 3636000, '2. Klasse undervannsteknologi', '11HUVT', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(105, 1, 3632000, '2. Klasse økonomiske- og administrative fag', '11HØA3', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(106, 1, 3570000, 'Realfagskurs vår 2011', '11VREAL', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(107, 1, 3983000, '1. klasse Bioingeniør', '12HBIO', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(108, 1, 3977000, '1. klasse Byggfag A', '12HBYGA', NULL, '2013-04-14 12:07:12');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(109, 1, 3978000, '1. klasse Byggfag B', '12HBYGB', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(110, 1, 3980000, '1. klasse Data', '12HDATA', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(111, 1, 3987000, '1. klasse Automatisering', '12HEAU', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(112, 1, 3986000, '1. klasse Elektrofag', '12HEEL', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(113, 1, 3988000, '1. klasse EL-kraft', '12HELK', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(114, 1, 3974000, '1. Klasse Energiteknologi', '12HETK', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(115, 1, 3981000, '1. klasse Informasjonsteknologi', '12HINF', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(116, 1, 3982000, '1. klasse Kjemiingeniør', '12HKJE', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(117, 1, 3985000, '1. klasse Kommunikasjonsteknologi', '12HKOM', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(118, 1, 3979000, '1. klasse Landmåling og Eiendomsdesign', '12HLEIE', NULL, '2013-04-14 12:07:13');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(119, 1, 3999000, '1. klasse allmenn maskin', '12HMAM', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(120, 1, 3973000, '1. Klasse Marinteknikk', '12HMMT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(121, 1, 3975000, '1. klasse produksjonsteknikk', '12HMPR', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(122, 1, 4000000, '1. klasse Master i Entrepenørskap', '12HMSCINN', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(123, 1, 3976000, '1. klasse Undervannsteknologi', '12HUVT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(124, 1, 3984000, '1. klasse Økonomiske- og Administrative fag', '12HØA3', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(125, 1, 3926000, 'Realfagskurs vår 2012', '12VREAL', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(126, 1, 3834000, 'ADFERDSVANSKER', 'ADFVANKL', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(127, 1, 3867000, 'BOGULIT', 'BOGULIT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(128, 1, 3787000, 'FOLKEHELS1', 'FHA1', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(129, 1, 3788000, 'FOLKEHELS2', 'FHA2', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(130, 1, 3789000, 'FOLKEHELS3', 'FHA3', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(131, 1, 3727000, 'FØU2K', 'FØU2K', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(132, 1, 3703000, 'FØU3DEL', 'FØU3_DEL', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(133, 1, 3769000, 'FØU3 DE YNGSTE BIB', 'FØU3DEYNGB', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(134, 1, 4006000, 'FØU3FYSAKT', 'FØU3FYSAKT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(135, 1, 4004000, 'FØU3KULT', 'FØU3KULT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(136, 1, 3768000, 'FØU3 PED LED', 'FØU3PEDL', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(137, 1, 3767000, 'FØU3 SPRÅK KULT', 'FØU3SPRK', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(138, 1, 3765000, 'FØU3 UTEFAG', 'FØU3UT', NULL, '2013-04-14 12:07:15');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(139, 1, 4007000, 'FØU4DEL18', 'FØU4DEL18', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(140, 1, 4003000, 'FØU4DEL8', 'FØU4DEL8', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(141, 1, 3823000, 'GLU 1-7 1 MUS', 'GB1F-MUS', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(142, 1, 3777000, 'GLU 1-7 2 ENG', 'GB2A-ENG', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(143, 1, 3779000, 'GLU1-7 2 NAT', 'GB2B-NAT', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(144, 1, 3782000, 'GLU1-7 2 KRØV', 'GB2C-KRØ', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(145, 1, 3780000, 'GLU1-7 2 RLE', 'GB2D-RLE', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(146, 1, 3801000, 'GLU 1-7 2 SAM', 'GB2E-SAM', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(147, 1, 3778000, 'GLU1-7 2 MAHE', 'GB2F-MH', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(148, 1, 3828000, 'GLU 1-7 2MUS', 'GB2F-MUS', NULL, '2013-04-14 12:07:16');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(149, 1, 4080000, 'GB3A-NOR', 'GB3A-NOR', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(150, 1, 4081000, 'GB3B-MAT', 'GB3B-MAT', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(151, 1, 4082000, 'GB3C-SAM', 'GB3C-SAM', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(152, 1, 4083000, 'GB3D-ENG1', 'GB3D-ENG1', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(153, 1, 4105000, 'GB3D-ENG2', 'GB3D-ENG2', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(154, 1, 4085000, 'GB3D-MH', 'GB3D-MH', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(155, 1, 4084000, 'GB3D-MUS', 'GB3D-MUS', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(156, 1, 4144000, 'GLU-Bachelor oppg', 'GLUBachlor', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(157, 1, 3811000, 'GLU510 1KL V2 ENGELSK', 'GU1-ENG', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(158, 1, 3813000, 'GLU510 1KL V2 KUH', 'GU1-KH', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(159, 1, 3810000, 'GLU510 1KL V2 NATURF', 'GU1-NAT', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(160, 1, 3809000, 'GLU510 1KL V2 NORSK', 'GU1-NOR', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(161, 1, 3812000, 'GLU510 1KL V2 RLE', 'GU1-RLE', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(162, 1, 3791000, 'GLU 5-10 1MA', 'GU1A-MAT', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(163, 1, 3792000, 'GLU 5- 10 1SA 50', 'GU1B-SAM', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(164, 1, 3790000, 'GLU 5-10 1 NO', 'GU1C-NO', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(165, 1, 3793000, 'GLU 5-10 1MH', 'GU1D-MH', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(166, 1, 3824000, 'GLU 5-10 1MUS', 'GU1D-MUS', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(167, 1, 3799000, 'GLU 5-10 2.kl V2 EN', 'GU2-ENG', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(168, 1, 3814000, 'GLU510 2KL V2 KUNST HV', 'GU2-KH', NULL, '2013-04-14 12:07:19');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(169, 1, 3798000, 'GLU 5-10 2.kl V2 NA', 'GU2-NAT', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(170, 1, 3797000, 'GLU 5-10 2.kl V2 NO', 'GU2-NO', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(171, 1, 3800000, 'GLU 5-10 2.kl V2 RLE', 'GU2-RLE', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(172, 1, 3815000, 'GLU510 2KL V1 MATTE', 'GU2A-MAT', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(173, 1, 3816000, 'GLU510 2KL V1 SAMF', 'GU2B-SAM', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(174, 1, 3817000, 'GLU510 2KL V1 NORSK', 'GU2C-NO', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(175, 1, 3819000, 'GLU510 2KL V1 MAT HELSE', 'GU2D-MH', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(176, 1, 3818000, 'GLU510 2KL V1 MUSIKK', 'GU2D-MUS', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(177, 1, 4102000, 'GU3A-KH', 'GU3A-KH', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(178, 1, 4099000, 'GU3A-NOR', 'GU3A-NOR', NULL, '2013-04-14 12:07:20');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(179, 1, 4100000, 'GU3B-MAT', 'GU3B-MAT', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(180, 1, 4101000, 'GU3C-SAM', 'GU3C-SAM', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(181, 1, 4103000, 'GU3D-MH', 'GU3D-MH', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(182, 1, 4104000, 'GU3D-MUS', 'GU3D-MUS', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(183, 1, 3504000, 'Erasmus student Chemical Engineering', 'H10ESC', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(184, 1, 3835000, 'LESEOPPLÆRING', 'LESOPPL', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(185, 1, 4111000, 'Master i samffag', 'MASSAMF', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(186, 1, 326000, 'Master Datafag', 'MASTERDATA', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(187, 1, 574000, 'MAT.LAB.', 'MATLAB', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(188, 1, 4120000, 'MAUND2', 'MAUND2', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(189, 1, 3943000, 'MAUNDEL', 'MAUNDEL', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(190, 1, 3873000, 'PED UTV BARNEHG', 'PUB', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(191, 1, 3842000, 'RÅDGIVNING1_2', 'RÅDG1_2', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(192, 1, 2147000, 'AI-Sommerstudenter', 'S08AISTUD', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(193, 1, 4118000, 'SA ANDRESPRÅKSPED', 'SAANDRESPR', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(194, 1, 3874000, 'BARUNGARB', 'SABUA', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(195, 1, 4115000, 'SAENG2', 'SAENG2', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(196, 1, 4149000, 'SAENGBARN', 'SAENGBARN', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(197, 1, 3857000, 'KOMP FOR KVALITET 1', 'SAKK1', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(198, 1, 3858000, 'KOMP FOR KVAL 2', 'SAKK2', NULL, '2013-04-14 12:07:22');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(199, 1, 4131000, 'SALESEKURS', 'SALESEKURS', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(200, 1, 4119000, 'SA LESEOPPL', 'SALESOPP', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(201, 1, 4116000, 'SAMAT1-1', 'SAMAT1-1', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(202, 1, 4126000, 'SAMATB30', 'SAMATB30', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(203, 1, 4150000, 'SAMATSMÅTR', 'SAMATSMÅTR', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(204, 1, 4154000, 'SAMENTOR', 'SAMENTOR', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(205, 1, 4114000, 'SA-NOR1', 'SANOR1', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(206, 1, 4153000, 'SANOR2', 'SANOR2', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(207, 1, 4152000, 'SANORSMÅTR', 'SANORSMÅTR', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(208, 1, 4134000, 'Samling ped 1 for tospråkelige', 'SAPEDTOSPR', NULL, '2013-04-14 12:07:23');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(209, 1, 4151000, 'SAV30PEDUTVF', 'SAPEDUTVBA', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(210, 1, 4127000, 'SAPUB', 'SAPUB', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(211, 1, 4117000, 'SARÅD1', 'SARÅD1', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(212, 1, 4138000, 'SARÅD2', 'SARÅD2', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(213, 1, 4128000, 'Samling småbarnsped', 'SASMBPED', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(214, 1, 4155000, 'SASYNSNEVROLOGI', 'SASYNSNEVR', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(215, 1, 4112000, 'Tilpasset opplæring samlinger', 'SATOP', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(216, 1, 4133000, 'Samling veiledning syst og gestalt', 'SAVEISG', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(217, 1, 2398000, 'UIB master Data', 'UMD', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(218, 1, 2757000, 'Erasmus Students Chemical Engineering', 'V09ESC', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(219, 1, 2515000, 'Pedagogikk', 'V09PED', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(220, 1, 2682000, 'Realfag', 'V09Realfag', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(221, 1, 3183000, 'Realfagskurs vår10', 'V10REAL', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(222, 1, 3841000, 'TILPASSET OPPLÆRING', 'V30TILOPPL', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(223, 1, 4109000, 'V60RLE-1', 'V60RLE-1', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(224, 1, 4110000, 'V60RLE-2', 'V60RLE-2', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(225, 1, 4107000, 'Samfunnsfag årsenhet med fordypn glob stud', 'V60SAM-G', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(226, 1, 4108000, 'Samfunnsfag årsenhet med fordypn historie', 'V60SAM-H', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(227, 1, 3890000, 'GluFølgegr', 'X68', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(228, 1, 3876000, 'GLSM PÅ BARNETRINNET', 'xBGLSM', NULL, '2013-04-14 12:07:25');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(229, 1, 3875000, 'BARNEHAGEPED', 'xBHGPED', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(230, 1, 3856000, 'DIGITAL KOMPETANSE', 'xDIGITKOMP', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(231, 1, 3685000, 'Ekstern1', 'xEkstBodPe', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(232, 1, 3687000, 'Ekstern01', 'xEkstern01', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(233, 1, 3898000, 'ENGBARNTR', 'xENGBARN', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(234, 1, 3904000, 'ENGBTR', 'xENGBTR', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(235, 1, 3741000, 'FØU1', 'xFØU_1', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(236, 1, 3742000, 'FØU2', 'xFØU2', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(237, 1, 3701000, 'FØU2F', 'xFØU2F', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(238, 1, 3743000, 'FØU3', 'xFØU3', NULL, '2013-04-14 12:07:26');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(239, 1, 4005000, 'FØU3SPRARB', 'xFØU3SPRAR', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(240, 1, 3888000, 'GLU1', 'xGLU1', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(241, 1, 3889000, 'GLU2', 'xGLU2', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(242, 1, 3882000, 'KORKURS', 'xKORKURS', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(243, 1, 3866000, 'KOR', 'xKORtbs', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(244, 1, 3843000, 'LESESRKIVE VANSK', 'xLESSKR_VA', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(245, 1, 3710000, 'MAS Dra', 'xMASDra', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(246, 1, 3864000, 'MASTER HISTORIE', 'xMASHIST', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(247, 1, 3877000, 'MATTE4', 'xMAT4', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(248, 1, 3881000, 'MATBARN', 'xMATBARN', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(249, 1, 3868000, 'NAFOL seminar', 'xNAFOL', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(250, 1, 3850000, 'NORSK SOM 2.SPRÅK', 'xNoSomAndS', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(251, 1, 3899000, 'PedStud', 'xPedStud', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(252, 1, 3883000, 'praksisteam', 'xPRAKTEAM', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(253, 1, 3937000, 'PUB NY', 'xPUBNY', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(254, 1, 3678000, 'ReaLise dagskonferanse', 'xReaLise', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(255, 1, 3852000, 'RESERV STUD START', 'xRSS', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(256, 1, 3853000, 'RSS1', 'xRSS1', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(257, 1, 3854000, 'RSS2', 'xRSS2', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(258, 1, 3855000, 'RSS3', 'xRSS3', NULL, '2013-04-14 12:07:28');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(259, 1, 3869000, 'RSS4', 'xRSS4', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(260, 1, 3844000, 'SKOLEBAS ALU3', 'xSALU3', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(261, 1, 3848000, 'SPRÅKDID FOR 2SPRL', 'xSPRÅKDID', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(262, 1, 3905000, 'Studenråd', 'XStudenråd', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(263, 1, 3728000, 'TestObj', 'xTestObj', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(264, 1, 3696000, 'TKL1', 'xTKLasse', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(265, 1, 3684000, 'UngdSkole', 'xU-skole', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(266, 1, 3872000, 'BARNHAGPED', 'XV30BAHAGP', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(267, 1, 3698000, 'Veil', 'xVeilednin', NULL, '2013-04-14 12:07:29');
INSERT INTO `schedule_group` (`group_id`, `website_id`, `group_code`, `group_name`, `group_name_short`, `group_updated`, `group_registered`) VALUES
	(268, 1, 2331000, 'Videreutdanning', 'xVidereutd', NULL, '2013-04-14 12:07:29');
/*!40000 ALTER TABLE `schedule_group` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=535 DEFAULT CHARSET=utf8 COMMENT='Course';


-- Dumping data for table campusguide_test.schedule_program: ~534 rows (approximately)
/*!40000 ALTER TABLE `schedule_program` DISABLE KEYS */;
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(1, 1, 153000, 'Fysikk videregående', '2FY', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(2, 1, 154000, 'Matte videregående', '2MX-3MX', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(3, 1, 1341000, '2MX/3MX', '2MX3MX', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(4, 1, 4014000, 'AA', 'AA', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(5, 1, 4013000, 'AAAA', 'AAAA', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(6, 1, 4016000, 'ABC', 'ABC', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(7, 1, 3833000, 'ADFERDSVANSKER', 'ADFVANS', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(8, 1, 4145000, 'Bacheloroppgaven', 'Bacoppg', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(9, 1, 6000, 'Cellebiologi, molekylærbiologi og genetikk', 'BIO001', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(10, 1, 7000, 'Anatomi, fysiologi og histologi', 'BIO002', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(11, 1, 8000, 'Etikk og kommunikasjon I', 'BIO003', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(12, 1, 9000, 'Matematikk og statistikk', 'BIO004', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(13, 1, 155000, 'Medisinsk lab. teknologi', 'BIO005', NULL, '2013-04-14 12:07:34');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(14, 1, 156000, 'Org. kjemi og biokjemi', 'BIO006', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(15, 1, 10000, 'Statistikk II', 'BIO007', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(16, 1, 11000, 'Hematololgi og hemostase', 'BIO008', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(17, 1, 12000, 'Mikrobiologi og immunologi', 'BIO009', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(18, 1, 157000, 'Transfusjonsmedisin', 'BIO010', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(19, 1, 13000, 'Cellebiologi, molekylbiologi og genetikk', 'BIO011', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(20, 1, 158000, 'Biokjemiske analysemetoder I', 'BIO012', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(21, 1, 247000, 'Biokjemiske analysemetoder II', 'BIO013', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(22, 1, 248000, 'Etikk og kommunikasjon II', 'BIO014', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(23, 1, 249000, 'Patologi', 'BIO015', NULL, '2013-04-14 12:07:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(24, 1, 250000, 'Medisinsk biokjemi med klinisk farmakologi og nukleærmedisin', 'BIO016', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(25, 1, 3688000, 'Matematikk', 'BIO018', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(26, 1, 1365000, 'Cellebiologi, molekylærbiologi og genetikk II', 'BIO020', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(27, 1, 246000, 'Cellebiologi, molekylærbiologi og genetikk', 'BIO021', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(28, 1, 3559000, 'Biokjemi', 'BIO022', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(29, 1, 3560000, 'Organisk kjemi', 'BIO023', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(30, 1, 149000, 'Molekylær Cellebiologi (Modul 3)', 'BIO110', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(31, 1, 4039000, 'Matematikk', 'BIO120', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(32, 1, 4038000, 'Anatomi, fysiologi og histologi', 'BIO121', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(33, 1, 4040000, 'Etikk og kommunikasjon', 'BIO122', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(34, 1, 619000, 'Fiskebiologi', 'BIO253', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(35, 1, 3561000, 'Bioinformatikk kurs', 'BIOINF', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(36, 1, 4030000, 'Materiallære for bygg', 'BYG101', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(37, 1, 4033000, 'Grunnleggende programmering', 'DAT100', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(38, 1, 4025000, 'Grunnleggende programmering', 'DATA100', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(39, 1, 3704000, 'DRA', 'DRA', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(40, 1, 2249000, 'E08', 'E08', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(41, 1, 264000, 'EDB-lab', 'EDB-lab', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(42, 1, 3989000, 'Grunnleggende elektrofag', 'ELE100', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(43, 1, 4034000, 'Grunnleggende elektrofag', 'ELE121', NULL, '2013-04-14 12:07:37');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(44, 1, 2758000, 'Entrepeneurship', 'ENT005', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(45, 1, 3487000, 'Practical Innovation Management', 'ENT4210', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(46, 1, 2183000, 'Fysioterapi 1 år', 'F08', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(47, 1, 3752000, 'MUSIKK 10SP', 'F10MUS08', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(48, 1, 3756000, 'RLE 12 SP', 'F12RLE09', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(49, 1, 3776000, 'DE YNGSTE BIB', 'F30DYB11', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(50, 1, 3753000, 'MUSIKK 30SP', 'F30MUS04', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(51, 1, 3773000, 'PED LED', 'F30PDLED11', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(52, 1, 3772000, 'SPRÅK KULT IB', 'F30SKB11', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(53, 1, 3771000, 'BARNAS LANDSKAP', 'F30UTF211', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(54, 1, 3757000, 'PED 45 SP', 'F45PD207', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(55, 1, 3770000, 'PED 45 SP', 'F45PD307', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(56, 1, 3760000, 'MATTE 10 SP', 'FD10MAT10', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(57, 1, 3759000, 'FYS FOS 12 SP', 'FD12FYF10', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(58, 1, 3758000, 'NAT FAG 13 SP', 'FD13NA10', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(59, 1, 3764000, 'SAMF FAG 13 SP', 'FD13SAM09', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(60, 1, 3761000, 'PED 45 SP', 'FD45PD209', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(61, 1, 3763000, 'PED 45 SP', 'FD45PD309', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(62, 1, 3508000, 'FELTKURS', 'FELTKURS', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(63, 1, 3821000, 'FH SAMPL SVIT MET', 'FHA407', NULL, '2013-04-14 12:07:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(64, 1, 3820000, 'FH STRAT HEL VT ETIKK', 'FHA509', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(65, 1, 3822000, 'FH MAT I KULT FORBR', 'FHA708', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(66, 1, 3830000, 'RLE 10 SP', 'FK10RLE09', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(67, 1, 3762000, 'PED 45 SP', 'FK45PD208', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(68, 1, 14000, 'Fysikk for data', 'FOA031', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(69, 1, 159000, 'Fysikk for el-fag', 'FOA032', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(70, 1, 160000, 'Fysikk/mekanikk', 'FOA033', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(71, 1, 161000, 'Fysikk for kjemi', 'FOA034', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(72, 1, 162000, 'Fysikk for akvakultur', 'FOA035', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(73, 1, 2681000, 'Fysikk for elektronikk og kommunikasjon', 'FOA036', NULL, '2013-04-14 12:07:42');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(74, 1, 15000, 'Innføring i bedriftsøkonomi', 'FOA040', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(75, 1, 16000, 'Organisering, styring og ledelse i prosjekter', 'FOA041', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(76, 1, 17000, 'Nyskaping og entreprenørskap', 'FOA042', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(77, 1, 257000, 'Grunnkurs i integrert prosjektgjennomføring og ledelse', 'FOA043', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(78, 1, 1362000, 'Nyskaping og entreprenørskap', 'FOA044', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(79, 1, 2261000, 'Grunnkurs integrert prosjektgjennomføring', 'FOA045', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(80, 1, 2930000, 'Nyskaping, entrepenørskap og etikk', 'FOA046', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(81, 1, 18000, 'Kjemi og miljø', 'FOA052', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(82, 1, 2741000, 'Kjemi og miljø', 'FOA053', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(83, 1, 19000, 'Grunnleggende databehandling', 'FOA063', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(84, 1, 163000, 'Datateknikk', 'FOA081', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(85, 1, 20000, 'Datateknikk', 'FOA082', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(86, 1, 3185000, 'Datateknikk', 'FOA091', NULL, '2013-04-14 12:07:44');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(87, 1, 21000, 'Matematisk analyse og vektoralgebra', 'FOA150', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(88, 1, 570000, 'Matematisk analyse og vektoralgebra', 'FOA151', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(89, 1, 565000, 'Matematisk analyse og vektoralgebra', 'FOA152', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(90, 1, 571000, 'Matematisk analyse og diskret matematikk', 'FOA153', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(91, 1, 556000, 'Diskret matematikk', 'FOA154', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(92, 1, 590000, 'Matematisk analyse og vektoralgebra', 'FOA157', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(93, 1, 22000, 'Videregående analyse og lineær algebra', 'FOA161', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(94, 1, 2239000, 'Videregående analyse og lineær algebra', 'FOA162', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(95, 1, 164000, 'Videregående analyse og linær A', 'FOA163', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(96, 1, 165000, 'Diskret matematikk og lineær algebra', 'FOA164', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(97, 1, 166000, 'Linær algebra', 'FOA165', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(98, 1, 24000, 'Differensialligninger og databehandling', 'FOA166', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(99, 1, 1354000, 'Videregående analyse og linær algebra', 'FOA167', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(100, 1, 256000, 'Differensialligninger og databehandling', 'FOA168', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(101, 1, 1334000, 'Matematisk analyse og lineær algebra', 'FOA169', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(102, 1, 25000, 'Sannsynlighetsregning og statistikk', 'FOA172', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(103, 1, 26000, 'Statistikk', 'FOA173', NULL, '2013-04-14 12:07:45');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(104, 1, 27000, 'Diskret matematikk I og lineær algebra', 'FOA180', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(105, 1, 167000, 'Diskret matematikk II, sannsynlighetsregning og statistikk', 'FOA181', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(106, 1, 28000, 'Matematikk for havbrukstenologi', 'FOA182', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(107, 1, 29000, 'Differensial- og integralregning', 'FOA183', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(108, 1, 2254000, 'Matematisk analyse og vektoralgebra', 'FOA191', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(109, 1, 23000, 'Videregående analyse og lineær algebra', 'FOA192', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(110, 1, 2857000, 'Differensialligninger Datateknikk', 'FOA193', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(111, 1, 2386000, 'Diffrensialligninger', 'FOA194', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(112, 1, 4130000, 'FORKURS', 'FORKURS', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(113, 1, 4129000, 'FORKURS-REGNØVELSE', 'FORKURSRØ', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(114, 1, 3723000, 'Form', 'Form', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(115, 1, 3717000, 'Forming', 'Forming', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(116, 1, 3724000, 'FormingF', 'FormingF', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(117, 1, 151000, 'Fransk kurs', 'FRANSK', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(118, 1, 30000, 'Mattematikk I', 'FVA141', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(119, 1, 31000, 'Mattematikk II', 'FVA142', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(120, 1, 32000, 'Engelsk', 'FVA150', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(121, 1, 33000, 'Spansk', 'FVA151', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(122, 1, 34000, 'Studentbedrift', 'FVA152', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(123, 1, 3774000, 'FYS FOS', 'FYFO', NULL, '2013-04-14 12:07:49');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(124, 1, 3719000, 'FysFos', 'FysFos', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(125, 1, 3837000, 'KRØV', 'GBKR11', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(126, 1, 3783000, 'SAMF FAG 15 SP', 'GBSF1111', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(127, 1, 3825000, 'GEHØR', 'GEHØR', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(128, 1, 1237000, 'Gruppearbeid', 'GruppeArb', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(129, 1, 615000, 'Senesterstart', 'H07OPPMØTE', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(130, 1, 168000, 'Hovedprosjekt Bygg', 'HOB110', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(131, 1, 1337000, 'Hovedprosjekt Data- og realfag', 'HOD190', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(132, 1, 1391000, 'Hovedprosjekt', 'HOE076', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(133, 1, 169000, 'Hovedprosjekt 05HJOR', 'HOJ200', NULL, '2013-04-14 12:07:50');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(134, 1, 170000, 'Hovedprosjekt LEIE', 'HOJ202', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(135, 1, 2732000, 'Hovedprosjekt', 'HOK120', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(136, 1, 171000, 'Hovedprosjekt bio', 'HOK341', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(137, 1, 251000, 'Bacheloroppgave', 'HOK343', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(138, 1, 172000, 'Hovedprosjekt Maskin- og marinfag', 'HOM140', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(139, 1, 3865000, 'IDR509', 'IDR509', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(140, 1, 2903000, 'Funksjonell programmering', 'INF121A', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(141, 1, 3172000, 'Nettverk', 'INF142A', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(142, 1, 3664000, 'INF220', 'INF220', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(143, 1, 3663000, 'INF225', 'INF225', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(144, 1, 3425000, 'INF226', 'INF226', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(145, 1, 3424000, 'INF234', 'INF234', NULL, '2013-04-14 12:07:52');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(146, 1, 3426000, 'INF252', 'INF252', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(147, 1, 1395000, 'INFO møte', 'INFOmøte', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(148, 1, 4046000, 'Teknologiledelse, økonomi og nyskapning', 'ING101', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(149, 1, 4024000, 'Ingeniørfaglig yrkesutøvelse og arbeidsmetoder for datafag', 'ING102', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(150, 1, 4021000, 'Ingeniørfaglig innføringsemne', 'ING103', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(151, 1, 4065000, 'Innføring i ingeniørfaglige emner', 'ING104', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(152, 1, 4008000, 'Innføringsemne Maskin- og marine fag', 'ING105', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(153, 1, 4125000, 'Innføringsemne for bygg', 'ING106', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(154, 1, 3939000, 'Integreringsdag', 'INTSDAG', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(155, 1, 4020000, 'Generell kjemi', 'KJE100', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(156, 1, 4023000, 'Kjemometri', 'KJE225', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(157, 1, 3745000, 'PLANLEGGING AV EKSPERIMENT OG ANALYSE AV FLERVARIABLE DATA', 'KJEM225', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(158, 1, 3523000, 'Klassens timer', 'Klasstimer', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(159, 1, 3840000, 'KOMPONERING', 'KOMP', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(160, 1, 3533000, 'Komplekse tall', 'Kompltall', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(161, 1, 3679000, 'KonferanseRL', 'KONFRL', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(162, 1, 3839000, 'KORLEDELSE', 'KORLEDELSE', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(163, 1, 4071000, 'KUNST OG HÅNDTVERK', 'KUNST_HÅND', NULL, '2013-04-14 12:07:53');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(164, 1, 3906000, 'KURS', 'KURS-AI', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(165, 1, 3525000, 'KURS-AI studenter', 'KURSAI', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(166, 1, 1338000, 'LABkurs', 'LABkurs', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(167, 1, 3998000, 'Innføring i eiendomsfagene og profesjonsdannelse for landmålere', 'LEI100', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(168, 1, 37000, 'Geografiske informasjonssystemer', 'LEI101', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(169, 1, 4087000, 'Matematikk', 'LEI102', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(170, 1, 3836000, 'LESEOPPLÆRING', 'LESOPPL_F', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(171, 1, 2260000, 'Mekanikk', 'lLOA172', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(172, 1, 35000, 'Mekanikk', 'LOA712', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(173, 1, 173000, 'Mekanikk', 'LOA713', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(174, 1, 174000, 'Landmåling', 'LOB208', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(175, 1, 36000, 'Rettslære', 'LOJ200', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(176, 1, 38000, 'Matematikk', 'LOJ203', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(177, 1, 175000, 'Eiendom I', 'LOJ204', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(178, 1, 39000, 'Geografiske informasjonssystemer', 'LOJ205', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(179, 1, 176000, 'Veg- og arealplanlegging', 'LOJ207', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(180, 1, 40000, 'Eiendom II', 'LOJ209', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(181, 1, 177000, 'økonomi og ressursforvaltning', 'LOJ211', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(182, 1, 41000, 'Ing. Landmåling', 'LOJ212', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(183, 1, 42000, 'Eiendoms landmåling', 'LOJ213', NULL, '2013-04-14 12:07:57');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(184, 1, 178000, 'Jordskifte og verdsettelse', 'LOJ215', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(185, 1, 43000, 'Geografiske informasjonssystemer', 'LOJ216', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(186, 1, 44000, 'Rettslære II', 'LOJ217', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(187, 1, 266000, 'Industrilandmåling', 'LOJ218', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(188, 1, 3126000, 'Eiendomsdanning ved oppmålingsforretning', 'LOJ225', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(189, 1, 3237000, 'Ressursforvaltning', 'LOJ226', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(190, 1, 1189000, 'Bustadrett I', 'LOJ230', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(191, 1, 1190000, 'Bustadrett II', 'LOJ231', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(192, 1, 147000, 'noname', 'LOK003', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(193, 1, 145000, 'Prosessteknikk', 'LOK203', NULL, '2013-04-14 12:07:58');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(194, 1, 45000, 'Makroøkonomi II', 'LOØØ65', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(195, 1, 46000, 'Markedsimperfeksjoner og spillteori', 'LOØØ66', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(196, 1, 179000, 'Internasjonal handel', 'LOØØ67', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(197, 1, 2989000, 'Innføringskurs i akvakultur', 'MAR250', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(198, 1, 579000, 'Ernæring hos fisk', 'MAR253', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(199, 1, 4009000, 'Statikk og fasthetslære', 'MAS100', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(200, 1, 152000, 'Mattematikk LAB', 'MAT-LAB', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(201, 1, 4010000, 'Matematikk I', 'MAT100', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(202, 1, 4086000, 'Grunnleggende matematikk', 'MAT100X', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(203, 1, 4026000, 'Diskret matematikk og programmering', 'MAT101', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(204, 1, 3845000, 'MATTE SALU', 'MAT10SP', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(205, 1, 589000, 'Kurs Mathcad', 'Mathca', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(206, 1, 2146000, 'Mattematikk Sommerkurs', 'Matte', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(207, 1, 3832000, 'Menneskesyn seminar', 'MenSySem', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(208, 1, 3955000, 'Metodekurs', 'Metodekurs', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(209, 1, 4064000, 'Konstruksjonsmodellering', 'MOB250', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(210, 1, 143000, 'Avansert programvareteknologi', 'MOD250', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(211, 1, 1381000, 'Moderne systemutviklingsmetoder', 'MOD251', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(212, 1, 2396000, 'Agentteknologier', 'MOD252', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(213, 1, 3422000, 'Grid-teknologi', 'MOD259', NULL, '2013-04-14 12:08:00');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(214, 1, 3665000, 'Grid-teknologi', 'MOD351', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(215, 1, 3102000, 'Materiallære for energiteknologi', 'MOM250', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(216, 1, 3490000, 'Marine Operasjoner', 'MOM251', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(217, 1, 3087000, 'Innovasjonsstrategi', 'MOØ200', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(218, 1, 3089000, 'finansiering', 'MOØ201', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(219, 1, 3088000, 'Markedsføringsledelse', 'MOØ202', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(220, 1, 3180000, 'Technology Based Entrepreneurship', 'MOØ203', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(221, 1, 3491000, 'Technology management', 'MOØ204', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(222, 1, 3775000, 'MUSIKK', 'MUS', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(223, 1, 3827000, 'MUS DID', 'MUSDID', NULL, '2013-04-14 12:08:01');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(224, 1, 3826000, 'MUS LEDELSE KOR', 'MUSLEDKOR', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(225, 1, 3838000, 'MUSIKKORIENTERING', 'MUSORIENT', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(226, 1, 3125000, 'Målebrev', 'Målebrev', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(227, 1, 2778000, 'Norwegian Language and Culture', 'NoLaandCul', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(228, 1, 3851000, 'NORSK SOM ANDRESPRÅK', 'NOR2SP', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(229, 1, 2805000, 'Norsk kurs', 'Norskkurs', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(230, 1, 3847000, 'NORSK SALU', 'NORSKSALU', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(231, 1, 148000, 'E-pedagogikk', 'PED', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(232, 1, 3846000, 'PED SALU', 'PEDSALU', NULL, '2013-04-14 12:08:04');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(233, 1, 3893000, 'PetroChallenge', 'PetroChall', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(234, 1, 1366000, 'PRAKSIS', 'PRAKSIS', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(235, 1, 1294000, 'Prøver', 'Prøver', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(236, 1, 1342000, 'Regneøving', 'Regneøving', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(237, 1, 2165000, 'Sykepleier, 3 år', 'S08A', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(238, 1, 2156000, 'GRSD08', 'SD08', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(239, 1, 3145000, 'seminar', 'seminar', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(240, 1, 180000, 'Patologi', 'SO338', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(241, 1, 47000, 'Instrumentelle analysermetodar II', 'SOK329', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(242, 1, 584000, 'Instrumentelle analyser', 'SOK337', NULL, '2013-04-14 12:08:05');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(243, 1, 48000, 'Patologi', 'SOK338', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(244, 1, 49000, 'Klinisk kjemi', 'SOK339', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(245, 1, 585000, 'Etikk og kommunikasjon', 'SOK345', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(246, 1, 50000, 'Etikk og kommunikasjon II', 'SOK347', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(247, 1, 52000, 'DAK II', 'SOM921', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(248, 1, 2172000, 'SOS08', 'SOS08', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(249, 1, 51000, 'Grunnkurs akvakultur', 'SOT538', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(250, 1, 3849000, 'SPRDIDF', 'SPRDIDF', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(251, 1, 2742000, 'Studiedag', 'Studiedag', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(252, 1, 2810000, 'Kurs i studieteknikk', 'studietekn', NULL, '2013-04-14 12:08:06');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(253, 1, 3455000, 'studiestart', 'studstart', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(254, 1, 2874000, 'Kurs i Studieteknikk', 'StudTek', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(255, 1, 3697000, 'TFG', 'TFaG', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(256, 1, 53000, 'Rettslære', 'TOB001', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(257, 1, 182000, 'Geoteknikk/fundamentering', 'TOB004', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(258, 1, 183000, 'Byggningskonstruksjoner', 'TOB005', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(259, 1, 54000, 'Teknisk tegning DAK', 'TOB007', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(260, 1, 184000, 'Byggningsfysikk/prosj.', 'TOB008', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(261, 1, 144000, 'Byggningsmaterialer', 'TOB009', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(262, 1, 2933000, 'Bygningsfysikk', 'TOB010', NULL, '2013-04-14 12:08:09');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(263, 1, 3210000, 'Energieffektive Bygninger', 'TOB011', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(264, 1, 3211000, 'Geoteknikk', 'TOB012', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(265, 1, 3212000, 'VA-Teknikk', 'TOB013', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(266, 1, 55000, 'Vegplanlegging', 'TOB050', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(267, 1, 56000, 'Vann- og avløpsplanlegging', 'TOB051', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(268, 1, 185000, 'Arealplanlegging', 'TOB052', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(269, 1, 3296000, 'Ingeniørgeologi', 'TOB053', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(270, 1, 3294000, 'Beskrivelse, kalkulajson og kontrahering', 'TOB055', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(271, 1, 3295000, 'Byggeplassdrift', 'TOB056', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(272, 1, 57000, 'Stålkonstruksjoner', 'TOB070', NULL, '2013-04-14 12:08:10');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(273, 1, 58000, 'Betongkonstruksjoner', 'TOB071', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(274, 1, 186000, 'Trekonstruksjoner', 'TOB072', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(275, 1, 187000, 'Statikk', 'TOB073', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(276, 1, 2685000, 'Landmåling', 'TOB208', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(277, 1, 59000, 'Informasjonsteknologi 1: Datamaskiner og web', 'TOD060', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(278, 1, 188000, 'Informasjonsteknologi 2: Systemering og samfunn', 'TOD061', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(279, 1, 60000, 'Grunnleggende programmering', 'TOD062', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(280, 1, 189000, 'Datastrukturer og algoritmer', 'TOD063', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(281, 1, 61000, 'Grunnleggende informasjonsteknologi', 'TOD064', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(282, 1, 3657000, 'Diskret matematisk programmering', 'TOD065', NULL, '2013-04-14 12:08:11');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(283, 1, 62000, 'Vidaregåande programmering', 'TOD070', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(284, 1, 63000, 'Datamaskinar og UNIX', 'TOD071', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(285, 1, 64000, 'Databaser 1', 'TOD072', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(286, 1, 190000, 'Systemutvikling', 'TOD073', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(287, 1, 191000, 'Operativsystemer og nettverk', 'TOD074', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(288, 1, 192000, 'Design og programutvikling for web', 'TOD075', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(289, 1, 2677000, 'Systemering og web', 'TOD076', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(290, 1, 2902000, 'Datamaskiner og operativststemer', 'TOD077', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(291, 1, 65000, 'Grafiske metodar', 'TOD110', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(292, 1, 66000, 'Programmeringsparadigmer/prolog', 'TOD111', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(293, 1, 193000, 'Utviklingsverktøy/C#/:NET', 'TOD112', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(294, 1, 67000, 'Nettverksadministrasjon, drift og sikkerhet', 'TOD120', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(295, 1, 194000, 'Unix drift', 'TOD121', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(296, 1, 68000, 'Database drift', 'TOD122', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(297, 1, 69000, 'Databasar 2', 'TOD130', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(298, 1, 267000, 'PC-basert måleteknikk', 'TOD131', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(299, 1, 70000, 'Programutvikling for web', 'TOD132', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(300, 1, 181000, 'Videregående algoritmer', 'TOD133', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(301, 1, 71000, 'Distribuerte system', 'TOD134', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(302, 1, 1403000, 'Praksisfag (drift av datasystemer)', 'TOD135', NULL, '2013-04-14 12:08:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(303, 1, 3953000, 'Praksisfag', 'TOD136', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(304, 1, 2145000, 'Databaser 2', 'TOD137', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(305, 1, 268000, 'Web-baserte tjenester og e-handel', 'TOD140', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(306, 1, 2144000, 'Internett', 'TOD141', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(307, 1, 3175000, 'Mobilteknologi', 'TOD142', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(308, 1, 3557000, 'Kunstige nevrale nett', 'TOD180', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(309, 1, 72000, 'Grunnleggende elektrofag I', 'TOE001', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(310, 1, 195000, 'Grunnleggende elektro', 'TOE002', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(311, 1, 196000, 'Linære systemer', 'TOE003', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(312, 1, 150000, 'Grunnleggende kommunikasjonsteknologi', 'TOE004', NULL, '2013-04-14 12:08:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(313, 1, 1330000, 'Grunnleggende kommunikasjonsteknologi II', 'TOE005', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(314, 1, 3188000, 'Elektrofag for kommunikasjon', 'TOE007', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(315, 1, 3499000, 'Laboratoriekurs 1', 'TOE009', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(316, 1, 73000, 'Transmisjonssystemer og datanett', 'TOE020', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(317, 1, 197000, 'Operativsystem', 'TOE021', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(318, 1, 198000, 'Datastrukturer og databaser', 'TOE022', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(319, 1, 261000, 'Trådløs teknologi', 'TOE023', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(320, 1, 262000, 'Systemutvikling', 'TOE024', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(321, 1, 263000, 'Signalbehandling for kommunikasjonsteknologi', 'TOE025', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(322, 1, 1331000, 'Ruting og svitsjing', 'TOE027', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(323, 1, 3415000, 'Videregående nettverksteknikk', 'TOE028', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(324, 1, 3190000, 'Datastrukturer', 'TOE029', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(325, 1, 2941000, 'Nettverksprogrammering og systemutvikling', 'TOE030', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(326, 1, 3189000, 'Optisk kommunikasjon', 'TOE031', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(327, 1, 3553000, 'Signalbehandling for kommunikasjon', 'TOE032', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(328, 1, 74000, 'Industrielle styresystemer', 'TOE050', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(329, 1, 199000, 'Instrumentering og datanett', 'TOE051', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(330, 1, 75000, 'Prosessteknikk', 'TOE052', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(331, 1, 76000, 'Industriell IT - A', 'TOE053', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(332, 1, 110000, 'Industriell IT - B', 'TOE053-B', NULL, '2013-04-14 13:04:16');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(333, 1, 77000, 'Videregående reguleringsteknikk', 'TOE054', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(334, 1, 78000, 'Robotikk', 'TOE055', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(335, 1, 2940000, 'Objektorientert programutvikling', 'TOE056', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(336, 1, 3411000, 'Robotikk', 'TOE057', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(337, 1, 3410000, 'Industriell IT', 'TOE058', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(338, 1, 79000, 'Analog instrumentkonstruksjon', 'TOE101', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(339, 1, 80000, 'Signalbehandling', 'TOE103', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(340, 1, 81000, 'Digitale system', 'TOE104', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(341, 1, 82000, 'Sensorikk', 'TOE105', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(342, 1, 83000, 'Industrielle datanett', 'TOE106', NULL, '2013-04-14 13:04:17');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(343, 1, 3652000, 'HW/SW systemkonstruksjon', 'TOE107', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(344, 1, 200000, 'lab kurs', 'TOE108', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(345, 1, 259000, 'Digital signalbehandling', 'TOE109', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(346, 1, 201000, 'Krets- og transmisjonsteknikk', 'TOE110', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(347, 1, 2296000, 'Målesystem og sensornettverk', 'TOE111', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(348, 1, 2297000, 'Analog kretskonstruksjon', 'TOE112', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(349, 1, 3319000, 'Lab 1', 'TOE114', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(350, 1, 3558000, 'Audioforsterkere', 'TOE115', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(351, 1, 202000, 'Elektriske maskiner', 'TOE151', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(352, 1, 84000, 'Elektriske anlegg', 'TOE152', NULL, '2013-04-14 13:04:19');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(353, 1, 85000, 'Overvåking og styringstenikk', 'TOE153', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(354, 1, 86000, 'Kraftelektronikk og elektriske motordrifter', 'TOE154', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(355, 1, 87000, 'Elverksanlegg og høyspenning', 'TOE155', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(356, 1, 88000, 'Elektriske installasjoner', 'TOE156', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(357, 1, 1329000, 'Grunnleggende kommunikasjonsteknologi II', 'TOEOO5', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(358, 1, 89000, 'Generell og analytisk kjemi', 'TOK001', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(359, 1, 90000, 'Miljøteknologi', 'TOK002', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(360, 1, 91000, 'Organisk kjemi', 'TOK003', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(361, 1, 203000, 'Fysikalsk kjemi', 'TOK004', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(362, 1, 92000, 'Anvendt strømningslære', 'TOK005', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(363, 1, 93000, 'Instrumentell Analyse', 'TOK006', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(364, 1, 204000, 'Kjemometri', 'TOK007', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(365, 1, 94000, 'Kjemiteknikk II', 'TOK008', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(366, 1, 95000, 'stoffoverføringsprosesser', 'TOK009', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(367, 1, 96000, 'Prosessteknikk', 'TOK010', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(368, 1, 253000, 'Analyseteknikk', 'TOK011', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(369, 1, 252000, 'Organisk kjemi I', 'TOK012', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(370, 1, 1352000, 'Organisk kjemi II', 'TOK013', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(371, 1, 3310000, 'Generell og analytisk kjemi 1', 'TOK014', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(372, 1, 97000, 'Grunnkurs i biologi I og datateknikk', 'TOK050', NULL, '2013-04-14 13:04:20');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(373, 1, 205000, 'Grunnleggende biologi', 'TOK051', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(374, 1, 206000, 'Fiskebiologi', 'TOK052', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(375, 1, 207000, 'Kvalitetsledelse og anvendt akvakultur', 'TOK053', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(376, 1, 254000, 'Vannkvalitet, miljø og akvakulturteknologi', 'TOK054', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(377, 1, 98000, 'VA-planlegging og akvakultursystemer', 'TOK055', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(378, 1, 578000, 'Havbruksteknologi', 'TOK056', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(379, 1, 3213000, 'Praktisk arbeid i akvakultur og vannteknologi', 'TOK057', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(380, 1, 3427000, 'Vannkvalitet', 'TOK058', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(381, 1, 2392000, 'Vamm- og avløpsplanlegging', 'TOK059', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(382, 1, 2991000, 'Vannanalyser', 'TOK060', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(383, 1, 208000, 'Konstruksjon II', 'TOM002', NULL, '2013-04-14 13:04:22');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(384, 1, 209000, 'Kvalitetsledelse', 'TOM003', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(385, 1, 99000, 'Konstr. III Maskin', 'TOM005', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(386, 1, 2385000, 'Grunnleggende elektro og automasjon', 'TOM006', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(387, 1, 100000, 'Regulering/modellering analyse', 'TOM007', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(388, 1, 210000, 'Konstruksjon I', 'TOM008', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(389, 1, 211000, 'Maskindeler', 'TOM009', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(390, 1, 101000, 'Kontraktsrett og immaterielle rettigheter', 'TOM010', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(391, 1, 2356000, 'Dak Maskintegning', 'TOM011', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(392, 1, 1356000, '3D-Modellering og design', 'TOM012', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(393, 1, 245000, 'Mattematikk og fluiddynamikk', 'TOM013', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(394, 1, 1357000, 'Matematikk og fluidmekanikk', 'TOM014', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(395, 1, 2692000, 'Maskindeler', 'TOM015', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(396, 1, 2931000, 'Konstruksjon II', 'TOM016', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(397, 1, 3314000, 'Konstruksjon III', 'TOM017', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(398, 1, 2691000, '3D mod. og tegning', 'TOM018', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(399, 1, 102000, 'Teknologi og samfunn I', 'TOM021', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(400, 1, 2255000, 'Teknologi og samfunn', 'TOM022', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(401, 1, 103000, 'Energi og samfunn I', 'TOM024', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(402, 1, 104000, 'Industriell og internasjonal markedsføring', 'TOM026', NULL, '2013-04-14 13:04:23');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(403, 1, 2256000, 'Dynamikk', 'TOM027', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(404, 1, 3208000, 'Fluidmekanikk', 'TOM028', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(405, 1, 2364000, 'Elektrofag I', 'TOM029', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(406, 1, 216000, 'Hydrodynamikk', 'TOM030', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(407, 1, 1360000, 'Marine Stålkonstruksjoner', 'TOM031', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(408, 1, 212000, 'Grunnlegende elektro og automasjon', 'TOM032', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(409, 1, 105000, 'Teknisk varmelære', 'TOM033', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(410, 1, 106000, 'Dynamikk', 'TOM034', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(411, 1, 213000, 'Fluidmekanikk', 'TOM035', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(412, 1, 2365000, 'Teknologi og samfunn', 'TOM037', NULL, '2013-04-14 13:04:25');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(413, 1, 3420000, 'Industriell og internasjonal markedsføring og ledelse', 'TOM038', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(414, 1, 3205000, 'Grunnleggende elektrofag', 'TOM039', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(415, 1, 3312000, 'elektro og automasjon', 'TOM040', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(416, 1, 107000, 'Marin prosjektering', 'TOM050', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(417, 1, 108000, 'Særkurs marinteknikk', 'TOM052', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(418, 1, 109000, 'Industriell IT - A', 'TOM053-A', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(419, 1, 214000, 'Marine stålkonstruksjoner', 'TOM054', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(420, 1, 215000, 'Hydrostatistikk og stabilitet', 'TOM055', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(421, 1, 111000, 'Hydrodynamikk', 'TOM056', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(422, 1, 217000, 'Undervannsteknikk gr.kurs', 'TOM057', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(423, 1, 3206000, 'Simulering', 'TOM058', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(424, 1, 1384000, 'Undervannsteknologi grunnkurs', 'TOM070', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(425, 1, 3709000, 'Undervannsteknologi praksis I', 'TOM071', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(426, 1, 112000, 'Drift og vedlikehold', 'TOM100', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(427, 1, 258000, 'Produksjon og logistikk', 'TOM103', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(428, 1, 113000, 'Innovasjonsteknikk, produktutvikling og design', 'TOM104', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(429, 1, 1361000, 'Tilvirkning', 'TOM105', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(430, 1, 218000, 'Produksjon og tilvirkning', 'TOM107', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(431, 1, 219000, 'Logistikk og innkjøp', 'TOM108', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(432, 1, 2274000, 'Produksjon, logistikk og innkjøp', 'TOM109', NULL, '2013-04-14 13:04:26');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(433, 1, 1377000, 'Vedlikehold og driftssikkerhet', 'TOM110', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(434, 1, 2936000, 'Logistikk og innkjøp', 'TOM111', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(435, 1, 3207000, 'Tilvirkning, datassistert produksjon', 'TOM112', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(436, 1, 114000, 'Varme, ventilasjon og klimateknikk', 'TOM150', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(437, 1, 220000, 'Energikilder', 'TOM151', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(438, 1, 221000, 'Elektrofag I', 'TOM152', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(439, 1, 115000, 'Elektrofag II', 'TOM153', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(440, 1, 222000, 'Termisk energiproduksjon', 'TOM156', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(441, 1, 116000, 'Teknisk varmelære II', 'TOM157', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(442, 1, 117000, 'Oljehydraulikk og hydrauliske maskiner', 'TOM158', NULL, '2013-04-14 13:04:28');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(443, 1, 255000, 'Materiallære', 'TOM159', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(444, 1, 2693000, 'Hydrostatikk', 'TOM160', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(445, 1, 3313000, 'Fluidmekanikk,hydraulikk og hydrauliske maskiner', 'TOM161', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(446, 1, 2690000, 'Materiallære', 'TOM162', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(447, 1, 2391000, 'Brønnteknologi', 'TOM163', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(448, 1, 2995000, 'Tetninger,koblinger,ventiler', 'TOM165', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(449, 1, 2744000, 'Instrumentering', 'TOM166', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(450, 1, 2986000, 'Industrielle data nettverk', 'TOM168', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(451, 1, 3578000, 'Grunnleggende skipsteknikk og Stabilitet', 'TOM169', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(452, 1, 3880000, 'Industrielle datanett', 'TOM170', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(453, 1, 3547000, 'Petroleums produksjon, brønner og ventiler', 'TOM171', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(454, 1, 223000, 'Anleggsteknikk', 'TVB080', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(455, 1, 3297000, 'Elementsmetoden', 'TVB082', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(456, 1, 2218000, 'Estetikk, byggeskikk og arkitektur', 'TVB083', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(457, 1, 224000, 'Kunstige nevrale nett', 'TVD180', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(458, 1, 2302000, 'Informasjonssikkerhet', 'TVE011', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(459, 1, 3271000, 'HW/SW systemkonstruksjon', 'TVE020', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(460, 1, 2304000, 'Optisk kommunikasjon', 'TVE021', NULL, '2013-04-14 13:04:29');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(461, 1, 2303000, 'Nettverksprogrammering', 'TVE026', NULL, '2013-04-14 13:04:30');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(462, 1, 225000, 'Offshore instrumentering', 'TVE070', NULL, '2013-04-14 13:04:30');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(463, 1, 226000, 'Bildebehandling/Robotsystem', 'TVE071', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(464, 1, 227000, 'Analog kretskonstruksjon', 'TVE076', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(465, 1, 118000, 'PC-basert datainnsamling', 'TVE077', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(466, 1, 228000, 'Maritime elektriske innstallasjoner', 'TVE078', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(467, 1, 229000, 'Anvendt datateknikk for elkraft', 'TVE079', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(468, 1, 230000, 'Windowsprogrammering', 'TVE081', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(469, 1, 260000, 'Industrielle styresystemer', 'TVE082', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(470, 1, 3555000, 'Anvendt datateknikk for elkraft', 'TVE084', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(471, 1, 3200000, 'Maritime elektriske installasjoner', 'TVE088', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(472, 1, 3204000, 'PLS-programmering', 'TVE092', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(473, 1, 119000, 'Gassteknologi', 'TVM040', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(474, 1, 231000, 'Materiallære', 'TVM044', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(475, 1, 232000, 'Dataassistert produksjon', 'TVM045', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(476, 1, 1396000, 'Avansert 3D-modellering Styrkeberegning av maskinelementer med', 'TVM046', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(477, 1, 1376000, 'Mat.Lab', 'TVM047', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(478, 1, 2397000, 'UIBDATA', 'UIBDATA', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(479, 1, 3682000, 'Uspesifisert', 'USPES', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(480, 1, 3766000, 'BARN NAT TEOR PRAKS', 'UTEFAG', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(481, 1, 3699000, 'VEILEDN', 'Veiledn', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(482, 1, 2199000, 'VPL08', 'VPL08', NULL, '2013-04-14 13:04:32');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(483, 1, 2332000, 'videreutdanning', 'VUTD', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(484, 1, 4060000, 'xyzfag', 'xyzfag', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(485, 1, 141000, 'Ledelse, organisasjon og kultur', 'ØAA101', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(486, 1, 142000, 'Personaladministrasjon', 'ØAA102', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(487, 1, 120000, 'Rettslære', 'ØAF101', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(488, 1, 121000, 'Endringsledelse', 'ØAF102', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(489, 1, 122000, 'Innovasjon og entreprenørskap fordypning', 'ØAI101', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(490, 1, 233000, 'Innovasjonsteknikk', 'ØAI102', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(491, 1, 123000, 'Produkt- og tjenesteutvikling', 'ØAI103', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(492, 1, 124000, 'Logistikk fordypning', 'ØAL101', NULL, '2013-04-14 13:04:33');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(493, 1, 125000, 'Innkjøp', 'ØAL102', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(494, 1, 234000, 'Supply chain management', 'ØAL103', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(495, 1, 126000, 'Transportrett og vareforsikring', 'ØAL104', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(496, 1, 127000, 'Markedsføring II', 'ØAM102', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(497, 1, 128000, 'Organisasjon 1', 'ØAO001', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(498, 1, 235000, 'Markedsføring 1', 'ØAO002', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(499, 1, 236000, 'Logistikk I', 'ØAO004', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(500, 1, 129000, 'Organisasjon II', 'ØAO011', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(501, 1, 237000, 'Foretaksstrategi', 'ØAO013', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(502, 1, 3176000, 'Strategisk ledelse og logistikk', 'ØAO014', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(503, 1, 3178000, 'Organisasjon og etikk', 'ØAO015', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(504, 1, 130000, 'Innføring i bed.øk. og regnskap', 'ØBO001', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(505, 1, 4029000, 'Innføring i bedriftsøkonomi og regnskap', 'ØBO002', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(506, 1, 238000, 'Fiansregnskap med analyse', 'ØBO011', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(507, 1, 131000, 'Driftsregnsk. og budsjettering', 'ØBO012', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(508, 1, 239000, 'Invistering og finansiering m/ regneark', 'ØBO013', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(509, 1, 240000, 'Beslutningsanalyse', 'ØBO014', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(510, 1, 3177000, 'Investering og finansiering', 'ØBO015', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(511, 1, 132000, 'Regnskap fordypning', 'ØBR101', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(512, 1, 133000, 'Skatterett 1', 'ØBR102', NULL, '2013-04-14 13:04:35');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(513, 1, 241000, 'Rettslære, skatt og avgift', 'ØBR103', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(514, 1, 2142000, 'Regnskap fordypning', 'ØBR104', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(515, 1, 2307000, 'Avgiftsrett', 'ØBR105', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(516, 1, 2716000, 'Budsjett og regnskap i offentlig sektor', 'ØBR106', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(517, 1, 2727000, 'Rettslære og skatt', 'ØBR107', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(518, 1, 146000, 'Prosjektadm./ekstern virksomhet', 'ØEV001', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(519, 1, 134000, 'Adm. info.systemer', 'ØMF101', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(520, 1, 1404000, 'Bacheloroppgave', 'ØMF190', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(521, 1, 135000, 'Matematikk', 'ØMO001', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(522, 1, 136000, 'Innføring i info.behandling', 'ØMO002', NULL, '2013-04-14 13:04:36');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(523, 1, 242000, 'Statistikk', 'ØMO003', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(524, 1, 3995000, 'Digital info.behandling', 'ØMO004', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(525, 1, 137000, 'Samf.vit. metode', 'ØMO011', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(526, 1, 243000, 'Mikroøkonomi', 'ØSO001', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(527, 1, 138000, 'Makroøkonomi', 'ØSO002', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(528, 1, 244000, 'Offentlig økonomi', 'ØSO011', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(529, 1, 139000, 'Markedsimperfeksjoner og spillteori', 'ØSS101', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(530, 1, 140000, 'Makroøkonomi 2', 'ØSS102', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(531, 1, 265000, 'Internasjonal handel', 'ØSS103', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(532, 1, 3892000, 'Markedsimperfeksjoner og spillteori', 'ØSS104', NULL, '2013-04-14 13:04:40');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(533, 1, 3644000, 'Markedsimperfeksjoner og spillteori', 'ØSS105', NULL, '2013-04-14 13:04:41');
INSERT INTO `schedule_program` (`program_id`, `website_id`, `program_code`, `program_name`, `program_name_short`, `program_updated`, `program_registered`) VALUES
	(534, 1, 3645000, 'Internasjonal handel', 'ØSS106', NULL, '2013-04-14 13:04:41');
/*!40000 ALTER TABLE `schedule_program` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_room: ~124 rows (approximately)
/*!40000 ALTER TABLE `schedule_room` DISABLE KEYS */;
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(1, 1, NULL, 3279000, 'Metall Lab', 'A001', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(2, 1, NULL, 3495000, 'Material Lab', 'A1', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(3, 1, NULL, 2230000, 'Instrumentell analyselab', 'A1012', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(4, 1, NULL, 3222000, 'Instrumentell analyse', 'A1012/14', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(5, 1, NULL, 3935000, 'Instrumentell lab', 'A1014', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(6, 1, NULL, 575000, 'FoU Lab', 'A1018A', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(7, 1, NULL, 467000, 'A2DATA', 'A2DATA', NULL, '2013-04-14 11:52:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(8, 1, NULL, 1379000, 'A2GR', 'A2GR', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(9, 1, NULL, 3162000, 'Vrimleområde inngangsparti', 'A3', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(10, 1, NULL, 472000, 'A513', 'A513', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(11, 1, NULL, 466000, 'A516', 'A516', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(12, 1, NULL, 2445000, 'Datalab', 'A517', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(13, 1, NULL, 470000, 'A521', 'A521', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(14, 1, NULL, 598000, 'A522', 'A522', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(15, 1, NULL, 508000, 'A526', 'A526', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(16, 1, NULL, 471000, 'A530', 'A530', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(17, 1, NULL, 460000, 'A615AU', 'A615AU', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(18, 1, NULL, 474000, 'A617', 'A617', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(19, 1, NULL, 475000, 'A618', 'A618', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(20, 1, NULL, 473000, 'A619', 'A619', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(21, 1, NULL, 476000, 'A622', 'A622', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(22, 1, NULL, 477000, 'A623', 'A623', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(23, 1, NULL, 2927000, 'A625', 'A625', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(24, 1, NULL, 486000, 'A627', 'A627', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(25, 1, NULL, 461000, 'A715AU', 'A715AU', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(26, 1, NULL, 479000, 'A718', 'A718', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(27, 1, NULL, 480000, 'A719', 'A719', NULL, '2013-04-14 11:52:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(28, 1, NULL, 481000, 'A723', 'A723', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(29, 1, NULL, 482000, 'A724', 'A724', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(30, 1, NULL, 468000, 'A726', 'A726', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(31, 1, NULL, 462000, 'A817AU', 'A817AU', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(32, 1, NULL, 483000, 'A819', 'A819', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(33, 1, NULL, 484000, 'A820', 'A820', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(34, 1, NULL, 485000, 'A825', 'A825', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(35, 1, NULL, 463000, 'A826AU', 'A826AU', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(36, 1, NULL, 469000, 'A829', 'A829', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(37, 1, NULL, 478000, 'A830', 'A830', NULL, '2013-04-14 12:04:06');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(38, 1, NULL, 2357000, 'Kjemi- og miljølab', 'A914', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(39, 1, NULL, 2228000, 'Generell Kjemilab', 'A915', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(40, 1, NULL, 2446000, 'Organisk kjemi lab', 'A919', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(41, 1, NULL, 2238000, 'Prosesskjemi', 'A926', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(42, 1, NULL, 3264000, 'Mikroskopi', 'A927', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(43, 1, NULL, 3101000, 'BIO lab', 'A930', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(44, 1, NULL, 1192000, 'FoU Lab', 'A934B', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(45, 1, NULL, 1392000, 'Bergen vitensenter auditorium', 'AudViten', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(46, 1, NULL, 2382000, 'Målesal', 'B112', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(47, 1, NULL, 3528000, 'Bygg Lab', 'B2', NULL, '2013-04-14 12:04:07');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(48, 1, NULL, 509000, 'B400', 'B400', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(49, 1, NULL, 510000, 'B417', 'B417', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(50, 1, NULL, 487000, 'B600', 'B600', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(51, 1, NULL, 488000, 'B601', 'B601', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(52, 1, NULL, 489000, 'B602', 'B602', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(53, 1, NULL, 2815000, 'B603', 'B603', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(54, 1, NULL, 2806000, 'B604', 'B604', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(55, 1, NULL, 490000, 'B605', 'B605', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(56, 1, NULL, 491000, 'B607', 'B607', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(57, 1, NULL, 3590000, 'Bedrift', 'Bedrift', NULL, '2013-04-14 12:04:08');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(58, 1, NULL, 3861000, 'Biblioteket', 'Biblioteke', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(59, 1, NULL, 583000, 'BIOLAB', 'BIOLAB', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(60, 1, NULL, 576000, 'Bergen vit.auditorium', 'BVaud', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(61, 1, NULL, 492000, 'C310', 'C310', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(62, 1, NULL, 464000, 'Carl Chr. Berners', 'CCBerners', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(63, 1, NULL, 493000, 'D201', 'D201', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(64, 1, NULL, 494000, 'D202', 'D202', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(65, 1, NULL, 495000, 'D203', 'D203', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(66, 1, NULL, 496000, 'D204', 'D204', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(67, 1, NULL, 3908000, 'D216', 'D216', NULL, '2013-04-14 12:04:18');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(68, 1, NULL, 1333000, 'Grunnlab', 'D311', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(69, 1, NULL, 2300000, 'Kommunikasjonslab', 'D312', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(70, 1, NULL, 3261000, 'Automatiseringslab', 'D313', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(71, 1, NULL, 497000, 'D517', 'D517', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(72, 1, NULL, 498000, 'D518', 'D518', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(73, 1, NULL, 500000, 'D521', 'D521', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(74, 1, NULL, 501000, 'D522', 'D522', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(75, 1, NULL, 1181000, 'Data Lab', 'DATALAB', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(76, 1, NULL, 502000, 'E200', 'E200', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(77, 1, NULL, 503000, 'E201', 'E201', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(78, 1, NULL, 504000, 'E308', 'E308', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(79, 1, NULL, 505000, 'E311A', 'E311A', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(80, 1, NULL, 506000, 'E311B', 'E311B', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(81, 1, NULL, 600000, 'EDB-gr.1', 'EDBGR1', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(82, 1, NULL, 601000, 'NN', 'EDBLAB', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(83, 1, NULL, 3144000, 'eksternt', 'eksternt', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(84, 1, NULL, 563000, 'EL.LAB07', 'ELLAB07', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(85, 1, NULL, 2926000, 'Grieghallen', 'Grieghalle', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(86, 1, NULL, 2780000, 'Haukelandsbakken', 'HAB', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(87, 1, NULL, 1367000, 'HUS', 'HAUKELAND', NULL, '2013-04-14 12:04:19');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(88, 1, NULL, 1370000, 'HAUKELAND1', 'HAUKELAND1', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(89, 1, NULL, 3568000, 'Haukeland', 'HAUKELAND2', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(90, 1, NULL, 3897000, 'HiB/div.', 'HiB/div', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(91, 1, NULL, 3942000, 'HUS', 'HUS', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(92, 1, NULL, 3254000, 'Høyteknologisenteret, Grupperom 2143', 'HøyGru2143', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(93, 1, NULL, 3255000, 'Høyteknologisenteret, Stort auditorium', 'HøyStoaudi', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(94, 1, NULL, 465000, 'Jacobs Eides aud.', 'JacobEides', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(95, 1, NULL, 599000, 'Kantine', 'Kantine', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(96, 1, NULL, 572000, 'KJELAB', 'KLAB', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(97, 1, NULL, 1188000, 'LAB.elektro.2', 'LAB-2klas', NULL, '2013-04-14 12:04:33');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(98, 1, NULL, 618000, 'LAB - BIO', 'LAB-BIO', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(99, 1, NULL, 1369000, 'LAB-1BIO', 'LAB1BIO', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(100, 1, NULL, 580000, 'LAB.gr.1', 'LABgr1', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(101, 1, NULL, 581000, 'LAB.gr.2', 'LABgr2', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(102, 1, NULL, 1368000, 'LAB-HAV', 'LABHAV', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(103, 1, NULL, 1193000, 'MAM-lab', 'MAM-lab', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(104, 1, NULL, 4124000, 'Møllendalsveien Amfi', 'MDV-Amfiet', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(105, 1, NULL, 4141000, 'MDV-Amfi.', 'MDVAmfi', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(106, 1, NULL, 593000, 'MMT-LAB', 'MMTLAB', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(107, 1, NULL, 3891000, 'Møllendalsbakken', 'Møllendal', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(108, 1, NULL, 1196000, 'nadaB607', 'nadaB607', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(109, 1, NULL, 3107000, 'AI', 'NYGAARD', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(110, 1, NULL, 507000, 'Odfjell 1', 'Odfjell1', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(111, 1, NULL, 499000, 'Odfjell 2', 'Odfjell2', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(112, 1, NULL, 3221000, 'Organisk lab', 'ORGLAB', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(113, 1, NULL, 607000, 'Sonja Gills', 'SonjaGills', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(114, 1, NULL, 2934000, 'STRAUME', 'ST321', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(115, 1, NULL, 2935000, 'STRAUME', 'ST322', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(116, 1, NULL, 1383000, 'STRAUME', 'STRAUME', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(117, 1, NULL, 2388000, 'STRAUME II', 'STRAUME2', NULL, '2013-04-14 12:04:34');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(118, 1, NULL, 620000, 'UIB', 'UIB', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(119, 1, NULL, 3692000, 'UiB', 'UiB1', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(120, 1, NULL, 3124000, 'ukjent', 'utlandet', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(121, 1, NULL, 3252000, 'Thormøhlens gate 51', 'VilVite', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(122, 1, NULL, 2210000, 'Tårnrom', 'xHGV-Tårn', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(123, 1, NULL, 3262000, 'Elkraftlab', 'XXXX', NULL, '2013-04-14 12:04:38');
INSERT INTO `schedule_room` (`room_id`, `website_id`, `element_id`, `room_code`, `room_name`, `room_name_short`, `room_updated`, `room_registered`) VALUES
	(124, 1, NULL, 2405000, 'Øvelse', 'Øvelse', NULL, '2013-04-14 12:04:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- Dumping data for table campusguide_test.schedule_website: ~1 rows (approximately)
/*!40000 ALTER TABLE `schedule_website` DISABLE KEYS */;
INSERT INTO `schedule_website` (`website_id`, `website_url`, `website_type`, `website_parsed`, `website_registered`) VALUES
	(1, 'http://timeedit.hib.no/4DACTION/WebShowSearch/1/2-0', 'timeedit', NULL, '2013-04-14 11:52:02');
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
