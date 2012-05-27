<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

use Casagrande\DaisyBundle\Entity\DaisyHTTPClient;
use Casagrande\DaisyBundle\Entity\IDaisyUser;
use Casagrande\DaisyBundle\Entity\DaisyConfig;

class Repository {
	
	private $user;
	private $response;
	
	public function __construct(IDaisyUser $user) {
		$this->user = $user;		
	}
		
	public function sendRequest() {
		$client = DaisyHTTPClient::singleton();		
		$client->connect();
		$client->setUser($this->user);
		$client->setPostMethod();
		$client->setPath('/publisher/request');				
		$client->sendToHost($this->request->saveXML());
		$this->response = $client->getResultData();
	}

	public function sendPost($path, $content) {
		$client = DaisyHTTPClient::singleton();		
		$client->connect();
		$client->setUser($this->user);
		$client->setPostMethod();
		$client->setPath($path);				
		$client->sendToHost($content);
		$this->response = $client->getResultData();
	}

	public function sendGet($path, $parameters = null) {
		$client = DaisyHTTPClient::singleton();		
		$client->connect(DaisyConfig::DAISY_REPOSITORY_HOST, DaisyConfig::DAISY_REPOSITORY_PORT);
		$client->setUser($this->user);
		$client->setGetMethod();
		
		$query = (!is_null($parameters) && count($parameters) > 0) ?
				http_build_query($parameters, '', "&") : '';
		
		$client->setPath($path);				
		$client->sendToHost($query);
		$this->response = $client->getResultData();
	}
	
	public function getResponse() {
		return $this->response;
	}
	
	/**
	 * 
	 * @param string id, integer branchId, integer languageId
	 */
	public function getDocument($id, 
			$branchId = DaisyConfig::DEFAULT_BRANCH_ID, 
			$languageId = DaisyConfig::DEFAULT_LANGUAGE_ID) {
		
	}
}

?>
