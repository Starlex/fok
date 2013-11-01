<?php
require_once './block/db.php';
require_once './block/phpfunlib.php';
require_once './block/header.php';

require_once "./block/leftblock.php";
require_once "./block/topblock.php";

?>

<div class="container">
	<?php
	if(empty($_GET) or isset($_GET['page'])):
		require_once '/pages/main.php';
	endif;
	/*echo "<pre>";
	print_r($GLOBALS);
	echo "</pre>";
	$_SERVER;*/
	?>
</div>

<?php
require_once "./block/bottomblock.php";
require_once './block/footer.php';
?>