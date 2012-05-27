<?php

namespace Casagrande\DaisyBundle\Entity;

interface DaisyUserInterface {
	/*
	 * @return string
	 */	
	function getDaisyPassword();
	
	/*
	 * @return string
	 */
	function getDaisyUsername();
}

?>
