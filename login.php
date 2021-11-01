<?php 

/* if(isset($_SESSION['user'])) {
	header('Location: profile.php');
} */

if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass'])){
	include_once 'includes/functions.php';
	login($_POST);
}

$error1 = '';
if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	include_once 'includes/functions.php';
	$error1 = $_SESSION['error'];
	//что бы ошибка не выводилась постоянно обнуляем сессию
	$_SESSION['error'] = '';
}

$success = '';
if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
	include_once 'includes/functions.php';
	$success = $_SESSION['success'];
	//что бы ошибка не выводилась постоянно обнуляем сессию
	$_SESSION['success'] = '';
}




include_once 'includes/header.php';

?>
	<main class="container">
		<?php if(!empty($success)) { ?>
		 <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
			<?php echo $success; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } else if(!empty($error1) ) {?>
			<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
				<?php echo $error1; ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>

		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Вход в личный кабинет</h2>
				<p class="text-center">Если вы еще не зарегистрированы, то самое время 
					<a href="<?php echo get_url('register.php'); ?>">зарегистрироваться</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input  name="login" type="text" class="form-control is-valid" id="login-input" required>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input name="pass"  type="password" class="form-control is-invalid" id="password-input" required>
					</div>
					<button type="submit" class="btn btn-primary">Войти</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>
