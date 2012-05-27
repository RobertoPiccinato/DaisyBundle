<?php

namespace Casagrande\DaisyBundle\Entity;

class DaisyUser implements IDaisyUser {
	private $user;
	private $passwd;
	
	public function __construct($user, $passwd = '') {
		$this->setUser($user);
		$this->setPasswd($passwd);
	}
	
	public function setUser($user) {
		if (empty($user)) throw new EDaisyEmptyArgumentSupplied(array('user'));
		$this->user = $user;
	}
	
	public function setPasswd($passwd = '') {
		$this->passwd = $passwd;
	}
	
	public function getUser() {
		return $this->user; 
	}
	
	public function getPasswd() {
		return $this->passwd;
	}
	
	public function getDaisyPassword() {
		return $this->getPasswd();
	}

	public function getDaisyUsername() {
		return $this->getUser();
	}
}


?>
