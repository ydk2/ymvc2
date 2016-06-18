<?php
namespace {

	require_once "bootstrap.php";
	use \System\helpers\Intl as Intl;
	use \System\helpers\Helpers as Helpers;
	use \Libraries\Classes\toAscii as toAscii;
	use \core\Router as Router;
	use \core\Helper as Helper;
	use \core\Controllers as Controllers;
	use \Data\Config\Config as Config;

	//Config::Data();
	Helper::Session_Start();
	Helper::Session_Set('user_role', ACCESS_EDITOR);
	$theme = "main";
	

	Config::$data['default']['database']['type'] = 'mysql';
	Config::$data['disabled'] = array();
	Config::$data['enabled'] = array(
		"templates/$theme/header", 
		"templates/$theme/footer", 
		'application/views/view', 
	);
	Controllers::LoadModel(MODEL . 'model');
	Controllers::LoadModel(SMODEL . 'model', 'system');
	$header = new \Core\Views(TEMPLATES . Config::$data['default']['theme'] . DS . "header");
	$header -> Show();

	//$start = new \Core\Views(VIEW.'view');
	//echo $start->Load();
	//echo $start->error;
	//echo $start->Errors(SVIEW.'shared/errors');

	$mid = new \Core\Loader(FALSE);
	//$mid->Show(VIEW.'view',CONTROLLER.'show');

	$mid -> ecode = 2986;
	$mid -> Show(VIEW . 'show', CONTROLLER . 'show');
	echo $mid -> Errors();

	Helper::Lock(VIEW . 'view');
	$mid -> Show(VIEW . 'view', CONTROLLER . 'core');
	//echo $mid->view->error;
	echo $mid -> Errors();
	$end = new \Core\Loader(TRUE);
	$end -> Enable(VIEW . 'show');
	$end -> Show(VIEW . 'show', CONTROLLER . 'show');
	//echo $end->error;

	$c = new \Core\Loader(TRUE);
	$c -> Unlock(VIEW . 'view');
	$c -> Show(VIEW . 'view', CONTROLLER . 'show');

	$footer = new \Core\Views(TEMPLATES . Config::$data['default']['theme'] . DS . "footer");
	$footer -> Show();
}
?>