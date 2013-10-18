<?php
$menu = array(
				array('link' => '../', 'name' => 'Домашняя страница'),
				array('link' => 'about-us/', 'name' => 'О нас'),
				array('link' => 'our-location/', 'name' => 'Наши координаты'),
				array('link' => 'our-services/', 'name' => 'Наши услуги'),
				array('link' => 'our-rates/', 'name' => 'Наши тарифы'),
				array('link' => 'news/', 'name' => 'Новости'),
				);
?>

<div class="leftblock">
	<div class="logo"><a href="http://nggu.ru" target="_blank"></a></div>
	<div class="logoSign">
		Федеральное государственное бюджетное учреждение высшего профессионального образования "Нижневартовский государственный университет"
	</div>

	<?=drawMenu($menu)?>

</div>