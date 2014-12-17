<?php

class JsonHandler
{
	private static $INSTANCE;
	
	public static $JSON_MESSAGES = "json/messages.json";
	public static $JSON_USERS = "json/users.json";
	public static $JSON_TALKS = "json/talks.json";
	
	private $_messages;
	private $_users;
	private $_talks;
	public function __construct()
	{
		// On lit les données JSON
		$this->_majData();
	}
	
	public static function init()
	{
		if(empty(self::$INSTANCE))
		{
			self::$INSTANCE = new JsonHandler();
		}
	}
	//Generic getter
	public static function get($json = null)
	{
		$res = null;
		
		if(is_null($json))
		{
			$res = self::$INSTANCE;
		}
		else
		{
			//Depends what Json we want get
			switch($json)
			{
				case "messages":
					$res = self::$INSTANCE->getMessages();
				break;
				
				case "users":
					$res = self::$INSTANCE->getUsers();
				break;
				
				case "talks":
					$res = self::$INSTANCE->getTalks();
				break;
				
				default: break;
			}
			
		}
		
		return $res;
	}
	//Get the Json of message
	public function getMessages()
	{
		return $this->_messages;
	}
	//Get the Json of User
	public function getUsers()
	{
		return $this->_users;
	}
	//Get the Json of talks
	public function getTalks()
	{
		return $this->_talks;
	}
	//Update data From Json file 
	private function _majData()
	{
		//Read again Json of Message, User and Talks
		$this->_messages = $this->read(self::$JSON_MESSAGES);
		$this->_users = $this->read(self::$JSON_USERS);
		$this->_talks = $this->read(self::$JSON_TALKS);
	}
	
	public function addMessage($msg)
	{
		// On ajoute le message à la liste en mémoire
		// We add message to list in memory
		$this->_messages[] = $msg;
		
		// On réécrit le fichier
		// Rewrite the file
		$this->write(self::$JSON_MESSAGES, $this->_messages);
	}
	
	public function addUser($user)
	{
		// On ajoute l'utilisateur à la liste en mémoire
		// Add user to list in memory
		$this->_users[] = $user;
		
		// On réécrit le fichier
		// Rewrite the file
		$this->write(self::$JSON_USERS, $this->_users);
	}
	
	public function removeUser($user)
	{
		// On efface l'utilisateur de la liste en mémoire
		// Delete user to list in memory
		foreach($this->_users as $idx => $u)
		{
			if($u["id"] == $user->getId())
			{
				array_splice($this->_users, $idx, 1);
				break;
			}
		}
		// On réécrit le fichier
		// Rewrite the file
		$this->write(self::$JSON_USERS, $this->_users);
	}
	
	// Delete several users
	public function removeUsers($usersId)
	{
		// If the parameter is an array of User ID
		if(is_array($usersId))
		{	
			// For each user ID in the array
			foreach($usersId as $userID)
			{
				// Delete user to list in memory
				foreach($this->_users as $idx => $u)
				{
					if($u["id"] == $userID)
					{
						array_splice($this->_users, $idx, 1);
						break;
					}
				}
			}
			
			// Rewrite the file
			$this->write(self::$JSON_USERS, $this->_users);
		}
	}
	
	public function setUsers($users)
	{
		if(is_array($users))
		{
			// Update user in memory
			$this->_users = $users;
		
			// Rewrite in Json file
			$this->write(self::$JSON_USERS, $users);
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
