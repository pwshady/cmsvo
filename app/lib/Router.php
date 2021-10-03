<?

namespace app\lib;

use PDO;
use app\lib\database;

class Router
{

    public function __construct(Database $db, string $tr, string $tyr)
    {
        $t1 = explode('/', $tr);
        $modulTableName = "";
        for ($i = 1; $i <= (count($t1)-2); $i++){
            $modulTableName .= $t1[$i];
            if ($i < (count($t1)-2)){
                $modulTableName .= '_';
            }
        }
        $this->getPage($db, $modulTableName, $t1[count($t1)-1]);
    }

    public function getPage(Database $db, $modulTableName, string $request)
    {
        if (!isset($_SESSION[$modulTableName])){
            $_SESSION[$modulTableName] = 0;
        }
        //print($modulTableName);
        $r5 = $db->getTableAccess($modulTableName, $_SESSION[$modulTableName]);
        print_r($r5);
        print_r("</br>");
        print_r($_SESSION[$modulTableName]);
        for ($i = 0; $i < count($r5); $i++){
            $str = "modules\\" . $r5[$i]["name"] . "\index.php";
            require $str;
        }
    }

}