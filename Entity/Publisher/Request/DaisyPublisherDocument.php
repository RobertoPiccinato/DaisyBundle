<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\ADaisyPublisherAllRequests;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherPreparedDocuments;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherDiff;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherDocument extends ADaisyPublisherAllRequests {	
	public $preparedDocuments = array();
	public $diff = array();
	
	protected $attributes = array (
								'id' => '',
								'branch' => '',
								'language' => '',
								'version' => 'empty',
								'field' => 'empty'
							);
		
	public function __construct(\DOMElement & $node, $id = '', $branch = '', $language = '', $version = '', $field = '') {
		parent::__construct($node, "p:document", DaisyConfig::PUBLISHER_NAMESPACE);
		
		if (!empty($id)) $this->id = $id;
		if (!empty($branch)) $this->branch = $branch;
		if (!empty($language)) $this->language = $language;
		$this->version = $version;
		$this->field = $field;
	}
	
	public function addAclInfo() {
		$this->addChild('aclInfo');
	}
	
	public function addSubscriptionInfo() {
		$this->addChild('subscriptionInfo');
	}
	
	public function addComments() {
		$this->addChild('comments');
	}
	
	public function addAvailableVariants() {
		$this->addChild('availableVariants');		
	}
	
	public function addPreparedDocuments() {
		$tmp = new DaisyPublisherPreparedDocuments($this->node);
		$this->preparedDocuments[] = $tmp;
		return $tmp;
	}
		
	public function addShallowAnnotatedVersion() {
		$this->addChild('shallowAnnotatedVersion');		
	}
	
	public function addAnnotatedDocument() {
		$this->addChild('annotatedDocument');		
	}
	
	public function addAnnotatedVersionList() {
		$this->addChild('annotatedVersionList');		
	}
	
	public function addDiff() {
		$tmp = new DaisyPublisherDiff($this->node);
		$this->diff[] = $tmp;
		return $tmp;
	}
}

?>