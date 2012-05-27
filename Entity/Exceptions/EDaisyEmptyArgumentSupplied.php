<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyEmptyArgumentSupplied extends \Exception {
	public $arguments = array();
	
	public function __construct ($arguments = array()) {
		$message = "Empty parameters supplied: ";
		if (!empty($arguments)) $message .= implode(', ', $arguments);			
		parent::__construct($message);
		$this->arguments = $arguments;
	}
}

?>
