<?

namespace app\lib;

use PDO;

class Database
{

	protected $database;

	/**
	 * The construct database connect.
     * @param Configuration file path. Format: string.
     * @return Database else null.
	 */
	public function __construct(string $dbConfig)
	{
		$config = require $dbConfig;
		try {
			$this->database = new PDO ('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['pass']);
		} catch (PDOException $e) {
            return null;
		}
	}

    /**
	 * The function imports the available rows to and from the table.
	 * @param Table name. Default - "". Format: string.
	 * @param Access level. Default - 0. Format: integer.
	 * @return Table. Format: an array of associative arrays.
	 */
	public function getTableAccess(string $nameTable = "", int $accessLevel = 0)
	{
		$stmt = $this->database->prepare("SELECT * FROM " . $nameTable . " WHERE access_level = :accessLevel");
		$stmt->bindValue(":accessLevel", $accessLevel);
		$stmt->execute();
		try{
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
			return [];
		};
	}

		/**
	 * The function gets the level of access rights from the table by login, password and ip. In the format: module name - access level
	 * @param Table name. Default - "". Format: string.
	 * @param Login. Default - "". Format: string.
	 * @param Password. Default - "". Format: string.
	 * @param Ip. Default - "". Format: string.
	 * @param Column name with logins. Default - "login". Format: string.
	 * @param Column name with passwords. Default - "pass". Format: string.
	 * @param Column name with ip. Default - "ip". Format: string.
	 * @param Column name with module name. Default - "module_name". Format: string.
	 * @param Column name with access level. Default - "access_level". Format: string.
	 * @return Access level. Default - 0. Format: array.
	 * If ip = "" only login and password are checked. Returns the access level for the first match
	 */
	public function getAccessLevel(
		string $nameTable = "", 
		string $login = "", 
		string $pass = "", 
		string $ip = "", 
		string $nameColumnLogin = "login", 
		string $nameColumnPass = "pass",
		string $nameColumnIp = "ip",
		string $nameColumnModuleName = "module_name",
		string $nameColumnAccessLevel = "access_level"
		): array
		{
			if ($nameTable != ""){
				$sql = "SELECT " . $nameColumnModuleName . ", " . $nameColumnAccessLevel . " FROM " . $nameTable . "  WHERE ";
				if ($login != ""){
					$sql .= ($nameColumnLogin . " = :login");
				}else{
					return [];
				};
				if ($pass != ""){
					$sql .= (" AND " . $nameColumnPass . " = :pass");
				}else{
					return [];
				}
				if ($ip != ""){
					$sql .= " AND " . $nameColumnIp . " = :ip";
				}
				$stmt = $this->database->prepare($sql);
				$stmt->bindValue(":login", $login);
				$stmt->bindValue(":pass", $pass);
				if ($ip != ""){
					$stmt->bindValue(":ip", $ip);
				}
				try{
					$stmt->execute();
					$accessLevel = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($accessLevel) > 0){
						return $accessLevel;
					}else{
						return [];
					}
				}
				catch(PDOException $e){
					return [];
				}
			}
			return [];
		}

}
