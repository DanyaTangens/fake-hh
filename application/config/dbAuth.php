<?
require 'application/lib/rb-mysql.php';// Подключаем библиотеку RedBeanPHP
$config = require 'application/config/db.php';
// Подключаемся к БД
$host = $config['host'];
$name = $config['name'];
$user = $config['user'];
$password = $config['password'];

try{
    R::setup('mysql:host=localhost;dbname=fakehh',
    'root', 'root');
} catch(PDOException $e){
    echo $e->getmessage();
} 

$isConnected = R::testConnection();
if($isConnected){
    echo 'подключение успешно';
} else{
    echo 'что-то не так';
}
// Проверка подключения к БД
if(!R::testConnection()) die('No DB connection!');