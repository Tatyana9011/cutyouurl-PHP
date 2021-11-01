<?php
include "functions.php";
include "config.php";

if(!isset($_GET['id']) && empty($_GET['id'])){
  header('Location: /profile.php');
  die;
}

delete_link($_GET['id']);
$_SESSION['success'] = "Ссылка успешно удалина";
header('Location: /profile.php');
die;

//проверка какому пользователю эта ссылка пренадлежит