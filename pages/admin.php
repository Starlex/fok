<?php
// list of elements for menu
try{
    $pages = $db->prepare('SELECT page_id, link, name FROM tbl_pages WHERE admin = ?');
    $pages->execute(array(1));
    $pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_pages = $pages->fetchAll();

    $sub_pages = $db->prepare('SELECT sub_page_id, link, name, page_id FROM tbl_sub_pages WHERE admin = ?');
    $sub_pages->execute(array(1));
    $sub_pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_sub_pages = $sub_pages->fetchAll();
}
catch(PDOException $e){
    header('Location:/500');
}

require_once "/block/leftblock.php";
require_once "/block/topblock.php";
?>

<div class="container">
	<?php
    if('/admin/' === $_GET['page'] and !isset($_GET['var1'])){
        require_once '/block/addpage.php';
    }
    elseif('/admin-update/' === $_GET['page']){
        require_once '/block/updatepage.php';
    }
?>
</div>

<?php
require_once "/block/bottomblock.php";
?>