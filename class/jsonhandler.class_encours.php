<?php

class JsonHandler
{
	
	const JSON_MESSAGES = "json/messages.json";
	const JSON_USERS = "json/users.json";
	const JSON_TALKS = "json/talks.json";
	
	private static $_messages;
	private static $_users;
	private static $_talks;
	
	public static function init()
	{
		self::_majData();
	}
	
	public static function get($json)
	{
		$res = null;
		
		switch($json)
		{
			case "messages":
				$res = self::getMessages();
			break;
			
			case "users":
				$res = self::getUsers();
			break;
			
			case "talks":
				$res = self::getTalks();
			break;
			
			default: break;
		}
		
		return $res;
	}
	
	public static function getMessages()
	{
		return self::$_messages;
	}
	
	public static function getUsers()
	{
		return self::$_users;
	}
	
	public static function getTalks()
	{
		return self::$_talks;
	}
	
	private static function _majData()
	{
		self::$_messages = self::read(self::JSON_MESSAGES);
		self::$_users = self::read(self::JSON_USERS);
		self::$_talks = self::read(self::JSON_TALKS);
	}
	
	public static function addMessage($msg)
	{
		// On ajoute le message à la liste en mémoire
		// We add message to list in memory
		self::$_messages[] = $msg;
		
		// On réécrit le fichier
		// Rewrite the file
		self::write(self::JSON_MESSAGES, self::$_messages);
	}
	
	public static function addUser($user)
	{
		// On ajoute l'utilisateur à la liste en mémoire
		// Add user to list in memory
		self::$_users[] = $user;
		
		// On réécrit le fichier
		// Rewrite the file
		self::write(self::JSON_USERS, self::$_users);
	}
	
	public static function removeUser($user)
	{
		// On efface l'utilisateur de la liste en mémoire
		// Delete user to list in memory
		foreach(self::$_users as $idx => $u)
		{
			if($u["id"] == $user->getId())
			{
				array_splice(self::$_users, $idx, 1);
				break;
			}
		}
		// On réécrit le fichier
		// Rewrite the file
		self::write(self::JSON_USERS, self::$_users);
	}
	
	// Delete several users with an array of User ID
	public static function removeUsers($usersId)
	{
		// If the parameter is an array of User ID
		if(is_array($usersId))
		{	
			// For each user ID in the array
			foreach($usersId as $userID)
			{
				// Delete user to list in memory
				foreach(self::$_users as $idx => $u)
				{
					if($u["id"] == $userID)
					{
						array_splice(self::$_users, $idx, 1);
						break;
					}
				}
			}
			
			// Rewrite the file
			self::write(self::JSON_USERS, self::$_users);
		}
	}
	
	public function setUsers($users)
	{
		if(is_array($users))
		{
			// Update user in memory
			self::$_users = $users;
		
			// Rewrite in Json file
			self::write(self::JSON_USERS, $users);
		}
	}
	//Read from Json File
	public function read($filepath)
	{
		$data = array();
		
		// If file exists
		if(file_exists($filepath))
		{
			try
			{
				// Get the content from Json file
				$data = file_get_contents($filepath);
				// Parse text data
				$data = json_decode($data, true);
			} 
			catch(Exception $e)
			{
				// Opening file exception
				print_r($e);
				exit;
			}	
		}
		return $data;
	}
	
	//Write in Json File
	public function write($filepath, $content)
	{
		file_put_contents($filepath , Utils::json_encode($content));
	}
}
?>
