<?php

namespace Casagrande\DaisyBundle\Entity\Exceptions;

class EDaisyNoTag extends \Exception {
	public function __construct ($tagName) {
		parent::__construct('Attribute "'.$tagName.'" not found in the node.');
	}
}

?>
