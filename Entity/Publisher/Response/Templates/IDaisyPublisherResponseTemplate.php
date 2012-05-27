<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Templates;

use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyEmptyArgumentSupplied;
use Casagrande\DaisyBundle\Entity\Exceptions\EDaisyWrongDaisyLink;

interface IDaisyPublisherResponseTemplate {
	public function __construct($processor, \SimpleXMLElement $source = NULL);
	public function setSource(\SimpleXMLElement $source);
	public function setTemplate($template);
	public function setCustomVariable($name, $value, $reference = false);
	public function deleteCustomVariable($name);
	public function process();

	public static function output(\SimpleXMLElement $source, $processor, $template);
}

?>
