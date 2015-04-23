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






?>


