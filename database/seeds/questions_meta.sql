# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: www.myste1tainn.com (MySQL 5.5.41-0ubuntu0.14.04.1)
# Database: ammart
# Generation Time: 2016-02-01 15:10:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table question_metas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_metas`;

CREATE TABLE `question_metas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `header` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `questionID` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `question_metas_questionid_foreign` (`questionID`),
  CONSTRAINT `question_metas_questionid_foreign` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `question_metas` WRITE;
/*!40000 ALTER TABLE `question_metas` DISABLE KEYS */;

INSERT INTO `question_metas` (`id`, `header`, `questionID`, `created_at`, `updated_at`)
VALUES
	(2,'{\"rows\":[{\"cols\":[{\"rowspan\":1,\"colspan\":\"4\",\"label\":\"\"},{\"rowspan\":1,\"colspan\":1,\"label\":\"\\u0e44\\u0e21\\u0e48\\u0e40\\u0e04\\u0e22\"},{\"rowspan\":1,\"colspan\":1,\"label\":\"\\u0e40\\u0e04\\u0e22\"}]}]}',44,'2016-01-23 07:58:36','2016-01-23 07:58:36');

/*!40000 ALTER TABLE `question_metas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
