<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherVersionMode extends DaisyXMLNode {
	
	public function __construct(\DOMElement & $node, $value = 'live') {
		parent::__construct($node, "p:versionMode", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->setValue($value);
	}
	
	public function setValue($value = 'live') {
		parent::setValue($value);
	}
}

?>
