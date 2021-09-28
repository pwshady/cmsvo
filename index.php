<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    //print($_SERVER["REQUEST_URI"]);

require_once "app\lib\Router.php";
require_once "app\lib\Database.php";

use app\lib\router;
use app\lib\database;

session_start();

//Определяем тип и строку запроса
$typeRequest = 0;
$textRequest = $_SERVER["REQUEST_URI"];

if ((stripos($textRequest, "/api/") !== false) && (stripos($textRequest, "/api/") === 0)){
    $typeRequest = 1;
}else{
    if ((stripos($textRequest, "/admin/") === false) && (stripos($textRequest, "/admin/") !== 0)){
        $textRequest = "/user" . $textRequest;
    };
};

print($typeRequest . "</br>");
print($textRequest . "</br>");

//Подключаемся к БД
$db = new Database("app/config/db-config.php");

if(is_null($db)){
    //require_once ""
    print("error db");
}else{
};

$router = new Router($db, $textRequest, $typeRequest);


