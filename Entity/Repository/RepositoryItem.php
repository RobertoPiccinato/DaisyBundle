<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

interface RepositoryItem {
		
	/**
	 * @param string $xml
	 * @return RepositoryItem
	 */
	public static function getFromXml($xml);
		
	/**
	 * @param XMLReader $reader
	 * @return RepositoryItem
	 */
	public static function getFromXMLReader(\XMLReader &$reader);
		
	/**
	 * @param $writer
	 * @return string
	 */ 
	public function getXml(&$writer);
	
}