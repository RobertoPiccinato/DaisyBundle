<?php

namespace Casagrande\DaisyBundle\Entity;

interface IDaisyUser {
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
