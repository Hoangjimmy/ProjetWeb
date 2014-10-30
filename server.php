<?php

if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"]))
{
	// On appel la fonction demandé par la requête AJAX
	$_REQUEST["action"]();
}

function send() 
{
	if(isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))
	{
		$file = "json/messages.json";
		$data = array();
		
		
		if(file_exists($file))
		{
			$data = file_get_contents($file);
			$data = json_decode($data, true);
		}
		
		$json = array(
			"msg" => $_REQUEST["message"]
		);
		
		$data[] = $json;
		
		file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
	}
}

?>