<?php
namespace application\controller;
use \Core\Controllers as controllers;
use \core\Router as router;
use \core\Helper as Helper;

class core  extends controllers {

	public function __construct() {

		parent::__construct();
		$this -> visable = FALSE;
		$this -> access = ACCESS_USER;
		//$this->disabled=TRUE;
		$this -> viewdata['title'] = "title";
		$this -> viewdata['text'] = "text";

		//file_put_contents(__APP__.DS."test.txt", "test");
	}

}
?>