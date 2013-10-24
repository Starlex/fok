<?php
require_once './block/db.php';
require_once './block/phpfunlib.php';
require_once './block/header.php';

drawMenu($db);

if(empty($_GET) or ""===$_GET['page']){
	require_once './pages/main.php';
}

require_once './block/footer.php';
?>