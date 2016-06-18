<?php
namespace System\controller;
use \System\core\Router as router;

class Errors extends \core\controllers {
	//    public $model;
	//	public $view;

	public function __construct() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		parent::__construct();
		$this->viewdata['title']="Error";
		$this->viewdata['title_access']="Access danied";
		$this->viewdata['text_access']="Access danied, Please login";
		$this->viewdata['title_disabled']="Not available";
		$this->viewdata['text_disabled']="This module is disabled";
		$this->viewdata['title_notexist']="Not available";
		$this->viewdata['text_notexist']="Not existed module";
	}



}
?>