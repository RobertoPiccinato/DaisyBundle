<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Schema;

use Casagrande\DaisyBundle\Entity\Repository\ARepositoryItem;

class Label extends ARepositoryItem {
	
	protected $locale;	    		// string
	protected $text;                // string
	
	
	/**
	 * @param \DomDocument $dom
	 * @return Label
	 */
	public static function getFromDom($dom) {
		
		$label = null;
		
		if($dom->documentElement->hasAttribute('locale')) {
		    
		    $label = new Label($dom->documentElement->getAttribute('locale'), $dom->documentElement->nodeValue);
		}
		
		return $label;
	}

	public function getLocale() {
		return $this->locale;
	}
	public function setLocale($locale) {
		$this->locale = $locale;
	}

	public function getText() {
		return $this->text;
	}
	public function setText($text) {
		$this->text = $text;
	}
}