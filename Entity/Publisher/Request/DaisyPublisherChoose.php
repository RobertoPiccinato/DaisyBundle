<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherChoose extends DaisyXMLNode {	
	public $when = array();
	public $otherwise = null;
	
	public function __construct(\DOMElement & $node) {
		parent::__construct($node, "p:choose", DaisyConfig::PUBLISHER_NAMESPACE);
	}
	
	public function addWhen($test = '') {		
		 $tmp = new DaisyPublisherWhen($this->node, $test);
		 $this->when[] = $tmp;
		 return $tmp;
	}
	
	public function addOtherwise() {
		if (!is_null($this->otherwise)) {			
			return $this->otherwise;
		}
		else {
			 $this->otherwise = new DaisyPublisheOtherwise($this->node);
			 return $this->otherwise;
		}
	}
}

?>