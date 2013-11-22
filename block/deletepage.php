<?php
/* PHP part of the page */


// delete page/subpage functional
if(isset($_POST['sendBtn'])){
    if(isset($_POST['page']) and isset($_POST['subPage'])){
        showMsg('Одновременно можно удалить только одну страницу', '/admin-delete/');
    }
    if(isset($_POST['page']) and !isset($_POST['subPage'])){
        /* delete page functional */
        if('' === $_POST['pageId']){
            showMsg('Вы не выбрали страницу для удаления', '/admin-delete/');
        }
        $pageId = (int)$_POST['pageId'];
        try{
        	$query = $db->prepare("SELECT count(*) FROM tbl_sub_pages WHERE page_id=?");
        	$query->execute(array($pageId));
        	$num = $query->fetchColumn();
        	if((int)$num > 0){
        		showMsg('Удаление этой страницы невозможно, т.к. у нее имеются подстраницы', '/admin-delete/');
        	}
        }
        catch(PDOException $e){
        	header('Location:/500');
        }
        $sql_check = "SELECT count(*) FROM tbl_pages WHERE page_id=?";
        $sql_delete = "DELETE FROM tbl_pages WHERE page_id=? ";
    }
    elseif(!isset($_POST['page']) and isset($_POST['subPage'])){
        /* delete subpage functional */
        if('' === $_POST['subpageId']){
            showMsg('Вы не выбрали подстраницу для удаления', '/admin-delete/');
        }
        $pageId = (int)$_POST['subpageId'];
        $sql_check = "SELECT count(*) FROM tbl_sub_pages WHERE sub_page_id=?";
        $sql_delete = "DELETE FROM tbl_sub_pages WHERE sub_page_id=?";
    }

    try{
        $query = $db->prepare($sql_check);
        $query->execute(array($pageId));
        $num = $query->fetchColumn();
    }
    catch(PDOException $e){
        header('Location:/500');
    }
    if((int)$num > 0){
        try{
            $query = $db->prepare($sql_delete);
            $query->execute(array($pageId));
            echo "<h2>Страница успешно удалена</h2>";
        }
        catch(PDOException $e){
            showMsg('Не удалось удалить страницу. Попробуйте позже', '/admin-delete/');
        }
    }
    else{
        showMsg('Такой страницы не существует', '/admin-delete/');
    }
}
?>

<!-- html part of the page-->

<form name="delete" method="post" action="">
    <label>
        <input type="checkbox" name="page" id="delP" value="1" onChange="showDiv('delP', 'delPage', 'delSP')">Удалить страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="delSP" value="2" onChange="showDiv('delSP', 'delSubPage', 'delP')">Удалить подстраницу
    </label>
    <!-- div for delete page -->
    <div class="hide" id="delPage">
        <label>
            <abbr title="Выберите страницу для удаления">(?)</abbr>
            <span><b class="req">*</b>Выберите страницу</span>
            <select name="pageId" id="delPageId">
                <?php getPagesList($db) ?>
            </select>
        </label>
    </div>
    <!-- dib for delete subpage -->
    <div class="hide" id="delSubPage">
        <label>
            <abbr title="Выберите подстраницу которую хотите удалить. Шаблон названия страницы: *родительская страница* --> *подстраница*">(?)</abbr>
            <span><b class="req">*</b>Выберите подстраницу</span>
            <select name="subpageId" id="delSubpageId">
                <?php getSubpagesList($db) ?>
            </select>
        </label>
    </div>
    <div class='hide' id="btn_div">
        <input class="button" name="sendBtn" type="submit" value="Удалить">
    </div>
</form>