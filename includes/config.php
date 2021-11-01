<?php
//error_reporting(E-ALL & E_NOTICE);
//ini_set('display_errors', 1);

//создаем константу
define ('SITE_NAME', "Cut your URL");
define ('HOST', "http://" . $_SERVER['HTTP_HOST']);

define ('DB_HOST', "127.0.0.1");
define ('DB_NAME', "cut_url");
define ('DB_USER', "root");
define ('DB_PASS', "root");

define("URL_CHARS", "0123456789qwertyuiopasdfghjklzxcvbnm-");

//начинаем записывать сессию, что бы с нее были доступны данные везде
//она будет стартовать каждый раз когда мы будем подключать хедер
session_start();
