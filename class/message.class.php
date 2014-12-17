<?php
// Message object class
class Message implements Jsonable
{	
	//Set the format of Date time
	public static $DATE_FORMAT = 'Y-m-d H:i:s';
	//Set the Default Style of every message
	public static $DEFAULT_STYLE = array(
		"color" => '#000',
		"bold" => false,
		"italic" => false,
		"font" => "Arial"
	);
	
	private $_id;
	private $_user;
	private $_talk;
	private $_content;
	private $_date;
	
	private $_style;
	
	public function __construct($user, $talk, $content, $style, $date = null)
	{
		$this->_id = uniqid();
		$this->_user = $user;
		$this->_talk = $talk;
		$this->_content = $content;
		$this->_date = $date;
		$this->_style = $style;
		
		if(is_null($style)) {
			$this->_style = self::$DEFAULT_STYLE;
		}
		
		if(is_null($date)) {
			$this->_date = new DateTime();
		}
	}
	// Get the Date when the message has been post
	public function getDate()
	{
		return $this->_date;
	}
	// Get the User who sent the message
	public function getUser()
	{
		return $this->_user;
	}
	// Get the text formating of a message
	public function getStyle($key)
	{
		if(is_null($key))
		{
			return $this->_style;
		}
		else
		{
			return $this->_style[$key];
		}
	}
	// Get the color of message
	public function getColor()
	{
		return $this->_style["color"];
	}
	// Set a color to a message
	public function setColor($value)
	{
		$this->_style["color"] = $value;
	}
	//Get the font to a message
	public function getFont()
	{
		return $this->_style["font"];
	}
	//Set a font to a message
	public function setFont($value)
	{
		$this->_style["font"] = $value;
	}
	//If a message is bold if it's not he will
	public function isBold($value)
	{
		if(is_null($value))
		{
			return $this->_style["bold"];
		}
		else
		{
			$this->_style["bold"] = $value;
		}
	}
	//IF is Italic if it's not he will
	public function isItalic($value)
	{
		if(is_null($value))
		{
			return $this->_style["italic"];
		}
		else
		{
			$this->_style["italic"] = $value;
		}
	}
	//Get the content of a message
	public function getContent()
	{
		return $this->_content;
	}
	// encode a message in Json Format
	public function toJson()
	{
		return array(
			"id" => $this->_id,
			"user_id" => $this->_user->getId(),
			"user_name" => $this->_user->getName(),
			"talk" => $this->_talk,
			"content" => $this->_content,
			"date" => $this->_date->format(self::$DATE_FORMAT),
			"style" => $this->_style
		);
	}
	// build a message object from a Json array
	public static function fromJson($json)
	{
		$user = User::byId($json["user_id"]);
		$talk = $json["talk"];
		$content = $json["content"];
		$style = $json["style"];
		$date = DateTime::createFromFormat(self::$DATE_FORMAT, $json["date"]);
		
		$msg = new Message($user, $talk, $content, $style, $date);
		return $msg;
	}
}
?>
