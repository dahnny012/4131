<?php
ini_set('display_errors','1'); error_reporting(E_ALL);

$config['db'] = array(
	'host' => getenv('IP'),
	'username' => getenv('C9_USER'),
	'password' => "",
	'dbname' => "c9"
	);


$db = new PDO('mysql:host=' . 
$config['db']['host']. ';dbname=' .
$config['db']['dbname'] , 
$config['db']['username'] , 
$config['db']['password']);


/*
$db = new PDO('mysql:host=egon.cs.umn.edu;port=3307;dbname=C4131S15#', 'C4131S15#', "P");
*/

?>


