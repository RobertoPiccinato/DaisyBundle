<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request\Base;

use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyEmptyArgumentSupplied;
use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyEmptyAttributeSupplied;
use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyNoAttribute;

class DaisyXMLNode {
	protected $node;
	protected $attributes = array();
	
	private $nameSpace;
	
	function __construct(\DOMElement & $parent, $elementName, $nameSpace = '') {		
		if (empty($parent)) throw new EDaisyEmptyArgumentSupplied(array('parent'));
		if (empty($elementName)) throw new EDaisyEmptyArgumentSupplied(array('elementName'));
		$this->node = $parent->appendChild(new \DOMElement($elementName, '', $nameSpace));
		$this->nameSpace = $nameSpace;
	}
	
	protected function init(\DOMElement & $self) {
		if (empty($self)) throw new EDaisyEmptyArgumentSupplied(array('self'));
		$this->node =& $self;
	}
	
	protected function getAttribute($attributeName) {				
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		pr($this); pr($attributeName);
		if ($this->node->hasAttribute($attributeName))
			return $this->node->getAttribute($attributeName);
		else return null;
	}
	
	protected function setAttribute($attributeName, $attributeValue = '') {				
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		$this->node->setAttribute($attributeName, $attributeValue);
	}
	
	protected function removeAttribute($attributeName) {
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		if ($this->node->hasAttribute($attributeName)) {
				$this->node->removeAttribute($attributeName);
		}
		else throw new EDaisyNoAttribute($attributeName);
	}
	
	protected function addChild($childName, $unique = true, $nameSpace = '') {
		if (empty($childName)) throw new EDaisyEmptyArgumentSupplied(array('childName'));
		if (empty($nameSpace)) $nameSpace = $this->nameSpace;		
		if ($unique) {
			$childNodes = $this->node->childNodes;
			for ($i = 0; ($node = $childNodes->item($i)) != NULL; $i++) {				
				($node->prefix != NULL) ? ($prefix = $node->prefix.':') : ($prefix = '');
				if ($node->nodeName == $node->prefix.':'.$childName) return NULL;
			}
		}
		return $this->node->appendChild(new \DOMElement($childName, '', $nameSpace));
	}
	
	protected function setValue($value) {
		$this->node->nodeValue = $value;
	}
	
	public function __get($attributeName) {
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		if (isset($this->attributes[$attributeName])) return $this->getAttribute($attributeName);
		else throw new EDaisyNoAttribute($attributeName);
	}
	
	public function __set($attributeName, $attributeValue = '') {
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		if (isset($this->attributes[$attributeName])) {
			if ($attributeValue == '' && $this->attributes[$attributeName] != 'empty')
				throw new EDaisyEmptyAttributeSupplied($attributeName);
			return $this->setAttribute($attributeName, $attributeValue);	
		}						 
		else throw new EDaisyNoAttribute($attributeName);
	}
	
	public function __isset($attributeName) {
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		if (isset($this->attributes[$attributeName])) {
			if ($this->node->hasAttribute($attributeName)) return TRUE;
			else return FALSE;				
		}
		else throw new EDaisyNoAttribute($attributeName);
	}
	
	public function __unset($attributeName) {
		if (empty($attributeName)) throw new EDaisyEmptyArgumentSupplied(array('attributeName'));
		if (isset($this->attributes[$attributeName])) {
			try {
				$this->removeAttribute($attributeName);
			}
			catch (EDaisyNoAttribute $e) {
				return;
			}
			return;
		}
		else throw new EDaisyNoAttribute($attributeName);
	}
}

?>
