<?php
try{
    $pages = $db->prepare('SELECT page_id, link, name FROM tbl_pages WHERE admin = ?');
    $pages->execute(array(0));
    $pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_pages = $pages->fetchAll();
    
    $sub_pages = $db->prepare('SELECT sub_page_id, link, name, page_id FROM tbl_sub_pages WHERE admin = ?');
    $sub_pages->execute(array(0));
    $sub_pages->setFetchMode(PDO::FETCH_ASSOC);
    $row_sub_pages = $sub_pages->fetchAll();
}
catch(PDOException $e){
    header('Location:/500');
}

require_once "/block/leftblock.php";
require_once "/block/topblock.php";

$pageData = array(
					'link' => getPageNameAndLink($db)['link'],
					'tbl_name' => getPageNameAndLink($db)['tbl_name']
				);

$query =$db->prepare("SELECT COUNT(*) FROM $pageData[tbl_name] WHERE link=?");
$query->execute(array($pageData['link']));
echo $num = $query->fetchColumn();
if(0 === (int) $num){
    header('Location:/404');
}

?>

<div class="container">

	<?php
    echo '<p><a href="/admin/">Админка</a></p>';
	echo getPageContent($db, $pageData);
	?>

</div>

<?php
require_once "/block/bottomblock.php";
?>