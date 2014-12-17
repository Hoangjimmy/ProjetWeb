<?php
require_once("../config.php");

class testMessage extends PHPUnit_Framework_TestCase
{

	
	public function testToJson()
	{
		//Before
		$user = new User("John");	
		$talks = new talk("main", $user,"private");
		$mess = new Message($user, $talk, "Salut ça va?", null, null);
		public static $DEFAULT_STYLE = array(
											"color" => '#000',
											"bold" => false,
											"italic" => false,
											"font" => "Arial");
		//Execute Method									
		$array = $mess->toJson();
		
		//Assert
		$this->assertNotNull($array);
		$this->assertEquals($array["user"], $user);
		$this->assertEquals($array["talk"],$talks);
		$this->assertEquals($array["content"], "Salut ça va?");
		$this->assertEquals($array["style"],$DEFAULT_STYLE);
		
	}
	
	public function testFromJson()
	{
		//Before
		$user = new User("John");	
		$talks = new talk("main", $user,"private");
		$mess = new Message($user, $talk , "Salut ça va?", null, null);
		$array = $mess->toJson();
		
		//Execute Method
		$mess2 = Message::fromJson($array);
		//Assert
		$this->assertNotNull($mess);
		$this->assertEquals($mess,$mess2);
	}

}
