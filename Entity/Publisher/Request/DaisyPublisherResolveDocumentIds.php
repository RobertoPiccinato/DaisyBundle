<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherResolveDocumentIds extends DaisyXMLNode {	
	public $document = array();
	protected $attributes = array (
								'branch' => '',
								'language' => ''
							);
	
	public function __construct(\DOMElement & $node, $branch = '', $language = '') {
		parent::__construct($node, "p:resolveDocumentIds", DaisyConfig::PUBLISHER_NAMESPACE);
		
		if (!empty($branch)) $this->branch = $branch;
		if (!empty($language)) $this->language = $language;
	}
	
	public function addDocument($id = '', $branch = '', $language = '', $version = '') {
		$tmp = new DaisyPublisherDocument($this->node, $id, $branch, $language, $version);
		$this->document[] = $tmp;
		return $tmp;
	}
}

?>
