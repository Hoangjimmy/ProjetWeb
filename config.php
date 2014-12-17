<?php

define("DS", DIRECTORY_SEPARATOR);
//autoloader to load every class in project (don't work in test class)
function __autoload($class_name) 
{
	$path = "class". DS . strtolower($class_name) . ".class.php";
	
	if(file_exists($path))
	{
		require_once($path);
	}
	else
	{
		throw new Exception("La classe \"$class_name\" n'existe pas...");
	}
}

?>
