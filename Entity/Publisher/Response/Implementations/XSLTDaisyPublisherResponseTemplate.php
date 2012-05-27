<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Implementations;

use Casagrande\DaisyBundle\Entity\Publisher\Response\Templates\IDaisyPublisherResponseTemplate;

class XSLTPublisherResponseTemplate implements IDaisyPublisherResponseTemplate {
	private $source;
	private $template;
	private $processor;
	private $customVars = array();
	
	public function __construct($processor, \SimpleXMLElement $source = null) {
		if (empty($processor)) return;
		$this->processor = $processor;
		
		if (!empty($source)) $this->setSource($source);
	}
	
	public function setSource(\SimpleXMLElement $source) {
		if (empty($source)) return;
		
		$this->source = new \DOMDocument();
		$this->source->loadXML($source->asXML());
		$this->customVars = array();
	}
	
	public function setTemplate($template) {
		if (empty($template)) return;		
		$this->processor->importStylesheet(\DOMDocument::load($template));
	}
	
	public function setCustomVariable($name, $value, $reference = false) {
		if (empty($name)) return;
		$this->customVars[$name] = array ('val' => $value, 'ref' => $reference);
	}
	
	public function deleteCustomVariable($name) {
		if (empty($name)) return;
		if (isset($this->customVars[$name])) unset($this->customVars[$name]);
	}
	
	public function process() {
		foreach ($this->customVars as $name => $var)
			$this->processor->setParameter('', $name, $var['val']);
		
		return $this->processor->transformToXML($this->source);
	}
	
	public static function output(\SimpleXMLElement $source, $processor, $template) {		
		if (empty($processor) || empty($template) || (!is_object($processor))) return '';
				
		$templ = new XSLTPublisherResponseTemplate($source, $processor);
		
		$templ->setTemplate($template);
		return $templ->process();
	}
}

?>
