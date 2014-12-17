<?php

require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/user.class.php");
require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/jsonable.class.php");
require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/jsonhandler.class.php");
require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/utils.class.php");
require_once("/home/etud/hoangjim/public_html/ProjetWeb/class/message.class.php");
date_default_timezone_set('Europe/Paris');

class UserTest extends PHPUnit_Framework_TestCase
{
	

public function testToJson()
{
	//Before
	$use = new User("John");
	$current = date_default_timezone_set();
	$use->setLastMessage($current);
	//Execute the method to be tested
	$array = $use->toJson();
	// Asserts after
	$this->assertNotNull($array);
	$this->assertEquals($array["name"],"John");
	$this->assertEquals($array["last-message"],$current);
}


public function testByID()
{
	//Before
	$use = new User("John");
	$jh = new JsonHandler();
	$jh->init();
	$jh->addUser($use);
	//Execute the method to be tested
	$use2 = User::byId($use->getId());
	//Asserts
	$this->assertNotNull($use2);
	$this->assertEquals($use,$use2);
}

public function testAlreadyExist()
{
	//Before 1
	$use = new User("John");
	$jh = new JsonHandler();
	$jh->init();
	$jh->addUser($use);
	//Execute Method 1
	$bool = User::alreadyExists("John");
	//Asserts 1
	$this->assertNotNull($bool);
	$this->assertEquals($bool,true);
	//Before 2
	$jh->removeUser($use);
	//Execute Method 2
	$bool = User::alreadyExists("John");
	//Assets 2
	$this->assertEquals($bool,false);
}

public function testCheckUsers()
{	
	//Before
	$jh = new JsonHandler();
	$jh->init();
	$dateLast = DateTime::createFromFormat('Y-m-d H:i:s', '2004-05-05 20:00:00');
	$use->setLastMessage($dateLast);	
	$use2 = new User("Johnny");
	$use2->updateLastMessage();
	$jh->addUser($use);
	$jh->addUser($use2);
	//Execute Method
	$use->checkUsers();
	//Asserts
	$this->assertEquals(alreadyExists($use),false);
	$this->assertEquals(alreadyExists($use2),true);
	$jh->removeUser($use2);
}

}
?>
