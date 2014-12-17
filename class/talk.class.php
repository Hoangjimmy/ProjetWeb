
<?php

class Talk implements Jsonable
{
	private $_id;
	private $_name;
	private $_users;
	private $_status;

	public function __construct($name, $users, $status)
	{
		$this->_id = $id;
		$this->_users = $users;
		$this->_name = $name;
		$this->_status = $status;
	}
	
	public function toJson()
	{
		return array(
			"id" => $this->_id,
			"name" => $this->_name,
			"users" => $this->_users,
			"status" => $this->_status
		);
	}
	
	public static function fromJson($json)
	{
		$talk = new Talk($json["name"]);
		return $talk;
	}
}
?>