<?php 

	//если $_GET['url'] существует и если он не пуст 
	if(isset($_GET['url']) && !empty($_GET['url'])) {
		include_once 'includes/functions.php';

		$url = strtolower(trim($_GET['url']));  //приводим в нижний регист и убираем пробелы
		//если урл есть то мы проверяем ее в БД если она есть топереходим по ней если нет то ничего не делаем
		$link = get_link_info($url);
//если ничего не найдено то переадресовываем на страницу 404
		if(empty($link)){
			header('Location: 404.php');
			die;
		}
		//меняем количество просмотров и переходим по длинной ссылке
		update_views($url);
		header('Location: ' . $link['long_link']);
		die;
	}

	include_once 'includes/header.php'; 

?>

	<main class="container">
		<?php if(!isset($_SESSION['user']['id'])) {?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Необходимо 
					<a href="<?php echo get_url('register.php'); ?>">зарегистрироваться</a> или 
					<a href="<?php echo get_url('login.php'); ?>">войти</a> под своей учетной записью</h2>
			</div>
		</div>
		<?php } ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php echo $users_count; ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php echo $link_count; ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php echo $views_sum; ?></h2>
			</div>
		</div>
	</main>
<?php include_once 'includes/footer.php'; ?>