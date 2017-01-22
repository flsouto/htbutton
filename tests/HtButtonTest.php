<?php

use PHPUnit\Framework\TestCase;
require_once('vendor/autoload.php');

use FlSouto\HtButton;

class HtButtonTest extends TestCase{


	function testCreate(){
		$button = new HtButton("action");
		$this->expectOutputRegex('/button.*Action.*button/');
		echo $button;
	}

	function testCreateWithLabel(){
		$button = new HtButton("action", "Save");
		$this->expectOutputRegex('/button.*Save.*button/');
		echo $button;
	}

	function testLabelSetter(){
		$button = new HtButton("action");
		$button->label("Save");
		$this->expectOutputRegex('/button.*Save.*button/');
		echo $button;
	}

	function testInlineTrue(){
		$button = new HtButton("action");
		$button->inline(true);
		$this->expectOutputRegex('/button.*style.*inline-block/');
		echo $button;
	}

	function testInlineFalse(){
		$button = new HtButton("action");
		$button->inline(true);
		$button->inline(false);
		$this->expectOutputRegex('/button.*style.*block/');
		echo $button;
	}

	function testInlineWithExtraStyling(){
		$button = new HtButton("action", "Delete");
		$button
			->inline(true)
			->attrs(['style'=>['background'=>'red','color'=>'yellow']]);

		$this->expectOutputRegex('/button.*style.*inline-block.*red.*yellow/');
		echo $button;
	}
	
	function testChangeValue(){
		$button = new HtButton("action", "Delete");
		$button->attrs(['id'=>'delete']);
		$this->expectOutputRegex('/button.*id.*delete.*value.*delete.*Delete/');
		echo $button;
	}

	function testCheckSubmit(){

		$this->expectOutputString('Deleting...');

		$_REQUEST['delete'] = 1;

		$button = new HtButton('delete');
		$button->context($_REQUEST);

		if($button->value()){
			echo 'Deleting...';
		}

	}

	function testMultipleButtons(){
		
		$this->expectOutputString('Deleting...');

		$_REQUEST['action_delete'] = 1;

		$updateBtn = (new HtButton('action_update'))->context($_REQUEST);
		$deleteBtn = (new HtButton('action_delete'))->context($_REQUEST);

		if($updateBtn->value()){
			echo 'Updating...';
		}

		if($deleteBtn->value()) {
			echo 'Deleting...';
		}

	}

	function testMultipleButtonsWithSameName(){

		$this->expectOutputString('Updating...');

		$_REQUEST['action'] = 'update';

		$updateBtn = new HtButton('action','Update');
		$updateBtn->attrs(['id'=>'update'])->context($_REQUEST);

		$deleteBtn = new HtButton('action','Delete');
		$deleteBtn->attrs(['id'=>'delete'])->context($_REQUEST);


		if(isset($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case $updateBtn->id() :
					echo 'Updating...';
					break;
				case $deleteBtn->id() :
					echo 'Deleting...';
					break;
			}
		}


	}

}