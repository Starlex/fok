<?php
/* PHP code*/

// create page/subpage functional
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

<!-- html code -->

<form name="update" method="post" action="">
    <label>
        <input type="checkbox" name="page" id="updP" value="1" onClick="showDiv('updP', 'updPage', 'updP')">Редактировать страницу
    </label>
    <label>
        <input type="checkbox" name="subPage" id="updP" value="2" onClick="showDiv('updP', 'updSubPage', 'updP')">Редактировать подстраницу
    </label>
    <div class="hide" id="updPage">
        <label>
            <abbr title="Имя создаваемой страницы">(?)</abbr>
            <span><b class="req">*</b> Имя страницы</span>
            <input name="pageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой страницы'>(?)</abbr>
            <span>Содержимое страницы</span>
            <textarea name="pageContent" rows="10"></textarea>
        </label>
    </div>
    <div class="hide" id="updSubPage">
        <label>
            <abbr title="Выберите родительскую страницу">(?)</abbr>
            <span><b class="req">*</b> Имя страницы</span>
            <select name="parrentId">
                <?php getPagesList($db); ?>
            </select>
        </label>
        <label>
            <abbr title="Имя создаваемой подстраницы">(?)</abbr>
            <span><b class="req">*</b> Имя подстраницы</span>
            <input name="subPageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой подстраницы'>(?)</abbr>
            <span>Содержимое подстраницы</span>
            <textarea name="subPageContent" rows="10"></textarea>
        </label>
    </div>
    <input class="button" name="updBtn" type="submit" id="sendForm" value="Создать" disabled>
    <input class="button" type="reset" value="Очистить поля">
</form>