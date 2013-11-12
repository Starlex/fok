<?php
try{
	$db = new PDO('mysql:host=localhost;dbname=fok', 'root', 'password', array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	die("Подключение не удалось: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
}
?>