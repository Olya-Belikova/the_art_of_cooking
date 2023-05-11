<?php //фыход из системы
session_start();

include "path.php";
//удаляем переменные
unset($_SESSION['id']);
unset($_SESSION['login']);
unset($_SESSION['admin']);

//переходим на главную страницу
header('location: ' . BASE_URL);