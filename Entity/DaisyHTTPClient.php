<?php
 
namespace Casagrande\DaisyBundle\Entity;
 
 class DaisyHTTPClient {
 	private $host;
 	private $path;
 	private $port;
 	private $user;
 	private $method = 'GET';
 	
 	private $resultCode = 0;
 	private $resultMsg = '';
 	private $resultData = '';
 	
 	private $socc;
 	private $connectionChanged;
 	
 	private static $instance;
 	 	
 	private function __construct() {
 	} 
 	
 	public function __destruct() {
 		$this->closeConnection();
 	}
 	
 	public static function &singleton () {
 		if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        
        return self::$instance;
 	}
 	
 	public function connect($host = '', $port = '') {
 		if ((!empty($host)) && (!empty($port))) {
 			$this->setHost($host);
 			$this->setPort($port);
 		}
 		
 		if ($this->connectionChanged) $this->openConnection();
 	}
 	
 	public function isConnected() {
 		return (boolean)$this->socc; 
 	}
 	
 	private function openConnection() {
 		$this->closeConnection();
 		$this->socc = fsockopen($this->host, $this->port, $errno, $errstr);
 		if (($this->socc = fsockopen($this->host, $this->port, $errno, $errstr)) === FALSE)
 			throw new EDaisyConnectionError($errno, $errstr);
 		$this->connectionChanged = false;
 	}
 	private function closeConnection() {
 		if ($this->isConnected()) fclose($this->socc);
 	}
 	
 	public function sendToHost($data = '') {
 		$path = $this->path;
 		$buf = "";
 		$this->clearResult();
 		
	    if ($this->method == 'GET') $path .= '?' . $data;
	    
	    $header  = $this->method." ".$this->path." HTTP/1.1\r\n";
	    $header .= "Host: ".$this->host."\r\n";
		$header .= "Content-type: text/xml; charset=UTF-8\r\n";
	    if ($this->method == "POST") $header .= "Content-length: ".strlen($data)."\r\n";
	    $header .= "Authorization: Basic ".base64_encode($this->user->getUser().":".$this->user->getPasswd())."\r\n";
	    $header .= "Connection: Close\r\n\r\n";
//	    $header .= "Referer: http://love.bigmir.net/search/\r\n";
//	    $header .= "Content-type: application/x-www-form-urlencoded\r\n";
//	    if ($useragent) $header .= "User-Agent: MSIE\r\n";	    
//		$header .= "Connection: Keep-Alive\r\n\r\n";
	    if ($this->method == "POST") $header .= $data;
		
	    if (fputs($this->socc, $header) === FALSE) throw new EDaisyConnectionIOError('Error wroting to socket');	       
		
	    while (!feof($this->socc)) $buf .= fgets($this->socc, 128);	    
	    //$this->resultData = $buf;
	    $this->parseResult($buf);
	    
	    if ($buf === FALSE) throw new EDaisyConnectionIOError('Error reading from socket');
	    
	    return;
	}
	
	private function clearResult() {
		$this->resultCode = 0;
		$this->resultMsg = '';
		$this->resultData = '';
	}
	
	private function parseResult($data) {
		if (empty($data)) return;
		list($this->resultCode, $this->resultMsg) = 
			explode(" ",
					substr(	$data,
							strpos($data, " ") + 1,
							strpos($data, "\r\n") - strpos($data, " ") - 1)
					);
		//$this->resultData = substr($data, strpos($data, "\r\n\r\n") + 4);
		$this->resultData = substr($data, strpos($data, '?>') + 2);
		
		//$this->resultData = str_replace(array("\r\n", "\r", "\n", "\t"), '', $this->resultData);
		//$this->resultData =preg_replace( '/[^[:print:]]/', '', $this->resultData); 
		
		if ($this->resultCode >= 400)
			throw new EDaisyConnectionHTTPError($this->resultCode, $this->resultMsg);
	}
	
	private function setMethod($method) {
		if (!empty($method)) $this->method = strtoupper($method);
	}
	
	public function setPostMethod() {
		if ($this->method != 'POST') $this->setMethod('POST');
	}
	
	public function setGetMethod() {
		if ($this->method != 'GET') $this->setMethod('GET');
	}
	
	public function getMethod() {
		return $this->method;
	}
 	
 	public function setUser(DaisyUser $user) {
 		if ($this->user == $user) return;
 		$this->user = $user;
 	}
 	
 	public function getUser() {
 		return $this->user;
 	}
 	
 	public function setPath($path) {
 		$this->path = $path;
 	}
 	
 	public function getPath() {
 		return $this->path;
 	}
 	
 	public function setHost($host) {
 		$this->connectionChanged = true;
 		$this->host = $host;
 	}
 	
 	public function getHost() {
 		return $this->host;
 	}
 	
 	public function setPort($port) {
 		$this->connectionChanged = true;
 		$this->port = $port;
 	}
 	
 	public function getPort($port) {
 		return $this->port;
 	}
 	
 	public function getResultCode() {
 		return $this->resultCode;
 	}
 	
 	public function getResultMsg() {
 		return $this->resultMsg;
 	}
 	
 	public function getResultData() {
 		return $this->resultData;
 	}
 }
?>
