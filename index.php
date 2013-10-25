<?php
require_once './block/db.php';
require_once './block/phpfunlib.php';
require_once './block/header.php';

require_once "./block/leftblock.php";
require_once "./block/topblock.php";

// if(empty($_GET) or ""===$_GET['page']):
// 	require_once './pages/main.php';
// endif;
?>

<div class="container">
	<?php
	$link = getPageNameAndLink($db)['link'];
	echo getPageContent($db, $link);
	echo "<pre>";
	print_r($GLOBALS);
	echo "</pre>";
	$_SERVER;
	/*echo "<pre>";
	print_r($_SERVER);
	echo "</pre>";*/
	?>
</div>

<?php
require_once "./block/bottomblock.php";
require_once './block/footer.php';
?>