<?php
namespace Core;
use \core\Helper as Helper;
/**
 *
 */
class Loader {
	private $errors;
	public $view;
	public $errview;
	public $eview;
	public $error;

	public function __construct($errors = TRUE) {
		//register_shutdown_function(array($this, '__destruct'));
		$this -> errors = $errors;
		$this -> eview = SVIEW.'shared/errors';
		$this->Enable($this->eview);
	}

	public function Errors($custom = NULL) {
		$a = '';
		if ($custom != NULL && $this -> view -> error != ERR_SUCCESS) {
			$this->Enable($custom);
			$eview = new \Core\Views($custom);
			$eview -> ecode = $this -> view -> error;
			$a = $eview  -> load();
			$this->Disable($custom);
			unset($eview );
		} elseif ($this->eview != NULL && $this ->  error != ERR_SUCCESS) {
			$eview  = new \Core\Views($this->eview);
			$eview -> ecode = $this -> error;
			$a = $eview  -> load();		
			unset($eview );
		} 
		unset($this -> view);
		return $a;
	}

	function View($view, $controller) {
		$this -> view = new \Core\Views($view);
		$this -> view -> action = NULL;
		$a = $this -> view -> Controller($controller);
		$this -> error = $this -> view -> error;
		if (!$a) {
			if ($this -> errors){
			if ($this -> eview!=NULL){
				return $this -> Errors();
			} else {
				return $this -> view -> Errors();
			}}
		} else {
			return $this -> view -> load();
		}
	}
	
	public  function Lock($view) {
		array_push(\Data\Config\Config::$data['disabled'], $view);
	}
	
	public function UnLock($view) {
		foreach (\Data\Config\Config::$data['disabled'] as $key => $value) {
			if ($value==$view) {
				unset(\Data\Config\Config::$data['disabled'][$key]);
			}
		}
	}
	
	public  function Enable($view) {
		array_push(\Data\Config\Config::$data['enabled'], $view);
	}
	
	public  function Disable($view) {
		foreach (\Data\Config\Config::$data['enabled'] as $key => $value) {
			if ($value==$view) {
				unset(\Data\Config\Config::$data['enabled'][$key]);
			}
		}
	}
	
	function Show($view, $controller) {
		echo $this->View($view, $controller);
	}

	public function __destruct() {
		$this->disable($this->eview);	
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		unset($this);
		clearstatcache();
	}

}
?>