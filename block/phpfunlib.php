<?php
/* Change cyrillic symbols to latin */
function cyrillic2latin($str){
	$converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'yo',  'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',    'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'Yo',  'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		'№' => '',
    );
    return strtr($string, $converter);
}

/* Draw menu (vertical or horizontal) */
function drawMenu($db, $vertical = true){
    $selected_page = '/main/';
    if(isset($_GET['page'])):
        $selected_page = $_GET['page'];
    endif;
    if (isset($_GET['var1'])):
        $selected_sub_page = $selected_page.$_GET['var1'];
    endif;
    $style = 'v-menu';
    if(!$vertical):
        $style = 'h-menu';
    endif;
    try{
        $db->beginTransaction();
        $pages = $db->query('SELECT * FROM tbl_pages');
        $sub_pages = $db->query('SELECT * FROM tbl_sub_pages');
        $db->commit();
        $pages->setFetchMode(PDO::FETCH_ASSOC);
        $row_pages = $pages->fetchAll();
        $sub_pages->setFetchMode(PDO::FETCH_ASSOC);
        $row_sub_pages = $sub_pages->fetchAll();

        echo "<div class='$style'>",
        "\n\t\t", "<ul>";
                foreach ($row_pages as $page):
                    $selected_style = "";
                    if($page['link'] === $selected_page):
                        $selected_style = " class='selected'";
                    endif;
                    echo "\n\t\t\t", "<li$selected_style><a href='$page[link]'>$page[name]</a>",
                            "\n\t\t\t\t", "<ul>";
                        foreach ($row_sub_pages as $sub_page):
                            $sub_page_link = $page['link'].$sub_page['link'];
                            if($page['page_id'] === $sub_page['page_id']):
                                echo "\n\t\t\t\t\t", "<li><a href='$sub_page_link'>$sub_page[name]</a>";
                            endif;
                        endforeach;
                    echo "\n\t\t\t\t", "</ul>",
                    "\n\t\t\t", "</li>";
                endforeach;
            echo "\n\t\t", "</ul>",
            "\n\t", "</div>";
    }
    catch(PDOException $e){
        $db->rollback();
        die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
    }
}

/* Get page name and link from DB */
function getPageNameAndLink($db){
    $page = array('link' => '/main/', 'name' => '', 'tbl_name' => 'tbl_pages');
    if(isset($_GET['page'])):
        $page['link'] = $_GET['page'];
        $page['tbl_name'] = 'tbl_pages';
    endif;
    if(isset($_GET['var1'])):
        $page['link'] .= $_GET['var1'];
        $page['tbl_name'] = 'tbl_sub_pages';
        $page['link'] = substr($page['link'], strpos($page['link'], '/', 1)+1);
    endif;
    try{
        $db->beginTransaction();
        $sql = $db->query("SELECT name FROM $page[tbl_name] WHERE link='$page[link]'");
        $db->commit();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sql->fetch();
        $page['name'] = $row['name'];
        return $page;
    }
    catch(PDOException $e){
        $db->rollback();
        $error = "Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage();
        return $error;
    }
}

/* Get page content from DB */
function getPageContent($db, $pageData){
    try{
        $db->beginTransaction();
        $sql = $db->query("SELECT page_content FROM $pageData[tbl_name] WHERE link='$pageData[link]'");
        $db->commit();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sql->fetch();
        return $row['page_content'];
    }
    catch(PDOException $e){
        $db->rollback();
        $error = "Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage();
        return $error;
    }
}
?>