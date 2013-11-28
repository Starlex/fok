<?php
/* PHP part of the page */


// update page/subpage functional
if(isset($_POST['sendBtn'])){
    if(isset($_POST['page']) and isset($_POST['subPage'])){
        showMsg('Одновременно можно отредактировать только одну страницу', '/admin-update/');
    }
    if(isset($_POST['page']) and !isset($_POST['subPage'])){
        /* update page functional */
        if('' === $_POST['pageName'] or '' === $_POST['pageId']){
            showMsg('Вы не заполнили обязательные поля', '/admin-update/');
        }
        $page = array(
                        'pageId' => (int)$_POST['pageId'],
                        'name' => $_POST['pageName'],
                        'link' => strtolower('/'.cyrillic2latin($_POST['pageName']).'/'),
                        'content' => $_POST['pageContent']
                    );
        $sql_check = "SELECT count(*) FROM tbl_pages WHERE (name=? OR link=?) AND page_id != $page[pageId]";
        $sql_update = "UPDATE tbl_pages SET link='$page[link]', name='$page[name]', page_content='$page[content]' WHERE page_id='$page[pageId]' ";
    }
    elseif(!isset($_POST['page']) and isset($_POST['subPage'])){
        /* update subpage functional */
        if('' === $_POST['subpageId'] or '' === $_POST['subPageName']){
            showMsg('Вы не заполнили обязательные поля', '/admin-update/');
        }
        $page = array(
                        'parrentId' => (int)$_POST['parrent'],
                        'pageId' => (int)$_POST['subpageId'],
                        'name' => $_POST['subPageName'],
                        'link' => strtolower(cyrillic2latin($_POST['subPageName']).'/'),
                        'content' => $_POST['subPageContent']
                    );

        $sql_check = "SELECT count(*) FROM tbl_sub_pages WHERE ((name=? OR link=?) AND page_id='$page[parrentId]') AND sub_page_id != $page[pageId]";
        $sql_update = "UPDATE tbl_sub_pages SET link='$page[link]', name='$page[name]', page_content='$page[content]' WHERE sub_page_id=? ";
    }

    try{
        $query = $db->prepare($sql_check);
        $query->execute(array($page['name'], $page['link']));
        $num = $query->fetchColumn();
    }
    catch(PDOException $e){
        header('Location:/500');
    }
    if(0 === (int)$num){
        try{
            $query = $db->prepare($sql_update);
            $query->execute(array($page['pageId']));
            echo "<h2>Страница успешно отредактирована</h2>";
        }
        catch(PDOException $e){
            showMsg('Не удалось отредактировать страницу. Попробуйте позже', '/admin-update/');
        }
    }
    else{
        showMsg('Страница с таким именем уже существует', '/admin-update/');
    }
}
?>

<!-- html part of the page-->

<form name="update" method="post" action="/admin-update/" id="updForm">
    <label>
        <input type="checkbox" name="page" id="updP" value="1" onChange="showDiv('#updP','#updPage','#updSP','updForm')">Редактировать страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="updSP" value="2" onChange="showDiv('#updSP','#updSubPage','#updP')">Редактировать подстраницу
    </label>
    <!-- div for upgate page -->
    <div class="hide" id="updPage">
        <label>
            <abbr title="Выберите страницу для редактирования">(?)</abbr>
            <span><b class="req">*</b>Выберите страницу</span>
            <select name="pageId" id="updPageId">
                <?php getPagesList($db) ?>
            </select>
        </label>
        <div class="hide" id="pagedata">
            <label>
                <abbr title="Если вы не хотите менять имя страницы, то оставьте его неизменным">(?)</abbr>
                <span><b class="req">*</b>Имя страницы</span>
                <input name="pageName" type="text" id="pName">
            </label>
            <label>
                <abbr title='Содержимое страницы'>(?)</abbr>
                <span>Содержимое страницы</span>
                <textarea class='ckeditor' name="pageContent" rows="10" id='pContent'></textarea>
            </label>
        </div>
    </div>
    <!-- dib for update subpage -->
    <div class="hide" id="updSubPage">
        <input type="hidden" name="parrent" id="parrentId">
        <label>
            <abbr title="Выберите подстраницу которую хотите отредактировать. Шаблон названия страницы: *родительская страница* --> *подстраница*">(?)</abbr>
            <span><b class="req">*</b>Выберите подстраницу</span>
            <select name="subpageId" id="updSubpageId">
                <?php getSubpagesList($db) ?>
            </select>
        </label>
        <div class="hide" id="subpagedata">
            <label>
                <abbr title="Если вы не хотите менять имя подстраницы, то оставьте его неизменным">(?)</abbr>
                <span><b class="req">*</b> Имя подстраницы</span>
                <input name="subPageName" type="text" id="spName">
            </label>
            <label>
                <abbr title='Содержимое подстраницы'>(?)</abbr>
                <span>Содержимое подстраницы</span>
                <textarea class='ckeditor' name="subPageContent" rows="10" id="spContent"></textarea>
            </label>
        </div>
    </div>
    <div class='hide' id="btn_div">
        <input class="button" name="sendBtn" type="submit" value="Сохранить">
    </div>
</form>