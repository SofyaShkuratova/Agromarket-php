<?php
//В каком режиме мы работаем? режим разработки или режим продакшн
define("DEBUG", 0);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/agromarket/core');
define("LIBS", ROOT . '/vendor/agromarket/core/libs');
define("CONF", ROOT . '/config');
define("CACHE", ROOT . '/tmp/cache');
define("LAYOUT", 'default');

//http://localhost:8888/agromarket/public/index.php
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$app_path = preg_replace("#[^/]+$#", '', $app_path);
//http://localhost:8888/agromarket/public/
$app_path = str_replace('/public/', '', $app_path);

define("PATH", $app_path);
define("ADMIN", PATH . '/admin');

require_once ROOT . '/vendor/autoload.php';
?>

