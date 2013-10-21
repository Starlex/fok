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

	<div class='v-menu'>
		<ul>
			<li><a href='../'>Домашняя страница</a></li>
			<li><a href='about-us/'>О нас</a></li>
			<li><a href='our-location/'>Наши координаты</a></li>
			<li><a href='our-services/'>Наши услуги</a>
				<ul>
					<li><a href="#">asdfasdf</a></li>
					<li><a href="#">asdfasdf</a></li>
				</ul>
			</li>
			<li><a href='our-rates/'>Наши тарифы</a></li>
			<li><a href='news/'>Новости</a></li>
		</ul>
	</div>
	<!-- <?=drawMenu($menu)?> -->

</div>