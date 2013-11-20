<?php
try{
	$db = new PDO('mysql:host=localhost;dbname=fok', 'root', 'password', array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	echo 'database error';
}

try{
	$query = $db->prepare("SELECT * FROM tbl_pages WHERE page_id=?");
	$query->execute(array($_POST['page_id']));
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetchAll();
	echo json_encode($row[0]);
}
catch(PDOException $e){
	//echo 'database error';
	echo $e->getFile()."<br>".$e->getLine()."<br>".$e->getMessage();
}

?>