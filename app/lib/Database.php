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

}
