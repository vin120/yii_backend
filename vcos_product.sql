# Host: localhost  (Version: 5.5.24-log)
# Date: 2015-11-25 09:52:52
# Generator: MySQL-Front 5.3  (Build 4.205)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "vcos_activity"
#

DROP TABLE IF EXISTS `vcos_activity`;
CREATE TABLE `vcos_activity` (
  `activity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(128) DEFAULT NULL COMMENT '活动名称',
  `activity_desc` varchar(255) DEFAULT NULL COMMENT '活动描述',
  `activity_img` varchar(255) DEFAULT NULL COMMENT '活动封面图',
  `start_time` datetime DEFAULT NULL COMMENT '活动开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '活动结束时间',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `creator` varchar(64) DEFAULT NULL COMMENT '创建者',
  `creator_id` int(11) DEFAULT NULL COMMENT '创建者id',
  `is_show_category` tinyint(4) DEFAULT '1' COMMENT '是否显示分类,1、显示',
  `cruise_id` int(11) NOT NULL COMMENT '邮轮id',
  `is_show_head` tinyint(4) DEFAULT '1' COMMENT '是否显示活动头,1显示',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='活动表';

#
# Data for table "vcos_activity"
#

INSERT INTO `vcos_activity` VALUES (1,'导航推荐','更多优惠等你来，无需要修改删除等。','activity_images/201511/201511051421112194.png','2015-10-30 16:03:00','2016-01-14 16:03:00',1,'2015-11-09 17:31:52','超级管理员',1,0,1,1),(9,'活动推荐2-国际品牌大促','全场低至1折','activity_images/201511/201511051422041096.png','2015-11-03 08:55:00','2016-01-07 08:55:00',1,'2015-11-09 16:24:18','超级管理员',1,1,1,1),(17,'活动推荐3-蓝秀变色口红','前两百名面单','activity_images/201511/201511051422383086.png','2015-11-05 14:32:04','2016-02-12 14:32:04',1,'2015-11-09 14:55:58','超级管理员',1,1,1,1),(19,'活动1--三利毛巾','满199减100','activity_images/201511/201511051515074893.png','2015-11-05 15:24:00','2016-02-17 15:24:00',1,'2015-11-09 16:24:34','超级管理员',1,1,1,1),(21,'活动2--快乐吃世界','全场任选 单件低至16元','activity_images/201511/201511051515456221.png','2015-11-05 15:26:00','2016-02-18 15:26:00',1,'2015-11-09 15:04:13','超级管理员',1,1,1,1),(23,'活动3--用画笔融入自然','全场最高降500元','activity_images/201511/201511051517296104.png','2015-11-01 00:00:00','2015-12-01 00:00:00',1,'2015-11-09 15:04:28','超级管理员',1,1,1,1),(25,'店铺1--零食物语','多种零食','activity_images/201511/201511051543486486.png','2015-11-05 15:53:00','2016-03-17 15:53:00',1,'2015-11-09 15:05:40','超级管理员',1,1,1,1),(29,'彩妆分会场','九朵云马油72元起','activity_images/201511/201511061504529415.jpg','2015-11-06 15:14:01','2015-11-27 15:14:01',1,'2015-11-06 15:04:52','超级管理员',1,1,1,1),(31,'双十一大牌提前购','全场至低3.3折','activity_images/201511/201511061506479409.jpg','2015-11-11 00:00:00','2015-11-11 00:00:00',1,'2015-11-06 15:06:47','超级管理员',1,1,1,1),(33,'拿钱买贵 不如买对','美肤好物白菜团','activity_images/201511/201511061508321735.jpg','2015-11-06 15:18:00','2015-11-30 15:18:00',1,'2015-11-06 15:08:32','超级管理员',1,1,1,1),(37,'导航店铺','店铺容器','activity_images/201511/201511091427398415.jpg','2015-11-08 14:37:00','2015-11-30 14:37:00',1,'2015-11-09 15:43:56','超级管理员',1,0,1,1),(39,'导航活动','导航活动容器','activity_images/201511/201511091428394168.png','2015-11-08 14:38:00','2015-11-30 14:38:00',1,'2015-11-09 15:43:44','超级管理员',1,0,1,1),(45,'商品推荐3','全自动机械表','activity_images/201511/201511091500002283.png','2015-11-08 00:09:45','2015-11-30 23:09:45',1,'2015-11-09 15:00:00','超级管理员',1,1,1,1),(47,'店铺推荐1','卡米龙双肩包','activity_images/201511/201511091501119129.png','2015-11-02 00:10:45','2015-11-30 23:10:45',1,'2015-11-09 15:01:11','超级管理员',1,1,1,1),(49,'店铺推荐2','米妮箱专卖店','activity_images/201511/201511091502117873.png','2015-11-01 00:11:45','2015-11-30 23:11:45',1,'2015-11-09 15:02:11','超级管理员',1,1,1,1),(51,'活动推荐3','运动鞋专卖店','activity_images/201511/201511091503163308.png','2015-11-01 00:13:00','2015-11-30 23:13:00',1,'2015-11-09 15:03:16','超级管理员',1,1,1,1),(53,'店铺2','pony运动','activity_images/201511/201511091507338561.png','2015-11-01 00:17:00','2015-11-30 23:17:00',1,'2015-11-09 15:07:33','超级管理员',1,1,1,1),(55,'店铺3','卡米龙','activity_images/201511/201511091508091972.png','2015-11-08 00:18:00','2015-11-30 23:18:00',1,'2015-11-09 15:09:33','超级管理员',1,1,1,1),(57,'店铺4','米妮箱','activity_images/201511/201511091509023435.png','2015-11-02 00:18:45','2015-11-30 23:18:45',1,'2015-11-09 15:09:02','超级管理员',1,1,1,1),(59,'推荐活动1','订单','activity_images/201511/201511091612126640.png','2015-11-01 16:22:00','2015-11-30 16:22:00',1,'2015-11-09 16:12:12','超级管理员',1,1,1,1),(61,'商品分类容器','商品分类容器','activity_images/201511/201511091655555674.png','2015-11-01 17:03:45','2015-11-30 17:03:45',1,'2015-11-09 16:55:55','超级管理员',1,1,1,1);

#
# Structure for table "vcos_activity_category"
#

DROP TABLE IF EXISTS `vcos_activity_category`;
CREATE TABLE `vcos_activity_category` (
  `activity_cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id,自增',
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `activity_category_name` varchar(32) DEFAULT NULL COMMENT '分类名',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(4) DEFAULT '1' COMMENT '1可用',
  PRIMARY KEY (`activity_cid`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='活动分类表';

#
# Data for table "vcos_activity_category"
#

INSERT INTO `vcos_activity_category` VALUES (1,1,'面部清洁',2,1),(9,9,'圣诞联谊合家欢',1,1),(11,23,'唇膏',1,1),(13,23,'润肤霜',2,1),(15,23,'保湿乳',2,1),(17,23,'水润膏',4,1),(19,25,'奶粉',1,1),(21,25,'零食',2,1),(23,25,'衣服',3,1),(25,25,'鞋包',4,1),(27,23,'化妆水/爽肤水',1,1),(29,17,'面部精华',1,1),(31,17,'眼部护肤',2,1),(33,29,'彩妆修复',1,1),(35,29,'迷人香水',1,1),(37,29,'面部彩妆',2,1),(39,1,'唇妆专区',3,1),(41,19,'软毛专区',1,1),(43,21,'零食专区',1,1),(45,33,'面部清洁',1,1),(47,1,'迷人香水',1,1),(49,31,'女装',1,1),(51,21,'奶粉专区',2,1);

#
# Structure for table "vcos_activity_product"
#

DROP TABLE IF EXISTS `vcos_activity_product`;
CREATE TABLE `vcos_activity_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `activity_cid` int(11) DEFAULT NULL COMMENT '活动分类id',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `start_show_time` datetime DEFAULT NULL COMMENT '开始显示时间',
  `end_show_time` datetime DEFAULT NULL COMMENT '结束显示时间',
  `product_type` tinyint(4) NOT NULL COMMENT '1,分类2,品牌3,店铺4,活动5,广告6,商品',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COMMENT='活动商品表';

#
# Data for table "vcos_activity_product"
#

INSERT INTO `vcos_activity_product` VALUES (9,1,9,NULL,3,'2015-11-03 11:06:00','2015-11-30 11:06:00',4),(19,23,55,17,1,'2015-11-05 15:38:00','2016-02-18 15:38:00',6),(21,23,51,15,1,'2015-11-05 15:47:00','2015-11-25 15:47:00',6),(23,23,53,13,3,'2015-11-05 15:48:00','2015-11-30 15:48:00',6),(25,23,49,11,1,'2015-11-05 15:51:30','2015-11-30 15:51:30',6),(27,25,41,21,1,'2015-11-05 15:56:15','2015-11-25 15:56:15',6),(29,25,43,21,2,'2015-11-05 15:56:45','2015-11-26 15:56:45',6),(33,25,47,1,4,'2015-11-05 15:57:30','2015-11-30 15:57:30',6),(35,1,3,NULL,2,'2015-11-05 16:29:00','2015-11-28 16:29:00',3),(37,1,7,NULL,3,'2015-11-05 12:45:01','2015-11-30 16:45:01',3),(43,1,37,1,4,'2015-11-06 15:07:00','2016-02-26 15:07:00',6),(45,9,37,9,5,'2015-11-06 15:58:04','2015-11-26 15:58:04',6),(49,1,53,1,1,'2015-11-06 16:01:45','2015-11-30 16:01:45',6),(51,9,55,9,3,'2015-11-06 16:02:00','2015-11-30 16:02:00',6),(53,1,9,NULL,1,'2015-11-06 16:03:01','2015-11-30 16:03:01',3),(55,9,1,NULL,1,'2015-11-06 16:04:00','2015-11-30 16:04:00',4),(57,9,9,NULL,4,'2015-11-06 16:04:15','2015-11-29 16:04:15',3),(61,21,41,43,1,'2015-11-06 16:20:30','2015-12-01 16:20:30',6),(63,31,57,49,1,'2015-11-06 16:23:00','2016-02-22 16:23:00',6),(65,21,59,51,2,'2015-11-06 16:35:00','2016-02-06 16:35:00',6),(73,39,19,NULL,2,'2015-11-08 15:56:30','2015-11-30 15:56:30',4),(75,39,21,NULL,1,'2015-11-08 15:57:45','2015-11-30 15:57:45',4),(77,39,23,NULL,3,'2015-11-08 15:58:04','2015-11-30 15:58:04',4),(81,37,3,NULL,2,'2015-11-08 16:01:30','2015-11-30 16:01:30',3),(83,37,7,NULL,3,'2015-11-08 16:02:01','2015-11-30 16:02:01',3),(91,1,17,NULL,3,'2015-11-02 16:19:00','2015-11-30 16:19:00',4),(93,1,59,NULL,1,'2015-11-01 16:22:00','2015-11-30 16:22:00',4),(95,1,19,1,1,'2015-11-01 16:31:15','2015-11-30 16:31:15',6),(99,37,19,NULL,1,'2015-11-01 16:37:15','2015-11-30 16:37:15',3),(101,37,9,NULL,4,'2015-11-01 16:38:15','2015-11-30 16:38:15',3),(109,17,49,29,1,'2015-11-01 10:51:15','2015-11-30 10:51:15',6),(111,17,69,29,2,'2015-11-01 10:55:30','2015-11-30 10:55:30',6),(113,17,55,29,3,'2015-11-01 11:11:15','2015-11-30 11:11:15',6),(117,25,77,21,1,'2015-11-01 12:48:03','2015-11-30 12:48:03',6),(119,25,75,21,1,'2015-11-01 12:50:00','2015-11-30 12:50:00',6),(121,25,41,21,1,'2015-11-01 12:51:15','2015-11-30 12:51:15',6),(123,1,39,1,3,'2015-11-01 13:51:15','2015-11-30 13:51:15',6),(125,25,75,21,1,'2015-11-01 14:19:15','2015-11-30 14:19:15',6),(127,25,41,19,2,'2015-11-01 14:20:45','2015-11-30 14:20:45',6),(129,1,51,1,2,'2015-11-01 16:28:01','2015-11-30 16:28:01',6),(131,9,79,9,1,'2015-11-01 16:53:00','2015-11-30 16:53:00',6),(133,9,81,9,4,'2015-11-01 16:54:01','2015-11-30 16:54:01',6),(135,17,53,29,3,'2015-11-01 16:56:15','2015-11-30 16:56:15',6),(137,17,51,29,4,'2015-11-01 16:57:15','2015-11-30 16:57:15',6),(139,47,0,0,1,'2015-11-01 17:12:00','2015-11-30 17:12:00',6),(141,1,0,1,1,'2015-11-01 17:18:00','2015-11-30 17:18:00',6),(143,21,79,51,3,'2015-11-01 17:37:45','2015-11-30 17:37:45',6),(145,21,81,51,4,'2015-11-01 17:38:15','2015-11-30 17:38:15',6);

#
# Structure for table "vcos_brand"
#

DROP TABLE IF EXISTS `vcos_brand`;
CREATE TABLE `vcos_brand` (
  `brand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `brand_cn_name` varchar(128) DEFAULT NULL COMMENT '品牌名',
  `brand_en_name` varchar(128) DEFAULT NULL COMMENT '品牌英文名',
  `country_id` int(11) DEFAULT NULL COMMENT '品牌国家',
  `brand_logo` varchar(128) DEFAULT NULL COMMENT '品牌logo',
  `brand_desc` varchar(255) DEFAULT NULL COMMENT '品牌描述',
  `brand_status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='品牌表';

#
# Data for table "vcos_brand"
#

INSERT INTO `vcos_brand` VALUES (1,'科颜氏','Kiehl\'s',1,'activity_images/201511/201511061535427295.jpg','好地方a',1),(7,'葆蝶家','BOTTEGA VENETA',1,'activity_images/201511/201511041704061669.jpg','hhh',1),(13,'袋鼠','Aussie',1,'activity_images/201511/201511061536256304.jpg','Aussie袋鼠三分钟奇迹发膜，殿堂级的亲民护发品，滋润发质，从里到外，含有野黑硬皮成分，用后能使头发丰盈蓬松，轻松抚平顽固毛躁。',1),(15,'加州宝宝','CALIFORNIA BABY',1,'brand_images/201511/201511041701317094.jpg','CALIFORNIA BABY，加州宝宝是美国婴儿有机护理领导品牌，所有产品成分都是天然有机的，测试标准达到或超过最高世界标准，是担心宝宝受化学刺激伤害的第一',1),(17,'美林','Mellin',3,'brand_images/201511/201511041702315131.jpg','意大利辅食的代名词，是意大利家喻户晓的婴幼儿食品生产商，拥有自己的天然优质农庄和牧场。',1),(19,'九朵云','Cloud9',1,'brand_images/201511/201511041703391465.jpg','九朵云根据多年临床经验，研究和分析顾客的皮肤问题，为了皮肤的安全决不使用防腐剂，是可以解决多种皮肤问题的无刺激化妆品。',1),(21,'博柏利','BURBERRY ',5,'brand_images/201511/201511041705001380.jpg','过去的几十年，Burberry主要以生产雨衣、伞具及丝巾为主，而今博柏利强调英国传统高贵的设计，赢取无数人的欢心，成为一个永恒的品牌',1),(23,'菲拉格慕','Salvatore Ferragamo ',3,'brand_images/201511/201511041706037815.jpg','菲拉格慕以制鞋起家，是皮革制品、配件、服装和香氛的世界顶级设计品牌之一。奥黛丽赫本、苏菲亚罗兰、玛丽莲梦露等都曾是他忠实的支持者',1),(25,'德运','DEVONDALE ',7,'brand_images/201511/201511041707018231.jpg','1900年，在澳大利亚的维多利亚省有超过100家的乳制品合作社。1950年，一小部分奶农联合起来形成了今天澳大利亚最大的乳制品合作社。',1),(27,'健安喜','GNC ',1,'brand_images/201511/201511041708188017.jpg','始于1935年，美国第一营养品牌，全球最大的综合健康营养品专业品牌。天然的才是最好的，按美国FDA、国际GMP标准制造，通过国际清真食品认证。',1),(29,'丹尼尔惠灵顿','Daniel Wellington ',7,'brand_images/201511/201511041709125256.jpg','将斯堪的纳维亚风格的特色充分展现到设计中，主张保持产品的简约风格，带给人们一种古典而又永恒的时尚魅力',1),(35,'莎娜','SANA',1,'activity_images/201511/201511100853227453.jpg','化妆品护肤品',1),(37,'伊索','VISODATE SERIES',5,'activity_images/201511/201511091702066231.png','高级机械表',1),(39,'日本果汁','日本',9,'brand_images/201511/201511051456498525.jpg','营养果汁',1),(41,'良品铺子','Ichiban shop',2,'brand_images/201511/201511051458146083.jpg','坚果类',1),(43,'三只松鼠','Three squirrels ',2,'brand_images/201511/201511061535114340.jpg','值得信赖',1),(45,'牛栏','Holland',11,'brand_images/201511/201511061622215852.jpg','宝宝奶粉',1),(47,'阿玛尼','Armani',3,'brand_images/201511/201511061747555592.jpg','Armani',1),(49,'百利威','Playwell',2,'brand_images/201511/201511091038516898.jpg','创立于1960年，中国玩具十大品牌之一，特别对开发儿童智力有独到设计思路',1),(51,'花王','KAO',9,'brand_images/201511/201511091359185333.png','花王株式会社成立于1887年，花王前身是西洋杂货店“长濑商店”（花王石碱），主要销售美国产化妆香皂以及日本国产香皂和进口文具等，花王创业人是长濑富郎。目前花王产',1),(53,'LG集团','LG',9,'brand_images/201511/201511091401017643.png','国LG集团于1947年成立于韩国首尔，位于首尔市永登浦区汝矣岛洞20号。是领导世界产业发展的国际性企业集团。LG集团目前在171个国家与地区建立了300多家海外',1),(55,'迈克高仕','Michael Kros',1,'brand_images/201511/201511091403584332.png','Michael Kors迈克高仕公司于1981年正式成立，总部设在纽约市。',1),(57,'its skin','its skin',9,'brand_images/201511/201511091405227794.png','it\'s skin一个护肤品品牌，在2007年获得英国kifus顶级化妆品有限公司技术配方支持，成为韩国时尚品牌新宠，韩国三大化妆品之一',1);

#
# Structure for table "vcos_category"
#

DROP TABLE IF EXISTS `vcos_category`;
CREATE TABLE `vcos_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(32) DEFAULT NULL COMMENT '分类编码',
  `name` varchar(128) DEFAULT NULL COMMENT '分类名',
  `parent_cid` varchar(32) DEFAULT NULL COMMENT '父级编码',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=358 DEFAULT CHARSET=utf8 COMMENT='分类表';

#
# Data for table "vcos_category"
#

INSERT INTO `vcos_category` VALUES (1,'10','母婴用品','0',1,1),(3,'11','家居生活','0',3,1),(5,'1001','健康辅食','10',1,1),(7,'1001001','米粉米糊','1001',1,1),(17,'1101','厨房电器','11',1,1),(19,'1102','生活电器','11',2,1),(21,'1101001','电压力锅','1101',1,1),(23,'1101002','豆浆机','1101',2,1),(25,'1102001','电风扇','1102',1,1),(27,'12','运动户外','0',3,1),(29,'13','电脑、办公','0',4,1),(31,'14','手机、数码、京东通信','0',5,1),(35,'16','营养保健','0',7,1),(37,'17','服饰鞋包','0',8,1),(39,'1201','运动鞋包','12',1,1),(41,'1202','健身训练','12',2,1),(43,'1203','运动服饰','12',3,1),(45,'1201001','跑步鞋','1201',1,1),(47,'1201002','休闲鞋','1201',2,1),(49,'1201003','拖鞋','1201',3,1),(51,'1201004','专项运动鞋','1201',4,1),(53,'1201005','板鞋','1201',5,1),(55,'1202001','跑步机','1202',1,1),(57,'1202002','哑铃','1202',2,1),(59,'1202003','武术搏击','1202',3,1),(61,'1202004','综合训练术','1202',4,1),(63,'1203001','羽绒服','1203',1,1),(65,'1203002','T桖','1203',2,1),(67,'1203003','运动套装','1203',3,1),(89,'1001003','饼干','1001',3,1),(91,'1001004','营养品','1001',4,1),(93,'1001005','肉松面仔','1001',5,1),(117,'1103','大家电','11',3,1),(119,'1103001','平板电视','1103',1,1),(121,'1103002','空调','1103',2,1),(123,'1301','电脑整机','13',1,1),(125,'1302','电脑配件','13',2,1),(127,'1302001','CPU','1302',1,1),(129,'1302002','主板','1302',2,1),(133,'1301001','笔记本','1301',1,1),(135,'1301002','超级本','1301',2,1),(137,'1301003','笔记本配件','1301',3,1),(139,'1401','手机通讯','14',1,0),(141,'1402','京东通讯','14',2,1),(143,'1403','手机配件','14',3,1),(145,'1403001','创意配件','1403',1,1),(147,'1403002','蓝牙耳机','1403',3,1),(149,'1402001','选号中心','1402',1,1),(151,'1402002','自助服务','1402',2,1),(153,'1401001','手机','1401',1,0),(155,'1401002','对讲机','1401',2,0),(157,'1403003','电池/移动电源','1403',2,1),(171,'1601','营养健康','16',1,1),(173,'1602','营养成分','16',2,1),(175,'1602001','维生素/矿物质','1602',1,1),(177,'1602002','蛋白质','1602',3,1),(179,'1602003','牛初乳','1602',2,1),(181,'1601001','调节免疫','1601',1,1),(183,'1601002','骨骼健康','1601',2,1),(185,'1701','女装','17',1,1),(187,'1702','男装','17',2,1),(189,'1703','内衣','17',3,1),(191,'1704','配饰','17',4,1),(193,'1704001','老花镜','1704',1,1),(195,'1704002','真皮手套','1704',2,1),(197,'1704003','毛线帽','1704',3,1),(199,'1703001','保暖内衣','1703',1,1),(201,'1703002','秋衣秋裤','1703',2,1),(203,'1703003','美腿袜','1703',3,1),(205,'1702001','羽绒服','1702',1,1),(207,'1702002','休闲裤','1702',2,1),(209,'1702003','牛仔裤','1702',3,1),(211,'1702004','西服套装','1702',4,1),(213,'1701001','毛呢大衣','1701',1,1),(215,'1701002','针织衫','1701',2,1),(217,'1701003','雪纺衫','1701',3,1),(219,'1701004','牛仔裤','1701',4,1),(221,'1701005','羊毛衫','1701',5,1),(239,'1004','宝宝清洁','10',4,1),(241,'1005','益智玩具','10',5,1),(243,'1004001','洗漱护肤','1004',1,1),(245,'1004002','护理用品','1004',2,1),(247,'1104','口腔护理','11',4,1),(249,'1105','洗发护发','11',5,1),(251,'1104001','牙膏','1104',1,1),(253,'1104002','漱口水','1104',2,1),(255,'1104003','牙刷/牙线','1104',3,1),(257,'1105001','护发素','1105',1,1),(259,'1105002','发膜','1105',2,1),(261,'18','美容彩妆','0',2,1),(263,'1801','护肤','18',1,1),(265,'1802','彩妆','18',2,1),(267,'1803','面膜','18',3,1),(269,'19','进口美食','0',9,1),(271,'1901','人气美味','19',1,1),(273,'1902','地域美食','19',2,1),(275,'1801001','乳液面霜','1801',1,1),(277,'1801002','精华','1801',2,1),(279,'1802001','眼线','1802',1,1),(281,'1802002','美甲','1802',2,1),(283,'1803001','保湿面膜','1803',1,1),(285,'1901001','日韩泡面','1901',1,1),(287,'1901002','奶粉/奶片','1901',2,1),(289,'1902001','纯净澳洲','1902',1,1),(291,'1902002','台湾美食','1902',2,1),(293,'1704004','手表','1704',4,1),(295,'1901003','果汁','1901',3,1),(297,'1901004','零食小吃','1901',4,1),(299,'1901005','热带果干','1901',5,1),(301,'1802003','唇膏','1802',4,1),(307,'1001006','奶粉','1001',6,1),(309,'1704005','项链','1704',5,1),(311,'1704006','墨镜','1704',6,1),(313,'1804','防晒修复','18',4,1),(315,'1901006','咖啡茶饮','1901',6,1),(317,'1603','女性必备','16',3,1),(319,'1603001','减肥瘦身','1603',1,1),(321,'1603002','胶原蛋白','1603',2,1),(323,'1603003','清肠排毒','1603',3,1),(325,'1701006','连衣裙','1701',5,1),(327,'1005001','搭塑胶火车','1005',6,1),(329,'1005002','宝宝零食','1005',2,1),(331,'1005003','宝宝零食','1005',2,1),(333,'1006','宝宝零食','10',2,1),(335,'1006001','aa','1006',2,0),(337,'1006002','bb','1006',2,0),(339,'1007','营养添加','10',3,1),(341,'1008','喂哺餐具','10',6,1),(343,'20','纸尿裤','0',10,1),(345,'2001','NB号','20',1,1),(347,'2002','S号','20',2,1),(349,'2003','M号','20',3,1),(351,'2004','L号','20',4,1),(353,'2005','XL号','20',5,1),(355,'2006','XXL号','20',6,1),(357,'1009','营养奶粉','10',7,1);

#
# Structure for table "vcos_category_brand"
#

DROP TABLE IF EXISTS `vcos_category_brand`;
CREATE TABLE `vcos_category_brand` (
  `category_code` varchar(12) NOT NULL,
  `brand_id` int(11) NOT NULL COMMENT '品牌id',
  `cruise_id` int(11) NOT NULL COMMENT '邮轮id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类品牌表';

#
# Data for table "vcos_category_brand"
#


#
# Structure for table "vcos_country"
#

DROP TABLE IF EXISTS `vcos_country`;
CREATE TABLE `vcos_country` (
  `country_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_cn_name` varchar(128) DEFAULT NULL COMMENT '国家名',
  `country_en_name` varchar(128) DEFAULT NULL COMMENT '国家英文名',
  `country_code` varchar(2) DEFAULT NULL COMMENT '国家编码',
  `country_short_code` varchar(3) DEFAULT NULL COMMENT '国家短编码',
  `country_number` int(11) DEFAULT NULL COMMENT '国家数字代号',
  `country_logo` varchar(128) DEFAULT NULL COMMENT '国旗logo',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='国家表';

#
# Data for table "vcos_country"
#

INSERT INTO `vcos_country` VALUES (1,'美国','U.S.A',NULL,NULL,NULL,NULL,1),(2,'中国','China',NULL,NULL,NULL,NULL,1),(3,'意大利亚','Italy',NULL,NULL,NULL,NULL,1),(5,'欧洲','Europe',NULL,NULL,NULL,NULL,1),(7,'澳大利亚','Australia',NULL,NULL,NULL,NULL,1),(9,'日本','Japan',NULL,NULL,NULL,NULL,1),(11,'荷兰','Holland ',NULL,NULL,NULL,NULL,1);

#
# Structure for table "vcos_cruise"
#

DROP TABLE IF EXISTS `vcos_cruise`;
CREATE TABLE `vcos_cruise` (
  `cruise_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '邮轮ID',
  `cruise_name` varchar(100) NOT NULL COMMENT '邮轮名',
  `cruise_basic_info` text NOT NULL COMMENT '邮轮简介',
  `cruise_detail_info` text NOT NULL COMMENT '邮轮详细信息',
  `cruise_logo_url` varchar(128) DEFAULT NULL,
  `cruise_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '邮轮状态',
  PRIMARY KEY (`cruise_id`),
  KEY `cruise_state` (`cruise_id`,`cruise_status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='邮轮表';

#
# Data for table "vcos_cruise"
#

INSERT INTO `vcos_cruise` VALUES (1,'中华泰山号邮轮','船  名：中华泰山 Chinese Taishan\n隶属于：（香港）渤海邮轮有限公司\n船  籍：巴拿马\n全  长：180.45米\n型  宽：25.5米\n吨  位：25000总吨\n最大航速：28节\n房间数量：416间\n额定载客: 927人\n服务人员：360人 ','“中华泰山号”由德国制造，船舶总长180.45米，型宽25.5米，总吨位2.45万吨，拥有927个客位；邮轮的各种配套设施完善，剧院、画廊、图书馆、免税店、小教堂等一应俱全，可满足乘客多种生活和娱乐需求。 “中华泰山号”将主要立足于中国周边的亚洲国家开展邮轮业务，航线为5至7天，其中夏季将航行于中国-韩国-日本之间，冬季将航行于台湾地区以及东南亚国家。',NULL,0);

#
# Structure for table "vcos_navigation"
#

DROP TABLE IF EXISTS `vcos_navigation`;
CREATE TABLE `vcos_navigation` (
  `navigation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_name` varchar(32) DEFAULT NULL COMMENT '导航名',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(4) DEFAULT '1' COMMENT '导航状态',
  `navigation_style_type` tinyint(4) DEFAULT '1' COMMENT '1手机，2网页',
  `activity_id` int(11) DEFAULT NULL,
  `cruise_id` int(11) DEFAULT NULL COMMENT '邮轮id',
  `is_show` tinyint(4) DEFAULT NULL COMMENT '是否显示',
  `is_category` tinyint(4) DEFAULT NULL COMMENT '是否设置分类',
  `is_main` tinyint(4) DEFAULT NULL COMMENT '是否第一个显示',
  PRIMARY KEY (`navigation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='导航表';

#
# Data for table "vcos_navigation"
#

INSERT INTO `vcos_navigation` VALUES (1,'推荐',1,1,1,1,1,1,0,1),(5,'店铺',2,1,1,37,1,1,0,0),(7,'活动',3,1,1,39,1,1,0,0),(29,'商品分类',1,1,1,1,1,1,1,0),(63,'推荐',3,0,1,17,1,1,0,0),(65,'活动',2,1,1,21,1,1,0,0);

#
# Structure for table "vcos_navigation_group"
#

DROP TABLE IF EXISTS `vcos_navigation_group`;
CREATE TABLE `vcos_navigation_group` (
  `navigation_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `navigation_id` int(11) DEFAULT NULL COMMENT '导航id',
  `navigation_group_name` varchar(64) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `show_type` tinyint(4) DEFAULT NULL COMMENT '1文字，2图片，3图文',
  `status` tinyint(4) DEFAULT '1' COMMENT '1可用',
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `img_url` varchar(128) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`navigation_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COMMENT='导航组表';

#
# Data for table "vcos_navigation_group"
#

INSERT INTO `vcos_navigation_group` VALUES (1,29,'奶粉',2,1,0,9,'navigation_images/201511/'),(35,5,'面膜',2,1,0,9,NULL),(39,7,'辅食营养',2,1,0,9,'navigation_images/201511/'),(41,1,'童装童鞋',3,1,0,9,NULL),(43,7,'宝宝用品',1,1,0,9,'navigation_images/201511/'),(47,5,'防晒修复',4,1,0,9,'navigation_images/201511/'),(51,7,'口腔护理',2,1,0,9,NULL),(53,7,'数码电器',3,1,0,9,NULL),(55,5,'卫生巾',4,1,0,9,'navigation_images/201511/'),(79,29,'鞋子',3,2,0,1,'navigation_images/201511/'),(85,29,'母婴用品',1,2,1,9,'navigation_images/201511/201511101029332248.png'),(87,29,'纸尿裤',2,2,1,1,'navigation_images/201511/201511101029598970.png');

#
# Structure for table "vcos_navigation_group_brand"
#

DROP TABLE IF EXISTS `vcos_navigation_group_brand`;
CREATE TABLE `vcos_navigation_group_brand` (
  `navigation_group_bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_group_id` int(11) DEFAULT NULL COMMENT '导航组id',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `sort_order` tinyint(4) DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`navigation_group_bid`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

#
# Data for table "vcos_navigation_group_brand"
#

INSERT INTO `vcos_navigation_group_brand` VALUES (1,79,1,6,1),(3,39,45,1,0),(5,85,45,1,0),(7,85,41,2,1),(9,87,15,2,1),(11,87,13,1,1),(13,39,1,1,0),(15,43,15,1,0),(17,79,53,1,1),(19,85,51,3,1),(21,85,27,7,1),(23,87,7,8,1),(25,85,29,9,1),(27,87,19,10,1),(29,85,49,11,0),(31,85,55,1,1),(33,79,47,1,1),(35,85,25,1,1),(37,85,57,12,0),(39,85,17,3,0),(41,85,21,12,1),(43,87,23,9,1);

#
# Structure for table "vcos_navigation_group_category"
#

DROP TABLE IF EXISTS `vcos_navigation_group_category`;
CREATE TABLE `vcos_navigation_group_category` (
  `navigation_group_cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_group_id` int(11) DEFAULT NULL COMMENT '分类id',
  `navigation_category_name` varchar(64) NOT NULL,
  `sort_order` int(11) DEFAULT '99' COMMENT '排序',
  `is_highlight` tinyint(4) DEFAULT '0' COMMENT '亮度，1高亮',
  `category_type` tinyint(4) DEFAULT NULL COMMENT '1分类，2品牌，3店铺，4活动，5广告，6商品',
  `mapping_id` varchar(255) DEFAULT NULL COMMENT '实际分类id(1,2,3)',
  `status` tinyint(4) DEFAULT '1' COMMENT '1启用，2禁用',
  PRIMARY KEY (`navigation_group_cid`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='导航分类表';

#
# Data for table "vcos_navigation_group_category"
#

INSERT INTO `vcos_navigation_group_category` VALUES (3,1,'爱他美',2,1,1,'1001003,1001004',0),(27,1,'贝拉米',2,1,1,'1601001',0),(33,35,'自然晨露',1,1,1,'1001003,1001001',0),(39,39,'泡芙',2,1,1,'1001',0),(41,43,'洗漱护肤',1,1,1,'1004',0),(43,51,'牙膏/牙线',2,1,1,'1104003',0),(45,53,'生活电器',3,1,1,'1102',0),(49,39,'健康辅食',1,1,1,'1001001,1001003',0),(51,85,'宝宝清洁',3,1,1,'1004002',1),(53,85,'健康辅食',1,1,1,'1001006',1),(55,87,' 日本花王',1,1,1,'1004002',0),(57,79,'its skin',1,1,2,'',1),(59,85,'宝宝零食',2,1,1,'1006',1),(61,85,'益智玩具',4,1,1,'1005002,1005001,1005003',1),(63,85,'营养添加',5,1,1,'1007',1),(65,85,'喂哺餐具',6,1,1,'1008',1),(67,87,'NB号',1,1,1,'2001',1),(69,87,'S号',2,1,1,'2002',1),(71,87,'M号',3,1,1,'2003',1),(73,87,'L号',4,1,1,'2004',1),(75,87,'XL号',5,1,1,'2005',1),(77,87,'XXL号',6,1,1,'2006',1),(79,85,'测试分类',1,1,1,'1001006',1);

#
# Structure for table "vcos_product"
#

DROP TABLE IF EXISTS `vcos_product`;
CREATE TABLE `vcos_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(32) DEFAULT NULL COMMENT '商品编码',
  `product_name` varchar(128) DEFAULT NULL COMMENT '商品名',
  `product_desc` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `product_img` varchar(128) DEFAULT NULL COMMENT '商品图片',
  `inventory_num` int(11) DEFAULT NULL COMMENT '商品库存',
  `sale_price` int(11) DEFAULT NULL COMMENT '商品销售价',
  `standard_price` int(11) DEFAULT NULL COMMENT '商品原价',
  `category_code` varchar(12) DEFAULT NULL COMMENT '商品分类code',
  `cruise_id` int(11) DEFAULT NULL COMMENT '邮轮id',
  `shop_id` int(11) DEFAULT NULL COMMENT '商品店铺id',
  `brand_id` int(11) DEFAULT NULL COMMENT '商品品牌id',
  `sale_num` int(11) DEFAULT NULL COMMENT '商品销量',
  `comment_num` int(11) DEFAULT NULL COMMENT '商品评价数',
  `sale_start_time` datetime DEFAULT NULL COMMENT '商品开始销售时间',
  `sale_end_time` datetime DEFAULT NULL COMMENT '商品结束销售时间',
  `creator_type` tinyint(4) DEFAULT '1' COMMENT '创建者类型1,店铺员工',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `creator` varchar(64) DEFAULT NULL COMMENT '创建者',
  `creator_id` int(11) DEFAULT NULL COMMENT '创建者id',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `origin` varchar(100) DEFAULT NULL COMMENT '产地',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COMMENT='商品表';

#
# Data for table "vcos_product"
#

INSERT INTO `vcos_product` VALUES (19,'SANA003','豆乳美肌保湿乳液','美白滋润，保湿不粘腻','product_images/201511/201511051357377381.png',20,12900,35000,'1801001',1,21,35,NULL,NULL,'2015-11-01 16:34:00','2015-11-30 16:34:00',1,'2015-11-03 16:36:44','超级管理员',1,1,'加拿大'),(37,'hf002','巧克力丝滑肤如凝脂护肤水乳','保湿去皱','product_images/201511/201511051407059901.png',300,12800,13000,'1801001',1,29,35,NULL,NULL,'2015-11-05 14:15:01','2016-03-18 14:15:01',1,'2015-11-05 14:07:05','超级管理员',1,1,'美国'),(39,'sb001','全自动机械表','全自动机械表，高端大气上档次','product_images/201511/201511051410234375.png',120,26500,30000,'1704004',1,19,37,NULL,NULL,'2015-11-05 14:18:00','2015-11-13 14:18:00',1,'2015-11-05 14:10:23','超级管理员',1,1,'加拿大'),(41,'yl001','猕猴桃果汁','果汁','product_images/201511/201511051454182736.jpg',200,2800,3600,'1901003',1,19,37,NULL,NULL,'2015-11-05 15:01:00','2016-02-24 15:01:00',1,'2015-11-05 14:54:18','超级管理员',1,1,'日本'),(43,'wy002','芒果干','爽口','product_images/201511/201511051500586832.png',200,2000,2300,'1902002',1,19,41,NULL,NULL,'2015-11-05 15:09:45','2016-04-07 15:09:45',1,'2015-11-05 15:00:58','超级管理员',1,1,'中国'),(49,'ac001','JAPAN 日本品牌口红','不易褪色','product_images/201511/201511051520017783.png',50,4200,4600,'1802003',1,17,1,NULL,NULL,'2015-11-05 15:28:03','2015-11-20 15:28:03',1,'2015-11-05 15:20:01','超级管理员',1,1,'日本'),(51,'ac002','美国进口高档皮肤滋润膏','保湿滋润','product_images/201511/201511051521243934.png',300,5800,6300,'1801001',1,17,37,NULL,NULL,'2015-11-05 15:31:00','2015-11-27 15:31:00',1,'2015-11-05 15:21:24','超级管理员',1,1,'美国'),(53,'ac003','韩国绿元素清新润发膏','让您的头发长久湿润','product_images/201511/201511051522511488.png',50,4700,4800,'1801001',1,17,35,NULL,NULL,'2015-11-05 15:32:15','2015-11-24 15:32:15',1,'2015-11-05 15:22:51','超级管理员',1,1,'韩国'),(55,'ac004','日本进口皮肤水润膏','让你的皮肤持久保持弹性','product_images/201511/201511051523533122.png',200,4800,5000,'1801001',1,17,37,NULL,NULL,'2015-11-05 15:33:45','2015-11-23 15:33:45',1,'2015-11-05 15:23:53','超级管理员',1,1,'日本'),(57,'yf001','名媛范气质 设计无袖连衣裙 ','名媛气质','product_images/201511/201511101724551491.jpg',200,19000,20000,'1701006',1,7,13,NULL,NULL,'2015-11-06 16:09:01','2015-11-30 16:09:01',1,'2015-11-06 16:00:42','超级管理员',1,1,'中国'),(59,'nf001','荷兰牛栏','婴儿奶粉 2段6-10个月 850克','product_images/201511/201511061614551462.jpg',200,34800,40000,'1001006',1,19,1,NULL,NULL,'2015-11-06 16:24:01','2016-01-09 16:24:01',1,'2015-11-06 16:14:55','超级管理员',1,1,'荷兰'),(61,'spbm12345','阿玛尼','全球号的奢侈品，提高档次','product_images/201511/201511061741171177.png',2,500000,700000,'1701001',1,17,25,NULL,NULL,'2015-11-01 00:46:45','2015-11-28 17:46:45',1,'2015-11-06 17:41:17','超级管理员',1,1,'英国'),(63,'spbm001','进口零食','来自的世界各地的零食，是吃货们的美食天堂','product_images/201511/201511090834088562.jpg',1000,10000,15000,'1901004',1,19,39,NULL,NULL,'2015-11-01 08:40:45','2015-11-30 23:40:45',1,'2015-11-09 08:34:08','超级管理员',1,1,'世界各地'),(65,'spbm003','儿童益智游戏搭火车','有益于儿童开发智力','product_images/201511/201511091033341657.jpg',1000,5000,8000,'1005001',1,31,49,NULL,NULL,'2015-11-01 10:40:04','2015-11-30 23:40:04',1,'2015-11-09 10:33:34','超级管理员',1,1,'中国'),(71,'zero001','JAPAN JOOS日本猕猴桃果汁','好吃','product_images/201511/201511101141339182.png',100,2800,3600,'1901004',1,19,41,NULL,NULL,'2015-11-01 11:48:45','2015-11-30 11:48:45',1,'2015-11-10 11:41:33','超级管理员',1,1,'日本'),(73,'zero002','良品铺子 芒果干108g','便宜','product_images/201511/201511101143236545.png',100,2000,2300,'1901004',1,19,41,NULL,NULL,'2015-11-01 11:52:30','2015-11-30 11:52:30',1,'2015-11-10 11:43:23','超级管理员',1,1,'日本'),(75,'zero003','韩国营养海苔','好吃','product_images/201511/201511101144477256.png',100,2800,3200,'1901004',1,25,41,NULL,NULL,'2015-11-01 11:54:00','2015-11-30 11:54:00',1,'2015-11-10 11:44:47','超级管理员',1,1,'韩国'),(77,'zero004','日本北海道香脆饼干','好吃','product_images/201511/201511101149132123.png',100,2800,3200,'1901004',1,25,41,NULL,NULL,'2015-11-01 11:58:45','2015-11-30 11:58:45',1,'2015-11-10 11:49:13','超级管理员',1,1,'日本'),(79,'naifen1','JAPEN GALS PURE 5 ESSENCE 益智奶粉','便宜','product_images/201511/201511101441435281.png',1000,38000,46000,'1001006',1,23,15,NULL,NULL,'2015-11-01 14:46:04','2015-11-30 14:46:04',1,'2015-11-10 14:39:01','超级管理员',1,1,'日本'),(81,'奶粉2','嘉宝（Gerber）贝启嘉幼儿配方奶粉','便宜','product_images/201511/201511101441228873.png',500,27500,52000,'1001006',1,23,15,NULL,NULL,'2015-11-01 14:49:45','2015-11-30 14:49:45',1,'2015-11-10 14:41:22','超级管理员',1,1,'日本'),(83,'奶粉3','JAPEN GALS PURE 5 ESSENCE 品质奶粉','便宜','product_images/201511/201511101443207642.png',50,25000,28000,'1001006',1,19,15,NULL,NULL,'2015-11-01 14:52:01','2015-11-30 14:52:01',1,'2015-11-10 14:43:20','超级管理员',1,1,'日本'),(85,'奶粉4','美国原生态奶粉-补充婴幼儿成长多种维生素','便宜','product_images/201511/201511101444485091.png',50,36000,40000,'1001006',1,19,1,NULL,NULL,'2015-11-01 14:54:00','2015-11-30 14:54:00',1,'2015-11-10 14:44:48','超级管理员',1,1,'美国');

#
# Structure for table "vcos_product_comment"
#

DROP TABLE IF EXISTS `vcos_product_comment`;
CREATE TABLE `vcos_product_comment` (
  `comment_id` int(11) NOT NULL,
  `comment_type` tinyint(4) DEFAULT '1' COMMENT '1主评，2追加',
  `product_id` int(11) DEFAULT NULL,
  `comment_content` varchar(255) DEFAULT NULL,
  `crater_time` datetime DEFAULT NULL,
  `member_code` varchar(32) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `score` tinyint(4) DEFAULT NULL COMMENT '评分',
  `url_img1` varchar(128) DEFAULT NULL,
  `url_img2` varchar(128) DEFAULT NULL,
  `url_img3` varchar(128) DEFAULT NULL,
  `url_img4` varchar(128) DEFAULT NULL,
  `is_upload_img` tinyint(4) DEFAULT NULL,
  `is_add_comment` tinyint(4) DEFAULT '0' COMMENT '1有追评',
  `reply_content` varchar(255) DEFAULT NULL,
  `reply_create_time` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1可用，0禁用',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品评论表';

#
# Data for table "vcos_product_comment"
#

INSERT INTO `vcos_product_comment` VALUES (1,1,47,'商品主评论','2015-11-04 17:49:56','1','1',4,NULL,NULL,NULL,NULL,0,1,'回复1','2015-11-07 00:35:29',1),(2,2,47,'追加评论内容','2015-11-05 17:50:02','1','1',0,NULL,NULL,NULL,NULL,0,0,'回复1','2015-11-07 00:35:34',1),(3,1,47,'会员2商品主评论','2015-11-04 17:50:13','2','2',3,NULL,NULL,NULL,NULL,0,1,'回复1','2015-11-07 00:35:36',1),(4,2,47,'会员2追评','2015-11-05 13:57:27','1','1',0,NULL,NULL,NULL,NULL,0,0,'回复1','2015-11-07 00:35:39',1);

#
# Structure for table "vcos_product_detail"
#

DROP TABLE IF EXISTS `vcos_product_detail`;
CREATE TABLE `vcos_product_detail` (
  `product_detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `text_detail` text COMMENT '商品文本详情',
  `graphic_detail` text COMMENT '商品图文详情',
  PRIMARY KEY (`product_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='商品详情表';

#
# Data for table "vcos_product_detail"
#

INSERT INTO `vcos_product_detail` VALUES (11,19,'<p>不管你每天的饮食如何，每日一颗复合维生素，是一种营养摄入平衡的保障，也是一种健康的“廉价保险”。美国诸多医生和营养学家都推荐每日一颗复合维生素，善存复合维生素家庭装，给全家健康投保。</p>',''),(15,19,'<p>不管你每天的饮食如何，每日一颗复合维生素，是一种营养摄入平衡的保障，也是一种健康的“廉价保险”。美国诸多医生和营养学家都推荐每日一颗复合维生素，善存复合维生素家庭装，给全家健康投保</p>',''),(21,19,'<p>美白滋润，保湿不粘腻<br/></p>',''),(27,57,'<h3 class=\"tb-main-title\" data-title=\"【双11限量5折】西西小可定制款 名媛范气质 设计无袖连衣裙 包邮\">双11限量5折</h3><p><br/></p>',''),(29,61,'<p>阿玛尼是世界知名奢侈品牌，1975年由时尚设计大师乔治·阿玛尼（Giorgio Armani）创立于意大利米兰，乔治·阿玛尼是在美国销量最大的欧洲设计师品牌，他以使用新型面料及优良制作而闻名。&nbsp;&nbsp; <br/></p>',''),(35,73,'<p></p><p>芒果干108g<br/></p>',''),(41,81,'<p>丹麦顶级纸尿裤闪电来“吸”，3-6千克宝宝通用。更轻更薄，3重干爽透气，防漏锁水。天然防过敏材料，顶级绵柔表层。完美贴合裁剪，拒绝O型腿，妈妈们囤货必收款哦。<br/></p>','');

#
# Structure for table "vcos_product_graphic"
#

DROP TABLE IF EXISTS `vcos_product_graphic`;
CREATE TABLE `vcos_product_graphic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `img_url` varchar(128) DEFAULT NULL,
  `graphic_desc` varchar(255) DEFAULT NULL,
  `sort_order` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

#
# Data for table "vcos_product_graphic"
#

INSERT INTO `vcos_product_graphic` VALUES (1,19,'product_images/201511/201511051438241395.jpg','',1),(7,19,'product_images/201511/201511051438371170.jpg','',2),(9,19,'product_images/201511/201511051438496948.jpg','',3),(11,19,'product_images/201511/201511051439017349.jpg','',4),(13,19,'product_images/201511/201511051442136686.jpg','',5),(15,19,'product_images/201511/201511051442238450.jpg','',6),(17,19,'product_images/201511/201511051442353844.jpg','',7),(19,19,'product_images/201511/201511051442466997.jpg','',8),(21,19,'product_images/201511/201511051442572368.jpg','',9),(23,19,'product_images/201511/201511051443097176.jpg','',10),(39,43,'product_images/201511/201511051550333641.jpg','',1),(41,43,'product_images/201511/201511051550421993.jpg','',2),(43,43,'product_images/201511/201511051555148202.jpg','',3),(45,43,'product_images/201511/201511051555249678.jpg','',4),(47,43,'product_images/201511/201511051555361596.jpg','',5),(49,49,'product_images/201511/201511051558303976.jpg','',1),(53,57,'product_images/201511/201511061603166618.jpg',NULL,1),(55,57,'product_images/201511/201511061603315828.jpg',NULL,2),(57,57,'product_images/201511/201511061603442936.jpg',NULL,3),(59,57,'product_images/201511/201511061603574217.jpg',NULL,4),(61,59,'product_images/201511/201511061616284303.jpg',NULL,1),(63,59,'product_images/201511/201511061616436148.jpg',NULL,2),(65,59,'product_images/201511/201511061616575050.jpg',NULL,3),(67,59,'product_images/201511/201511061617176137.jpg',NULL,4),(69,59,'product_images/201511/201511061617329091.jpg',NULL,5),(71,59,'product_images/201511/201511061617456509.jpg',NULL,6),(73,61,'product_images/201511/201511061745335933.png','阿玛尼是世界知名奢侈品牌，1975年由时尚设计大师乔治·阿玛尼（Giorgio Armani）创立于意大利米兰，乔治·阿玛尼是在美国销量最大的欧洲设计师品牌，他',1),(75,49,'product_images/201511/201511100942117074.jpg','顶级口红',1),(77,81,'product_images/201511/201511101447305868.jpg',NULL,1),(79,81,'product_images/201511/201511101447503071.jpg',NULL,2),(81,81,'product_images/201511/201511101448207647.jpg',NULL,3),(85,81,'product_images/201511/201511101449137722.jpg',NULL,4),(87,81,'product_images/201511/201511101449287071.jpg',NULL,5),(89,81,'product_images/201511/201511101449436743.jpg',NULL,6),(91,81,'product_images/201511/201511101449598524.jpg',NULL,7),(93,81,'product_images/201511/201511101450267654.jpg',NULL,8),(95,81,'product_images/201511/201511101450427662.jpg',NULL,9),(97,81,'product_images/201511/201511101451028876.jpg',NULL,10),(99,51,'product_images/201511/201511101620389115.png','便宜',1),(101,51,'product_images/201511/201511101634021514.jpg',NULL,2);

#
# Structure for table "vcos_product_img"
#

DROP TABLE IF EXISTS `vcos_product_img`;
CREATE TABLE `vcos_product_img` (
  `product_img_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `img_url` varchar(128) DEFAULT NULL COMMENT '商品图片',
  `img_type` tinyint(4) DEFAULT '1' COMMENT '商品类型',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '图片排序',
  PRIMARY KEY (`product_img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='商品图片表';

#
# Data for table "vcos_product_img"
#

INSERT INTO `vcos_product_img` VALUES (13,19,'product_images/201511/201511051437091514.png',1,1),(15,19,'product_images/201511/201511051437426303.png',1,2),(49,43,'product_images/201511/201511051550063730.png',1,1),(51,43,'product_images/201511/201511051550152976.png',1,2),(53,57,'product_images/201511/201511101725215257.jpg',1,1),(57,57,'product_images/201511/201511101725581394.jpg',1,3),(59,57,'product_images/201511/201511101725432075.jpg',1,4),(61,59,'product_images/201511/201511061615364312.jpg',1,1),(63,61,'product_images/201511/201511061743553271.png',1,2),(65,61,'product_images/201511/201511061744474020.png',1,2),(67,65,'product_images/201511/201511091051007385.jpg',1,1),(73,77,'product_images/201511/201511101243548404.png',1,1),(75,71,'product_images/201511/201511101346404196.png',1,1),(77,73,'product_images/201511/201511101347316672.png',1,3),(79,75,'product_images/201511/201511101348058874.png',1,4),(81,81,'product_images/201511/201511101500126982.png',1,1),(83,81,'product_images/201511/201511101500249625.png',1,2),(85,81,'product_images/201511/201511101500389419.png',1,3),(87,81,'product_images/201511/201511101500541085.png',1,4),(89,73,'product_images/201511/201511101529588477.png',1,1),(91,51,'product_images/201511/201511101619484048.png',1,1),(93,53,'product_images/201511/201511101629287406.png',1,1),(95,49,'product_images/201511/201511101633349732.png',1,1),(97,55,'product_images/201511/201511101641555478.png',1,1);

#
# Structure for table "vcos_shop"
#

DROP TABLE IF EXISTS `vcos_shop`;
CREATE TABLE `vcos_shop` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_code` varchar(32) DEFAULT NULL COMMENT '店铺code',
  `shop_title` varchar(100) DEFAULT NULL COMMENT '店铺名',
  `shop_logo` varchar(100) DEFAULT NULL COMMENT '店铺logo',
  `shop_img_url` varchar(128) DEFAULT NULL COMMENT '店铺封面图',
  `shop_desc` varchar(200) DEFAULT NULL COMMENT '店铺描述',
  `legal_representative` varchar(100) DEFAULT NULL COMMENT '店铺法人',
  `company_name` varchar(100) DEFAULT NULL COMMENT '所属公司名',
  `shop_address` varchar(100) DEFAULT NULL COMMENT '店铺地址',
  `cash_deposit` int(11) DEFAULT NULL COMMENT '店铺保证金',
  `main_products` varchar(255) DEFAULT NULL COMMENT '店铺主营',
  `created` datetime DEFAULT NULL COMMENT '2015-10-28 12:01:01 入驻时间',
  `business_license` varchar(100) DEFAULT NULL COMMENT '营业执照 pdf扫描件上传地址',
  `shop_status` tinyint(4) DEFAULT NULL COMMENT '店铺状态，1、可用，2、封店',
  `cruise_id` int(11) DEFAULT NULL COMMENT '所属邮轮',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='店铺表';

#
# Data for table "vcos_shop"
#

INSERT INTO `vcos_shop` VALUES (3,'qjxp','PONT运动','shop_images/201511/201511091626385727.jpg','shop_images/201511/201511091630023605.png','主打运动系列','张某某','PONT集团','甲板三层',2000000,'休闲裤、休闲衫、运动鞋','2015-11-09 16:30:02','shop_images/201511/201511091626381282.jpg',1,1),(7,'0002','卡米龙','shop_images/201511/201511041642144075.jpg','shop_images/201511/201511091630147530.png','双肩包、单肩包','李某某','卡米龙有限集团','甲板四层A区',1000000,'休闲包、运动包、双肩包','2015-11-09 16:30:14','shop_images/201511/201511091607583442.png',1,1),(9,'001','米妮箱包专营店','shop_images/201511/201511041643127129.jpg','shop_images/201511/201511091630359704.png','时尚风','张某某','test1','甲板二层',100000,'女装，包包','2015-11-09 16:31:40','shop_images/201511/201511041643124567.png',1,1),(17,'002','采妍国际海外旗舰店','shop_images/201511/201511051416092891.jpg','shop_images/201511/201511051416093500.jpg','正品护肤品','张某某','采妍国际','甲板三层',1000000,'护肤品，化妆品','2015-11-05 14:16:09','shop_images/201511/201511051416093175.jpg',1,1),(19,'ls001','零食物语','shop_images/201511/201511051449492406.jpg','shop_images/201511/201511051449494700.png','零食物语为香港一间专门销售日式零食的连锁店于1997年创立属四洲集团旗下的零售店，代理包括明治及固力果等品牌。','小红','四洲集团','甲板五层左转',200000,'零食小吃','2015-11-05 14:49:49','shop_images/201511/201511051449494882.jpg',1,1),(21,'001','西西小可','shop_images/201511/201511061527425790.jpg','shop_images/201511/201511061527427433.jpg','时尚女装','张某某','西西有限公司','甲板二层',200000,'女装','2015-11-06 15:27:42','shop_images/201511/201511061527429879.jpg',1,1),(23,'0003',' 良心正品断码折扣店','shop_images/201511/201511061529163700.jpg','shop_images/201511/201511061529164954.jpg','正品','李某某','良心品牌','甲板四层左转',1000000,'球服、休闲鞋、运动鞋','2015-11-06 15:29:16','shop_images/201511/201511061529163312.jpg',1,1),(25,'004','良品铺子','shop_images/201511/201511061530232319.jpg','shop_images/201511/201511061530236327.jpg','坚果','张某某','良品铺子','甲板五层中部',2000000,'坚果、饮料','2015-11-06 15:30:23','shop_images/201511/201511061530232774.jpg',1,1),(27,'004','牛栏旗舰店','shop_images/201511/201511061620001742.jpg','shop_images/201511/201511061620008303.jpg','婴儿奶粉','陆某某','荷兰牛栏集团','甲板三层',2000000,'奶粉','2015-11-06 16:20:00','shop_images/201511/201511061620003550.jpg',1,1),(29,'001','奢侈品时装店','shop_images/201511/201511061749417436.jpg','shop_images/201511/201511061749413880.jpg','世界上奢侈品','林','毕升','珠海',5000000,'奢侈品','2015-11-06 17:49:41','shop_images/201511/201511061749413299.jpg',1,1),(31,'1020','儿童益智玩具','shop_images/201511/201511091044191986.jpg','shop_images/201511/201511091044199838.jpg','便宜','Michael','百利威','三层甲板',5000000,'儿童玩具','2015-11-09 10:44:19','shop_images/201511/201511091044198313.jpg',1,1),(33,'20151109','its skin','shop_images/201511/201511091413511282.jpg','shop_images/201511/201511091413514135.jpg','it\'s skin一个护肤品品牌，在2007年获得英国kifus顶级化妆品有限公司技术配方支持，成为韩国时尚品牌新宠，韩国三大化妆品之一','李明浩','it\'s skin','四层甲板',10000000,'化妆品','2015-11-09 14:13:51','shop_images/201511/201511091413517369.jpg',1,1),(35,'0001','aaaaaaaaaa','shop_images/201511/201511091604052803.jpg','shop_images/201511/201511091604059540.jpg','aaa','aa','aaa','aa',1200,'aa','2015-11-09 16:14:21','shop_images/201511/201511091614219700.jpg',1,1),(37,'001','bb','shop_images/201511/201511091607056212.png','shop_images/201511/201511091607059223.png','bb','bbb','bbb','bbb',154600,'bbb','2015-11-09 16:07:05','shop_images/201511/201511091607051735.png',1,1);

#
# Structure for table "vcos_shop_brand"
#

DROP TABLE IF EXISTS `vcos_shop_brand`;
CREATE TABLE `vcos_shop_brand` (
  `shop_brand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  PRIMARY KEY (`shop_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='店铺品牌表';

#
# Data for table "vcos_shop_brand"
#

INSERT INTO `vcos_shop_brand` VALUES (1,3,1,2),(7,3,7,1),(9,7,13,1),(13,3,37,1),(15,9,21,1),(17,17,17,1),(19,19,39,1),(21,19,41,2),(25,23,23,1),(27,25,41,1),(29,27,45,1),(31,29,47,1),(33,3,13,1),(35,29,47,2),(37,29,47,1),(39,31,49,4),(41,33,57,1),(43,3,1,1),(45,3,1,1);

#
# Structure for table "vcos_shop_category"
#

DROP TABLE IF EXISTS `vcos_shop_category`;
CREATE TABLE `vcos_shop_category` (
  `shop_cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `category_code` int(11) NOT NULL COMMENT '商品分类id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分类类型',
  `sort_order` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  PRIMARY KEY (`shop_cid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='店铺分类表';

#
# Data for table "vcos_shop_category"
#

INSERT INTO `vcos_shop_category` VALUES (1,3,1101002,1,2),(7,7,1702001,1,1),(9,3,1702002,1,2),(11,9,1701001,1,2),(15,27,1001006,1,1),(17,27,1001001,1,2),(19,29,1701001,1,1),(21,29,1701001,1,1),(23,31,1005001,1,4),(25,33,1801002,1,1),(29,3,1001001,1,2),(33,9,1701005,1,2);

#
# Structure for table "vcos_shop_operation_category"
#

DROP TABLE IF EXISTS `vcos_shop_operation_category`;
CREATE TABLE `vcos_shop_operation_category` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `category_code` varchar(12) DEFAULT NULL,
  `tree_type` tinyint(4) DEFAULT NULL,
  `is_sub_all` tinyint(4) DEFAULT '0' COMMENT '1:all',
  `status` tinyint(4) DEFAULT NULL,
  `parent_catogory_code` varchar(12) DEFAULT '0',
  PRIMARY KEY (`so_id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

#
# Data for table "vcos_shop_operation_category"
#

INSERT INTO `vcos_shop_operation_category` VALUES (43,3,'1202002',3,1,1,'1202'),(45,3,'1202004',3,1,1,'1202'),(47,3,'1203003',3,1,1,'1203'),(49,3,'1203001',3,1,1,'1203'),(51,3,'1203002',3,1,1,'1203'),(53,3,'1203',2,1,1,'12'),(55,3,'1202',2,0,1,'12'),(57,3,'12',1,0,1,'0'),(79,7,'1702001',3,1,1,'1702'),(81,7,'1702003',3,1,1,'1702'),(83,7,'1702002',3,1,1,'1702'),(85,7,'1702004',3,1,1,'1702'),(87,7,'1704002',3,1,1,'1704'),(89,7,'1704006',3,1,1,'1704'),(91,7,'1704004',3,1,1,'1704'),(93,7,'1702',2,1,1,'17'),(95,7,'1704',2,0,1,'17'),(97,7,'17',1,0,1,'0'),(139,9,'1202003',3,1,1,'1202'),(141,9,'1203003',3,1,1,'1203'),(143,9,'1203001',3,1,1,'1203'),(145,9,'1203002',3,1,1,'1203'),(147,9,'1203',2,1,1,'12'),(149,9,'1202',2,0,1,'12'),(151,9,'12',1,0,1,'0'),(152,37,'1001001',3,1,1,'1001'),(153,37,'1001004',3,1,1,'1001'),(154,37,'1001005',3,1,1,'1001'),(155,37,'1001003',3,1,1,'1001'),(156,37,'1001006',3,1,1,'1001'),(157,37,'1004002',3,1,1,'1004'),(158,37,'1004001',3,1,1,'1004'),(159,37,'1005003',3,1,1,'1005'),(160,37,'1005002',3,1,1,'1005'),(161,37,'1005001',3,1,1,'1005'),(162,37,'1403002',3,1,1,'1403'),(163,37,'1403001',3,1,1,'1403'),(164,37,'1403003',3,1,1,'1403'),(165,37,'1001',2,1,1,'10'),(166,37,'1008',2,1,1,'10'),(167,37,'1007',2,1,1,'10'),(168,37,'1006',2,1,1,'10'),(169,37,'1009',2,1,1,'10'),(170,37,'1005',2,1,1,'10'),(171,37,'1004',2,1,1,'10'),(172,37,'1403',2,1,1,'14'),(173,37,'10',1,1,1,'0'),(174,37,'14',1,0,1,'0'),(175,17,'',3,1,1,''),(176,17,'2001',2,1,1,'20'),(177,17,'2002',2,1,1,'20'),(178,17,'2004',2,1,1,'20'),(179,17,'2005',2,1,1,'20'),(180,17,'2006',2,1,1,'20'),(181,17,'2003',2,1,1,'20'),(182,17,'20',1,1,1,'0');

#
# Structure for table "vcos_shop_user"
#

DROP TABLE IF EXISTS `vcos_shop_user`;
CREATE TABLE `vcos_shop_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='店铺用户表';

#
# Data for table "vcos_shop_user"
#

INSERT INTO `vcos_shop_user` VALUES (1,'test1','123',1,1,1),(2,'test2','12',1,0,1);
