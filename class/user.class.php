<?php
require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/jsonable.class.php");

//Define User object class composed by an ID a name and the date of the last message sent
class User implements Jsonable
{
	public static $TIMEOUT = 600;
	
	private $_id;
	private $_name;
	private $_lastMessage;
	
	public function __construct($name)
	{
		$this->_id = uniqid("user_");
		$this->_name = $name;
		$this->_lastMessage = new DateTime();
	}
	//Get the name of the object
	public function getName()
	{
		return $this->_name;
	}
	//Set the name of the object
	public function setName($name)
	{
		$this->_name = $name;
	}
	//Get the Id of User
	public function getId()
	{
		return $this->_id;
	}
	//Set the Id of User
	public function setId($id)
	{
		$this->_id = $id;
	}
	//Get the date time of the last message post by this user
	public function getLastMessage()
	{
		return $this->_lastMessage;
	}
	//Set the date time of the last message post by this user
	public function setLastMessage(DateTime $date)
	{
		$this->_lastMessage = $date;
	}
	//Set the current date time to the last message post by this user
	public function updateLastMessage()
	{
		$this->_lastMessage = new DateTime();
	}
	// Serialize an User to a Json format array with his different 
	public function toJson()
	{
		return array(
			"id" => $this->_id,
			"name" => $this->_name,
			"last-message" => $this->_lastMessage->format(Message::$DATE_FORMAT)
		);
	}
	// Create a User from a Json object
	public static function fromJson($json)
	{
		$lastMsg = DateTime::createFromFormat(Message::$DATE_FORMAT, $json["last-message"]);
		
		$user = new User($json["name"]);
		$user->setId($json["id"]);
		$user->setLastMessage($lastMsg);
		
		return $user;
	}
	// Test if user exist in JSon with a nickname give in parameter
	public static function alreadyExists($pseudo)
	{	
		// Get user and test if the name match with each User from Json
		$users = JsonHandler::get("users");
		$bool = false;
		
		foreach($users as $json)
		{	
			// If he find he return true and break the loop
			if($json["name"] == $pseudo)
			{
				$bool = true;
				break;
			}
		}
		
		return $bool;
	}
	// Get an User with his ID
	public static function byId($id)
	{	
		// Get the user from JSon
		$users = JsonHandler::get("users");
		$user = null;
		// For each User compare with the ID in parameter
		// If the loop find him he break the loop and return the user else return null
		foreach($users as $idx => $json)
		{
			if($json["id"] == $id)
			{
				$user = User::fromJson($json);
				break;
			}
		}
		
		return $user;
	}
	
	public static function checkUsers()
	{
		// Get user from Json
		$users = JsonHandler::get("users");
		// Declare an empty array of user to Remove
		$toRemove = array();
		//Set current Date Time in memory
		$now = new DateTime();
		//For each user in Json
		foreach($users as $idx => $json)
		{	//Get the last message date time
			$lastMsg = DateTime::createFromFormat(Message::$DATE_FORMAT, $json["last-message"]);
			// Substract Now and last message send
			$interval = $now->getTimestamp() - $lastMsg->getTimestamp();
			//If user don't write for some minutes we define him as away
			if($interval >= self::$TIMEOUT)
			{
				$toRemove[] = $json["id"];
			}
		}
		// Update the JSON file of user and remove every away user
		if(count($toRemove) > 0)
		{	
			//Remove the array of User
			JsonHandler::get()->removeUsers($toRemove);
		}
	}
}
?>
