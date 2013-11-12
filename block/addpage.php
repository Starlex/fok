<?php
// create (sub)page functional
if(isset($_POST['addBtn'])){
    if(isset($_POST['page']) and isset($_POST['subpage'])){
        die("<b class='req'><p>Одновременно можно создать только одну страницу</b></p><a href='/admin/'>Назад</a>");
    }
    if('' !== $_POST['page'] and !isset($_POST['subpage'])){
        if('' === $_POST['pageName']){
            die("<b class='req'><p>Вы не заполнили обязательные поля</b></p><a href='/admin/'>Назад</a>");
        }
        $page = array(
                        'name' => $_POST['pageName'],
                        'link' => strtolower('/'.cyrillic2latin($_POST['pageName']).'/'),
                        'content' => $_POST['pageContent']
                    );
        try{
            $result = $db->prepare("SELECT count(*) FROM tbl_pages WHERE name=? OR link=?");
            $result->execute(array($page['name'], $page['link']));
            $num = $result->fetchColumn();
        }
        catch(PDOException $e){
            die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
        }
        if($num > 0){
            die("<b class='req'><p>Невозможно создать страницу с таким именем</b></p><a href='/admin/'>Назад</a>");
        }
        
    }
}
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
            <abbr title="Имя создаваемой страницы">(?)</abbr>
            <span><b class="req">*</b> Имя страницы</span>
            <input name="pageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой страницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</abbr>
            <span>Содержимое страницы</span>
            <textarea name="pageContent" rows="10"></textarea>
        </label>
    </div>
    <div class="hide" id="addSubPage">
        <label>
            <abbr title="Выберите родительскую страницу">(?)</abbr>
            <span><b class="req">*</b> Имя страницы</span>
            <select name="parrentPageName">
                <?php getPagesList($db); ?>
            </select>
        </label>
        <label>
            <abbr title="Имя создаваемой подстраницы">(?)</abbr>
            <span><b class="req">*</b> Имя подстраницы</span>
            <input name="subPageName" type="text" value="">
        </label>
        <label>
            <abbr title='Содержимое создаваемой подстраницы. Можно оставить пустым и заполнить потом с помощью пункта меню "Редактировать"'>(?)</abbr>
            <span>Содержимое подстраницы</span>
            <textarea name="subPageContent" rows="10"></textarea>
        </label>
    </div>
    <input class="button" name="addBtn" type="submit" id="sendForm" value="Создать" disabled>
    <input class="button" type="reset" value="Очистить поля">
</form>