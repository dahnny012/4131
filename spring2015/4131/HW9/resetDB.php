<?php
include "database.php";
$drop = $db->prepare("DELETE FROM tbl_restaurants WHERE 1=1");
$drop->execute();

include "fillDB.php";





?>
