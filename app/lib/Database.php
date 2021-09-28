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

}
