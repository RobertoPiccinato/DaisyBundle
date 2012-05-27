<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

abstract class ARepositoryItem {
		
	/**
	 * Enter description here ...
	 * @param string $xml
	 * @return 
	 */
	public static function getFromXml($xml) {
		
		$object = null;
		
		if($dom = \DOMDocument::loadXML($xml)) {

			$object = self::getFromDom($dom); 
		}
		
		return $object;
	}
	
	// $id può essere un intero o, nel caso di un Document, una terna (documentId, branchId, languageId)
	abstract public static function get($id, Repository $repository);
		
	abstract public static function getFromDom($dom);
	
}