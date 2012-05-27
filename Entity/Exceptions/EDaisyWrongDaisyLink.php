<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyWrongDaisyLink extends \Exception {
	public $link;
	
	public function __construct ($link) {
		$message = "Wrong daisy link supplied: ".$link;
		parent::__construct($message);
		$this->link = $link;
	}
}

?>
