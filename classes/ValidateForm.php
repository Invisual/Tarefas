<?php

class classes_ValidateForm {

	private $_myErrorArray = array ();
	private $_availableFormValidation = array ('registerUser');

	public function __construct ($formName, $formData) {

		if ( !in_array($formName, $this->_availableFormValidation) || !is_array($formData)){

			throw new InvalidArgumentException ("Invalid arguments passed on");
		}


		switch ($formName) {

			case 'registerUser': $this->registerUserValidation($formData);
			break;
		}
	}


	private function registerUserValidation($formData){

		$nameMin=5;
		$nameMax=70;
		$passwordMin=4;
		$passwordMax=32;


				


		if (!$this->checkEmail($formData['email'])) {

			$this->_myErrorArray['email'] = "You must enter a valid email";
		}

		if (!$this->checkIfVarchar($formData['password'], $passwordMin, $passwordMax)) {

			$this->_myErrorArray['password']= "Invalid Password: It must be a string with between " . $passwordMin . " and " . $passwordMax . " chars";
		}

		else if ($formData['password'] != $formData['repassword']) {


			$this->_myErrorArray['repassword'] = "Passwords must match";
		}

		if ( count ($this->_myErrorArray) == 0) {

			//no errors found
			$this-> _myErrorArray = true;
		}
	}

	public function getStatus() {

		return ($this->_myErrorArray);
	}

	private function checkIfString($string, $min, $max) {

		$expression = '/^[A-z]{'.$min.','.$max.'}$/';

		if (!preg_match($expression, $string)) {

			//Error
			return (false);
		}
		else {

			return (true);
		}
	}

	private function checkEmail($email){

		if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {

			return (false);
		}
		else {
			return (true);
		}
	}

	private function checkIfVarchar($string, $min, $max) {

		$expression = '/^[A-z0-9]{'.$min.','.$max.'}$/';

		if (!preg_match($expression, $string)){
			return (false);
		}
		else {
			return (true);
		}
	}
}

?>