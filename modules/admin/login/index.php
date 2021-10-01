<?php

print(__DIR__);
print("</br>");

//Проверка правильности структуры
if (stripos(__DIR__, "\\modules\\") === false){
    print('error');
    exit();
};

$position = stripos(__DIR__, "\\modules\\");
$moduleLocation = substr(__DIR__, ($position + 9));
$moduleLocation = str_replace("\\", "/", $moduleLocation);
$moduleTablesPrefix = str_replace("/", "_", $moduleLocation);
print($moduleLocation);
print("</br>");
print($moduleTablesPrefix);
print_r($_POST);

//Подключаем настройки
include "settings.php";

//Подключаем локализацию
if (isset($localization)){
    include $localization . "name-variable.php";
}else{
    print("</br>");
    print("erloc");
    print("</br>");
}
$header = "login_header" .PHP_EOL;
$GLOBALS["page"]["header"] .= $header;

$body = "" .PHP_EOL;
if (isset($_SESSION[$moduleTablesPrefix]) && ($_SESSION[$moduleTablesPrefix] === 1))
{
    $body .= "exit" .PHP_EOL;
}else{
    //Определяем метод запроса
    print($_SERVER['REQUEST_METHOD']);
    print("</br>");
    $body .= "<div>" .PHP_EOL;
    $body .= "    <form action=\"/admin/\" method=\"post\">" .PHP_EOL;
    $body .= "        <p>" . $nameAdminLoginLogin . "<input type=\"text\" name=\"login_admin\"></p>" .PHP_EOL;
    $body .= "        <p>" . $nameAdminLoginPass . "<input type=\"password\" name=\"pass_admin\"></p>" .PHP_EOL;
    $body .= "        <p><button type=\"submit\">" . $nameAdminLoginEnter . "</button></p>" .PHP_EOL;
    $body .= "    </form>" .PHP_EOL;
    $body .= "</div>" .PHP_EOL;
}
$GLOBALS["page"]["body"] .= $body;
$GLOBALS["page"]["footer"] .= "login_footer" .PHP_EOL;