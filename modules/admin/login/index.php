<?php

//Проверка правильности структуры
if (stripos(__DIR__, "\\modules\\") === false){
    print('error');
    exit();
};

$position = stripos(__DIR__, "\\modules\\");
$moduleLocation = substr(__DIR__, ($position + 9));
$moduleLocation = str_replace("\\", "/", $moduleLocation);
$moduleTablesPrefix = str_replace("/", "_", $moduleLocation);


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

body:

if(isset($GLOBALS["page"]["instructions"]["login"]["end"])){
    header ('Location: //cmsvo/admin/');
    exit();
}
$body = "" .PHP_EOL;

if (isset($_SESSION[$moduleTablesPrefix]) && ($_SESSION[$moduleTablesPrefix] == 1))
{
    //Определяем метод запроса
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        //Удаляем сессии
        if (isset($_POST[$moduleTablesPrefix . "_exit"])){
            //Получаем список модулей доступных для данного логина и пароля
            $mmm = $db->getAccessLevel($moduleTablesPrefix . "_accesslevel", $_SESSION[$moduleTablesPrefix . "_login"], $_SESSION[$moduleTablesPrefix . "_pass"]);
            for ($i = 0; $i < count($mmm); $i++){
                print("</br>" . $mmm[$i]["module_name"] . "  -  " . $mmm[$i]["access_level"]);
                unset($_SESSION[str_replace("/", "_", $mmm[$i]["module_name"])]);
            }
            unset($_SESSION[$moduleTablesPrefix . "_login"]);
            unset($_SESSION[$moduleTablesPrefix . "_pass"]);
            $GLOBALS["page"]["instructions"]["login"]["end"] = true;
        }
        $_SERVER['REQUEST_METHOD'] = "GET";
        goto body;
    }
    $body .= "<div>" .PHP_EOL;
    $body .= "    <form action=\"/" . $moduleLocation . "/\" method=\"post\">" .PHP_EOL;
    $body .= "        <p><button type=\"submit\" name=\"" . $moduleTablesPrefix . "_exit\">" . $nameLoginExit . "</button></p>" .PHP_EOL;
    $body .= "    </form>" .PHP_EOL;
    $body .= "</div>" .PHP_EOL;
}else{
    $body .= "<div>" .PHP_EOL;
    $body .= "    <form action=\"/" . $moduleLocation . "/\" method=\"post\">" .PHP_EOL;
    $body .= "        <p>" . $nameLoginLogin . "<input type=\"text\" name=\"" . $moduleTablesPrefix . "_login\"></p>" .PHP_EOL;
    $body .= "        <p>" . $nameLoginPass . "<input type=\"password\" name=\"" . $moduleTablesPrefix . "_pass\"></p>" .PHP_EOL;
    $body .= "        <p><button type=\"submit\">" . $nameLoginEnter . "</button></p>" .PHP_EOL;
    $body .= "    </form>" .PHP_EOL;
    $body .= "</div>" .PHP_EOL;
    //Определяем метод запроса
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        //Создаем сессии
        if ((isset($_POST[$moduleTablesPrefix . "_login"])) && (isset($_POST[$moduleTablesPrefix . "_pass"]))){
            //Получаем список модулей доступных для данного логина и пароля
            $mmm = $db->getAccessLevel($moduleTablesPrefix . "_accesslevel", $_POST[$moduleTablesPrefix . "_login"], $_POST[$moduleTablesPrefix . "_pass"]);
            if(count($mmm) > 0){
                for ($i = 0; $i < count($mmm); $i++){
                    print("</br>" . $mmm[$i]["module_name"] . "  -  " . $mmm[$i]["access_level"]);
                    $_SESSION[str_replace("/", "_", $mmm[$i]["module_name"])] = $mmm[$i]["access_level"];
                }
                $_SESSION[$moduleTablesPrefix . "_login"] = $_POST[$moduleTablesPrefix . "_login"];
                $_SESSION[$moduleTablesPrefix . "_pass"] = $_POST[$moduleTablesPrefix . "_pass"];
                $GLOBALS["page"]["instructions"]["login"]["end"] = true;
            }else{
                print("ERRORRRR");
            }
        }
        $_SERVER['REQUEST_METHOD'] = "GET";
        goto body;
    }
}

print_r("</br>");
print_r($_SESSION);

$GLOBALS["page"]["body"] .= $body;
$GLOBALS["page"]["footer"] .= "login_footer</br>" .PHP_EOL;
