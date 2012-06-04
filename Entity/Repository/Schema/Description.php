<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Schema;

use Casagrande\DaisyBundle\Entity\Repository\ARepositoryItem;

class Description extends ARepositoryItem {
	
	protected $locale;	    		// string
	protected $text;                // string
	
	
	/**
	 * @param \DomDocument $dom
	 * @return Description
	 */
	public static function getFromDom($dom) {
		
		$description = null;
		
		if($dom->documentElement->hasAttribute('locale')) {
		    
		    $description = new Description($dom->documentElement->getAttribute('locale'), $dom->documentElement->nodeValue);
		}
		
		return $description;
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