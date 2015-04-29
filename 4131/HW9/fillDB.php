<?php 
include "database.php";

/*
$drop = $db->prepare("DELETE FROM tbl_restaurants WHERE 1=1");
$drop->execute();
*/

$json = file_get_contents("new_restaurants.json");
$data = json_decode($json)->restaurants;
$id = 1;
foreach($data as $entry){
    $hours = mergeHours($entry->hours);
    $insert = $db->prepare("INSERT INTO tbl_restaurants VALUES (?,?,?,?,?,?,?,?)");
    $insert->bindParam(1,$id);
    $insert->bindParam(2,$entry->name);
    $insert->bindParam(3,$entry->type);
    $insert->bindParam(4,$entry->phone);
    $insert->bindParam(5,$entry->rating);
    $insert->bindParam(6,$entry->url);
    $insert->bindParam(7,$entry->address);
    $insert->bindParam(8,$hours);
    $insert->execute();
    $id++;
    if($insert->rowCount() < 1){
        print_r($db->errorInfo());
        echo "Not inserted\n";
    }
}

function mergeHours($hours){
    $buffer = "";
    foreach($hours as $day){
        $buffer .= $day->day." : ".$day->time."<br>"; 
    }
    return $buffer;
}





?>
