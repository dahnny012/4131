<?php
return;
include "connection.php";
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$drop = $db->prepare("DROP TABLE USER");
$drop2 = $db->prepare("DROP TABLE VOTES");
$drop->execute();
$drop2->execute();

$create = $db->prepare("CREATE TABLE USER (Email varchar(64) PRIMARY KEY,Name varchar(64))");
$create->execute();

$create2 = $db->prepare("CREATE TABLE VOTES (Category varchar(64) PRIMARY KEY,Num_Votes int(8))");
$create2->execute();

$categories = ["Indian","Chinese","Mexican","Italian","Thai"];

foreach($categories as $key){
    $insert = $db->prepare("INSERT INTO VOTES VALUES (?,0)");
    $insert->bindParam(1,$key);
    $insert->execute();
}

$select = $db->prepare("SELECT * from User");
$select->execute();

$select2 = $db->prepare("SELECT Count(*) from Votes");
$select2->execute();


$drop = $db->prepare("DROP TABLE test");
$drop->execute();
?>
