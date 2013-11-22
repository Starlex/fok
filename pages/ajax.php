<?php
try{
	$db = new PDO('mysql:host=localhost;dbname=fok', 'root', 'password', array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	echo '<h1>Internal server error</h1>';
	exit;
}
if(isset($_POST['page_id'])){
	try{
		$query = $db->prepare("SELECT name, page_content FROM tbl_pages WHERE page_id=?");
		$query->execute(array($_POST['page_id']));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		echo json_encode($row);
	}
	catch(PDOException $e){
		echo '<h1>Internal server error</h1>';
		exit;
	}	
}
elseif(isset($_POST['subpage_id'])){
	try{
		$query = $db->prepare("SELECT name, page_content, page_id FROM tbl_sub_pages WHERE sub_page_id=?");
		$query->execute(array($_POST['subpage_id']));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		echo json_encode($row);
	}
	catch(PDOException $e){
		echo '<h1>Internal server error</h1>';
		exit;
	}
}



?>