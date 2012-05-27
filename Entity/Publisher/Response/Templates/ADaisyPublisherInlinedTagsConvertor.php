<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Templates;

use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyEmptyArgumentSupplied;
use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyWrongDaisyLink;

abstract class ADaisyPublisherInlinedTagsConvertor {
	protected $branch;
	protected $language;
	protected $version;
	
	abstract public function getDocumentHref($daisyLink);
	abstract public function getImageSrc($daisyLink, $part);
	
	abstract public function convertLink(\SimpleXMLElement $a);	
	abstract public function convertImageLink(\SimpleXMLElement $img);
	abstract public function convertSearchResults(\SimpleXMLElement $res);
	
	final public function setConvertorParameters($branch, $language, $version) {
		if (empty($branch)) throw new EDaisyEmptyArgumentSupplied(array('branch'));
		if (empty($language)) throw new EDaisyEmptyArgumentSupplied(array('language'));
		if (empty($version)) throw new EDaisyEmptyArgumentSupplied(array('version'));
		
		$this->branch = $branch;
		$this->language = $language;
		$this->version = $version;
	}
	
	final protected function explodeDaisyLink($daisyLink) {
		if (empty($daisyLink)) throw new EDaisyEmptyArgumentSupplied(array('daisyLink'));
		if (strpos($daisyLink, 'daisy:') !== 0) throw new EDaisyWrongDaisyLink($daisyLink);
		
		$link = explode(':', $daisyLink);
		if (!isset($link[1])) throw new EDaisyWrongDaisyLink($daisyLink);
		
		$idAndBranch = explode('@', $link[1]);
				
		$linkArray['id'] = $idAndBranch[0];
		
		$linkArray['branch'] = (!empty($idAndBranch[1])) ? $idAndBranch[1] : $this->branch;
		
		$linkArray['language'] = (!empty($link[2])) ? $link[2] : $this->language;
		
		$linkArray['version'] = (!empty($link[3])) ? $link[3] : $this->version;
		
		return $linkArray;
	}
}

?>
