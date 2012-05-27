<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherOtherDocument;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherDiff extends DaisyXMLNode {
	public $otherDocument = null;
	
	public function __construct(\DOMElement & $node) {
		parent::__construct($node, "p:diff", DaisyConfig::PUBLISHER_NAMESPACE);
	}
	
	public function addOtherDocument($id = '', $branch = '', $language = '', $version = '') {
		if (!is_null($this->otherDocument)) {
			$this->otherDocument->id = $id;
			$this->otherDocument->branch = $branch;
			$this->otherDocument->language = $language;
			$this->otherDocument->version = $version;
			return $this->otherDocument;
		}
		else {
			 $this->otherDocument = new DaisyPublisherotherDocument($this->node, $id, $branch, $language, $version);
			 return $this->otherDocument;
		}
	}
}

?>
