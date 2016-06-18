<?php
namespace application\controller;

use \Core\Controllers as controllers;
use \core\Router as router;
use \core\Helper as Helper;

class show  extends controllers {

	public function __construct() {
		parent::__construct(self::Model());
		$this -> access = ACCESS_ANY;
		//$this->visable=FALSE;

		//$this->disabled=TRUE;
		$this -> viewdata['title'] = "Show";
		$this -> viewdata['text'] = "text";
		//$this-> viewdata = array_merge($this -> viewdata, $this  -> model -> viewdata);
	}
	public function functionName($value='')
	{
		
	}

}
?>