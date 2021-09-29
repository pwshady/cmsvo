<?

namespace app\lib;

use PDO;
use app\lib\database;

class Router
{

    public function __construct(Database $db, string $tr, string $tyr)
    {
        $t1 = explode('/', $tr);
        print_r($t1);
        print('</br>');
        print($t1[count($t1)-2]);
        print('</br>');
        $modulTableName = "";
        for ($i = 1; $i <= (count($t1)-2); $i++){
            $modulTableName .= $t1[$i];
            if ($i < (count($t1)-2)){
                $modulTableName .= '_';
            }
        }
        print($modulTableName);
        print('</br>');
        $this->getPage($db, $modulTableName, $t1[count($t1)-1]);
    }

    public function getPage(Database $db, $modulTableName, string $request)
    {
        if (!isset($_SESSION[$modulTableName])){
            $_SESSION[$modulTableName] = 0;
        }
        print($modulTableName);
        $r5 = $db->getTableAccess($modulTableName, $_SESSION[$modulTableName]);
        print_r($r5);
        for ($i = 0; $i < count($r5); $i++){
            $str = "modules\\" . $r5[$i]["name"] . "\index.php";
            require $str;
        }
    }

}