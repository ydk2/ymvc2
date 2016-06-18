<?php
namespace Core;
	use Libraries\Classes\CustomException as CustomException;
	use \System\helpers\Intl as Intl;
	use \System\helpers\Helpers as Helpers;
	use \Libraries\Classes\toAscii as toAscii;
	use \core\Router as Router;
	use \core\Helper as Helper;
	use \core\Controllers as Controllers;
	use \Data\Config\Config as Config;
/**
 *
 */

class DBConnect {
	public $db;
	
	public function Connect($engin, $database, $host = 'localhost', $user = NULL, $pass = NULL) {
		try {
			if ($engin == 'posql') {
				require_once __APP__.VENDORS.'posql.php';
				$database_name = __APP__ . '/data/database/' . $database . '.db';
				if (!file_exists($database_name)) {
					throw new CustomException('Database not exist.');
				}
				// try connect
				//$sql = SQL;
				
				$this->db = new \Posql($database_name);
				//$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				if ($this->db -> isError()) {
					abort($this->db);
					throw new CustomException('Can\'t connect to Database.');
				}

			}
			if ($engin != 'posql') {
			try {
				if ($user === NULL || $pass === NULL) {
					throw new CustomException('User and Password not filed.');
				}
				$this->db = new \PDO($engin.':host=' . $host . ';dbname=' . $database, $user, $pass);
				$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new CustomException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch(\PDOException $e){
    			//handle PDO
    			throw new CustomException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
		} catch (CustomException $e) {

			Helper::Enable(SVIEW . 'shared/Exception');
			$eview = new \Core\Views(SVIEW . 'shared/Exception');
			$eview -> ecode = $e->getCode();
			$eview -> etitle ="Exception ";
			$eview -> etitle_error = "";
			$eview -> etext_error = $e->errorMessage();
			$a = $eview  -> load();
			Helper::Disable(SVIEW . 'shared/Exception');

			exit($a);
		}

	}

	public function __destruct() {
		$this->db = NULL;
		unset($this->db);
	}

}
?>