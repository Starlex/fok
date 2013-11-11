<?php
require_once '/block/db.php';
require_once '/block/phpfunlib.php';
require_once '/block/header.php';

if(isset($_GET['page'])){
	if('/admin/' === $_GET['page']){
		session_start();
		require_once '/block/auth.php';
		require_once '/pages/admin.php';
	}
	elseif('/login/' === $_GET['page'] or '/logout/' === $_GET['page']){
		require_once '/pages/loginout.php';
	}
	else{
		require_once '/pages/main.php';
	}
}
if(empty($_GET)){
	require_once '/pages/main.php';
}

require_once '/block/footer.php';
?>