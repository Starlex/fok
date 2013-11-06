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
		if('admin' === $_GET['page']):
			require_once '/pages/admin.php';
		else:
			require_once '/pages/main.php';
		endif;
	endif;
	?>
</div>

<?php
require_once "./block/bottomblock.php";
require_once './block/footer.php';
?>