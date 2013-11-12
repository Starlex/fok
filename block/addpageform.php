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
            <select name="pageName">
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
    <input class="button" type="submit" id="sendForm" value="Создать" disabled>
    <input class="button" type="reset" value="Очистить поля">
</form>