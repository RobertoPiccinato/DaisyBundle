<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

use Casagrande\DaisyBundle\Entity\Repository\Document\VersionState;
use Casagrande\DaisyBundle\Entity\Repository\Document\ChangeType;
use Casagrande\DaisyBundle\Entity\Repository\Document\LiveStrategy;

class Document extends ARepositoryItem {
	
	protected $id;						// integer
	protected $lastModified;			// DateTime
	protected $lastModifierId; 			// integer
	protected $created;					// DateTime
	protected $ownerId;					// integer
	protected $private;					// boolean
	protected $updateCount;				// integer
	protected $referenceLanguageId; 	// integer
	protected $variantLastModified; 	// \DateTime
	protected $variantLastModifierId; 	// integer
	protected $liveVersionId			// integer
	protected $branchId;				// integer
	protected $languageId;				// integer
	protected $typeId;					// integer
	protected $lastVersionId;			// integer
	protected $retired;					// boolean
	protected $newVersionState;			// VersionState
	protected $newChangeType;			// ChangeType
	protected $newLiveStrategy;			// LiveStrategy
	protected $requestedLiveVersionId;  // integer
	protected $variantUpdateCount; 		// integer
	protected $fullVersionAccess;		// boolean
	protected $createdFromBranchId; 	// integer
	protected $createdFromLanguageId;	// integer
	protected $createdFromVersionId;  	// integer
	protected $documentTypeChecksEnabled; // boolean
	protected $lastMajorChangeVersionId;// integer
	protected $liveMajorChangeVersionId;// integer
	protected $dataVersionId;			// integer
	protected $name;					// string
	protected $validateOnSave;			// boolean
	protected $summary;					// string
	protected $customFields;			// array
	protected $lockInfo;				// LockInfo
	protected $collectionIds;			// array
	protected $timeLine;				// Timeline
	protected $fields;					// array
	protected $parts;					// array
	protected $links;					// array
	protected $hasLock;					// boolean
	
	
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
				case 'owner':
					$document->setOwnerId($attrNode->nodeValue);
					break;
				case 'private':
					$document->setPrivate($attrNode->nodeValue);
					break;
				case 'updateCount':
					$document->setUpdateCount($attrNode->nodeValue);
					break;
				case 'referenceLanguageId':
					$document->setReferenceLanguageId($attrNode->nodeValue);
					break;
				case 'variantLastModified':
					$document->setVariantLastModified($attrNode->nodeValue);
					break;
				case 'variantLastModifier':
					$document->setVariantLastModifierId($attrNode->nodeValue);
					break;
				case 'liveVersionId':
					$document->setLiveVersionId($attrNode->nodeValue);
					break;
				case 'branchId':
					$document->setBranchId($attrNode->nodeValue);
					break;
				case 'languageId':
					$document->setLanguageId($attrNode->nodeValue);
					break;
				case 'typeId':
					$document->setTypeId($attrNode->nodeValue);
					break;
				case 'lastVersionId':
					$document->setLastVersionId($attrNode->nodeValue);
					break;
				case 'retired':
					$document->setRetired($attrNode->nodeValue);
					break;
				case 'newVersionState':
					if($attrNode->nodeValue == 'publish') {
						$document->setNewVersionState(VersionState::PUBLISH);
					}
					break;
				case 'newChangeType':
					if($attrNode->nodeValue == 'major') {
						$document->setNewChangeType(ChangeType:MAJOR)
					}
					elseif($attrNode->nodeValue == 'minor') {
						$document->setNewChangeType(ChangeType:MINOR)
					}
					break;
				case 'newLiveStrategy':
					$document->setNewLiveStrategy($attrNode->nodeValue);
					break;
				case 'requestedLiveVersionId':
					$document->setRequestedLiveVersionId($attrNode->nodeValue);
					break;
				case 'variantUpdateCount':
					$document->setVariantUpdateCount($attrNode->nodeValue);
					break;
				case 'fullVersionAccess':
					$document->setFullVersionAccess($attrNode->nodeValue);
					break;
				case 'createdFromBranchId':
					$document->setCreatedFromBranchId($attrNode->nodeValue);
					break;
				case 'createdFromLanguageId':
					$document->setCreatedFromLanguageId($attrNode->nodeValue);
					break;
				case 'createdFromVersionId':
					$document->setCreatedFromVersionId($attrNode->nodeValue);
					break;
				case 'documentTypeChecksEnabled':
					$document->setDocumentTypeChecksEnabled($attrNode->nodeValue);
					break;
				case 'lastMajorChangeVersionId':
					$document->setLastMajorChangeVersionId($attrNode->nodeValue);
					break;
				case 'liveMajorChangeVersionId':
					$document->setLiveMajorChangeVersionId($attrNode->nodeValue);
					break;
				case 'dataVersionId':
					$document->setDataVersionId($attrNode->nodeValue);
					break;
				case 'name':
					$document->setName($attrNode->nodeValue);
					break;
				case 'validateOnSave':
					$document->setValidateOnSave($attrNode->nodeValue);
					break;
			}
		}
		
		foreach($dom->documentElement->childNodes as $child) {
			
			switch($child->localName) {
				case 'summary':
					$document->setSummary($child->nodeValue);
					break;
				case 'lockInfo':
					$document->setLockInfo(LockInfo::getFromDom(Child));
					break;
				case 'timeline':
					$document->setTimeline(Timeline::getFromDom(Child));
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