<?php

class classes_ControlPanel{

	private $_myDbManager;

	public function setMyDb($myDb){

		$this->_myDbManager=$myDb;
	}


	public function getMyDb(){

		return ($this->_myDbManager->_myDb);
	}

	public function get(){
		return ($this->_myDbManager);
	}

}


?>