<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

class User extends ARepositoryItem {
	
	private $login;					// string
	private $id;						// integer
	private $lastModified;			// DateTime
	private $lastModifierId; 		// integer
	private $updateCount;			// integer
	private $updateableByUser;		// boolean
	private $confirmed;				// boolean
	private $authenticationScheme;	// string
	private $currentRole;			// Role
	private $roles;					// array of Role
	
	public function __construct() {
		$this->roles = array();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, $repository) {
    	
		$repository->sendGet('/repository/user/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	public static function getUserByLogin($login, $repository) {
    	
		$repository->sendGet('/repository/userByLogin/' . $login);
		
		return self::getFromXml($repository->getResponse());
	}
	
	public static function getUsersByEmail($email, $repository) {
		 		
		$repository->sendGet('/repository/usersByEmail/' . $email);
		
		$users = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			$domUsers = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'user');

			foreach($domUsers as $user) {
				
				$users[] = self::getFromDom($user);
			}
		}
		
		return $users;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \DomDocument $dom
	 * @return User
	 */
	public static function getFromDom($dom) {
		
		$user = new User();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'login':
					$user->setLogin($attrNode->nodeValue);
					break;
				case 'updateCount':
					$user->setUpdateCount($attrNode->nodeValue);
					break;
				case 'updateableByUser':
					$user->setUpdateCount($attrNode->nodeValue);
					break;
				case 'confirmed':
					$user->setConfirmed($attrNode->nodeValue);
					break;
				case 'authenticationScheme':
					$user->setAuthenticationScheme($attrNode->nodeValue);
					break;
				case 'lastModified':
					$user->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$user->setLastModifierId($attrNode->nodeValue);
					break;
				case 'updateCount':
					$user->setId($attrNode->nodeValue);
					break;
			}
		}
		
		foreach($domUser->childNodes as $child) {
			
			if($child->localName == 'role') {
				
				$user->setCurrentRole(Role::getFromDom($child));
			}
			elseif($child->localName == 'roles') {
				
				$user->roles = array();
				
				foreach($child->childNodes as $subChild) {
					
					if($subChild->localName == 'role') {
						
						$roles[] = Role::getFromDom($subChild);
					}
				}
			}
		}
		
		return $user;
	}
	
	/**
	 * 
	 * restituisce la lista di tutti gli id utenti
	 * @param Respository $repository
	 * @return array
	 */
	public static function getUserIds(Repository $repository) {
		
		$repository->sendGet('/repository/userIds');
		
		$userIds = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			$ids = $dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'id');

			foreach($ids as $id) {
				
				$userIds[] = $id->nodeValue;
			}
		}
		
		return $userIds;
	}

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getLogin() {
		return $this->login;
	}
	public function setLogin($login) {
		$this->login = $login;
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
		return self::get($this->getLastModifierId, $repository);
	}
	public function setLastModifierId($lastModifierId) {
		$this->lastModifierId = $lastModifierId;
	}
	
	public function getUpdateCount() {
		return $this->updateCount;
	}
	public function setUpdateCount($updateCount) {
		$this->updateCount = $updateCount;
	}
}