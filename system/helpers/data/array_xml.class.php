<?php
/**
 * 
 */
require_once 'array_paths.class.php';
class array_xml extends array_paths {
function _get_path_by_attr($key,$value,$array,$force = TRUE){
$output = FALSE;
$this->init($array);
$path = $this->search($key,$value);
if ($path != '') {
$path = explode('/@attributes', $path);
$subpath = explode('/', $path[0]);
if($force){
array_pop($subpath);
$output = implode("/", $subpath); 
} else {
	$output = $path[0];
}   
}   
//$this->close();
return $output;
}
/*
 * 
 */ 
function _get_element_by_attr($key,$value,$array, $force = TRUE){
$path = $this->_get_path_by_attr($key, $value, $array,$force);
$output = $this->get($path);    
//$this->close();
return $output;
}
function _set_element_by_attr($key,$value,$array,$input, $force = TRUE){
$path = $this->_get_path_by_attr($key, $value, $array,$force);
$output = $this->set($path, $input); 
//var_dump( $array);   
//$this->close();
return $output;
}

function _set_attr_by_path($path,$array){
$output = $this->set($path."/@attributes", $array); 
//var_dump( $array);   
//$this->close();
return $output;
}

// Recursive backtracking function for multidimensional array search

 function search_r($value, $array){
 $results = array();

 if(is_array($array)){
 $path = $this->array_search_recursive($value,$array);
 if (is_array($path) && count($path) > 0){
 $results[] = $path;
 unset($array[$path[0]]);
 $results = array_merge($results, $this->search_r($value,$array));
 }else{

 }
 }

 return $results;
 }
 
}

?>