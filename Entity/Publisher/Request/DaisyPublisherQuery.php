<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherQuery extends DaisyXMLNode {
	
	public function __construct(\DOMElement & $node, $value = '') {
		parent::__construct($node, "p:query", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->setValue($value);
	}
	
	public function setValue($value = '') {
		parent::setValue($value);
	}
	
}

?>
