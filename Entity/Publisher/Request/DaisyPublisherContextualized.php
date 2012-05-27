<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherContextualized extends DaisyXMLNode {
	
	public function __construct(\DOMElement & $node, $value = true) {
		parent::__construct($node, "p:contextualized", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->setValue($value);
	}
	
	public function setValue($value = true) {
		if ($value) parent::setValue('true');
		else parent::setValue('false');
	}
	
}
?>
