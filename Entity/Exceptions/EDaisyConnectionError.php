<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyConnectionError extends \Exception {
	public $errno;
	public $errstr;
	
	public function __construct ($errno, $errstr) {
		parent::__construct('Error opening socket: '.$errno.' - '.$errstr);
		$this->errno = $errno;
		$this->errstr = $errstr;		
	}	
}

?>
