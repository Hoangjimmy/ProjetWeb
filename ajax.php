<?php
session_start();

// Import class configuration
require_once("config.php");

// We inform client data which it receives
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json; charset=utf-8');

if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"]))
{
	// Load Json data
	JsonHandler::init();
	// Call function requested by AJAX request
	$_REQUEST["action"]();
} 
else
{
	echo "/* ERREUR !!!!!! */\n\n{}";
}
//Function which send messages on chat
function send() 
{
	$response = array(
		"success" => false
	);
	
	// If message has been sent
	if(isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))
	{
		$handler = JsonHandler::get();
		$user = User::byId($_SESSION["id"]);
		$talk = null;
		$style = array(
			"color" => $_REQUEST["color"],
			"bold" => $_REQUEST["bold"],
			"italic" => $_REQUEST["italic"],
			"font" => $_REQUEST["font"]
		);
		$msg = new Message($user, $talk, $_REQUEST["message"], $style);
		// Update DateTime of LastMessage sent by this user
		$user->updateLastMessage();
		// Add message in Json file
		$handler->addMessage($msg);
		
		$response["success"] = true;
	}
	
	echo Utils::json_encode($response);
}

function updateUsers() 
{
	$response = array(
		"connected" => true
	);
	
	//We update users , we delete users who are disconnected
	User::checkUsers();
	
	// We add list of users connected during the callback
	$response["users"] = JsonHandler::get("users");
	// if current user is disconnected
	if(!User::alreadyExists($_SESSION['user']))
	{
		$response["connected"] = false;
		$_SESSION["connected"] = false;
		session_destroy();
	}
	
	echo Utils::json_encode($response);
}

function getMessages() 
{
	$date = null;
	// If we wish start from espacially date
	if(isset($_REQUEST["fromDate"]) && !empty($_REQUEST["fromDate"]))
	{
		$date = DateTime::createFromFormat(Message::$DATE_FORMAT, $_REQUEST["fromDate"]);
	}
	// We get messages
	$all = JsonHandler::get("messages");
	$msgs = array();
	
	// We filter messages
	foreach($all as $idx => $m) 
	{
		$msg = Message::fromJson($m);
		
		if(!is_null($date))
		{

			$diff = $date->getTimestamp() - $msg->getDate()->getTimestamp();
			
			// If the message is more recent than the date of the last message check
			if($diff >= -1)
			{
				$msgs[] = $m;
			}
		}
		else
		{
			$msgs[] = $m;
		}
	}
	
	echo Utils::json_encode($msgs);
}

?>
