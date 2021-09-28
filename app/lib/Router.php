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
    }

    public function rrr()
    {

    }

}