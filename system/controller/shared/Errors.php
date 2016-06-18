<?php
namespace System\controller\Shared;
use \System\core\Router as router;

class Errors extends \core\Controllers {
	//    public $model;
	public $ecode;

	public function __construct() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		parent::__construct();

	}

	public function register_values($array = array()) {
		$this->ecode = (isset($array[0]))?$array[0]:0;
		$this -> viewdata['title'] = "Error";
		$this -> viewdata['title_error'] = "";
		$this -> viewdata['num_error'] = $this -> ecode;
		$this -> viewdata['text_error'] = "Unknown Exceptions Number: ";
	}
	public function e_values($array = array()) {
		$this->ecode = (isset($array[0]))?$array[0]:0;
		$this -> viewdata['title'] = (isset($array[1]))?$array[1]:"Error";
		$this -> viewdata['title_error'] = (isset($array[2]))?$array[2]:"";
		$this -> viewdata['num_error'] = $this -> ecode;
		$this -> viewdata['text_error'] = (isset($array[3]))?$array[3]:"Unknown Exceptions Number: ";
	}

}
?>