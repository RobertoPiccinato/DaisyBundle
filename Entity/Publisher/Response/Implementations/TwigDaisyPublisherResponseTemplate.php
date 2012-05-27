<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Implementations;

use Casagrande\DaisyBundle\Entity\Publisher\Response\Templates\IDaisyPublisherResponseTemplate;

class TwigDaisyPublisherResponseTemplate implements IDaisyPublisherResponseTemplate {
	private $source;
	private $template;
	private $processor;
	private $customVars = array();
	
	public function __construct($processor, \SimpleXMLElement $source = NULL) {
		if (empty($processor)) return;
		$this->processor = $processor;
		
		if (!empty($source)) $this->setSource($source);
	}
	
	public function setSource(\SimpleXMLElement $source) {
		if (empty($source)) return;
		
		$this->source = $source;
		$this->processor->assign_by_ref('source', $this->source);
		$this->customVars = array();
	}
	
	public function setTemplate($template) {
		if (empty($template)) return;
		$this->template = $template;
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
			if ($var['ref']) $this->processor->assign_by_ref($name, $var['val']);
			else $this->processor->assign($name, $var['val']);
		
		return $this->processor->fetch($this->template);
	}
	
	public static function output(\SimpleXMLElement $source, $processor, $template) {		
		if (empty($processor) || empty($template) || (!is_object($processor))) return '';
		
		$templ = new SmartyDaisyPublisherResponseTemplate($processor, $source);
		
		$templ->setTemplate($template);
		return $templ->process();
	}
}

?>