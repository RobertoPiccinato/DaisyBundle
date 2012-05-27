<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Request;

use Casagrande\DaisyBundle\Entity\DaisyHTTPClient;
use Casagrande\DaisyBundle\Entity\DaisyUserInterface;
use Casagrande\DaisyBundle\Entity\DaisyConfig;
use Casagrande\DaisyBundle\Entity\Publisher\Request\Base\ADaisyPublisherAllRequests;

class DaisyPublisherRequest extends ADaisyPublisherAllRequests {
	public $xmlns = DaisyConfig::PUBLISHER_NAMESPACE;
	protected $attributes = array (
								'locale' => '',
								'exceptions' => '',
							);
	private $user;
	private $request;
	private $response; 
	
	public function __construct($user, $xmlns = '') {
		$this->clearRequest($xmlns);
		$this->user = $user;		
	}
	
	public function clearRequest($xmlns = '') {
		if (!empty($xmlns)) $this->xmlns = $xmlns;
		
		$requestStr = '<p:publisherRequest '.
						'xmlns:p="'.$this->xmlns.'" '.
						'locale="'.DaisyConfig::PUBLISHER_DEFAULT_LOCALE.'" '.
						'exceptions="'.DaisyConfig::PUBLISHER_DEFAULT_EXCEPTIONS.'">'.
						'</p:publisherRequest>';
		
		if (!empty($this->request)) unset($this->request);
		
		$this->request = new \DOMDocument();
		$this->request->loadXML($requestStr);		
		$this->init($this->request->documentElement);
		
		$this->locale = 'en-US';
		$this->exceptions = 'throw';
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
	
	public function getResponse() {
		return $this->response;
	}
}

?>
