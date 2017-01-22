<?php

use PHPUnit\Framework\TestCase;
require_once('vendor/autoload.php');

use FlSouto\HtButton;

class HtButtonTest extends TestCase{


	function testRender(){

		$button = new HtButton("submit");
		$this->expectOutputRegex('/button.*id.*name.*submit.*button/');
		echo $button;

	}

}