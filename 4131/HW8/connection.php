<?php
ini_set('display_errors','1'); error_reporting(E_ALL);
/*
$config['db'] = array(
	'host' => "egon.cs.umn.edu",
	'username' => "C4131S15U50",
	'password' => 5833,
	'dbname' => "C4131S15U50"
	);
*/
/*
$db = new PDO('mysql:host=' . 
$config['db']['host']. ';dbname=' .
$config['db']['dbname'] , 
$config['db']['username'] , 
$config['db']['password']);
*/


$db = new PDO('mysql:host=egon.cs.umn.edu;port=3307;dbname=C4131S15#', 'C4131S15#', "P");


?>


