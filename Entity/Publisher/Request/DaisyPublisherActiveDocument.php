<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherActiveDocument extends DaisyXMLNode {	
	protected $attributes = array (
								'id' => '',
								'branch' => '',
								'language' => ''
							);
							
	public function __construct(\DOMElement & $node, $id = '', $branch = '', $language = '') {
		parent::__construct($node, "p:activeDocument", DaisyConfig::PUBLISHER_NAMESPACE);
		
		if (!empty($id)) $this->id = $id;
		if (!empty($branch)) $this->branch = $branch;
		if (!empty($language)) $this->language = $language;
	}
}

?>
