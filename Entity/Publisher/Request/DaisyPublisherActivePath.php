<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherActivePath extends DaisyXMLNode {
	
	public function __construct(\DOMElement & $node, $path = '') {
		parent::__construct($node, "p:activePath", DaisyConfig::PUBLISHER_NAMESPACE);
		if (!empty($path)) $this->setValue($path);
	}
	
	public function setValue($path) {
		parent::setValue($path);
	}
	
}
?>
