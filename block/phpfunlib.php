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
	/*echo "<pre>";
    print_r($menu);
    echo "</pre>";*/
    $selected_page = "../";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    $style = 'v-menu';
    if(!$vertical){
        $style = 'h-menu';
    }

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
                foreach ($row_pages as $page) {
                    $li_style = "";
                    if($page['page_link'] === $selected_page){
                        $li_style = " class='selected'";
                    }
                    echo "\n\t\t\t", "<li$li_style><a href='$page[page_link]'>$page[page_name]</a>",
                            "\n\t\t\t\t", "<ul>";
                        foreach ($row_sub_pages as $sub_page) {
                            if($page['page_id'] === $sub_page['page_id']){
                                echo "\n\t\t\t\t\t", "<li><a href='$sub_page[sub_page_link]'>$sub_page[sub_page_name]</a>";
                            }
                        }
                    echo "\n\t\t\t\t", "</ul>",
                    "\n\t\t\t", "</li>";
                }
            echo "\n\t\t", "</ul>",
            "\n\t", "</div>";
    }
    catch(PDOException $e){
        $db->rollback();
        die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
    }
}
?>