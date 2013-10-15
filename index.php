<?php
require_once "./block/header.php";
if(empty($_GET) or ""===$_GET['page']){
	require_once "./pages/main.php";
}
require_once "./block/footer.php";
?>