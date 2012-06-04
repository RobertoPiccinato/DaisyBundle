<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Document;

class Id {
	
	protected $documentId;		// string
	protected $branchId;		// string
	protected $languageId;		// string

	public function __construct($documentId, $branchId, $languageId) {
	    
	    $this->documentId = $documentId;
	    $this->branchId = $branchId;
	    $this->languageId = $languageId;
	}
	
	public function getDocumentId() {
		return $this->documentId;
	}
	
	public function getBranchId() {
		return $this->branchId;
	}
	
	public function getLanguageId() {
		return $this->languageId;
	}
}