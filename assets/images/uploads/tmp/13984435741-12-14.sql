# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: affordabike
# Generation Time: 2014-01-12 17:55:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bikes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bikes`;

CREATE TABLE `bikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `brand` text NOT NULL,
  `bike_type` text NOT NULL,
  `category` text NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `color` text NOT NULL,
  `sizes` text NOT NULL,
  `components` text NOT NULL,
  `in_stock` int(11) NOT NULL DEFAULT '0',
  `image` text NOT NULL,
  `website` text NOT NULL,
  `description` longtext NOT NULL,
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `bikes` WRITE;
/*!40000 ALTER TABLE `bikes` DISABLE KEYS */;

INSERT INTO `bikes` (`id`, `name`, `brand`, `bike_type`, `category`, `price`, `color`, `sizes`, `components`, `in_stock`, `image`, `website`, `description`, `displayorder`, `active`, `created`, `modified`)
VALUES
	(18,'Bilda Chuck','bildabike','cruiser','Custom Beach',200.00,'','','',0,'bilda-chuck-sample.png','','',0,1,'2011-05-18 15:59:19','2013-01-29 08:17:17'),
	(19,'Bilda Queen','bildabike','cruiser','Custom Beach',250.00,'','','',0,'queen-sample-new.png','','',0,1,'2011-05-18 16:02:47','2013-01-29 08:19:16'),
	(20,'Bilda Popsicle','bildabike','cruiser','Custom Beach',200.00,'','','',0,'bilda-popsicle-sample.png','','',0,1,'2011-05-18 16:04:51','2013-01-29 08:17:47'),
	(598,'Beta Red/Black','retrospec','single','Singlespeed',299.00,'Red/Black','','',0,'beta-black-red.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(599,'Beta Turquoise/White','retrospec','single','Singlespeed',299.00,'Turquoise/White','','',0,'beta-turq-white.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(600,'Mantra Fixie','retrospec','single','Fixie',349.00,'Blue/Black','','',0,'mantra-fixie-black-blue.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(601,'Siddhartha','retrospec','single','Singlespeed',300.00,'Red','','',0,'retrospec_siddhartha_red.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(602,'Girl\'s Street 20\"','cannondale','kids','Kids',370.00,'Gray','','',0,'c_13_FSTREET20_gry_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(491,'Storm 9.2','norco','mountain','Hardtail 29er',529.00,'Grey / Black','','',0,'storm92.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:25:08'),
	(603,'Girl\'s Street 24\"','cannondale','kids','Kids',410.00,'White','','',0,'c_13_FSTREET24_bbq_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(604,'Boy\'s Trail 20\"','cannondale','kids','Kids',370.00,'Black','','',0,'c_13_MTRAIL20_blk_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(490,'Storm 6.3 Forma','norco','mountain','Hardtail 26',420.00,'Grey','','',0,'storm63forma.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:24:32'),
	(489,'City Glide Men\'s 2 Auto','norco','urban','Hybrid',570.00,'Grey','','',0,'cityglide2auto.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:38:10'),
	(596,'City Glide Men\'s','norco','urban','Hybrid',505.00,'Black','','',0,'cityglidem.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(487,'Yorkville Men\'s','norco','urban','Hybrid',360.00,'Black','','',0,'yorkvillemens.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-27 12:39:40'),
	(486,'VFR 4','norco','urban','Hybrid',449.00,'Black / Grey','','',0,'vfr4.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:37:23'),
	(485,'EZ Boarding 7','biria','cruiser','Cruiser',550.00,'Blue','40,46 cm','',0,'eb_easy_7_aqua_blue_btrfly.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(483,'EZ Boarding 7','biria','cruiser','Cruiser',550.00,'White','40,46 cm','',0,'eb-cream.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(484,'EZ Boarding 7','biria','cruiser','Cruiser',550.00,'Green ','40,46 cm','',0,'eb-mint.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(481,'EZ Boarding 3','biria','cruiser','Cruiser',575.00,'Green','40,46 cm','',0,'eb-mint_0.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(482,'EZ Boarding 3','biria','cruiser','Cruiser',575.00,'Blue','40,46 cm','',0,'eb_easy_7_aqua_blue_btrfly.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(479,'EZ Boarding 1 ','biria','cruiser','Cruiser',450.00,'Blue','40,46 cm','',0,'eb_easy_7_aqua_blue_btrfly.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(480,'EZ Boarding 3','biria','cruiser','Cruiser',575.00,'White','40,46 cm','',0,'eb-cream.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(478,'EZ Boarding 1 ','biria','cruiser','Cruiser',450.00,'Green','40,46 cm','',0,'eb-mint_0.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(477,'EZ Boarding 1 ','biria','cruiser','Cruiser',450.00,'White','40,46 cm','',0,'eb-cream.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(476,'Fixed Gear ','biria','single','Single Speed',440.00,'Chrome','48,55 cm','',0,'Fixedgear-grey1-sm.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:39:56'),
	(475,'Fixed Gear ','biria','single','Single Speed',440.00,'Black','48,55 cm','',0,'fixedgear-black1-sm.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:40:48'),
	(474,'Fixed Gear ','biria','single','Single Speed',440.00,'White','48,55 cm','',0,'fixedgear-white1-sm.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:41:00'),
	(473,'Women\'s City ','biria','urban','Hybrid',450.00,'Yellow','17,19 inch','',0,'yellow sharp.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(472,'Women\'s City ','biria','urban','Hybrid',450.00,'Baby Blue','17,19 inch','',0,'citilady-babyblue.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(471,'Women\'s City ','biria','urban','Hybrid',450.00,'Sea Foam','17,19 inch','',0,'light green sharp.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(470,'Women\'s City ','biria','urban','Hybrid',450.00,'Olive Green','17,19 inch','',0,'citilady-olive.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(469,'Women\'s City ','biria','urban','Hybrid',450.00,'Black','17,19 inch','',0,'citilady-black.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(468,'Women\'s City ','biria','urban','Hybrid',450.00,'Red','17,19 inch','',0,'citilady-red.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(466,'Men\'s City ','biria','urban','Hybrid',450.00,'Cream','18,21 inch','',0,'cream_men.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(467,'Men\'s City ','biria','urban','Hybrid',450.00,'Baby Blue','18,21 inch','',0,'cream_men.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(465,'Men\'s City ','biria','urban','Hybrid',450.00,'Olive Green','18,21 inch','',0,'olive_green_men.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(464,'Men\'s City','biria','urban','Hybrid',450.00,'Black','18,21 inch','',0,'black_men.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(463,'Men\'s City ','biria','urban','Hybrid',450.00,'Red','18,21 inch','',0,'red_men.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:25:14'),
	(591,'Quick 6 Women\'s','cannondale','urban','Hybrid',520.00,'Black','','',0,'C14_700F_QCK_W6_BLK_6.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(461,'Caad 8 Tiagra','cannondale','road','Road',1250.00,'Black','','',0,'c14_700m_cd8_6_blk_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:56:21'),
	(592,'Felicity','cannondale','urban','Hybrid',870.00,'BBQ','','',0,'C14_700M_FELICITY_BBQ_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(593,'Bad Boy 1','cannondale','urban','Hybrid',1840.00,'BBQ','','',0,'C14_700M_BADBOY_1_BBQ_1.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(460,'Adventure 3','cannondale','urban','Hybrid',520.00,'Black','','',0,'c_13_3as3_blk-1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:10:43'),
	(590,'Adventure 1','cannondale','urban','Hybrid',725.00,'Black','','',0,'c_13_3as1_blk_1.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(456,'Quick 3 SL','cannondale','urban','Hybrid',920.00,'White','','',0,'C14_700M_QCK_SL3_WHT_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:11:16'),
	(457,'Quick 5 CX','cannondale','urban','Hybrid',590.00,'Black','','',0,'C14_700M_QCK_CX5_BLK_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:11:37'),
	(455,'Supersix Evo 105','cannondale','road','Road',2060.00,'BBQ','','',0,'C14_700M_EVO_6_BBQ_CJ.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:00:20'),
	(454,'Synapse Alloy Disc 5','cannondale','road','Road',1570.00,'Black','','',0,'C14_700M_SYNAL_5TDSC_BLK_7.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:58:03'),
	(453,'Synapse Alloy 8 Claris','cannondale','road','Road',920.00,'BBQ','','',0,'C14_700M_SYNAL_8_BBQ_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-27 12:58:29'),
	(451,'Caad 10 5 105','cannondale','road','Road',1680.00,'White','','',0,'C14_700M_CD10_5_WHT_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:56:46'),
	(586,'Storm 7.2','norco','mountain','Hardtail 29er',530.00,'Grey / Black','','',0,'storm72.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(585,'Storm 7.1','norco','mountain','Hardtail 29er',685.00,'Yellow','','',0,'storm71.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(448,'Trail SL 3 29er','cannondale','mountain','Hardtail 29er',1120.00,'White','','',0,'c14_29m_trlsl_3_wht_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:45:13'),
	(588,'Valence Alloy 4','norco','road','Road',680.00,'Blue / White','','',0,'valence_a4.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(589,'Valence Alloy 4 Forma','norco','road','Road',680.00,'Blue','','',0,'valence_a4forma.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(446,'Trail 5 29er','cannondale','mountain','Hardtail 29er',840.00,'Black','','',0,'c14_29m_trail_5_blk_1.png','','',0,1,'2012-03-08 11:02:58','2013-01-22 09:44:43'),
	(510,'Quick 4','cannondale','urban','Hybrid',740.00,'Silver/blue','','',0,'C14_700M_QCK_4_BLU_1.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 10:11:51'),
	(508,'Adventure 3 Women\'s','cannondale','urban','Hybrid',520.00,'Brown/Light Blue','','',0,'c_13_3asw3_grk.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 10:11:00'),
	(509,'Quick 6','cannondale','urban','Hybrid',520.00,'Black','','',0,'C14_700M_QCK_6_BLK_1.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 10:10:22'),
	(583,'Bigfoot','norco','mountain','Fat Bike',1415.00,'','','',0,'bigfoot.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(597,'Beta Pink/White/Blue','retrospec','single','Singlespeed',299.00,'Pink/White/Blue','','',0,'retrospec_beta_pink.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(506,'VFR 4 Forma','norco','urban','Hybrid',459.00,'Sage / Silver','','',0,'vfrforma4.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-22 10:37:37'),
	(503,'Jake','kona','cyclocross','Cyclocross',1149.00,'Grey','51,53, 56, 59cm','',0,'jake.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:21:24'),
	(504,'Jake the Snake','kona','cyclocross','Cyclocross',1649.00,'Orange','51,53,56,59cm','',0,'jake_the_snake.jpg','','',0,1,'2012-03-08 11:02:58','2013-01-22 10:21:34'),
	(505,'Bilda Brewster','bildabike','cruiser','Custom Beach',250.00,'','','',0,'bilda-brewster-sample.png','','',0,1,'2012-03-29 10:29:06','2013-01-29 08:18:00'),
	(512,'Trail 7 29er','cannondale','mountain','Hardtail 29er',600.00,'Black','','',0,'c14_29m_trail_7_blk_1_2.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 09:45:34'),
	(513,'Trail 7 ','cannondale','mountain','Hardtail 26',580.00,'Black','','',0,'c14_26m_trail_7_blk_1.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 09:43:35'),
	(514,'Trail 7 Women\'s','cannondale','mountain','Hardtail 26',580.00,'Grey','','',0,'C14_26F_TRAIL_W7_GRY_1.png','','',0,1,'2013-01-22 09:25:05','2013-01-22 09:44:11'),
	(584,'Tango 7 Women\'s 29er','cannondale','mountain','Hardtail 29er',600.00,'White','','',0,'C14_29F_TNGO29_7_WHT_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(517,'Mariner','dahon','folding','Folding',675.00,'Silver/blue','','',0,'Dahon-Mariner-D7-folding-bike.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-29 08:06:44'),
	(518,'Boardwalk','dahon','folding','Folding',350.00,'Black','','',0,'2010__unfold_boardwalkd7.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-29 08:06:04'),
	(519,'Eco C7','dahon','folding','Folding',475.00,'Red','','',0,'2011_ecoc7_unfold.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-29 08:08:36'),
	(520,'Mu P8','dahon','folding','Folding',900.00,'Black','','',0,'2010__unfold_mup8.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-29 08:07:55'),
	(521,'Vitesee D3','dahon','folding','Folding',775.00,'Flat Black','','',0,'2010__unfold_vitessed7hg.jpg','','',0,1,'2013-01-22 09:25:05','2013-01-29 08:07:22'),
	(578,'No Coast','coast','single','Fixed Gear/Single Speed',250.00,'Black','51cm and 56cm','flip flop hub/3 piece crank',0,'Hybrid_final_5.jpg','','',0,1,'2013-08-13 18:03:59','2013-08-21 13:33:46'),
	(580,'Dutchie','coast','urban','Hybrid ',350.00,'Lime Green','15, 18','Shimano',0,'Hybrid_final_7.jpg','','',0,1,'2013-08-13 18:05:01','2013-11-27 10:22:53'),
	(581,'Dutchie','coast','urban','Hybrid',350.00,'Beige','15, 18','Shimano',0,'Hybrid_final_8.jpg','','',0,1,'2013-08-13 18:05:44','2013-11-27 10:24:44'),
	(582,'Jasmine','coast','urban','Hybrid',389.00,'White','14.5, 16','Shimano',0,'Hybrid_final_9.jpg','','',0,1,'2013-08-13 18:06:04','2013-12-02 09:43:24'),
	(595,'City Glide Men\'s SS','norco','urban','Hybrid',495.00,'Black','','',0,'cityglidess.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(573,'Malahat Women\'s','norco','urban','Hybrid',440.00,'Mint','','Shimano',0,'malahatw.jpg','norco.com','',0,1,'2013-01-27 13:28:18','2013-11-27 10:31:49'),
	(574,'Rollercoaster','coast','cruiser','Cruiser',150.00,'Blue','','',0,'Hybrid_final_1.jpg','','',0,1,'2013-08-13 18:01:37','2013-11-27 10:26:55'),
	(575,'Rollercoaster','coast','cruiser','Cruiser',150.00,'Orange','','',0,'Hybrid_final_2.jpg','','',0,1,'2013-08-13 18:02:14','2013-11-27 10:26:48'),
	(576,'Rollercoaster','coast','cruiser','Cruiser',150.00,'Violet','','',0,'Hybrid_final_3.jpg','','',0,1,'2013-08-13 18:02:47','2013-11-27 10:28:04'),
	(594,'Bad Boy Commuter','cannondale','urban','Hybrid',820.00,'BBQ','','',0,'C14_700M_BADBOY_CM_BBQ_1.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(587,'Threshold Alloy 3','norco','cyclocross','Cyclocross',860.00,'Black / Blue','','',0,'threshhold_a3.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(605,'Boy\'s Trail 20\"','cannondale','kids','Kids',390.00,'Brushed','','',0,'c_13_MTRAIL20_bsd_2.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(607,'Boy\'s Street 24\"','cannondale','kids','Kids',520.00,'Black','','',0,'c_13_MSTREET24_bbq_3.png','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(608,'Scorpion Alloy 16\"','norco','kids','Kids',257.00,'Orange','','',0,'scorpionorange.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(609,'Boy\'s Turbo Aluminum','norco','kids','Kids',289.00,'Black','','',0,'turboboysal.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(610,'Boy\'s Jasmine Aluminum','norco','kids','Kids',289.00,'Teal','','',0,'jasmineteal.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(611,'Glide','norco','kids','Kids',365.00,'Red','','',0,'glide.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(612,'Cutler 7','origin8','single','Singlespeed',375.00,'','','',0,'cutler7.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(613,'Cutler CB','origin8','single','Singlespeed',325.00,'','','',0,'cutler_cb.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(614,'Flower Power 16\"','sun','kids','Kids',149.00,'Pink','','',0,'flowerpower16.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(615,'Lil Kitten 12\"','sun','kids','Kids',100.00,'Pink','','',0,'littlekitten.jpg','','',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `bikes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
