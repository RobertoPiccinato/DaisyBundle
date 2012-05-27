<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherOtherDocument extends DaisyXMLNode {	
	protected $attributes = array (
								'id' => '',
								'branch' => '',
								'language' => '',
								'version' => ''
							);

	public function __construct(\DOMElement & $node, $id = '', $branch = '', $language = '', $version = '') {
		parent::__construct($node, "p:otherDocument", DaisyConfig::PUBLISHER_NAMESPACE);
		
		if(!empty($id)) $this->id = $id;
		if(!empty($branch)) $this->branch = $branch;
		if(!empty($language)) $this->language = $language;
		if(!empty($version)) $this->version = $version;
	}
	
}

?>
