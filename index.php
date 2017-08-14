<?php
session_start();  
require 'config.php';
function __autoload($class){
	if(file_exists('core/'.$class.'.php')) {
		require 'core/'.$class.'.php';
	}
}
	$core = new Database();
?>