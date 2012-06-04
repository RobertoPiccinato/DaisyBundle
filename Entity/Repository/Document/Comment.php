<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Document;

use Casagrande\DaisyBundle\Entity\DaisyUser;
use Casagrande\DaisyBundle\Entity\Repository\ARepositoryItem;
use Casagrande\DaisyBundle\Entity\Repository\Repository;

class Comment extends ARepositoryItem {
	
	protected $id;					    // integer
	protected $visibility;		        // CommentVisibility
	protected $creatorId;     		    // integer
	protected $documentId;    		    // string
	protected $branchId;                // string
	protected $languageId;              // string
	protected $createdOn;               // \DateTime
	protected $content;                 // string
	
		
	public function __construct(    
	        $id, 
	        $visibility, 
	        $creatorId, 
	        $documentId, 
	        $branchId,
	        $languageId, 
	        $createdOn,
	        $content) {

        $this->id = $id;
        $this->visibility = $visibility;
        $this->creatorId = $creatorId;
        $this->documentId = $documentId;
        $this->branchId = $branchId;
        $this->languageId = $languageId;
        $this->createdOn = $createdOn;
        $this->content = $content;
	}
	
		
	/**
	 * @param \DomDocument $dom
	 * @return Comment
	 */
	public static function getFromDom($dom) {
		
		$comment = new Comment();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'id':
					$comment->setId($attrNode->nodeValue);
					break;
				case 'visibility':
					$comment->setVisibility($attrNode->nodeValue);
					break;
				case 'createdBy':
					$comment->setCreatorId($attrNode->nodeValue);
					break;
				case 'documentId':
					$comment->setDocumentId($attrNode->nodeValue);
					break;
				case 'branchId':
					$comment->setBranchId($attrNode->nodeValue);
					break;
				case 'languageId':
					$comment->setLanguageId($attrNode->nodeValue);
					break;
				case 'createdOn':
					$comment->setCreatedOn($attrNode->nodeValue);
					break;
			}
		}
		
		$this->setContent($dom->documentElement->firstChild()->nodeValue());
		
		return $comment;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getCreatorId() {
		return $this->creatorId;
	}
	/**
	 * @return DaisyUser
	 */
	public function getCreator() {
	    return DaisyUser::get($this->getCreatorId);
	}
	
	public function getVisibility() {
		return $this->visibility;
	}
	
}