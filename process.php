<?php
session_start();

// Import configuration and classes
require_once("config.php");

if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"]))
{
	// Load Json File
	JsonHandler::init();
	// Call function call by AJAX request
	$_REQUEST["action"]();
}

function enterChat() 
{
	//If a message has been sent
	if(isset($_REQUEST["pseudo"]) && !empty($_REQUEST["pseudo"]))
	{
		// If User doesn't exist
		if(!User::alreadyExists($_REQUEST["pseudo"]))
		{
			// Create User
			$user = new User($_REQUEST["pseudo"]);
			
			// Store the user in Session var
			$_SESSION["id"] = $user->getId();
			$_SESSION["user"] = $user->getName();
			$_SESSION["connected"] = true;
			
			// Add him in  User Json file
			JsonHandler::get()->addUser($user);
			// On redirect to the chat page
			header("Location: chat.php");
		}
		else
		{	//Error Nickname already used
			header("Location: index.php?alert=". urlencode("Ce pseudo est déjà utilisé"));
		}
	}
}

function disconnect() 
{	//Get User with Session var
	$user = User::byId($_SESSION["id"]);
	//Remove User from Json
	JsonHandler::get()->removeUser($user);
	// Destroy the session
	session_destroy();
	
	// Redirect to the home page
	header("Location: index.php");
}

?>
