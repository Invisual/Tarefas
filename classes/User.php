<?php

class classes_User{

	private $_userId = null;
	private $_email = null;
	private $_name = null;
	private $_registerDate = null;
	private $_availableOperation = array('newUser','existingUser');


	public function __construct ($userData, $actionType) {

		if (!in_array($actionType, $this->_availableOperation) || !is_array($userData)) {

			throw new InvalidArgumentException('Invalid arguments passed on');
		}

		switch ($actionType) {

			case 'newUser': $this->_email = $userData['email'];
							$this->_name = $userData['name'];
							break;


			case 'existingUser': $this->_email = $userData['email'];
								 $this->_name = $userData['name'];
								 $this->_userId = $userData['id_user'];
							
								 break;

		}
	}

	
	public function getPassword(){
		return ($this->_password);
	}
	
	public function getImageName(){
		return ($this->_image);
	}

	public function getEmail(){
		return ($this->_email);
	}

	public function getName(){
		return ($this->_name);
	}

	public function getUserId(){
		return ($this->_userId);
	}
	
}


?>