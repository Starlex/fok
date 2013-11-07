<?php
try{
	$db->beginTransaction();
    $pages = $db->query('SELECT page_id, link, name FROM tbl_pages WHERE admin = 1');
    $sub_pages = $db->query('SELECT sub_page_id, link, name, page_id FROM tbl_sub_pages WHERE admin = 1');
    $db->commit();
    $pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_pages = $pages->fetchAll();
    $sub_pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_sub_pages = $sub_pages->fetchAll();
}
catch(PDOException $e){
    $db->rollback();
    die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
}

require_once "/block/leftblock.php";
require_once "/block/topblock.php";
?>

<div class="container">

	<?php
    if('/admin/' === $_GET['page']):
        echo 'someshit';
    endif;
	?>

</div>

<?php
require_once "/block/bottomblock.php";
?>