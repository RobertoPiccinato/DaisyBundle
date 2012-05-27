<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\ADaisyPublisherAllRequests;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherOtherwise extends ADaisyPublisherAllRequests {
	
	public function __construct(\DOMElement & $node) {
		parent::__construct($node, "p:otherwise", DaisyConfig::PUBLISHER_NAMESPACE);
	}
		
}
?>
