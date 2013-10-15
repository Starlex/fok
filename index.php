<?php
require_once "./block/header.php";
if(""===$_GET['page']){
	require_once "./pages/main.php";
}
$var = "asdf";
print_r($_GET);
echo "<pre>";
print_r($GLOBALS);
require_once "./block/footer.php";
?>