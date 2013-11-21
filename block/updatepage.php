<?php
/* PHP part of the page */


// update page/subpage functional
if(isset($_POST['addBtn'])){
    if(isset($_POST['page']) and isset($_POST['subPage'])){
        showMsg('Одновременно можно создать только одну страницу', '/admin/');
    }
    if(isset($_POST['page']) and !isset($_POST['subPage'])){
        /* data for create page functional */
        if('' === $_POST['pageName']){
            showMsg('Вы не заполнили обязательные поля', '/admin/');
        }
        $page = array(
                        'name' => $_POST['pageName'],
                        'link' => strtolower('/'.cyrillic2latin($_POST['pageName']).'/'),
                        'content' => $_POST['pageContent']
                    );
        $sql_check = "SELECT count(*) FROM tbl_pages WHERE name=? OR link=?";
        $sql_insert = "INSERT INTO tbl_pages(link,name,page_content) VALUES ('$page[link]','$page[name]','$page[content]')";
    }
    elseif(!isset($_POST['page']) and isset($_POST['subPage'])){
        /* data for create subpage functional */
        if('' === $_POST['parrentId'] or '' === $_POST['subPageName']){
            showMsg('Вы не заполнили обязательные поля', '/admin/');
        }
        $page = array(
                        'parrentId' => (int)$_POST['parrentId'],
                        'name' => $_POST['subPageName'],
                        'link' => strtolower(cyrillic2latin($_POST['subPageName']).'/'),
                        'content' => $_POST['subPageContent']
                    );
        $sql_check = "SELECT count(*) FROM tbl_sub_pages WHERE (name=? OR link=?) AND page_id='$page[parrentId]'";
        $sql_insert = "INSERT INTO tbl_sub_pages(link,name,page_content,page_id) VALUES ('$page[link]','$page[name]','$page[content]', '$page[parrentId]')";
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
            $query = $db->prepare($sql_insert);
            $query->execute();
            echo "<h2>Страница успешно добавлена</h2>";
        }
        catch(PDOException $e){
            showMsg('Не удалось добавить страницу. Попробуйте позже', '/admin/');
        }
    }
    else{
        showMsg('Невозможно создать страницу с таким именем', '/admin/');
    }
}
?>

<!-- html part of the page-->


<script type="text/javascript">
    
</script>


<form name="update" method="post" action="">
    <label>
        <input type="checkbox" name="page" id="updP" value="1" onChange="showDiv('updP', 'updPage', 'updSP')">Редактировать страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="updSP" value="2" onChange="showDiv('updSP', 'updSubPage', 'updP')">Редактировать подстраницу
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
            <label>
                <abbr title='Содержимое страницы'>(?)</abbr>
                <span>Содержимое страницы</span>
                <textarea class='ckeditor' name="pageContent" rows="10" id='pContent'></textarea>
            </label>
        </div>
    </div>
    <!-- dib for update subpage -->
    <div class="hide" id="updSubPage">
        <label>
            <abbr title="Выберите подстраницу которую хотите отредактировать. Шаблон названия страницы: *родительская страница* --> *подстраница*">(?)</abbr>
            <span><b class="req">*</b>Выберите подстраницу</span>
            <select name="" id="updSubpageId">
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
        <input class="button" type="reset" value="Очистить поля">
    </div>
</form>