<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyConnectionHTTPError extends \Exception {
	public $errno;
	public $errstr;
	
	public function __construct ($errno, $errstr) {
		parent::__construct('HTTP error: '.$errno.' - '.$errstr);
		$this->errno = $errno;
		$this->errstr = $errstr;
	}	
}

?>
