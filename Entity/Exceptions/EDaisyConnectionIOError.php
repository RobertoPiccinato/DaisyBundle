<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyConnectionIOError extends \Exception {
	public function __construct ($message) {
		parent::__construct($message);
	}	
}

?>
