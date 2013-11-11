<?php
// list of elements for menu
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

// list of elements for creating sub pages
// code will be here

require_once "/block/leftblock.php";
require_once "/block/topblock.php";
?>

<div class="container">
	<?php
    if('/admin/' === $_GET['page']):
        // echo 'someshit';
	?>

<form name="add" method="post" action="">
    <label>
        <input type="checkbox" name="page" id="addP" value="1" onClick="showDiv('addP', 'addPage', 'addSP')">Добавить страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="addSP" value="2" onClick="showDiv('addSP', 'addSubPage', 'addP')">Добавить подстраницу
    </label>
    <div class="hide" id="addPage">
        <label>
            <acronym title="Имя создаваемой страницы">(?)</acronym>
            <span>Имя страницы <b class="req">*</b></span>
            <input name="pageName" type="text" value="">
        </label>
        <label>
            <acronym title='Содержимое создаваемой страницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</acronym>
            <span>Содержимое страницы</span>
            <textarea name="pageContent" rows="10"></textarea>
        </label>
    </div>
    <div class="hide" id="addSubPage">
        <label>
            <acronym title="Выберите родительскую страницу">(?)</acronym>
            <span>Имя страницы <b class="req">*</b></span>
            <select name="pageName">
                <option value="" selected> - - - - - - - Не выбрано - - - - - - - </option>
            </select>
        </label>
        <label>
            <acronym title="Имя создаваемой подстраницы">(?)</acronym>
            <span>Имя подстраницы <b class="req">*</b></span>
            <input name="subPageName" type="text" value="">
        </label>
        <label>
            <acronym title='Содержимое создаваемой подстраницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</acronym>
            <span>Содержимое подстраницы</span>
            <textarea name="subPageContent" rows="10"></textarea>
        </label>
    </div>
</form>
<?php
endif;
?>
</div>

<?php
require_once "/block/bottomblock.php";
?>