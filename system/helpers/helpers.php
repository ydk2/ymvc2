<?php 
namespace System\helpers {
/**
 * static helpers
 */
abstract class Helpers {
	
static public function build_sorter($key) {
	return function($a, $b) use ($key) {
		return strnatcmp($a[$key], $b[$key]);
	};
}
}
}
?>