<?php
require_once("../config.php");

class testJsonHandler extends PHPUnit_Framework_TestCase
{
// Testing add and remove only one User
	public function TestAdd-RemoveUser()
	{
		//Before
		$use = new User("John");
		JsonHandler::init();
		
		//Execute Method addUser()
		JsonHandler::addUser($use);
		
		//Assert 1
		$this->assertEquals(User::alreadyExists("John"),true);
		
		//Execute Method removeUser()
		JsonHandler::removeUser($use);
		//Assert 2
		$this->assertEquals(User::alreadyExists("John"),false);
	}

// Testing Add and remove several Users

	public function testSetRemoveUsers()
	{
		//Before
		JsonHandler::init();
		$use = new User("John");
		$use2 = new User("Johnny");
		$use3 =  new User("Johnna");
		$arrUsers = array($use,$use2,$use3);
		$idUseArr = array( $use->getId(), $use2->getId(), $use3->getId),	
		
		// Execute Method SetUsers()	
		JsonHandler::setUsers($arrUsers);
		
		// Asserts 1
		$this->assertEquals(alreadyExists($use),true);
		$this->assertEquals(alreadyExists($use2),true);
		$this->assertEquals(alreadyExists($use3),true);
		
		// Execute Method removeUsers()
		JsonHandler::removeUsers($idUseArr);
		// Assert 2
		$this->assertEquals(alreadyExists($use),false);
		$this->assertEquals(alreadyExists($use2),false);
		$this->assertEquals(alreadyExists($use3),false);
		
	}

}
