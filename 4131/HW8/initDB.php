<?php
include "connection.php";
return;

$create = $db->prepare("CREATE TABLE User (ID number(8) AUTO_INCREMENT,Name varchar(64), Email varchar(64))
PRIMARY KEY (ID)");
$create->execute();

$create2 = $db->prepare("CREATE TABLE Votes (VID number(8),Category varchar(64),Num_Votes int(8))
PRIMARY KEY (VID) Auto Increment");
$create2->execute();

$categories = ["Indian","Chinese","Mexican","Italian","Thai"];

$id = 0;
foreach($categories as $key){
    $insert = $db->prepare("INSERT INTO Votes (? ? 0)");
    $insert->bindParam(1,$id);
    $insert->bindParam(2,$key);
    $insert->execute();
    $id++;
}

$select = $db->prepare("SELECT * from User");
//$select->execute();

$select2 = $db->prepare("SELECT Count(*) from Votes");
//$select2->execute();


$drop = $db->prepare("DROP TABLE test");
//$drop->execute();
?>