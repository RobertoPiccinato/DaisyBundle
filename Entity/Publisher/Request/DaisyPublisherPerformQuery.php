<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherQuery;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherExtraConditions;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherPerformQuery extends DaisyXMLNode {	
	public $query = null;
	public $extraConditions = null;
	
	public function __construct(\DOMElement & $node, $query = '') {
		parent::__construct($node, "p:performQuery", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->addQuery($query);
	}
	
	public function addQuery($value = '') {
		if (!is_null($this->query)) {
			$this->query->setValue($value);
			return $this->query;
		}
		else {
			 $this->query = new DaisyPublisherQuery($this->node, $value);
			 return $this->query;
		}
	}
	
	public function addExtraConditions($value = '') {
		if (!is_null($this->extraConditions)) {
			$this->extraConditions->setValue($value);
			return $this->extraConditions;
		}
		else {
			 $this->extraConditions = new DaisyPublisheExtraConditions($this->node, $value);
			 return $this->extraConditions;
		}
	}
}

?>
