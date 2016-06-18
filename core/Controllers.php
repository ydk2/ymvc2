<?php
namespace Core;
use \System\helpers\Intl as Intl;
use \core\Router as Router;
use \core\Helper as Helper;
use \Data\Config\Config as Config;

class Controllers {
	public $model;
	public $me;
	public $parent;
	public $access;
	public $disabled;
	public $viewdata;
	public $visable;

	public function __construct($model = NULL) {
		if ($model != NULL) {
			if (is_object($model)) {
				$this -> model = $model;
			} else {
				$model = str_replace('/', '\\', $model);
				$this -> model = new $model();
			}
			if (isset($this -> model -> viewdata)) {
				$this -> viewdata = array();
				$this -> viewdata = array_merge($this -> viewdata, $this -> model -> viewdata);
			}
		}
		if (!isset($this -> access)) {
			$this -> access = ACCESS_ANY;
		}
		if (!isset($this -> disabled)) {
			$this -> disabled = FALSE;
		}
		if (!isset($this -> visable)) {
			$this -> visable = TRUE;
		}
		$this -> parent = get_class();
		$this -> me = get_class($this);
	}

	public function __destruct() {
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		unset($this);
		clearstatcache();
	}

	public static function LoadModel($model, $pos = 0) {
		if (is_object($model)) {
			Config::$data['models'][$pos] = $model;
		} else {
			$model = str_replace('/', '\\', $model);
			Config::$data['models'][$pos] = new $model();
		}
	}

	public function ViewData() {
		$argsv = func_get_args();
		$argsc = func_num_args();
		if (method_exists($this, $f = 'Data_' . $argsc)) {
			return call_user_func_array(array($this, $f), $argsv);
		}
	}

	private function Data_1($value = '') {
		return (isset($this -> viewdata[$value])) ? $this -> viewdata[$value] : '';
	}

	private function Data_2($name, $value = '') {
		$this -> viewdata[$name] = $value;
		return (isset($this -> viewdata[$name])) ? $this -> viewdata[$name] : '';
	}
	
	public function ModelData() {
		$argsv = func_get_args();
		$argsc = func_num_args();
		if (method_exists($this, $f = 'MData_' . $argsc)) {
			return call_user_func_array(array($this, $f), $argsv);
		}
	}

	private function MData_1($value = '') {
		return (isset($this ->model-> viewdata[$value])) ? $this ->model->  viewdata[$value] : '';
	}

	private function MData_2($name, $value = '') {
		$this ->model->  viewdata[$name] = $value;
		return (isset($this ->model->  viewdata[$name])) ? $this ->model->  viewdata[$name] : '';
	}

	public static function Model($pos = 0) {
		return Config::$data['models'][$pos];
	}

	public static function UnsetModel($pos = 0) {
		if (isset(Config::$data['models'][$pos])) {
			unset(Config::$data['models'][$pos]);
			return TRUE;
		}
		return false;
	}

}
?>