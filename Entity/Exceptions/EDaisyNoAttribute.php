<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyNoAttribute extends \Exception {
	public function __construct ($attributeName) {
		parent::__construct('Attribute "'.$attributeName.'" does not exist in the node.');
	}
}

?>
