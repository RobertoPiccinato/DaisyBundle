<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherQuery;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherForEach extends DaisyXMLNode {	
	public $query = null;
	public $document = null;
	
	protected $attributes = array (
								'useLastVersion' => ''
							);
	
	public function __construct(\DOMElement & $node, $useLastVersion = 'true') {
		parent::__construct($node, "p:forEach", DaisyConfig::PUBLISHER_NAMESPACE);
		$this->useLastVersion = $useLastVersion;
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
	
	public function addDocument($id = '', $branch = '', $language = '', $version = '', $field = '') {
		if (!is_null($this->document)) {
			if (!empty($id))$this->document->id = $id;
			if (!empty($branch))$this->document->branch = $branch;
			if (!empty($language))$this->document->language = $language;
			$this->document->version = $version;
			$this->document->field = $field;			
			return $this->document;
		}
		else {
			 $this->document = new DaisyPublisherDocument($this->node, $id, $branch, $language, $version);
			 return $this->document;
		}
	}
}

?>
