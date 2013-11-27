<?php
if($_FILES['upload']){
	$allowed_ext = array('jpg','jpeg','png','gif');
	$allowed_mime = array('image/jpeg','image/png','image/gif');
	$ext = strtolower(pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION));
	$mime = strtolower($_FILES['upload']['type']);
	if (($_FILES['upload'] === "none") OR (empty($_FILES['upload']['name']))){
		$message = "Вы не выбрали файл";
	}
	elseif ($_FILES['upload']["size"] < 0 OR $_FILES['upload']["size"] > 2050000){
		$message = "Размер файла не соответствует нормам";
	}
	elseif (!in_array($ext, $allowed_ext) OR !in_array($mime, $allowed_mime)){
		$message = "Допускается загрузка только картинок JPG, PNG и GIF.";
	}
	elseif (!is_uploaded_file($_FILES['upload']["tmp_name"])){
		$message = "Что-то пошло не так. Попытайтесь загрузить файл ещё раз.";
	}
	else{
		$name =rand(1, 1000).'-'.md5($_FILES['upload']['name']).'.'.$ext;
		$full_path = "../ckeditor/uplimg/".$name;
		move_uploaded_file($_FILES['upload']['tmp_name'], $full_path);
		$message = "Файл ".$_FILES['upload']['name']." загружен";
		$size=getimagesize($full_path);
		if($size[0]<50 OR $size[1]<50){
			unlink($full_path);
			$message = "Файл не является допустимым изображением";
			$full_path="";
		}
	}
	$callback = $_REQUEST['CKEditorFuncNum'];
	echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('$callback', '$full_path', '$message');</script>";
}
?>