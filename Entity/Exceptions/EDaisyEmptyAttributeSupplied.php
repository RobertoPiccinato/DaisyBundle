<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyEmptyAttributeSupplied extends \Exception {
	public $attribute;
	
	public function __construct ($attribute) {
		$message = "Empty attribute supplied: ".$attribute;
		parent::__construct($message);
		$this->attribute = $attribute;
	}
}

?>
