<?php

$error = '';
if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	include 'includes/functions.php';
	$error = $_SESSION['error'];
	//что бы ошибка не выводилась постоянно обнуляем сессию
	$_SESSION['error'] = '';
}

$success = '';
if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
	include_once '/includes/functions.php';
	$success = $_SESSION['success'];
	//что бы ошибка не выводилась постоянно обнуляем сессию
	$_SESSION['success'] = '';
}

if(isset($_POST['login']) && !empty($_POST['login'])){
	include 'includes/functions.php';
	register_user($_POST);
}

include_once 'includes/header.php';

?>
	<main class="container">
		<?php if(!empty($success)) { ?>
		 <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
			<?php echo $success; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } else if(!empty($error1)) {?>
			<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
				<?php echo $error1; ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Регистрация</h2>
				<p class="text-center">Если у вас уже есть логин и пароль, <a href="<?php echo get_url('login.php'); ?>">войдите на сайт</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input type="text" name="login" class="form-control" id="login-input" required>
						<!-- <div class="valid-feedback">Все ок</div> -->
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" name="pass1"class="form-control" id="password-input" required>
						<!-- div class="invalid-feedback">А тут не ок</div> -->
					</div>
					<div class="mb-3">
						<label for="password-input2" class="form-label">Пароль еще раз</label>
						<input type="password" name="pass2" class="form-control" id="password-input2" required>
						<!-- <div class="invalid-feedback">И тут тоже не ок</div> -->
					</div>
					<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
				</form>
			</div>
		</div>
	</main>
<?php include_once 'includes/footer.php' ?>
