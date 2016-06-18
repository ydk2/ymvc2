<?php
namespace application\models;

use \core\Router as Router;
use \Core\DBConnect as DBConnect;
use \System\helpers\Intl as Intl;
use \System\helpers\Helpers as Helpers;
use \Data\Config\Config as Config;

class model extends DBConnect {
	public function __construct() {
		//Config::Data();
//		Config::$data['default']['database']['type']='posql';
		$data=Config::$data['default']['database'];
		$this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		$items=$this->db->query('DESCRIBE pages');
		$item = $items -> fetchAll(\PDO::FETCH_NAMED);
		if ($item) :
			ob_start();
			var_dump($item);
			$a=ob_get_clean();
			//return $item[0]['title'];
		endif;
		//$data=(!router::get('data'))?'start':router::get('data');
		$this->viewdata['data']=$a;		
	}

	
	
}

?>