<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherNavigationDocument;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherPreparedDocuments extends DaisyXMLNode {	
	public $navigationDocument = null;
	protected $attributes = array (
								'publisherRequestSet' => '',
								'applyDocumentTypeStyling' => ''
							);

	public function __construct(\DOMElement & $node) {
		parent::__construct($node, "p:preparedDocuments", DaisyConfig::PUBLISHER_NAMESPACE);
	}
	
	public function addNavigationDocument($id = '', $branch = '', $language = '') {
		if (!is_null($this->navigationDocument)) {
			if (!empty($id)) $this->navigationDocument->id = $id;
			if (!empty($branch)) $this->navigationDocument->branch = $branch;
			if (!empty($language)) $this->navigationDocument->language = $language;
			return $this->navigationDocument;
		}
		else {
			 $this->navigationDocument = new DaisyPublisherNavigationDocument($this->node, $id, $branch, $language);
			 return $this->navigationDocument;
		}
	}
		
}

?>