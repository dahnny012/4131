<?php
include "database.php";
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$drop = $db->prepare("DROP TABLE IF EXISTS tbl_restaurants");
$drop->execute();

$create = $db->prepare("CREATE TABLE IF NOT EXISTS tbl_restaurants (
 res_id int(11) NOT NULL auto_increment,
 res_name varchar(255) NOT NULL,
 res_type varchar(20) NOT NULL,
 res_phone varchar(12) NOT NULL,
 res_ratings float NOT NULL,
 res_url varchar(255) NOT NULL,
 res_address varchar(255) NOT NULL,
 res_hours varchar(255) NOT NULL,
 PRIMARY KEY (res_id),
 UNIQUE KEY res_name (res_name)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$create->execute();
?>
