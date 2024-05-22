-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: lms
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','123456');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_details`
--

DROP TABLE IF EXISTS `admin_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `homepage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `introduction` varchar(144) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `imageUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_details`
--

LOCK TABLES `admin_details` WRITE;
/*!40000 ALTER TABLE `admin_details` DISABLE KEYS */;
INSERT INTO `admin_details` VALUES (1,'admin','zs','12345345353','www.google.com','不过是一个普通的大学生罢','2020-09-15','张三',NULL);
/*!40000 ALTER TABLE `admin_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `publisher` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10019 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (10001,'我的青春恋爱物语果然有问题','渡航','小学馆','2011-03-18','A02-01-02-052','校园 喜剧 恋爱 青春'),(10002,'路人女主的养成方法','丸户史明','富士见书房','2012-07-20','A02-05-02-052','恋爱 校园 喜剧'),(10003,'天龙八部','金庸','人民出版社','2003-06-13','B12-01-02-052','武侠'),(10004,'笑傲江湖','金庸','明报','1969-05-17','C11-11-12-051','武侠'),(10005,'倚天屠龙记','金庸','明报','1961-06-11','F11-05-11-005','武侠'),(10006,'中二病也要谈恋爱','虎虎','京都动画','2011-06-11','I09-02-05-012','喜剧 恋爱'),(10007,'随便','随便','随便','2020-10-13','I09-02-05-022','随便'),(10008,'C语言程序设计（第四版）','谭浩强','清华大学出版社','2016-11-01','I09-02-05-032','编码 计算机'),(10009,'Android移动应用开发','不详','不详','2021-12-06','G05-05-02-012','编程 计算机'),(10011,'高等数学','张三','银河出版社','2018-02-02','C11-02-02-022','数学'),(10012,'三大法师的法师','士大夫','大师傅','2023-09-05','C11-02-02-025','手打'),(10013,'java程序设计','张三','张三出版社','2023-10-03','C11-02-02-027','编程'),(10014,'web脚本语言','李四','李四','2023-10-01','C11-02-12-022','脚本'),(10015,'阿萨德','阿萨德','阿萨德','2023-10-03','C11-02-05-022','阿萨德'),(10016,'电饭锅','电饭锅','电饭锅','2023-10-02','C11-07-02-022','啥地方'),(10017,'asf','asf','asf','2023-11-06',NULL,'dff'),(10018,'fargafg','sadf','fdga','2024-05-06',NULL,'dsf');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrow`
--

DROP TABLE IF EXISTS `borrow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrow` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `should_return_date` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrow`
--

LOCK TABLES `borrow` WRITE;
/*!40000 ALTER TABLE `borrow` DISABLE KEYS */;
INSERT INTO `borrow` VALUES (13,'1','10009','2021-12-02','2022-04-29'),(25,'1','10002','2023-09-05','2023-10-31'),(26,'2','10002','2023-09-06','2023-09-29'),(27,'2','10003','2023-09-12','2023-09-27'),(29,'23','10017','2023-11-06','2023-12-06');
/*!40000 ALTER TABLE `borrow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (1,'2020-09-09','标题1','谁要是再在图书馆吃东西，没你好果子吃！'),(2,'2020-09-10','标题2','图书馆，学习的地方，天天拿着手机在那王者荣耀？给我滚'),(3,'2020-09-11','标题3','没还书的，小心我让你毕不了业！'),(4,'2020-09-12','随便','因为你不会 所以你才会 这是一种哲学'),(5,'2020-09-28','大家都是单身狗','所以没什么好怕'),(6,'2020-10-13','哈哈哈','没什么内容..'),(7,'2020-10-13','这是标题','这是正文'),(8,'2020-10-13','哈哈哈哈','1234'),(9,'2020-10-13','标题','123456'),(10,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(11,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(12,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(13,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(14,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(15,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(16,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(17,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(18,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(19,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(20,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(21,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(22,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(23,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(24,'2021-11-10','图书入库','最近又有一批图书新入库，请大家借阅时不要弄坏了。'),(25,'2021-11-02','123','98561856'),(26,'2021-11-02','1528','123'),(27,'2021-11-02','1528','123'),(28,'2021-11-09','图书入库2021/11/9','入库30本Java'),(29,'2021-11-09','图书入库2021/11/9','入库30本Java'),(30,'2021-11-09','新书入库','最近图书馆新入库了一批图书，请大家借阅时不要弄坏了。'),(31,'2021-11-10','入库','与归教你几节课 '),(32,'2022-04-22','新入库20本图书','图书馆新入库20本图书，希望学生要珍惜书本'),(33,'2023-10-11','sad ','asdgdafbdfdsfbsdbdcvb对VSVB冲刺你'),(34,'2023-11-14','asd','asf'),(35,'2024-04-08','asd','asddasd');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revert`
--

DROP TABLE IF EXISTS `revert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `recert_id` int DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `should_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revert`
--

LOCK TABLES `revert` WRITE;
/*!40000 ALTER TABLE `revert` DISABLE KEYS */;
INSERT INTO `revert` VALUES (1,1,'1','10006','2020-09-01','2020-09-30','2020-10-03'),(2,2,'1','10002','2020-10-13','2020-10-13','2020-10-13'),(3,3,'1','10004','2020-10-03','2020-10-16','2020-10-13'),(4,4,'1','10008','2020-10-06','2020-10-14','2020-10-13'),(5,5,'1','10004','2021-11-01','2021-11-15','2021-11-12'),(6,6,'2','10007','2021-10-20','2021-11-30','2021-11-25'),(7,7,'1','10007','2021-12-02','2021-12-23','2021-12-16'),(8,8,'1','10006','2021-12-02','2021-12-23','2021-12-16'),(9,9,'1','10005','2021-12-02','2021-12-08','2021-12-16'),(11,11,'1','10003','2021-12-02','2021-12-23','2021-12-16'),(12,12,'1','10002','2021-12-02','2021-12-14','2021-12-16'),(13,13,'2','10009','2021-12-02','2021-12-03','2021-12-16'),(14,14,'1','10008','2021-12-01','2021-12-15','2021-12-17'),(15,15,'1','10001','2021-12-01','2021-12-08','2021-12-17'),(16,16,'1','10009','2021-12-02','2021-12-23','2021-12-17'),(17,17,'1','10009','2021-12-02','2021-12-23','2021-12-17'),(18,18,'1','10009','2021-12-02','2021-12-31','2022-04-24'),(19,19,'2','10005','2023-09-11','2023-09-26','2023-09-25'),(44,NULL,'25','10003','2024-04-09','2024-04-17','2024-04-12'),(45,NULL,'1','10009','2021-12-02','2024-05-07','2024-05-02');
/*!40000 ALTER TABLE `revert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `store` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_total` int DEFAULT NULL,
  `store_current` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
INSERT INTO `store` VALUES (1,'10001',60,60),(2,'10002',60,60),(3,'10003',70,70),(4,'10004',70,70),(5,'10005',60,60),(6,'10006',50,50),(7,'10008',50,50),(8,'10001',25,25),(9,'10003',67,67),(10,'10005',20,20),(11,'10007',15,15),(12,'10008',50,50),(13,'10009',2,2),(14,'10012',50,50);
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `no` double(20,0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'student','123456',201710089135),(2,'teacher','123456',201710089136),(3,'ssrteacher','123456',201710089137),(4,'lujune1006','123456',201710089138),(5,'songjiang1015','123456',201710089139),(6,'steki','123456',201710089140),(7,'15281','152813',NULL),(14,'zhansan','152813',NULL),(15,'152813','152813',NULL),(16,'student003','123456',NULL),(17,'student004','123456',202120200042),(18,'zhangsan','123456',NULL),(19,'asdf4','123456',NULL),(20,'asdfg','123456',NULL),(21,'admin1','123456',NULL),(22,'asdfgh','123456',NULL),(23,'asdfa','123456',NULL),(24,'a2312313','a123456',NULL),(25,'asdfgh1','a123456',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxborrow` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `imageUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (1,'student','student','张三','zs1','19987654322','50','男',19,NULL),(2,'teacher','teacher','陈萧','Chen','18476205410','60','女',26,'http://localhost/lms_api/image/663b75da625ea_06.jpg'),(3,'teacher','ssrteacher','李青','Li','18476205411','40','男',28,NULL),(4,'teacher','lujune1006','卢俊义','Lu','18476205412','50','男',45,NULL),(5,'teacher','songjang1015','宋江','Song','18476205413','40','男',36,NULL),(6,'student','steki','西风吟','XiFeng','18476205414','50','男',20,NULL),(7,'student','admin','xu','xu','18476205409','50','保密',32,NULL),(9,'teacher','teacher01','李四','ls','12345602052','50','男',35,NULL),(10,'teacher','Teacher001','王一','wnagyi','98765432109','99','男',39,NULL),(11,'teacher','teacher002','王二','wanger','98765432108','55','保密',29,NULL),(12,'student','student003','王三','wangsan','19876543211','5','女',18,NULL),(13,'student','LiSi','李四','小李','12345678997','20','男',18,NULL),(14,'student','sad','asdsa','asdf','12345678944','50','男',20,NULL);
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-08 21:00:30
