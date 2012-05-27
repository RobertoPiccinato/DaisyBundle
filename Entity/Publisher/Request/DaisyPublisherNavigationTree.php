<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\DaisyXMLNode;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherNavigationDocument;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherActiveDocument;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherActivePath;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherContextualized;
use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherVersionMode;

use Casagrande\DaisyBundle\Entity\DaisyConfig;

class DaisyPublisherNavigationTree extends DaisyXMLNode {
	public $navigationDocument = null;
	public $activeDocument = null;
	public $activePath = null;
	public $contextualized = null;
	public $versionMode = null;
	
	public function __construct(\DOMElement & $node) {
		parent::__construct($node, "p:navigationTree", DaisyConfig::PUBLISHER_NAMESPACE);
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
	
	public function addActiveDocument($id = '', $branch = '', $language = '') {
		if (!is_null($this->activeDocument)) {
			if (!empty($id)) $this->activeDocument->id = $id;
			if (!empty($branch)) $this->activeDocument->branch = $branch;
			if (!empty($language)) $this->activeDocument->language = $language;
			return $this->activeDocument;
		}
		else {
			 $this->activeDocument = new DaisyPublisherActiveDocument($this->node, $id, $branch, $language);
			 return $this->activeDocument;
		}
	}
	
	public function addActivePath($path = '') {
		if (!is_null($this->activePath)) {
			if (!empty($path)) $this->activePath->setValue($path);
			return $this->activePath;
		}
		else {
			$this->activePath = new DaisyPublisherActivePath($this->node, $path);
			return $this->activePath;
		}
	}
	
	public function addContextualized($value = true) {
		if (!is_null($this->contextualized)) {
			$this->contextualized->setValue($value);
			return $this->contextualized;
		}
		else {
			$this->contextualized = new DaisyPublisherContextualized($this->node, $value);
			return $this->contextualized;
		}
	}
	
	public function addVersionMode($value = 'live') {
		if (!is_null($this->versionMode)) {
			$this->versionMode->setValue($value);
			return $this->versionMode;
		}
		else {
			$this->versionMode = new DaisyPublisherVersionMode($this->node, $value);
			return $this->versionMode;
		}
	}
}

?>
