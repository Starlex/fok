<?php
require_once '/block/db.php';
require_once '/block/phpfunlib.php';
require_once '/block/header.php';

if(empty($_GET) or isset($_GET['page'])):
	if(isset($_GET['page']) and '/admin/' === $_GET['page']):
		require_once '/pages/admin.php';
	else:
		require_once '/pages/main.php';
	endif;
endif;

require_once '/block/footer.php';
?>