<?php
namespace Core {
	use \core\Router as Router;
	use \core\Helper as Helper;
	use \System\helpers\Intl as Intl;
	use \Data\Config\Config as Config;
	/**
	 *
	 */
	class Views {
		public $model;
		public $viewdata;
		private $view;
		public $action;
		public $disabled;
		public $access;
		public $enable;
		public $error;
		public $visable;

		function __construct($view) {
			register_shutdown_function(array($this, '__destruct'));
			$this -> view = __APP__ . DIRECTORY_SEPARATOR . $view . VEXT;
			$this -> enable = FALSE;
			$this -> disabled = FALSE;
			$this -> access = ACCESS_ANY;
			$this -> visable = TRUE;

			if (in_array($view, Config::$data['enabled']) && !in_array($view, Config::$data['disabled'])) {
				$this -> enable = TRUE;
			} else {
				$this -> enable = FALSE;
			}
			if (in_array($view, Config::$data['disabled'])) {
				$this -> disabled = TRUE;
			}	//$show=$this -> Load();
		}

		private function Check() {

			if (Helper::Session('user_role') > $this -> access) {
				$this -> error = ERR_CVACCESS;
				return ERR_CVACCESS;
			}
			if ($this -> disabled) {
				$this -> error = ERR_CVDISABLE;
				return ERR_CVDISABLE;
			}
			if (!$this -> enable) {
				$this -> error = ERR_CVENABLE;
				return ERR_CVENABLE;
			}

			$this -> error = ERR_SUCCESS;
			return ERR_SUCCESS;
		}

		public function Show($view = null) {

			echo $this -> Load($view);
		}

		public function Errors($custom = NULL) {
			$a = '';
			if ($custom != NULL && $this -> error != ERR_SUCCESS) {
				array_push(\Data\Config\Config::$data['enabled'], $custom);
				$eview = new $this($custom);
				$eview -> ecode = $this -> error;
				$a = $eview -> load();
				unset($eview);
			}
			return $a;
		}

		public function Load($view = NULL) {
			ob_start();
			if ($this -> action != NULL && isset($this -> c)) {
				$this -> access = $this -> action -> access;
				$this -> disabled = $this -> action -> disabled;
				$this -> visable = $this -> action -> visable;
				$this -> viewdata = $this -> action -> viewdata;
			}
			$out = "";
			if ($view == NULL) {
				if (file_exists($this -> view)) {
					require ($this -> view);
				} else {
					$this -> error = ERR_CVEXIST;
				}
			} else {
				if (file_exists(__APP__ . DIRECTORY_SEPARATOR . $view)) {
					require (__APP__ . DIRECTORY_SEPARATOR . $view);
				} else {
					$this -> error = ERR_CVEXIST;
				}
			}

			$out = ob_get_clean();

			return $out;
		}

		public function Controller($controller, $model = NULL) {
			if (isset($this -> c)) {
				return TRUE;
			}
			if (in_array($controller, Config::$data['disabled'])) {
				$this -> disabled = TRUE;
			}
			if ($this -> Check() == ERR_SUCCESS) {
				$p = str_replace('/', '\\', $controller);
				if (class_exists($p)) {
					$this -> action = new $p($model);
					$this -> access = $this -> action -> access;
					$this -> disabled = $this -> action -> disabled;
					$this -> visable = $this -> action -> visable;
					$this -> viewdata = $this -> action -> viewdata;
					$this -> c = TRUE;
					if ($this -> Check() == ERR_SUCCESS) {
						return true;
					} else {
						return false;
					}
				} else {
					$this -> error = ERR_CVEXIST;
					return FALSE;
				}
			} else {
				return false;
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
			return (isset($this -> action -> viewdata[$value])) ? $this -> action -> viewdata[$value] : '';
		}

		private function Data_2($name, $value = '') {
			$this -> action -> viewdata[$name] = $value;
			return (isset($this -> action -> viewdata[$name])) ? $this -> action -> viewdata[$name] : '';
		}
	
	public function ModelData() {
		$argsv = func_get_args();
		$argsc = func_num_args();
		if (method_exists($this, $f = 'MData_' . $argsc)) {
			return call_user_func_array(array($this, $f), $argsv);
		}
	}

	private function MData_1($value = '') {
		return (isset($this -> action->model-> viewdata[$value])) ? $this -> action ->model->  viewdata[$value] : '';
	}

	private function MData_2($name, $value = '') {
		$this -> action ->model->  viewdata[$name] = $value;
		return (isset($this -> action ->model->  viewdata[$name])) ? $this -> action ->model->  viewdata[$name] : '';
	}

		public function __destruct() {
			foreach ($this as $key => $value) {
				$this -> $key = NULL;
				unset($this -> $key);
			}
			unset($this);
			clearstatcache();
		}

	}

}
// end namespace
?>