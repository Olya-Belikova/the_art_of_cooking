<?php //'функция', отвечающая за корневую директорию, за расположение блока(сервера)
error_reporting(E_ERROR | E_PARSE);
const SITE_ROOT = __DIR__;
const BASE_URL = 'http://localhost/the_art_of_cooking/';
define("ROOT_PATH", realpath(dirname(__FILE__)));