<?php
/* PHP code*/

// create page/subpage functional
if(isset($_POST['sendBtn'])){
    if(isset($_POST['page']) and isset($_POST['subPage'])){
        showMsg('Одновременно можно создать только одну страницу', '/admin/');
    }
    if(isset($_POST['page']) and !isset($_POST['subPage'])){
        /* create page functional */
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
        /* create subpage functional */
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

<!-- html code -->

<form name="add" method="post" action="">
    <label>
        <input type="checkbox" name="page" id="addP" value="1" onClick="showDiv('addP', 'addPage', 'addSP')">Добавить страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="addSP" value="2" onClick="showDiv('addSP', 'addSubPage', 'addP')">Добавить подстраницу
    </label>
    <div class="hide" id="addPage">
        <label>
            <abbr title="Имя создаваемой страницы">(?)</abbr>
            <span><b class="req">*</b>Имя страницы</span>
            <input name="pageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой страницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</abbr>
            <span>Содержимое страницы</span>
            <textarea class='ckeditor' name="pageContent" rows="10"></textarea>
        </label>
    </div>
    <div class="hide" id="addSubPage">
        <label>
            <abbr title="Выберите родительскую страницу">(?)</abbr>
            <span><b class="req">*</b>Имя страницы</span>
            <select name="parrentId">
                <?php getPagesList($db); ?>
            </select>
        </label>
        <label>
            <abbr title="Имя создаваемой подстраницы">(?)</abbr>
            <span><b class="req">*</b>Имя подстраницы</span>
            <input name="subPageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой подстраницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</abbr>
            <span>Содержимое подстраницы</span>
            <textarea class='ckeditor' name="subPageContent" rows="10"></textarea>
        </label>
    </div>
    <div class="hide" id="btn_div">
        <input class="button" name="sendBtn" type="submit" value="Создать">
        <input class="button" type="reset" value="Очистить поля">
    </div>
</form>