<?php
namespace application\models;
use \core\Router as router;
class show {
	public $title;
	public $date;
	public $content;
	public $path;
	public $parent;
	public $id;
	
	public function __construct() {
		$data=(!router::get('data'))?'start':router::get('data');
		$this->viewdata['data']=$data;	
		$this->viewdata['text']=$data;		
	}
}

?>