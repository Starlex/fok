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
function drawMenu($db, $vertical = true, $page = ''){
	/*echo "<pre>";
    print_r($menu);
    echo "</pre>";*/

    $style = 'v-menu';
    if(!$vertical){
        $style = 'h-menu';
    }

    $sql = "SELECT p.page_id, sp.page_id pid, p.page_link, p.page_name, sp.sub_page_link, sp.sub_page_name
            FROM tbl_pages p
            LEFT JOIN tbl_sub_pages sp
            ON p.page_id = sp.page_id";
    try{
        $db->beginTransaction();
        $sql_result = $db->query($sql);
        $db->commit();
        $sql_result->setFetchMode(PDO::FETCH_ASSOC);
        echo "<div class='$style'>";
            echo "\n\t\t<ul>";
        while($row = $sql_result->fetch()){
            // echo "<pre>";
            // print_r($row);
            // echo "</pre>";
            echo "\n\t\t\t<li><a href='$row[page_link]'>$row[page_name]</a></li>";
            if($row['page_id'] === $row['pid']){
                echo "\n\t\t\t<li><a href='$row[sub_page_link]'>$row[sub_page_name]</a></li>";
            }
        }
            echo "\n\t\t</ul>";
        echo "\n\t</div>";
    }
    catch(PDOException $e){
        $db->rollback();
        die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
    }
}
?>