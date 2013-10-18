<?php
try{
	$db = new PDO('mysql:host=localhost;dbname=fok', 'root', 'password', array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	die("Подключение не удалось: ".$e->getMessage());
}
?>