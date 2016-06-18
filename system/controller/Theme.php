<?php
namespace System\controller;
use \System\core\Router as router;
use \Data\Config\Config as Config;

class Theme extends \core\controllers {
	//    public $model;
	//	public $view;

	public function __construct() {
		//register_shutdown_function(array($this, '__destruct'));
		parent::__construct(self::Model('system'));
		$this -> ViewData('title',"Ymvc");
		$this -> ViewData('subtitle',"System");
		
		$this->viewdata = array_merge($this->viewdata, $this->model->viewdata);
	}

	public function __destruct() {
	//$footer = new \Core\Views(TEMPLATES.Config::$data['default']['theme'].DS."footer");
	//$footer->Show();
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		unset($this);
		clearstatcache();
	}

}
?>