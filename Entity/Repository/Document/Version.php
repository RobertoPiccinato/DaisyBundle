<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Document;

class Version extends ARepositoryItem {
	
	protected $id;					// integer
	protected $documentName;		// string
	protected $created;				// DateTime
	protected $creatorId;			// integer
	protected $state;				// VersionState
	protected $changeType;			// ChangeType
	protected $lastModified;		// DateTime
	protected $lastModifierId; 		// integer
	protected $totalSizeOfParts; 	// integer
	protected $fields;				// array
	protected $parts;				// array
	protected $links;				// array
	protected $summary;				// string
	protected $changeComment;		// boolean
	
	public static function getFromDom($dom) {
		
		$document = new Document();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'id':
					$document->setLogin($attrNode->nodeValue);
					break;
				case 'lastModified':
					$document->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$document->setLastModifierId($attrNode->nodeValue);
					break;
				case 'created':
					$document->setCreated($attrNode->nodeValue);
					break;
				case 'creator':
					$document->setCreatorId($attrNode->nodeValue);
					break;
				case 'state':
					if($attrNode->nodeValue == 'publish') {
						$document->setState(VersionState::PUBLISH);
					}
					break;
				case 'changeType':
					if($attrNode->nodeValue == 'major') {
						$document->setChangeType(ChangeType:MAJOR)
					}
					elseif($attrNode->nodeValue == 'minor') {
						$document->setNewChangeType(ChangeType:MINOR)
					}
					break;
				case 'documentName':
					$document->setDocumentName($attrNode->nodeValue);
					break;
			}
		}
		
		foreach($dom->documentElement->childNodes as $child) {
			
			switch($child->localName) {
				case 'summary':
					$document->setSummary($child->nodeValue);
					break;
				case 'changeComment':
					$document->setChangeComment();
					break;
			}
		}
		
		$customFields = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'customField');

		foreach($customFields as $customField) {
			
			$customFields[] = CustomField::getFromDom($customField);
		}
		
		$document->setCustomFields($customFields);
		
		$collectionIds = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'collectionId');

		foreach($collectionIds as $collectionId) {
			
			$collectionIds[] = $collectionId;
		}
		
		$document->setCollectionIds($collectionIds);
		
		$fields = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'field');

		foreach($fields as $field) {
			
			$fields[] = Field::getFromDom($field);
		}
		
		$document->setFields($fields);
		
		$parts = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'part');

		foreach($parts as $part) {
			
			$parts[] = Part::getFromDom($part);
		}
		
		$document->setParts($parts);
		
		$links = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'link');

		foreach($links as $link) {
			
			$links[] = Link::getFromDom($link);
		}
		
		$document->setLinks($links);
		
		return $document;
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getBranchId() {
		return $this->branchId;
	}
	public function getBranch(Repository $repository) {
		return Branch::get($this->getBranchId, $repository);
	}
	public function setBranchId($branchId) {
		$this->branchId = $branchId;
	}
	
	public function getCreatedFromBranchId() {
		return $this->createdFromBranchId;
	}
	public function getCreatedFromBranch(Repository $repository) {
		return Branch::get($this->getCreatedFromBranchId, $repository);
	}
	public function setCreatedFromBranchId($createdFromBranchId) {
		$this->createdFromBranchId = $createdFromBranchId;
	}

	public function getCreatedFromLanguageId() {
		return $this->createdFromLanguageId;
	}
	public function getCreatedFromLanguage(Repository $repository) {
		return Language::get($this->getCreatedFromLanguageId, $repository);
	}
	public function setCreatedFromLanguageId($createdFromLanguageId) {
		$this->createdFromLanguageId = $createdFromLanguageId;
	}

	public function getCreatedFromVersionId() {
		return $this->createdFromVersionId;
	}
	public function getCreatedFromVersion(Repository $repository) {
		return Version::get($this->getCreatedFromVersionId, $repository);
	}
	public function setCreatedFromVersionId($createdFromVersionId) {
		$this->createdFromVersionId = $createdFromVersionId;
	}
	
	public function getUpdateCount() {
		return $this->updateCount;
	}
	public function setUpdateCount($updateCount) {
		$this->updateCount = $updateCount;
	}
	
	public function getVariantUpdateCount() {
		return $this->variantUpdateCount;
	}
	public function setVariantUpdateCount($variantUpdateCount) {
		$this->variantUpdateCount = $variantUpdateCount;
	}
	
	/**
	 * 
	 * @return Branch
	 */
	public function getBranch(Repository $repository) {
		return Branch::get($this->getBranchId(), $repository);
	}
	
	public function getLanguageId() {
		return $this->languageId;
	}
	public function getLanguage(Repository $repository) {
		return Language::get($this->getLanguageId(), $repository);
	}
	public function setLanguageId($languageId) {
		$this->languageId = $languageId;
	}
		
	public function getDocumentName() {
		return $this->documentName;
	}
	public function setDocumentName($documentName) {
		$this->documentName = $documentName;
	}
	
	public function getCreated() {
		return $this->created;
	}
	public function setCreated($created) {
		$this->created = $created;
	}
	
	public function getCreatorId() {
		return $this->creatorId;
	}
	public function getCreator(Repository $repository) {
		return User::get($this->getCreatorId(), $repository);
	}
	
	public function setCreatorId($creatorId) {
		$this->creatorId = $creatorId;
	}
	
	public function getOwnerId() {
		return $this->ownerId;
	}
	public function getOwner(Repository $repository) {
		return User::get($this->getOwnerId(), $repository);
	}
	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
	}
	
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
	}
	
	public function getChangeType() {
		return $this->changeType;
	}
	public function setChangeType($changeType) {
		$this->changeType = $changeType;
	}
	
	public function getLastModified() {
		return $this->lastModified;
	}
	public function setLastModified($lastModified) {
		$this->lastModified = $lastModified;
	}
	
	public function getLastModifierId() {
		return $this->lastModifierId;
	}
	public function getLastModifier(Repository $repository) {
		return User::get($this->getId(), $repository);
	}
	public function setLastModifierId($lastModifierId) {
		$this->lastModifierId = $lastModifierId;
	}
	
	public function getLastVersionId() {
		return $this->lastVersionId;
	}
	public function getLastVersion(Repository $repository) {
		return Version::get($this->getLastVersionId(), $repository);
	}
	
	public function getLiveVersionId() {
		return $this->liveVersionId;
	}
	public function getLiveVersion(Repository $repository) {
		return Version::get($this->getLiveVersionId(), $repository);
	}
		
	public function getRequestedLiveVersionId() {
		return $this->requestedLiveVersion;
	}
	public function getRequestedLiveVersion(Repository $repository) {
		return Version::get($this->getRequestedLiveVersionId(), $repository);
	}
	public function setRequestedLiveVersionId($requestedLiveVersion) {
		$this->requestedLiveVersion = $requestedLiveVersion;
	}
		
	public function getLastMajorChangeVersionId() {
		return $this->lastMajorChangeVersionId;
	}
	public function getLastMajorChangeVersionId(Repository $repository) {
		return Version::get($this->getLastMajorChangeVersionId(), $repository);
	}
	public function setLastMajorChangeVersionId($lastMajorChangeVersionId) {
		$this->lastMajorChangeVersionId = $lastMajorChangeVersionId;
	}
		
	public function getLiveMajorChangeVersionId() {
		return $this->liveMajorChangeVersionId;
	}
	public function getLiveMajorChangeVersionId(Repository $repository) {
		return Version::get($this->getLiveMajorChangeVersionId(), $repository);
	}
	public function setLiveMajorChangeVersionId($liveMajorChangeVersionId) {
		$this->liveMajorChangeVersionId = $liveMajorChangeVersionId;
	}
	
	/**
	 * @param string $fullVersionAccess
	 */
	public function setFullVersionAccess($fullVersionAccess) {
		$this->fullVersionAccess = ($fullVersionAccess == 'true') ? true : false;
	}
	public function hasFullVersionAccess() {
		return $this->fullVersionAccess;
	}
		
	/**
	 * @param string $documentTypeChecksEnabled
	 */
	public function setDocumentTypeChecksEnabled($documentTypeChecksEnabled) {
		$this->documentTypeChecksEnabled = ($documentTypeChecksEnabled == 'true') ? true : false;
	}
	public function hasDocumentTypeChecksEnabled() {
		return $this->documentTypeChecksEnabled;
	}

	public function getTotalSizeOfParts() {
		return $this->totalSizeOfParts;
	}
	public function setTotalSizeOfParts($totalSizeOfParts) {
		$this->totalSizeOfParts = $totalSizeOfParts;
	}
	
	public function addCollectionId($id) {
		
		if(!in_array($id, $this->collectionIds)) {

			$this->collectionIds[] = $id;
		}
	}
	public function removeCollectionId($id) {
		
		if(in_array($id, $this->collectionIds)) {

			unset($this->collectionIds[$id]);
			$this->collectionIds = array_values($this->collectionIds);
		}
	}
}