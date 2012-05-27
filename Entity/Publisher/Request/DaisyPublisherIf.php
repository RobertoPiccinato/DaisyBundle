<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\ADaisyPublisherAllRequests;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherIf extends ADaisyPublisherAllRequests {
	protected $attributes = array (
								'test' => ''
							);
							
	public function __construct(\DOMElement & $node, $test = '') {
		parent::__construct($node, "p:if", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->test = $test;
	}
		
}
?>
