<?php
if(isset($_POST['send'])):
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	$sql = "SELECT count(*) FROM tbl_admin WHERE login = ? AND password = ?";
	try{
		$result = $db->prepare($sql);
		$result->execute(array($login, $password));
		$num = $result->fetchColumn();
	}
	catch(PDOException $e){
		die("Ошибка при доступе к базе данных: <br>in file: ".$e->getFile()."; line: ".$e->getLine().";<br>error: ".$e->getMessage());
	}
	if($num > 0):
		session_start();
		$_SESSION['login'] = $login;
		header('Location:/admin/');
	endif;

endif;

if('/login/' === $_GET['page']):
?>

	<fieldset>
		<legend>Авторизация пользователя</legend>
		<form name="flogin" method='post' action="">
			<label for="">
				<span>Введите логин:</span>
				<input type="text" name="login" id="">
			</label>
			<label for="">
				<span>Введите пароль:</span>
				<input type="password" name="password" id="pass">
			</label>
			<div class="button_panel">
				<input class="button" name='send' type="submit" value="Войти">
				<input class="button" type="reset" value="Очистить поля">
			</div>
		</form>
	</fieldset>

<?php
elseif('/logout/' === $_GET['page']):
	session_start();
	session_destroy();
	header('Location;/home-page/');
endif;

?>