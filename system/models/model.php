<?php
namespace System\models;

use \core\Router as Router;
use \Core\DBConnect as DBConnect;
use \System\helpers\Intl as Intl;
use \System\helpers\Helpers as Helpers;
use \Core\Helper as Helper;
use \Data\Config\Config as Config;

class model extends DBConnect {
	public function __construct() {
		$data=(!Helper::get('data'))?'start':Helper::get('data');
		$this->viewdata['data']=$data;		
	}

	
	
}

?>