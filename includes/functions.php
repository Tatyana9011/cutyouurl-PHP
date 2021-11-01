<?php
include_once 'config.php';
//функция которая возвращает правельный адрес страници
function get_url($page = ""){
  // . это склеивание строк
  return HOST . '/' . $page;
}
function db(){
  try{
      return new PDO("mysql: host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }catch (PDOException $e) {
    die($e->getMessage());//команда дай завершает выполнение скрипта
  }
}
//получает с БД
function db_query($sql = '', $exec = false){
  //если приходит пустая - выходим из функции
  if (empty($sql)) return false;
  
  if($exec){
    return db()->exec($sql); //обновляет БД
  }

  return db()->query($sql);

}

function get_user_count(){
  return db_query("SELECT COUNT(id) FROM `users`")->fetchColumn();
}

function get_views_sum(){
  return db_query("SELECT SUM(`views`) FROM `links`")->fetchColumn();
}
function get_link_count(){
  return db_query("SELECT COUNT(id) FROM `links`")->fetchColumn();
}
function get_link_info($url){
  if (empty($url)) return [];

  return db_query("SELECT * FROM `links` WHERE `short_link` = '$url';")->fetch();
}

function update_views($url){
  if (empty($url)) return [];

  return db_query("UPDATE `links` SET `views` = `views` + 1 WHERE `short_link`='$url';", true);
}

function get_user_info($login){
  if (empty($login)) return [];

  return db_query("SELECT * FROM `users` WHERE `login` = '$login';")->fetch();
}

//добавление пользователя
function add_user($login, $pass){
  //для сокрытия пароля используют специальные функции md5() но ее легко расшифровуют потому используем другую
  $password = password_hash($pass, PASSWORD_DEFAULT); 

  return db_query("INSERT INTO `users` (`id`, `login`, `pass`) VALUES (NULL, '$login', '$password')", true);
}

function register_user($auth_data){
  if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass1']) || !isset($auth_data['pass2'])) return false;
  
  $user = get_user_info($auth_data['login']);

  if(!empty($user)){
    $_SESSION['error'] = "Пользователь '" . $auth_data['login'] . "' уже существует";
    header('Location: register.php');
    die;
  }

  if($auth_data['pass1'] !== $auth_data['pass2']){
    $_SESSION['error'] = "Пароли не совпадают";
    header('Location: register.php');
    die;
  }

  if(add_user($auth_data['login'], $auth_data['pass1'])){
    $_SESSION['success'] = "Регистрация прошла успешно";
    header('Location: login.php');
    die;
  }

  return true;
}

function login($auth_data){
   if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || empty($auth_data['pass'])) {
    $_SESSION['error'] = "Логин или пароль не может быть пустым";
    header('Location: login.php');
    die;
   }

   $user = get_user_info($auth_data['login']);

   if(empty($user)){
      $_SESSION['error'] = "Логин или пароль неверен!";
      header('Location: login.php');
      die;
    }
    //проверяем пароль если он не совпадает то сообщаем пользователю
    //password_verify - это спец функция сравнения паролей возвращает правда если пароли совпали и лож есни не совпали
    if(password_verify($auth_data['pass'], $user['pass'])){
      //когда юзер авторизовался ми сохраняем его в сессию
      $_SESSION['user'] = $user;
      $_SESSION['success'] = "Добро пожаловать!";
      
      header('Location: profile.php');
      die;
    }else{
      $_SESSION['error'] = "Пароль неверен!";
      header('Location: login.php');
      die;
    }
  
}

function logout(){

  session_destroy();

  header('Location: ' . HOST);
}
function get_user_links($user_id){
if(empty($user_id)) return [];

 return db_query("SELECT * FROM `links` WHERE `user_id` = '$user_id';")->fetchAll();
}

function delete_link($id){
  if(empty($id)) return false;
//DELETE FROM `links` WHERE `links`.`id` = 6
 return db_query("DELETE FROM `links` WHERE `links`.`id` = '$id';",true);
}

function generate_string($size = 6){
  //перемешиваем строку
  $new_str = str_shuffle('URL_CHARS');
//получаем подстроку со строки
 return substr($new_str,0,$size);
}

function add_link($user_id, $link){
  $short_link = generate_string();

  return db_query("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES (NULL, '$user_id', '$link', '$short_link', '0');",true);
}
