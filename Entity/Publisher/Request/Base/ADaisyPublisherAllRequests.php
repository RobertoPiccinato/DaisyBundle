<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request\Base;

use Casagrande\DaisyBundle\Entity\DaisyConfig;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherDocument;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherNavigationTree;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherPerformQuery;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherForEach;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherIf;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherChoose;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherGroup;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherResolveDocumentIds;

abstract class ADaisyPublisherAllRequests extends DaisyXMLNode {
	public $document = array();
	public $navigationTree = array();
	public $performQuery = array();
	public $forEach = array();
	public $if = array();
	public $choose = array();
	public $group = array();
	public $resolveDocumentIds = array();
	
	public function addDocument($id = '', $branch = '', $language = '', $version = '', $field = '') {
		$tmp = new DaisyPublisherDocument($this->node, $id, $branch, $language, $version, $field);
		$this->document[] = $tmp;
		return $tmp;
	}
	
	public function addMyComments() {
		$this->addChild('p:myComments', true, DaisyConfig::PUBLISHER_NAMESPACE);
	}
	
	public function addNavigationTree() {
		$tmp = new DaisyPublisherNavigationTree($this->node);
		$this->navigationTree[] = $tmp;
		return $tmp;
	}
	
	public function addPerformQuery($query = '') {
		$tmp = new DaisyPublisherPerformQuery($this->node, $query);
		$this->performQuery[] = $tmp;
		return $tmp;		
	}
	
	public function addForEach() {
		$tmp = new DaisyPublisherForEach($this->node);
		$this->forEach[] = $tmp;
		return $tmp;
	}
	
	public function addIf($test = '') {
		$tmp = new DaisyPublisherIf($this->node, $test);
		$this->if[] = $tmp;
		return $tmp;
	}
	
	public function addChoose() {
		$tmp = new DaisyPublisherChoose($this->node);
		$this->choose[] = $tmp;
		return $tmp;
	}
	
	public function addGroup($id = '') {
		$tmp = new DaisyPublisherGroup($this->node, $id);
		$this->group[] = $tmp;
		return $tmp;		
	}
	
	public function addResolveDocumentIds($branch = '', $language = '') {
		$tmp = new DaisyPublisherResolveDocumentIds($this->node, $branch, $language);
		$this->resolveDocumentIds[] = $tmp;
		return $tmp;
	}
}

?>

