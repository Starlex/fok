<?php
require_once 'block/db.php';
require_once 'block/phpfunlib.php';
require_once 'block/header.php';

if(isset($_GET['page'])){
	if(0 === strpos($_GET['page'], '/admin')){
		session_start();
		require_once 'block/auth.php';
		require_once 'pages/admin.php';
	}
	elseif('/login/' === $_GET['page'] or '/logout/' === $_GET['page']){
		require_once 'pages/loginout.php';
	}
	else{
		require_once 'pages/main.php';
	}
}
elseif(empty($_GET)){
	require_once 'pages/main.php';
}

require_once 'block/footer.php';
?>