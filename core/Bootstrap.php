<?php
namespace {
	
	function Loader( $Class ) {
    $Class = str_replace( __NAMESPACE__.'\\', '/', $Class );
    // Correct DIRECTORY_SEPARATOR
    $Class = str_replace( array( '\\', DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR, __APP__.DIRECTORY_SEPARATOR.$Class.'.php' );
    if( false === ( $Class = realpath( $Class ) ) ) {
        //echo "<h1>File not found in $Class</h1>";
        return false;
    } else {
        require_once( $Class );
        return true;
    }
}
spl_autoload_register("Loader");
}
?>