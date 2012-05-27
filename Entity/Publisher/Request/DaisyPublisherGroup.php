<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\ADaisyPublisherAllRequests;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherGroup extends ADaisyPublisherAllRequests {
	protected $attributes = array (
								'id' => ''
							);
	
	public function __construct(\DOMElement & $node, $id = '') {
		parent::__construct($node, "p:group", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->id = $id;
	}
	
}
?>
